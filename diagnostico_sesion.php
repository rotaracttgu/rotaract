<?php
/**
 * Diagnóstico: Verificar sesión actual
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

echo "🔍 DIAGNÓSTICO DE SESIÓN\n";
echo "========================\n\n";

// Obtener usuario actual (simular petición autenticada)
// Para esto, vamos a ver en la BD qué usuarios tienen sesión activa reciente

echo "1️⃣ ÚLTIMAS SESIONES ACTIVAS:\n";
$sessions = DB::select("
    SELECT u.id, u.name, u.email
    FROM users u
    ORDER BY u.updated_at DESC
    LIMIT 5
");

foreach ($sessions as $session) {
    echo "   UserID: {$session->id}, Name: {$session->name}\n";
}

echo "\n2️⃣ RELACIÓN USERS -> MIEMBROS:\n";
$users = DB::select("
    SELECT u.id, u.name, m.MiembroID, m.Rol
    FROM users u
    LEFT JOIN miembros m ON u.id = m.user_id
    WHERE u.id IN (1, 22, 23, 24, 25, 26, 27)
    ORDER BY u.id
");

foreach ($users as $user) {
    echo "   UserID: {$user->id}, Name: {$user->name}, MiembroID: {$user->MiembroID}, Rol: {$user->Rol}\n";
}

echo "\n3️⃣ VERIFICAR DASHBOARD SOCIO:\n";
echo "   Los usuarios con rol 'Socio' o 'Presidente' pueden acceder\n";
$socio_users = DB::select("
    SELECT u.id, u.name, m.MiembroID, m.Rol
    FROM users u
    JOIN miembros m ON u.id = m.user_id
    WHERE m.Rol IN ('Socio', 'Presidente', 'Tesorero')
");

foreach ($socio_users as $user) {
    echo "   ✓ UserID: {$user->id}, Name: {$user->name}, Rol: {$user->Rol}\n";
}
