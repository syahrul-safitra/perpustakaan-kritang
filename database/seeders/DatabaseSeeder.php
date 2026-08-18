<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Membuat akun Admin Pustakawan
        // User::create([
        //     'name' => 'Admin Pustakawan',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('password'), // Password untuk login nanti
        //     // 'role' => 'admin', // Pastikan kolom role sudah ada di migration users kamu
        // ]);

        User::create([
            'nama_lengkap' => 'Administrator Utama',
            'email'        => 'admin@gmail.com',
            'password'     => Hash::make('password123'),
        ]);
    }
}
