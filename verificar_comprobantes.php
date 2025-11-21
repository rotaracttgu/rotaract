<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== VERIFICANDO CONSULTAS CON COMPROBANTES ===\n\n";
    
    // Obtener todas las consultas con SP_ConsultasSecretaria
    $consultas = DB::select('CALL SP_ConsultasSecretaria(NULL, NULL)');
    
    echo "Total de consultas: " . count($consultas) . "\n\n";
    
    foreach ($consultas as $consulta) {
        echo "Consulta #{$consulta->ConsultaID}\n";
        echo "Usuario: {$consulta->NombreUsuario} ({$consulta->EmailUsuario})\n";
        echo "Asunto: {$consulta->Asunto}\n";
        echo "Prioridad: {$consulta->Prioridad}\n";
        echo "Estado: {$consulta->Estado}\n";
        
        if ($consulta->ComprobanteRuta) {
            echo "✓ COMPROBANTE: {$consulta->ComprobanteRuta}\n";
            
            // Verificar si el archivo existe
            $rutaCompleta = storage_path('app/public/' . $consulta->ComprobanteRuta);
            if (file_exists($rutaCompleta)) {
                echo "  → Archivo existe en: {$rutaCompleta}\n";
                echo "  → Tamaño: " . filesize($rutaCompleta) . " bytes\n";
            } else {
                echo "  ✗ Archivo NO existe en: {$rutaCompleta}\n";
            }
            
            echo "  → URL: " . asset('storage/' . $consulta->ComprobanteRuta) . "\n";
        } else {
            echo "  Sin comprobante\n";
        }
        
        echo "Fecha: {$consulta->FechaEnvio}\n";
        echo str_repeat('-', 60) . "\n\n";
    }
    
    echo "\n=== VERIFICANDO DIRECTORIO DE STORAGE ===\n";
    $storagePublic = storage_path('app/public');
    echo "Directorio: {$storagePublic}\n";
    
    if (is_dir($storagePublic)) {
        echo "✓ Directorio existe\n";
        
        // Verificar si existe la carpeta comprobantes
        $comprobantesDir = $storagePublic . '/comprobantes';
        if (is_dir($comprobantesDir)) {
            echo "✓ Carpeta comprobantes existe\n";
            $archivos = scandir($comprobantesDir);
            echo "Archivos en comprobantes: " . (count($archivos) - 2) . "\n";
            foreach ($archivos as $archivo) {
                if ($archivo != '.' && $archivo != '..') {
                    echo "  - {$archivo}\n";
                }
            }
        } else {
            echo "✗ Carpeta comprobantes NO existe\n";
        }
    } else {
        echo "✗ Directorio NO existe\n";
    }
    
    // Verificar symlink
    echo "\n=== VERIFICANDO SYMLINK ===\n";
    $publicStorage = public_path('storage');
    if (is_link($publicStorage)) {
        echo "✓ Symlink existe: {$publicStorage}\n";
        echo "  → Apunta a: " . readlink($publicStorage) . "\n";
    } else {
        echo "✗ Symlink NO existe\n";
        echo "  Ejecuta: php artisan storage:link\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
