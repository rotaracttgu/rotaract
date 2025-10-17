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
        Schema::create('carta_formals', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_envio');
            $table->string('destinatario');
            $table->string('contacto')->nullable();
            $table->enum('tipo', ['invitacion', 'agradecimiento', 'solicitud', 'notificacion', 'felicitacion', 'comunicado']);
            $table->string('asunto');
            $table->text('contenido')->nullable();
            $table->enum('estado', ['enviada', 'borrador'])->default('borrador');
            $table->boolean('respuesta_recibida')->default(false);
            $table->date('fecha_respuesta')->nullable();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carta_formals');
    }
};
