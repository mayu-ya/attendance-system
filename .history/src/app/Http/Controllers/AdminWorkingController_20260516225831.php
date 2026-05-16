<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminWorkingController extends Controller
{
    public function index()
    {
        return view('admin.staff');
    }

    public function detail()
    {
        return view('admin.detail');
    }

    public function person()
    {
        return view('admin.person');
    }
}
