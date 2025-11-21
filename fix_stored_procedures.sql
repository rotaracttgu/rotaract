-- Script para actualizar stored procedures corregidos sin perder datos
-- Fecha: 2025-11-21
-- Corrección: Cambiar referencias de m.Nombre/m.Correo a u.name/u.email

-- 1. sp_buscar_eventos_por_fecha
DROP PROCEDURE IF EXISTS sp_buscar_eventos_por_fecha;

DELIMITER $$
CREATE PROCEDURE `sp_buscar_eventos_por_fecha`(
    IN `p_fecha_inicio` DATE,
    IN `p_fecha_fin` DATE
)
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
    COALESCE(u.name, 'Sin Organizador') AS NombreOrganizador,
    c.ProyectoID
  FROM calendarios c
  LEFT JOIN miembros m ON c.OrganizadorID = m.MiembroID
  LEFT JOIN users u ON m.user_id = u.id
  WHERE c.FechaInicio >= p_fecha_inicio
    AND c.FechaFin <= p_fecha_fin
  ORDER BY c.FechaInicio, c.HoraInicio;
END$$
DELIMITER ;

-- 2. SP_Calendario_Aspirante
DROP PROCEDURE IF EXISTS SP_Calendario_Aspirante;

DELIMITER $$
CREATE PROCEDURE `SP_Calendario_Aspirante`(
    IN `p_user_id` BIGINT,
    IN `p_mes` INT,
    IN `p_anio` INT,
    IN `p_tipo_evento` VARCHAR(50)
)
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
        u_org.name AS nombre_organizador,
        c.ProyectoID,
        p.Nombre AS nombre_proyecto,
        c.FechaCreacion,
        c.FechaActualizacion
    FROM calendarios c
    LEFT JOIN miembros m_org ON c.OrganizadorID = m_org.MiembroID
    LEFT JOIN users u_org ON m_org.user_id = u_org.id
    LEFT JOIN proyectos p ON c.ProyectoID = p.ProyectoID
    WHERE (p_mes IS NULL OR MONTH(c.FechaInicio) = p_mes)
      AND (p_anio IS NULL OR YEAR(c.FechaInicio) = p_anio)
      AND (p_tipo_evento IS NULL OR p_tipo_evento = '' OR c.TipoEvento = p_tipo_evento)
    ORDER BY c.FechaInicio ASC, c.HoraInicio ASC;
END$$
DELIMITER ;

-- 3. SP_EventosDelDia
DROP PROCEDURE IF EXISTS SP_EventosDelDia;

DELIMITER $$
CREATE PROCEDURE `SP_EventosDelDia`(IN `p_fecha` DATE)
BEGIN
    SELECT 
        c.CalendarioID,
        c.TituloEvento,
        c.Descripcion,
        c.TipoEvento,
        c.HoraInicio,
        c.HoraFin,
        c.Ubicacion,
        u_org.name AS organizador,
        p.Nombre AS proyecto,
        c.EstadoEvento
    FROM calendarios c
    LEFT JOIN miembros m_org ON c.OrganizadorID = m_org.MiembroID
    LEFT JOIN users u_org ON m_org.user_id = u_org.id
    LEFT JOIN proyectos p ON c.ProyectoID = p.ProyectoID
    WHERE DATE(c.FechaInicio) = p_fecha
    ORDER BY c.HoraInicio;
END$$
DELIMITER ;

-- 4. sp_estadisticas_asistencia_miembro
DROP PROCEDURE IF EXISTS sp_estadisticas_asistencia_miembro;

DELIMITER $$
CREATE PROCEDURE `sp_estadisticas_asistencia_miembro`(IN `p_miembro_id` INT)
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
END$$
DELIMITER ;

-- 5. sp_generar_reporte_evento
DROP PROCEDURE IF EXISTS sp_generar_reporte_evento;

DELIMITER $$
CREATE PROCEDURE `sp_generar_reporte_evento`(IN `p_calendario_id` INT)
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
END$$
DELIMITER ;

-- 6. SP_MisNotas (antigua)
DROP PROCEDURE IF EXISTS SP_MisNotas;

