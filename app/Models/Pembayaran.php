<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran'; 
    protected $primaryKey = 'id_pembayaran'; 
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_pemesanan',
        'metode_pembayaran',
        'tanggal_pembayaran',
        'bukti_pembayaran',
        'status_pembayaran', // Pastikan kolom status diizinkan masuk
    ];

    // Relasi balik ke Pemesanan
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan', 'id_pemesanan');
    }
}