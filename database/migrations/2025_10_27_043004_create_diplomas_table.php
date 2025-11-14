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
        Schema::create('diplomas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('miembro_id')->constrained('users')->onDelete('cascade');
            $table->enum('tipo', ['participacion', 'reconocimiento', 'merito', 'asistencia']);
            $table->string('motivo', 500);
            $table->date('fecha_emision');
            $table->string('archivo_path')->nullable();
            $table->foreignId('emitido_por')->constrained('users')->onDelete('cascade');
            $table->boolean('enviado_email')->default(false);
            $table->timestamp('fecha_envio_email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diplomas');
    }
};
