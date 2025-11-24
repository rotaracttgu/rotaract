<?php

namespace App\Http\Controllers\Admin\Configuracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    /**
     * Método AJAX para cargar la vista completa de permisos
     */
    public function ajaxIndex()
    {
        // Optimizado con eager loading
        $permissions = Permission::with('roles:id,name')
            ->orderBy('name')
            ->paginate(20);
            
        $permissionsGrouped = Permission::with('roles:id,name')
            ->get()
            ->groupBy(function($permission) {
                $parts = explode('.', $permission->name);
                return $parts[0] ?? 'general';
            });
        
        // Indicar que es AJAX para la vista
        $isAjax = true;
        
        // Si es petición AJAX, devolver solo el contenido HTML sin layout
        if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            $html = view('modulos.admin.configuracion.permisos.index', compact('permissions', 'permissionsGrouped', 'isAjax'))->render();
            return response($html)
                ->header('Content-Type', 'text/html; charset=UTF-8')
                ->header('X-AJAX-Response', 'true')
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, proxy-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }
        
        // Si no es AJAX, devolver vista completa con layout
        $isAjax = false;
        return view('modulos.admin.configuracion.permisos.index', compact('permissions', 'permissionsGrouped', 'isAjax'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        
        $modulos = [
            'dashboard' => 'Dashboard',
            'usuarios' => 'Usuarios',
            'roles' => 'Roles',
            'permisos' => 'Permisos',
            'miembros' => 'Miembros',
            'proyectos' => 'Proyectos',
            'finanzas' => 'Finanzas',
            'eventos' => 'Eventos',
            'asistencias' => 'Asistencias',
            'actas' => 'Actas',
            'comunicaciones' => 'Comunicaciones',
            'reportes' => 'Reportes',
            'configuracion' => 'Configuración',
            'bitacora' => 'Bitácora',
            'backup' => 'Backup'
        ];
        
        // Si es petición AJAX, devolver solo el contenido HTML sin layout
        if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            $isAjax = true;
            $html = view('modulos.admin.configuracion.permisos.create', compact('roles', 'modulos', 'isAjax'))->render();
            return response($html)
                ->header('Content-Type', 'text/html; charset=UTF-8')
                ->header('X-AJAX-Response', 'true');
        }
        
        $isAjax = false;
        return view('modulos.admin.configuracion.permisos.create', compact('roles', 'modulos', 'isAjax'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'guard_name' => 'nullable|string|max:255',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id'
        ], [
            'name.required' => 'El nombre del permiso es obligatorio',
            'name.unique' => 'Ya existe un permiso con este nombre',
            'roles.*.exists' => 'Uno o más roles seleccionados no son válidos'
        ]);

        try {
            DB::beginTransaction();
            
            $permission = Permission::create([
                'name' => $validated['name'],
                'guard_name' => $validated['guard_name'] ?? 'web'
            ]);

            if (!empty($validated['roles'])) {
                $roles = Role::whereIn('id', $validated['roles'])->get();
                $permission->assignRole($roles);
            }

            DB::commit();

            // Si es petición AJAX, devolver JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permiso creado exitosamente',
                    'permission' => $permission->load('roles')
                ]);
            }

            return redirect()->route('admin.configuracion.permisos.ajax')
                ->with('success', 'Permiso creado exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Si es petición AJAX, devolver JSON de error
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el permiso: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withInput()
                ->with('error', 'Error al crear el permiso: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permiso)
    {
        $permiso->load('roles');
        return view('modulos.admin.configuracion.permisos.show', compact('permiso'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permiso)
    {
        $roles = Role::all();
        $permisoRoles = $permiso->roles->pluck('id')->toArray();
        
        // Si es petición AJAX, devolver solo el contenido HTML sin layout
        if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            $isAjax = true;
            $html = view('modulos.admin.configuracion.permisos.edit', compact('permiso', 'roles', 'permisoRoles', 'isAjax'))->render();
            return response($html)
                ->header('Content-Type', 'text/html; charset=UTF-8')
                ->header('X-AJAX-Response', 'true');
        }
        
        $isAjax = false;
        return view('modulos.admin.configuracion.permisos.edit', compact('permiso', 'roles', 'permisoRoles', 'isAjax'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permiso)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions', 'name')->ignore($permiso->id)
            ],
            'guard_name' => 'nullable|string|max:255',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id'
        ], [
            'name.required' => 'El nombre del permiso es obligatorio',
            'name.unique' => 'Ya existe un permiso con este nombre',
            'roles.*.exists' => 'Uno o más roles seleccionados no son válidos'
        ]);

        try {
            DB::beginTransaction();
            
            $permiso->update([
                'name' => $validated['name'],
                'guard_name' => $validated['guard_name'] ?? 'web'
            ]);

            if (isset($validated['roles'])) {
                $roles = Role::whereIn('id', $validated['roles'])->get();
                $permiso->syncRoles($roles);
            } else {
                $permiso->syncRoles([]);
            }

            DB::commit();

            // Si es petición AJAX, devolver JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permiso actualizado exitosamente',
                    'permission' => $permiso->load('roles')
                ]);
            }

            return redirect()->route('admin.configuracion.permisos.ajax')
                ->with('success', 'Permiso actualizado exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Si es petición AJAX, devolver JSON de error
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el permiso: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withInput()
                ->with('error', 'Error al actualizar el permiso: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Permission $permiso)
    {
        try {
            DB::table('role_has_permissions')->where('permission_id', $permiso->id)->delete();
            DB::table('model_has_permissions')->where('permission_id', $permiso->id)->delete();
            
            $permiso->delete();
            
            // Si es petición AJAX, devolver JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permiso eliminado exitosamente'
                ]);
            }
            
            return redirect()->route('admin.configuracion.permisos.ajax')
                ->with('success', 'Permiso eliminado exitosamente');
        } catch (\Exception $e) {
            // Si es petición AJAX, devolver JSON de error
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el permiso: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Error al eliminar el permiso: ' . $e->getMessage());
        }
    }
}