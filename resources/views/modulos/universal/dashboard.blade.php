@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">
                Bienvenido, {{ $user->name }} 👋
            </h1>
            <p class="text-gray-300">
                Rol: <span class="font-semibold text-blue-400">{{ $user->roles->pluck('name')->implode(', ') }}</span>
            </p>
        </div>

        <!-- Estadísticas -->
        @if(count($stats) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @foreach($stats as $key => $stat)
            <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20 hover:bg-white/15 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-lg bg-{{ $stat['color'] }}-500/20">
                        <svg class="w-6 h-6 text-{{ $stat['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($stat['icon'] === 'users')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            @elseif($stat['icon'] === 'briefcase')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            @elseif($stat['icon'] === 'calendar')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            @elseif($stat['icon'] === 'user-circle')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            @endif
                        </svg>
                    </div>
                </div>
                <h3 class="text-gray-400 text-sm uppercase tracking-wider mb-2">{{ ucfirst($key) }}</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-white">{{ $stat['total'] }}</span>
                    <span class="text-sm text-{{ $stat['color'] }}-400">{{ $stat['activos'] ?? 0 }} activos</span>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Módulos Disponibles -->
        <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20 mb-8">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Módulos Disponibles
            </h2>

            @if(count($modules) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($modules as $module)
                @if($module['route'] !== '#')
                <a href="{{ route($module['route']) }}" 
                   class="block bg-white/5 hover:bg-white/10 rounded-lg p-4 border border-white/10 hover:border-blue-400/50 transition-all duration-300 group">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="p-2 rounded-lg bg-blue-500/20 group-hover:bg-blue-500/30 transition-colors">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-white font-semibold">{{ $module['display_name'] }}</h3>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach(array_unique($module['actions']) as $action)
                        <span class="px-2 py-1 text-xs rounded-full bg-blue-500/20 text-blue-300 border border-blue-500/30">
                            {{ ucfirst($action) }}
                        </span>
                        @endforeach
                    </div>
                </a>
                @else
                <div class="block bg-white/5 rounded-lg p-4 border border-white/10 opacity-60 cursor-not-allowed">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="p-2 rounded-lg bg-gray-500/20">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-gray-400 font-semibold">{{ $module['display_name'] }}</h3>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach(array_unique($module['actions']) as $action)
                        <span class="px-2 py-1 text-xs rounded-full bg-gray-500/20 text-gray-300 border border-gray-500/30">
                            {{ ucfirst($action) }}
                        </span>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Sin vista disponible</p>
                </div>
                @endif
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-300 mb-2">No tienes permisos asignados</h3>
                <p class="text-gray-400">Contacta al administrador para solicitar acceso a los módulos.</p>
            </div>
            @endif
        </div>

        <!-- Mensaje de ayuda -->
        <div class="bg-blue-500/10 border border-blue-500/30 rounded-xl p-6">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-blue-400 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h4 class="text-white font-semibold mb-1">Información sobre tus permisos</h4>
                    <p class="text-gray-300 text-sm">
                        Tu acceso al sistema está controlado por permisos específicos. Solo puedes ver y realizar acciones en los módulos que se muestran arriba.
                        Si necesitas acceso adicional, contacta al administrador del sistema.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
