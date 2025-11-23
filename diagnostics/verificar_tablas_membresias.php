<?php

/**
 * Script para verificar estructura de tablas de pagos/membresías
 * 
 * Ejecutar: php verificar_tablas_membresias.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "============================================\n";
echo "🔍 VERIFICACIÓN DE TABLAS DE MEMBRESÍAS\n";
echo "============================================\n\n";

// 1. Verificar qué tablas existen
echo "1️⃣ TABLAS EXISTENTES:\n";
echo "-------------------------------------------\n";

$tablas = [
    'pagosmembresia' => Schema::hasTable('pagosmembresia'),
    'membresias' => Schema::hasTable('membresias'),
    'pagos_membresia' => Schema::hasTable('pagos_membresia'),
];

foreach ($tablas as $nombre => $existe) {
    $status = $existe ? '✅ EXISTE' : '❌ NO EXISTE';
    echo "  - {$nombre}: {$status}\n";
}

echo "\n";

// 2. Contar registros en cada tabla existente
echo "2️⃣ CONTEO DE REGISTROS:\n";
echo "-------------------------------------------\n";

foreach ($tablas as $nombre => $existe) {
    if ($existe) {
        try {
            $count = DB::table($nombre)->count();
            echo "  - {$nombre}: {$count} registros\n";
        } catch (\Exception $e) {
            echo "  - {$nombre}: ERROR al contar - " . $e->getMessage() . "\n";
        }
    }
}

echo "\n";

// 3. Verificar estructura de tabla 'membresias' (la que usa PagoMembresia)
if (Schema::hasTable('membresias')) {
    echo "3️⃣ ESTRUCTURA DE TABLA 'membresias':\n";
    echo "-------------------------------------------\n";
    
    $columns = DB::select("DESCRIBE membresias");
    
    $columnasImportantes = ['id', 'usuario_id', 'miembro_id', 'monto', 'fecha_pago', 'estado'];
    
    foreach ($columns as $column) {
        if (in_array($column->Field, $columnasImportantes)) {
            echo sprintf(
                "  - %-20s | %-15s | Null: %s | Key: %s\n",
                $column->Field,
                $column->Type,
                $column->Null,
                $column->Key ?: 'N/A'
            );
        }
    }
    
    echo "\n";
}

// 4. Verificar estructura de tabla 'pagosmembresia' (legacy)
if (Schema::hasTable('pagosmembresia')) {
    echo "4️⃣ ESTRUCTURA DE TABLA 'pagosmembresia' (LEGACY):\n";
    echo "-------------------------------------------\n";
    
    $columns = DB::select("DESCRIBE pagosmembresia");
    
    foreach ($columns as $column) {
        echo sprintf(
            "  - %-20s | %-15s | Null: %s | Key: %s\n",
            $column->Field,
            $column->Type,
            $column->Null,
            $column->Key ?: 'N/A'
        );
    }
    
    echo "\n";
}

// 5. Verificar datos de ejemplo en tabla 'membresias'
if (Schema::hasTable('membresias')) {
    echo "5️⃣ DATOS DE EJEMPLO EN 'membresias' (Últimos 5):\n";
    echo "-------------------------------------------\n";
    
    $ejemplos = DB::table('membresias')
        ->select('id', 'usuario_id', 'miembro_id', 'monto', 'fecha_pago', 'estado')
        ->orderBy('id', 'desc')
        ->limit(5)
        ->get();
    
    if ($ejemplos->isEmpty()) {
        echo "  ⚠️ No hay registros en la tabla 'membresias'\n";
    } else {
        foreach ($ejemplos as $ejemplo) {
            echo sprintf(
                "  - ID: %d | usuario_id: %s | miembro_id: %s | Monto: %.2f | Estado: %s\n",
                $ejemplo->id,
                $ejemplo->usuario_id ?? 'NULL',
                $ejemplo->miembro_id ?? 'NULL',
                $ejemplo->monto,
                $ejemplo->estado
            );
        }
    }
    
    echo "\n";
}

// 6. Verificar sincronización usuario_id vs miembro_id
if (Schema::hasTable('membresias')) {
    echo "6️⃣ VERIFICACIÓN DE SINCRONIZACIÓN:\n";
    echo "-------------------------------------------\n";
    
    $totalRegistros = DB::table('membresias')->count();
    $conUsuarioId = DB::table('membresias')->whereNotNull('usuario_id')->count();
    $conMiembroId = DB::table('membresias')->whereNotNull('miembro_id')->count();
    $sincronizados = DB::table('membresias')
        ->whereNotNull('usuario_id')
        ->whereNotNull('miembro_id')
        ->whereRaw('usuario_id = miembro_id')
        ->count();
    
    echo "  - Total registros: {$totalRegistros}\n";
    echo "  - Con usuario_id: {$conUsuarioId}\n";
    echo "  - Con miembro_id: {$conMiembroId}\n";
    echo "  - Sincronizados (usuario_id = miembro_id): {$sincronizados}\n";
    
    if ($totalRegistros > 0) {
        $porcentaje = round(($sincronizados / $totalRegistros) * 100, 2);
        echo "  - Porcentaje sincronizado: {$porcentaje}%\n";
        
        if ($porcentaje < 100) {
            echo "  ⚠️ ADVERTENCIA: No todos los registros están sincronizados\n";
        } else {
            echo "  ✅ Todos los registros están sincronizados\n";
        }
    }
    
    echo "\n";
}

// 7. Verificar relación con tabla miembros
echo "7️⃣ RELACIÓN CON TABLA 'miembros':\n";
echo "-------------------------------------------\n";

if (Schema::hasTable('membresias') && Schema::hasTable('miembros')) {
    $membresiasSinMiembro = DB::table('membresias as m')
        ->leftJoin('miembros as miem', 'm.usuario_id', '=', 'miem.user_id')
        ->whereNull('miem.MiembroID')
        ->count();
    
    echo "  - Membresías sin miembro asociado: {$membresiasSinMiembro}\n";
    
    if ($membresiasSinMiembro > 0) {
        echo "  ⚠️ Hay membresías sin miembro asociado (posibles huérfanos)\n";
    } else {
        echo "  ✅ Todas las membresías tienen miembro asociado\n";
    }
}

echo "\n";

// 8. Recomendaciones
echo "8️⃣ RECOMENDACIONES:\n";
echo "-------------------------------------------\n";

if (Schema::hasTable('pagosmembresia')) {
    $countLegacy = DB::table('pagosmembresia')->count();
    if ($countLegacy > 0) {
        echo "  ⚠️ La tabla 'pagosmembresia' tiene {$countLegacy} registros\n";
        echo "     Considerar migrar datos a tabla 'membresias'\n";
    } else {
        echo "  ✅ Tabla 'pagosmembresia' está vacía (puede eliminarse después de backup)\n";
    }
}

if (Schema::hasTable('membresias')) {
    $totalMem = DB::table('membresias')->count();
    if ($totalMem === 0) {
        echo "  ⚠️ La tabla 'membresias' está vacía\n";
        echo "     Si hay datos en 'pagosmembresia', ejecutar migración\n";
    }
}

echo "\n============================================\n";
echo "✅ Verificación completada\n";
echo "============================================\n";
