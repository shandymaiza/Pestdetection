<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckMembershipStatus
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->membership == 'premium' && $user->membership_expiry < now()) {
            $user->membership = 'free';
            $user->membership_expiry = null;
            $user->save();
        }

        return $next($request);
    }
}