@extends('modulos.superadmin.usuarios.layout')

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                Dashboard - Super Administrador
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Bienvenido, <span class="font-semibold">{{ Auth::user()->name }}</span>
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <div class="text-sm text-gray-500 bg-gray-100 px-4 py-2 rounded-full">
                {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- KPIs Principales -->
            <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                
                <!-- Total Usuarios -->
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white shadow-xl transform hover:scale-105 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Usuarios</p>
                            <p class="text-4xl font-bold mt-2">{{ $totalUsuarios }}</p>
                            <p class="text-blue-100 text-xs mt-2">
                                +{{ $usuariosNuevos }} este mes
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-white/20 rounded-full p-3">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usuarios Verificados -->
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-6 text-white shadow-xl transform hover:scale-105 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm font-medium">Verificados</p>
                            <p class="text-4xl font-bold mt-2">{{ $usuariosVerificados }}</p>
                            <p class="text-emerald-100 text-xs mt-2">
                                {{ $porcentajeVerificados }}% del total
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-white/20 rounded-full p-3">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usuarios Pendientes -->
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-500 to-amber-600 p-6 text-white shadow-xl transform hover:scale-105 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-amber-100 text-sm font-medium">Sin Verificar</p>
                            <p class="text-4xl font-bold mt-2">{{ $usuariosPendientes }}</p>
                            <p class="text-amber-100 text-xs mt-2">
                                Requieren atención
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-white/20 rounded-full p-3">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Roles Activos -->
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 p-6 text-white shadow-xl transform hover:scale-105 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Roles Activos</p>
                            <p class="text-4xl font-bold mt-2">{{ $rolesActivos }}</p>
                            <p class="text-purple-100 text-xs mt-2">
                                En el sistema
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-white/20 rounded-full p-3">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Accesos Rápidos -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Accesos Rápidos</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    
                    <!-- Ver Todos los Usuarios -->
                    <a href="{{ route('admin.usuarios.lista') }}" class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-lg ring-1 ring-black/5 hover:shadow-xl transition-all duration-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-blue-100 rounded-lg p-3 group-hover:bg-blue-200 transition-colors duration-200">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Lista de Usuarios</p>
                                <p class="text-xs text-gray-500 mt-1">Ver todos</p>
                            </div>
                        </div>
                    </a>

                    <!-- Crear Usuario -->
                    <a href="{{ route('admin.usuarios.crear') }}" class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-lg ring-1 ring-black/5 hover:shadow-xl transition-all duration-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-emerald-100 rounded-lg p-3 group-hover:bg-emerald-200 transition-colors duration-200">
                                    <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Nuevo Usuario</p>
                                <p class="text-xs text-gray-500 mt-1">Registrar</p>
                            </div>
                        </div>
                    </a>

                    <!-- Usuarios Pendientes -->
                    <a href="{{ route('admin.usuarios.lista') }}?filtro=pendientes" class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-lg ring-1 ring-black/5 hover:shadow-xl transition-all duration-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-amber-100 rounded-lg p-3 group-hover:bg-amber-200 transition-colors duration-200">
                                    <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Sin Verificar</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $usuariosPendientes }} usuarios</p>
                            </div>
                        </div>
                    </a>

                    <!-- Configuración -->
                    <a href="#" class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-lg ring-1 ring-black/5 hover:shadow-xl transition-all duration-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-gray-100 rounded-lg p-3 group-hover:bg-gray-200 transition-colors duration-200">
                                    <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Configuración</p>
                                <p class="text-xs text-gray-500 mt-1">Sistema</p>
                            </div>
                        </div>
                    </a>

                </div>
            </div>

            <!-- Distribución de Roles y Últimos Usuarios -->
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                
                <!-- Distribución por Roles -->
                <div class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-black/5">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Distribución por Roles</h3>
                        <p class="mt-1 text-sm text-gray-500">Usuarios registrados por rol</p>
                    </div>
                    <div class="px-6 py-6">
                        <div class="space-y-4">
                            @foreach($usuariosPorRol as $rol)
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center">
                                        <div class="h-3 w-3 rounded-full {{ $rol->color }} mr-2"></div>
                                        <span class="text-sm font-medium text-gray-900">{{ $rol->nombre }}</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700">{{ $rol->cantidad }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="{{ $rol->colorBarra }} h-2 rounded-full transition-all duration-500" style="width: {{ $rol->porcentaje }}%"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Últimos Usuarios Registrados -->
                <div class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-black/5">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Últimos Usuarios</h3>
                        <p class="mt-1 text-sm text-gray-500">Registros recientes</p>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @forelse($ultimosUsuarios as $usuario)
                        <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                        {{ strtoupper(substr($usuario->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $usuario->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $usuario->email }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($usuario->email_verified_at)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Verificado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pendiente
                                        </span>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-1">{{ $usuario->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="px-6 py-8 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">No hay usuarios registrados</p>
                        </div>
                        @endforelse
                    </div>
                    @if($ultimosUsuarios->count() > 0)
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <a href="{{ route('admin.usuarios.lista') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 flex items-center justify-center">
                            Ver todos los usuarios---##
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    @endif
                </div>

            </div>

            <!-- Información de la Base de Datos -->
            <div class="mt-8">
                <div class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-black/5">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Información de la Base de Datos</h3>
                    </div>
                    <div class="px-6 py-6">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Estado de Conexión</p>
                                    <p class="mt-1 text-sm text-gray-600">Conectado exitosamente</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Base de Datos</p>
                                    <p class="mt-1 text-sm text-gray-600">{{ config('database.connections.mysql.database') }}</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Total de Registros</p>
                                    <p class="mt-1 text-sm text-gray-600">{{ $totalUsuarios }} usuarios</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection