@extends('layouts.app-admin')

@push('styles')
<style>
    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }
    .progress-bar-animated {
        animation: progress-bar-stripes 1s linear infinite;
    }
    @keyframes progress-bar-stripes {
        0% { background-position: 1rem 0; }
        100% { background-position: 0 0; }
    }
    .badge-status {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.5s ease-out;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-indigo-950 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 bg-gradient-to-r from-red-600 via-pink-600 to-purple-700 rounded-2xl p-4 sm:p-6 lg:p-8 shadow-2xl text-white animate-fade-in">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex-1">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold flex items-center flex-wrap gap-2">
                        <i class="fas fa-crown text-yellow-300 text-xl sm:text-2xl lg:text-3xl"></i>
                        <span>Panel de Administración</span>
                    </h1>
                    <p class="text-red-100 mt-2 sm:mt-3 text-sm sm:text-base lg:text-lg">Bienvenido al panel de control del Super Admin</p>
                    <p class="text-xs sm:text-sm text-red-200 mt-2 flex flex-wrap items-center gap-2 sm:gap-4">
                        <span><i class="far fa-calendar-alt mr-1"></i>{{ now()->format('d/m/Y') }}</span>
                        <span><i class="far fa-clock mr-1"></i>{{ now()->format('H:i') }}</span>
                    </p>
                </div>
                <div class="hidden sm:flex bg-white/20 rounded-full p-3 sm:p-4 backdrop-blur-sm">
                    <i class="fas fa-chart-line text-4xl sm:text-5xl lg:text-6xl text-white"></i>
                </div>
            </div>
        </div>

        <!-- Estadísticas de Usuarios -->
        <div class="mb-8">
            <h2 class="text-xl sm:text-2xl font-bold text-white mb-4 sm:mb-6 flex items-center">
                <i class="fas fa-users mr-2 sm:mr-3 text-blue-400 text-lg sm:text-xl"></i>
                <span>Estadísticas de Usuarios</span>
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Total Usuarios -->
                <div class="stat-card bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-2xl shadow-xl p-4 sm:p-6 text-white">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex-1 min-w-0">
                            <p class="text-blue-200 text-xs uppercase tracking-wide mb-2 font-semibold truncate">Total Usuarios</p>
                            <h3 class="text-3xl sm:text-4xl lg:text-5xl font-bold">{{ $totalUsuarios }}</h3>
                            <p class="text-xs text-blue-200 mt-2 sm:mt-3 flex items-center">
                                <i class="fas fa-chart-line text-green-300 mr-1 flex-shrink-0"></i>
                                <span class="truncate">{{ $rolesActivos }} roles activos</span>
                            </p>
                        </div>
                        <div class="bg-white/20 p-2 sm:p-3 lg:p-4 rounded-xl shadow-md backdrop-blur-sm flex-shrink-0">
                            <i class="fas fa-users text-2xl sm:text-3xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Usuarios Verificados -->
                <div class="stat-card bg-gradient-to-br from-green-600 via-emerald-700 to-teal-800 rounded-2xl shadow-xl p-4 sm:p-6 text-white">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex-1 min-w-0">
                            <p class="text-green-200 text-xs uppercase tracking-wide mb-2 font-semibold truncate">Verificados</p>
                            <h3 class="text-3xl sm:text-4xl lg:text-5xl font-bold">{{ $usuariosVerificados }}</h3>
                            <div class="mt-2 sm:mt-3">
                                <div class="flex items-center justify-between text-xs mb-1.5">
                                    <span class="text-green-200">Progreso</span>
                                    <span class="font-bold text-white">{{ $porcentajeVerificados }}%</span>
                                </div>
                                <div class="w-full bg-white/20 rounded-full h-2 sm:h-2.5 overflow-hidden">
                                    <div class="bg-white h-full rounded-full transition-all duration-500" style="width: {{ $porcentajeVerificados }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white/20 p-2 sm:p-3 lg:p-4 rounded-xl shadow-md backdrop-blur-sm flex-shrink-0">
                            <i class="fas fa-user-check text-2xl sm:text-3xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Usuarios Pendientes -->
                <div class="stat-card bg-gradient-to-br from-orange-600 via-orange-700 to-red-800 rounded-2xl shadow-xl p-4 sm:p-6 text-white">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex-1 min-w-0">
                            <p class="text-orange-200 text-xs uppercase tracking-wide mb-2 font-semibold truncate">Pendientes</p>
                            <h3 class="text-3xl sm:text-4xl lg:text-5xl font-bold">{{ $usuariosPendientes }}</h3>
                            <p class="text-xs text-orange-200 mt-2 sm:mt-3 flex items-center">
                                @if($usuariosPendientes > 0)
                                    <i class="fas fa-exclamation-circle text-yellow-300 mr-1 flex-shrink-0"></i> 
                                    <span class="truncate">Requieren verificación</span>
                                @else
                                    <i class="fas fa-check-circle text-green-300 mr-1 flex-shrink-0"></i> 
                                    <span class="truncate">Todos verificados</span>
                                @endif
                            </p>
                        </div>
                        <div class="bg-white/20 p-2 sm:p-3 lg:p-4 rounded-xl shadow-md backdrop-blur-sm flex-shrink-0">
                            <i class="fas fa-user-clock text-2xl sm:text-3xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Usuarios Nuevos -->
                <div class="stat-card bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-800 rounded-2xl shadow-xl p-4 sm:p-6 text-white">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex-1 min-w-0">
                            <p class="text-purple-200 text-xs uppercase tracking-wide mb-2 font-semibold truncate">Nuevos Este Mes</p>
                            <h3 class="text-3xl sm:text-4xl lg:text-5xl font-bold">{{ $usuariosNuevos }}</h3>
                            <p class="text-xs text-purple-200 mt-2 sm:mt-3 flex items-center">
                                <i class="fas fa-calendar-alt text-purple-300 mr-1 flex-shrink-0"></i>
                                <span class="truncate">{{ now()->format('F Y') }}</span>
                            </p>
                        </div>
                        <div class="bg-white/20 p-2 sm:p-3 lg:p-4 rounded-xl shadow-md backdrop-blur-sm flex-shrink-0">
                            <i class="fas fa-user-plus text-2xl sm:text-3xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas de Bitácora -->
        <div class="mb-8">
            <h2 class="text-xl sm:text-2xl font-bold text-white mb-4 sm:mb-6 flex items-center">
                <i class="fas fa-history mr-2 sm:mr-3 text-indigo-400 text-lg sm:text-xl"></i>
                <span>Actividad del Sistema</span>
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Eventos Hoy -->
                <div class="stat-card bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 rounded-2xl shadow-xl p-4 sm:p-6 text-white">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex-1 min-w-0">
                            <p class="text-indigo-200 text-xs uppercase tracking-wide mb-2 font-semibold truncate">Eventos Hoy</p>
                            <h3 class="text-3xl sm:text-4xl lg:text-5xl font-bold">{{ $bitacoraStats['eventos_hoy'] }}</h3>
                            <p class="text-xs text-indigo-200 mt-2 sm:mt-3 flex items-center">
                                <i class="fas fa-clock text-indigo-300 mr-1 flex-shrink-0"></i>
                                <span class="truncate">Últimas 24h</span>
                            </p>
                        </div>
                        <div class="bg-white/20 p-2 sm:p-3 lg:p-4 rounded-xl shadow-md backdrop-blur-sm flex-shrink-0">
                            <i class="fas fa-chart-line text-2xl sm:text-3xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Logins Hoy -->
                <div class="stat-card bg-gradient-to-br from-cyan-600 via-cyan-700 to-blue-800 rounded-2xl shadow-xl p-4 sm:p-6 text-white">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex-1 min-w-0">
                            <p class="text-cyan-200 text-xs uppercase tracking-wide mb-2 font-semibold truncate">Logins Hoy</p>
                            <h3 class="text-3xl sm:text-4xl lg:text-5xl font-bold">{{ $bitacoraStats['logins_hoy'] }}</h3>
                            <p class="text-xs text-cyan-200 mt-2 sm:mt-3 flex items-center">
                                <i class="fas fa-sign-in-alt text-cyan-300 mr-1 flex-shrink-0"></i>
                                <span class="truncate">Accesos exitosos</span>
                            </p>
                        </div>
                        <div class="bg-white/20 p-2 sm:p-3 lg:p-4 rounded-xl shadow-md backdrop-blur-sm flex-shrink-0">
                            <i class="fas fa-door-open text-2xl sm:text-3xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Errores Hoy -->
                <div class="stat-card bg-gradient-to-br from-red-600 via-red-700 to-pink-800 rounded-2xl shadow-xl p-4 sm:p-6 text-white">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex-1 min-w-0">
                            <p class="text-red-200 text-xs uppercase tracking-wide mb-2 font-semibold truncate">Errores Hoy</p>
                            <h3 class="text-3xl sm:text-4xl lg:text-5xl font-bold">{{ $bitacoraStats['errores_hoy'] }}</h3>
                            <p class="text-xs text-red-200 mt-2 sm:mt-3 flex items-center">
                                @if($bitacoraStats['errores_hoy'] > 0)
                                    <i class="fas fa-exclamation-triangle text-yellow-300 mr-1 flex-shrink-0"></i>
                                    <span class="truncate">Requieren atención</span>
                                @else
                                    <i class="fas fa-check-circle text-green-300 mr-1 flex-shrink-0"></i>
                                    <span class="truncate">Sin problemas</span>
                                @endif
                            </p>
                        </div>
                        <div class="bg-white/20 p-2 sm:p-3 lg:p-4 rounded-xl shadow-md backdrop-blur-sm flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-2xl sm:text-3xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Eventos -->
                <div class="stat-card bg-gradient-to-br from-gray-600 via-gray-700 to-slate-800 rounded-2xl shadow-xl p-4 sm:p-6 text-white">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-gray-200 text-xs uppercase tracking-wide mb-2 font-semibold">Total Eventos</p>
                            <h3 class="text-5xl font-bold">{{ number_format($bitacoraStats['total_eventos']) }}</h3>
                            <p class="text-xs text-gray-200 mt-3 flex items-center">
                                <i class="fas fa-database text-gray-300 mr-1"></i> Historial completo
                            </p>
                        </div>
                        <div class="bg-white/20 p-4 rounded-xl shadow-md backdrop-blur-sm">
                            <i class="fas fa-archive text-3xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid de Dos Columnas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Distribución de Usuarios por Rol -->
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-gray-700">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-user-tag mr-3 text-purple-400"></i>Distribución por Rol
                </h3>
                <div class="space-y-4">
                    @foreach($usuariosPorRol as $rol)
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <span class="inline-block w-3 h-3 rounded-full {{ $rol->color }} mr-3"></span>
                                <span class="font-semibold text-gray-200">{{ $rol->nombre }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-white font-bold text-lg">{{ $rol->cantidad }}</span>
                                <span class="text-sm text-gray-400 bg-gray-700 px-2 py-1 rounded-full">{{ $rol->porcentaje }}%</span>
                            </div>
                        </div>
                        <div class="w-full bg-gray-700/50 rounded-full h-3 overflow-hidden">
                            <div class="{{ $rol->colorBarra }} h-3 rounded-full transition-all duration-500 shadow-lg" 
                                 style="width: {{ $rol->porcentaje }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Usuarios Más Activos -->
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-gray-700">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-fire mr-3 text-orange-400"></i>Usuarios Más Activos (7 días)
                </h3>
                @if($bitacoraStats['usuarios_activos']->count() > 0)
                <div class="space-y-3">
                    @foreach($bitacoraStats['usuarios_activos'] as $index => $usuario)
                    <div class="flex items-center justify-between p-4 bg-gray-700/50 rounded-xl hover:bg-gray-700 transition-all duration-200 border border-gray-600">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full 
                                {{ $index === 0 ? 'bg-gradient-to-br from-yellow-400 to-yellow-600' : ($index === 1 ? 'bg-gradient-to-br from-gray-300 to-gray-500' : ($index === 2 ? 'bg-gradient-to-br from-orange-400 to-orange-600' : 'bg-gradient-to-br from-blue-400 to-blue-600')) }} 
                                text-white font-bold shadow-lg">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <p class="font-semibold text-white">{{ $usuario->usuario_nombre }}</p>
                                <p class="text-xs text-gray-400">ID: {{ $usuario->user_id }}</p>
                            </div>
                        </div>
                        <span class="badge-status bg-blue-600 text-white px-3 py-1.5">
                            <i class="fas fa-chart-line mr-1"></i>{{ $usuario->total }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12 text-gray-400">
                    <i class="fas fa-inbox text-5xl mb-4"></i>
                    <p class="text-lg">No hay actividad reciente</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Últimos Usuarios Registrados y Últimos Eventos -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Últimos Usuarios Registrados -->
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-gray-700">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-user-plus mr-3 text-green-400"></i>Últimos Usuarios Registrados
                </h3>
                <div class="space-y-3">
                    @foreach($ultimosUsuarios as $usuario)
                    <div class="flex items-center justify-between p-4 bg-gray-700/50 rounded-xl hover:bg-gray-700 transition-all duration-200 border border-gray-600">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                {{ strtoupper(substr($usuario->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-white">{{ $usuario->name }}</p>
                                <p class="text-xs text-gray-400">{{ $usuario->email }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            @if($usuario->email_verified_at)
                                <span class="badge-status bg-green-600 text-white mb-2 inline-block">
                                    <i class="fas fa-check-circle"></i> Verificado
                                </span>
                            @else
                                <span class="badge-status bg-orange-600 text-white mb-2 inline-block">
                                    <i class="fas fa-clock"></i> Pendiente
                                </span>
                            @endif
                            <p class="text-xs text-gray-400">
                                {{ $usuario->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Últimos Eventos del Sistema -->
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-gray-700">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-stream mr-3 text-indigo-400"></i>Últimos Eventos del Sistema
                </h3>
                @if($bitacoraStats['ultimos_eventos']->count() > 0)
                <div class="space-y-3">
                    @foreach($bitacoraStats['ultimos_eventos'] as $evento)
                    <div class="flex items-start gap-4 p-4 bg-gray-700/50 rounded-xl hover:bg-gray-700 transition-all duration-200 border border-gray-600">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full 
                            {{ $evento->estado === 'exitoso' ? 'bg-green-600' : 'bg-red-600' }} 
                            flex items-center justify-center shadow-lg">
                            <i class="fas {{ $evento->estado === 'exitoso' ? 'fa-check' : 'fa-times' }} text-white"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-white text-sm">{{ $evento->accion }}</p>
                            <p class="text-xs text-gray-300">{{ $evento->usuario_nombre ?? 'Sistema' }}</p>
                            @if($evento->modulo)
                            <p class="text-xs text-gray-400 mt-1">
                                <i class="fas fa-folder mr-1"></i>{{ $evento->modulo }}
                            </p>
                            @endif
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-xs text-gray-400">
                                {{ $evento->fecha_hora->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12 text-gray-400">
                    <i class="fas fa-inbox text-5xl mb-4"></i>
                    <p class="text-lg">No hay eventos recientes</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Actividad por Módulo y Acciones -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Módulos Más Usados -->
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-gray-700">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-cube mr-3 text-teal-400"></i>Módulos Más Usados (7 días)
                </h3>
                @if($bitacoraStats['por_modulo']->count() > 0)
                <div class="space-y-3">
                    @foreach($bitacoraStats['por_modulo'] as $modulo)
                    <div class="flex items-center justify-between p-4 bg-gray-700/50 rounded-xl hover:bg-gray-700 transition-all duration-200 border border-gray-600">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-teal-500 to-cyan-500 flex items-center justify-center text-white shadow-lg">
                                <i class="fas fa-folder text-xl"></i>
                            </div>
                            <span class="font-semibold text-white">{{ $modulo->modulo }}</span>
                        </div>
                        <span class="badge-status bg-teal-600 text-white px-3 py-1.5">
                            {{ $modulo->total }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12 text-gray-400">
                    <i class="fas fa-inbox text-5xl mb-4"></i>
                    <p class="text-lg">No hay datos disponibles</p>
                </div>
                @endif
            </div>

            <!-- Acciones Más Frecuentes -->
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-gray-700">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-bolt mr-3 text-yellow-400"></i>Acciones Más Frecuentes (7 días)
                </h3>
                @if($bitacoraStats['por_accion']->count() > 0)
                <div class="space-y-3">
                    @foreach($bitacoraStats['por_accion']->take(5) as $accion)
                    <div class="flex items-center justify-between p-4 bg-gray-700/50 rounded-xl hover:bg-gray-700 transition-all duration-200 border border-gray-600">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-500 to-orange-500 flex items-center justify-center text-white shadow-lg">
                                <i class="fas fa-play text-xl"></i>
                            </div>
                            <span class="font-semibold text-white">{{ $accion->accion }}</span>
                        </div>
                        <span class="badge-status bg-yellow-600 text-white px-3 py-1.5">
                            {{ $accion->total }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12 text-gray-400">
                    <i class="fas fa-inbox text-5xl mb-4"></i>
                    <p class="text-lg">No hay datos disponibles</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Resumen Mensual -->
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl shadow-xl p-6 border border-gray-700">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <i class="fas fa-calendar-check mr-3 text-blue-400"></i>Resumen del Mes
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-6 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl shadow-lg border border-blue-500">
                    <p class="text-sm text-blue-200 mb-3 font-semibold uppercase tracking-wide">Eventos del Mes</p>
                    <p class="text-4xl font-bold text-white">{{ number_format($bitacoraStats['eventos_mes']) }}</p>
                </div>
                <div class="text-center p-6 bg-gradient-to-br from-green-600 to-emerald-700 rounded-xl shadow-lg border border-green-500">
                    <p class="text-sm text-green-200 mb-3 font-semibold uppercase tracking-wide">Logins Exitosos</p>
                    <p class="text-4xl font-bold text-white">{{ number_format($bitacoraStats['logins_exitosos_mes']) }}</p>
                </div>
                <div class="text-center p-6 bg-gradient-to-br from-red-600 to-pink-700 rounded-xl shadow-lg border border-red-500">
                    <p class="text-sm text-red-200 mb-3 font-semibold uppercase tracking-wide">Logins Fallidos</p>
                    <p class="text-4xl font-bold text-white">{{ number_format($bitacoraStats['logins_fallidos_mes']) }}</p>
                </div>
                <div class="text-center p-6 bg-gradient-to-br from-purple-600 to-indigo-700 rounded-xl shadow-lg border border-purple-500">
                    <p class="text-sm text-purple-200 mb-3 font-semibold uppercase tracking-wide">Nuevos Usuarios</p>
                    <p class="text-4xl font-bold text-white">{{ $usuariosNuevos }}</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    // Animación de números al cargar
    document.addEventListener('DOMContentLoaded', function() {
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 50);
            }, index * 50);
        });
    });
</script>
@endpush
