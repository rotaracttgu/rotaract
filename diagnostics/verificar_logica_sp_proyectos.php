<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 VERIFICAR LÓGICA DE SP_MisProyectos\n";
echo "======================================\n\n";

// Ver SP completo
$def = DB::select("SHOW CREATE PROCEDURE `SP_MisProyectos`");
$sp = $def[0]->{'Create Procedure'};

// Buscar la parte WHERE principal
if (preg_match('/WHERE\s+\((.*?)\)\s+AND/is', $sp, $matches)) {
    echo "Condición WHERE del SP:\n";
    echo $matches[1] . "\n\n";
}

// Intentar llamar SP_MisProyectos con los 4 parámetros correctos
echo "📞 PRUEBA: SP_MisProyectos(2, NULL, NULL, '')\n";
try {
    $result = DB::select('CALL SP_MisProyectos(?, NULL, NULL, "")', [2]);
    echo "Resultados: " . count($result) . " proyectos\n";
    foreach ($result as $p) {
        echo "  - {$p->NombreProyecto}\n";
    }
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

// Intentar con estado Activo
echo "\n📞 PRUEBA: SP_MisProyectos(2, 'Activo', NULL, '')\n";
try {
    $result = DB::select('CALL SP_MisProyectos(?, "Activo", NULL, "")', [2]);
    echo "Resultados: " . count($result) . " proyectos\n";
    foreach ($result as $p) {
        echo "  - {$p->NombreProyecto}\n";
    }
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n";
