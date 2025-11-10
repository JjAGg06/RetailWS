<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard'); // resources/views/dashboard.blade.php
    }
}
