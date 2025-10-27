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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CrearNota`(IN `p_user_id` BIGINT, IN `p_titulo` VARCHAR(200), IN `p_contenido` TEXT, IN `p_categoria` VARCHAR(50), IN `p_visibilidad` VARCHAR(20), IN `p_etiquetas` VARCHAR(500), IN `p_recordatorio` DATETIME)
BEGIN
    DECLARE v_miembro_id INT;
    DECLARE v_nota_id INT;
    
    -- Obtener MiembroID desde user_id
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id
    LIMIT 1;
    
    -- Insertar la nota
    INSERT INTO notas_personales (
        MiembroID,
        Titulo,
        Contenido,
        Categoria,
        Visibilidad,
        Etiquetas,
        FechaRecordatorio,
        FechaCreacion,
        FechaActualizacion,
        Estado
    ) VALUES (
        v_miembro_id,
        p_titulo,
        p_contenido,
        p_categoria,
        p_visibilidad,
        p_etiquetas,
        p_recordatorio,
        NOW(),
        NOW(),
        'activa'
    );
    
    -- Obtener el ID de la nota recién creada
    SET v_nota_id = LAST_INSERT_ID();
    
    -- Retornar resultado
    SELECT 
        1 AS exito,
        'Nota creada exitosamente' AS mensaje,
        v_nota_id AS nota_id;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_CrearNota");
    }
};
