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
        if (!Schema::hasTable('conversaciones_chat')) {
            Schema::create('conversaciones_chat', function (Blueprint $table) {
                $table->id('ConversacionID');
                $table->unsignedBigInteger('MensajeID');
                $table->unsignedBigInteger('RemitenteID');
                $table->boolean('EsRespuesta')->default(false);
                $table->text('TextoMensaje');
                $table->dateTime('FechaEnvio')->useCurrent();
                $table->boolean('Leido')->default(false);
                $table->dateTime('FechaLectura')->nullable();
                
                $table->foreign('MensajeID')->references('MensajeID')->on('mensajes_consultas')->onDelete('cascade');
                $table->foreign('RemitenteID')->references('MiembroID')->on('miembros')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversaciones_chat');
    }
};
