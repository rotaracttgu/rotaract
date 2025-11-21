<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
use Illuminate\Support\Facades\DB;

try {
    echo "Eliminando SP...\n";
    DB::unprepared("DROP PROCEDURE IF EXISTS SP_DashboardSocio");
    echo "Creando SP...\n";
    DB::unprepared("
CREATE PROCEDURE SP_DashboardSocio(IN p_user_id BIGINT)
BEGIN
    -- 1. Estadísticas de Proyectos
    SELECT 
        COUNT(*) AS TotalProyectos,
        SUM(CASE WHEN p.EstadoProyecto = 'Activo' THEN 1 ELSE 0 END) AS ProyectosActivos,
        SUM(CASE WHEN p.EstadoProyecto IN ('En Planificacion', 'Activo') THEN 1 ELSE 0 END) AS ProyectosEnCurso
    FROM proyectos p
    LEFT JOIN participaciones part ON p.ProyectoID = part.ProyectoID
    LEFT JOIN miembros m ON part.MiembroID = m.MiembroID
    WHERE m.user_id = p_user_id OR p.ResponsableID IN (
        SELECT MiembroID FROM miembros WHERE user_id = p_user_id
    );
    
    -- 2. Estadísticas de Reuniones
    SELECT 
        COUNT(*) AS TotalReuniones,
        SUM(CASE WHEN c.EstadoEvento = 'Programado' THEN 1 ELSE 0 END) AS ReunionesProgramadas,
        SUM(CASE WHEN c.EstadoEvento = 'EnCurso' THEN 1 ELSE 0 END) AS ReunionesEnCurso
    FROM calendarios c
    LEFT JOIN asistencias a ON c.CalendarioID = a.CalendarioID
    LEFT JOIN miembros m ON a.MiembroID = m.MiembroID
    WHERE m.user_id = p_user_id OR c.OrganizadorID IN (
        SELECT MiembroID FROM miembros WHERE user_id = p_user_id
    );
    
    -- 3. Estadísticas de Notas
    SELECT 
        COUNT(*) AS TotalNotas,
        SUM(CASE WHEN Visibilidad = 'privada' THEN 1 ELSE 0 END) AS NotasPrivadas,
        SUM(CASE WHEN Visibilidad = 'publica' THEN 1 ELSE 0 END) AS NotasPublicas,
        SUM(CASE WHEN DATE(FechaCreacion) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) THEN 1 ELSE 0 END) AS NotasEsteMes
    FROM notas_personales np
    INNER JOIN miembros m ON np.MiembroID = m.MiembroID
    WHERE m.user_id = p_user_id;
    
    -- 4. Estadísticas de Consultas
    SELECT 
        COUNT(*) AS TotalConsultas,
        SUM(CASE WHEN estado = 'pendiente' THEN 1 ELSE 0 END) AS ConsultasPendientes,
        SUM(CASE WHEN estado = 'respondida' THEN 1 ELSE 0 END) AS ConsultasRespondidas,
        SUM(CASE WHEN DATE(created_at) = CURDATE() THEN 1 ELSE 0 END) AS ConsultasHoy
    FROM consultas
    WHERE usuario_id = p_user_id;
    
    -- 5. Próximas Reuniones (próximas 3)
    SELECT 
        c.CalendarioID,
        c.TituloEvento,
        c.Descripcion AS DescripcionEvento,
        c.FechaInicio,
        c.FechaFin,
        c.Ubicacion,
        c.TipoEvento,
        c.EstadoEvento,
        m.Nombre AS NombreOrganizador,
        CASE 
            WHEN a.EstadoAsistencia IS NOT NULL THEN a.EstadoAsistencia
            ELSE 'Pendiente'
        END AS MiAsistencia
    FROM calendarios c
    LEFT JOIN miembros m ON c.OrganizadorID = m.MiembroID
    LEFT JOIN asistencias a ON c.CalendarioID = a.CalendarioID 
        AND a.MiembroID IN (SELECT MiembroID FROM miembros WHERE user_id = p_user_id)
    WHERE c.EstadoEvento IN ('Programado', 'EnCurso')
    AND c.FechaInicio >= NOW()
    ORDER BY c.FechaInicio ASC
    LIMIT 3;
    
    -- 6. Proyectos Activos del Usuario (últimos 3)
    SELECT 
        p.ProyectoID,
        p.Nombre AS NombreProyecto,
        p.Descripcion AS DescripcionProyecto,
        p.FechaInicio,
        p.FechaFin,
        p.TipoProyecto,
        p.EstadoProyecto,
        m.Nombre AS NombreResponsable,
        COUNT(DISTINCT part.MiembroID) AS TotalParticipantes,
        CASE
            WHEN p.FechaFin IS NOT NULL THEN DATEDIFF(p.FechaFin, CURDATE())
            ELSE NULL
        END AS DiasRestantes
    FROM proyectos p
    LEFT JOIN miembros m ON p.ResponsableID = m.MiembroID
    LEFT JOIN participaciones part ON p.ProyectoID = part.ProyectoID
    WHERE (
        p.ProyectoID IN (
            SELECT DISTINCT ProyectoID 
            FROM participaciones 
            WHERE MiembroID IN (SELECT MiembroID FROM miembros WHERE user_id = p_user_id)
        )
        OR p.ResponsableID IN (SELECT MiembroID FROM miembros WHERE user_id = p_user_id)
    )
    AND p.EstadoProyecto IN ('Activo', 'En Planificacion')
    GROUP BY p.ProyectoID, p.Nombre, p.Descripcion, p.FechaInicio, 
             p.FechaFin, p.TipoProyecto, p.EstadoProyecto, m.Nombre
    ORDER BY p.FechaInicio DESC
    LIMIT 3;
END
    ");
    echo "✓ SP creado exitosamente\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
