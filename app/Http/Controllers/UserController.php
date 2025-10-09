<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use App\Services\UsuarioServicio;

class UserController extends Controller
{
    protected $usuarioServicio;
    
        public function __construct(UsuarioServicio $usuarioServicio)
        {
            $this->usuarioServicio = $usuarioServicio;
        }
    /**
     * Mostrar listado de usuarios
     */
    public function index(Request $request)
    {
        try {
            // Verificar permisos
            // if (!auth()->user()->can('ver usuarios')) {
            //     abort(403, 'No tienes permisos para ver usuarios');
            // }

            // Obtener parámetros de la petición
            $opciones = [
                'pagina' => $request->get('page', 1),
                'por_pagina' => $request->get('per_page', 10),
                'ordenar_por' => $request->get('order_by', 'created_at'),
                'direccion_orden' => $request->get('order_direction', 'desc'),
            ];
            
            // Si hay búsqueda
            if ($request->has('buscar') && $request->filled('buscar')) {
                $resultadoBusqueda = $this->usuarioServicio->buscarUsuarios(
                    $request->get('buscar'),
                    $opciones
                );
                
                return view('users.index', [
                    'usuarios' => $resultadoBusqueda['usuarios'],
                    'totalUsuarios' => $resultadoBusqueda['total'],
                    'terminoBusqueda' => $request->get('buscar')
                ]);
            }
            
            // Obtener usuarios paginados usando procedimientos almacenados
            $usuarios = $this->usuarioServicio->obtenerUsuariosPaginados($opciones);
            
            // Obtener total de usuarios
            $totalUsuarios = $this->usuarioServicio->contarUsuarios();
            
            // Obtener estadísticas (opcional)
            $estadisticas = $this->usuarioServicio->obtenerEstadisticas();
            
            return view('users.index', compact('usuarios', 'totalUsuarios', 'estadisticas'));
            
        } catch (\Exception $e) {
            \Log::error('Error en UserController@index: ' . $e->getMessage());
            
            return view('users.index', [
                'usuarios' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10),
                'totalUsuarios' => 0,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'email_verified' => ['nullable', 'boolean'],
            'role' => ['required', 'string', 'exists:roles,name'],
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'email_verified_at' => $request->email_verified ? now() : null,
            ]);

            // ===== HABILITAR 2FA AUTOMÁTICAMENTE =====
            $user->two_factor_enabled = true;
            $user->save();
            // =========================================

            // ===== ASIGNAR ROL AL USUARIO =====
            if ($request->role) {
                $user->assignRole($request->role);
            }
            // ==================================

            return redirect()->route('admin.usuarios.lista')
                ->with('success', 'Usuario creado exitosamente con autenticación de dos factores habilitada.')
                ->with('usuario_creado', $user->name);

        } catch (\Exception $e) {
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
        return view('users.ver', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($usuario)
    {
        // Buscar el usuario por ID
        $usuario = User::findOrFail($usuario);
        return view('users.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $usuario)
    {
        // Buscar el usuario por ID
        $usuario = User::findOrFail($usuario);
        
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $usuario->id],
            'email_verified' => ['nullable', 'boolean'],
            'role' => ['nullable', 'string', 'exists:roles,name'],
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

            $usuario->update($userData);

            if ($request->has('role') && (auth()->user()->can('gestionar roles') || auth()->user()->hasRole('administrador'))) {
                if ($request->role) {
                    $usuario->syncRoles([$request->role]);
                } else {
                    $usuario->syncRoles([]);
                }
            }
            
            return redirect()->route('admin.usuarios.lista')
                ->with('success', 'Usuario actualizado exitosamente.')
                ->with('usuario_actualizado', $usuario->name);

        } catch (\Exception $e) {
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
            $usuario->delete();

            return redirect()->route('admin.usuarios.lista')
                ->with('success', 'Usuario eliminado exitosamente.')
                ->with('usuario_eliminado', $userName);

        } catch (\Exception $e) {
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