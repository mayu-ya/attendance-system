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
        $startMonth = Carbon::now()->startOfMonth();
        $endMonth = Carbon::now()->endOfMonth();

        $records = AttendanceRecord::whereBetween('date', [$startMonth->format('Y-m-d'), $endMonth->format('Y-m-d')])
                   ->get();
        
        $monthDays = [];
        $daysMonth = $startMonth->daysInMonth;
        for ($i = 0; $i < $daysMonth; $i++) {
            $currentDate = $startMonth->copy()->addDays($i)->format('Y-m-d');

            $work = $records->get($currentDate);

            if($work){
                $work->break = BreakTime::where('attendance_record_id', $work->id)->get();
            }

            $monthDays[] = [
                'date' => $currentDate,
                'work' => $work
            ];
        }
        
        return view('timestamp', compact('monthDays'));
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
        $workStart = AttendanceRecord::where('date', $date)->first('start_time');
        $endTime = Carbon::now();
        AttendanceRecord::where('date', $date)->first()->update([
            'end_time' => Carbon::now()->format('H:i'),
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
        BreakTime::where('attendance_record_id', $workId)->latest()->first()
                    ->update([
                        'rest_end' => Carbon::now()->format('H:i'),
                    ]);

        return redirect('/attendance/list');
    }

    public function attendance()
    {
        $userId = Auth::user()->id;
        $works = AttendanceRecord::where('user_id', $userId)->get();
        return view('attendance', compact('works'));
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
