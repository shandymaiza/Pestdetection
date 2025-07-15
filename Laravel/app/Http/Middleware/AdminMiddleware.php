<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login DAN is_role = 1 atau 2
        if (!Auth::check() || !in_array(Auth::user()->is_role, [1, 2])) {
            return redirect()->back()->with('error', 'Access denied!');
        }

        return $next($request);
    }
}
