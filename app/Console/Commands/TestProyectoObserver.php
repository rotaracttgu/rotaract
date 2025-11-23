<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Proyecto;
use Illuminate\Support\Facades\DB;

class TestProyectoObserver extends Command
{
    protected $signature = 'test:proyecto-observer';
    protected $description = 'Test ProyectoObserver to verify calendar events are auto-created';

    public function handle()
    {
        $this->info('=== TEST: ProyectoObserver - Auto-crear Calendario ===');
        $this->newLine();

        // Get counts before
        $proyectosAntes = Proyecto::count();
        $calendariosAntes = DB::table('calendarios')->count();

        $this->info("✓ Proyectos antes: $proyectosAntes");
        $this->info("✓ Calendarios antes: $calendariosAntes");
        $this->newLine();

        // Create new project
        $this->info("Creando nuevo proyecto: 'Proyecto Test Observer'...");
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

        $this->info("✓ Proyecto creado: ID {$nuevoProyecto->ProyectoID}");
        $this->newLine();

        // Check if calendar was created
        $calendarRelacionado = DB::table('calendarios')->where('ProyectoID', $nuevoProyecto->ProyectoID)->first();

        if($calendarRelacionado) {
            $this->info('✅ SUCCESS! Calendario creado automáticamente:');
            $this->info("   - CalendarioID: {$calendarRelacionado->CalendarioID}");
            $this->info("   - TituloEvento: {$calendarRelacionado->TituloEvento}");
            $this->info("   - TipoEvento: {$calendarRelacionado->TipoEvento}");
            $this->info("   - ProyectoID: {$calendarRelacionado->ProyectoID}");
            $this->info("   - FechaInicio: {$calendarRelacionado->FechaInicio}");
        } else {
            $this->error('❌ FAIL! No se creó el calendario automáticamente');
        }

        $this->newLine();
        $this->info('=== Conteo Final ===');
        $this->info('✓ Proyectos ahora: ' . Proyecto::count());
        $this->info('✓ Calendarios ahora: ' . DB::table('calendarios')->count());
    }
}
