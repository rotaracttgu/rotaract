<?php

namespace App\Http\Controllers\Admin\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Método AJAX para cargar la vista completa de roles
     */
    public function ajaxIndex()
    {
        \Log::info('🔵 RoleController::ajaxIndex - Iniciado');
        \Log::info('🔵 Headers:', [
            'ajax' => request()->ajax(),
            'wantsJson' => request()->wantsJson(),
            'X-Requested-With' => request()->header('X-Requested-With')
        ]);
        
        // Optimizado con eager loading para evitar N+1 queries
        $roles = Role::with(['permissions:id,name', 'users:id,name'])
            ->withCount('users')
            ->orderBy('name')
            ->paginate(10);
        
        \Log::info('🔵 Roles cargados: ' . $roles->count());
        
        // Indicar que es AJAX para la vista
        $isAjax = true;
        
        // Si es petición AJAX, devolver solo el contenido HTML sin layout
        if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            \Log::info('🔵 Detectado como AJAX - Renderizando vista sin layout');
            $html = view('modulos.admin.configuracion.roles.index', compact('roles', 'isAjax'))->render();
            \Log::info('🔵 HTML generado - longitud: ' . strlen($html));
            return response($html)
                ->header('Content-Type', 'text/html; charset=UTF-8')
                ->header('X-AJAX-Response', 'true');
        }
        
        // Si no es AJAX, devolver vista completa con layout
        \Log::info('🔵 NO detectado como AJAX - Renderizando vista completa');
        $isAjax = false;
        return view('modulos.admin.configuracion.roles.index', compact('roles', 'isAjax'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy(function($permission) {
            $parts = explode('.', $permission->name);
            return $parts[0] ?? 'general';
        });
        
        // Si es petición AJAX, devolver solo el contenido HTML sin layout
        if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            $html = view('modulos.admin.configuracion.roles.create', compact('permissions'))->render();
            return response($html)
                ->header('Content-Type', 'text/html; charset=UTF-8')
                ->header('X-AJAX-Response', 'true');
        }
        
        return view('modulos.admin.configuracion.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'guard_name' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ], [
            'name.required' => 'El nombre del rol es obligatorio',
            'name.unique' => 'Ya existe un rol con este nombre',
            'permissions.*.exists' => 'Uno o más permisos seleccionados no son válidos'
        ]);

        try {
            DB::beginTransaction();
            
            $role = Role::create([
                'name' => $validated['name'],
                'guard_name' => $validated['guard_name'] ?? 'web'
            ]);

            if (!empty($validated['permissions'])) {
                $permissions = Permission::whereIn('id', $validated['permissions'])->get();
                $role->syncPermissions($permissions);
            }

            DB::commit();

            // Si es petición AJAX, devolver JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rol creado exitosamente',
                    'role' => $role->load('permissions')
                ]);
            }

            return redirect()->route('admin.configuracion.roles.ajax')
                ->with('success', 'Rol creado exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Si es petición AJAX, devolver JSON de error
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el rol: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withInput()
                ->with('error', 'Error al crear el rol: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $role->load('permissions', 'users');
        
        // Si es petición AJAX, devolver solo el contenido HTML sin layout
        if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            $html = view('modulos.admin.configuracion.roles.show', compact('role'))->render();
            return response($html)
                ->header('Content-Type', 'text/html; charset=UTF-8')
                ->header('X-AJAX-Response', 'true');
        }
        
        return view('modulos.admin.configuracion.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        if ($role->name === 'Super Admin') {
            // Si es AJAX, devolver JSON de error
            if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'El rol Super Admin no puede ser editado'
                ], 403);
            }
            return back()->with('warning', 'El rol Super Admin no puede ser editado');
        }

        $permissions = Permission::all()->groupBy(function($permission) {
            $parts = explode('.', $permission->name);
            return $parts[0] ?? 'general';
        });
        
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        // Si es petición AJAX, devolver solo el contenido HTML sin layout
        if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            $html = view('modulos.admin.configuracion.roles.edit', compact('role', 'permissions', 'rolePermissions'))->render();
            return response($html)
                ->header('Content-Type', 'text/html; charset=UTF-8')
                ->header('X-AJAX-Response', 'true');
        }
        
        return view('modulos.admin.configuracion.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        if ($role->name === 'Super Admin') {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'El rol Super Admin no puede ser modificado'
                ], 403);
            }
            return back()->with('warning', 'El rol Super Admin no puede ser modificado');
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($role->id)
            ],
            'guard_name' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ], [
            'name.required' => 'El nombre del rol es obligatorio',
            'name.unique' => 'Ya existe un rol con este nombre',
            'permissions.*.exists' => 'Uno o más permisos seleccionados no son válidos'
        ]);

        try {
            DB::beginTransaction();
            
            $role->update([
                'name' => $validated['name'],
                'guard_name' => $validated['guard_name'] ?? 'web'
            ]);

            if (isset($validated['permissions'])) {
                $permissions = Permission::whereIn('id', $validated['permissions'])->get();
                $role->syncPermissions($permissions);
            } else {
                $role->syncPermissions([]);
            }

            DB::commit();

            // Si es petición AJAX, devolver JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rol actualizado exitosamente',
                    'role' => $role->load('permissions')
                ]);
            }

            return redirect()->route('admin.configuracion.roles.ajax')
                ->with('success', 'Rol actualizado exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Si es petición AJAX, devolver JSON de error
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el rol: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withInput()
                ->with('error', 'Error al actualizar el rol: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Role $role)
    {
        $rolesProtegidos = ['Super Admin', 'Presidente', 'Vicepresidente', 'Tesorero', 'Secretario', 'Vocero', 'Aspirante'];
        
        if (in_array($role->name, $rolesProtegidos)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este rol no puede ser eliminado por ser un rol del sistema'
                ], 403);
            }
            return back()->with('warning', 'Este rol no puede ser eliminado por ser un rol del sistema');
        }

        if ($role->users()->count() > 0) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el rol porque tiene ' . $role->users()->count() . ' usuarios asignados'
                ], 400);
            }
            return back()->with('warning', 'No se puede eliminar el rol porque tiene usuarios asignados');
        }

        try {
            $role->delete();
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Rol eliminado exitosamente'
                ]);
            }
            
            return redirect()->route('admin.configuracion.roles.ajax')
                ->with('success', 'Rol eliminado exitosamente');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el rol: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Error al eliminar el rol: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar formulario para asignar permisos a un rol por módulo
     */
    public function mostrarAsignarPermisos(Role $role)
    {
        // Agrupar permisos por módulo
        $permisosPorModulo = Permission::all()->groupBy(function($permission) {
            $parts = explode('.', $permission->name);
            return $parts[0] ?? 'general';
        });
        
        // Obtener IDs de permisos actuales del rol
        $permisosActuales = $role->permissions->pluck('id')->toArray();
        
        // Mapeo de nombres de módulos a nombres legibles
        $nombresModulos = [
            'dashboard' => 'Dashboard',
            'usuarios' => 'Usuarios',
            'miembros' => 'Miembros',
            'proyectos' => 'Proyectos',
            'presidente' => 'Presidente',
            'vicepresidente' => 'Vicepresidente',
            'tesorero' => 'Tesorero',
            'secretaria' => 'Secretaría',
            'vocero' => 'Vocero',
            'socio' => 'Socio',
            'finanzas' => 'Finanzas',
            'eventos' => 'Eventos',
            'asistencias' => 'Asistencias',
            'actas' => 'Actas',
            'comunicaciones' => 'Comunicaciones',
            'reportes' => 'Reportes',
            'configuracion' => 'Configuración',
            'roles' => 'Roles',
            'permisos' => 'Permisos',
            'bitacora' => 'Bitácora',
            'backup' => 'Backup',
            'general' => 'General'
        ];
        
        // Si es petición AJAX, devolver solo el contenido HTML sin layout
        if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            $html = view('modulos.admin.configuracion.roles.asignar-permisos', compact(
                'role',
                'permisosPorModulo',
                'permisosActuales',
                'nombresModulos'
            ))->render();
            
            return response($html)
                ->header('Content-Type', 'text/html; charset=UTF-8')
                ->header('X-AJAX-Response', 'true');
        }
        
        // Si no es AJAX, devolver vista completa (normalmente no debería llegar aquí)
        return view('modulos.admin.configuracion.roles.asignar-permisos', compact(
            'role',
            'permisosPorModulo',
            'permisosActuales',
            'nombresModulos'
        ));
    }

    /**
     * Asignar permisos a un rol
     */
    public function asignarPermisos(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        try {
            if (isset($validated['permissions']) && !empty($validated['permissions'])) {
                $permissions = Permission::whereIn('id', $validated['permissions'])->get();
                $role->syncPermissions($permissions);
            } else {
                // Si no hay permisos seleccionados, quitar todos
                $role->syncPermissions([]);
            }

            // Si es AJAX, devolver JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permisos actualizados exitosamente'
                ]);
            }

            return redirect()->route('admin.configuracion.roles.ajax')
                ->with('success', 'Permisos asignados exitosamente');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al asignar permisos: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Error al asignar permisos: ' . $e->getMessage());
        }
    }
}