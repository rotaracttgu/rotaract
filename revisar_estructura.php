<?php
/**
 * Revisar estructura de tablas relacionadas
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 ESTRUCTURA DE TABLAS RELACIONADAS\n";
echo "====================================\n\n";

// Estructura de miembros
echo "1️⃣ ESTRUCTURA DE TABLA: miembros\n";
$columns = DB::select("DESCRIBE miembros");
foreach ($columns as $col) {
    echo "   - {$col->Field} ({$col->Type}) NULL: {$col->Null}\n";
}

// Estructura de users
echo "\n2️⃣ ESTRUCTURA DE TABLA: users\n";
$columns = DB::select("DESCRIBE users");
foreach ($columns as $col) {
    echo "   - {$col->Field} ({$col->Type}) NULL: {$col->Null}\n";
}

// Todos los Socios
echo "\n3️⃣ TODOS LOS SOCIOS (sin columna Nombre):\n";
$socios = DB::select("SELECT MiembroID, user_id, Rol, Estado, FechaIngreso FROM miembros WHERE Rol = 'Socio' ORDER BY MiembroID");
foreach ($socios as $s) {
    echo "   MiembroID: {$s->MiembroID}, user_id: {$s->user_id}, Rol: {$s->Rol}, Estado: {$s->Estado}, Ingreso: {$s->FechaIngreso}\n";
}

// Ver usuarios asociados
echo "\n4️⃣ USUARIOS Y SUS MIEMBROS ASOCIADOS:\n";
$usuarios = DB::select("
    SELECT u.id, u.name, u.email, u.created_at, u.updated_at,
           m.MiembroID, m.Rol, m.Estado
    FROM users u
    LEFT JOIN miembros m ON u.id = m.user_id
    ORDER BY u.id
");
foreach ($usuarios as $u) {
    if ($u->MiembroID) {
        echo "   UserID {$u->id} ({$u->name}) -> MiembroID {$u->MiembroID} ({$u->Rol})\n";
    }
}

echo "\n";
