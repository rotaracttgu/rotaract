<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Aspirante\AspiranteController;
use App\Http\Controllers\VoceroController;
use App\Http\Controllers\TesoreroController;
use App\Http\Controllers\VicepresidenteController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\Auth\TwoFactorController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;

// Página de inicio (pública)
Route::get('/', function () {
    return view('welcome');
});

// Dashboard general - redirige según el rol del usuario
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if (!$user) {
        return redirect()->route('login');
    }

    // Redirigir al dashboard correspondiente según el rol
    if ($user->hasRole('Super Admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('Presidente')) {
        return redirect()->route('presidente.dashboard');
    } elseif ($user->hasRole('Vicepresidente')) {
        return redirect()->route('vicepresidente.dashboard');
    } elseif ($user->hasRole('Tesorero')) {
        return redirect()->route('tesorero.dashboard');
    } elseif ($user->hasRole('Secretario')) {
        return redirect()->route('secretario.dashboard');
    } elseif ($user->hasRole('Vocero')) {
        return redirect()->route('vocero.dashboard');
    } elseif ($user->hasRole('Aspirante')) {
        return redirect()->route('aspirante.dashboard');
    }
    
    // Si no tiene rol definido, mostrar dashboard genérico
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ============================================================================
// RUTAS DE AUTENTICACIÓN DE DOS FACTORES (2FA)
// ============================================================================
Route::middleware('auth')->group(function () {
    Route::get('/2fa/verify', [TwoFactorController::class, 'show'])->name('2fa.verify');
    Route::post('/2fa/verify', [TwoFactorController::class, 'verify'])->name('2fa.verify.post');
    Route::post('/2fa/resend', [TwoFactorController::class, 'generateCode'])->name('2fa.resend');
    
    // Rutas para habilitar/deshabilitar 2FA desde el perfil
    Route::post('/2fa/enable', [TwoFactorController::class, 'enable'])->name('2fa.enable');
    Route::post('/2fa/disable', [TwoFactorController::class, 'disable'])->name('2fa.disable');
});

// ============================================================================
// RUTAS DE PERFIL (Accesibles para todos los usuarios autenticados)
// ============================================================================
Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('perfil.editar');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('perfil.actualizar');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('perfil.eliminar');
});

// ============================================================================
// RUTAS DE SUPER ADMIN
// ============================================================================
Route::prefix('admin')->middleware(['auth', RoleMiddleware::class . ':Super Admin'])->name('admin.')->group(function () {
    // Dashboard de Super Admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Gestión de usuarios (solo Super Admin)
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.lista');
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('usuarios.crear');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.guardar');
    Route::get('/usuarios/{usuario}', [UserController::class, 'show'])->name('usuarios.ver');
    Route::get('/usuarios/{usuario}/editar', [UserController::class, 'edit'])->name('usuarios.editar');
    Route::put('/usuarios/{usuario}', [UserController::class, 'update'])->name('usuarios.actualizar');
    Route::delete('/usuarios/{usuario}', [UserController::class, 'destroy'])->name('usuarios.eliminar');
});

// ============================================================================
// RUTAS DEL MÓDULO PRESIDENTE
// ============================================================================
Route::prefix('presidente')->middleware(['auth', RoleMiddleware::class . ':Presidente|Super Admin'])->name('presidente.')->group(function () {
    Route::get('/dashboard', function () {
        return view('presidente.dashboard');
    })->name('dashboard');
    
    // Aquí agregarás más rutas del presidente cuando las necesites
});

