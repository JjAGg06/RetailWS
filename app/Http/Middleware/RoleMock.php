<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMock
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('role')) {
            return redirect()->route('login')->with('msg', 'Inicia sesión (demo).');
        }
        return $next($request);
    }
}
