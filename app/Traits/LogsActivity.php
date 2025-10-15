<?php

namespace App\Traits;

use App\Models\BitacoraSistema;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Boot del trait - registra los eventos del modelo
     */
    protected static function bootLogsActivity()
    {
        // Evento: Después de crear
        static::created(function ($model) {
            $model->logActivity('created');
        });

        // Evento: Después de actualizar
        static::updated(function ($model) {
            $model->logActivity('updated');
        });

        // Evento: Después de eliminar
        static::deleted(function ($model) {
            $model->logActivity('deleted');
        });

        // Evento: Después de restaurar (soft deletes)
        if (method_exists(static::class, 'restored')) {
            static::restored(function ($model) {
                $model->logActivity('restored');
            });
        }
    }

    /**
     * Registrar la actividad en la bitácora
     */
    protected function logActivity($action)
    {
        try {
            // Obtener el nombre de la tabla
            $table = $this->getTable();
            
            // Obtener el ID del registro
            $recordId = $this->getKey();

            // Obtener usuario actual
            $user = Auth::user();

            // Determinar el módulo basado en el nombre de la tabla
            $modulo = $this->getModuleName();

            // Obtener descripción personalizada si existe
            $descripcion = method_exists($this, 'getActivityDescription')
                ? $this->getActivityDescription($action)
                : $this->getDefaultDescription($action);

            // Preparar datos anteriores y nuevos
            $datosAnteriores = null;
            $datosNuevos = null;

            if ($action === 'updated') {
                $datosAnteriores = $this->getOriginal();
                $datosNuevos = $this->getAttributes();
                
                // Remover campos sensibles
                if (property_exists($this, 'sensitiveAttributes')) {
                    foreach ($this->sensitiveAttributes as $attr) {
                        unset($datosAnteriores[$attr]);
                        unset($datosNuevos[$attr]);
                    }
                }
            } elseif ($action === 'created') {
                $datosNuevos = $this->getAttributes();
                
                // Remover campos sensibles
                if (property_exists($this, 'sensitiveAttributes')) {
                    foreach ($this->sensitiveAttributes as $attr) {
                        unset($datosNuevos[$attr]);
                    }
                }
            } elseif ($action === 'deleted') {
                $datosAnteriores = $this->getOriginal();
                
                // Remover campos sensibles
                if (property_exists($this, 'sensitiveAttributes')) {
                    foreach ($this->sensitiveAttributes as $attr) {
                        unset($datosAnteriores[$attr]);
                    }
                }
            }

            // Crear el registro en bitácora
            BitacoraSistema::registrar([
                'user_id' => $user?->id,
                'usuario_nombre' => $user?->name,
                'usuario_email' => $user?->email,
                'usuario_rol' => $user?->getRolPrincipal(),
                'accion' => $action,
                'modulo' => $modulo,
                'tabla' => $table,
                'registro_id' => $recordId,
                'descripcion' => $descripcion,
                'datos_anteriores' => $datosAnteriores,
                'datos_nuevos' => $datosNuevos,
                'estado' => 'exitoso',
            ]);

        } catch (\Exception $e) {
            // No interrumpir la ejecución si falla el logging
            \Log::error('Error en LogsActivity: ' . $e->getMessage());
        }
    }

    /**
     * Obtener el nombre del módulo basado en la tabla
     */
    protected function getModuleName()
    {
        $table = $this->getTable();
        
        $modulos = [
            'users' => 'usuarios',
            'miembros' => 'miembros',
            'proyectos' => 'proyectos',
            'reuniones' => 'reuniones',
            'asistencias' => 'asistencias',
            'documentos' => 'documentos',
            'movimientos' => 'finanzas',
            'pagos_membresia' => 'membresias',
        ];

        return $modulos[$table] ?? $table;
    }

    /**
     * Obtener descripción por defecto
     */
    protected function getDefaultDescription($action)
    {
        $table = $this->getTable();
        $id = $this->getKey();

        $descriptions = [
            'created' => "Nuevo registro creado en {$table} (ID: {$id})",
            'updated' => "Registro actualizado en {$table} (ID: {$id})",
            'deleted' => "Registro eliminado de {$table} (ID: {$id})",
            'restored' => "Registro restaurado en {$table} (ID: {$id})",
        ];

        return $descriptions[$action] ?? "Acción {$action} en {$table} (ID: {$id})";
    }
}