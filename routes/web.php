<?php

//use App\Services\ResendService;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SocioController; // NUEVO - Reemplaza AspiranteController
use App\Http\Controllers\VoceroController;
use App\Http\Controllers\TesoreroController;
use App\Http\Controllers\VicepresidenteController;
use App\Http\Controllers\SecretariaController;
use App\Http\Controllers\PresidenteController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Auth\CompleteProfileController;
use App\Http\Controllers\Auth\SecurityQuestionPasswordResetController; // NUEVO
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BitacoraController;
use App\Http\Controllers\Admin\UsuariosBloqueadosController;
use App\Http\Controllers\BackupController;  // NUEVO: Importación para rutas de backup
use App\Http\Controllers\UniversalDashboardController;  // NUEVO: Dashboard dinámico universal
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Mail;

// ⭐ IMPORTAR CONTROLADORES DE CONFIGURACIÓN
use App\Http\Controllers\Admin\Configuracion\RoleController;
use App\Http\Controllers\Admin\Configuracion\PermissionController;
use App\Http\Controllers\AdminController;

// Página de inicio (pública)
Route::get('/', function () {
    return view('welcome');
});

//Verificación de correo resend
Route::get('/mail-test', function () {
    \Illuminate\Support\Facades\Mail::raw(
        'Prueba de correo vía Resend',
        function ($m) {
            $m->to('cinteriano25@gmail.com')
              ->subject('Test Resend desde Laravel');
        }
    );
    return 'Correo de prueba enviado (revisa tu inbox/spam).';
});

// ============================================================================
// RUTAS PARA COMPLETAR PERFIL (PRIMER LOGIN)
// ============================================================================
Route::middleware('auth')->group(function () {
    Route::get('/completar-perfil', [CompleteProfileController::class, 'showForm'])
        ->name('profile.complete.form');
    Route::post('/completar-perfil', [CompleteProfileController::class, 'store'])
        ->name('profile.complete.store');
});

// ============================================================================
// RUTAS PARA RECUPERACIÓN DE CONTRASEÑA CON PREGUNTAS DE SEGURIDAD (NUEVO)
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

    // Roles con módulos específicos - redirigen a su dashboard propio
    $rolesConModulo = [
        'Super Admin' => 'admin.dashboard',
        'Presidente' => 'presidente.dashboard',
        'Vicepresidente' => 'vicepresidente.dashboard',
        'Tesorero' => 'tesorero.dashboard',
        'Secretario' => 'secretaria.dashboard',
        'Vocero' => 'vocero.dashboard',
        'Aspirante' => 'socio.dashboard',
    ];

    // Verificar si tiene un rol con módulo específico
    foreach ($rolesConModulo as $roleName => $route) {
        if ($user->hasRole($roleName)) {
            return redirect()->route($route);
        }
    }
    
    // Si no tiene un módulo específico, usar el dashboard universal dinámico
    // Este dashboard se adapta a los permisos del usuario
    return redirect()->route('universal.dashboard');
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
// DASHBOARD UNIVERSAL DINÁMICO (Para roles sin módulo específico)
// ============================================================================
Route::middleware(['auth', 'check.first.login'])->group(function () {
    Route::get('/mi-dashboard', [UniversalDashboardController::class, 'index'])->name('universal.dashboard');
});

