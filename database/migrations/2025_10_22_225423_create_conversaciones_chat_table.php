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
        Schema::create('conversaciones_chat', function (Blueprint $table) {
            $table->integer('ConversacionID', true);
            $table->integer('MensajeID')->index('fk_conv_mensaje');
            $table->integer('RemitenteID')->index('fk_conv_remitente');
            $table->boolean('EsRespuesta')->default(false);
            $table->text('TextoMensaje');
            $table->dateTime('FechaEnvio')->useCurrent()->index('ix_conversaciones_fecha');
            $table->boolean('Leido')->default(false)->index('ix_conv_leido');
            $table->dateTime('FechaLectura')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversaciones_chat');
    }
};
