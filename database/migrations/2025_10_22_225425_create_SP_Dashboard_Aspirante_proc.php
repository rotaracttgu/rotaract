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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Dashboard_Aspirante`(IN `p_user_id` BIGINT)
BEGIN
    DECLARE v_miembro_id INT;
    
    -- Obtener el MiembroID del usuario
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    -- Si no existe el miembro, retornar vacío
    IF v_miembro_id IS NULL THEN
        SELECT 
            0 AS proyectos_activos,
            0 AS reuniones_mes,
            0 AS mensajes_pendientes,
            0 AS notas_personales,
            0 AS porcentaje_asistencia;
    ELSE
        SELECT 
            -- Proyectos activos en los que participa
            (SELECT COUNT(DISTINCT p.ProyectoID)
             FROM proyectos p
             INNER JOIN participaciones part ON p.ProyectoID = part.ProyectoID
             WHERE part.MiembroID = v_miembro_id 
             AND p.Estatus = 'Activo'
             AND (part.EstadoParticipacion = 'Activo' OR part.EstadoParticipacion IS NULL)
            ) AS proyectos_activos,
            
            -- Reuniones este mes
            (SELECT COUNT(*)
             FROM calendarios c
             WHERE MONTH(c.FechaInicio) = MONTH(CURRENT_DATE())
             AND YEAR(c.FechaInicio) = YEAR(CURRENT_DATE())
             AND c.EstadoEvento IN ('Programado', 'EnCurso')
            ) AS reuniones_mes,
            
            -- Mensajes pendientes (esto dependerá de tu sistema de mensajería)
            0 AS mensajes_pendientes,
            
            -- Notas personales (aquí deberás crear la tabla de notas)
            0 AS notas_personales,
            
            -- Porcentaje de asistencia
            (SELECT 
                CASE 
                    WHEN COUNT(*) = 0 THEN 0
                    ELSE ROUND((SUM(CASE WHEN EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) * 100.0) / COUNT(*), 2)
                END
             FROM asistencias
             WHERE MiembroID = v_miembro_id
            ) AS porcentaje_asistencia;
    END IF;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_Dashboard_Aspirante");
    }
};
