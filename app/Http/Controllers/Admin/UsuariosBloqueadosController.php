<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsuariosBloqueadosController extends Controller
{
    /**
     * Mostrar lista de usuarios bloqueados
     */
    public function index()
    {
        $usuariosBloqueados = User::where('is_locked', true)
            ->with('roles')
            ->orderBy('locked_until', 'desc')
            ->paginate(15);

        $usuariosConIntentos = User::where('failed_login_attempts', '>', 0)
            ->where('is_locked', false)
            ->with('roles')
            ->orderBy('failed_login_attempts', 'desc')
            ->paginate(15);

        return view('modulos.users.usuarios-bloqueados.index', compact('usuariosBloqueados', 'usuariosConIntentos'));
    }

    /**
     * Desbloquear un usuario
     */
    public function desbloquear($id)
    {
        $user = User::findOrFail($id);
        
        if (!$user->is_locked) {
            return redirect()->back()->with('warning', 'Este usuario no está bloqueado.');
        }

        $user->unlock();

        return redirect()->back()->with('success', "La cuenta de {$user->name} ha sido desbloqueada exitosamente.");
    }

    /**
     * Resetear intentos fallidos de un usuario
     */
    public function resetearIntentos($id)
    {
        $user = User::findOrFail($id);
        
        $user->resetLoginAttempts();

        return redirect()->back()->with('success', "Los intentos fallidos de {$user->name} han sido reseteados.");
    }

    /**
     * Desbloquear todos los usuarios bloqueados
     */
    public function desbloquearTodos()
    {
        $usuarios = User::where('is_locked', true)->get();
        
        foreach ($usuarios as $user) {
            $user->unlock();
        }

        return redirect()->back()->with('success', "Se han desbloqueado {$usuarios->count()} cuentas.");
    }
}