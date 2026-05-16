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

    public function staff()
    {
        return view('admin.staff');
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
