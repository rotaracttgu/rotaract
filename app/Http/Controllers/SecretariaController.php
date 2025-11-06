<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Consulta;
use App\Models\Acta;
use App\Models\Diploma;
use App\Models\Documento;
use App\Models\User;
use App\Models\Miembro;
use App\Services\NotificacionService;

class SecretariaController extends Controller
{
    /**
     * Dashboard principal de secretaría
     */
    public function dashboard()
    {
        // Calcular estadísticas
        $estadisticas = [
            // Consultas
            'consultas_pendientes' => Consulta::where('estado', 'pendiente')->count(),
            'consultas_nuevas' => Consulta::whereDate('created_at', today())->count(),
            
            // Actas
            'total_actas' => Acta::count(),
            'actas_este_mes' => Acta::whereMonth('created_at', now()->month)
                                   ->whereYear('created_at', now()->year)
                                   ->count(),
            
            // Diplomas
            'total_diplomas' => Diploma::count(),
            'diplomas_este_mes' => Diploma::whereMonth('created_at', now()->month)
                                         ->whereYear('created_at', now()->year)
                                         ->count(),
            
            // Documentos
            'total_documentos' => Documento::count(),
            'categorias_documentos' => Documento::distinct('TipoDocumento')->count('TipoDocumento'),
        ];
        
        // Contadores para las tarjetas
        $consultasPendientes = Consulta::where('estado', 'pendiente')->count();
        $consultasRecientes = Consulta::latest()->take(5)->get();
        
        // Datos recientes
        $actas = Acta::latest()->take(5)->get();
        $diplomas = Diploma::with('miembro')->latest()->take(5)->get();
        $documentos = Documento::orderBy('FechaSubida', 'desc')->take(5)->get();
        
        // Consultas recientes para la sección
        $consultasRecientesSeccion = Consulta::with('usuario')
            ->latest()
            ->take(5)
            ->get();
        
        // Documentos recientes
        $documentosRecientes = Documento::orderBy('FechaSubida', 'desc')
            ->take(5)
            ->get();
        
        // Actas recientes
        $actasRecientes = Acta::latest()
            ->take(5)
            ->get();
        
        // Diplomas recientes
        $diplomasRecientes = Diploma::with('miembro')
            ->latest()
            ->take(5)
            ->get();

        return view('modulos.secretaria.dashboard', compact(
            'estadisticas',
            'consultasPendientes',
            'consultasRecientes',
            'actas',
            'diplomas',
            'documentos',
            'consultasRecientesSeccion',
            'documentosRecientes',
            'actasRecientes',
            'diplomasRecientes'
        ));
    }

    /**
     * Muestra el calendario de Secretaría
     */
    public function calendario()
    {
        return view('modulos.secretaria.calendario');
    }

    // ============================================================================
    // GESTIÓN DE CONSULTAS
    // ============================================================================

    /**
     * Mostrar lista de consultas
     */
    public function consultas()
    {
        $consultas = Consulta::with('usuario')
            ->latest()
            ->paginate(15);

        $estadisticas = [
            'total' => Consulta::count(),
            'pendientes' => Consulta::where('estado', 'pendiente')->count(),
            'respondidas' => Consulta::where('estado', 'respondida')->count(),
            'cerradas' => Consulta::where('estado', 'cerrada')->count(),
            'hoy' => Consulta::whereDate('created_at', today())->count(),
        ];

        return view('modulos.secretaria.consultas', compact('consultas', 'estadisticas'));
    }

    /**
     * Mostrar consultas pendientes
     */
    public function consultasPendientes()
    {
        $consultas = Consulta::with('usuario')
            ->where('estado', 'pendiente')
            ->latest()
            ->paginate(15);

        $estadisticas = [
            'total' => Consulta::count(),
            'pendientes' => Consulta::where('estado', 'pendiente')->count(),
            'respondidas' => Consulta::where('estado', 'respondida')->count(),
            'cerradas' => Consulta::where('estado', 'cerrada')->count(),
            'hoy' => Consulta::whereDate('created_at', today())->count(),
        ];

        return view('modulos.secretaria.consultas', compact('consultas', 'estadisticas'));
    }

