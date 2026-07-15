<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user'); // Primary Key
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role'); // Bisa diisi admin atau user
            $table->timestamps(); // otomatis bikin created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};