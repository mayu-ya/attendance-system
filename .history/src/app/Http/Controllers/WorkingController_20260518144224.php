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
        $date = Carbon::now()->isoFormat('YYYY/MM/DD/');
        $work = AttendanceRecord::where('date', $date)->first();
        if($work){
        $workId = $work->id;
        $break = BreakTime::where('attendance_record_id', $workId)->get();
        }

        return view('timestamp', compact('work', 'break'));
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

    public function working__end()
    {
        $date = Carbon::now()->isoFormat('YYYY/MM/DD/');
        $time = Carbon::now();
        $workStart = AttendanceRecord::where('date', $date)->first('start_time');
        AttendanceRecord::where('date', $date)->first()->update([
            'end_time' => Carbon::now()->format('H:i'),
            'work_total' => $time - $workStart,
        ]);

        return redirect('/attendance/list');
    }

    public function break__start(Request $request)
    {
        $workId = $request->only('id');
        Breaktime::create([
            'attendance_record_id' => $workId,
            'rest_start' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
        ]);

        return redirect('/attendance/list');
    }

    public function attendance()
    {
        $userId = Auth::user()->id;
        $attendances = AttendanceRecord::where('user_id', $userId)->get();
        //dd($attendances);
        return view('attendance', compact('attendances'));
    }

    public function detail()
    {
        $userId = Auth::user()->id;
        $attendance = AttendanceRecord::where('user_id', $userId)->get();
        return view('detail');
    }

    public function apply()
    {
        return view('apply');
    }
}
