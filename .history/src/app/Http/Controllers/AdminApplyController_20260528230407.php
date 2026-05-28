<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
