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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->integer('ProyectoID', true);
            $table->string('Nombre', 100);
            $table->text('Descripcion')->nullable();
            $table->date('FechaInicio')->nullable();
            $table->date('FechaFin')->nullable();
            $table->string('Estatus', 20)->nullable();
            $table->string('EstadoProyecto', 20)->nullable();
            $table->decimal('Presupuesto', 14)->nullable();
            $table->string('TipoProyecto', 50)->nullable();
            $table->integer('ResponsableID')->nullable()->index('responsableid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
