<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🧹 LIMPIEZA: Eliminar asistencia de prueba\n";
echo "==========================================\n\n";

// Eliminar asistencia de prueba
echo "1️⃣ Eliminando asistencia de prueba (MiembroID 2, CalendarioID 15)...\n";
try {
    DB::table('asistencias')
        ->where('MiembroID', 2)
        ->where('CalendarioID', 15)
        ->delete();
    echo "   ✅ Eliminado\n";
} catch (\Exception $e) {
    echo "   ⚠️ Error: " . $e->getMessage() . "\n";
}

// Verificar estado actual
echo "\n2️⃣ Verificando estado de asistencias:\n";
$count = DB::table('asistencias')->count();
echo "   Total asistencias: $count\n";

echo "\n3️⃣ Verificando funcionamiento de SPs:\n";

// Test sp_obtener_asistencias_evento
try {
    $result = DB::select('CALL sp_obtener_asistencias_evento(?)', [15]);
    echo "   ✅ sp_obtener_asistencias_evento: " . count($result) . " registro(s)\n";
} catch (\Exception $e) {
    echo "   ❌ sp_obtener_asistencias_evento: " . $e->getMessage() . "\n";
}

// Test sp_obtener_miembros_para_asistencia
try {
    $result = DB::select('CALL sp_obtener_miembros_para_asistencia(?)', [15]);
    echo "   ✅ sp_obtener_miembros_para_asistencia: " . count($result) . " miembro(s) sin registrar\n";
} catch (\Exception $e) {
    echo "   ❌ sp_obtener_miembros_para_asistencia: " . $e->getMessage() . "\n";
}

echo "\n";
