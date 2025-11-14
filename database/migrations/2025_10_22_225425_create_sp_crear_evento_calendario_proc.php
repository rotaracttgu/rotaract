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
        DB::unprepared("CREATE PROCEDURE `sp_crear_evento_calendario`(IN `p_titulo` VARCHAR(100), IN `p_descripcion` TEXT, IN `p_tipo_evento` ENUM('Virtual','Presencial','InicioProyecto','FinProyecto'), IN `p_estado_evento` ENUM('Programado','EnCurso','Finalizado'), IN `p_fecha_inicio` DATETIME, IN `p_fecha_fin` DATETIME, IN `p_hora_inicio` TIME, IN `p_hora_fin` TIME, IN `p_ubicacion` VARCHAR(200), IN `p_organizador_id` INT, IN `p_proyecto_id` INT, OUT `p_calendario_id` INT, OUT `p_mensaje` VARCHAR(255))
BEGIN
  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    ROLLBACK;
    SET p_mensaje = 'Error al crear el evento';
    SET p_calendario_id = NULL;
  END;
  
  START TRANSACTION;
  
  -- Validar que el organizador existe
  IF p_organizador_id IS NOT NULL AND NOT EXISTS (SELECT 1 FROM miembros WHERE MiembroID = p_organizador_id) THEN
    SET p_mensaje = 'El organizador especificado no existe';
    SET p_calendario_id = NULL;
    ROLLBACK;
  -- Validar que el proyecto existe si se proporciona
  ELSEIF p_proyecto_id IS NOT NULL AND NOT EXISTS (SELECT 1 FROM proyectos WHERE ProyectoID = p_proyecto_id) THEN
    SET p_mensaje = 'El proyecto especificado no existe';
    SET p_calendario_id = NULL;
    ROLLBACK;
  ELSE
    -- Insertar el evento
    INSERT INTO calendarios (
      TituloEvento, Descripcion, TipoEvento, EstadoEvento,
      FechaInicio, FechaFin, HoraInicio, HoraFin,
      Ubicacion, OrganizadorID, ProyectoID
    ) VALUES (
      p_titulo, p_descripcion, p_tipo_evento, p_estado_evento,
      p_fecha_inicio, p_fecha_fin, p_hora_inicio, p_hora_fin,
      p_ubicacion, p_organizador_id, p_proyecto_id
    );
    
    SET p_calendario_id = LAST_INSERT_ID();
    SET p_mensaje = 'Evento creado exitosamente';
    
    COMMIT;
  END IF;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_crear_evento_calendario");
    }
};
