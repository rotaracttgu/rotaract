<?php
/**
 * Diagnóstico de Collations - Comparar Local vs Servidor
 */

// Incluir configuración de Laravel
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 DIAGNÓSTICO DE COLLATIONS Y SCHEMA\n";
echo "=====================================\n\n";

// 1. Obtener collation de BD
echo "1️⃣ DATABASE COLLATION:\n";
try {
    $dbCollation = DB::selectOne("SELECT @@collation_database as collation");
    echo "   Database Collation: " . $dbCollation->collation . "\n";
} catch (\Exception $e) {
    echo "   Error: " . $e->getMessage() . "\n";
}

echo "\n2️⃣ TABLE COLLATIONS:\n";
$tables = ['calendarios', 'notas_personales', 'usuarios', 'miembros'];
foreach ($tables as $table) {
    try {
        $result = DB::selectOne("
            SELECT TABLE_COLLATION 
            FROM INFORMATION_SCHEMA.TABLES 
            WHERE TABLE_NAME = ? AND TABLE_SCHEMA = DATABASE()
        ", [$table]);
        
        if ($result) {
            echo "   $table: " . $result->TABLE_COLLATION . "\n";
        } else {
            echo "   $table: NOT FOUND\n";
        }
    } catch (\Exception $e) {
        echo "   $table: Error - " . $e->getMessage() . "\n";
    }
}

echo "\n3️⃣ COLUMNS IN CALENDARIOS:\n";
try {
    $columns = DB::select("
        SELECT COLUMN_NAME, COLUMN_TYPE, COLLATION_NAME 
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = 'calendarios' AND TABLE_SCHEMA = DATABASE()
        ORDER BY ORDINAL_POSITION
    ");
    
    foreach ($columns as $col) {
        echo "   {$col->COLUMN_NAME}: {$col->COLUMN_TYPE} (Collation: {$col->COLLATION_NAME})\n";
    }
} catch (\Exception $e) {
    echo "   Error: " . $e->getMessage() . "\n";
}

echo "\n4️⃣ STORED PROCEDURES:\n";
try {
    $sps = DB::select("
        SELECT ROUTINE_NAME 
        FROM INFORMATION_SCHEMA.ROUTINES 
        WHERE ROUTINE_SCHEMA = DATABASE() 
        ORDER BY ROUTINE_NAME
    ");
    
    foreach ($sps as $sp) {
        echo "   ✓ " . $sp->ROUTINE_NAME . "\n";
    }
} catch (\Exception $e) {
    echo "   Error: " . $e->getMessage() . "\n";
}

echo "\n5️⃣ TEST: CALL SP_MisNotas\n";
try {
    $result = DB::select("CALL SP_MisNotas(?, ?)", [14, 1]);
    echo "   ✅ SP_MisNotas executed successfully! Records: " . count($result) . "\n";
} catch (\Exception $e) {
    echo "   ❌ SP_MisNotas ERROR: " . $e->getMessage() . "\n";
}

echo "\n";
