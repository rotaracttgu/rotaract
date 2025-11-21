<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== VERIFICACIÓN DE NOTAS ===\n\n";

// 1. Ver notas en la base de datos
$notas = DB::table('notas_personales')->get();
echo "Notas en la tabla notas_personales: " . $notas->count() . "\n\n";

if ($notas->count() > 0) {
    foreach ($notas as $nota) {
        echo "ID: {$nota->NotaID}\n";
        echo "Título: {$nota->Titulo}\n";
        echo "Categoría: {$nota->Categoria}\n";
        echo "Visibilidad: {$nota->Visibilidad}\n";
        echo "Estado: {$nota->Estado}\n";
        echo "MiembroID: {$nota->MiembroID}\n";
        echo "---\n";
    }
}

// 2. Verificar miembros
echo "\n=== MIEMBROS ===\n";
$miembros = DB::table('miembros')->get(['MiembroID', 'user_id', 'Nombre']);
foreach ($miembros as $miembro) {
    echo "MiembroID: {$miembro->MiembroID}, UserID: {$miembro->user_id}, Nombre: {$miembro->Nombre}\n";
}

// 3. Probar el stored procedure
echo "\n=== PRUEBA DEL SP_MisNotas ===\n";
$userId = 5; // Tu usuario Super Admin

try {
    $resultado = DB::select('CALL SP_MisNotas(?, ?, ?, ?, ?, ?)', [
        $userId,
        null, // categoria
        null, // visibilidad
        '',   // buscar
        50,   // limite
        0     // offset
    ]);
    
    echo "Notas devueltas por SP: " . count($resultado) . "\n";
    
    if (count($resultado) > 0) {
        foreach ($resultado as $nota) {
            print_r($nota);
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
