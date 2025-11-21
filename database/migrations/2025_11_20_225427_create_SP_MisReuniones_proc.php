<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("CREATE PROCEDURE `SP_MisReuniones`(IN `p_user_id` BIGINT, IN `p_tipo_filtro` VARCHAR(50), IN `p_tipo_evento` VARCHAR(50))
BEGIN
    DECLARE v_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id
    LIMIT 1;
    
    IF v_miembro_id IS NULL THEN
        SELECT * FROM calendarios WHERE 1=0;
    ELSE
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
            u_org.name AS NombreOrganizador,
            u_org.email AS EmailOrganizador,
            c.ProyectoID,
            p.Nombre AS NombreProyecto,
            a.AsistenciaID,
            a.EstadoAsistencia,
            a.HoraLlegada,
            a.MinutosTarde,
            a.Observacion,
            CASE 
                WHEN c.FechaInicio > CURRENT_DATE() THEN DATEDIFF(c.FechaInicio, CURRENT_DATE())
                WHEN c.FechaInicio = CURRENT_DATE() THEN 0
                ELSE -DATEDIFF(CURRENT_DATE(), c.FechaInicio)
            END AS DiasRestantes,
            CASE 
                WHEN c.HoraInicio IS NOT NULL AND c.HoraFin IS NOT NULL THEN
                    CONCAT(
                        HOUR(TIMEDIFF(c.HoraFin, c.HoraInicio)), 'h ',
                        MINUTE(TIMEDIFF(c.HoraFin, c.HoraInicio)), 'min'
                    )
                ELSE NULL
            END AS DuracionReunion,
            (SELECT COUNT(*) FROM asistencias WHERE CalendarioID = c.CalendarioID AND EstadoAsistencia = 'Presente') AS TotalAsistentes
        FROM calendarios c
        LEFT JOIN miembros m_org ON c.OrganizadorID = m_org.MiembroID
        LEFT JOIN users u_org ON m_org.user_id = u_org.id
        LEFT JOIN proyectos p ON c.ProyectoID = p.ProyectoID
        LEFT JOIN asistencias a ON c.CalendarioID = a.CalendarioID AND a.MiembroID = v_miembro_id
        WHERE 1=1
        AND (
            p_tipo_filtro IS NULL 
            OR p_tipo_filtro = '' 
            OR (p_tipo_filtro = 'proximas' AND c.FechaInicio >= CURRENT_DATE())
            OR (p_tipo_filtro = 'pasadas' AND c.FechaInicio < CURRENT_DATE())
            OR (p_tipo_filtro = 'mes_actual' AND MONTH(c.FechaInicio) = MONTH(CURRENT_DATE()) AND YEAR(c.FechaInicio) = YEAR(CURRENT_DATE()))
            OR (p_tipo_filtro = c.EstadoEvento COLLATE utf8mb4_unicode_ci)
        )
        AND (p_tipo_evento IS NULL OR c.TipoEvento = p_tipo_evento COLLATE utf8mb4_unicode_ci)
        ORDER BY 
            CASE 
                WHEN p_tipo_filtro = 'proximas' OR p_tipo_filtro IS NULL THEN c.FechaInicio
                ELSE NULL
            END ASC,
            CASE 
                WHEN p_tipo_filtro = 'pasadas' THEN c.FechaInicio
                ELSE NULL
            END DESC,
            c.HoraInicio ASC
        LIMIT 100;
    END IF;
END");
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_MisReuniones");
    }
};
