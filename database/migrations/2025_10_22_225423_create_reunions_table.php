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
        Schema::create('reunions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->dateTime('fecha_hora');
            $table->string('lugar')->nullable();
            $table->enum('tipo', ['Ordinaria', 'Extraordinaria', 'Junta Directiva', 'Comite'])->default('Ordinaria');
            $table->enum('estado', ['Programada', 'En Curso', 'Finalizada', 'Cancelada'])->default('Programada');
            $table->integer('asistentes_esperados')->default(0);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reunions');
    }
};
