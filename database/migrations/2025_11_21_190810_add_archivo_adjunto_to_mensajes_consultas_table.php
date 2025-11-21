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
        Schema::table('mensajes_consultas', function (Blueprint $table) {
            $table->string('ArchivoAdjunto', 500)->nullable()->after('Mensaje');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mensajes_consultas', function (Blueprint $table) {
            $table->dropColumn('ArchivoAdjunto');
        });
    }
};
