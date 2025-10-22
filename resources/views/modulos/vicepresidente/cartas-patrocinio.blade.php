@extends('modulos.vicepresidente.layout')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Cartas de Patrocinio</h1>
            <p class="text-gray-600 mt-1">Gestión de cartas de patrocinio enviadas</p>
        </div>
        <a href="{{ route('vicepresidente.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Dashboard
        </a>
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 cursor-pointer hover:shadow-md transition-shadow" onclick="filtrarPorEstado('')">
                    <p class="text-sm text-gray-600">Total</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $estadisticas['total'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Click para ver todas</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 cursor-pointer hover:shadow-md transition-shadow" onclick="filtrarPorEstado('Aprobada')">
                    <p class="text-sm text-gray-600">Aprobadas</p>
                    <p class="text-2xl font-bold text-green-600">{{ $estadisticas['aprobadas'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Click para filtrar</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 cursor-pointer hover:shadow-md transition-shadow" onclick="filtrarPorEstado('Pendiente')">
                    <p class="text-sm text-gray-600">Pendientes</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $estadisticas['pendientes'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Click para filtrar</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 cursor-pointer hover:shadow-md transition-shadow" onclick="filtrarPorEstado('Rechazada')">
                    <p class="text-sm text-gray-600">Rechazadas</p>
                    <p class="text-2xl font-bold text-red-600">{{ $estadisticas['rechazadas'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Click para filtrar</p>
                </div>
            </div>

            <!-- Panel principal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Gestión de Cartas de Patrocinio</h3>
                        <button onclick="abrirModalPatrocinio()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Nueva Carta de Patrocinio
                        </button>
                    </div>

                    <!-- Filtros avanzados -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                            <select id="filtro-estado" onchange="aplicarFiltros()" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Todos los estados</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="En Revision">En Revisión</option>
                                <option value="Aprobada">Aprobada</option>
                                <option value="Rechazada">Rechazada</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Proyecto</label>
                            <select id="filtro-proyecto" onchange="aplicarFiltros()" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Todos los proyectos</option>
                                @foreach($proyectos as $proyecto)
                                    <option value="{{ $proyecto->ProyectoID }}">{{ $proyecto->Nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha desde</label>
                            <input type="date" id="filtro-fecha-desde" onchange="aplicarFiltros()" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha hasta</label>
                            <input type="date" id="filtro-fecha-hasta" onchange="aplicarFiltros()" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Barra de búsqueda -->
                    <div class="mb-6">
                        <div class="relative">
                            <input type="text" id="buscador" oninput="aplicarFiltros()" placeholder="Buscar por destinatario, número de carta o descripción..." 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-10">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Tabla de cartas -->
                    <div class="overflow-x-auto">
                        <table id="tabla-cartas" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Envío</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destinatario</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proyecto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto Solicitado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Última Actualización</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($cartas as $carta)
                                    <tr class="hover:bg-gray-50" 
                                        data-proyecto-id="{{ $carta->proyecto_id }}"
                                        data-fecha="{{ $carta->fecha_solicitud }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $carta->fecha_solicitud ? \Carbon\Carbon::parse($carta->fecha_solicitud)->format('d/m/Y') : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div>
                                                <p class="font-medium">{{ $carta->destinatario }}</p>
                                                @if($carta->numero_carta)
                                                    <p class="text-xs text-gray-500">Carta #{{ $carta->numero_carta }}</p>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $carta->proyecto ? $carta->proyecto->Nombre : 'Sin proyecto' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            L. {{ number_format($carta->monto_solicitado, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $estadoClasses = [
                                                    'Pendiente' => 'bg-yellow-100 text-yellow-800',
                                                    'Aprobada' => 'bg-green-100 text-green-800',
                                                    'Rechazada' => 'bg-red-100 text-red-800',
                                                    'En Revision' => 'bg-blue-100 text-blue-800',
                                                ];
                                                $clase = $estadoClasses[$carta->estado] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $clase }}">
                                                {{ $carta->estado }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $carta->updated_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex gap-2">
                                                <button class="text-blue-600 hover:text-blue-900" title="Ver detalles" onclick="verDetalleCarta({{ $carta->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-yellow-600 hover:text-yellow-900" title="Editar" onclick="editarCarta({{ $carta->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-red-600 hover:text-red-900" title="Eliminar" onclick="eliminarCarta({{ $carta->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-green-600 hover:text-green-900" title="Descargar PDF" onclick="descargarPDF({{ $carta->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="mt-2 text-sm font-medium">No hay cartas de patrocinio registradas</p>
                                            <p class="text-xs text-gray-400 mt-1">Haz clic en "Nueva Carta de Patrocinio" para comenzar</p>
                                        </td>
                                    </tr>
                                @endforelse
                                <!-- Mensaje cuando no hay resultados del filtro -->
                                <tr id="mensaje-sin-resultados" style="display: none;">
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        <p class="mt-2 text-sm font-medium">No se encontraron resultados</p>
                                        <p class="text-xs text-gray-400 mt-1">Intenta con otros criterios de búsqueda</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Información de resultados -->
                    @if($cartas->count() > 0)
                    <div class="mt-6 flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Mostrando <span class="font-medium">{{ $cartas->count() }}</span> carta(s) de patrocinio
                        </div>
                        <div class="text-sm text-gray-500">
                            Monto total aprobado: <span class="font-bold text-green-600">L. {{ number_format($estadisticas['montoTotal'], 2) }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nueva Carta de Patrocinio -->
    <div id="modalNuevaCartaPatrocinio" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-xl bg-white overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white">Nueva Carta de Patrocinio</h3>
                <button onclick="cerrarModalPatrocinio()" class="text-white hover:text-gray-200 transition-colors p-1 rounded-lg hover:bg-white hover:bg-opacity-10">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="formCartaPatrocinio" action="{{ route('vicepresidente.cartas.patrocinio.store') }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Número de Carta</label>
                        <input type="text" name="numero_carta" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Ej: CP-2025-001">
                    </div>

                    <!-- Proyecto -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Proyecto <span class="text-red-500">*</span></label>
                        <select name="proyecto_id" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Seleccionar proyecto</option>
                            @foreach($proyectos as $proyecto)
                                <option value="{{ $proyecto->ProyectoID }}">{{ $proyecto->Nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Destinatario -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Destinatario <span class="text-red-500">*</span></label>
                        <input type="text" name="destinatario" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Nombre de la empresa o institución">
                    </div>

                    <!-- Monto Solicitado -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Monto Solicitado (L.) <span class="text-red-500">*</span></label>
                        <input type="number" name="monto_solicitado" required step="0.01" min="0"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="0.00">
                    </div>

                    <!-- Estado -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select name="estado"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="Pendiente">Pendiente</option>
                            <option value="En Revision">En Revisión</option>
                            <option value="Aprobada">Aprobada</option>
                            <option value="Rechazada">Rechazada</option>
                        </select>
                    </div>

                    <!-- Fecha Solicitud -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Solicitud</label>
                        <input type="date" name="fecha_solicitud" value="{{ date('Y-m-d') }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Fecha Respuesta -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Respuesta</label>
                        <input type="date" name="fecha_respuesta"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Descripción -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea name="descripcion" rows="3"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Descripción del patrocinio solicitado"></textarea>
                    </div>

                    <!-- Observaciones -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                        <textarea name="observaciones" rows="2"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Observaciones adicionales"></textarea>
                    </div>
                </div>

                <!-- Botones con diseño mejorado -->
                <div class="mt-6 pt-4 border-t border-gray-200 flex justify-end gap-3">
                    <button type="button" onclick="cerrarModalPatrocinio()"
                            class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all font-medium shadow-sm hover:shadow">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium shadow-md hover:shadow-lg">
                        Guardar Carta
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Ver Detalles -->
    <div id="modalVerDetalle" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-xl bg-white overflow-hidden">
            <!-- Header -->
            <div class="bg-purple-600 px-6 py-4 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="bg-white bg-opacity-20 p-2 rounded-lg mr-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white">Detalles de la Carta</h3>
                </div>
                <button onclick="cerrarModalDetalle()" class="text-white hover:text-gray-200 transition-colors p-1 rounded-lg hover:bg-white hover:bg-opacity-10">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div id="detalleContenido" class="p-6">
                <!-- Loader mientras carga -->
                <div class="flex justify-center items-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                <button onclick="cerrarModalDetalle()" class="px-6 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all font-medium shadow-sm hover:shadow">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Editar -->
    <div id="modalEditarCarta" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-xl bg-white overflow-hidden">
            <!-- Header -->
            <div class="bg-green-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white">Editar Carta de Patrocinio</h3>
                <button onclick="cerrarModalEditar()" class="text-white hover:text-gray-200 transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="formEditarCarta" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_carta_id" name="carta_id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Número de Carta</label>
                        <input type="text" id="edit_numero_carta" name="numero_carta" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Proyecto <span class="text-red-500">*</span></label>
                        <select id="edit_proyecto_id" name="proyecto_id" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Seleccionar proyecto</option>
                            @foreach($proyectos as $proyecto)
                                <option value="{{ $proyecto->ProyectoID }}">{{ $proyecto->Nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Destinatario <span class="text-red-500">*</span></label>
                        <input type="text" id="edit_destinatario" name="destinatario" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Monto Solicitado (L.) <span class="text-red-500">*</span></label>
                        <input type="number" id="edit_monto_solicitado" name="monto_solicitado" required step="0.01" min="0"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select id="edit_estado" name="estado"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="Pendiente">Pendiente</option>
                            <option value="En Revision">En Revisión</option>
                            <option value="Aprobada">Aprobada</option>
                            <option value="Rechazada">Rechazada</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Solicitud</label>
                        <input type="date" id="edit_fecha_solicitud" name="fecha_solicitud"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Respuesta</label>
                        <input type="date" id="edit_fecha_respuesta" name="fecha_respuesta"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea id="edit_descripcion" name="descripcion" rows="3"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                        <textarea id="edit_observaciones" name="observaciones" rows="2"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-200 flex justify-end gap-3">
                    <button type="button" onclick="cerrarModalEditar()"
                            class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all font-medium shadow-sm hover:shadow">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium shadow-md hover:shadow-lg">
                        Actualizar Carta
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Modal Nueva Carta
        function abrirModalPatrocinio() {
            document.getElementById('modalNuevaCartaPatrocinio').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function cerrarModalPatrocinio() {
            document.getElementById('modalNuevaCartaPatrocinio').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('formCartaPatrocinio').reset();
        }

        // Modal Ver Detalles con loading y animaciones
        async function verDetalleCarta(id) {
            const modal = document.getElementById('modalVerDetalle');
            const contenedor = document.getElementById('detalleContenido');
            
            // Mostrar modal con loader
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            contenedor.innerHTML = `
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-indigo-600 mb-4"></div>
                    <p class="text-gray-600 font-medium">Cargando detalles...</p>
                </div>
            `;
            
            try {
                const response = await fetch(`/vicepresidente/cartas/patrocinio/${id}`);
                const carta = await response.json();
                
                // Animación de fade in para el contenido
                setTimeout(() => {
                    contenedor.innerHTML = `
                        <div class="animate-fadeIn">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Número de Carta -->
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Número de Carta</p>
                                    <p class="text-lg font-bold text-gray-900">${carta.numero_carta}</p>
                                </div>
                                
                                <!-- Estado -->
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Estado</p>
                                    <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold shadow-sm
                                        ${carta.estado === 'Aprobada' ? 'bg-green-500 text-white' : 
                                          carta.estado === 'Pendiente' ? 'bg-yellow-500 text-white' : 
                                          carta.estado === 'Rechazada' ? 'bg-red-500 text-white' : 'bg-blue-500 text-white'}">
                                        ${carta.estado}
                                    </span>
                                </div>
                                
                                <!-- Destinatario -->
                                <div class="md:col-span-2 bg-white border-2 border-gray-200 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Destinatario</p>
                                    <p class="text-base font-semibold text-gray-900">${carta.destinatario}</p>
                                </div>
                                
                                <!-- Proyecto -->
                                <div class="md:col-span-2 bg-purple-50 p-4 rounded-lg border-l-4 border-purple-500">
                                    <p class="text-xs font-medium text-purple-700 uppercase mb-1">Proyecto Asociado</p>
                                    <p class="text-base font-semibold text-gray-900">${carta.proyecto ? carta.proyecto.Nombre : '<span class="text-gray-400">Sin proyecto asignado</span>'}</p>
                                </div>
                                
                                <!-- Monto -->
                                <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Monto Solicitado</p>
                                    <p class="text-2xl font-bold text-green-600">L. ${parseFloat(carta.monto_solicitado).toLocaleString('es-HN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</p>
                                </div>
                                
                                <!-- Fechas -->
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase">Fecha Solicitud</p>
                                        <p class="text-base text-gray-900">${carta.fecha_solicitud || '<span class="text-gray-400">N/A</span>'}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase">Fecha Respuesta</p>
                                        <p class="text-base text-gray-900">${carta.fecha_respuesta || '<span class="text-gray-400">Pendiente</span>'}</p>
                                    </div>
                                </div>
                                
                                <!-- Creado por -->
                                <div class="md:col-span-2 bg-indigo-50 p-4 rounded-lg flex items-center">
                                    <svg class="w-10 h-10 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase">Creado por</p>
                                        <p class="text-base font-semibold text-gray-900">${carta.usuario ? carta.usuario.name : 'N/A'}</p>
                                    </div>
                                </div>
                                
                                <!-- Descripción -->
                                <div class="md:col-span-2 bg-white border-2 border-gray-200 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-2">Descripción</p>
                                    <p class="text-sm text-gray-700 leading-relaxed">${carta.descripcion || '<span class="text-gray-400">Sin descripción</span>'}</p>
                                </div>
                                
                                ${carta.observaciones ? `
                                <div class="md:col-span-2 bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-500">
                                    <p class="text-xs font-medium text-yellow-700 uppercase mb-2">Observaciones</p>
                                    <p class="text-sm text-gray-700">${carta.observaciones}</p>
                                </div>` : ''}
                            </div>
                        </div>
                    `;
                }, 300);
                
            } catch (error) {
                console.error('Error:', error);
                contenedor.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-12 animate-shake">
                        <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-red-600 font-medium">Error al cargar los detalles</p>
                        <p class="text-gray-500 text-sm mt-2">Por favor, intenta nuevamente</p>
                    </div>
                `;
            }
        }

        function cerrarModalDetalle() {
            document.getElementById('modalVerDetalle').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Modal Editar con loading
        async function editarCarta(id) {
            const modal = document.getElementById('modalEditarCarta');
            const form = document.getElementById('formEditarCarta');
            
            // Mostrar modal con loading
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Mostrar loader temporal en el formulario
            const formContainer = form.querySelector('.p-6');
            const originalContent = formContainer.innerHTML;
            formContainer.innerHTML = `
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-4 border-green-600 mb-3"></div>
                    <p class="text-gray-600 font-medium">Cargando datos...</p>
                </div>
            `;
            
            try {
                const response = await fetch(`/vicepresidente/cartas/patrocinio/${id}`);
                const carta = await response.json();
                
                // Restaurar contenido original
                setTimeout(() => {
                    formContainer.innerHTML = originalContent;
                    
                    // Llenar formulario con animación
                    document.getElementById('edit_carta_id').value = carta.id;
                    document.getElementById('edit_numero_carta').value = carta.numero_carta;
                    document.getElementById('edit_destinatario').value = carta.destinatario;
                    document.getElementById('edit_monto_solicitado').value = carta.monto_solicitado;
                    document.getElementById('edit_estado').value = carta.estado;
                    document.getElementById('edit_proyecto_id').value = carta.proyecto_id || '';
                    document.getElementById('edit_fecha_solicitud').value = carta.fecha_solicitud;
                    document.getElementById('edit_fecha_respuesta').value = carta.fecha_respuesta || '';
                    document.getElementById('edit_descripcion').value = carta.descripcion || '';
                    document.getElementById('edit_observaciones').value = carta.observaciones || '';
                    
                    // Configurar action del formulario
                    form.action = `/vicepresidente/cartas/patrocinio/${id}`;
                    
                    // Añadir clase de animación
                    formContainer.classList.add('animate-fadeIn');
                }, 300);
                
            } catch (error) {
                console.error('Error:', error);
                formContainer.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-12 animate-shake">
                        <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-red-600 font-medium">Error al cargar los datos</p>
                        <button onclick="cerrarModalEditar()" class="mt-4 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                            Cerrar
                        </button>
                    </div>
                `;
            }
        }

        function cerrarModalEditar() {
            document.getElementById('modalEditarCarta').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('formEditarCarta').reset();
        }

        // Eliminar
        // Eliminar con modal de confirmación personalizado
        function eliminarCarta(id) {
            if (confirm('¿Estás seguro de que deseas eliminar esta carta de patrocinio? Esta acción no se puede deshacer.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/vicepresidente/cartas/patrocinio/${id}`;
                
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

        function descargarPDF(id) {
            // TODO: Implementar en Fase 4
            console.log('Descargar PDF carta:', id);
            alert('Función de descarga PDF próximamente disponible');
        }

        // Filtros y búsqueda
        function filtrarPorEstado(estado) {
            document.getElementById('filtro-estado').value = estado;
            aplicarFiltros();
        }

        function aplicarFiltros() {
            const buscador = document.getElementById('buscador').value.toLowerCase();
            const filtroEstado = document.getElementById('filtro-estado').value;
            const filtroProyecto = document.getElementById('filtro-proyecto').value;
            const filtroFechaDesde = document.getElementById('filtro-fecha-desde').value;
            const filtroFechaHasta = document.getElementById('filtro-fecha-hasta').value;
            
            const filas = document.querySelectorAll('#tabla-cartas tbody tr');
            let visibles = 0;
            
            filas.forEach(fila => {
                if (fila.querySelector('td[colspan]')) return; // Skip empty state row
                
                const textoFila = fila.textContent.toLowerCase();
                const estado = fila.querySelector('td:nth-child(5)')?.textContent.trim();
                const proyectoId = fila.getAttribute('data-proyecto-id');
                const fecha = fila.getAttribute('data-fecha');
                
                let mostrar = true;
                
                // Filtro de búsqueda
                if (buscador && !textoFila.includes(buscador)) {
                    mostrar = false;
                }
                
                // Filtro de estado
                if (filtroEstado && estado !== filtroEstado) {
                    mostrar = false;
                }
                
                // Filtro de proyecto
                if (filtroProyecto && proyectoId !== filtroProyecto) {
                    mostrar = false;
                }
                
                // Filtro de fecha desde
                if (filtroFechaDesde && fecha < filtroFechaDesde) {
                    mostrar = false;
                }
                
                // Filtro de fecha hasta
                if (filtroFechaHasta && fecha > filtroFechaHasta) {
                    mostrar = false;
                }
                
                fila.style.display = mostrar ? '' : 'none';
                if (mostrar) visibles++;
            });
            
            // Mostrar mensaje si no hay resultados
            const mensajeVacio = document.getElementById('mensaje-sin-resultados');
            if (mensajeVacio) {
                mensajeVacio.style.display = visibles === 0 ? '' : 'none';
            }
        }

        // Indicadores de carga en formularios
        // Cerrar modales al hacer clic fuera
        document.getElementById('modalNuevaCartaPatrocinio')?.addEventListener('click', function(e) {
            if (e.target === this) cerrarModalPatrocinio();
        });
        document.getElementById('modalVerDetalle')?.addEventListener('click', function(e) {
            if (e.target === this) cerrarModalDetalle();
        });
        document.getElementById('modalEditarCarta')?.addEventListener('click', function(e) {
            if (e.target === this) cerrarModalEditar();
        });
    </script>
@endsection
