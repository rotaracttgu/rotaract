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
        DB::unprepared("CREATE PROCEDURE `sp_obtener_detalle_evento`(IN `p_calendario_id` INT)
BEGIN
  SELECT 
    c.CalendarioID,
    c.TituloEvento,
    c.Descripcion,
    c.TipoEvento,
    c.EstadoEvento,
    c.FechaInicio,
    c.FechaFin,
    c.HoraInicio,
    c.HoraFin,
    c.Ubicacion,
    c.OrganizadorID,
    COALESCE(m.Nombre, 'Sin Organizador') AS NombreOrganizador,
    m.Correo AS CorreoOrganizador,
    c.ProyectoID,
    p.Nombre AS NombreProyecto,
    p.Descripcion AS DescripcionProyecto
  FROM calendarios c
  LEFT JOIN miembros m ON c.OrganizadorID = m.MiembroID
  LEFT JOIN proyectos p ON c.ProyectoID = p.ProyectoID
  WHERE c.CalendarioID = p_calendario_id;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_obtener_detalle_evento");
    }
};
