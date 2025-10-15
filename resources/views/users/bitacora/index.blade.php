@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                Bitácora del Sistema
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Registro completo de actividades y eventos del sistema
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver
            </a>
            <button onclick="document.getElementById('exportForm').submit()" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Exportar CSV
            </button>
        </div>
    </div>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Estadísticas Generales -->
        <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Eventos -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Eventos</p>
                        <p class="text-4xl font-bold mt-2">{{ number_format($stats['total_eventos']) }}</p>
                        <p class="text-blue-100 text-xs mt-2">{{ $stats['eventos_hoy'] }} hoy</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Eventos Exitosos -->
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium">Exitosos</p>
                        <p class="text-4xl font-bold mt-2">{{ number_format($stats['exitosos']) }}</p>
                        <p class="text-emerald-100 text-xs mt-2">
                            {{ $stats['total_eventos'] > 0 ? round(($stats['exitosos'] / $stats['total_eventos']) * 100, 1) : 0 }}% del total
                        </p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Eventos Fallidos -->
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Fallidos</p>
                        <p class="text-4xl font-bold mt-2">{{ number_format($stats['fallidos']) }}</p>
                        <p class="text-red-100 text-xs mt-2">Requieren atención</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Logins -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Inicios de Sesión</p>
                        <p class="text-4xl font-bold mt-2">{{ number_format($stats['logins_exitosos']) }}</p>
                        <p class="text-purple-100 text-xs mt-2">{{ $stats['logins_fallidos'] }} fallidos</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="mb-6 bg-white rounded-2xl shadow-xl p-6 ring-1 ring-black/5">
            <form method="GET" action="{{ route('admin.bitacora.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Usuario -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Usuario</label>
                        <select name="usuario" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Todos los usuarios</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ request('usuario') == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Acción -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Acción</label>
                        <select name="accion" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Todas las acciones</option>
                            <option value="login" {{ request('accion') == 'login' ? 'selected' : '' }}>Login</option>
                            <option value="login_fallido" {{ request('accion') == 'login_fallido' ? 'selected' : '' }}>Login Fallido</option>
                            <option value="logout" {{ request('accion') == 'logout' ? 'selected' : '' }}>Logout</option>
                            <option value="create" {{ request('accion') == 'create' ? 'selected' : '' }}>Crear</option>
                            <option value="update" {{ request('accion') == 'update' ? 'selected' : '' }}>Actualizar</option>
                            <option value="delete" {{ request('accion') == 'delete' ? 'selected' : '' }}>Eliminar</option>
                        </select>
                    </div>

                    <!-- Módulo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Módulo</label>
                        <select name="modulo" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Todos los módulos</option>
                            @foreach($modulos as $modulo)
                                <option value="{{ $modulo }}" {{ request('modulo') == $modulo ? 'selected' : '' }}>
                                    {{ ucfirst($modulo) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Estado -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <select name="estado" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Todos los estados</option>
                            <option value="exitoso" {{ request('estado') == 'exitoso' ? 'selected' : '' }}>Exitoso</option>
                            <option value="fallido" {{ request('estado') == 'fallido' ? 'selected' : '' }}>Fallido</option>
                            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        </select>
                    </div>

                    <!-- Fecha Desde -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Desde</label>
                        <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Fecha Hasta -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hasta</label>
                        <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Buscar -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar en descripción, usuario, email, IP..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.bitacora.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                        Limpiar Filtros
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        Aplicar Filtros
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabla de Registros -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden ring-1 ring-black/5">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha/Hora</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acción</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Módulo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($registros as $registro)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="font-medium">{{ $registro->fecha_hora->format('d/m/Y') }}</div>
                                <div class="text-gray-500">{{ $registro->fecha_hora->format('H:i:s') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($registro->user)
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                            {{ strtoupper(substr($registro->usuario_nombre, 0, 2)) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $registro->usuario_nombre }}</div>
                                            <div class="text-xs text-gray-500">{{ $registro->usuario_email }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-500">Sistema / Anónimo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $accionClasses = [
                                        'login' => 'bg-blue-100 text-blue-800',
                                        'logout' => 'bg-gray-100 text-gray-800',
                                        'login_fallido' => 'bg-red-100 text-red-800',
                                        'create' => 'bg-green-100 text-green-800',
                                        'update' => 'bg-yellow-100 text-yellow-800',
                                        'delete' => 'bg-red-100 text-red-800',
                                    ];
                                    $class = $accionClasses[$registro->accion] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $class }}">
                                    {{ ucfirst(str_replace('_', ' ', $registro->accion)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ ucfirst($registro->modulo) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate">
                                {{ $registro->descripcion }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                {{ $registro->ip_address }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($registro->estado === 'exitoso')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Exitoso
                                    </span>
                                @elseif($registro->estado === 'fallido')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Fallido
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pendiente
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('admin.bitacora.show', $registro->BitacoraID) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                    Ver detalles
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No se encontraron registros</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($registros->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $registros->links() }}
            </div>
            @endif
        </div>

    </div>
</div>

<!-- Form para exportar (oculto) -->
<form id="exportForm" action="{{ route('admin.bitacora.exportar') }}" method="GET" class="hidden">
    <input type="hidden" name="usuario" value="{{ request('usuario') }}">
    <input type="hidden" name="accion" value="{{ request('accion') }}">
    <input type="hidden" name="modulo" value="{{ request('modulo') }}">
    <input type="hidden" name="estado" value="{{ request('estado') }}">
    <input type="hidden" name="fecha_desde" value="{{ request('fecha_desde') }}">
    <input type="hidden" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
</form>
@endsection