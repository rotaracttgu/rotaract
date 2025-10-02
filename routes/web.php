<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
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

require __DIR__.'/auth.php';