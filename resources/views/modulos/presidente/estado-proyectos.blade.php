@extends('modulos.presidente.layout')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Estado de Proyectos</h1>
            <p class="text-gray-600 mt-1">Vista general del estado de todos los proyectos</p>
        </div>
        <div class="flex gap-3">
            @can('proyectos.crear')
            <button onclick="abrirModalNuevoProyecto()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nuevo Proyecto
            </button>
            @endcan
            <a href="{{ route('presidente.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Dashboard
            </a>
        </div>
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <!-- Estadísticas generales -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105" onclick="filtrarPorEstadoProyecto('')">
                    <p class="text-sm text-indigo-100">Total Proyectos</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['total'] }}</p>
                    <p class="text-xs text-indigo-100 mt-1">Click para ver todos</p>
                </div>
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105" onclick="filtrarPorEstadoProyecto('Planificacion')">
                    <p class="text-sm text-yellow-100">En Planificación</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['enPlanificacion'] }}</p>
                    <p class="text-xs text-yellow-100 mt-1">Click para filtrar</p>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105" onclick="filtrarPorEstadoProyecto('EnEjecucion')">
                    <p class="text-sm text-blue-100">En Ejecución</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['enEjecucion'] }}</p>
                    <p class="text-xs text-blue-100 mt-1">Click para filtrar</p>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105" onclick="filtrarPorEstadoProyecto('Finalizado')">
                    <p class="text-sm text-green-100">Finalizados</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['finalizados'] }}</p>
                    <p class="text-xs text-green-100 mt-1">Click para filtrar</p>
                </div>
                <div class="bg-gradient-to-br from-red-500 to-red-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105" onclick="filtrarPorEstadoProyecto('Cancelado')">
                    <p class="text-sm text-red-100">Cancelados</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['cancelados'] }}</p>
                    <p class="text-xs text-red-100 mt-1">Click para filtrar</p>
                </div>
            </div>

            <!-- Panel principal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Todos los Proyectos</h3>
                        <div class="flex gap-2 items-center">
                            <!-- Selector de formato -->
                            <select id="formato-exportacion" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="pdf">PDF</option>
                                <option value="excel">Excel (CSV)</option>
                            </select>
                            <button onclick="exportarProyectos()" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-2 px-6 rounded-lg flex items-center gap-2 shadow-md hover:shadow-lg transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Exportar
                            </button>
                        </div>
                    </div>

                    <!-- Barra de búsqueda -->
                    <div class="mb-6">
                        <div class="relative">
                            <input type="text" id="buscador-proyectos" oninput="aplicarFiltrosProyectos()" placeholder="Buscar por nombre, área o responsable..." 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-10">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                            <select id="filtro-estado-proyecto" onchange="aplicarFiltrosProyectos()" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Todos</option>
                                <option value="Planificacion">Planificación</option>
                                <option value="EnEjecucion">En Ejecución</option>
                                <option value="Finalizado">Finalizado</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Área</label>
                            <select id="filtro-area-proyecto" onchange="aplicarFiltrosProyectos()" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Todas</option>
                                <option value="Educacion">Educación</option>
                                <option>Medio Ambiente</option>
                                <option>Salud</option>
                                <option>Social</option>
                                <option>Desarrollo Comunitario</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Responsable</label>
                            <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option>Todos</option>
                                <option>Juan Pérez</option>
                                <option>María García</option>
                                <option>Carlos López</option>
                                <option>Ana Martínez</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vista</label>
                            <select id="viewMode" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="toggleView()">
                                <option value="grid">Tarjetas</option>
                                <option value="table">Tabla</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Búsqueda</label>
                            <input type="text" placeholder="Buscar proyecto..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Vista de tarjetas -->
                    <div id="gridView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($proyectos as $proyecto)
                            @php
                                // Determinar estado del proyecto
                                if($proyecto->FechaFin) {
                                    $estado = 'Finalizado';
                                    $estadoClass = 'bg-green-100 text-green-800';
                                    $progressColor = 'bg-green-600';
                                    $progreso = 100;
                                } elseif($proyecto->FechaInicio) {
                                    $estado = 'EnEjecucion';
                                    $estadoClass = 'bg-blue-100 text-blue-800';
                                    $progressColor = 'bg-blue-600';
                                    // Calcular progreso basado en fechas
                                    if($proyecto->FechaFin) {
                                        $total = \Carbon\Carbon::parse($proyecto->FechaInicio)->diffInDays($proyecto->FechaFin);
                                        $transcurrido = \Carbon\Carbon::parse($proyecto->FechaInicio)->diffInDays(now());
                                        $progreso = $total > 0 ? min(100, round(($transcurrido / $total) * 100)) : 50;
                                    } else {
                                        $progreso = 50;
                                    }
                                } else {
                                    $estado = 'Planificacion';
                                    $estadoClass = 'bg-yellow-100 text-yellow-800';
                                    $progressColor = 'bg-yellow-500';
                                    $progreso = 10;
                                }
                            @endphp
                            <div class="bg-white border border-gray-200 rounded-lg p-5 hover:shadow-lg transition-shadow proyecto-card" 
                                 data-estado="{{ $estado }}" 
                                 data-area="{{ $proyecto->Area }}">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-800 mb-1">{{ $proyecto->Nombre }}</h4>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $estadoClass }}">{{ $estado }}</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mb-4">{{ Str::limit($proyecto->Descripcion ?? 'Sin descripción', 80) }}</p>
                            
                                <div class="space-y-2 text-xs mb-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Responsable:</span>
                                        <span class="font-medium text-gray-700">{{ $proyecto->responsable ? $proyecto->responsable->name : 'Sin asignar' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Área:</span>
                                        <span class="font-medium text-gray-700">{{ $proyecto->Area ?? 'N/A' }}</span>
                                    </div>
                                    @if($proyecto->FechaInicio)
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Inicio:</span>
                                            <span class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($proyecto->FechaInicio)->format('d/m/Y') }}</span>
                                        </div>
                                    @endif
                                    @if($proyecto->FechaFin)
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">{{ $estado == 'Finalizado' ? 'Finalizado:' : 'Fin previsto:' }}</span>
                                            <span class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($proyecto->FechaFin)->format('d/m/Y') }}</span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Participantes:</span>
                                        <span class="font-medium text-gray-700">{{ $proyecto->total_participantes ?? 0 }} socios</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Presupuesto:</span>
                                        <span class="font-medium text-green-700">L. {{ number_format($proyecto->Presupuesto ?? 0, 2) }}</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                                        <span>Progreso</span>
                                        <span class="font-semibold">{{ $progreso }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="{{ $progressColor }} h-2.5 rounded-full" style="width: {{ $progreso }}%"></div>
                                    </div>
                                </div>

                                <div class="flex gap-2">
                                    @can('proyectos.ver')
                                    <button class="flex-1 text-center text-sm text-indigo-600 hover:text-indigo-800 font-medium border border-indigo-200 rounded py-2 hover:bg-indigo-50 transition" onclick="verDetalleProyecto({{ $proyecto->ProyectoID }})">
                                        Ver detalles
                                    </button>
                                    @endcan
                                    @can('proyectos.editar')
                                    <button class="text-sm text-blue-600 hover:text-blue-800 font-medium border border-blue-200 rounded px-3 py-2 hover:bg-blue-50 transition" onclick="abrirModalParticipantes({{ $proyecto->ProyectoID }})" title="Participantes">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM6 20a9 9 0 0118 0v2h-2v-2a7 7 0 00-14 0v2H6v-2z"></path>
                                        </svg>
                                    </button>
                                    @endcan
                                    @can('proyectos.editar')
                                    <button class="text-sm text-yellow-600 hover:text-yellow-800 font-medium border border-yellow-200 rounded px-3 py-2 hover:bg-yellow-50 transition" onclick="editarProyecto({{ $proyecto->ProyectoID }})" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    @endcan
                                    @can('proyectos.eliminar')
                                    <button class="text-sm text-red-600 hover:text-red-800 font-medium border border-red-200 rounded px-3 py-2 hover:bg-red-50 transition" onclick="eliminarProyecto({{ $proyecto->ProyectoID }})" title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                    @endcan
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No hay proyectos registrados</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Vista de tabla (oculta por defecto) -->
                    <div id="tableView" class="hidden overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proyecto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsable</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Área</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progreso</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Presupuesto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($proyectos as $proyecto)
                                    @php
                                        // Determinar estado del proyecto (igual que arriba)
                                        if($proyecto->FechaFin) {
                                            $estadoTabla = 'Finalizado';
                                            $estadoClass = 'bg-green-100 text-green-800';
                                            $progressColor = 'bg-green-600';
                                            $progreso = 100;
                                        } elseif($proyecto->FechaInicio) {
                                            $estadoTabla = 'EnEjecucion';
                                            $estadoClass = 'bg-blue-100 text-blue-800';
                                            $progressColor = 'bg-blue-600';
                                            if($proyecto->FechaFin) {
                                                $total = \Carbon\Carbon::parse($proyecto->FechaInicio)->diffInDays($proyecto->FechaFin);
                                                $transcurrido = \Carbon\Carbon::parse($proyecto->FechaInicio)->diffInDays(now());
                                                $progreso = $total > 0 ? min(100, round(($transcurrido / $total) * 100)) : 50;
                                            } else {
                                                $progreso = 50;
                                            }
                                        } else {
                                            $estadoTabla = 'Planificacion';
                                            $estadoClass = 'bg-yellow-100 text-yellow-800';
                                            $progressColor = 'bg-yellow-500';
                                            $progreso = 10;
                                        }
                                    @endphp
                                    <tr class="hover:bg-gray-50" 
                                        data-estado="{{ $estadoTabla }}" 
                                        data-area="{{ $proyecto->Area }}">
                                        <td class="px-6 py-4">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $proyecto->Nombre }}</p>
                                                <p class="text-xs text-gray-500">
                                                    @if($proyecto->FechaInicio && $proyecto->FechaFin)
                                                        {{ \Carbon\Carbon::parse($proyecto->FechaInicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($proyecto->FechaFin)->format('d/m/Y') }}
                                                    @elseif($proyecto->FechaInicio)
                                                        Desde {{ \Carbon\Carbon::parse($proyecto->FechaInicio)->format('d/m/Y') }}
                                                    @else
                                                        En planificación
                                                    @endif
                                                </p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $proyecto->responsable ? $proyecto->responsable->name : 'Sin asignar' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $proyecto->Area ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $estadoClass }}">
                                                @if($estadoTabla == 'EnEjecucion')
                                                    En Ejecución
                                                @elseif($estadoTabla == 'Planificacion')
                                                    Planificación
                                                @else
                                                    {{ $estadoTabla }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="w-24">
                                                <div class="text-xs text-gray-600 mb-1">{{ $progreso }}%</div>
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="{{ $progressColor }} h-2 rounded-full" style="width: {{ $progreso }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">L. {{ number_format($proyecto->Presupuesto ?? 0, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex gap-2">
                                                @can('proyectos.ver')
                                                <button class="text-indigo-600 hover:text-indigo-900" onclick="verDetalleProyecto({{ $proyecto->ProyectoID }})">Ver</button>
                                                @endcan
                                                @can('proyectos.editar')
                                                <button class="text-yellow-600 hover:text-yellow-900" onclick="editarProyecto({{ $proyecto->ProyectoID }})">Editar</button>
                                                @endcan
                                                @can('proyectos.eliminar')
                                                <button class="text-red-600 hover:text-red-900" onclick="eliminarProyecto({{ $proyecto->ProyectoID }})">Eliminar</button>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                            <p class="mt-2 text-sm">No hay proyectos registrados</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Definir ruta base según el módulo
        const baseRoute = 'presidente';
        
        // Función de validación de caracteres repetidos
        function validarCaracteresRepetidos(input) {
            const value = input.value;
            const regex = /(.)\1{2,}/;
            const errorSpan = input.nextElementSibling;
            
            if (regex.test(value)) {
                input.classList.add('border-red-500');
                input.classList.remove('border-gray-300');
                if (errorSpan && errorSpan.classList.contains('error-message')) {
                    errorSpan.classList.remove('hidden');
                } else {
                    const span = document.createElement('span');
                    span.className = 'error-message text-red-500 text-sm mt-1';
                    span.textContent = 'No se permiten más de 2 caracteres repetidos consecutivos';
                    input.parentNode.insertBefore(span, input.nextSibling);
                }
                return false;
            } else {
                input.classList.remove('border-red-500');
                input.classList.add('border-gray-300');
                if (errorSpan && errorSpan.classList.contains('error-message')) {
                    errorSpan.classList.add('hidden');
                }
                return true;
            }
        }
        
        function toggleView() {
            const viewMode = document.getElementById('viewMode').value;
            const gridView = document.getElementById('gridView');
            const tableView = document.getElementById('tableView');
            
            if (viewMode === 'grid') {
                gridView.classList.remove('hidden');
                tableView.classList.add('hidden');
            } else {
                gridView.classList.add('hidden');
                tableView.classList.remove('hidden');
            }
        }

        // Función para ver detalles completos del proyecto
        function verDetalleProyecto(proyectoId) {
            fetch(`/${baseRoute}/proyectos/${proyectoId}/detalles`)
                .then(response => response.json())
                .then(data => {
                    mostrarModalDetalles(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al cargar los detalles del proyecto');
                });
        }

        // Mostrar modal con detalles completos
        function mostrarModalDetalles(proyecto) {
            const responsable = proyecto.responsable ? 
                `${proyecto.responsable.Nombre}` : 'N/A';
            
            const fechaInicio = proyecto.FechaInicio ? 
                new Date(proyecto.FechaInicio).toLocaleDateString('es-GT') : 'N/A';
            
            const fechaFin = proyecto.FechaFin ? 
                new Date(proyecto.FechaFin).toLocaleDateString('es-GT') : 'En curso';

            let participantesHTML = '<p class="text-gray-500 text-sm">No hay participantes registrados</p>';
            if (proyecto.participaciones && proyecto.participaciones.length > 0) {
                participantesHTML = '<div class="space-y-2">';
                proyecto.participaciones.forEach(p => {
                    const usuario = p.usuario || {};
                    participantesHTML += `
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="font-medium">${usuario.name || 'Participante'}</span>
                        </div>
                    `;
                });
                participantesHTML += '</div>';
            }

            let cartasHTML = '<p class="text-gray-500 text-sm">No hay cartas de patrocinio</p>';
            if (proyecto.cartas_patrocinio && proyecto.cartas_patrocinio.length > 0) {
                cartasHTML = '<div class="space-y-2">';
                proyecto.cartas_patrocinio.forEach(c => {
                    const badgeClass = c.estado === 'Aprobada' ? 'bg-green-100 text-green-800' :
                                       c.estado === 'Rechazada' ? 'bg-red-100 text-red-800' :
                                       'bg-yellow-100 text-yellow-800';
                    cartasHTML += `
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="font-medium">${c.destinatario}</span>
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-semibold">$${parseFloat(c.monto_solicitado).toFixed(2)}</span>
                                <span class="px-3 py-1 text-xs rounded-full font-medium ${badgeClass}">${c.estado}</span>
                            </div>
                        </div>
                    `;
                });
                cartasHTML += '</div>';
            }

            // Crear y mostrar el modal
            const modalHTML = `
                <div id="modalDetallesProyecto" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" onclick="cerrarModalDetalles(event)">
                    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 rounded-t-xl sticky top-0 z-10">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-2xl font-bold">${proyecto.Nombre}</h2>
                                    <p class="text-blue-100 mt-1">Proyecto #${proyecto.ProyectoID}</p>
                                </div>
                                <button onclick="cerrarModalDetalles()" class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="p-6 space-y-6">
                            <!-- Información General -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                                    <p class="text-sm text-gray-600 mb-1">Responsable</p>
                                    <p class="font-semibold text-gray-900">${responsable}</p>
                                </div>
                                <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-500">
                                    <p class="text-sm text-gray-600 mb-1">Estado</p>
                                    <p class="font-semibold text-gray-900">${proyecto.EstadoProyecto || proyecto.Estatus || 'N/A'}</p>
                                </div>
                                <div class="bg-purple-50 p-4 rounded-lg border-l-4 border-purple-500">
                                    <p class="text-sm text-gray-600 mb-1">Fecha Inicio</p>
                                    <p class="font-semibold text-gray-900">${fechaInicio}</p>
                                </div>
                                <div class="bg-orange-50 p-4 rounded-lg border-l-4 border-orange-500">
                                    <p class="text-sm text-gray-600 mb-1">Fecha Fin</p>
                                    <p class="font-semibold text-gray-900">${fechaFin}</p>
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Descripción
                                </h3>
                                <p class="text-gray-700 bg-gray-50 p-4 rounded-lg border border-gray-200">${proyecto.Descripcion || 'Sin descripción disponible'}</p>
                            </div>

                            <!-- Estadísticas -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-5 rounded-xl text-center shadow-sm">
                                    <p class="text-sm text-gray-600 mb-1">Presupuesto</p>
                                    <p class="text-2xl font-bold text-blue-600">$${parseFloat(proyecto.Presupuesto || 0).toFixed(2)}</p>
                                </div>
                                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-5 rounded-xl text-center shadow-sm">
                                    <p class="text-sm text-gray-600 mb-1">Participantes</p>
                                    <p class="text-2xl font-bold text-purple-600">${proyecto.total_participantes || 0}</p>
                                </div>
                                <div class="bg-gradient-to-br from-green-50 to-green-100 p-5 rounded-xl text-center shadow-sm">
                                    <p class="text-sm text-gray-600 mb-1">Horas Totales</p>
                                    <p class="text-2xl font-bold text-green-600">${proyecto.horas_totales || 0}</p>
                                </div>
                            </div>

                            <!-- Vínculos del Proyecto -->
                            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
                                <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                    Vínculos del Proyecto
                                </h3>
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700">Participaciones (tabla original):</span>
                                        <span class="font-bold ${proyecto.total_participaciones_originales > 0 ? 'text-red-600' : 'text-green-600'}">
                                            ${proyecto.total_participaciones_originales || 0}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700">Participaciones de proyectos:</span>
                                        <span class="font-bold ${proyecto.total_participantes > 0 ? 'text-red-600' : 'text-green-600'}">
                                            ${proyecto.total_participantes || 0}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700">Cartas de patrocinio:</span>
                                        <span class="font-bold ${proyecto.total_cartas_patrocinio > 0 ? 'text-red-600' : 'text-green-600'}">
                                            ${proyecto.total_cartas_patrocinio || 0}
                                        </span>
                                    </div>
                                    ${(proyecto.total_participaciones_originales > 0 || proyecto.total_participantes > 0 || proyecto.total_cartas_patrocinio > 0) ? 
                                        '<p class="text-sm text-red-600 mt-2 font-medium">⚠️ No se puede eliminar este proyecto porque tiene vínculos activos</p>' : 
                                        '<p class="text-sm text-green-600 mt-2 font-medium">✓ Este proyecto puede ser eliminado</p>'
                                    }
                                </div>
                            </div>

                            <!-- Participantes -->
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Participantes
                                </h3>
                                ${participantesHTML}
                            </div>

                            <!-- Cartas de Patrocinio -->
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    Cartas de Patrocinio
                                </h3>
                                ${cartasHTML}
                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-b-xl flex justify-end border-t border-gray-200">
                            <button onclick="cerrarModalDetalles()" class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-bold py-3 px-6 rounded-lg transition-all shadow-md hover:shadow-lg">
                                Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            `;

            document.body.insertAdjacentHTML('beforeend', modalHTML);
        }

        function cerrarModalDetalles(event) {
            if (event && event.target !== event.currentTarget) return;
            const modal = document.getElementById('modalDetallesProyecto');
            if (modal) {
                modal.remove();
            }
        }

        // Función unificada de exportación
        function exportarProyectos() {
            const formato = document.getElementById('formato-exportacion').value;
            const url = `{{ route('presidente.proyectos.exportar') }}?formato=${formato}`;
            window.location.href = url;
        }

        function exportarProyectosPDF() {
            // TODO: Implementar en Fase 4
            alert('Función de exportar PDF próximamente disponible');
        }

        function exportarProyectosExcel() {
            // TODO: Implementar en Fase 4
            alert('Función de exportar Excel próximamente disponible');
        }

        // Filtros y búsqueda para proyectos
        function filtrarPorEstadoProyecto(estado) {
            document.getElementById('filtro-estado-proyecto').value = estado;
            aplicarFiltrosProyectos();
        }

        function aplicarFiltrosProyectos() {
            const buscador = document.getElementById('buscador-proyectos').value.toLowerCase();
            const filtroEstado = document.getElementById('filtro-estado-proyecto').value;
            const filtroArea = document.getElementById('filtro-area-proyecto').value;
            
            // Filtrar cards en grid view
            const cards = document.querySelectorAll('#gridView .proyecto-card');
            let visiblesGrid = 0;
            
            cards.forEach(card => {
                const textoCard = card.textContent.toLowerCase();
                const estado = card.getAttribute('data-estado');
                const area = card.getAttribute('data-area');
                
                let mostrar = true;
                
                if (buscador && !textoCard.includes(buscador)) {
                    mostrar = false;
                }
                
                if (filtroEstado && estado !== filtroEstado) {
                    mostrar = false;
                }
                
                if (filtroArea && area !== filtroArea) {
                    mostrar = false;
                }
                
                card.style.display = mostrar ? '' : 'none';
                if (mostrar) visiblesGrid++;
            });
            
            // Filtrar filas en table view
            const filas = document.querySelectorAll('#tableView table tbody tr');
            let visiblesTable = 0;
            
            filas.forEach(fila => {
                if (fila.querySelector('td[colspan]')) return;
                
                const textoFila = fila.textContent.toLowerCase();
                const estado = fila.getAttribute('data-estado');
                const area = fila.getAttribute('data-area');
                
                let mostrar = true;
                
                if (buscador && !textoFila.includes(buscador)) {
                    mostrar = false;
                }
                
                if (filtroEstado && estado !== filtroEstado) {
                    mostrar = false;
                }
                
                if (filtroArea && area !== filtroArea) {
                    mostrar = false;
                }
                
                fila.style.display = mostrar ? '' : 'none';
                if (mostrar) visiblesTable++;
            });
            
            // Mostrar mensajes si no hay resultados (puedes agregar mensajes visuales si lo deseas)
            console.log(`Proyectos visibles - Grid: ${visiblesGrid}, Table: ${visiblesTable}`);
        }
        
        // Funciones CRUD Proyectos
        function abrirModalNuevoProyecto() {
            document.getElementById('modalNuevoProyecto').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function cerrarModalNuevoProyecto() {
            document.getElementById('modalNuevoProyecto').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('formNuevoProyecto').reset();
        }

        async function editarProyecto(id) {
            const modal = document.getElementById('modalEditarProyecto');
            const form = document.getElementById('formEditarProyecto');
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            try {
                const response = await fetch(`/presidente/proyectos/${id}/detalles`);
                const proyecto = await response.json();
                
                // Esperar un momento para asegurar que el modal esté completamente visible
                setTimeout(() => {
                    // Llenar TODOS los campos del formulario manteniendo valores previos
                    document.getElementById('edit_proyecto_id').value = proyecto.ProyectoID || '';
                    document.getElementById('edit_nombre').value = proyecto.Nombre || '';
                    document.getElementById('edit_descripcion').value = proyecto.Descripcion || '';
                    
                    // Formatear fechas correctamente (solo YYYY-MM-DD)
                    if (proyecto.FechaInicio) {
                        const fechaInicio = proyecto.FechaInicio.split(' ')[0];
                        document.getElementById('edit_fecha_inicio').value = fechaInicio;
                    } else {
                        document.getElementById('edit_fecha_inicio').value = '';
                    }
                    
                    if (proyecto.FechaFin) {
                        const fechaFin = proyecto.FechaFin.split(' ')[0];
                        document.getElementById('edit_fecha_fin').value = fechaFin;
                    } else {
                        document.getElementById('edit_fecha_fin').value = '';
                    }
                    
                    document.getElementById('edit_presupuesto').value = proyecto.Presupuesto || '';
                    document.getElementById('edit_tipo_proyecto').value = proyecto.TipoProyecto || '';
                    document.getElementById('edit_estatus').value = proyecto.Estatus || 'Activo';
                    document.getElementById('edit_responsable_id').value = proyecto.ResponsableID || '';
                    
                    form.action = `/${baseRoute}/proyectos/${id}`;
                }, 100);
            } catch (error) {
                console.error('Error:', error);
                alert('Error al cargar los datos del proyecto');
                cerrarModalEditarProyecto();
            }
        }

        function cerrarModalEditarProyecto() {
            document.getElementById('modalEditarProyecto').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('formEditarProyecto').reset();
        }

        function eliminarProyecto(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este proyecto? Esta acción no se puede deshacer.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/${baseRoute}/proyectos/${id}`;
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // ============ PARTICIPANTES ============

        function abrirModalParticipantes(proyectoId) {
            document.getElementById('proyectoId').value = proyectoId;
            document.getElementById('modalParticipantes').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Cargar participantes actuales
            cargarParticipantes(proyectoId);
        }

        function cerrarModalParticipantes() {
            document.getElementById('modalParticipantes').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('formAgregarParticipante').reset();
        }

        async function cargarParticipantes(proyectoId) {
            try {
                const response = await fetch(`/${baseRoute}/proyectos/${proyectoId}/participantes`);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const participantes = await response.json();
                
                const tbody = document.getElementById('participantesList');
                
                if (!participantes || participantes.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="px-4 py-3 text-center text-gray-500">No hay participantes</td></tr>';
                } else {
                    tbody.innerHTML = participantes.map(p => `
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900">${p.miembro_nombre}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">${p.rol_perfil || p.rol_participacion}</td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" onclick="eliminarParticipante(${proyectoId}, ${p.participacion_id})" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `).join('');
                }
            } catch (error) {
                console.error('Error al cargar participantes:', error);
                const tbody = document.getElementById('participantesList');
                tbody.innerHTML = `<tr><td colspan="4" class="px-4 py-3 text-center text-red-500">Error: ${error.message}</td></tr>`;
            }
        }

        async function agregarParticipante(event) {
            event.preventDefault();
            
            const proyectoId = document.getElementById('proyectoId').value;
            const miembroId = document.getElementById('miembroId').value;
            const rol = document.getElementById('rol').value;
            
            if (!miembroId) {
                alert('Por favor selecciona un miembro');
                return;
            }

            try {
                const response = await fetch(`/${baseRoute}/proyectos/${proyectoId}/participantes`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        miembro_id: miembroId,
                        rol: rol
                    })
                });

                if (response.ok) {
                    alert('Participante agregado correctamente');
                    document.getElementById('formAgregarParticipante').reset();
                    cargarParticipantes(proyectoId);
                } else {
                    alert('Error al agregar participante');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error en la solicitud');
            }
        }

        async function eliminarParticipante(proyectoId, participacionId) {
            if (!confirm('¿Eliminar este participante?')) return;

            try {
                const response = await fetch(`/${baseRoute}/proyectos/${proyectoId}/participantes/${participacionId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    cargarParticipantes(proyectoId);
                } else {
                    alert('Error al eliminar participante');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    </script>
    
    <!-- Modal Nuevo Proyecto -->
    <div id="modalNuevoProyecto" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-xl bg-white">
            <div class="bg-indigo-600 px-6 py-4 rounded-t-xl flex justify-between items-center">
                <h3 class="text-xl font-bold text-white">Nuevo Proyecto</h3>
                <button onclick="cerrarModalNuevoProyecto()" class="text-white hover:text-gray-200">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="formNuevoProyecto" action="{{ route('presidente.proyectos.store') }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Proyecto <span class="text-red-500">*</span></label>
                        <input type="text" name="Nombre" required
                               oninput="validarCaracteresRepetidos(this)"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="Nombre del proyecto">
                        <span class="error-message text-red-500 text-sm mt-1 hidden">No se permiten más de 2 caracteres repetidos consecutivos</span>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea name="Descripcion" rows="3"
                                  oninput="validarCaracteresRepetidos(this)"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                  placeholder="Descripción del proyecto"></textarea>
                        <span class="error-message text-red-500 text-sm mt-1 hidden">No se permiten más de 2 caracteres repetidos consecutivos</span>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Inicio</label>
                        <input type="date" name="FechaInicio"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Fin</label>
                        <input type="date" name="FechaFin"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Presupuesto (L.)</label>
                        <input type="number" name="Presupuesto" step="0.01" min="0"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="0.00">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Proyecto</label>
                        <select name="TipoProyecto"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Seleccionar tipo</option>
                            <option value="Educacion">Educación</option>
                            <option value="Medio Ambiente">Medio Ambiente</option>
                            <option value="Salud">Salud</option>
                            <option value="Social">Social</option>
                            <option value="Desarrollo Comunitario">Desarrollo Comunitario</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Responsable</label>
                        <select name="ResponsableID"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Sin asignar</option>
                            @foreach($miembros as $miembro)
                                @if($miembro->user)
                                    @php
                                        $nombreCompleto = trim($miembro->user->name . ' ' . ($miembro->user->apellidos ?? ''));
                                        $rol = $miembro->user->roles->first()?->name ?? 'Sin rol';
                                        $display = $nombreCompleto . ' - ' . $rol;
                                    @endphp
                                    <option value="{{ $miembro->MiembroID }}">{{ $display }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t flex justify-end gap-3">
                    <button type="button" onclick="cerrarModalNuevoProyecto()"
                            class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium shadow-md hover:shadow-lg">
                        Crear Proyecto
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar Proyecto -->
    <div id="modalEditarProyecto" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-xl bg-white">
            <div class="bg-yellow-600 px-6 py-4 rounded-t-xl flex justify-between items-center">
                <h3 class="text-xl font-bold text-white">Editar Proyecto</h3>
                <button onclick="cerrarModalEditarProyecto()" class="text-white hover:text-gray-200">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="formEditarProyecto" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_proyecto_id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Proyecto <span class="text-red-500">*</span></label>
                        <input type="text" id="edit_nombre" name="Nombre" required
                               oninput="validarCaracteresRepetidos(this)"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                        <span class="error-message text-red-500 text-sm mt-1 hidden">No se permiten más de 2 caracteres repetidos consecutivos</span>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea id="edit_descripcion" name="Descripcion" rows="3"
                                  oninput="validarCaracteresRepetidos(this)"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500"></textarea>
                        <span class="error-message text-red-500 text-sm mt-1 hidden">No se permiten más de 2 caracteres repetidos consecutivos</span>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Inicio</label>
                        <input type="date" id="edit_fecha_inicio" name="FechaInicio"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Fin</label>
                        <input type="date" id="edit_fecha_fin" name="FechaFin"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Presupuesto (L.)</label>
                        <input type="number" id="edit_presupuesto" name="Presupuesto" step="0.01" min="0"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Proyecto</label>
                        <select id="edit_tipo_proyecto" name="TipoProyecto"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                            <option value="">Seleccionar tipo</option>
                            <option value="Educacion">Educación</option>
                            <option value="Medio Ambiente">Medio Ambiente</option>
                            <option value="Salud">Salud</option>
                            <option value="Social">Social</option>
                            <option value="Desarrollo Comunitario">Desarrollo Comunitario</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Responsable</label>
                        <select id="edit_responsable_id" name="ResponsableID"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                            <option value="">Sin asignar</option>
                            @foreach($miembros as $miembro)
                                @if($miembro->user)
                                    <option value="{{ $miembro->MiembroID }}">{{ $miembro->user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estatus</label>
                        <select id="edit_estatus" name="Estatus"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                            <option value="Cancelado">Cancelado</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t flex justify-end gap-3">
                    <button type="button" onclick="cerrarModalEditarProyecto()"
                            class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition font-medium shadow-md hover:shadow-lg">
                        Actualizar Proyecto
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Agregar/Ver Participantes -->
    <div id="modalParticipantes" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-2/3 shadow-2xl rounded-xl bg-white">
            <div class="bg-blue-600 px-6 py-4 rounded-t-xl flex justify-between items-center">
                <h3 class="text-xl font-bold text-white">Participantes del Proyecto</h3>
                <button onclick="cerrarModalParticipantes()" class="text-white hover:text-gray-200">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="p-6">
                <!-- Tabla de participantes actuales -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Participantes Actuales</h4>
                    <div id="participantesTableContainer" class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Miembro</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Rol Perfil</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="participantesList" class="divide-y divide-gray-200">
                                <tr><td colspan="4" class="px-4 py-3 text-center text-gray-500">Cargando...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Formulario para agregar participante -->
                <div class="border-t pt-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Agregar Participante</h4>
                    <form id="formAgregarParticipante" onsubmit="agregarParticipante(event)" class="space-y-4">
                        @csrf
                        <input type="hidden" id="proyectoId" name="proyecto_id">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Miembro</label>
                            <select id="miembroId" name="miembro_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Seleccionar miembro...</option>
                                @foreach($miembros as $miembro)
                                    @if($miembro->user)
                                        <option value="{{ $miembro->MiembroID }}">{{ $miembro->user->name }} {{ $miembro->user->apellidos ?? '' }} - {{ $miembro->Rol ?? 'N/A' }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Rol en el Proyecto</label>
                                <select id="rol" name="rol" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="Responsable">Responsable</option>
                                    <option value="Participante" selected>Participante</option>
                                    <option value="Colaborador">Colaborador</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t">
                            <button type="button" onclick="cerrarModalParticipantes()"
                                    class="px-4 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                                Cancelar
                            </button>
                            <button type="submit"
                                    class="px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium shadow-md hover:shadow-lg">
                                Agregar Participante
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
