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
        Schema::create('mensajes_consultas', function (Blueprint $table) {
            $table->integer('MensajeID', true);
            $table->integer('MiembroID')->index('fk_mensaje_miembro');
            $table->enum('DestinatarioTipo', ['secretaria', 'voceria', 'directiva', 'otro'])->index('ix_mensaje_tipo_destinatario');
            $table->integer('DestinatarioID')->nullable();
            $table->string('TipoConsulta', 50)->nullable();
            $table->string('Asunto', 200);
            $table->text('Mensaje');
            $table->enum('Prioridad', ['baja', 'media', 'alta', 'urgente'])->default('media');
            $table->enum('Estado', ['pendiente', 'en_proceso', 'respondida', 'cerrada'])->default('pendiente')->index('ix_mensaje_estado');
            $table->dateTime('FechaEnvio')->useCurrent()->index('ix_mensajes_fecha');
            $table->dateTime('FechaRespuesta')->nullable();
            $table->text('RespuestaMensaje')->nullable();
            $table->integer('RespondidoPor')->nullable()->index('fk_mensaje_respondido');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensajes_consultas');
    }
};
