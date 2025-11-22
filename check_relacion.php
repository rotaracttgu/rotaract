<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 RELACIÓN ENTRE MIEMBROS Y USERS\n";
echo "==================================\n\n";

$data = DB::select('SELECT m.MiembroID, m.user_id, u.name FROM miembros m LEFT JOIN users u ON m.user_id = u.id LIMIT 3');

foreach ($data as $row) {
    echo "MiembroID: {$row->MiembroID}, UserID: {$row->user_id}, Name: {$row->name}\n";
}

echo "\n";
echo "Los SPs deben obtener el nombre de la tabla 'users' usando la relación user_id\n";
echo "Esto significa que los SPs tienen un BUG: usan m_resp.Nombre pero debería ser u_resp.name\n";
