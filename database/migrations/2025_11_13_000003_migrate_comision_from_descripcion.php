<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Extraer comisiones y referencias que estén incrustadas en el campo `descripcion`.
        // Patrones buscados (no exhaustivos):
        // - "Comisión: 12.34" or "Comisión: 12,34" or "Comisión: L. 12.34"
        // - "Ref: ABC123" or "Referencia: ABC123" or strings tipo TRF-2025-XXXX

        DB::table('gastos')
            ->where('tipo', 'transferencia')
            ->whereNull('comision')
            ->orderBy('id')
            ->chunkById(100, function($rows) {
                foreach ($rows as $row) {
                    $descripcion = $row->descripcion ?? '';
                    $comision = null;
                    $referencia = null;

                    // Buscar patrón de comisión: capturar números, puntos y comas
                    if (preg_match('/Comisi[oó]n[:\s]*L?\.?\s*([\d\.,]+)/i', $descripcion, $m)) {
                        $comisionStr = $m[1];
                    } elseif (preg_match('/Comisi[oó]n[:\s]*([\d\.,]+)/i', $descripcion, $m)) {
                        $comisionStr = $m[1];
                    } else {
                        $comisionStr = null;
                    }

                    if ($comisionStr) {
                        // Normalizar: eliminar separadores de miles (comas) y convertir coma decimal a punto
                        $normalized = str_replace(['.', ','], ['', '.'], $comisionStr);
                        // Si la normalización anterior queda mal (por ejemplo '2500' -> ''), fallback:
                        $normalized = preg_replace('/[^0-9\.\-]/', '', $normalized);
                        $comision = floatval($normalized);
                    }

                    // Buscar referencia explícita
                    if (preg_match('/\bTRF[-_A-Z0-9]+\b/i', $descripcion, $m)) {
                        $referencia = $m[0];
                    } elseif (preg_match('/Ref(?:erencia)?[:\s]*([A-Za-z0-9\-\_]+)/i', $descripcion, $m)) {
                        $referencia = $m[1];
                    }

                    // Si encontramos algo, actualizar la fila
                    $data = [];
                    if (!is_null($comision)) {
                        $data['comision'] = $comision;
                    }
                    if (!is_null($referencia) && empty($row->referencia)) {
                        $data['referencia'] = $referencia;
                    }

                    if (!empty($data)) {
                        DB::table('gastos')->where('id', $row->id)->update($data);
                    }
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir: setear a NULL las comisiones que coincidan con un patrón en la descripción
        DB::table('gastos')
            ->where('tipo', 'transferencia')
            ->whereNotNull('comision')
            ->orderBy('id')
            ->chunkById(100, function($rows) {
                foreach ($rows as $row) {
                    $descripcion = $row->descripcion ?? '';
                    // Si la descripcion contiene la palabra 'Comisión' asumimos que fue migrada por esta migration
                    if (preg_match('/Comisi[oó]n/i', $descripcion)) {
                        DB::table('gastos')->where('id', $row->id)->update(['comision' => null]);
                    }
                }
            });
    }
};
