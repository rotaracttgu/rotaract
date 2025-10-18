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
        if (!Schema::hasTable('mensajes_consultas')) {
            Schema::create('mensajes_consultas', function (Blueprint $table) {
                $table->id('MensajeID');
                $table->unsignedBigInteger('MiembroID');
                $table->enum('DestinatarioTipo', ['secretaria', 'voceria', 'directiva', 'otro']);
                $table->unsignedBigInteger('DestinatarioID')->nullable();
                $table->string('TipoConsulta', 50)->nullable();
                $table->string('Asunto', 200);
                $table->text('Mensaje');
                $table->enum('Prioridad', ['baja', 'media', 'alta', 'urgente'])->default('media');
                $table->enum('Estado', ['pendiente', 'en_proceso', 'respondida', 'cerrada'])->default('pendiente');
                $table->dateTime('FechaEnvio')->useCurrent();
                $table->dateTime('FechaRespuesta')->nullable();
                $table->text('RespuestaMensaje')->nullable();
                $table->unsignedBigInteger('RespondidoPor')->nullable();
                
                $table->foreign('MiembroID')->references('MiembroID')->on('miembros')->onDelete('cascade');
                $table->foreign('RespondidoPor')->references('MiembroID')->on('miembros')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensajes_consultas');
    }
};
