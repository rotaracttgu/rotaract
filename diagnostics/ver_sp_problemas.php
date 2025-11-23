<?php
/**
 * Verificar estructura de SPs y arreglar problemas
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

// Mostrar definición actual del SP_MisProyectos
echo "DEFINICIÓN ACTUAL DE SP_MisProyectos:\n";
$def = DB::select("SHOW CREATE PROCEDURE SP_MisProyectos");
if ($def) {
    echo $def[0]->{'Create Procedure'} . "\n\n";
}

echo "\n\n";

// Mostrar definición actual del SP_MisConsultas
echo "DEFINICIÓN ACTUAL DE SP_MisConsultas:\n";
$def2 = DB::select("SHOW CREATE PROCEDURE SP_MisConsultas");
if ($def2) {
    echo $def2[0]->{'Create Procedure'} . "\n\n";
}
