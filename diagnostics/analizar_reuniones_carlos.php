<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 ANÁLISIS: ¿QUÉ REUNIONES VERÁ CARLOS?\n";
echo "========================================\n\n";

// 1. Ver eventos/reuniones en BD
echo "1️⃣ REUNIONES (CALENDARIOS) EN LA BD:\n";
$eventos = DB::select("
    SELECT CalendarioID, TituloEvento, TipoEvento, EstadoEvento, FechaInicio, FechaFin, OrganizadorID
    FROM calendarios
    ORDER BY CalendarioID
");

foreach ($eventos as $e) {
    echo "   CalendarioID {$e->CalendarioID}: {$e->TituloEvento}\n";
    echo "      Tipo: {$e->TipoEvento} | Estado: {$e->EstadoEvento}\n";
    echo "      Fecha: {$e->FechaInicio} a {$e->FechaFin}\n";
    echo "      Organizador: {$e->OrganizadorID}\n";
}

// 2. Ver asistencias registradas
echo "\n2️⃣ ASISTENCIAS REGISTRADAS:\n";
$asistencias = DB::select("
    SELECT CalendarioID, MiembroID, EstadoAsistencia, FechaRegistro
    FROM asistencias
    ORDER BY CalendarioID, MiembroID
");

if (count($asistencias) > 0) {
    foreach ($asistencias as $a) {
        echo "   CalendarioID {$a->CalendarioID} - MiembroID {$a->MiembroID}: {$a->EstadoAsistencia}\n";
    }
} else {
    echo "   ⚠️ No hay asistencias registradas\n";
}

// 3. Ver qué SPs existen para reuniones
echo "\n3️⃣ SPs RELACIONADOS A REUNIONES/EVENTOS:\n";
$procedures = DB::select("SHOW PROCEDURE STATUS WHERE Db = DATABASE() AND Name LIKE '%Reunion%' OR Name LIKE '%Evento%'");
if (count($procedures) > 0) {
    foreach ($procedures as $p) {
        echo "   - {$p->Name}\n";
    }
} else {
    echo "   ℹ️ No hay SPs específicos para reuniones\n";
}

// 4. Verificar cómo se muestran en el dashboard (revisar SocioController)
echo "\n4️⃣ VERIFICAR SP_MisReuniones (si existe):\n";
try {
    // Intentar llamar SP_MisReuniones
    $resultado = DB::select("SHOW PROCEDURE STATUS WHERE Name = 'SP_MisReuniones'");
    if (count($resultado) > 0) {
        echo "   ✅ SP_MisReuniones existe\n";
        
        // Ver definición
        $def = DB::select("SHOW CREATE PROCEDURE SP_MisReuniones");
        if (count($def) > 0) {
            echo "   Parámetros: Probablemente (user_id/miembro_id)\n";
            // Intentar ejecutar
            try {
                $reuniones = DB::select("CALL SP_MisReuniones(2)");
                echo "   Resultados para Carlos: " . count($reuniones) . " reuniones\n";
                if (count($reuniones) > 0) {
                    echo "   Carlos VERÁ reuniones automáticamente\n";
                } else {
                    echo "   Carlos NO VERÁ reuniones (SP retorna 0)\n";
                }
            } catch (\Exception $e) {
                echo "   ❌ Error al ejecutar: " . $e->getMessage() . "\n";
            }
        }
    } else {
        echo "   ❌ SP_MisReuniones NO existe\n";
        echo "   Las reuniones probablemente se cargan de otra forma\n";
    }
} catch (\Exception $e) {
    echo "   Error: " . $e->getMessage() . "\n";
}

// 5. Verificar cómo calcula reuniones en vista
echo "\n5️⃣ VERIFICACIÓN MANUAL: LÓGICA DE REUNIONES\n";
echo "   Las reuniones en calendarios normalmente se muestran:\n";
echo "   Opción A: Todas (sin filtro de asistencia)\n";
echo "   Opción B: Solo las que el usuario atiende (registro en asistencias)\n";
echo "   Opción C: Solo las que organiza (OrganizadorID = MiembroID)\n\n";

echo "   Eventos totales: " . count($eventos) . "\n";
echo "   Asistencias de Carlos: " . count(DB::select("SELECT * FROM asistencias WHERE MiembroID = 2")) . "\n";
echo "   Eventos que organiza Carlos: " . count(DB::select("SELECT * FROM calendarios WHERE OrganizadorID = 2")) . "\n";

// 6. Mostrar evento de prueba
echo "\n6️⃣ EJEMPLO CON EVENTO ACTUAL:\n";
if (count($eventos) > 0) {
    $e = $eventos[0];
    echo "   Evento: {$e->TituloEvento}\n";
    echo "   ¿Tiene asistencia de Carlos? " . (count(DB::select("SELECT * FROM asistencias WHERE CalendarioID = ? AND MiembroID = 2", [$e->CalendarioID])) > 0 ? "SÍ" : "NO") . "\n";
    echo "   ¿Es organizado por Carlos? " . ($e->OrganizadorID == 2 ? "SÍ" : "NO") . "\n";
}

echo "\n7️⃣ CONCLUSIÓN:\n";
echo "   Para que Carlos VEJA una reunión:\n";
echo "   • Si el sistema muestra TODAS: ✅ Las verá automáticamente\n";
echo "   • Si filtra por ASISTENCIA: ❌ Necesita registro en 'asistencias'\n";
echo "   • Si filtra por ORGANIZADOR: ❌ Solo si él las organiza\n";

echo "\n";
