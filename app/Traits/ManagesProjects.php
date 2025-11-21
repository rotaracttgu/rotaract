<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Proyecto;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * Trait ManagesProjects
 *
 * Maneja toda la lógica compartida de gestión de proyectos
 */
trait ManagesProjects
{
    /**
     * Muestra el estado y seguimiento de todos los proyectos
     */
    public function estadoProyectos()
    {
        $proyectos = Proyecto::with(['responsable', 'participaciones', 'cartasPatrocinio'])->get();

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

        $miembros = \App\Models\Miembro::with('user')->orderBy('user_id')->get();

        $vista = $this->getProjectsView();
        return view($vista, compact('proyectos', 'estadisticas', 'miembros'));
    }

    /**
     * Almacena un nuevo proyecto
     */
    public function storeProyecto(Request $request)
    {
        $this->authorize('proyectos.crear');

        $validated = $request->validate([
            'Nombre' => 'required|string|max:255',
            'Descripcion' => 'nullable|string',
            'FechaInicio' => 'nullable|date',
            'FechaFin' => 'nullable|date|after_or_equal:FechaInicio',
            'Presupuesto' => 'nullable|numeric|min:0',
            'TipoProyecto' => 'nullable|string|max:50',
            'ResponsableID' => 'nullable|exists:miembros,MiembroID',
        ]);

        $validated['Estatus'] = 'Activo';
        $validated['EstadoProyecto'] = $validated['FechaInicio'] ? 'En Ejecución' : 'Planificación';

        Proyecto::create($validated);

        $route = $this->getProjectsRoute();
        return redirect()->route($route)->with('success', 'Proyecto creado exitosamente.');
    }

    /**
     * Actualiza un proyecto existente
     */
    public function updateProyecto(Request $request, $id)
    {
        $this->authorize('proyectos.editar');

        $proyecto = Proyecto::findOrFail($id);

        $validated = $request->validate([
            'Nombre' => 'required|string|max:255',
            'Descripcion' => 'nullable|string',
            'FechaInicio' => 'nullable|date',
            'FechaFin' => 'nullable|date|after_or_equal:FechaInicio',
            'Presupuesto' => 'nullable|numeric|min:0',
            'TipoProyecto' => 'nullable|string|max:50',
            'ResponsableID' => 'nullable|exists:miembros,MiembroID',
            'Estatus' => 'nullable|in:Activo,Inactivo,Cancelado',
        ]);

        if (isset($validated['FechaFin']) && $validated['FechaFin']) {
            $validated['EstadoProyecto'] = 'Finalizado';
        } elseif (isset($validated['FechaInicio']) && $validated['FechaInicio']) {
            $validated['EstadoProyecto'] = 'En Ejecución';
        }

        $proyecto->update($validated);

        $route = $this->getProjectsRoute();
        return redirect()->route($route)->with('success', 'Proyecto actualizado exitosamente.');
    }

    /**
     * Elimina un proyecto
     */
    public function destroyProyecto($id)
    {
        $this->authorize('proyectos.eliminar');

        $proyecto = Proyecto::findOrFail($id);

        if ($proyecto->participacionesOriginales()->count() > 0 ||
            $proyecto->participaciones()->count() > 0 ||
            $proyecto->cartasPatrocinio()->count() > 0) {
            $route = $this->getProjectsRoute();
            return redirect()->route($route)
                            ->with('error', 'No se puede eliminar el proyecto porque tiene participaciones o cartas de patrocinio asociadas.');
        }

        $proyecto->delete();

        $route = $this->getProjectsRoute();
        return redirect()->route($route)->with('success', 'Proyecto eliminado exitosamente.');
    }

    /**
     * Obtener detalles completos de un proyecto
     */
    public function detallesProyecto($id)
    {
        $proyecto = Proyecto::with([
            'responsable',
            'participaciones.usuario',
            'participacionesOriginales.miembro',
            'cartasPatrocinio'
        ])->findOrFail($id);

        $proyecto->total_participantes = $proyecto->participaciones->count();
        $proyecto->horas_totales = $proyecto->participaciones->sum('horas_dedicadas');
        $proyecto->monto_patrocinio = $proyecto->cartasPatrocinio()
                                               ->where('estado', 'Aprobada')
                                               ->sum('monto_solicitado');
        $proyecto->total_participaciones_originales = $proyecto->participacionesOriginales->count();
        $proyecto->total_cartas_patrocinio = $proyecto->cartasPatrocinio->count();

        return response()->json($proyecto);
    }

    /**
     * Exportar proyectos a PDF o Excel
     */
    public function exportarProyectos(Request $request)
    {
        $formato = $request->input('formato', 'pdf');

        $proyectos = Proyecto::with(['responsable', 'participaciones', 'cartasPatrocinio'])->get();

        foreach ($proyectos as $proyecto) {
            $proyecto->total_participantes = $proyecto->participaciones->count();
            $proyecto->horas_totales = $proyecto->participaciones->sum('horas_dedicadas');
            $proyecto->monto_patrocinio = $proyecto->cartasPatrocinio()
                                                   ->where('estado', 'Aprobada')
                                                   ->sum('monto_solicitado');
        }

        if ($formato === 'excel') {
            return $this->exportarProyectosExcel($proyectos);
        } else {
            return $this->exportarProyectosPDF($proyectos);
        }
    }

    /**
     * Exportar proyectos a PDF
     */
    protected function exportarProyectosPDF($proyectos)
    {
        $vista = $this->getProjectsPdfView();
        $pdf = Pdf::loadView($vista, compact('proyectos'));
        return $pdf->download('proyectos-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Exportar proyectos a Excel (CSV)
     */
    protected function exportarProyectosExcel($proyectos)
    {
        $datos = [];
        foreach ($proyectos as $proyecto) {
            $datos[] = [
                'ID' => $proyecto->ProyectoID,
                'Nombre' => $proyecto->Nombre,
                'Descripción' => $proyecto->Descripcion ?? '',
                'Fecha Inicio' => $proyecto->FechaInicio ? $proyecto->FechaInicio->format('d/m/Y') : 'N/A',
                'Fecha Fin' => $proyecto->FechaFin ? $proyecto->FechaFin->format('d/m/Y') : 'En curso',
                'Estado' => $proyecto->EstadoProyecto ?? $proyecto->Estatus,
                'Presupuesto' => '$' . number_format($proyecto->Presupuesto ?? 0, 2),
                'Tipo' => $proyecto->TipoProyecto ?? 'N/A',
                'Responsable' => $proyecto->responsable ? $proyecto->responsable->Nombre : 'N/A',
                'Participantes' => $proyecto->total_participantes ?? 0,
                'Horas Totales' => $proyecto->horas_totales ?? 0,
                'Monto Patrocinio' => '$' . number_format($proyecto->monto_patrocinio ?? 0, 2),
            ];
        }

        $filename = 'proyectos-' . now()->format('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'r+');

        fputcsv($handle, array_keys($datos[0] ?? []));
        foreach ($datos as $row) {
            fputcsv($handle, $row);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    // Métodos abstractos
    abstract protected function getProjectsView(): string;
    abstract protected function getProjectsRoute(): string;
    abstract protected function getProjectsPdfView(): string;
}
