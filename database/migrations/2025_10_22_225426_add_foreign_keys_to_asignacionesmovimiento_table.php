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
        Schema::table('asignacionesmovimiento', function (Blueprint $table) {
            $table->foreign(['MovimientoID'], 'asignacionesmovimiento_ibfk_1')->references(['MovimientoID'])->on('movimientos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['ProyectoID'], 'asignacionesmovimiento_ibfk_2')->references(['ProyectoID'])->on('proyectos')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asignacionesmovimiento', function (Blueprint $table) {
            $table->dropForeign('asignacionesmovimiento_ibfk_1');
            $table->dropForeign('asignacionesmovimiento_ibfk_2');
        });
    }
};
