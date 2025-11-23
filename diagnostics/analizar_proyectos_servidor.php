<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 ANÁLISIS: PROYECTOS EN SERVIDOR\n";
echo "===================================\n\n";

// 1. Ver todos los proyectos
echo "1️⃣ TODOS LOS PROYECTOS EN BD:\n";
$proyectos = DB::select("SELECT ProyectoID, NombreProyecto, Descripcion, ResponsableID, FechaInicio, Estatus FROM proyectos ORDER BY ProyectoID");
foreach ($proyectos as $p) {
    echo "   ID {$p->ProyectoID}: {$p->NombreProyecto}\n";
    echo "      Responsable: {$p->ResponsableID} | Estatus: {$p->Estatus} | Inicio: {$p->FechaInicio}\n";
}

// 2. Ver miembros
echo "\n2️⃣ MIEMBROS EN BD:\n";
$miembros = DB::select("SELECT m.MiembroID, u.name, m.Rol FROM miembros m JOIN users u ON m.user_id = u.id");
foreach ($miembros as $m) {
    echo "   ID {$m->MiembroID}: {$m->name} ({$m->Rol})\n";
}

// 3. Ver participaciones
echo "\n3️⃣ PARTICIPACIONES EN BD:\n";
$partic = DB::select("SELECT ParticipacionID, ProyectoID, MiembroID, RolParticipante FROM participaciones");
if (empty($partic)) {
    echo "   ❌ NO HAY PARTICIPACIONES\n";
} else {
    foreach ($partic as $p) {
        echo "   ProyectoID {$p->ProyectoID} - MiembroID {$p->MiembroID} - Rol: {$p->RolParticipante}\n";
    }
}

// 4. Ver qué retorna SP_MisProyectos para Carlos (MiembroID 2)
echo "\n4️⃣ SP_MisProyectos para Carlos (MiembroID 2):\n";
try {
    $result = DB::select('CALL SP_MisProyectos(?)', [2]);
    if (empty($result)) {
        echo "   ⚠️ SP retorna 0 proyectos\n";
    } else {
        foreach ($result as $p) {
            echo "   - " . json_encode((array)$p) . "\n";
        }
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// 5. Ver definición del SP
echo "\n5️⃣ DEFINICIÓN DE SP_MisProyectos:\n";
try {
    $def = DB::select("SHOW CREATE PROCEDURE `SP_MisProyectos`");
    echo $def[0]->{'Create Procedure'} . "\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n";
