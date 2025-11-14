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
        if (!Schema::hasTable('participaciones')) {
            Schema::create('participaciones', function (Blueprint $table) {
                $table->id('ParticipacionID');
                $table->unsignedBigInteger('MiembroID');
                $table->unsignedInteger('ProyectoID');
                $table->string('Rol', 100)->nullable();
                $table->date('FechaIngreso');
                $table->date('FechaSalida')->nullable();
                $table->string('EstadoParticipacion', 20)->nullable();
                
                $table->foreign('MiembroID')->references('MiembroID')->on('miembros')->onDelete('cascade');
                $table->foreign('ProyectoID')->references('ProyectoID')->on('proyectos')->onDelete('cascade');
                
                $table->index(['MiembroID', 'ProyectoID']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participaciones');
    }
};