// ============================================================================
// RUTAS DE SUPER ADMIN
// ============================================================================
Route::prefix('admin')->middleware(['auth', 'check.first.login', RoleMiddleware::class . ':Super Admin'])->name('admin.')->group(function () {
    // Dashboard de Super Admin
    Route::get('/dashboard', [DashboardController::class, 'indexTabs'])->name('dashboard');
    Route::get('/calendario', [DashboardController::class, 'calendario'])->name('calendario');
    
    // Notificaciones
    Route::get('/notificaciones', [DashboardController::class, 'notificaciones'])->name('notificaciones');
    Route::post('/notificaciones/{id}/marcar-leida', [DashboardController::class, 'marcarNotificacionLeida'])->name('notificaciones.marcar-leida');
    Route::post('/notificaciones/marcar-todas-leidas', [DashboardController::class, 'marcarTodasNotificacionesLeidas'])->name('notificaciones.marcar-todas-leidas');

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

    // ============================================================================
    // ⭐ RUTAS DE CONFIGURACIÓN - ROLES Y PERMISOS (NUEVO)
    // ============================================================================
    Route::prefix('configuracion')->name('configuracion.')->group(function () {
        
        // RUTAS AJAX: Cargan el index completo
        Route::get('roles/ajax', [RoleController::class, 'ajaxIndex'])
            ->name('roles.ajax');

        Route::get('permisos/ajax', [PermissionController::class, 'ajaxIndex'])
            ->name('permisos.ajax');

        // Vista para asignar permisos por módulo
        Route::get('roles/{role}/asignar-permisos', [RoleController::class, 'mostrarAsignarPermisos'])
            ->name('roles.mostrar-asignar-permisos');
        
        Route::post('roles/{role}/asignar-permisos', [RoleController::class, 'asignarPermisos'])
            ->name('roles.asignar-permisos');

        // RECURSOS SIN index (para create, edit, show, etc.)
        Route::resource('roles', RoleController::class)->except(['index']);
        Route::resource('permisos', PermissionController::class)->except(['index']);
    });

    // ============================================================================
    // MÓDULO PRESIDENTE - Integrado en Admin
    // ============================================================================
    Route::prefix('presidente')->name('presidente.')->group(function () {
        // Dashboard y vistas principales
        Route::get('/dashboard', [AdminController::class, 'presidenteDashboard'])->name('dashboard');
        
        // Notificaciones
        Route::get('/notificaciones', [AdminController::class, 'presidenteNotificaciones'])->name('notificaciones');
        
        // Cartas Formales
        Route::get('/cartas/formales', [AdminController::class, 'presidenteCartasFormales'])->name('cartas.formales');
        Route::get('/cartas/formales/{id}', [AdminController::class, 'showCartaFormal'])->name('cartas.formales.show');
        Route::post('/cartas/formales', [AdminController::class, 'storeCartaFormal'])->name('cartas.formales.store');
        Route::put('/cartas/formales/{id}', [AdminController::class, 'updateCartaFormal'])->name('cartas.formales.update');
        Route::delete('/cartas/formales/{id}', [AdminController::class, 'destroyCartaFormal'])->name('cartas.formales.destroy');
        Route::get('/cartas/formales/{id}/pdf', [AdminController::class, 'exportarCartaFormalPDF'])->name('cartas.formales.pdf');
        Route::get('/cartas/formales/{id}/word', [AdminController::class, 'exportarCartaFormalWord'])->name('cartas.formales.word');
        
        // Cartas Patrocinio
        Route::get('/cartas/patrocinio', [AdminController::class, 'presidenteCartasPatrocinio'])->name('cartas.patrocinio');
        Route::get('/cartas/patrocinio/{id}', [AdminController::class, 'showCartaPatrocinio'])->name('cartas.patrocinio.show');
        Route::post('/cartas/patrocinio', [AdminController::class, 'storeCartaPatrocinio'])->name('cartas.patrocinio.store');
        Route::put('/cartas/patrocinio/{id}', [AdminController::class, 'updateCartaPatrocinio'])->name('cartas.patrocinio.update');
        Route::delete('/cartas/patrocinio/{id}', [AdminController::class, 'destroyCartaPatrocinio'])->name('cartas.patrocinio.destroy');
        Route::get('/cartas/patrocinio/{id}/pdf', [AdminController::class, 'exportarCartaPatrocinioPDF'])->name('cartas.patrocinio.pdf');
        Route::get('/cartas/patrocinio/{id}/word', [AdminController::class, 'exportarCartaPatrocinioWord'])->name('cartas.patrocinio.word');
        
        // Estado de Proyectos
        Route::get('/estado/proyectos', [AdminController::class, 'presidenteEstadoProyectos'])->name('estado.proyectos');
        Route::get('/proyectos/{id}', [AdminController::class, 'showProyecto'])->name('proyectos.show');
        Route::get('/proyectos/{id}/detalles', [AdminController::class, 'detallesProyecto'])->name('proyectos.detalles');
        Route::post('/proyectos', [AdminController::class, 'storeProyecto'])->name('proyectos.store');
        Route::put('/proyectos/{id}', [AdminController::class, 'updateProyecto'])->name('proyectos.update');
        Route::delete('/proyectos/{id}', [AdminController::class, 'destroyProyecto'])->name('proyectos.destroy');
    });

    // API del Calendario de Presidente
    Route::prefix('api/presidente/calendario')->name('api.presidente.calendario.')->group(function () {
        Route::get('/eventos', [AdminController::class, 'obtenerEventos']);
        Route::post('/eventos', [AdminController::class, 'crearEvento']);
        Route::put('/eventos/{id}', [AdminController::class, 'actualizarEvento']);
        Route::delete('/eventos/{id}', [AdminController::class, 'eliminarEvento']);
        Route::patch('/eventos/{id}/fechas', [AdminController::class, 'actualizarFechas']);
        Route::get('/miembros', [AdminController::class, 'obtenerMiembros']);
        Route::get('/eventos/{id}/asistencias', [AdminController::class, 'obtenerAsistenciasEvento']);
        Route::post('/asistencias', [AdminController::class, 'registrarAsistencia']);
        Route::put('/asistencias/{id}', [AdminController::class, 'actualizarAsistencia']);
        Route::delete('/asistencias/{id}', [AdminController::class, 'eliminarAsistencia']);
    });
});

