<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Pemesanan extends Model
{
    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'kode_booking',
        'id_user',
        'id_jadwal',
        'total_harga',
        'status_pembayaran',
        'tanggal_pemesanan',
        'tanggal_keberangkatan',
        'metode_pembayaran',
        'email_pemesan',
        'hp_pemesan',
        'expired_at',
    ];

    protected $casts = [
        'tanggal_pemesanan' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    public function tiket()
    {
        return $this->hasMany(Tiket::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pemesanan', 'id_pemesanan');
    }
}