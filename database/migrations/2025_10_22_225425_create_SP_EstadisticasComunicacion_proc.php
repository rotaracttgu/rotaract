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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EstadisticasComunicacion`(IN `p_user_id` BIGINT)
BEGIN
    DECLARE v_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    SELECT 
        -- Consultas por estado
        (SELECT COUNT(*) FROM mensajes_consultas WHERE MiembroID = v_miembro_id AND Estado = 'pendiente') AS consultas_pendientes,
        (SELECT COUNT(*) FROM mensajes_consultas WHERE MiembroID = v_miembro_id AND Estado = 'en_proceso') AS consultas_en_proceso,
        (SELECT COUNT(*) FROM mensajes_consultas WHERE MiembroID = v_miembro_id AND Estado = 'respondida') AS consultas_respondidas,
        (SELECT COUNT(*) FROM mensajes_consultas WHERE MiembroID = v_miembro_id AND Estado = 'cerrada') AS consultas_cerradas,
        
        -- Consultas por destinatario
        (SELECT COUNT(*) FROM mensajes_consultas WHERE MiembroID = v_miembro_id AND DestinatarioTipo = 'secretaria') AS consultas_secretaria,
        (SELECT COUNT(*) FROM mensajes_consultas WHERE MiembroID = v_miembro_id AND DestinatarioTipo = 'voceria') AS consultas_voceria,
        
        -- Mensajes no leídos
        (SELECT COUNT(*) 
         FROM conversaciones_chat cc
         INNER JOIN mensajes_consultas mc ON cc.MensajeID = mc.MensajeID
         WHERE mc.MiembroID = v_miembro_id
         AND cc.RemitenteID != v_miembro_id
         AND cc.Leido = 0
        ) AS mensajes_no_leidos,
        
        -- Total de consultas
        (SELECT COUNT(*) FROM mensajes_consultas WHERE MiembroID = v_miembro_id) AS total_consultas;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_EstadisticasComunicacion");
    }
};
