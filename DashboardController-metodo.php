<?php

/**
 * MÉTODO PARA AGREGAR AL DashboardController
 * 
 * Ubicación: app/Http/Controllers/Admin/DashboardController.php
 * 
 * INSTRUCCIONES:
 * 1. Abre el archivo DashboardController.php
 * 2. Copia este método completo
 * 3. Pégalo DESPUÉS del método index() existente
 * 4. Asegúrate de que las importaciones estén al inicio del archivo
 */

// ============================================================================
// IMPORTACIONES NECESARIAS (Agregar al inicio del archivo si no existen)
// ============================================================================
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

// ============================================================================
// MÉTODO PARA EL DASHBOARD CON PESTAÑAS
// ============================================================================

/**
 * Dashboard con sistema de pestañas para Super Admin
 * Muestra estadísticas generales y acceso a todos los módulos
 */
public function indexTabs();
{
    try {
        // ====================================================================
        // ESTADÍSTICAS DE USUARIOS
        // ====================================================================
        
        // Total de usuarios en el sistema
        $totalUsuarios = User::count();
        
        // Usuarios verificados (con email confirmado)
        $verificados = User::whereNotNull('email_verified_at')->count();
        
        // Usuarios pendientes de verificación
        $pendientes = User::whereNull('email_verified_at')->count();
        
        // Nuevos usuarios este mes
        $nuevosEsteMes = User::whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->count();
        
        // Calcular porcentaje de verificados
        $porcentajeVerificados = $totalUsuarios > 0 
            ? round(($verificados / $totalUsuarios) * 100, 1) 
            : 0;
        
        // Contar roles activos (roles que tienen usuarios asignados)
        $rolesActivos = Role::has('users')->count();
        
        // ====================================================================
        // ESTADÍSTICAS DE ACTIVIDAD DEL SISTEMA
        // ====================================================================
        
        // Eventos registrados hoy en la bitácora
        $eventosHoy = DB::table('bitacora')
                        ->whereDate('created_at', today())
                        ->count();
        
        // Logins exitosos hoy
        $loginsHoy = DB::table('bitacora')
                       ->where('accion', 'LIKE', '%login%')
                       ->whereDate('created_at', today())
                       ->count();
        
        // Errores hoy (ajusta según tu estructura de logs)
        // Puedes modificar esto según cómo registres los errores
        $erroresHoy = DB::table('bitacora')
                        ->where('tipo', 'error')
                        ->whereDate('created_at', today())
                        ->count();
        
        // Total de eventos históricos
        $totalEventos = DB::table('bitacora')->count();
        
        // ====================================================================
        // RETORNAR VISTA CON DATOS
        // ====================================================================
        
        return view('modulos.admin.dashboard-nuevo', compact(
            // Estadísticas de usuarios
            'totalUsuarios',
            'verificados',
            'pendientes',
            'nuevosEsteMes',
            'porcentajeVerificados',
            'rolesActivos',
            
            // Estadísticas de actividad
            'eventosHoy',
            'loginsHoy',
            'erroresHoy',
            'totalEventos'
        ));
        
    } catch (\Exception $e) {
        // ====================================================================
        // MANEJO DE ERRORES
        // ====================================================================
        
        // Registrar error en logs
        \Log::error('Error en dashboard con pestañas: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        
        // Retornar vista con valores por defecto y mensaje de error
        return view('modulos.admin.dashboard-nuevo', [
            // Valores por defecto para estadísticas
            'totalUsuarios' => 0,
            'verificados' => 0,
            'pendientes' => 0,
            'nuevosEsteMes' => 0,
            'porcentajeVerificados' => 0,
            'rolesActivos' => 0,
            'eventosHoy' => 0,
            'loginsHoy' => 0,
            'erroresHoy' => 0,
            'totalEventos' => 0,
            
            // Mensaje de error para mostrar al usuario
            'error' => 'Error al cargar las estadísticas: ' . $e->getMessage()
        ]);
    }
};

// ============================================================================
// FIN DEL MÉTODO
// ============================================================================

/**
 * NOTAS ADICIONALES:
 * 
 * 1. Si tu tabla de bitácora tiene un nombre diferente, cámbialo en las queries
 * 2. Ajusta los campos según tu estructura de base de datos
 * 3. Puedes agregar más estadísticas según necesites
 * 4. Los errores se registran automáticamente en storage/logs/laravel.log
 * 
 * EJEMPLO DE ESTADÍSTICAS ADICIONALES:
 * 
 * // Usuarios por rol
 * $usuariosPorRol = User::select('roles.name', DB::raw('count(*) as total'))
 *     ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
 *     ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
 *     ->groupBy('roles.name')
 *     ->get();
 * 
 * // Usuarios más activos
 * $usuariosActivos = DB::table('bitacora')
 *     ->select('user_id', DB::raw('count(*) as actividad'))
 *     ->whereDate('created_at', '>=', now()->subDays(7))
 *     ->groupBy('user_id')
 *     ->orderByDesc('actividad')
 *     ->limit(5)
 *     ->get();
 */
