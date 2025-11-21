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
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_ResponderConsulta");
        
        DB::unprepared("CREATE PROCEDURE `SP_ResponderConsulta`(IN `p_consulta_id` INT, IN `p_respuesta` TEXT, IN `p_respondido_por_user_id` BIGINT)
BEGIN
    DECLARE v_respondido_por_miembro_id INT DEFAULT NULL;
    DECLARE v_miembro_solicitante_id INT;
    DECLARE v_consulta_existe INT;
    
    -- Verificar que la consulta existe
    SELECT COUNT(*) INTO v_consulta_existe
    FROM mensajes_consultas
    WHERE MensajeID = p_consulta_id;
    
    IF v_consulta_existe = 0 THEN
        SELECT 
            0 AS exito,
            'La consulta no existe' AS mensaje,
            NULL AS ConsultaID;
    ELSE
        -- Intentar obtener MiembroID del que responde (puede ser NULL si no es miembro)
        SELECT MiembroID INTO v_respondido_por_miembro_id
        FROM miembros
        WHERE user_id = p_respondido_por_user_id
        LIMIT 1;
        
        -- Obtener MiembroID del solicitante
        SELECT MiembroID INTO v_miembro_solicitante_id
        FROM mensajes_consultas
        WHERE MensajeID = p_consulta_id;
        
        -- Actualizar la consulta (RespondidoPor puede ser NULL)
        UPDATE mensajes_consultas
        SET 
            RespuestaMensaje = p_respuesta,
            FechaRespuesta = NOW(),
            RespondidoPor = v_respondido_por_miembro_id,
            Estado = 'respondida'
        WHERE MensajeID = p_consulta_id;
        
        -- Insertar mensaje en conversación solo si el que responde es miembro
        IF v_respondido_por_miembro_id IS NOT NULL THEN
            INSERT INTO conversaciones_chat (
                MensajeID,
                RemitenteID,
                EsRespuesta,
                TextoMensaje,
                FechaEnvio,
                Leido
            ) VALUES (
                p_consulta_id,
                v_respondido_por_miembro_id,
                1,
                p_respuesta,
                NOW(),
                0
            );
        END IF;
        
        SELECT 
            1 AS exito,
            'Respuesta enviada correctamente' AS mensaje,
            p_consulta_id AS ConsultaID;
    END IF;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_ResponderConsulta");
    }
};
