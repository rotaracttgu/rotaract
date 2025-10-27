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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ValidarDatosAspirante`(IN `p_user_id` BIGINT)
BEGIN
    DECLARE v_miembro_id INT;
    DECLARE v_tiene_miembro INT DEFAULT 0;
    DECLARE v_tiene_rol INT DEFAULT 0;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    SET v_tiene_miembro = IF(v_miembro_id IS NOT NULL, 1, 0);
    
    SELECT COUNT(*) INTO v_tiene_rol
    FROM model_has_roles
    WHERE model_type = 'App\\Models\\User'
    AND model_id = p_user_id;
    
    SELECT 
        p_user_id AS user_id_verificado,
        v_tiene_miembro AS tiene_registro_miembro,
        v_miembro_id AS miembro_id,
        v_tiene_rol AS tiene_rol_asignado,
        (SELECT COUNT(*) FROM proyectos p
         INNER JOIN participaciones part ON p.ProyectoID = part.ProyectoID
         WHERE part.MiembroID = v_miembro_id
        ) AS proyectos_vinculados,
        (SELECT COUNT(*) FROM asistencias WHERE MiembroID = v_miembro_id) AS registros_asistencia,
        (SELECT COUNT(*) FROM notas_personales WHERE MiembroID = v_miembro_id AND Estado = 'activa') AS notas_activas,
        (SELECT COUNT(*) FROM mensajes_consultas WHERE MiembroID = v_miembro_id) AS consultas_realizadas,
        CASE 
            WHEN v_tiene_miembro = 0 THEN 'ADVERTENCIA: No existe registro en tabla miembros'
            WHEN v_tiene_rol = 0 THEN 'ADVERTENCIA: No tiene rol asignado'
            ELSE 'OK: Datos completos'
        END AS estado_validacion;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_ValidarDatosAspirante");
    }
};
