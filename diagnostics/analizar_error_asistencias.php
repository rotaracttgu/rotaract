<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

echo "🔍 ANÁLISIS: ERROR AL REGISTRAR ASISTENCIAS\n";
echo "==========================================\n\n";

// 1. Ver estructura de tabla asistencias
echo "1️⃣ ESTRUCTURA DE TABLA 'asistencias':\n";
$columns = DB::select("DESCRIBE asistencias");
foreach ($columns as $col) {
    echo "   - {$col->Field} ({$col->Type}) NULL: {$col->Null}\n";
}

// 2. Ver si hay registros
echo "\n2️⃣ REGISTROS EN ASISTENCIAS:\n";
$count = DB::select("SELECT COUNT(*) as cnt FROM asistencias")[0]->cnt;
echo "   Total: {$count}\n";

if ($count > 0) {
    $registros = DB::select("SELECT * FROM asistencias LIMIT 5");
    foreach ($registros as $r) {
        echo "   " . json_encode((array)$r, JSON_UNESCAPED_UNICODE) . "\n";
    }
}

// 3. Ver calendarios disponibles
echo "\n3️⃣ EVENTOS/CALENDARIOS PARA REGISTRAR ASISTENCIA:\n";
$eventos = DB::select("SELECT CalendarioID, TituloEvento, FechaInicio, EstadoEvento FROM calendarios ORDER BY CalendarioID");
foreach ($eventos as $e) {
    echo "   CalendarioID {$e->CalendarioID}: {$e->TituloEvento} ({$e->EstadoEvento})\n";
}

// 4. Verificar si hay SPs relacionados
echo "\n4️⃣ SPs RELACIONADOS A ASISTENCIAS:\n";
$sps = DB::select("SHOW PROCEDURE STATUS WHERE Db = DATABASE() AND (Name LIKE '%asistencia%' OR Name LIKE '%Asistencia%')");
foreach ($sps as $sp) {
    echo "   - {$sp->Name}\n";
}

// 5. Ver logs del servidor
echo "\n5️⃣ ÚLTIMAS LÍNEAS DEL ARCHIVO DE LOG:\n";
$logPath = storage_path('logs/laravel.log');
if (file_exists($logPath)) {
    $lines = array_slice(file($logPath), -20);
    foreach ($lines as $line) {
        if (strpos(strtolower($line), 'asistencia') !== false || strpos(strtolower($line), 'error') !== false) {
            echo "   " . trim($line) . "\n";
        }
    }
    if (count(array_filter($lines, fn($l) => strpos(strtolower($l), 'asistencia') !== false || strpos(strtolower($l), 'error') !== false)) === 0) {
        echo "   ℹ️ No hay errores específicos de asistencias en logs recientes\n";
    }
} else {
    echo "   ❌ No se encontró archivo de log\n";
}

// 6. Intentar insertar una asistencia de prueba
echo "\n6️⃣ PRUEBA: Insertar asistencia de prueba\n";
try {
    $calendarID = 10; // El evento que existe
    $miembroID = 2;   // Carlos
    
    DB::table('asistencias')->insert([
        'CalendarioID' => $calendarID,
        'MiembroID' => $miembroID,
        'EstadoAsistencia' => 'Presente',
        'FechaRegistro' => now(),
        'HoraLlegada' => now()->format('H:i:s'),
        'MinutosTarde' => 0,
        'Observacion' => 'Prueba desde diagnóstico'
    ]);
    
    echo "   ✅ Asistencia insertada exitosamente\n";
    
    // Verificar
    $verificar = DB::select("SELECT * FROM asistencias WHERE CalendarioID = ? AND MiembroID = ?", [$calendarID, $miembroID]);
    echo "   ✅ Verificación: " . count($verificar) . " registro(s) encontrado(s)\n";
    
} catch (\Exception $e) {
    echo "   ❌ Error al insertar: " . $e->getMessage() . "\n";
}

echo "\n";
