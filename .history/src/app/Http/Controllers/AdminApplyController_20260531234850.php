<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Carbon\Carbon;
use App\Models\Apply;
use App\Models\Rest;

class AdminApplyController extends Controller
{
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

    public function wait()
    {
        $applies = Apply::with('rests', 'user')->where('status', 'pending')->get();
        
        foreach($applies as $apply){
            $apply->date = Carbon::parse($apply->date)->format('Y/m/d');
            $apply->updated_at_formatted = Carbon::parse($apply->updated_at)->format('Y/m/d');
        }

        return view('admin.apply_wait', compact('applies'));
    }

    public function approved()
    {
        $applies = Apply::with('rests', 'user')->where('status', 'approved')->get();

        foreach($applies as $apply){
            $apply->date = Carbon::parse($apply->date)->format('Y/m/d');
            $apply->updated_at_formatted = Carbon::parse($apply->updated_at)->format('Y/m/d');
        }

        return view('admin.apply', compact('applies'));
    }

    public function request($attendance_correct_request_id)
    {
        $apply = Apply::with('rests', 'user')->where('id', $attendance_correct_request_id)->first();

        $apply->date_year = Carbon::parse($apply->date)->isoFormat('YYYY年');
        $apply->date_day = Carbon::parse($apply->date)->isoFormat('M月DD日');
        $apply->start_time = Carbon::parse($apply->start_time)->format('H:i');
        $apply->end_time = Carbon::parse($apply->end_time)->format('H:i');

        foreach($apply->rests as $rest){
            $apply->rest_start = Carbon::parse($rest->rest_start)->format('H:i');
            $apply->rest_end = Carbon::parse($rest->rest_end)->format('H:i');
        }

        return view('admin.approval', compact('apply'));
    }

    public function approval(Request $request)
    {
        $applyId = $request->input('id');

        $apply = Apply::with('rests')-find($applyId);

        $restTime = $apply->rests->sum('rest_total');
        $totailRestTime = sprintf('%02d:%02d:00', floor($restTime / 60), $restTime % 60);

        $start = Carbon::parse($apply->start_time);
        $end = Carbon::parse($apply->end_time);
        $totail = $start->diffInMinutes($end);
        $totailWork = $totail->$restTime;
        $totailTime = sprintf('%02d:%02d:00', floot($totailWork / 60), $totailWork % 60);

        $apply->update([
            'admin_id' => Auth::user('admin')->id,
            'work_total' => $totailTime,
            'duration' => $totailRestTime,
            'status' => 'approved'
        ]);

        return redirect()->back();
    }
}
