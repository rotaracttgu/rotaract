<?php
/**
 * Arreglar SP_MisNotas - collations
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$sql = <<<'SQL'
CREATE DEFINER=`dbadmin`@`localhost` PROCEDURE `SP_MisNotas`(
    IN p_user_id INT,
    IN p_categoria VARCHAR(50),
    IN p_visibilidad VARCHAR(20),
    IN p_buscar VARCHAR(100),
    IN p_limite INT,
    IN p_offset INT
)
BEGIN
    DECLARE v_miembro_id INT DEFAULT NULL;

    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id
    LIMIT 1;

    IF v_miembro_id IS NULL THEN
        SELECT 0 AS exito, 'No se encontró el miembro asociado al usuario' AS mensaje;
    ELSE
        SELECT
            n.NotaID,
            n.Titulo,
            n.Contenido,
            n.Categoria,
            n.FechaCreacion,
            n.Visibilidad,
            n.Etiquetas,
            n.Estado,
            n.MiembroID,
            u.name AS AutorNombre,
            COALESCE((
                SELECT COUNT(*)
                FROM notas_personales n2
                WHERE n2.MiembroID = v_miembro_id
                AND (p_categoria IS NULL OR n2.Categoria COLLATE utf8mb4_general_ci = p_categoria COLLATE utf8mb4_general_ci)    
                AND (p_visibilidad IS NULL OR n2.Visibilidad COLLATE utf8mb4_general_ci = p_visibilidad COLLATE utf8mb4_general_ci)
                AND (p_buscar = '' OR n2.Titulo COLLATE utf8mb4_general_ci LIKE CONCAT('%', p_buscar COLLATE utf8mb4_general_ci, '%') OR n2.Contenido COLLATE utf8mb4_general_ci LIKE CONCAT('%', p_buscar COLLATE utf8mb4_general_ci, '%')) 
            ), 0) AS total_resultados
        FROM notas_personales n
        INNER JOIN miembros m ON n.MiembroID = m.MiembroID
        INNER JOIN users u ON m.user_id = u.id
        WHERE n.MiembroID = v_miembro_id
        AND n.Estado COLLATE utf8mb4_general_ci = 'activa'
        AND (p_categoria IS NULL OR n.Categoria COLLATE utf8mb4_general_ci = p_categoria COLLATE utf8mb4_general_ci)
        AND (p_visibilidad IS NULL OR n.Visibilidad COLLATE utf8mb4_general_ci = p_visibilidad COLLATE utf8mb4_general_ci)       
        AND (p_buscar = '' OR n.Titulo COLLATE utf8mb4_general_ci LIKE CONCAT('%', p_buscar COLLATE utf8mb4_general_ci, '%') OR n.Contenido COLLATE utf8mb4_general_ci LIKE CONCAT('%', p_buscar COLLATE utf8mb4_general_ci, '%'))
        ORDER BY n.FechaCreacion DESC
        LIMIT p_limite OFFSET p_offset;
    END IF;
END
SQL;

DB::statement("DROP PROCEDURE IF EXISTS SP_MisNotas");
DB::statement($sql);

echo "✅ SP_MisNotas corregido\n";
