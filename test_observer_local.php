<?php
// Test script to verify ProyectoObserver works locally

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';

use App\Models\Proyecto;
use App\Models\Calendario;
use Illuminate\Support\Facades\DB;

echo "=== TEST: ProyectoObserver - Auto-crear Calendario ===\n\n";

// 1. Get initial counts
$proyectosAntes = Proyecto::count();
$calendariosAntes = Calendario::count();

echo "✓ Proyectos antes: $proyectosAntes\n";
echo "✓ Calendarios antes: $calendariosAntes\n\n";

// 2. Create a new project WITH FechaInicio
echo "Creando nuevo proyecto: 'Proyecto Test Observer'...\n";
$nuevoProyecto = Proyecto::create([
    'Nombre' => 'Proyecto Test Observer ' . now()->timestamp,
    'Descripcion' => 'Proyecto de prueba para verificar que el Observer crea calendarios automáticamente',
    'FechaInicio' => now()->addDays(7),
    'FechaFin' => now()->addDays(14),
    'Presupuesto' => 1000,
    'TipoProyecto' => 'Educacion',
    'Estatus' => 'Activo',
    'EstadoProyecto' => 'En Ejecución',
]);

echo "✓ Proyecto creado: ID {$nuevoProyecto->ProyectoID}\n\n";

// 3. Check if calendar was created
$calendarRelacionado = Calendario::where('ProyectoID', $nuevoProyecto->ProyectoID)->first();

if($calendarRelacionado) {
    echo "✅ SUCCESS! Calendario creado automáticamente:\n";
    echo "   - CalendarioID: {$calendarRelacionado->CalendarioID}\n";
    echo "   - Nombre: {$calendarRelacionado->Nombre}\n";
    echo "   - ProyectoID: {$calendarRelacionado->ProyectoID}\n";
    echo "   - FechaInicio: {$calendarRelacionado->FechaInicio}\n";
} else {
    echo "❌ FAIL! No se creó el calendario automáticamente\n";
}

echo "\n=== Conteo Final ===\n";
echo "✓ Proyectos ahora: " . Proyecto::count() . "\n";
echo "✓ Calendarios ahora: " . Calendario::count() . "\n";
