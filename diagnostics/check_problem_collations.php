<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 Columnas con collations problemáticas\n";
echo "======================================\n\n";

$cols = DB::select("
    SELECT TABLE_NAME, COLUMN_NAME, COLLATION_NAME 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = 'gestiones_clubrotario'
    AND COLLATION_NAME = 'utf8mb4_unicode_ci'
");

foreach ($cols as $col) {
    echo "{$col->TABLE_NAME}.{$col->COLUMN_NAME}: {$col->COLLATION_NAME}\n";
}

echo "\n" . count($cols) . " columnas encontradas con utf8mb4_unicode_ci\n";
