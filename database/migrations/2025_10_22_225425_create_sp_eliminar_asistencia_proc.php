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
        DB::unprepared("CREATE PROCEDURE `sp_eliminar_asistencia`(IN `p_asistencia_id` INT, OUT `p_mensaje` VARCHAR(255))
BEGIN
  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    ROLLBACK;
    SET p_mensaje = 'Error al eliminar la asistencia';
  END;
  
  START TRANSACTION;
  
  -- Validar que la asistencia existe
  IF NOT EXISTS (SELECT 1 FROM asistencias WHERE AsistenciaID = p_asistencia_id) THEN
    SET p_mensaje = 'La asistencia no existe';
    ROLLBACK;
  ELSE
    DELETE FROM asistencias WHERE AsistenciaID = p_asistencia_id;
    SET p_mensaje = 'Asistencia eliminada exitosamente';
    COMMIT;
  END IF;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_eliminar_asistencia");
    }
};
