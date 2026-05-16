<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminWorkingController extends Controller
{
    public function index()
    {
        return view('admin.apply_wait');
    }

    public function detail()
    {
        return view('admin.detail');
    }

    public function person()
    {
        return view('admin.person');
    }

    public function approval()
    {
        return view('admin.approval');
    }
}
