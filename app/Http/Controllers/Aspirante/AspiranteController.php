<?php

namespace App\Http\Controllers\Aspirante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AspiranteController extends Controller
{
    // ============================================
    // DASHBOARD
    // ============================================
    
    public function dashboard()
    {
        $userId = Auth::id();
        
        try {
            // Llamar al procedimiento almacenado
            $dashboard = DB::select('CALL SP_Dashboard_Aspirante(?)', [$userId]);
            
            // Reconectar para obtener próximas reuniones
            DB::reconnect();
            $proximasReuniones = DB::select('CALL SP_ProximasReuniones(?)', [$userId]);
            
            return view('modulos.aspirante.dashboard', [
                'stats' => $dashboard[0] ?? null,
                'proximasReuniones' => $proximasReuniones
            ]);
            
        } catch (\Exception $e) {
            return view('modulos.aspirante.dashboard', [
                'stats' => null,
                'proximasReuniones' => [],
                'error' => 'Error al cargar dashboard: ' . $e->getMessage()
            ]);
        }
    }

    // ============================================
    // CALENDARIO
    // ============================================
    
    public function calendario(Request $request)
    {
        $userId = Auth::id();
        $mes = $request->input('mes', date('m'));
        $anio = $request->input('anio', date('Y'));
        
        try {
            $eventos = DB::select('CALL SP_Calendario_Aspirante(?, ?, ?)', [
                $userId, $mes, $anio
            ]);
            
            return view('modulos.aspirante.calendario-consulta', [
                'eventos' => $eventos,
                'mes' => $mes,
                'anio' => $anio
            ]);
            
        } catch (\Exception $e) {
            return view('modulos.aspirante.calendario-consulta', [
                'eventos' => [],
                'mes' => $mes,
                'anio' => $anio,
                'error' => 'Error al cargar calendario: ' . $e->getMessage()
            ]);
        }
    }
    
