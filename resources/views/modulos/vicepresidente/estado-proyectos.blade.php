@extends('modulos.vicepresidente.layout')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Estado de Proyectos</h1>
            <p class="text-gray-600 mt-1">Vista general del estado de todos los proyectos</p>
        </div>
        <div class="flex gap-3">
            <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full flex items-center">
                🔒 Solo Lectura
            </span>
            <a href="{{ route('vicepresidente.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
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
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 cursor-pointer hover:shadow-md transition-shadow" onclick="filtrarPorEstadoProyecto('')">
                    <p class="text-sm text-gray-600">Total Proyectos</p>
                    <p class="text-2xl font-bold text-indigo-600">{{ $estadisticas['total'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Click para ver todos</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 cursor-pointer hover:shadow-md transition-shadow" onclick="filtrarPorEstadoProyecto('Planificacion')">
                    <p class="text-sm text-gray-600">En Planificación</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $estadisticas['enPlanificacion'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Click para filtrar</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 cursor-pointer hover:shadow-md transition-shadow" onclick="filtrarPorEstadoProyecto('EnEjecucion')">
                    <p class="text-sm text-gray-600">En Ejecución</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $estadisticas['enEjecucion'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Click para filtrar</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 cursor-pointer hover:shadow-md transition-shadow" onclick="filtrarPorEstadoProyecto('Finalizado')">
                    <p class="text-sm text-gray-600">Finalizados</p>
                    <p class="text-2xl font-bold text-green-600">{{ $estadisticas['finalizados'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Click para filtrar</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 cursor-pointer hover:shadow-md transition-shadow" onclick="filtrarPorEstadoProyecto('Cancelado')">
                    <p class="text-sm text-gray-600">Cancelados</p>
                    <p class="text-2xl font-bold text-red-600">{{ $estadisticas['cancelados'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Click para filtrar</p>
                </div>
            </div>

            <!-- Panel principal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Todos los Proyectos</h3>
                        <div class="flex gap-2">
                            <button onclick="exportarProyectosPDF()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Exportar PDF
                            </button>
                            <button onclick="exportarProyectosExcel()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Exportar Excel
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

                                <button class="w-full text-center text-sm text-indigo-600 hover:text-indigo-800 font-medium border border-indigo-200 rounded py-2 hover:bg-indigo-50 transition" onclick="verDetalleProyecto({{ $proyecto->ProyectoID }})">
                                    Ver detalles completos →
                                </button>
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
                                            <button class="text-indigo-600 hover:text-indigo-900" onclick="verDetalleProyecto({{ $proyecto->ProyectoID }})">Ver detalles</button>
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

        function verDetalleProyecto(id) {
            // TODO: Implementar en futuro - modal de detalles del proyecto
            console.log('Ver detalle proyecto:', id);
            alert('Función de detalles próximamente disponible');
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
    </script>
@endsection
