<?php

namespace App\Http\Controllers;

use App\Models\Tanaman;
use App\Models\JenisTanaman;
use Illuminate\Http\Request;

class AdminTanamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pencarian = $request->input('cari');

        $tanamans = Tanaman::with('jenisTanaman')
            ->when($pencarian, function ($query) use ($pencarian) {
                $query->where('Nama', 'like', "%$pencarian%");
            })->get();

        $jenisTanamanList = JenisTanaman::all(); //  Diperbaiki: ambil semua jenis tanaman

        return view('admin/mengelolatanaman', compact('tanamans', 'jenisTanamanList', 'pencarian'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:infotanaman,Nama',
            'klasifikasi' => 'required|string|max:255',
            'jenis_tanaman_id' => 'required|exists:jenis_tanaman,id', // ⬅️ Diperbaiki: koma hilang sebelumnya
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:10000',
            'deskripsi' => 'required|string',
        ]);

        $filepath = public_path('uploads');
        $infotanaman = new Tanaman();
        $infotanaman->Nama = $request->nama;
        $infotanaman->Klasifikasi = $request->klasifikasi;
        $infotanaman->Deskripsi = $request->deskripsi;
        $infotanaman->jenis_tanaman_id = $request->jenis_tanaman_id; // ⬅️ Tambahkan relasi

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = uniqid() . date('Y-m-d') . $file->getClientOriginalName();
            $file->move($filepath, $filename);
            $infotanaman->Gambar = $filename;
        }

        $infotanaman->save();

        return redirect()->route('mengelolatanaman.index')->with('success', 'Data tanaman berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'klasifikasi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
            'deskripsi' => 'required|string',
            'jenis_tanaman_id' => 'required|exists:jenis_tanaman,id', // ⬅️ Ditambahkan validasi jenis_id
        ]);

        $tanaman = Tanaman::findOrFail($id);
        $tanaman->Nama = $request->nama;
        $tanaman->Klasifikasi = $request->klasifikasi;
        $tanaman->Deskripsi = $request->deskripsi;
        $tanaman->jenis_tanaman_id = $request->jenis_tanaman_id; // ⬅️ Tambahkan relasi

        if ($request->hasFile('gambar')) {
            $filepath = public_path('uploads');
            $file = $request->file('gambar');
            $filename = uniqid() . date('Y-m-d') . $file->getClientOriginalName();
            $file->move($filepath, $filename);
            $tanaman->Gambar = $filename;
        }

        $tanaman->save();

        return redirect()->route('mengelolatanaman.index')->with('success', 'Data tanaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $Id_Tanaman)
    {
        $del = Tanaman::findOrFail($Id_Tanaman);
        $del->delete();
        return redirect()->route('mengelolatanaman.index')->with('success', 'Data tanaman berhasil dihapus.');
    }
}
