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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_eliminar_evento`(IN `p_calendario_id` INT, OUT `p_mensaje` VARCHAR(255))
BEGIN
  DECLARE v_count_asistencias INT;
  
  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    ROLLBACK;
    SET p_mensaje = 'Error al eliminar el evento';
  END;
  
  START TRANSACTION;
  
  -- Validar que el evento existe
  IF NOT EXISTS (SELECT 1 FROM calendarios WHERE CalendarioID = p_calendario_id) THEN
    SET p_mensaje = 'El evento no existe';
    ROLLBACK;
  ELSE
    -- Verificar si hay asistencias registradas
    SELECT COUNT(*) INTO v_count_asistencias
    FROM asistencias
    WHERE CalendarioID = p_calendario_id;
    
    -- Eliminar asistencias primero si existen
    IF v_count_asistencias > 0 THEN
      DELETE FROM asistencias WHERE CalendarioID = p_calendario_id;
    END IF;
    
    -- Eliminar el evento
    DELETE FROM calendarios WHERE CalendarioID = p_calendario_id;
    
    SET p_mensaje = CONCAT('Evento eliminado exitosamente. Se eliminaron ', v_count_asistencias, ' registros de asistencia.');
    COMMIT;
  END IF;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_eliminar_evento");
    }
};
