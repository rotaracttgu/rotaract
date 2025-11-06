<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Models\Reunion;
use App\Models\CartaPatrocinio;
use App\Models\CartaFormal;
use App\Models\AsistenciaReunion;
use App\Models\ParticipacionProyecto;
use App\Models\Notificacion;
use App\Models\User;
use App\Services\NotificacionService;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProyectosExport;

class PresidenteController extends Controller
{
    // *** 1. PANEL PRINCIPAL (DASHBOARD) ***

    /**
     * Muestra el panel principal (Dashboard) del presidente.
     */
    public function dashboard()
    {
        // Obtener proyectos desde el módulo Vocero
        $totalProyectos = Proyecto::count();
        $proyectosActivos = Proyecto::whereNotNull('FechaInicio')
                                   ->whereNull('FechaFin')
                                   ->count();

        // Obtener reuniones próximas desde el calendario
        $proximasReuniones = Reunion::where('fecha_hora', '>=', now())
            ->whereIn('estado', ['Programada', 'En Curso'])
            ->orderBy('fecha_hora')
            ->limit(5)
            ->get();

        // Cartas pendientes
        $cartasPendientes = CartaPatrocinio::where('estado', 'Pendiente')->count();

        // Reuniones hoy
        $reunionesHoy = Reunion::whereDate('fecha_hora', today())->count();

        // Estadísticas adicionales para gráficas
        $datosActividad = $this->obtenerDatosActividadMensual();

        $datos = [
            'totalProyectos' => $totalProyectos,
            'proyectosActivos' => $proyectosActivos,
            'proximasReuniones' => $proximasReuniones,
            'cartasPendientes' => $cartasPendientes,
            'reunionesHoy' => $reunionesHoy,
            'datosActividad' => $datosActividad,
        ];

        return view('modulos.presidente.dashboard', $datos);
    }

    /**
     * Obtener datos de actividad mensual para la gráfica
     */
    private function obtenerDatosActividadMensual()
    {
        $meses = [];
        $proyectosPorMes = [];
        $reunionesPorMes = [];

        for ($i = 5; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $meses[] = $fecha->format('M');

            // Contar proyectos iniciados en ese mes
            $proyectosPorMes[] = Proyecto::whereYear('FechaInicio', $fecha->year)
                                        ->whereMonth('FechaInicio', $fecha->month)
                                        ->count();

            // Contar reuniones en ese mes
            $reunionesPorMes[] = Reunion::whereYear('fecha_hora', $fecha->year)
                                        ->whereMonth('fecha_hora', $fecha->month)
                                        ->count();
        }

        return [
            'meses' => $meses,
            'proyectos' => $proyectosPorMes,
            'reuniones' => $reunionesPorMes,
        ];
    }

