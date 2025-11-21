<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\NotificacionService;
use App\Models\User;
use Exception;

/**
 * Trait ManagesCalendarEvents
 *
 * Maneja toda la lógica compartida de gestión de eventos del calendario
 * entre Presidente, Vicepresidente y Vocero
 */
trait ManagesCalendarEvents
{
    /**
     * Obtener todos los eventos del calendario
     */
    public function obtenerEventos()
    {
        try {
            $eventos = DB::table('calendarios as c')
                ->leftJoin('miembros as m', 'c.OrganizadorID', '=', 'm.MiembroID')
                ->leftJoin('proyectos as p', 'c.ProyectoID', '=', 'p.ProyectoID')
                ->select(
                    'c.CalendarioID',
                    'c.TituloEvento',
                    'c.Descripcion',
                    'c.TipoEvento',
                    'c.EstadoEvento',
                    'c.FechaInicio',
                    'c.FechaFin',
                    'c.HoraInicio',
                    'c.HoraFin',
                    'c.Ubicacion',
                    'c.OrganizadorID',
                    'c.ProyectoID',
                    DB::raw('COALESCE(m.Nombre, "Sin Organizador") as NombreOrganizador'),
                    'p.Nombre as NombreProyecto'
                )
                ->orderBy('c.FechaInicio', 'desc')
                ->get();

            $eventosFormateados = $eventos->map(function($evento) {
                $colores = [
                    'Virtual' => '#3b82f6',
                    'Presencial' => '#10b981',
                    'InicioProyecto' => '#f59e0b',
                    'FinProyecto' => '#ef4444',
                    'Otros' => '#8b5cf6'
                ];

                return [
                    'id' => $evento->CalendarioID,
                    'title' => $evento->TituloEvento,
                    'start' => $evento->FechaInicio,
                    'end' => $evento->FechaFin,
                    'backgroundColor' => $colores[$evento->TipoEvento] ?? '#6b7280',
                    'borderColor' => $colores[$evento->TipoEvento] ?? '#6b7280',
                    'extendedProps' => [
                        'descripcion' => $evento->Descripcion,
                        'tipo_evento' => $evento->TipoEvento,
                        'estado' => $evento->EstadoEvento,
                        'hora_inicio' => $evento->HoraInicio,
                        'hora_fin' => $evento->HoraFin,
                        'ubicacion' => $evento->Ubicacion,
                        'organizador_id' => $evento->OrganizadorID,
                        'proyecto_id' => $evento->ProyectoID,
                        'detalles' => [
                            'organizador' => $evento->NombreOrganizador ?? 'Sin Organizador',
                            'proyecto' => $evento->NombreProyecto ?? null
                        ]
                    ]
                ];
            });

            return response()->json($eventosFormateados);

        } catch (Exception $e) {
            \Log::error('Error al obtener eventos: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al obtener eventos',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener lista de miembros para el select
     */
    public function obtenerMiembros()
    {
        try {
            $miembros = \App\Models\Miembro::with('user')
                ->whereNotNull('user_id')
                ->get()
                ->map(function($miembro) {
                    return [
                        'MiembroID' => $miembro->MiembroID,
                        'Nombre' => $miembro->user->name ?? 'N/A',
                        'Rol' => $miembro->Rol,
                        'NombreCompleto' => ($miembro->user->name ?? 'N/A') . ' - ' . $miembro->Rol
                    ];
                });
            $miembros = $miembros->sortBy('Nombre')->values()->all();

            return response()->json([
                'success' => true,
                'miembros' => $miembros
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener miembros',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo evento
     */
    public function crearEvento(Request $request)
    {
        try {
            $validated = $request->validate([
                'titulo' => [
                    'required',
                    'string',
                    'max:100',
                    function ($attribute, $value, $fail) {
                        if (preg_match('/(.)\\1{2,}/', $value)) {
                            $fail('El título no puede contener más de 2 caracteres repetidos consecutivos.');
                        }
                    },
                ],
                'descripcion' => [
                    'nullable',
                    'string',
                    function ($attribute, $value, $fail) {
                        if ($value && preg_match('/(.)\\1{2,}/', $value)) {
                            $fail('La descripción no puede contener más de 2 caracteres repetidos consecutivos.');
                        }
                    },
                ],
                'tipo_evento' => 'required|in:reunion-virtual,reunion-presencial,inicio-proyecto,finalizar-proyecto,otros',
                'estado' => 'required|in:programado,en-curso,finalizado',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after:fecha_inicio',
                'organizador_id' => 'nullable|integer',
                'proyecto_id' => 'nullable|integer',
                'detalles' => 'nullable|array'
            ]);

            $tipoEventoDB = $this->convertirTipoEvento($validated['tipo_evento']);
            $estadoDB = $this->convertirEstado($validated['estado']);

            $fechaInicio = date('Y-m-d H:i:s', strtotime($validated['fecha_inicio']));
            $fechaFin = date('Y-m-d H:i:s', strtotime($validated['fecha_fin']));
            $horaInicio = date('H:i:s', strtotime($validated['fecha_inicio']));
            $horaFin = date('H:i:s', strtotime($validated['fecha_fin']));

            $ubicacion = '';
            if (isset($validated['detalles'])) {
                if (isset($validated['detalles']['enlace'])) {
                    $ubicacion = $validated['detalles']['enlace'];
                } elseif (isset($validated['detalles']['lugar'])) {
                    $ubicacion = $validated['detalles']['lugar'];
                } elseif (isset($validated['detalles']['ubicacion_proyecto'])) {
                    $ubicacion = $validated['detalles']['ubicacion_proyecto'];
                } elseif (isset($validated['detalles']['ubicacion_otros'])) {
                    $ubicacion = $validated['detalles']['ubicacion_otros'];
                }
            }

            DB::select('CALL sp_crear_evento_calendario(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @calendario_id, @mensaje)', [
                $validated['titulo'],
                $validated['descripcion'] ?? null,
                $tipoEventoDB,
                $estadoDB,
                $fechaInicio,
                $fechaFin,
                $horaInicio,
                $horaFin,
                $ubicacion,
                $validated['organizador_id'] ?? null,
                $validated['proyecto_id'] ?? null
            ]);

            $output = DB::select('SELECT @calendario_id as calendario_id, @mensaje as mensaje');

            if ($output[0]->calendario_id) {
                $evento = DB::select('CALL sp_obtener_detalle_evento(?)', [$output[0]->calendario_id]);

                // Enviar notificaciones
                $this->enviarNotificacionEvento($validated, 'creado');

                return response()->json([
                    'success' => true,
                    'mensaje' => $output[0]->mensaje,
                    'evento' => $this->formatearEvento($evento[0])
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'mensaje' => $output[0]->mensaje
                ], 400);
            }

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al crear evento',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un evento existente
     */
    public function actualizarEvento(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'titulo' => [
                    'required',
                    'string',
                    'max:100',
                    function ($attribute, $value, $fail) {
                        if (preg_match('/(.)\\1{2,}/', $value)) {
                            $fail('El título no puede contener más de 2 caracteres repetidos consecutivos.');
                        }
                    },
                ],
                'descripcion' => [
                    'nullable',
                    'string',
                    function ($attribute, $value, $fail) {
                        if ($value && preg_match('/(.)\\1{2,}/', $value)) {
                            $fail('La descripción no puede contener más de 2 caracteres repetidos consecutivos.');
                        }
                    },
                ],
                'tipo_evento' => 'required|in:reunion-virtual,reunion-presencial,inicio-proyecto,finalizar-proyecto,otros',
                'estado' => 'required|in:programado,en-curso,finalizado',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after:fecha_inicio',
                'organizador_id' => 'nullable|integer',
                'proyecto_id' => 'nullable|integer',
                'detalles' => 'nullable|array'
            ]);

            $tipoEventoDB = $this->convertirTipoEvento($validated['tipo_evento']);
            $estadoDB = $this->convertirEstado($validated['estado']);

            $fechaInicio = date('Y-m-d H:i:s', strtotime($validated['fecha_inicio']));
            $fechaFin = date('Y-m-d H:i:s', strtotime($validated['fecha_fin']));
            $horaInicio = date('H:i:s', strtotime($validated['fecha_inicio']));
            $horaFin = date('H:i:s', strtotime($validated['fecha_fin']));

            $ubicacion = '';
            if (isset($validated['detalles'])) {
                if (isset($validated['detalles']['enlace'])) {
                    $ubicacion = $validated['detalles']['enlace'];
                } elseif (isset($validated['detalles']['lugar'])) {
                    $ubicacion = $validated['detalles']['lugar'];
                } elseif (isset($validated['detalles']['ubicacion_proyecto'])) {
                    $ubicacion = $validated['detalles']['ubicacion_proyecto'];
                } elseif (isset($validated['detalles']['ubicacion_otros'])) {
                    $ubicacion = $validated['detalles']['ubicacion_otros'];
                }
            }

            DB::select('CALL sp_actualizar_evento(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @mensaje)', [
                $id,
                $validated['titulo'],
                $validated['descripcion'] ?? null,
                $tipoEventoDB,
                $estadoDB,
                $fechaInicio,
                $fechaFin,
                $horaInicio,
                $horaFin,
                $ubicacion,
                $validated['organizador_id'] ?? null,
                $validated['proyecto_id'] ?? null
            ]);

            $output = DB::select('SELECT @mensaje as mensaje');
            $evento = DB::select('CALL sp_obtener_detalle_evento(?)', [$id]);

            // Enviar notificaciones
            $this->enviarNotificacionEvento($validated, 'actualizado');

            return response()->json([
                'success' => true,
                'mensaje' => $output[0]->mensaje,
                'evento' => $this->formatearEvento($evento[0])
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al actualizar evento',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un evento
     */
    public function eliminarEvento($id)
    {
        try {
            DB::select('CALL sp_eliminar_evento(?, @mensaje)', [$id]);
            $output = DB::select('SELECT @mensaje as mensaje');

            return response()->json([
                'success' => true,
                'mensaje' => $output[0]->mensaje
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al eliminar evento',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar fechas de un evento (para drag & drop)
     */
    public function actualizarFechas(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after:fecha_inicio'
            ]);

            $eventoActual = DB::select('CALL sp_obtener_detalle_evento(?)', [$id]);

            if (empty($eventoActual)) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Evento no encontrado'
                ], 404);
            }

            $evento = $eventoActual[0];
            $fechaAnterior = $evento->FechaInicio;

            $fechaInicio = date('Y-m-d H:i:s', strtotime($validated['fecha_inicio']));
            $fechaFin = date('Y-m-d H:i:s', strtotime($validated['fecha_fin']));
            $horaInicio = date('H:i:s', strtotime($validated['fecha_inicio']));
            $horaFin = date('H:i:s', strtotime($validated['fecha_fin']));

            DB::select('CALL sp_actualizar_evento(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @mensaje)', [
                $id,
                $evento->TituloEvento,
                $evento->Descripcion,
                $evento->TipoEvento,
                $evento->EstadoEvento,
                $fechaInicio,
                $fechaFin,
                $horaInicio,
                $horaFin,
                $evento->Ubicacion,
                $evento->OrganizadorID,
                $evento->ProyectoID
            ]);

            // Enviar notificación de cambio de evento
            $notificacionService = app(NotificacionService::class);
            $notificacionService->notificarEventoRescheduleado($evento, $fechaAnterior, $fechaInicio);

            $output = DB::select('SELECT @mensaje as mensaje');

            return response()->json([
                'success' => true,
                'mensaje' => $output[0]->mensaje
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al actualizar fechas',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Formatear evento para FullCalendar
     */
    protected function formatearEvento($evento)
    {
        $tipoEvento = $this->convertirTipoEventoDesdeDB($evento->TipoEvento);
        $estado = $this->convertirEstadoDesdeDB($evento->EstadoEvento);

        $colores = [
            'reunion-virtual' => '#3b82f6',
            'reunion-presencial' => '#10b981',
            'inicio-proyecto' => '#f59e0b',
            'finalizar-proyecto' => '#ef4444',
            'otros' => '#8b5cf6'
        ];

        $detalles = [
            'organizador' => $evento->NombreOrganizador ?? 'Sin Organizador'
        ];

        if ($tipoEvento === 'reunion-virtual' || $tipoEvento === 'reunion-presencial') {
            $detalles['tipo_reunion'] = $tipoEvento === 'reunion-virtual' ? 'Virtual' : 'Presencial';
            $detalles['ubicacion'] = $evento->Ubicacion ?? '';
        } elseif ($tipoEvento === 'inicio-proyecto' || $tipoEvento === 'finalizar-proyecto') {
            $detalles['proyecto'] = $evento->NombreProyecto ?? 'Sin Proyecto';
            $detalles['tipo_accion'] = $tipoEvento === 'inicio-proyecto' ? 'Inicio' : 'Finalización';
        } elseif ($tipoEvento === 'otros') {
            $detalles['ubicacion_otros'] = $evento->Ubicacion ?? '';
        }

        return [
            'id' => $evento->CalendarioID,
            'title' => $evento->TituloEvento,
            'start' => $evento->FechaInicio,
            'end' => $evento->FechaFin,
            'backgroundColor' => $colores[$tipoEvento] ?? '#6b7280',
            'borderColor' => $colores[$tipoEvento] ?? '#6b7280',
            'textColor' => '#ffffff',
            'extendedProps' => [
                'descripcion' => $evento->Descripcion ?? '',
                'tipo_evento' => $tipoEvento,
                'estado' => $estado,
                'ubicacion' => $evento->Ubicacion ?? '',
                'organizador_id' => $evento->OrganizadorID,
                'proyecto_id' => $evento->ProyectoID,
                'detalles' => $detalles
            ]
        ];
    }

    /**
     * Convertir tipo de evento de formato de vista a BD
     */
    protected function convertirTipoEvento($tipo)
    {
        $conversion = [
            'reunion-virtual' => 'Virtual',
            'reunion-presencial' => 'Presencial',
            'inicio-proyecto' => 'InicioProyecto',
            'finalizar-proyecto' => 'FinProyecto',
            'otros' => 'Otros'
        ];

        return $conversion[$tipo] ?? $tipo;
    }

    /**
     * Convertir tipo de evento de BD a formato de vista
     */
    protected function convertirTipoEventoDesdeDB($tipo)
    {
        $conversion = [
            'Virtual' => 'reunion-virtual',
            'Presencial' => 'reunion-presencial',
            'InicioProyecto' => 'inicio-proyecto',
            'FinProyecto' => 'finalizar-proyecto',
            'Otros' => 'otros',
            // Mantener compatibilidad con formatos antiguos
            'Reunion Virtual' => 'reunion-virtual',
            'Reunion Presencial' => 'reunion-presencial',
            'Inicio Proyecto' => 'inicio-proyecto',
            'Finalizar Proyecto' => 'finalizar-proyecto'
        ];

        return $conversion[$tipo] ?? strtolower(str_replace(' ', '-', $tipo));
    }

    /**
     * Convertir estado de formato de vista a BD
     */
    protected function convertirEstado($estado)
    {
        $conversion = [
            'programado' => 'Programado',
            'en-curso' => 'EnCurso',
            'finalizado' => 'Finalizado'
        ];

        return $conversion[$estado] ?? $estado;
    }

    /**
     * Convertir estado de BD a formato de vista
     */
    protected function convertirEstadoDesdeDB($estado)
    {
        $conversion = [
            'Programado' => 'programado',
            'EnCurso' => 'en-curso',
            'Finalizado' => 'finalizado',
            // Mantener compatibilidad con formato antiguo
            'En Curso' => 'en-curso'
        ];

        return $conversion[$estado] ?? strtolower(str_replace(' ', '-', $estado));
    }

    /**
     * Enviar notificaciones de eventos a usuarios relevantes
     */
    protected function enviarNotificacionEvento($eventoData, $accion = 'creado')
    {
        try {
            $notificacionService = app(NotificacionService::class);

            $usuarios = User::whereHas('roles', function($query) {
                $query->whereIn('name', ['Presidente', 'Vicepresidente', 'Secretaria', 'Vocero', 'Admin', 'Super Admin']);
            })->pluck('id')->toArray();

            if (empty($usuarios)) {
                return;
            }

            $tiposEvento = [
                'reunion-virtual' => 'Reunión Virtual',
                'reunion-presencial' => 'Reunión Presencial',
                'inicio-proyecto' => 'Inicio de Proyecto',
                'finalizar-proyecto' => 'Finalización de Proyecto',
                'otros' => 'Evento'
            ];

            $tipoTexto = $tiposEvento[$eventoData['tipo_evento']] ?? 'Evento';
            $fechaFormateada = \Carbon\Carbon::parse($eventoData['fecha_inicio'])->format('d/m/Y H:i');

            $titulo = $accion === 'creado'
                ? "Nuevo {$tipoTexto} Programado"
                : "{$tipoTexto} Actualizado";

            $mensaje = $accion === 'creado'
                ? "Se ha programado: {$eventoData['titulo']} el {$fechaFormateada}"
                : "Se ha actualizado: {$eventoData['titulo']} para el {$fechaFormateada}";

            $tipo = strpos($eventoData['tipo_evento'], 'reunion') !== false ? 'reunion_creada' : 'evento_creado';

            foreach ($usuarios as $usuarioId) {
                $usuario = User::find($usuarioId);
                if (!$usuario) continue;

                $urlCalendario = $this->getDashboardRouteForUser($usuario);

                $notificacionService->crear(
                    $usuarioId,
                    $tipo,
                    $titulo,
                    $mensaje,
                    $urlCalendario
                );
            }

        } catch (Exception $e) {
            \Log::error('Error al enviar notificaciones de evento: ' . $e->getMessage());
        }
    }

    /**
     * Obtener ruta del dashboard según el rol del usuario
     */
    protected function getDashboardRouteForUser($usuario)
    {
        if ($usuario->hasRole('Presidente')) {
            return route('presidente.dashboard');
        } elseif ($usuario->hasRole('Vicepresidente')) {
            return route('vicepresidente.dashboard');
        } elseif ($usuario->hasRole('Secretaria')) {
            return route('secretaria.dashboard');
        } elseif ($usuario->hasRole('Vocero')) {
            return route('vocero.dashboard');
        } elseif ($usuario->hasRole(['Admin', 'Super Admin'])) {
            return route('admin.dashboard');
        }

        return route('dashboard'); // Fallback
    }
}
