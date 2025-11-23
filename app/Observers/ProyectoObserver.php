<?php

namespace App\Observers;

use App\Models\Proyecto;
use Illuminate\Support\Facades\DB;

/**
 * ProyectoObserver
 *
 * Observa eventos del modelo Proyecto para automatizar tareas
 * como la creación de eventos en calendarios
 */
class ProyectoObserver
{
    /**
     * Handle the Proyecto "created" event.
     *
     * Cuando se crea un proyecto, automáticamente crea un evento
     * en la tabla calendarios si tiene FechaInicio
     */
    public function created(Proyecto $proyecto): void
    {
        // Si el proyecto tiene una fecha de inicio, crear un evento en calendarios
        if ($proyecto->FechaInicio) {
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
        }
    }

    /**
     * Handle the Proyecto "updated" event.
     *
     * Cuando se actualiza un proyecto:
     * 1. Si NO tenía calendario y ahora sí tiene FechaInicio → crear calendarios
     * 2. Si ya tiene calendario → actualizar sus fechas
     * 3. Si FechaInicio se elimina → eliminar el calendario
     */
    public function updated(Proyecto $proyecto): void
    {
        $calendarioExistente = DB::table('calendarios')
            ->where('ProyectoID', $proyecto->ProyectoID)
            ->first();

        // Caso 1: El proyecto NUNCA tuvo FechaInicio pero ahora sí
        if (!$calendarioExistente && $proyecto->FechaInicio) {
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
        }
        // Caso 2: El proyecto ya tenía calendario, actualizar fechas y nombre
        elseif ($calendarioExistente && $proyecto->FechaInicio) {
            DB::table('calendarios')
                ->where('ProyectoID', $proyecto->ProyectoID)
                ->update([
                    'TituloEvento' => $proyecto->Nombre,
                    'Descripcion' => $proyecto->Descripcion ?? null,
                    'FechaInicio' => $proyecto->FechaInicio,
                    'FechaFin' => $proyecto->FechaFin ?? $proyecto->FechaInicio,
                ]);
        }
        // Caso 3: Si FechaInicio se borra (o se setea a null), eliminar el calendario
        elseif ($calendarioExistente && !$proyecto->FechaInicio) {
            DB::table('calendarios')
                ->where('ProyectoID', $proyecto->ProyectoID)
                ->delete();
        }
    }

    /**
     * Handle the Proyecto "deleted" event.
     *
     * Cuando se elimina un proyecto, también eliminar su evento en calendarios
     */
    public function deleted(Proyecto $proyecto): void
    {
        DB::table('calendarios')
            ->where('ProyectoID', $proyecto->ProyectoID)
            ->delete();
    }
}
