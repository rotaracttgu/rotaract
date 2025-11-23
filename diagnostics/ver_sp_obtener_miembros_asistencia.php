<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 VERIFICAR SP: sp_obtener_miembros_para_asistencia\n";
echo "====================================================\n\n";

$def = DB::select("SHOW CREATE PROCEDURE `sp_obtener_miembros_para_asistencia`");
echo $def[0]->{'Create Procedure'} . "\n\n";

echo "📞 PRUEBA: Obtener miembros para asistencia en evento 15\n";
try {
    $result = DB::select('CALL sp_obtener_miembros_para_asistencia(?)', [15]);
    echo "✅ Éxito: " . count($result) . " registro(s)\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
