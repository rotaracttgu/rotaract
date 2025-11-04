<?php
//use App\Services\ResendService;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Aspirante\AspiranteController;
use App\Http\Controllers\VoceroController;
use App\Http\Controllers\TesoreroController;
use App\Http\Controllers\VicepresidenteController;
use App\Http\Controllers\SecretariaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Auth\CompleteProfileController;
use App\Http\Controllers\Auth\SecurityQuestionPasswordResetController; // ⭐ NUEVO
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BitacoraController;
use App\Http\Controllers\Admin\UsuariosBloqueadosController;
use App\Http\Controllers\BackupController;  // ⭐ NUEVO: Importación para rutas de backup
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Mail;

// Página de inicio (pública)
Route::get('/', function () {
    return view('welcome');
});

//Verificación de correo resend
Route::get('/mail-test', function () {
    \Illuminate\Support\Facades\Mail::raw(
        'Prueba de correo vía Resend ✅',
        function ($m) {
            $m->to('cinteriano25@gmail.com')
              ->subject('Test Resend desde Laravel');
        }
    );
    return 'Correo de prueba enviado (revisa tu inbox/spam).';
});

// ============================================================================
// ⭐ RUTAS PARA COMPLETAR PERFIL (PRIMER LOGIN)
// ============================================================================
Route::middleware('auth')->group(function () {
    Route::get('/completar-perfil', [CompleteProfileController::class, 'showForm'])
        ->name('profile.complete.form');
    Route::post('/completar-perfil', [CompleteProfileController::class, 'store'])
        ->name('profile.complete.store');
});

// ============================================================================
// ⭐ RUTAS PARA RECUPERACIÓN DE CONTRASEÑA CON PREGUNTAS DE SEGURIDAD (NUEVO)
// ============================================================================
Route::middleware('guest')->group(function () {
    // Página de selección de método de recuperación
    Route::get('/password/recovery-options', function () {
        return view('auth.password-recovery-options');
    })->name('password.recovery.options');
    
    // Flujo de recuperación por preguntas de seguridad
    Route::get('/password/security-questions', [SecurityQuestionPasswordResetController::class, 'showIdentifyForm'])
        ->name('password.security.identify');
    
    Route::post('/password/security-questions/verify-user', [SecurityQuestionPasswordResetController::class, 'showQuestions'])
        ->name('password.security.questions');
    
    Route::post('/password/security-questions/verify-answers', [SecurityQuestionPasswordResetController::class, 'verifyAnswers'])
        ->name('password.security.verify');
    
    Route::post('/password/security-questions/reset', [SecurityQuestionPasswordResetController::class, 'resetPassword'])
        ->name('password.security.reset');
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
        return redirect()->route('secretaria.dashboard');
    } elseif ($user->hasRole('Vocero')) {
        return redirect()->route('vocero.dashboard');
    } elseif ($user->hasRole('Aspirante')) {
        return redirect()->route('aspirante.dashboard');
    }
    
    // Si no tiene rol definido, mostrar dashboard genérico
    return view('dashboard');
})->middleware(['auth', 'verified', 'check.first.login'])->name('dashboard');

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
Route::middleware(['auth', 'check.first.login'])->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('perfil.editar');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('perfil.actualizar');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('perfil.eliminar');
});

// ============================================================================
// RUTAS DE SUPER ADMIN
// ============================================================================
Route::prefix('admin')->middleware(['auth', 'check.first.login', RoleMiddleware::class . ':Super Admin'])->name('admin.')->group(function () {
    // Dashboard de Super Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notificaciones', [DashboardController::class, 'notificaciones'])->name('notificaciones');

    // Gestión de usuarios (solo Super Admin)
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.lista');
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('usuarios.crear');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.guardar');
    Route::get('/usuarios/{usuario}', [UserController::class, 'show'])->name('usuarios.ver');
    Route::get('/usuarios/{usuario}/editar', [UserController::class, 'edit'])->name('usuarios.editar');
    Route::put('/usuarios/{usuario}', [UserController::class, 'update'])->name('usuarios.actualizar');
    Route::delete('/usuarios/{usuario}', [UserController::class, 'destroy'])->name('usuarios.eliminar');

    // ============================================================================
    // RUTAS DE BITÁCORA DEL SISTEMA
    // ============================================================================
    Route::prefix('bitacora')->name('bitacora.')->group(function () {
        Route::get('/', [BitacoraController::class, 'index'])->name('index');
        Route::get('/{id}', [BitacoraController::class, 'show'])->name('show');
        Route::get('/exportar/csv', [BitacoraController::class, 'exportar'])->name('exportar');
        Route::post('/limpiar', [BitacoraController::class, 'limpiar'])->name('limpiar');
    });

    // ============================================================================
    // RUTAS DE GESTIÓN DE USUARIOS BLOQUEADOS
    // ============================================================================
    Route::prefix('usuarios-bloqueados')->name('usuarios-bloqueados.')->group(function () {
        Route::get('/', [UsuariosBloqueadosController::class, 'index'])->name('index');
        Route::post('/{id}/desbloquear', [UsuariosBloqueadosController::class, 'desbloquear'])->name('desbloquear');
        Route::post('/{id}/resetear-intentos', [UsuariosBloqueadosController::class, 'resetearIntentos'])->name('resetear');
        Route::post('/desbloquear-todos', [UsuariosBloqueadosController::class, 'desbloquearTodos'])->name('desbloquear-todos');
    });

    // ============================================================================
    // RUTAS DEL SISTEMA DE BACKUP (ANIDADO BAJO USERS)
    // ============================================================================
    Route::prefix('users/backup')->name('backup.')->group(function () {
        Route::get('/', [BackupController::class, 'index'])->name('index');
        Route::post('/ejecutar', [BackupController::class, 'ejecutarBackup'])->name('ejecutar');
        Route::post('/configuracion', [BackupController::class, 'guardarConfiguracion'])->name('configuracion');
        Route::get('/descargar/{id}', [BackupController::class, 'descargar'])->name('descargar');
         Route::post('/restaurar/{id}', [BackupController::class, 'restaurar'])->name('restaurar');
        Route::delete('/eliminar/{id}', [BackupController::class, 'eliminar'])->name('eliminar');
    });
});

