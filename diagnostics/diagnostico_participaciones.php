<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 DIAGNÓSTICO: ¿QUIÉN AGREGA PARTICIPACIONES?\n";
echo "================================================\n\n";

// 1. Ver participaciones actuales
echo "1️⃣ PARTICIPACIONES ACTUALES:\n";
$partic = DB::select("SELECT * FROM participaciones");
foreach ($partic as $p) {
    echo "   - ProyectoID {$p->ProyectoID}, MiembroID {$p->MiembroID}, Rol: {$p->Rol}\n";
    echo "     Fecha: {$p->FechaIngreso}, Estado: {$p->EstadoParticipacion}\n";
}

// 2. Ver roles de Carlos en el club vs en el proyecto
echo "\n2️⃣ ROLES DE CARLOS:\n";
$carlos = DB::select("
    SELECT 
        m.MiembroID,
        u.name,
        m.Rol AS RolEnClub,
        p.Rol AS RolEnProyecto
    FROM users u
    JOIN miembros m ON u.id = m.user_id
    LEFT JOIN participaciones p ON m.MiembroID = p.MiembroID
    WHERE u.name = 'Carlos'
");

foreach ($carlos as $c) {
    echo "   Nombre: {$c->name}\n";
    echo "   Rol en Club: {$c->RolEnClub}\n";
    echo "   Rol en Proyecto: {$c->RolEnProyecto}\n";
}

// 3. Ver qué dice el SP
echo "\n3️⃣ QUÉ RETORNA SP_MisProyectos PARA CARLOS:\n";
try {
    $sp = DB::select('CALL SP_MisProyectos(?, NULL, NULL, "")', [2]);
    if ($sp) {
        foreach ($sp as $p) {
            echo "   Proyecto: {$p->NombreProyecto}\n";
            echo "   RolProyecto: {$p->RolProyecto}\n";
        }
    }
} catch (\Exception $e) {
    echo "   Error: " . $e->getMessage() . "\n";
}

echo "\n";
