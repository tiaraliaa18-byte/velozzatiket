<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            if (!Schema::hasColumn('pemesanan', 'metode_pembayaran')) {
                $table->string('metode_pembayaran')->nullable();
            }
            if (!Schema::hasColumn('pemesanan', 'expired_at')) {
                $table->dateTime('expired_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'expired_at']);
        });
    }
};