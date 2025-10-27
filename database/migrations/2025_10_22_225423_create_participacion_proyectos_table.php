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
        Schema::create('participacion_proyectos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('proyecto_id');
            $table->unsignedBigInteger('usuario_id');
            $table->enum('rol', ['Coordinador', 'Colaborador', 'Voluntario', 'Apoyo'])->default('Colaborador');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->integer('horas_dedicadas')->default(0);
            $table->text('tareas_asignadas')->nullable();
            $table->enum('estado_participacion', ['Activo', 'Finalizado', 'Suspendido'])->default('Activo');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participacion_proyectos');
    }
};
