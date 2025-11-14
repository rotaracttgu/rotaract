<?php

namespace App\Services;

use App\Models\Acta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ActaPdfService
{
    /**
     * Generar PDF del acta
     */
    public function generarPDF(Acta $acta)
    {
        $data = [
            'acta' => $acta,
            'creador' => $acta->creador,
            'fecha' => $acta->fecha_reunion->format('d \d\e F \d\e Y'),
        ];

        $pdf = Pdf::loadView('pdfs.acta', $data);
        $pdf->setPaper('a4', 'portrait');
        
        // Guardar el PDF
        $fileName = 'acta_' . $acta->id . '_' . time() . '.pdf';
        $path = 'actas/' . $fileName;
        
        Storage::disk('public')->put($path, $pdf->output());
        
        return [
            'path' => $path,
            'pdf' => $pdf
        ];
    }
    
    /**
     * Descargar PDF del acta
     */
    public function descargarPDF(Acta $acta)
    {
        $data = [
            'acta' => $acta,
            'creador' => $acta->creador,
            'fecha' => $acta->fecha_reunion->format('d \d\e F \d\e Y'),
        ];

        $pdf = Pdf::loadView('pdfs.acta', $data);
        $pdf->setPaper('a4', 'portrait');
        
        $fileName = 'Acta_' . str_replace(' ', '_', $acta->titulo) . '.pdf';
        
        return $pdf->download($fileName);
    }
}
