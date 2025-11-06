@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center p-6 bg-gradient-to-br from-gray-900 to-indigo-950 text-white shadow-2xl">
        <div>
            <h2 class="text-3xl font-bold bg-gradient-to-r from-teal-300 to-blue-400 bg-clip-text text-transparent">
                🎯 Dashboard - Super Administrador
            </h2>
            <p class="mt-2 text-sm text-gray-400">
                Bienvenido, <span class="font-semibold text-purple-300">{{ Auth::user()->name }}</span> 👋
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <div class="text-sm font-medium text-gray-300 bg-gray-800 px-5 py-2.5 rounded-full shadow-md border border-gray-700">
                <span class="text-purple-300">📅</span> 26/10/2025 14:54
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-900 to-indigo-950 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- KPIs Principales -->
            <div class="mb-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-5">
                
                <!-- Total Usuarios -->
                <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-pink-600 via-purple-600 to-indigo-700 p-6 text-white shadow-xl transform hover:scale-105 transition-all duration-300">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-20 w-20 rounded-full bg-white/10 blur-xl"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-purple-200 text-xs font-bold uppercase tracking-wider">Total Usuarios</p>
                            <div class="bg-white/20 rounded-full p-2">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-4xl font-bold text-white mb-2">{{ $totalUsuarios }}</p>
                        <p class="text-purple-100 text-xs font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            +{{ $usuariosNuevos }} este mes
                        </p>
                    </div>
                </div>

                <!-- Usuarios Verificados -->
                <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-700 p-6 text-white shadow-xl transform hover:scale-105 transition-all duration-300">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-20 w-20 rounded-full bg-white/10 blur-xl"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-emerald-200 text-xs font-bold uppercase tracking-wider">Verificados</p>
                            <div class="bg-white/20 rounded-full p-2">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-4xl font-bold text-white mb-2">{{ $usuariosVerificados }}</p>
                        <p class="text-emerald-100 text-xs font-medium">
                            {{ $porcentajeVerificados }}% del total
                        </p>
                    </div>
                </div>

                <!-- Usuarios Pendientes -->
                <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-600 via-orange-600 to-red-700 p-6 text-white shadow-xl transform hover:scale-105 transition-all duration-300">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-20 w-20 rounded-full bg-white/10 blur-xl"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-amber-200 text-xs font-bold uppercase tracking-wider">Sin Verificar</p>
                            <div class="bg-white/20 rounded-full p-2">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-4xl font-bold text-white mb-2">{{ $usuariosPendientes }}</p>
                        <p class="text-amber-100 text-xs font-medium">
                            Requieren atención
                        </p>
                    </div>
                </div>

                <!-- Roles Activos -->
                <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 p-6 text-white shadow-xl transform hover:scale-105 transition-all duration-300">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-20 w-20 rounded-full bg-white/10 blur-xl"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-blue-200 text-xs font-bold uppercase tracking-wider">Roles Activos</p>
                            <div class="bg-white/20 rounded-full p-2">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-4xl font-bold text-white mb-2">{{ $rolesActivos }}</p>
                        <p class="text-blue-100 text-xs font-medium">
                            En el sistema
                        </p>
                    </div>
                </div>

                <!-- Sesiones Activas -->
                <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-rose-600 via-pink-600 to-fuchsia-700 p-6 text-white shadow-xl transform hover:scale-105 transition-all duration-300">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-20 w-20 rounded-full bg-white/10 blur-xl"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-rose-200 text-xs font-bold uppercase tracking-wider">Sesiones Hoy</p>
                            <div class="bg-white/20 rounded-full p-2">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-4xl font-bold text-white mb-2">{{ $sesionesHoy ?? 0 }}</p>
                        <p class="text-rose-100 text-xs font-medium">
                            Inicios de sesión
                        </p>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="mb-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                
                <!-- Ver Usuarios -->
                <a href="{{ route('admin.usuarios.lista') }}" 
                    class="group relative overflow-hidden rounded-2xl bg-gray-800 p-6 shadow-xl ring-1 ring-gray-700/50 hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-20 w-20 rounded-full bg-gradient-to-br from-pink-900/50 to-purple-900/50 blur-xl opacity-50"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-pink-600 to-purple-700 flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <svg class="h-6 w-6 text-gray-400 group-hover:text-purple-300 transform group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-100 mb-2">Ver Usuarios</h3>
                        <p class="text-sm text-gray-400">Gestiona y administra todos los usuarios del sistema</p>
                    </div>
                </a>

                <!-- Crear Usuario -->
                <a href="{{ route('admin.usuarios.crear') }}" 
                    class="group relative overflow-hidden rounded-2xl bg-gray-800 p-6 shadow-xl ring-1 ring-gray-700/50 hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-20 w-20 rounded-full bg-gradient-to-br from-emerald-900/50 to-teal-900/50 blur-xl opacity-50"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-700 flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <svg class="h-6 w-6 text-gray-400 group-hover:text-emerald-300 transform group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-100 mb-2">Crear Usuario</h3>
                        <p class="text-sm text-gray-400">Agrega un nuevo usuario al sistema rápidamente</p>
                    </div>
                </a>

                <!-- Bitácora -->
                <a href="{{ route('admin.bitacora.index') }}" 
                    class="group relative overflow-hidden rounded-2xl bg-gray-800 p-6 shadow-xl ring-1 ring-gray-700/50 hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-20 w-20 rounded-full bg-gradient-to-br from-blue-900/50 to-indigo-900/50 blur-xl opacity-50"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <svg class="h-6 w-6 text-gray-400 group-hover:text-blue-300 transform group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-100 mb-2">Bitácora</h3>
                        <p class="text-sm text-gray-400">Revisa el registro de actividades del sistema</p>
                    </div>
                </a>

                <!-- Calendario -->
                <a href="{{ route('admin.calendario') }}" 
                    class="group relative overflow-hidden rounded-2xl bg-gray-800 p-6 shadow-xl ring-1 ring-gray-700/50 hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-20 w-20 rounded-full bg-gradient-to-br from-purple-900/50 to-pink-900/50 blur-xl opacity-50"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-purple-600 to-pink-700 flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <svg class="h-6 w-6 text-gray-400 group-hover:text-purple-300 transform group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-100 mb-2">Calendario</h3>
                        <p class="text-sm text-gray-400">Gestiona eventos y reuniones del club</p>
                    </div>
                </a>
            </div>

            <!-- Distribución de Roles -->
            <div class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden ring-1 ring-gray-700/50 mb-10">
                <div class="px-8 py-6 border-b border-gray-700 bg-gray-900">
                    <h3 class="text-xl font-bold text-gray-100">📊 Distribución de Roles</h3>
                    <p class="mt-1 text-sm text-gray-400">Estadísticas de usuarios por rol en el sistema</p>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @if(isset($distribucionRoles))
                            @foreach($distribucionRoles as $rol => $cantidad)
                                @php
                                    $colors = [
                                        'Super Admin' => ['from' => 'from-red-600', 'to' => 'to-pink-700', 'text' => 'text-red-200', 'bg' => 'bg-red-900/50', 'emoji' => '🔐'],
                                        'Presidente' => ['from' => 'from-yellow-600', 'to' => 'to-orange-700', 'text' => 'text-yellow-200', 'bg' => 'bg-yellow-900/50', 'emoji' => '👑'],
                                        'Vicepresidente' => ['from' => 'from-blue-600', 'to' => 'to-indigo-700', 'text' => 'text-blue-200', 'bg' => 'bg-blue-900/50', 'emoji' => '👔'],
                                        'Tesorero' => ['from' => 'from-green-600', 'to' => 'to-emerald-700', 'text' => 'text-green-200', 'bg' => 'bg-green-900/50', 'emoji' => '💰'],
                                        'Secretario' => ['from' => 'from-purple-600', 'to' => 'to-violet-700', 'text' => 'text-purple-200', 'bg' => 'bg-purple-900/50', 'emoji' => '📝'],
                                        'Vocero' => ['from' => 'from-pink-600', 'to' => 'to-rose-700', 'text' => 'text-pink-200', 'bg' => 'bg-pink-900/50', 'emoji' => '📢'],
                                        'Aspirante' => ['from' => 'from-cyan-600', 'to' => 'to-teal-700', 'text' => 'text-cyan-200', 'bg' => 'bg-cyan-900/50', 'emoji' => '⭐'],
                                    ];
                                    $color = $colors[$rol] ?? ['from' => 'from-gray-600', 'to' => 'to-gray-700', 'text' => 'text-gray-200', 'bg' => 'bg-gray-900/50', 'emoji' => '👤'];
                                @endphp
                                <div class="group {{ $color['bg'] }} rounded-2xl p-6 border-2 border-{{ str_replace('text-', '', $color['text']) }}-700/50 hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="text-3xl">{{ $color['emoji'] }}</span>
                                        <span class="text-3xl font-black {{ $color['text'] }}">{{ $cantidad }}</span>
                                    </div>
                                    <h4 class="text-sm font-bold text-gray-200">{{ $rol }}</h4>
                                    <div class="mt-3 bg-gray-700 rounded-full h-2 overflow-hidden">
                                        <div class="h-full bg-gradient-to-r {{ $color['from'] }} {{ $color['to'] }} rounded-full" 
                                             style="width: {{ $totalUsuarios > 0 ? ($cantidad / $totalUsuarios) * 100 : 0 }}%"></div>
                                    </div>
                                    <p class="mt-2 text-xs {{ $color['text'] }} font-semibold">
                                        {{ $totalUsuarios > 0 ? round(($cantidad / $totalUsuarios) * 100, 1) : 0 }}% del total
                                    </p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actividad Reciente -->
            <div class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden ring-1 ring-gray-700/50">
                <div class="px-8 py-6 border-b border-gray-700 bg-gray-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-100">⚡ Actividad Reciente</h3>
                            <p class="mt-1 text-sm text-gray-400">Últimas acciones realizadas en el sistema</p>
                        </div>
                        <a href="{{ route('admin.bitacora.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-700 hover:from-purple-700 hover:to-pink-800 text-white text-sm font-bold rounded-xl transition-all duration-200 transform hover:scale-105 shadow-md">
                            Ver Todo
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="p-8">
                    @if(isset($actividadReciente) && $actividadReciente->count() > 0)
                        <div class="space-y-4">
                            @foreach($actividadReciente as $actividad)
                                <div class="flex items-start space-x-4 p-4 rounded-2xl hover:bg-gray-700/50 transition-all duration-200">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-purple-600 to-pink-700 flex items-center justify-center text-white font-bold shadow-lg">
                                            {{ strtoupper(substr($actividad->usuario_nombre ?? 'S', 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-200">
                                            {{ $actividad->usuario_nombre ?? 'Sistema' }}
                                        </p>
                                        <p class="text-sm text-gray-400">{{ $actividad->descripcion }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $actividad->fecha_hora->diffForHumans() }}</p>
                                    </div>
                                    <div>
                                        @php
                                            $badgeColors = [
                                                'login' => 'bg-blue-900/50 text-blue-200',
                                                'logout' => 'bg-gray-900/50 text-gray-200',
                                                'create' => 'bg-green-900/50 text-green-200',
                                                'update' => 'bg-yellow-900/50 text-yellow-200',
                                                'delete' => 'bg-red-900/50 text-red-200',
                                            ];
                                            $badgeColor = $badgeColors[$actividad->accion] ?? 'bg-gray-900/50 text-gray-200';
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $badgeColor }}">
                                            {{ ucfirst($actividad->accion) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-400">No hay actividad reciente</h3>
                            <p class="mt-1 text-sm text-gray-500">Las acciones del sistema aparecerán aquí</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }
    </style>
@endsection