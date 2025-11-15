@extends('layouts.app-admin')

@section('header')
    <div class="flex justify-between items-center p-6 bg-gradient-to-br from-gray-900 to-indigo-950 text-white shadow-2xl">
        <div>
            <h2 class="text-3xl font-bold bg-gradient-to-r from-teal-300 to-blue-400 bg-clip-text text-transparent">
                👥 Gestión de Usuarios
            </h2>
            <p class="mt-2 text-sm text-gray-400">
                Administra todos los usuarios del sistema Rotaract
            </p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="text-sm font-medium text-gray-300 bg-gray-800 px-5 py-2.5 rounded-full shadow-md border border-gray-700">
                <span class="text-purple-300 font-bold">{{ $totalUsuarios ?? 0 }}</span> {{ $totalUsuarios === 1 ? 'usuario' : 'usuarios' }}
            </div>
            <a href="{{ route(($moduloActual ?? 'admin') . '.usuarios.crear') }}" 
                class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl text-white bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 shadow-lg transition-all duration-200 transform hover:scale-105">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
                Nuevo Usuario
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-900 to-indigo-950 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Mensajes de éxito con animación -->
            @if(session('success'))
                <div class="mb-8 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-700 p-5 shadow-xl transform hover:scale-[1.02] transition-all duration-300 animate-fade-in">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-white/20 rounded-full p-2.5">
                                <svg class="h-7 w-7 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-white font-semibold text-lg">✨ {{ session('success') }}</p>
                            @if(session('usuario_creado'))
                                <p class="mt-1 text-sm text-white/90">Usuario "{{ session('usuario_creado') }}" creado correctamente.</p>
                            @elseif(session('usuario_actualizado'))
                                <p class="mt-1 text-sm text-white/90">Usuario "{{ session('usuario_actualizado') }}" actualizado correctamente.</p>
                            @elseif(session('usuario_eliminado'))
                                <p class="mt-1 text-sm text-white/90">Usuario "{{ session('usuario_eliminado') }}" eliminado correctamente.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($error))
                <div class="mb-8 rounded-2xl bg-gradient-to-r from-red-600 to-pink-700 p-5 shadow-xl transform hover:scale-[1.02] transition-all duration-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-white/20 rounded-full p-2.5">
                                <svg class="h-7 w-7 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-white font-semibold text-lg">⚠️ Error de conexión</h3>
                            <p class="mt-1 text-sm text-white/90">{{ $error }}</p>
                        </div>
                    </div>
                </div>
            @else
                <!-- KPIs Estadísticas -->
                <div class="mb-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    
                    <!-- Total Usuarios -->
                    <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-pink-600 via-purple-600 to-indigo-700 p-6 text-white shadow-xl transform hover:scale-105 transition-all duration-300">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 h-20 w-20 rounded-full bg-white/10 blur-xl"></div>
                        <div class="relative">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-purple-200 text-xs font-semibold uppercase tracking-wider mb-2">👥 Total Usuarios</p>
                                    <p class="text-4xl font-bold text-white">{{ $totalUsuarios }}</p>
                                </div>
                                <div class="bg-white/20 rounded-full p-3">
                                    <svg class="h-8 w-8 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-purple-100 text-sm font-medium mt-3">Usuarios registrados en el sistema</p>
                        </div>
                    </div>

                    <!-- Base de Datos -->
                    <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-cyan-600 via-blue-600 to-indigo-700 p-6 text-white shadow-xl transform hover:scale-105 transition-all duration-300">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 h-20 w-20 rounded-full bg-white/10 blur-xl"></div>
                        <div class="relative">
                            <div class="flex items-start justify-between">
                                <div class="w-full">
                                    <p class="text-cyan-200 text-xs font-semibold uppercase tracking-wider mb-2">🗄️ Base de Datos</p>
                                    <p class="text-xl font-bold text-white truncate">{{ config('database.connections.mysql.database') }}</p>
                                </div>
                                <div class="bg-white/20 rounded-full p-3">
                                    <svg class="h-8 w-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-cyan-100 text-sm font-medium mt-3">Conexión establecida</p>
                        </div>
                    </div>

                    <!-- Estado de Conexión -->
                    <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-600 via-teal-600 to-green-700 p-6 text-white shadow-xl transform hover:scale-105 transition-all duration-300">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 h-20 w-20 rounded-full bg-white/10 blur-xl"></div>
                        <div class="relative">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-emerald-200 text-xs font-semibold uppercase tracking-wider mb-2">✅ Estado</p>
                                    <p class="text-2xl font-bold text-white">Activo</p>
                                </div>
                                <div class="bg-white/20 rounded-full p-3">
                                    <svg class="h-8 w-8 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-emerald-100 text-sm font-medium mt-3">Sistema funcionando correctamente</p>
                        </div>
                    </div>
                </div>

                <!-- Botón Flotante Grande para Agregar Usuario -->
                <div class="mb-6">
                    <a href="{{ route(($moduloActual ?? 'admin') . '.usuarios.crear') }}" 
                        class="group flex items-center justify-center w-full p-6 rounded-2xl bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 hover:from-pink-700 hover:via-purple-700 hover:to-blue-700 shadow-xl transition-all duration-300 transform hover:scale-[1.02]">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white/20 rounded-full p-4 group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-8 w-8 text-purple-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="text-left">
                                <h3 class="text-2xl font-black text-white">Agregar Nuevo Usuario</h3>
                                <p class="text-white/90 text-sm font-medium mt-1">Haz clic aquí para crear un nuevo usuario en el sistema</p>
                            </div>
                            <svg class="h-8 w-8 text-white group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </div>
                    </a>
                </div>

                <!-- Tabla de Usuarios -->
                <div class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden ring-1 ring-gray-700/50">
                    <div class="px-6 py-5 border-b border-gray-700 bg-gray-900">
                        <h3 class="text-lg font-bold text-gray-100">📋 Listado de Usuarios</h3>
                        <p class="mt-1 text-sm text-gray-400">Administra y gestiona todos los usuarios del sistema</p>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-900">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Usuario</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Rol</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Registro</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-300 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-800 divide-y divide-gray-700">
                                @forelse($usuarios as $usuario)
                                <tr class="hover:bg-gray-700 transition-all duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-bold text-gray-200">#{{ $usuario->id }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php $userDisplay = $usuario->username ?? $usuario->nombre_completo; @endphp
                                        <div class="flex items-center">
                                            <div class="h-11 w-11 rounded-full bg-gradient-to-br from-pink-600 via-purple-600 to-indigo-700 flex items-center justify-center text-white text-sm font-bold shadow-md">
                                                {{ strtoupper(substr($userDisplay, 0, 2)) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-200">{{ $usuario->username ?? $usuario->name }}</div>
                                                @if($usuario->username)
                                                    <div class="text-xs text-gray-400">{{ $usuario->nombre_completo }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-400">{{ $usuario->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-purple-900/50 text-purple-200">
                                            {{ $usuario->getRolPrincipal() ?? 'Sin rol' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($usuario->email_verified_at)
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-emerald-900/50 text-emerald-200">
                                                ✓ Verificado
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-amber-900/50 text-amber-200">
                                                ⏳ Pendiente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $usuario->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center space-x-2">
                                            <!-- Botón Editar -->
                                            <a href="{{ route(($moduloActual ?? 'admin') . '.usuarios.editar', $usuario) }}" 
                                                class="inline-flex items-center px-2 py-1 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white text-xs font-bold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Editar
                                            </a>
                                            
                                            <!-- Botón Eliminar -->
                                            <form method="POST" action="{{ route(($moduloActual ?? 'admin') . '.usuarios.eliminar', $usuario) }}" 
                                                  onsubmit="return confirm('¿Está seguro de que desea eliminar al usuario {{ $usuario->name }}? Esta acción no se puede deshacer.');"
                                                  class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="inline-flex items-center px-2 py-1 bg-gradient-to-r from-red-600 to-pink-700 hover:from-red-700 hover:to-pink-800 text-white text-xs font-bold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Eliminar
                                                </button>
                                            </form>

                                            <!-- Botón Ver -->
                                            <a href="{{ route(($moduloActual ?? 'admin') . '.usuarios.ver', $usuario) }}" 
                                                class="inline-flex items-center px-2 py-1 bg-gradient-to-r from-green-600 to-teal-700 hover:from-green-700 hover:to-teal-800 text-white text-xs font-bold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Ver
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="h-20 w-20 rounded-full bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center mb-4">
                                                <svg class="h-10 w-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                            </div>
                                            <p class="text-gray-400 font-medium">No hay usuarios registrados</p>
                                            <p class="text-gray-500 text-sm mt-1">Comienza creando tu primer usuario</p>
                                            <a href="{{ route(($moduloActual ?? 'admin') . '.usuarios.crear') }}" 
                                                class="mt-4 inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-700 hover:from-purple-700 hover:to-pink-800 text-white text-sm font-bold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md">
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                                                </svg>
                                                Crear Primer Usuario
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if(isset($usuarios) && $usuarios->hasPages())
                    <div class="px-6 py-4 border-t border-gray-700 bg-gray-900">
                        {{ $usuarios->links() }}
                    </div>
                    @endif
                </div>
            @endif

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

        /* Ajuste para evitar que los botones se corten */
        .min-w-full th:last-child,
        .min-w-full td:last-child {
            min-width: 200px; /* Aumenta el ancho mínimo de la columna de acciones */
            white-space: normal; /* Permite que el texto se ajuste si es necesario */
        }

        .flex.items-center.justify-center.space-x-2 a,
        .flex.items-center.justify-center.space-x-2 button {
            min-width: 60px; /* Asegura un ancho mínimo para los botones */
            padding: 2px 8px; /* Reduce el padding para compactar los botones */
        }
    </style>
@endsection