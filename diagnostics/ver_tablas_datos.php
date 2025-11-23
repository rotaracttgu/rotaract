<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "📊 VERIFICACIÓN DE DATOS EN TODAS LAS TABLAS\n";
echo "==========================================\n\n";

// Obtener todas las tablas
$tables = DB::select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE()");

foreach ($tables as $t) {
    $tableName = $t->TABLE_NAME;
    
    // Contar registros
    $count = DB::select("SELECT COUNT(*) as cnt FROM `$tableName`")[0]->cnt;
    
    if ($count > 0) {
        echo "📋 $tableName: $count registros\n";
        
        // Mostrar primeros registros
        $records = DB::select("SELECT * FROM `$tableName` LIMIT 3");
        foreach ($records as $r) {
            echo "   " . json_encode((array)$r, JSON_UNESCAPED_UNICODE) . "\n";
        }
        echo "\n";
    }
}

echo "\n✅ Verificación completada\n";
