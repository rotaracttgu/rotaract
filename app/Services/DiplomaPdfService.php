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
        try {
            $data = [
                'diploma' => $diploma,
                'miembro' => $diploma->miembro,
                'emisor' => $diploma->emisor,
                'fecha_emision' => $diploma->fecha_emision->format('d \d\e F \d\e Y'),
            ];

            // Verificar que la vista existe
            if (!view()->exists('pdfs.diploma')) {
                throw new \Exception('La vista pdfs.diploma no existe');
            }

            $pdf = Pdf::loadView('pdfs.diploma', $data);
            $pdf->setPaper('a4', 'landscape');
            
            // Crear directorio si no existe
            $directory = 'diplomas';
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            
            // Guardar el PDF
            $fileName = 'diploma_' . $diploma->id . '_' . time() . '.pdf';
            $path = $directory . '/' . $fileName;
            
            $pdfContent = $pdf->output();
            
            // Verificar que el PDF tiene contenido
            if (empty($pdfContent)) {
                throw new \Exception('El PDF generado está vacío');
            }
            
            Storage::disk('public')->put($path, $pdfContent);
            
            // Verificar que el archivo se guardó correctamente
            if (!Storage::disk('public')->exists($path)) {
                throw new \Exception('El archivo PDF no se pudo guardar');
            }
            
            return [
                'path' => $path,
                'pdf' => $pdf
            ];
        } catch (\Exception $e) {
            // Log del error
            \Log::error('Error generando PDF del diploma: ' . $e->getMessage(), [
                'diploma_id' => $diploma->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
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
