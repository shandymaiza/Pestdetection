<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'count', 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
