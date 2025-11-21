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
        DB::unprepared("CREATE PROCEDURE `sp_obtener_asistencias_evento`(IN `p_calendario_id` INT)
BEGIN
  SELECT 
    a.AsistenciaID,
    a.MiembroID,
    u.name AS NombreParticipante,
    u.email AS Gmail,
    u.dni AS DNI_Pasaporte,
    a.EstadoAsistencia,
    a.HoraLlegada,
    a.MinutosTarde,
    a.Observacion,
    a.FechaRegistro
  FROM asistencias a
  INNER JOIN miembros m ON a.MiembroID = m.MiembroID
  INNER JOIN users u ON m.user_id = u.id
  WHERE a.CalendarioID = p_calendario_id
  ORDER BY u.name;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_obtener_asistencias_evento");
    }
};
