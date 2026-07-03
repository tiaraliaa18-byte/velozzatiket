<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Kolom waktu_keberangkatan diubah dari DATETIME -> TIME,
     * karena sekarang jadwal cuma nyimpen jam (berlaku tiap hari),
     * bukan tanggal keberangkatan spesifik.
     */
    public function up(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->time('waktu_keberangkatan')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dateTime('waktu_keberangkatan')->change();
        });
    }
};