<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // 🌟 1. WAJIB DISETTING: Beritahu Laravel kalau primary key kamu bernama id_user
    protected $primaryKey = 'id_user';

    // 🌟 2. MASUKKAN KOLOM YANG ADA DI DATABASE KAMU
    protected $fillable = [
        'email',
        'password',
        'role',
    ];

    // 🌟 3. SEMBUNYIKAN KATA SANDI SAAT PENGAMBILAN DATA
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'id_user', 'id_user');
    }
}