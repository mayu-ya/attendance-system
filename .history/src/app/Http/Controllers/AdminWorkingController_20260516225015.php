<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminWorkingController extends Controller
{
    public function index()
    {
        return view('admin.attendance');
    }

    public function detail()
    {
        return view('admin.detail');
    }
}
