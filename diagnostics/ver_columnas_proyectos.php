<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Columnas en tabla proyectos:\n";
$columns = DB::select("DESCRIBE proyectos");
foreach ($columns as $col) {
    echo "- {$col->Field}\n";
}

echo "\n\nTodos los registros:\n";
$all = DB::select("SELECT * FROM proyectos");
foreach ($all as $p) {
    echo json_encode((array)$p, JSON_UNESCAPED_UNICODE) . "\n";
}
