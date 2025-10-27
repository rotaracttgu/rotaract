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

    /**
     * Muestra el calendario de eventos y reuniones.
     */
    public function calendario()
    {
        $eventos = Reunion::all()->map(function($reunion) {
            return [
                'id' => $reunion->id,
                'title' => $reunion->titulo,
                'start' => $reunion->fecha_hora,
                'description' => $reunion->descripcion,
                'lugar' => $reunion->lugar,
                'estado' => $reunion->estado,
                'color' => $this->getEventColor($reunion->estado)
            ];
        });

        return view('modulos.vicepresidente.calendario', compact('eventos'));
    }

    /**
     * Muestra el centro de notificaciones.
     */
    public function notificaciones()
    {
        // Aquí puedes agregar lógica para obtener notificaciones
        $notificaciones = [];
        
        return view('modulos.vicepresidente.notificaciones', compact('notificaciones'));
    }

    /**
     * Obtiene el color del evento según su estado.
     */
    private function getEventColor($estado)
    {
        return match($estado) {
            'Programada' => '#3b82f6',
            'Completada' => '#10b981',
            'Cancelada' => '#ef4444',
            default => '#6b7280'
        };
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

        // Obtener lista de proyectos para los dropdowns
        $proyectos = Proyecto::orderBy('Nombre')->get();

        return view('modulos.vicepresidente.cartas-patrocinio', compact('cartas', 'estadisticas', 'proyectos'));
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

        return redirect()->route('vicepresidente.cartas.formales')
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

        return redirect()->route('vicepresidente.cartas.formales')
                        ->with('success', 'Carta formal actualizada exitosamente.');
    }

    /**
     * Elimina una carta formal.
     */
    public function destroyCartaFormal($id)
    {
        $carta = CartaFormal::findOrFail($id);
        $carta->delete();

        return redirect()->route('vicepresidente.cartas.formales')
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

        return redirect()->route('vicepresidente.cartas.patrocinio')
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

        return redirect()->route('vicepresidente.cartas.patrocinio')
                        ->with('success', 'Carta de patrocinio actualizada exitosamente.');
    }

    /**
     * Elimina una carta de patrocinio.
     */
    public function destroyCartaPatrocinio($id)
    {
        $carta = CartaPatrocinio::findOrFail($id);
        $carta->delete();

        return redirect()->route('vicepresidente.cartas.patrocinio')
                        ->with('success', 'Carta de patrocinio eliminada exitosamente.');
    }
}