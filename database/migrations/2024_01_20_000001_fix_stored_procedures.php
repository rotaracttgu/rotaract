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
        // Leer y ejecutar el archivo SQL con las correcciones de SPs
        $sqlFile = database_path('migrations/fix_sps.sql');
        
        if (file_exists($sqlFile)) {
            $sql = file_get_contents($sqlFile);
            
            // Dividir por DELIMITER y ejecutar cada procedimiento
            $parts = array_filter(array_map('trim', explode('DELIMITER ;', $sql)));
            
            foreach ($parts as $part) {
                if (!empty($part) && strpos($part, '--') !== 0) {
                    try {
                        // Limpiar la parte del DELIMITER inicial si existe
                        $part = preg_replace('/^DELIMITER\s+\$\$\s*/i', '', $part);
                        $part = preg_replace('/\$\$\s*DELIMITER\s+;\s*$/i', '', $part);
                        
                        if (!empty($part)) {
                            DB::statement($part);
                        }
                    } catch (\Exception $e) {
                        \Log::warning("SP Migration Warning: " . $e->getMessage());
                    }
                }
            }
            
            echo "✅ Stored Procedures actualizados\n";
        } else {
            echo "⚠️  Archivo fix_sps.sql no encontrado\n";
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No hacer rollback de SPs
    }
};
