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
        Schema::table('participaciones', function (Blueprint $table) {
            $table->foreign(['MiembroID'], 'participaciones_ibfk_1')->references(['MiembroID'])->on('miembros')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['ProyectoID'], 'participaciones_ibfk_2')->references(['ProyectoID'])->on('proyectos')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participaciones', function (Blueprint $table) {
            $table->dropForeign('participaciones_ibfk_1');
            $table->dropForeign('participaciones_ibfk_2');
        });
    }
};
