<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    // Menegaskan bahwa nama tabel di database kamu adalah 'jadwal' (bukan jadwals)
    protected $table = 'jadwal'; 

    // PENTING: Beritahu Laravel bahwa primary key tabelmu bernama 'id_jadwal'
    protected $primaryKey = 'id_jadwal';

    // Mengizinkan pengisian data massal (mass assignment) untuk semua kolom
    protected $guarded = []; 
}