<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== CREANDO STORED PROCEDURE DASHBOARD SOCIO ===\n\n";
    
    // SP para obtener todas las estadísticas del dashboard del socio
    echo "Creando SP_DashboardSocio...\n";
    DB::unprepared("DROP PROCEDURE IF EXISTS SP_DashboardSocio");
    DB::unprepared("CREATE PROCEDURE SP_DashboardSocio(
        IN p_user_id BIGINT
    )
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
        LEFT JOIN asistencias a ON c.CalendarioID = a.EventoID
        LEFT JOIN miembros m ON a.MiembroID = m.MiembroID
        WHERE (m.user_id = p_user_id OR c.OrganizadorID IN (
            SELECT MiembroID FROM miembros WHERE user_id = p_user_id
        ))
        AND c.TipoEvento IN ('Reunion', 'Junta');
        
        -- 3. Estadísticas de Notas
        SELECT 
            COUNT(*) AS TotalNotas,
            SUM(CASE WHEN Visibilidad = 'privada' THEN 1 ELSE 0 END) AS NotasPrivadas,
            SUM(CASE WHEN Visibilidad = 'publica' THEN 1 ELSE 0 END) AS NotasPublicas,
            SUM(CASE WHEN DATE(FechaCreacion) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) THEN 1 ELSE 0 END) AS NotasEsteMes
        FROM notas_personales
        WHERE AutorID = p_user_id;
        
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
            CONCAT(m.Nombre, ' ', m.Apellido) AS NombreOrganizador,
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
            CONCAT(m.Nombre, ' ', m.Apellido) AS NombreResponsable,
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
                 p.FechaFin, p.TipoProyecto, p.EstadoProyecto, m.Nombre, m.Apellido
        ORDER BY p.FechaInicio DESC
        LIMIT 3;
    END");
    echo "   ✓ SP_DashboardSocio creado\n";
    
    // Probar el SP
    echo "\n\n=== PROBANDO SP_DashboardSocio ===\n";
    $userId = 5; // Rodrigo
    
    $results = DB::select('CALL SP_DashboardSocio(?)', [$userId]);
    
    echo "\n1. Estadísticas de Proyectos:\n";
    echo "   Total: " . ($results[0]->TotalProyectos ?? 0) . "\n";
    echo "   Activos: " . ($results[0]->ProyectosActivos ?? 0) . "\n";
    echo "   En Curso: " . ($results[0]->ProyectosEnCurso ?? 0) . "\n";
    
    echo "\n2. Estadísticas de Reuniones:\n";
    if (isset($results[1])) {
        echo "   Total: " . ($results[1]->TotalReuniones ?? 0) . "\n";
        echo "   Programadas: " . ($results[1]->ReunionesProgramadas ?? 0) . "\n";
        echo "   En Curso: " . ($results[1]->ReunionesEnCurso ?? 0) . "\n";
    }
    
    echo "\n3. Estadísticas de Notas:\n";
    if (isset($results[2])) {
        echo "   Total: " . ($results[2]->TotalNotas ?? 0) . "\n";
        echo "   Privadas: " . ($results[2]->NotasPrivadas ?? 0) . "\n";
        echo "   Públicas: " . ($results[2]->NotasPublicas ?? 0) . "\n";
        echo "   Este Mes: " . ($results[2]->NotasEsteMes ?? 0) . "\n";
    }
    
    echo "\n4. Estadísticas de Consultas:\n";
    if (isset($results[3])) {
        echo "   Total: " . ($results[3]->TotalConsultas ?? 0) . "\n";
        echo "   Pendientes: " . ($results[3]->ConsultasPendientes ?? 0) . "\n";
        echo "   Respondidas: " . ($results[3]->ConsultasRespondidas ?? 0) . "\n";
        echo "   Hoy: " . ($results[3]->ConsultasHoy ?? 0) . "\n";
    }
    
    echo "\n✅ Stored Procedure creado y probado exitosamente\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
