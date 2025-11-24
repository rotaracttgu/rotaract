<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Tesorero</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50">
    <div class="min-h-screen">
        @if(!request()->has('embed'))
        @include('layouts.navigation')
        @endif

        <div class="flex">
            <!-- Overlay para cerrar el menú en móvil -->
            <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

            <!-- Sidebar Mejorado con Responsive y Fixed -->
            <aside id="sidebar" class="fixed top-0 left-0 w-64 h-screen bg-white shadow-xl border-r border-gray-200 z-40 -translate-x-full lg:translate-x-0 transition-transform duration-300 overflow-y-auto">
                <!-- Header del Sidebar -->
                <div class="p-6 bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600 text-white flex justify-between items-center sticky top-0 z-10">
                    <h2 class="text-xl font-bold">Tesorero</h2>
                    <!-- Botón cerrar en móvil -->
                    <button id="closeSidebar" class="lg:hidden text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Navegación -->
                <nav class="p-3">
                    <!-- Inicio -->
                    <a href="{{ route('tesorero.dashboard') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('tesorero.dashboard') ? 'bg-emerald-500 text-white shadow-md' : 'text-gray-700 hover:bg-emerald-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Inicio
                    </a>

                    <!-- Divider -->
                    <div class="my-3 border-t border-gray-200"></div>
                    <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Transacciones</div>

                    <!-- Ingresos -->
                    <a href="{{ route('tesorero.ingresos.index') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('tesorero.ingresos.*') ? 'bg-emerald-500 text-white shadow-md' : 'text-gray-700 hover:bg-emerald-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Ingresos
                    </a>

                    <!-- Gastos -->
                    <a href="{{ route('tesorero.gastos.index') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('tesorero.gastos.*') ? 'bg-emerald-500 text-white shadow-md' : 'text-gray-700 hover:bg-emerald-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Gastos
                    </a>

                    <!-- Movimientos -->
                    <a href="{{ route('tesorero.movimientos.index') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('tesorero.movimientos.*') ? 'bg-emerald-500 text-white shadow-md' : 'text-gray-700 hover:bg-emerald-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        Movimientos
                    </a>

                    <!-- Divider -->
                    <div class="my-3 border-t border-gray-200"></div>
                    <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Gestión</div>

                    <!-- Membresías -->
                    <a href="{{ route('tesorero.membresias.index') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('tesorero.membresias.*') ? 'bg-emerald-500 text-white shadow-md' : 'text-gray-700 hover:bg-emerald-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Membresías
                    </a>

                    <!-- Presupuestos -->
                    <a href="{{ route('tesorero.presupuestos.index') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('tesorero.presupuestos.*') ? 'bg-emerald-500 text-white shadow-md' : 'text-gray-700 hover:bg-emerald-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Presupuestos
                    </a>

                    <!-- Divider -->
                    <div class="my-3 border-t border-gray-200"></div>
                    <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Análisis</div>

                    <!-- Reportes -->
                    <a href="{{ route('tesorero.reportes.index') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('tesorero.reportes.*') ? 'bg-emerald-500 text-white shadow-md' : 'text-gray-700 hover:bg-emerald-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Reportes
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

            <!-- Contenido Principal con margen para el sidebar -->
            <main class="flex-1 p-4 lg:p-6 max-w-full overflow-x-hidden lg:ml-64">
                <!-- Botón menú hamburguesa para móvil -->
                <button id="openSidebar" class="lg:hidden fixed bottom-6 right-6 bg-emerald-600 text-white p-4 rounded-full shadow-lg z-50 hover:bg-emerald-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div class="max-w-7xl mx-auto">
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

                    @if(session('success'))
                        <div id="success-notification" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative flex items-center" role="alert">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                                </svg>
                            </button>
                        </div>
                        <script>
                            setTimeout(() => {
                                const notification = document.getElementById('success-notification');
                                if (notification) {
                                    notification.style.transition = 'opacity 0.5s ease-out';
                                    notification.style.opacity = '0';
                                    setTimeout(() => notification.remove(), 500);
                                }
                            }, 5000);
                        </script>
                    @endif

                    @if(session('error'))
                        <div id="error-notification" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative flex items-center" role="alert">
                            <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">{{ session('error') }}</span>
                            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                                </svg>
                            </button>
                        </div>
                        <script>
                            setTimeout(() => {
                                const notification = document.getElementById('error-notification');
                                if (notification) {
                                    notification.style.transition = 'opacity 0.5s ease-out';
                                    notification.style.opacity = '0';
                                    setTimeout(() => notification.remove(), 500);
                                }
                            }, 5000);
                        </script>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- JavaScript para controlar el menú móvil -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        openBtn.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);

        // Cerrar menú al hacer clic en un enlace (solo en móvil)
        const sidebarLinks = sidebar.querySelectorAll('a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    closeSidebar();
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>