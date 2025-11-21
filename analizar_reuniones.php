<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== ANÁLISIS DE REUNIONES ===\n\n";
    
    // 1. Verificar tabla calendarios
    echo "1. Verificando tabla calendarios...\n";
    $calendarios = DB::select("SELECT * FROM calendarios LIMIT 5");
    echo "   Registros en calendarios: " . count($calendarios) . "\n";
    
    if (count($calendarios) > 0) {
        echo "\n   Ejemplo de registro:\n";
        print_r($calendarios[0]);
    }
    
    // 2. Verificar tabla asistencias
    echo "\n2. Verificando tabla asistencias...\n";
    $asistencias = DB::select("SELECT * FROM asistencias LIMIT 5");
    echo "   Registros en asistencias: " . count($asistencias) . "\n";
    
    // 3. Verificar MiembroID del usuario
    echo "\n3. Verificando usuario...\n";
    $miembro = DB::selectOne("SELECT MiembroID, Nombre FROM miembros WHERE user_id = 5");
    if ($miembro) {
        echo "   MiembroID: {$miembro->MiembroID}\n";
        echo "   Nombre: {$miembro->Nombre}\n";
    } else {
        echo "   ❌ No se encontró miembro para user_id = 5\n";
    }
    
    // 4. Verificar si existe el SP
    echo "\n4. Verificando stored procedures...\n";
    $procedures = DB::select("SHOW PROCEDURE STATUS WHERE Db = DATABASE() AND Name LIKE '%Reunion%'");
    echo "   SPs de reuniones encontrados: " . count($procedures) . "\n";
    foreach ($procedures as $proc) {
        echo "   - {$proc->Name}\n";
    }
    
    // 5. Probar el controller actual
    echo "\n5. Probando lógica actual del controller...\n";
    $filtroEstado = 'todas';
    $reuniones = collect([
        (object)[
            'ReunionID' => 1,
            'titulo' => 'Reunión General',
            'descripcion' => 'Revisión mensual.',
            'fecha_hora' => '2025-11-10 18:00:00',
            'lugar' => 'Sala Principal',
            'tipo' => 'Ordinaria',
            'estado' => 'Programada'
        ]
    ]);
    echo "   Controller actual retorna datos mock: " . $reuniones->count() . " reunión(es)\n";
    
    // 6. Verificar estructura esperada
    echo "\n6. ESTRUCTURA ESPERADA:\n";
    echo "   - La tabla 'calendarios' almacena los eventos/reuniones\n";
    echo "   - La tabla 'asistencias' vincula miembros con eventos\n";
    echo "   - El SP debe traer eventos del calendario filtrados\n";
    echo "   - La vista espera: TituloEvento, FechaInicio, Ubicacion, EstadoEvento\n";
    
    echo "\n\n=== RECOMENDACIÓN ===\n";
    if (count($calendarios) == 0) {
        echo "❌ No hay reuniones en la BD. Necesitas crear eventos en 'calendarios'\n";
        echo "   Las reuniones se crean desde los módulos de Vocero/Presidente\n";
    } else {
        echo "✓ Hay eventos en calendarios\n";
        echo "  Ahora necesitamos:\n";
        echo "  1. Crear/actualizar el SP_MisReuniones\n";
        echo "  2. Actualizar el controller para usar el SP\n";
        echo "  3. Actualizar la vista para mostrar los datos correctos\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
