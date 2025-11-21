@extends('modulos.socio.layout')

@section('page-title', 'Mi Perfil')

@section('content')
    <div class="mb-6">
        <a href="{{ route('socio.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold text-sm text-white transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Dashboard
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Tarjeta de Perfil -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg p-6 sticky top-6">
                <!-- Avatar -->
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-blue-400 to-green-400 text-white text-3xl font-bold mb-4">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ Auth::user()->name }}</h2>
                    <p class="text-gray-500 text-sm mt-1">{{ $miembro->Rol }}</p>
                    <div class="mt-3">
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full font-semibold">Socio Activo</span>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="space-y-2 border-t border-gray-200 pt-6">
                    <a href="{{ route('socio.perfil.editar') }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold text-sm transition">
                        <i class="fas fa-edit mr-2"></i> Editar Perfil
                    </a>
                    <a href="{{ route('perfil.editar') }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-semibold text-sm transition">
                        <i class="fas fa-key mr-2"></i> Cambiar Contraseña
                    </a>
                </div>
            </div>
        </div>

        <!-- Información Detallada -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Información Personal -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user-circle text-blue-600 mr-2"></i>
                    Información Personal
                </h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Nombre Completo</p>
                            <p class="text-gray-800 font-semibold">{{ Auth::user()->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Usuario</p>
                            <p class="text-gray-800 font-semibold">{{ Auth::user()->username ?? 'No disponible' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contacto -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-envelope text-green-600 mr-2"></i>
                    Información de Contacto
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Correo Electrónico</p>
                        <p class="text-gray-800 font-semibold">{{ Auth::user()->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Teléfono</p>
                        <p class="text-gray-800 font-semibold">{{ Auth::user()->phone ?? 'No registrado' }}</p>
                    </div>
                </div>
            </div>

            <!-- Información de Identidad -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-id-card text-orange-600 mr-2"></i>
                    Información de Identidad
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">DNI/Pasaporte</p>
                        <p class="text-gray-800 font-semibold">{{ $miembro->user->dni ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Estado en el Club</p>
                        <p class="text-gray-800 font-semibold">{{ $miembro->Apuntes }}</p>
                    </div>
                </div>
            </div>

            <!-- Rol y Responsabilidades -->
            <div class="bg-gradient-to-r from-blue-50 to-green-50 rounded-xl shadow-lg p-6 border border-blue-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-briefcase text-blue-600 mr-2"></i>
                    Rol en el Club
                </h3>
                <div class="space-y-2">
                    <p class="text-gray-700"><strong>Rol:</strong> {{ $miembro->Rol }}</p>
                    <p class="text-gray-700"><strong>Estado:</strong> <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full font-semibold">Activo</span></p>
                    <p class="text-sm text-gray-600 mt-3">Como Socio, tienes acceso a todas las actividades del club. Participa activamente en proyectos y reuniones para avanzar en tu trayectoria.</p>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">Proyectos Participando</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $proyectosActivos ?? 0 }}</h3>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">Reuniones Asistidas</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $reunionesAsistidas ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
