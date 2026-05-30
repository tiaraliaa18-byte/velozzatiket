<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    // Menegaskan bahwa nama tabel di database kamu adalah 'jadwal' (bukan jadwals)
    protected $table = 'jadwal'; 

    // Mengizinkan pengisian data massal (mass assignment)
    protected $guarded = []; 
}