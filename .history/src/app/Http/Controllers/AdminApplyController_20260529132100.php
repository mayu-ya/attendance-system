<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Carbon\Carbon;
use App\Models\Apply;
use App\Models\Rest;

class AdminApplyController extends Controller
{
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

        $apply->start_time = Corbon::parse($apply->start_time)->format('H:i');

        foreach($apply->rests as $apply){
            //
        }

        return view('admin.approval', compact('apply'));
    }
}
