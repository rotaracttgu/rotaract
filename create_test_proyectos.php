<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "Creando proyecto de prueba...\n\n";
    
    // Obtener el MiembroID del usuario 5
    $miembro = DB::selectOne("SELECT MiembroID FROM miembros WHERE user_id = 5");
    
    if (!$miembro) {
        echo "❌ No se encontró miembro para el usuario 5\n";
        exit;
    }
    
    $miembroID = $miembro->MiembroID;
    echo "✓ MiembroID encontrado: $miembroID\n";
    
    // Crear proyecto
    $proyectoID = DB::table('proyectos')->insertGetId([
        'Nombre' => 'Campaña de Donación de Alimentos',
        'Descripcion' => 'Recolección de alimentos no perecederos para comunidades vulnerables durante la temporada navideña.',
        'FechaInicio' => '2025-11-01',
        'FechaFin' => '2025-12-20',
        'Estatus' => 'Activo',
        'EstadoProyecto' => 'Activo',
        'Presupuesto' => 25000.00,
        'TipoProyecto' => 'Social',
        'ResponsableID' => $miembroID
    ]);
    
    echo "✓ Proyecto creado con ID: $proyectoID\n";
    
    // Crear participación para el usuario
    DB::table('participaciones')->insert([
        'ProyectoID' => $proyectoID,
        'MiembroID' => $miembroID,
        'Rol' => 'Líder',
        'FechaIngreso' => '2025-11-01',
        'EstadoParticipacion' => 'Activo'
    ]);
    
    echo "✓ Participación creada (Líder)\n";
    
    // Crear un segundo proyecto
    $proyectoID2 = DB::table('proyectos')->insertGetId([
        'Nombre' => 'Taller de Educación Ambiental',
        'Descripcion' => 'Serie de talleres educativos sobre reciclaje y cuidado del medio ambiente en escuelas locales.',
        'FechaInicio' => '2025-11-15',
        'FechaFin' => '2025-12-15',
        'Estatus' => 'En Planificacion',
        'EstadoProyecto' => 'En Planificacion',
        'Presupuesto' => 15000.00,
        'TipoProyecto' => 'Educativo',
        'ResponsableID' => $miembroID
    ]);
    
    echo "✓ Segundo proyecto creado con ID: $proyectoID2\n";
    
    DB::table('participaciones')->insert([
        'ProyectoID' => $proyectoID2,
        'MiembroID' => $miembroID,
        'Rol' => 'Coordinador',
        'FechaIngreso' => '2025-11-15',
        'EstadoParticipacion' => 'Activo'
    ]);
    
    echo "✓ Segunda participación creada (Coordinador)\n";
    
    // Crear un tercer proyecto completado
    $proyectoID3 = DB::table('proyectos')->insertGetId([
        'Nombre' => 'Jornada de Limpieza de Playas',
        'Descripcion' => 'Actividad de limpieza y concientización en las playas del municipio.',
        'FechaInicio' => '2025-10-01',
        'FechaFin' => '2025-10-31',
        'Estatus' => 'Completado',
        'EstadoProyecto' => 'Completado',
        'Presupuesto' => 8000.00,
        'TipoProyecto' => 'Ambiental',
        'ResponsableID' => $miembroID
    ]);
    
    echo "✓ Tercer proyecto creado con ID: $proyectoID3\n";
    
    DB::table('participaciones')->insert([
        'ProyectoID' => $proyectoID3,
        'MiembroID' => $miembroID,
        'Rol' => 'Líder',
        'FechaIngreso' => '2025-10-01',
        'FechaSalida' => '2025-10-31',
        'EstadoParticipacion' => 'Activo'
    ]);
    
    echo "✓ Tercera participación creada (Líder)\n\n";
    
    // Probar el SP
    echo "Probando SP_MisProyectos...\n";
    $proyectos = DB::select('CALL SP_MisProyectos(?, NULL, NULL, "")', [5]);
    
    echo "✅ Proyectos encontrados: " . count($proyectos) . "\n\n";
    
    foreach ($proyectos as $proyecto) {
        echo "📋 {$proyecto->NombreProyecto}\n";
        echo "   Estado: {$proyecto->Estatus}\n";
        echo "   Tipo: {$proyecto->TipoProyecto}\n";
        echo "   Rol: {$proyecto->RolProyecto}\n";
        echo "   Presupuesto: L. " . number_format($proyecto->Presupuesto, 2) . "\n";
        echo "   Progreso: {$proyecto->PorcentajeProgreso}%\n";
        echo "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
