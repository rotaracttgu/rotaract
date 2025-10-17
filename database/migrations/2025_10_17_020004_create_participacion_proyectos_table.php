<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Solo crear si NO existe
        if (!Schema::hasTable('participacion_proyectos')) {
            Schema::create('participacion_proyectos', function (Blueprint $table) {
                $table->id();
                // Se vincula a la tabla 'proyectos' EXISTENTE usando 'ProyectoID'
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
                
                // Indices
                $table->index('proyecto_id');
                $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
                
                // Evitar duplicados
                $table->unique(['proyecto_id', 'usuario_id', 'fecha_inicio'], 'participacion_unique');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('participacion_proyectos');
    }
};
