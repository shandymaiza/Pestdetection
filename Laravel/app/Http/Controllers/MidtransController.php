<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Transaction;
use App\Models\User;

class MidtransController extends Controller
{
    public function handleNotification(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Ambil data notifikasi dari Midtrans
        $notification = $request->all();

        // Ambil informasi transaksi
        $transactionStatus = $notification['transaction_status'];
        $orderId = $notification['order_id'];
        $orderParts = explode('-', $orderId);
        
        $userId = $orderParts[1]; // Ambil user_id dari order_id
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Periksa status transaksi
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            // Pembayaran berhasil, ubah status menjadi premium
            $user->membership = 'premium';
            $user->membership_expiry = now()->addMonth();
            $user->save();

            return response()->json(['message' => 'Subscription updated to premium'], 200);
        } elseif ($transactionStatus == 'pending') {
            // Pembayaran tertunda
            return response()->json(['message' => 'Payment pending'], 200);
        } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            // Pembayaran gagal
            return response()->json(['message' => 'Payment failed'], 200);
        }

        return response()->json(['message' => 'Transaction status unknown'], 400);
    }
}
