<?php

namespace App\Traits;

use App\Models\Proyecto;
use App\Models\Reunion;
use App\Models\CartaPatrocinio;
use App\Models\CartaFormal;

/**
 * Trait ManagesDashboard
 *
 * Maneja la lógica compartida del dashboard
 */
trait ManagesDashboard
{
    /**
     * Muestra el panel principal (Dashboard)
     */
    public function dashboard()
    {
        $this->authorize('dashboard.ver');

        $totalProyectos = Proyecto::count();
        $proyectosActivos = Proyecto::whereNotNull('FechaInicio')
                                   ->whereNull('FechaFin')
                                   ->count();

        $proximasReuniones = Reunion::where('fecha_hora', '>=', now())
            ->whereIn('estado', ['Programada', 'En Curso'])
            ->orderBy('fecha_hora')
            ->limit(5)
            ->get();

        $cartasPatrocinioPendientes = CartaPatrocinio::where('estado', 'Pendiente')->count();
        $cartasFormalesPendientes = CartaFormal::where('estado', 'Pendiente')->count();
        $cartasPendientes = $cartasPatrocinioPendientes + $cartasFormalesPendientes;

        $reunionesHoy = Reunion::whereDate('fecha_hora', today())->count();

        $datosActividad = $this->obtenerDatosActividadMensual();

        $datos = [
            'totalProyectos' => $totalProyectos,
            'proyectosActivos' => $proyectosActivos,
            'proximasReuniones' => $proximasReuniones,
            'cartasPendientes' => $cartasPendientes,
            'reunionesHoy' => $reunionesHoy,
            'datosActividad' => $datosActividad,
        ];

        $vista = $this->getDashboardView();
        return view($vista, $datos);
    }

    /**
     * Obtener datos de actividad mensual para la gráfica
     */
    protected function obtenerDatosActividadMensual()
    {
        $meses = [];
        $proyectosPorMes = [];
        $reunionesPorMes = [];

        for ($i = 5; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $meses[] = $fecha->format('M');

            $proyectosPorMes[] = Proyecto::whereYear('FechaInicio', $fecha->year)
                                        ->whereMonth('FechaInicio', $fecha->month)
                                        ->count();

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
     * Obtener la vista del dashboard según el controlador
     */
    abstract protected function getDashboardView(): string;
}
