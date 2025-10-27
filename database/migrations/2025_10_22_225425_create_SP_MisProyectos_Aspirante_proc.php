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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MisProyectos_Aspirante`(IN `p_user_id` BIGINT, IN `p_filtro_estado` VARCHAR(20), IN `p_filtro_categoria` VARCHAR(50))
BEGIN
    DECLARE v_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    SELECT 
        p.ProyectoID,
        p.Nombre,
        p.Descripcion,
        p.FechaInicio,
        p.FechaFin,
        p.Estatus,
        p.EstadoProyecto,
        p.Presupuesto,
        p.TipoProyecto,
        p.ResponsableID,
        -- Información del responsable
        m_resp.Nombre AS nombre_responsable,
        -- Información de la participación
        part.Rol AS mi_rol,
        part.FechaIngreso AS fecha_ingreso_proyecto,
        part.FechaSalida AS fecha_salida_proyecto,
        part.EstadoParticipacion,
        -- Calcular progreso (simplificado - ajustar según necesidad)
        CASE 
            WHEN p.FechaInicio IS NULL OR p.FechaFin IS NULL THEN 0
            WHEN CURRENT_DATE() < p.FechaInicio THEN 0
            WHEN CURRENT_DATE() > p.FechaFin THEN 100
            ELSE ROUND(
                (DATEDIFF(CURRENT_DATE(), p.FechaInicio) / 
                 DATEDIFF(p.FechaFin, p.FechaInicio)) * 100, 2
            )
        END AS porcentaje_progreso,
        -- Días restantes
        CASE 
            WHEN p.FechaFin IS NULL THEN NULL
            WHEN p.FechaFin < CURRENT_DATE() THEN 0
            ELSE DATEDIFF(p.FechaFin, CURRENT_DATE())
        END AS dias_restantes,
        -- Total de participantes
        (SELECT COUNT(*) 
         FROM participaciones 
         WHERE ProyectoID = p.ProyectoID
         AND (EstadoParticipacion = 'Activo' OR EstadoParticipacion IS NULL)
        ) AS total_participantes
    FROM proyectos p
    INNER JOIN participaciones part ON p.ProyectoID = part.ProyectoID
    LEFT JOIN miembros m_resp ON p.ResponsableID = m_resp.MiembroID
    WHERE part.MiembroID = v_miembro_id
    AND (p_filtro_estado IS NULL OR p.Estatus = p_filtro_estado)
    AND (p_filtro_categoria IS NULL OR p.TipoProyecto = p_filtro_categoria)
    ORDER BY 
        CASE p.Estatus
            WHEN 'Activo' THEN 1
            WHEN 'En Planificacion' THEN 2
            WHEN 'Completado' THEN 3
            ELSE 4
        END,
        p.FechaInicio DESC;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_MisProyectos_Aspirante");
    }
};