DELIMITER $$
CREATE PROCEDURE `SP_MisNotas`(
    IN `p_user_id` BIGINT,
    IN `p_categoria` VARCHAR(50),
    IN `p_visibilidad` VARCHAR(20),
    IN `p_buscar` VARCHAR(255),
    IN `p_limite` INT,
    IN `p_offset` INT
)
BEGIN
    DECLARE v_miembro_id INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id
    LIMIT 1;
    
    IF v_miembro_id IS NULL THEN
        SELECT * FROM notas_personales WHERE 1=0;
    ELSE
        SELECT 
            n.NotaID,
            n.MiembroID,
            n.Titulo,
            n.Contenido,
            n.Categoria,
            n.Visibilidad,
            n.Etiquetas,
            n.FechaRecordatorio,
            n.FechaCreacion,
            n.FechaActualizacion,
            n.Estado,
            u.name AS AutorNombre,
            u.email AS AutorEmail
        FROM notas_personales n
        INNER JOIN miembros m ON m.MiembroID = n.MiembroID
        INNER JOIN users u ON u.id = m.user_id
        WHERE n.MiembroID = v_miembro_id
        AND n.Estado = 'activa'
        AND (p_categoria IS NULL OR n.Categoria = CAST(p_categoria AS CHAR))
        AND (p_visibilidad IS NULL OR n.Visibilidad = CAST(p_visibilidad AS CHAR))
        AND (p_buscar IS NULL OR p_buscar = '' OR n.Titulo LIKE CONCAT('%', CAST(p_buscar AS CHAR), '%') OR n.Contenido LIKE CONCAT('%', CAST(p_buscar AS CHAR), '%') OR n.Etiquetas LIKE CONCAT('%', CAST(p_buscar AS CHAR), '%'))
        ORDER BY n.FechaCreacion DESC
        LIMIT p_limite OFFSET p_offset;
    END IF;
END$$
DELIMITER ;

-- 7. SP_NotasPublicasPopulares (antigua)
DROP PROCEDURE IF EXISTS SP_NotasPublicasPopulares;

DELIMITER $$
CREATE PROCEDURE `SP_NotasPublicasPopulares`(IN `p_limite` INT)
BEGIN
    SELECT 
        n.NotaID,
        n.Titulo,
        n.Contenido,
        n.Categoria,
        n.FechaCreacion,
        u.name AS autor,
        CASE 
            WHEN LENGTH(n.Contenido) > 100 THEN CONCAT(SUBSTRING(n.Contenido, 1, 100), '...')
            ELSE n.Contenido
        END AS resumen,
        0 AS total_vistas,
        0 AS total_comentarios
    FROM notas_personales n
    INNER JOIN miembros m ON n.MiembroID = m.MiembroID
    INNER JOIN users u ON m.user_id = u.id
    WHERE n.Visibilidad = 'publica'
    AND n.Estado = 'activa'
    ORDER BY n.FechaCreacion DESC
    LIMIT p_limite;
END$$
DELIMITER ;

-- 8. sp_obtener_asistencias_evento
DROP PROCEDURE IF EXISTS sp_obtener_asistencias_evento;

DELIMITER $$
CREATE PROCEDURE `sp_obtener_asistencias_evento`(IN `p_calendario_id` INT)
BEGIN
  SELECT 
    a.AsistenciaID,
    a.MiembroID,
    u.name AS NombreParticipante,
    u.email AS Gmail,
    u.dni AS DNI_Pasaporte,
    a.EstadoAsistencia,
    a.HoraLlegada,
    a.MinutosTarde,
    a.Observacion,
    a.FechaRegistro
  FROM asistencias a
  INNER JOIN miembros m ON a.MiembroID = m.MiembroID
  INNER JOIN users u ON m.user_id = u.id
  WHERE a.CalendarioID = p_calendario_id
  ORDER BY u.name;
END$$
DELIMITER ;

-- 9. sp_obtener_eventos_por_estado
DROP PROCEDURE IF EXISTS sp_obtener_eventos_por_estado;

