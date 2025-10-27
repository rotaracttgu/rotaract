<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Crear tabla que COMPLEMENTA la tabla 'asistencias' existente
        // Esta es específica para las reuniones del módulo Vicepresidente
        if (!Schema::hasTable('asistencias_reunions')) {
            Schema::create('asistencias_reunions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('reunion_id')->constrained('reunions')->onDelete('cascade');
                $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
                $table->boolean('asistio')->default(false);
                $table->time('hora_llegada')->nullable();
                $table->enum('tipo_asistencia', ['Presente', 'Ausente', 'Justificada', 'Tardanza'])->default('Ausente');
                $table->text('observaciones')->nullable();
                $table->timestamps();
                
                // Evitar duplicados
                $table->unique(['reunion_id', 'usuario_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias_reunions');
    }
};
