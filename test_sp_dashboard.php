<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== PROBANDO SP_DashboardSocio COMPLETO ===\n\n";
    
    $userId = 5;
    
    // Obtener todos los result sets
    $pdo = DB::connection()->getPdo();
    $stmt = $pdo->prepare('CALL SP_DashboardSocio(?)');
    $stmt->execute([$userId]);
    
    // Result Set 1: Estadísticas de Proyectos
    echo "1. Estadísticas de Proyectos:\n";
    $proyectos = $stmt->fetchAll(PDO::FETCH_OBJ);
    if (!empty($proyectos)) {
        echo "   Total: " . ($proyectos[0]->TotalProyectos ?? 0) . "\n";
        echo "   Activos: " . ($proyectos[0]->ProyectosActivos ?? 0) . "\n";
        echo "   En Curso: " . ($proyectos[0]->ProyectosEnCurso ?? 0) . "\n";
    }
    
    // Result Set 2: Estadísticas de Reuniones
    $stmt->nextRowset();
    echo "\n2. Estadísticas de Reuniones:\n";
    $reuniones = $stmt->fetchAll(PDO::FETCH_OBJ);
    if (!empty($reuniones)) {
        echo "   Total: " . ($reuniones[0]->TotalReuniones ?? 0) . "\n";
        echo "   Programadas: " . ($reuniones[0]->ReunionesProgramadas ?? 0) . "\n";
        echo "   En Curso: " . ($reuniones[0]->ReunionesEnCurso ?? 0) . "\n";
    }
    
    // Result Set 3: Estadísticas de Notas
    $stmt->nextRowset();
    echo "\n3. Estadísticas de Notas:\n";
    $notas = $stmt->fetchAll(PDO::FETCH_OBJ);
    if (!empty($notas)) {
        echo "   Total: " . ($notas[0]->TotalNotas ?? 0) . "\n";
        echo "   Privadas: " . ($notas[0]->NotasPrivadas ?? 0) . "\n";
        echo "   Públicas: " . ($notas[0]->NotasPublicas ?? 0) . "\n";
        echo "   Este Mes: " . ($notas[0]->NotasEsteMes ?? 0) . "\n";
    }
    
    // Result Set 4: Estadísticas de Consultas
    $stmt->nextRowset();
    echo "\n4. Estadísticas de Consultas:\n";
    $consultas = $stmt->fetchAll(PDO::FETCH_OBJ);
    if (!empty($consultas)) {
        echo "   Total: " . ($consultas[0]->TotalConsultas ?? 0) . "\n";
        echo "   Pendientes: " . ($consultas[0]->ConsultasPendientes ?? 0) . "\n";
        echo "   Respondidas: " . ($consultas[0]->ConsultasRespondidas ?? 0) . "\n";
        echo "   Hoy: " . ($consultas[0]->ConsultasHoy ?? 0) . "\n";
    }
    
    // Result Set 5: Próximas Reuniones
    $stmt->nextRowset();
    echo "\n5. Próximas Reuniones:\n";
    $proximasReuniones = $stmt->fetchAll(PDO::FETCH_OBJ);
    echo "   Encontradas: " . count($proximasReuniones) . "\n";
    foreach ($proximasReuniones as $reunion) {
        echo "   • {$reunion->TituloEvento} - {$reunion->FechaInicio}\n";
        echo "     Estado: {$reunion->EstadoEvento} | Ubicación: {$reunion->Ubicacion}\n";
    }
    
    // Result Set 6: Proyectos Activos
    $stmt->nextRowset();
    echo "\n6. Proyectos Activos del Usuario:\n";
    $proyectosActivos = $stmt->fetchAll(PDO::FETCH_OBJ);
    echo "   Encontrados: " . count($proyectosActivos) . "\n";
    foreach ($proyectosActivos as $proyecto) {
        echo "   • {$proyecto->NombreProyecto}\n";
        echo "     Tipo: {$proyecto->TipoProyecto} | Estado: {$proyecto->EstadoProyecto}\n";
        echo "     Participantes: {$proyecto->TotalParticipantes}\n";
    }
    
    echo "\n✅ Prueba completada exitosamente\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
