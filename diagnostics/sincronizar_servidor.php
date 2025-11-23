<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Miembro;

echo "🔧 SINCRONIZACIÓN DE USUARIOS Y MIEMBROS\n";
echo "==========================================\n\n";

// 1. Crear usuario Leonel si no existe
echo "1️⃣ CREAR USUARIO LEONEL:\n";
$leonel = User::where('email', 'lordleo7k@gmail.com')->first();

if (!$leonel) {
    $leonel = User::create([
        'name' => 'Leonel A.',
        'email' => 'lordleo7k@gmail.com',
        'password' => bcrypt('password123'),
        'email_verified_at' => now(),
    ]);
    echo "   ✅ Usuario Leonel creado (ID:{$leonel->id})\n";
    
    // Asignarle rol de Socio
    $leonel->assignRole('Socio');
    echo "   ✅ Rol Socio asignado\n";
} else {
    echo "   ✅ Usuario Leonel ya existe (ID:{$leonel->id})\n";
}

// 2. Asignarle un miembro
echo "\n2️⃣ ASIGNAR MIEMBRO:\n";
$miembro = Miembro::where('user_id', $leonel->id)->first();

if (!$miembro) {
    // Asignarle el miembro ID 5 (Aspirante disponible)
    $miembroDisponible = Miembro::find(5);
    if ($miembroDisponible) {
        $miembroDisponible->update(['user_id' => $leonel->id]);
        echo "   ✅ Miembro ID:5 asignado a Leonel\n";
    }
} else {
    echo "   ✅ Leonel ya tiene Miembro ID:{$miembro->MiembroID}\n";
}

// 3. Crear una nota de prueba
echo "\n3️⃣ CREAR NOTA DE PRUEBA:\n";
try {
    $notaExistente = DB::table('notas_personales')
        ->where('MiembroID', 5)
        ->first();
    
    if (!$notaExistente) {
        DB::table('notas_personales')->insert([
            'MiembroID' => 5,
            'Titulo' => 'Mi Primera Nota',
            'Contenido' => 'Esta es una nota de prueba para verificar que funciona en el servidor',
            'Categoria' => 'Personal',
            'Visibilidad' => 'privada',
            'Etiquetas' => 'prueba,test',
            'Estado' => 'activa',
            'FechaCreacion' => now(),
            'FechaActualizacion' => now(),
        ]);
        echo "   ✅ Nota de prueba creada\n";
    } else {
        echo "   ℹ️ Ya existe una nota para este miembro\n";
    }
} catch (\Exception $e) {
    echo "   ❌ ERROR: {$e->getMessage()}\n";
}

// 4. Crear un evento de prueba
echo "\n4️⃣ CREAR EVENTO DE PRUEBA:\n";
try {
    $eventoExistente = DB::table('calendarios')
        ->where('TituloEvento', 'Reunión de Prueba')
        ->first();
    
    if (!$eventoExistente) {
        DB::table('calendarios')->insert([
            'TituloEvento' => 'Reunión de Prueba',
            'Descripcion' => 'Esta es una reunión de prueba',
            'TipoEvento' => 'Ordinaria',
            'EstadoEvento' => 'Programado',
            'FechaInicio' => now()->addDays(2)->toDateString() . ' 10:00:00',
            'FechaFin' => now()->addDays(2)->toDateString() . ' 11:00:00',
            'HoraInicio' => '10:00',
            'HoraFin' => '11:00',
            'Ubicacion' => 'Sala de Reuniones',
            'OrganizadorID' => 5,
            'FechaCreacion' => now(),
            'FechaActualizacion' => now(),
        ]);
        echo "   ✅ Evento de prueba creado\n";
    } else {
        echo "   ℹ️ Ya existe un evento de prueba\n";
    }
} catch (\Exception $e) {
    echo "   ❌ ERROR: {$e->getMessage()}\n";
}

// 5. Verificar que todo funciona
echo "\n5️⃣ VERIFICACIÓN FINAL:\n";
try {
    $notas = DB::select('CALL SP_MisNotas(?, ?, ?, ?, ?, ?)', [
        $leonel->id,
        NULL,
        NULL,
        '',
        50,
        0
    ]);
    
    if (!empty($notas) && isset($notas[0]->exito) && $notas[0]->exito === 0) {
        echo "   ⚠️ Procedimiento devolvió error: {$notas[0]->mensaje}\n";
    } else {
        echo "   ✅ SP_MisNotas funcionando (" . count($notas) . " registros)\n";
    }
} catch (\Exception $e) {
    echo "   ❌ ERROR: {$e->getMessage()}\n";
}

echo "\n✅ Sincronización completada\n";
