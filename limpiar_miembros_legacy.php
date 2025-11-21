<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== LIMPIEZA DE MIEMBROS LEGACY (sin user_id) ===\n\n";

// Encontrar miembros sin user_id
$miembrosLegacy = DB::table('miembros')
    ->whereNull('user_id')
    ->get();

echo "Miembros legacy encontrados: " . count($miembrosLegacy) . "\n\n";

if (count($miembrosLegacy) > 0) {
    echo "Detalles:\n";
    echo str_repeat("-", 80) . "\n";
    printf("%-12s | %-20s | %-20s | %-15s\n", "MiembroID", "Rol", "FechaIngreso", "Apuntes");
    echo str_repeat("-", 80) . "\n";
    
    foreach ($miembrosLegacy as $m) {
        printf("%-12d | %-20s | %-20s | %-15s\n", 
            $m->MiembroID,
            substr($m->Rol ?? 'N/A', 0, 20),
            substr($m->FechaIngreso ?? 'N/A', 0, 20),
            substr($m->Apuntes ?? 'N/A', 0, 15)
        );
    }
    echo str_repeat("-", 80) . "\n\n";
    
    echo "⚠️  ADVERTENCIA: Estos miembros no tienen usuario asociado y pueden causar errores.\n";
    echo "   Se recomienda revisar si contienen datos importantes o pueden ser eliminados.\n\n";
    
    // Opciones
    echo "OPCIONES:\n";
    echo "1. Mantener los registros (sin usuario) - Aparecerán errores en dropdowns\n";
    echo "2. Eliminar definitivamente - ESTO NO SE PUEDE DESHACER\n\n";
    
    echo "Para eliminarlos, ejecuta:\n";
    echo "   DB::table('miembros')->whereNull('user_id')->delete();\n\n";
} else {
    echo "✅ No hay miembros legacy. Todos los miembros tienen usuario.\n";
}

// Resumen
echo "\n=== RESUMEN ACTUAL ===\n";
$totalMiembros = DB::table('miembros')->count();
$conUser = DB::table('miembros')->whereNotNull('user_id')->count();
$sinUser = DB::table('miembros')->whereNull('user_id')->count();

echo "Total miembros: $totalMiembros\n";
echo "✅ Con usuario: $conUser\n";
echo "❌ Sin usuario: $sinUser\n";

?>
