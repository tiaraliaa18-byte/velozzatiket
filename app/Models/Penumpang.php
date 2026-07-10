<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penumpang extends Model
{
    protected $table = 'penumpang';
    protected $primaryKey = 'id_penumpang';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'nama_lengkap',
        'nik_ktp',
        'no_telfon',
        'jenis_kelamin',
        'tgl_lahir',
    ];

    public function tiket()
    {
        return $this->hasMany(Tiket::class, 'id_penumpang', 'id_penumpang');
    }
}