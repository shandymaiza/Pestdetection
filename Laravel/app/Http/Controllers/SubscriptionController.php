<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SubscriptionController extends Controller
{
    public function updateSubscription(Request $request)
    {
        $user = Auth::user();

        // Perbarui status berlangganan
        $user->membership = 'premium';
        $user->membership_expiry = now()->addMonth();
        $user->save();

        return response()->json(['message' => 'Status berlangganan berhasil diperbarui.']);
    }
}
