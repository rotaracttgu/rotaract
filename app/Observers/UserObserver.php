<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Miembro;

class UserObserver
{
    /**
     * Handle the User "created" event.
     * Crear automáticamente un registro de miembro para todo nuevo usuario.
     */
    public function created(User $user): void
    {
        // Verificar si ya existe un registro de miembro para este user_id
        $miembroExistente = Miembro::where('user_id', $user->id)->first();
        
        if (!$miembroExistente) {
            Miembro::create([
                'user_id' => $user->id,
                'Rol' => $user->getRoleNames()->first() ?? 'Socio',
                'FechaIngreso' => $user->fecha_juramentacion ?? now()->toDateString(),
                'Apuntes' => 'Creado automáticamente al registrar nuevo usuario'
            ]);
        }
    }

    /**
     * Handle the User "updated" event.
     * Sincronizar cambios de rol en miembro si el usuario existe.
     */
    public function updated(User $user): void
    {
        $miembroExistente = Miembro::where('user_id', $user->id)->first();
        
        if (!$miembroExistente) {
            // Si no existe el miembro, crearlo
            Miembro::create([
                'user_id' => $user->id,
                'Rol' => $user->getRoleNames()->first() ?? 'Socio',
                'FechaIngreso' => $user->fecha_juramentacion ?? now()->toDateString(),
                'Apuntes' => 'Creado automáticamente al actualizar usuario'
            ]);
        } else {
            // Actualizar el rol si cambió
            if ($user->isDirty() && $user->roles()->exists()) {
                $miembroExistente->update([
                    'Rol' => $user->getRoleNames()->first() ?? 'Socio',
                    'FechaIngreso' => $user->fecha_juramentacion ?? $miembroExistente->FechaIngreso,
                ]);
            }
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        // Opcional: Eliminar el registro de miembro cuando se elimina el usuario
        // Miembro::where('user_id', $user->id)->delete();
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        // Opcional: Eliminar el registro de miembro cuando se elimina permanentemente
        // Miembro::where('user_id', $user->id)->forceDelete();
    }
}
