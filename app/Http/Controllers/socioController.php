<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocioController extends Controller
{
    public function dashboard()
    {
        // DATOS MOCK (sin BD)
        $proximasReuniones = collect([
            (object)[
                'ReunionID' => 1,
                'titulo' => 'Reunión General del Club',
                'descripcion' => 'Revisión de proyectos y planificación mensual.',
                'fecha_hora' => '2025-11-10 18:00:00',
                'lugar' => 'Sala Principal',
                'tipo' => 'Ordinaria',
                'estado' => 'Programada'
            ],
            (object)[
                'ReunionID' => 2,
                'titulo' => 'Capacitación: Liderazgo',
                'descripcion' => 'Taller sobre habilidades de liderazgo.',
                'fecha_hora' => '2025-11-15 16:00:00',
                'lugar' => 'Zoom',
                'tipo' => 'Extraordinaria',
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

        return view('modulos.socio.dashboard', [
            'proximasReuniones' => $proximasReuniones,
            'proyectosActivos' => $proyectosActivos,
            'consultasSecretariaPendientes' => 2,
            'consultasVoceriaPendientes' => 1,
            'notasActivas' => 3
        ]);
    }

    public function calendario()
    {
        return view('modulos.socio.calendario-consulta');
    }

    public function obtenerEventosCalendario($year, $month)
    {
        $eventos = [
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
        ];

        return response()->json($eventos);
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
        return redirect()->route('socio.secretaria.index')
            ->with('success', 'Consulta enviada (modo demo)');
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
            'Respuesta' => null
        ];

        $historial = collect([]); // empty conversation for demo

        return view('modulos.socio.ver-consulta-secretaria', compact('consulta', 'historial'));
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
        $request->validate([
            'titulo' => 'required|string|max:200',
            'categoria' => 'required|in:proyecto,reunion,capacitacion,idea,personal',
            'visibilidad' => 'required|in:publica,privada',
            'contenido' => 'required|string',
            'etiquetas' => 'nullable|string|max:500'
        ]);

        $id = rand(100, 999);

        session()->flash('success', '¡Nota creada exitosamente!');

        return redirect()->route('socio.notas.ver', $id);
    }

    public function updateNota(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'categoria' => 'required|in:proyecto,reunion,capacitacion,idea,personal',
            'visibilidad' => 'required|in:publica,privada',
            'contenido' => 'required|string',
            'etiquetas' => 'nullable|string|max:500'
        ]);

        session()->flash('success', '¡Nota actualizada correctamente!');

        return redirect()->route('socio.notas.ver', $id);
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

        return view('modulos.socio.perfil', compact('miembro'));
    }

    public function actualizarPerfil(Request $request)
    {
        return back()->with('success', 'Perfil actualizado (modo demo)');
    }
}