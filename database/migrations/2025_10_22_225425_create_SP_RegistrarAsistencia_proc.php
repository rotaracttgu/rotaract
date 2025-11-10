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
        DB::unprepared("CREATE PROCEDURE `SP_RegistrarAsistencia`(IN `p_user_id` BIGINT, IN `p_calendario_id` INT, IN `p_estado_asistencia` ENUM('Presente','Ausente','Justificado'), IN `p_hora_llegada` TIME, IN `p_observacion` TEXT)
BEGIN
    DECLARE v_miembro_id INT;
    DECLARE v_hora_inicio TIME;
    DECLARE v_minutos_tarde INT DEFAULT 0;
    DECLARE v_existe_registro INT;
    
    -- Obtener miembro ID
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    -- Obtener hora de inicio del evento
    SELECT HoraInicio INTO v_hora_inicio
    FROM calendarios
    WHERE CalendarioID = p_calendario_id;
    
    -- Calcular minutos tarde si llegó presente
    IF p_estado_asistencia = 'Presente' AND p_hora_llegada IS NOT NULL AND v_hora_inicio IS NOT NULL THEN
        SET v_minutos_tarde = TIMESTAMPDIFF(MINUTE, v_hora_inicio, p_hora_llegada);
        IF v_minutos_tarde < 0 THEN
            SET v_minutos_tarde = 0;
        END IF;
    END IF;
    
    -- Verificar si ya existe un registro
    SELECT COUNT(*) INTO v_existe_registro
    FROM asistencias
    WHERE MiembroID = v_miembro_id
    AND CalendarioID = p_calendario_id;
    
    IF v_existe_registro > 0 THEN
        -- Actualizar registro existente
        UPDATE asistencias
        SET 
            EstadoAsistencia = p_estado_asistencia,
            HoraLlegada = p_hora_llegada,
            MinutosTarde = v_minutos_tarde,
            Observacion = p_observacion,
            FechaRegistro = CURRENT_TIMESTAMP()
        WHERE MiembroID = v_miembro_id
        AND CalendarioID = p_calendario_id;
        
        SELECT 'Asistencia actualizada exitosamente' AS mensaje, 1 AS exito;
    ELSE
        -- Insertar nuevo registro
        INSERT INTO asistencias (
            MiembroID, CalendarioID, EstadoAsistencia, 
            HoraLlegada, MinutosTarde, Observacion, FechaRegistro
        ) VALUES (
            v_miembro_id, p_calendario_id, p_estado_asistencia,
            p_hora_llegada, v_minutos_tarde, p_observacion, CURRENT_TIMESTAMP()
        );
        
        SELECT 'Asistencia registrada exitosamente' AS mensaje, 1 AS exito, LAST_INSERT_ID() AS AsistenciaID;
    END IF;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_RegistrarAsistencia");
    }
};
