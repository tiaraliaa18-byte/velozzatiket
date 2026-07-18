<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tiket', function (Blueprint $table) {
            $table->string('kode_tiket')->nullable()->after('no_kursi');
            $table->integer('harga_satuan')->nullable()->after('kode_tiket');
            $table->string('kelas_kursi')->nullable()->after('harga_satuan');
        });
    }

    public function down(): void
    {
        Schema::table('tiket', function (Blueprint $table) {
            $table->dropColumn(['kode_tiket', 'harga_satuan', 'kelas_kursi']);
        });
    }
};