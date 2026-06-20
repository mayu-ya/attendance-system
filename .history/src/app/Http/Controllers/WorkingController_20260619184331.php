<?php

namespace App\Http\Controllers;

use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AttendanceRecord;
use App\Models\BreakTime;
use App\Models\Apply;
use App\Models\Rest;
use App\Models\Report;
use \Carbon\Carbon;

class WorkingController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id;
        $date = Carbon::now()->format('Y-m-d');
        $work = AttendanceRecord::where('user_id', $user)->where('date', $date)->first();
        if($work){
        $workId = $work->id;
        $work->break = BreakTime::where('attendance_record_id', $workId)->get();
        }
        
        return view('timestamp', compact('work'));
    }

    public function working__start()
    {
        $date = Carbon::now();
        $userId = Auth::user()->id;

        AttendanceRecord::create([
            'user_id' => $userId,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => $date->format('H:i'),
        ]);

        //遅刻判定
        $item = "09:00";
        if($date > $item) {
            $report = Report::firstOrNew(
                [
                    'user_id' => $userId,
                    'month' => $date->format('Y-m'), 
                ]);

            if($report->exists) {
                $report->increment('behind_time');
            } else {
                $report->behind_time = 1;
                $report->save();
            }
        }

        return redirect('/attendance/list');
    }

    public function working__end(Request $request)
    {
        $workId = $request->input('attendance_record_id');

        $breakTime = BreakTime::where('attendance_record_id', $workId)->get()->sum('rest_total');
        $totalBreakTime = sprintf('%02d:%02d:00', floor($breakTime / 60), $breakTime % 60);

        $work = AttendanceRecord::find($workId);
        $start = Carbon::parse($work->start_time);
        $end = Carbon::now();
        $total = $start->diffInMinutes($end);
        $totalWork = $total-$breakTime;
        $totalTime = sprintf('%02d:%02d:00', floor($totalWork / 60), $totalWork % 60);

        $work->update([
            'end_time' => $end->format('H:i:s'),
            'work_total' => $totalTime,
            'duration' => $totalBreakTime,
        ]);

        //総労働時間
        $attendances = AttendanceRecord::where('user_id', Auth::id())
                                        ->whereYear('date', $end->year)
                                        ->whereMonth('date', $end->month)
                                        ->get();

        $workTotal = 0;
        foreach($attendances as $attendance){
            $apply = Apply::where('status', 'approved')
                            ->where('attendance_record_id', $attendance->id)
                            ->first();
            if($apply){
                $workTotal += CarbonInterval::createFromFormat('H:i:s',$apply->work_total)->totalMinutes;
            } else {
                //dd($attendance->work_total);
                $workTotal += CarbonInterval::createFromFormat('H:i:s',$attendance->work_total)->totalMinutes;
                dd($workTotal);
            }
        }

        $report = Report::where('user_id', Auth::id())
                ->where('month', $end->format('Y-m'))
                ->first();

        //平均労働時間
        $startMonth = $end->copy()->startOfMonth();
        $endMonth = $end->copy()->endOfMonth();
        $thisMonth = AttendanceRecord::where('user_id', Auth::id())
                                    ->whereBetween('date', [$startMonth->toDateString(), $endMonth->toDateString()])
                                    ->count();
        //dd($thisMonth);
        $averageTime = round($workTotal/$thisMonth);
        //dd($totalWork);

        $report->update([
                    'total_work' => $workTotal,
                    'average_work' => $averageTime,
                ]);

        //残業時間
        $workTime = 480;
        if($totalWork > $workTime) {
            $overTime = $totalWork-$workTime;
            $totalOverTime = ($report->total_overtime ?? 0) + $overTime;
            $report->update([
                'total_overtime' => $totalOverTime,
            ]);
        }

        //早退判定
        $leaving = "18:00";
        if($end->format('H:i') < $leaving) {
            $report->increment('leaving_early');
        }

        //長時間労働判定
        $today = 600;
        if($totalWork > $today) {
            $report->increment('overtime_day');
        }

        return redirect('/attendance');
    }

    public function break__start(Request $request)
    {
        $workId = $request->input('attendance_record_id');
        Breaktime::create([
            'attendance_record_id' => $workId,
            'rest_start' => Carbon::now()->format('H:i'),
        ]);

        return redirect('/attendance/list');
    }

    public function break__end(Request $request)
    {
        $workId = $request->input('attendance_record_id');
        $break = BreakTime::where('attendance_record_id', $workId)->whereNull('rest_end')->first();

        $now = Carbon::now();
        $breakStart = Carbon::parse($break->rest_start);

        $total = $now->diffInMinutes($breakStart);

        $break->update([ 
            'rest_end' => Carbon::now()->format('H:i'),
            'rest_total' => $total,
        ]);

        return redirect('/attendance/list');
    }

    public function attendance(Request $request)
    {
        $year = $request->input('year')??Carbon::today()->format('Y');
        $month = $request->input('month')??Carbon::today()->format('m');
        $dayYm = Carbon::create($year, $month);

        $action = $request->input('action');
        if($action === 'sub'){
            $dayYm->subMonth();
        }
        elseif($action === 'add'){
            $dayYm->addMonth();
        }
        
        $startMonth = $dayYm->copy()->startOfMonth();
        $endMonth = $dayYm->copy()->endOfMonth();

        $userId = Auth::user()->id;

        $applies = Apply::where('user_id', $userId)
                    ->whereBetween('date', [$startMonth->toDateString(), $endMonth->toDateString()])
                    ->get()
                    ->keyBy(function ($item) {
                        return Carbon::parse($item->date)->toDateString();
                    });

        $records = AttendanceRecord::where('user_id', $userId)
                    ->whereBetween('date', [$startMonth->toDateString(), $endMonth->toDateString()])
                    ->get()
                    ->keyBy(function ($item) {
                        return Carbon::parse($item->date)->toDateString();
                    });

        $monthDays = [];
        $daysMonth = $startMonth->daysInMonth;

        for ($i = 0; $i < $daysMonth; $i++) {
            $currentDate = $startMonth->copy()->addDays($i)->toDateString();
            
            $work = $records->get($currentDate);
            $apply = $applies->get($currentDate);

            $monthDays[] = [
                'date' => $currentDate,
                'apply' => $apply,
                'work' => $work,
            ];
        }

        return view('attendance', [
            'monthDays' => $monthDays,
            'thisMonth' => $dayYm,
        ]);
    }
}
