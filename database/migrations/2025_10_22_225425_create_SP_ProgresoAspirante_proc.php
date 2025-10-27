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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ProgresoAspirante`(IN `p_user_id` BIGINT)
BEGIN
    DECLARE v_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    IF v_miembro_id IS NOT NULL THEN
        SELECT 
            -- Participación en proyectos
            (SELECT COUNT(DISTINCT ProyectoID)
             FROM participaciones
             WHERE MiembroID = v_miembro_id
            ) AS proyectos_participados,
            4 AS proyectos_requeridos,
            LEAST(ROUND((SELECT COUNT(DISTINCT ProyectoID)
                         FROM participaciones
                         WHERE MiembroID = v_miembro_id) / 4.0 * 100, 2), 100) AS porcentaje_proyectos,
            
            -- Asistencia a reuniones
            (SELECT COUNT(*)
             FROM asistencias
             WHERE MiembroID = v_miembro_id
             AND EstadoAsistencia = 'Presente'
            ) AS reuniones_asistidas,
            (SELECT COUNT(*)
             FROM asistencias
             WHERE MiembroID = v_miembro_id
            ) AS total_reuniones,
            (SELECT 
                CASE 
                    WHEN COUNT(*) = 0 THEN 0
                    ELSE ROUND((SUM(CASE WHEN EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) * 100.0) / COUNT(*), 2)
                END
             FROM asistencias
             WHERE MiembroID = v_miembro_id
            ) AS porcentaje_asistencia,
            
            -- Capacitaciones (simplificado - ajustar según tus necesidades)
            0 AS capacitaciones_completadas,
            5 AS capacitaciones_requeridas,
            0 AS porcentaje_capacitaciones,
            
            -- Fecha de ingreso
            (SELECT FechaIngreso FROM miembros WHERE MiembroID = v_miembro_id) AS fecha_ingreso,
            
            -- Tiempo como aspirante (en meses)
            TIMESTAMPDIFF(MONTH, 
                (SELECT FechaIngreso FROM miembros WHERE MiembroID = v_miembro_id), 
                CURRENT_DATE()
            ) AS meses_como_aspirante;
    ELSE
        SELECT 
            0 AS proyectos_participados, 4 AS proyectos_requeridos, 0 AS porcentaje_proyectos,
            0 AS reuniones_asistidas, 0 AS total_reuniones, 0 AS porcentaje_asistencia,
            0 AS capacitaciones_completadas, 5 AS capacitaciones_requeridas, 0 AS porcentaje_capacitaciones,
            NULL AS fecha_ingreso, 0 AS meses_como_aspirante;
    END IF;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_ProgresoAspirante");
    }
};
