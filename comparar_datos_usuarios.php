<?php
/**
 * Comparar qué datos tiene Rodrigo vs Leonel
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "📊 COMPARACIÓN DE DATOS: RODRIGO (MiembroID 10) vs LEONEL (MiembroID 14)\n";
echo "=====================================================================\n\n";

// Rodrigo = UserID 24, MiembroID 10
echo "👤 RODRIGO (UserID 24, MiembroID 10):\n";
echo "------------------------------------\n";

$notas = DB::select('CALL SP_MisNotas(24, NULL, NULL, "", 100, 0)');
echo "  Notas: " . count($notas) . "\n";
foreach ($notas as $n) {
    if (isset($n->Titulo)) {
        echo "    - {$n->Titulo}\n";
    }
}

$proyectos = DB::select('CALL SP_MisProyectos(24, NULL, NULL, "")');
echo "  Proyectos: " . count($proyectos) . "\n";
foreach ($proyectos as $p) {
    echo "    - {$p->NombreProyecto}\n";
}

$consultas = DB::select('CALL SP_MisConsultas(24, NULL, NULL, 100)');
echo "  Consultas Secretaría: " . count($consultas) . "\n";
foreach ($consultas as $c) {
    echo "    - {$c->Asunto}\n";
}

echo "\n👤 LEONEL (UserID 27, MiembroID 14):\n";
echo "----------------------------------\n";

$notas = DB::select('CALL SP_MisNotas(27, NULL, NULL, "", 100, 0)');
echo "  Notas: " . count($notas) . "\n";
foreach ($notas as $n) {
    if (isset($n->Titulo)) {
        echo "    - {$n->Titulo}\n";
    }
}

$proyectos = DB::select('CALL SP_MisProyectos(27, NULL, NULL, "")');
echo "  Proyectos: " . count($proyectos) . "\n";
foreach ($proyectos as $p) {
    echo "    - {$p->NombreProyecto}\n";
}

$consultas = DB::select('CALL SP_MisConsultas(27, NULL, NULL, 100)');
echo "  Consultas Secretaría: " . count($consultas) . "\n";
foreach ($consultas as $c) {
    echo "    - {$c->Asunto}\n";
}

echo "\n";
