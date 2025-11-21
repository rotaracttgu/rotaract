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
        DB::unprepared("CREATE PROCEDURE `SP_EventosDelDia`(IN `p_fecha` DATE)
BEGIN
    SELECT 
        c.CalendarioID,
        c.TituloEvento,
        c.Descripcion,
        c.TipoEvento,
        c.EstadoEvento,
        c.FechaInicio,
        c.HoraInicio,
        c.HoraFin,
        c.Ubicacion,
        u_org.name AS organizador,
        p.Nombre AS proyecto,
        -- Indicador si es evento actual
        CASE 
            WHEN CURRENT_TIME() BETWEEN c.HoraInicio AND c.HoraFin THEN 1
            WHEN CURRENT_TIME() < c.HoraInicio THEN 0
            ELSE -1
        END AS estado_tiempo  -- 1: en curso, 0: próximo, -1: finalizado
    FROM calendarios c
    LEFT JOIN miembros m_org ON c.OrganizadorID = m_org.MiembroID
    LEFT JOIN users u_org ON m_org.user_id = u_org.id
    LEFT JOIN proyectos p ON c.ProyectoID = p.ProyectoID
    WHERE DATE(c.FechaInicio) = p_fecha
    ORDER BY c.HoraInicio ASC;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_EventosDelDia");
    }
};
