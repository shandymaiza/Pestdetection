<?php

namespace App\Http\Controllers;
use App\Models\Hama;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AdminHamaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pencarian = $request->input('cari');
        if($pencarian){
            $hamaa = Hama::where('nama', 'like', '%'. $pencarian . '%')->get();
        } else {
            $hamaa= Hama::all();
        }
        
        return view('admin/mengelolahama', compact('hamaa', 'pencarian'));
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
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:infohama,Nama',
            'klasifikasi' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:10000',
            'deskripsi' => 'required|string',
        ]);

        $filepath = public_path('uploads');
        $infohama = new Hama();
        $infohama->Nama= $request->nama;
        $infohama->Klasifikasi = $request->klasifikasi;
        $infohama->Deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) { 
            $file = $request->file('gambar'); 
            $filename = uniqid() . date('Y-m-d') .  $file->getClientOriginalName();

            $file->move($filepath, $filename);
            $infohama->Gambar = $filename;

         }
          $infohama->save();
          return redirect()->route('mengelolahama.index')->with('success', 'Data hama berhasil ditambahkan.');
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
        $request->validate([
            'nama' => 'required|string|max:255',
            'klasifikasi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
            'deskripsi' => 'required|string',
        ]);
    
        $hama = Hama::findOrFail($id);
        $hama->Nama = $request->nama;
        $hama->Klasifikasi = $request->klasifikasi;
        $hama->Deskripsi = $request->deskripsi;
    
        if ($request->hasFile('gambar')) {
            $filepath = public_path('uploads');
            $file = $request->file('gambar');
            $filename = uniqid() . date('Y-m-d') .  $file->getClientOriginalName();
            $file->move($filepath, $filename);
            $hama->Gambar = $filename;
        }
    
        $hama->save();
        return redirect()->route('mengelolahama.index')->with('success', 'Data tanaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $Id_Hama)
    {
        $del = Hama::findorFail($Id_Hama);
        $del->delete();
        return redirect()->route('mengelolahama.index')->with('success', 'Data tanaman berhasil dihapus.');;
    }
}