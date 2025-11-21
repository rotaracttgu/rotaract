@extends('layouts.app-admin')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white flex items-center">
                <i class="fas fa-project-diagram mr-3 text-indigo-400"></i>
                Estado de Proyectos
            </h1>
            <p class="text-gray-300 mt-1">Vista general del estado de todos los proyectos - Módulo Presidente (Admin)</p>
        </div>
        <a href="{{ route('admin.presidente.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Dashboard
        </a>
    </div>

    <div class="py-4 px-4">
        <div class="w-full">
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
                        <button onclick="abrirModalNuevoProyecto()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Nuevo Proyecto
                        </button>
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
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
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
                                <option value="Medio Ambiente">Medio Ambiente</option>
                                <option value="Salud">Salud</option>
                                <option value="Social">Social</option>
                                <option value="Desarrollo Comunitario">Desarrollo Comunitario</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vista</label>
                            <select id="viewMode" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="toggleView()">
                                <option value="grid">Tarjetas</option>
                                <option value="table">Tabla</option>
                            </select>
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
                                 data-area="{{ $proyecto->TipoProyecto }}">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-800 mb-1">{{ $proyecto->Nombre }}</h4>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $estadoClass }}">
                                            @if($estado == 'EnEjecucion')
                                                En Ejecución
                                            @elseif($estado == 'Planificacion')
                                                Planificación
                                            @else
                                                {{ $estado }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mb-4">{{ Str::limit($proyecto->Descripcion ?? 'Sin descripción', 80) }}</p>
                            
                                <div class="space-y-2 text-xs mb-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Tipo:</span>
                                        <span class="font-medium text-gray-700">{{ $proyecto->TipoProyecto ?? 'N/A' }}</span>
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
                                    <button class="flex-1 text-center text-sm text-indigo-600 hover:text-indigo-800 font-medium border border-indigo-200 rounded py-2 hover:bg-indigo-50 transition" onclick="verDetalleProyecto({{ $proyecto->ProyectoID }})">
                                        Ver detalles
                                    </button>
                                    <button class="text-sm text-yellow-600 hover:text-yellow-800 font-medium border border-yellow-200 rounded px-3 py-2 hover:bg-yellow-50 transition" onclick="editarProyecto({{ $proyecto->ProyectoID }})" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button class="text-sm text-red-600 hover:text-red-800 font-medium border border-red-200 rounded px-3 py-2 hover:bg-red-50 transition" onclick="eliminarProyecto({{ $proyecto->ProyectoID }})" title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
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
                            <thead class="bg-gradient-to-r from-indigo-600 to-indigo-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Proyecto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Progreso</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Presupuesto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($proyectos as $proyecto)
                                    @php
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
                                        data-area="{{ $proyecto->TipoProyecto }}">
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $proyecto->TipoProyecto ?? 'N/A' }}</td>
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <button class="text-indigo-600 hover:text-indigo-900" onclick="verDetalleProyecto({{ $proyecto->ProyectoID }})">Ver</button>
                                            <button class="text-yellow-600 hover:text-yellow-900" onclick="editarProyecto({{ $proyecto->ProyectoID }})">Editar</button>
                                            <button class="text-red-600 hover:text-red-900" onclick="eliminarProyecto({{ $proyecto->ProyectoID }})">Eliminar</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
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

    <!-- Modal Nuevo Proyecto -->
    <div id="modalNuevoProyecto" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-xl bg-white overflow-hidden">
            <div class="bg-indigo-600 px-6 py-4 rounded-t-xl flex justify-between items-center">
                <h3 class="text-xl font-bold text-white">Nuevo Proyecto</h3>
                <button onclick="cerrarModalNuevoProyecto()" class="text-white hover:text-gray-200">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="formNuevoProyecto" action="{{ route('admin.presidente.proyectos.store') }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Proyecto <span class="text-red-500">*</span></label>
                        <input type="text" name="Nombre" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="Nombre del proyecto">
                        <span class="error-message text-red-500 text-sm mt-1 hidden">No se permiten más de 2 caracteres repetidos consecutivos</span>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea name="Descripcion" rows="3"
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
                                <option value="{{ $miembro->MiembroID }}">{{ $miembro->user->name }}</option>
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
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-xl bg-white overflow-hidden">
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
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                        <span class="error-message text-red-500 text-sm mt-1 hidden">No se permiten más de 2 caracteres repetidos consecutivos</span>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea id="edit_descripcion" name="Descripcion" rows="3"
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
                                <option value="{{ $miembro->MiembroID }}">{{ $miembro->user->name }}</option>
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
@endsection

