<?php
/**
 * Ver datos reales sin columnas inexistentes
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "📊 DATOS REALES DE MIEMBROS\n";
echo "===========================\n\n";

echo "TODOS LOS MIEMBROS:\n";
$miembros = DB::select("
    SELECT 
        m.MiembroID,
        m.user_id,
        m.Rol,
        m.FechaIngreso,
        u.id as UserID,
        u.name,
        u.email,
        u.created_at,
        u.updated_at
    FROM miembros m
    LEFT JOIN users u ON m.user_id = u.id
    ORDER BY m.MiembroID
");

foreach ($miembros as $m) {
    echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "MiembroID: {$m->MiembroID}\n";
    echo "  Rol: {$m->Rol}\n";
    echo "  FechaIngreso: {$m->FechaIngreso}\n";
    echo "  user_id: {$m->user_id}\n";
    
    if ($m->UserID) {
        echo "  ┌─ Usuario Asociado:\n";
        echo "  │  ID: {$m->UserID}\n";
        echo "  │  Name: {$m->name}\n";
        echo "  │  Email: {$m->email}\n";
        echo "  │  Creado: {$m->created_at}\n";
        echo "  │  Actualizado: {$m->updated_at}\n";
        echo "  └─\n";
    } else {
        echo "  ⚠️ SIN USUARIO ASOCIADO\n";
    }
}

echo "\n\n🔍 ANÁLISIS:\n";
echo "============\n";

$total_miembros = count($miembros);
$socios = array_filter($miembros, fn($m) => $m->Rol === 'Socio');

echo "Total de miembros: {$total_miembros}\n";
echo "Total de Socios: " . count($socios) . "\n";

echo "\nDatos en cada Socio:\n";
foreach ($socios as $socio) {
    echo "  - MiembroID {$socio->MiembroID} ({$socio->name}) - Datos: UserID={$socio->user_id}, Name={$socio->name}\n";
}
