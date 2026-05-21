<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penumpang extends Model
{
    public function pemesanan()
    {
        return $this->hasOne(Pemesanan::class, 'id_penumpang', 'id_penumpang');
    }
}
