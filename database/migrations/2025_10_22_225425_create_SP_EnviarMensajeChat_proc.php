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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EnviarMensajeChat`(IN `p_user_id` BIGINT, IN `p_mensaje_id` INT, IN `p_texto_mensaje` TEXT)
BEGIN
    DECLARE v_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    -- Insertar mensaje en la conversación
    INSERT INTO conversaciones_chat (
        MensajeID, RemitenteID, EsRespuesta, TextoMensaje, FechaEnvio
    ) VALUES (
        p_mensaje_id, v_miembro_id, 1, p_texto_mensaje, CURRENT_TIMESTAMP()
    );
    
    -- Actualizar estado de la consulta si está pendiente
    UPDATE mensajes_consultas
    SET Estado = 'en_proceso'
    WHERE MensajeID = p_mensaje_id
    AND Estado = 'pendiente';
    
    SELECT 
        'Mensaje enviado exitosamente' AS mensaje, 
        1 AS exito,
        LAST_INSERT_ID() AS ConversacionID;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_EnviarMensajeChat");
    }
};
