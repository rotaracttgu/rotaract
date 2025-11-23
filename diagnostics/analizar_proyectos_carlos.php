<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 ANÁLISIS: ¿QUÉ PROYECTOS VERÁ CARLOS INTERIANO?\n";
echo "=================================================\n\n";

// 1. Ver proyectos existentes
echo "1️⃣ PROYECTOS EN LA BD:\n";
$proyectos = DB::select("
    SELECT ProyectoID, Nombre, ResponsableID, Estatus, EstadoProyecto, TipoProyecto, FechaInicio, FechaFin
    FROM proyectos
    ORDER BY ProyectoID
");

foreach ($proyectos as $p) {
    echo "   ProyectoID {$p->ProyectoID}: {$p->Nombre}\n";
    echo "      Responsable: {$p->ResponsableID}\n";
    echo "      Estado: {$p->EstadoProyecto} ({$p->Estatus})\n";
    echo "      Tipo: {$p->TipoProyecto}\n";
    echo "      Fechas: {$p->FechaInicio} a {$p->FechaFin}\n";
}

// 2. Ver participaciones existentes
echo "\n2️⃣ PARTICIPACIONES EN PROYECTOS:\n";
$participaciones = DB::select("
    SELECT ProyectoID, MiembroID, Rol, EstadoParticipacion, FechaIngreso
    FROM participaciones
    ORDER BY ProyectoID, MiembroID
");

if (count($participaciones) > 0) {
    foreach ($participaciones as $p) {
        echo "   ProyectoID {$p->ProyectoID} - MiembroID {$p->MiembroID}: Rol {$p->Rol}, Estado {$p->EstadoParticipacion}\n";
    }
} else {
    echo "   ⚠️ No hay participaciones registradas\n";
}

// 3. Verificar datos de Carlos
echo "\n3️⃣ DATOS DE CARLOS INTERIANO (MiembroID 2):\n";
$carlos = DB::select("SELECT MiembroID, user_id, Rol FROM miembros WHERE MiembroID = 2");
if (count($carlos) > 0) {
    $c = $carlos[0];
    echo "   MiembroID: {$c->MiembroID}\n";
    echo "   UserID: {$c->user_id}\n";
    echo "   Rol: {$c->Rol}\n";
}

// 4. Probar SP_MisProyectos para Carlos
echo "\n4️⃣ PRUEBA SP_MisProyectos(2, NULL, NULL, ''):\n";
try {
    $resultado = DB::select("CALL SP_MisProyectos(2, NULL, NULL, '')");
    echo "   ✅ Registros retornados: " . count($resultado) . "\n";
    
    if (count($resultado) > 0) {
        echo "\n   Proyectos que Carlos VERÁ:\n";
        foreach ($resultado as $r) {
            echo "      - {$r->NombreProyecto} (ID: {$r->ProyectoID})\n";
            echo "        Responsable: {$r->NombreResponsable}\n";
            echo "        Estado: {$r->EstadoProyecto}\n";
        }
    } else {
        echo "   ℹ️ Carlos NO verá ningún proyecto porque:\n";
        echo "      • No es responsable de ningún proyecto\n";
        echo "      • No participa en ningún proyecto\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error al ejecutar SP: " . $e->getMessage() . "\n";
}

// 5. Explicar qué necesita para ver proyectos
echo "\n5️⃣ PARA QUE CARLOS VEA UN PROYECTO DEBE:\n";
echo "   Opción A: Ser RESPONSABLE del proyecto (ResponsableID = 2)\n";
echo "   Opción B: Tener una participación registrada\n";
echo "              (INSERT INTO participaciones (ProyectoID, MiembroID, ...)\n";

echo "\n6️⃣ RESUMEN:\n";
if (count($proyectos) > 0) {
    echo "   Hay " . count($proyectos) . " proyecto(s) en la BD\n";
    echo "   Carlos tiene " . count(DB::select("SELECT * FROM participaciones WHERE MiembroID = 2")) . " participación(es)\n";
    echo "   Carlos es responsable de " . count(DB::select("SELECT * FROM proyectos WHERE ResponsableID = 2")) . " proyecto(s)\n";
    echo "   → Carlos VERÁ: " . (count($resultado) ?? 0) . " proyecto(s)\n";
} else {
    echo "   ⚠️ No hay proyectos en la BD aún\n";
}

echo "\n";
