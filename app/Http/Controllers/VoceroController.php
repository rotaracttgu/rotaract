<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificacionService;
use App\Models\Reunion;
use App\Models\User;
use Exception;

class VoceroController extends Controller
{
    // ============================================================================
    // VISTAS DEL MÓDULO VOCERO
    // ============================================================================
    
    // Vista principal/bienvenida del módulo vocero
    public function index()
    {
        return view('modulos.vocero.vocero');
    }

    // Vista de bienvenida específica
    public function welcome()
    {
        return view('modulos.vocero.welcome');
    }

    // Vista del calendario
    public function calendario()
    {
        return view('modulos.vocero.calendario');
    }

    // Vista del dashboard
    public function dashboard()
    {
        return view('modulos.vocero.dashboard');
    }

    // Vista de gestión de asistencias
    public function gestionAsistencias()
    {
        return view('modulos.vocero.gestion-asistencias');
    }

    // Vista de gestión de eventos
    public function gestionEventos()
    {
        return view('modulos.vocero.gestion-eventos');
    }

    // Vista de reportes y análisis
    public function reportesAnalisis()
    {
        return view('modulos.vocero.reportes-analisis');
    }

    /**
     * Muestra el centro de notificaciones
     */
    public function notificaciones()
    {
        // Auto-marcar todas las notificaciones como leídas al entrar
        \App\Models\Notificacion::where('usuario_id', auth()->id())
            ->where('leida', false)
            ->update(['leida' => true, 'leida_en' => now()]);

        $notificacionService = app(NotificacionService::class);
        
        // Obtener todas las notificaciones del usuario actual
        $notificaciones = $notificacionService->obtenerTodas(auth()->id(), 50);
        
        // Contar notificaciones no leídas (ahora será 0)
        $noLeidas = 0;
        
        return view('modulos.vocero.notificaciones', compact('notificaciones', 'noLeidas'));
    }

    /**
     * Marcar una notificación como leída
     */
    public function marcarNotificacionLeida($id)
    {
        $notificacionService = app(NotificacionService::class);
        $notificacionService->marcarComoLeida($id);
        
        return response()->json(['success' => true]);
    }

    /**
     * Marcar todas las notificaciones como leídas
     */
    public function marcarTodasNotificacionesLeidas()
    {
        $notificacionService = app(NotificacionService::class);
        $notificacionService->marcarTodasComoLeidas(auth()->id());
        
        return response()->json(['success' => true]);
    }

    // ============================================================================
    // API - GESTIÓN DE EVENTOS DEL CALENDARIO
    // ============================================================================

    /**
     * Obtener todos los eventos del calendario
     */
    public function obtenerEventos()
    {
        try {
            // Obtener eventos directamente desde la tabla calendarios
            $eventos = DB::table('calendarios')
                ->select(
                    'CalendarioID',
                    'TituloEvento',
                    'Descripcion',
                    'TipoEvento',
                    'EstadoEvento',
                    'FechaInicio',
                    'FechaFin',
                    'HoraInicio',
                    'HoraFin',
                    'Ubicacion',
                    'OrganizadorID',
                    'ProyectoID'
                )
                ->orderBy('FechaInicio', 'desc')
                ->get();
            
            // Formatear eventos para FullCalendar
            $eventosFormateados = $eventos->map(function($evento) {
                // Determinar color según tipo
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
                        'proyecto_id' => $evento->ProyectoID
                    ]
                ];
            });
            
