<!-- Sidebar Lateral para Super Admin -->
<aside id="sidebar" class="fixed left-0 top-0 h-full bg-gray-900 text-white transition-all duration-300 z-40 pt-20 overflow-y-auto overflow-x-hidden shadow-2xl"
       x-data="{ sidebarOpen: false }" 
       :class="sidebarOpen ? 'w-80 translate-x-0' : 'w-80 lg:translate-x-0 -translate-x-full lg:translate-x-0'"
       style="top: 80px;">
    
    <!-- Overlay para móviles -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-30 lg:hidden"
         x-transition>
    </div>
    
    <div class="flex flex-col h-full">
        
        <!-- Menú de Módulos -->
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-gray-800">
            
            <!-- 1. MÓDULO PRESIDENTE -->
            <div x-data="{ open: false }" class="mb-1 group">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-3 rounded-lg hover:bg-purple-700/30 transition-all duration-200 group hover:shadow-lg hover:shadow-purple-500/20">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <i class="fas fa-crown text-purple-400 flex-shrink-0 group-hover:text-purple-300"></i>
                        <span class="font-semibold text-sm truncate">Presidente</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs flex-shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-transition x-collapse class="mt-1 ml-2 space-y-0.5 border-l border-purple-700/30 pl-3">
                    <a href="{{ route('admin.presidente.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-purple-700/40 transition-all text-xs {{ request()->routeIs('admin.presidente.dashboard') ? 'bg-purple-600/50 text-purple-200' : 'text-gray-300 hover:text-white' }}">
                        <i class="fas fa-home text-xs flex-shrink-0"></i>
                        <span class="truncate">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.presidente.cartas.patrocinio') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-purple-700/40 transition-all text-xs {{ request()->routeIs('admin.presidente.cartas.patrocinio') ? 'bg-purple-600/50 text-purple-200' : 'text-gray-300 hover:text-white' }}">
                        <i class="fas fa-envelope text-xs flex-shrink-0"></i>
                        <span class="truncate">Cartas Patrocinio</span>
                    </a>
                    <a href="{{ route('admin.presidente.cartas.formales') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-purple-700/40 transition-all text-xs {{ request()->routeIs('admin.presidente.cartas.formales') ? 'bg-purple-600/50 text-purple-200' : 'text-gray-300 hover:text-white' }}">
                        <i class="fas fa-file-alt text-xs flex-shrink-0"></i>
                        <span class="truncate">Cartas Formales</span>
                    </a>
                    <a href="{{ route('admin.presidente.estado.proyectos') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-purple-700/40 transition-all text-xs {{ request()->routeIs('admin.presidente.estado.proyectos') ? 'bg-purple-600/50 text-purple-200' : 'text-gray-300 hover:text-white' }}">
                        <i class="fas fa-chart-line text-xs flex-shrink-0"></i>
                        <span class="truncate">Estado Proyectos</span>
                    </a>
                </div>
            </div>

            <!-- 2. MÓDULO VICEPRESIDENTE -->
            <div x-data="{ open: false }" class="mb-1 group">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-3 rounded-lg hover:bg-blue-700/30 transition-all duration-200 group hover:shadow-lg hover:shadow-blue-500/20">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <i class="fas fa-user-tie text-blue-400 flex-shrink-0 group-hover:text-blue-300"></i>
                        <span class="font-semibold text-sm truncate">Vicepresidente</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs flex-shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-transition x-collapse class="mt-1 ml-2 space-y-0.5 border-l border-blue-700/30 pl-3">
                    <a href="{{ route('vicepresidente.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700/40 transition-all text-xs {{ request()->routeIs('vicepresidente.dashboard') ? 'bg-blue-600/50 text-blue-200' : 'text-gray-300 hover:text-white' }}">
                        <i class="fas fa-home text-xs flex-shrink-0"></i>
                        <span class="truncate">Dashboard</span>
                    </a>
                    <a href="{{ route('vicepresidente.cartas.patrocinio') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700/40 transition-all text-xs {{ request()->routeIs('vicepresidente.cartas.patrocinio') ? 'bg-blue-600/50 text-blue-200' : 'text-gray-300 hover:text-white' }}">
                        <i class="fas fa-envelope text-xs flex-shrink-0"></i>
                        <span class="truncate">Cartas Patrocinio</span>
                    </a>
                    <a href="{{ route('vicepresidente.cartas.formales') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700/40 transition-all text-xs {{ request()->routeIs('vicepresidente.cartas.formales') ? 'bg-blue-600/50 text-blue-200' : 'text-gray-300 hover:text-white' }}">
                        <i class="fas fa-file-alt text-xs flex-shrink-0"></i>
                        <span class="truncate">Cartas Formales</span>
                    </a>
                    <a href="{{ route('vicepresidente.estado.proyectos') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700/40 transition-all text-xs {{ request()->routeIs('vicepresidente.estado.proyectos') ? 'bg-blue-600/50 text-blue-200' : 'text-gray-300 hover:text-white' }}">
                        <i class="fas fa-chart-line text-xs flex-shrink-0"></i>
                        <span class="truncate">Estado Proyectos</span>
                    </a>
                    <a href="{{ route('vicepresidente.usuarios.lista') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-700/40 transition-all text-xs {{ request()->routeIs('vicepresidente.usuarios.*') ? 'bg-blue-600/50 text-blue-200' : 'text-gray-300 hover:text-white' }}">
                        <i class="fas fa-users text-xs flex-shrink-0"></i>
                        <span class="truncate">Gestión Usuarios</span>
                    </a>
                </div>
            </div>

            <!-- 3. MÓDULO TESORERO -->
            <div x-data="{ open: false }" class="mb-1 group">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-3 rounded-lg hover:bg-green-700/30 transition-all duration-200 group hover:shadow-lg hover:shadow-green-500/20">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <i class="fas fa-coins text-green-400 flex-shrink-0 group-hover:text-green-300"></i>
                        <span class="font-semibold text-sm truncate">Tesorero</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs flex-shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-transition x-collapse class="mt-1 ml-2 space-y-0.5 border-l border-green-700/30 pl-3">
                    <a href="{{ route('tesorero.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-700/40 transition-all text-xs {{ request()->routeIs('tesorero.dashboard') ? 'bg-green-600/50 text-green-200' : 'text-gray-300 hover:text-white' }}">
                        <i class="fas fa-home text-xs flex-shrink-0"></i>
                        <span class="truncate">Dashboard</span>
                    </a>
                    <a href="{{ route('tesorero.ingresos.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-700/40 transition-all text-xs {{ request()->routeIs('tesorero.ingresos.*') ? 'bg-green-600/50 text-green-200' : 'text-gray-300 hover:text-white' }}">
                        <i class="fas fa-arrow-up text-xs flex-shrink-0"></i>
                        <span class="truncate">Registrar Ingreso</span>
                    </a>
                    <a href="{{ route('tesorero.gastos.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-700/40 transition-all text-xs {{ request()->routeIs('tesorero.gastos.*') ? 'bg-green-600/50 text-green-200' : 'text-gray-300 hover:text-white' }}">
                        <i class="fas fa-arrow-down text-xs flex-shrink-0"></i>
                        <span class="truncate">Registrar Gasto</span>
                    </a>
                    <a href="{{ route('tesorero.membresias.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-green-700/40 transition-all text-xs {{ request()->routeIs('tesorero.membresias.*') ? 'bg-green-600/50 text-green-200' : 'text-gray-300 hover:text-white' }}">
                        <i class="fas fa-id-card text-xs flex-shrink-0"></i>
                        <span class="truncate">Nueva Membresía</span>
                    </a>
                </div>
            </div>

            <!-- 4. MÓDULO SECRETARÍA -->
            <div x-data="{ open: false }" class="mb-2">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-3 rounded-lg hover:bg-pink-700/30 transition-all duration-200 group hover:shadow-lg hover:shadow-pink-500/20">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <i class="fas fa-file-pen text-pink-400 flex-shrink-0 group-hover:text-pink-300"></i>
                        <span class="font-semibold text-sm truncate">Secretaría</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs flex-shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="mt-1 ml-3 space-y-1 border-l-2 border-pink-500/50 pl-2">
                    <a href="{{ route('secretaria.actas.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-gray-800 transition-colors text-xs truncate {{ request()->routeIs('secretaria.actas.*') ? 'bg-pink-600/30 text-pink-300' : 'text-gray-300' }}">
                        <i class="fas fa-file-contract text-xs flex-shrink-0"></i>
                        <span class="truncate">Actas</span>
                    </a>
                    <a href="{{ route('secretaria.documentos.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-gray-800 transition-colors text-xs truncate {{ request()->routeIs('secretaria.documentos.*') ? 'bg-pink-600/30 text-pink-300' : 'text-gray-300' }}">
                        <i class="fas fa-folder text-xs flex-shrink-0"></i>
                        <span class="truncate">Documentos</span>
                    </a>
                    <a href="{{ route('secretaria.calendario') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-gray-800 transition-colors text-xs truncate {{ request()->routeIs('secretaria.calendario') ? 'bg-pink-600/30 text-pink-300' : 'text-gray-300' }}">
                        <i class="fas fa-calendar text-xs flex-shrink-0"></i>
                        <span class="truncate">Calendario</span>
                    </a>
                </div>
            </div>

            <!-- 5. MÓDULO VOCERO/MACERO -->
            <div x-data="{ open: false }" class="mb-2">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-3 rounded-lg hover:bg-orange-700/30 transition-all duration-200 group hover:shadow-lg hover:shadow-orange-500/20">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <i class="fas fa-megaphone text-orange-400 flex-shrink-0 group-hover:text-orange-300"></i>
                        <span class="font-semibold text-sm truncate">Vocero</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs flex-shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="mt-1 ml-3 space-y-1 border-l-2 border-orange-500/50 pl-2">
                    <a href="{{ route('vocero.dashboard') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-gray-800 transition-colors text-xs truncate {{ request()->routeIs('vocero.dashboard') ? 'bg-orange-600/30 text-orange-300' : 'text-gray-300' }}">
                        <i class="fas fa-chart-bar text-xs flex-shrink-0"></i>
                        <span class="truncate">Dashboard</span>
                    </a>
                    <a href="{{ route('vocero.eventos') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-gray-800 transition-colors text-xs truncate {{ request()->routeIs('vocero.eventos') ? 'bg-orange-600/30 text-orange-300' : 'text-gray-300' }}">
                        <i class="fas fa-calendar text-xs flex-shrink-0"></i>
                        <span class="truncate">Eventos</span>
                    </a>
                    <a href="{{ route('vocero.asistencias') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-gray-800 transition-colors text-xs truncate {{ request()->routeIs('vocero.asistencias') ? 'bg-orange-600/30 text-orange-300' : 'text-gray-300' }}">
                        <i class="fas fa-user-check text-xs flex-shrink-0"></i>
                        <span class="truncate">Asistencias</span>
                    </a>
                </div>
            </div>

            <!-- 6. MÓDULO SOCIO/ASPIRANTE -->
            <div x-data="{ open: false }" class="mb-2">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-3 rounded-lg hover:bg-cyan-700/30 transition-all duration-200 group hover:shadow-lg hover:shadow-cyan-500/20">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <i class="fas fa-user text-cyan-400 flex-shrink-0 group-hover:text-cyan-300"></i>
                        <span class="font-semibold text-sm truncate">Socio</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs flex-shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="mt-1 ml-3 space-y-1 border-l-2 border-cyan-500/50 pl-2">
                    <a href="{{ route('socio.dashboard') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-gray-800 transition-colors text-xs truncate {{ request()->routeIs('socio.dashboard') ? 'bg-cyan-600/30 text-cyan-300' : 'text-gray-300' }}">
                        <i class="fas fa-home text-xs flex-shrink-0"></i>
                        <span class="truncate">Dashboard</span>
                    </a>
                    <a href="{{ route('socio.proyectos') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-gray-800 transition-colors text-xs truncate {{ request()->routeIs('socio.proyectos*') ? 'bg-cyan-600/30 text-cyan-300' : 'text-gray-300' }}">
                        <i class="fas fa-project-diagram text-xs flex-shrink-0"></i>
                        <span class="truncate">Proyectos</span>
                    </a>
                    <a href="{{ route('socio.reuniones') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-gray-800 transition-colors text-xs truncate {{ request()->routeIs('socio.reuniones*') ? 'bg-cyan-600/30 text-cyan-300' : 'text-gray-300' }}">
                        <i class="fas fa-users text-xs flex-shrink-0"></i>
                        <span class="truncate">Reuniones</span>
                    </a>
                    <a href="{{ route('socio.calendario') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-gray-800 transition-colors text-xs truncate {{ request()->routeIs('socio.calendario') ? 'bg-cyan-600/30 text-cyan-300' : 'text-gray-300' }}">
                        <i class="fas fa-calendar text-xs flex-shrink-0"></i>
                        <span class="truncate">Calendario</span>
                    </a>
                </div>
            </div>

            <!-- Divisor -->
            <div class="border-t border-gray-700 my-4"></div>

            <!-- 7. CONFIGURACIONES -->
            <div x-data="{ open: true }" class="mb-2">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-3 rounded-lg hover:bg-gray-700/30 transition-all duration-200 group hover:shadow-lg hover:shadow-gray-500/20">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <i class="fas fa-cog text-gray-400 flex-shrink-0 group-hover:text-gray-200"></i>
                        <span class="font-semibold text-sm truncate">Configuración</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs flex-shrink-0 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="mt-1 ml-3 space-y-1 border-l-2 border-gray-600/50 pl-2">
                    <a href="{{ route('admin.usuarios.lista') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-gray-800 transition-colors text-xs truncate {{ request()->routeIs('admin.usuarios.*') ? 'bg-gray-700/30 text-gray-200' : 'text-gray-300' }}">
                        <i class="fas fa-users text-xs flex-shrink-0"></i>
                        <span class="truncate">Usuarios</span>
                    </a>
                    <a href="{{ route('admin.usuarios-bloqueados.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-gray-800 transition-colors text-xs truncate {{ request()->routeIs('admin.usuarios.bloqueados') ? 'bg-gray-700/30 text-gray-200' : 'text-gray-300' }}">
                        <i class="fas fa-user-slash text-xs flex-shrink-0"></i>
                        <span class="truncate">Bloqueados</span>
                    </a>
                    <a href="{{ route('admin.configuracion.roles.ajax') }}" class="ajax-load flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-gray-800 transition-colors text-xs truncate text-gray-300" data-target="#config-content" data-section="roles">
                        <i class="fas fa-user-tag text-xs flex-shrink-0"></i>
                        <span class="truncate">Roles</span>
                    </a>
                    <a href="{{ route('admin.configuracion.permisos.ajax') }}" class="ajax-load flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-gray-800 transition-colors text-xs truncate text-gray-300" data-target="#config-content" data-section="permisos">
                        <i class="fas fa-key text-xs flex-shrink-0"></i>
                        <span class="truncate">Permisos</span>
                    </a>
                    <a href="{{ route('admin.bitacora.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-gray-800 transition-colors text-xs truncate {{ request()->routeIs('admin.bitacora.*') ? 'bg-gray-700/30 text-gray-200' : 'text-gray-300' }}">
                        <i class="fas fa-history text-xs flex-shrink-0"></i>
                        <span class="truncate">Bitácora</span>
                    </a>
                    <a href="{{ route('admin.backup.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-gray-800 transition-colors text-xs truncate {{ request()->routeIs('admin.backup.*') ? 'bg-gray-700/30 text-gray-200' : 'text-gray-300' }}">
                        <i class="fas fa-database text-xs flex-shrink-0"></i>
                        <span class="truncate">Backup</span>
                    </a>
                </div>
            </div>

        </nav>

        <!-- Footer del Sidebar -->
        <div class="p-3 border-t border-gray-800 mt-auto flex-shrink-0 bg-gray-800/50">
            <div class="flex items-center gap-2 px-3 py-2 text-xs text-gray-400 bg-gray-700/50 rounded-lg">
                <i class="fas fa-shield-alt"></i>
                <span class="truncate">Panel Super Admin</span>
            </div>
        </div>
    </div>
</aside>

<style>
    [x-cloak] { display: none !important; }
    
    .scrollbar-thin::-webkit-scrollbar {
        width: 6px;
    }
    .scrollbar-thin::-webkit-scrollbar-track {
        background: rgba(107, 114, 128, 0.1);
        border-radius: 3px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: rgba(107, 114, 128, 0.5);
        border-radius: 3px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: rgba(107, 114, 128, 0.7);
    }
    
    /* Responsive sidebar para móviles */
    @media (max-width: 1023px) {
        #sidebar {
            width: 20rem !important;
            height: 100vh;
        }
    }
</style>

<script>
    // Exponer en Window para navbar
    if (typeof window.toggleSidebar === 'undefined') {
        window.toggleSidebar = function() {
            // Alpine.js manejará esto
            console.log('Sidebar toggle');
        }
    }
</script>