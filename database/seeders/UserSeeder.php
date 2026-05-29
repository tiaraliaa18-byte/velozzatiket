<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        //Akun Contoh untuk Admin Velozza
        DB::table('users')->insert([
            'email' => 'admin@velozza.com',
            'password' => Hash::make('password123'), // Password disamarkan demi keamanan
            'role' => 'admin',
            'created_at' => now(),
        ]);

        //Akun Contoh untuk Penumpang Velozza
        DB::table('users')->insert([
            'email' => 'penumpang@velozza.com',
            'password' => Hash::make('password123'),
            'role' => 'passenger', // atau 'penumpang' sesuaikan dengan migrasi Anda
            'created_at' => now(),
        ]);
    }
}