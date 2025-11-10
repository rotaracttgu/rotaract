@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Perfil') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Botón de Regreso -->
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver al Inicio
                </a>
            </div>

            <!-- Navegación de pestañas -->
            <div class="mb-8">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8" aria-label="Pestañas">
                        <button 
                            id="tab-info" 
                            class="tab-button active whitespace-nowrap border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600" 
                            onclick="showTab('info')">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Información Personal
                        </button>
                        
                        <button 
                            id="tab-profile" 
                            class="tab-button whitespace-nowrap border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" 
                            onclick="showTab('profile')">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar Perfil
                        </button>
                        
                        <button 
                            id="tab-password" 
                            class="tab-button whitespace-nowrap border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700" 
                            onclick="showTab('password')">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Cambiar Contraseña
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Contenido de las pestañas -->
            <div class="space-y-6">
                
                <!-- Pestaña: Información Personal -->
                <div id="content-info" class="tab-content">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                        <div class="px-6 py-8">
                            <div class="flex items-center justify-center mb-8">
                                <div class="h-24 w-24 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                            </div>
                            
                            <div class="text-center mb-8">
                                <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                                <p class="mt-2 text-lg text-gray-600">{{ $user->email }}</p>
                                <div class="mt-4 flex items-center justify-center">
                                    @if($user->email_verified_at)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Email Verificado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                            Verificación Pendiente
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Información Detallada -->
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <!-- Fecha de Registro -->
                                <div class="bg-gray-50 rounded-xl p-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-500">Miembro desde</p>
                                            <p class="text-lg font-semibold text-gray-900">{{ $user->created_at->format('d/m/Y') }}</p>
                                            <p class="text-sm text-gray-600">{{ $user->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Última Actualización -->
                                <div class="bg-gray-50 rounded-xl p-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-500">Última Actualización</p>
                                            <p class="text-lg font-semibold text-gray-900">{{ $user->updated_at->format('d/m/Y') }}</p>
                                            <p class="text-sm text-gray-600">{{ $user->updated_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pestaña: Editar Perfil -->
                <div id="content-profile" class="tab-content hidden">
                    <div class="bg-white shadow-xl sm:rounded-2xl">
                        <div class="px-6 py-8">
                            <div class="max-w-xl mx-auto">
                                @include('modulos.profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pestaña: Cambiar Contraseña -->
                <div id="content-password" class="tab-content hidden">
                    <div class="bg-white shadow-xl sm:rounded-2xl">
                        <div class="px-6 py-8">
                            <div class="max-w-xl mx-auto">
                                @include('modulos.profile.partials.update-password-form')
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección de eliminar cuenta (siempre visible abajo) -->
                <div class="bg-red-50 shadow-xl sm:rounded-2xl border border-red-200">
                    <div class="px-6 py-8">
                        <div class="max-w-xl mx-auto">
                            @include('modulos.profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Ocultar todo el contenido
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => content.classList.add('hidden'));
            
            // Desactivar todos los botones
            const buttons = document.querySelectorAll('.tab-button');
            buttons.forEach(button => {
                button.classList.remove('active', 'border-blue-500', 'text-blue-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Mostrar contenido seleccionado
            document.getElementById('content-' + tabName).classList.remove('hidden');
            
            // Activar botón seleccionado
            const activeButton = document.getElementById('tab-' + tabName);
            activeButton.classList.remove('border-transparent', 'text-gray-500');
            activeButton.classList.add('active', 'border-blue-500', 'text-blue-600');
        }

        // Mostrar la primera pestaña por defecto
        document.addEventListener('DOMContentLoaded', function() {
            showTab('info');
        });
    </script>
@endsection
