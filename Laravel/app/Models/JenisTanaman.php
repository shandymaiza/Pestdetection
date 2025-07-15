<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JenisTanaman;

class JenisTanaman extends Model
{
    protected $table = 'jenis_tanaman';
    protected $fillable = ['nama_jenis'];

    public function tanamans()
    {
        return $this->hasMany(Tanaman::class, 'jenis_tanaman_id');
    }
}
