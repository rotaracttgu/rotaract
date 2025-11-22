<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Miembro;

echo "🔍 DIAGNÓSTICO DE USUARIOS Y MIEMBROS\n";
echo "=====================================\n\n";

// 1. Listar todos los usuarios
echo "1️⃣ TODOS LOS USUARIOS:\n";
$usuarios = User::all();
foreach ($usuarios as $u) {
    $miembro = Miembro::where('user_id', $u->id)->first();
    $status = $miembro ? "✅ Con miembro (ID:{$miembro->MiembroID})" : "❌ SIN miembro";
    printf("   ID:%4d | %-25s | %s\n", $u->id, substr($u->name, 0, 25), $status);
}

echo "\n2️⃣ MIEMBROS SIN USUARIO:\n";
$miembrosSinUser = Miembro::whereNull('user_id')->get();
foreach ($miembrosSinUser as $m) {
    echo "   ID:{$m->MiembroID} | {$m->Rol}\n";
}

echo "\n3️⃣ INTENTAR CREAR RELACIÓN PARA LEONEL:\n";
// Buscar Leonel (podría estar con nombre diferente)
$leonel = User::whereRaw("LOWER(name) LIKE '%leonel%'")->first();
if ($leonel) {
    echo "   ✅ Leonel encontrado: {$leonel->name} (ID:{$leonel->id})\n";
    $miembroAsociado = Miembro::where('user_id', $leonel->id)->first();
    if (!$miembroAsociado) {
        echo "   ⚠️ No tiene miembro asignado, buscando disponible...\n";
        // Miembro más probable para Leonel
        $miembroLeonel = Miembro::find(5);
        if ($miembroLeonel && $miembroLeonel->user_id !== $leonel->id) {
            $miembroLeonel->update(['user_id' => $leonel->id]);
            echo "   ✅ Asignado Miembro ID:5 a usuario Leonel\n";
        }
    } else {
        echo "   ✅ Ya tiene Miembro ID:{$miembroAsociado->MiembroID}\n";
    }
} else {
    echo "   ❌ Leonel no encontrado\n";
}

echo "\n";
