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
        DB::unprepared("CREATE PROCEDURE `sp_actualizar_evento`(IN `p_calendario_id` INT, IN `p_titulo` VARCHAR(100), IN `p_descripcion` TEXT, IN `p_tipo_evento` ENUM('Virtual','Presencial','InicioProyecto','FinProyecto'), IN `p_estado_evento` ENUM('Programado','EnCurso','Finalizado'), IN `p_fecha_inicio` DATETIME, IN `p_fecha_fin` DATETIME, IN `p_hora_inicio` TIME, IN `p_hora_fin` TIME, IN `p_ubicacion` VARCHAR(200), IN `p_organizador_id` INT, IN `p_proyecto_id` INT, OUT `p_mensaje` VARCHAR(255))
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
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_actualizar_evento");
    }
};
