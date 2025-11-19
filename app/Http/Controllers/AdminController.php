<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PresidenteController;
use App\Models\Proyecto;
use App\Models\Reunion;
use App\Models\CartaPatrocinio;
use App\Models\CartaFormal;
use App\Http\Requests\CartaPatrocinioRequest;
use App\Http\Requests\CartaFormalRequest;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    protected $presidenteController;

    public function __construct()
    {
        $this->presidenteController = new PresidenteController();
    }

    // ============================================================================
    // MÓDULO PRESIDENTE - Integrado en Admin
    // ============================================================================

    /**
     * Dashboard de Presidente desde el Admin
     */
    public function presidenteDashboard()
    {
        // Reutilizar la lógica del PresidenteController
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

        // Usar layout de admin en lugar del layout de presidente
        return view('modulos.admin.presidente.dashboard', $datos);
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
     * Cartas de Patrocinio desde el Admin
     */
    public function presidenteCartasPatrocinio()
    {
        // Delegar al PresidenteController pero con vista de admin
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
        
        $proyectos = Proyecto::orderBy('Nombre')->get();

        return view('modulos.admin.presidente.cartas-patrocinio', compact('cartas', 'estadisticas', 'proyectos'));
    }

    /**
     * Cartas Formales desde el Admin
     */
    public function presidenteCartasFormales()
    {
        $cartas = CartaFormal::orderBy('created_at', 'desc')->get();

        $estadisticas = [
            'total' => $cartas->count(),
            'enviadas' => $cartas->where('estado', 'Enviada')->count(),
            'borradores' => $cartas->where('estado', 'Borrador')->count(),
            'recibidas' => $cartas->where('estado', 'Recibida')->count(),
        ];

        return view('modulos.admin.presidente.cartas-formales', compact('cartas', 'estadisticas'));
    }

    /**
     * Estado de Proyectos desde el Admin
     */
    public function presidenteEstadoProyectos()
    {
        $proyectos = Proyecto::with(['participaciones.usuario'])
                    ->orderBy('FechaInicio', 'desc')
                    ->get();

        // Obtener lista de miembros para los dropdowns
        $miembros = DB::table('miembros')->orderBy('Nombre')->get();

        $estadisticas = [
            'total' => Proyecto::count(),
            'enPlanificacion' => Proyecto::whereNull('FechaInicio')->count(),
            'enEjecucion' => Proyecto::whereNotNull('FechaInicio')->whereNull('FechaFin')->count(),
            'finalizados' => Proyecto::whereNotNull('FechaFin')->count(),
            'cancelados' => Proyecto::where('Estatus', 'Cancelado')->count(),
        ];

        return view('modulos.admin.presidente.estado-proyectos', compact('proyectos', 'estadisticas', 'miembros'));
    }

    /**
     * Notificaciones desde el Admin
     */
    public function presidenteNotificaciones()
    {
        // Reutilizar método del PresidenteController
        return $this->presidenteController->notificaciones();
    }

    // ============================================================================
    // PROXY METHODS - Delegar operaciones CRUD al PresidenteController
    // ============================================================================

    /**
     * Proxy para mostrar carta formal (AJAX)
     */
    public function showCartaFormal($id)
    {
        $carta = CartaFormal::with('usuario')->findOrFail($id);
        return response()->json($carta);
    }

    /**
     * Proxy para crear carta formal
     */
    public function storeCartaFormal(CartaFormalRequest $request)
    {
        $result = $this->presidenteController->storeCartaFormal($request);
        
        // Si es JSON redirect, cambiar la ruta a admin
        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }
        
        return redirect()->route('admin.presidente.cartas.formales')->with('success', 'Carta formal creada exitosamente');
    }

    /**
     * Proxy para actualizar carta formal
     */
    public function updateCartaFormal(CartaFormalRequest $request, $id)
    {
        $result = $this->presidenteController->updateCartaFormal($request, $id);
        
        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }
        
        return redirect()->route('admin.presidente.cartas.formales')->with('success', 'Carta formal actualizada exitosamente');
    }

    /**
     * Proxy para eliminar carta formal
     */
    public function destroyCartaFormal($id)
    {
        return $this->presidenteController->destroyCartaFormal($id);
    }

    /**
     * Proxy para mostrar carta patrocinio (AJAX)
     */
    public function showCartaPatrocinio($id)
    {
        $carta = CartaPatrocinio::with(['proyecto', 'usuario'])->findOrFail($id);
        return response()->json($carta);
    }

    /**
     * Proxy para crear carta patrocinio
     */
    public function storeCartaPatrocinio(CartaPatrocinioRequest $request)
    {
        $result = $this->presidenteController->storeCartaPatrocinio($request);
        
        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }
        
        return redirect()->route('admin.presidente.cartas.patrocinio')->with('success', 'Carta de patrocinio creada exitosamente');
    }

    /**
     * Proxy para actualizar carta patrocinio
     */
    public function updateCartaPatrocinio(CartaPatrocinioRequest $request, $id)
    {
        $result = $this->presidenteController->updateCartaPatrocinio($request, $id);
        
        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }
        
        return redirect()->route('admin.presidente.cartas.patrocinio')->with('success', 'Carta de patrocinio actualizada exitosamente');
    }

    /**
     * Proxy para eliminar carta patrocinio
     */
    public function destroyCartaPatrocinio($id)
    {
        return $this->presidenteController->destroyCartaPatrocinio($id);
    }

    /**
     * Proxy para mostrar proyecto (AJAX)
     */
    public function showProyecto($id)
    {
        $proyecto = Proyecto::with(['participaciones.usuario'])->findOrFail($id);
        return response()->json($proyecto);
    }

    /**
     * Proxy para crear proyecto
     */
    public function storeProyecto(Request $request)
    {
        return $this->presidenteController->storeProyecto($request);
    }

    /**
     * Proxy para actualizar proyecto
     */
    public function updateProyecto(Request $request, $id)
    {
        return $this->presidenteController->updateProyecto($request, $id);
    }

    /**
     * Proxy para eliminar proyecto
     */
    public function destroyProyecto($id)
    {
        return $this->presidenteController->destroyProyecto($id);
    }

    /**
     * Proxy para exportar PDFs y otros
     */
    public function exportarCartaFormalPDF($id)
    {
        return $this->presidenteController->exportarCartaFormalPDF($id);
    }

    public function exportarCartaFormalWord($id)
    {
        return $this->presidenteController->exportarCartaFormalWord($id);
    }

    public function exportarCartaPatrocinioPDF($id)
    {
        return $this->presidenteController->exportarCartaPatrocinioPDF($id);
    }

    public function exportarCartaPatrocinioWord($id)
    {
        return $this->presidenteController->exportarCartaPatrocinioWord($id);
    }

    public function detallesProyecto($id)
    {
        return $this->presidenteController->detallesProyecto($id);
    }

    // ============================================================================
    // API CALENDARIO - Proxy methods
    // ============================================================================

    public function obtenerEventos()
    {
        return $this->presidenteController->obtenerEventos();
    }

    public function obtenerMiembros()
    {
        return $this->presidenteController->obtenerMiembros();
    }

    public function crearEvento(Request $request)
    {
        return $this->presidenteController->crearEvento($request);
    }

    public function actualizarEvento(Request $request, $id)
    {
        return $this->presidenteController->actualizarEvento($request, $id);
    }

    public function eliminarEvento($id)
    {
        return $this->presidenteController->eliminarEvento($id);
    }

    public function actualizarFechas(Request $request, $id)
    {
        return $this->presidenteController->actualizarFechas($request, $id);
    }

    public function obtenerAsistenciasEvento($id)
    {
        return $this->presidenteController->obtenerAsistenciasEvento($id);
    }

    public function registrarAsistencia(Request $request)
    {
        return $this->presidenteController->registrarAsistencia($request);
    }

    public function actualizarAsistencia(Request $request, $id)
    {
        return $this->presidenteController->actualizarAsistencia($request, $id);
    }

    public function eliminarAsistencia($id)
    {
        return $this->presidenteController->eliminarAsistencia($id);
    }
}
