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
        DB::unprepared("CREATE PROCEDURE `SP_BusquedaGlobal`(IN `p_user_id` BIGINT, IN `p_termino_busqueda` VARCHAR(200), IN `p_limite` INT)
BEGIN
    DECLARE v_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    -- Buscar en proyectos
    SELECT 
        'proyecto' AS tipo_resultado,
        p.ProyectoID AS id_referencia,
        p.Nombre AS titulo,
        p.Descripcion AS descripcion,
        p.FechaInicio AS fecha_referencia,
        NULL AS relevancia
    FROM proyectos p
    INNER JOIN participaciones part ON p.ProyectoID = part.ProyectoID
    WHERE part.MiembroID = v_miembro_id
    AND (
        p.Nombre LIKE CONCAT('%', p_termino_busqueda, '%') OR
        p.Descripcion LIKE CONCAT('%', p_termino_busqueda, '%')
    )
    
    UNION ALL
    
    -- Buscar en calendario
    SELECT 
        'evento' AS tipo_resultado,
        c.CalendarioID AS id_referencia,
        c.TituloEvento AS titulo,
        c.Descripcion AS descripcion,
        c.FechaInicio AS fecha_referencia,
        NULL AS relevancia
    FROM calendarios c
    WHERE c.TituloEvento LIKE CONCAT('%', p_termino_busqueda, '%')
    OR c.Descripcion LIKE CONCAT('%', p_termino_busqueda, '%')
    
    UNION ALL
    
    -- Buscar en notas
    SELECT 
        'nota' AS tipo_resultado,
        n.NotaID AS id_referencia,
        n.Titulo AS titulo,
        SUBSTRING(n.Contenido, 1, 200) AS descripcion,
        n.FechaCreacion AS fecha_referencia,
        NULL AS relevancia
    FROM notas_personales n
    WHERE n.MiembroID = v_miembro_id
    AND n.Estado = 'activa'
    AND (
        n.Titulo LIKE CONCAT('%', p_termino_busqueda, '%') OR
        n.Contenido LIKE CONCAT('%', p_termino_busqueda, '%') OR
        n.Etiquetas LIKE CONCAT('%', p_termino_busqueda, '%')
    )
    
    ORDER BY fecha_referencia DESC
    LIMIT p_limite;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_BusquedaGlobal");
    }
};
