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
        Schema::table('mensajes_consultas', function (Blueprint $table) {
            $table->foreign(['MiembroID'], 'fk_mensaje_miembro')->references(['MiembroID'])->on('miembros')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['RespondidoPor'], 'fk_mensaje_respondido')->references(['MiembroID'])->on('miembros')->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mensajes_consultas', function (Blueprint $table) {
            $table->dropForeign('fk_mensaje_miembro');
            $table->dropForeign('fk_mensaje_respondido');
        });
    }
};
