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
        if (!Schema::hasTable('calendarios')) {
            Schema::create('calendarios', function (Blueprint $table) {
                $table->id('CalendarioID');
                $table->string('TituloEvento', 100);
                $table->text('Descripcion')->nullable();
                $table->enum('TipoEvento', ['Virtual', 'Presencial', 'InicioProyecto', 'FinProyecto']);
                $table->enum('EstadoEvento', ['Programado', 'EnCurso', 'Finalizado'])->default('Programado');
                $table->dateTime('FechaInicio');
                $table->dateTime('FechaFin')->nullable();
                $table->time('HoraInicio');
                $table->time('HoraFin')->nullable();
                $table->string('Ubicacion', 200)->nullable();
                $table->unsignedBigInteger('OrganizadorID')->nullable();
                $table->unsignedBigInteger('ProyectoID')->nullable();
                
                $table->foreign('OrganizadorID')->references('MiembroID')->on('miembros')->onDelete('set null');
                $table->foreign('ProyectoID')->references('ProyectoID')->on('proyectos')->onDelete('set null');
                
                $table->index('OrganizadorID');
                $table->index('ProyectoID');
                $table->index('FechaInicio');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendarios');
    }
};
