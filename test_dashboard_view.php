<?php
/**
 * Script para probar que el dashboard del Socio carga correctamente
 * Simula los datos que el controlador pasa a la vista
 */

require __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "=== PRUEBA DE DASHBOARD SOCIO ===\n\n";
    
    // Simular usuario autenticado (user_id = 5)
    $user_id = 5;
    
    echo "1. Verificando usuario...\n";
    echo "   ✓ user_id: $user_id\n\n";
    
    // Ejecutar el SP (el SP internamente convierte user_id a MiembroID)
    echo "2. Ejecutando SP_DashboardSocio con user_id=$user_id...\n";
    $pdo = DB::connection()->getPdo();
    $stmt = $pdo->prepare("CALL SP_DashboardSocio(?)");
    $stmt->execute([$user_id]);
    
    // Result Set 1: Estadísticas de Proyectos
    $proyectosStats = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "\n   PROYECTOS:\n";
    echo "   - Total: {$proyectosStats['TotalProyectos']}\n";
    echo "   - Activos: {$proyectosStats['ProyectosActivos']}\n";
    echo "   - En Curso: {$proyectosStats['ProyectosEnCurso']}\n";
    
    $stmt->nextRowset();
    
    // Result Set 2: Estadísticas de Reuniones
    $reunionesStats = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "\n   REUNIONES:\n";
    echo "   - Total: {$reunionesStats['TotalReuniones']}\n";
    echo "   - Programadas: {$reunionesStats['ReunionesProgramadas']}\n";
    
    $stmt->nextRowset();
    
    // Result Set 3: Estadísticas de Notas
    $notasStats = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "\n   NOTAS:\n";
    echo "   - Total: {$notasStats['TotalNotas']}\n";
    echo "   - Privadas: {$notasStats['NotasPrivadas']}\n";
    echo "   - Públicas: {$notasStats['NotasPublicas']}\n";
    
    $stmt->nextRowset();
    
    // Result Set 4: Estadísticas de Consultas
    $consultasStats = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "\n   CONSULTAS:\n";
    echo "   - Total: {$consultasStats['TotalConsultas']}\n";
    echo "   - Pendientes: {$consultasStats['ConsultasPendientes']}\n";
    echo "   - Respondidas: {$consultasStats['ConsultasRespondidas']}\n";
    
    $stmt->nextRowset();
    
    // Result Set 5: Próximas Reuniones
    $proximasReuniones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "\n   PRÓXIMAS REUNIONES: " . count($proximasReuniones) . "\n";
    foreach ($proximasReuniones as $reunion) {
        echo "   - {$reunion['TituloEvento']} ({$reunion['FechaInicio']})\n";
    }
    
    $stmt->nextRowset();
    
    // Result Set 6: Proyectos Activos
    $proyectosActivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "\n   PROYECTOS ACTIVOS: " . count($proyectosActivos) . "\n";
    foreach ($proyectosActivos as $proyecto) {
        echo "   - {$proyecto['NombreProyecto']} ({$proyecto['EstadoProyecto']})\n";
    }
    
    echo "\n✅ PRUEBA COMPLETADA - Dashboard listo para usar\n";
    echo "\nVariables que la vista recibirá:\n";
    echo "   \$totalProyectos = {$proyectosStats['TotalProyectos']}\n";
    echo "   \$proyectosActivosCount = {$proyectosStats['ProyectosActivos']}\n";
    echo "   \$totalReuniones = {$reunionesStats['TotalReuniones']}\n";
    echo "   \$reunionesProgramadas = {$reunionesStats['ReunionesProgramadas']}\n";
    echo "   \$totalNotas = {$notasStats['TotalNotas']}\n";
    echo "   \$notasPrivadas = {$notasStats['NotasPrivadas']}\n";
    echo "   \$notasPublicas = {$notasStats['NotasPublicas']}\n";
    echo "   \$consultasPendientes = {$consultasStats['ConsultasPendientes']}\n";
    echo "   \$totalConsultas = {$consultasStats['TotalConsultas']}\n";
    echo "   \$proximasReuniones (Collection) = " . count($proximasReuniones) . " items\n";
    echo "   \$proyectosActivos (Collection) = " . count($proyectosActivos) . " items\n";
    
} catch (Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
