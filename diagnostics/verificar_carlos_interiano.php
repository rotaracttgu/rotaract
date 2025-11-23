<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 VERIFICACIÓN DE NUEVO USUARIO: CARLOS INTERIANO\n";
echo "================================================\n\n";

// 1. Ver usuarios
echo "1️⃣ USUARIOS EN BD:\n";
$usuarios = DB::select("SELECT id, name, email, created_at, updated_at FROM users ORDER BY id");
foreach ($usuarios as $u) {
    echo "   UserID {$u->id}: {$u->name} ({$u->email})\n";
    echo "      Creado: {$u->created_at}\n";
    echo "      Actualizado: {$u->updated_at}\n";
}

// 2. Ver miembros
echo "\n2️⃣ MIEMBROS EN BD:\n";
$miembros = DB::select("SELECT m.MiembroID, m.user_id, m.Rol, m.FechaIngreso FROM miembros m ORDER BY m.MiembroID");
foreach ($miembros as $m) {
    echo "   MiembroID {$m->MiembroID}: Rol {$m->Rol}, user_id {$m->user_id}, Ingreso: {$m->FechaIngreso}\n";
}

// 3. Verificar vinculación
echo "\n3️⃣ VINCULACIÓN USERS ↔ MIEMBROS:\n";
$vinculacion = DB::select("
    SELECT u.id as UserID, u.name, m.MiembroID, m.Rol
    FROM users u
    LEFT JOIN miembros m ON u.id = m.user_id
    ORDER BY u.id
");
foreach ($vinculacion as $v) {
    if ($v->MiembroID) {
        echo "   ✅ UserID {$v->UserID} ({$v->name}) ← → MiembroID {$v->MiembroID} ({$v->Rol})\n";
    } else {
        echo "   ❌ UserID {$v->UserID} ({$v->name}) SIN MIEMBRO VINCULADO\n";
    }
}

// 4. Verificar roles asignados
echo "\n4️⃣ ROLES ASIGNADOS:\n";
$roles = DB::select("
    SELECT u.id, u.name, r.name as rol_name
    FROM users u
    LEFT JOIN model_has_roles mhr ON u.id = mhr.model_id AND mhr.model_type = 'App\\\\Models\\\\User'
    LEFT JOIN roles r ON mhr.role_id = r.id
    WHERE u.id > 1
    ORDER BY u.id
");
foreach ($roles as $role) {
    if ($role->rol_name) {
        echo "   ✅ {$role->name}: {$role->rol_name}\n";
    } else {
        echo "   ⚠️ {$role->name}: SIN ROL ASIGNADO\n";
    }
}

// 5. Verificar datos de Carlos Interiano
echo "\n5️⃣ DATOS ESPECÍFICOS DE CARLOS INTERIANO:\n";
$carlos = DB::select("
    SELECT u.*, m.MiembroID, m.Rol, m.FechaIngreso
    FROM users u
    LEFT JOIN miembros m ON u.id = m.user_id
    WHERE u.name LIKE '%Carlos%' OR u.name LIKE '%Interiano%'
    LIMIT 1
");

if (count($carlos) > 0) {
    $c = $carlos[0];
    echo "   ✅ Usuario encontrado!\n";
    echo "      ID: {$c->id}\n";
    echo "      Nombre: {$c->name}\n";
    echo "      Email: {$c->email}\n";
    echo "      MiembroID: {$c->MiembroID}\n";
    echo "      Rol: {$c->Rol}\n";
    echo "      FechaIngreso: {$c->FechaIngreso}\n";
    echo "      Perfil completado en: {$c->profile_completed_at}\n";
    echo "      Primer login: " . ($c->first_login ? "SÍ" : "NO") . "\n";
    
    // Verificar si tiene datos
    if ($c->MiembroID) {
        echo "\n6️⃣ DATOS ASOCIADOS A CARLOS:\n";
        $notas = DB::select("SELECT COUNT(*) as cnt FROM notas_personales WHERE MiembroID = ?", [$c->MiembroID]);
        echo "      Notas: {$notas[0]->cnt}\n";
        
        $consultas = DB::select("SELECT COUNT(*) as cnt FROM mensajes_consultas WHERE MiembroID = ?", [$c->MiembroID]);
        echo "      Consultas: {$consultas[0]->cnt}\n";
        
        $participaciones = DB::select("SELECT COUNT(*) as cnt FROM participaciones WHERE MiembroID = ?", [$c->MiembroID]);
        echo "      Participaciones: {$participaciones[0]->cnt}\n";
    }
} else {
    echo "   ❌ Usuario Carlos Interiano NO encontrado\n";
}

echo "\n✅ Verificación completada\n";
