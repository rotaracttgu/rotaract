<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Columnas en miembros:\n";
$columns = DB::select("DESCRIBE miembros");
foreach ($columns as $col) {
    echo "- {$col->Field}\n";
}

echo "\nColumnas en users:\n";
$columns = DB::select("DESCRIBE users");
foreach ($columns as $col) {
    echo "- {$col->Field}\n";
}
