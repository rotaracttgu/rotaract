<?php
/**
 * Ejecutar SPs corregidos directamente
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔄 ACTUALIZANDO STORED PROCEDURES\n";
echo "=================================\n\n";

// 1. SP_EventosDelDia
echo "1️⃣ Actualizando SP_EventosDelDia...\n";
try {
    DB::statement("DROP PROCEDURE IF EXISTS SP_EventosDelDia");
    DB::statement(<<<'SQL'
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
                COALESCE(u_org.name, 'Sin Organizador') AS organizador,
                p.Nombre AS proyecto,
                c.EstadoEvento
            FROM calendarios c
            LEFT JOIN miembros m_org ON c.OrganizadorID = m_org.MiembroID
            LEFT JOIN users u_org ON m_org.user_id = u_org.id
            LEFT JOIN proyectos p ON c.ProyectoID = p.ProyectoID
            WHERE DATE(c.FechaInicio) = p_fecha
            ORDER BY c.HoraInicio;
        END
    SQL);
    echo "   ✅ SP_EventosDelDia actualizado\n";
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// 2. SP_MisConsultas
echo "\n2️⃣ Actualizando SP_MisConsultas...\n";
try {
    DB::statement("DROP PROCEDURE IF EXISTS SP_MisConsultas");
    DB::statement(<<<'SQL'
        CREATE PROCEDURE `SP_MisConsultas`(IN `p_user_id` BIGINT, IN `p_filtro_destinatario` VARCHAR(50), IN `p_filtro_estado` VARCHAR(50), IN `p_limite` INT)
        BEGIN
            DECLARE v_miembro_id INT;

            SELECT MiembroID INTO v_miembro_id
            FROM miembros
            WHERE user_id = p_user_id;

            SELECT
                mc.MensajeID,
                mc.DestinatarioTipo COLLATE utf8mb4_general_ci,
                mc.TipoConsulta,
                mc.Asunto COLLATE utf8mb4_general_ci,
                mc.Mensaje COLLATE utf8mb4_general_ci,
                mc.Prioridad COLLATE utf8mb4_general_ci,
                mc.Estado COLLATE utf8mb4_general_ci,
                mc.FechaEnvio,
                mc.FechaRespuesta,
                mc.RespuestaMensaje,
                COALESCE(u_resp.name, 'Sin respuesta') AS respondido_por_nombre,
                (SELECT COUNT(*) FROM conversaciones_chat WHERE MensajeID = mc.MensajeID) AS total_mensajes,
                (SELECT COUNT(*) FROM conversaciones_chat WHERE MensajeID = mc.MensajeID AND RemitenteID != v_miembro_id AND Leido = 0) AS mensajes_no_leidos,
                (SELECT TextoMensaje FROM conversaciones_chat WHERE MensajeID = mc.MensajeID ORDER BY FechaEnvio DESC LIMIT 1) AS ultimo_mensaje,
                (SELECT FechaEnvio FROM conversaciones_chat WHERE MensajeID = mc.MensajeID ORDER BY FechaEnvio DESC LIMIT 1) AS fecha_ultimo_mensaje
            FROM mensajes_consultas mc
            LEFT JOIN miembros m_resp ON mc.RespondidoPor = m_resp.MiembroID
            LEFT JOIN users u_resp ON m_resp.user_id = u_resp.id
            WHERE mc.MiembroID = v_miembro_id
            AND (p_filtro_destinatario IS NULL OR mc.DestinatarioTipo COLLATE utf8mb4_general_ci = p_filtro_destinatario)
            AND (p_filtro_estado IS NULL OR mc.Estado COLLATE utf8mb4_general_ci = p_filtro_estado)
            ORDER BY mc.FechaEnvio DESC
            LIMIT p_limite;
        END
    SQL);
    echo "   ✅ SP_MisConsultas actualizado\n";
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// 3. SP_RecordatoriosProximos
echo "\n3️⃣ Actualizando SP_RecordatoriosProximos...\n";
try {
    DB::statement("DROP PROCEDURE IF EXISTS SP_RecordatoriosProximos");
    DB::statement(<<<'SQL'
        CREATE PROCEDURE `SP_RecordatoriosProximos`(IN `p_user_id` BIGINT, IN `p_horas_adelante` INT)
        BEGIN
            DECLARE v_miembro_id INT;

            SELECT MiembroID INTO v_miembro_id
            FROM miembros
            WHERE user_id = p_user_id;

            SELECT
                n.NotaID,
                n.Titulo,
                n.Categoria,
                n.FechaRecordatorio,
                TIMESTAMPDIFF(HOUR, CURRENT_TIMESTAMP(), n.FechaRecordatorio) AS horas_restantes,
                CASE
                    WHEN n.FechaRecordatorio <= CURRENT_TIMESTAMP() THEN 'Vencido'
                    WHEN TIMESTAMPDIFF(HOUR, CURRENT_TIMESTAMP(), n.FechaRecordatorio) <= 1 THEN 'Urgente'
                    WHEN TIMESTAMPDIFF(HOUR, CURRENT_TIMESTAMP(), n.FechaRecordatorio) <= 24 THEN 'Próximo'
                    ELSE 'Programado'
                END AS estado_recordatorio
            FROM notas_personales n
            WHERE n.MiembroID = v_miembro_id
            AND n.Estado = 'activa'
            AND n.FechaRecordatorio IS NOT NULL
            AND n.FechaRecordatorio <= DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL p_horas_adelante HOUR)
            ORDER BY n.FechaRecordatorio ASC;
        END
    SQL);
    echo "   ✅ SP_RecordatoriosProximos actualizado\n";
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

echo "\n✅ SPs Actualizados exitosamente\n";
