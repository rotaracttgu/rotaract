<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Procedimiento almacenado para generar reporte de diplomas por período.
     * Parámetros: fecha_inicio, fecha_fin, tipo (opcional)
     */
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS SP_ReporteDiplomas');
        
        DB::unprepared("
            CREATE PROCEDURE SP_ReporteDiplomas(
                IN p_fecha_inicio DATE,
                IN p_fecha_fin DATE,
                IN p_tipo VARCHAR(50)
            )
            BEGIN
                SELECT 
                    d.id,
                    d.tipo,
                    d.motivo,
                    d.fecha_emision,
                    d.enviado_email,
                    d.fecha_envio_email,
                    u.name AS miembro_nombre,
                    u.email AS miembro_email,
                    emisor.name AS emisor_nombre,
                    d.created_at AS fecha_creacion,
                    CASE 
                        WHEN d.archivo_path IS NOT NULL THEN 'Con archivo'
                        ELSE 'Sin archivo'
                    END AS estado_archivo
                FROM diplomas d
                INNER JOIN users u ON d.miembro_id = u.id
                LEFT JOIN users emisor ON d.emitido_por = emisor.id
                WHERE d.fecha_emision BETWEEN p_fecha_inicio AND p_fecha_fin
                    AND (p_tipo IS NULL OR p_tipo = '' OR d.tipo = p_tipo)
                ORDER BY d.fecha_emision DESC, d.created_at DESC;
                
                -- Resumen del reporte
                SELECT 
                    COUNT(*) AS total_diplomas,
                    SUM(CASE WHEN tipo = 'participacion' THEN 1 ELSE 0 END) AS total_participacion,
                    SUM(CASE WHEN tipo = 'reconocimiento' THEN 1 ELSE 0 END) AS total_reconocimiento,
                    SUM(CASE WHEN tipo = 'merito' THEN 1 ELSE 0 END) AS total_merito,
                    SUM(CASE WHEN tipo = 'asistencia' THEN 1 ELSE 0 END) AS total_asistencia,
                    SUM(CASE WHEN enviado_email = 1 THEN 1 ELSE 0 END) AS total_enviados,
                    SUM(CASE WHEN enviado_email = 0 THEN 1 ELSE 0 END) AS total_no_enviados
                FROM diplomas
                WHERE fecha_emision BETWEEN p_fecha_inicio AND p_fecha_fin
                    AND (p_tipo IS NULL OR p_tipo = '' OR tipo = p_tipo);
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS SP_ReporteDiplomas');
    }
};
