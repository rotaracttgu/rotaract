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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MisNotas`(IN `p_user_id` BIGINT, IN `p_categoria` VARCHAR(50), IN `p_visibilidad` VARCHAR(20), IN `p_buscar` VARCHAR(255), IN `p_limite` INT, IN `p_offset` INT)
BEGIN
    DECLARE v_miembro_id INT;
    
    -- Obtener MiembroID desde user_id
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id
    LIMIT 1;
    
    -- Si no existe el miembro, retornar vacío
    IF v_miembro_id IS NULL THEN
        SELECT 
            0 AS total_registros,
            'Usuario no tiene miembro asociado' AS mensaje;
        SELECT * FROM notas_personales WHERE 1=0;
    ELSE
        -- Contar total de registros
        SELECT COUNT(*) AS total_registros
        FROM notas_personales
        WHERE MiembroID = v_miembro_id
        AND Estado = 'activa'
        AND (p_categoria IS NULL OR Categoria = p_categoria)
        AND (p_visibilidad IS NULL OR Visibilidad = p_visibilidad)
        AND (
            p_buscar IS NULL 
            OR Titulo LIKE CONCAT('%', p_buscar, '%')
            OR Contenido LIKE CONCAT('%', p_buscar, '%')
            OR Etiquetas LIKE CONCAT('%', p_buscar, '%')
        );
        
        -- Obtener las notas con paginación
        SELECT 
            n.NotaID AS id,
            n.MiembroID,
            n.Titulo AS titulo,
            n.Contenido AS contenido,
            n.Categoria AS categoria,
            n.Visibilidad AS visibilidad,
            n.Etiquetas AS etiquetas,
            n.FechaRecordatorio AS recordatorio,
            n.FechaCreacion AS created_at,
            n.FechaActualizacion AS updated_at,
            m.Nombre AS autor_nombre,
            u.email AS autor_email
        FROM notas_personales n
        INNER JOIN miembros m ON m.MiembroID = n.MiembroID
        INNER JOIN users u ON u.id = m.user_id
        WHERE n.MiembroID = v_miembro_id
        AND n.Estado = 'activa'
        AND (p_categoria IS NULL OR n.Categoria = p_categoria)
        AND (p_visibilidad IS NULL OR n.Visibilidad = p_visibilidad)
        AND (
            p_buscar IS NULL 
            OR n.Titulo LIKE CONCAT('%', p_buscar, '%')
            OR n.Contenido LIKE CONCAT('%', p_buscar, '%')
            OR n.Etiquetas LIKE CONCAT('%', p_buscar, '%')
        )
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
