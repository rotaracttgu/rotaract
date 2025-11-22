<?php
/**
 * Test de todos los SP que usa Socio Dashboard
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 PRUEBANDO TODOS LOS STORED PROCEDURES DEL DASHBOARD SOCIO\n";
echo "==============================================================\n\n";

// ID del miembro de prueba (Leonel = 14)
$miembroId = 14;
$usuarioId = 27; // Leonel

// 1. SP_MisProyectos - Con parámetros como en SocioController
echo "1️⃣ SP_MisProyectos (Activos):\n";
try {
    $result = DB::select('CALL SP_MisProyectos(?, "Activo", NULL, "")', [$miembroId]);
    echo "   ✅ Éxito! Registros: " . count($result) . "\n";
    if (count($result) > 0) {
        echo "   Primer proyecto: " . $result[0]->ProyectoID . "\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// 2. SP_MisReuniones - Con parámetros como en SocioController
echo "\n2️⃣ SP_MisReuniones:\n";
try {
    $result = DB::select('CALL SP_MisReuniones(?, NULL, NULL)', [$miembroId]);
    echo "   ✅ Éxito! Registros: " . count($result) . "\n";
    if (count($result) > 0) {
        echo "   Primera reunión: " . $result[0]->ReunionID . "\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// 3. SP_MisNotas - Con parámetros como en SocioController
echo "\n3️⃣ SP_MisNotas:\n";
try {
    $result = DB::select('CALL SP_MisNotas(?, ?, ?, ?, ?, ?)', [$miembroId, 1, 1, 0, 0, 0]);
    echo "   ✅ Éxito! Registros: " . count($result) . "\n";
    if (count($result) > 0) {
        echo "   Primera nota: " . $result[0]->Titulo . "\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// 4. SP_MisConsultas - Con parámetros como en SocioController
echo "\n4️⃣ SP_MisConsultas (Secretaria):\n";
try {
    $result = DB::select('CALL SP_MisConsultas(?, "secretaria", NULL, 100)', [$usuarioId]);
    echo "   ✅ Éxito! Registros: " . count($result) . "\n";
    if (count($result) > 0) {
        echo "   Primera consulta: " . $result[0]->ConsultaID . "\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// 5. SP_EventosDelDia - Necesita fecha
echo "\n5️⃣ SP_EventosDelDia:\n";
try {
    $hoy = date('Y-m-d');
    $result = DB::select('CALL SP_EventosDelDia(?)', [$hoy]);
    echo "   ✅ Éxito! Registros: " . count($result) . "\n";
    if (count($result) > 0) {
        echo "   Primer evento: " . $result[0]->TituloEvento . "\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// 6. SP_RecordatoriosProximos
echo "\n6️⃣ SP_RecordatoriosProximos:\n";
try {
    $result = DB::select("CALL SP_RecordatoriosProximos(?)", [$usuarioId]);
    echo "   ✅ Éxito! Registros: " . count($result) . "\n";
    if (count($result) > 0) {
        echo "   Primer recordatorio: " . $result[0]->Titulo . "\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// 7. SP_NotasPublicasPopulares
echo "\n7️⃣ SP_NotasPublicasPopulares:\n";
try {
    $result = DB::select("CALL SP_NotasPublicasPopulares(1)");
    echo "   ✅ Éxito! Registros: " . count($result) . "\n";
    if (count($result) > 0) {
        echo "   Primera nota: " . $result[0]->Titulo . "\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

echo "\n";
echo "✅ Diagnóstico completado\n";
