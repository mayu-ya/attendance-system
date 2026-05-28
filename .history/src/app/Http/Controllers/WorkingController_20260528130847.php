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

    public function attendance(Request $request, Item $item)
    {
        $year = $request->input('year')??Carbon::today()->format('Y');
        $mouth = $request->input('mouth')??Carbon::today()->format('m');
        $dayYm = Carbon::create($year, $mouth);

        if($item === 'sub'){
            $startMonth = Carbon::now()->startOfMonth()->subMonth();
            $endMonth = Carbon::now()->endOfMonth()->subMonth();
        } else {
            $startMonth = Carbon::now()->startOfMonth();
            $endMonth = Carbon::now()->endOfMonth();
        }
        

        $userId = Auth::user()->id;

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

            $monthDays[] = [
                'date' => $currentDate,
                'work' => $work,
            ];            
        }

        return view('attendance', [
            'monthDays' => $monthDays,
            'thisMonth' => $dayYm,
        ]);
    }

    public function subDay(Request $request)
    {
        $year = $request->input('year')??Carbon::today()->format('Y');
        $mouth = $request->input('mouth')??Carbon::today()->format('m');
        $dayYm = Carbon::create($year, $mouth);

        $startMonth = Carbon::now()->startOfMonth()->subMonth();
        $endMonth = Carbon::now()->endOfMonth()->subMonth();

        $userId = Auth::user()->id;

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

            $monthDays[] = [
                'date' => $currentDate,
                'work' => $work,
            ];            
        }

        return view('attendance', [
            'monthDays' => $monthDays,
            'thisMonth' => $dayYm->subMonth(),
        ]);
    }

    public function addDay(Request $request)
    {
        $year = $request->input('year')??Carbon::today()->format('Y');
        $mouth = $request->input('mouth')??Carbon::today()->format('m');
        $dayYm = Carbon::create($year, $mouth);

        $startMonth = Carbon::now()->startOfMonth()->addMonth();
        $endMonth = Carbon::now()->endOfMonth()->addMonth();

        $userId = Auth::user()->id;

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

            $monthDays[] = [
                'date' => $currentDate,
                'work' => $work,
            ];            
        }

        return view('attendance', [
            'monthDays' => $monthDays,
            'thisMonth' => $dayYm->addMonth(),
        ]);
    }
}
