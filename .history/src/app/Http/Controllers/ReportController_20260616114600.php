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
        $month = Carbon::now()->format('Y-m');
        $subMonth = $month->copy()->subMonth(6)->format('Y-m');

        $reports = Report::where('user_id', $userId)
                        ->whereBetween('month', [$month, $subMonth])
                        ->get();

        $count = Report::where('user_id', $userId)
                        ->whereYear('month', $month->year)
                        ->whereMonth('month', $month->month)
                        ->first();

        return view('report', compact('reports', 'count'));
    }
}
