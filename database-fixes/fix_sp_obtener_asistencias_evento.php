<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔧 CORRIGIENDO SP_obtener_asistencias_evento\n";
echo "=============================================\n\n";

// Primero, eliminar el SP existente
echo "1️⃣ Eliminando SP anterior...\n";
try {
    DB::statement("DROP PROCEDURE IF EXISTS sp_obtener_asistencias_evento");
    echo "   ✅ SP eliminado\n";
} catch (\Exception $e) {
    echo "   ⚠️ Error al eliminar: " . $e->getMessage() . "\n";
}

// Crear el SP correcto
echo "\n2️⃣ Creando nuevo SP...\n";
$newSP = <<<'SQL'
CREATE PROCEDURE `sp_obtener_asistencias_evento`(IN p_evento_id INT)
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
  WHERE a.CalendarioID = p_evento_id
  ORDER BY u.name;
END
SQL;

try {
    DB::statement($newSP);
    echo "   ✅ SP creado correctamente\n";
} catch (\Exception $e) {
    echo "   ❌ Error al crear: " . $e->getMessage() . "\n";
}

// Verificar que funciona
echo "\n3️⃣ Verificando que funciona...\n";
try {
    $result = DB::select('CALL sp_obtener_asistencias_evento(?)', [15]);
    echo "   ✅ SP funciona! Resultados: " . count($result) . " registro(s)\n";
    if (count($result) > 0) {
        echo "   Primer registro: " . json_encode($result[0]) . "\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

echo "\n";
