<?php

namespace App\Services;

use App\Models\Diploma;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class DiplomaPdfService
{
    /**
     * Generar PDF del diploma con diseño bonito
     */
    public function generarPDF(Diploma $diploma)
    {
        $data = [
            'diploma' => $diploma,
            'miembro' => $diploma->miembro,
            'emisor' => $diploma->emisor,
            'fecha_emision' => $diploma->fecha_emision->format('d \d\e F \d\e Y'),
        ];

        $pdf = Pdf::loadView('pdfs.diploma', $data);
        $pdf->setPaper('a4', 'landscape');
        
        // Guardar el PDF
        $fileName = 'diploma_' . $diploma->id . '_' . time() . '.pdf';
        $path = 'diplomas/' . $fileName;
        
        Storage::disk('public')->put($path, $pdf->output());
        
        return [
            'path' => $path,
            'pdf' => $pdf
        ];
    }
    
    /**
     * Descargar PDF del diploma
     */
    public function descargarPDF(Diploma $diploma)
    {
        $data = [
            'diploma' => $diploma,
            'miembro' => $diploma->miembro,
            'emisor' => $diploma->emisor,
            'fecha_emision' => $diploma->fecha_emision->format('d \d\e F \d\e Y'),
        ];

        $pdf = Pdf::loadView('pdfs.diploma', $data);
        $pdf->setPaper('a4', 'landscape');
        
        $fileName = 'Diploma_' . str_replace(' ', '_', $diploma->miembro->name) . '.pdf';
        
        return $pdf->download($fileName);
    }
}
