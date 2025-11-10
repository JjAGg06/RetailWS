<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthMockController extends Controller
{
    public function show() { return view('login'); }

    public function login(Request $r)
    {
        $r->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:Admin,Analista,Invitado'
        ]);
        session(['role' => $r->role, 'email' => $r->email]);
        return redirect()->route('dashboard');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
