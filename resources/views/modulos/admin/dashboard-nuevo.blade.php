@extends('layouts.app-admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-indigo-950">
    
    <!-- Header con Gradiente -->
    <div class="bg-gradient-to-r from-red-500 via-pink-600 to-purple-600 p-8 shadow-2xl">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="bg-white/20 rounded-full p-4 backdrop-blur-sm">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-black text-white">👑 Panel de Administración</h1>
                        <p class="text-white/90 text-lg font-medium mt-1">Bienvenido al panel de control del Super Admin</p>
                    </div>
                </div>
            </div>

            <!-- Fecha y Hora -->
            <div class="mt-4 flex items-center space-x-4 text-white/90">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-sm font-medium">📅 {{ now()->format('d/m/Y') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium">🕐 {{ now()->format('H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="space-y-6">
            
            <!-- ⭐ Contenedor para carga AJAX (Roles, Permisos, etc.) -->
            <div id="config-content" class="min-h-screen">
                <!-- Por defecto muestra el overview, AJAX cargará aquí Roles/Permisos -->
                @include('modulos.admin.partials.overview')
            </div>

        </div>
    </div>
</div>
@endsection