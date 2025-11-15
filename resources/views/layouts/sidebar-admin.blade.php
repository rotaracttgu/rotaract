<!-- Sidebar Lateral para Super Admin -->
<aside id="sidebar" class="fixed left-0 top-0 h-full bg-gray-900 text-white transition-all duration-300 z-40 pt-28 overflow-hidden" style="width: 280px;">
    <div class="flex flex-col h-full overflow-y-auto">
        
        <!-- Menú de Módulos -->
        <nav class="flex-1 px-4 py-6 space-y-2">
            
            <!-- 1. MÓDULO PRESIDENTE -->
            <div x-data="{ open: false }" class="mb-2">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-purple-700 transition-colors duration-200 group">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-crown text-purple-400 group-hover:text-white"></i>
                        <span class="font-semibold">Presidente</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="mt-2 ml-4 space-y-1">
                    <a href="{{ route('presidente.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.presidente.dashboard') ? 'bg-purple-600' : '' }}">
                        <i class="fas fa-home text-sm"></i>
                        <span class="text-sm">Dashboard</span>
                    </a>
                    <a href="{{ route('presidente.cartas.patrocinio') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('presidente.cartas.patrocinio') ? 'bg-purple-600' : '' }}">
                        <i class="fas fa-envelope text-sm"></i>
                        <span class="text-sm">Cartas Patrocinio</span>
                    </a>
                    <a href="{{ route('presidente.cartas.formales') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('presidente.cartas.formales') ? 'bg-purple-600' : '' }}">
                        <i class="fas fa-file-alt text-sm"></i>
                        <span class="text-sm">Cartas Formales</span>
                    </a>
                    <a href="{{ route('presidente.estado.proyectos') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('presidente.estado.proyectos') ? 'bg-purple-600' : '' }}">
                        <i class="fas fa-chart-line text-sm"></i>
                        <span class="text-sm">Estado Proyectos</span>
                    </a>
                    <a href="{{ route('presidente.usuarios.lista') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('presidente.usuarios.*') ? 'bg-purple-600' : '' }}">
                        <i class="fas fa-users text-sm"></i>
                        <span class="text-sm">Gestión de Usuarios</span>
                    </a>
                </div>
            </div>

            <!-- 2. MÓDULO VICEPRESIDENTE -->
            <div x-data="{ open: false }" class="mb-2">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 group">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-user-tie text-blue-400 group-hover:text-white"></i>
                        <span class="font-semibold">Vicepresidente</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="mt-2 ml-4 space-y-1">
                    <a href="{{ route('vicepresidente.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('vicepresidente.dashboard') ? 'bg-blue-600' : '' }}">
                        <i class="fas fa-home text-sm"></i>
                        <span class="text-sm">Dashboard</span>
                    </a>
                    <a href="{{ route('vicepresidente.cartas.patrocinio') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('vicepresidente.cartas.patrocinio') ? 'bg-blue-600' : '' }}">
                        <i class="fas fa-envelope text-sm"></i>
                        <span class="text-sm">Cartas Patrocinio</span>
                    </a>
                    <a href="{{ route('vicepresidente.cartas.formales') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('vicepresidente.cartas.formales') ? 'bg-blue-600' : '' }}">
                        <i class="fas fa-file-alt text-sm"></i>
                        <span class="text-sm">Cartas Formales</span>
                    </a>
                    <a href="{{ route('vicepresidente.estado.proyectos') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('vicepresidente.estado.proyectos') ? 'bg-blue-600' : '' }}">
                        <i class="fas fa-chart-line text-sm"></i>
                        <span class="text-sm">Estado Proyectos</span>
                    </a>
                    <a href="{{ route('vicepresidente.usuarios.lista') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('vicepresidente.usuarios.*') ? 'bg-blue-600' : '' }}">
                        <i class="fas fa-users text-sm"></i>
                        <span class="text-sm">Gestión de Usuarios</span>
                    </a>
                </div>
            </div>

            <!-- 3. MÓDULO TESORERO -->
            <div x-data="{ open: false }" class="mb-2">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-green-700 transition-colors duration-200 group">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-coins text-green-400 group-hover:text-white"></i>
                        <span class="font-semibold">Tesorero</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="mt-2 ml-4 space-y-1">
                    <a href="{{ route('tesorero.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('tesorero.dashboard') ? 'bg-green-600' : '' }}">
                        <i class="fas fa-home text-sm"></i>
                        <span class="text-sm">Dashboard</span>
                    </a>
                    <a href="{{ route('tesorero.ingresos.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('tesorero.ingresos.*') ? 'bg-green-600' : '' }}">
                        <i class="fas fa-arrow-up text-sm"></i>
                        <span class="text-sm">Registrar Ingreso</span>
                    </a>
                    <a href="{{ route('tesorero.gastos.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('tesorero.gastos.*') ? 'bg-green-600' : '' }}">
                        <i class="fas fa-arrow-down text-sm"></i>
                        <span class="text-sm">Registrar Gasto</span>
                    </a>
                    <a href="{{ route('tesorero.membresias.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('tesorero.membresias.*') ? 'bg-green-600' : '' }}">
                        <i class="fas fa-id-card text-sm"></i>
                        <span class="text-sm">Nueva Membresía</span>
                    </a>
                </div>
            </div>

            <!-- 4. MÓDULO SECRETARÍA -->
            <div x-data="{ open: false, openCrear: false }" class="mb-2">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-pink-700 transition-colors duration-200 group">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-file-signature text-pink-400 group-hover:text-white"></i>
                        <span class="font-semibold">Secretaría</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="mt-2 ml-4 space-y-1">
                    <a href="{{ route('secretaria.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('secretaria.dashboard') ? 'bg-pink-600' : '' }}">
                        <i class="fas fa-home text-sm"></i>
                        <span class="text-sm">Dashboard</span>
                    </a>
                    <a href="{{ route('secretaria.consultas.pendientes') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('secretaria.consultas.pendientes') ? 'bg-pink-600' : '' }}">
                        <i class="fas fa-comments text-sm"></i>
                        <span class="text-sm">Consultas Pendientes</span>
                    </a>
                    
                    <!-- Submenú: Crear Nuevo -->
                    <div class="ml-2">
                        <button @click="openCrear = !openCrear" class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-plus-circle text-sm"></i>
                                <span class="text-sm">Crear Nuevo</span>
                            </div>
                            <i class="fas fa-chevron-right text-xs transition-transform duration-200" :class="openCrear ? 'rotate-90' : ''"></i>
                        </button>
                        <div x-show="openCrear" x-collapse class="mt-1 ml-4 space-y-1">
                            <a href="{{ route('secretaria.actas.index') }}?action=create" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors text-xs">
                                <i class="fas fa-file-contract"></i>
                                <span>Nueva Acta</span>
                            </a>
                            <a href="{{ route('secretaria.diplomas.index') }}?action=create" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors text-xs">
                                <i class="fas fa-certificate"></i>
                                <span>Nuevo Diploma</span>
                            </a>
                            <a href="{{ route('secretaria.documentos.index') }}?action=create" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors text-xs">
                                <i class="fas fa-folder-plus"></i>
                                <span>Nuevo Documento</span>
                            </a>
                            <a href="{{ route('secretaria.consultas') }}?action=create" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors text-xs">
                                <i class="fas fa-question-circle"></i>
                                <span>Nueva Consulta</span>
                            </a>
                        </div>
                    </div>
                    
                    <a href="{{ route('secretaria.actas.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('secretaria.actas.*') ? 'bg-pink-600' : '' }}">
                        <i class="fas fa-file-contract text-sm"></i>
                        <span class="text-sm">Actas Registradas</span>
                    </a>
                    <a href="{{ route('secretaria.documentos.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('secretaria.documentos.*') ? 'bg-pink-600' : '' }}">
                        <i class="fas fa-folder text-sm"></i>
                        <span class="text-sm">Documentos Archivados</span>
                    </a>
                    <a href="{{ route('secretaria.calendario') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('secretaria.calendario') ? 'bg-pink-600' : '' }}">
                        <i class="fas fa-calendar text-sm"></i>
                        <span class="text-sm">Calendario</span>
                    </a>
                </div>
            </div>

            <!-- 5. MÓDULO VOCERO/MACERO -->
            <div x-data="{ open: false }" class="mb-2">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-orange-700 transition-colors duration-200 group">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-calendar-check text-orange-400 group-hover:text-white"></i>
                        <span class="font-semibold">Macero</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="mt-2 ml-4 space-y-1">
                    <a href="{{ route('vocero.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('vocero.dashboard') ? 'bg-orange-600' : '' }}">
                        <i class="fas fa-chart-bar text-sm"></i>
                        <span class="text-sm">Resumen General</span>
                    </a>
                    <a href="{{ route('vocero.calendario') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('vocero.calendario') ? 'bg-orange-600' : '' }}">
                        <i class="fas fa-calendar text-sm"></i>
                        <span class="text-sm">Calendario</span>
                    </a>
                    <a href="{{ route('vocero.eventos') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('vocero.eventos') ? 'bg-orange-600' : '' }}">
                        <i class="fas fa-calendar-plus text-sm"></i>
                        <span class="text-sm">Gestión de Eventos</span>
                    </a>
                    <a href="{{ route('vocero.asistencias') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('vocero.asistencias') ? 'bg-orange-600' : '' }}">
                        <i class="fas fa-user-check text-sm"></i>
                        <span class="text-sm">Asistencias</span>
                    </a>
                    <a href="{{ route('vocero.reportes') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('vocero.reportes') ? 'bg-orange-600' : '' }}">
                        <i class="fas fa-file-chart-line text-sm"></i>
                        <span class="text-sm">Reportes</span>
                    </a>
                </div>
            </div>

            <!-- 6. MÓDULO SOCIO/ASPIRANTE -->
            <div x-data="{ open: false }" class="mb-2">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-cyan-700 transition-colors duration-200 group">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-user text-cyan-400 group-hover:text-white"></i>
                        <span class="font-semibold">Socio</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="mt-2 ml-4 space-y-1">
                    <a href="{{ route('socio.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('socio.dashboard') ? 'bg-cyan-600' : '' }}">
                        <i class="fas fa-home text-sm"></i>
                        <span class="text-sm">Dashboard</span>
                    </a>
                    <a href="{{ route('socio.calendario') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('socio.calendario') ? 'bg-cyan-600' : '' }}">
                        <i class="fas fa-calendar text-sm"></i>
                        <span class="text-sm">Calendario</span>
                        <span class="text-xs bg-cyan-600 px-2 py-0.5 rounded-full">Solo Lectura</span>
                    </a>
                    <a href="{{ route('socio.proyectos') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('socio.proyectos*') ? 'bg-cyan-600' : '' }}">
                        <i class="fas fa-project-diagram text-sm"></i>
                        <span class="text-sm">Mis Proyectos</span>
                    </a>
                    <a href="{{ route('socio.reuniones') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('socio.reuniones*') ? 'bg-cyan-600' : '' }}">
                        <i class="fas fa-users text-sm"></i>
                        <span class="text-sm">Mis Reuniones</span>
                    </a>
                    <a href="{{ route('socio.secretaria.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('socio.secretaria.*') ? 'bg-cyan-600' : '' }}">
                        <i class="fas fa-envelope text-sm"></i>
                        <span class="text-sm">Secretaría</span>
                    </a>
                    <a href="{{ route('socio.notas.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('socio.notas.*') ? 'bg-cyan-600' : '' }}">
                        <i class="fas fa-sticky-note text-sm"></i>
                        <span class="text-sm">Blog de Notas</span>
                    </a>
                </div>
            </div>

            <!-- Divisor -->
            <div class="border-t border-gray-700 my-4"></div>

            <!-- 7. CONFIGURACIONES -->
            <div x-data="{ open: true }" class="mb-2">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 group">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-cog text-gray-400 group-hover:text-white"></i>
                        <span class="font-semibold">Configuraciones</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-collapse class="mt-2 ml-4 space-y-1">
                    
                    <!-- Usuarios -->
                    <a href="{{ route('admin.usuarios.lista') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.usuarios.*') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-users text-sm"></i>
                        <span class="text-sm">Usuarios</span>
                    </a>

                    <!-- Bloqueados -->
                    <a href="{{ route('admin.usuarios-bloqueados.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.usuarios.bloqueados') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-user-slash text-sm"></i>
                        <span class="text-sm">Bloqueados</span>
                        @php
                            $bloqueados = \App\Models\User::where('is_locked', true)->count();
                        @endphp
                        @if($bloqueados > 0)
                            <span class="ml-auto bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">{{ $bloqueados }}</span>
                        @endif
                    </a>

                    <!-- ⭐ ROLES (AJAX) -->
                    <a href="{{ route('admin.configuracion.roles.ajax') }}" 
                       class="ajax-load flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors text-sm"
                       data-target="#config-content"
                       data-section="roles">
                        <i class="fas fa-user-tag"></i>
                        <span>Roles</span>
                    </a>

                    <!-- ⭐ PERMISOS (AJAX) -->
                    <a href="{{ route('admin.configuracion.permisos.ajax') }}" 
                       class="ajax-load flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors text-sm"
                       data-target="#config-content"
                       data-section="permisos">
                        <i class="fas fa-key"></i>
                        <span>Permisos</span>
                    </a>

                    <!-- Bitácora -->
                    <a href="{{ route('admin.bitacora.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.bitacora.*') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-history text-sm"></i>
                        <span class="text-sm">Bitácora</span>
                    </a>

                    <!-- Backup -->
                    <a href="{{ route('admin.backup.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.backup.*') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-database text-sm"></i>
                        <span class="text-sm">Backup</span>
                    </a>
                </div>
            </div>

        </nav>

        <!-- Footer del Sidebar -->
        <div class="p-4 border-t border-gray-800">
            <div class="flex items-center gap-3 px-4 py-2 text-xs text-gray-400">
                <i class="fas fa-shield-alt"></i>
                <span>Super Admin Panel</span>
            </div>
        </div>
    </div>
</aside>

<!-- Overlay para móvil -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

<style>
    [x-cloak] { display: none !important; }
    #sidebar::-webkit-scrollbar {
        width: 6px;
    }
    #sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
    }
    #sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
    }
    #sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }
</style>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }
</script>