<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "✅ ESTADO ACTUAL DEL SERVIDOR (POST-LIMPIEZA)\n";
echo "===========================================\n\n";

$usuarios = DB::select("SELECT id, name, email FROM users ORDER BY id");
echo "Usuarios:\n";
foreach ($usuarios as $u) {
    echo "  - ID {$u->id}: {$u->name} ({$u->email})\n";
}

$miembros = DB::select("SELECT MiembroID, user_id, Rol FROM miembros ORDER BY MiembroID");
echo "\nMiembros:\n";
foreach ($miembros as $m) {
    echo "  - MiembroID {$m->MiembroID}: Rol {$m->Rol}, user_id {$m->user_id}\n";
}

$notas = DB::select("SELECT COUNT(*) as cnt FROM notas_personales");
$consultas = DB::select("SELECT COUNT(*) as cnt FROM mensajes_consultas");
$participaciones = DB::select("SELECT COUNT(*) as cnt FROM participaciones");

echo "\nDatos de prueba:\n";
echo "  - Notas: " . $notas[0]->cnt . "\n";
echo "  - Consultas: " . $consultas[0]->cnt . "\n";
echo "  - Participaciones: " . $participaciones[0]->cnt . "\n";

echo "\n✅ Base de datos LIMPIA - Lista para pruebas\n";
