<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 ANÁLISIS: CONSULTAS\n";
echo "======================\n\n";

// Ver estructura tabla consultas
echo "1️⃣ COLUMNAS EN TABLA consultas:\n";
$columns = DB::select("DESCRIBE consultas");
foreach ($columns as $col) {
    echo "- {$col->Field} ({$col->Type})\n";
}

// Ver SPs de consultas
echo "\n2️⃣ SPs DE CONSULTAS:\n";
$sps = DB::select("SHOW PROCEDURE STATUS WHERE Db = DATABASE() AND Name LIKE '%consulta%'");
foreach ($sps as $sp) {
    echo "- {$sp->Name}\n";
}

// Ver definición de SP_MisConsultas
echo "\n3️⃣ DEFINICIÓN SP_MisConsultas:\n";
try {
    $def = DB::select("SHOW CREATE PROCEDURE `SP_MisConsultas`");
    echo $def[0]->{'Create Procedure'} . "\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

// Intentar llamar SP
echo "\n4️⃣ PRUEBA: Llamar SP_MisConsultas para Carlos (MiembroID 2):\n";
try {
    $result = DB::select('CALL SP_MisConsultas(?)', [2]);
    echo "✅ Éxito: " . count($result) . " consulta(s)\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n";
