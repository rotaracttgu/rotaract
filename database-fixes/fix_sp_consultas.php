<?php
/**
 * Actualizar SP_MisConsultas con todas las columnas necesarias
 */

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔄 ACTUALIZANDO SP_MisConsultas CON TODAS LAS COLUMNAS\n";
echo "====================================================\n\n";

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
                mc.Asunto,
                mc.Mensaje,
                mc.DestinatarioTipo,
                mc.TipoConsulta,
                mc.Prioridad,
                mc.Estado,
                mc.FechaEnvio,
                mc.FechaRespuesta,
                mc.RespuestaMensaje,
                mc.ArchivoAdjunto,
                COALESCE(u_resp.name, 'Sin respuesta') AS respondido_por_nombre,
                (SELECT COUNT(*) FROM conversaciones_chat WHERE MensajeID = mc.MensajeID) AS total_mensajes,
                (SELECT COUNT(*) FROM conversaciones_chat WHERE MensajeID = mc.MensajeID AND RemitenteID != v_miembro_id AND Leido = 0) AS mensajes_no_leidos,
                (SELECT TextoMensaje FROM conversaciones_chat WHERE MensajeID = mc.MensajeID ORDER BY FechaEnvio DESC LIMIT 1) AS ultimo_mensaje,
                (SELECT FechaEnvio FROM conversaciones_chat WHERE MensajeID = mc.MensajeID ORDER BY FechaEnvio DESC LIMIT 1) AS fecha_ultimo_mensaje
            FROM mensajes_consultas mc
            LEFT JOIN miembros m_resp ON mc.RespondidoPor = m_resp.MiembroID
            LEFT JOIN users u_resp ON m_resp.user_id = u_resp.id
            WHERE mc.MiembroID = v_miembro_id
            AND (p_filtro_destinatario IS NULL OR mc.DestinatarioTipo = p_filtro_destinatario)
            AND (p_filtro_estado IS NULL OR mc.Estado = p_filtro_estado)
            ORDER BY mc.FechaEnvio DESC
            LIMIT p_limite;
        END
    SQL);
    echo "✅ SP_MisConsultas actualizado con todas las columnas\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
