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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_generar_reporte_general_eventos`()
BEGIN
  -- Resumen general de eventos
  SELECT
    COUNT(*) AS TotalEventos,
    SUM(CASE WHEN c.TipoEvento = 'Virtual' THEN 1 ELSE 0 END) AS TotalVirtual,
    SUM(CASE WHEN c.TipoEvento = 'Presencial' THEN 1 ELSE 0 END) AS TotalPresencial,
    SUM(CASE WHEN c.TipoEvento = 'InicioProyecto' THEN 1 ELSE 0 END) AS TotalInicioProyecto,
    SUM(CASE WHEN c.TipoEvento = 'FinProyecto' THEN 1 ELSE 0 END) AS TotalFinProyecto,
    SUM(CASE WHEN c.EstadoEvento = 'Programado' THEN 1 ELSE 0 END) AS TotalProgramados,
    SUM(CASE WHEN c.EstadoEvento = 'EnCurso' THEN 1 ELSE 0 END) AS TotalEnCurso,
    SUM(CASE WHEN c.EstadoEvento = 'Finalizado' THEN 1 ELSE 0 END) AS TotalFinalizados
  FROM calendarios c;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_generar_reporte_general_eventos");
    }
};
