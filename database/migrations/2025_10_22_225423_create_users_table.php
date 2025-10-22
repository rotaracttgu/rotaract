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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('apellidos')->nullable();
            $table->string('username')->nullable()->unique();
            $table->string('email')->unique();
            $table->string('dni')->nullable()->unique();
            $table->string('telefono')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('profile_completed_at')->nullable();
            $table->string('password');
            $table->string('pregunta_seguridad_1')->nullable();
            $table->string('respuesta_seguridad_1')->nullable();
            $table->string('pregunta_seguridad_2')->nullable();
            $table->string('respuesta_seguridad_2')->nullable();
            $table->boolean('first_login')->default(true);
            $table->integer('failed_login_attempts')->default(0);
            $table->timestamp('locked_until')->nullable();
            $table->boolean('is_locked')->default(false);
            $table->boolean('two_factor_enabled')->default(false);
            $table->string('two_factor_code')->nullable();
            $table->timestamp('two_factor_expires_at')->nullable();
            $table->timestamp('two_factor_verified_at')->nullable();
            $table->text('two_factor_secret')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
