<?php

namespace App\Http\Controllers;
use App\Models\Tanaman;
use App\Models\Hama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (Auth::user()->is_role == 2) {
            return view('superadmin.dashboard');
        } 
        elseif (Auth::user()->is_role == 1) {
            // Gabungkan data dari kedua function
            $data['getRecord'] = User::find(Auth::user()->id);
            $data['jumlahpengguna'] = User::count();
            $data['jumlahhama'] = Hama::count();
            $data['jumlahtanaman'] = Tanaman::count();
            $data['penggunabiasa'] = User::where('is_role', 0)->take(4)->get();
            
            return view('admin.dashboard', $data);
        } 
        elseif (Auth::user()->is_role == 0) {
            $data['getRecord'] = User::find(Auth::user()->id);
            return view('user.halamandeteksi', $data);
        }
    }
}