// ============================================================================
// RUTAS DEL MÓDULO VICEPRESIDENTE
// ============================================================================
Route::prefix('vicepresidente')->middleware(['auth', RoleMiddleware::class . ':Vicepresidente|Presidente|Super Admin'])->name('vicepresidente.')->group(function () {
    Route::get('/dashboard', [VicepresidenteController::class, 'dashboard'])->name('dashboard');
    Route::get('/asistencia/proyectos', [VicepresidenteController::class, 'asistenciaProyectos'])->name('asistencia.proyectos');
    Route::get('/asistencia/reuniones', [VicepresidenteController::class, 'asistenciaReuniones'])->name('asistencia.reuniones');
    Route::get('/cartas/formales', [VicepresidenteController::class, 'cartasFormales'])->name('cartas.formales');
    Route::get('/cartas/patrocinio', [VicepresidenteController::class, 'cartasPatrocinio'])->name('cartas.patrocinio');
    
    // Módulo de Reportes (Vicepresidente)
    Route::get('/reportes/dashboard', [ReporteController::class, 'dashboard'])->name('reportes.dashboard');
    Route::get('/reportes/mensuales', [ReporteController::class, 'mensuales'])->name('reportes.mensuales');
});

// ============================================================================
// RUTAS DEL MÓDULO TESORERO
// ============================================================================
Route::prefix('tesorero')->middleware(['auth', RoleMiddleware::class . ':Tesorero|Presidente|Super Admin'])->name('tesorero.')->group(function () {
    Route::get('/', [TesoreroController::class, 'welcome'])->name('welcome');
    Route::get('/dashboard', [TesoreroController::class, 'index'])->name('dashboard');
    Route::get('/calendario', [TesoreroController::class, 'calendario'])->name('calendario');
    Route::get('/finanzas', [TesoreroController::class, 'finanzas'])->name('finanzas');
});

// ============================================================================
// RUTAS DEL MÓDULO SECRETARIO
// ============================================================================
Route::prefix('secretario')->middleware(['auth', RoleMiddleware::class . ':Secretario|Presidente|Super Admin'])->name('secretario.')->group(function () {
    Route::get('/dashboard', function () {
        return view('secretario.dashboard');
    })->name('dashboard');
    
    // Aquí agregarás más rutas del secretario cuando las necesites
});

// ============================================================================
// RUTAS DEL MÓDULO VOCERO
// ============================================================================
Route::prefix('vocero')->middleware(['auth', RoleMiddleware::class . ':Vocero|Presidente|Super Admin'])->name('vocero.')->group(function () {
    Route::get('/', [VoceroController::class, 'index'])->name('index');
    Route::get('/bienvenida', [VoceroController::class, 'welcome'])->name('bienvenida');
    Route::get('/calendario', [VoceroController::class, 'calendario'])->name('calendario');
    Route::get('/dashboard', [VoceroController::class, 'dashboard'])->name('dashboard');
    Route::get('/asistencias', [VoceroController::class, 'gestionAsistencias'])->name('asistencias');
    Route::get('/eventos', [VoceroController::class, 'gestionEventos'])->name('eventos');
    Route::get('/reportes', [VoceroController::class, 'reportesAnalisis'])->name('reportes');
});

// ============================================================================
// RUTAS DEL MÓDULO ASPIRANTE
// ============================================================================
Route::prefix('aspirante')->middleware(['auth', RoleMiddleware::class . ':Aspirante|Vocero|Secretario|Tesorero|Vicepresidente|Presidente|Super Admin'])->name('aspirante.')->group(function () {
    Route::get('/dashboard', [AspiranteController::class, 'dashboard'])->name('dashboard');
    Route::get('/calendario', [AspiranteController::class, 'calendario'])->name('calendario-consulta');
    Route::get('/proyectos', [AspiranteController::class, 'proyectos'])->name('mis-proyectos');
    Route::get('/reuniones', [AspiranteController::class, 'reuniones'])->name('mis-reuniones');
    Route::get('/secretaria', [AspiranteController::class, 'secretaria'])->name('comunicacion-secretaria');
    Route::get('/voceria', [AspiranteController::class, 'voceria'])->name('comunicacion-voceria');
    Route::get('/notas', [AspiranteController::class, 'notas'])->name('blog-notas');
    Route::get('/notas/crear', [AspiranteController::class, 'crearNota'])->name('crear-nota');
    Route::get('/perfil', [AspiranteController::class, 'perfil'])->name('mi-perfil');
});

// ============================================================================
// RUTAS DE AUTENTICACIÓN (Laravel Breeze)
// ============================================================================
require __DIR__.'/auth.php';