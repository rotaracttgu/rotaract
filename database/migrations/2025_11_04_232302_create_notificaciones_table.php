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
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id'); // Usuario que recibe la notificación
            $table->string('tipo'); // 'reunion_creada', 'proyecto_creado', 'proyecto_finalizado', 'carta_pendiente', etc.
            $table->string('titulo');
            $table->text('mensaje');
            $table->string('icono')->nullable(); // Clase de icono para mostrar
            $table->string('color')->default('blue'); // Color del badge/icono
            $table->string('url')->nullable(); // URL a la que redirige al hacer clic
            $table->boolean('leida')->default(false);
            $table->timestamp('leida_en')->nullable();
            $table->unsignedBigInteger('relacionado_id')->nullable(); // ID del elemento relacionado (proyecto, reunión, etc)
            $table->string('relacionado_tipo')->nullable(); // Tipo del elemento relacionado
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['usuario_id', 'leida']);
            $table->index('tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
