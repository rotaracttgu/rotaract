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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_obtener_miembros_para_asistencia`(IN `p_calendario_id` INT)
BEGIN
  -- Obtener miembros que aún no tienen asistencia registrada para este evento
  SELECT 
    m.MiembroID,
    m.Nombre,
    m.Correo,
    m.Rol,
    m.DNI_Pasaporte
  FROM miembros m
  WHERE m.MiembroID NOT IN (
    SELECT a.MiembroID 
    FROM asistencias a 
    WHERE a.CalendarioID = p_calendario_id
  )
  ORDER BY m.Nombre;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_obtener_miembros_para_asistencia");
    }
};
