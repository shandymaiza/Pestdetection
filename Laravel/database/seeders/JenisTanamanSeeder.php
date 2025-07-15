<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisTanaman;

class JenisTanamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisTanaman::insert([
            ['nama_jenis' => 'Tanaman Hias'],
            ['nama_jenis' => 'Tanaman Obat'],
            ['nama_jenis' => 'Tanaman Pangan'],
        ]);
    }
}
