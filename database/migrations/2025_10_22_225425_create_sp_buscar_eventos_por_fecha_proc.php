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
        DB::unprepared("CREATE PROCEDURE `sp_buscar_eventos_por_fecha`(IN `p_fecha_inicio` DATE, IN `p_fecha_fin` DATE)
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
    COALESCE(u.name, 'Sin Organizador') AS NombreOrganizador
  FROM calendarios c
  LEFT JOIN miembros m ON c.OrganizadorID = m.MiembroID
  LEFT JOIN users u ON m.user_id = u.id
  WHERE DATE(c.FechaInicio) BETWEEN p_fecha_inicio AND p_fecha_fin
  ORDER BY c.FechaInicio;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_buscar_eventos_por_fecha");
    }
};
