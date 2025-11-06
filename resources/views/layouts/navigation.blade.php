<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-28">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/LogoRotaract.png') }}" alt="Rotaract Logo" class="block h-16 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(!request()->routeIs('presidente.*') && !request()->routeIs('vicepresidente.*') && !request()->routeIs('perfil.*'))
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        @role('Super Admin|Presidente')
                            <!-- Gestión de Usuarios -->
                            <x-nav-link :href="route('admin.usuarios.lista')" :active="request()->routeIs('admin.usuarios.*')">
                                {{ __('Usuarios') }}
                            </x-nav-link>

                            <!-- Usuarios Bloqueados -->
                            <x-nav-link :href="route('admin.usuarios-bloqueados.index')" :active="request()->routeIs('admin.usuarios-bloqueados.*')">
                                <span class="flex items-center">
                                    {{ __('Bloqueados') }}
                                    @php
                                        $bloqueados = \App\Models\User::where('is_locked', true)->count();
                                    @endphp
                                    @if($bloqueados > 0)
                                        <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                                            {{ $bloqueados }}
                                        </span>
                                    @endif
                                </span>
                            </x-nav-link>

                            <!-- Bitácora del Sistema -->
                            <a class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('admin.bitacora.index') }}">
                                Bitácora
                            </a>

                            {{-- ⭐ NUEVO: Menú de Backup --}}
                            <a class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.backup.*') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500' }} text-sm font-medium leading-5 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('admin.backup.index') }}">
                                Backup
                            </a>
                        @endrole
                    @endif

                    {{-- Menú de Vicepresidente ocultado - Ahora usa el sidebar lateral --}}
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                <!-- Icono de Notificaciones - Dinámico según rol -->
                @php
                    $notificacionesRoute = null;
                    if (auth()->user()->hasRole('Super Admin')) {
                        $notificacionesRoute = route('admin.notificaciones');
                    } elseif (auth()->user()->hasRole('Presidente')) {
                        $notificacionesRoute = route('presidente.notificaciones');
                    } elseif (auth()->user()->hasRole('Vicepresidente')) {
                        $notificacionesRoute = route('vicepresidente.notificaciones');
                    } elseif (auth()->user()->hasRole('Vocero')) {
                        $notificacionesRoute = route('vocero.notificaciones');
                    } elseif (auth()->user()->hasRole('Secretario')) {
                        $notificacionesRoute = route('secretaria.notificaciones');
                    } elseif (auth()->user()->hasRole('Tesorero')) {
                        $notificacionesRoute = route('tesorero.notificaciones');
                    } elseif (auth()->user()->hasRole('Aspirante')) {
                        $notificacionesRoute = route('aspirante.notificaciones');
                    }
                    
                    // Contar notificaciones no leídas
                    $notificacionesNoLeidas = \App\Models\Notificacion::where('usuario_id', auth()->id())->where('leida', false)->count();
                @endphp
                
                @if($notificacionesRoute)
                    <a href="{{ $notificacionesRoute }}" class="relative inline-flex items-center p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full transition-colors duration-150" title="Notificaciones">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <!-- Badge de notificaciones no leídas -->
                        @if($notificacionesNoLeidas > 0)
                            <span data-notificaciones-badge class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full animate-pulse">
                                {{ $notificacionesNoLeidas }}
                            </span>
                        @else
                            <span data-notificaciones-badge class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full animate-pulse hidden">
                                0
                            </span>
                        @endif
                    </a>
                @endif

                <!-- Dropdown del Usuario - Oculto en la página de perfil -->
                @if(!request()->routeIs('perfil.editar'))
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-3 px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-150 shadow-sm">
                                <!-- Avatar con iniciales -->
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 text-white font-semibold text-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                
                                <!-- Nombre y Rol -->
                                <div class="flex flex-col items-start">
                                    <span class="font-semibold text-gray-900">{{ Auth::user()->name }}</span>
                                    <span class="text-xs text-gray-500">{{ Auth::user()->getRoleNames()->first() }}</span>
                                </div>

                                <!-- Icono flecha -->
                                <svg class="fill-current h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('perfil.editar')">
                                {{ __('Perfil') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Salir') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <!-- En la página de perfil, mostrar solo botón de Salir -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-150 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                </svg>
                                <span>Menú</span>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Salir') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endif
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @role('Super Admin|Presidente')
                <!-- Gestión de Usuarios (Mobile) -->
                <x-responsive-nav-link :href="route('admin.usuarios.lista')" :active="request()->routeIs('admin.usuarios.*')">
                    {{ __('Usuarios') }}
                </x-responsive-nav-link>

                <!-- Usuarios Bloqueados (Mobile) -->
                <x-responsive-nav-link :href="route('admin.usuarios-bloqueados.index')" :active="request()->routeIs('admin.usuarios-bloqueados.*')">
                    <span class="flex items-center justify-between">
                        <span>{{ __('Bloqueados') }}</span>
                        @php
                            $bloqueados = \App\Models\User::where('is_locked', true)->count();
                        @endphp
                        @if($bloqueados > 0)
                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                                {{ $bloqueados }}
                            </span>
                        @endif
                    </span>
                </x-responsive-nav-link>

                <!-- Bitácora del Sistema (Mobile) -->
                <a class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('admin.bitacora.index') }}">
                    Bitácora
                </a>

                {{-- ⭐ NUEVO: Backup (Mobile) --}}
                <a class="block w-full ps-3 pe-4 py-2 border-l-4 {{ request()->routeIs('admin.backup.*') ? 'border-indigo-400' : 'border-transparent' }} text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('admin.backup.index') }}">
                    Backup
                </a>
            @endrole

            @role('Vicepresidente')
                <!-- Menú Vicepresidente (Mobile) -->
                <div class="pt-2 pb-2 border-t border-gray-200">
                    <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase">
                        👔 Módulo Vicepresidente
                    </div>
                    <x-responsive-nav-link :href="route('vicepresidente.dashboard')" :active="request()->routeIs('vicepresidente.dashboard')">
                        📊 Dashboard
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('vicepresidente.cartas.patrocinio')" :active="request()->routeIs('vicepresidente.cartas.patrocinio')">
                        📝 Cartas de Patrocinio
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('vicepresidente.cartas.formales')" :active="request()->routeIs('vicepresidente.cartas.formales')">
                        📧 Cartas Formales
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('vicepresidente.estado.proyectos')" :active="request()->routeIs('vicepresidente.estado.proyectos')">
                        📂 Estado de Proyectos
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('vicepresidente.usuarios.lista')" :active="request()->routeIs('vicepresidente.usuarios.*')">
                        � Gestión de Usuarios
                    </x-responsive-nav-link>
                </div>
            @endrole
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('perfil.editar')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>