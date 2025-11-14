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
        DB::unprepared("CREATE PROCEDURE `SP_ProximasReuniones_Aspirante`(IN `p_user_id` BIGINT, IN `p_limite` INT)
BEGIN
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
        CASE 
            WHEN c.TipoEvento = 'Virtual' THEN 'Virtual'
            WHEN c.TipoEvento = 'Presencial' THEN c.Ubicacion
            ELSE 'Evento Especial'
        END AS lugar_evento,
        DATEDIFF(c.FechaInicio, CURRENT_DATE()) AS dias_restantes,
        CASE 
            WHEN DATEDIFF(c.FechaInicio, CURRENT_DATE()) = 0 THEN 'Hoy'
            WHEN DATEDIFF(c.FechaInicio, CURRENT_DATE()) = 1 THEN 'Mañana'
            WHEN DATEDIFF(c.FechaInicio, CURRENT_DATE()) <= 7 THEN CONCAT('En ', DATEDIFF(c.FechaInicio, CURRENT_DATE()), ' días')
            ELSE DATE_FORMAT(c.FechaInicio, '%d de %M, %Y')
        END AS etiqueta_fecha
    FROM calendarios c
    WHERE c.FechaInicio >= CURRENT_DATE()
    AND c.EstadoEvento IN ('Programado', 'EnCurso')
    ORDER BY c.FechaInicio ASC, c.HoraInicio ASC
    LIMIT p_limite;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_ProximasReuniones_Aspirante");
    }
};
