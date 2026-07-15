<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat akun Penumpang (Passenger)
        User::create([
            'name' => 'Tiara Penumpang',
            'email' => 'penumpang@velozza.com',
            'password' => Hash::make('password123'), // Ini cara enkripsi password yang benar di Laravel
            'role' => 'passenger', // atau 'penumpang' (sesuaikan dengan enum/kolom di database kamu)
        ]);

        // Membuat akun Admin (Opsional)
        User::create([
            'name' => 'Admin Velozza',
            'email' => 'admin@velozza.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
    }
}