<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\CartaFormal;
use App\Models\CartaPatrocinio;
use App\Models\Proyecto;
use App\Http\Requests\CartaFormalRequest;
use App\Http\Requests\CartaPatrocinioRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

/**
 * Trait ManagesLetters
 *
 * Maneja toda la lógica compartida de gestión de cartas formales y de patrocinio
 * entre Presidente y Vicepresidente
 */
trait ManagesLetters
{
    // ============================================================================
    // CARTAS FORMALES
    // ============================================================================

    /**
     * Muestra la vista para gestionar y generar cartas formales
     */
    public function cartasFormales()
    {
        $this->authorize('cartas.ver');

        $cartas = CartaFormal::with('usuario')
                             ->orderBy('created_at', 'desc')
                             ->get();

        $estadisticas = [
            'total' => $cartas->count(),
            'borradores' => $cartas->where('estado', 'Borrador')->count(),
            'enviadas' => $cartas->where('estado', 'Enviada')->count(),
            'recibidas' => $cartas->where('estado', 'Recibida')->count(),
        ];

        $vista = $this->getLettersView('formales');
        return view($vista, compact('cartas', 'estadisticas'));
    }

    /**
     * Muestra los detalles de una carta formal
     */
    public function showCartaFormal($id)
    {
        $this->authorize('cartas.ver');
        $carta = CartaFormal::with('usuario')->findOrFail($id);
        return response()->json($carta);
    }

