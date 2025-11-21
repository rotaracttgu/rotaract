<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== CREANDO CONSULTAS DE PRUEBA ===\n\n";
    
    $userId = 5; // Rodrigo
    
    // Consulta 1: Certificado de membresía (pendiente)
    echo "1. Creando consulta: Certificado de membresía...\n";
    DB::statement('CALL SP_CrearConsulta(?, ?, ?, ?, ?, @id1)', [
        $userId,
        'Solicitud de certificado de membresía activa',
        'Buenos días, necesito un certificado que acredite mi membresía activa en el club para presentarlo en mi universidad. Agradezco su pronta respuesta.',
        null,
        'media'
    ]);
    $id1 = DB::select('SELECT @id1 AS id')[0]->id;
    echo "   ✓ Consulta #$id1 creada (Pendiente)\n";
    
    // Consulta 2: Pago de cuota (respondida)
    echo "\n2. Creando consulta: Consulta sobre pago...\n";
    DB::statement('CALL SP_CrearConsulta(?, ?, ?, ?, ?, @id2)', [
        $userId,
        'Consulta sobre pago de cuota mensual',
        '¿Podrían confirmarme si mi pago de la cuota del mes de octubre fue registrado correctamente? Realicé la transferencia el día 15.',
        'comprobantes/pago_transferencia.pdf',
        'media'
    ]);
    $id2 = DB::select('SELECT @id2 AS id')[0]->id;
    
    // Responder esta consulta
    DB::statement('CALL SP_ResponderConsulta(?, ?, ?)', [
        $id2,
        'Hola Rodrigo, confirmamos que tu pago de octubre fue registrado correctamente el día 16. Tu comprobante está archivado en el sistema. ¡Gracias por tu puntualidad!',
        1 // ID del admin que responde
    ]);
    echo "   ✓ Consulta #$id2 creada y respondida\n";
    
    // Consulta 3: Información de proyectos (alta prioridad)
    echo "\n3. Creando consulta: Información de proyecto...\n";
    DB::statement('CALL SP_CrearConsulta(?, ?, ?, ?, ?, @id3)', [
        $userId,
        '¿Cómo puedo inscribirme al proyecto Limpieza de Playa?',
        'Vi en redes sociales el proyecto de limpieza de playa para el próximo sábado y me gustaría participar. ¿Cuál es el proceso de inscripción? ¿Hay cupo limitado?',
        null,
        'baja'
    ]);
    $id3 = DB::select('SELECT @id3 AS id')[0]->id;
    echo "   ✓ Consulta #$id3 creada (Pendiente)\n";
    
    // Consulta 4: Queja (cerrada)
    echo "\n4. Creando consulta: Constancia de horas...\n";
    DB::statement('CALL SP_CrearConsulta(?, ?, ?, ?, ?, @id4)', [
        $userId,
        'Solicitud de constancia de horas de servicio social',
        'Necesito una constancia que certifique las horas de servicio social que he acumulado durante este año para presentarla en mi facultad. En total deben ser aproximadamente 40 horas.',
        null,
        'media'
    ]);
    $id4 = DB::select('SELECT @id4 AS id')[0]->id;
    
    // Responder y cerrar
    DB::statement('CALL SP_ResponderConsulta(?, ?, ?)', [
        $id4,
        'Tu constancia ha sido generada con 42 horas de servicio social certificadas. Puedes recogerla en la oficina del club o te la enviamos por correo electrónico. ¿Cuál prefieres?',
        1
    ]);
    DB::statement('CALL SP_CerrarConsulta(?)', [$id4]);
    echo "   ✓ Consulta #$id4 creada, respondida y cerrada\n";
    
    // Consulta 5: Actualización de datos (pendiente)
    echo "\n5. Creando consulta: Actualización de contacto...\n";
    DB::statement('CALL SP_CrearConsulta(?, ?, ?, ?, ?, @id5)', [
        $userId,
        'Actualización de datos de contacto',
        'He cambiado de número telefónico y dirección recientemente. ¿Podrían indicarme el procedimiento para actualizar mis datos en el sistema del club?',
        null,
        'baja'
    ]);
    $id5 = DB::select('SELECT @id5 AS id')[0]->id;
    echo "   ✓ Consulta #$id5 creada (Pendiente)\n";
    
    // Verificar consultas creadas
    echo "\n\n=== VERIFICANDO CONSULTAS ===\n";
    $consultas = DB::select('CALL SP_MisConsultasSocio(?, NULL)', [$userId]);
    
    echo "\nTotal de consultas: " . count($consultas) . "\n\n";
    
    foreach ($consultas as $c) {
        echo "• #{$c->ConsultaID}: {$c->Asunto}\n";
        echo "  Estado: {$c->Estado} | Prioridad: {$c->Prioridad}\n";
        echo "  Enviado: {$c->FechaEnvio}\n";
        if ($c->Respuesta) {
            echo "  Respuesta: " . substr($c->Respuesta, 0, 50) . "...\n";
            echo "  Respondido por: {$c->RespondidoPor} ({$c->FechaRespuesta})\n";
        }
        echo "\n";
    }
    
    // Estadísticas
    echo "=== ESTADÍSTICAS ===\n";
    $pendientes = count(array_filter($consultas, fn($c) => $c->Estado === 'pendiente'));
    $respondidas = count(array_filter($consultas, fn($c) => $c->Estado === 'respondida'));
    $cerradas = count(array_filter($consultas, fn($c) => $c->Estado === 'cerrada'));
    
    echo "Pendientes: $pendientes\n";
    echo "Respondidas: $respondidas\n";
    echo "Cerradas: $cerradas\n";
    
    echo "\n✅ Consultas de prueba creadas exitosamente\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
