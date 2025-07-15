<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hama extends Model
{
    use HasFactory;
    protected $table = 'infohama';
    protected $primaryKey = 'Id_Hama';
    protected $keyType = 'int'; 
    protected $fillable = [
        'nama',
        'klasifikasi',
        'gambar',
        'deskripsi',
    ];
}
