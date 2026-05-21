<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    // Relasi balik ke User, Penumpang, dan Jadwal
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function penumpang()
    {
        return $this->belongsTo(Penumpang::class, 'id_penumpang', 'id_penumpang');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    // Relasi ke Tiket dan Pembayaran (One-to-One)
    public function tiket()
    {
            return $this->hasOne(Tiket::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pemesanan', 'id_pemesanan');
    }
}
