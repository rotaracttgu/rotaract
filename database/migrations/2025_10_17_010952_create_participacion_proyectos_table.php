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
            $table->id();
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->enum('nivel_involucramiento', ['alto', 'medio', 'bajo'])->default('medio');
            $table->integer('actividades_realizadas')->default(0);
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            // Índice único para evitar duplicados
            $table->unique(['proyecto_id', 'usuario_id']);
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
