<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EstadisticasAsistencia_Aspirante`(IN `p_user_id` BIGINT)
BEGIN
    DECLARE v_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    -- Estadísticas generales
    SELECT 
        -- Total de reuniones asistidas
        (SELECT COUNT(*)
         FROM asistencias
         WHERE MiembroID = v_miembro_id
         AND EstadoAsistencia = 'Presente'
        ) AS reuniones_asistidas,
        
        -- Porcentaje de asistencia general
        (SELECT 
            CASE 
                WHEN COUNT(*) = 0 THEN 0
                ELSE ROUND((SUM(CASE WHEN EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) * 100.0) / COUNT(*), 2)
            END
         FROM asistencias
         WHERE MiembroID = v_miembro_id
        ) AS porcentaje_asistencia,
        
        -- Próximas reuniones
        (SELECT COUNT(*)
         FROM calendarios
         WHERE FechaInicio >= CURRENT_DATE()
         AND EstadoEvento = 'Programado'
        ) AS proximas_reuniones,
        
        -- Reuniones este mes
        (SELECT COUNT(*)
         FROM calendarios
         WHERE MONTH(FechaInicio) = MONTH(CURRENT_DATE())
         AND YEAR(FechaInicio) = YEAR(CURRENT_DATE())
        ) AS reuniones_este_mes,
        
        -- Ausencias justificadas
        (SELECT COUNT(*)
         FROM asistencias
         WHERE MiembroID = v_miembro_id
         AND EstadoAsistencia = 'Justificado'
        ) AS ausencias_justificadas,
        
        -- Ausencias sin justificar
        (SELECT COUNT(*)
         FROM asistencias
         WHERE MiembroID = v_miembro_id
         AND EstadoAsistencia = 'Ausente'
        ) AS ausencias_sin_justificar;
    
    -- Asistencia por mes (últimos 3 meses)
    SELECT 
        DATE_FORMAT(c.FechaInicio, '%Y-%m') AS mes,
        DATE_FORMAT(c.FechaInicio, '%M %Y') AS mes_nombre,
        COUNT(*) AS total_reuniones,
        SUM(CASE WHEN a.EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) AS asistidas,
        ROUND(
            (SUM(CASE WHEN a.EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) * 100.0) / COUNT(*), 
            2
        ) AS porcentaje
    FROM calendarios c
    LEFT JOIN asistencias a ON c.CalendarioID = a.CalendarioID AND a.MiembroID = v_miembro_id
    WHERE c.FechaInicio >= DATE_SUB(CURRENT_DATE(), INTERVAL 3 MONTH)
    AND c.FechaInicio <= CURRENT_DATE()
    GROUP BY mes, mes_nombre
    ORDER BY mes DESC;
    
    -- Asistencia por tipo de reunión
    SELECT 
        c.TipoEvento,
        COUNT(*) AS total_reuniones,
        SUM(CASE WHEN a.EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) AS asistidas,
        ROUND(
            (SUM(CASE WHEN a.EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) * 100.0) / COUNT(*), 
            2
        ) AS porcentaje
    FROM calendarios c
    LEFT JOIN asistencias a ON c.CalendarioID = a.CalendarioID AND a.MiembroID = v_miembro_id
    WHERE c.FechaInicio <= CURRENT_DATE()
    GROUP BY c.TipoEvento
    ORDER BY total_reuniones DESC;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_EstadisticasAsistencia_Aspirante");
    }
};
