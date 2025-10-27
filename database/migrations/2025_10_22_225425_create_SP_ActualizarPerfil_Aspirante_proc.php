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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ActualizarPerfil_Aspirante`(IN `p_user_id` BIGINT, IN `p_dni_pasaporte` VARCHAR(20), IN `p_nombre` VARCHAR(100), IN `p_correo` VARCHAR(100), IN `p_apuntes` TEXT)
BEGIN
    DECLARE v_miembro_id INT;
    DECLARE v_existe_miembro INT;
    
    -- Verificar si existe el miembro
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    IF v_miembro_id IS NULL THEN
        -- Si no existe, crear el registro del miembro
        INSERT INTO miembros (user_id, DNI_Pasaporte, Nombre, Correo, FechaIngreso, Apuntes)
        VALUES (p_user_id, p_dni_pasaporte, p_nombre, p_correo, CURRENT_DATE(), p_apuntes);
        
        SELECT LAST_INSERT_ID() AS MiembroID, 'Perfil creado exitosamente' AS mensaje, 1 AS exito;
    ELSE
        -- Si existe, actualizar
        UPDATE miembros
        SET 
            DNI_Pasaporte = COALESCE(p_dni_pasaporte, DNI_Pasaporte),
            Nombre = COALESCE(p_nombre, Nombre),
            Correo = COALESCE(p_correo, Correo),
            Apuntes = COALESCE(p_apuntes, Apuntes)
        WHERE MiembroID = v_miembro_id;
        
        SELECT v_miembro_id AS MiembroID, 'Perfil actualizado exitosamente' AS mensaje, 1 AS exito;
    END IF;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_ActualizarPerfil_Aspirante");
    }
};
