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
        $userId = Auth::user()->id;
        $apply = Apply::where('user_id', $userId)->where('attendance_record_id', $id)->first();
        $work = AttendanceRecord::with('user')->where('id', $id)->first();

        if($apply){
            $breaks = Rest::where('apply_id', $apply->id)->get();
        }
  
        $breaks = BreakTime::where('attendance_record_id', $id)->get();

        return view('detail', compact('work', 'apply', 'breaks'));
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

        $rests = collect();

        if($breaks){
        foreach($breaks as $break)
        {
            $restStart = Carbon::parse($break['rest_start']);
            $restEnd = Carbon::parse($break['rest_end']);
            $total = $restStart->diffInMinutes($restEnd);

            $rest = Rest::create([
                'apply_id' => $apply->id,
                'rest_start' => $restStart,
                'rest_end' => $restEnd,
                'rest_total' => $total
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

    public function mix_apply(Request $request)
    {
        if(Auth::guard('admin')->check()){
            return $this->index($request);
        }

        return $this->apply($request);
    }

    public function apply(Request $request)
    {
        $action = $request->input('action');
        $userId = Auth::user()->id;

        if($action === 'wait')
        {
            $applies = Apply::with('rests', 'user')->where('user_id', $userId)->where('status', 'pending')->get();
        
            foreach($applies as $apply){
                $apply->date = Carbon::parse($apply->date)->format('Y/m/d');
                $apply->updated_at_formatted = Carbon::parse($apply->updated_at)->format('Y/m/d');
            }

            return view('apply_wait', compact('applies'));
        }
        elseif($action === 'apply')
        {
            $applies = Apply::with('rests', 'user')->where('user_id', $userId)->where('status', 'approved')->get();

            foreach($applies as $apply){
                $apply->date = Carbon::parse($apply->date)->format('Y/m/d');
                $apply->updated_at_formatted = Carbon::parse($apply->updated_at)->format('Y/m/d');
            }

            return view('apply', compact('applies'));
        }
    }

    public function index(Request $request)
    {
        $action = $request->input('action');

        if($action === 'wait')
        {
            $applies = Apply::with('rests', 'user')->where('status', 'pending')->get();
        
            foreach($applies as $apply){
                $apply->date = Carbon::parse($apply->date)->format('Y/m/d');
                $apply->updated_at_formatted = Carbon::parse($apply->updated_at)->format('Y/m/d');
            }

            return view('admin.apply_wait', compact('applies'));
        }
        elseif($action === 'apply')
        {
            $applies = Apply::with('rests', 'user')->where('status', 'approved')->get();

            foreach($applies as $apply){
                $apply->date = Carbon::parse($apply->date)->format('Y/m/d');
                $apply->updated_at_formatted = Carbon::parse($apply->updated_at)->format('Y/m/d');
            }

            return view('admin.apply', compact('applies'));
        }
    }
}
