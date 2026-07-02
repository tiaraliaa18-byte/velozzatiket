<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_pemesanan');
            $table->string('metode_pembayaran');
            $table->string('nama_rekening')->nullable();
            $table->date('tanggal_pembayaran')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status_pembayaran', ['menunggu', 'valid', 'ditolak'])
                  ->default('menunggu');
            $table->timestamps();

            $table->foreign('id_pemesanan')
                  ->references('id_pemesanan')
                  ->on('pemesanan')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};