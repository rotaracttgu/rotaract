<?php

namespace App\Observers;

use App\Models\Reunion;
use App\Services\NotificacionService;

class ReunionObserver
{
    protected $notificacionService;

    public function __construct(NotificacionService $notificacionService)
    {
        $this->notificacionService = $notificacionService;
    }

    /**
     * Handle the Reunion "created" event.
     */
    public function created(Reunion $reunion): void
    {
        // Notificar a todos los usuarios sobre la nueva reunión
        $this->notificacionService->notificarReunionCreada($reunion);
    }

    /**
     * Handle the Reunion "updated" event.
     */
    public function updated(Reunion $reunion): void
    {
        //
    }

    /**
     * Handle the Reunion "deleted" event.
     */
    public function deleted(Reunion $reunion): void
    {
        //
    }

    /**
     * Handle the Reunion "restored" event.
     */
    public function restored(Reunion $reunion): void
    {
        //
    }

    /**
     * Handle the Reunion "force deleted" event.
     */
    public function forceDeleted(Reunion $reunion): void
    {
        //
    }
}
