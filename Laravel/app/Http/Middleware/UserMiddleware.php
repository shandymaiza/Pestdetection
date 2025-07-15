<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !in_array(Auth::user()->is_role, [0])) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }
        return $next($request);
    }
}
