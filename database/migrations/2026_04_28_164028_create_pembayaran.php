<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran'); // Primary Key
            $table->foreignId('id_pemesanan')->constrained('pemesanan', 'id_pemesanan'); // Foreign Key
            $table->string('metode_pembayaran');
            $table->date('tanggal_pembayaran');
            $table->string('bukti_pembayaran'); // Menyimpan nama file gambar bukti transfer
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};