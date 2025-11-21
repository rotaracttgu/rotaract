<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== CREANDO STORED PROCEDURES PARA CONSULTAS ===\n\n";
    
    // 1. SP para listar consultas del socio
    echo "1. Creando SP_MisConsultasSocio...\n";
    DB::unprepared("DROP PROCEDURE IF EXISTS SP_MisConsultasSocio");
    DB::unprepared("CREATE PROCEDURE SP_MisConsultasSocio(
        IN p_user_id BIGINT,
        IN p_estado VARCHAR(50)
    )
    BEGIN
        SELECT 
            c.id AS ConsultaID,
            c.asunto AS Asunto,
            c.mensaje AS Mensaje,
            c.comprobante_ruta AS ComprobanteRuta,
            c.estado AS Estado,
            c.respuesta AS Respuesta,
            c.prioridad AS Prioridad,
            c.created_at AS FechaEnvio,
            c.respondido_at AS FechaRespuesta,
            u_resp.name AS RespondidoPor,
            u_resp.email AS EmailRespondidoPor
        FROM consultas c
        LEFT JOIN users u_resp ON c.respondido_por = u_resp.id
        WHERE c.usuario_id = p_user_id
        AND (p_estado IS NULL OR p_estado = '' OR c.estado = CAST(p_estado AS CHAR CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci))
        ORDER BY c.created_at DESC;
    END");
    echo "   ✓ SP_MisConsultasSocio creado\n";
    
    // 2. SP para listar todas las consultas (Secretaria)
    echo "\n2. Creando SP_ConsultasSecretaria...\n";
    DB::unprepared("DROP PROCEDURE IF EXISTS SP_ConsultasSecretaria");
    DB::unprepared("CREATE PROCEDURE SP_ConsultasSecretaria(
        IN p_estado VARCHAR(50),
        IN p_prioridad VARCHAR(50)
    )
    BEGIN
        SELECT 
            c.id AS ConsultaID,
            c.asunto AS Asunto,
            c.mensaje AS Mensaje,
            c.comprobante_ruta AS ComprobanteRuta,
            c.estado AS Estado,
            c.respuesta AS Respuesta,
            c.prioridad AS Prioridad,
            c.created_at AS FechaEnvio,
            c.respondido_at AS FechaRespuesta,
            u.id AS UsuarioID,
            u.name AS NombreUsuario,
            u.email AS EmailUsuario,
            m.MiembroID,
            m.Nombre AS NombreMiembro,
            u_resp.name AS RespondidoPor
        FROM consultas c
        INNER JOIN users u ON c.usuario_id = u.id
        LEFT JOIN miembros m ON u.id = m.user_id
        LEFT JOIN users u_resp ON c.respondido_por = u_resp.id
        WHERE (p_estado IS NULL OR p_estado = '' OR c.estado = CAST(p_estado AS CHAR CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci))
        AND (p_prioridad IS NULL OR p_prioridad = '' OR c.prioridad = CAST(p_prioridad AS CHAR CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci))
        ORDER BY 
            CASE c.prioridad
                WHEN 'alta' THEN 1
                WHEN 'media' THEN 2
                WHEN 'baja' THEN 3
            END,
            c.created_at DESC;
    END");
    echo "   ✓ SP_ConsultasSecretaria creado\n";
    
    // 3. SP para crear consulta
    echo "\n3. Creando SP_CrearConsulta...\n";
    DB::unprepared("DROP PROCEDURE IF EXISTS SP_CrearConsulta");
    DB::unprepared("CREATE PROCEDURE SP_CrearConsulta(
        IN p_usuario_id BIGINT,
        IN p_asunto VARCHAR(255),
        IN p_mensaje TEXT,
        IN p_comprobante_ruta VARCHAR(255),
        IN p_prioridad VARCHAR(50),
        OUT p_consulta_id BIGINT
    )
    BEGIN
        INSERT INTO consultas (
            usuario_id,
            asunto,
            mensaje,
            comprobante_ruta,
            estado,
            prioridad,
            created_at,
            updated_at
        ) VALUES (
            p_usuario_id,
            p_asunto,
            p_mensaje,
            p_comprobante_ruta,
            'pendiente',
            COALESCE(p_prioridad, 'media'),
            NOW(),
            NOW()
        );
        
        SET p_consulta_id = LAST_INSERT_ID();
    END");
    echo "   ✓ SP_CrearConsulta creado\n";
    
    // 4. SP para responder consulta
    echo "\n4. Creando SP_ResponderConsulta...\n";
    DB::unprepared("DROP PROCEDURE IF EXISTS SP_ResponderConsulta");
    DB::unprepared("CREATE PROCEDURE SP_ResponderConsulta(
        IN p_consulta_id BIGINT,
        IN p_respuesta TEXT,
        IN p_respondido_por BIGINT
    )
    BEGIN
        UPDATE consultas
        SET 
            respuesta = p_respuesta,
            respondido_por = p_respondido_por,
            respondido_at = NOW(),
            estado = 'respondida',
            updated_at = NOW()
        WHERE id = p_consulta_id;
    END");
    echo "   ✓ SP_ResponderConsulta creado\n";
    
    // 5. SP para cerrar consulta
    echo "\n5. Creando SP_CerrarConsulta...\n";
    DB::unprepared("DROP PROCEDURE IF EXISTS SP_CerrarConsulta");
    DB::unprepared("CREATE PROCEDURE SP_CerrarConsulta(
        IN p_consulta_id BIGINT
    )
    BEGIN
        UPDATE consultas
        SET 
            estado = 'cerrada',
            updated_at = NOW()
        WHERE id = p_consulta_id;
    END");
    echo "   ✓ SP_CerrarConsulta creado\n";
    
    // Probar los SPs
    echo "\n\n=== PROBANDO SPs ===\n";
    
    echo "\n1. Probando SP_MisConsultasSocio con usuario 5...\n";
    $resultado = DB::select('CALL SP_MisConsultasSocio(?, NULL)', [5]);
    echo "   Consultas encontradas: " . count($resultado) . "\n";
    
    echo "\n2. Probando SP_ConsultasSecretaria...\n";
    $resultado = DB::select('CALL SP_ConsultasSecretaria(NULL, NULL)');
    echo "   Consultas encontradas: " . count($resultado) . "\n";
    
    echo "\n\n✅ Todos los stored procedures creados exitosamente\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
