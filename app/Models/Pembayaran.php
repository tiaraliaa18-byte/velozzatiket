<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran'; // tambahkan ini
    protected $primaryKey = 'id_pembayaran'; // tambahkan ini

    protected $fillable = [
        'id_pemesanan',
        'metode_pembayaran',
        'tanggal_pembayaran',
        'bukti_pembayaran',
        'bank_asal',
        'nama_rekening',
        'status_pembayaran',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan', 'id_pemesanan');
    }
}