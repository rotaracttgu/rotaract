<?php
/**
 * Ver definición de SP_MisNotas
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$def = DB::select("SHOW CREATE PROCEDURE SP_MisNotas");
if ($def) {
    echo $def[0]->{'Create Procedure'} . "\n";
}
