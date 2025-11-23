<?php
/**
 * LIMPIAR DATOS DE PRUEBA - Eliminar todos los usuarios/miembros excepto Admin
 * Y sus datos relacionados
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🗑️  INICIANDO LIMPIEZA DE DATOS\n";
echo "==============================\n\n";

try {
    // 1. Obtener IDs de miembros y usuarios a eliminar
    $miembros_borrar = DB::select("SELECT MiembroID FROM miembros WHERE MiembroID > 1");
    $usuarios_borrar = DB::select("SELECT id FROM users WHERE id > 1");
    
    $member_ids = array_map(fn($m) => $m->MiembroID, $miembros_borrar);
    $user_ids = array_map(fn($u) => $u->id, $usuarios_borrar);
    
    if (empty($member_ids) || empty($user_ids)) {
        echo "✅ No hay datos para limpiar\n";
        exit;
    }
    
    // 2. Eliminar datos relacionados a miembros
    echo "Eliminando datos relacionados...\n";
    
    $ids_str = implode(',', $member_ids);
    
    // Notas
    $notas = DB::delete("DELETE FROM notas_personales WHERE MiembroID IN ($ids_str)");
    echo "  ✓ Notas eliminadas: {$notas}\n";
    
    // Consultas
    $consultas = DB::delete("DELETE FROM mensajes_consultas WHERE MiembroID IN ($ids_str)");
    echo "  ✓ Consultas eliminadas: {$consultas}\n";
    
    // Participaciones
    $participaciones = DB::delete("DELETE FROM participaciones WHERE MiembroID IN ($ids_str)");
    echo "  ✓ Participaciones eliminadas: {$participaciones}\n";
    
    // Asistencias
    $asistencias = DB::delete("DELETE FROM asistencias WHERE MiembroID IN ($ids_str)");
    echo "  ✓ Asistencias eliminadas: {$asistencias}\n";
    
    // Conversaciones de chat
    $chat = DB::delete("DELETE FROM conversaciones_chat WHERE RemitenteID IN ($ids_str)");
    echo "  ✓ Conversaciones de chat eliminadas: {$chat}\n";
    
    echo "\nEliminando miembros...\n";
    
    // 3. Eliminar miembros
    $miembros_elim = DB::delete("DELETE FROM miembros WHERE MiembroID > 1");
    echo "  ✓ Miembros eliminados: {$miembros_elim}\n";
    
    echo "\nEliminando usuarios...\n";
    
    // 4. Eliminar usuarios
    $users_str = implode(',', $user_ids);
    $usuarios_elim = DB::delete("DELETE FROM users WHERE id IN ($users_str)");
    echo "  ✓ Usuarios eliminados: {$usuarios_elim}\n";
    
    // 5. Resetear auto_increment
    echo "\nResetando auto_increment...\n";
    DB::statement("ALTER TABLE users AUTO_INCREMENT = 2");
    DB::statement("ALTER TABLE miembros AUTO_INCREMENT = 2");
    echo "  ✓ Auto_increment reseteado\n";
    
    echo "\n\n✅ LIMPIEZA COMPLETADA\n";
    echo "====================\n";
    echo "\nEstado actual:\n";
    
    $usuarios_restantes = DB::select("SELECT id, name, email FROM users ORDER BY id");
    echo "\nUsuarios restantes:\n";
    foreach ($usuarios_restantes as $u) {
        echo "  - ID {$u->id}: {$u->name} ({$u->email})\n";
    }
    
    $miembros_restantes = DB::select("SELECT MiembroID, user_id, Rol FROM miembros ORDER BY MiembroID");
    echo "\nMiembros restantes:\n";
    foreach ($miembros_restantes as $m) {
        echo "  - MiembroID {$m->MiembroID}: Rol {$m->Rol}, user_id {$m->user_id}\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error durante la limpieza:\n";
    echo $e->getMessage() . "\n";
}
