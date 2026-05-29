<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id('id_pemesanan'); // Primary Key
            
            $table->foreignId('id_penumpang')->constrained('penumpang', 'id_penumpang');
            $table->foreignId('id_jadwal')->constrained('jadwal', 'id_jadwal');
            $table->foreignId('id_user')->constrained('users', 'id_user');
            
            $table->date('tanggal_pemesanan');
            $table->integer('total_harga');
            $table->string('status_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};