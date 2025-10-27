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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_RecordatoriosProximos`(IN `p_user_id` BIGINT, IN `p_horas_adelante` INT)
BEGIN
    DECLARE v_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    SELECT 
        n.NotaID,
        n.Titulo,
        n.Categoria,
        n.FechaRecordatorio,
        TIMESTAMPDIFF(HOUR, CURRENT_TIMESTAMP(), n.FechaRecordatorio) AS horas_restantes,
        CASE 
            WHEN n.FechaRecordatorio <= CURRENT_TIMESTAMP() THEN 'Vencido'
            WHEN TIMESTAMPDIFF(HOUR, CURRENT_TIMESTAMP(), n.FechaRecordatorio) <= 1 THEN 'Urgente'
            WHEN TIMESTAMPDIFF(HOUR, CURRENT_TIMESTAMP(), n.FechaRecordatorio) <= 24 THEN 'Próximo'
            ELSE 'Programado'
        END AS estado_recordatorio
    FROM notas_personales n
    WHERE n.MiembroID = v_miembro_id
    AND n.Estado = 'activa'
    AND n.FechaRecordatorio IS NOT NULL
    AND n.FechaRecordatorio <= DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL p_horas_adelante HOUR)
    ORDER BY n.FechaRecordatorio ASC;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_RecordatoriosProximos");
    }
};
