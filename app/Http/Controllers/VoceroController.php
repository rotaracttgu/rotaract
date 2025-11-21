<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ManagesCalendarEvents;
use App\Traits\ManagesAttendance;
use App\Traits\ManagesNotifications;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Exception;

/**
 * VoceroController - VERSIÓN REFACTORIZADA
 *
 * Este controlador ahora usa Traits para eliminar código duplicado.
 * Pasó de ~1240 líneas a ~300 líneas (75% menos código!)
 */
class VoceroController extends Controller
{
    use AuthorizesRequests;
    use ManagesCalendarEvents;      // Gestión de eventos del calendario
    use ManagesAttendance;           // Gestión de asistencias
    use ManagesNotifications;        // Gestión de notificaciones

    // ============================================================================
    // VISTAS DEL MÓDULO VOCERO
    // ============================================================================

    /**
     * Vista principal/bienvenida del módulo vocero
     */
    public function index()
    {
        $this->authorize('eventos.ver');
        return view('modulos.vocero.vocero');
    }

    /**
     * Vista de bienvenida específica
     */
    public function welcome()
    {
        $this->authorize('eventos.ver');
        return view('modulos.vocero.welcome');
    }

    /**
     * Vista del calendario
     */
    public function calendario()
    {
        $this->authorize('eventos.ver');
        return view('modulos.vocero.calendario');
    }

    /**
     * Vista del dashboard
     */
    public function dashboard()
    {
        $this->authorize('eventos.ver');
        return view('modulos.vocero.dashboard');
    }

    /**
     * Vista de gestión de asistencias
     */
    public function gestionAsistencias()
    {
        $this->authorize('asistencias.ver');
        return view('modulos.vocero.gestion-asistencias');
    }

    /**
     * Vista de gestión de eventos
     */
    public function gestionEventos()
    {
        $this->authorize('eventos.ver');
        return view('modulos.vocero.gestion-eventos');
    }

    /**
     * Vista de reportes y análisis
     */
    public function reportesAnalisis()
    {
        $this->authorize('reportes.ver');
        return view('modulos.vocero.reportes-analisis');
    }

    // ============================================================================
    // IMPLEMENTACIÓN DE MÉTODOS ABSTRACTOS DE LOS TRAITS
    // ============================================================================

    /**
     * Vista de notificaciones para Vocero
     */
    protected function getNotificationsView(): string
    {
        return 'modulos.vocero.notificaciones';
    }

    // ============================================================================
    // API - REPORTES Y ESTADÍSTICAS (ESPECÍFICO DEL VOCERO)
    // ============================================================================

    /**
     * Obtener estadísticas generales de eventos
     */
    public function obtenerEstadisticasGenerales()
    {
        $this->authorize('reportes.ver');
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
        $this->authorize('reportes.ver');
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
        $this->authorize('reportes.ver');
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
        $this->authorize('reportes.ver');
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
        $this->authorize('eventos.ver');
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
        $this->authorize('reportes.ver');
        try {
            $statsGenerales = DB::select('CALL sp_generar_reporte_general_eventos()');
            $reporteDetallado = DB::select('CALL sp_generar_reporte_detallado_eventos()');

            $totalOtros = DB::table('calendarios')
                ->where('TipoEvento', 'Otros')
                ->count();

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
                    'otros' => $totalOtros
                ],
                'asistencias' => [],
                'tendencia' => []
            ];

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

                $fecha = new \DateTime($evento->FechaInicio);
                $mes = $fecha->format('Y-m');

                if (!isset($datosGraficos['tendencia'][$mes])) {
                    $datosGraficos['tendencia'][$mes] = 0;
                }
                $datosGraficos['tendencia'][$mes]++;
            }

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
}
