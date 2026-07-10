<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('penumpang', function (Blueprint $table) {
            $table->string('jenis_kelamin')->nullable();
            $table->date('tgl_lahir')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penumpang', function (Blueprint $table) {
            //
        });
    }
};
