<?php
// Leer últimas líneas del log
$logPath = 'storage/logs/laravel.log';

if (file_exists($logPath)) {
    $lines = array_reverse(file($logPath));
    $count = 0;
    
    echo "📋 ÚLTIMAS LÍNEAS DEL LOG (últimos 50 errores):\n";
    echo "==============================================\n\n";
    
    foreach ($lines as $line) {
        if ($count >= 50) break;
        
        // Mostrar líneas que contengan ERROR o EXCEPTION
        if (stripos($line, 'ERROR') !== false || stripos($line, 'EXCEPTION') !== false) {
            echo $line;
            $count++;
        }
    }
} else {
    echo "Log no encontrado\n";
}
