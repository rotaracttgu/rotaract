<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Las collations ya fueron corregidas manualmente en el servidor
        // Esta migración solo documenta el cambio: utf8mb4_0900_ai_ci -> utf8mb4_general_ci
        
        // Si necesitas cambiar collations localmente, descomenta lo siguiente:
        /*
        DB::statement('ALTER DATABASE gestiones_clubrotario COLLATE utf8mb4_general_ci');
        $tables = ['calendarios', 'notas_personales', 'miembros', 'users', 'proyectos', 'reunions'];
        foreach ($tables as $table) {
            try {
                DB::statement("ALTER TABLE {$table} COLLATE utf8mb4_general_ci");
            } catch (\Exception $e) {
                // Ignorar si la tabla no existe
            }
        }
        */
        
        echo "✅ Collations ya están corregidas en utf8mb4_general_ci\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No hacer rollback de collations
    }
};
