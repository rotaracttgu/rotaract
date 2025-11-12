<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Services\NotificacionService;
use App\Models\Notificacion;

class SocioController extends Controller
{
    public function dashboard()
    {
        // Obtener datos reales de la BD con queries seguras
        try {
            // Próximas reuniones (solo del usuario actual)
            $proximasReuniones = DB::table('reunions')
                ->where('estado', 'Programada')
                ->orderBy('fecha_hora')
                ->limit(5)
                ->get(['ReunionID', 'titulo', 'descripcion', 'fecha_hora', 'lugar', 'tipo', 'estado']);
            
            if ($proximasReuniones->isEmpty()) {
                $proximasReuniones = collect([
                    (object)[
                        'ReunionID' => 1,
                        'titulo' => 'Reunión General del Club',
                        'descripcion' => 'Revisión de proyectos y planificación mensual.',
                        'fecha_hora' => '2025-11-10 18:00:00',
                        'lugar' => 'Sala Principal',
                        'tipo' => 'Ordinaria',
                        'estado' => 'Programada'
                    ]
                ]);
            }

            // Proyectos activos donde participa el usuario
            $proyectosActivos = DB::table('proyectos')
                ->where('estado', 'Activo')
                ->limit(3)
                ->get(['ProyectoID', 'nombre as NombreProyecto', 'descripcion as DescripcionProyecto', 'tipo as TipoProyecto', 'estado as EstadoProyecto']);
            
            if ($proyectosActivos->isEmpty()) {
                $proyectosActivos = collect([
                    (object)[
                        'ProyectoID' => 1,
                        'NombreProyecto' => 'Campaña de Donación',
                        'DescripcionProyecto' => 'Recolección de alimentos para comunidades.',
                        'TipoProyecto' => 'Social',
                        'EstadoProyecto' => 'Activo'
                    ]
                ]);
            }

            // Contar consultas pendientes
            $consultasSecretariaPendientes = DB::table('consultas')
                ->where('estado', 'Pendiente')
                ->where('usuario_id', Auth::id())
                ->count();
                
            $notasActivas = DB::table('notas')
                ->where('usuario_id', Auth::id())
                ->count();

        } catch (\Exception $e) {
            // En caso de error, usar datos mock
            $proximasReuniones = collect([
                (object)[
                    'ReunionID' => 1,
                    'titulo' => 'Reunión General del Club',
                    'descripcion' => 'Revisión de proyectos y planificación mensual.',
                    'fecha_hora' => '2025-11-10 18:00:00',
                    'lugar' => 'Sala Principal',
                    'tipo' => 'Ordinaria',
                    'estado' => 'Programada'
                ]
            ]);

            $proyectosActivos = collect([
                (object)[
                    'ProyectoID' => 1,
                    'NombreProyecto' => 'Campaña de Donación',
                    'DescripcionProyecto' => 'Recolección de alimentos para comunidades.',
                    'TipoProyecto' => 'Social',
                    'EstadoProyecto' => 'Activo'
                ]
            ]);

            $consultasSecretariaPendientes = 0;
            $notasActivas = 0;
        }

        return view('modulos.socio.dashboard', [
            'proximasReuniones' => $proximasReuniones,
            'proyectosActivos' => $proyectosActivos,
            'consultasSecretariaPendientes' => $consultasSecretariaPendientes,
            'consultasVoceriaPendientes' => 0,
            'notasActivas' => $notasActivas
        ]);
    }

    public function calendario()
    {
        return view('modulos.socio.calendario-consulta');
    }

