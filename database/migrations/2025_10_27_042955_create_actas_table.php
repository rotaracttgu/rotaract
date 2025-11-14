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
        Schema::create('actas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->date('fecha_reunion');
            $table->enum('tipo_reunion', ['ordinaria', 'extraordinaria', 'junta', 'asamblea']);
            $table->text('contenido');
            $table->text('asistentes')->nullable();
            $table->string('archivo_path')->nullable();
            $table->foreignId('creado_por')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actas');
    }
};
