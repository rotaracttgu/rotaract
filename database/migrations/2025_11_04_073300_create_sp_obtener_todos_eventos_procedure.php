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
        // Procedimiento almacenado para obtener todos los eventos del calendario
        DB::unprepared("
            DROP PROCEDURE IF EXISTS sp_obtener_todos_eventos;
        ");

        DB::unprepared("
            CREATE PROCEDURE sp_obtener_todos_eventos()
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
                    c.ProyectoID,
                    u.name AS NombreOrganizador,
                    p.Nombre AS NombreProyecto
                FROM calendarios c
                LEFT JOIN miembros m ON c.OrganizadorID = m.MiembroID
                LEFT JOIN users u ON m.user_id = u.id
                LEFT JOIN proyectos p ON c.ProyectoID = p.ProyectoID
                ORDER BY c.FechaInicio DESC;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_obtener_todos_eventos");
    }
};