// ============================================================================
// RUTAS DEL MÓDULO PRESIDENTE (Original - para usuarios con rol Presidente)
// ============================================================================
Route::prefix('presidente')->middleware(['auth', 'check.first.login', RoleMiddleware::class . ':Presidente|Super Admin'])->name('presidente.')->group(function () {
    Route::get('/dashboard', [PresidenteController::class, 'dashboard'])->name('dashboard');
    
    // Notificaciones
    Route::get('/notificaciones', [PresidenteController::class, 'notificaciones'])->name('notificaciones');
    Route::post('/notificaciones/{id}/marcar-leida', [PresidenteController::class, 'marcarNotificacionLeida'])->name('notificaciones.marcar-leida');
    Route::post('/notificaciones/marcar-todas-leidas', [PresidenteController::class, 'marcarTodasNotificacionesLeidas'])->name('notificaciones.marcar-todas-leidas');
    Route::get('/notificaciones/verificar', [PresidenteController::class, 'verificarActualizaciones'])->name('notificaciones.verificar');
    
    // Cartas Formales
    Route::get('/cartas/formales', [PresidenteController::class, 'cartasFormales'])->name('cartas.formales');
    Route::get('/cartas/formales/{id}', [PresidenteController::class, 'showCartaFormal'])->name('cartas.formales.show');
    Route::post('/cartas/formales', [PresidenteController::class, 'storeCartaFormal'])->name('cartas.formales.store');
    Route::put('/cartas/formales/{id}', [PresidenteController::class, 'updateCartaFormal'])->name('cartas.formales.update');
    Route::delete('/cartas/formales/{id}', [PresidenteController::class, 'destroyCartaFormal'])->name('cartas.formales.destroy');
    Route::get('/cartas/formales/{id}/pdf', [PresidenteController::class, 'exportarCartaFormalPDF'])->name('cartas.formales.pdf');
    Route::get('/cartas/formales/{id}/word', [PresidenteController::class, 'exportarCartaFormalWord'])->name('cartas.formales.word');
    Route::get('/cartas/formales/export/excel', [PresidenteController::class, 'exportarCartasFormalesExcel'])->name('cartas.formales.excel');
    
    // Cartas Patrocinio
    Route::get('/cartas/patrocinio', [PresidenteController::class, 'cartasPatrocinio'])->name('cartas.patrocinio');
    Route::get('/cartas/patrocinio/{id}', [PresidenteController::class, 'showCartaPatrocinio'])->name('cartas.patrocinio.show');
    Route::post('/cartas/patrocinio', [PresidenteController::class, 'storeCartaPatrocinio'])->name('cartas.patrocinio.store');
    Route::put('/cartas/patrocinio/{id}', [PresidenteController::class, 'updateCartaPatrocinio'])->name('cartas.patrocinio.update');
    Route::delete('/cartas/patrocinio/{id}', [PresidenteController::class, 'destroyCartaPatrocinio'])->name('cartas.patrocinio.destroy');
    Route::get('/cartas/patrocinio/{id}/pdf', [PresidenteController::class, 'exportarCartaPatrocinioPDF'])->name('cartas.patrocinio.pdf');
    Route::get('/cartas/patrocinio/{id}/word', [PresidenteController::class, 'exportarCartaPatrocinioWord'])->name('cartas.patrocinio.word');
    Route::get('/cartas/patrocinio/export/excel', [PresidenteController::class, 'exportarCartasPatrocinioExcel'])->name('cartas.patrocinio.excel');
    
    // Estado de Proyectos (CRUD Completo)
    Route::get('/estado/proyectos', [PresidenteController::class, 'estadoProyectos'])->name('estado.proyectos');
    Route::get('/proyectos/{id}/detalles', [PresidenteController::class, 'detallesProyecto'])->name('proyectos.detalles');
    Route::post('/proyectos', [PresidenteController::class, 'storeProyecto'])->name('proyectos.store');
    Route::put('/proyectos/{id}', [PresidenteController::class, 'updateProyecto'])->name('proyectos.update');
    Route::delete('/proyectos/{id}', [PresidenteController::class, 'destroyProyecto'])->name('proyectos.destroy');
    Route::get('/proyectos/exportar', [PresidenteController::class, 'exportarProyectos'])->name('proyectos.exportar');
    
    Route::get('/reportes/dashboard', [ReporteController::class, 'dashboard'])->name('reportes.dashboard');
    Route::get('/reportes/mensuales', [ReporteController::class, 'mensuales'])->name('reportes.mensuales');
    
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

    // Gestión de Usuarios
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/', [PresidenteController::class, 'usuariosLista'])->name('lista');
        Route::get('/crear', [PresidenteController::class, 'usuariosCrear'])->name('crear');
        Route::post('/', [PresidenteController::class, 'usuariosGuardar'])->name('guardar');
        Route::get('/{usuario}', [PresidenteController::class, 'usuariosVer'])->name('ver');
        Route::get('/{usuario}/editar', [PresidenteController::class, 'usuariosEditar'])->name('editar');
        Route::put('/{usuario}', [PresidenteController::class, 'usuariosActualizar'])->name('actualizar');
        Route::delete('/{usuario}', [PresidenteController::class, 'usuariosEliminar'])->name('eliminar');
    });
});

// ============================================================================
// RUTAS API DEL CALENDARIO (PRESIDENTE) - Sistema Integrado
// ============================================================================
Route::prefix('api/presidente/calendario')->middleware(['auth', 'check.first.login', RoleMiddleware::class . ':Presidente|Super Admin'])->group(function () {
    Route::get('/eventos', [PresidenteController::class, 'obtenerEventos']);
    Route::post('/eventos', [PresidenteController::class, 'crearEvento']);
    Route::put('/eventos/{id}', [PresidenteController::class, 'actualizarEvento']);
    Route::delete('/eventos/{id}', [PresidenteController::class, 'eliminarEvento']);
    Route::patch('/eventos/{id}/fechas', [PresidenteController::class, 'actualizarFechas']);
    Route::get('/miembros', [PresidenteController::class, 'obtenerMiembros']);
    Route::get('/eventos/{id}/asistencias', [PresidenteController::class, 'obtenerAsistenciasEvento']);
    Route::post('/asistencias', [PresidenteController::class, 'registrarAsistencia']);
    Route::put('/asistencias/{id}', [PresidenteController::class, 'actualizarAsistencia']);
    Route::delete('/asistencias/{id}', [PresidenteController::class, 'eliminarAsistencia']);
});

