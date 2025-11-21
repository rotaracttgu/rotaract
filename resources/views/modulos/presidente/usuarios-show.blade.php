@extends('modulos.presidente.layout')

@section('content')
    <!-- Header -->
    <div class="mb-6 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 rounded-xl p-6 shadow-lg text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold flex items-center">
                    <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Detalle del Usuario
                </h1>
                <p class="text-blue-100 mt-2">Información completa de {{ $usuario->name }}</p>
            </div>
            <div class="flex items-center space-x-3">
                @can('usuarios.editar')
                <a href="{{ route('presidente.usuarios.editar', $usuario->id) }}"
                    class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg hover:bg-blue-50 font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar
                </a>
                @endcan
                <a href="{{ route('presidente.usuarios.lista') }}"
                    class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-lg hover:bg-white/30 font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver
                </a>
            </div>
        </div>
    </div>

    <!-- Información del Usuario -->
    <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3">Información Personal</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nombre -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Nombre Completo</label>
                <p class="text-gray-900 text-lg font-semibold">{{ $usuario->name }} {{ $usuario->apellidos }}</p>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Correo Electrónico</label>
                <p class="text-gray-900">{{ $usuario->email }}</p>
            </div>

            <!-- Teléfono -->
            @if($usuario->telefono)
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Teléfono</label>
                <p class="text-gray-900">{{ $usuario->telefono }}</p>
            </div>
            @endif

            <!-- DNI -->
            @if($usuario->dni)
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">DNI</label>
                <p class="text-gray-900">{{ $usuario->dni }}</p>
            </div>
            @endif

            <!-- Rol -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Rol</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($usuario->roles as $role)
                    @php
                        $roleColors = [
                            'Super Admin' => 'bg-red-100 text-red-800',
                            'Presidente' => 'bg-purple-100 text-purple-800',
                            'Vicepresidente' => 'bg-blue-100 text-blue-800',
                            'Tesorero' => 'bg-orange-100 text-orange-800',
                            'Secretaría' => 'bg-green-100 text-green-800',
                            'Vocero' => 'bg-yellow-100 text-yellow-800',
                            'Socio' => 'bg-gray-100 text-gray-800',
                        ];
                        $colorClass = $roleColors[$role->name] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-3 py-1 text-sm rounded-full font-semibold {{ $colorClass }}">
                        {{ $role->name }}
                    </span>
                    @endforeach
                </div>
            </div>

            <!-- Estado de Verificación -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Estado de Verificación</label>
                @if($usuario->email_verified_at)
                <span class="inline-flex items-center px-3 py-1 text-sm rounded-full bg-green-100 text-green-800 font-semibold">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Email Verificado
                </span>
                @else
                <span class="inline-flex items-center px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800 font-semibold">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Pendiente de Verificación
                </span>
                @endif
            </div>

            <!-- Estado Activo -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Estado</label>
                @if($usuario->activo)
                <span class="inline-flex items-center px-3 py-1 text-sm rounded-full bg-green-100 text-green-800 font-semibold">
                    Activo
                </span>
                @else
                <span class="inline-flex items-center px-3 py-1 text-sm rounded-full bg-red-100 text-red-800 font-semibold">
                    Inactivo
                </span>
                @endif
            </div>

            <!-- Rotary ID -->
            @if($usuario->rotary_id)
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Rotary ID</label>
                <p class="text-gray-900">{{ $usuario->rotary_id }}</p>
            </div>
            @endif

            <!-- Fecha de Juramentación -->
            @if($usuario->fecha_juramentacion)
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Fecha de Juramentación</label>
                <p class="text-gray-900">{{ \Carbon\Carbon::parse($usuario->fecha_juramentacion)->format('d/m/Y') }}</p>
            </div>
            @endif

            <!-- Fecha de Cumpleaños -->
            @if($usuario->fecha_cumpleaños)
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Fecha de Cumpleaños</label>
                <p class="text-gray-900">{{ \Carbon\Carbon::parse($usuario->fecha_cumpleaños)->format('d/m/Y') }}</p>
            </div>
            @endif

            <!-- Fecha de Registro -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Fecha de Registro</label>
                <p class="text-gray-900">{{ $usuario->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <!-- Última Actualización -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Última Actualización</label>
                <p class="text-gray-900">{{ $usuario->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Permisos del Usuario -->
    @if($usuario->getAllPermissions()->count() > 0)
    <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3">Permisos Asignados</h2>
        <div class="flex flex-wrap gap-2">
            @foreach($usuario->getAllPermissions() as $permission)
            <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-800 font-semibold">
                {{ $permission->name }}
            </span>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Acciones -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('presidente.usuarios.lista') }}"
                class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver a la Lista
            </a>

            @can('usuarios.editar')
            <a href="{{ route('presidente.usuarios.editar', $usuario->id) }}"
                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Editar Usuario
            </a>
            @endcan

            @can('usuarios.eliminar')
            <form action="{{ route('presidente.usuarios.eliminar', $usuario->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('¿Estás seguro de eliminar al usuario {{ $usuario->name }}? Esta acción no se puede deshacer.')"
                        class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Eliminar Usuario
                </button>
            </form>
            @endcan
        </div>
    </div>
@endsection
