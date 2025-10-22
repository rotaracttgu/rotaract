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
        if (!Schema::hasTable('asistencias')) {
            Schema::create('asistencias', function (Blueprint $table) {
                $table->id('AsistenciaID');
                $table->unsignedBigInteger('MiembroID');
                $table->unsignedBigInteger('CalendarioID');
                $table->enum('EstadoAsistencia', ['Presente', 'Ausente', 'Justificado'])->default('Presente');
                $table->time('HoraLlegada')->nullable();
                $table->integer('MinutosTarde')->default(0);
                $table->text('Observacion')->nullable();
                $table->dateTime('FechaRegistro')->useCurrent();
                
                $table->foreign('MiembroID')->references('MiembroID')->on('miembros')->onDelete('cascade');
                $table->foreign('CalendarioID')->references('CalendarioID')->on('calendarios')->onDelete('cascade');
                
                $table->index('MiembroID');
                $table->index('CalendarioID');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
