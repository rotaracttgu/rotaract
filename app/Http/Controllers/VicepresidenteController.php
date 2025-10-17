<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Models\Reunion;
use App\Models\CartaPatrocinio;
use App\Models\CartaFormal;
use App\Models\AsistenciaReunion;
use App\Models\ParticipacionProyecto;
use Illuminate\Support\Facades\DB;

class VicepresidenteController extends Controller
{
    // *** 1. PANEL PRINCIPAL (DASHBOARD) ***

    /**
     * Muestra el panel principal (Dashboard) del vicepresidente.
     */
    public function dashboard()
    {
        $datos = [
            'totalProyectos' => Proyecto::count(),
            'proyectosActivos' => Proyecto::whereNotNull('FechaInicio')->whereNull('FechaFin')->count(),
            'proximasReuniones' => Reunion::where('fecha_hora', '>=', now())
                                         ->where('estado', 'Programada')
                                         ->orderBy('fecha_hora')
                                         ->limit(5)
                                         ->get(),
            'cartasPendientes' => CartaPatrocinio::where('estado', 'Pendiente')->count(),
            'reunionesHoy' => Reunion::whereDate('fecha_hora', today())->count(),
        ];

        return view('modulos.vicepresidente.dashboard', $datos);
    }

    // *** 2. ASISTENCIA A PROYECTOS ***

    /**
     * Muestra la vista de asistencia y seguimiento de proyectos.
     */
    public function asistenciaProyectos()
    {
        $proyectos = Proyecto::with(['responsable', 'participaciones.usuario'])
                             ->orderBy('FechaInicio', 'desc')
                             ->get();

        return view('modulos.vicepresidente.asistencia-proyectos', compact('proyectos'));
    }

    // *** 3. ASISTENCIA A REUNIONES ***

    /**
     * Muestra la vista de registro y seguimiento de asistencia a reuniones.
     */
    public function asistenciaReuniones()
    {
        $reuniones = Reunion::with(['asistencias.usuario'])
                            ->orderBy('fecha_hora', 'desc')
                            ->get();

        // Calcular porcentaje de asistencia por reunión
        foreach ($reuniones as $reunion) {
            $totalRegistros = $reunion->asistencias->count();
            $totalAsistieron = $reunion->asistencias->where('asistio', true)->count();
            $reunion->porcentaje_asistencia = $totalRegistros > 0 
                ? round(($totalAsistieron / $totalRegistros) * 100, 1) 
                : 0;
        }

        return view('modulos.vicepresidente.asistencia-reuniones', compact('reuniones'));
    }

    // *** 4. CARTAS FORMALES ***

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

        return view('modulos.vicepresidente.cartas-formales', compact('cartas', 'estadisticas'));
    }

    // *** 5. CARTAS DE PATROCINIO ***

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

        return view('modulos.vicepresidente.cartas-patrocinio', compact('cartas', 'estadisticas'));
    }

    // *** 6. ESTADO DE PROYECTOS ***

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

        return view('modulos.vicepresidente.estado-proyectos', compact('proyectos', 'estadisticas'));
    }
}