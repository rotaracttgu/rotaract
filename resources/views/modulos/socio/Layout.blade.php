<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title', 'Dashboard') - Rotaract Fuerza Tegucigalpa Sur</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col">

        <!-- Header Superior -->
        <header class="bg-white shadow-sm border-b border-gray-200 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">

                    <!-- Logo + Nombre del Club -->
                        <!-- Logo del Club (mostrar sólo el logo, quitar título textual) -->
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('images/Logo_Rotaract.webp') }}" alt="Rotaract" class="h-10">
                        </div>

                    <!-- Right Side -->
                    <div class="flex items-center space-x-6">
                        <button class="relative text-gray-600 hover:text-gray-900 transition">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 h-3 w-3 bg-red-500 rounded-full"></span>
                        </button>

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-3 text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none">
                                @php $socioDisplay = Auth::user()->username ?? Auth::user()->name; @endphp
                                <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-orange-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                    {{ strtoupper(substr($socioDisplay, 0, 1)) }}
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="font-medium">{{ $socioDisplay }}</p>
                                        <p class="text-xs text-gray-500">Socio</p>
                                </div>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>

                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50 border">
                                <a href="{{ route('perfil.editar') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Perfil</a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Contenido Principal con Sidebar -->
        <div class="flex flex-1 overflow-hidden">

            <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

            <aside id="sidebar" 
                   class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-900 to-blue-800 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-xl flex flex-col">
                
                <div class="flex items-center justify-between h-16 px-6 bg-blue-950 border-b border-blue-700">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-graduate text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold">Aspirante</h2>
                            <p class="text-xs text-blue-300">{{ Auth::user()->username ?? Auth::user()->name }}</p>
                        </div>
                    </div>
                    <button id="closeSidebar" class="lg:hidden text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <a href="{{ route('socio.dashboard') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('socio.dashboard') ? 'bg-blue-700 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                        <i class="fas fa-home w-5"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>

                    <a href="{{ route('socio.calendario') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('socio.calendario') ? 'bg-blue-700 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                        <i class="fas fa-calendar-alt w-5"></i>
                        <span class="ml-3">Calendario</span>
                        <span class="ml-auto text-xs bg-blue-600 px-2 py-1 rounded-full">Solo Lectura</span>
                    </a>

                    <a href="{{ route('socio.proyectos') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('socio.proyectos*') ? 'bg-blue-700 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                        <i class="fas fa-project-diagram w-5"></i>
                        <span class="ml-3">Mis Proyectos</span>
                    </a>

                    <a href="{{ route('socio.reuniones') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('socio.reuniones*') ? 'bg-blue-700 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                        <i class="fas fa-users w-5"></i>
                        <span class="ml-3">Mis Reuniones</span>
                    </a>

                    <div class="my-4 border-t border-blue-700"></div>
                    <div class="px-4 py-2 text-xs font-semibold text-blue-300 uppercase tracking-wider">Comunicación</div>

                    <a href="{{ route('socio.secretaria.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('socio.secretaria*') ? 'bg-blue-700 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                        <i class="fas fa-envelope w-5"></i>
                        <span class="ml-3">Secretaría</span>
                        @if(isset($consultasSecretariaPendientes) && $consultasSecretariaPendientes > 0)
                            <span class="ml-auto bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                {{ $consultasSecretariaPendientes }}
                            </span>
                        @endif
                    </a>

                        <!-- Eliminado: Vocalía (no se utiliza) -->

                    <div class="my-4 border-t border-blue-700"></div>
                    <div class="px-4 py-2 text-xs font-semibold text-blue-300 uppercase tracking-wider">Personal</div>

                    <a href="{{ route('socio.notas.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('socio.notas*') ? 'bg-blue-700 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                        <i class="fas fa-sticky-note w-5"></i>
                        <span class="ml-3">Blog de Notas</span>
                        @if(isset($notasActivas) && $notasActivas > 0)
                            <span class="ml-auto text-xs text-blue-300">{{ $notasActivas }}</span>
                        @endif
                    </a>

                    <!-- ELIMINADO: Mi Perfil del sidebar -->
                </nav>
            </aside>

            <main class="flex-1 overflow-y-auto bg-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">
                            @yield('page-title', 'Dashboard')
                        </h1>
                    </div>

                    @if(session('success'))
                        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                                <p class="text-green-700 font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                                <p class="text-red-700 font-medium">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>

        <button id="openSidebar" 
                class="lg:hidden fixed bottom-6 right-6 bg-blue-600 text-white p-4 rounded-full shadow-lg z-50 hover:bg-blue-700 transition">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>

    @stack('scripts')

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

        openBtn?.addEventListener('click', openSidebar);
        closeBtn?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);

        document.querySelectorAll('#sidebar a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) closeSidebar();
            });
        });
    </script>
</body>
</html>