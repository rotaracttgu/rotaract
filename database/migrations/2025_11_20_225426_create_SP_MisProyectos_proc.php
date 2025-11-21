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
        DB::unprepared("CREATE PROCEDURE `SP_MisProyectos`(IN `p_user_id` BIGINT, IN `p_filtro_estado` VARCHAR(50), IN `p_filtro_tipo` VARCHAR(50), IN `p_buscar` VARCHAR(255))
BEGIN
    DECLARE v_miembro_id INT;
    
    -- Obtener MiembroID desde user_id
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id
    LIMIT 1;
    
    IF v_miembro_id IS NULL THEN
        SELECT * FROM proyectos WHERE 1=0;
    ELSE
        SELECT 
            p.ProyectoID,
            p.Nombre AS NombreProyecto,
            p.Descripcion AS DescripcionProyecto,
            p.FechaInicio,
            p.FechaFin,
            p.Estatus,
            p.EstadoProyecto,
            p.Presupuesto,
            p.TipoProyecto,
            p.ResponsableID,
            m_resp.Nombre AS NombreResponsable,
            u_resp.email AS CorreoResponsable,
            part.Rol AS RolProyecto,
            part.FechaIngreso AS FechaIngresoProyecto,
            part.EstadoParticipacion,
            CASE 
                WHEN p.FechaInicio IS NULL OR p.FechaFin IS NULL THEN 0
                WHEN CURRENT_DATE() < p.FechaInicio THEN 0
                WHEN CURRENT_DATE() > p.FechaFin THEN 100
                ELSE ROUND(
                    (DATEDIFF(CURRENT_DATE(), p.FechaInicio) / 
                     DATEDIFF(p.FechaFin, p.FechaInicio)) * 100, 2
                )
            END AS PorcentajeProgreso,
            CASE 
                WHEN p.FechaFin IS NULL THEN NULL
                WHEN p.FechaFin < CURRENT_DATE() THEN 0
                ELSE DATEDIFF(p.FechaFin, CURRENT_DATE())
            END AS DiasRestantes,
            (SELECT COUNT(*) 
             FROM participaciones 
             WHERE ProyectoID = p.ProyectoID
             AND (EstadoParticipacion = 'Activo' OR EstadoParticipacion IS NULL)
            ) AS TotalParticipantes
        FROM proyectos p
        LEFT JOIN participaciones part ON p.ProyectoID = part.ProyectoID AND part.MiembroID = v_miembro_id
        LEFT JOIN miembros m_resp ON p.ResponsableID = m_resp.MiembroID
        LEFT JOIN users u_resp ON m_resp.user_id = u_resp.id
        WHERE (
            p.ResponsableID = v_miembro_id
            OR
            part.MiembroID = v_miembro_id
        )
        AND (p_filtro_estado IS NULL OR p.Estatus = CAST(p_filtro_estado AS CHAR))
        AND (p_filtro_tipo IS NULL OR p.TipoProyecto = CAST(p_filtro_tipo AS CHAR))
        AND (
            p_buscar IS NULL OR p_buscar = '' 
            OR p.Nombre LIKE CONCAT('%', CAST(p_buscar AS CHAR), '%')
            OR p.Descripcion LIKE CONCAT('%', CAST(p_buscar AS CHAR), '%')
        )
        ORDER BY 
            CASE p.Estatus
                WHEN 'Activo' THEN 1
                WHEN 'En Planificacion' THEN 2
                WHEN 'Completado' THEN 3
                ELSE 4
            END,
            p.FechaInicio DESC;
    END IF;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_MisProyectos");
    }
};
