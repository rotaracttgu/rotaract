<?php
/**
 * Limpiar datos de prueba - Hacer backup y limpiar
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🧹 LIMPIEZA DE DATOS DE PRUEBA\n";
echo "==============================\n\n";

// 1. Hacer backup mostrando qué vamos a borrar
echo "1️⃣ DATOS A ELIMINAR:\n\n";

echo "USUARIOS A BORRAR:\n";
$usuarios_borrar = DB::select("
    SELECT id, name, email, created_at 
    FROM users 
    WHERE id > 1 
    ORDER BY id
");
foreach ($usuarios_borrar as $u) {
    echo "  - ID {$u->id}: {$u->name} ({$u->email}) - Creado: {$u->created_at}\n";
}

echo "\nMIEMBROS A BORRAR:\n";
$miembros_borrar = DB::select("
    SELECT MiembroID, user_id, Rol, FechaIngreso 
    FROM miembros 
    WHERE MiembroID > 1 
    ORDER BY MiembroID
");
foreach ($miembros_borrar as $m) {
    echo "  - MiembroID {$m->MiembroID}: Rol {$m->Rol}, user_id {$m->user_id}\n";
}

echo "\n\n2️⃣ DATOS RELACIONADOS A ELIMINAR:\n\n";

// Datos asociados a estos miembros
$member_ids = array_map(fn($m) => $m->MiembroID, $miembros_borrar);
$user_ids = array_map(fn($u) => $u->id, $usuarios_borrar);

if (!empty($member_ids)) {
    $notas = DB::select("SELECT COUNT(*) as cnt FROM notas_personales WHERE MiembroID IN (" . implode(',', $member_ids) . ")");
    echo "  - Notas personales: " . $notas[0]->cnt . "\n";
    
    $consultas = DB::select("SELECT COUNT(*) as cnt FROM mensajes_consultas WHERE MiembroID IN (" . implode(',', $member_ids) . ")");
    echo "  - Consultas: " . $consultas[0]->cnt . "\n";
    
    $participaciones = DB::select("SELECT COUNT(*) as cnt FROM participaciones WHERE MiembroID IN (" . implode(',', $member_ids) . ")");
    echo "  - Participaciones: " . $participaciones[0]->cnt . "\n";
    
    $asistencias = DB::select("SELECT COUNT(*) as cnt FROM asistencias WHERE MiembroID IN (" . implode(',', $member_ids) . ")");
    echo "  - Asistencias: " . $asistencias[0]->cnt . "\n";
}

echo "\n\n3️⃣ ¿PROCEDER CON LA LIMPIEZA? (Se ejecutará en próximo script)\n";
echo "   Presiona confirmar para continuar...\n";
