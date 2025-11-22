<?php
/**
 * Diagnóstico: Ver qué datos reales existen en el servidor para cada usuario
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 DIAGNÓSTICO DE DATOS EN SERVIDOR\n";
echo "===================================\n\n";

// Ver todos los usuarios
echo "1️⃣ USUARIOS EN EL SERVIDOR:\n";
$users = DB::select("SELECT id, name, email FROM users ORDER BY id");
foreach ($users as $user) {
    echo "   ID: {$user->id}, Name: {$user->name}, Email: {$user->email}\n";
}

echo "\n2️⃣ MIEMBROS EN EL SERVIDOR:\n";
$members = DB::select("SELECT MiembroID, user_id, Rol FROM miembros ORDER BY MiembroID");
foreach ($members as $member) {
    echo "   MiembroID: {$member->MiembroID}, UserID: {$member->user_id}, Rol: {$member->Rol}\n";
}

// Por cada usuario, ver cuántos datos tiene
echo "\n3️⃣ DATOS POR USUARIO:\n";
foreach ($users as $user) {
    $member = DB::selectOne("SELECT MiembroID FROM miembros WHERE user_id = ?", [$user->id]);
    
    if ($member) {
        $notas = DB::selectOne("SELECT COUNT(*) as count FROM notas_personales WHERE MiembroID = ?", [$member->MiembroID]);
        $proyectos = DB::selectOne("SELECT COUNT(*) as count FROM participaciones WHERE MiembroID = ?", [$member->MiembroID]);
        $eventos = DB::selectOne("SELECT COUNT(*) as count FROM asistencias WHERE MiembroID = ?", [$member->MiembroID]);
        $consultas = DB::selectOne("SELECT COUNT(*) as count FROM mensajes_consultas WHERE MiembroID = ?", [$member->MiembroID]);
        
        echo "\n   👤 {$user->name} (UserID: {$user->id}):\n";
        echo "      - Notas: {$notas->count}\n";
        echo "      - Proyectos (participaciones): {$proyectos->count}\n";
        echo "      - Eventos (asistencias): {$eventos->count}\n";
        echo "      - Consultas: {$consultas->count}\n";
    } else {
        echo "\n   👤 {$user->name} (UserID: {$user->id}): ❌ SIN MIEMBRO\n";
    }
}

echo "\n";
