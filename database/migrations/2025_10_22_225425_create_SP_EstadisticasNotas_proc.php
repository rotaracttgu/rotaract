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
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EstadisticasNotas`(IN `p_user_id` BIGINT)
BEGIN
    DECLARE v_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    SELECT 
        -- Total de notas
        (SELECT COUNT(*) 
         FROM notas_personales 
         WHERE MiembroID = v_miembro_id AND Estado = 'activa'
        ) AS total_notas,
        
        -- Notas privadas
        (SELECT COUNT(*) 
         FROM notas_personales 
         WHERE MiembroID = v_miembro_id AND Estado = 'activa' AND Visibilidad = 'privada'
        ) AS notas_privadas,
        
        -- Notas públicas
        (SELECT COUNT(*) 
         FROM notas_personales 
         WHERE MiembroID = v_miembro_id AND Estado = 'activa' AND Visibilidad = 'publica'
        ) AS notas_publicas,
        
        -- Notas este mes
        (SELECT COUNT(*) 
         FROM notas_personales 
         WHERE MiembroID = v_miembro_id 
         AND Estado = 'activa'
         AND MONTH(FechaCreacion) = MONTH(CURRENT_DATE())
         AND YEAR(FechaCreacion) = YEAR(CURRENT_DATE())
        ) AS notas_este_mes,
        
        -- Notas por categoría
        (SELECT COUNT(*) FROM notas_personales WHERE MiembroID = v_miembro_id AND Estado = 'activa' AND Categoria = 'proyecto') AS notas_proyecto,
        (SELECT COUNT(*) FROM notas_personales WHERE MiembroID = v_miembro_id AND Estado = 'activa' AND Categoria = 'reunion') AS notas_reunion,
        (SELECT COUNT(*) FROM notas_personales WHERE MiembroID = v_miembro_id AND Estado = 'activa' AND Categoria = 'capacitacion') AS notas_capacitacion,
        (SELECT COUNT(*) FROM notas_personales WHERE MiembroID = v_miembro_id AND Estado = 'activa' AND Categoria = 'idea') AS notas_idea,
        (SELECT COUNT(*) FROM notas_personales WHERE MiembroID = v_miembro_id AND Estado = 'activa' AND Categoria = 'personal') AS notas_personal;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_EstadisticasNotas");
    }
};