// ============================================================================
// RUTAS DEL MÓDULO PRESIDENTE
// ============================================================================
Route::prefix('presidente')->middleware(['auth', 'check.first.login', RoleMiddleware::class . ':Presidente|Super Admin'])->name('presidente.')->group(function () {
    Route::get('/dashboard', function () {
        return view('presidente.dashboard');
    })->name('dashboard');
    Route::get('/notificaciones', function () {
        return view('presidente.notificaciones', ['notificaciones' => []]);
    })->name('notificaciones');
    
    Route::prefix('bitacora')->name('bitacora.')->group(function () {
        Route::get('/', [BitacoraController::class, 'index'])->name('index');
        Route::get('/{id}', [BitacoraController::class, 'show'])->name('show');
        Route::get('/exportar/csv', [BitacoraController::class, 'exportar'])->name('exportar');
    });

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
    Route::prefix('vicepresidente')->middleware(['auth', 'check.first.login', RoleMiddleware::class . ':Vicepresidente|Presidente|Super Admin'])->name('vicepresidente.')->group(function () {
    Route::get('/dashboard', [VicepresidenteController::class, 'dashboard'])->name('dashboard');
    Route::get('/calendario', [VicepresidenteController::class, 'calendario'])->name('calendario');
    Route::get('/notificaciones', [VicepresidenteController::class, 'notificaciones'])->name('notificaciones');
    Route::get('/asistencia/proyectos', [VicepresidenteController::class, 'asistenciaProyectos'])->name('asistencia.proyectos');
    Route::get('/asistencia/reuniones', [VicepresidenteController::class, 'asistenciaReuniones'])->name('asistencia.reuniones');
    
    // Cartas Formales
    Route::get('/cartas/formales', [VicepresidenteController::class, 'cartasFormales'])->name('cartas.formales');
    Route::get('/cartas/formales/{id}', [VicepresidenteController::class, 'showCartaFormal'])->name('cartas.formales.show');
    Route::post('/cartas/formales', [VicepresidenteController::class, 'storeCartaFormal'])->name('cartas.formales.store');
    Route::put('/cartas/formales/{id}', [VicepresidenteController::class, 'updateCartaFormal'])->name('cartas.formales.update');
    Route::delete('/cartas/formales/{id}', [VicepresidenteController::class, 'destroyCartaFormal'])->name('cartas.formales.destroy');
    
    // Cartas Patrocinio
    Route::get('/cartas/patrocinio', [VicepresidenteController::class, 'cartasPatrocinio'])->name('cartas.patrocinio');
    Route::get('/cartas/patrocinio/{id}', [VicepresidenteController::class, 'showCartaPatrocinio'])->name('cartas.patrocinio.show');
    Route::post('/cartas/patrocinio', [VicepresidenteController::class, 'storeCartaPatrocinio'])->name('cartas.patrocinio.store');
    Route::put('/cartas/patrocinio/{id}', [VicepresidenteController::class, 'updateCartaPatrocinio'])->name('cartas.patrocinio.update');
    Route::delete('/cartas/patrocinio/{id}', [VicepresidenteController::class, 'destroyCartaPatrocinio'])->name('cartas.patrocinio.destroy');
    
    Route::get('/estado/proyectos', [VicepresidenteController::class, 'estadoProyectos'])->name('estado.proyectos');
    
    Route::get('/reportes/dashboard', [ReporteController::class, 'dashboard'])->name('reportes.dashboard');
    Route::get('/reportes/mensuales', [ReporteController::class, 'mensuales'])->name('reportes.mensuales');
});

// ============================================================================
// RUTAS DEL MÓDULO TESORERO
// ============================================================================
Route::prefix('tesorero')->middleware(['auth', 'check.first.login', RoleMiddleware::class . ':Tesorero|Presidente|Super Admin'])->name('tesorero.')->group(function () {
    Route::get('/', [TesoreroController::class, 'welcome'])->name('welcome');
    Route::get('/dashboard', [TesoreroController::class, 'index'])->name('dashboard');
    Route::get('/calendario', [TesoreroController::class, 'calendario'])->name('calendario');
    Route::get('/finanzas', [TesoreroController::class, 'finanzas'])->name('finanzas');
});

// ============================================================================
// RUTAS DEL MÓDULO SECRETARÍA
// ============================================================================
Route::prefix('secretaria')->name('secretaria.')->middleware(['auth', 'check.first.login', RoleMiddleware::class . ':Secretario|Presidente|Super Admin'])->group(function () {
    // Dashboard principal
    Route::get('/dashboard', [SecretariaController::class, 'dashboard'])->name('dashboard');
    
    // Consultas
    Route::get('/consultas', [SecretariaController::class, 'consultas'])->name('consultas');
    Route::get('/consultas/pendientes', [SecretariaController::class, 'consultasPendientes'])->name('consultas.pendientes');
    Route::get('/consultas/recientes', [SecretariaController::class, 'consultasRecientes'])->name('consultas.recientes');
    Route::get('/consultas/{id}', [SecretariaController::class, 'getConsulta']);
    Route::post('/consultas/{id}/responder', [SecretariaController::class, 'responderConsulta']);
    Route::delete('/consultas/{id}', [SecretariaController::class, 'eliminarConsulta']);
    
    // Actas
    Route::get('/actas', [SecretariaController::class, 'actas'])->name('actas.index');
    Route::get('/actas/{id}', [SecretariaController::class, 'getActa']);
    Route::post('/actas', [SecretariaController::class, 'storeActa']);
    Route::post('/actas/{id}', [SecretariaController::class, 'updateActa']);
    Route::delete('/actas/{id}', [SecretariaController::class, 'eliminarActa']);
    
    // Diplomas
    Route::get('/diplomas', [SecretariaController::class, 'diplomas'])->name('diplomas.index');
    Route::get('/diplomas/{id}', [SecretariaController::class, 'getDiploma']);
    Route::post('/diplomas', [SecretariaController::class, 'storeDiploma']);
    Route::post('/diplomas/{id}', [SecretariaController::class, 'updateDiploma']);
    Route::delete('/diplomas/{id}', [SecretariaController::class, 'eliminarDiploma']);
    Route::post('/diplomas/{id}/enviar-email', [SecretariaController::class, 'enviarEmailDiploma']);
    
    // Documentos
    Route::get('/documentos', [SecretariaController::class, 'documentos'])->name('documentos.index');
    Route::get('/documentos/{id}', [SecretariaController::class, 'getDocumento']);
    Route::post('/documentos', [SecretariaController::class, 'storeDocumento']);
    Route::post('/documentos/{id}', [SecretariaController::class, 'updateDocumento']);
    Route::delete('/documentos/{id}', [SecretariaController::class, 'eliminarDocumento']);
});

// ============================================================================
// RUTAS DEL MÓDULO VOCERO
// ============================================================================
Route::prefix('vocero')->middleware(['auth', 'check.first.login', RoleMiddleware::class . ':Vocero|Presidente|Super Admin'])->name('vocero.')->group(function () {
    Route::get('/', [VoceroController::class, 'index'])->name('index');
    Route::get('/bienvenida', [VoceroController::class, 'welcome'])->name('bienvenida');
    Route::get('/calendario', [VoceroController::class, 'calendario'])->name('calendario');
    Route::get('/dashboard', [VoceroController::class, 'dashboard'])->name('dashboard');
    Route::get('/notificaciones', function () {
        return view('modulos.vocero.notificaciones', ['notificaciones' => []]);
    })->name('notificaciones');
    Route::get('/asistencias', [VoceroController::class, 'gestionAsistencias'])->name('asistencias');
    Route::get('/eventos', [VoceroController::class, 'gestionEventos'])->name('eventos');
    Route::get('/reportes', [VoceroController::class, 'reportesAnalisis'])->name('reportes');
});
// ============================================================================
// 🆕 RUTAS API DEL CALENDARIO (VOCERO)
// ============================================================================
Route::prefix('api/calendario')->middleware(['auth', 'check.first.login'])->group(function () {
    Route::get('/eventos', [VoceroController::class, 'obtenerEventos']);
    Route::post('/eventos', [VoceroController::class, 'crearEvento']);
    Route::put('/eventos/{id}', [VoceroController::class, 'actualizarEvento']);
    Route::delete('/eventos/{id}', [VoceroController::class, 'eliminarEvento']);
    Route::patch('/eventos/{id}/fechas', [VoceroController::class, 'actualizarFechas']);
     Route::get('/miembros', [VoceroController::class, 'obtenerMiembros']);
    Route::get('/eventos/{id}/asistencias', [VoceroController::class, 'obtenerAsistenciasEvento']);
    Route::post('/asistencias', [VoceroController::class, 'registrarAsistencia']);
    Route::put('/asistencias/{id}', [VoceroController::class, 'actualizarAsistencia']);
    Route::delete('/asistencias/{id}', [VoceroController::class, 'eliminarAsistencia']);
    // ============================================================================
    // 🆕 RUTAS DE REPORTES Y ESTADÍSTICAS
    // ============================================================================
    Route::get('/reportes/estadisticas-generales', [VoceroController::class, 'obtenerEstadisticasGenerales']);
    Route::get('/reportes/detallado', [VoceroController::class, 'obtenerReporteDetallado']);
    Route::get('/reportes/evento/{id}', [VoceroController::class, 'obtenerReporteEvento']);
    Route::get('/reportes/miembro/{id}', [VoceroController::class, 'obtenerEstadisticasMiembro']);
    Route::post('/reportes/buscar-por-fecha', [VoceroController::class, 'buscarEventosPorFecha']);
    Route::get('/reportes/graficos', [VoceroController::class, 'obtenerDatosGraficos']);
});

// ============================================================================
// RUTAS DEL MÓDULO ASPIRANTE
// ============================================================================
Route::prefix('aspirante')->middleware(['auth', 'check.first.login', RoleMiddleware::class . ':Aspirante|Vocero|Secretario|Tesorero|Vicepresidente|Presidente|Super Admin'])->name('aspirante.')->group(function () {
    Route::get('/dashboard', [AspiranteController::class, 'dashboard'])->name('dashboard');
    Route::get('/notificaciones', function () {
        return view('modulos.aspirante.notificaciones', ['notificaciones' => []]);
    })->name('notificaciones');
    Route::get('/perfil', [AspiranteController::class, 'perfil'])->name('mi-perfil');
    Route::post('/perfil', [AspiranteController::class, 'actualizarPerfil'])->name('perfil.actualizar');
    Route::get('/proyectos', [AspiranteController::class, 'proyectos'])->name('mis-proyectos');
    Route::get('/proyectos/{id}', [AspiranteController::class, 'detalleProyecto'])->name('proyectos.detalle');
    Route::get('/reuniones', [AspiranteController::class, 'reuniones'])->name('mis-reuniones');
    Route::post('/reuniones/asistencia', [AspiranteController::class, 'registrarAsistencia'])->name('reuniones.asistencia');
    Route::get('/calendario', [AspiranteController::class, 'calendario'])->name('calendario-consulta');
    Route::get('/calendario/eventos', [AspiranteController::class, 'eventosDelDia'])->name('calendario.eventos');
    Route::get('/notas', [AspiranteController::class, 'notas'])->name('blog-notas');
    Route::get('/notas/crear', [AspiranteController::class, 'crearNota'])->name('crear-nota');
    Route::post('/notas', [AspiranteController::class, 'guardarNota'])->name('notas.guardar');
    Route::get('/notas/{id}/editar', [AspiranteController::class, 'editarNota'])->name('notas.editar');
    Route::put('/notas/{id}', [AspiranteController::class, 'actualizarNota'])->name('notas.actualizar');
    Route::delete('/notas/{id}', [AspiranteController::class, 'eliminarNota'])->name('notas.eliminar');
    Route::get('/secretaria', [AspiranteController::class, 'secretaria'])->name('comunicacion-secretaria');
    Route::post('/secretaria/consulta', [AspiranteController::class, 'enviarConsultaSecretaria'])->name('secretaria.consulta');
    Route::get('/voceria', [AspiranteController::class, 'voceria'])->name('comunicacion-voceria');
    Route::post('/voceria/consulta', [AspiranteController::class, 'enviarConsultaVoceria'])->name('voceria.consulta');
    Route::get('/conversacion/{id}', [AspiranteController::class, 'obtenerConversacion'])->name('conversacion');
    Route::post('/chat/mensaje', [AspiranteController::class, 'enviarMensajeChat'])->name('chat.mensaje');
    Route::get('/buscar', [AspiranteController::class, 'buscar'])->name('buscar');
});

// ============================================================================
// RUTAS DE AUTENTICACIÓN (Laravel Breeze)
// ============================================================================
require __DIR__.'/auth.php';
