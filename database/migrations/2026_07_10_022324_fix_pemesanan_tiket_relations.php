<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom kontak pemesan di tabel pemesanan
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->string('email_pemesan')->nullable()->after('id_user');
            $table->string('hp_pemesan')->nullable()->after('email_pemesan');
        });

        // Hapus id_penumpang dari pemesanan (gak dipakai lagi, karena tiap tiket sekarang punya penumpang sendiri-sendiri)
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropForeign(['id_penumpang']);
            $table->dropColumn('id_penumpang');
        });

        // Tambah id_penumpang di tabel tiket (biar tiap kursi/tiket tau ini punya siapa)
        Schema::table('tiket', function (Blueprint $table) {
            $table->unsignedBigInteger('id_penumpang')->nullable()->after('id_pemesanan');
            $table->foreign('id_penumpang')->references('id_penumpang')->on('penumpang')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('tiket', function (Blueprint $table) {
            $table->dropForeign(['id_penumpang']);
            $table->dropColumn('id_penumpang');
        });

        Schema::table('pemesanan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_penumpang')->nullable();
            $table->foreign('id_penumpang')->references('id_penumpang')->on('penumpang');
            $table->dropColumn(['email_pemesan', 'hp_pemesan']);
        });
    }
};