// ============================================================================
// RUTAS DEL MÓDULO VICEPRESIDENTE
// ============================================================================
Route::prefix('vicepresidente')->middleware(['auth', 'check.first.login', RoleMiddleware::class . ':Vicepresidente|Presidente|Super Admin'])->name('vicepresidente.')->group(function () {
    Route::get('/dashboard', [VicepresidenteController::class, 'dashboard'])->name('dashboard');
    
    // Notificaciones
    Route::get('/notificaciones', [VicepresidenteController::class, 'notificaciones'])->name('notificaciones');
    Route::post('/notificaciones/{id}/marcar-leida', [VicepresidenteController::class, 'marcarNotificacionLeida'])->name('notificaciones.marcar-leida');
    Route::post('/notificaciones/marcar-todas-leidas', [VicepresidenteController::class, 'marcarTodasNotificacionesLeidas'])->name('notificaciones.marcar-todas-leidas');
    Route::get('/notificaciones/verificar', [VicepresidenteController::class, 'verificarActualizaciones'])->name('notificaciones.verificar');
    
    // Cartas Formales
    Route::get('/cartas/formales', [VicepresidenteController::class, 'cartasFormales'])->name('cartas.formales');
    Route::get('/cartas/formales/{id}', [VicepresidenteController::class, 'showCartaFormal'])->name('cartas.formales.show');
    Route::post('/cartas/formales', [VicepresidenteController::class, 'storeCartaFormal'])->name('cartas.formales.store');
    Route::put('/cartas/formales/{id}', [VicepresidenteController::class, 'updateCartaFormal'])->name('cartas.formales.update');
    Route::delete('/cartas/formales/{id}', [VicepresidenteController::class, 'destroyCartaFormal'])->name('cartas.formales.destroy');
    Route::get('/cartas/formales/{id}/pdf', [VicepresidenteController::class, 'exportarCartaFormalPDF'])->name('cartas.formales.pdf');
    Route::get('/cartas/formales/{id}/word', [VicepresidenteController::class, 'exportarCartaFormalWord'])->name('cartas.formales.word');
    Route::get('/cartas/formales/export/excel', [VicepresidenteController::class, 'exportarCartasFormalesExcel'])->name('cartas.formales.excel');
    
    // Cartas Patrocinio
    Route::get('/cartas/patrocinio', [VicepresidenteController::class, 'cartasPatrocinio'])->name('cartas.patrocinio');
    Route::get('/cartas/patrocinio/{id}', [VicepresidenteController::class, 'showCartaPatrocinio'])->name('cartas.patrocinio.show');
    Route::post('/cartas/patrocinio', [VicepresidenteController::class, 'storeCartaPatrocinio'])->name('cartas.patrocinio.store');
    Route::put('/cartas/patrocinio/{id}', [VicepresidenteController::class, 'updateCartaPatrocinio'])->name('cartas.patrocinio.update');
    Route::delete('/cartas/patrocinio/{id}', [VicepresidenteController::class, 'destroyCartaPatrocinio'])->name('cartas.patrocinio.destroy');
    Route::get('/cartas/patrocinio/{id}/pdf', [VicepresidenteController::class, 'exportarCartaPatrocinioPDF'])->name('cartas.patrocinio.pdf');
    Route::get('/cartas/patrocinio/{id}/word', [VicepresidenteController::class, 'exportarCartaPatrocinioWord'])->name('cartas.patrocinio.word');
    Route::get('/cartas/patrocinio/export/excel', [VicepresidenteController::class, 'exportarCartasPatrocinioExcel'])->name('cartas.patrocinio.excel');
    
    // Estado de Proyectos (CRUD Completo)
    Route::get('/estado/proyectos', [VicepresidenteController::class, 'estadoProyectos'])->name('estado.proyectos');
    Route::get('/proyectos/{id}/detalles', [VicepresidenteController::class, 'detallesProyecto'])->name('proyectos.detalles');
    Route::post('/proyectos', [VicepresidenteController::class, 'storeProyecto'])->name('proyectos.store');
    Route::put('/proyectos/{id}', [VicepresidenteController::class, 'updateProyecto'])->name('proyectos.update');
    Route::delete('/proyectos/{id}', [VicepresidenteController::class, 'destroyProyecto'])->name('proyectos.destroy');
    Route::get('/proyectos/exportar', [VicepresidenteController::class, 'exportarProyectos'])->name('proyectos.exportar');
    
    Route::get('/reportes/dashboard', [ReporteController::class, 'dashboard'])->name('reportes.dashboard');
    Route::get('/reportes/mensuales', [ReporteController::class, 'mensuales'])->name('reportes.mensuales');

    // Gestión de Usuarios
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/', [VicepresidenteController::class, 'usuariosLista'])->name('lista');
        Route::get('/{usuario}', [VicepresidenteController::class, 'usuariosVer'])->name('ver');
        Route::get('/{usuario}/editar', [VicepresidenteController::class, 'usuariosEditar'])->name('editar');
        Route::put('/{usuario}', [VicepresidenteController::class, 'usuariosActualizar'])->name('actualizar');
    });
});

