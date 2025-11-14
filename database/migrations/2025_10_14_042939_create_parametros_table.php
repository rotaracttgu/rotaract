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
        Schema::create('parametros', function (Blueprint $table) {
            $table->id();
            $table->string('clave')->unique()->comment('Clave única del parámetro');
            $table->string('valor')->comment('Valor del parámetro');
            $table->string('descripcion')->nullable()->comment('Descripción del parámetro');
            $table->string('tipo')->default('string')->comment('Tipo de dato: string, integer, boolean');
            $table->timestamps();
        });

        // Insertar parámetros por defecto
        DB::table('parametros')->insert([
            [
                'clave' => 'max_intentos_login',
                'valor' => '3',
                'descripcion' => 'Número máximo de intentos de login antes de bloquear la cuenta',
                'tipo' => 'integer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'clave' => 'tiempo_bloqueo_minutos',
                'valor' => '30',
                'descripcion' => 'Tiempo en minutos que la cuenta permanece bloqueada',
                'tipo' => 'integer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametros');
    }
};