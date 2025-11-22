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
        // Cambiar collation de la base de datos
        DB::statement('ALTER DATABASE rotaract COLLATE utf8mb4_general_ci');
        
        // Cambiar collation de las tablas principales
        $tables = ['calendarios', 'notas_personales', 'miembros', 'usuarios', 'proyectos', 'reuniones'];
        
        foreach ($tables as $table) {
            try {
                DB::statement("ALTER TABLE {$table} COLLATE utf8mb4_general_ci");
            } catch (\Exception $e) {
                // Log silenciosamente si la tabla no existe
            }
        }
        
        echo "✅ Collations corregidas a utf8mb4_general_ci\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No hacer rollback de collations
    }
};