@push('scripts')
<script>
    const baseRoute = 'admin/presidente';
    
    // Validación de caracteres repetidos
    function validarCaracteresRepetidos(input) {
        const value = input.value;
        const regex = /(.)\1{2,}/;
        const errorSpan = input.nextElementSibling;
        
        if (regex.test(value)) {
            input.classList.add('border-red-500');
            input.classList.remove('border-gray-300');
            if (errorSpan && errorSpan.classList.contains('error-message')) {
                errorSpan.classList.remove('hidden');
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
    
    // Agregar validación a los inputs de los formularios
    document.querySelectorAll('[name="Nombre"], [name="Descripcion"]').forEach(input => {
        input.addEventListener('input', function() {
            validarCaracteresRepetidos(this);
        });
    });
    
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

    function verDetalleProyecto(proyectoId) {
        Swal.fire({
            title: 'Cargando...',
            text: 'Obteniendo detalles del proyecto',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        fetch(`/${baseRoute}/proyectos/${proyectoId}/detalles`)
            .then(response => response.json())
            .then(data => {
                Swal.close();
                mostrarModalDetalles(data);
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'No se pudieron cargar los detalles del proyecto', 'error');
            });
    }

    function mostrarModalDetalles(proyecto) {
        const fechaInicio = proyecto.FechaInicio ? 
            new Date(proyecto.FechaInicio).toLocaleDateString('es-GT') : 'N/A';
        
        const fechaFin = proyecto.FechaFin ? 
            new Date(proyecto.FechaFin).toLocaleDateString('es-GT') : 'En curso';

        Swal.fire({
            title: proyecto.Nombre,
            html: `
                <div class="text-left space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <strong>Tipo:</strong> ${proyecto.TipoProyecto || 'N/A'}
                        </div>
                        <div>
                            <strong>Estado:</strong> ${proyecto.Estatus || 'N/A'}
                        </div>
                        <div>
                            <strong>Inicio:</strong> ${fechaInicio}
                        </div>
                        <div>
                            <strong>Fin:</strong> ${fechaFin}
                        </div>
                        <div class="col-span-2">
                            <strong>Presupuesto:</strong> L. ${parseFloat(proyecto.Presupuesto || 0).toFixed(2)}
                        </div>
                    </div>
                    <div>
                        <strong>Descripción:</strong><br>
                        ${proyecto.Descripcion || 'Sin descripción disponible'}
                    </div>
                </div>
            `,
            width: '600px',
            confirmButtonText: 'Cerrar',
            confirmButtonColor: '#4F46E5'
        });
    }

    function filtrarPorEstadoProyecto(estado) {
        document.getElementById('filtro-estado-proyecto').value = estado;
        aplicarFiltrosProyectos();
    }

    function aplicarFiltrosProyectos() {
        const buscador = document.getElementById('buscador-proyectos').value.toLowerCase();
        const filtroEstado = document.getElementById('filtro-estado-proyecto').value;
        const filtroArea = document.getElementById('filtro-area-proyecto').value;
        
        const cards = document.querySelectorAll('#gridView .proyecto-card');
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
        });
        
        const filas = document.querySelectorAll('#tableView table tbody tr');
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
        });
    }
    
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
            const response = await fetch(`/${baseRoute}/proyectos/${id}/detalles`);
            const proyecto = await response.json();
            
            setTimeout(() => {
                document.getElementById('edit_proyecto_id').value = proyecto.ProyectoID || '';
                document.getElementById('edit_nombre').value = proyecto.Nombre || '';
                document.getElementById('edit_descripcion').value = proyecto.Descripcion || '';
                
                if (proyecto.FechaInicio) {
                    const fechaInicio = proyecto.FechaInicio.split(' ')[0];
                    document.getElementById('edit_fecha_inicio').value = fechaInicio;
                }
                
                if (proyecto.FechaFin) {
                    const fechaFin = proyecto.FechaFin.split(' ')[0];
                    document.getElementById('edit_fecha_fin').value = fechaFin;
                }
                
                document.getElementById('edit_presupuesto').value = proyecto.Presupuesto || '';
                document.getElementById('edit_tipo_proyecto').value = proyecto.TipoProyecto || '';
                document.getElementById('edit_estatus').value = proyecto.Estatus || 'Activo';
                document.getElementById('edit_responsable_id').value = proyecto.ResponsableID || '';
                
                form.action = `/${baseRoute}/proyectos/${id}`;
            }, 100);
        } catch (error) {
            console.error('Error:', error);
            Swal.fire('Error', 'No se pudieron cargar los datos del proyecto', 'error');
            cerrarModalEditarProyecto();
        }
    }

    function cerrarModalEditarProyecto() {
        document.getElementById('modalEditarProyecto').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('formEditarProyecto').reset();
    }

    function eliminarProyecto(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
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
        });
    }
    
    // Cerrar modal al hacer click fuera
    document.getElementById('modalNuevoProyecto')?.addEventListener('click', function(e) {
        if (e.target === this) cerrarModalNuevoProyecto();
    });
    
    document.getElementById('modalEditarProyecto')?.addEventListener('click', function(e) {
        if (e.target === this) cerrarModalEditarProyecto();
    });
</script>
@endpush
