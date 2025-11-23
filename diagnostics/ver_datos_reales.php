<?php
/**
 * Verificar qué datos REALES existen en el servidor
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 DATOS REALES EN EL SERVIDOR\n";
echo "==============================\n\n";

// Ver todos los datos en notas_personales
echo "1️⃣ TODAS LAS NOTAS:\n";
$notas = DB::select("SELECT NotaID, MiembroID, Titulo, Categoria, Visibilidad, Estado FROM notas_personales LIMIT 10");
if (count($notas) > 0) {
    foreach ($notas as $nota) {
        echo "   NotaID: {$nota->NotaID}, MiembroID: {$nota->MiembroID}, Titulo: {$nota->Titulo}, Categoria: {$nota->Categoria}, Visibilidad: {$nota->Visibilidad}\n";
    }
} else {
    echo "   ❌ No hay notas\n";
}

// Ver todas las participaciones
echo "\n2️⃣ TODAS LAS PARTICIPACIONES EN PROYECTOS:\n";
$participaciones = DB::select("SELECT ProyectoID, MiembroID, Rol, EstadoParticipacion FROM participaciones LIMIT 10");
if (count($participaciones) > 0) {
    foreach ($participaciones as $p) {
        echo "   ProyectoID: {$p->ProyectoID}, MiembroID: {$p->MiembroID}, Rol: {$p->Rol}, Estado: {$p->EstadoParticipacion}\n";
    }
} else {
    echo "   ❌ No hay participaciones\n";
}

// Ver todos los eventos
echo "\n3️⃣ TODOS LOS EVENTOS (CALENDARIOS):\n";
$eventos = DB::select("SELECT CalendarioID, TituloEvento, OrganizadorID, FechaInicio FROM calendarios LIMIT 10");
if (count($eventos) > 0) {
    foreach ($eventos as $evento) {
        echo "   CalendarioID: {$evento->CalendarioID}, Titulo: {$evento->TituloEvento}, OrganizadorID: {$evento->OrganizadorID}, Fecha: {$evento->FechaInicio}\n";
    }
} else {
    echo "   ❌ No hay eventos\n";
}

// Ver todas las consultas
echo "\n4️⃣ TODAS LAS CONSULTAS CON SECRETARÍA:\n";
$consultas = DB::select("SELECT MensajeID, MiembroID, Asunto, Estado FROM mensajes_consultas LIMIT 10");
if (count($consultas) > 0) {
    foreach ($consultas as $consulta) {
        echo "   MensajeID: {$consulta->MensajeID}, MiembroID: {$consulta->MiembroID}, Asunto: {$consulta->Asunto}, Estado: {$consulta->Estado}\n";
    }
} else {
    echo "   ❌ No hay consultas\n";
}

// Probar SPs directamente
echo "\n5️⃣ PRUEBAS DE SPs:\n";

echo "   SP_MisNotas(14, 1, 1, 0, 0, 0):\n";
try {
    $resultado = DB::select("CALL SP_MisNotas(?, ?, ?, ?, ?, ?)", [14, 1, 1, 0, 0, 0]);
    echo "      ✅ Registros retornados: " . count($resultado) . "\n";
} catch (\Exception $e) {
    echo "      ❌ Error: " . $e->getMessage() . "\n";
}

echo "\n   SP_MisProyectos(27, 'Activo', NULL, ''):\n";
try {
    $resultado = DB::select("CALL SP_MisProyectos(?, ?, ?, ?)", [27, 'Activo', NULL, '']);
    echo "      ✅ Registros retornados: " . count($resultado) . "\n";
} catch (\Exception $e) {
    echo "      ❌ Error: " . $e->getMessage() . "\n";
}

echo "\n   SP_MisConsultas(27, 'secretaria', NULL, 100):\n";
try {
    $resultado = DB::select("CALL SP_MisConsultas(?, ?, ?, ?)", [27, 'secretaria', NULL, 100]);
    echo "      ✅ Registros retornados: " . count($resultado) . "\n";
} catch (\Exception $e) {
    echo "      ❌ Error: " . $e->getMessage() . "\n";
}

echo "\n";
