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
        DB::unprepared("CREATE PROCEDURE `SP_Notificaciones_Aspirante`(IN `p_user_id` BIGINT, IN `p_limite` INT)
BEGIN
    DECLARE v_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    -- Notificaciones de próximos eventos (dentro de 7 días)
    SELECT 
        'evento' AS tipo_notificacion,
        c.CalendarioID AS referencia_id,
        c.TituloEvento AS titulo,
        CONCAT('Tienes un evento próximo: ', c.TituloEvento) AS mensaje,
        c.FechaInicio AS fecha_referencia,
        DATEDIFF(c.FechaInicio, CURRENT_DATE()) AS dias_restantes,
        CASE 
            WHEN DATEDIFF(c.FechaInicio, CURRENT_DATE()) = 0 THEN 'urgente'
            WHEN DATEDIFF(c.FechaInicio, CURRENT_DATE()) <= 3 THEN 'importante'
            ELSE 'normal'
        END AS prioridad,
        0 AS leida
    FROM calendarios c
    WHERE c.FechaInicio BETWEEN CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 7 DAY)
    AND c.EstadoEvento = 'Programado'
    
    UNION ALL
    
    -- Notificaciones de proyectos con tareas pendientes
    SELECT 
        'proyecto' AS tipo_notificacion,
        p.ProyectoID AS referencia_id,
        p.Nombre AS titulo,
        CONCAT('Tienes actividades pendientes en: ', p.Nombre) AS mensaje,
        p.FechaFin AS fecha_referencia,
        DATEDIFF(p.FechaFin, CURRENT_DATE()) AS dias_restantes,
        CASE 
            WHEN DATEDIFF(p.FechaFin, CURRENT_DATE()) <= 7 THEN 'importante'
            ELSE 'normal'
        END AS prioridad,
        0 AS leida
    FROM proyectos p
    INNER JOIN participaciones part ON p.ProyectoID = part.ProyectoID
    WHERE part.MiembroID = v_miembro_id
    AND p.Estatus = 'Activo'
    AND p.FechaFin >= CURRENT_DATE()
    
    ORDER BY prioridad DESC, fecha_referencia ASC
    LIMIT p_limite;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_Notificaciones_Aspirante");
    }
};
