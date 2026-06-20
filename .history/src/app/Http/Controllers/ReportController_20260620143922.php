<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use \Carbon\Carbon;

class ReportController extends Controller
{
    public function report()
    {
        $userId = Auth::id();
        $month = Carbon::now();
        $subMonth = $month->copy()->subMonth(5);

        $reports = Report::where('user_id', $userId)
                        ->whereBetween('month', [$subMonth->format('Y-m'), $month->format('Y-m')])
                        ->get();

        $count = Report::where('user_id', $userId)
                        ->where('month', $month->format('Y-m'))
                        ->first();

        $total = 0;
        foreach($reports as $report) {
            $timeTotal = Carbon::parse($report->total_work)->format('H:i');
            sscanf($timeTotal, '%d:%d', $hours, $minutes);
            $total += ($hours * 60) + $minutes;
            dd($hours);
        }

        return view('report', compact('reports', 'count', 'total'));
    }
}
