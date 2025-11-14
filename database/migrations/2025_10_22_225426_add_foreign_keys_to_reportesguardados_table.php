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
        Schema::table('reportesguardados', function (Blueprint $table) {
            $table->foreign(['UsuarioID'], 'fk_reportesguardados_users')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['ReporteID'], 'reportesguardados_ibfk_1')->references(['ReporteID'])->on('reportes')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reportesguardados', function (Blueprint $table) {
            $table->dropForeign('fk_reportesguardados_users');
            $table->dropForeign('reportesguardados_ibfk_1');
        });
    }
};
