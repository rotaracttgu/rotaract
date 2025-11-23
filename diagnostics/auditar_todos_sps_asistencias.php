<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 AUDITORÍA: Verificar todos los SPs relacionados a asistencias\n";
echo "===============================================================\n\n";

// Obtener todos los SPs
$sps = DB::select("SHOW PROCEDURE STATUS WHERE Db = DATABASE() AND Name LIKE '%asistencia%'");

foreach ($sps as $sp) {
    echo "📋 SP: {$sp->Name}\n";
    echo "   ────────────────────────────────────────────────────\n";
    
    // Obtener definición
    try {
        $def = DB::select("SHOW CREATE PROCEDURE `{$sp->Name}`");
        $codigo = $def[0]->{'Create Procedure'};
        
        // Buscar problemas comunes
        $problemas = [];
        
        if (strpos($codigo, 'a.Presente') !== false) {
            $problemas[] = "❌ Usa 'a.Presente' (debe ser 'EstadoAsistencia')";
        }
        if (strpos($codigo, 'a.Observaciones') !== false) {
            $problemas[] = "❌ Usa 'a.Observaciones' (debe ser 'Observacion')";
        }
        if (strpos($codigo, 'a.EventoID') !== false) {
            $problemas[] = "❌ Usa 'a.EventoID' (debe ser 'CalendarioID')";
        }
        if (strpos($codigo, 'm.DNI') !== false) {
            $problemas[] = "❌ Usa 'm.DNI' (debe ser 'u.dni')";
        }
        
        if (empty($problemas)) {
            echo "   ✅ Sin problemas detectados\n";
        } else {
            foreach ($problemas as $p) {
                echo "   $p\n";
            }
        }
        
    } catch (\Exception $e) {
        echo "   ⚠️ Error al obtener definición: " . $e->getMessage() . "\n";
    }
    echo "\n";
}

echo "\n";
