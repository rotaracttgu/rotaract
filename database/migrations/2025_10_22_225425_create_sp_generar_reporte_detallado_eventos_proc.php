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
        DB::unprepared("CREATE PROCEDURE `sp_generar_reporte_detallado_eventos`()
BEGIN
  SELECT
    c.CalendarioID,
    c.TituloEvento,
    c.TipoEvento,
    c.EstadoEvento,
    c.FechaInicio,
    c.FechaFin,
    c.Ubicacion,
    COALESCE(m.Nombre, 'Sin Organizador') AS Organizador,
    COUNT(DISTINCT a.AsistenciaID) AS TotalAsistencias,
    SUM(CASE WHEN a.EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) AS TotalPresentes,
    SUM(CASE WHEN a.EstadoAsistencia = 'Ausente' THEN 1 ELSE 0 END) AS TotalAusentes,
    SUM(CASE WHEN a.EstadoAsistencia = 'Justificado' THEN 1 ELSE 0 END) AS TotalJustificados,
    ROUND(
      (SUM(CASE WHEN a.EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) * 100.0) / 
      NULLIF(COUNT(DISTINCT a.AsistenciaID), 0), 2
    ) AS PorcentajeAsistencia
  FROM calendarios c
  LEFT JOIN miembros m ON c.OrganizadorID = m.MiembroID
  LEFT JOIN asistencias a ON c.CalendarioID = a.CalendarioID
  GROUP BY c.CalendarioID, c.TituloEvento, c.TipoEvento, c.EstadoEvento, 
           c.FechaInicio, c.FechaFin, c.Ubicacion, m.Nombre
  ORDER BY c.FechaInicio DESC;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_generar_reporte_detallado_eventos");
    }
};
