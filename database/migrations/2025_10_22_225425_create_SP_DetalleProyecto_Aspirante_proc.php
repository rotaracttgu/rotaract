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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_DetalleProyecto_Aspirante`(IN `p_user_id` BIGINT, IN `p_proyecto_id` INT)
BEGIN
    DECLARE v_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    -- Información principal del proyecto
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
        m_resp.Nombre AS nombre_responsable,
        m_resp.Correo AS correo_responsable,
        -- Mi participación
        part.Rol AS mi_rol,
        part.FechaIngreso AS mi_fecha_ingreso,
        part.EstadoParticipacion AS mi_estado,
        -- Estadísticas financieras
        COALESCE(
            (SELECT SUM(MontoAsignado)
             FROM asignacionesmovimiento am
             INNER JOIN movimientos m ON am.MovimientoID = m.MovimientoID
             WHERE am.ProyectoID = p.ProyectoID
             AND m.TipoMovimiento = 'Ingreso'
            ), 0
        ) AS total_ingresos,
        COALESCE(
            (SELECT SUM(MontoAsignado)
             FROM asignacionesmovimiento am
             INNER JOIN movimientos m ON am.MovimientoID = m.MovimientoID
             WHERE am.ProyectoID = p.ProyectoID
             AND m.TipoMovimiento = 'Egreso'
            ), 0
        ) AS total_egresos,
        -- Próximos eventos del proyecto
        (SELECT COUNT(*)
         FROM calendarios
         WHERE ProyectoID = p.ProyectoID
         AND FechaInicio >= CURRENT_DATE()
         AND EstadoEvento = 'Programado'
        ) AS proximos_eventos
    FROM proyectos p
    LEFT JOIN miembros m_resp ON p.ResponsableID = m_resp.MiembroID
    LEFT JOIN participaciones part ON p.ProyectoID = part.ProyectoID AND part.MiembroID = v_miembro_id
    WHERE p.ProyectoID = p_proyecto_id;
    
    -- Participantes del proyecto
    SELECT 
        m.MiembroID,
        m.Nombre,
        m.Correo,
        part.Rol,
        part.FechaIngreso,
        part.EstadoParticipacion,
        CASE 
            WHEN p.ResponsableID = m.MiembroID THEN 1
            ELSE 0
        END AS es_responsable
    FROM participaciones part
    INNER JOIN miembros m ON part.MiembroID = m.MiembroID
    INNER JOIN proyectos p ON part.ProyectoID = p.ProyectoID
    WHERE part.ProyectoID = p_proyecto_id
    AND (part.EstadoParticipacion = 'Activo' OR part.EstadoParticipacion IS NULL)
    ORDER BY es_responsable DESC, m.Nombre ASC;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_DetalleProyecto_Aspirante");
    }
};
