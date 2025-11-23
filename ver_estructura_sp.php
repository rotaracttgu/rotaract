<?php
/**
 * Ver exactamente qué retornan los SPs
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 ESTRUCTURA DE DATOS RETORNADOS POR SPs\n";
echo "=========================================\n\n";

echo "1. SP_MisNotas(10, 1, 1, 0, 0, 0):\n";
$notas = DB::select('CALL SP_MisNotas(10, 1, 1, 0, 0, 0)');
if (count($notas) > 0) {
    echo json_encode($notas[0], JSON_PRETTY_PRINT) . "\n";
} else {
    echo "  (sin resultados)\n";
}

echo "\n2. SP_MisProyectos(24, NULL, NULL, ''):\n";
$proyectos = DB::select('CALL SP_MisProyectos(24, NULL, NULL, "")');
if (count($proyectos) > 0) {
    echo json_encode($proyectos[0], JSON_PRETTY_PRINT) . "\n";
} else {
    echo "  (sin resultados)\n";
}

echo "\n3. SP_MisConsultas(24, NULL, NULL, 100):\n";
$consultas = DB::select('CALL SP_MisConsultas(24, NULL, NULL, 100)');
if (count($consultas) > 0) {
    echo json_encode($consultas[0], JSON_PRETTY_PRINT) . "\n";
} else {
    echo "  (sin resultados)\n";
}

echo "\n";
