<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 VERIFICAR SP_RegistrarAsistencia\n";
echo "====================================\n\n";

// Obtener definición del SP
$sp = DB::select("SHOW CREATE PROCEDURE `sp_registrar_asistencia`");

if ($sp) {
    echo $sp[0]->{'Create Procedure'} . "\n\n";
} else {
    echo "❌ SP no encontrado\n";
}

// Intentar llamarlo
echo "\n\n📞 PRUEBA DE EJECUCIÓN:\n";
try {
    $result = DB::select('CALL sp_registrar_asistencia(2, 10, ?, ?, ?, ?, @asistencia_id, @mensaje)', [
        'Presente',
        '19:30:00',
        0,
        'Prueba de diagnóstico'
    ]);
    
    echo "✅ SP ejecutado\n";
    
    $output = DB::select('SELECT @asistencia_id as asistencia_id, @mensaje as mensaje');
    echo "Resultado:\n";
    echo "  ID: " . ($output[0]->asistencia_id ?? 'NULL') . "\n";
    echo "  Mensaje: " . ($output[0]->mensaje ?? 'NULL') . "\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
