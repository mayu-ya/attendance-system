<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminApplyController extends Controller
{
    public function apply()
    {
        $applies = Apply::with('rests', 'user')->where('status', 'pending')->get();
        
        foreach($applies as $apply){
            $apply->date = Carbon::parse($apply->date)->format('Y/m/d');
            $apply->updated_at_formatted = Carbon::parse($apply->updated_at)->format('Y/m/d');
        }

        return view('apply_wait', compact('applies'));
    }

    public function show()
    {
        $applies = Apply::with('rests', 'user')->where('status', 'approved')->get();
        
        foreach($applies as $apply){
            $apply->date = Carbon::parse($apply->date)->format('Y/m/d');
            $apply->updated_at_formatted = Carbon::parse($apply->updated_at)->format('Y/m/d');
        }

        return view('apply', compact('applies'));
    }
}