DELIMITER $$
CREATE PROCEDURE `sp_obtener_eventos_por_estado`(
    IN `p_estado_evento` ENUM('Programado','EnCurso','Finalizado')
)
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
    c.ProyectoID,
    p.Nombre AS NombreProyecto
  FROM calendarios c
  LEFT JOIN miembros m ON c.OrganizadorID = m.MiembroID
  LEFT JOIN users u ON m.user_id = u.id
  LEFT JOIN proyectos p ON c.ProyectoID = p.ProyectoID
  WHERE c.EstadoEvento COLLATE utf8mb4_general_ci = p_estado_evento COLLATE utf8mb4_general_ci
  ORDER BY c.FechaInicio DESC;
END$$
DELIMITER ;

-- 10. sp_obtener_detalle_evento
DROP PROCEDURE IF EXISTS sp_obtener_detalle_evento;

DELIMITER $$
CREATE PROCEDURE `sp_obtener_detalle_evento`(IN `p_calendario_id` INT)
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
END$$
DELIMITER ;

-- 11. sp_obtener_todos_miembros
DROP PROCEDURE IF EXISTS sp_obtener_todos_miembros;

DELIMITER $$
CREATE PROCEDURE `sp_obtener_todos_miembros`()
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
END$$
DELIMITER ;

-- 12. sp_obtener_miembros_para_asistencia
DROP PROCEDURE IF EXISTS sp_obtener_miembros_para_asistencia;

DELIMITER $$
CREATE PROCEDURE `sp_obtener_miembros_para_asistencia`(IN `p_calendario_id` INT)
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
    SELECT a.MiembroID 
    FROM asistencias a 
    WHERE a.CalendarioID = p_calendario_id
  )
  ORDER BY u.name;
END$$
DELIMITER ;

-- 13. SP_ObtenerConversacion
DROP PROCEDURE IF EXISTS SP_ObtenerConversacion;

DELIMITER $$
CREATE PROCEDURE `SP_ObtenerConversacion`(
    IN `p_user_id` BIGINT,
    IN `p_mensaje_id` INT
)
BEGIN
    DECLARE v_miembro_id INT;
    DECLARE v_propietario INT;
    
    SELECT MiembroID INTO v_miembro_id
    FROM miembros
    WHERE user_id = p_user_id;
    
    SELECT MiembroID INTO v_propietario
    FROM mensajes_consultas
    WHERE MensajeID = p_mensaje_id;
    
    IF v_propietario = v_miembro_id OR 
       (SELECT COUNT(*) FROM conversaciones_chat WHERE MensajeID = p_mensaje_id AND RemitenteID = v_miembro_id) > 0 THEN
        
        SELECT 
            mc.MensajeID,
            mc.DestinatarioTipo,
            mc.TipoConsulta,
            mc.Asunto,
            mc.Prioridad,
            mc.Estado,
            mc.FechaEnvio,
            u_emisor.name AS nombre_emisor,
            u_emisor.email AS correo_emisor
        FROM mensajes_consultas mc
        INNER JOIN miembros m_emisor ON mc.MiembroID = m_emisor.MiembroID
        INNER JOIN users u_emisor ON m_emisor.user_id = u_emisor.id
        WHERE mc.MensajeID = p_mensaje_id;
        
        SELECT 
            cc.ConversacionID,
            cc.RemitenteID,
            u.name AS nombre_remitente,
            cc.EsRespuesta,
            cc.TextoMensaje,
            cc.FechaEnvio,
            cc.Leido,
            cc.FechaLectura,
            CASE 
                WHEN cc.RemitenteID = v_miembro_id THEN 1
                ELSE 0
            END AS es_mi_mensaje
        FROM conversaciones_chat cc
        INNER JOIN miembros m ON cc.RemitenteID = m.MiembroID
        INNER JOIN users u ON m.user_id = u.id
        WHERE cc.MensajeID = p_mensaje_id
        ORDER BY cc.FechaEnvio ASC;
        
        UPDATE conversaciones_chat
        SET Leido = 1, FechaLectura = CURRENT_TIMESTAMP()
        WHERE MensajeID = p_mensaje_id
        AND RemitenteID != v_miembro_id
        AND Leido = 0;
        
    ELSE
        SELECT 'No tienes acceso a esta conversación' AS mensaje, 0 AS exito;
    END IF;
END$$
DELIMITER ;
