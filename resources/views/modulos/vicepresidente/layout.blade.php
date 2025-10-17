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
                    <!-- Dashboard -->
                    <a href="{{ route('vicepresidente.dashboard') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('vicepresidente.dashboard') ? 'bg-blue-500 text-white shadow-md' : 'text-gray-700 hover:bg-blue-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        Dashboard
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
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
