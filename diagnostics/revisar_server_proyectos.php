<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 ANÁLISIS SERVIDOR - Problemas reales\n";
echo "========================================\n\n";

// 1. VER TODOS LOS PROYECTOS EN SERVIDOR
echo "1️⃣ TODOS LOS PROYECTOS EN SERVIDOR:\n";
$proyectos = DB::select("SELECT * FROM proyectos");
foreach ($proyectos as $p) {
    echo json_encode((array)$p, JSON_UNESCAPED_UNICODE) . "\n";
}

// 2. VER MIEMBROS
echo "\n2️⃣ MIEMBROS:\n";
$miembros = DB::select("SELECT m.MiembroID, u.name, m.Rol FROM miembros m JOIN users u ON m.user_id = u.id");
foreach ($miembros as $m) {
    echo "   {$m->MiembroID}: {$m->name} ({$m->Rol})\n";
}

// 3. VER PARTICIPACIONES
echo "\n3️⃣ PARTICIPACIONES:\n";
$partic = DB::select("SELECT * FROM participaciones");
if (empty($partic)) {
    echo "   ❌ SIN PARTICIPACIONES\n";
} else {
    foreach ($partic as $p) {
        echo "   ProyectoID {$p->ProyectoID} - MiembroID {$p->MiembroID}\n";
    }
}

// 4. LLAMAR SP_MisProyectos PARA CARLOS (MiembroID 2)
echo "\n4️⃣ SP_MisProyectos(2) - Proyectos que debería ver Carlos:\n";
try {
    $result = DB::select('CALL SP_MisProyectos(?)', [2]);
    if (empty($result)) {
        echo "   ⚠️ RETORNA 0 PROYECTOS (por eso no ve nada)\n";
    } else {
        foreach ($result as $p) {
            echo "   - " . json_encode((array)$p, JSON_UNESCAPED_UNICODE) . "\n";
        }
    }
} catch (\Exception $e) {
    echo "   ❌ ERROR: " . $e->getMessage() . "\n";
}

// 5. VER DEFINICIÓN DE SP_MisProyectos
echo "\n5️⃣ DEFINICIÓN DE SP_MisProyectos:\n";
try {
    $def = DB::select("SHOW CREATE PROCEDURE `SP_MisProyectos`");
    $sp = $def[0]->{'Create Procedure'};
    // Mostrar solo las primeras 500 caracteres
    echo substr($sp, 0, 1500) . "...\n";
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n";
