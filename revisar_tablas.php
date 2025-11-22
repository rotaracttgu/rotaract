<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "📋 ESTRUCTURA DE TABLAS\n";
echo "=======================\n\n";

// 1. Estructura calendarios
echo "1️⃣ TABLA calendarios:\n";
$columns = DB::select("DESCRIBE calendarios");
foreach ($columns as $col) {
    echo sprintf("   %-20s | %-20s | Null:%s\n", $col->Field, $col->Type, $col->Null);
}

echo "\n2️⃣ TABLA notas_personales:\n";
$columns = DB::select("DESCRIBE notas_personales");
foreach ($columns as $col) {
    echo sprintf("   %-20s | %-20s | Null:%s\n", $col->Field, $col->Type, $col->Null);
}

echo "\n3️⃣ COLLATION ISSUES:\n";
// Ver collations
$dbCollation = DB::select("SELECT DEFAULT_COLLATION_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'rotaract'");
echo "   Base de datos: " . ($dbCollation[0]->DEFAULT_COLLATION_NAME ?? 'N/A') . "\n";

$calendarioCollation = DB::select("SELECT COLLATION_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'calendarios' AND TABLE_SCHEMA = 'rotaract'");
echo "   Tabla calendarios: " . ($calendarioCollation[0]->COLLATION_NAME ?? 'N/A') . "\n";

$notasCollation = DB::select("SELECT COLLATION_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'notas_personales' AND TABLE_SCHEMA = 'rotaract'");
echo "   Tabla notas_personales: " . ($notasCollation[0]->COLLATION_NAME ?? 'N/A') . "\n";
