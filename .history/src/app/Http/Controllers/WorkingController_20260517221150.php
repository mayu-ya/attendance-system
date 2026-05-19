<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AttendanceRecord;
use \Carbon\Carbon;

class WorkingController extends Controller
{
    public function index()
    {
        $date = Carbon::now()->isoFormat('YYYY/MM/DD/');
        $work = AttendanceRecord::where('date', $date)->first();

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

    public function working__end()
    {
        $date = Carbon::now()->isoFormat('YYYY/MM/DD/');
        $time = Carbon::now();
        $workStart = $work = AttendanceRecord::where('date', $date)->first('start_time');
        $work = AttendanceRecord::where('date', $date)->first()->update([
            'end_time' => Carbon::now()->format('H:i'),
            'work_total' => $time - $workStart,
        ]);

        return redirect('/attendance/list');
    }

    public function attendance()
    {
        $userId = Auth::user()->id;
        $attendances = AttendanceRecord::where('user_id', $userId);

        return view('attendance', compact('attendances'));
    }

    public function detail()
    {
        return view('detail');
    }

    public function apply()
    {
        return view('apply');
    }
}
