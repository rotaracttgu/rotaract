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
        Schema::table('movimientos', function (Blueprint $table) {
            $table->foreign(['MiembroID'], 'movimientos_ibfk_1')->references(['MiembroID'])->on('miembros')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['ProyectoID'], 'movimientos_ibfk_2')->references(['ProyectoID'])->on('proyectos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['PagoID'], 'movimientos_ibfk_3')->references(['PagoID'])->on('pagosmembresia')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movimientos', function (Blueprint $table) {
            $table->dropForeign('movimientos_ibfk_1');
            $table->dropForeign('movimientos_ibfk_2');
            $table->dropForeign('movimientos_ibfk_3');
        });
    }
};
