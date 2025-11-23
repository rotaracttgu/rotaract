<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Columnas en tabla participaciones:\n";
$columns = DB::select("DESCRIBE participaciones");
foreach ($columns as $col) {
    echo "- {$col->Field} ({$col->Type})\n";
}

echo "\nContenido actual:\n";
$data = DB::select("SELECT * FROM participaciones");
if (empty($data)) {
    echo "Tabla vacía\n";
} else {
    foreach ($data as $row) {
        echo json_encode((array)$row) . "\n";
    }
}
