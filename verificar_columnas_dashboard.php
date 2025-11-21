<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== VERIFICANDO ESTRUCTURA DE TABLAS ===\n\n";
    
    echo "1. Tabla proyectos:\n";
    $proyectos = DB::select("DESCRIBE proyectos");
    foreach ($proyectos as $col) {
        echo "   - {$col->Field} ({$col->Type})\n";
    }
    
    echo "\n2. Tabla calendarios:\n";
    $calendarios = DB::select("DESCRIBE calendarios");
    foreach ($calendarios as $col) {
        echo "   - {$col->Field} ({$col->Type})\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
