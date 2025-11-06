<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BitacoraSistema;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard del Super Admin
     */
    public function index()
    {
        // ============================================
        // ESTADÍSTICAS DE USUARIOS (Tu código original)
        // ============================================
        
        // Total de usuarios
        $totalUsuarios = User::count();

        // Usuarios verificados
        $usuariosVerificados = User::whereNotNull('email_verified_at')->count();

        // Usuarios pendientes (sin verificar)
        $usuariosPendientes = User::whereNull('email_verified_at')->count();

        // Porcentaje de usuarios verificados
        $porcentajeVerificados = $totalUsuarios > 0 
            ? round(($usuariosVerificados / $totalUsuarios) * 100, 1) 
            : 0;

        // Usuarios nuevos este mes
        $usuariosNuevos = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Roles activos en el sistema
        $rolesActivos = Role::count();

        // Últimos 5 usuarios registrados
        $ultimosUsuarios = User::latest()
            ->take(5)
            ->get();

        // Distribución de usuarios por rol
        $usuariosPorRol = $this->obtenerDistribucionRoles();

        // ============================================
        // ESTADÍSTICAS DE BITÁCORA (NUEVO)
        // ============================================
        
        $bitacoraStats = $this->obtenerEstadisticasBitacora();

        return view('modulos.admin.dashboard', compact(
            'totalUsuarios',
            'usuariosVerificados',
            'usuariosPendientes',
            'porcentajeVerificados',
            'usuariosNuevos',
            'rolesActivos',
            'ultimosUsuarios',
            'usuariosPorRol',
            'bitacoraStats' // NUEVO
        ));
    }

    /**
     * Obtener estadísticas de la bitácora (VERSIÓN SEGURA - CORREGIDO)
     */
    private function obtenerEstadisticasBitacora()
    {
        try {
            $hoy = Carbon::today();
            $semanaAtras = Carbon::now()->subDays(7);
            $mesAtras = Carbon::now()->subDays(30);

            return [
                // Eventos de hoy
                'eventos_hoy' => BitacoraSistema::whereDate('fecha_hora', $hoy)->count() ?? 0,
                
                // Logins de hoy
                'logins_hoy' => BitacoraSistema::where('accion', 'login')
                    ->whereDate('fecha_hora', $hoy)
                    ->count() ?? 0,
                
                // Errores de hoy
                'errores_hoy' => BitacoraSistema::where('estado', 'fallido')
                    ->whereDate('fecha_hora', $hoy)
                    ->count() ?? 0,
                
                // Total de eventos
                'total_eventos' => BitacoraSistema::count() ?? 0,
                
                // Eventos esta semana
                'eventos_semana' => BitacoraSistema::where('fecha_hora', '>=', $semanaAtras)->count() ?? 0,
                
                // Eventos este mes
                'eventos_mes' => BitacoraSistema::where('fecha_hora', '>=', $mesAtras)->count() ?? 0,
                
                // Logins exitosos del mes
                'logins_exitosos_mes' => BitacoraSistema::where('accion', 'login')
                    ->where('estado', 'exitoso')
                    ->where('fecha_hora', '>=', $mesAtras)
                    ->count() ?? 0,
                
                // Logins fallidos del mes
                'logins_fallidos_mes' => BitacoraSistema::where('accion', 'login_fallido')
                    ->where('fecha_hora', '>=', $mesAtras)
                    ->count() ?? 0,
                
                // Actividad por acción (últimos 7 días)
                'por_accion' => BitacoraSistema::select('accion', DB::raw('count(*) as total'))
                    ->where('fecha_hora', '>=', $semanaAtras)
                    ->whereNotNull('accion')
                    ->groupBy('accion')
                    ->orderBy('total', 'desc')
                    ->get() ?? collect(),
                
                // Actividad por módulo (últimos 7 días)
                'por_modulo' => BitacoraSistema::select('modulo', DB::raw('count(*) as total'))
                    ->where('fecha_hora', '>=', $semanaAtras)
                    ->whereNotNull('modulo')
                    ->groupBy('modulo')
                    ->orderBy('total', 'desc')
                    ->limit(5)
                    ->get() ?? collect(),
                
                // Usuarios más activos (últimos 7 días)
                'usuarios_activos' => BitacoraSistema::select(
                        'usuario_nombre', 
                        'user_id', 
                        DB::raw('count(*) as total')
                    )
                    ->where('fecha_hora', '>=', $semanaAtras)
                    ->whereNotNull('user_id')
                    ->groupBy('usuario_nombre', 'user_id')
                    ->orderBy('total', 'desc')
                    ->limit(5)
                    ->get() ?? collect(),
                
                // Últimos 5 eventos
                'ultimos_eventos' => BitacoraSistema::with('user')
                    ->orderBy('fecha_hora', 'desc')
                    ->limit(5)
                    ->get() ?? collect(),
            ];
        } catch (\Exception $e) {
            // Si hay error, retornar valores por defecto vacíos
            \Log::error('Error al obtener estadísticas de bitácora: ' . $e->getMessage());
            
            return [
                'eventos_hoy' => 0,
                'logins_hoy' => 0,
                'errores_hoy' => 0,
                'total_eventos' => 0,
                'eventos_semana' => 0,
                'eventos_mes' => 0,
                'logins_exitosos_mes' => 0,
                'logins_fallidos_mes' => 0,
                'por_accion' => collect(),
                'por_modulo' => collect(),
                'usuarios_activos' => collect(),
                'ultimos_eventos' => collect(),
            ];
        }
    }

    /**
     * Obtener la distribución de usuarios por rol con colores y porcentajes
     */
    private function obtenerDistribucionRoles()
    {
        $roles = Role::withCount('users')->get();
        $totalUsuarios = User::count();

        $distribucion = collect();

        // Colores para cada rol
        $coloresRol = [
            'Super Admin' => [
                'color' => 'bg-red-500',
                'colorBarra' => 'bg-red-500'
            ],
            'Presidente' => [
                'color' => 'bg-blue-500',
                'colorBarra' => 'bg-blue-500'
            ],
            'Vicepresidente' => [
                'color' => 'bg-indigo-500',
                'colorBarra' => 'bg-indigo-500'
            ],
            'Tesorero' => [
                'color' => 'bg-emerald-500',
                'colorBarra' => 'bg-emerald-500'
            ],
            'Secretario' => [
                'color' => 'bg-purple-500',
                'colorBarra' => 'bg-purple-500'
            ],
            'Vocero' => [
                'color' => 'bg-amber-500',
                'colorBarra' => 'bg-amber-500'
            ],
            'Aspirante' => [
                'color' => 'bg-gray-500',
                'colorBarra' => 'bg-gray-500'
            ],
        ];

        foreach ($roles as $rol) {
            $porcentaje = $totalUsuarios > 0 
                ? round(($rol->users_count / $totalUsuarios) * 100, 1) 
                : 0;

            $colores = $coloresRol[$rol->name] ?? [
                'color' => 'bg-gray-500',
                'colorBarra' => 'bg-gray-500'
            ];

            $distribucion->push((object)[
                'nombre' => $rol->name,
                'cantidad' => $rol->users_count,
                'porcentaje' => $porcentaje,
                'color' => $colores['color'],
                'colorBarra' => $colores['colorBarra']
            ]);
        }

        // Ordenar por cantidad (mayor a menor)
        return $distribucion->sortByDesc('cantidad')->values();
    }

    /**
     * Obtener estadísticas adicionales (para futuras implementaciones)
     */
    public function obtenerEstadisticas()
    {
        return [
            'usuarios_activos_hoy' => User::whereDate('last_login_at', Carbon::today())->count(),
            'usuarios_activos_semana' => User::whereBetween('last_login_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count(),
            'usuarios_activos_mes' => User::whereMonth('last_login_at', Carbon::now()->month)
                ->whereYear('last_login_at', Carbon::now()->year)
                ->count(),
            'crecimiento_mensual' => $this->calcularCrecimientoMensual(),
        ];
    }

    /**
     * Calcular el crecimiento mensual de usuarios
     */
    private function calcularCrecimientoMensual()
    {
        $mesActual = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $mesAnterior = User::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        if ($mesAnterior == 0) {
            return $mesActual > 0 ? 100 : 0;
        }

        return round((($mesActual - $mesAnterior) / $mesAnterior) * 100, 1);
    }

    /**
     * Obtener gráfico de usuarios por mes (últimos 6 meses)
     */
    public function obtenerGraficoUsuarios()
    {
        $meses = collect();
        
        for ($i = 5; $i >= 0; $i--) {
            $fecha = Carbon::now()->subMonths($i);
            $cantidad = User::whereMonth('created_at', $fecha->month)
                ->whereYear('created_at', $fecha->year)
                ->count();

            $meses->push([
                'mes' => $fecha->format('M Y'),
                'cantidad' => $cantidad
            ]);
        }

        return $meses;
    }

    /**
     * Obtener actividad de bitácora por hora (últimas 24 horas) - CORREGIDO
     */
    public function obtenerActividadPorHora()
    {
        try {
            return BitacoraSistema::select(
                    DB::raw('HOUR(fecha_hora) as hora'),
                    DB::raw('count(*) as total')
                )
                ->where('fecha_hora', '>=', Carbon::now()->subDay())
                ->groupBy('hora')
                ->orderBy('hora')
                ->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    /**
     * Obtener resumen de seguridad (CORREGIDO)
     */
    public function obtenerResumenSeguridad()
    {
        try {
            $hace7dias = Carbon::now()->subDays(7);

            return [
                'intentos_fallidos' => BitacoraSistema::where('accion', 'login_fallido')
                    ->where('fecha_hora', '>=', $hace7dias)
                    ->count(),
                
                'ips_sospechosas' => BitacoraSistema::where('accion', 'login_fallido')
                    ->where('fecha_hora', '>=', $hace7dias)
                    ->select('ip_address', DB::raw('count(*) as intentos'))
                    ->groupBy('ip_address')
                    ->having('intentos', '>', 5)
                    ->get(),
                
                'cambios_password' => BitacoraSistema::where('accion', 'cambio_password')
                    ->where('fecha_hora', '>=', $hace7dias)
                    ->count(),
            ];
        } catch (\Exception $e) {
            return [
                'intentos_fallidos' => 0,
                'ips_sospechosas' => collect(),
                'cambios_password' => 0,
            ];
        }
    }

    /**
     * Muestra el calendario del Admin
     */
    public function calendario()
    {
        return view('modulos.admin.calendario');
    }

    /**
     * Mostrar el centro de notificaciones del Super Admin
     */
    public function notificaciones()
    {
        $notificacionService = app(\App\Services\NotificacionService::class);
        
        // Obtener todas las notificaciones del usuario actual
        $notificaciones = $notificacionService->obtenerTodas(auth()->id(), 50);
        
        // Contar notificaciones no leídas
        $noLeidas = $notificaciones->where('leida', false)->count();
        
        return view('modulos.admin.notificaciones', compact('notificaciones', 'noLeidas'));
    }

    /**
     * Marcar una notificación como leída
     */
    public function marcarNotificacionLeida($id)
    {
        $notificacionService = app(\App\Services\NotificacionService::class);
        $notificacionService->marcarComoLeida($id);
        
        return response()->json(['success' => true]);
    }

    /**
     * Marcar todas las notificaciones como leídas
     */
    public function marcarTodasNotificacionesLeidas()
    {
        $notificacionService = app(\App\Services\NotificacionService::class);
        $notificacionService->marcarTodasComoLeidas(auth()->id());
        
        return response()->json(['success' => true]);
    }
}
