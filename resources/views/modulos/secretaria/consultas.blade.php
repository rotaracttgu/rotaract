@extends('modulos.secretaria.layout') 

@section('title', 'Gestión de Consultas')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Gestión de Consultas</h1>
            <p class="text-gray-600 mt-1">Administra todas las consultas recibidas</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.location.reload()" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Actualizar
            </button>
            <div class="relative inline-block">
                <button id="exportDropdownBtn" type="button" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Exportar
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="exportDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
                    <a href="{{ route('secretaria.consultas.exportar.pdf') }}" class="block px-4 py-3 text-gray-700 hover:bg-red-50 transition-colors rounded-t-lg">
                        <svg class="w-4 h-4 inline-block mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Exportar a PDF
                    </a>
                    <a href="{{ route('secretaria.consultas.exportar.word') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors rounded-b-lg">
                        <svg class="w-4 h-4 inline-block mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Exportar a Word
                    </a>
                </div>
            </div>
            <a href="{{ route('secretaria.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
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
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105" onclick="filtrarPorEstado('')">
                    <p class="text-sm text-purple-100">Total Consultas</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['total'] ?? 0 }}</p>
                    <p class="text-xs text-purple-100 mt-1">Click para ver todas</p>
                </div>
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105" onclick="filtrarPorEstado('pendiente')">
                    <p class="text-sm text-yellow-100">Pendientes</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['pendientes'] ?? 0 }}</p>
                    <p class="text-xs text-yellow-100 mt-1">Click para filtrar</p>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105" onclick="filtrarPorEstado('respondida')">
                    <p class="text-sm text-green-100">Respondidas</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['respondidas'] ?? 0 }}</p>
                    <p class="text-xs text-green-100 mt-1">Click para filtrar</p>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105" onclick="filtrarPorFecha('hoy')">
                    <p class="text-sm text-blue-100">Hoy</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['hoy'] ?? 0 }}</p>
                    <p class="text-xs text-blue-100 mt-1">Click para filtrar</p>
                </div>
            </div>

            <!-- Panel principal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Listado de Consultas</h3>
                    </div>

                    <!-- Filtros -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                            <select id="filtro-estado" name="estado" onchange="aplicarFiltros()" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                <option value="">Todos</option>
                                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="respondida" {{ request('estado') == 'respondida' ? 'selected' : '' }}>Respondida</option>
                                <option value="cerrada" {{ request('estado') == 'cerrada' ? 'selected' : '' }}>Cerrada</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                            <select id="filtro-fecha" name="fecha" onchange="aplicarFiltros()" class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                <option value="">Todas</option>
                                <option value="hoy" {{ request('fecha') == 'hoy' ? 'selected' : '' }}>Hoy</option>
                                <option value="semana" {{ request('fecha') == 'semana' ? 'selected' : '' }}>Esta Semana</option>
                                <option value="mes" {{ request('fecha') == 'mes' ? 'selected' : '' }}>Este Mes</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                            <div class="flex gap-2">
                                <div class="relative flex-1">
                                    <input type="text" id="buscador" name="buscar" value="{{ request('buscar') }}" oninput="aplicarFiltros()" placeholder="Nombre, email, asunto, mensaje..." 
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 pl-10">
                                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                @if(request()->hasAny(['estado', 'fecha', 'buscar']))
                                <button onclick="limpiarFiltros()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de consultas -->
                    <div class="overflow-x-auto">
                        <table id="tabla-consultas" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-blue-600 to-blue-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Usuario</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Asunto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Mensaje</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($consultas as $consulta)
                                    <tr class="hover:bg-gray-50"
                                        data-estado="{{ $consulta->estado }}"
                                        data-fecha="{{ $consulta->created_at->format('Y-m-d') }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-600">#{{ $consulta->id }}</td>
                                        <td class="px-6 py-4">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $consulta->usuario->name ?? 'Usuario' }}</p>
                                                <p class="text-xs text-gray-500">{{ $consulta->usuario->email ?? '' }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="font-medium">{{ Str::limit($consulta->asunto ?? 'Sin asunto', 40) }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($consulta->mensaje, 60) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($consulta->estado == 'pendiente')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pendiente
                                            </span>
                                            @elseif($consulta->estado == 'respondida')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Respondida
                                            </span>
                                            @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Cerrada
                                            </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($consulta->created_at)->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex gap-2">
                                                <button class="text-purple-600 hover:text-purple-900" title="Ver consulta" onclick="verConsulta({{ $consulta->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </button>
                                                @if($consulta->estado == 'pendiente')
                                                <button class="text-green-600 hover:text-green-900" title="Responder" onclick="responderConsulta({{ $consulta->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                                    </svg>
                                                </button>
                                                @endif
                                                <button class="text-red-600 hover:text-red-900" title="Eliminar" onclick="eliminarConsulta({{ $consulta->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                            </svg>
                                            <p class="mt-2 text-sm font-medium">No hay consultas registradas</p>
                                            <p class="text-xs text-gray-400 mt-1">Las consultas aparecerán aquí cuando sean creadas</p>
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
                    @if($consultas->count() > 0)
                    <div class="mt-6 flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Mostrando <span class="font-medium">{{ $consultas->count() }}</span> consulta(s)
                        </div>
                    </div>
                    @endif

                    <!-- Paginación -->
                    @if($consultas->hasPages())
                    <div class="mt-6">
                        {{ $consultas->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ver Consulta -->
    <div id="modalVerConsulta" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-xl bg-white">
            <!-- Header -->
            <div class="bg-teal-600 px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Detalles de la Consulta</h3>
                    <button onclick="cerrarModal('modalVerConsulta')" class="text-white hover:text-gray-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div id="contenidoConsulta" class="p-6">
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-teal-600 mb-4"></div>
                    <p class="text-gray-600 font-medium">Cargando detalles...</p>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t rounded-b-xl flex justify-end">
                <button onclick="cerrarModal('modalVerConsulta')" class="px-6 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-medium shadow-sm">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Responder Consulta -->
    <div id="modalResponderConsulta" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-xl bg-white">
            <!-- Header -->
            <div class="bg-green-600 px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Responder Consulta</h3>
                    <button onclick="cerrarModal('modalResponderConsulta')" class="text-white hover:text-gray-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <form id="formResponderConsulta" onsubmit="enviarRespuesta(event)" class="p-6">
                <input type="hidden" id="consultaIdResponder" name="consulta_id">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Respuesta <span class="text-red-500">*</span></label>
                    <textarea name="respuesta" rows="6" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Escribe tu respuesta aquí..."></textarea>
                </div>

                <!-- Botones -->
                <div class="mt-6 pt-4 border-t flex justify-end gap-3">
                    <button type="button" onclick="cerrarModal('modalResponderConsulta')"
                            class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium shadow-sm">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Enviar Respuesta
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Filtrar por estado desde las tarjetas de estadísticas
        function filtrarPorEstado(estado) {
            document.getElementById('filtro-estado').value = estado;
            aplicarFiltros();
        }

        // Filtrar por fecha desde las tarjetas de estadísticas
        function filtrarPorFecha(periodo) {
            document.getElementById('filtro-fecha').value = periodo;
            aplicarFiltros();
        }

        // Aplicar filtros
        function aplicarFiltros() {
            const buscador = document.getElementById('buscador').value.toLowerCase();
            const filtroEstado = document.getElementById('filtro-estado').value;
            const filtroFecha = document.getElementById('filtro-fecha').value;
            
            const filas = document.querySelectorAll('#tabla-consultas tbody tr');
            let visibles = 0;
            
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);
            
            const inicioSemana = new Date(hoy);
            inicioSemana.setDate(hoy.getDate() - hoy.getDay());
            
            const inicioMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
            
            filas.forEach(fila => {
                if (fila.querySelector('td[colspan]')) return; // Skip empty state row
                
                const textoFila = fila.textContent.toLowerCase();
                const estado = fila.getAttribute('data-estado');
                const fechaStr = fila.getAttribute('data-fecha');
                const fecha = fechaStr ? new Date(fechaStr) : null;
                
                let mostrar = true;
                
                // Filtro de búsqueda
                if (buscador && !textoFila.includes(buscador)) {
                    mostrar = false;
                }
                
                // Filtro de estado
                if (filtroEstado && estado !== filtroEstado) {
                    mostrar = false;
                }
                
                // Filtro de fecha
                if (filtroFecha && fecha) {
                    fecha.setHours(0, 0, 0, 0);
                    if (filtroFecha === 'hoy' && fecha.getTime() !== hoy.getTime()) {
                        mostrar = false;
                    } else if (filtroFecha === 'semana' && fecha < inicioSemana) {
                        mostrar = false;
                    } else if (filtroFecha === 'mes' && fecha < inicioMes) {
                        mostrar = false;
                    }
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

        // Limpiar filtros
        function limpiarFiltros() {
            document.getElementById('buscador').value = '';
            document.getElementById('filtro-estado').value = '';
            document.getElementById('filtro-fecha').value = '';
            aplicarFiltros();
        }

        // Ver consulta con loading
        async function verConsulta(id) {
            const modal = document.getElementById('modalVerConsulta');
            const contenedor = document.getElementById('contenidoConsulta');
            
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
                const response = await fetch(`/secretaria/consultas/${id}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                const consulta = await response.json();
                
                const estadoBadges = {
                    'pendiente': 'bg-yellow-500 text-white',
                    'respondida': 'bg-green-500 text-white',
                    'cerrada': 'bg-gray-500 text-white'
                };
                
                // Animación de fade in para el contenido
                setTimeout(() => {
                    contenedor.innerHTML = `
                        <div class="animate-fadeIn">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- ID -->
                                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">ID de Consulta</p>
                                    <p class="text-lg font-bold text-gray-900">#${consulta.id}</p>
                                </div>
                                
                                <!-- Estado -->
                                <div class="bg-gradient-to-br from-teal-50 to-cyan-50 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Estado</p>
                                    <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold shadow-sm ${estadoBadges[consulta.estado] || 'bg-gray-500 text-white'}">
                                        ${consulta.estado}
                                    </span>
                                </div>
                                
                                <!-- Usuario -->
                                <div class="md:col-span-2 bg-white border-2 border-gray-200 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Usuario</p>
                                    <p class="text-base font-semibold text-gray-900">${consulta.usuario?.name || 'N/A'}</p>
                                    <p class="text-sm text-gray-600">${consulta.usuario?.email || ''}</p>
                                </div>
                                
                                <!-- Asunto -->
                                <div class="md:col-span-2 bg-purple-50 p-4 rounded-lg border-l-4 border-purple-500">
                                    <p class="text-xs font-medium text-purple-700 uppercase mb-1">Asunto</p>
                                    <p class="text-base font-semibold text-gray-900">${consulta.asunto || 'Sin asunto'}</p>
                                </div>
                                
                                <!-- Mensaje -->
                                <div class="md:col-span-2 bg-white border-2 border-gray-200 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-2">Mensaje</p>
                                    <div class="text-sm text-gray-700 bg-gray-50 p-4 rounded border leading-relaxed max-h-64 overflow-y-auto">
                                        ${consulta.mensaje ? consulta.mensaje.replace(/\n/g, '<br>') : '<span class="text-gray-400">Sin mensaje</span>'}
                                    </div>
                                </div>
                                
                                ${consulta.respuesta ? `
                                <div class="md:col-span-2 bg-green-50 p-4 rounded-lg border-l-4 border-green-500">
                                    <p class="text-xs font-medium text-green-700 uppercase mb-2">Respuesta</p>
                                    <p class="text-sm text-gray-700">${consulta.respuesta}</p>
                                    <p class="text-xs text-gray-500 mt-2">Respondida el: ${new Date(consulta.respondido_at).toLocaleString('es-ES')}</p>
                                </div>` : ''}
                                
                                <!-- Fecha Creación -->
                                <div class="md:col-span-2 bg-white border-2 border-gray-200 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Fecha de Creación</p>
                                    <p class="text-base text-gray-900">${new Date(consulta.created_at).toLocaleString('es-ES')}</p>
                                </div>
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

        function responderConsulta(id) {
            document.getElementById('consultaIdResponder').value = id;
            document.getElementById('modalResponderConsulta').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        async function enviarRespuesta(event) {
            event.preventDefault();
            const form = event.target;
            const id = document.getElementById('consultaIdResponder').value;
            const formData = new FormData(form);
            
            try {
                const response = await fetch(`/secretaria/consultas/${id}/responder`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert('Respuesta enviada exitosamente');
                    cerrarModal('modalResponderConsulta');
                    window.location.reload();
                } else {
                    alert('Error al enviar respuesta');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error de conexión');
            }
        }

        function eliminarConsulta(id) {
            if (!confirm('¿Estás seguro de eliminar esta consulta? Esta acción no se puede deshacer.')) return;
            
            fetch(`/secretaria/consultas/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Consulta eliminada exitosamente');
                    window.location.reload();
                } else {
                    alert('Error al eliminar consulta');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error de conexión');
            });
        }

        function cerrarModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Dropdown de exportar
        document.addEventListener('DOMContentLoaded', function() {
            const exportBtn = document.getElementById('exportDropdownBtn');
            const exportDropdown = document.getElementById('exportDropdown');
            
            if (exportBtn && exportDropdown) {
                exportBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    exportDropdown.classList.toggle('hidden');
                });
                
                // Cerrar dropdown al hacer clic fuera
                document.addEventListener('click', function(e) {
                    if (!exportBtn.contains(e.target) && !exportDropdown.contains(e.target)) {
                        exportDropdown.classList.add('hidden');
                    }
                });
            }
        });

        // Cerrar modales al hacer clic fuera
        document.getElementById('modalVerConsulta')?.addEventListener('click', function(e) {
            if (e.target === this) cerrarModal('modalVerConsulta');
        });
        document.getElementById('modalResponderConsulta')?.addEventListener('click', function(e) {
            if (e.target === this) cerrarModal('modalResponderConsulta');
        });
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }

        .animate-shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>
@endsection