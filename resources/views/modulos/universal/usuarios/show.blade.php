@extends('layouts.app')

@section('title', 'Ver Usuario')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">
                👤 Detalle del Usuario
            </h1>
            <p class="text-gray-300">
                Información completa del usuario
            </p>
        </div>

        <!-- Información del Usuario -->
        <div class="bg-white/10 backdrop-blur-lg rounded-xl p-8 border border-white/20 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Nombre Completo</label>
                    <p class="text-white text-lg font-semibold">{{ $usuario->name }}</p>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Correo Electrónico</label>
                    <p class="text-white text-lg">{{ $usuario->email }}</p>
                </div>

                <!-- Rol -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Rol</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($usuario->roles as $role)
                        <span class="px-3 py-1 text-sm rounded-full bg-purple-500/20 text-purple-300 border border-purple-500/30">
                            {{ $role->name }}
                        </span>
                        @endforeach
                    </div>
                </div>

                <!-- Estado de Verificación -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Estado</label>
                    @if($usuario->email_verified_at)
                    <span class="inline-flex items-center px-3 py-1 text-sm rounded-full bg-green-500/20 text-green-300 border border-green-500/30">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Verificado
                    </span>
                    @else
                    <span class="inline-flex items-center px-3 py-1 text-sm rounded-full bg-yellow-500/20 text-yellow-300 border border-yellow-500/30">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Pendiente de Verificación
                    </span>
                    @endif
                </div>

                <!-- Rotary ID -->
                @if($usuario->rotary_id)
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Rotary ID</label>
                    <p class="text-white">{{ $usuario->rotary_id }}</p>
                </div>
                @endif

                <!-- Fecha de Juramentación -->
                @if($usuario->fecha_juramentacion)
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Fecha de Juramentación</label>
                    <p class="text-white">{{ \Carbon\Carbon::parse($usuario->fecha_juramentacion)->format('d/m/Y') }}</p>
                </div>
                @endif

                <!-- Fecha de Cumpleaños -->
                @if($usuario->fecha_cumpleaños)
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Fecha de Cumpleaños</label>
                    <p class="text-white">{{ \Carbon\Carbon::parse($usuario->fecha_cumpleaños)->format('d/m/Y') }}</p>
                </div>
                @endif

                <!-- Fecha de Registro -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Fecha de Registro</label>
                    <p class="text-white">{{ $usuario->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Permisos del Usuario -->
        @if($usuario->getAllPermissions()->count() > 0)
        <div class="bg-white/10 backdrop-blur-lg rounded-xl p-8 border border-white/20 mb-6">
            <h2 class="text-2xl font-bold text-white mb-4">Permisos Asignados</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($usuario->getAllPermissions() as $permission)
                <span class="px-3 py-1 text-xs rounded-full bg-blue-500/20 text-blue-300 border border-blue-500/30">
                    {{ $permission->name }}
                </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Acciones -->
        <div class="flex gap-4">
            <a href="{{ route('universal.usuarios.lista') }}"
               class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-lg transition-all duration-300">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver
            </a>

            @can('usuarios.editar')
            <a href="{{ route('universal.usuarios.editar', $usuario->id) }}"
               class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-lg transition-all duration-300">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Editar Usuario
            </a>
            @endcan

            @can('usuarios.eliminar')
            <form action="{{ route('universal.usuarios.eliminar', $usuario->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('¿Estás seguro de eliminar este usuario?')"
                        class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-lg transition-all duration-300">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Eliminar
                </button>
            </form>
            @endcan
        </div>
    </div>
</div>
@endsection
