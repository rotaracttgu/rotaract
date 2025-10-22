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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EstadisticasProyectos_Aspirante`(IN `p_user_id` BIGINT)
BEGIN
    DECLARE v_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    SELECT 
        -- Proyectos activos
        (SELECT COUNT(DISTINCT p.ProyectoID)
         FROM proyectos p
         INNER JOIN participaciones part ON p.ProyectoID = part.ProyectoID
         WHERE part.MiembroID = v_miembro_id
         AND p.Estatus = 'Activo'
         AND (part.EstadoParticipacion = 'Activo' OR part.EstadoParticipacion IS NULL)
        ) AS proyectos_activos,
        
        -- Proyectos en planificación
        (SELECT COUNT(DISTINCT p.ProyectoID)
         FROM proyectos p
         INNER JOIN participaciones part ON p.ProyectoID = part.ProyectoID
         WHERE part.MiembroID = v_miembro_id
         AND p.Estatus = 'En Planificacion'
        ) AS proyectos_planificacion,
        
        -- Proyectos completados
        (SELECT COUNT(DISTINCT p.ProyectoID)
         FROM proyectos p
         INNER JOIN participaciones part ON p.ProyectoID = part.ProyectoID
         WHERE part.MiembroID = v_miembro_id
         AND p.Estatus = 'Completado'
        ) AS proyectos_completados,
        
        -- Total de proyectos
        (SELECT COUNT(DISTINCT ProyectoID)
         FROM participaciones
         WHERE MiembroID = v_miembro_id
        ) AS total_proyectos,
        
        -- Proyectos como responsable
        (SELECT COUNT(*)
         FROM proyectos
         WHERE ResponsableID = v_miembro_id
        ) AS proyectos_como_responsable;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_EstadisticasProyectos_Aspirante");
    }
};
