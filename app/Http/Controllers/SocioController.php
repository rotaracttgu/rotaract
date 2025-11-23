<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Services\NotificacionService;
use App\Models\Notificacion;
use App\Models\Consulta;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SocioController extends Controller
{
    use AuthorizesRequests;
    public function dashboard()
    {
        $this->authorize('dashboard.ver');
        
        try {
            $userId = Auth::id();
            
            // Obtener proyectos activos
            $proyectosActivosLista = DB::select('CALL SP_MisProyectos(?, "Activo", NULL, "")', [$userId]);
            $proyectosActivosLista = collect($proyectosActivosLista);
            
            // Obtener todas las reuniones para estadísticas
            $todasReuniones = DB::select('CALL SP_MisReuniones(?, NULL, NULL)', [$userId]);
            $todasReuniones = collect($todasReuniones);
            
            // Próximas reuniones (próximos 7 días)
            $proximasReuniones = $todasReuniones->filter(function($r) {
                $fecha = \Carbon\Carbon::parse($r->FechaEvento ?? $r->FechaInicio ?? null);
                return $fecha && $fecha->isFuture() && $fecha->diffInDays(\Carbon\Carbon::now()) <= 7;
            })->take(5);
            
            // Obtener todas las notas
            $todasNotas = DB::select('CALL SP_MisNotas(?, NULL, NULL, "", 1000, 0)', [$userId]);
            $todasNotas = collect($todasNotas);
            
            // Obtener todas las consultas
            $todasConsultas = DB::select('CALL SP_MisConsultas(?, "secretaria", NULL, 100)', [$userId]);
            $todasConsultas = collect($todasConsultas);
            
            // Calcular estadísticas
            $totalProyectos = DB::select('CALL SP_MisProyectos(?, NULL, NULL, "")', [$userId]);
            $totalProyectos = collect($totalProyectos)->count();
            
            $proyectosActivos = $proyectosActivosLista->count();
            $proyectosEnCurso = $todasReuniones->whereIn('EstadoEvento', ['Activo', 'En Progreso'])->count();
            
            $totalReuniones = $todasReuniones->count();
            $reunionesProgramadas = $todasReuniones->where('EstadoEvento', 'Programado')->count();
            
            $totalNotas = $todasNotas->count();
            $notasPrivadas = $todasNotas->where('Visibilidad', 'privada')->count();
            $notasPublicas = $todasNotas->where('Visibilidad', 'publica')->count();
            
            $totalConsultas = $todasConsultas->count();
            $consultasPendientes = $todasConsultas->where('Estado', 'pendiente')->count();
            
            return view('modulos.socio.dashboard', [
                // Listas
                'proximasReuniones' => $proximasReuniones,
                'proyectosActivos' => $proyectosActivosLista,
                
                // Estadísticas de Proyectos
                'totalProyectos' => $totalProyectos,
                'proyectosActivosCount' => $proyectosActivos,
                'proyectosEnCurso' => $proyectosEnCurso,
                
                // Estadísticas de Reuniones
                'totalReuniones' => $totalReuniones,
                'reunionesProgramadas' => $reunionesProgramadas,
                
                // Estadísticas de Notas
                'totalNotas' => $totalNotas,
                'notasPrivadas' => $notasPrivadas,
                'notasPublicas' => $notasPublicas,
                
                // Estadísticas de Consultas
                'totalConsultas' => $totalConsultas,
                'consultasPendientes' => $consultasPendientes,
                
                // Para compatibilidad
                'consultasSecretariaPendientes' => $consultasPendientes,
                'consultasVoceriaPendientes' => 0,
                'notasActivas' => $totalNotas
            ]);
        } catch (\Exception $e) {
            // Retornar dashboard vacío si hay error
            return view('modulos.socio.dashboard', [
                'proximasReuniones' => collect([]),
                'proyectosActivos' => collect([]),
                'totalProyectos' => 0,
                'proyectosActivosCount' => 0,
                'proyectosEnCurso' => 0,
                'totalReuniones' => 0,
                'reunionesProgramadas' => 0,
                'totalNotas' => 0,
                'notasPrivadas' => 0,
                'notasPublicas' => 0,
                'totalConsultas' => 0,
                'consultasPendientes' => 0,
                'consultasSecretariaPendientes' => 0,
                'consultasVoceriaPendientes' => 0,
                'notasActivas' => 0
            ]);
        }
    }

    public function calendario()
    {
        $this->authorize('calendario.ver');
        return view('modulos.socio.calendario-consulta');
    }

    public function obtenerEventosCalendario($year, $month)
    {
        $this->authorize('calendario.ver');
        
        try {
            // Obtener eventos reales de la BD - usando nombres correctos de columnas
            $eventos = DB::table('calendarios')
                ->whereYear('FechaInicio', $year)
                ->whereMonth('FechaInicio', $month)
                ->get();

            if ($eventos->isEmpty()) {
                // Datos mock si no hay eventos
                return response()->json([
                    [
                        'id' => 1,
                        'title' => 'Reunión General',
                        'start' => "$year-$month-10",
                        'end' => "$year-$month-10",
                        'description' => 'Reunión mensual del club',
                        'location' => 'Sala Principal',
                        'type' => 'Ordinaria',
                        'status' => 'Programada',
                        'backgroundColor' => '#3B82F6',
                        'borderColor' => '#3B82F6'
                    ]
                ]);
            }

            // Mapear eventos a formato FullCalendar
            return response()->json($eventos->map(function ($evento) {
                return [
                    'id' => $evento->CalendarioID,
                    'title' => $evento->TituloEvento,
                    'start' => $evento->FechaInicio,
                    'end' => $evento->FechaFin,
                    'description' => $evento->Descripcion,
                    'location' => $evento->Ubicacion ?? '',
                    'type' => $evento->TipoEvento ?? 'General',
                    'status' => $evento->EstadoEvento ?? 'Programado',
                    'backgroundColor' => '#10B981',
                    'borderColor' => '#059669'
                ];
            })->toArray());

        } catch (\Exception $e) {
            // En caso de error, devolver mock
            return response()->json([
                [
                    'id' => 1,
                    'title' => 'Reunión General',
                    'start' => "$year-$month-10",
                    'end' => "$year-$month-10",
                    'description' => 'Reunión mensual del club',
                    'location' => 'Sala Principal',
                    'type' => 'Ordinaria',
                    'status' => 'Programada',
                    'backgroundColor' => '#3B82F6',
                    'borderColor' => '#3B82F6'
                ]
            ]);
        }
    }

    public function misProyectos(Request $request)
    {
        $this->authorize('proyectos.ver');
        
        try {
            $userId = Auth::id();
            $filtroEstado = $request->get('estado');
            $filtroTipo = $request->get('tipo');
            $buscar = $request->get('buscar', '');

            // Obtener rol de perfil del usuario
            $miembro = DB::table('miembros')
                ->where('user_id', $userId)
                ->first();
            $rolPerfil = $miembro->Rol ?? 'Socio';

            // Llamar al stored procedure SP_MisProyectos
            $proyectos = DB::select('CALL SP_MisProyectos(?, ?, ?, ?)', [
                $userId,
                $filtroEstado,
                $filtroTipo,
                $buscar
            ]);

            $proyectos = collect($proyectos)->map(function($p) use ($rolPerfil) {
                // Agregar rol de perfil a cada proyecto
                $p->RolPerfil = $rolPerfil;
                return $p;
            });

            // Calcular estadísticas
            $totalProyectos = $proyectos->count();
            $proyectosActivos = $proyectos->where('Estatus', 'Activo')->count();
            $proyectosEnProgreso = $proyectos->whereIn('Estatus', ['Activo', 'En Planificacion'])->count();

            return view('modulos.socio.mis-proyectos', compact(
                'proyectos',
                'totalProyectos',
                'proyectosActivos',
                'proyectosEnProgreso',
                'rolPerfil'
            ));
        } catch (\Exception $e) {
            $proyectos = collect([]);
            return view('modulos.socio.mis-proyectos', [
                'proyectos' => $proyectos,
                'totalProyectos' => 0,
                'proyectosActivos' => 0,
                'proyectosEnProgreso' => 0
            ]);
        }
    }

    public function detalleProyecto($id)
    {
        $this->authorize('proyectos.ver');
        
        try {
            $userId = Auth::id();
            
            // Obtener proyecto desde SP
            $proyectos = DB::select('CALL SP_MisProyectos(?, NULL, NULL, "")', [$userId]);
            $proyectos = collect($proyectos);
            
            $proyecto = $proyectos->where('ProyectoID', $id)->first();
            
            if (!$proyecto) {
                return redirect()->route('socio.proyectos')->with('error', 'Proyecto no encontrado');
            }
            
            // Obtener participantes del proyecto
            $participantes = DB::select(
                "SELECT u.name AS Nombre, u.email AS Correo, p.Rol AS RolProyecto
                 FROM participaciones p
                 INNER JOIN miembros m ON p.MiembroID = m.MiembroID
                 INNER JOIN users u ON m.user_id = u.id
                 WHERE p.ProyectoID = ?
                 AND (p.EstadoParticipacion = 'Activo' OR p.EstadoParticipacion IS NULL)",
                [$id]
            );
            $participantes = collect($participantes);
            
            return view('modulos.socio.detalle-proyecto', compact('proyecto', 'participantes'));
        } catch (\Exception $e) {
            return redirect()->route('socio.proyectos')->with('error', 'Error al cargar proyecto');
        }
    }

    public function misReuniones(Request $request)
    {
        $this->authorize('reuniones.ver');
        
        try {
            $userId = Auth::id();
            $filtroEstado = $request->get('estado');
            $filtroTipo = $request->get('tipo');

            // Llamar al stored procedure SP_MisReuniones
            $reuniones = DB::select('CALL SP_MisReuniones(?, ?, ?)', [
                $userId,
                $filtroEstado,
                $filtroTipo
            ]);

            $reuniones = collect($reuniones);

            // Calcular estadísticas
            $totalReuniones = $reuniones->count();
            $reunionesProgramadas = $reuniones->where('EstadoEvento', 'Programado')->count();
            $reunionesEnCurso = $reuniones->where('EstadoEvento', 'EnCurso')->count();
            $reunionesFinalizadas = $reuniones->where('EstadoEvento', 'Finalizado')->count();

            return view('modulos.socio.mis-reuniones', compact(
                'reuniones',
                'totalReuniones',
                'reunionesProgramadas',
                'reunionesEnCurso',
                'reunionesFinalizadas',
                'filtroEstado',
                'filtroTipo'
            ));
        } catch (\Exception $e) {
            $reuniones = collect([]);
            return view('modulos.socio.mis-reuniones', [
                'reuniones' => $reuniones,
                'totalReuniones' => 0,
                'reunionesProgramadas' => 0,
                'reunionesEnCurso' => 0,
                'reunionesFinalizadas' => 0,
                'filtroEstado' => null,
                'filtroTipo' => null
            ]);
        }
    }

    public function detalleReunion($id)
    {
        $this->authorize('reuniones.ver');
        
        try {
            $userId = Auth::id();
            
            // Obtener reunión desde SP
            $reuniones = DB::select('CALL SP_MisReuniones(?, NULL, NULL)', [$userId]);
            $reuniones = collect($reuniones);
            
            $reunion = $reuniones->where('CalendarioID', $id)->first();
            
            if (!$reunion) {
                return redirect()->route('socio.reuniones')->with('error', 'Reunión no encontrada');
            }
            
            return view('modulos.socio.detalle-reunion', compact('reunion'));
        } catch (\Exception $e) {
            return redirect()->route('socio.reuniones')->with('error', 'Error al cargar reunión');
        }
    }

    // === COMUNICACIÓN SECRETARÍA ===
    public function comunicacionSecretaria(Request $request)
    {
        $this->authorize('consultas.ver');
        
        try {
            $userId = Auth::id();
            $filtroEstado = $request->get('estado', null);
            
            // Obtener consultas del socio desde SP
            $consultas = DB::select('CALL SP_MisConsultasSocio(?, ?)', [
                $userId,
                $filtroEstado
            ]);
            $consultas = collect($consultas);
            
            // Calcular estadísticas
            $totalConsultas = $consultas->count();
            $consultasPendientes = $consultas->where('Estado', 'pendiente')->count();
            $consultasRespondidas = $consultas->where('Estado', 'respondida')->count();
            $consultasCerradas = $consultas->where('Estado', 'cerrada')->count();
            
            return view('modulos.socio.comunicacion-secretaria', compact(
                'consultas',
                'totalConsultas',
                'consultasPendientes',
                'consultasRespondidas',
                'consultasCerradas',
                'filtroEstado'
            ));
        } catch (\Exception $e) {
            $consultas = collect([]);
            return view('modulos.socio.comunicacion-secretaria', [
                'consultas' => $consultas,
                'totalConsultas' => 0,
                'consultasPendientes' => 0,
                'consultasRespondidas' => 0,
                'consultasCerradas' => 0,
                'filtroEstado' => null
            ]);
        }
    }

    public function crearConsultaSecretaria()
    {
        $this->authorize('consultas.crear');
        return view('modulos.socio.crear-consulta-secretaria');
    }

    public function storeConsultaSecretaria(Request $request)
    {
        $this->authorize('consultas.crear');
        
        // Validar datos básicos
        $validated = $request->validate([
            'asunto' => 'required|string|min:5|max:200',
            'tipo' => 'required|in:Certificado,Constancia,Pago,Informacion,Queja,Otro',
            'mensaje' => 'required|string|min:20',
            'comprobante' => 'nullable|file|mimes:jpeg,jpg,png,webp,pdf|max:5120', // 5MB máximo
        ], [
            'asunto.required' => 'El asunto es obligatorio',
            'asunto.min' => 'El asunto debe tener al menos 5 caracteres',
            'asunto.max' => 'El asunto no puede exceder 200 caracteres',
            'tipo.required' => 'Debes seleccionar un tipo de consulta',
            'tipo.in' => 'El tipo de consulta seleccionado no es válido',
            'mensaje.required' => 'El mensaje es obligatorio',
            'mensaje.min' => 'El mensaje debe tener al menos 20 caracteres',
            'comprobante.file' => 'El archivo debe ser un documento válido',
            'comprobante.mimes' => 'Solo se permiten archivos JPG, PNG, WEBP o PDF',
            'comprobante.max' => 'El archivo no debe superar los 5MB',
        ]);

        // Validaciones adicionales de contenido
        $erroresAdicionales = [];

        // Validar letras repetidas en asunto
        if (!$this->validarLetrasRepetidas($validated['asunto'])) {
            $erroresAdicionales['asunto'] = 'El asunto contiene letras repetidas más de 3 veces consecutivas';
        }

        // Validar caracteres especiales en asunto
        if (!$this->validarCaracteresEspeciales($validated['asunto'])) {
            $erroresAdicionales['asunto'] = 'El asunto contiene demasiados caracteres especiales consecutivos';
        }

        // Validar mayúsculas excesivas en asunto
        if (!$this->validarMayusculas($validated['asunto'])) {
            $erroresAdicionales['asunto'] = 'El asunto contiene demasiadas mayúsculas';
        }

        // Validar letras repetidas en mensaje
        if (!$this->validarLetrasRepetidas($validated['mensaje'])) {
            $erroresAdicionales['mensaje'] = 'El mensaje contiene letras repetidas más de 3 veces consecutivas';
        }

        // Validar texto coherente en mensaje
        if (!$this->validarTextoCoherente($validated['mensaje'])) {
            $erroresAdicionales['mensaje'] = 'El mensaje debe contener texto coherente';
        }

        // Si hay errores adicionales, retornar con errores
        if (!empty($erroresAdicionales)) {
            return back()->withErrors($erroresAdicionales)->withInput();
        }

        // Validar que si es tipo "Pago", debe tener comprobante
        if ($validated['tipo'] === 'Pago' && !$request->hasFile('comprobante')) {
            return back()->withErrors(['comprobante' => 'Debes adjuntar un comprobante de pago'])->withInput();
        }

        try {
            // Procesar el archivo si existe
            $comprobanteRuta = null;
            if ($request->hasFile('comprobante')) {
                $archivo = $request->file('comprobante');
                
                // Generar nombre único para el archivo
                $nombreArchivo = 'comprobante_' . Auth::id() . '_' . time() . '.' . $archivo->getClientOriginalExtension();
                
                // Guardar en storage/app/public/comprobantes
                $comprobanteRuta = $archivo->storeAs('comprobantes', $nombreArchivo, 'public');
            }

            // Determinar prioridad según tipo
            $prioridad = match($validated['tipo']) {
                'Queja' => 'alta',
                'Pago', 'Certificado', 'Constancia' => 'media',
                default => 'baja'
            };
            
            // Crear consulta en la tabla consultas
            $consultaId = DB::table('consultas')->insertGetId([
                'usuario_id' => Auth::id(),
                'asunto' => $validated['asunto'],
                'mensaje' => $validated['mensaje'],
                'comprobante_ruta' => $comprobanteRuta,
                'estado' => 'pendiente',
                'prioridad' => $prioridad,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($consultaId) {
                // 📢 Notificar a Secretarios sobre la nueva consulta
                $consulta = new \stdClass();
                $consulta->ConsultaID = $consultaId;
                $consulta->Asunto = $validated['asunto'];
                
                $notificacionService = app(\App\Services\NotificacionService::class);
                $notificacionService->notificarConsultaNueva($consulta);
                
                return redirect()->route('socio.secretaria.index')
                    ->with('success', '¡Consulta enviada exitosamente! La Secretaría la revisará pronto.');
            } else {
                throw new \Exception('No se pudo crear la consulta');
            }

        } catch (\Exception $e) {
            // Si hubo error y se subió archivo, eliminarlo
            if ($comprobanteRuta) {
                Storage::disk('public')->delete($comprobanteRuta);
            }

            return back()
                ->withErrors(['error' => 'Ocurrió un error al enviar la consulta. Por favor, intenta nuevamente.'])
                ->withInput();
        }
    }

    // Métodos auxiliares de validación
    private function validarLetrasRepetidas($texto)
    {
        $palabras = preg_split('/\s+/', $texto);
        foreach ($palabras as $palabra) {
            if (preg_match('/(.)\1{3,}/i', $palabra)) {
                return false;
            }
        }
        return true;
    }

    private function validarCaracteresEspeciales($texto)
    {
        return !preg_match('/[^a-záéíóúñA-ZÁÉÍÓÚÑ0-9\s]{6,}/', $texto);
    }

    private function validarMayusculas($texto)
    {
        $letras = preg_replace('/[^a-záéíóúñA-ZÁÉÍÓÚÑ]/', '', $texto);
        if (strlen($letras) === 0) return true;
        
        $mayusculas = preg_replace('/[^A-ZÁÉÍÓÚÑ]/', '', $texto);
        $porcentaje = (strlen($mayusculas) / strlen($letras)) * 100;
        
        return $porcentaje <= 60;
    }

    private function validarTextoCoherente($texto)
    {
        $textoLimpio = preg_replace('/\s/', '', $texto);
        $letras = preg_replace('/[^a-záéíóúñA-ZÁÉÍÓÚÑ]/', '', $textoLimpio);
        
        if (strlen($textoLimpio) > 10 && strlen($letras) < strlen($textoLimpio) * 0.3) {
            return false;
        }
        
        return true;
    }

    public function verConsultaSecretaria($id)
    {
        $this->authorize('consultas.ver');
        
        try {
            // Obtener la consulta de la base de datos
            $consulta = DB::table('consultas')
                ->where('id', $id)
                ->where('usuario_id', Auth::id()) // Verificar que pertenece al usuario actual
                ->first();
            
            if (!$consulta) {
                return redirect()->route('socio.secretaria.index')
                    ->with('error', 'Consulta no encontrada');
            }
            
            // Obtener información del usuario que respondió (si aplica)
            $respondidoPor = null;
            if ($consulta->respondido_por) {
                $respondidoPor = DB::table('users')
                    ->where('id', $consulta->respondido_por)
                    ->select('name', 'email')
                    ->first();
            }
            
            // Preparar la consulta con los datos correctos
            $consulta = (object)[
                'ConsultaID' => $consulta->id,
                'Asunto' => $consulta->asunto,
                'Mensaje' => $consulta->mensaje,
                'Estado' => ucfirst($consulta->estado),
                'FechaConsulta' => $consulta->created_at,
                'Prioridad' => ucfirst($consulta->prioridad),
                'Categoria' => 'Consulta General', // Valor por defecto
                'FechaRespuesta' => $consulta->respondido_at,
                'RespondidoPor' => $respondidoPor?->name,
                'Respuesta' => $consulta->respuesta,
                'comprobante_ruta' => $consulta->comprobante_ruta,
            ];
            
            $historial = collect([]); // Sin historial de conversación por ahora

            return view('modulos.socio.ver-consulta-secretaria', compact('consulta', 'historial'));
        } catch (\Exception $e) {
            return redirect()->route('socio.secretaria.index')
                ->with('error', 'Error al cargar la consulta');
        }
    }

    public function responderConsultaSecretaria(Request $request, $id)
    {
        $this->authorize('consultas.crear');
        
        $request->validate([
            'respuesta' => 'required|string|max:1000'
        ]);

        // Mock: guardar respuesta (en BD iría en tabla)
        session()->flash('success', '¡Respuesta enviada correctamente!');

        return redirect()->route('socio.secretaria.ver', $id);
    }

    public function actualizarConsultaSecretaria(Request $request, $id)
    {
        $this->authorize('consultas.editar');
        
        $request->validate([
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string|max:5000',
            'prioridad' => 'required|in:baja,media,alta'
        ]);

        try {
            $consulta = Consulta::where('id', $id)
                ->where('usuario_id', Auth::id())
                ->firstOrFail();
            
            // Solo permitir editar si está en estado pendiente o en revisión
            if (!in_array($consulta->estado, ['pendiente', 'en_revision'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo puedes editar consultas en estado pendiente o en revisión'
                ], 403);
            }
            
            $consulta->update([
                'asunto' => $request->asunto,
                'mensaje' => $request->mensaje,
                'prioridad' => $request->prioridad
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Consulta actualizada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar consulta: ' . $e->getMessage()
            ], 500);
        }
    }

    public function eliminarConsultaSecretaria($id)
    {
        $this->authorize('consultas.eliminar');
        
        try {
            $consulta = Consulta::where('id', $id)
                ->where('usuario_id', Auth::id())
                ->firstOrFail();
            
            // Eliminar comprobante si existe
            if ($consulta->comprobante_ruta) {
                Storage::disk('public')->delete($consulta->comprobante_ruta);
            }
            
            $consulta->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Consulta eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar consulta'
            ], 500);
        }
    }

    // === COMUNICACIÓN VOCERÍA ===
    public function comunicacionVoceria()
    {
        $this->authorize('consultas.ver');
        
        $consultas = collect([
            (object)[
                'ConsultaID' => 1,
                'TipoSolicitud' => 'Recurso_Material',
                'Asunto' => 'Necesito material',
                'Estado' => 'Pendiente',
                'FechaEnvio' => '07/11/2025 03:45 PM'
            ]
        ]);

        return view('modulos.socio.comunicacion-voceria', compact('consultas'));
    }

    public function crearConsultaVoceria()
    {
        $this->authorize('consultas.crear');
        return view('modulos.socio.crear-consulta-voceria');
    }

    public function storeConsultaVoceria(Request $request)
    {
        $this->authorize('consultas.crear');
        return redirect()->route('socio.voceria.index')
            ->with('success', 'Solicitud enviada (modo demo)');
    }

    public function verConsultaVoceria($id)
    {
        $this->authorize('consultas.ver');
        
        $datos = [
            1 => [
                'Titulo' => 'Consulta sobre presupuesto anual',
                'Contenido' => 'Estimados socios, se solicita su opinión sobre el presupuesto propuesto para el año 2026. Incluye L. 250,000 para proyectos sociales y L. 100,000 para capacitaciones.',
                'Estado' => 'abierta',
                'FechaCreacion' => '2025-11-06 09:30:00',
                'FechaCierre' => '2025-11-15 23:59:00',
                'Respuestas' => 12,
                'Votos' => ['Sí' => 8, 'No' => 3, 'Abstención' => 1]
            ],
            2 => [
                'Titulo' => 'Propuesta de nuevo proyecto',
                'Contenido' => 'Se propone iniciar un programa de mentoría para nuevos socios. ¿Están de acuerdo?',
                'Estado' => 'cerrada',
                'FechaCreacion' => '2025-10-25 14:00:00',
                'FechaCierre' => '2025-11-01 23:59:00',
                'Respuestas' => 15,
                'Votos' => ['Sí' => 12, 'No' => 2, 'Abstención' => 1]
            ],
            3 => [
                'Titulo' => 'Cambio de horario de reuniones',
                'Contenido' => '¿Prefieren mantener las reuniones los sábados o cambiar a domingos?',
                'Estado' => 'abierta',
                'FechaCreacion' => '2025-11-05 10:15:00',
                'FechaCierre' => '2025-11-10 23:59:00',
                'Respuestas' => 7,
                'Votos' => ['Sábado' => 4, 'Domingo' => 3]
            ]
        ];

        $data = $datos[$id] ?? $datos[1];

        $consulta = (object) array_merge([
            'ConsultaID' => $id,
            'Autor' => 'Presidente del Club'
        ], $data);

        return view('modulos.socio.ver-consulta-voceria', compact('consulta'));
    }

    // === BLOG DE NOTAS ===
    public function blogNotas(Request $request)
    {
        $this->authorize('notas.ver');
        
        try {
            $userId = Auth::id();
            $filtroCategoria = $request->get('categoria', 'todas');
            $filtroVisibilidad = $request->get('visibilidad', 'todas');
            $buscar = $request->get('buscar', '');
            $limite = 50;
            $offset = 0;

            // Preparar parámetros para el SP
            $categoriaParam = $filtroCategoria === 'todas' ? null : $filtroCategoria;
            $visibilidadParam = $filtroVisibilidad === 'todas' ? null : $filtroVisibilidad;

            // Llamar al stored procedure SP_MisNotas
            $notas = DB::select('CALL SP_MisNotas(?, ?, ?, ?, ?, ?)', [
                $userId,
                $categoriaParam,
                $visibilidadParam,
                $buscar,
                $limite,
                $offset
            ]);

            $notas = collect($notas);

            // Calcular estadísticas desde las notas obtenidas (sin filtros)
            $todasLasNotas = DB::select('CALL SP_MisNotas(?, NULL, NULL, "", 1000, 0)', [$userId]);
            $todasLasNotas = collect($todasLasNotas);
            
            $totalNotas = $todasLasNotas->count();
            $notasPrivadas = $todasLasNotas->where('Visibilidad', 'privada')->count();
            $notasPublicas = $todasLasNotas->where('Visibilidad', 'publica')->count();
            
            // Notas de este mes (noviembre 2025)
            $mesActual = now()->format('Y-m');
            $notasEsteMes = $todasLasNotas->filter(function($nota) use ($mesActual) {
                return strpos($nota->FechaCreacion, $mesActual) === 0;
            })->count();

            return view('modulos.socio.blog-notas', compact(
                'notas', 
                'filtroCategoria', 
                'filtroVisibilidad',
                'totalNotas',
                'notasPrivadas',
                'notasPublicas',
                'notasEsteMes'
            ));
        } catch (\Exception $e) {
            // En caso de error, retornar colección vacía
            $notas = collect([]);
            return view('modulos.socio.blog-notas', [
                'notas' => $notas,
                'filtroCategoria' => $request->get('categoria', 'todas'),
                'filtroVisibilidad' => $request->get('visibilidad', 'todas'),
                'totalNotas' => 0,
                'notasPrivadas' => 0,
                'notasPublicas' => 0,
                'notasEsteMes' => 0
            ]);
        }
    }

    public function crearNota()
    {
        $this->authorize('notas.crear');
        return view('modulos.socio.crear-nota');
    }

    public function verNota($id)
    {
        $this->authorize('notas.ver');
        
        try {
            $userId = Auth::id();

            // Llamar al stored procedure SP_DetalleNota
            $resultado = DB::select('CALL SP_DetalleNota(?, ?)', [$userId, $id]);

            if (empty($resultado)) {
                return redirect()->route('socio.notas.index')
                    ->with('error', 'Nota no encontrada o no tienes permiso para verla.');
            }

            $nota = $resultado[0];

            return view('modulos.socio.ver-nota', compact('nota'));
        } catch (\Exception $e) {
            return redirect()->route('socio.notas.index')
                ->with('error', 'Error al cargar la nota: ' . $e->getMessage());
        }
    }

    public function editarNota($id)
    {
        $this->authorize('notas.editar');
        
        try {
            $userId = Auth::id();

            // Llamar al stored procedure SP_DetalleNota
            $resultado = DB::select('CALL SP_DetalleNota(?, ?)', [$userId, $id]);

            if (empty($resultado)) {
                return redirect()->route('socio.notas.index')
                    ->with('error', 'Nota no encontrada o no tienes permiso para editarla.');
            }

            $nota = $resultado[0];

            return view('modulos.socio.editar-nota', compact('nota'));
        } catch (\Exception $e) {
            return redirect()->route('socio.notas.index')
                ->with('error', 'Error al cargar la nota: ' . $e->getMessage());
        }
    }

    public function eliminarNota($id)
    {
        $this->authorize('notas.eliminar');
        
        try {
            $userId = Auth::id();

            // Llamar al stored procedure SP_EliminarNota
            $resultado = DB::select('CALL SP_EliminarNota(?, ?)', [$userId, $id]);

            if (!empty($resultado) && isset($resultado[0]->exito) && $resultado[0]->exito == 1) {
                return redirect()->route('socio.notas.index')
                    ->with('success', $resultado[0]->mensaje ?? '¡Nota eliminada correctamente!');
            } else {
                return redirect()->route('socio.notas.index')
                    ->with('error', $resultado[0]->mensaje ?? 'No se pudo eliminar la nota.');
            }
        } catch (\Exception $e) {
            return redirect()->route('socio.notas.index')
                ->with('error', 'Error al eliminar la nota: ' . $e->getMessage());
        }
    }

    public function storeNota(Request $request)
    {
        $this->authorize('notas.crear');
        
        // Validar datos básicos
        $validated = $request->validate([
            'titulo' => 'required|string|min:5|max:200',
            'categoria' => 'required|in:proyecto,reunion,capacitacion,idea,personal',
            'visibilidad' => 'required|in:publica,privada',
            'contenido' => 'required|string|min:10',
            'etiquetas' => 'nullable|string|max:500'
        ], [
            'titulo.required' => 'El título es obligatorio',
            'titulo.min' => 'El título debe tener al menos 5 caracteres',
            'titulo.max' => 'El título no puede exceder 200 caracteres',
            'categoria.required' => 'Debes seleccionar una categoría',
            'categoria.in' => 'La categoría seleccionada no es válida',
            'visibilidad.required' => 'Debes seleccionar la visibilidad',
            'visibilidad.in' => 'La visibilidad seleccionada no es válida',
            'contenido.required' => 'El contenido es obligatorio',
            'contenido.min' => 'El contenido debe tener al menos 10 caracteres',
            'etiquetas.max' => 'Las etiquetas no pueden exceder 500 caracteres',
        ]);

        // Validaciones adicionales de contenido
        $erroresAdicionales = [];

        // Validar letras repetidas en título
        if (!$this->validarLetrasRepetidas($validated['titulo'])) {
            $erroresAdicionales['titulo'] = 'El título contiene letras repetidas más de 3 veces consecutivas';
        }

        // Validar caracteres especiales en título
        if (!$this->validarCaracteresEspeciales($validated['titulo'])) {
            $erroresAdicionales['titulo'] = 'El título contiene demasiados caracteres especiales consecutivos';
        }

        // Validar mayúsculas excesivas en título
        if (!$this->validarMayusculas($validated['titulo'])) {
            $erroresAdicionales['titulo'] = 'El título contiene demasiadas mayúsculas';
        }

        // Validar letras repetidas en contenido
        if (!$this->validarLetrasRepetidas($validated['contenido'])) {
            $erroresAdicionales['contenido'] = 'El contenido contiene letras repetidas más de 3 veces consecutivas';
        }

        // Validar texto coherente en contenido
        if (!$this->validarTextoCoherente($validated['contenido'])) {
            $erroresAdicionales['contenido'] = 'El contenido debe contener texto coherente';
        }

        // Si hay errores adicionales, retornar con errores
        if (!empty($erroresAdicionales)) {
            return back()->withErrors($erroresAdicionales)->withInput();
        }

        try {
            $userId = Auth::id();

            // Llamar al stored procedure SP_CrearNota
            $resultado = DB::select('CALL SP_CrearNota(?, ?, ?, ?, ?, ?, ?)', [
                $userId,
                $validated['titulo'],
                $validated['contenido'],
                $validated['categoria'],
                $validated['visibilidad'],
                $validated['etiquetas'] ?? null,
                null // fecha_recordatorio
            ]);

            if (!empty($resultado) && isset($resultado[0]->exito) && $resultado[0]->exito == 1) {
                $notaId = $resultado[0]->nota_id;
                
                return redirect()->route('socio.notas.ver', $notaId)
                    ->with('success', $resultado[0]->mensaje ?? '¡Nota creada exitosamente!');
            } else {
                return back()
                    ->withErrors(['error' => $resultado[0]->mensaje ?? 'No se pudo crear la nota.'])
                    ->withInput();
            }

        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Ocurrió un error al crear la nota: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function updateNota(Request $request, $id)
    {
        $this->authorize('notas.editar');
        
        // Validar datos básicos
        $validated = $request->validate([
            'titulo' => 'required|string|min:5|max:200',
            'categoria' => 'required|in:proyecto,reunion,capacitacion,idea,personal',
            'visibilidad' => 'required|in:publica,privada',
            'contenido' => 'required|string|min:10',
            'etiquetas' => 'nullable|string|max:500'
        ], [
            'titulo.required' => 'El título es obligatorio',
            'titulo.min' => 'El título debe tener al menos 5 caracteres',
            'titulo.max' => 'El título no puede exceder 200 caracteres',
            'categoria.required' => 'Debes seleccionar una categoría',
            'categoria.in' => 'La categoría seleccionada no es válida',
            'visibilidad.required' => 'Debes seleccionar la visibilidad',
            'visibilidad.in' => 'La visibilidad seleccionada no es válida',
            'contenido.required' => 'El contenido es obligatorio',
            'contenido.min' => 'El contenido debe tener al menos 10 caracteres',
            'etiquetas.max' => 'Las etiquetas no pueden exceder 500 caracteres',
        ]);

        // Validaciones adicionales de contenido
        $erroresAdicionales = [];

        if (!$this->validarLetrasRepetidas($validated['titulo'])) {
            $erroresAdicionales['titulo'] = 'El título contiene letras repetidas más de 3 veces consecutivas';
        }

        if (!$this->validarCaracteresEspeciales($validated['titulo'])) {
            $erroresAdicionales['titulo'] = 'El título contiene demasiados caracteres especiales consecutivos';
        }

        if (!$this->validarMayusculas($validated['titulo'])) {
            $erroresAdicionales['titulo'] = 'El título contiene demasiadas mayúsculas';
        }

        if (!$this->validarLetrasRepetidas($validated['contenido'])) {
            $erroresAdicionales['contenido'] = 'El contenido contiene letras repetidas más de 3 veces consecutivas';
        }

        if (!$this->validarTextoCoherente($validated['contenido'])) {
            $erroresAdicionales['contenido'] = 'El contenido debe contener texto coherente';
        }

        if (!empty($erroresAdicionales)) {
            return back()->withErrors($erroresAdicionales)->withInput();
        }

        try {
            $userId = Auth::id();

            // Llamar al stored procedure SP_ActualizarNota
            $resultado = DB::select('CALL SP_ActualizarNota(?, ?, ?, ?, ?, ?, ?, ?)', [
                $userId,
                $id,
                $validated['titulo'],
                $validated['contenido'],
                $validated['categoria'],
                $validated['visibilidad'],
                $validated['etiquetas'] ?? null,
                null // fecha_recordatorio
            ]);

            if (!empty($resultado) && isset($resultado[0]->exito) && $resultado[0]->exito == 1) {
                return redirect()->route('socio.notas.ver', $id)
                    ->with('success', $resultado[0]->mensaje ?? '¡Nota actualizada correctamente!');
            } else {
                return back()
                    ->withErrors(['error' => $resultado[0]->mensaje ?? 'No se pudo actualizar la nota.'])
                    ->withInput();
            }

        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Ocurrió un error al actualizar la nota: ' . $e->getMessage()])
                ->withInput();
        }
    }

    // === PERFIL ===
    public function perfil()
    {
        $this->authorize('perfil.ver');
        
        $user = Auth::user();
        $miembro = DB::table('miembros')
            ->join('users', 'miembros.user_id', '=', 'users.id')
            ->where('users.id', $user->id)
            ->select('miembros.*', 'users.name', 'users.email', 'users.dni')
            ->first();
        
        if (!$miembro) {
            return back()->with('error', 'No se encontró información del miembro');
        }

        $proyectosActivos = DB::table('participaciones')
            ->where('MiembroID', $miembro->MiembroID)
            ->count();
            
        $reunionesAsistidas = DB::table('asistencias')
            ->where('MiembroID', $miembro->MiembroID)
            ->count();

        return view('modulos.socio.perfil-show', compact('miembro', 'proyectosActivos', 'reunionesAsistidas'));
    }

    public function perfilEditar()
    {
        $this->authorize('perfil.editar');
        return view('modulos.socio.perfil-editar');
    }

    public function actualizarPerfil(Request $request)
    {
        $this->authorize('perfil.editar');
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'username' => 'nullable|string|max:255|unique:users,username,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'interests' => 'nullable|string|max:255'
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->bio = $request->bio;
        $user->interests = $request->interests;
        $user->save();

        return redirect()->route('socio.perfil')->with('success', '¡Perfil actualizado correctamente!');
    }

    // === NOTIFICACIONES EN TIEMPO REAL ===
    public function notificaciones()
    {
        $this->authorize('notificaciones.ver');
        
        // Auto-marcar todas las notificaciones como leídas al entrar
        Notificacion::where('usuario_id', Auth::id())
            ->where('leida', false)
            ->update(['leida' => true, 'leida_en' => now()]);

        $notificaciones = Notificacion::where('usuario_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('modulos.socio.notificaciones', compact('notificaciones'));
    }

    public function marcarNotificacionLeida($id)
    {
        $this->authorize('notificaciones.ver');
        
        try {
            $notificacion = Notificacion::where('id', $id)
                ->where('usuario_id', Auth::id())
                ->firstOrFail();

            $notificacion->update(['leida' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Notificación marcada como leída'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al marcar notificación'
            ], 404);
        }
    }

    public function marcarTodasNotificacionesLeidas()
    {
        $this->authorize('notificaciones.ver');
        
        try {
            Notificacion::where('usuario_id', Auth::id())
                ->where('leida', false)
                ->update(['leida' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Todas las notificaciones han sido marcadas como leídas'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al marcar notificaciones'
            ], 500);
        }
    }

    public function verificarActualizaciones()
    {
        $this->authorize('notificaciones.ver');
        
        try {
            // Obtener notificaciones no leídas del usuario
            $notificaciones = Notificacion::where('usuario_id', Auth::id())
                ->where('leida', false)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            $tieneNoLeidas = $notificaciones->count() > 0;

            return response()->json([
                'success' => true,
                'tiene_notificaciones' => $tieneNoLeidas,
                'cantidad' => $notificaciones->count(),
                'notificaciones' => $notificaciones->map(function ($n) {
                    return [
                        'id' => $n->id,
                        'titulo' => $n->titulo,
                        'mensaje' => $n->mensaje,
                        'tipo' => $n->tipo,
                        'leida' => $n->leida,
                        'created_at' => $n->created_at->diffForHumans()
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar notificaciones',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}