<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

// Ver estructura del procedimiento
$result = DB::select('CALL SP_MisNotas(12, NULL, NULL, "", 50, 0)');

if (!empty($result)) {
    echo "Columnas devueltas por SP_MisNotas:\n";
    echo json_encode($result[0], JSON_PRETTY_PRINT);
}
