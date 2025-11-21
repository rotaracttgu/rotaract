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
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_ConsultasSecretaria");
        
        DB::unprepared("CREATE PROCEDURE `SP_ConsultasSecretaria`(IN `p_estado` VARCHAR(20), IN `p_prioridad` VARCHAR(20))
BEGIN
    SELECT 
        mc.MensajeID,
        mc.MensajeID AS ConsultaID,
        mc.MiembroID,
        u.name AS NombreUsuario,
        u.email AS EmailUsuario,
        mc.DestinatarioTipo,
        mc.TipoConsulta,
        mc.Asunto,
        mc.Mensaje,
        mc.Prioridad,
        mc.Estado,
        mc.FechaEnvio,
        mc.FechaRespuesta,
        mc.RespuestaMensaje,
        mc.RespuestaMensaje AS Respuesta,
        mc.ArchivoAdjunto,
        mc.ArchivoAdjunto AS ComprobanteRuta,
        mc.RespondidoPor,
        u_resp.name AS respondido_por_nombre,
        -- Contador de mensajes en la conversación
        (SELECT COUNT(*) 
         FROM conversaciones_chat 
         WHERE MensajeID = mc.MensajeID
        ) AS total_mensajes,
        -- Mensajes no leídos por la secretaría
        (SELECT COUNT(*) 
         FROM conversaciones_chat 
         WHERE MensajeID = mc.MensajeID 
         AND RemitenteID = mc.MiembroID
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
    INNER JOIN miembros m ON mc.MiembroID = m.MiembroID
    INNER JOIN users u ON m.user_id = u.id
    LEFT JOIN miembros m_resp ON mc.RespondidoPor = m_resp.MiembroID
    LEFT JOIN users u_resp ON m_resp.user_id = u_resp.id
    WHERE mc.DestinatarioTipo = 'secretaria'
    AND (p_estado IS NULL OR mc.Estado = p_estado)
    AND (p_prioridad IS NULL OR mc.Prioridad = p_prioridad)
    ORDER BY 
        FIELD(mc.Estado, 'pendiente', 'en_proceso', 'respondida', 'cerrada'),
        FIELD(mc.Prioridad, 'urgente', 'alta', 'media', 'baja'),
        mc.FechaEnvio DESC
    LIMIT 100;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_ConsultasSecretaria");
    }
};
