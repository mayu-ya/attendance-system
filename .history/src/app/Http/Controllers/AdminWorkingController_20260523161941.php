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
        $works = AttendanceRecord::with('User')->where('date', $date)->get();

        return view('admin.attendance', compact('works'));
    }

    public function detail($id)
    {
        $work = AttendanceRecord::where('id', $id)->first();
        $user = User::where('id', $work->user_id)->first();
        $breaks = BreakTime::where('attendance_record_id', $id)->get();

        return view('admin.detail', compact('work', 'user', 'breaks'));
    }

    public function staff()
    {
        $users = User::all();

        return view('admin.staff', compact('users'));
    }

    public function person($id)
    {
        $user = User::find($id);
        
        $startMonth = Carbon::now()->startOfMonth();
        $endMonth = Carbon::now()->endOfMonth();

        $records = AttendanceRecord::where('user_id', $id)->whereBetween('date', [$startMonth->toDateString(), $endMonth->toDateString()])
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

        return view('admin.person', compact('user', 'monthDays'));
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
