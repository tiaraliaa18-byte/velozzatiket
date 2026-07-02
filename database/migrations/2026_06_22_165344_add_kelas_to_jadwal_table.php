<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('jadwal', 'kelas')) {
            Schema::table('jadwal', function (Blueprint $table) {
                // Menambahkan kolom kelas setelah nama_kereta
                $table->string('kelas')->after('nama_kereta')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('jadwal', 'kelas')) {
            Schema::table('jadwal', function (Blueprint $table) {
                // Menghapus kembali kolom kelas jika migrasi di-rollback
                $table->dropColumn('kelas');
            });
        }
    }
};