<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $primaryKey = 'id_tiket'; // sesuaikan dengan nama PK di tabel kamu

    protected $fillable = [
        'id_pemesanan',
        'id_jadwal',
        // kolom lain sesuaikan
    ];

    public function pemesanan() 
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan', 'id_pemesanan');
    }

    // Tambahkan relasi ke Pembayaran
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_tiket', 'id_tiket');
    }
}