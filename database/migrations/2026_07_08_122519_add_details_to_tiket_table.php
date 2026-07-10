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
        Schema::table('tiket', function (Blueprint $table) {
            $table->string('jenis_kelamin', 20)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('no_hp', 20)->nullable();
        });
    }

    public function down()
    {
        Schema::table('tiket', function (Blueprint $table) {
            $table->dropColumn(['jenis_kelamin', 'tgl_lahir', 'no_hp']);
        });
    }
};
