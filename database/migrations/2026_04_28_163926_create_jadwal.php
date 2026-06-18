<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id('id_jadwal'); // Primary Key 
            $table->string('nama_kereta');
            $table->string('kelas');
            $table->string('asal');
            $table->string('tujuan');
            $table->dateTime('waktu_keberangkatan');
            $table->integer('harga_tiket');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};