// ============================================================================
// RUTAS API DEL CALENDARIO (VICEPRESIDENTE) - Sistema Integrado
// ============================================================================
Route::prefix('api/vicepresidente/calendario')->middleware(['auth', 'check.first.login', RoleMiddleware::class . ':Vicepresidente|Presidente|Super Admin'])->group(function () {
    Route::get('/eventos', [VicepresidenteController::class, 'obtenerEventos']);
    Route::post('/eventos', [VicepresidenteController::class, 'crearEvento']);
    Route::put('/eventos/{id}', [VicepresidenteController::class, 'actualizarEvento']);
    Route::delete('/eventos/{id}', [VicepresidenteController::class, 'eliminarEvento']);
    Route::patch('/eventos/{id}/fechas', [VicepresidenteController::class, 'actualizarFechas']);
    Route::get('/miembros', [VicepresidenteController::class, 'obtenerMiembros']);
    Route::get('/eventos/{id}/asistencias', [VicepresidenteController::class, 'obtenerAsistenciasEvento']);
    Route::post('/asistencias', [VicepresidenteController::class, 'registrarAsistencia']);
    Route::put('/asistencias/{id}', [VicepresidenteController::class, 'actualizarAsistencia']);
    Route::delete('/asistencias/{id}', [VicepresidenteController::class, 'eliminarAsistencia']);
});

