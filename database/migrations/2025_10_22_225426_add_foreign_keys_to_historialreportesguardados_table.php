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
        Schema::table('historialreportesguardados', function (Blueprint $table) {
            $table->foreign(['UsuarioID'], 'fk_historialreportesguardados_users')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['ReporteGuardadoID'], 'historialreportesguardados_ibfk_1')->references(['ReporteGuardadoID'])->on('reportesguardados')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historialreportesguardados', function (Blueprint $table) {
            $table->dropForeign('fk_historialreportesguardados_users');
            $table->dropForeign('historialreportesguardados_ibfk_1');
        });
    }
};
