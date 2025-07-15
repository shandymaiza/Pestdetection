<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JenisTanaman;

class Tanaman extends Model
{
    use HasFactory;
    protected $table = 'infotanaman';
    protected $primaryKey = 'Id_Tanaman';
    protected $keyType = 'int';
    protected $fillable = [
        'nama',
        'klasifikasi',
        'gambar',
        'deskripsi',
        'jenis_tanaman_id',
    ];

    public function jenis()
    {
        return $this->belongsTo(JenisTanaman::class, 'jenis_tanaman_id');
    }

    public function jenisTanaman()
{
    return $this->belongsTo(JenisTanaman::class, 'jenis_tanaman_id');
}
}
