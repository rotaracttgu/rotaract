<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 VERIFICAR SP_ObtenerAsistenciasEvento (para cargar el formulario)\n";
echo "====================================================================\n\n";

// Obtener definición del SP
$sp = DB::select("SHOW CREATE PROCEDURE `sp_obtener_asistencias_evento`");

if ($sp) {
    echo $sp[0]->{'Create Procedure'} . "\n\n";
} else {
    echo "❌ SP no encontrado\n";
}

// Intentar llamarlo con evento 15
echo "\n\n📞 PRUEBA: Obtener asistencias evento 15 (Proyecto de Prueba):\n";
try {
    $result = DB::select('CALL sp_obtener_asistencias_evento(?)', [15]);
    
    echo "✅ SP ejecutado, resultados:\n";
    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

// Intentar con evento 10
echo "\n\n📞 PRUEBA: Obtener asistencias evento 10 (Reunion):\n";
try {
    $result = DB::select('CALL sp_obtener_asistencias_evento(?)', [10]);
    
    echo "✅ SP ejecutado, resultados:\n";
    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