    /**
     * Mostrar consultas recientes
     */
    public function consultasRecientes()
    {
        $consultas = Consulta::with('usuario')
            ->latest()
            ->take(10)
            ->paginate(15);

        $estadisticas = [
            'total' => Consulta::count(),
            'pendientes' => Consulta::where('estado', 'pendiente')->count(),
            'respondidas' => Consulta::where('estado', 'respondida')->count(),
            'cerradas' => Consulta::where('estado', 'cerrada')->count(),
            'hoy' => Consulta::whereDate('created_at', today())->count(),
        ];

        return view('modulos.secretaria.consultas', compact('consultas', 'estadisticas'));
    }

    /**
     * Obtener una consulta específica
     */
    public function getConsulta($id)
    {
        $consulta = Consulta::with('usuario')->findOrFail($id);
        return response()->json($consulta);
    }

    /**
     * Responder a una consulta
     */
    public function responderConsulta(Request $request, $id)
    {
        $request->validate([
            'respuesta' => 'required|string|max:1000',
        ]);

        $consulta = Consulta::findOrFail($id);
        $consulta->update([
            'respuesta' => $request->respuesta,
            'estado' => 'respondida',
            'respondido_por' => Auth::id(),
            'respondido_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Consulta respondida exitosamente',
            'consulta' => $consulta
        ]);
    }

    /**
     * Eliminar una consulta
     */
    public function eliminarConsulta($id)
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->delete();

