<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Blokir eror dengan mencocokkan kolom asli di phpMyAdmin kamu
        
        // Akun Contoh untuk Admin Velozza
        DB::table('users')->insert([
            'email' => 'admin@velozza.com',
            'password' => Hash::make('password123'), 
            'role' => 'admin',
            'created_at' => now(),
        ]);

        // Akun Contoh untuk Penumpang Velozza
        DB::table('users')->insert([
            'email' => 'penumpang@velozza.com',
            'password' => Hash::make('password123'),
            'role' => 'passenger', // ganti 'penumpang' jika di database menggunakan bahasa Indonesia
            'created_at' => now(),
        ]);
    }
}