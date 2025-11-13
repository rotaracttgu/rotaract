<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BitacoraSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Determina el módulo actual basado en la ruta
     */
    private function getModuloActual()
    {
        $routeName = request()->route()->getName();
        
        if (str_starts_with($routeName, 'presidente.')) {
            return 'presidente';
        } elseif (str_starts_with($routeName, 'vicepresidente.')) {
            return 'vicepresidente';
        } else {
            return 'admin';
        }
    }

    /**
     * Obtiene la ruta de listado según el módulo
     */
    private function getListaRoute()
    {
        $modulo = $this->getModuloActual();
        return $modulo . '.usuarios.lista';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // if (!auth()->user()->can('ver usuarios')) {
            //     abort(403, 'No tienes permisos para ver usuarios');
            // }

            // Obtener todos los usuarios con paginación
            $usuarios = User::orderBy('created_at', 'desc')->paginate(10);
            
            // Contar total de usuarios
            $totalUsuarios = User::count();
            
            // Pasar el módulo actual a la vista
            $moduloActual = $this->getModuloActual();
            
            // Determinar la vista según el módulo
            $vista = $moduloActual === 'admin' 
                ? 'modulos.users.index' 
                : "modulos.{$moduloActual}.usuarios";
            
            return view($vista, compact('usuarios', 'totalUsuarios', 'moduloActual'));
            
        } catch (\Exception $e) {
            $moduloActual = $this->getModuloActual();
            $vista = $moduloActual === 'admin' 
                ? 'modulos.users.index' 
                : "modulos.{$moduloActual}.usuarios";
                
            return view($vista, [
                'usuarios' => collect([]),
                'totalUsuarios' => 0,
                'moduloActual' => $moduloActual,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $moduloActual = $this->getModuloActual();
        return view('modulos.users.create', compact('moduloActual'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'email_verified' => ['nullable', 'boolean'],
            'two_factor_verified' => ['nullable', 'boolean'], // Nuevo campo para el checkbox
            'role' => ['required', 'string', 'exists:roles,name'],
            'rotary_id' => ['nullable', 'string', 'max:50'],
            'fecha_juramentacion' => ['nullable', 'date'],
            'fecha_cumpleaños' => ['nullable', 'date'],
            'activo' => ['nullable', 'boolean'],
        ]);

        try {
            // Generar contraseña automática aleatoria
            $passwordAleatorio = \Illuminate\Support\Str::random(12) . rand(100, 999);
            
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($passwordAleatorio),
                'email_verified_at' => $request->email_verified ? now() : null,
                'first_login' => true,
                'two_factor_enabled' => true, // Mantener 2FA habilitado por defecto
                'two_factor_verified_at' => $request->two_factor_verified ? now() : null, // Setear si checkbox está marcado
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
                    'two_factor_verified' => $request->two_factor_verified ? true : false, // Nuevo
                    'rotary_id' => $request->rotary_id,
                    'fecha_juramentacion' => $request->fecha_juramentacion,
                    'fecha_cumpleaños' => $request->fecha_cumpleaños,
                    'activo' => $user->activo,
                ],
            ]);

            return redirect()->route($this->getListaRoute())
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
     * Display the specified resource.
     */
    public function show($usuario)
    {
        // Buscar el usuario por ID
        $usuario = User::findOrFail($usuario);
        
        // ⭐ REGISTRAR EN BITÁCORA
        BitacoraSistema::registrar([
            'accion' => 'view',
            'modulo' => 'usuarios',
            'tabla' => 'users',
            'registro_id' => $usuario->id,
            'descripcion' => "Visualización del perfil de usuario: {$usuario->name}",
            'estado' => 'exitoso',
        ]);
        
        $moduloActual = $this->getModuloActual();
        return view('modulos.users.ver', compact('usuario', 'moduloActual'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($usuario)
    {
        // Buscar el usuario por ID
        $usuario = User::findOrFail($usuario);
        $moduloActual = $this->getModuloActual();
        return view('modulos.users.edit', compact('usuario', 'moduloActual'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $usuario)
    {
        // Buscar el usuario por ID
        $usuario = User::findOrFail($usuario);
        
        // ⭐ GUARDAR DATOS ANTERIORES PARA BITÁCORA
        $datosAnteriores = [
            'name' => $usuario->name,
            'email' => $usuario->email,
            'role' => $usuario->getRolPrincipal(),
            'email_verified' => $usuario->email_verified_at ? true : false,
            'two_factor_verified' => $usuario->two_factor_verified_at ? true : false, // Nuevo
            'rotary_id' => $usuario->rotary_id,
            'fecha_juramentacion' => $usuario->fecha_juramentacion,
            'fecha_cumpleaños' => $usuario->fecha_cumpleaños,
            'activo' => $usuario->activo ?? true,
        ];
        
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $usuario->id],
            'email_verified' => ['nullable', 'boolean'],
            'two_factor_verified' => ['nullable', 'boolean'], // Nuevo campo para el checkbox
            'role' => ['nullable', 'string', 'exists:roles,name'],
            'rotary_id' => ['nullable', 'string', 'max:50'],
            'fecha_juramentacion' => ['nullable', 'date'],
            'fecha_cumpleaños' => ['nullable', 'date'],
            'activo' => ['nullable', 'boolean'],
        ];

        // Solo validar contraseña si se proporciona
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        $request->validate($rules);

        try {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'rotary_id' => $request->rotary_id,
                'fecha_juramentacion' => $request->fecha_juramentacion,
                'fecha_cumpleaños' => $request->fecha_cumpleaños,
                'activo' => $request->has('activo') ? (bool)$request->activo : false,
            ];

            // Actualizar contraseña solo si se proporciona
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            // Manejar verificación de email
            if ($request->email_verified && !$usuario->email_verified_at) {
                $userData['email_verified_at'] = now();
            } elseif (!$request->email_verified && $usuario->email_verified_at) {
                $userData['email_verified_at'] = null;
            }

            // Manejar verificación 2FA
            if ($request->two_factor_verified && !$usuario->two_factor_verified_at) {
                $userData['two_factor_verified_at'] = now();
            } elseif (!$request->two_factor_verified && $usuario->two_factor_verified_at) {
                $userData['two_factor_verified_at'] = null;
            }

            $usuario->update($userData);

            if ($request->has('role') && (auth()->user()->can('gestionar roles') || auth()->user()->hasRole('Super Admin'))) {
                if ($request->role) {
                    $usuario->syncRoles([$request->role]);
                } else {
                    $usuario->syncRoles([]);
                }
            }

            // ⭐ PREPARAR DATOS NUEVOS PARA BITÁCORA
            $datosNuevos = [
                'name' => $usuario->name,
                'email' => $usuario->email,
                'role' => $request->role ?? $usuario->getRolPrincipal(),
                'email_verified' => $request->email_verified ? true : false,
                'two_factor_verified' => $request->two_factor_verified ? true : false, // Nuevo
                'rotary_id' => $request->rotary_id,
                'fecha_juramentacion' => $request->fecha_juramentacion,
                'fecha_cumpleaños' => $request->fecha_cumpleaños,
                'activo' => $request->has('activo') ? (bool)$request->activo : false,
            ];

            if ($request->filled('password')) {
                $datosNuevos['password_changed'] = true;
            }

            // ⭐ REGISTRAR EN BITÁCORA
            BitacoraSistema::registrar([
                'accion' => 'update',
                'modulo' => 'usuarios',
                'tabla' => 'users',
                'registro_id' => $usuario->id,
                'descripcion' => "Usuario actualizado: {$usuario->name} ({$usuario->email})",
                'estado' => 'exitoso',
                'datos_anteriores' => $datosAnteriores,
                'datos_nuevos' => $datosNuevos,
            ]);
            
            return redirect()->route($this->getListaRoute())
                ->with('success', 'Usuario actualizado exitosamente.')
                ->with('usuario_actualizado', $usuario->name);

        } catch (\Exception $e) {
            // ⭐ REGISTRAR ERROR EN BITÁCORA
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
     * Remove the specified resource from storage.
     */
    public function destroy($usuario)
    {
        try {
            // Buscar el usuario por ID
            $usuario = User::findOrFail($usuario);
            $userName = $usuario->name;
            $userEmail = $usuario->email;
            $userRole = $usuario->getRolPrincipal();
            $userId = $usuario->id;

            // ⭐ REGISTRAR EN BITÁCORA ANTES DE ELIMINAR
            BitacoraSistema::registrar([
                'accion' => 'delete',
                'modulo' => 'usuarios',
                'tabla' => 'users',
                'registro_id' => $userId,
                'descripcion' => "Usuario eliminado: {$userName} ({$userEmail})",
                'estado' => 'exitoso',
                'datos_anteriores' => [
                    'name' => $userName,
                    'email' => $userEmail,
                    'role' => $userRole,
                ],
            ]);

            $usuario->delete();

            return redirect()->route($this->getListaRoute())
                ->with('success', 'Usuario eliminado exitosamente.')
                ->with('usuario_eliminado', $userName);

        } catch (\Exception $e) {
            // ⭐ REGISTRAR ERROR EN BITÁCORA
            if (isset($usuario)) {
                BitacoraSistema::registrar([
                    'accion' => 'delete',
                    'modulo' => 'usuarios',
                    'tabla' => 'users',
                    'registro_id' => $usuario->id ?? null,
                    'descripcion' => "Error al eliminar usuario",
                    'estado' => 'fallido',
                    'error_mensaje' => $e->getMessage(),
                ]);
            }

            return back()->withErrors(['error' => 'Error al eliminar el usuario: ' . $e->getMessage()]);
        }
    }

    /**
     * Get user statistics for dashboard
     */
    public function getStats()
    {
        try {
            $stats = [
                'total_usuarios' => User::count(),
                'usuarios_verificados' => User::whereNotNull('email_verified_at')->count(),
                'usuarios_no_verificados' => User::whereNull('email_verified_at')->count(),
                'usuarios_recientes' => User::where('created_at', '>=', now()->subDays(7))->count(),
                'usuarios_hoy' => User::whereDate('created_at', today())->count(),
                'usuarios_con_2fa' => User::where('two_factor_enabled', true)->count(),
            ];

            return response()->json($stats);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}