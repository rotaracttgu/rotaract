<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔧 CORRIGIENDO SP_obtener_miembros_para_asistencia\n";
echo "=================================================\n\n";

// Primero, eliminar el SP existente
echo "1️⃣ Eliminando SP anterior...\n";
try {
    DB::statement("DROP PROCEDURE IF EXISTS sp_obtener_miembros_para_asistencia");
    echo "   ✅ SP eliminado\n";
} catch (\Exception $e) {
    echo "   ⚠️ Error: " . $e->getMessage() . "\n";
}

// Crear el SP correcto
echo "\n2️⃣ Creando nuevo SP...\n";
$newSP = <<<'SQL'
CREATE PROCEDURE `sp_obtener_miembros_para_asistencia`(IN p_evento_id INT)
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
    SELECT a.MiembroID FROM asistencias a WHERE a.CalendarioID = p_evento_id
  )
  ORDER BY u.name;
END
SQL;

try {
    DB::statement($newSP);
    echo "   ✅ SP creado correctamente\n";
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// Verificar
echo "\n3️⃣ Verificando...\n";
try {
    $result = DB::select('CALL sp_obtener_miembros_para_asistencia(?)', [15]);
    echo "   ✅ SP funciona! Miembros sin registrar: " . count($result) . "\n";
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

echo "\n";
