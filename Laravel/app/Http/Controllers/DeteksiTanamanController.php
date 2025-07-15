<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class DeteksiTanamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->membership == 'premium' && $user->membership_expiry < now()) {
            $user->membership = 'free';
            $user->membership_expiry = null;
            $user->save();
        }

        return view('user/halamandeteksi');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function upload(Request $request)
   {
    // Validasi file gambar
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg|max:10000',
    ]);

    // Simpan gambar ke public/deteksi
    $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
    $filePath = public_path('deteksi'); // Path ke public/deteksi
    $request->file('image')->move($filePath, $fileName);

    try {
        // Kirim gambar ke Flask API
        $fullPath = public_path("deteksi/$fileName");
        $response = Http::attach(
            'image', file_get_contents($fullPath), $fileName
        )->post('http://127.0.0.1:9001/detect'); // URL Flask API

        if ($response->successful()) {
            $result = $response->json();
            return response()->json([
                'status' => 'success',
                'result' => $result['result'],
                'image_url' => asset("deteksi/$fileName"), // URL gambar
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal mendeteksi gambar.',
        ], $response->status());
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
        ], 500);
    }
}
 
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}