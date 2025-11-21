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
        DB::unprepared("CREATE PROCEDURE `SP_MisNotas`(IN `p_user_id` BIGINT, IN `p_categoria` VARCHAR(50), IN `p_visibilidad` VARCHAR(20), IN `p_buscar` VARCHAR(255), IN `p_limite` INT, IN `p_offset` INT)
BEGIN
    DECLARE v_miembro_id INT;
    
    -- Obtener MiembroID desde user_id
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id
    LIMIT 1;
    
    -- Si no existe el miembro, retornar vacío
    IF v_miembro_id IS NULL THEN
        SELECT * FROM notas_personales WHERE 1=0;
    ELSE
        -- Obtener las notas con filtros (sin COUNT para evitar múltiples result sets)
        SELECT 
            n.NotaID,
            n.MiembroID,
            n.Titulo,
            n.Contenido,
            n.Categoria,
            n.Visibilidad,
            n.Etiquetas,
            n.FechaRecordatorio,
            n.FechaCreacion,
            n.FechaActualizacion,
            n.Estado,
            u.name AS AutorNombre,
            u.email AS AutorEmail
        FROM notas_personales n
        INNER JOIN miembros m ON m.MiembroID = n.MiembroID
        INNER JOIN users u ON u.id = m.user_id
        WHERE n.MiembroID = v_miembro_id
        AND n.Estado = 'activa'
        AND (p_categoria IS NULL OR n.Categoria = CAST(p_categoria AS CHAR))
        AND (p_visibilidad IS NULL OR n.Visibilidad = CAST(p_visibilidad AS CHAR))
        AND (p_buscar IS NULL OR p_buscar = '' OR n.Titulo LIKE CONCAT('%', CAST(p_buscar AS CHAR), '%') OR n.Contenido LIKE CONCAT('%', CAST(p_buscar AS CHAR), '%') OR n.Etiquetas LIKE CONCAT('%', CAST(p_buscar AS CHAR), '%'))
        ORDER BY n.FechaCreacion DESC
        LIMIT p_limite OFFSET p_offset;
    END IF;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_MisNotas");
    }
};
