<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Guard;


class PaymentController extends Controller
{
    public function createTransaction(Request $request)
{
    // Set Midtrans Config
    Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
    Config::$isSanitized = true;
    Config::$is3ds = true;

    // Ambil data pengguna yang sedang login
    $user = auth()->user();

    // Data transaksi
    $transactionDetails = [
        'order_id' => 'order-' . auth()->id() . '-' . Str::uuid(),
        'gross_amount' => 100000, // Harga dalam IDR
    ];

    $itemDetails = [
        [
            'id' => 'basic_plan',
            'price' => 100000,
            'quantity' => 1,
            'name' => 'Basic Plan',
        ],
    ];

    $customerDetails = [
        'first_name' => $user->first_name ?? explode(' ', $user->name)[0],
        'last_name' => $user->last_name ?? explode(' ', $user->name)[1] ?? '',
        'email' => $user->email,
        'phone' => '',
    ];

    // Membuat transaksi
    $transaction = [
        'transaction_details' => $transactionDetails,
        'item_details' => $itemDetails,
        'customer_details' => $customerDetails,
    ];

    try {
        $snapToken = Snap::getSnapToken($transaction);
        return response()->json(['snapToken' => $snapToken]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


}
