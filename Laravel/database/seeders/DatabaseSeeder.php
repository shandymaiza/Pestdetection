<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisTanaman;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
    ['email' => 'test@example.com'],
    [
        'name' => 'Test User',
        'password' => bcrypt('password'), // Atur default password
    ]
);


          $this->call([
            AdminSeeder::class,
            JenisTanamanSeeder::class,
        ]);
    }
}
