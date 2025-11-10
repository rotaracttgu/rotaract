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
        DB::unprepared("CREATE PROCEDURE `SP_Calendario_Aspirante`(IN `p_user_id` BIGINT, IN `p_mes` INT, IN `p_anio` INT, IN `p_tipo_evento` VARCHAR(50))
BEGIN
    DECLARE v_fecha_inicio DATE;
    DECLARE v_fecha_fin DATE;
    
    -- Calcular primer y último día del mes
    SET v_fecha_inicio = DATE(CONCAT(p_anio, '-', LPAD(p_mes, 2, '0'), '-01'));
    SET v_fecha_fin = LAST_DAY(v_fecha_inicio);
    
    SELECT 
        c.CalendarioID,
        c.TituloEvento,
        c.Descripcion,
        c.TipoEvento,
        c.EstadoEvento,
        c.FechaInicio,
        c.FechaFin,
        c.HoraInicio,
        c.HoraFin,
        c.Ubicacion,
        c.OrganizadorID,
        m_org.Nombre AS nombre_organizador,
        c.ProyectoID,
        p.Nombre AS nombre_proyecto,
        -- Información adicional
        DAY(c.FechaInicio) AS dia_mes,
        DAYOFWEEK(c.FechaInicio) AS dia_semana,
        DATE_FORMAT(c.FechaInicio, '%W') AS nombre_dia,
        -- Color según tipo de evento (para UI)
        CASE c.TipoEvento
            WHEN 'Virtual' THEN '#3498db'
            WHEN 'Presencial' THEN '#2ecc71'
            WHEN 'InicioProyecto' THEN '#9b59b6'
            WHEN 'FinProyecto' THEN '#e74c3c'
            ELSE '#95a5a6'
        END AS color_evento,
        -- Badge según estado
        CASE c.EstadoEvento
            WHEN 'Programado' THEN 'primary'
            WHEN 'EnCurso' THEN 'success'
            WHEN 'Finalizado' THEN 'secondary'
            ELSE 'info'
        END AS badge_estado
    FROM calendarios c
    LEFT JOIN miembros m_org ON c.OrganizadorID = m_org.MiembroID
    LEFT JOIN proyectos p ON c.ProyectoID = p.ProyectoID
    WHERE c.FechaInicio BETWEEN v_fecha_inicio AND v_fecha_fin
    AND (p_tipo_evento IS NULL OR c.TipoEvento = p_tipo_evento)
    ORDER BY c.FechaInicio ASC, c.HoraInicio ASC;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_Calendario_Aspirante");
    }
};
