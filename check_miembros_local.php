<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$cols = DB::select('DESC miembros');
echo "Columnas de 'miembros' en LOCAL:\n";
foreach($cols as $c) {
    echo "  - " . $c->Field . " (" . $c->Type . ")\n";
}
