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
        Schema::create('calendarios', function (Blueprint $table) {
            $table->integer('CalendarioID', true);
            $table->string('TituloEvento', 100);
            $table->text('Descripcion')->nullable();
            $table->enum('TipoEvento', ['Virtual', 'Presencial', 'InicioProyecto', 'FinProyecto'])->index('ix_calendarios_tipo');
            $table->enum('EstadoEvento', ['Programado', 'EnCurso', 'Finalizado'])->default('Programado')->index('ix_calendarios_estado');
            $table->dateTime('FechaInicio')->index('ix_calendarios_fecha');
            $table->dateTime('FechaFin')->nullable();
            $table->time('HoraInicio');
            $table->time('HoraFin')->nullable();
            $table->string('Ubicacion', 200)->nullable();
            $table->integer('OrganizadorID')->nullable()->index('fk_calendarios_organizador');
            $table->integer('ProyectoID')->nullable()->index('fk_calendarios_proyecto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendarios');
    }
};
