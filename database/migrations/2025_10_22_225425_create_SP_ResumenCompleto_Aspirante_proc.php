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
        DB::unprepared("CREATE PROCEDURE `SP_ResumenCompleto_Aspirante`(IN `p_user_id` BIGINT)
BEGIN
    DECLARE v_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    -- Información del usuario y miembro
    SELECT 
        u.id AS user_id,
        u.name AS nombre_usuario,
        u.email,
        m.MiembroID,
        m.Nombre AS nombre_completo,
        m.Rol,
        m.FechaIngreso,
        TIMESTAMPDIFF(MONTH, m.FechaIngreso, CURRENT_DATE()) AS meses_como_miembro
    FROM users u
    LEFT JOIN miembros m ON u.id = m.user_id
    WHERE u.id = p_user_id;
    
    -- Estadísticas de proyectos
    SELECT 
        COUNT(DISTINCT p.ProyectoID) AS proyectos_activos,
        COUNT(DISTINCT CASE WHEN p.Estatus = 'Completado' THEN p.ProyectoID END) AS proyectos_completados
    FROM proyectos p
    INNER JOIN participaciones part ON p.ProyectoID = part.ProyectoID
    WHERE part.MiembroID = v_miembro_id;
    
    -- Estadísticas de asistencia
    SELECT 
        COUNT(*) AS total_reuniones_registradas,
        SUM(CASE WHEN EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) AS reuniones_asistidas,
        ROUND((SUM(CASE WHEN EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) * 100.0) / NULLIF(COUNT(*), 0), 2) AS porcentaje_asistencia
    FROM asistencias
    WHERE MiembroID = v_miembro_id;
    
    -- Próximos eventos (3)
    SELECT 
        c.CalendarioID,
        c.TituloEvento,
        c.FechaInicio,
        c.HoraInicio,
        c.TipoEvento,
        DATEDIFF(c.FechaInicio, CURRENT_DATE()) AS dias_restantes
    FROM calendarios c
    WHERE c.FechaInicio >= CURRENT_DATE()
    AND c.EstadoEvento = 'Programado'
    ORDER BY c.FechaInicio ASC
    LIMIT 3;
    
    -- Estadísticas de notas
    SELECT 
        COUNT(*) AS total_notas,
        SUM(CASE WHEN Visibilidad = 'privada' THEN 1 ELSE 0 END) AS notas_privadas,
        SUM(CASE WHEN Visibilidad = 'publica' THEN 1 ELSE 0 END) AS notas_publicas
    FROM notas_personales
    WHERE MiembroID = v_miembro_id
    AND Estado = 'activa';
    
    -- Consultas pendientes
    SELECT 
        COUNT(*) AS consultas_pendientes,
        (SELECT COUNT(*) 
         FROM conversaciones_chat cc
         INNER JOIN mensajes_consultas mc ON cc.MensajeID = mc.MensajeID
         WHERE mc.MiembroID = v_miembro_id
         AND cc.RemitenteID != v_miembro_id
         AND cc.Leido = 0
        ) AS mensajes_sin_leer
    FROM mensajes_consultas
    WHERE MiembroID = v_miembro_id
    AND Estado IN ('pendiente', 'en_proceso');
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_ResumenCompleto_Aspirante");
    }
};
