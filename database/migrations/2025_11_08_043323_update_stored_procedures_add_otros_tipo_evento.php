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
        // ============================================================================
        // ACTUALIZAR sp_crear_evento_calendario para incluir 'Otros'
        // ============================================================================
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_crear_evento_calendario");
        
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_crear_evento_calendario`(
            IN `p_titulo` VARCHAR(100), 
            IN `p_descripcion` TEXT, 
            IN `p_tipo_evento` ENUM('Virtual','Presencial','InicioProyecto','FinProyecto','Otros'), 
            IN `p_estado_evento` ENUM('Programado','EnCurso','Finalizado'), 
            IN `p_fecha_inicio` DATETIME, 
            IN `p_fecha_fin` DATETIME, 
            IN `p_hora_inicio` TIME, 
            IN `p_hora_fin` TIME, 
            IN `p_ubicacion` VARCHAR(200), 
            IN `p_organizador_id` INT, 
            IN `p_proyecto_id` INT, 
            OUT `p_calendario_id` INT, 
            OUT `p_mensaje` VARCHAR(255)
        )
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

        // ============================================================================
        // ACTUALIZAR sp_actualizar_evento para incluir 'Otros'
        // ============================================================================
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_actualizar_evento");
        
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizar_evento`(
            IN `p_calendario_id` INT, 
            IN `p_titulo` VARCHAR(100), 
            IN `p_descripcion` TEXT, 
            IN `p_tipo_evento` ENUM('Virtual','Presencial','InicioProyecto','FinProyecto','Otros'), 
            IN `p_estado_evento` ENUM('Programado','EnCurso','Finalizado'), 
            IN `p_fecha_inicio` DATETIME, 
            IN `p_fecha_fin` DATETIME, 
            IN `p_hora_inicio` TIME, 
            IN `p_hora_fin` TIME, 
            IN `p_ubicacion` VARCHAR(200), 
            IN `p_organizador_id` INT, 
            IN `p_proyecto_id` INT, 
            OUT `p_mensaje` VARCHAR(255)
        )
        BEGIN
          DECLARE EXIT HANDLER FOR SQLEXCEPTION
          BEGIN
            ROLLBACK;
            SET p_mensaje = 'Error al actualizar el evento';
          END;
          
          START TRANSACTION;
          
          -- Validar que el evento existe
          IF NOT EXISTS (SELECT 1 FROM calendarios WHERE CalendarioID = p_calendario_id) THEN
            SET p_mensaje = 'El evento no existe';
            ROLLBACK;
          -- Validar que el organizador existe si se proporciona
          ELSEIF p_organizador_id IS NOT NULL AND NOT EXISTS (SELECT 1 FROM miembros WHERE MiembroID = p_organizador_id) THEN
            SET p_mensaje = 'El organizador especificado no existe';
            ROLLBACK;
          -- Validar que el proyecto existe si se proporciona
          ELSEIF p_proyecto_id IS NOT NULL AND NOT EXISTS (SELECT 1 FROM proyectos WHERE ProyectoID = p_proyecto_id) THEN
            SET p_mensaje = 'El proyecto especificado no existe';
            ROLLBACK;
          ELSE
            UPDATE calendarios
            SET TituloEvento = p_titulo,
                Descripcion = p_descripcion,
                TipoEvento = p_tipo_evento,
                EstadoEvento = p_estado_evento,
                FechaInicio = p_fecha_inicio,
                FechaFin = p_fecha_fin,
                HoraInicio = p_hora_inicio,
                HoraFin = p_hora_fin,
                Ubicacion = p_ubicacion,
                OrganizadorID = p_organizador_id,
                ProyectoID = p_proyecto_id
            WHERE CalendarioID = p_calendario_id;
            
            SET p_mensaje = 'Evento actualizado exitosamente';
            COMMIT;
          END IF;
        END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ============================================================================
        // REVERTIR sp_crear_evento_calendario (sin 'Otros')
        // ============================================================================
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_crear_evento_calendario");
        
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_crear_evento_calendario`(
            IN `p_titulo` VARCHAR(100), 
            IN `p_descripcion` TEXT, 
            IN `p_tipo_evento` ENUM('Virtual','Presencial','InicioProyecto','FinProyecto'), 
            IN `p_estado_evento` ENUM('Programado','EnCurso','Finalizado'), 
            IN `p_fecha_inicio` DATETIME, 
            IN `p_fecha_fin` DATETIME, 
            IN `p_hora_inicio` TIME, 
            IN `p_hora_fin` TIME, 
            IN `p_ubicacion` VARCHAR(200), 
            IN `p_organizador_id` INT, 
            IN `p_proyecto_id` INT, 
            OUT `p_calendario_id` INT, 
            OUT `p_mensaje` VARCHAR(255)
        )
        BEGIN
          DECLARE EXIT HANDLER FOR SQLEXCEPTION
          BEGIN
            ROLLBACK;
            SET p_mensaje = 'Error al crear el evento';
            SET p_calendario_id = NULL;
          END;
          
          START TRANSACTION;
          
          IF p_organizador_id IS NOT NULL AND NOT EXISTS (SELECT 1 FROM miembros WHERE MiembroID = p_organizador_id) THEN
            SET p_mensaje = 'El organizador especificado no existe';
            SET p_calendario_id = NULL;
            ROLLBACK;
          ELSEIF p_proyecto_id IS NOT NULL AND NOT EXISTS (SELECT 1 FROM proyectos WHERE ProyectoID = p_proyecto_id) THEN
            SET p_mensaje = 'El proyecto especificado no existe';
            SET p_calendario_id = NULL;
            ROLLBACK;
          ELSE
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

        // ============================================================================
        // REVERTIR sp_actualizar_evento (sin 'Otros')
        // ============================================================================
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_actualizar_evento");
        
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizar_evento`(
            IN `p_calendario_id` INT, 
            IN `p_titulo` VARCHAR(100), 
            IN `p_descripcion` TEXT, 
            IN `p_tipo_evento` ENUM('Virtual','Presencial','InicioProyecto','FinProyecto'), 
            IN `p_estado_evento` ENUM('Programado','EnCurso','Finalizado'), 
            IN `p_fecha_inicio` DATETIME, 
            IN `p_fecha_fin` DATETIME, 
            IN `p_hora_inicio` TIME, 
            IN `p_hora_fin` TIME, 
            IN `p_ubicacion` VARCHAR(200), 
            IN `p_organizador_id` INT, 
            IN `p_proyecto_id` INT, 
            OUT `p_mensaje` VARCHAR(255)
        )
        BEGIN
          DECLARE EXIT HANDLER FOR SQLEXCEPTION
          BEGIN
            ROLLBACK;
            SET p_mensaje = 'Error al actualizar el evento';
          END;
          
          START TRANSACTION;
          
          IF NOT EXISTS (SELECT 1 FROM calendarios WHERE CalendarioID = p_calendario_id) THEN
            SET p_mensaje = 'El evento no existe';
            ROLLBACK;
          ELSEIF p_organizador_id IS NOT NULL AND NOT EXISTS (SELECT 1 FROM miembros WHERE MiembroID = p_organizador_id) THEN
            SET p_mensaje = 'El organizador especificado no existe';
            ROLLBACK;
          ELSEIF p_proyecto_id IS NOT NULL AND NOT EXISTS (SELECT 1 FROM proyectos WHERE ProyectoID = p_proyecto_id) THEN
            SET p_mensaje = 'El proyecto especificado no existe';
            ROLLBACK;
          ELSE
            UPDATE calendarios
            SET TituloEvento = p_titulo,
                Descripcion = p_descripcion,
                TipoEvento = p_tipo_evento,
                EstadoEvento = p_estado_evento,
                FechaInicio = p_fecha_inicio,
                FechaFin = p_fecha_fin,
                HoraInicio = p_hora_inicio,
                HoraFin = p_hora_fin,
                Ubicacion = p_ubicacion,
                OrganizadorID = p_organizador_id,
                ProyectoID = p_proyecto_id
            WHERE CalendarioID = p_calendario_id;
            
            SET p_mensaje = 'Evento actualizado exitosamente';
            COMMIT;
          END IF;
        END");
    }
};
