<?php

namespace App\Observers;

use App\Models\Proyecto;
use App\Services\NotificacionService;
use Illuminate\Support\Facades\DB;

/**
 * ProyectoObserver
 *
 * Observa eventos del modelo Proyecto para automatizar tareas
 * como la creación de eventos en calendarios y notificaciones
 */
class ProyectoObserver
{
    protected $notificacionService;

    public function __construct(NotificacionService $notificacionService)
    {
        $this->notificacionService = $notificacionService;
    }

    /**
     * Handle the Proyecto "created" event.
     *
     * Cuando se crea un proyecto, automáticamente crea un evento
     * en la tabla calendarios si tiene FechaInicio
     */
    public function created(Proyecto $proyecto): void
    {
        \Log::info("ProyectoObserver.created - Proyecto: {$proyecto->Nombre} (ID: {$proyecto->ProyectoID})");
        
        // Si el proyecto tiene una fecha de inicio, crear un evento en calendarios
        if ($proyecto->FechaInicio) {
            try {
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
                \Log::info("Evento en calendario creado para proyecto {$proyecto->ProyectoID}");
            } catch (\Exception $e) {
                \Log::error("Error al crear evento en calendario: " . $e->getMessage());
            }
        }

        // 📢 Notificar sobre nuevo proyecto
        try {
            $this->notificacionService->notificarProyectoCreado($proyecto);
            \Log::info("Notificación de proyecto creado enviada para {$proyecto->ProyectoID}");
        } catch (\Exception $e) {
            \Log::error("Error al notificar proyecto creado: " . $e->getMessage());
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
