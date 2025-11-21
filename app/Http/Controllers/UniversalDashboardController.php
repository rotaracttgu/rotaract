<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Miembro;
use App\Models\Proyecto;
use App\Models\Evento;
use App\Models\Acta;

class UniversalDashboardController extends Controller
{
    /**
     * Dashboard universal que se adapta a los permisos del usuario
     */
    public function index()
    {
        $user = Auth::user();
        
        // Obtener todos los permisos del usuario
        $permissions = $user->getAllPermissions()->pluck('name')->toArray();
        
        // Agrupar permisos por módulo
        $modules = $this->groupPermissionsByModule($permissions);
        
        // Obtener estadísticas según los permisos
        $stats = $this->getStatsForUser($permissions);
        
        // Obtener actividades recientes según permisos
        $recentActivities = $this->getRecentActivities($permissions);
        
        return view('modulos.universal.dashboard', compact('modules', 'stats', 'recentActivities', 'user'));
    }
    
    /**
     * Agrupar permisos por módulo
     */
    private function groupPermissionsByModule($permissions)
    {
        $modules = [];
        
        foreach ($permissions as $permission) {
            // Detectar el módulo (antes del punto o del guion)
            if (str_contains($permission, '.')) {
                $parts = explode('.', $permission);
            } elseif (str_contains($permission, '-')) {
                $parts = explode('-', $permission, 2);
            } else {
                continue;
            }
            
            $action = $parts[0] ?? '';
            $module = $parts[1] ?? '';
            
            // Normalizar el nombre del módulo
            if (in_array($action, ['ver', 'crear', 'editar', 'eliminar', 'aprobar', 'exportar', 'bloquear'])) {
                // Formato: ver-miembros → módulo: miembros, acción: ver
                if (!isset($modules[$module])) {
                    $modules[$module] = [
                        'name' => $module,
                        'display_name' => ucfirst($module),
                        'actions' => [],
                        'icon' => $this->getModuleIcon($module),
                        'route' => $this->getModuleRoute($module)
                    ];
                }
                $modules[$module]['actions'][] = $action;
            } else {
                // Formato: miembros.ver → módulo: miembros, acción: ver
                $module = $action;
                $action = $parts[1] ?? '';
                
                if (!isset($modules[$module])) {
                    $modules[$module] = [
                        'name' => $module,
                        'display_name' => ucfirst($module),
                        'actions' => [],
                        'icon' => $this->getModuleIcon($module),
                        'route' => $this->getModuleRoute($module)
                    ];
                }
                $modules[$module]['actions'][] = $action;
            }
        }
        
        return $modules;
    }
    
    /**
     * Obtener estadísticas según los permisos del usuario
     */
    private function getStatsForUser($permissions)
    {
        $stats = [];
        
        try {
            // Verificar cada tipo de permiso y obtener estadísticas
            if ($this->hasModulePermission($permissions, 'miembros')) {
                $stats['miembros'] = [
                    'total' => Miembro::count(),
                    'activos' => Miembro::whereNotNull('FechaIngreso')->count(),
                    'icon' => 'users',
                    'color' => 'blue'
                ];
            }
            
            if ($this->hasModulePermission($permissions, 'proyectos')) {
                $stats['proyectos'] = [
                    'total' => Proyecto::count(),
                    'activos' => Proyecto::where('estado', 'En progreso')->count(),
                    'icon' => 'briefcase',
                    'color' => 'green'
                ];
            }
            
            if ($this->hasModulePermission($permissions, 'usuarios')) {
                $stats['usuarios'] = [
                    'total' => User::count(),
                    'activos' => User::where('is_blocked', false)->count(),
                    'icon' => 'user-circle',
                    'color' => 'purple'
                ];
            }
            
            if ($this->hasModulePermission($permissions, 'eventos')) {
                $stats['eventos'] = [
                    'total' => Evento::count(),
                    'proximos' => Evento::where('fecha', '>=', now())->count(),
                    'icon' => 'calendar',
                    'color' => 'orange'
                ];
            }
            
            if ($this->hasModulePermission($permissions, 'actas')) {
                $stats['actas'] = [
                    'total' => Acta::count(),
                    'pendientes' => Acta::where('estado', 'Borrador')->count(),
                    'icon' => 'document-text',
                    'color' => 'indigo'
                ];
            }
        } catch (\Exception $e) {
            // Si hay error en las estadísticas, continuar sin ellas
            // Esto previene errores por columnas inexistentes
            Log::warning('Error obteniendo estadísticas del dashboard: ' . $e->getMessage());
        }
        
        return $stats;
    }
    
    /**
     * Verificar si el usuario tiene algún permiso del módulo
     */
    private function hasModulePermission($permissions, $module)
    {
        foreach ($permissions as $permission) {
            if (str_contains($permission, $module)) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Obtener actividades recientes según permisos
     */
    private function getRecentActivities($permissions)
    {
        $activities = [];
        
        // Aquí podrías implementar un sistema de actividades/bitácora
        // Por ahora retornamos un array vacío
        
        return $activities;
    }
    
    /**
     * Obtener icono del módulo
     */
    private function getModuleIcon($module)
    {
        $icons = [
            'usuarios' => 'user-circle',
            'miembros' => 'users',
            'proyectos' => 'briefcase',
            'finanzas' => 'currency-dollar',
            'eventos' => 'calendar',
            'asistencias' => 'clipboard-check',
            'actas' => 'document-text',
            'comunicaciones' => 'mail',
            'reportes' => 'chart-bar',
            'roles' => 'shield-check',
            'permisos' => 'lock-closed',
            'configuracion' => 'cog',
            'backup' => 'database',
            'bitacora' => 'clock',
            'dashboard' => 'home'
        ];
        
        return $icons[$module] ?? 'folder';
    }
    
    /**
     * Obtener ruta del módulo (basado en permisos, no en roles)
     */
    private function getModuleRoute($module)
    {
        $routes = [
            // Usuarios: usa ruta UNIVERSAL (funciona para todos los roles)
            'usuarios' => 'universal.usuarios.lista',
            'miembros' => 'universal.usuarios.lista',  // Miembros redirige a usuarios

            // Proyectos
            'proyectos' => 'presidente.estado.proyectos',

            // Eventos y Calendario
            'eventos' => 'presidente.dashboard',   // Dashboard tiene calendario

            // Actas
            'actas' => 'secretaria.dashboard',     // Secretaría maneja actas

            // Finanzas
            'finanzas' => 'tesorero.dashboard',

            // Comunicaciones y Cartas
            'comunicaciones' => 'presidente.cartas.formales',
            'cartas' => 'presidente.cartas.formales',

            // Roles y Permisos (solo Super Admin - mantener admin)
            'roles' => 'admin.configuracion.roles.ajax',
            'permisos' => 'admin.configuracion.permisos.ajax',
            'configuracion' => 'admin.configuracion.roles.ajax',

            // Asistencias
            'asistencias' => 'vocero.dashboard',

            // Reportes
            'reportes' => 'presidente.dashboard',

            // Backup y Bitácora (solo Super Admin - mantener admin)
            'backup' => 'admin.backup.index',
            'bitacora' => 'admin.bitacora.index',

            // Dashboard
            'dashboard' => 'dashboard',
        ];

        return $routes[$module] ?? '#';
    }
}
