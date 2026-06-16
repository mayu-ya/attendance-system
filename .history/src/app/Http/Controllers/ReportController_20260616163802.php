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
        $subMonth = $month->copy()->subMonth(5);

        $reports = Report::where('user_id', $userId)
                        ->whereBetween('month', [$subMonth->format('Y-m'), $month->format('Y-m')])
                        ->get();
        dd($reports);

        $count = Report::where('user_id', $userId)
                        ->where('month', $month->format('Y-m'))
                        ->first();

        return view('report', compact('reports', 'count'));
    }
}
