<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiket', function (Blueprint $table) {
            $table->id('id_tiket'); // Primary Key
            $table->foreignId('id_pemesanan')->constrained('pemesanan', 'id_pemesanan'); // Foreign Key
            $table->string('no_kursi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiket');
    }
};