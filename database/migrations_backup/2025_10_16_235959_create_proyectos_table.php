<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Solo crear si NO existe (porque puede que ya exista en algunas bases de datos)
        if (!Schema::hasTable('proyectos')) {
            Schema::create('proyectos', function (Blueprint $table) {
                $table->increments('ProyectoID'); // ID autoincremental
                $table->string('Nombre', 255);
                $table->text('Descripcion')->nullable();
                $table->date('FechaInicio')->nullable();
                $table->date('FechaFin')->nullable();
                $table->string('Estatus', 50)->nullable();
                $table->string('EstadoProyecto', 50)->nullable();
                $table->decimal('Presupuesto', 12, 2)->nullable();
                $table->string('TipoProyecto', 100)->nullable();
                $table->unsignedBigInteger('ResponsableID')->nullable();
                
                // Foreign key opcional al usuario responsable
                $table->foreign('ResponsableID')->references('id')->on('users')->onDelete('set null');
                
                // Sin timestamps automáticos porque la tabla original no los tiene
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
