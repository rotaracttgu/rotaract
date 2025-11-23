<?php
/**
 * Análisis completo de perfiles de Socio, usuarios y actualizaciones
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 ANÁLISIS COMPLETO DE PERFILES SOCIO\n";
echo "=====================================\n\n";

// 1. Ver todos los perfiles de Socio
echo "1️⃣ TODOS LOS PERFILES DE SOCIO:\n";
$socios = DB::select("SELECT MiembroID, Nombre, user_id, Rol, FechaIngreso, Estado FROM miembros WHERE Rol = 'Socio' ORDER BY MiembroID");
foreach ($socios as $s) {
    echo "   MiembroID: {$s->MiembroID}\n";
    echo "     - Nombre: {$s->Nombre}\n";
    echo "     - user_id: {$s->user_id}\n";
    echo "     - Estado: {$s->Estado}\n";
    echo "     - FechaIngreso: {$s->FechaIngreso}\n";
    echo "     - Rol: {$s->Rol}\n";
}

// 2. Ver usuarios asociados a Socios
echo "\n2️⃣ USUARIOS ASOCIADOS A SOCIOS:\n";
$usuarios = DB::select("
    SELECT u.id, u.name, u.email, u.created_at, u.updated_at, m.MiembroID, m.Nombre as MiembroNombre
    FROM users u
    LEFT JOIN miembros m ON u.id = m.user_id
    WHERE m.Rol = 'Socio' OR m.MiembroID IN (10, 14)
    ORDER BY u.id
");
foreach ($usuarios as $u) {
    echo "   UserID: {$u->id}\n";
    echo "     - Nombre (users.name): {$u->name}\n";
    echo "     - Email: {$u->email}\n";
    echo "     - MiembroID: {$u->MiembroID}\n";
    echo "     - MiembroNombre (miembros.Nombre): {$u->MiembroNombre}\n";
    echo "     - Usuario creado: {$u->created_at}\n";
    echo "     - Usuario actualizado: {$u->updated_at}\n";
    echo "\n";
}

// 3. Ver detalles completos de miembros Socio
echo "\n3️⃣ DETALLES COMPLETOS DE MIEMBROS SOCIO:\n";
$miembros = DB::select("
    SELECT * FROM miembros 
    WHERE Rol = 'Socio'
    ORDER BY MiembroID
");
foreach ($miembros as $m) {
    echo "   MiembroID: {$m->MiembroID} - {$m->Nombre}\n";
    echo "     " . json_encode((array)$m, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
}

// 4. Ver historial de cambios si existe tabla de auditoría
echo "\n4️⃣ BUSCANDO AUDITORÍA/HISTORIAL:\n";
$tables = DB::select("SHOW TABLES LIKE '%audit%' OR LIKE '%history%' OR LIKE '%log%'");
if (count($tables) > 0) {
    echo "   Encontradas tablas de auditoría:\n";
    foreach ($tables as $table) {
        $tableName = array_values((array)$table)[0];
        echo "   - {$tableName}\n";
    }
} else {
    echo "   No se encontraron tablas de auditoría\n";
}

// 5. Verificar si hay observers en el código
echo "\n5️⃣ BUSCANDO OBSERVERS EN EL CÓDIGO:\n";

echo "\n";
