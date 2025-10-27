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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MisReuniones_Aspirante`(IN `p_user_id` BIGINT, IN `p_tipo_filtro` VARCHAR(20), IN `p_tipo_evento` VARCHAR(50), IN `p_limite` INT)
BEGIN
    DECLARE v_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
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
        -- Información de asistencia
        a.AsistenciaID,
        a.EstadoAsistencia,
        a.HoraLlegada,
        a.MinutosTarde,
        a.Observacion,
        -- Cálculos de tiempo
        CASE 
            WHEN c.FechaInicio > CURRENT_DATE() THEN DATEDIFF(c.FechaInicio, CURRENT_DATE())
            WHEN c.FechaInicio = CURRENT_DATE() THEN 0
            ELSE -DATEDIFF(CURRENT_DATE(), c.FechaInicio)
        END AS dias_diferencia,
        CASE 
            WHEN c.FechaInicio > CURRENT_DATE() THEN 
                CASE 
                    WHEN DATEDIFF(c.FechaInicio, CURRENT_DATE()) = 1 THEN 'Mañana'
                    WHEN DATEDIFF(c.FechaInicio, CURRENT_DATE()) <= 7 THEN CONCAT('En ', DATEDIFF(c.FechaInicio, CURRENT_DATE()), ' días')
                    ELSE DATE_FORMAT(c.FechaInicio, '%d de %M, %Y')
                END
            WHEN c.FechaInicio = CURRENT_DATE() THEN 'Hoy'
            ELSE DATE_FORMAT(c.FechaInicio, '%d de %M, %Y')
        END AS etiqueta_fecha,
        -- Duración de la reunión
        CASE 
            WHEN c.HoraInicio IS NOT NULL AND c.HoraFin IS NOT NULL THEN
                CONCAT(
                    HOUR(TIMEDIFF(c.HoraFin, c.HoraInicio)), 'h ',
                    MINUTE(TIMEDIFF(c.HoraFin, c.HoraInicio)), 'min'
                )
            ELSE NULL
        END AS duracion_reunion
    FROM calendarios c
    LEFT JOIN miembros m_org ON c.OrganizadorID = m_org.MiembroID
    LEFT JOIN proyectos p ON c.ProyectoID = p.ProyectoID
    LEFT JOIN asistencias a ON c.CalendarioID = a.CalendarioID AND a.MiembroID = v_miembro_id
    WHERE 
        (p_tipo_filtro = 'proximas' AND c.FechaInicio >= CURRENT_DATE()) OR
        (p_tipo_filtro = 'pasadas' AND c.FechaInicio < CURRENT_DATE()) OR
        (p_tipo_filtro = 'mes_actual' AND MONTH(c.FechaInicio) = MONTH(CURRENT_DATE()) AND YEAR(c.FechaInicio) = YEAR(CURRENT_DATE())) OR
        (p_tipo_filtro = 'todas') OR
        (p_tipo_filtro IS NULL)
    AND (p_tipo_evento IS NULL OR c.TipoEvento = p_tipo_evento)
    ORDER BY 
        CASE 
            WHEN p_tipo_filtro = 'proximas' THEN c.FechaInicio
            ELSE NULL
        END ASC,
        CASE 
            WHEN p_tipo_filtro = 'pasadas' THEN c.FechaInicio
            ELSE NULL
        END DESC,
        c.HoraInicio ASC
    LIMIT p_limite;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_MisReuniones_Aspirante");
    }
};
