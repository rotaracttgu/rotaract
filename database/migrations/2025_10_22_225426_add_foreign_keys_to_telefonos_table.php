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
        Schema::table('telefonos', function (Blueprint $table) {
            $table->foreign(['MiembroID'], 'telefonos_ibfk_1')->references(['MiembroID'])->on('miembros')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('telefonos', function (Blueprint $table) {
            $table->dropForeign('telefonos_ibfk_1');
        });
    }
};
