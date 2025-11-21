<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== ANÁLISIS DE COMUNICACIÓN SECRETARIA ===\n\n";
    
    // 1. Verificar tablas
    echo "1. Verificando tablas...\n";
    
    $tablas = ['consultas', 'mensajes_consultas', 'conversaciones_chat'];
    foreach ($tablas as $tabla) {
        try {
            $count = DB::select("SELECT COUNT(*) as total FROM $tabla")[0]->total;
            echo "   ✓ $tabla: $count registros\n";
        } catch (Exception $e) {
            echo "   ❌ $tabla: NO EXISTE\n";
        }
    }
    
    // 2. Verificar estructura de consultas
    echo "\n2. Estructura de tabla 'consultas':\n";
    $estructura = DB::select("DESCRIBE consultas");
    foreach ($estructura as $campo) {
        echo "   - {$campo->Field} ({$campo->Type})\n";
    }
    
    // 3. Verificar stored procedures
    echo "\n3. Verificando stored procedures...\n";
    $procedures = DB::select("SHOW PROCEDURE STATUS WHERE Db = DATABASE() AND Name LIKE '%Consulta%'");
    echo "   SPs encontrados: " . count($procedures) . "\n";
    foreach ($procedures as $proc) {
        echo "   - {$proc->Name}\n";
    }
    
    // 4. Verificar datos existentes
    echo "\n4. Verificando datos existentes...\n";
    $consultasData = DB::select("SELECT * FROM consultas LIMIT 3");
    if (count($consultasData) > 0) {
        echo "   Ejemplo de consulta:\n";
        print_r($consultasData[0]);
    } else {
        echo "   No hay consultas en la BD\n";
    }
    
    // 5. Verificar usuario
    echo "\n5. Verificando usuario...\n";
    $usuario = DB::selectOne("SELECT id, name, email FROM users WHERE id = 5");
    if ($usuario) {
        echo "   Usuario: {$usuario->name} ({$usuario->email})\n";
    }
    
    echo "\n\n=== RECOMENDACIÓN ===\n";
    echo "📋 Sistema a implementar:\n";
    echo "   1. Usar tabla 'consultas' (más simple y moderna)\n";
    echo "   2. Crear SP_MisConsultasSocio (listar consultas del socio)\n";
    echo "   3. Crear SP_ConsultasSecretaria (listar todas las consultas para secretaria)\n";
    echo "   4. Crear SP_CrearConsulta (socio envía consulta)\n";
    echo "   5. Crear SP_ResponderConsulta (secretaria responde)\n";
    echo "   6. Actualizar controllers de Socio y Secretaria\n";
    echo "   7. Actualizar vistas con datos reales\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
