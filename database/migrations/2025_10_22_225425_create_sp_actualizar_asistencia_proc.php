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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizar_asistencia`(IN `p_asistencia_id` INT, IN `p_estado_asistencia` ENUM('Presente','Ausente','Justificado'), IN `p_hora_llegada` TIME, IN `p_minutos_tarde` INT, IN `p_observacion` TEXT, OUT `p_mensaje` VARCHAR(255))
BEGIN
  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    ROLLBACK;
    SET p_mensaje = 'Error al actualizar la asistencia';
  END;
  
  START TRANSACTION;
  
  -- Validar que la asistencia existe
  IF NOT EXISTS (SELECT 1 FROM asistencias WHERE AsistenciaID = p_asistencia_id) THEN
    SET p_mensaje = 'La asistencia no existe';
    ROLLBACK;
  ELSE
    UPDATE asistencias
    SET EstadoAsistencia = p_estado_asistencia,
        HoraLlegada = p_hora_llegada,
        MinutosTarde = p_minutos_tarde,
        Observacion = p_observacion
    WHERE AsistenciaID = p_asistencia_id;
    
    SET p_mensaje = 'Asistencia actualizada exitosamente';
    COMMIT;
  END IF;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_actualizar_asistencia");
    }
};
