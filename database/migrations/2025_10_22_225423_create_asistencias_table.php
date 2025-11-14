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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->integer('AsistenciaID', true);
            $table->integer('MiembroID');
            $table->integer('CalendarioID')->index('agendaid');
            $table->enum('EstadoAsistencia', ['Presente', 'Ausente', 'Justificado'])->default('Presente')->index('ix_asistencias_estado');
            $table->time('HoraLlegada')->nullable();
            $table->integer('MinutosTarde')->nullable()->default(0);
            $table->text('Observacion')->nullable();
            $table->dateTime('FechaRegistro')->useCurrent();

            $table->unique(['MiembroID', 'CalendarioID'], 'ux_asistencia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
