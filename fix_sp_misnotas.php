<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Recreando SP_MisNotas con collation corregida...\n";

try {
    DB::statement('DROP PROCEDURE IF EXISTS SP_MisNotas');
    
    DB::unprepared("CREATE PROCEDURE `SP_MisNotas`(
        IN `p_user_id` BIGINT, 
        IN `p_categoria` VARCHAR(50), 
        IN `p_visibilidad` VARCHAR(20), 
        IN `p_buscar` VARCHAR(255), 
        IN `p_limite` INT, 
        IN `p_offset` INT
    )
BEGIN
    DECLARE v_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id
    LIMIT 1;
    
    IF v_miembro_id IS NULL THEN
        SELECT 
            0 AS total_registros,
            'Usuario no tiene miembro asociado' AS mensaje;
        SELECT * FROM notas_personales WHERE 1=0;
    ELSE
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
            m.Nombre AS AutorNombre,
            u.email AS AutorEmail
        FROM notas_personales n
        INNER JOIN miembros m ON m.MiembroID = n.MiembroID
        INNER JOIN users u ON u.id = m.user_id
        WHERE n.MiembroID = v_miembro_id
        AND n.Estado = 'activa'
        AND (p_categoria IS NULL OR n.Categoria = CAST(p_categoria AS CHAR CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci))
        AND (p_visibilidad IS NULL OR n.Visibilidad = CAST(p_visibilidad AS CHAR CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci))
        AND (p_buscar IS NULL OR p_buscar = '' OR n.Titulo LIKE CONCAT('%', CAST(p_buscar AS CHAR CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci), '%') OR n.Contenido LIKE CONCAT('%', CAST(p_buscar AS CHAR CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci), '%') OR n.Etiquetas LIKE CONCAT('%', CAST(p_buscar AS CHAR CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci), '%'))
        ORDER BY n.FechaCreacion DESC
        LIMIT p_limite OFFSET p_offset;
    END IF;
END");
    
    echo "✓ SP_MisNotas recreado exitosamente\n";
    
    // Probar el SP
    echo "\nProbando SP con usuario 5...\n";
    $resultado = DB::select('CALL SP_MisNotas(?, ?, ?, ?, ?, ?)', [5, null, null, '', 50, 0]);
    echo "Notas encontradas: " . count($resultado) . "\n";
    
    if (count($resultado) > 0) {
        foreach ($resultado as $nota) {
            echo "- {$nota->Titulo} (ID: {$nota->NotaID})\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
