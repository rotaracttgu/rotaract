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
        $permissions = Permission::with('roles')
            ->orderBy('name')
            ->paginate(20);
            
        $permissionsGrouped = Permission::all()->groupBy(function($permission) {
            $parts = explode('.', $permission->name);
            return $parts[0] ?? 'general';
        });
        
        // Si es petición AJAX, devolver solo el contenido
        if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            return view('modulos.admin.configuracion.permisos.index', compact('permissions', 'permissionsGrouped'))->render();
        }
        
        // Si no es AJAX, devolver vista completa
        return view('modulos.admin.configuracion.permisos.index', compact('permissions', 'permissionsGrouped'));
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
        
        return view('modulos.admin.configuracion.permisos.create', compact('roles', 'modulos'));
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

            return redirect()->route('admin.configuracion.permisos.ajax')
                ->with('success', 'Permiso creado exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
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
        
        return view('modulos.admin.configuracion.permisos.edit', compact('permiso', 'roles', 'permisoRoles'));
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

            return redirect()->route('admin.configuracion.permisos.ajax')
                ->with('success', 'Permiso actualizado exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al actualizar el permiso: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permiso)
    {
        try {
            DB::table('role_has_permissions')->where('permission_id', $permiso->id)->delete();
            DB::table('model_has_permissions')->where('permission_id', $permiso->id)->delete();
            
            $permiso->delete();
            
            return redirect()->route('admin.configuracion.permisos.ajax')
                ->with('success', 'Permiso eliminado exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el permiso: ' . $e->getMessage());
        }
    }
}