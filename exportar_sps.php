<?php
/**
 * Exportar definiciones de SPs para comparar
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$procedures = [
    'SP_MisConsultas',
    'SP_EventosDelDia',
    'SP_RecordatoriosProximos',
    'SP_MisProyectos',
    'SP_MisReuniones',
    'SP_MisNotas'
];

echo "📋 DEFINICIONES DE STORED PROCEDURES\n";
echo "====================================\n\n";

foreach ($procedures as $sp) {
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "SP: $sp\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    
    try {
        $result = DB::selectOne("SELECT ROUTINE_DEFINITION FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_NAME = ? AND ROUTINE_SCHEMA = DATABASE()", [$sp]);
        
        if ($result) {
            echo $result->ROUTINE_DEFINITION . "\n\n";
        } else {
            echo "❌ NO ENCONTRADO\n\n";
        }
    } catch (\Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n\n";
    }
}
