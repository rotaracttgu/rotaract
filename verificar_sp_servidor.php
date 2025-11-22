<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Miembro;

echo "============================================\n";
echo "🔍 VERIFICACIÓN DE DATOS EN SERVIDOR\n";
echo "============================================\n\n";

// 1. Verificar procedimiento SP_MisNotas
echo "1️⃣ PROCEDIMIENTO SP_MisNotas:\n";
echo "-------------------------------------------\n";

try {
    $result = DB::select("SHOW PROCEDURE STATUS WHERE Name='SP_MisNotas'");
    if (empty($result)) {
        echo "  ❌ Procedimiento NO existe\n";
    } else {
        echo "  ✅ Procedimiento EXISTE\n";
    }
} catch (\Exception $e) {
    echo "  ❌ ERROR: {$e->getMessage()}\n";
}

echo "\n";

// 2. Verificar usuario actual (Leonel)
echo "2️⃣ USUARIO LEONEL:\n";
echo "-------------------------------------------\n";

try {
    $leonel = User::where('name', 'Leonel A.')->first();
    if ($leonel) {
        echo "  ✅ Usuario encontrado\n";
        echo "     - ID: {$leonel->id}\n";
        echo "     - Email: {$leonel->email}\n";
        
        // Verificar miembro asociado
        $miembro = $leonel->miembro;
        if ($miembro) {
            echo "     - Miembro ID: {$miembro->MiembroID}\n";
            echo "     - Miembro user_id: {$miembro->user_id}\n";
        } else {
            echo "     ⚠️ No tiene miembro asociado\n";
        }
    } else {
        echo "  ❌ Usuario NO encontrado\n";
    }
} catch (\Exception $e) {
    echo "  ❌ ERROR: {$e->getMessage()}\n";
}

echo "\n";

// 3. Prueba del procedimiento SP_MisNotas
echo "3️⃣ PRUEBA SP_MisNotas:\n";
echo "-------------------------------------------\n";

try {
    $userId = 12; // Leonel
    $notas = DB::select('CALL SP_MisNotas(?, ?, ?, ?, ?, ?)', [
        $userId,
        NULL, // categoría
        NULL, // visibilidad
        '',   // búsqueda
        50,   // límite
        0     // offset
    ]);
    
    echo "  ✅ Procedimiento ejecutado\n";
    echo "  📊 Notas encontradas: " . count($notas) . "\n";
    
    if (count($notas) > 0) {
        echo "  📋 Primeras notas:\n";
        foreach (array_slice($notas, 0, 3) as $nota) {
            echo "     - {$nota->Titulo}: {$nota->Contenido}\n";
        }
    }
} catch (\Exception $e) {
    echo "  ❌ ERROR: {$e->getMessage()}\n";
}

echo "\n";

// 4. Verificar tabla notas_personales
echo "4️⃣ TABLA notas_personales:\n";
echo "-------------------------------------------\n";

try {
    $countNotas = DB::table('notas_personales')->count();
    echo "  📊 Total notas: {$countNotas}\n";
    
    if ($countNotas > 0) {
        $ultimasNotas = DB::table('notas_personales')
            ->select('NotaID', 'MiembroID', 'Titulo', 'Estado', 'Visibilidad')
            ->orderBy('FechaCreacion', 'desc')
            ->limit(5)
            ->get();
        
        echo "  📋 Últimas notas:\n";
        foreach ($ultimasNotas as $nota) {
            echo sprintf(
                "     - ID:%d | Miembro:%d | %s | Estado:%s | Visibilidad:%s\n",
                $nota->NotaID,
                $nota->MiembroID,
                substr($nota->Titulo, 0, 30),
                $nota->Estado,
                $nota->Visibilidad
            );
        }
    }
} catch (\Exception $e) {
    echo "  ❌ ERROR: {$e->getMessage()}\n";
}

echo "\n";

// 5. Verificar relaciones Miembro->Notas
echo "5️⃣ RELACIÓN MIEMBRO->NOTAS:\n";
echo "-------------------------------------------\n";

try {
    $miembro = Miembro::find(5); // Leonel
    if ($miembro) {
        echo "  ✅ Miembro encontrado: {$miembro->MiembroID}\n";
        
        // Intentar obtener notas directamente desde BD
        $notasDirectas = DB::table('notas_personales')
            ->where('MiembroID', $miembro->MiembroID)
            ->count();
        
        echo "  📊 Notas directas en BD: {$notasDirectas}\n";
    } else {
        echo "  ❌ Miembro NO encontrado\n";
    }
} catch (\Exception $e) {
    echo "  ❌ ERROR: {$e->getMessage()}\n";
}

echo "\n";

// 6. Verificar eventos (calendarios)
echo "6️⃣ TABLA calendarios:\n";
echo "-------------------------------------------\n";

try {
    $countEventos = DB::table('calendarios')->count();
    echo "  📊 Total eventos: {$countEventos}\n";
    
    if ($countEventos > 0) {
        $ultimosEventos = DB::table('calendarios')
            ->select('CalendarioID', 'TituloEvento', 'FechaInicio', 'EstadoEvento')
            ->orderBy('FechaInicio', 'desc')
            ->limit(3)
            ->get();
        
        echo "  📋 Últimos eventos:\n";
        foreach ($ultimosEventos as $evt) {
            echo sprintf(
                "     - %s | %s | %s\n",
                substr($evt->TituloEvento, 0, 30),
                $evt->FechaInicio,
                $evt->EstadoEvento
            );
        }
    }
} catch (\Exception $e) {
    echo "  ❌ ERROR: {$e->getMessage()}\n";
}

echo "\n============================================\n";
echo "✅ Verificación completada\n";
echo "============================================\n";
