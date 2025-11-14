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
        Schema::table('calendarios', function (Blueprint $table) {
            $table->foreign(['OrganizadorID'], 'fk_calendarios_organizador')->references(['MiembroID'])->on('miembros')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['ProyectoID'], 'fk_calendarios_proyecto')->references(['ProyectoID'])->on('proyectos')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calendarios', function (Blueprint $table) {
            $table->dropForeign('fk_calendarios_organizador');
            $table->dropForeign('fk_calendarios_proyecto');
        });
    }
};
