<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class BuatPenumpang extends Command
{
    protected $signature = 'buat:penumpang';
    protected $description = 'Buat akun penumpang default';

    public function handle()
    {
        $email = 'penumpang' . chr(64) . 'velozza.com';

        $existing = User::where('email', $email)->first();
        if ($existing) {
            $this->info('User sudah ada.');
            return;
        }

        User::create([
            'name' => 'Penumpang Velozza',
            'email' => $email,
            'password' => bcrypt('penumpang123'),
            'role' => 'user',
        ]);

        $this->info('User penumpang berhasil dibuat.');
    }
}