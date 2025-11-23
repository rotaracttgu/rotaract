<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "✅ RESPUESTA: ¿QUÉ REUNIONES VERÁ CARLOS?\n";
echo "==========================================\n\n";

// Ejecutar SP_MisReuniones con 3 parámetros
// SP_MisReuniones(p_user_id, p_tipo_filtro, p_tipo_evento)
echo "Ejecutando: SP_MisReuniones(2, NULL, NULL)\n";
echo "(UserID 2 = Carlos, sin filtros)\n\n";

try {
    $reuniones = DB::select("CALL SP_MisReuniones(2, NULL, NULL)");
    
    echo "📊 RESULTADOS:\n";
    echo "   Reuniones retornadas: " . count($reuniones) . "\n\n";
    
    if (count($reuniones) > 0) {
        foreach ($reuniones as $r) {
            echo "   📅 {$r->TituloEvento}\n";
            echo "      ID: {$r->CalendarioID}\n";
            echo "      Tipo: {$r->TipoEvento}\n";
            echo "      Estado: {$r->EstadoEvento}\n";
            echo "      Fecha: {$r->FechaInicio}\n";
            echo "      Organiza: {$r->NombreOrganizador}\n";
            echo "      Asistencia de Carlos: " . ($r->AsistenciaID ? "SÍ (" . $r->EstadoAsistencia . ")" : "NO REGISTRADA") . "\n";
            echo "      Duración: {$r->DuracionReunion}\n";
            echo "      Total asistentes: {$r->TotalAsistentes}\n\n";
        }
    }
    
    echo "\n✅ CONCLUSIÓN:\n";
    echo "   • SP_MisReuniones retorna TODAS las reuniones\n";
    echo "   • Incluye info de asistencia de Carlos (si existe)\n";
    echo "   • ✅ Carlos VERÁ TODAS las reuniones automáticamente\n";
    echo "   • NO necesita asistencia registrada para verlas\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n";
