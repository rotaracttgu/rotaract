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
        // ============================================================================
        // ACTUALIZAR sp_obtener_eventos_por_tipo para incluir 'Otros'
        // ============================================================================
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_obtener_eventos_por_tipo");
        
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_obtener_eventos_por_tipo`(
            IN `p_tipo_evento` ENUM('Virtual','Presencial','InicioProyecto','FinProyecto','Otros')
        )
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
    CONCAT(m.Nombre, ' ', m.Apellido) AS NombreOrganizador,
    c.ProyectoID,
    p.NombreProyecto
  FROM calendarios c
  LEFT JOIN miembros m ON c.OrganizadorID = m.MiembroID
  LEFT JOIN proyectos p ON c.ProyectoID = p.ProyectoID
  WHERE c.TipoEvento COLLATE utf8mb4_general_ci = p_tipo_evento COLLATE utf8mb4_general_ci
  ORDER BY c.FechaInicio DESC;
        END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ============================================================================
        // REVERTIR sp_obtener_eventos_por_tipo (sin 'Otros')
        // ============================================================================
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_obtener_eventos_por_tipo");
        
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_obtener_eventos_por_tipo`(
            IN `p_tipo_evento` ENUM('Virtual','Presencial','InicioProyecto','FinProyecto')
        )
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
    CONCAT(m.Nombre, ' ', m.Apellido) AS NombreOrganizador,
    c.ProyectoID,
    p.NombreProyecto
  FROM calendarios c
  LEFT JOIN miembros m ON c.OrganizadorID = m.MiembroID
  LEFT JOIN proyectos p ON c.ProyectoID = p.ProyectoID
  WHERE c.TipoEvento COLLATE utf8mb4_general_ci = p_tipo_evento COLLATE utf8mb4_general_ci
  ORDER BY c.FechaInicio DESC;
        END");
    }
};
