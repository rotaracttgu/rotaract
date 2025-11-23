<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Log;

echo "📋 ÚLTIMOS 30 ERRORES DEL LOG DEL SERVIDOR\n";
echo "==========================================\n\n";

$logPath = storage_path('logs/laravel.log');

if (file_exists($logPath)) {
    $lines = file($logPath);
    $errores = [];
    
    // Revertir y buscar errores
    foreach (array_reverse($lines) as $line) {
        if (strpos($line, 'ERROR') !== false || strpos($line, 'Exception') !== false) {
            $errores[] = $line;
            if (count($errores) >= 30) break;
        }
    }
    
    foreach ($errores as $error) {
        echo $error;
    }
} else {
    echo "No se encontró log\n";
}
