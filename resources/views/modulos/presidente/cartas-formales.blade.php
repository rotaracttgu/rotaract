@extends('modulos.presidente.layout')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Cartas Formales</h1>
            <p class="text-gray-600 mt-1">Gestión de correspondencia oficial del club</p>
        </div>
        <div class="flex gap-3">
            <button onclick="abrirModalFormal()" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Carta Formal
            </button>
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
            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 cursor-pointer hover:shadow-md transition-shadow" onclick="filtrarPorEstadoFormal('')">
                    <p class="text-sm text-gray-600">Total</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $estadisticas['total'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Click para ver todas</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 cursor-pointer hover:shadow-md transition-shadow" onclick="filtrarPorEstadoFormal('Enviada')">
                    <p class="text-sm text-gray-600">Enviadas</p>
                    <p class="text-2xl font-bold text-green-600">{{ $estadisticas['enviadas'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Click para filtrar</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 cursor-pointer hover:shadow-md transition-shadow" onclick="filtrarPorEstadoFormal('Borrador')">
                    <p class="text-sm text-gray-600">Borradores</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $estadisticas['borradores'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Click para filtrar</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 cursor-pointer hover:shadow-md transition-shadow" onclick="filtrarPorEstadoFormal('Recibida')">
                    <p class="text-sm text-gray-600">Recibidas</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $estadisticas['recibidas'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Click para filtrar</p>
                </div>
            </div>

            <!-- Panel principal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Correspondencia Formal</h3>
                    </div>

                    <!-- Filtros -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Carta</label>
                            <select id="filtro-tipo-formal" onchange="aplicarFiltrosFormal()" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                <option value="">Todos los tipos</option>
                                <option value="Invitacion">Invitación</option>
                                <option value="Agradecimiento">Agradecimiento</option>
                                <option value="Solicitud">Solicitud</option>
                                <option value="Notificacion">Notificación</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                            <select id="filtro-estado-formal" onchange="aplicarFiltrosFormal()" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                <option value="">Todos</option>
                                <option value="Borrador">Borrador</option>
                                <option value="Enviada">Enviada</option>
                                <option value="Recibida">Recibida</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha desde</label>
                            <input type="date" id="filtro-fecha-desde-formal" onchange="aplicarFiltrosFormal()" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha hasta</label>
                            <input type="date" id="filtro-fecha-hasta-formal" onchange="aplicarFiltrosFormal()" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>
                    </div>

                    <!-- Barra de búsqueda -->
                    <div class="mb-6">
                        <div class="relative">
                            <input type="text" id="buscador-formal" oninput="aplicarFiltrosFormal()" placeholder="Buscar por destinatario, asunto o contenido..." 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 pl-10">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Tabla de cartas formales -->
                    <div class="overflow-x-auto">
                        <table id="tabla-cartas-formal" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destinatario</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asunto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Respuesta</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($cartas as $carta)
                                    <tr class="hover:bg-gray-50"
                                        data-tipo="{{ $carta->tipo }}"
                                        data-fecha="{{ $carta->fecha_envio }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $carta->fecha_envio ? \Carbon\Carbon::parse($carta->fecha_envio)->format('d/m/Y') : ($carta->created_at ? $carta->created_at->format('d/m/Y') : 'N/A') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div>
                                                <p class="font-medium">{{ $carta->destinatario }}</p>
                                                @if($carta->numero_carta)
                                                    <p class="text-xs text-gray-500">Carta #{{ $carta->numero_carta }}</p>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $tipoClasses = [
                                                    'Invitacion' => 'bg-blue-100 text-blue-800',
                                                    'Agradecimiento' => 'bg-green-100 text-green-800',
                                                    'Solicitud' => 'bg-yellow-100 text-yellow-800',
                                                    'Notificacion' => 'bg-purple-100 text-purple-800',
                                                    'Otro' => 'bg-gray-100 text-gray-800',
                                                ];
                                                $claseTipo = $tipoClasses[$carta->tipo] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $claseTipo }}">
                                                {{ $carta->tipo }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($carta->asunto, 40) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $estadoClasses = [
                                                    'Borrador' => 'bg-gray-100 text-gray-800',
                                                    'Enviada' => 'bg-green-100 text-green-800',
                                                    'Recibida' => 'bg-blue-100 text-blue-800',
                                                ];
                                                $claseEstado = $estadoClasses[$carta->estado] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $claseEstado }}">
                                                {{ $carta->estado }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div>
                                                @if($carta->estado == 'Recibida')
                                                    <p class="text-green-600 font-medium">Confirmada</p>
                                                @elseif($carta->estado == 'Enviada')
                                                    <p class="text-yellow-600 font-medium">Pendiente</p>
                                                @else
                                                    <p class="text-gray-600 font-medium">{{ $carta->estado }}</p>
                                                @endif
                                                <p class="text-xs text-gray-500">{{ $carta->updated_at->format('d/m/Y') }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex gap-2">
                                                <button class="text-purple-600 hover:text-purple-900" title="Ver carta" onclick="verCartaFormal({{ $carta->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-yellow-600 hover:text-yellow-900" title="Editar" onclick="editarCartaFormal({{ $carta->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-red-600 hover:text-red-900" title="Eliminar" onclick="eliminarCartaFormal({{ $carta->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-green-600 hover:text-green-900" title="Descargar PDF" onclick="descargarCartaPDF({{ $carta->id }})">
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="mt-2 text-sm font-medium">No hay cartas formales registradas</p>
                                            <p class="text-xs text-gray-400 mt-1">Haz clic en "Nueva Carta Formal" para comenzar</p>
                                        </td>
                                    </tr>
                                @endforelse
                                <!-- Mensaje cuando no hay resultados del filtro -->
                                <tr id="mensaje-sin-resultados-formal" style="display: none;">
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
                            Mostrando <span class="font-medium">{{ $cartas->count() }}</span> carta(s) formal(es)
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Archivo de correspondencia -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Archivo de Correspondencia</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-gray-900">2025</h4>
                                <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full">32 cartas</span>
                            </div>
                            <button class="text-sm text-purple-600 hover:text-purple-900">Ver archivo →</button>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-gray-900">2024</h4>
                                <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded-full">156 cartas</span>
                            </div>
                            <button class="text-sm text-purple-600 hover:text-purple-900">Ver archivo →</button>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-gray-900">2023</h4>
                                <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded-full">142 cartas</span>
                            </div>
                            <button class="text-sm text-purple-600 hover:text-purple-900">Ver archivo →</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nueva Carta Formal -->
    <div id="modalNuevaCartaFormal" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-xl bg-white">
            <!-- Header -->
            <div class="bg-purple-600 px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Nueva Carta Formal</h3>
                    <button onclick="cerrarModalFormal()" class="text-white hover:text-gray-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <form id="formCartaFormal" action="{{ route('presidente.cartas.formales.store') }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Número de Carta -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Número de Carta</label>
                        <input type="text" name="numero_carta" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="Ej: CF-2025-001">
                    </div>

                    <!-- Tipo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Carta <span class="text-red-500">*</span></label>
                        <select name="tipo" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="">Seleccionar tipo</option>
                            <option value="Invitacion">Invitación</option>
                            <option value="Agradecimiento">Agradecimiento</option>
                            <option value="Solicitud">Solicitud</option>
                            <option value="Notificacion">Notificación</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>

                    <!-- Destinatario -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Destinatario <span class="text-red-500">*</span></label>
                        <input type="text" name="destinatario" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="Nombre del destinatario o institución">
                    </div>

                    <!-- Asunto -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Asunto <span class="text-red-500">*</span></label>
                        <input type="text" name="asunto" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="Asunto de la carta">
                    </div>

                    <!-- Estado -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select name="estado"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="Borrador">Borrador</option>
                            <option value="Enviada">Enviada</option>
                            <option value="Recibida">Recibida</option>
                        </select>
                    </div>

                    <!-- Fecha Envío -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Envío</label>
                        <input type="date" name="fecha_envio" value="{{ date('Y-m-d') }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>

                    <!-- Contenido -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contenido <span class="text-red-500">*</span></label>
                        <textarea name="contenido" rows="6" required
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                  placeholder="Cuerpo de la carta formal"></textarea>
                    </div>

                    <!-- Observaciones -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                        <textarea name="observaciones" rows="2"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                  placeholder="Observaciones adicionales"></textarea>
                    </div>
                </div>

                <!-- Botones -->
                <div class="mt-6 pt-4 border-t flex justify-end gap-3">
                    <button type="button" onclick="cerrarModalFormal()"
                            class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium shadow-sm">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium shadow-md hover:shadow-lg">
                        Guardar Carta
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Ver Detalles -->
    <div id="modalVerDetalleFormal" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-xl bg-white">
            <!-- Header -->
            <div class="bg-teal-600 px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Detalles de la Carta Formal</h3>
                    <button onclick="cerrarModalDetalleFormal()" class="text-white hover:text-gray-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div id="detalleContenidoFormal" class="p-6">
                <!-- Contenido dinámico cargado con JavaScript -->
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t rounded-b-xl flex justify-end">
                <button onclick="cerrarModalDetalleFormal()" class="px-6 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-medium shadow-sm">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Editar -->
    <div id="modalEditarCartaFormal" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-xl bg-white">
            <!-- Header -->
            <div class="bg-green-600 px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Editar Carta Formal</h3>
                    <button onclick="cerrarModalEditarFormal()" class="text-white hover:text-gray-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <form id="formEditarCartaFormal" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_formal_id" name="carta_id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Número de Carta</label>
                        <input type="text" id="edit_formal_numero_carta" name="numero_carta" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Carta <span class="text-red-500">*</span></label>
                        <select id="edit_formal_tipo" name="tipo" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="Invitacion">Invitación</option>
                            <option value="Agradecimiento">Agradecimiento</option>
                            <option value="Solicitud">Solicitud</option>
                            <option value="Notificacion">Notificación</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Destinatario <span class="text-red-500">*</span></label>
                        <input type="text" id="edit_formal_destinatario" name="destinatario" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Asunto <span class="text-red-500">*</span></label>
                        <input type="text" id="edit_formal_asunto" name="asunto" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select id="edit_formal_estado" name="estado"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="Borrador">Borrador</option>
                            <option value="Enviada">Enviada</option>
                            <option value="Recibida">Recibida</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Envío</label>
                        <input type="date" id="edit_formal_fecha_envio" name="fecha_envio"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contenido <span class="text-red-500">*</span></label>
                        <textarea id="edit_formal_contenido" name="contenido" required rows="6"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                        <textarea id="edit_formal_observaciones" name="observaciones" rows="2"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"></textarea>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t flex justify-end gap-3">
                    <button type="button" onclick="cerrarModalEditarFormal()"
                            class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium shadow-sm">
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

    <script>
        // Modal Nueva Carta
        function abrirModalFormal() {
            document.getElementById('modalNuevaCartaFormal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function cerrarModalFormal() {
            document.getElementById('modalNuevaCartaFormal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('formCartaFormal').reset();
        }

        // Modal Ver Detalles con loading
        async function verCartaFormal(id) {
            const modal = document.getElementById('modalVerDetalleFormal');
            const contenedor = document.getElementById('detalleContenidoFormal');
            
            // Mostrar modal con loader
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            contenedor.innerHTML = `
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-teal-600 mb-4"></div>
                    <p class="text-gray-600 font-medium">Cargando detalles...</p>
                </div>
            `;
            
            try {
                const response = await fetch(`/vicepresidente/cartas/formales/${id}`);
                const carta = await response.json();
                
                const tipoBadges = {
                    'Invitacion': 'bg-blue-500 text-white',
                    'Agradecimiento': 'bg-green-500 text-white',
                    'Solicitud': 'bg-yellow-500 text-white',
                    'Notificacion': 'bg-purple-500 text-white',
                    'Otro': 'bg-gray-500 text-white'
                };
                
                const estadoBadges = {
                    'Borrador': 'bg-gray-500 text-white',
                    'Enviada': 'bg-green-500 text-white',
                    'Recibida': 'bg-blue-500 text-white'
                };
                
                // Animación de fade in para el contenido
                setTimeout(() => {
                    contenedor.innerHTML = `
                        <div class="animate-fadeIn">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Número de Carta -->
                                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Número de Carta</p>
                                    <p class="text-lg font-bold text-gray-900">${carta.numero_carta}</p>
                                </div>
                                
                                <!-- Tipo -->
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Tipo</p>
                                    <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold shadow-sm ${tipoBadges[carta.tipo] || 'bg-gray-500 text-white'}">
                                        ${carta.tipo}
                                    </span>
                                </div>
                                
                                <!-- Estado -->
                                <div class="bg-gradient-to-br from-teal-50 to-cyan-50 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Estado</p>
                                    <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold shadow-sm ${estadoBadges[carta.estado] || 'bg-gray-500 text-white'}">
                                        ${carta.estado}
                                    </span>
                                </div>
                                
                                <!-- Fecha Envío -->
                                <div class="bg-white border-2 border-gray-200 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Fecha de Envío</p>
                                    <p class="text-base font-semibold text-gray-900">${carta.fecha_envio || '<span class="text-gray-400">Sin fecha</span>'}</p>
                                </div>
                                
                                <!-- Destinatario -->
                                <div class="md:col-span-2 bg-white border-2 border-gray-200 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Destinatario</p>
                                    <p class="text-base font-semibold text-gray-900">${carta.destinatario}</p>
                                </div>
                                
                                <!-- Asunto -->
                                <div class="md:col-span-2 bg-purple-50 p-4 rounded-lg border-l-4 border-purple-500">
                                    <p class="text-xs font-medium text-purple-700 uppercase mb-1">Asunto</p>
                                    <p class="text-base font-semibold text-gray-900">${carta.asunto}</p>
                                </div>
                                
                                <!-- Contenido -->
                                <div class="md:col-span-2 bg-white border-2 border-gray-200 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-2">Contenido</p>
                                    <div class="text-sm text-gray-700 bg-gray-50 p-4 rounded border leading-relaxed max-h-64 overflow-y-auto">
                                        ${carta.contenido ? carta.contenido.replace(/\n/g, '<br>') : '<span class="text-gray-400">Sin contenido</span>'}
                                    </div>
                                </div>
                                
                                <!-- Creado por -->
                                <div class="bg-teal-50 p-4 rounded-lg flex items-center">
                                    <svg class="w-10 h-10 text-teal-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase">Creado por</p>
                                        <p class="text-base font-semibold text-gray-900">${carta.usuario ? carta.usuario.name : 'N/A'}</p>
                                    </div>
                                </div>
                                
                                <!-- Fecha Creación -->
                                <div class="bg-white border-2 border-gray-200 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Fecha de Creación</p>
                                    <p class="text-base text-gray-900">${carta.created_at ? new Date(carta.created_at).toLocaleDateString('es-HN') : 'N/A'}</p>
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

        function cerrarModalDetalleFormal() {
            document.getElementById('modalVerDetalleFormal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Modal Editar con loading
        async function editarCartaFormal(id) {
            const modal = document.getElementById('modalEditarCartaFormal');
            const form = document.getElementById('formEditarCartaFormal');
            
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
                const response = await fetch(`/vicepresidente/cartas/formales/${id}`);
                const carta = await response.json();
                
                // Restaurar contenido original
                setTimeout(() => {
                    formContainer.innerHTML = originalContent;
                    
                    // Llenar formulario con animación
                    document.getElementById('edit_formal_id').value = carta.id;
                    document.getElementById('edit_formal_numero_carta').value = carta.numero_carta;
                    document.getElementById('edit_formal_tipo').value = carta.tipo;
                    document.getElementById('edit_formal_destinatario').value = carta.destinatario;
                    document.getElementById('edit_formal_asunto').value = carta.asunto;
                    document.getElementById('edit_formal_contenido').value = carta.contenido || '';
                    document.getElementById('edit_formal_estado').value = carta.estado;
                    document.getElementById('edit_formal_fecha_envio').value = carta.fecha_envio || '';
                    document.getElementById('edit_formal_observaciones').value = carta.observaciones || '';
                    
                    // Configurar action del formulario
                    form.action = `/vicepresidente/cartas/formales/${id}`;
                    
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
                        <button onclick="cerrarModalEditarFormal()" class="mt-4 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                            Cerrar
                        </button>
                    </div>
                `;
            }
        }

        function cerrarModalEditarFormal() {
            document.getElementById('modalEditarCartaFormal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('formEditarCartaFormal').reset();
        }

        // Eliminar carta
        function eliminarCartaFormal(id) {
            if (confirm('¿Estás seguro de que deseas eliminar esta carta formal? Esta acción no se puede deshacer.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/vicepresidente/cartas/formales/${id}`;
                
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

        function descargarCartaPDF(id) {
            // TODO: Implementar en Fase 4
            console.log('Descargar PDF carta:', id);
            alert('Función de descarga PDF próximamente disponible');
        }

        // Filtros y búsqueda
        function filtrarPorEstadoFormal(estado) {
            document.getElementById('filtro-estado-formal').value = estado;
            aplicarFiltrosFormal();
        }

        function aplicarFiltrosFormal() {
            const buscador = document.getElementById('buscador-formal').value.toLowerCase();
            const filtroTipo = document.getElementById('filtro-tipo-formal').value;
            const filtroEstado = document.getElementById('filtro-estado-formal').value;
            const filtroFechaDesde = document.getElementById('filtro-fecha-desde-formal').value;
            const filtroFechaHasta = document.getElementById('filtro-fecha-hasta-formal').value;
            
            const filas = document.querySelectorAll('#tabla-cartas-formal tbody tr');
            let visibles = 0;
            
            filas.forEach(fila => {
                if (fila.querySelector('td[colspan]')) return; // Skip empty state row
                
                const textoFila = fila.textContent.toLowerCase();
                const tipo = fila.getAttribute('data-tipo');
                const estado = fila.querySelector('td:nth-child(5)')?.textContent.trim();
                const fecha = fila.getAttribute('data-fecha');
                
                let mostrar = true;
                
                // Filtro de búsqueda
                if (buscador && !textoFila.includes(buscador)) {
                    mostrar = false;
                }
                
                // Filtro de tipo
                if (filtroTipo && tipo !== filtroTipo) {
                    mostrar = false;
                }
                
                // Filtro de estado
                if (filtroEstado && estado !== filtroEstado) {
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
            const mensajeVacio = document.getElementById('mensaje-sin-resultados-formal');
            if (mensajeVacio) {
                mensajeVacio.style.display = visibles === 0 ? '' : 'none';
            }
        }

        // Cerrar modales al hacer clic fuera
        document.getElementById('modalNuevaCartaFormal')?.addEventListener('click', function(e) {
            if (e.target === this) cerrarModalFormal();
        });
        document.getElementById('modalVerDetalleFormal')?.addEventListener('click', function(e) {
            if (e.target === this) cerrarModalDetalleFormal();
        });
        document.getElementById('modalEditarCartaFormal')?.addEventListener('click', function(e) {
            if (e.target === this) cerrarModalEditarFormal();
        });
    </script>
@endsection