    public function obtenerEventosCalendario($year, $month)
    {
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

    public function misProyectos()
    {
        $proyectos = collect([
            (object)[
                'ProyectoID' => 1,
                'NombreProyecto' => 'Campaña de Donación',
                'DescripcionProyecto' => 'Recolección de alimentos.',
                'TipoProyecto' => 'Social',
                'EstadoProyecto' => 'Activo',
                'FechaInicio' => '2025-11-01',
                'FechaFin' => '2025-12-20',
                'NombreResponsable' => 'Ana López',
                'Presupuesto' => 25000.00,
                'RolProyecto' => 'Líder'
            ]
        ]);

        return view('modulos.socio.mis-proyectos', compact('proyectos'));
    }

    public function detalleProyecto($id)
    {
        $proyecto = (object)[
            'ProyectoID' => $id,
            'NombreProyecto' => 'Campaña de Donación',
            'DescripcionProyecto' => 'Recolección de alimentos para comunidades vulnerables.',
            'TipoProyecto' => 'Social',
            'EstadoProyecto' => 'Activo',
            'FechaInicio' => '2025-11-01',
            'FechaFin' => '2025-12-20',
            'NombreResponsable' => 'Ana López',
            'CorreoResponsable' => 'ana@club.com',
            'Presupuesto' => 25000.00,
            'RolProyecto' => 'Líder'
        ];

        $participantes = collect([
            (object)['Nombre' => 'Lord Leo', 'Correo' => 'lord@gmail.com', 'RolProyecto' => 'Líder'],
            (object)['Nombre' => 'María Pérez', 'Correo' => 'maria@club.com', 'RolProyecto' => 'Apoyo']
        ]);

        return view('modulos.socio.detalle-proyecto', compact('proyecto', 'participantes'));
    }

    public function misReuniones(Request $request)
    {
        $filtroEstado = $request->get('estado', 'todas');

        $reuniones = collect([
            (object)[
                'ReunionID' => 1,
                'titulo' => 'Reunión General',
                'descripcion' => 'Revisión mensual.',
                'fecha_hora' => '2025-11-10 18:00:00',
                'lugar' => 'Sala Principal',
                'tipo' => 'Ordinaria',
                'estado' => 'Programada'
            ]
        ]);

        return view('modulos.socio.mis-reuniones', compact('reuniones', 'filtroEstado'));
    }

    public function detalleReunion($id)
    {
        $reunion = (object)[
            'ReunionID' => $id,
            'titulo' => 'Reunión General',
            'descripcion' => 'Revisión mensual del club.',
            'fecha_hora' => '2025-11-10 18:00:00',
            'lugar' => 'Sala Principal',
            'tipo' => 'Ordinaria',
            'estado' => 'Programada',
            'asistentes' => 25,
            'confirmados' => 20
        ];

        return view('modulos.socio.detalle-reunion', compact('reunion'));
    }

    // === COMUNICACIÓN SECRETARÍA ===
    public function comunicacionSecretaria()
    {
        $consultas = collect([
            (object)[
                'ConsultaID' => 1,
                'Asunto' => 'Solicitud de certificado',
                'Categoria' => 'Documentacion',
                'Estado' => 'Pendiente',
                'FechaEnvio' => '07/11/2025 04:10 PM'
            ]
        ]);

        return view('modulos.socio.comunicacion-secretaria', compact('consultas'));
    }

    public function crearConsultaSecretaria()
    {
        return view('modulos.socio.crear-consulta-secretaria');
    }

    public function storeConsultaSecretaria(Request $request)
    {
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

            // Aquí guardarías en la base de datos
            // Ejemplo (ajusta según tu estructura de BD):
            /*
            DB::table('consultas')->insert([
                'usuario_id' => Auth::id(),
                'asunto' => $validated['asunto'],
                'tipo' => $validated['tipo'],
                'mensaje' => $validated['mensaje'],
                'comprobante_ruta' => $comprobanteRuta,
                'estado' => 'Pendiente',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            */

            return redirect()->route('socio.secretaria.index')
                ->with('success', '¡Consulta enviada exitosamente! La Secretaría la revisará pronto.');

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
        // Mock consulta: provide the fields expected by the Blade view to avoid undefined/null parsing errors
        $consulta = (object)[
            'ConsultaID' => $id,
            'Asunto' => 'Solicitud de certificado',
            'Mensaje' => 'Necesito un certificado de membresía para presentar en mi empresa. ¿Pueden emitirlo con fecha de este mes?',
            'Categoria' => 'Documentacion',
            'Estado' => 'Pendiente',
            // Blade expects FechaConsulta (used with Carbon::parse)
            'FechaConsulta' => '2025-11-07 16:10:00',
            // Prioridad (Alta/Media/Baja) - view shows badges
            'Prioridad' => 'Media',
            // When answered these will be filled; keep null for demo
            'FechaRespuesta' => null,
            'RespondidoPor' => null,
            'Respuesta' => null,
            'comprobante_ruta' => null, // Ruta del comprobante si existe
        ];

        $historial = collect([]); // empty conversation for demo

        return view('modulos.socio.ver-consulta-secretaria', compact('consulta', 'historial'));
    }

    public function responderConsultaSecretaria(Request $request, $id)
    {
        $request->validate([
            'respuesta' => 'required|string|max:1000'
        ]);

        // Mock: guardar respuesta (en BD iría en tabla)
        session()->flash('success', '¡Respuesta enviada correctamente!');

        return redirect()->route('socio.secretaria.ver', $id);
    }

    // === COMUNICACIÓN VOCERÍA ===
    public function comunicacionVoceria()
    {
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
        return view('modulos.socio.crear-consulta-voceria');
    }

    public function storeConsultaVoceria(Request $request)
    {
        return redirect()->route('socio.voceria.index')
            ->with('success', 'Solicitud enviada (modo demo)');
    }

    public function verConsultaVoceria($id)
    {
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
        $filtroCategoria = $request->get('categoria', 'todas');
        $filtroVisibilidad = $request->get('visibilidad', 'todas');

        $notas = collect([
            (object)[
                'NotaID' => 1,
                'Titulo' => 'Idea para proyecto',
                'Contenido' => 'Campaña de reciclaje en escuelas. Involucrar a estudiantes y padres.',
                'Categoria' => 'idea',
                'Visibilidad' => 'privada',
                'FechaCreacion' => '2025-11-07 14:30:00',
                'Etiquetas' => 'reciclaje,escuelas,medioambiente'
            ],
            (object)[
                'NotaID' => 2,
                'Titulo' => 'Apuntes reunión mensual',
                'Contenido' => 'Se aprobó el presupuesto del proyecto social. Próxima reunión: 15/11. Responsable: Ana.',
                'Categoria' => 'reunion',
                'Visibilidad' => 'privada',
                'FechaCreacion' => '2025-11-06 10:00:00',
                'Etiquetas' => 'reunion,presupuesto,proyectos'
            ],
            (object)[
                'NotaID' => 3,
                'Titulo' => 'Capacitación en liderazgo',
                'Contenido' => 'Taller con experto externo. Fecha: 20/11. Inscribirse antes del 18.',
                'Categoria' => 'capacitacion',
                'Visibilidad' => 'publica',
                'FechaCreacion' => '2025-11-05 16:45:00',
                'Etiquetas' => 'liderazgo,capacitacion'
            ]
        ]);

        if ($filtroCategoria !== 'todas') {
            $notas = $notas->where('Categoria', $filtroCategoria);
        }
        if ($filtroVisibilidad !== 'todas') {
            $notas = $notas->where('Visibilidad', $filtroVisibilidad);
        }

        return view('modulos.socio.blog-notas', compact('notas', 'filtroCategoria', 'filtroVisibilidad'));
    }

    public function crearNota()
    {
        return view('modulos.socio.crear-nota');
    }

    public function verNota($id)
    {
        $datos = [
            1 => [
                'Titulo' => 'Idea para proyecto',
                'Contenido' => 'Campaña de reciclaje en escuelas. Involucrar a estudiantes y padres. Presupuesto estimado: L. 15,000. Fecha tentativa: Marzo 2026.',
                'Categoria' => 'idea',
                'Visibilidad' => 'privada',
                'FechaCreacion' => '2025-11-07 14:30:00',
                'FechaActualizacion' => '2025-11-07 16:45:00',
                'Etiquetas' => 'reciclaje, escuelas, medioambiente, comunidad'
            ],
            2 => [
                'Titulo' => 'Apuntes reunión mensual',
                'Contenido' => 'Se aprobó el presupuesto del proyecto social. Próxima reunión: 15/11. Responsable: Ana.',
                'Categoria' => 'reunion',
                'Visibilidad' => 'privada',
                'FechaCreacion' => '2025-11-06 10:00:00',
                'FechaActualizacion' => null,
                'Etiquetas' => 'reunion, presupuesto, proyectos'
            ],
            3 => [
                'Titulo' => 'Capacitación en liderazgo',
                'Contenido' => 'Taller con experto externo. Fecha: 20/11. Inscribirse antes del 18.',
                'Categoria' => 'capacitacion',
                'Visibilidad' => 'publica',
                'FechaCreacion' => '2025-11-05 16:45:00',
                'FechaActualizacion' => '2025-11-06 09:20:00',
                'Etiquetas' => 'liderazgo, capacitacion'
            ]
        ];

        $data = $datos[$id] ?? $datos[1];

        $nota = (object) array_merge([
            'NotaID' => $id,
            'Estado' => 'activa',
            'NombreAutor' => 'Tú'
        ], $data);

        return view('modulos.socio.ver-nota', compact('nota'));
    }

    public function editarNota($id)
    {
        $datos = [
            1 => [
                'Titulo' => 'Idea para proyecto',
                'Contenido' => 'Campaña de reciclaje en escuelas. Involucrar a estudiantes y padres. Presupuesto estimado: L. 15,000. Fecha tentativa: Marzo 2026.',
                'Categoria' => 'idea',
                'Visibilidad' => 'privada',
                'Etiquetas' => 'reciclaje, escuelas, medioambiente, comunidad',
                'FechaCreacion' => '2025-11-07 14:30:00',
                'FechaActualizacion' => '2025-11-07 16:45:00'
            ],
            2 => [
                'Titulo' => 'Apuntes reunión mensual',
                'Contenido' => 'Se aprobó el presupuesto del proyecto social. Próxima reunión: 15/11. Responsable: Ana.',
                'Categoria' => 'reunion',
                'Visibilidad' => 'privada',
                'Etiquetas' => 'reunion, presupuesto, proyectos',
                'FechaCreacion' => '2025-11-06 10:00:00',
                'FechaActualizacion' => null
            ],
            3 => [
                'Titulo' => 'Capacitación en liderazgo',
                'Contenido' => 'Taller con experto externo. Fecha: 20/11. Inscribirse antes del 18.',
                'Categoria' => 'capacitacion',
                'Visibilidad' => 'publica',
                'Etiquetas' => 'liderazgo, capacitacion',
                'FechaCreacion' => '2025-11-05 16:45:00',
                'FechaActualizacion' => '2025-11-06 09:20:00'
            ]
        ];

        $data = $datos[$id] ?? $datos[1];

        $nota = (object) array_merge([
            'NotaID' => $id,
            'Estado' => 'activa'
        ], $data);

        return view('modulos.socio.editar-nota', compact('nota'));
    }

    public function eliminarNota($id)
    {
        session()->flash('success', '¡Nota eliminada correctamente!');

        return redirect()->route('socio.notas.index');
    }

    public function storeNota(Request $request)
    {
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
            // Aquí guardarías en la base de datos
            // Ejemplo:
            /*
            DB::table('notas')->insert([
                'usuario_id' => Auth::id(),
                'titulo' => $validated['titulo'],
                'categoria' => $validated['categoria'],
                'visibilidad' => $validated['visibilidad'],
                'contenido' => $validated['contenido'],
                'etiquetas' => $validated['etiquetas'],
                'estado' => 'activa',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            */

            $id = rand(100, 999);

            session()->flash('success', '¡Nota creada exitosamente!');

            return redirect()->route('socio.notas.ver', $id);

        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Ocurrió un error al crear la nota. Por favor, intenta nuevamente.'])
                ->withInput();
        }
    }

