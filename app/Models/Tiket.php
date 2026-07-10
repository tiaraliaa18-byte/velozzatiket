<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $table = 'tiket';
    protected $primaryKey = 'id_tiket';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_pemesanan',
        'id_penumpang',
        'no_kursi',
        'kode_tiket',
        'harga_satuan',
        'kelas_kursi',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function penumpang()
    {
        return $this->belongsTo(Penumpang::class, 'id_penumpang', 'id_penumpang');
    }
}