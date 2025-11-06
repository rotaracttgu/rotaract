<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Procedimiento almacenado para generar resumen de actas por período.
     * Agrupa actas por mes y tipo de reunión.
     */
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS SP_ResumenActas');
        
        DB::unprepared("
            CREATE PROCEDURE SP_ResumenActas(
                IN p_anio INT,
                IN p_mes INT
            )
            BEGIN
                -- Resumen detallado por mes/año
                SELECT 
                    DATE_FORMAT(fecha_reunion, '%Y-%m') AS periodo,
                    MONTH(fecha_reunion) AS mes,
                    YEAR(fecha_reunion) AS anio,
                    tipo_reunion,
                    COUNT(*) AS total_actas,
                    COUNT(DISTINCT DATE(fecha_reunion)) AS dias_con_reunion,
                    GROUP_CONCAT(titulo SEPARATOR ' | ') AS titulos
                FROM actas
                WHERE (p_anio IS NULL OR YEAR(fecha_reunion) = p_anio)
                    AND (p_mes IS NULL OR MONTH(fecha_reunion) = p_mes)
                GROUP BY 
                    DATE_FORMAT(fecha_reunion, '%Y-%m'),
                    MONTH(fecha_reunion),
                    YEAR(fecha_reunion),
                    tipo_reunion
                ORDER BY 
                    YEAR(fecha_reunion) DESC, 
                    MONTH(fecha_reunion) DESC,
                    tipo_reunion;
                
                -- Estadísticas generales del período
                SELECT 
                    COUNT(*) AS total_actas,
                    SUM(CASE WHEN tipo_reunion = 'ordinaria' THEN 1 ELSE 0 END) AS ordinarias,
                    SUM(CASE WHEN tipo_reunion = 'extraordinaria' THEN 1 ELSE 0 END) AS extraordinarias,
                    SUM(CASE WHEN tipo_reunion = 'junta' THEN 1 ELSE 0 END) AS juntas,
                    SUM(CASE WHEN tipo_reunion = 'asamblea' THEN 1 ELSE 0 END) AS asambleas,
                    COUNT(DISTINCT DATE(fecha_reunion)) AS total_dias_reunion,
                    MIN(fecha_reunion) AS primera_reunion,
                    MAX(fecha_reunion) AS ultima_reunion,
                    AVG(LENGTH(contenido)) AS promedio_longitud_contenido
                FROM actas
                WHERE (p_anio IS NULL OR YEAR(fecha_reunion) = p_anio)
                    AND (p_mes IS NULL OR MONTH(fecha_reunion) = p_mes);
                
                -- Top 5 actas más recientes del período
                SELECT 
                    id,
                    titulo,
                    tipo_reunion,
                    fecha_reunion,
                    asistentes,
                    u.name AS creador_nombre,
                    created_at AS fecha_creacion,
                    CASE 
                        WHEN archivo_path IS NOT NULL THEN 'Con archivo'
                        ELSE 'Sin archivo'
                    END AS estado_archivo
                FROM actas a
                LEFT JOIN users u ON a.creado_por = u.id
                WHERE (p_anio IS NULL OR YEAR(fecha_reunion) = p_anio)
                    AND (p_mes IS NULL OR MONTH(fecha_reunion) = p_mes)
                ORDER BY fecha_reunion DESC, created_at DESC
                LIMIT 5;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS SP_ResumenActas');
    }
};
