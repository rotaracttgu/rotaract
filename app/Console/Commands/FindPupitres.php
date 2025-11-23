<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Proyecto;

class FindPupitres extends Command
{
    protected $signature = 'find:pupitres';
    protected $description = 'Find where the pupitres project is stored';

    public function handle()
    {
        $this->info('=== BUSCANDO PUPITRES ===');
        $this->newLine();

        // Buscar en proyectos
        $proyecto = Proyecto::where('Nombre', 'like', '%pupitres%')->first();
        
        if ($proyecto) {
            $this->info('✓ ENCONTRADO EN TABLA proyectos:');
            $this->info("  ProyectoID: {$proyecto->ProyectoID}");
            $this->info("  Nombre: {$proyecto->Nombre}");
            $this->info("  created_at: {$proyecto->created_at}");
            $this->info("  updated_at: {$proyecto->updated_at}");
        } else {
            $this->warn('✗ NO en tabla proyectos');
        }

        $this->newLine();

        // Buscar en calendarios
        $calendario = DB::table('calendarios')->where('TituloEvento', 'like', '%pupitres%')->first();
        
        if ($calendario) {
            $this->info('✓ ENCONTRADO EN TABLA calendarios:');
            $this->info("  CalendarioID: {$calendario->CalendarioID}");
            $this->info("  TituloEvento: {$calendario->TituloEvento}");
            $this->info("  TipoEvento: {$calendario->TipoEvento}");
            $this->info("  ProyectoID: " . ($calendario->ProyectoID ?? 'NULL'));
        } else {
            $this->warn('✗ NO en tabla calendarios');
        }

        $this->newLine();

        if ($proyecto) {
            $this->comment("⚡ CONCLUSIÓN: Es un PROYECTO REAL creado desde Estado Proyectos");
        } elseif ($calendario) {
            $this->comment("⚡ CONCLUSIÓN: Es un EVENTO DE CALENDARIO creado desde Macero");
        } else {
            $this->error("⚡ NO EXISTE EN NINGÚN LADO");
        }
    }
}
