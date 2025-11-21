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
        DB::unprepared("CREATE PROCEDURE `SP_NotasPublicasPopulares`(IN `p_limite` INT)
BEGIN
    SELECT 
        n.NotaID,
        n.Titulo,
        n.Contenido,
        n.Categoria,
        n.FechaCreacion,
        u.name AS autor,
        -- Resumen
        CASE 
            WHEN LENGTH(n.Contenido) > 100 THEN CONCAT(SUBSTRING(n.Contenido, 1, 100), '...')
            ELSE n.Contenido
        END AS resumen,
        -- Simulación de vistas (en producción esto vendría de una tabla de vistas)
        0 AS total_vistas,
        0 AS total_comentarios
    FROM notas_personales n
    INNER JOIN miembros m ON n.MiembroID = m.MiembroID
    INNER JOIN users u ON m.user_id = u.id
    WHERE n.Visibilidad = 'publica'
    AND n.Estado = 'activa'
    ORDER BY n.FechaCreacion DESC
    LIMIT p_limite;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_NotasPublicasPopulares");
    }
};