// ============================================================================
// RUTAS DEL MÓDULO TESORERO
// ============================================================================
Route::prefix('tesorero')->middleware(['auth', 'check.first.login', RoleMiddleware::class . ':Tesorero|Presidente|Super Admin'])->name('tesorero.')->group(function () {
    // Dashboard principal - ÚNICA RUTA
    Route::get('/dashboard', [TesoreroController::class, 'index'])->name('dashboard');
    Route::get('/calendario', [TesoreroController::class, 'calendario'])->name('calendario');
    
    // NOTIFICACIONES
    Route::prefix('notificaciones')->name('notificaciones.')->group(function () {
        Route::get('/', [TesoreroController::class, 'notificaciones'])->name('index');
        Route::post('/{id}/leer', [TesoreroController::class, 'marcarNotificacionLeida'])->name('leer');
        Route::post('/todas/leer', [TesoreroController::class, 'marcarTodasNotificacionesLeidas'])->name('todas-leer');
    });
    
    // CRUD INGRESOS
    Route::prefix('ingresos')->name('ingresos.')->group(function () {
        Route::get('/', [TesoreroController::class, 'ingresosIndex'])->name('index');
        Route::get('/crear', [TesoreroController::class, 'ingresosCreate'])->name('create');
        Route::post('/', [TesoreroController::class, 'ingresosStore'])->name('store');
        Route::get('/{id}', [TesoreroController::class, 'ingresosShow'])->name('show');
        Route::get('/{id}/editar', [TesoreroController::class, 'ingresosEdit'])->name('edit');
        Route::put('/{id}', [TesoreroController::class, 'ingresosUpdate'])->name('update');
        Route::delete('/{id}', [TesoreroController::class, 'ingresosDestroy'])->name('destroy');
    });
    
    // CRUD GASTOS
    Route::prefix('gastos')->name('gastos.')->group(function () {
        Route::get('/', [TesoreroController::class, 'gastosIndex'])->name('index');
        Route::get('/crear', [TesoreroController::class, 'gastosCreate'])->name('create');
        Route::post('/', [TesoreroController::class, 'gastosStore'])->name('store');
        Route::get('/{id}', [TesoreroController::class, 'gastosShow'])->name('show');
        Route::get('/{id}/editar', [TesoreroController::class, 'gastosEdit'])->name('edit');
        Route::put('/{id}', [TesoreroController::class, 'gastosUpdate'])->name('update');
        Route::delete('/{id}', [TesoreroController::class, 'gastosDestroy'])->name('destroy');
        
        // Acciones especiales
        Route::post('/{id}/aprobar', [TesoreroController::class, 'aprobarGasto'])->name('aprobar');
        Route::post('/{id}/rechazar', [TesoreroController::class, 'rechazarGasto'])->name('rechazar');
        Route::get('/{id}/detalles', [TesoreroController::class, 'verDetallesGasto'])->name('detalles');
    });
    
    // CRUD TRANSFERENCIAS
    Route::prefix('transferencias')->name('transferencias.')->group(function () {
        Route::get('/', [TesoreroController::class, 'transferenciasIndex'])->name('index');
        Route::get('/crear', [TesoreroController::class, 'transferenciasCreate'])->name('create');
        Route::post('/', [TesoreroController::class, 'transferenciasStore'])->name('store');
        Route::get('/{id}', [TesoreroController::class, 'transferenciasShow'])->name('show');
        Route::get('/{id}/editar', [TesoreroController::class, 'transferenciasEdit'])->name('edit');
        Route::put('/{id}', [TesoreroController::class, 'transferenciasUpdate'])->name('update');
        Route::delete('/{id}', [TesoreroController::class, 'transferenciasDestroy'])->name('destroy');
    });
    
    // CRUD MEMBRESÍAS
    Route::prefix('membresias')->name('membresias.')->group(function () {
        Route::get('/', [TesoreroController::class, 'membresiasIndex'])->name('index');
        Route::get('/crear', [TesoreroController::class, 'membresiasCreate'])->name('create');
        // Membresías personales - Rutas específicas ANTES de rutas paramétrizadas
        Route::get('/mis/membresias', [TesoreroController::class, 'misMembresías'])->name('mis');
        Route::post('/solicitar/renovacion', [TesoreroController::class, 'solicitarRenovacion'])->name('renovacion');
        Route::post('/guardar/recordatorio', [TesoreroController::class, 'guardarRecordatorio'])->name('recordatorio');
        Route::post('/eliminar/pago', [TesoreroController::class, 'eliminarPagoHistorial'])->name('eliminar-pago');
        Route::post('/limpiar/historial', [TesoreroController::class, 'limpiarHistorial'])->name('limpiar-historial');
        // Rutas paramétrizadas
        Route::post('/', [TesoreroController::class, 'membresiasStore'])->name('store');
        Route::get('/{id}', [TesoreroController::class, 'membresiasShow'])->name('show');
        Route::get('/{id}/editar', [TesoreroController::class, 'membresiasEdit'])->name('edit');
        Route::put('/{id}', [TesoreroController::class, 'membresiasUpdate'])->name('update');
        Route::delete('/{id}', [TesoreroController::class, 'membresiasDestroy'])->name('destroy');
    });
    
    // CRUD PRESUPUESTOS
    Route::prefix('presupuestos')->name('presupuestos.')->group(function () {
        Route::get('/', [TesoreroController::class, 'presupuestosIndex'])->name('index');
        Route::get('/crear', [TesoreroController::class, 'presupuestosCreate'])->name('create');
        Route::post('/', [TesoreroController::class, 'presupuestosStore'])->name('store');
        Route::get('/{id}', [TesoreroController::class, 'presupuestosShow'])->name('show');
        Route::get('/{id}/editar', [TesoreroController::class, 'presupuestosEdit'])->name('edit');
        Route::put('/{id}', [TesoreroController::class, 'presupuestosUpdate'])->name('update');
        Route::delete('/{id}', [TesoreroController::class, 'presupuestosDestroy'])->name('destroy');
        Route::get('/seguimiento', [TesoreroController::class, 'presupuestosSeguimiento'])->name('seguimiento');
        Route::post('/{id}/duplicar', [TesoreroController::class, 'presupuestosDuplicar'])->name('duplicar');
        Route::prefix('exportar')->name('exportar.')->group(function () {
            Route::post('/excel', [TesoreroController::class, 'presupuestosExportarExcel'])->name('excel');
            Route::post('/pdf', [TesoreroController::class, 'presupuestosExportarPDF'])->name('pdf');
        });
    });
    
    // MOVIMIENTOS Y TRANSACCIONES
    Route::prefix('movimientos')->name('movimientos.')->group(function () {
        Route::get('/', [TesoreroController::class, 'movimientos'])->name('index');
        Route::get('/{id}', [TesoreroController::class, 'verDetalle'])->name('detalle');
    });
    
    // REPORTES Y ESTADÍSTICAS
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/', [TesoreroController::class, 'reportes'])->name('index');
        Route::match(['get', 'post'], '/generar', [TesoreroController::class, 'generarReporte'])->name('generar');
        Route::get('/mensual', [TesoreroController::class, 'reporteMensual'])->name('mensual');
        Route::get('/anual', [TesoreroController::class, 'reporteAnual'])->name('anual');
        Route::post('/exportar/{tipo?}', [TesoreroController::class, 'exportar'])->name('exportar');
    });
    
    // ESTADÍSTICAS PERSONALES
    Route::get('/mis-transacciones', [TesoreroController::class, 'misTransacciones'])->name('mis-transacciones');
    Route::get('/mis-estadisticas', [TesoreroController::class, 'misEstadisticas'])->name('mis-estadisticas');
    
    // APIs para funcionalidades del dashboard
    Route::get('/mis-notificaciones', [TesoreroController::class, 'obtenerMisNotificaciones'])->name('api.mis-notificaciones');
    Route::post('/marcar-notificacion-leida/{id}', [TesoreroController::class, 'marcarNotificacionLeida'])->name('api.marcar-leida');
    Route::post('/marcar-todas-leidas', [TesoreroController::class, 'marcarTodasNotificacionesLeidas'])->name('api.marcar-todas-leidas');
    Route::get('/mis-membresias', [TesoreroController::class, 'obtenerMisMembresías'])->name('api.mis-membresias');
    Route::post('/solicitar-renovacion', [TesoreroController::class, 'procesarRenovacion'])->name('api.solicitar-renovacion');
    Route::post('/eliminar-pago-historial', [TesoreroController::class, 'eliminarPagoHistorial'])->name('api.eliminar-pago');
    Route::post('/limpiar-historial', [TesoreroController::class, 'limpiarHistorial'])->name('api.limpiar-historial');
    Route::post('/guardar-recordatorio', [TesoreroController::class, 'guardarRecordatorio'])->name('api.guardar-recordatorio');
    
    // AJAX autocomplete para membresías
    Route::get('/membresias/suggestions', [TesoreroController::class, 'membresiasSuggestions'])->name('membresias.suggestions');
});

