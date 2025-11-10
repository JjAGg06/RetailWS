<?php

namespace App\Http\Controllers;

class LogsController extends Controller
{
    // GET /logs
    public function index()
    {
        return view('logs'); // resources/views/logs.blade.php
    }
}
