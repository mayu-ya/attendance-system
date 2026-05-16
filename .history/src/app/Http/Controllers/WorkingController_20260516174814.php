<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkingController extends Controller
{
    public function index()
    {
        return view('timestamp');
    }

    public function detail()
    {
        return view('detail');
    }

    public function apply()
    {
        return view('apply_wait');
    }
}
