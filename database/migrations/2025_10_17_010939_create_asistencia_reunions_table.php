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
        Schema::create('asistencia_reunions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reunion_id')->constrained('reunions')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->boolean('asistio')->default(false);
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            // Índice único para evitar duplicados
            $table->unique(['reunion_id', 'usuario_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencia_reunions');
    }
};
