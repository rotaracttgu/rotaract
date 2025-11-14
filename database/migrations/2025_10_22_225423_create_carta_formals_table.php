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
            $table->bigIncrements('id');
            $table->string('numero_carta')->unique();
            $table->string('destinatario');
            $table->string('asunto');
            $table->text('contenido');
            $table->enum('tipo', ['Invitacion', 'Agradecimiento', 'Solicitud', 'Notificacion', 'Otro'])->default('Notificacion');
            $table->enum('estado', ['Borrador', 'Enviada', 'Recibida'])->default('Borrador');
            $table->date('fecha_envio')->nullable();
            $table->unsignedBigInteger('usuario_id')->index('carta_formals_usuario_id_foreign');
            $table->text('observaciones')->nullable();
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
