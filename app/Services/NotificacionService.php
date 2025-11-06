<?php

namespace App\Services;

use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Support\Collection;

class NotificacionService
{
    /**
     * Crear una notificación para un usuario específico
     */
    public function crear(int $usuarioId, string $tipo, string $titulo, string $mensaje, ?string $url = null, ?int $relacionadoId = null, ?string $relacionadoTipo = null): Notificacion
    {
        $config = $this->getConfiguracionPorTipo($tipo);
        
        return Notificacion::create([
            'usuario_id' => $usuarioId,
            'tipo' => $tipo,
            'titulo' => $titulo,
            'mensaje' => $mensaje,
            'icono' => $config['icono'],
            'color' => $config['color'],
            'url' => $url,
            'relacionado_id' => $relacionadoId,
            'relacionado_tipo' => $relacionadoTipo,
        ]);
    }

    /**
     * Crear notificaciones para múltiples usuarios
     */
    public function crearParaMultiples(array $usuariosIds, string $tipo, string $titulo, string $mensaje, ?string $url = null, ?int $relacionadoId = null, ?string $relacionadoTipo = null): Collection
    {
        $notificaciones = collect();
        
        foreach ($usuariosIds as $usuarioId) {
            $notificaciones->push(
                $this->crear($usuarioId, $tipo, $titulo, $mensaje, $url, $relacionadoId, $relacionadoTipo)
            );
        }
        
        return $notificaciones;
    }

    /**
     * Notificar creación de reunión
     */
    public function notificarReunionCreada($reunion, array $usuariosIds = []): void
    {
        if (empty($usuariosIds)) {
            $usuariosIds = User::whereHas('roles')->pluck('id')->toArray();
        }

        $fechaFormateada = \Carbon\Carbon::parse($reunion->fecha_hora ?? $reunion->fecha)->format('d/m/Y H:i');
        
        $this->crearParaMultiples(
            $usuariosIds,
            'reunion_creada',
            'Nueva Reunión Programada',
            "Se ha programado una nueva reunión: {$reunion->titulo} el {$fechaFormateada}",
            route('vicepresidente.calendario'),
            $reunion->id,
            'reunion'
        );
    }

    /**
     * Notificar creación de proyecto
     */
    public function notificarProyectoCreado($proyecto, array $usuariosIds = []): void
    {
        if (empty($usuariosIds)) {
            $usuariosIds = User::role(['Vicepresidente', 'Presidente', 'Vocero'])->pluck('id')->toArray();
        }

        $this->crearParaMultiples(
            $usuariosIds,
            'proyecto_creado',
            'Nuevo Proyecto Creado',
            "Se ha creado el proyecto: {$proyecto->Nombre}",
            route('vicepresidente.estado.proyectos'),
            $proyecto->ProyectoID,
            'proyecto'
        );
    }

    /**
     * Notificar finalización de proyecto
     */
    public function notificarProyectoFinalizado($proyecto, array $usuariosIds = []): void
    {
        if (empty($usuariosIds)) {
            $usuariosIds = User::role(['Vicepresidente', 'Presidente', 'Vocero'])->pluck('id')->toArray();
        }

        $this->crearParaMultiples(
            $usuariosIds,
            'proyecto_finalizado',
            'Proyecto Finalizado',
            "El proyecto {$proyecto->Nombre} ha sido finalizado exitosamente",
            route('vicepresidente.estado.proyectos'),
            $proyecto->ProyectoID,
            'proyecto'
        );
    }

    /**
     * Notificar carta pendiente
     */
    public function notificarCartaPendiente($carta, $tipoModulo = 'vicepresidente'): void
    {
        $usuariosIds = User::role(['Vicepresidente', 'Presidente'])->pluck('id')->toArray();
        
        $tipo = get_class($carta);
        $titulo = strpos($tipo, 'CartaPatrocinio') !== false ? 'Carta de Patrocinio Pendiente' : 'Carta Formal Pendiente';
        $mensaje = strpos($tipo, 'CartaPatrocinio') !== false 
            ? "Tiene una carta de patrocinio pendiente de revisión" 
            : "Tiene una carta formal pendiente de revisión";
        
        $url = strpos($tipo, 'CartaPatrocinio') !== false 
            ? route('vicepresidente.cartas.patrocinio')
            : route('vicepresidente.cartas.formales');

        $this->crearParaMultiples(
            $usuariosIds,
            'carta_pendiente',
            $titulo,
            $mensaje,
            $url,
            $carta->id,
            'carta'
        );
    }

    /**
     * Obtener notificaciones no leídas de un usuario
     */
    public function obtenerNoLeidas(int $usuarioId): Collection
    {
        return Notificacion::delUsuario($usuarioId)
            ->noLeidas()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Obtener todas las notificaciones de un usuario
     */
    public function obtenerTodas(int $usuarioId, int $limite = 20): Collection
    {
        return Notificacion::delUsuario($usuarioId)
            ->orderBy('created_at', 'desc')
            ->limit($limite)
            ->get();
    }

    /**
     * Marcar notificación como leída
     */
    public function marcarComoLeida(int $notificacionId): bool
    {
        $notificacion = Notificacion::find($notificacionId);
        
        if ($notificacion) {
            $notificacion->marcarComoLeida();
            return true;
        }
        
        return false;
    }

    /**
     * Marcar todas las notificaciones de un usuario como leídas
     */
    public function marcarTodasComoLeidas(int $usuarioId): void
    {
        Notificacion::delUsuario($usuarioId)
            ->noLeidas()
            ->update([
                'leida' => true,
                'leida_en' => now(),
            ]);
    }

    /**
     * Configuración de iconos y colores por tipo de notificación
     */
    private function getConfiguracionPorTipo(string $tipo): array
    {
        $configuraciones = [
            'reunion_creada' => [
                'icono' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                'color' => 'blue',
            ],
            'proyecto_creado' => [
                'icono' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                'color' => 'green',
            ],
            'proyecto_finalizado' => [
                'icono' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                'color' => 'purple',
            ],
            'carta_pendiente' => [
                'icono' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                'color' => 'orange',
            ],
            'default' => [
                'icono' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'color' => 'gray',
            ],
        ];

        return $configuraciones[$tipo] ?? $configuraciones['default'];
    }
}
