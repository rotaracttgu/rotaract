<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "📋 DEFINICIÓN DE SP_MisReuniones\n";
echo "==============================\n\n";

$def = DB::select("SHOW CREATE PROCEDURE SP_MisReuniones");
if (count($def) > 0) {
    echo $def[0]->{'Create Procedure'} . "\n";
}
