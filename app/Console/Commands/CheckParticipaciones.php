<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckParticipaciones extends Command
{
    protected $signature = 'check:participaciones {proyecto_id?}';
    protected $description = 'Check participaciones table structure and data';

    public function handle()
    {
        $this->info('=== VERIFICANDO TABLA participaciones ===');
        $this->newLine();

        // Contar registros
        $count = DB::table('participaciones')->count();
        $this->info("Total registros: $count");
        
        if ($count === 0) {
            $this->warn('La tabla está vacía');
        }

        // Si se proporciona proyecto_id, mostrar datos específicos
        if ($this->argument('proyecto_id')) {
            $proyectoId = $this->argument('proyecto_id');
            $this->newLine();
            $this->info("Participantes del proyecto $proyectoId:");
            
            $participantes = DB::table('participaciones')
                ->where('ProyectoID', $proyectoId)
                ->get();
            
            if ($participantes->isEmpty()) {
                $this->warn('No hay participantes para este proyecto');
            } else {
                foreach ($participantes as $p) {
                    $horas = isset($p->horasDedicadas) ? $p->horasDedicadas : 'N/A';
                    $this->line("  - MiembroID: {$p->MiembroID}, Rol: {$p->Rol}, Horas: {$horas}");
                }
            }
        }

        // Mostrar estructura
        $this->newLine();
        $this->info('Estructura de la tabla:');
        $columns = DB::select('DESC participaciones');
        foreach ($columns as $col) {
            $this->line("  {$col->Field}: {$col->Type}");
        }
    }
}
