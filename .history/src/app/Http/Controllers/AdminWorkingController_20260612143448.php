<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminTimeRequest;
use App\Models\User;
use App\Models\AttendanceRecord;
use App\Models\BreakTime;
use App\Models\Apply;
use App\Models\Rest;
use \Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        $apply = Apply::where('attendance_record_id', $work->id)->first();
        if($apply){
            $apply->rests = Rest::where('apply_id', $apply->id)->get();
        }

        return view('admin.detail', compact('work', 'breaks', 'apply'));
    }

    public function request(AdminTimeRequest $request, $id)
    {
        $item = $request->except('breaks', 'rest');
        $breaks = $request->input('breaks');
        $work = AttendanceRecord::find($id);

        $apply = Apply::updateOrCreate(
            ['attendance_record_id' => $work->id],
            ['user_id' => Auth::guard('admin')->user()->id,
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
            if (empty($break['rest_start']) || empty($break['rest_end'])) {
            continue; 
            }

            $restStart = Carbon::parse($break['rest_start']);
            $restEnd = Carbon::parse($break['rest_end']);
            $total = $restStart->diffInMinutes($restEnd);

            $startTimeString = $restStart->format('H:i:s');
            $endTimeString = $restEnd->format('H:i:s');

            $rest = Rest::updateOrCreate(
                [
                    'apply_id' => $apply->id,
                    'rest_start' => $startTimeString
                ],
                [
                    'apply_id' => $apply->id,
                    'rest_start' => $startTimeString,
                    'rest_end' => $endTimeString,
                    'rest_total' => $total
            ]);
            $rests->push($rest);
        }
        }

        if($request->input('rest')){
            if (!empty($breakDate['rest_start']) && !empty($breakDate['rest_end'])) {
            $breakDate = $request->input('rest');
            $breakStart = Carbon::parse($breakDate['rest_start']);
            $breakEnd = Carbon::parse($breakDate['rest_end']);
            $totalDate = $breakStart->diffInMinutes($breakEnd);

            Rest::updateOrCreate(
                [
                    'id' => $breakDate['id'] ?? null,
                    'apply_id' => $apply->id
                ],
                [
                    'apply_id' => $apply->id,
                    'rest_start' => $breakStart->format('H:i'),
                    'rest_end' => $breakEnd->format('H:i'),
                    'rest_total' => $totalDate
            ]);
            }
        }

        return redirect()->back();
    }

    public function staff()
    {
        $users = User::all();

        return view('admin.staff', compact('users'));
    }

    public function person(Request $request, $id)
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

    public function export(Request $request)
    {
        //dd($request);
        $userId = $request->user_id;
        $month = str_replace('/', '-', $request->thisMonth);
        $dayYm = carbon::parse($month);
        $startMonth = $dayYm->copy()->startOfMonth();
        $endMonth = $dayYm->copy()->endOfMonth();

        $attendances = AttendanceRecord::with('applies', 'user')
                                        ->where('user_id', $userId)
                                        ->whereBetween('date', [$startMonth->toDateString(), $endMonth->toDateString()])
                                        ->get();

        $csvTitile = [$attendances->user->name . 'さんの勤怠 '];
        fputcsv($csvTitile, $row);

        $csvHeader = ['日付', '出勤', '退勤', '休憩', '合計'];
        $csvAttendance = $attendances->toArray();

        $response = new StreamedResponse(function () use($csvHeader, $csvAttendance) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, pack('C*', 0xEF, 0xBB, 0xBF));
            fputcsv($handle, $csvHeader);

            foreach($csvAttendance as $row) {
                $startTime = Carbon::parse($attendance->start_time)->format('H:i');
                $endTime = Carbon::parse($attendance->end_time)->format('H:i');
                $workTotal = Carbon::parse($attendance->work_total)->format('H:i');
                $duration = Carbon::parse($attendance->duration)->format('H:i');

                $row = [
                    $attendance->date,
                    $startTime,
                    $endTime,
                    $workTotal,
                    $duration,
                ];

                fputcsv($handle, $row);
            }
            fclose($handle);
        }, 200, [
            'content-Type' => 'text/csv',
            'content-Disposition' => 'attendance.csv',
        ]);

        return $response;
    }
}
