<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$cols = DB::select("DESCRIBE conversaciones_chat");
foreach ($cols as $c) {
    echo "  - {$c->Field} ({$c->Type})\n";
}
