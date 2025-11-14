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
        Schema::table('users', function (Blueprint $table) {
            // Verificar si la columna no existe antes de agregar
            if (!Schema::hasColumn('users', 'fecha_juramentacion')) {
                $table->date('fecha_juramentacion')->nullable()->after('telefono');
            }
            
            if (!Schema::hasColumn('users', 'fecha_cumpleaños')) {
                $table->date('fecha_cumpleaños')->nullable()->after('fecha_juramentacion');
            }
            
            if (!Schema::hasColumn('users', 'activo')) {
                $table->boolean('activo')->default(true)->after('fecha_cumpleaños');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['fecha_juramentacion', 'fecha_cumpleaños', 'activo']);
        });
    }
};
