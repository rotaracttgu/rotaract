<?php

namespace App\Http\Controllers\Universal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BitacoraSistema;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * UniversalUsuariosController
 *
 * Controlador genérico para gestión de usuarios que funciona para cualquier rol
 * basándose en permisos en lugar de roles específicos.
 */
class UniversalUsuariosController extends Controller
{
    use AuthorizesRequests;

    /**
     * Lista de usuarios
     */
    public function index()
    {
        $this->authorize('usuarios.ver');
        $usuarios = User::orderBy('created_at', 'desc')->paginate(10);
        $totalUsuarios = User::count();
        return view('modulos.universal.usuarios.index', compact('usuarios', 'totalUsuarios'));
    }

    /**
     * Ver usuario específico
     */
    public function show($usuario)
    {
        $this->authorize('usuarios.ver');
        $usuario = User::findOrFail($usuario);
        $usuarios = User::orderBy('created_at', 'desc')->paginate(10);
        $totalUsuarios = User::count();

        BitacoraSistema::registrar([
            'accion' => 'view',
            'modulo' => 'usuarios',
            'tabla' => 'users',
            'registro_id' => $usuario->id,
            'descripcion' => "Visualización del perfil de usuario: {$usuario->name}",
            'estado' => 'exitoso',
        ]);

        return view('modulos.universal.usuarios.show', compact('usuario', 'usuarios', 'totalUsuarios'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        $this->authorize('usuarios.crear');
        $roles = Role::orderBy('name')->get();
        return view('modulos.universal.usuarios.create', compact('roles'));
    }

    /**
     * Almacenar nuevo usuario
     */
    public function store(Request $request)
    {
        $this->authorize('usuarios.crear');
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'email_verified' => ['nullable', 'boolean'],
            'two_factor_verified' => ['nullable', 'boolean'],
            'role' => ['required', 'string', 'exists:roles,name'],
            'rotary_id' => ['nullable', 'string', 'max:50'],
            'fecha_juramentacion' => ['nullable', 'date'],
            'fecha_cumpleaños' => ['nullable', 'date'],
            'activo' => ['nullable', 'boolean'],
        ]);

        try {
            $passwordAleatorio = \Illuminate\Support\Str::random(12) . rand(100, 999);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $passwordAleatorio,
                'email_verified_at' => $request->email_verified ? now() : null,
                'first_login' => true,
                'two_factor_enabled' => true,
                'two_factor_verified_at' => $request->two_factor_verified ? now() : null,
                'rotary_id' => $request->rotary_id,
                'fecha_juramentacion' => $request->fecha_juramentacion,
                'fecha_cumpleaños' => $request->fecha_cumpleaños,
                'activo' => $request->has('activo') ? (bool)$request->activo : true,
            ]);

            if ($request->role) {
                $user->assignRole($request->role);
            }

