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
        DB::unprepared("CREATE PROCEDURE `sp_obtener_miembros_para_asistencia`(IN `p_calendario_id` INT)
BEGIN
  -- Obtener miembros que aún no tienen asistencia registrada para este evento
  SELECT 
    m.MiembroID,
    u.name AS Nombre,
    u.email AS Correo,
    m.Rol,
    u.dni AS DNI_Pasaporte
  FROM miembros m
  INNER JOIN users u ON m.user_id = u.id
  WHERE m.MiembroID NOT IN (
    SELECT a.MiembroID 
    FROM asistencias a 
    WHERE a.CalendarioID = p_calendario_id
  )
  ORDER BY u.name;
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
