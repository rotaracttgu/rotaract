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
        Schema::table('historialreportes', function (Blueprint $table) {
            $table->foreign(['UsuarioID'], 'fk_historialreportes_users')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['ReporteID'], 'historialreportes_ibfk_1')->references(['ReporteID'])->on('reportes')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historialreportes', function (Blueprint $table) {
            $table->dropForeign('fk_historialreportes_users');
            $table->dropForeign('historialreportes_ibfk_1');
        });
    }
};
