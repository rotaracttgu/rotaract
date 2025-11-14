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
        DB::unprepared("CREATE PROCEDURE `SP_MisConsultas`(IN `p_user_id` BIGINT, IN `p_filtro_destinatario` VARCHAR(20), IN `p_filtro_estado` VARCHAR(20), IN `p_limite` INT)
BEGIN
    DECLARE v_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    SELECT 
        mc.MensajeID,
        mc.DestinatarioTipo,
        mc.TipoConsulta,
        mc.Asunto,
        mc.Mensaje,
        mc.Prioridad,
        mc.Estado,
        mc.FechaEnvio,
        mc.FechaRespuesta,
        mc.RespuestaMensaje,
        m_resp.Nombre AS respondido_por_nombre,
        -- Contador de mensajes en la conversación
        (SELECT COUNT(*) 
         FROM conversaciones_chat 
         WHERE MensajeID = mc.MensajeID
        ) AS total_mensajes,
        -- Mensajes no leídos
        (SELECT COUNT(*) 
         FROM conversaciones_chat 
         WHERE MensajeID = mc.MensajeID 
         AND RemitenteID != v_miembro_id
         AND Leido = 0
        ) AS mensajes_no_leidos,
        -- Último mensaje
        (SELECT TextoMensaje 
         FROM conversaciones_chat 
         WHERE MensajeID = mc.MensajeID 
         ORDER BY FechaEnvio DESC 
         LIMIT 1
        ) AS ultimo_mensaje,
        -- Fecha último mensaje
        (SELECT FechaEnvio 
         FROM conversaciones_chat 
         WHERE MensajeID = mc.MensajeID 
         ORDER BY FechaEnvio DESC 
         LIMIT 1
        ) AS fecha_ultimo_mensaje
    FROM mensajes_consultas mc
    LEFT JOIN miembros m_resp ON mc.RespondidoPor = m_resp.MiembroID
    WHERE mc.MiembroID = v_miembro_id
    AND (p_filtro_destinatario IS NULL OR mc.DestinatarioTipo = p_filtro_destinatario)
    AND (p_filtro_estado IS NULL OR mc.Estado = p_filtro_estado)
    ORDER BY mc.FechaEnvio DESC
    LIMIT p_limite;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_MisConsultas");
    }
};
