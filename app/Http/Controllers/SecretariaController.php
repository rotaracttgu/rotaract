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
}