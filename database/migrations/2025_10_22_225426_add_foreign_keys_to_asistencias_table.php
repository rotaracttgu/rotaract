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
        Schema::table('asistencias', function (Blueprint $table) {
            $table->foreign(['MiembroID'], 'asistencias_ibfk_1')->references(['MiembroID'])->on('miembros')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['CalendarioID'], 'fk_asistencias_calendario')->references(['CalendarioID'])->on('calendarios')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asistencias', function (Blueprint $table) {
            $table->dropForeign('asistencias_ibfk_1');
            $table->dropForeign('fk_asistencias_calendario');
        });
    }
};