    /**
     * Almacena una nueva carta formal
     */
    public function storeCartaFormal(CartaFormalRequest $request)
    {
        $this->authorize('cartas.crear');

        $validated = $request->validated();

        if (empty($validated['numero_carta'])) {
            $validated['numero_carta'] = $this->generarNumeroCartaFormal();
        }

        $validated['usuario_id'] = auth()->id();
        $validated['estado'] = $validated['estado'] ?? 'Borrador';

        $carta = CartaFormal::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Carta formal creada exitosamente con número: ' . $validated['numero_carta'],
            'data' => $carta
        ]);
    }

    /**
     * Actualiza una carta formal existente
     */
    public function updateCartaFormal(CartaFormalRequest $request, $id)
    {
        $this->authorize('cartas.editar');

        $carta = CartaFormal::findOrFail($id);
        $validated = $request->validated();

        if (empty($validated['numero_carta'])) {
            $validated['numero_carta'] = $carta->numero_carta ?? $this->generarNumeroCartaFormal();
        }

        $carta->update($validated);

        return response()->json([
            'success' => true,
            'message' => '✓ Carta formal actualizada exitosamente.',
            'data' => $carta
        ]);
    }

    /**
     * Elimina una carta formal
     */
    public function destroyCartaFormal($id)
    {
        $this->authorize('cartas.eliminar');

        $carta = CartaFormal::findOrFail($id);
        $numeroCartaEliminada = $carta->numero_carta;
        $carta->delete();

        $route = $this->getLettersRoute('formales');
        return redirect()->route($route)
                        ->with('success', '✓ Carta formal ' . $numeroCartaEliminada . ' eliminada exitosamente.');
    }

    // ============================================================================
    // CARTAS DE PATROCINIO
    // ============================================================================

    /**
     * Muestra la vista para gestionar y generar cartas de patrocinio
     */
    public function cartasPatrocinio()
    {
        $this->authorize('cartas.ver');

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

        $vista = $this->getLettersView('patrocinio');
        return view($vista, compact('cartas', 'estadisticas', 'proyectos'));
    }

    /**
     * Muestra los detalles de una carta de patrocinio
     */
    public function showCartaPatrocinio($id)
    {
        $this->authorize('cartas.ver');
        $carta = CartaPatrocinio::with(['proyecto', 'usuario'])->findOrFail($id);
        return response()->json($carta);
    }

    /**
     * Almacena una nueva carta de patrocinio
     */
    public function storeCartaPatrocinio(CartaPatrocinioRequest $request)
    {
        $this->authorize('cartas.crear');

        $validated = $request->validated();

        if (empty($validated['numero_carta'])) {
            $validated['numero_carta'] = $this->generarNumeroCartaPatrocinio();
        }

        $validated['usuario_id'] = auth()->id();
        $validated['estado'] = $validated['estado'] ?? 'Pendiente';

        $carta = CartaPatrocinio::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Carta de patrocinio creada exitosamente con número: ' . $validated['numero_carta'],
            'data' => $carta
        ]);
    }

    /**
     * Actualiza una carta de patrocinio existente
     */
    public function updateCartaPatrocinio(CartaPatrocinioRequest $request, $id)
    {
        $this->authorize('cartas.editar');

        $carta = CartaPatrocinio::findOrFail($id);
        $validated = $request->validated();

        if (empty($validated['numero_carta'])) {
            $validated['numero_carta'] = $carta->numero_carta ?? $this->generarNumeroCartaPatrocinio();
        }

        if (empty($validated['fecha_solicitud'])) {
            $validated['fecha_solicitud'] = $carta->fecha_solicitud;
        }
        if (empty($validated['fecha_respuesta'])) {
            unset($validated['fecha_respuesta']);
        }

        $carta->update($validated);

        return response()->json([
            'success' => true,
            'message' => '✓ Carta de patrocinio actualizada exitosamente.',
            'data' => $carta
        ]);
    }

    /**
     * Elimina una carta de patrocinio
     */
    public function destroyCartaPatrocinio($id)
    {
        $this->authorize('cartas.eliminar');

        $carta = CartaPatrocinio::findOrFail($id);
        $numeroCartaEliminada = $carta->numero_carta;
        $carta->delete();

        $route = $this->getLettersRoute('patrocinio');
        return redirect()->route($route)
                        ->with('success', '✓ Carta de patrocinio ' . $numeroCartaEliminada . ' eliminada exitosamente.');
    }

    // ============================================================================
    // EXPORTACIÓN - PDF
    // ============================================================================

    /**
     * Exportar carta formal a PDF
     */
    public function exportarCartaFormalPDF($id)
    {
        $carta = CartaFormal::with('usuario')->findOrFail($id);

        $vista = $this->getLettersPdfView('formal');
        $pdf = Pdf::loadView($vista, compact('carta'));
        $pdf->setPaper('letter');

        $filename = 'carta-formal-' . $carta->numero_carta . '-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Exportar carta de patrocinio a PDF
     */
    public function exportarCartaPatrocinioPDF($id)
    {
        $carta = CartaPatrocinio::with(['proyecto', 'usuario'])->findOrFail($id);

        $vista = $this->getLettersPdfView('patrocinio');
        $pdf = Pdf::loadView($vista, compact('carta'));
        $pdf->setPaper('letter');

        $filename = 'carta-patrocinio-' . $carta->numero_carta . '-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    // ============================================================================
    // EXPORTACIÓN - WORD
    // ============================================================================

    /**
     * Exportar carta formal a Word
     */
    public function exportarCartaFormalWord($id)
    {
        $carta = CartaFormal::with('usuario')->findOrFail($id);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addText('CARTA FORMAL', ['bold' => true, 'size' => 16]);
        $section->addTextBreak();

        $section->addText('Número de Carta: ' . $carta->numero_carta, ['bold' => true]);
        $section->addText('Tipo: ' . $carta->tipo);
        $section->addText('Destinatario: ' . $carta->destinatario, ['bold' => true]);
        $section->addText('Fecha: ' . ($carta->fecha_envio ? $carta->fecha_envio->format('d/m/Y') : 'N/A'));
        $section->addTextBreak();

        $section->addText('Asunto: ' . $carta->asunto, ['bold' => true, 'size' => 12]);
        $section->addTextBreak();

        $section->addText('Contenido:', ['bold' => true]);
        $section->addText($carta->contenido);
        $section->addTextBreak(2);

        if ($carta->observaciones) {
            $section->addText('Observaciones:', ['bold' => true]);
            $section->addText($carta->observaciones);
        }

        $filename = 'carta-formal-' . $carta->numero_carta . '-' . now()->format('Y-m-d') . '.docx';

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');

        $objWriter->save('php://output');
        exit;
    }

    /**
     * Exportar carta de patrocinio a Word
     */
    public function exportarCartaPatrocinioWord($id)
    {
        $carta = CartaPatrocinio::with(['proyecto', 'usuario'])->findOrFail($id);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addText('CARTA DE PATROCINIO', ['bold' => true, 'size' => 16]);
        $section->addTextBreak();

        $section->addText('Número de Carta: ' . $carta->numero_carta, ['bold' => true]);
        $section->addText('Destinatario: ' . $carta->destinatario, ['bold' => true]);
        $section->addText('Proyecto: ' . ($carta->proyecto ? $carta->proyecto->Nombre : 'N/A'));
        $section->addText('Fecha Solicitud: ' . ($carta->fecha_solicitud ? $carta->fecha_solicitud->format('d/m/Y') : 'N/A'));
        $section->addText('Monto Solicitado: Q. ' . number_format($carta->monto_solicitado, 2), ['bold' => true]);
        $section->addTextBreak();

        if ($carta->descripcion) {
            $section->addText('Descripción:', ['bold' => true]);
            $section->addText($carta->descripcion);
            $section->addTextBreak();
        }

        $section->addText('Estado: ' . $carta->estado, ['bold' => true]);

        if ($carta->observaciones) {
            $section->addTextBreak();
            $section->addText('Observaciones:', ['bold' => true]);
            $section->addText($carta->observaciones);
        }

        $filename = 'carta-patrocinio-' . $carta->numero_carta . '-' . now()->format('Y-m-d') . '.docx';

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');

        $objWriter->save('php://output');
        exit;
    }

    // ============================================================================
    // EXPORTACIÓN - EXCEL
    // ============================================================================

    /**
     * Exportar todas las cartas formales a Excel
     */
    public function exportarCartasFormalesExcel()
    {
        $cartas = CartaFormal::with('usuario')->orderBy('created_at', 'desc')->get();

        $datos = [];
        foreach ($cartas as $carta) {
            $datos[] = [
                'Número Carta' => $carta->numero_carta,
                'Destinatario' => $carta->destinatario,
                'Asunto' => $carta->asunto,
                'Tipo' => $carta->tipo,
                'Estado' => $carta->estado,
                'Fecha Envío' => $carta->fecha_envio ? $carta->fecha_envio->format('d/m/Y') : 'N/A',
                'Creado Por' => $carta->usuario ? $carta->usuario->name : 'N/A',
                'Fecha Creación' => $carta->created_at->format('d/m/Y H:i')
            ];
        }

        $filename = 'cartas-formales-' . now()->format('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'r+');

        if (!empty($datos)) {
            fputcsv($handle, array_keys($datos[0]));
            foreach ($datos as $row) {
                fputcsv($handle, $row);
            }
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Content-Transfer-Encoding', 'binary');
    }

    /**
     * Exportar todas las cartas de patrocinio a Excel
     */
    public function exportarCartasPatrocinioExcel()
    {
        $cartas = CartaPatrocinio::with(['proyecto', 'usuario'])->orderBy('fecha_solicitud', 'desc')->get();

        $datos = [];
        foreach ($cartas as $carta) {
            $datos[] = [
                'Número Carta' => $carta->numero_carta,
                'Destinatario' => $carta->destinatario,
                'Proyecto' => $carta->proyecto ? $carta->proyecto->Nombre : 'N/A',
                'Monto Solicitado' => '$' . number_format($carta->monto_solicitado, 2),
                'Estado' => $carta->estado,
                'Fecha Solicitud' => $carta->fecha_solicitud ? $carta->fecha_solicitud->format('d/m/Y') : 'N/A',
                'Fecha Respuesta' => $carta->fecha_respuesta ? $carta->fecha_respuesta->format('d/m/Y') : 'N/A',
                'Creado Por' => $carta->usuario ? $carta->usuario->name : 'N/A',
                'Fecha Creación' => $carta->created_at->format('d/m/Y H:i')
            ];
        }

        $filename = 'cartas-patrocinio-' . now()->format('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'r+');

        if (!empty($datos)) {
            fputcsv($handle, array_keys($datos[0]));
            foreach ($datos as $row) {
                fputcsv($handle, $row);
            }
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Content-Transfer-Encoding', 'binary');
    }

    // ============================================================================
    // MÉTODOS AUXILIARES
    // ============================================================================

    /**
     * Genera un número automático para carta formal
     */
    protected function generarNumeroCartaFormal(): string
    {
        $year = now()->year;
        $ultimaCarta = CartaFormal::whereYear('created_at', $year)
                                  ->orderBy('id', 'desc')
                                  ->first();

        $numero = $ultimaCarta ? (int) substr($ultimaCarta->numero_carta, -4) + 1 : 1;

        return 'CF-' . $year . '-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Genera un número automático para carta de patrocinio
     */
    protected function generarNumeroCartaPatrocinio(): string
    {
        $year = now()->year;
        $ultimaCarta = CartaPatrocinio::whereYear('created_at', $year)
                                      ->orderBy('id', 'desc')
                                      ->first();

        $numero = $ultimaCarta ? (int) substr($ultimaCarta->numero_carta, -4) + 1 : 1;

        return 'CP-' . $year . '-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    // ============================================================================
    // MÉTODOS ABSTRACTOS - Implementados por los controladores
    // ============================================================================

    /**
     * Obtener la vista de cartas según el controlador
     */
    abstract protected function getLettersView(string $type): string;

    /**
     * Obtener la ruta de cartas según el controlador
     */
    abstract protected function getLettersRoute(string $type): string;

    /**
     * Obtener la vista PDF de cartas según el controlador
     */
    abstract protected function getLettersPdfView(string $type): string;
}
