<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
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

        return view('modulos.superadmin.usuarios.dashboard', compact(
            'totalUsuarios',
            'usuariosVerificados',
            'usuariosPendientes',
            'porcentajeVerificados',
            'usuariosNuevos',
            'rolesActivos',
            'ultimosUsuarios',
            'usuariosPorRol'
        ));
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
}