    public function updateNota(Request $request, $id)
    {
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
            // Aquí actualizarías en la base de datos
            /*
            DB::table('notas')
                ->where('NotaID', $id)
                ->where('usuario_id', Auth::id())
                ->update([
                    'titulo' => $validated['titulo'],
                    'categoria' => $validated['categoria'],
                    'visibilidad' => $validated['visibilidad'],
                    'contenido' => $validated['contenido'],
                    'etiquetas' => $validated['etiquetas'],
                    'updated_at' => now(),
                ]);
            */

            session()->flash('success', '¡Nota actualizada correctamente!');

            return redirect()->route('socio.notas.ver', $id);

        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Ocurrió un error al actualizar la nota. Por favor, intenta nuevamente.'])
                ->withInput();
        }
    }

    // === PERFIL ===
    public function perfil()
    {
        $miembro = (object)[
            'Nombre' => Auth::user()->name,
            'Correo' => Auth::user()->email,
            'Rol' => 'Socio',
            'DNI_Pasaporte' => '0801-2001-14521',
            'Apuntes' => 'Aspirante activo'
        ];

        $proyectosActivos = 5;
        $reunionesAsistidas = 12;

        return view('modulos.socio.perfil-show', compact('miembro', 'proyectosActivos', 'reunionesAsistidas'));
    }

    public function perfilEditar()
    {
        return view('modulos.socio.perfil-editar');
    }

    public function actualizarPerfil(Request $request)
    {
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