    /**
    // ============================================================================
    // API - GESTIÓN DE EVENTOS DEL CALENDARIO (INTEGRADO CON VOCERO)
    // ============================================================================

    /**
     * Obtener todos los eventos del calendario
     */
    public function obtenerEventos()
    {
        try {
            $eventos = DB::select('CALL sp_obtener_todos_eventos()');
            
            // Formatear eventos para FullCalendar
            $eventosFormateados = array_map(function($evento) {
                return $this->formatearEvento($evento);
            }, $eventos);
            
            return response()->json($eventosFormateados);
            
        } catch (\Exception $e) {
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
            
        } catch (\Exception $e) {
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
                'titulo' => 'required|string|max:100',
                'descripcion' => 'nullable|string',
                'tipo_evento' => 'required|in:reunion-virtual,reunion-presencial,inicio-proyecto,finalizar-proyecto',
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
                
                // 🆕 ENVIAR NOTIFICACIONES A TODOS LOS USUARIOS
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
            
        } catch (\Exception $e) {
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
                'titulo' => 'required|string|max:100',
                'descripcion' => 'nullable|string',
                'tipo_evento' => 'required|in:reunion-virtual,reunion-presencial,inicio-proyecto,finalizar-proyecto',
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
            
            // 🆕 ENVIAR NOTIFICACIONES DE ACTUALIZACIÓN
            $this->enviarNotificacionEvento($validated, 'actualizado');
            
            return response()->json([
                'success' => true,
                'mensaje' => $output[0]->mensaje,
                'evento' => $this->formatearEvento($evento[0])
            ]);
            
        } catch (\Exception $e) {
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
            
        } catch (\Exception $e) {
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
            
            $output = DB::select('SELECT @mensaje as mensaje');
            
            return response()->json([
                'success' => true,
                'mensaje' => $output[0]->mensaje
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al actualizar fechas',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener asistencias de un evento específico
     */
    public function obtenerAsistenciasEvento($eventoId)
    {
        try {
            $asistencias = DB::select('CALL sp_obtener_asistencias_evento(?)', [$eventoId]);
            
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
            
        } catch (\Exception $e) {
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
            
        } catch (\Exception $e) {
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
            
        } catch (\Exception $e) {
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
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al eliminar asistencia',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    // ============================================================================
    // MÉTODOS PRIVADOS - FORMATEO Y CONVERSIÓN
    // ============================================================================

    /**
     * Formatear evento para FullCalendar
     */
    private function formatearEvento($evento)
    {
        $tipoEvento = $this->convertirTipoEventoDesdeDB($evento->TipoEvento);
        $estado = $this->convertirEstadoDesdeDB($evento->EstadoEvento);
        
        $colores = [
            'reunion-virtual' => '#3b82f6',
            'reunion-presencial' => '#10b981',
            'inicio-proyecto' => '#f59e0b',
            'finalizar-proyecto' => '#ef4444'
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
    private function convertirTipoEvento($tipo)
    {
        $conversion = [
            'reunion-virtual' => 'Virtual',
            'reunion-presencial' => 'Presencial',
            'inicio-proyecto' => 'InicioProyecto',
            'finalizar-proyecto' => 'FinProyecto'
        ];
        
        return $conversion[$tipo] ?? $tipo;
    }

    /**
     * Convertir tipo de evento de BD a formato de vista
     */
    private function convertirTipoEventoDesdeDB($tipo)
    {
        $conversion = [
            'Virtual' => 'reunion-virtual',
            'Presencial' => 'reunion-presencial',
            'InicioProyecto' => 'inicio-proyecto',
            'FinProyecto' => 'finalizar-proyecto',
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
    private function convertirEstado($estado)
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
    private function convertirEstadoDesdeDB($estado)
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
     * 🆕 ENVIAR NOTIFICACIONES DE EVENTOS A TODOS LOS USUARIOS
     */
    private function enviarNotificacionEvento($eventoData, $accion = 'creado')
    {
        try {
            $notificacionService = app(NotificacionService::class);
            
            // Obtener todos los usuarios con roles relevantes
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
                'finalizar-proyecto' => 'Finalización de Proyecto'
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
            
            // 🆕 Crear notificaciones con URL específica según el rol del usuario
            foreach ($usuarios as $usuarioId) {
                $usuario = User::find($usuarioId);
                if (!$usuario) continue;
                
                // Determinar la URL correcta según el rol del usuario (redirigir al dashboard)
                $urlCalendario = null;
                if ($usuario->hasRole('Presidente')) {
                    $urlCalendario = route('presidente.dashboard');
                } elseif ($usuario->hasRole('Vicepresidente')) {
                    $urlCalendario = route('vicepresidente.dashboard');
                } elseif ($usuario->hasRole('Secretaria')) {
                    $urlCalendario = route('secretaria.dashboard');
                } elseif ($usuario->hasRole('Vocero')) {
                    $urlCalendario = route('vocero.dashboard');
                } elseif ($usuario->hasRole(['Admin', 'Super Admin'])) {
                    $urlCalendario = route('admin.dashboard');
                } else {
                    $urlCalendario = route('presidente.dashboard'); // Fallback
                }
                
                $notificacionService->crear(
                    $usuarioId,
                    $tipo,
                    $titulo,
                    $mensaje,
                    $urlCalendario
                );
            }
            
        } catch (\Exception $e) {
            // Log error pero no interrumpir la creación del evento
            \Log::error('Error al enviar notificaciones de evento: ' . $e->getMessage());
        }
    }

    /**
     * Convertir estado de asistencia de formato de vista a BD
     */
    private function convertirEstadoAsistencia($estado)
    {
        $conversion = [
            'presente' => 'Presente',
            'ausente' => 'Ausente',
            'justificado' => 'Justificado'
        ];
        
        return $conversion[$estado] ?? $estado;
    }

    /**
     * Convertir estado de asistencia de BD a formato de vista
     */
    private function convertirEstadoAsistenciaDesdeDB($estado)
    {
        $conversion = [
            'Presente' => 'presente',
            'Ausente' => 'ausente',
            'Justificado' => 'justificado'
        ];
        
        return $conversion[$estado] ?? strtolower($estado);
    }

    /**
     * Muestra el centro de notificaciones.
     */
    public function notificaciones()
    {
        $notificacionService = app(NotificacionService::class);
        
        // Obtener todas las notificaciones del usuario actual
        $notificaciones = $notificacionService->obtenerTodas(auth()->id(), 50);
        
        // Contar notificaciones no leídas
        $noLeidas = $notificaciones->where('leida', false)->count();
        
        return view('modulos.presidente.notificaciones', compact('notificaciones', 'noLeidas'));
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

    // *** 2. CARTAS FORMALES ***

    /**
     * Muestra la vista para gestionar y generar cartas formales.
     */
    public function cartasFormales()
    {
        $cartas = CartaFormal::with('usuario')
                             ->orderBy('created_at', 'desc')
                             ->get();

        $estadisticas = [
            'total' => $cartas->count(),
            'borradores' => $cartas->where('estado', 'Borrador')->count(),
            'enviadas' => $cartas->where('estado', 'Enviada')->count(),
            'recibidas' => $cartas->where('estado', 'Recibida')->count(),
        ];

        return view('modulos.presidente.cartas-formales', compact('cartas', 'estadisticas'));
    }

    // *** 3. CARTAS DE PATROCINIO ***

    /**
     * Muestra la vista para gestionar y generar cartas de patrocinio.
     */
    public function cartasPatrocinio()
    {
        $cartas = CartaPatrocinio::with(['proyecto', 'usuario'])
                                 ->orderBy('fecha_solicitud', 'desc')
                                 ->get();

        $estadisticas = [
            'total' => $cartas->count(),
            'pendientes' => $cartas->where('estado', 'Pendiente')->count(),
            'aprobadas' => $cartas->where('estado', 'Aprobada')->count(),
            'rechazadas' => $cartas->where('estado', 'Rechazada')->count(),
            'montoTotal' => $cartas->where('estado', 'Aprobada')->sum('monto_solicitado'),
        ];

        // Obtener lista de proyectos para los dropdowns
        $proyectos = Proyecto::orderBy('Nombre')->get();

        return view('modulos.presidente.cartas-patrocinio', compact('cartas', 'estadisticas', 'proyectos'));
    }

    // *** 4. ESTADO DE PROYECTOS ***

    /**
     * Muestra el estado y seguimiento de todos los proyectos.
     */
    public function estadoProyectos()
    {
        $proyectos = Proyecto::with(['responsable', 'participaciones', 'cartasPatrocinio'])
                             ->get();

        // Calcular estadísticas por proyecto
        foreach ($proyectos as $proyecto) {
            $proyecto->total_participantes = $proyecto->participaciones->count();
            $proyecto->horas_totales = $proyecto->participaciones->sum('horas_dedicadas');
            $proyecto->monto_patrocinio = $proyecto->cartasPatrocinio()
                                                   ->where('estado', 'Aprobada')
                                                   ->sum('monto_solicitado');
        }

        $estadisticas = [
            'total' => $proyectos->count(),
            'enPlanificacion' => $proyectos->whereNull('FechaInicio')->count(),
            'enEjecucion' => $proyectos->whereNotNull('FechaInicio')->whereNull('FechaFin')->count(),
            'finalizados' => $proyectos->whereNotNull('FechaFin')->count(),
            'cancelados' => 0,
        ];

        return view('modulos.presidente.estado-proyectos', compact('proyectos', 'estadisticas'));
    }

    /**
     * Exportar proyectos a PDF o Excel
     */
    public function exportarProyectos(Request $request)
    {
        $formato = $request->input('formato', 'pdf'); // pdf o excel
        
        $proyectos = Proyecto::with(['responsable', 'participaciones', 'cartasPatrocinio'])
                             ->get();

        // Calcular estadísticas por proyecto
        foreach ($proyectos as $proyecto) {
            $proyecto->total_participantes = $proyecto->participaciones->count();
            $proyecto->horas_totales = $proyecto->participaciones->sum('horas_dedicadas');
            $proyecto->monto_patrocinio = $proyecto->cartasPatrocinio()
                                                   ->where('estado', 'Aprobada')
                                                   ->sum('monto_solicitado');
        }

        if ($formato === 'excel') {
            return $this->exportarProyectosExcel($proyectos);
        } else {
            return $this->exportarProyectosPDF($proyectos);
        }
    }

    /**
     * Exportar proyectos a PDF
     */
    private function exportarProyectosPDF($proyectos)
    {
        $pdf = Pdf::loadView('modulos.presidente.exports.proyectos-pdf', compact('proyectos'));
        return $pdf->download('proyectos-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Exportar proyectos a Excel
     */
    private function exportarProyectosExcel($proyectos)
    {
        // Preparar datos para Excel
        $datos = [];
        foreach ($proyectos as $proyecto) {
            $datos[] = [
                'ID' => $proyecto->ProyectoID,
                'Nombre' => $proyecto->Nombre,
                'Descripción' => $proyecto->Descripcion ?? '',
                'Fecha Inicio' => $proyecto->FechaInicio ? $proyecto->FechaInicio->format('d/m/Y') : 'N/A',
                'Fecha Fin' => $proyecto->FechaFin ? $proyecto->FechaFin->format('d/m/Y') : 'En curso',
                'Estado' => $proyecto->EstadoProyecto ?? $proyecto->Estatus,
                'Presupuesto' => '$' . number_format($proyecto->Presupuesto ?? 0, 2),
                'Tipo' => $proyecto->TipoProyecto ?? 'N/A',
                'Responsable' => $proyecto->responsable ? $proyecto->responsable->Nombre . ' ' . $proyecto->responsable->Apellido : 'N/A',
                'Participantes' => $proyecto->total_participantes ?? 0,
                'Horas Totales' => $proyecto->horas_totales ?? 0,
                'Monto Patrocinio' => '$' . number_format($proyecto->monto_patrocinio ?? 0, 2),
            ];
        }

        // Crear archivo Excel simple
        $filename = 'proyectos-' . now()->format('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'r+');
        
        // Escribir encabezados
        fputcsv($handle, array_keys($datos[0] ?? []));
        
        // Escribir datos
        foreach ($datos as $row) {
            fputcsv($handle, $row);
        }
        
        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Obtener detalles completos de un proyecto
     */
    public function detallesProyecto($id)
    {
        $proyecto = Proyecto::with([
            'responsable',
            'participaciones.usuario',
            'cartasPatrocinio'
        ])->findOrFail($id);

        // Calcular estadísticas
        $proyecto->total_participantes = $proyecto->participaciones->count();
        $proyecto->horas_totales = $proyecto->participaciones->sum('horas_dedicadas');
        $proyecto->monto_patrocinio = $proyecto->cartasPatrocinio()
                                               ->where('estado', 'Aprobada')
                                               ->sum('monto_solicitado');

        return response()->json($proyecto);
    }

    // *** 7. CRUD CARTAS FORMALES ***

    /**
     * Muestra los detalles de una carta formal.
     */
    public function showCartaFormal($id)
    {
        $carta = CartaFormal::with('usuario')->findOrFail($id);
        return response()->json($carta);
    }

    /**
     * Almacena una nueva carta formal.
     */
    public function storeCartaFormal(Request $request)
    {
        $validated = $request->validate([
            'numero_carta' => 'required|string|max:50|unique:carta_formals,numero_carta',
            'destinatario' => 'required|string|max:255',
            'asunto' => 'required|string|max:255',
            'contenido' => 'required|string',
            'tipo' => 'required|in:Invitacion,Agradecimiento,Solicitud,Notificacion,Otro',
            'estado' => 'nullable|in:Borrador,Enviada,Recibida',
            'fecha_envio' => 'nullable|date',
            'observaciones' => 'nullable|string',
        ]);

        $validated['usuario_id'] = auth()->id();
        $validated['estado'] = $validated['estado'] ?? 'Borrador';

        CartaFormal::create($validated);

        return redirect()->route('presidente.cartas.formales')
                        ->with('success', 'Carta formal creada exitosamente.');
    }

    /**
     * Actualiza una carta formal existente.
     */
    public function updateCartaFormal(Request $request, $id)
    {
        $carta = CartaFormal::findOrFail($id);

        $validated = $request->validate([
            'numero_carta' => 'required|string|max:50|unique:carta_formals,numero_carta,' . $id,
            'destinatario' => 'required|string|max:255',
            'asunto' => 'required|string|max:255',
            'contenido' => 'required|string',
            'tipo' => 'required|in:Invitacion,Agradecimiento,Solicitud,Notificacion,Otro',
            'estado' => 'nullable|in:Borrador,Enviada,Recibida',
            'fecha_envio' => 'nullable|date',
            'observaciones' => 'nullable|string',
        ]);

        $carta->update($validated);

        return redirect()->route('presidente.cartas.formales')
                        ->with('success', 'Carta formal actualizada exitosamente.');
    }

    /**
     * Elimina una carta formal.
     */
    public function destroyCartaFormal($id)
    {
        $carta = CartaFormal::findOrFail($id);
        $carta->delete();

        return redirect()->route('presidente.cartas.formales')
                        ->with('success', 'Carta formal eliminada exitosamente.');
    }

    // *** 8. CRUD CARTAS DE PATROCINIO ***

    /**
     * Muestra los detalles de una carta de patrocinio.
     */
    public function showCartaPatrocinio($id)
    {
        $carta = CartaPatrocinio::with(['proyecto', 'usuario'])->findOrFail($id);
        return response()->json($carta);
    }

    /**
     * Almacena una nueva carta de patrocinio.
     */
    public function storeCartaPatrocinio(Request $request)
    {
        $validated = $request->validate([
            'numero_carta' => 'required|string|max:50|unique:carta_patrocinios,numero_carta',
            'destinatario' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'monto_solicitado' => 'required|numeric|min:0',
            'estado' => 'nullable|in:Pendiente,Aprobada,Rechazada,En Revision',
            'fecha_solicitud' => 'nullable|date',
            'fecha_respuesta' => 'nullable|date',
            'proyecto_id' => 'required|exists:proyectos,ProyectoID',
            'observaciones' => 'nullable|string',
        ]);

        $validated['usuario_id'] = auth()->id();
        $validated['estado'] = $validated['estado'] ?? 'Pendiente';

        CartaPatrocinio::create($validated);

        return redirect()->route('presidente.cartas.patrocinio')
                        ->with('success', 'Carta de patrocinio creada exitosamente.');
    }

    /**
     * Actualiza una carta de patrocinio existente.
     */
    public function updateCartaPatrocinio(Request $request, $id)
    {
        $carta = CartaPatrocinio::findOrFail($id);

        $validated = $request->validate([
            'numero_carta' => 'required|string|max:50|unique:carta_patrocinios,numero_carta,' . $id,
            'destinatario' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'monto_solicitado' => 'required|numeric|min:0',
            'estado' => 'nullable|in:Pendiente,Aprobada,Rechazada,En Revision',
            'fecha_solicitud' => 'nullable|date',
            'fecha_respuesta' => 'nullable|date',
            'proyecto_id' => 'required|exists:proyectos,ProyectoID',
            'observaciones' => 'nullable|string',
        ]);

        $carta->update($validated);

        return redirect()->route('presidente.cartas.patrocinio')
                        ->with('success', 'Carta de patrocinio actualizada exitosamente.');
    }

    /**
     * Elimina una carta de patrocinio.
     */
    public function destroyCartaPatrocinio($id)
    {
        $carta = CartaPatrocinio::findOrFail($id);
        $carta->delete();

        return redirect()->route('presidente.cartas.patrocinio')
                        ->with('success', 'Carta de patrocinio eliminada exitosamente.');
    }

    // *** 9. EXPORTACIÓN DE CARTAS ***

    /**
     * Exportar carta formal a PDF
     */
    public function exportarCartaFormalPDF($id)
    {
        $carta = CartaFormal::with('usuario')->findOrFail($id);
        
        $pdf = Pdf::loadView('modulos.presidente.exports.carta-formal-pdf', compact('carta'));
        $pdf->setPaper('letter');
        
        $filename = 'carta-formal-' . $carta->numero_carta . '-' . now()->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Exportar carta de patrocinio a PDF
     */
    public function exportarCartaPatrocinioPDF($id)
    {
        $carta = CartaPatrocinio::with(['proyecto', 'usuario'])->findOrFail($id);
        
        $pdf = Pdf::loadView('modulos.presidente.exports.carta-patrocinio-pdf', compact('carta'));
        $pdf->setPaper('letter');
        
        $filename = 'carta-patrocinio-' . $carta->numero_carta . '-' . now()->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Exportar todas las cartas formales a Excel
     */
    public function exportarCartasFormalesExcel()
    {
        $cartas = CartaFormal::with('usuario')->orderBy('created_at', 'desc')->get();
        
        $datos = [];
        foreach ($cartas as $carta) {
            $datos[] = [
                'Número Carta' => $carta->numero_carta,
                'Destinatario' => $carta->destinatario,
                'Asunto' => $carta->asunto,
                'Tipo' => $carta->tipo,
                'Estado' => $carta->estado,
                'Fecha Envío' => $carta->fecha_envio ? $carta->fecha_envio->format('d/m/Y') : 'N/A',
                'Creado Por' => $carta->usuario ? $carta->usuario->name : 'N/A',
                'Fecha Creación' => $carta->created_at->format('d/m/Y H:i')
            ];
        }
        
        $filename = 'cartas-formales-' . now()->format('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'r+');
        
        if (!empty($datos)) {
            fputcsv($handle, array_keys($datos[0]));
            foreach ($datos as $row) {
                fputcsv($handle, $row);
            }
        }
        
        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Content-Transfer-Encoding', 'binary');
    }

    /**
     * Exportar todas las cartas de patrocinio a Excel
     */
    public function exportarCartasPatrocinioExcel()
    {
        $cartas = CartaPatrocinio::with(['proyecto', 'usuario'])->orderBy('fecha_solicitud', 'desc')->get();
        
        $datos = [];
        foreach ($cartas as $carta) {
            $datos[] = [
                'Número Carta' => $carta->numero_carta,
                'Destinatario' => $carta->destinatario,
                'Proyecto' => $carta->proyecto ? $carta->proyecto->Nombre : 'N/A',
                'Monto Solicitado' => '$' . number_format($carta->monto_solicitado, 2),
                'Estado' => $carta->estado,
                'Fecha Solicitud' => $carta->fecha_solicitud ? $carta->fecha_solicitud->format('d/m/Y') : 'N/A',
                'Fecha Respuesta' => $carta->fecha_respuesta ? $carta->fecha_respuesta->format('d/m/Y') : 'N/A',
                'Creado Por' => $carta->usuario ? $carta->usuario->name : 'N/A',
                'Fecha Creación' => $carta->created_at->format('d/m/Y H:i')
            ];
        }
        
        $filename = 'cartas-patrocinio-' . now()->format('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'r+');
        
        if (!empty($datos)) {
            fputcsv($handle, array_keys($datos[0]));
            foreach ($datos as $row) {
                fputcsv($handle, $row);
            }
        }
        
        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Content-Transfer-Encoding', 'binary');
    }
}
