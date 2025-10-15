@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold bg-gradient-to-r from-red-600 via-pink-600 to-purple-600 bg-clip-text text-transparent">
                🔒 Gestión de Usuarios Bloqueados
            </h2>
            <p class="mt-2 text-sm text-gray-600 flex items-center">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                Administra las cuentas bloqueadas por intentos fallidos de inicio de sesión
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <div class="text-sm text-gray-600 bg-gradient-to-r from-gray-50 to-gray-100 px-5 py-2.5 rounded-full shadow-sm border border-gray-200">
                <span class="font-medium">📅 {{ now()->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Mensajes de éxito/error con animación -->
            @if(session('success'))
                <div class="mb-8 rounded-2xl bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-600 p-5 shadow-2xl transform hover:scale-[1.02] transition-all duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-white/20 backdrop-blur-sm rounded-full p-2.5">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="ml-4 text-white font-semibold text-lg">✨ {{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div class="mb-8 rounded-2xl bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 p-5 shadow-2xl transform hover:scale-[1.02] transition-all duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-white/20 backdrop-blur-sm rounded-full p-2.5">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                        </div>
                        <p class="ml-4 text-white font-semibold text-lg">⚠️ {{ session('warning') }}</p>
                    </div>
                </div>
            @endif

            <!-- KPIs Estadísticas - ALTURA FIJA -->
            <div class="mb-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                
                <!-- Usuarios Bloqueados -->
                <div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-red-500 via-red-600 to-pink-600 p-6 text-white shadow-2xl transform hover:scale-105 transition-all duration-300 min-h-[180px] flex flex-col justify-between">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="relative">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-red-100 text-xs font-semibold uppercase tracking-wider mb-2">🔒 Bloqueados</p>
                                <p class="text-5xl font-black">{{ $usuariosBloqueados->total() }}</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-3">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-red-50 text-xs font-medium mt-3">Cuentas bloqueadas</p>
                    </div>
                </div>

                <!-- Con Intentos Fallidos -->
                <div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-amber-500 via-orange-500 to-red-500 p-6 text-white shadow-2xl transform hover:scale-105 transition-all duration-300 min-h-[180px] flex flex-col justify-between">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="relative">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-amber-100 text-xs font-semibold uppercase tracking-wider mb-2">⚠️ En Riesgo</p>
                                <p class="text-5xl font-black">{{ $usuariosConIntentos->total() }}</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-3">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-orange-50 text-xs font-medium mt-3">Con intentos fallidos</p>
                    </div>
                </div>

                <!-- Máximo Intentos -->
                <div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-600 p-6 text-white shadow-2xl transform hover:scale-105 transition-all duration-300 min-h-[180px] flex flex-col justify-between">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="relative">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-blue-100 text-xs font-semibold uppercase tracking-wider mb-2">🛡️ Límite</p>
                                <p class="text-5xl font-black">{{ \App\Models\Parametro::obtener('max_intentos_login', 3) }}</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-3">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-blue-50 text-xs font-medium mt-3">Intentos antes de bloquear</p>
                    </div>
                </div>

                <!-- Tiempo Bloqueo -->
                <div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-purple-500 via-pink-500 to-red-500 p-6 text-white shadow-2xl transform hover:scale-105 transition-all duration-300 min-h-[180px] flex flex-col justify-between">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="relative">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-purple-100 text-xs font-semibold uppercase tracking-wider mb-2">⏱️ Duración</p>
                                <p class="text-5xl font-black">{{ \App\Models\Parametro::obtener('tiempo_bloqueo_minutos', 30) }}</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-3">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-purple-50 text-xs font-medium mt-3">Minutos de bloqueo</p>
                    </div>
                </div>

            </div>

            <!-- Usuarios Bloqueados - Tabla Premium -->
            <div class="mb-10 overflow-hidden rounded-3xl bg-white shadow-2xl border border-gray-100">
                <div class="bg-gradient-to-r from-red-50 to-pink-50 px-8 py-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                                <span class="bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent">
                                    🔒 Usuarios Bloqueados
                                </span>
                            </h3>
                            <p class="mt-2 text-sm text-gray-600">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    {{ $usuariosBloqueados->total() }} {{ $usuariosBloqueados->total() == 1 ? 'cuenta bloqueada' : 'cuentas bloqueadas' }}
                                </span>
                            </p>
                        </div>
                        
                        @if($usuariosBloqueados->count() > 0)
                            <form action="{{ route('admin.usuarios-bloqueados.desbloquear-todos') }}" method="POST" onsubmit="return confirm('🔓 ¿Estás seguro de desbloquear TODAS las cuentas?')">
                                @csrf
                                <button type="submit" class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-700 hover:from-emerald-700 hover:via-emerald-800 hover:to-teal-800 text-white text-sm font-bold rounded-2xl transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-105">
                                    <svg class="h-5 w-5 mr-2 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                    </svg>
                                    Desbloquear Todos
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                @if($usuariosBloqueados->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Usuario</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Rol</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Intentos</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Bloqueado Hasta</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tiempo Restante</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($usuariosBloqueados as $usuario)
                                    <tr class="hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 transition-all duration-200 group">
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-red-500 to-pink-600 flex items-center justify-center text-white font-black text-base shadow-lg">
                                                    {{ strtoupper(substr($usuario->name, 0, 2)) }}
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-bold text-gray-900">{{ $usuario->name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <p class="text-sm text-gray-700 font-medium">{{ $usuario->email }}</p>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800">
                                                {{ $usuario->getRolPrincipal() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-red-100 to-pink-100 text-red-800">
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ $usuario->failed_login_attempts }} intentos
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-700 font-medium">
                                            {{ $usuario->locked_until ? $usuario->locked_until->format('d/m/Y H:i') : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            @php
                                                $minutosRestantes = $usuario->getRemainingLockTime();
                                            @endphp
                                            @if($minutosRestantes > 0)
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-red-100 to-pink-100 text-red-800 animate-pulse">
                                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ $minutosRestantes }} min
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800">
                                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Expirado
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-sm">
                                            <form action="{{ route('admin.usuarios-bloqueados.desbloquear', $usuario->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-bold rounded-xl transition-all duration-300 shadow-md hover:shadow-xl transform hover:scale-105">
                                                    <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                                    </svg>
                                                    Desbloquear
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-t border-gray-200">
                        {{ $usuariosBloqueados->links() }}
                    </div>
                @else
                    <div class="px-6 py-20 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-emerald-100 to-teal-100 mb-6">
                            <svg class="h-12 w-12 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-900 mb-2">¡Excelente!</p>
                        <p class="text-sm text-gray-600">No hay usuarios bloqueados actualmente 🎉</p>
                    </div>
                @endif
            </div>

            <!-- Usuarios con Intentos Fallidos - Tabla Premium -->
            <div class="overflow-hidden rounded-3xl bg-white shadow-2xl border border-gray-100">
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-8 py-6 border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                        <span class="bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                            ⚠️ Usuarios en Riesgo
                        </span>
                    </h3>
                    <p class="mt-2 text-sm text-gray-600">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                            {{ $usuariosConIntentos->total() }} {{ $usuariosConIntentos->total() == 1 ? 'usuario' : 'usuarios' }} con intentos fallidos
                        </span>
                    </p>
                </div>

                @if($usuariosConIntentos->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Usuario</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Rol</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Intentos Fallidos</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nivel de Riesgo</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($usuariosConIntentos as $usuario)
                                    <tr class="hover:bg-gradient-to-r hover:from-amber-50 hover:to-orange-50 transition-all duration-200 group">
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white font-black text-base shadow-lg">
                                                    {{ strtoupper(substr($usuario->name, 0, 2)) }}
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-bold text-gray-900">{{ $usuario->name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <p class="text-sm text-gray-700 font-medium">{{ $usuario->email }}</p>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800">
                                                {{ $usuario->getRolPrincipal() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-amber-100 to-orange-100 text-amber-800">
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ $usuario->failed_login_attempts }} intentos
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            @php
                                                $maxIntentos = \App\Models\Parametro::obtener('max_intentos_login', 3);
                                                $porcentajeRiesgo = ($usuario->failed_login_attempts / $maxIntentos) * 100;
                                            @endphp
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-1 bg-gray-200 rounded-full h-3 w-32 overflow-hidden shadow-inner">
                                                    <div class="h-3 rounded-full transition-all duration-500
                                                        @if($porcentajeRiesgo >= 75) bg-gradient-to-r from-red-500 to-red-600
                                                        @elseif($porcentajeRiesgo >= 50) bg-gradient-to-r from-amber-500 to-orange-500
                                                        @else bg-gradient-to-r from-yellow-400 to-yellow-500
                                                        @endif" 
                                                        style="width: {{ $porcentajeRiesgo }}%">
                                                    </div>
                                                </div>
                                                <span class="text-sm font-bold
                                                    @if($porcentajeRiesgo >= 75) text-red-700
                                                    @elseif($porcentajeRiesgo >= 50) text-amber-700
                                                    @else text-yellow-700
                                                    @endif">
                                                    {{ round($porcentajeRiesgo) }}%
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-sm">
                                            <form action="{{ route('admin.usuarios-bloqueados.resetear', $usuario->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs font-bold rounded-xl transition-all duration-300 shadow-md hover:shadow-xl transform hover:scale-105">
                                                    <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                    Resetear
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-t border-gray-200">
                        {{ $usuariosConIntentos->links() }}
                    </div>
                @else
                    <div class="px-6 py-20 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-emerald-100 to-teal-100 mb-6">
                            <svg class="h-12 w-12 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-900 mb-2">¡Todo en orden!</p>
                        <p class="text-sm text-gray-600">No hay usuarios con intentos fallidos 🎉</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection