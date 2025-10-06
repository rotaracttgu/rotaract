<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Aspirante\AspiranteController;
use App\Http\Controllers\VoceroController;
use App\Http\Controllers\TesoreroController;
// 🚨 Importaciones de los nuevos controladores
use App\Http\Controllers\VicepresidenteController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Rutas de perfil
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('perfil.editar');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('perfil.actualizar');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('perfil.eliminar');

    // Rutas para gestión de usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.lista');
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('usuarios.crear');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.guardar');
    Route::get('/usuarios/{usuario}', [UserController::class, 'show'])->name('usuarios.ver');
    Route::get('/usuarios/{usuario}/editar', [UserController::class, 'edit'])->name('usuarios.editar');
    Route::put('/usuarios/{usuario}', [UserController::class, 'update'])->name('usuarios.actualizar');
    Route::delete('/usuarios/{usuario}', [UserController::class, 'destroy'])->name('usuarios.eliminar');
});

// Rutas del módulo aspirante
Route::prefix('aspirante')->middleware('auth')->name('aspirante.')->group(function () {
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

// Rutas del módulo vocero
Route::prefix('vocero')->middleware('auth')->name('vocero.')->group(function () {
    Route::get('/', [VoceroController::class, 'index'])->name('index');
    Route::get('/bienvenida', [VoceroController::class, 'welcome'])->name('bienvenida');
    Route::get('/calendario', [VoceroController::class, 'calendario'])->name('calendario');
    Route::get('/dashboard', [VoceroController::class, 'dashboard'])->name('dashboard');
    Route::get('/asistencias', [VoceroController::class, 'gestionAsistencias'])->name('asistencias');
    Route::get('/eventos', [VoceroController::class, 'gestionEventos'])->name('eventos');
    Route::get('/reportes', [VoceroController::class, 'reportesAnalisis'])->name('reportes');
});

// Rutas del módulo tesorero
Route::prefix('tesorero')->middleware('auth')->name('tesorero.')->group(function () {
    Route::get('/', [TesoreroController::class, 'welcome'])->name('welcome');
    Route::get('/dashboard', [TesoreroController::class, 'index'])->name('index');
    Route::get('/calendario', [TesoreroController::class, 'calendario'])->name('calendario');
    Route::get('/finanzas', [TesoreroController::class, 'finanzas'])->name('finanzas');
});

// ---
// 🚨 Rutas para el Módulo Vicepresidente (NUEVAS)
Route::prefix('vicepresidente')->middleware('auth')->name('vicepresidente.')->group(function () {

    // Rutas del VicepresidenteController (vistas de la imagen)
    Route::get('dashboard', [VicepresidenteController::class, 'dashboard'])->name('dashboard');
    Route::get('asistencia/proyectos', [VicepresidenteController::class, 'asistenciaProyectos'])->name('asistencia.proyectos');
    Route::get('asistencia/reuniones', [VicepresidenteController::class, 'asistenciaReuniones'])->name('asistencia.reuniones');
    Route::get('cartas/formales', [VicepresidenteController::class, 'cartasFormales'])->name('cartas.formales');
    Route::get('cartas/patrocinio', [VicepresidenteController::class, 'cartasPatrocinio'])->name('cartas.patrocinio');

    // Rutas para el Nuevo Módulo de Reportes (Vicepresidente)
    Route::get('reportes/dashboard', [ReporteController::class, 'dashboard'])->name('reportes.dashboard');
    Route::get('reportes/mensuales', [ReporteController::class, 'mensuales'])->name('reportes.mensuales');
});

// ---

require __DIR__.'/auth.php';