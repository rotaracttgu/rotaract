@extends('modulos.secretaria.layout')  

@section('title', 'Gestión de Actas')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Gestión de Actas</h1>
            <p class="text-gray-600 mt-1">Administra todas las actas del club</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.location.reload()" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Actualizar
            </button>
            <button onclick="nuevaActa()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Acta
            </button>
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
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105">
                    <p class="text-sm text-blue-100">Total Actas</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['total'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105">
                    <p class="text-sm text-indigo-100">Este Mes</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['este_mes'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105">
                    <p class="text-sm text-purple-100">Este Año</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['este_anio'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105">
                    <p class="text-sm text-green-100">Ordinarias</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['ordinarias'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-amber-500 to-amber-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105">
                    <p class="text-sm text-amber-100">Extraordinarias</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['extraordinarias'] ?? 0 }}</p>
                </div>
            </div>

            <!-- Panel principal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Listado de Actas</h3>
                    </div>

                    <!-- Tabla de actas -->
                    <div class="overflow-x-auto">
                        <table id="tabla-actas" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-blue-600 to-blue-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Título</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Fecha Reunión</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Archivo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($actas as $acta)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-600">#{{ $acta->id }}</td>
                                        <td class="px-6 py-4">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $acta->titulo }}</p>
                                                @if($acta->contenido)
                                                    <p class="text-xs text-gray-500">{{ Str::limit($acta->contenido, 60) }}</p>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 capitalize">
                                                {{ $acta->tipo_reunion }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($acta->fecha_reunion)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($acta->archivo_path)
                                            <a href="{{ Storage::url($acta->archivo_path) }}" target="_blank" class="inline-flex items-center gap-1 text-red-600 hover:text-red-700">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                </svg>
                                                <span class="text-sm font-semibold">Ver PDF</span>
                                            </a>
                                            @else
                                            <span class="text-gray-400 text-sm">Sin archivo</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex gap-2">
                                                <button class="text-purple-600 hover:text-purple-900" title="Ver acta" onclick="verActa({{ $acta->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-yellow-600 hover:text-yellow-900" title="Editar" onclick="editarActa({{ $acta->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-red-600 hover:text-red-900" title="Eliminar" onclick="eliminarActa({{ $acta->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="mt-2 text-sm font-medium">No hay actas registradas</p>
                                            <p class="text-xs text-gray-400 mt-1">Las actas aparecerán aquí cuando sean creadas</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Información de resultados -->
                    @if($actas->count() > 0)
                    <div class="mt-6 flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Mostrando <span class="font-medium">{{ $actas->count() }}</span> acta(s)
                        </div>
                    </div>
                    @endif

                    <!-- Paginación -->
                    @if($actas->hasPages())
                    <div class="mt-6">
                        {{ $actas->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear/Editar Acta -->
    <div id="modalActa" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-2/3 shadow-2xl rounded-xl bg-white">
            <!-- Header -->
            <div class="bg-blue-600 px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">
                        <span id="textoTituloActa">Nueva Acta</span>
                    </h3>
                    <button onclick="cerrarModalActa()" class="text-white hover:text-gray-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <form id="formActa" enctype="multipart/form-data" class="p-6">
                <input type="hidden" id="actaId" name="acta_id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Título -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Título del Acta <span class="text-red-500">*</span></label>
                        <input type="text" name="titulo" id="titulo" required 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Ej: Acta de Reunión Ordinaria #05">
                    </div>

                    <!-- Fecha Reunión -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Reunión <span class="text-red-500">*</span></label>
                        <input type="date" name="fecha_reunion" id="fecha_reunion" required 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Tipo de Reunión -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Reunión <span class="text-red-500">*</span></label>
                        <select name="tipo_reunion" id="tipo_reunion" required 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Seleccionar...</option>
                            <option value="ordinaria">Ordinaria</option>
                            <option value="extraordinaria">Extraordinaria</option>
                            <option value="junta">Junta Directiva</option>
                            <option value="asamblea">Asamblea General</option>
                        </select>
                    </div>

                    <!-- Contenido/Descripción -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contenido del Acta <span class="text-red-500">*</span></label>
                        <textarea name="contenido" id="contenido" rows="6" required 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Describe el desarrollo de la reunión, temas tratados, decisiones tomadas..."></textarea>
                    </div>

                    <!-- Asistentes -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Asistentes</label>
                        <textarea name="asistentes" id="asistentes" rows="3" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Nombres de los asistentes, separados por comas..."></textarea>
                    </div>

                    <!-- Archivo PDF -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Archivo PDF</label>
                        <input type="file" name="archivo_pdf" id="archivo_pdf" accept=".pdf"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Formato: PDF. Tamaño máximo: 5MB</p>
                        <div id="archivoActual" class="hidden mt-2 p-3 bg-blue-50 rounded-lg">
                            <p class="text-sm text-blue-700">
                                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <span>Archivo actual: </span>
                                <a href="#" id="linkArchivoActual" target="_blank" class="font-semibold hover:underline">Ver archivo</a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="mt-6 pt-4 border-t flex justify-end gap-3">
                    <button type="button" onclick="cerrarModalActa()"
                            class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium shadow-sm">
                        Cancelar
                    </button>
                    <button type="submit" id="btnGuardarActa"
                            class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium shadow-md hover:shadow-lg">
                        <span id="textoBotonGuardar">Crear Acta</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Ver Acta -->
    <div id="modalVerActa" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-2/3 shadow-2xl rounded-xl bg-white">
            <!-- Header -->
            <div class="bg-teal-600 px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Detalles del Acta</h3>
                    <button onclick="cerrarModal('modalVerActa')" class="text-white hover:text-gray-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div id="contenidoActa" class="p-6">
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-teal-600 mb-4"></div>
                    <p class="text-gray-600 font-medium">Cargando detalles...</p>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t rounded-b-xl flex justify-end">
                <button onclick="cerrarModal('modalVerActa')" class="px-6 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-medium shadow-sm">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <script>
        // Abrir modal para crear nueva acta
        function nuevaActa() {
            document.getElementById('actaId').value = '';
            document.getElementById('formActa').reset();
            document.getElementById('textoTituloActa').textContent = 'Nueva Acta';
            document.getElementById('textoBotonGuardar').textContent = 'Crear Acta';
            document.getElementById('archivoActual').classList.add('hidden');
            document.getElementById('modalActa').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Ver detalles de un acta
        async function verActa(id) {
            const modal = document.getElementById('modalVerActa');
            const contenedor = document.getElementById('contenidoActa');
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            contenedor.innerHTML = `
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-teal-600 mb-4"></div>
                    <p class="text-gray-600 font-medium">Cargando detalles...</p>
                </div>
            `;
            
            try {
                const response = await fetch(`/secretaria/actas/${id}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                const acta = await response.json();
                
                const fechaReunion = new Date(acta.fecha_reunion).toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                setTimeout(() => {
                    contenedor.innerHTML = `
                        <div class="animate-fadeIn">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Título y Tipo -->
                                <div class="md:col-span-2 bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Título del Acta</p>
                                    <p class="text-lg font-bold text-gray-900">${acta.titulo}</p>
                                    <div class="mt-3 flex gap-2">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full capitalize">${acta.tipo_reunion}</span>
                                        <span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs font-semibold rounded-full">${fechaReunion}</span>
                                    </div>
                                </div>
                                
                                <!-- Contenido -->
                                <div class="md:col-span-2 bg-white border-2 border-gray-200 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-2">Contenido del Acta</p>
                                    <div class="text-sm text-gray-700 bg-gray-50 p-4 rounded border leading-relaxed max-h-64 overflow-y-auto">
                                        ${acta.contenido ? acta.contenido.replace(/\n/g, '<br>') : '<span class="text-gray-400">Sin contenido</span>'}
                                    </div>
                                </div>
                                
                                ${acta.asistentes ? `
                                <div class="md:col-span-2 bg-green-50 p-4 rounded-lg border-l-4 border-green-500">
                                    <p class="text-xs font-medium text-green-700 uppercase mb-2">Asistentes</p>
                                    <p class="text-sm text-gray-700">${acta.asistentes}</p>
                                </div>` : ''}
                                
                                ${acta.archivo_path ? `
                                <div class="md:col-span-2">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-2">Documento</p>
                                    <div class="flex gap-2">
                                        <a href="/storage/${acta.archivo_path}" target="_blank" 
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium text-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Ver PDF
                                        </a>
                                        <a href="/secretaria/actas/${acta.id}/descargar" 
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Descargar
                                        </a>
                                    </div>
                                </div>
                                ` : `
                                <div class="md:col-span-2">
                                    <a href="/secretaria/actas/${acta.id}/descargar" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Generar y Descargar PDF
                                    </a>
                                </div>
                                `}
                                
                                <!-- Metadata -->
                                <div class="md:col-span-2 bg-gray-50 p-4 rounded-lg">
                                    <p class="text-xs text-gray-500"><strong>Creado por:</strong> ${acta.creador?.name || 'Sistema'}</p>
                                    <p class="text-xs text-gray-500"><strong>Fecha de creación:</strong> ${new Date(acta.created_at).toLocaleString('es-ES')}</p>
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

        // Editar un acta existente
        async function editarActa(id) {
            try {
                const response = await fetch(`/secretaria/actas/${id}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                const acta = await response.json();
                
                document.getElementById('actaId').value = acta.id;
                document.getElementById('titulo').value = acta.titulo;
                document.getElementById('fecha_reunion').value = acta.fecha_reunion;
                document.getElementById('tipo_reunion').value = acta.tipo_reunion;
                document.getElementById('contenido').value = acta.contenido || '';
                document.getElementById('asistentes').value = acta.asistentes || '';
                
                document.getElementById('textoTituloActa').textContent = 'Editar Acta';
                document.getElementById('textoBotonGuardar').textContent = 'Actualizar Acta';
                
                if (acta.archivo_path) {
                    document.getElementById('archivoActual').classList.remove('hidden');
                    document.getElementById('linkArchivoActual').href = `/storage/${acta.archivo_path}`;
                } else {
                    document.getElementById('archivoActual').classList.add('hidden');
                }
                
                document.getElementById('modalActa').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } catch (error) {
                alert('Error al cargar los datos del acta');
                console.error(error);
            }
        }

        // Guardar acta (crear o actualizar)
        document.getElementById('formActa').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const actaId = document.getElementById('actaId').value;
            const formData = new FormData(this);
            const isEdit = actaId !== '';
            
            const url = isEdit ? `/secretaria/actas/${actaId}` : '/secretaria/actas';
            
            const btnGuardar = document.getElementById('btnGuardarActa');
            const textoOriginal = btnGuardar.innerHTML;
            btnGuardar.disabled = true;
            btnGuardar.innerHTML = '<svg class="animate-spin h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Guardando...';
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(isEdit ? 'Acta actualizada exitosamente' : 'Acta creada exitosamente');
                    cerrarModalActa();
                    window.location.reload();
                } else {
                    alert(data.message || 'Error al guardar el acta');
                    btnGuardar.disabled = false;
                    btnGuardar.innerHTML = textoOriginal;
                }
            })
            .catch(error => {
                alert('Error de conexión. Por favor, intenta de nuevo.');
                console.error(error);
                btnGuardar.disabled = false;
                btnGuardar.innerHTML = textoOriginal;
            });
        });

        // Eliminar acta
        function eliminarActa(id) {
            if (!confirm('¿Estás seguro de eliminar esta acta? Esta acción no se puede deshacer.')) return;
            
            fetch(`/secretaria/actas/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Acta eliminada exitosamente');
                    window.location.reload();
                } else {
                    alert(data.message || 'Error al eliminar el acta');
                }
            })
            .catch(error => {
                alert('Error de conexión');
                console.error(error);
            });
        }

        function cerrarModalActa() {
            document.getElementById('modalActa').classList.add('hidden');
            document.getElementById('formActa').reset();
            document.body.style.overflow = 'auto';
        }

        function cerrarModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Cerrar modales al hacer clic fuera
        document.getElementById('modalActa')?.addEventListener('click', function(e) {
            if (e.target === this) cerrarModalActa();
        });
        document.getElementById('modalVerActa')?.addEventListener('click', function(e) {
            if (e.target === this) cerrarModal('modalVerActa');
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