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
        DB::unprepared("CREATE PROCEDURE `SP_Perfil_Aspirante`(IN `p_user_id` BIGINT)
BEGIN
    SELECT 
        u.id AS user_id,
        u.name AS nombre_usuario,
        u.email,
        u.created_at AS fecha_registro,
        m.MiembroID,
        m.DNI_Pasaporte,
        m.Nombre AS nombre_completo,
        m.Rol,
        m.Correo,
        m.FechaIngreso,
        m.Apuntes,
        -- Estadísticas del miembro
        (SELECT COUNT(DISTINCT ProyectoID)
         FROM participaciones
         WHERE MiembroID = m.MiembroID
         AND (EstadoParticipacion = 'Activo' OR EstadoParticipacion IS NULL)
        ) AS proyectos_activos,
        (SELECT 
            CASE 
                WHEN COUNT(*) = 0 THEN 0
                ELSE ROUND((SUM(CASE WHEN EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) * 100.0) / COUNT(*), 2)
            END
         FROM asistencias
         WHERE MiembroID = m.MiembroID
        ) AS porcentaje_asistencia,
        (SELECT COUNT(*)
         FROM asistencias
         WHERE MiembroID = m.MiembroID
         AND EstadoAsistencia = 'Presente'
        ) AS total_asistencias
    FROM users u
    LEFT JOIN miembros m ON u.id = m.user_id
    WHERE u.id = p_user_id;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_Perfil_Aspirante");
    }
};
