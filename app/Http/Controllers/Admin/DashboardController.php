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

        return view('users.dashboard', compact(
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
     * Obtener estadísticas de la bitácora (NUEVO)
     */
    private function obtenerEstadisticasBitacora()
    {
        $hoy = Carbon::today();
        $semanaAtras = Carbon::now()->subDays(7);
        $mesAtras = Carbon::now()->subDays(30);

        return [
            // Eventos de hoy
            'eventos_hoy' => BitacoraSistema::whereDate('fecha_hora', $hoy)->count(),
            
            // Logins de hoy
            'logins_hoy' => BitacoraSistema::where('accion', 'login')
                ->whereDate('fecha_hora', $hoy)
                ->count(),
            
            // Errores de hoy
            'errores_hoy' => BitacoraSistema::where('estado', 'fallido')
                ->whereDate('fecha_hora', $hoy)
                ->count(),
            
            // Total de eventos
            'total_eventos' => BitacoraSistema::count(),
            
            // Eventos esta semana
            'eventos_semana' => BitacoraSistema::where('fecha_hora', '>=', $semanaAtras)->count(),
            
            // Eventos este mes
            'eventos_mes' => BitacoraSistema::where('fecha_hora', '>=', $mesAtras)->count(),
            
            // Logins exitosos del mes
            'logins_exitosos_mes' => BitacoraSistema::where('accion', 'login')
                ->where('estado', 'exitoso')
                ->where('fecha_hora', '>=', $mesAtras)
                ->count(),
            
            // Logins fallidos del mes
            'logins_fallidos_mes' => BitacoraSistema::where('accion', 'login_fallido')
                ->where('fecha_hora', '>=', $mesAtras)
                ->count(),
            
            // Actividad por acción (últimos 7 días)
            'por_accion' => BitacoraSistema::select('accion', DB::raw('count(*) as total'))
                ->where('fecha_hora', '>=', $semanaAtras)
                ->groupBy('accion')
                ->orderBy('total', 'desc')
                ->get(),
            
            // Actividad por módulo (últimos 7 días)
            'por_modulo' => BitacoraSistema::select('modulo', DB::raw('count(*) as total'))
                ->where('fecha_hora', '>=', $semanaAtras)
                ->groupBy('modulo')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get(),
            
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
                ->get(),
            
            // Últimos 5 eventos
            'ultimos_eventos' => BitacoraSistema::with('user')
                ->orderBy('fecha_hora', 'desc')
                ->limit(5)
                ->get(),
        ];
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
     * Obtener actividad de bitácora por hora (últimas 24 horas) - NUEVO
     */
    public function obtenerActividadPorHora()
    {
        return BitacoraSistema::select(
                DB::raw('HOUR(fecha_hora) as hora'),
                DB::raw('count(*) as total')
            )
            ->where('fecha_hora', '>=', Carbon::now()->subDay())
            ->groupBy('hora')
            ->orderBy('hora')
            ->get();
    }

    /**
     * Obtener resumen de seguridad (NUEVO)
     */
    public function obtenerResumenSeguridad()
    {
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
    }
}