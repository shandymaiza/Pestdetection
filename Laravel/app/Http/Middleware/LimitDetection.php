<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Detection;

class LimitDetection
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $limit = $user->membership === 'premium' ? 7 : 5;

        $detection = Detection::firstOrCreate(
            ['user_id' => $user->id, 'date' => now()->format('Y-m-d')],
            ['count' => 0]
        );

        if ($detection->count >= $limit) {
            return response()->json([
                'success' => false,
                'message' => 'Batas deteksi harian Anda telah habis.'
            ], 403);
        }

        // Tingkatkan jumlah deteksi jika melewati middleware
        $detection->increment('count');
        return $next($request);
    }
}