// ============================================================================
// RUTAS DEL MÓDULO SECRETARÍA
// ============================================================================
Route::prefix('secretaria')->name('secretaria.')->middleware(['auth', 'check.first.login', RoleMiddleware::class . ':Secretario|Presidente|Super Admin'])->group(function () {
    // Dashboard principal
    Route::get('/dashboard', [SecretariaController::class, 'dashboard'])->name('dashboard');
    Route::get('/calendario', [SecretariaController::class, 'calendario'])->name('calendario');
    
    // Consultas
    Route::get('/consultas', [SecretariaController::class, 'consultas'])->name('consultas');
    Route::get('/consultas/pendientes', [SecretariaController::class, 'consultasPendientes'])->name('consultas.pendientes');
    Route::get('/consultas/recientes', [SecretariaController::class, 'consultasRecientes'])->name('consultas.recientes');
    Route::get('/consultas/exportar/pdf', [SecretariaController::class, 'exportarConsultasPDF'])->name('consultas.exportar.pdf');
    Route::get('/consultas/exportar/word', [SecretariaController::class, 'exportarConsultasWord'])->name('consultas.exportar.word');
    Route::get('/consultas/{id}', [SecretariaController::class, 'getConsulta']);
    Route::post('/consultas/{id}/responder', [SecretariaController::class, 'responderConsulta']);
    Route::delete('/consultas/{id}', [SecretariaController::class, 'eliminarConsulta']);
    
    // Actas
    Route::get('/actas', [SecretariaController::class, 'actas'])->name('actas.index');
    Route::get('/actas/{id}', [SecretariaController::class, 'getActa']);
    Route::get('/actas/{id}/descargar', [SecretariaController::class, 'descargarActa'])->name('actas.descargar');
    Route::post('/actas', [SecretariaController::class, 'storeActa']);
    Route::post('/actas/{id}', [SecretariaController::class, 'updateActa']);
    Route::delete('/actas/{id}', [SecretariaController::class, 'eliminarActa']);
    
    // Diplomas
    Route::get('/diplomas', [SecretariaController::class, 'diplomas'])->name('diplomas.index');
    Route::get('/diplomas/{id}', [SecretariaController::class, 'getDiploma']);
    Route::get('/diplomas/{id}/descargar', [SecretariaController::class, 'descargarDiploma'])->name('diplomas.descargar');
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
    
    // Reportes avanzados con Stored Procedures
    Route::post('/reportes/diplomas', [SecretariaController::class, 'reporteDiplomas'])->name('reportes.diplomas');
    Route::post('/reportes/documentos/buscar', [SecretariaController::class, 'buscarDocumentos'])->name('reportes.documentos.buscar');
    Route::post('/reportes/actas/resumen', [SecretariaController::class, 'resumenActas'])->name('reportes.actas.resumen');
    
    // Notificaciones
    Route::get('/notificaciones', [SecretariaController::class, 'notificaciones'])->name('notificaciones');
    Route::post('/notificaciones/{id}/marcar-leida', [SecretariaController::class, 'marcarNotificacionLeida'])->name('notificaciones.marcar-leida');
    Route::get('/notificaciones/verificar', [SecretariaController::class, 'verificarActualizaciones'])->name('notificaciones.verificar');
    Route::post('/notificaciones/marcar-todas-leidas', [SecretariaController::class, 'marcarTodasNotificacionesLeidas'])->name('notificaciones.marcar-todas-leidas');
    
    // Asistencias
    Route::get('/asistencias', [SecretariaController::class, 'gestionAsistencias'])->name('asistencias');
    Route::get('/eventos/{id}/asistencias', [SecretariaController::class, 'obtenerAsistenciasEvento']);
    Route::post('/asistencias', [SecretariaController::class, 'registrarAsistencia']);
    Route::put('/asistencias/{id}', [SecretariaController::class, 'actualizarAsistencia']);
    Route::delete('/asistencias/{id}', [SecretariaController::class, 'eliminarAsistencia']);
});

// ============================================================================
// RUTAS API DEL CALENDARIO (SECRETARIA)
// ============================================================================
Route::prefix('api/secretaria/calendario')->middleware(['auth', 'check.first.login'])->group(function () {
    Route::get('/eventos', [SecretariaController::class, 'obtenerEventos']);
    Route::post('/eventos', [SecretariaController::class, 'crearEvento']);
    Route::put('/eventos/{id}', [SecretariaController::class, 'actualizarEvento']);
    Route::delete('/eventos/{id}', [SecretariaController::class, 'eliminarEvento']);
    Route::patch('/eventos/{id}/fechas', [SecretariaController::class, 'actualizarFechas']);
    Route::get('/miembros', [SecretariaController::class, 'obtenerMiembros']);
    Route::get('/eventos/{id}/asistencias', [SecretariaController::class, 'obtenerAsistenciasEvento']);
    Route::post('/asistencias', [SecretariaController::class, 'registrarAsistencia']);
    Route::put('/asistencias/{id}', [SecretariaController::class, 'actualizarAsistencia']);
    Route::delete('/asistencias/{id}', [SecretariaController::class, 'eliminarAsistencia']);
});

// ============================================================================
// RUTAS DEL MÓDULO VOCERO
// ============================================================================
Route::prefix('vocero')->middleware(['auth', 'check.first.login', RoleMiddleware::class . ':Vocero|Presidente|Super Admin'])->name('vocero.')->group(function () {
    Route::get('/', [VoceroController::class, 'index'])->name('index');
    Route::get('/bienvenida', [VoceroController::class, 'welcome'])->name('bienvenida');
    Route::get('/calendario', [VoceroController::class, 'calendario'])->name('calendario');
    Route::get('/dashboard', [VoceroController::class, 'dashboard'])->name('dashboard');
    Route::get('/notificaciones', [VoceroController::class, 'notificaciones'])->name('notificaciones');
    Route::post('/notificaciones/{id}/marcar-leida', [VoceroController::class, 'marcarNotificacionLeida'])->name('notificaciones.marcar-leida');
    Route::post('/notificaciones/marcar-todas-leidas', [VoceroController::class, 'marcarTodasNotificacionesLeidas'])->name('notificaciones.marcar-todas-leidas');
    Route::get('/notificaciones/verificar', [VoceroController::class, 'verificarActualizaciones'])->name('notificaciones.verificar');
    Route::get('/asistencias', [VoceroController::class, 'gestionAsistencias'])->name('asistencias');
    Route::get('/eventos', [VoceroController::class, 'gestionEventos'])->name('eventos');
    Route::get('/reportes', [VoceroController::class, 'reportesAnalisis'])->name('reportes');
});

