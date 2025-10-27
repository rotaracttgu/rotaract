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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_obtener_eventos_por_estado`(IN `p_estado_evento` ENUM('Programado','EnCurso','Finalizado'))
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
    c.ProyectoID,
    p.Nombre AS NombreProyecto
  FROM calendarios c
  LEFT JOIN miembros m ON c.OrganizadorID = m.MiembroID
  LEFT JOIN proyectos p ON c.ProyectoID = p.ProyectoID
  WHERE c.EstadoEvento COLLATE utf8mb4_general_ci = p_estado_evento COLLATE utf8mb4_general_ci
  ORDER BY c.FechaInicio DESC;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_obtener_eventos_por_estado");
    }
};
