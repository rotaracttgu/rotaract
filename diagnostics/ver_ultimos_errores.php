<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Log;

echo "📋 ÚLTIMOS 30 ERRORES DEL LOG\n";
echo "=============================\n\n";

$logPath = storage_path('logs/laravel.log');

if (file_exists($logPath)) {
    $contents = file_get_contents($logPath);
    $lines = explode("\n", $contents);
    
    $errores = [];
    foreach (array_reverse($lines) as $line) {
        if (strpos($line, 'ERROR') !== false || strpos($line, 'Exception') !== false) {
            $errores[] = $line;
            if (count($errores) >= 30) break;
        }
    }
    
    foreach ($errores as $error) {
        echo $error . "\n";
    }
} else {
    echo "Log no encontrado en: $logPath\n";
}
