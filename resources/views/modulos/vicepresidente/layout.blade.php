<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Vicepresidente</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <div class="flex pt-16">
            <!-- Sidebar Mejorado -->
            <aside class="w-64 bg-white shadow-lg min-h-screen border-r border-gray-200 flex-shrink-0">
                <!-- Header del Sidebar -->
                <div class="p-6 bg-gradient-to-br from-blue-500 to-blue-600 text-white">
                    <h2 class="text-xl font-bold">Vicepresidente</h2>
                </div>
                
                <!-- Navegación -->
                <nav class="p-3">
                    <!-- Inicio -->
                    <a href="{{ route('vicepresidente.dashboard') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('vicepresidente.dashboard') ? 'bg-blue-500 text-white shadow-md' : 'text-gray-700 hover:bg-blue-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Inicio
                    </a>

                    <!-- Calendario -->
                    <a href="{{ route('vicepresidente.calendario') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('vicepresidente.calendario') ? 'bg-blue-500 text-white shadow-md' : 'text-gray-700 hover:bg-blue-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Calendario
                    </a>

                    <!-- Cartas Patrocinio -->
                    <a href="{{ route('vicepresidente.cartas.patrocinio') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('vicepresidente.cartas.patrocinio') ? 'bg-blue-500 text-white shadow-md' : 'text-gray-700 hover:bg-blue-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Cartas Patrocinio
                    </a>

                    <!-- Cartas Formales -->
                    <a href="{{ route('vicepresidente.cartas.formales') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('vicepresidente.cartas.formales') ? 'bg-blue-500 text-white shadow-md' : 'text-gray-700 hover:bg-blue-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Cartas Formales
                    </a>

                    <!-- Estado Proyectos -->
                    <a href="{{ route('vicepresidente.estado.proyectos') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('vicepresidente.estado.proyectos') ? 'bg-blue-500 text-white shadow-md' : 'text-gray-700 hover:bg-blue-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Estado Proyectos
                    </a>

                    <!-- Asist. Reuniones -->
                    <a href="{{ route('vicepresidente.asistencia.reuniones') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('vicepresidente.asistencia.reuniones') ? 'bg-blue-500 text-white shadow-md' : 'text-gray-700 hover:bg-blue-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Asist. Reuniones
                    </a>

                    <!-- Particip. Proyectos -->
                    <a href="{{ route('vicepresidente.asistencia.proyectos') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('vicepresidente.asistencia.proyectos') ? 'bg-blue-500 text-white shadow-md' : 'text-gray-700 hover:bg-blue-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Particip. Proyectos
                    </a>
                </nav>

                <!-- Footer -->
                <div class="mt-auto p-4 border-t border-gray-200 bg-white">
                    <div class="flex items-center text-xs text-gray-600">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                        <span>Sistema Activo</span>
                    </div>
                </div>
            </aside>

            <!-- Contenido Principal -->
            <main class="flex-1 p-6 max-w-full overflow-x-hidden">
                <div class="max-w-7xl mx-auto">
                    <!-- Mensajes de Éxito/Error -->
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                                </svg>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                                </svg>
                            </button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">¡Ups! Hay algunos errores:</strong>
                            <ul class="mt-2 ml-4 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                                </svg>
                            </button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
