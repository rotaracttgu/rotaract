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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ObtenerConversacion`(IN `p_user_id` BIGINT, IN `p_mensaje_id` INT)
BEGIN
    DECLARE v_miembro_id INT;
    DECLARE v_propietario INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    -- Verificar que el usuario tiene acceso a esta conversación
    SELECT MiembroID INTO v_propietario
    FROM mensajes_consultas
    WHERE MensajeID = p_mensaje_id;
    
    IF v_propietario = v_miembro_id OR 
       (SELECT COUNT(*) FROM conversaciones_chat WHERE MensajeID = p_mensaje_id AND RemitenteID = v_miembro_id) > 0 THEN
        
        -- Información de la consulta
        SELECT 
            mc.MensajeID,
            mc.DestinatarioTipo,
            mc.TipoConsulta,
            mc.Asunto,
            mc.Prioridad,
            mc.Estado,
            mc.FechaEnvio,
            m_emisor.Nombre AS nombre_emisor,
            m_emisor.Correo AS correo_emisor
        FROM mensajes_consultas mc
        INNER JOIN miembros m_emisor ON mc.MiembroID = m_emisor.MiembroID
        WHERE mc.MensajeID = p_mensaje_id;
        
        -- Todos los mensajes de la conversación
        SELECT 
            cc.ConversacionID,
            cc.RemitenteID,
            m.Nombre AS nombre_remitente,
            cc.EsRespuesta,
            cc.TextoMensaje,
            cc.FechaEnvio,
            cc.Leido,
            cc.FechaLectura,
            CASE 
                WHEN cc.RemitenteID = v_miembro_id THEN 1
                ELSE 0
            END AS es_mi_mensaje
        FROM conversaciones_chat cc
        INNER JOIN miembros m ON cc.RemitenteID = m.MiembroID
        WHERE cc.MensajeID = p_mensaje_id
        ORDER BY cc.FechaEnvio ASC;
        
        -- Marcar mensajes como leídos
        UPDATE conversaciones_chat
        SET Leido = 1, FechaLectura = CURRENT_TIMESTAMP()
        WHERE MensajeID = p_mensaje_id
        AND RemitenteID != v_miembro_id
        AND Leido = 0;
        
    ELSE
        SELECT 'No tienes acceso a esta conversación' AS mensaje, 0 AS exito;
    END IF;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_ObtenerConversacion");
    }
};
