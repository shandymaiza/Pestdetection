<?php

namespace App\Http\Controllers;
use App\Models\Tanaman;
use App\Models\Hama;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function pengguna(Request $request)
    {
    return view('admin/pengguna');
    }

    public function informasi()
    {
        $jumlahpengguna = User::count();
        $jumlahhama = Hama::count();
        $jumlahtanaman = Tanaman::count();
        $penggunabiasa = User::where('is_role', 0)->get();

        return view('admin/pengguna', compact('jumlahhama','jumlahtanaman','jumlahpengguna','penggunabiasa'));
    }
}
