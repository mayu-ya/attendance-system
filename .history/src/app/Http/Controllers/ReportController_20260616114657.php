<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use \Carbon\Carbon;

class ReportController extends Controller
{
    public function export()
    {
        $userId = Auth::id();
        $month = Carbon::now();
        $subMonth = $month->copy()->subMonth(6);

        $reports = Report::where('user_id', $userId)
                        ->whereBetween('month', [$month->format('Y-m'), $subMonth->format('Y-m')])
                        ->get();

        $count = Report::where('user_id', $userId)
                        ->whereYear('month', $month->year)
                        ->whereMonth('month', $month->month)
                        ->first();

        return view('report', compact('reports', 'count'));
    }
}