            BitacoraSistema::registrar([
                'accion' => 'create',
                'modulo' => 'usuarios',
                'tabla' => 'users',
                'registro_id' => $user->id,
                'descripcion' => "Nuevo usuario creado: {$user->name} ({$user->email}) con rol {$request->role}",
                'estado' => 'exitoso',
                'datos_nuevos' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $request->role,
                    'two_factor_enabled' => true,
                    'email_verified' => $request->email_verified ? true : false,
                    'first_login' => true,
                    'two_factor_verified' => $request->two_factor_verified ? true : false,
                    'rotary_id' => $request->rotary_id,
                    'fecha_juramentacion' => $request->fecha_juramentacion,
                    'fecha_cumpleaños' => $request->fecha_cumpleaños,
                    'activo' => $user->activo,
                ],
            ]);

            return redirect()->route('universal.usuarios.lista')
                ->with('success', "Usuario creado exitosamente. Contraseña temporal: {$passwordAleatorio}. El usuario deberá cambiarla en el primer inicio de sesión.")
                ->with('usuario_creado', $user->name)
                ->with('password_temporal', $passwordAleatorio);

        } catch (\Exception $e) {
            BitacoraSistema::registrar([
                'accion' => 'create',
                'modulo' => 'usuarios',
                'tabla' => 'users',
                'descripcion' => "Error al crear usuario: {$request->name} ({$request->email})",
                'estado' => 'fallido',
                'error_mensaje' => $e->getMessage(),
                'datos_nuevos' => [
                    'name' => $request->name,
                    'email' => $request->email,
                ],
            ]);

            return back()->withInput()
                ->withErrors(['error' => 'Error al crear el usuario: ' . $e->getMessage()]);
        }
    }

    /**
     * Formulario de edición
     */
    public function edit($usuario)
    {
        $this->authorize('usuarios.editar');
        $usuario = User::findOrFail($usuario);
        $roles = Role::orderBy('name')->get();
        return view('modulos.universal.usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, $usuario)
    {
        $this->authorize('usuarios.editar');
        $usuario = User::findOrFail($usuario);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $usuario->id],
            'email_verified' => ['nullable', 'boolean'],
            'two_factor_verified' => ['nullable', 'boolean'],
            'role' => ['required', 'string', 'exists:roles,name'],
            'rotary_id' => ['nullable', 'string', 'max:50'],
            'fecha_juramentacion' => ['nullable', 'date'],
            'fecha_cumpleaños' => ['nullable', 'date'],
            'activo' => ['nullable', 'boolean'],
        ]);

        try {
            $datosAntiguos = $usuario->getAttributes();

            $usuario->update([
                'name' => $request->name,
                'email' => $request->email,
                'email_verified_at' => $request->email_verified ? now() : null,
                'two_factor_verified_at' => $request->two_factor_verified ? now() : null,
                'rotary_id' => $request->rotary_id,
                'fecha_juramentacion' => $request->fecha_juramentacion,
                'fecha_cumpleaños' => $request->fecha_cumpleaños,
                'activo' => $request->has('activo') ? (bool)$request->activo : true,
            ]);

            if ($request->role) {
                $usuario->syncRoles($request->role);
            }

            BitacoraSistema::registrar([
                'accion' => 'update',
                'modulo' => 'usuarios',
                'tabla' => 'users',
                'registro_id' => $usuario->id,
                'descripcion' => "Actualización de usuario: {$usuario->name} ({$usuario->email})",
                'estado' => 'exitoso',
                'datos_antiguos' => $datosAntiguos,
                'datos_nuevos' => $usuario->getAttributes(),
            ]);

            return redirect()->route('universal.usuarios.lista')
                ->with('success', "Usuario {$usuario->name} actualizado correctamente");
        } catch (\Exception $e) {
            BitacoraSistema::registrar([
                'accion' => 'update',
                'modulo' => 'usuarios',
                'tabla' => 'users',
                'registro_id' => $usuario->id,
                'descripcion' => "Error al actualizar usuario: {$usuario->name}",
                'estado' => 'fallido',
                'error_mensaje' => $e->getMessage(),
            ]);

            return back()->withInput()
                ->withErrors(['error' => 'Error al actualizar el usuario: ' . $e->getMessage()]);
        }
    }

    /**
     * Eliminar usuario
     */
    public function destroy($usuario)
    {
        $this->authorize('usuarios.eliminar');
        $usuario = User::findOrFail($usuario);
        $nombre = $usuario->name;

        BitacoraSistema::registrar([
            'accion' => 'delete',
            'modulo' => 'usuarios',
            'tabla' => 'users',
            'registro_id' => $usuario->id,
            'descripcion' => "Usuario {$usuario->name} eliminado",
            'estado' => 'exitoso',
        ]);

        $usuario->delete();

        return redirect()->route('universal.usuarios.lista')
            ->with('success', "Usuario {$nombre} eliminado correctamente");
    }
}
