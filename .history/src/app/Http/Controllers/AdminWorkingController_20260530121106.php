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
    public function index(Request $request)
    {
        $day = $request->input('date') ?? Carbon::toDay();
        $date = Carbon::parse($day);

        $action = $request->input('action');
        if($action === 'sub'){
            $date->subDay();
        } elseif($action === 'add'){
            $date->addDay();
        }

        $works = AttendanceRecord::with('user')->where('date', $date)->get();

        return view('admin.attendance', compact('works', 'date'));
    }

    public function detail($id)
    {
        $work = AttendanceRecord::with('user')->where('id', $id)->first();
        $breaks = BreakTime::where('attendance_record_id', $id)->get();

        return view('admin.detail', compact('work', 'breaks'));
    }

    public function staff()
    {
        $users = User::all();

        return view('admin.staff', compact('users'));
    }

    public function person($id)
    {
        $year = $request->input('year')??Carbon::today()->format('Y');
        $month = $request->input('month')??Carbon::today()->format('m');
        $dayYm = Carbon::create($year, $month);

        $action = $request->input('action');
        if($action === 'sub'){
            $dayYm->subMonth();
        }
        elseif($action === 'add'){
            $dayYm->addMonth();
        }

        $user = User::find($id);
        
        $startMonth = $dayYm->copy()->startOfMonth();
        $endMonth = $dayYm->copy()->endOfMonth();

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

        return view('admin.person', [
            'user' => $user,
            'monthDays' => $monthDays,
            'thisMonth' => $dayYm,
        ]);
    }
}
