<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 SP_EnviarConsulta\n";
echo "====================\n\n";

try {
    $def = DB::select("SHOW CREATE PROCEDURE `SP_EnviarConsulta`");
    echo $def[0]->{'Create Procedure'} . "\n\n";
    
    echo "📞 PRUEBA: Llamar SP_EnviarConsulta:\n";
    $result = DB::select('CALL SP_EnviarConsulta(?, ?, ?, ?, ?, ?)', [
        2,              // user_id (Carlos)
        'secretaria',   // destinatario_tipo
        'Prueba',       // tipo_consulta
        'Asunto Test',  // asunto
        'Mensaje de prueba largooo',  // mensaje
        'media'         // prioridad
    ]);
    
    echo "✅ Éxito!\n";
    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
