<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 AUDITORÍA: ¿DE DÓNDE SALIÓ EL PROYECTO?\n";
echo "==========================================\n\n";

// 1. Ver detalles del proyecto
echo "1️⃣ DETALLES DEL PROYECTO:\n";
$proyecto = DB::select("SELECT * FROM proyectos WHERE ProyectoID = 1")[0];
echo json_encode((array)$proyecto, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n";

// 2. Ver quién es el responsable
echo "\n2️⃣ RESPONSABLE:\n";
echo "   ResponsableID: " . ($proyecto->ResponsableID ?? 'NULL') . "\n";
if ($proyecto->ResponsableID) {
    $resp = DB::select("SELECT m.MiembroID, u.name FROM miembros m JOIN users u ON m.user_id = u.id WHERE m.MiembroID = ?", [$proyecto->ResponsableID]);
    if ($resp) {
        echo "   Responsable: " . $resp[0]->name . "\n";
    }
}

// 3. Ver si está en calendarios (eventos)
echo "\n3️⃣ ¿ESTÁ EN CALENDARIOS?\n";
$calendarios = DB::select("SELECT * FROM calendarios WHERE ProyectoID = 1");
if (empty($calendarios)) {
    echo "   ❌ NO está en calendarios\n";
} else {
    foreach ($calendarios as $c) {
        echo "   ✅ Evento: {$c->TituloEvento}\n";
    }
}

// 4. Ver TODAS las modificaciones recientes en BD (chequear logs)
echo "\n4️⃣ LOG DE CAMBIOS EN BD:\n";
echo "   (Buscando tablas de auditoría...)\n";

$tables = DB::select("SHOW TABLES");
$auditTables = [];
foreach ($tables as $t) {
    $tableName = array_values((array)$t)[0];
    if (strpos($tableName, 'audit') !== false || strpos($tableName, 'log') !== false) {
        $auditTables[] = $tableName;
    }
}

if (empty($auditTables)) {
    echo "   ℹ️ No hay tablas de auditoría/logs\n";
} else {
    echo "   Tablas encontradas: " . implode(", ", $auditTables) . "\n";
}

// 5. Ver cuándo se creó/modificó (si Laravel timestamps están habilitados)
echo "\n5️⃣ INFORMACIÓN DE TIMESTAMPS:\n";
echo "   Proyecto no tiene timestamps (created_at, updated_at)\n";

// 6. Ver si hay registros en base de datos por fecha
echo "\n6️⃣ VERIFICAR SI VIENE DE SEED O MIGRACIÓN:\n";
echo "   Buscando en migraciones...\n";

// Revisar el modelo para ver si hay factory/seed
$migraciones = DB::select("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY CREATE_TIME DESC LIMIT 10");
echo "   Últimas tablas creadas:\n";
foreach ($migraciones as $m) {
    echo "   - " . $m->TABLE_NAME . "\n";
}

echo "\n";
