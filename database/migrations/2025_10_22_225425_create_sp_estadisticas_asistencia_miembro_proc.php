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
        DB::unprepared("CREATE PROCEDURE `sp_estadisticas_asistencia_miembro`(IN `p_miembro_id` INT)
BEGIN
  SELECT 
    m.MiembroID,
    m.Nombre,
    m.Correo,
    COUNT(a.AsistenciaID) AS TotalEventos,
    SUM(CASE WHEN a.EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) AS TotalPresente,
    SUM(CASE WHEN a.EstadoAsistencia = 'Ausente' THEN 1 ELSE 0 END) AS TotalAusente,
    SUM(CASE WHEN a.EstadoAsistencia = 'Justificado' THEN 1 ELSE 0 END) AS TotalJustificado,
    ROUND(
      (SUM(CASE WHEN a.EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) * 100.0) / 
      NULLIF(COUNT(a.AsistenciaID), 0), 2
    ) AS PorcentajeAsistencia,
    SUM(COALESCE(a.MinutosTarde, 0)) AS TotalMinutosTarde
  FROM miembros m
  LEFT JOIN asistencias a ON m.MiembroID = a.MiembroID
  WHERE m.MiembroID = p_miembro_id
  GROUP BY m.MiembroID, m.Nombre, m.Correo;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_estadisticas_asistencia_miembro");
    }
};
