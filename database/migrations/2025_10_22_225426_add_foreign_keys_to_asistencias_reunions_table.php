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
        Schema::table('asistencias_reunions', function (Blueprint $table) {
            $table->foreign(['reunion_id'])->references(['id'])->on('reunions')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['usuario_id'])->references(['id'])->on('users')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asistencias_reunions', function (Blueprint $table) {
            $table->dropForeign('asistencias_reunions_reunion_id_foreign');
            $table->dropForeign('asistencias_reunions_usuario_id_foreign');
        });
    }
};
