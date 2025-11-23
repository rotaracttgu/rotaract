<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔧 HACER PROYECTO VISIBLE PARA CARLOS\n";
echo "========================================\n\n";

// OPCIÓN 1: Asignar Responsable
echo "1️⃣ ASIGNANDO RESPONSABLE AL PROYECTO:\n";
try {
    DB::table('proyectos')
        ->where('ProyectoID', 1)
        ->update(['ResponsableID' => 1]); // Admin como responsable
    
    echo "   ✅ Responsable asignado: Admin (MiembroID 1)\n";
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// OPCIÓN 2: Crear Participación
echo "\n2️⃣ CREANDO PARTICIPACIÓN PARA CARLOS:\n";
try {
    DB::table('participaciones')->insert([
        'ProyectoID' => 1,
        'MiembroID' => 2, // Carlos
        'Rol' => 'Participante',
        'FechaIngreso' => now()->format('Y-m-d'),
        'EstadoParticipacion' => 'Activo'
    ]);
    
    echo "   ✅ Participación creada: Carlos participa en proyecto\n";
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// VERIFICAR
echo "\n3️⃣ VERIFICANDO - SP_MisProyectos(2):\n";
try {
    $result = DB::select('CALL SP_MisProyectos(?, NULL, NULL, "")', [2]);
    echo "   Resultados: " . count($result) . " proyecto(s)\n";
    foreach ($result as $p) {
        echo "   ✅ {$p->NombreProyecto}\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

echo "\n";
