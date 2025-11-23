<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🧪 REPRODUCIR: Crear consulta como Carlos\n";
echo "==========================================\n\n";

// Datos de prueba
$userId = 2; // Carlos
$asunto = 'Proyecto en curso';
$tipo = 'Informacion';
$mensaje = 'He ingresado un proyecto en el módulo de Macero pero no aparece en mis proyectos como Socio. ¿Pueden verificar?';
$prioridad = 'media';

echo "Datos:\n";
echo "  User ID: $userId\n";
echo "  Asunto: $asunto\n";
echo "  Tipo: $tipo\n";
echo "  Mensaje: $mensaje\n";
echo "  Prioridad: $prioridad\n\n";

// Validaciones del controlador
echo "Validando...\n";

// 1. Validar letras repetidas
$palabras = preg_split('/\s+/', $asunto);
foreach ($palabras as $palabra) {
    if (preg_match('/(.)\1{3,}/i', $palabra)) {
        echo "❌ Asunto: Contiene letras repetidas más de 3 veces\n";
        exit;
    }
}
echo "✅ Letras repetidas: OK\n";

// 2. Validar caracteres especiales
if (preg_match('/[^a-záéíóúñA-ZÁÉÍÓÚÑ0-9\s]{6,}/', $asunto)) {
    echo "❌ Asunto: Demasiados caracteres especiales consecutivos\n";
    exit;
}
echo "✅ Caracteres especiales: OK\n";

// 3. Validar mayúsculas
$letras = preg_replace('/[^a-záéíóúñA-ZÁÉÍÓÚÑ]/', '', $asunto);
$mayusculas = preg_replace('/[^A-ZÁÉÍÓÚÑ]/', '', $asunto);
$porcentaje = strlen($letras) > 0 ? (strlen($mayusculas) / strlen($letras)) * 100 : 0;
echo "   Mayúsculas: {$porcentaje}% (máx 60%)\n";
if ($porcentaje > 60) {
    echo "❌ Asunto: Demasiadas mayúsculas\n";
    exit;
}
echo "✅ Mayúsculas: OK\n";

// 4. Mensaje - Letras repetidas
$palabras = preg_split('/\s+/', $mensaje);
foreach ($palabras as $palabra) {
    if (preg_match('/(.)\1{3,}/i', $palabra)) {
        echo "❌ Mensaje: Contiene letras repetidas más de 3 veces\n";
        exit;
    }
}
echo "✅ Mensaje letras repetidas: OK\n";

// 5. Texto coherente
$textoLimpio = preg_replace('/\s/', '', $mensaje);
$letras = preg_replace('/[^a-záéíóúñA-ZÁÉÍÓÚÑ]/', '', $textoLimpio);
$coherencia = strlen($textoLimpio) > 10 ? (strlen($letras) / strlen($textoLimpio)) * 100 : 100;
echo "   Coherencia: {$coherencia}% (mín 30%)\n";
if (strlen($textoLimpio) > 10 && $coherencia < 30) {
    echo "❌ Mensaje: No es coherente\n";
    exit;
}
echo "✅ Texto coherente: OK\n\n";

// Si llega aquí, las validaciones pasaron
echo "✅ TODAS LAS VALIDACIONES PASARON\n\n";

// Ahora intentar llamar el SP
echo "📞 Llamando SP_EnviarConsulta...\n";
try {
    $resultado = DB::select('CALL SP_EnviarConsulta(?, ?, ?, ?, ?, ?)', [
        $userId,
        'secretaria',
        $tipo,
        $asunto,
        $mensaje,
        $prioridad
    ]);

    if (!empty($resultado) && isset($resultado[0]->exito) && $resultado[0]->exito == 1) {
        echo "✅ Consulta creada exitosamente!\n";
        echo "   MensajeID: " . $resultado[0]->MensajeID . "\n";
    } else {
        echo "❌ Error en SP: " . ($resultado[0]->mensaje ?? 'Error desconocido') . "\n";
    }

} catch (\Exception $e) {
    echo "❌ Excepción: " . $e->getMessage() . "\n";
}

echo "\n";
