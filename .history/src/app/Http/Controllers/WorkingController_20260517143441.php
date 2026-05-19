<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance_Record;
use \Carbon\Carbon;

class WorkingController extends Controller
{
    public function index()
    {
        return view('timestamp');
    }

    public function working__start()
    {
        $working = Attendance_Record::create([
            'user_id' => Auth::user(),
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => Carbon::now()->format('H:i'),
        ]);

        redirect('/attendance/list');
    }

    public function attendance()
    {
        return view('attendance');
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
