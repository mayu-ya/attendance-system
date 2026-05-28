<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AttendanceRecord;
use App\Models\BreakTime;
use App\Models\Apply;
use App\Models\Rest;
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

    public function attendance()
    {
        $startMonth = Carbon::now()->startOfMonth();
        $endMonth = Carbon::now()->endOfMonth();

        $userId = Auth::user()->id;

        $records = AttendanceRecord::where('user_id', $userId)->whereBetween('date', [$startMonth->toDateString(), $endMonth->toDateString()])
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

        return view('attendance', compact('monthDays'));
    }

    public function detail($id)
    {
        $apply = Apply::where('attendance_record_id', $id)->first();

        if($apply){
            $rests = Rest::where('apply_id', $apply->id)->get();

            return view('detail', compact('apply', 'rests'));
        }

        $work = AttendanceRecord::with('user')->where('id', $id)->first();
        $breaks = BreakTime::where('attendance_record_id', $id)->get();

        return view('detail', compact('work', 'breaks'));
    }

    public function request(Request $request, $id)
    {
        //dd($request);
        $item = $request->except('breaks', 'rest');
        $breaks = $request->input('breaks');
        //dd($breaks);

        $apply = Apply::create([
            'user_id' => Auth::user()->id,
            'attendance_record_id' => $id,
            'date' => $item->date,
            'start_time' => Carbon::parse($item->start_time),
            'end_time' => Carbon::parse($item->end_time),
            'content' => $item->content,
            'status' => 'pending'
        ]);
        dd($apply);

        foreach($breaks[breaks] as $break){
            $restStart = Carbon::parse($break->rest_start);
            $restEnd = Carbon::parse($break->rest_end);
            $total = $restStart->diffInMinutes($restEnd);
            $restTotal = Carbon::parse($total);

            $rest = Rest::create([
                'apply_id' => $apply->id,
                'rest_start' => $restStart,
                'rest_end' => $restEnd,
                'rest_total' => $restTotal
            ]);
            $rests->push($rest);
        }

        if($request->fill('rest')){
            $breakDate = $request->input('rest');
            $breakStart = Carbon::parse($breakDate->rest_start);
            $breakEnd = Carbon::parse($breakDate->rest_end);
            $totalDate = $restStart->diffInMinutes($breakEnd);
            $breakTotal = Carbon::parse($totalDate);

            Rest::create([
                'apply_id' => $apply->id,
                'rest_start' => $breakStart,
                'rest_end' => $breakEnd,
                'rest_total' => $breakTotal
            ]);
        }

        return redirect()->back();
    }

    public function apply()
    {
        return view('apply');
    }
}
