<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penumpang', function (Blueprint $table) {
            $table->id('id_penumpang'); // Primary Key 
            $table->string('nama_lengkap');
            $table->string('nik_ktp');
            $table->string('no_telfon');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penumpang');
    }
};