// ============================================================================
// RUTAS API DEL CALENDARIO (VOCERO)
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
    // RUTAS DE REPORTES Y ESTADÍSTICAS
    Route::get('/reportes/estadisticas-generales', [VoceroController::class, 'obtenerEstadisticasGenerales']);
    Route::get('/reportes/detallado', [VoceroController::class, 'obtenerReporteDetallado']);
    Route::get('/reportes/evento/{id}', [VoceroController::class, 'obtenerReporteEvento']);
    Route::get('/reportes/miembro/{id}', [VoceroController::class, 'obtenerEstadisticasMiembro']);
    Route::post('/reportes/buscar-por-fecha', [VoceroController::class, 'buscarEventosPorFecha']);
    Route::get('/reportes/graficos', [VoceroController::class, 'obtenerDatosGraficos']);
});

// ============================================================================
// RUTAS DEL MÓDULO SOCIO/ASPIRANTE (CORREGIDO: RUTAS DE SECRETARÍA Y VOCERÍA)
// ============================================================================
Route::prefix('socio')->middleware(['auth', 'check.first.login', RoleMiddleware::class . ':Aspirante|Vocero|Secretario|Tesorero|Vicepresidente|Presidente|Super Admin'])->name('socio.')->group(function () {
    
    // Dashboard principal
    Route::get('/dashboard', [SocioController::class, 'dashboard'])->name('dashboard');
    
    // Notificaciones
    Route::get('/notificaciones', [SocioController::class, 'notificaciones'])->name('notificaciones');
    Route::post('/notificaciones/{id}/marcar-leida', [SocioController::class, 'marcarNotificacionLeida'])->name('notificaciones.marcar-leida');
    Route::post('/notificaciones/marcar-todas-leidas', [SocioController::class, 'marcarTodasNotificacionesLeidas'])->name('notificaciones.marcar-todas-leidas');
    Route::get('/notificaciones/verificar', [SocioController::class, 'verificarActualizaciones'])->name('notificaciones.verificar');
    
    // Calendario (solo lectura)
    Route::get('/calendario', [SocioController::class, 'calendario'])->name('calendario');
    Route::get('/calendario/eventos/{year}/{month}', [SocioController::class, 'obtenerEventosCalendario'])->name('calendario.eventos');
    
    // Mis Proyectos
    Route::get('/proyectos', [SocioController::class, 'misProyectos'])->name('proyectos');
    Route::get('/proyectos/{id}', [SocioController::class, 'detalleProyecto'])->name('proyectos.detalle');
    
    // Mis Reuniones
    Route::get('/reuniones', [SocioController::class, 'misReuniones'])->name('reuniones');
    Route::get('/reuniones/{id}', [SocioController::class, 'detalleReunion'])->name('reuniones.detalle');
    
    // Comunicación con Secretaría
    Route::prefix('comunicacion-secretaria')->name('secretaria.')->group(function () {
        Route::get('/', [SocioController::class, 'comunicacionSecretaria'])->name('index');
        Route::get('/crear', [SocioController::class, 'crearConsultaSecretaria'])->name('crear');
        Route::post('/store', [SocioController::class, 'storeConsultaSecretaria'])->name('store');
        Route::get('/{id}', [SocioController::class, 'verConsultaSecretaria'])->name('ver');
        Route::post('/{id}/responder', [SocioController::class, 'responderConsultaSecretaria'])->name('responder');
    });
    
    // Comunicación con Vocalía
    Route::prefix('comunicacion-voceria')->name('voceria.')->group(function () {
        Route::get('/', [SocioController::class, 'comunicacionVoceria'])->name('index');
        Route::get('/crear', [SocioController::class, 'crearConsultaVoceria'])->name('crear');
        Route::post('/store', [SocioController::class, 'storeConsultaVoceria'])->name('store');
        Route::get('/{id}', [SocioController::class, 'verConsultaVoceria'])->name('ver');
    });
    
    // Blog de Notas Personales
    Route::prefix('notas')->name('notas.')->group(function () {
        Route::get('/', [SocioController::class, 'blogNotas'])->name('index');
        Route::get('/crear', [SocioController::class, 'crearNota'])->name('crear');
        Route::post('/store', [SocioController::class, 'storeNota'])->name('store');
        Route::get('/{id}', [SocioController::class, 'verNota'])->name('ver');
        Route::get('/{id}/editar', [SocioController::class, 'editarNota'])->name('editar');
        Route::put('/{id}', [SocioController::class, 'updateNota'])->name('update');
        Route::delete('/{id}', [SocioController::class, 'eliminarNota'])->name('eliminar');
    });
    
    // Perfil del socio/aspirante
    Route::get('/perfil', [SocioController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [SocioController::class, 'actualizarPerfil'])->name('perfil.actualizar');
});

// ============================================================================
// RUTAS DE AUTENTICACIÓN (Laravel Breeze)
// ============================================================================
require __DIR__.'/auth.php';