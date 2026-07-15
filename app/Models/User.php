<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 🌟 1. WAJIB DISETTING: Beritahu Laravel kalau primary key kamu bernama id_user
    protected $primaryKey = 'id_user';
    public $incrementing = true;
    public $timestamps = false;

    // 🌟 2. MASUKKAN KOLOM YANG ADA DI DATABASE KAMU
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // 🌟 3. SEMBUNYIKAN KATA SANDI SAAT PENGAMBILAN DATA
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}