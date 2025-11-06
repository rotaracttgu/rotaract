<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Procedimiento almacenado para obtener estadísticas optimizadas del dashboard de secretaría.
     * Retorna todas las estadísticas en una sola consulta para mejorar el rendimiento.
     */
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS SP_EstadisticasSecretaria');
        
        DB::unprepared("
            CREATE PROCEDURE SP_EstadisticasSecretaria()
            BEGIN
                -- Estadísticas de Consultas
                SELECT 
                    'consultas' AS seccion,
                    COUNT(*) AS total,
                    SUM(CASE WHEN estado = 'pendiente' THEN 1 ELSE 0 END) AS pendientes,
                    SUM(CASE WHEN estado = 'respondida' THEN 1 ELSE 0 END) AS respondidas,
                    SUM(CASE WHEN estado = 'cerrada' THEN 1 ELSE 0 END) AS cerradas,
                    SUM(CASE WHEN DATE(created_at) = CURDATE() THEN 1 ELSE 0 END) AS hoy,
                    SUM(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN 1 ELSE 0 END) AS este_mes
                FROM consultas
                
                UNION ALL
                
                -- Estadísticas de Actas
                SELECT 
                    'actas' AS seccion,
                    COUNT(*) AS total,
                    SUM(CASE WHEN tipo_reunion = 'ordinaria' THEN 1 ELSE 0 END) AS ordinarias,
                    SUM(CASE WHEN tipo_reunion = 'extraordinaria' THEN 1 ELSE 0 END) AS extraordinarias,
                    SUM(CASE WHEN tipo_reunion = 'junta' THEN 1 ELSE 0 END) AS juntas,
                    SUM(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN 1 ELSE 0 END) AS este_mes,
                    SUM(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) THEN 1 ELSE 0 END) AS este_anio
                FROM actas
                
                UNION ALL
                
                -- Estadísticas de Diplomas
                SELECT 
                    'diplomas' AS seccion,
                    COUNT(*) AS total,
                    SUM(CASE WHEN tipo = 'participacion' THEN 1 ELSE 0 END) AS participacion,
                    SUM(CASE WHEN tipo = 'reconocimiento' THEN 1 ELSE 0 END) AS reconocimiento,
                    SUM(CASE WHEN tipo = 'merito' THEN 1 ELSE 0 END) AS merito,
                    SUM(CASE WHEN tipo = 'asistencia' THEN 1 ELSE 0 END) AS asistencia,
                    SUM(CASE WHEN enviado_email = 1 THEN 1 ELSE 0 END) AS enviados
                FROM diplomas
                
                UNION ALL
                
                -- Estadísticas de Documentos
                SELECT 
                    'documentos' AS seccion,
                    COUNT(*) AS total,
                    SUM(CASE WHEN tipo = 'oficial' THEN 1 ELSE 0 END) AS oficiales,
                    SUM(CASE WHEN tipo = 'interno' THEN 1 ELSE 0 END) AS internos,
                    COUNT(DISTINCT categoria) AS categorias,
                    SUM(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN 1 ELSE 0 END) AS este_mes,
                    SUM(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) THEN 1 ELSE 0 END) AS este_anio
                FROM documentos;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS SP_EstadisticasSecretaria');
    }
};