    public function eventosDelDia(Request $request)
    {
        $userId = Auth::id();
        $fecha = $request->input('fecha', date('Y-m-d'));
        
        try {
            $eventos = DB::select('CALL SP_EventosDelDia(?, ?)', [$userId, $fecha]);
            
            return response()->json([
                'success' => true,
                'data' => $eventos
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar eventos: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // PROYECTOS
    // ============================================
    
    public function proyectos(Request $request)
    {
        $userId = Auth::id();
        $estado = $request->input('estado', null);
        $buscar = $request->input('buscar', null);
        $limite = 10;
        $offset = ($request->input('page', 1) - 1) * $limite;
        
        try {
            // Obtener proyectos
            $proyectos = DB::select('CALL SP_MisProyectos(?, ?, ?, ?, ?)', [
                $userId, $estado, $buscar, $limite, $offset
            ]);
            
            // Reconectar para la segunda consulta
            DB::reconnect();
            
            // Obtener estadísticas
            $estadisticas = DB::select('CALL SP_EstadisticasProyectos_Aspirante(?)', [$userId]);
            
            return view('modulos.aspirante.mis-proyectos', [
                'proyectos' => $proyectos,
                'estadisticas' => $estadisticas[0] ?? null
            ]);
            
        } catch (\Exception $e) {
            return view('modulos.aspirante.mis-proyectos', [
                'proyectos' => [],
                'estadisticas' => null,
                'error' => 'Error al cargar proyectos: ' . $e->getMessage()
            ]);
        }
    }
    
    public function detalleProyecto($id)
    {
        $userId = Auth::id();
        
        try {
            $proyecto = DB::select('CALL SP_DetalleProyecto_Aspirante(?, ?)', [$id, $userId]);
            
            if (empty($proyecto)) {
                return back()->with('error', 'Proyecto no encontrado o no tienes acceso');
            }
            
            return view('modulos.aspirante.detalle-proyecto', [
                'proyecto' => $proyecto[0]
            ]);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar proyecto: ' . $e->getMessage());
        }
    }

    // ============================================
    // REUNIONES
    // ============================================
    
    public function reuniones(Request $request)
    {
        $userId = Auth::id();
        $tipo = $request->input('tipo', null);
        $buscar = $request->input('buscar', null);
        $limite = 10;
        $offset = ($request->input('page', 1) - 1) * $limite;
        
        try {
            // Obtener reuniones
            $reuniones = DB::select('CALL SP_MisReuniones(?, ?, ?, ?, ?)', [
                $userId, $tipo, $buscar, $limite, $offset
            ]);
            
            // Reconectar para la segunda consulta
            DB::reconnect();
            
            // Obtener estadísticas de asistencia
            $estadisticas = DB::select('CALL SP_EstadisticasAsistencia(?)', [$userId]);
            
            return view('modulos.aspirante.mis-reuniones', [
                'reuniones' => $reuniones,
                'estadisticas' => $estadisticas[0] ?? null
            ]);
            
        } catch (\Exception $e) {
            return view('modulos.aspirante.mis-reuniones', [
                'reuniones' => [],
                'estadisticas' => null,
                'error' => 'Error al cargar reuniones: ' . $e->getMessage()
            ]);
        }
    }
    
    public function registrarAsistencia(Request $request)
    {
        $request->validate([
            'calendario_id' => 'required|integer',
            'estado' => 'required|in:Presente,Ausente,Justificado',
            'hora_llegada' => 'nullable|date_format:H:i',
            'observacion' => 'nullable|string'
        ]);
        
        $userId = Auth::id();
        
        try {
            DB::select('CALL SP_RegistrarAsistencia(?, ?, ?, ?, ?)', [
                $userId,
                $request->calendario_id,
                $request->estado,
                $request->hora_llegada,
                $request->observacion
            ]);
            
            return back()->with('success', 'Asistencia registrada exitosamente');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al registrar asistencia: ' . $e->getMessage());
        }
    }

    // ============================================
    // COMUNICACIÓN - SECRETARÍA
    // ============================================
    
    public function secretaria()
    {
        $userId = Auth::id();
        
        try {
            $consultas = DB::select('CALL SP_MisConsultas(?, ?)', [$userId, 'secretaria']);
            
            return view('modulos.aspirante.comunicacion-secretaria', [
                'consultas' => $consultas
            ]);
            
        } catch (\Exception $e) {
            return view('modulos.aspirante.comunicacion-secretaria', [
                'consultas' => [],
                'error' => 'Error al cargar consultas: ' . $e->getMessage()
            ]);
        }
    }
    
    public function enviarConsultaSecretaria(Request $request)
    {
        $request->validate([
            'asunto' => 'required|string|max:200',
            'mensaje' => 'required|string'
        ]);
        
        $userId = Auth::id();
        
        try {
            DB::select('CALL SP_EnviarConsulta(?, ?, ?, ?)', [
                $userId,
                'secretaria',
                $request->asunto,
                $request->mensaje
            ]);
            
            return back()->with('success', 'Consulta enviada exitosamente');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al enviar consulta: ' . $e->getMessage());
        }
    }

    // ============================================
    // COMUNICACIÓN - VOCALÍA
    // ============================================
    
    public function voceria()
    {
        $userId = Auth::id();
        
        try {
            $consultas = DB::select('CALL SP_MisConsultas(?, ?)', [$userId, 'vocalia']);
            
            return view('modulos.aspirante.comunicacion-voceria', [
                'consultas' => $consultas
            ]);
            
        } catch (\Exception $e) {
            return view('modulos.aspirante.comunicacion-voceria', [
                'consultas' => [],
                'error' => 'Error al cargar consultas: ' . $e->getMessage()
            ]);
        }
    }
    
    public function enviarConsultaVoceria(Request $request)
    {
        $request->validate([
            'asunto' => 'required|string|max:200',
            'mensaje' => 'required|string'
        ]);
        
        $userId = Auth::id();
        
        try {
            DB::select('CALL SP_EnviarConsulta(?, ?, ?, ?)', [
                $userId,
                'vocalia',
                $request->asunto,
                $request->mensaje
            ]);
            
            return back()->with('success', 'Consulta enviada exitosamente');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al enviar consulta: ' . $e->getMessage());
        }
    }

    // ============================================
    // NOTAS PERSONALES
    // ============================================
    
    public function notas(Request $request)
    {
        $userId = Auth::id();
        $categoria = $request->input('categoria', null);
        $visibilidad = $request->input('visibilidad', null);
        $buscar = $request->input('buscar', null);
        $limite = 10;
        $offset = ($request->input('page', 1) - 1) * $limite;
        
        try {
            // Obtener notas
            $notas = DB::select('CALL SP_MisNotas(?, ?, ?, ?, ?, ?)', [
                $userId, $categoria, $visibilidad, $buscar, $limite, $offset
            ]);
            
            // Reconectar para la segunda consulta
            DB::reconnect();
            
            // Obtener estadísticas
            $estadisticas = DB::select('CALL SP_EstadisticasNotas(?)', [$userId]);
            
            return view('modulos.aspirante.blog-notas', [
                'notas' => $notas,
                'estadisticas' => $estadisticas[0] ?? null
            ]);
            
        } catch (\Exception $e) {
            return view('modulos.aspirante.blog-notas', [
                'notas' => [],
                'estadisticas' => null,
                'error' => 'Error al cargar notas: ' . $e->getMessage()
            ]);
        }
    }
    
    public function crearNota()
    {
        return view('modulos.aspirante.crear-nota');
    }
    
    public function guardarNota(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'contenido' => 'required|string',
            'categoria' => 'nullable|in:personal,trabajo,estudio,proyecto,reunion,idea,otro',
            'visibilidad' => 'nullable|in:privada,publica',
            'etiquetas' => 'nullable|string',
            'recordatorio' => 'nullable|date'
        ]);
        
        $userId = Auth::id();
        
        try {
            $resultado = DB::select('CALL SP_CrearNota(?, ?, ?, ?, ?, ?, ?)', [
                $userId,
                $request->titulo,
                $request->contenido,
                $request->categoria ?? 'personal',
                $request->visibilidad ?? 'privada',
                $request->etiquetas,
                $request->recordatorio
            ]);
            
           return redirect()->route('aspirante.blog-notas')->with('success', 'Nota creada exitosamente');
            
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al crear nota: ' . $e->getMessage());
        }
    }
    
    public function editarNota($id)
    {
        $userId = Auth::id();
        
        try {
            $nota = DB::select('CALL SP_DetalleNota(?, ?)', [$id, $userId]);
            
            if (empty($nota)) {
                return back()->with('error', 'Nota no encontrada o no tienes acceso');
            }
            
            return view('modulos.aspirante.editar-nota', [
                'nota' => $nota[0]
            ]);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar nota: ' . $e->getMessage());
        }
    }
    
    public function actualizarNota(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'contenido' => 'required|string',
            'categoria' => 'nullable|string',
            'visibilidad' => 'nullable|string',
            'etiquetas' => 'nullable|string',
            'recordatorio' => 'nullable|date'
        ]);
        
        $userId = Auth::id();
        
        try {
            DB::select('CALL SP_ActualizarNota(?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $userId,
                $request->titulo,
                $request->contenido,
                $request->categoria,
                $request->visibilidad,
                $request->etiquetas,
                $request->recordatorio
            ]);
            
            return redirect()->route('aspirante.notas')->with('success', 'Nota actualizada exitosamente');
            
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al actualizar nota: ' . $e->getMessage());
        }
    }
    
    public function eliminarNota($id)
    {
        $userId = Auth::id();
        
        try {
            DB::select('CALL SP_EliminarNota(?, ?)', [$id, $userId]);
            
            return back()->with('success', 'Nota eliminada exitosamente');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar nota: ' . $e->getMessage());
        }
    }

    // ============================================
    // PERFIL
    // ============================================
    
    public function perfil()
    {
        $userId = Auth::id();
        
        try {
            $perfil = DB::select('CALL SP_Perfil_Aspirante(?)', [$userId]);
            
            // Reconectar para obtener progreso
            DB::reconnect();
            $progreso = DB::select('CALL SP_ProgresoAspirante(?)', [$userId]);
            
            return view('modulos.aspirante.mi-perfil', [
                'perfil' => $perfil[0] ?? null,
                'progreso' => $progreso[0] ?? null
            ]);
            
        } catch (\Exception $e) {
            return view('modulos.aspirante.mi-perfil', [
                'perfil' => null,
                'progreso' => null,
                'error' => 'Error al cargar perfil: ' . $e->getMessage()
            ]);
        }
    }
    
    public function actualizarPerfil(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|max:100',
            'dni_pasaporte' => 'nullable|string|max:20',
            'apuntes' => 'nullable|string'
        ]);
        
        $userId = Auth::id();
        
        try {
            DB::select('CALL SP_ActualizarPerfil_Aspirante(?, ?, ?, ?, ?)', [
                $userId,
                $request->nombre,
                $request->correo,
                $request->dni_pasaporte,
                $request->apuntes
            ]);
            
            return back()->with('success', 'Perfil actualizado exitosamente');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar perfil: ' . $e->getMessage());
        }
    }
    
    // ============================================
    // CHAT EN TIEMPO REAL
    // ============================================
    
    public function obtenerConversacion($conversacionId)
    {
        $userId = Auth::id();
        
        try {
            $mensajes = DB::select('CALL SP_ObtenerConversacion(?, ?)', [$conversacionId, $userId]);
            
            return response()->json([
                'success' => true,
                'data' => $mensajes
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar conversación: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function enviarMensajeChat(Request $request)
    {
        $request->validate([
            'conversacion_id' => 'required|integer',
            'mensaje' => 'required|string'
        ]);
        
        $userId = Auth::id();
        
        try {
            DB::select('CALL SP_EnviarMensajeChat(?, ?, ?)', [
                $request->conversacion_id,
                $userId,
                $request->mensaje
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Mensaje enviado'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar mensaje: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // ============================================
    // BÚSQUEDA GLOBAL
    // ============================================
    
    public function buscar(Request $request)
    {
        $request->validate([
            'termino' => 'required|string|min:3'
        ]);
        
        $userId = Auth::id();
        
        try {
            $resultados = DB::select('CALL SP_BusquedaGlobal(?, ?)', [
                $userId,
                $request->termino
            ]);
            
            return response()->json([
                'success' => true,
                'data' => $resultados
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda: ' . $e->getMessage()
            ], 500);
        }
    }
}