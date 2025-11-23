<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 COMPARACIÓN: LOCAL vs SERVIDOR\n";
echo "==================================\n\n";

echo "📍 EN LOCAL:\n";
echo "────────────────────────────────────────────────────────\n";

// Ver SPs de asistencias en local
$spsLocal = DB::select("SHOW PROCEDURE STATUS WHERE Db = DATABASE() AND Name LIKE '%asistencia%'");

if (empty($spsLocal)) {
    echo "❌ NO HAY SPs de asistencias en local\n";
} else {
    echo "✅ SPs encontrados:\n";
    foreach ($spsLocal as $sp) {
        echo "   - {$sp->Name}\n";
    }
}

// Verificar SPs específicos
echo "\n📝 Verificando SPs específicos:\n";
$spsVerificar = [
    'sp_obtener_asistencias_evento',
    'sp_obtener_miembros_para_asistencia',
    'SP_MisReuniones',
    'SP_MisProyectos',
    'SP_MisNotas',
    'sp_registrar_asistencia'
];

foreach ($spsVerificar as $spName) {
    try {
        $def = DB::select("SHOW CREATE PROCEDURE `$spName`");
        echo "   ✅ $spName existe\n";
    } catch (\Exception $e) {
        echo "   ❌ $spName NO EXISTE\n";
    }
}

echo "\n";
