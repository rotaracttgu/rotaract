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
        DB::unprepared("CREATE PROCEDURE `SP_ActualizarNota`(IN `p_user_id` BIGINT, IN `p_nota_id` INT, IN `p_titulo` VARCHAR(200), IN `p_contenido` TEXT, IN `p_categoria` ENUM('proyecto','reunion','capacitacion','idea','personal'), IN `p_visibilidad` ENUM('privada','publica'), IN `p_etiquetas` VARCHAR(500), IN `p_fecha_recordatorio` DATETIME)
BEGIN
    DECLARE v_miembro_id INT;
    DECLARE v_propietario INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    -- Verificar que el usuario es el propietario de la nota
    SELECT MiembroID INTO v_propietario
    FROM notas_personales
    WHERE NotaID = p_nota_id;
    
    IF v_propietario = v_miembro_id THEN
        UPDATE notas_personales
        SET 
            Titulo = COALESCE(p_titulo, Titulo),
            Contenido = COALESCE(p_contenido, Contenido),
            Categoria = COALESCE(p_categoria, Categoria),
            Visibilidad = COALESCE(p_visibilidad, Visibilidad),
            Etiquetas = COALESCE(p_etiquetas, Etiquetas),
            FechaRecordatorio = p_fecha_recordatorio,
            FechaActualizacion = CURRENT_TIMESTAMP()
        WHERE NotaID = p_nota_id;
        
        SELECT 'Nota actualizada exitosamente' AS mensaje, 1 AS exito;
    ELSE
        SELECT 'No tienes permiso para editar esta nota' AS mensaje, 0 AS exito;
    END IF;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_ActualizarNota");
    }
};
