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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_registrar_asistencia`(IN `p_miembro_id` INT, IN `p_calendario_id` INT, IN `p_estado_asistencia` ENUM('Presente','Ausente','Justificado'), IN `p_hora_llegada` TIME, IN `p_minutos_tarde` INT, IN `p_observacion` TEXT, OUT `p_asistencia_id` INT, OUT `p_mensaje` VARCHAR(255))
BEGIN
  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    ROLLBACK;
    SET p_mensaje = 'Error al registrar la asistencia';
    SET p_asistencia_id = NULL;
  END;
  
  START TRANSACTION;
  
  -- Validar que el miembro existe
  IF NOT EXISTS (SELECT 1 FROM miembros WHERE MiembroID = p_miembro_id) THEN
    SET p_mensaje = 'El miembro no existe';
    SET p_asistencia_id = NULL;
    ROLLBACK;
  -- Validar que el evento existe
  ELSEIF NOT EXISTS (SELECT 1 FROM calendarios WHERE CalendarioID = p_calendario_id) THEN
    SET p_mensaje = 'El evento no existe';
    SET p_asistencia_id = NULL;
    ROLLBACK;
  -- Validar si ya existe una asistencia registrada
  ELSEIF EXISTS (SELECT 1 FROM asistencias WHERE MiembroID = p_miembro_id AND CalendarioID = p_calendario_id) THEN
    SET p_mensaje = 'Ya existe un registro de asistencia para este miembro en este evento';
    SET p_asistencia_id = NULL;
    ROLLBACK;
  ELSE
    -- Insertar la asistencia
    INSERT INTO asistencias (
      MiembroID, CalendarioID, EstadoAsistencia,
      HoraLlegada, MinutosTarde, Observacion
    ) VALUES (
      p_miembro_id, p_calendario_id, p_estado_asistencia,
      p_hora_llegada, p_minutos_tarde, p_observacion
    );
    
    SET p_asistencia_id = LAST_INSERT_ID();
    SET p_mensaje = 'Asistencia registrada exitosamente';
    
    COMMIT;
  END IF;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_registrar_asistencia");
    }
};
