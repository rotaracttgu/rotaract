<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Proyecto;
use Illuminate\Support\Facades\DB;

class SyncProyectosToCalendarios extends Command
{
    protected $signature = 'sync:proyectos-calendarios {--dry-run : Show what would be done without making changes}';
    protected $description = 'Create calendar events for projects that dont have them';

    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        $this->info('=== SINCRONIZANDO PROYECTOS CON CALENDARIOS ===');
        $this->newLine();

        if ($dryRun) {
            $this->warn('[DRY RUN] No se harán cambios reales, solo mostraré qué se crearía');
            $this->newLine();
        }

        // Obtener todos los proyectos que TIENEN FechaInicio pero NO tienen evento en calendarios
        $proyectosConFecha = Proyecto::whereNotNull('FechaInicio')->get();
        
        $this->info("Total proyectos con FechaInicio: {$proyectosConFecha->count()}");
        
        $creados = 0;
        $yaExisten = 0;

        foreach ($proyectosConFecha as $proyecto) {
            $calendarioExistente = DB::table('calendarios')
                ->where('ProyectoID', $proyecto->ProyectoID)
                ->first();

            if ($calendarioExistente) {
                $this->line("  ✓ {$proyecto->ProyectoID}: Ya tiene evento (CalendarioID {$calendarioExistente->CalendarioID})");
                $yaExisten++;
            } else {
                $this->warn("  ✗ {$proyecto->ProyectoID}: NO tiene evento - CREAR");
                
                if (!$dryRun) {
                    DB::table('calendarios')->insert([
                        'TituloEvento' => $proyecto->Nombre,
                        'Descripcion' => $proyecto->Descripcion ?? null,
                        'TipoEvento' => 'InicioProyecto',
                        'EstadoEvento' => 'Programado',
                        'FechaInicio' => $proyecto->FechaInicio,
                        'FechaFin' => $proyecto->FechaFin ?? $proyecto->FechaInicio,
                        'HoraInicio' => '08:00:00',
                        'HoraFin' => '17:00:00',
                        'ProyectoID' => $proyecto->ProyectoID,
                    ]);
                    $this->line("       ✅ Creado");
                } else {
                    $this->line("       [DRY] Se crearía");
                }
                
                $creados++;
            }
        }

        $this->newLine();
        $this->info("=== RESUMEN ===");
        $this->info("Ya existían: $yaExisten");
        $this->info("Creados/Por crear: $creados");

        if ($dryRun && $creados > 0) {
            $this->newLine();
            $this->comment("Ejecuta sin --dry-run para crear los eventos reales:");
            $this->info("php artisan sync:proyectos-calendarios");
        }
    }
}
