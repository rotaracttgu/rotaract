<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Presidente</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <div class="flex">
            <!-- Overlay para cerrar el menú en móvil -->
            <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

            <!-- Sidebar Mejorado con Responsive -->
            <aside id="sidebar" class="fixed lg:static w-64 bg-white shadow-xl min-h-screen border-r border-gray-200 flex-shrink-0 z-40 -translate-x-full lg:translate-x-0 transition-transform duration-300">
                <!-- Header del Sidebar -->
                <div class="p-6 bg-gradient-to-br from-purple-600 via-purple-700 to-pink-700 text-white flex justify-between items-center">
                    <h2 class="text-xl font-bold">Presidente</h2>
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
                    <a href="{{ route('presidente.dashboard') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('presidente.dashboard') ? 'bg-purple-500 text-white shadow-md' : 'text-gray-700 hover:bg-purple-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Inicio
                    </a>

                    <!-- Cartas Patrocinio -->
                    <a href="{{ route('presidente.cartas.patrocinio') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('presidente.cartas.patrocinio') ? 'bg-purple-500 text-white shadow-md' : 'text-gray-700 hover:bg-purple-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Cartas Patrocinio
                    </a>

                    <!-- Cartas Formales -->
                    <a href="{{ route('presidente.cartas.formales') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('presidente.cartas.formales') ? 'bg-purple-500 text-white shadow-md' : 'text-gray-700 hover:bg-purple-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Cartas Formales
                    </a>

                    <!-- Estado Proyectos -->
                    <a href="{{ route('presidente.estado.proyectos') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('presidente.estado.proyectos') ? 'bg-purple-500 text-white shadow-md' : 'text-gray-700 hover:bg-purple-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Estado Proyectos
                    </a>

                    <!-- Gestión de Usuarios -->
                    <a href="{{ route('presidente.usuarios.lista') }}" 
                       class="flex items-center px-4 py-3 mb-1 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('presidente.usuarios.*') ? 'bg-purple-500 text-white shadow-md' : 'text-gray-700 hover:bg-purple-50' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Gestión de Usuarios
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
            <main class="flex-1 p-4 lg:p-6 max-w-full overflow-x-hidden">
                <!-- Botón menú hamburguesa para móvil -->
                <button id="openSidebar" class="lg:hidden fixed bottom-6 right-6 bg-blue-600 text-white p-4 rounded-full shadow-lg z-50 hover:bg-blue-700 transition-colors">
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

