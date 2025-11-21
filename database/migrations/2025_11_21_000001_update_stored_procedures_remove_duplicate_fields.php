<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Actualizar 15 stored procedures para usar JOIN con users en lugar de campos duplicados.
     * Eliminados SPs obsoletos de "Aspirante" (rol ya no existe).
     */
    public function up(): void
    {
        // 1. sp_obtener_todos_miembros
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_obtener_todos_miembros");
        DB::unprepared("CREATE PROCEDURE `sp_obtener_todos_miembros`()
BEGIN
  SELECT 
    m.MiembroID,
    u.name AS Nombre,
    u.email AS Correo,
    m.Rol,
    u.dni AS DNI_Pasaporte,
    m.FechaIngreso
  FROM miembros m
  INNER JOIN users u ON m.user_id = u.id
  ORDER BY u.name;
END");

        // 2. SP_ObtenerMiembrosParaAsistencia
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_obtener_miembros_para_asistencia");
        DB::unprepared("CREATE PROCEDURE `sp_obtener_miembros_para_asistencia`(IN p_evento_id INT)
BEGIN
  SELECT 
    m.MiembroID,
    u.name AS Nombre,
    u.email AS Correo,
    m.Rol,
    u.dni AS DNI_Pasaporte
  FROM miembros m
  INNER JOIN users u ON m.user_id = u.id
  WHERE m.MiembroID NOT IN (
    SELECT a.MiembroID FROM asistencias a WHERE a.EventoID = p_evento_id
  )
  ORDER BY u.name;
END");

        // 3. SP_NotasPublicasPopulares
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_NotasPublicasPopulares");
        DB::unprepared("CREATE PROCEDURE `SP_NotasPublicasPopulares`(IN p_limite INT)
BEGIN
    SELECT 
        n.NotaID,
        n.Titulo,
        n.Contenido,
        n.Categoria,
        n.FechaCreacion,
        u.name AS autor,
        n.MiembroID
    FROM notas_personales n
    INNER JOIN miembros m ON n.MiembroID = m.MiembroID
    INNER JOIN users u ON m.user_id = u.id
    WHERE n.Visibilidad = 'publica'
    ORDER BY n.FechaCreacion DESC
    LIMIT p_limite;
END");

        // 4. SP_MisNotas
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_MisNotas");
        DB::unprepared("CREATE PROCEDURE `SP_MisNotas`(
    IN p_user_id INT,
    IN p_categoria VARCHAR(50),
    IN p_visibilidad VARCHAR(20),
    IN p_buscar VARCHAR(100),
    IN p_limite INT,
    IN p_offset INT
)
BEGIN
    DECLARE v_miembro_id INT DEFAULT NULL;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros 
    WHERE user_id = p_user_id
    LIMIT 1;
    
    IF v_miembro_id IS NULL THEN
        SELECT 0 AS exito, 'No se encontró el miembro asociado al usuario' AS mensaje;
    ELSE
        SELECT 
            n.NotaID,
            n.Titulo,
            n.Contenido,
            n.Categoria,
            n.FechaCreacion,
            n.Visibilidad,
            n.Etiquetas,
            n.Estado,
            n.MiembroID,
            u.name AS AutorNombre,
            COALESCE((
                SELECT COUNT(*) 
                FROM notas_personales n2 
                WHERE n2.MiembroID = v_miembro_id
                AND (p_categoria IS NULL OR n2.Categoria COLLATE utf8mb4_general_ci = p_categoria COLLATE utf8mb4_general_ci)
                AND (p_visibilidad IS NULL OR n2.Visibilidad COLLATE utf8mb4_general_ci = p_visibilidad COLLATE utf8mb4_general_ci)
                AND (p_buscar = '' OR n2.Titulo LIKE CONCAT('%', p_buscar, '%') OR n2.Contenido LIKE CONCAT('%', p_buscar, '%'))
            ), 0) AS total_resultados
        FROM notas_personales n
        INNER JOIN miembros m ON n.MiembroID = m.MiembroID
        INNER JOIN users u ON m.user_id = u.id
        WHERE n.MiembroID = v_miembro_id
        AND n.Estado COLLATE utf8mb4_general_ci = 'activa'
        AND (p_categoria IS NULL OR n.Categoria COLLATE utf8mb4_general_ci = p_categoria COLLATE utf8mb4_general_ci)
        AND (p_visibilidad IS NULL OR n.Visibilidad COLLATE utf8mb4_general_ci = p_visibilidad COLLATE utf8mb4_general_ci)
        AND (p_buscar = '' OR n.Titulo LIKE CONCAT('%', p_buscar, '%') OR n.Contenido LIKE CONCAT('%', p_buscar, '%'))
        ORDER BY n.FechaCreacion DESC
        LIMIT p_limite OFFSET p_offset;
    END IF;
END");

        // 5. SP_ObtenerConversacion
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_ObtenerConversacion");
        DB::unprepared("CREATE PROCEDURE `SP_ObtenerConversacion`(
    IN p_usuario_id INT,
    IN p_contacto_id INT
)
BEGIN
    DECLARE v_miembro_id INT;
    DECLARE v_contacto_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros 
    WHERE user_id = p_usuario_id
    LIMIT 1;
    
    SELECT MiembroID INTO v_contacto_miembro_id
    FROM miembros 
    WHERE user_id = p_contacto_id
    LIMIT 1;
    
    IF v_miembro_id IS NULL OR v_contacto_miembro_id IS NULL THEN
        SELECT 0 AS exito, 'Usuario o contacto no encontrado' AS mensaje;
    ELSE
        SELECT 
            msg.MensajeID,
            msg.RemitenteID,
            msg.DestinatarioID,
            msg.Contenido,
            msg.FechaEnvio,
            msg.Leido,
            u.name AS nombre_remitente,
            msg.RemitenteID = v_miembro_id AS es_propio
        FROM mensajes msg
        INNER JOIN miembros m ON msg.RemitenteID = m.MiembroID
        INNER JOIN users u ON m.user_id = u.id
        WHERE 
            (msg.RemitenteID = v_miembro_id AND msg.DestinatarioID = v_contacto_miembro_id)
            OR (msg.RemitenteID = v_contacto_miembro_id AND msg.DestinatarioID = v_miembro_id)
        ORDER BY msg.FechaEnvio ASC;
    END IF;
END");

        // 6. sp_obtener_asistencias_evento
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_obtener_asistencias_evento");
        DB::unprepared("CREATE PROCEDURE `sp_obtener_asistencias_evento`(IN p_evento_id INT)
BEGIN
  SELECT 
    a.AsistenciaID,
    a.MiembroID,
    u.name AS NombreParticipante,
    a.Presente,
    a.Observaciones,
    a.FechaRegistro
  FROM asistencias a
  INNER JOIN miembros m ON a.MiembroID = m.MiembroID
  INNER JOIN users u ON m.user_id = u.id
  WHERE a.EventoID = p_evento_id
  ORDER BY u.name;
END");

        // 7-9. Procedimientos de eventos (3 similares)
        $eventosProcedures = [
            'sp_obtener_eventos_por_tipo' => "IN p_tipo VARCHAR(50)",
            'sp_obtener_eventos_por_estado' => "IN p_estado VARCHAR(20)",
            'sp_obtener_todos_eventos' => ""
        ];

        foreach ($eventosProcedures as $procName => $params) {
            DB::unprepared("DROP PROCEDURE IF EXISTS {$procName}");
            $paramsClause = $params ? "({$params})" : "()";
            $whereClause = $params ? "WHERE e.Tipo COLLATE utf8mb4_general_ci = p_tipo COLLATE utf8mb4_general_ci" : "";
            if ($procName === 'sp_obtener_eventos_por_estado') {
                $whereClause = "WHERE e.Estado COLLATE utf8mb4_general_ci = p_estado COLLATE utf8mb4_general_ci";
            }
            
            DB::unprepared("CREATE PROCEDURE `{$procName}`{$paramsClause}
BEGIN
  SELECT 
    e.EventoID,
    e.NombreEvento,
    e.Tipo,
    e.FechaEvento,
    e.HoraInicio,
    e.HoraFin,
    e.Ubicacion,
    e.Descripcion,
    e.Estado,
    e.OrganizadorID,
    COALESCE(u.name, 'Sin Organizador') AS NombreOrganizador,
    e.ProyectoID
  FROM eventos e
  LEFT JOIN miembros m ON e.OrganizadorID = m.MiembroID
  LEFT JOIN users u ON m.user_id = u.id
  {$whereClause}
  ORDER BY e.FechaEvento DESC;
END");
        }

        // 10. sp_buscar_eventos_por_fecha
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_buscar_eventos_por_fecha");
        DB::unprepared("CREATE PROCEDURE `sp_buscar_eventos_por_fecha`(IN `p_fecha_inicio` DATE, IN `p_fecha_fin` DATE)
BEGIN
  SELECT 
    c.CalendarioID,
    c.TituloEvento,
    c.Descripcion,
    c.TipoEvento,
    c.EstadoEvento,
    c.FechaInicio,
    c.FechaFin,
    c.HoraInicio,
    c.HoraFin,
    c.Ubicacion,
    COALESCE(u.name, 'Sin Organizador') AS NombreOrganizador
  FROM calendarios c
  LEFT JOIN miembros m ON c.OrganizadorID = m.MiembroID
  LEFT JOIN users u ON m.user_id = u.id
  WHERE DATE(c.FechaInicio) BETWEEN p_fecha_inicio AND p_fecha_fin
  ORDER BY c.FechaInicio;
END");

        // 11. SP_DetalleNota
        DB::unprepared("DROP PROCEDURE IF EXISTS SP_DetalleNota");
        DB::unprepared("CREATE PROCEDURE `SP_DetalleNota`(IN `p_user_id` BIGINT, IN `p_nota_id` INT)
BEGIN
    DECLARE v_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    SELECT 
        n.NotaID,
        n.Titulo,
        n.Contenido,
        n.Categoria,
        n.Visibilidad,
        n.Etiquetas,
        n.FechaCreacion,
        n.FechaActualizacion,
        n.FechaRecordatorio,
        n.Estado,
        u.name AS autor
    FROM notas_personales n
    INNER JOIN miembros m ON n.MiembroID = m.MiembroID
    INNER JOIN users u ON m.user_id = u.id
    WHERE n.NotaID = p_nota_id
    AND (n.MiembroID = v_miembro_id OR n.Visibilidad = 'publica')
    AND n.Estado = 'activa';
END");

        // 12. sp_estadisticas_asistencia_miembro
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_estadisticas_asistencia_miembro");
        DB::unprepared("CREATE PROCEDURE `sp_estadisticas_asistencia_miembro`(IN `p_miembro_id` INT)
BEGIN
  SELECT 
    m.MiembroID,
    u.name AS Nombre,
    u.email AS Correo,
    COUNT(a.AsistenciaID) AS TotalEventos,
    SUM(CASE WHEN a.EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) AS TotalPresente,
    SUM(CASE WHEN a.EstadoAsistencia = 'Ausente' THEN 1 ELSE 0 END) AS TotalAusente,
    SUM(CASE WHEN a.EstadoAsistencia = 'Justificado' THEN 1 ELSE 0 END) AS TotalJustificado,
    ROUND(
      (SUM(CASE WHEN a.EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) * 100.0) / 
      NULLIF(COUNT(a.AsistenciaID), 0), 2
    ) AS PorcentajeAsistencia,
    SUM(COALESCE(a.MinutosTarde, 0)) AS TotalMinutosTarde
  FROM miembros m
  INNER JOIN users u ON m.user_id = u.id
  LEFT JOIN asistencias a ON m.MiembroID = a.MiembroID
  WHERE m.MiembroID = p_miembro_id
  GROUP BY m.MiembroID, u.name, u.email;
END");

        // 13. sp_generar_reporte_detallado_eventos
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_generar_reporte_detallado_eventos");
        DB::unprepared("CREATE PROCEDURE `sp_generar_reporte_detallado_eventos`()
BEGIN
  SELECT
    c.CalendarioID,
    c.TituloEvento,
    c.TipoEvento,
    c.EstadoEvento,
    c.FechaInicio,
    c.FechaFin,
    c.Ubicacion,
    COALESCE(u.name, 'Sin Organizador') AS Organizador,
    COUNT(DISTINCT a.AsistenciaID) AS TotalAsistencias,
    SUM(CASE WHEN a.EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) AS TotalPresentes,
    SUM(CASE WHEN a.EstadoAsistencia = 'Ausente' THEN 1 ELSE 0 END) AS TotalAusentes,
    SUM(CASE WHEN a.EstadoAsistencia = 'Justificado' THEN 1 ELSE 0 END) AS TotalJustificados,
    ROUND(
      (SUM(CASE WHEN a.EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) * 100.0) / 
      NULLIF(COUNT(DISTINCT a.AsistenciaID), 0), 2
    ) AS PorcentajeAsistencia
  FROM calendarios c
  LEFT JOIN miembros m ON c.OrganizadorID = m.MiembroID
  LEFT JOIN users u ON m.user_id = u.id
  LEFT JOIN asistencias a ON c.CalendarioID = a.CalendarioID
  GROUP BY c.CalendarioID, c.TituloEvento, c.TipoEvento, c.EstadoEvento, 
           c.FechaInicio, c.FechaFin, c.Ubicacion, u.name
  ORDER BY c.FechaInicio DESC;
END");

        // 14. sp_generar_reporte_evento
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_generar_reporte_evento");
        DB::unprepared("CREATE PROCEDURE `sp_generar_reporte_evento`(IN `p_calendario_id` INT)
BEGIN
  SELECT
    c.CalendarioID,
    c.TituloEvento,
    c.TipoEvento,
    c.EstadoEvento,
    c.FechaInicio,
    c.FechaFin,
    c.HoraInicio,
    c.HoraFin,
    c.Ubicacion,
    COALESCE(u.name, 'Sin Organizador') AS Organizador,
    u.email AS CorreoOrganizador,
    COUNT(DISTINCT a.AsistenciaID) AS TotalRegistros,
    SUM(CASE WHEN a.EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) AS TotalPresentes,
    SUM(CASE WHEN a.EstadoAsistencia = 'Ausente' THEN 1 ELSE 0 END) AS TotalAusentes,
    SUM(CASE WHEN a.EstadoAsistencia = 'Justificado' THEN 1 ELSE 0 END) AS TotalJustificados,
    ROUND(
      (SUM(CASE WHEN a.EstadoAsistencia = 'Presente' THEN 1 ELSE 0 END) * 100.0) / 
      NULLIF(COUNT(DISTINCT a.AsistenciaID), 0), 2
    ) AS PorcentajeAsistencia
  FROM calendarios c
  LEFT JOIN miembros m ON c.OrganizadorID = m.MiembroID
  LEFT JOIN users u ON m.user_id = u.id
  LEFT JOIN asistencias a ON c.CalendarioID = a.CalendarioID
  WHERE c.CalendarioID = p_calendario_id
  GROUP BY c.CalendarioID, c.TituloEvento, c.TipoEvento, c.EstadoEvento,
           c.FechaInicio, c.FechaFin, c.HoraInicio, c.HoraFin, c.Ubicacion, 
           u.name, u.email;
END");

        // 15. sp_obtener_detalle_evento
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_obtener_detalle_evento");
        DB::unprepared("CREATE PROCEDURE `sp_obtener_detalle_evento`(IN `p_calendario_id` INT)
BEGIN
  SELECT 
    c.CalendarioID,
    c.TituloEvento,
    c.Descripcion,
    c.TipoEvento,
    c.EstadoEvento,
    c.FechaInicio,
    c.FechaFin,
    c.HoraInicio,
    c.HoraFin,
    c.Ubicacion,
    c.OrganizadorID,
    COALESCE(u.name, 'Sin Organizador') AS NombreOrganizador,
    u.email AS CorreoOrganizador,
    c.ProyectoID,
    p.Nombre AS NombreProyecto,
    p.Descripcion AS DescripcionProyecto
  FROM calendarios c
  LEFT JOIN miembros m ON c.OrganizadorID = m.MiembroID
  LEFT JOIN users u ON m.user_id = u.id
  LEFT JOIN proyectos p ON c.ProyectoID = p.ProyectoID
  WHERE c.CalendarioID = p_calendario_id;
END");
    }

    /**
     * Reverse the migrations.
     * Revertir todos los cambios (restaurar versiones antiguas).
     */
    public function down(): void
    {
        // Revertir requiere recrear los procedimientos con los campos antiguos
        // Por simplicidad, solo eliminamos los procedimientos
        $procedures = [
            'sp_obtener_todos_miembros',
            'sp_obtener_miembros_para_asistencia',
            'SP_NotasPublicasPopulares',
            'SP_MisNotas',
            'SP_ObtenerConversacion',
            'sp_obtener_asistencias_evento',
            'sp_obtener_eventos_por_tipo',
            'sp_obtener_eventos_por_estado',
            'sp_obtener_todos_eventos',
            'sp_buscar_eventos_por_fecha',
            'SP_DetalleNota',
            'sp_estadisticas_asistencia_miembro',
            'sp_generar_reporte_detallado_eventos',
            'sp_generar_reporte_evento',
            'sp_obtener_detalle_evento',
        ];

        foreach ($procedures as $proc) {
            DB::unprepared("DROP PROCEDURE IF EXISTS {$proc}");
        }
    }
};
