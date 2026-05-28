<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AttendanceRecord;
use App\Models\BreakTime;
use \Carbon\Carbon;
use App\Models\Apply;
use App\Models\Rest;
use App\Http\Requests\TimeRequest;

class ApplyController extends Controller
{
    public function detail($id)
    {
        $apply = Apply::where('attendance_record_id', $id)->first();

        if($apply){
            $breaks = Rest::where('apply_id', $apply->id)->get();

            return view('detail', compact('apply', 'breaks'));
        }

        $work = AttendanceRecord::with('user')->where('id', $id)->first();
        $breaks = BreakTime::where('attendance_record_id', $id)->get();

        return view('detail', compact('work', 'breaks'));
    }

    public function request(TimeRequest $request, $id)
    {
        $item = $request->except('breaks', 'rest');
        $breaks = $request->input('breaks');
        $work = AttendanceRecord::find($id);

        $apply = Apply::create([
            'user_id' => Auth::user()->id,
            'attendance_record_id' => $id,
            'date' => $work->date,
            'start_time' => Carbon::parse($item['start_time']),
            'end_time' => Carbon::parse($item['end_time']),
            'content' => $item['content'],
            'status' => 'pending'
        ]);

        if($breaks){
        foreach($breaks['breaks'] as $break)
        {
            $restStart = Carbon::parse($break['rest_start']);
            $restEnd = Carbon::parse($break['rest_end']);
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
        }

        if($request->input('rest')){
            $breakDate = $request->input('rest');
            $breakStart = Carbon::parse($breakDate['rest_start']);
            $breakEnd = Carbon::parse($breakDate['rest_end']);
            $totalDate = $breakStart->diffInMinutes($breakEnd);

            Rest::create([
                'apply_id' => $apply->id,
                'rest_start' => $breakStart->format('H:i:s'),
                'rest_end' => $breakEnd->format('H:i:s'),
                'rest_total' => $totalDate
            ]);
        }

        return redirect()->back();
    }

    public function apply()
    {
        $userId = Auth::user()->id;
        $applies = Apply::with('rests', 'user')->where('user_id', $userId)->where('status', 'pending')->get();
        
        foreach($applies as $apply){
            $apply->date = Carbon::parse($apply['date'])->format('Y/m/d');
        }

        return view('apply_wait', compact('applies'));
    }
}
