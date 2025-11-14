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
        Schema::table('conversaciones_chat', function (Blueprint $table) {
            $table->foreign(['MensajeID'], 'fk_conv_mensaje')->references(['MensajeID'])->on('mensajes_consultas')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['RemitenteID'], 'fk_conv_remitente')->references(['MiembroID'])->on('miembros')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conversaciones_chat', function (Blueprint $table) {
            $table->dropForeign('fk_conv_mensaje');
            $table->dropForeign('fk_conv_remitente');
        });
    }
};
