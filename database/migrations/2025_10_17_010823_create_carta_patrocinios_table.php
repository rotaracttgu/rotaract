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
        Schema::create('carta_patrocinios', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_envio');
            $table->string('destinatario');
            $table->string('contacto')->nullable();
            $table->unsignedBigInteger('proyecto_id')->nullable();
            $table->decimal('monto_solicitado', 10, 2);
            $table->enum('estado', ['enviada', 'respondida', 'pendiente', 'sin_respuesta'])->default('pendiente');
            $table->date('fecha_respuesta')->nullable();
            $table->text('contenido')->nullable();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carta_patrocinios');
    }
};
