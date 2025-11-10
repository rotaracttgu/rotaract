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
        DB::unprepared("CREATE PROCEDURE `SP_EnviarConsulta`(IN `p_user_id` BIGINT, IN `p_destinatario_tipo` ENUM('secretaria','voceria','directiva','otro'), IN `p_tipo_consulta` VARCHAR(50), IN `p_asunto` VARCHAR(200), IN `p_mensaje` TEXT, IN `p_prioridad` ENUM('baja','media','alta','urgente'))
BEGIN
    DECLARE v_miembro_id INT;
    DECLARE v_mensaje_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    IF v_miembro_id IS NULL THEN
        SELECT 'Usuario no encontrado' AS mensaje, 0 AS exito;
    ELSE
        -- Insertar consulta
        INSERT INTO mensajes_consultas (
            MiembroID, DestinatarioTipo, TipoConsulta, 
            Asunto, Mensaje, Prioridad, Estado, FechaEnvio
        ) VALUES (
            v_miembro_id, p_destinatario_tipo, p_tipo_consulta,
            p_asunto, p_mensaje, p_prioridad, 'pendiente', CURRENT_TIMESTAMP()
        );
        
        SET v_mensaje_id = LAST_INSERT_ID();
        
        -- Insertar primer mensaje en la conversación
        INSERT INTO conversaciones_chat (
            MensajeID, RemitenteID, EsRespuesta, TextoMensaje, FechaEnvio
        ) VALUES (
            v_mensaje_id, v_miembro_id, 0, p_mensaje, CURRENT_TIMESTAMP()
        );
        
        SELECT 
            'Consulta enviada exitosamente' AS mensaje, 
            1 AS exito,
            v_mensaje_id AS MensajeID;
    END IF;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_EnviarConsulta");
    }
};
