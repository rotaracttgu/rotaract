<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Aspirante\AspiranteController;
use App\Http\Controllers\VoceroController;
use App\Http\Controllers\TesoreroController;
use App\Http\Controllers\VicepresidenteController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BitacoraController; // ⭐ NUEVO
use App\Http\Controllers\Admin\UsuariosBloqueadosController; // ⭐ NUEVO - Sistema de bloqueo
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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Gestión de usuarios (solo Super Admin)
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.lista');
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('usuarios.crear');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.guardar');
    Route::get('/usuarios/{usuario}', [UserController::class, 'show'])->name('usuarios.ver');
    Route::get('/usuarios/{usuario}/editar', [UserController::class, 'edit'])->name('usuarios.editar');
    Route::put('/usuarios/{usuario}', [UserController::class, 'update'])->name('usuarios.actualizar');
    Route::delete('/usuarios/{usuario}', [UserController::class, 'destroy'])->name('usuarios.eliminar');

    // ============================================================================
    // ⭐ RUTAS DE BITÁCORA DEL SISTEMA
    // ============================================================================
    Route::prefix('bitacora')->name('bitacora.')->group(function () {
        // Vista principal con filtros
        Route::get('/', [BitacoraController::class, 'index'])->name('index');
        
        // Ver detalles de un registro específico
        Route::get('/{id}', [BitacoraController::class, 'show'])->name('show');
        
        // Exportar bitácora a CSV
        Route::get('/exportar/csv', [BitacoraController::class, 'exportar'])->name('exportar');
        
        // Limpiar registros antiguos
        Route::post('/limpiar', [BitacoraController::class, 'limpiar'])->name('limpiar');
    });

    // ============================================================================
    // ⭐ RUTAS DE GESTIÓN DE USUARIOS BLOQUEADOS - NUEVO
    // ============================================================================
    Route::prefix('usuarios-bloqueados')->name('usuarios-bloqueados.')->group(function () {
        // Vista principal - listar usuarios bloqueados
        Route::get('/', [UsuariosBloqueadosController::class, 'index'])->name('index');
        
        // Desbloquear un usuario específico
        Route::post('/{id}/desbloquear', [UsuariosBloqueadosController::class, 'desbloquear'])->name('desbloquear');
        
        // Resetear intentos fallidos de un usuario
        Route::post('/{id}/resetear-intentos', [UsuariosBloqueadosController::class, 'resetearIntentos'])->name('resetear');
        
        // Desbloquear todos los usuarios bloqueados
        Route::post('/desbloquear-todos', [UsuariosBloqueadosController::class, 'desbloquearTodos'])->name('desbloquear-todos');
    });
});

// ============================================================================
// RUTAS DEL MÓDULO PRESIDENTE
// ============================================================================
Route::prefix('presidente')->middleware(['auth', RoleMiddleware::class . ':Presidente|Super Admin'])->name('presidente.')->group(function () {
    Route::get('/dashboard', function () {
        return view('presidente.dashboard');
    })->name('dashboard');
    
    // ⭐ Bitácora también accesible para Presidente
    Route::prefix('bitacora')->name('bitacora.')->group(function () {
        Route::get('/', [BitacoraController::class, 'index'])->name('index');
        Route::get('/{id}', [BitacoraController::class, 'show'])->name('show');
        Route::get('/exportar/csv', [BitacoraController::class, 'exportar'])->name('exportar');
    });

    // ⭐ Gestión de usuarios bloqueados también accesible para Presidente
    Route::prefix('usuarios-bloqueados')->name('usuarios-bloqueados.')->group(function () {
        Route::get('/', [UsuariosBloqueadosController::class, 'index'])->name('index');
        Route::post('/{id}/desbloquear', [UsuariosBloqueadosController::class, 'desbloquear'])->name('desbloquear');
        Route::post('/{id}/resetear-intentos', [UsuariosBloqueadosController::class, 'resetearIntentos'])->name('resetear');
        Route::post('/desbloquear-todos', [UsuariosBloqueadosController::class, 'desbloquearTodos'])->name('desbloquear-todos');
    });
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
// RUTAS DEL MÓDULO ASPIRANTE - ✨ INTEGRADO CON PROCEDIMIENTOS ALMACENADOS
// ============================================================================
Route::prefix('aspirante')->middleware(['auth', RoleMiddleware::class . ':Aspirante|Vocero|Secretario|Tesorero|Vicepresidente|Presidente|Super Admin'])->name('aspirante.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AspiranteController::class, 'dashboard'])->name('dashboard');
    
    // Perfil
    Route::get('/perfil', [AspiranteController::class, 'perfil'])->name('mi-perfil');
    Route::post('/perfil', [AspiranteController::class, 'actualizarPerfil'])->name('perfil.actualizar');
    
    // Proyectos
    Route::get('/proyectos', [AspiranteController::class, 'proyectos'])->name('mis-proyectos');
    Route::get('/proyectos/{id}', [AspiranteController::class, 'detalleProyecto'])->name('proyectos.detalle');
    
    // Reuniones
    Route::get('/reuniones', [AspiranteController::class, 'reuniones'])->name('mis-reuniones');
    Route::post('/reuniones/asistencia', [AspiranteController::class, 'registrarAsistencia'])->name('reuniones.asistencia');
    
    // Calendario
    Route::get('/calendario', [AspiranteController::class, 'calendario'])->name('calendario-consulta');
    Route::get('/calendario/eventos', [AspiranteController::class, 'eventosDelDia'])->name('calendario.eventos');
    
    // Notas Personales - ✨ CRUD COMPLETO
    Route::get('/notas', [AspiranteController::class, 'notas'])->name('blog-notas');
    Route::get('/notas/crear', [AspiranteController::class, 'crearNota'])->name('crear-nota');
    Route::post('/notas', [AspiranteController::class, 'guardarNota'])->name('notas.guardar');
    Route::get('/notas/{id}/editar', [AspiranteController::class, 'editarNota'])->name('notas.editar');
    Route::put('/notas/{id}', [AspiranteController::class, 'actualizarNota'])->name('notas.actualizar');
    Route::delete('/notas/{id}', [AspiranteController::class, 'eliminarNota'])->name('notas.eliminar');
    
    // Comunicación - Secretaría
    Route::get('/secretaria', [AspiranteController::class, 'secretaria'])->name('comunicacion-secretaria');
    Route::post('/secretaria/consulta', [AspiranteController::class, 'enviarConsultaSecretaria'])->name('secretaria.consulta');
    
    // Comunicación - Vocalía
    Route::get('/voceria', [AspiranteController::class, 'voceria'])->name('comunicacion-voceria');
    Route::post('/voceria/consulta', [AspiranteController::class, 'enviarConsultaVoceria'])->name('voceria.consulta');
    
    // Chat en Tiempo Real
    Route::get('/conversacion/{id}', [AspiranteController::class, 'obtenerConversacion'])->name('conversacion');
    Route::post('/chat/mensaje', [AspiranteController::class, 'enviarMensajeChat'])->name('chat.mensaje');
    
    // Búsqueda Global
    Route::get('/buscar', [AspiranteController::class, 'buscar'])->name('buscar');
});

// ============================================================================
// RUTAS DE AUTENTICACIÓN (Laravel Breeze)
// ============================================================================
require __DIR__.'/auth.php';