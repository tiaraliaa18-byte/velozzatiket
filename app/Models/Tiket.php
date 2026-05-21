<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    public function pemesanan() 
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan', 'id_pemesanan');
    }
}
