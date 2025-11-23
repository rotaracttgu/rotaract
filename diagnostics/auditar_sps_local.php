<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 ESTADO DE SPs EN LOCAL - Checkeando errores\n";
echo "==============================================\n\n";

$spsVerificar = [
    'sp_obtener_asistencias_evento' => [
        'a.Presente' => '❌ PROBLEMA: Usa a.Presente (debe ser EstadoAsistencia)',
        'a.EventoID' => '❌ PROBLEMA: Usa a.EventoID (debe ser CalendarioID)',
        'm.DNI' => '❌ PROBLEMA: Usa m.DNI (debe ser u.dni)'
    ],
    'sp_obtener_miembros_para_asistencia' => [
        'a.EventoID' => '❌ PROBLEMA: Usa a.EventoID (debe ser CalendarioID)'
    ],
    'SP_MisReuniones' => [
        'm_org.Nombre' => '❌ PROBLEMA: Usa m_org.Nombre (debe ser u_org.name)'
    ],
    'SP_MisProyectos' => [
        'm_resp.Nombre' => '❌ PROBLEMA: Usa m_resp.Nombre (debe ser u_resp.name)'
    ]
];

foreach ($spsVerificar as $spName => $problemas) {
    echo "📋 $spName\n";
    echo "   ────────────────────────────────\n";
    
    try {
        $def = DB::select("SHOW CREATE PROCEDURE `$spName`");
        $codigo = $def[0]->{'Create Procedure'};
        
        $tieneProblemas = false;
        foreach ($problemas as $patron => $mensaje) {
            if (strpos($codigo, $patron) !== false) {
                echo "   $mensaje\n";
                $tieneProblemas = true;
            }
        }
        
        if (!$tieneProblemas) {
            echo "   ✅ Sin problemas detectados\n";
        }
        
    } catch (\Exception $e) {
        echo "   ⚠️ Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
}
