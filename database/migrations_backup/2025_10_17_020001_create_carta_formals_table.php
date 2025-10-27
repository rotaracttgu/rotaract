<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Solo crear si NO existe
        if (!Schema::hasTable('carta_formals')) {
            Schema::create('carta_formals', function (Blueprint $table) {
                $table->id();
                $table->string('numero_carta')->unique();
                $table->string('destinatario');
                $table->string('asunto');
                $table->text('contenido');
                $table->enum('tipo', ['Invitacion', 'Agradecimiento', 'Solicitud', 'Notificacion', 'Otro'])->default('Notificacion');
                $table->enum('estado', ['Borrador', 'Enviada', 'Recibida'])->default('Borrador');
                $table->date('fecha_envio')->nullable();
                $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
                $table->text('observaciones')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('carta_formals');
    }
};
