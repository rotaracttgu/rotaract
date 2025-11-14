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
        Schema::create('participaciones', function (Blueprint $table) {
            $table->integer('ParticipacionID', true);
            $table->integer('MiembroID');
            $table->integer('ProyectoID')->index('proyectoid');
            $table->string('Rol', 30)->nullable();
            $table->date('FechaIngreso')->nullable();
            $table->date('FechaSalida')->nullable();
            $table->string('EstadoParticipacion', 20)->nullable();

            $table->unique(['MiembroID', 'ProyectoID', 'FechaIngreso'], 'ux_participacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participaciones');
    }
};