            return response()->json($eventosFormateados);
            
        } catch (Exception $e) {
            \Log::error('Error al obtener eventos en Vocero: ' . $e->getMessage());
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
            // Consulta ajustada según tu estructura de tabla
            $miembros = DB::select('
                SELECT 
                    MiembroID, 
                    Nombre, 
                    Rol,
                    CONCAT(Nombre, " - ", Rol) as NombreCompleto
                FROM miembros 
                ORDER BY Nombre ASC
            ');
            
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
            // Validar datos - 🆕 AGREGADO "otros" en la validación
            $validated = $request->validate([
                'titulo' => 'required|string|max:100',
                'descripcion' => 'nullable|string',
                'tipo_evento' => 'required|in:reunion-virtual,reunion-presencial,inicio-proyecto,finalizar-proyecto,otros',
                'estado' => 'required|in:programado,en-curso,finalizado',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after:fecha_inicio',
                'organizador_id' => 'nullable|integer',
                'proyecto_id' => 'nullable|integer',
                'detalles' => 'nullable|array'
            ]);

            // Convertir tipo de evento al formato de la base de datos
            $tipoEventoDB = $this->convertirTipoEvento($validated['tipo_evento']);
            
            // Convertir estado al formato de la base de datos
            $estadoDB = $this->convertirEstado($validated['estado']);
            
            // Extraer fecha y hora
            $fechaInicio = date('Y-m-d H:i:s', strtotime($validated['fecha_inicio']));
            $fechaFin = date('Y-m-d H:i:s', strtotime($validated['fecha_fin']));
            $horaInicio = date('H:i:s', strtotime($validated['fecha_inicio']));
            $horaFin = date('H:i:s', strtotime($validated['fecha_fin']));
            
            // Determinar ubicación según el tipo de evento
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
            
            // Ejecutar procedimiento almacenado
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
            
            // Obtener los valores de salida
            $output = DB::select('SELECT @calendario_id as calendario_id, @mensaje as mensaje');
            
            if ($output[0]->calendario_id) {
                // Obtener el evento recién creado
                $evento = DB::select('CALL sp_obtener_detalle_evento(?)', [$output[0]->calendario_id]);
                
                // 🔔 ENVIAR NOTIFICACIONES según el tipo de evento
                if (in_array($validated['tipo_evento'], ['reunion-virtual', 'reunion-presencial'])) {
                    $this->enviarNotificacionReunion($evento[0], $validated);
                } elseif ($validated['tipo_evento'] === 'inicio-proyecto' && isset($validated['proyecto_id'])) {
                    $this->enviarNotificacionProyectoCreado($validated['proyecto_id'], $validated['titulo']);
                } elseif ($validated['tipo_evento'] === 'finalizar-proyecto' && isset($validated['proyecto_id'])) {
                    $this->enviarNotificacionProyectoFinalizado($validated['proyecto_id'], $validated['titulo']);
                }
                
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
            // Validar datos - 🆕 AGREGADO "otros" en la validación
            $validated = $request->validate([
                'titulo' => 'required|string|max:100',
                'descripcion' => 'nullable|string',
                'tipo_evento' => 'required|in:reunion-virtual,reunion-presencial,inicio-proyecto,finalizar-proyecto,otros',
                'estado' => 'required|in:programado,en-curso,finalizado',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after:fecha_inicio',
                'organizador_id' => 'nullable|integer',
                'proyecto_id' => 'nullable|integer',
                'detalles' => 'nullable|array'
            ]);

            // Convertir tipo de evento al formato de la base de datos
            $tipoEventoDB = $this->convertirTipoEvento($validated['tipo_evento']);
            
            // Convertir estado al formato de la base de datos
            $estadoDB = $this->convertirEstado($validated['estado']);
            
            // Extraer fecha y hora
            $fechaInicio = date('Y-m-d H:i:s', strtotime($validated['fecha_inicio']));
            $fechaFin = date('Y-m-d H:i:s', strtotime($validated['fecha_fin']));
            $horaInicio = date('H:i:s', strtotime($validated['fecha_inicio']));
            $horaFin = date('H:i:s', strtotime($validated['fecha_fin']));
            
            // Determinar ubicación según el tipo de evento
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
            
            // Ejecutar procedimiento almacenado
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
            
            // Obtener el mensaje de salida
            $output = DB::select('SELECT @mensaje as mensaje');
            
            // Obtener el evento actualizado
            $evento = DB::select('CALL sp_obtener_detalle_evento(?)', [$id]);
            
            // Enviar notificación de actualización de evento
            $notificacionService = app(\App\Services\NotificacionService::class);
            $notificacionService->crearParaMultiples(
                User::pluck('id')->toArray(),
                'evento_actualizado',
                'Evento Actualizado',
                "El evento \"{$validated['titulo']}\" ha sido actualizado",
                route('vocero.calendario'),
                $id,
                'evento'
            );
            
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
            // Obtener datos del evento antes de eliminarlo para la notificación
            $evento = DB::select('CALL sp_obtener_detalle_evento(?)', [$id]);
            
            // Ejecutar procedimiento almacenado
            DB::select('CALL sp_eliminar_evento(?, @mensaje)', [$id]);
            
            // Obtener el mensaje de salida
            $output = DB::select('SELECT @mensaje as mensaje');
            
            // Enviar notificación de eliminación de evento
            if (!empty($evento)) {
                $notificacionService = app(\App\Services\NotificacionService::class);
                $notificacionService->crearParaMultiples(
                    User::pluck('id')->toArray(),
                    'evento_eliminado',
                    'Evento Eliminado',
                    "El evento \"{$evento[0]->TituloEvento}\" ha sido eliminado",
                    route('vocero.calendario'),
                    $id,
                    'evento'
                );
            }
            
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

            // Obtener el evento actual para mantener sus datos
            $eventoActual = DB::select('CALL sp_obtener_detalle_evento(?)', [$id]);
            
            if (empty($eventoActual)) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Evento no encontrado'
                ], 404);
            }

            $evento = $eventoActual[0];
            $fechaAnterior = $evento->FechaInicio;
            
            // Extraer fecha y hora
            $fechaInicio = date('Y-m-d H:i:s', strtotime($validated['fecha_inicio']));
            $fechaFin = date('Y-m-d H:i:s', strtotime($validated['fecha_fin']));
            $horaInicio = date('H:i:s', strtotime($validated['fecha_inicio']));
            $horaFin = date('H:i:s', strtotime($validated['fecha_fin']));
            
            // Actualizar evento manteniendo los demás datos
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
            $notificacionService = app(\App\Services\NotificacionService::class);
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

    // ============================================================================
    // 🆕 API - GESTIÓN DE ASISTENCIAS
    // ============================================================================

    /**
     * Obtener asistencias de un evento específico
     */
    public function obtenerAsistenciasEvento($eventoId)
    {
        try {
            $asistencias = DB::select('CALL sp_obtener_asistencias_evento(?)', [$eventoId]);
            
            // Formatear asistencias para la vista
            $asistenciasFormateadas = array_map(function($asistencia) use ($eventoId) {
                return [
                    'id' => $asistencia->AsistenciaID,
                    'member_id' => $asistencia->MiembroID,
                    'event_id' => $eventoId,
                    'name' => $asistencia->NombreParticipante,
                    'email' => $asistencia->Gmail,
                    'dni' => $asistencia->DNI_Pasaporte,
                    'status' => $this->convertirEstadoAsistenciaDesdeDB($asistencia->EstadoAsistencia),
                    'arrival_time' => $asistencia->HoraLlegada,
                    'minutes_late' => $asistencia->MinutosTarde ?? 0,
                    'notes' => $asistencia->Observacion,
                    'registration_date' => $asistencia->FechaRegistro
                ];
            }, $asistencias);
            
            return response()->json([
                'success' => true,
                'asistencias' => $asistenciasFormateadas
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener asistencias',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Registrar nueva asistencia
     */
    public function registrarAsistencia(Request $request)
    {
        try {
            $validated = $request->validate([
                'member_id' => 'required|integer',
                'event_id' => 'required|integer',
                'status' => 'required|in:presente,ausente,justificado',
                'arrival_time' => 'nullable|date_format:H:i:s',
                'minutes_late' => 'nullable|integer|min:0',
                'notes' => 'nullable|string'
            ]);

            $estadoDB = $this->convertirEstadoAsistencia($validated['status']);
            
            DB::select('CALL sp_registrar_asistencia(?, ?, ?, ?, ?, ?, @asistencia_id, @mensaje)', [
                $validated['member_id'],
                $validated['event_id'],
                $estadoDB,
                $validated['arrival_time'] ?? null,
                $validated['minutes_late'] ?? 0,
                $validated['notes'] ?? null
            ]);
            
            $output = DB::select('SELECT @asistencia_id as asistencia_id, @mensaje as mensaje');
            
            if ($output[0]->asistencia_id) {
                return response()->json([
                    'success' => true,
                    'mensaje' => $output[0]->mensaje,
                    'asistencia_id' => $output[0]->asistencia_id
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
                'error' => 'Error al registrar asistencia',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar asistencia existente
     */
    public function actualizarAsistencia(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:presente,ausente,justificado',
                'arrival_time' => 'nullable|date_format:H:i:s',
                'minutes_late' => 'nullable|integer|min:0',
                'notes' => 'nullable|string'
            ]);

            $estadoDB = $this->convertirEstadoAsistencia($validated['status']);
            
            DB::select('CALL sp_actualizar_asistencia(?, ?, ?, ?, ?, @mensaje)', [
                $id,
                $estadoDB,
                $validated['arrival_time'] ?? null,
                $validated['minutes_late'] ?? 0,
                $validated['notes'] ?? null
            ]);
            
            $output = DB::select('SELECT @mensaje as mensaje');
            
            return response()->json([
                'success' => true,
                'mensaje' => $output[0]->mensaje
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al actualizar asistencia',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar asistencia
     */
    public function eliminarAsistencia($id)
    {
        try {
            DB::select('CALL sp_eliminar_asistencia(?, @mensaje)', [$id]);
            
            $output = DB::select('SELECT @mensaje as mensaje');
            
            return response()->json([
                'success' => true,
                'mensaje' => $output[0]->mensaje
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al eliminar asistencia',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    // ============================================================================
    // MÉTODOS PRIVADOS - FORMATEO Y CONVERSIÓN (EVENTOS)
    // ============================================================================

    /**
     * Formatear evento para FullCalendar
     */
    private function formatearEvento($evento)
    {
        // Convertir tipo de evento de DB a formato de vista
        $tipoEvento = $this->convertirTipoEventoDesdeDB($evento->TipoEvento);
        
        // Convertir estado de DB a formato de vista
        $estado = $this->convertirEstadoDesdeDB($evento->EstadoEvento);
        
        // Determinar color según tipo - 🆕 AGREGADO COLOR PARA "otros"
        $colores = [
            'reunion-virtual' => '#3b82f6',
            'reunion-presencial' => '#10b981',
            'inicio-proyecto' => '#f59e0b',
            'finalizar-proyecto' => '#ef4444',
            'otros' => '#8b5cf6'  // 🆕 Color púrpura para "Otros"
        ];
        
        // Preparar detalles
        $detalles = [
            'organizador' => $evento->NombreOrganizador ?? 'Sin Organizador'
        ];
        
        if ($tipoEvento === 'reunion-virtual') {
            $detalles['enlace'] = $evento->Ubicacion ?? '';
        } elseif ($tipoEvento === 'reunion-presencial') {
            $detalles['lugar'] = $evento->Ubicacion ?? '';
        } elseif ($tipoEvento === 'otros') {  // 🆕 AGREGADO MANEJO PARA "otros"
            $detalles['ubicacion_otros'] = $evento->Ubicacion ?? '';
        } else {
            $detalles['ubicacion_proyecto'] = $evento->Ubicacion ?? '';
        }
        
        return [
            'id' => $evento->CalendarioID,
            'title' => $evento->TituloEvento,
            'start' => $evento->FechaInicio,
            'end' => $evento->FechaFin,
            'backgroundColor' => $colores[$tipoEvento] ?? '#6b7280',
            'borderColor' => $colores[$tipoEvento] ?? '#6b7280',
            'extendedProps' => [
                'tipo_evento' => $tipoEvento,
                'estado' => $estado,
                'organizador' => $evento->NombreOrganizador ?? 'Sin Organizador',
                'organizador_id' => $evento->OrganizadorID ?? null,
                'proyecto_id' => $evento->ProyectoID ?? null,
                'detalles' => $detalles
            ]
        ];
    }

    /**
     * Convertir tipo de evento de vista a DB
     * 🆕 AGREGADO MAPEO PARA "otros"
     */
    private function convertirTipoEvento($tipo)
    {
        $mapa = [
            'reunion-virtual' => 'Virtual',
            'reunion-presencial' => 'Presencial',
            'inicio-proyecto' => 'InicioProyecto',
            'finalizar-proyecto' => 'FinProyecto',
            'otros' => 'Otros'  // 🆕 AGREGADO
        ];
        
        return $mapa[$tipo] ?? 'Virtual';
    }

    /**
     * Convertir tipo de evento de DB a vista
     * 🆕 AGREGADO MAPEO PARA "Otros"
     */
    private function convertirTipoEventoDesdeDB($tipo)
    {
        $mapa = [
            'Virtual' => 'reunion-virtual',
            'Presencial' => 'reunion-presencial',
            'InicioProyecto' => 'inicio-proyecto',
            'FinProyecto' => 'finalizar-proyecto',
            'Otros' => 'otros'  // 🆕 AGREGADO
        ];
        
        return $mapa[$tipo] ?? 'reunion-virtual';
    }

    /**
     * Convertir estado de vista a DB
     */
    private function convertirEstado($estado)
    {
        $mapa = [
            'programado' => 'Programado',
            'en-curso' => 'EnCurso',
            'finalizado' => 'Finalizado'
        ];
        
        return $mapa[$estado] ?? 'Programado';
    }

    /**
     * Convertir estado de DB a vista
     */
    private function convertirEstadoDesdeDB($estado)
    {
        $mapa = [
            'Programado' => 'programado',
            'EnCurso' => 'en-curso',
            'Finalizado' => 'finalizado'
        ];
        
        return $mapa[$estado] ?? 'programado';
    }

    // ============================================================================
    // 🆕 MÉTODOS PRIVADOS - FORMATEO Y CONVERSIÓN (ASISTENCIAS)
    // ============================================================================

    /**
     * Convertir estado de asistencia de vista a DB
     */
    private function convertirEstadoAsistencia($estado)
    {
        $mapa = [
            'presente' => 'Presente',
            'ausente' => 'Ausente',
            'justificado' => 'Justificado'
        ];
        
        return $mapa[$estado] ?? 'Ausente';
    }

    /**
     * Convertir estado de asistencia de DB a vista
     */
    private function convertirEstadoAsistenciaDesdeDB($estado)
    {
        $mapa = [
            'Presente' => 'presente',
            'Ausente' => 'ausente',
            'Justificado' => 'justificado'
        ];
        
        return $mapa[$estado] ?? 'ausente';
    }

    // ============================================================================
    // 🆕 API - REPORTES Y ESTADÍSTICAS
    // ============================================================================

    /**
     * Obtener estadísticas generales de eventos
     */
    public function obtenerEstadisticasGenerales()
    {
        try {
            $stats = DB::select('CALL sp_generar_reporte_general_eventos()');
            
            if (empty($stats)) {
                return response()->json([
                    'success' => true,
                    'estadisticas' => [
                        'TotalEventos' => 0,
                        'TotalVirtual' => 0,
                        'TotalPresencial' => 0,
                        'TotalInicioProyecto' => 0,
                        'TotalFinProyecto' => 0,
                        'TotalProgramados' => 0,
                        'TotalEnCurso' => 0,
                        'TotalFinalizados' => 0
                    ]
                ]);
            }
            
            return response()->json([
                'success' => true,
                'estadisticas' => $stats[0]
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener estadísticas generales',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener reporte detallado de todos los eventos
     */
    public function obtenerReporteDetallado()
    {
        try {
            $eventos = DB::select('CALL sp_generar_reporte_detallado_eventos()');
            
            return response()->json([
                'success' => true,
                'eventos' => $eventos
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener reporte detallado',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener reporte de un evento específico
     */
    public function obtenerReporteEvento($eventoId)
    {
        try {
            $reporte = DB::select('CALL sp_generar_reporte_evento(?)', [$eventoId]);
            
            if (empty($reporte)) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Evento no encontrado'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'reporte' => $reporte[0]
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener reporte del evento',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estadísticas de asistencia por miembro
     */
    public function obtenerEstadisticasMiembro($miembroId)
    {
        try {
            $stats = DB::select('CALL sp_estadisticas_asistencia_miembro(?)', [$miembroId]);
            
            if (empty($stats)) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'Miembro no encontrado'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'estadisticas' => $stats[0]
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener estadísticas del miembro',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Buscar eventos por rango de fechas
     */
    public function buscarEventosPorFecha(Request $request)
    {
        try {
            $validated = $request->validate([
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
            ]);
            
            $eventos = DB::select('CALL sp_buscar_eventos_por_fecha(?, ?)', [
                $validated['fecha_inicio'],
                $validated['fecha_fin']
            ]);
            
            return response()->json([
                'success' => true,
                'eventos' => $eventos
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al buscar eventos por fecha',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener datos para gráficos de reportes
     */
    public function obtenerDatosGraficos()
    {
        try {
            // Obtener estadísticas generales
            $statsGenerales = DB::select('CALL sp_generar_reporte_general_eventos()');
            
            // Obtener reporte detallado
            $reporteDetallado = DB::select('CALL sp_generar_reporte_detallado_eventos()');
            
            // 🆕 Contar eventos tipo "Otros" manualmente
            $totalOtros = DB::table('calendarios')
                ->where('TipoEvento', 'Otros')
                ->count();
            
            // Preparar datos para gráficos
            $datosGraficos = [
                'estados' => [
                    'programados' => $statsGenerales[0]->TotalProgramados ?? 0,
                    'en_curso' => $statsGenerales[0]->TotalEnCurso ?? 0,
                    'finalizados' => $statsGenerales[0]->TotalFinalizados ?? 0
                ],
                'tipos' => [
                    'virtual' => $statsGenerales[0]->TotalVirtual ?? 0,
                    'presencial' => $statsGenerales[0]->TotalPresencial ?? 0,
                    'inicio_proyecto' => $statsGenerales[0]->TotalInicioProyecto ?? 0,
                    'fin_proyecto' => $statsGenerales[0]->TotalFinProyecto ?? 0,
                    'otros' => $totalOtros  // 🆕 AGREGADO
                ],
                'asistencias' => [],
                'tendencia' => []
            ];
            
            // Procesar datos de asistencias por evento
            foreach ($reporteDetallado as $evento) {
                if ($evento->TotalAsistencias > 0) {
                    $datosGraficos['asistencias'][] = [
                        'titulo' => $evento->TituloEvento,
                        'presentes' => $evento->TotalPresentes ?? 0,
                        'ausentes' => $evento->TotalAusentes ?? 0,
                        'justificados' => $evento->TotalJustificados ?? 0,
                        'porcentaje' => $evento->PorcentajeAsistencia ?? 0
                    ];
                }
                
                // Agregar datos de tendencia (eventos por mes)
                $fecha = new \DateTime($evento->FechaInicio);
                $mes = $fecha->format('Y-m');
                
                if (!isset($datosGraficos['tendencia'][$mes])) {
                    $datosGraficos['tendencia'][$mes] = 0;
                }
                $datosGraficos['tendencia'][$mes]++;
            }
            
            // Convertir tendencia a array ordenado
            ksort($datosGraficos['tendencia']);
            $tendenciaArray = [];
            foreach ($datosGraficos['tendencia'] as $mes => $cantidad) {
                $tendenciaArray[] = [
                    'mes' => $mes,
                    'cantidad' => $cantidad
                ];
            }
            $datosGraficos['tendencia'] = $tendenciaArray;
            
            return response()->json([
                'success' => true,
                'graficos' => $datosGraficos,
                'estadisticas_generales' => $statsGenerales[0] ?? null
            ]);
            
                    
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener datos para gráficos',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    // ============================================================================
    // NOTIFICACIONES
    // ============================================================================

    /**
     * Enviar notificación cuando se crea una reunión
     */
    private function enviarNotificacionReunion($evento, $validated)
    {
        try {
            $notificacionService = app(NotificacionService::class);
            
            // Obtener todos los usuarios con roles relevantes (Vicepresidente, Secretaría, Presidente, etc.)
            $usuariosNotificar = User::whereHas('roles', function($query) {
                $query->whereIn('name', ['Vicepresidente', 'Secretaria', 'Presidente', 'Super Admin']);
            })->pluck('id')->toArray();
            
            // Crear objeto similar a Reunion para el servicio
            $reunionData = (object)[
                'id' => $evento->CalendarioID ?? null,
                'titulo' => $validated['titulo'],
                'fecha_hora' => $validated['fecha_inicio'],
                'tipo' => $validated['tipo_evento'] === 'reunion-virtual' ? 'Virtual' : 'Presencial',
            ];
            
            // Enviar notificación
            $notificacionService->notificarReunionCreada($reunionData, $usuariosNotificar);
            
        } catch (Exception $e) {
            // Log del error pero no detener la ejecución
            \Log::error('Error al enviar notificación de reunión: ' . $e->getMessage());
        }
    }

    /**
     * Enviar notificación cuando se crea un proyecto
     */
    private function enviarNotificacionProyectoCreado($proyectoId, $titulo)
    {
        try {
            $notificacionService = app(NotificacionService::class);
            
            // Obtener todos los usuarios con roles relevantes
            $usuariosNotificar = User::whereHas('roles', function($query) {
                $query->whereIn('name', ['Vicepresidente', 'Vocero', 'Presidente', 'Super Admin']);
            })->pluck('id')->toArray();
            
            // Crear objeto para el servicio
            $proyectoData = (object)[
                'ProyectoID' => $proyectoId,
                'NombreProyecto' => $titulo,
            ];
            
            // Enviar notificación
            $notificacionService->notificarProyectoCreado($proyectoData, $usuariosNotificar);
            
        } catch (Exception $e) {
            \Log::error('Error al enviar notificación de proyecto: ' . $e->getMessage());
        }
    }

    /**
     * Enviar notificación cuando se finaliza un proyecto
     */
    private function enviarNotificacionProyectoFinalizado($proyectoId, $titulo)
    {
        try {
            $notificacionService = app(NotificacionService::class);
            
            // Obtener todos los usuarios con roles relevantes
            $usuariosNotificar = User::whereHas('roles', function($query) {
                $query->whereIn('name', ['Vicepresidente', 'Vocero', 'Presidente', 'Super Admin']);
            })->pluck('id')->toArray();
            
            // Crear objeto para el servicio
            $proyectoData = (object)[
                'ProyectoID' => $proyectoId,
                'NombreProyecto' => $titulo,
            ];
            
            // Enviar notificación
            $notificacionService->notificarProyectoFinalizado($proyectoData, $usuariosNotificar);
            
        } catch (Exception $e) {
            \Log::error('Error al enviar notificación de proyecto finalizado: ' . $e->getMessage());
        }
    }

    /**
     * Verificar actualizaciones para notificaciones en tiempo real
     */
    public function verificarActualizaciones()
    {
        try {
            $notificacionService = app(\App\Services\NotificacionService::class);
            $ultimasNotificaciones = $notificacionService->obtenerNoLeidas(Auth::id())
                ->take(1)
                ->get();
            
            if ($ultimasNotificaciones->isEmpty()) {
                return response()->json([
                    'hay_nuevas' => false,
                    'notificaciones' => [],
                    'success' => true,
                    'notificaciones_nuevas' => 0
                ]);
            }
            
            $notificacion = $ultimasNotificaciones->first();
            
            return response()->json([
                'success' => true,
                'notificaciones_nuevas' => $ultimasNotificaciones->count(),
                'ultima_notificacion' => [
                    'id' => $notificacion->id,
                    'titulo' => $notificacion->titulo,
                    'mensaje' => $notificacion->mensaje,
                    'icono' => $notificacion->icono ?? 'fa-bell',
                    'color' => $notificacion->color ?? 'blue',
                    'url' => $notificacion->url ?? '#',
                    'created_at' => $notificacion->created_at->diffForHumans()
                ],
                'timestamp' => now()->timestamp
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error verificando notificaciones en Vocero: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'notificaciones_nuevas' => 0,
                'mensaje' => 'Error al verificar actualizaciones'
            ], 500);
        }
    }

    /**
     * Obtener detalle de un evento sin usar stored procedure
     */
    private function obtenerDetalleEvento($calendarioId)
    {
        return DB::table('calendarios as c')
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
                DB::raw('COALESCE(m.Nombre, "Sin Organizador") as NombreOrganizador'),
                'm.Correo as CorreoOrganizador',
                'c.ProyectoID',
                'p.Nombre as NombreProyecto',
                'p.Descripcion as DescripcionProyecto'
            )
            ->where('c.CalendarioID', $calendarioId)
            ->first();
    }
}
