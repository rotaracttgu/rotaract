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
        // Este archivo contiene las definiciones corregidas de los SPs
        // Leer y ejecutar el contenido del archivo SQL
        $sqlFile = database_path('migrations/fix_sps.sql');
        
        if (file_exists($sqlFile)) {
            $sql = file_get_contents($sqlFile);
            
            // Dividir por DELIMITER ;; (que es la forma que usa el archivo)
            $statements = array_filter(explode('DELIMITER ;', $sql));
            
            foreach ($statements as $statement) {
                $statement = trim($statement);
                if (!empty($statement)) {
                    try {
                        DB::statement($statement);
                        echo "✅ SP actualizado\n";
                    } catch (\Exception $e) {
                        echo "⚠️  Error: " . $e->getMessage() . "\n";
                    }
                }
            }
        }
        
        echo "✅ Stored Procedures corregidos\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No hacer rollback de SPs
    }
};
