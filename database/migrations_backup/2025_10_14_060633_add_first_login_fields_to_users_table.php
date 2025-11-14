<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('first_login')->default(true)->after('password');
            $table->string('username')->nullable()->unique()->after('name');
            $table->string('apellidos')->nullable()->after('name');
            $table->string('dni')->nullable()->unique()->after('email');
            $table->string('telefono')->nullable()->after('dni');
            
            // Preguntas de seguridad
            $table->string('pregunta_seguridad_1')->nullable()->after('password');
            $table->string('respuesta_seguridad_1')->nullable()->after('pregunta_seguridad_1');
            $table->string('pregunta_seguridad_2')->nullable()->after('respuesta_seguridad_1');
            $table->string('respuesta_seguridad_2')->nullable()->after('pregunta_seguridad_2');
            
            $table->timestamp('profile_completed_at')->nullable()->after('email_verified_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_login',
                'username',
                'apellidos',
                'dni',
                'telefono',
                'pregunta_seguridad_1',
                'respuesta_seguridad_1',
                'pregunta_seguridad_2',
                'respuesta_seguridad_2',
                'profile_completed_at'
            ]);
        });
    }
};