        return response()->json([
            'success' => true,
            'message' => 'Consulta eliminada exitosamente'
        ]);
    }

    // ============================================================================
    // GESTIÓN DE ACTAS
    // ============================================================================

    /**
     * Mostrar lista de actas
     */
    public function actas()
    {
        $actas = Acta::with('creador')
            ->latest('fecha_reunion')
            ->paginate(15);

        $estadisticas = [
            'total' => Acta::count(),
            'este_mes' => Acta::whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->count(),
            'este_anio' => Acta::whereYear('created_at', now()->year)->count(),
            'ordinarias' => Acta::where('tipo_reunion', 'ordinaria')->count(),
            'extraordinarias' => Acta::where('tipo_reunion', 'extraordinaria')->count(),
        ];

        return view('modulos.secretaria.actas', compact('actas', 'estadisticas'));
    }

    /**
     * Obtener un acta específica
     */
    public function getActa($id)
    {
        $acta = Acta::with('creador')->findOrFail($id);
        return response()->json($acta);
    }

    /**
     * Crear un acta nueva
     */
    public function storeActa(Request $request)
    {
        $request->validate([
            'fecha_reunion' => 'required|date',
            'tipo_reunion' => 'required|string|in:ordinaria,extraordinaria',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'asistentes' => 'nullable|string',
            'acuerdos' => 'nullable|string',
            'firma_presidente' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'firma_secretario' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $data = $request->except(['firma_presidente', 'firma_secretario']);
        $data['creado_por'] = Auth::id();

        if ($request->hasFile('firma_presidente')) {
            $path = $request->file('firma_presidente')->store('firmas', 'public');
            $data['firma_presidente_path'] = $path;
        }

        if ($request->hasFile('firma_secretario')) {
            $path = $request->file('firma_secretario')->store('firmas', 'public');
            $data['firma_secretario_path'] = $path;
        }

        $acta = Acta::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Acta creada exitosamente',
            'acta' => $acta
        ]);
    }

    /**
     * Actualizar un acta existente
     */
    public function updateActa(Request $request, $id)
    {
        $request->validate([
            'fecha_reunion' => 'required|date',
            'tipo_reunion' => 'required|string|in:ordinaria,extraordinaria',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'asistentes' => 'nullable|string',
            'acuerdos' => 'nullable|string',
            'firma_presidente' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'firma_secretario' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $acta = Acta::findOrFail($id);
        $data = $request->except(['firma_presidente', 'firma_secretario']);

        if ($request->hasFile('firma_presidente')) {
            if ($acta->firma_presidente_path) {
                Storage::disk('public')->delete($acta->firma_presidente_path);
            }
            $path = $request->file('firma_presidente')->store('firmas', 'public');
            $data['firma_presidente_path'] = $path;
        }

        if ($request->hasFile('firma_secretario')) {
            if ($acta->firma_secretario_path) {
                Storage::disk('public')->delete($acta->firma_secretario_path);
            }
            $path = $request->file('firma_secretario')->store('firmas', 'public');
            $data['firma_secretario_path'] = $path;
        }

        $acta->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Acta actualizada exitosamente',
            'acta' => $acta
        ]);
    }

    /**
     * Eliminar un acta
     */
    public function eliminarActa($id)
    {
        $acta = Acta::findOrFail($id);

        if ($acta->firma_presidente_path) {
            Storage::disk('public')->delete($acta->firma_presidente_path);
        }

        if ($acta->firma_secretario_path) {
            Storage::disk('public')->delete($acta->firma_secretario_path);
        }

        $acta->delete();

        return response()->json([
            'success' => true,
            'message' => 'Acta eliminada exitosamente'
        ]);
    }

    // ============================================================================
    // GESTIÓN DE DIPLOMAS
    // ============================================================================

    /**
     * Mostrar lista de diplomas
     */
    public function diplomas()
    {
        $diplomas = Diploma::with('miembro', 'emisor')
            ->latest()
            ->paginate(15);

        $estadisticas = [
            'total' => Diploma::count(),
            'este_mes' => Diploma::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->count(),
            'este_anio' => Diploma::whereYear('created_at', now()->year)->count(),
            'merito' => Diploma::where('tipo', 'merito')->count(),
            'asistencia' => Diploma::where('tipo', 'asistencia')->count(),
            'participacion' => Diploma::where('tipo', 'participacion')->count(),
            'reconocimiento' => Diploma::where('tipo', 'reconocimiento')->count(),
            'enviados' => Diploma::where('enviado_email', true)->count(),
        ];

        return view('modulos.secretaria.diplomas', compact('diplomas', 'estadisticas'));
    }

    /**
     * Obtener un diploma específico
     */
    public function getDiploma($id)
    {
        $diploma = Diploma::with('miembro', 'emisor')->findOrFail($id);
        return response()->json($diploma);
    }

    /**
     * Crear un diploma nuevo
     */
    public function storeDiploma(Request $request)
    {
        $request->validate([
            'miembro_id' => 'required|exists:users,id',
            'tipo' => 'required|string|in:participacion,reconocimiento,merito,asistencia',
            'motivo' => 'required|string|max:500',
            'fecha_emision' => 'required|date',
            'archivo' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $data = $request->except('archivo');
        $data['emitido_por'] = Auth::id();

        if ($request->hasFile('archivo')) {
            $path = $request->file('archivo')->store('diplomas', 'public');
            $data['archivo_path'] = $path;
        }

        $diploma = Diploma::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Diploma creado exitosamente',
            'diploma' => $diploma
        ]);
    }

    /**
     * Actualizar un diploma existente
     */
    public function updateDiploma(Request $request, $id)
    {
        $request->validate([
            'miembro_id' => 'required|exists:users,id',
            'tipo' => 'required|string|in:participacion,reconocimiento,merito,asistencia',
            'motivo' => 'required|string|max:500',
            'fecha_emision' => 'required|date',
            'archivo' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $diploma = Diploma::findOrFail($id);
        $data = $request->except('archivo');

        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($diploma->archivo_path) {
                Storage::disk('public')->delete($diploma->archivo_path);
            }
            $path = $request->file('archivo')->store('diplomas', 'public');
            $data['archivo_path'] = $path;
        }

        $diploma->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Diploma actualizado exitosamente',
            'diploma' => $diploma
        ]);
    }

    /**
     * Eliminar un diploma
     */
    public function eliminarDiploma($id)
    {
        $diploma = Diploma::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($diploma->archivo_path) {
            Storage::disk('public')->delete($diploma->archivo_path);
        }

        $diploma->delete();

        return response()->json([
            'success' => true,
            'message' => 'Diploma eliminado exitosamente'
        ]);
    }

    /**
     * Enviar diploma por email
     */
    public function enviarEmailDiploma(Request $request, $id)
    {
        $diploma = Diploma::with('miembro')->findOrFail($id);

        // Aquí puedes implementar el envío de email
        // Mail::to($diploma->miembro->email)->send(new DiplomaMail($diploma));

        $diploma->update(['enviado_email' => true, 'fecha_envio_email' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Diploma enviado por email exitosamente'
        ]);
    }

    // ============================================================================
    // GESTIÓN DE DOCUMENTOS
    // ============================================================================

    /**
     * Mostrar lista de documentos
     */
    public function documentos()
    {
        $documentos = Documento::with('creador')
            ->orderBy('FechaSubida', 'desc')
            ->paginate(15);

        $estadisticas = [
            'total' => Documento::count(),
            'este_mes' => Documento::whereMonth('FechaSubida', now()->month)
                                  ->whereYear('FechaSubida', now()->year)
                                  ->count(),
            'este_anio' => Documento::whereYear('FechaSubida', now()->year)->count(),
            'categorias' => Documento::distinct('TipoDocumento')->count('TipoDocumento'),
            'oficiales' => Documento::where('tipo', 'oficial')->count(),
            'internos' => Documento::where('tipo', 'interno')->count(),
        ];

        return view('modulos.secretaria.documentos', compact('documentos', 'estadisticas'));
    }

    /**
     * Obtener un documento específico
     */
    public function getDocumento($id)
    {
        $documento = Documento::with('creador')->findOrFail($id);
        return response()->json($documento);
    }

    /**
     * Crear un documento nuevo
     */
    public function storeDocumento(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|string|in:oficial,interno,comunicado,carta,informe,otro',
            'descripcion' => 'nullable|string|max:1000',
            'archivo' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'categoria' => 'nullable|string|max:100',
        ]);

        $data = $request->except('archivo');
        $data['creado_por'] = Auth::id();

        if ($request->hasFile('archivo')) {
            $originalName = $request->file('archivo')->getClientOriginalName();
            $path = $request->file('archivo')->store('documentos', 'public');
            $data['archivo_path'] = $path;
            $data['archivo_nombre'] = $originalName;
        }

        $documento = Documento::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Documento creado exitosamente',
            'documento' => $documento
        ]);
    }

    /**
     * Actualizar un documento existente
     */
    public function updateDocumento(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|string|in:oficial,interno,comunicado,carta,informe,otro',
            'descripcion' => 'nullable|string|max:1000',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'categoria' => 'nullable|string|max:100',
        ]);

        $documento = Documento::findOrFail($id);
        $data = $request->except('archivo');

        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($documento->archivo_path) {
                Storage::disk('public')->delete($documento->archivo_path);
            }
            $originalName = $request->file('archivo')->getClientOriginalName();
            $path = $request->file('archivo')->store('documentos', 'public');
            $data['archivo_path'] = $path;
            $data['archivo_nombre'] = $originalName;
        }

        $documento->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Documento actualizado exitosamente',
            'documento' => $documento
        ]);
    }

    /**
     * Eliminar un documento
     */
    public function eliminarDocumento($id)
    {
        $documento = Documento::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($documento->archivo_path) {
            Storage::disk('public')->delete($documento->archivo_path);
        }

        $documento->delete();

        return response()->json([
            'success' => true,
            'message' => 'Documento eliminado exitosamente'
        ]);
    }

    // ============================================================================
    // NOTIFICACIONES
    // ============================================================================

    /**
     * Muestra el centro de notificaciones
     */
    public function notificaciones()
    {
        $notificacionService = app(NotificacionService::class);
        
        // Obtener todas las notificaciones del usuario actual
        $notificaciones = $notificacionService->obtenerTodas(auth()->id(), 50);
        
        // Contar notificaciones no leídas
        $noLeidas = $notificaciones->where('leida', false)->count();
        
        return view('modulos.secretaria.notificaciones', compact('notificaciones', 'noLeidas'));
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
    // 🆕 MÉTODOS DE CALENDARIO
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

    // ============================================================================
    // 🆕 MÉTODOS DE ASISTENCIAS
    // ============================================================================

    /**
     * Vista principal de gestión de asistencias
     */
    public function gestionAsistencias()
    {
        return view('modulos.secretaria.gestion-asistencias');
    }

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
    // MÉTODOS PRIVADOS - CONVERSIÓN DE ESTADOS
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
    // MÉTODOS PRIVADOS - FORMATEO Y CONVERSIÓN (CALENDARIO)
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
        
        if ($tipoEvento === 'reunion-virtual') {
            $detalles['enlace'] = $evento->Ubicacion ?? '';
        } elseif ($tipoEvento === 'reunion-presencial') {
            $detalles['lugar'] = $evento->Ubicacion ?? '';
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
     */
    private function convertirTipoEvento($tipo)
    {
        $mapa = [
            'reunion-virtual' => 'Virtual',
            'reunion-presencial' => 'Presencial',
            'inicio-proyecto' => 'InicioProyecto',
            'finalizar-proyecto' => 'FinProyecto'
        ];
        
        return $mapa[$tipo] ?? 'Virtual';
    }

    /**
     * Convertir tipo de evento de DB a vista
     */
    private function convertirTipoEventoDesdeDB($tipo)
    {
        $mapa = [
            'Virtual' => 'reunion-virtual',
            'Presencial' => 'reunion-presencial',
            'InicioProyecto' => 'inicio-proyecto',
            'FinProyecto' => 'finalizar-proyecto'
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
}
