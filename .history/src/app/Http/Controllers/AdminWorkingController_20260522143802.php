<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\AttendanceRecord;
use App\Models\BreakTime;
use \Carbon\Carbon;

class AdminWorkingController extends Controller
{
    public function index()
    {
        $date = Carbon::toDay();
        $works = AttendanceRecord::where('date', $date)->get();

        return view('admin.attendance', compact('works'));
    }

    public function detail($id)
    {
        return view('admin.detail');
    }

    public function staff()
    {
        $users = User::all();

        return view('admin.staff', compact('users'));
    }

    public function person()
    {
        return view('admin.person');
    }

    public function apply()
    {
        return view('admin.apply_wait');
    }
    
    public function approval()
    {
        return view('admin.approval');
    }
}
