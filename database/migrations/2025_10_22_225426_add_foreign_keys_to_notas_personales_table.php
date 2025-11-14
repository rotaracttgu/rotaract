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
        Schema::table('notas_personales', function (Blueprint $table) {
            $table->foreign(['MiembroID'], 'fk_notas_miembro')->references(['MiembroID'])->on('miembros')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notas_personales', function (Blueprint $table) {
            $table->dropForeign('fk_notas_miembro');
        });
    }
};
