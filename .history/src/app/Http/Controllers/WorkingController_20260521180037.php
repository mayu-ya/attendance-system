<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AttendanceRecord;
use App\Models\BreakTime;
use \Carbon\Carbon;

class WorkingController extends Controller
{
    public function index()
    {
        $date = Carbon::now()->format('Y-m-d');
        $work = AttendanceRecord::where('date', $date)->first();
        if($work){
        $workId = $work->id;
        $work->break = BreakTime::where('attendance_record_id', $workId)->get();
        }
        
        return view('timestamp', compact('work'));
    }

    public function working__start()
    {
        AttendanceRecord::create([
            'user_id' => Auth::user()->id,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => Carbon::now()->format('H:i'),
        ]);

        return redirect('/attendance/list');
    }

    public function working__end(Request $request)
    {
        $workId = $request->input('attendance_record_id');
        //dd($workId);

        $totalBreakTime = BreakTime::where('attendance_record_id', $workId)->get()->sum('rest_total');
        //dd($totalBreakTime);

        $work = AttendanceRecord::find($workId);
        $start = Carbon::parse($work->start_time);
        $end = Carbon::now();
        $total = $start->diffInMinutes($end);
        $totalWork = $total-$totalBreakTime;
        $totalTime = sprintf('%02d:%02d:00', floor($totalWork / 60), $totalWork % 60);

        $work->update([
            'end_time' => $end->format('H:i'),
            'work_total' => $totalWork,
            'duration' => $totalBreakTime,
        ]);

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

    public function attendance()
    {
        $startMonth = Carbon::now()->startOfMonth();
        $endMonth = Carbon::now()->endOfMonth();

        $records = AttendanceRecord::whereBetween('date', [$startMonth->toDateString(), $endMonth->toDateString()])
                    ->get()
                    ->keyBy(function ($item) {
                        return Carbon::parse($item->date)->toDateString();
                    });

        $monthDays = [];
        $daysMonth = $startMonth->daysInMonth;
        
        for ($i = 0; $i < $daysMonth; $i++) {
            $currentDate = $startMonth->copy()->addDays($i)->toDateString();

            $work = $records->get($currentDate);

            $monthDays[] = [
                'date' => $currentDate,
                'work' => $work
            ];
        }

        return view('attendance', compact('monthDays'));
    }

    public function detail($id)
    {
        $user = Auth::user();
        $work = AttendanceRecord::where('id', $id)->first();

        return view('detail', compact('user', 'work'));
    }

    public function apply()
    {
        return view('apply');
    }
}
