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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_obtener_todos_miembros`()
BEGIN
  SELECT 
    m.MiembroID,
    m.Nombre,
    m.Correo,
    m.Rol,
    m.DNI_Pasaporte,
    m.FechaIngreso
  FROM miembros m
  ORDER BY m.Nombre;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_obtener_todos_miembros");
    }
};
