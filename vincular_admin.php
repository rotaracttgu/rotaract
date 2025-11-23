<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

DB::table('miembros')->where('MiembroID', 1)->update(['user_id' => 1]);
echo "✅ Admin user_id vinculado\n";

// Verificar
$admin = DB::select("SELECT MiembroID, user_id, Rol FROM miembros WHERE MiembroID = 1");
foreach ($admin as $a) {
    echo "   MiembroID {$a->MiembroID}: Rol {$a->Rol}, user_id {$a->user_id}\n";
}
