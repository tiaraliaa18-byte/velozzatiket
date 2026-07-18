<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class BuatAdmin extends Command
{
    protected $signature = 'buat:admin';
    protected $description = 'Buat akun admin default';

    public function handle()
    {
        $email = 'admin' . chr(64) . 'velozza.com';

        $existing = User::where('email', $email)->first();
        if ($existing) {
            $this->info('User sudah ada.');
            return;
        }

        User::create([
            'name' => 'Admin Velozza',
            'email' => $email,
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        $this->info('User admin berhasil dibuat.');
    }
}