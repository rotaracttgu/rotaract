@extends('modulos.secretaria.layout')  

@section('title', 'Gestión de Documentos')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Gestión de Documentos</h1>
            <p class="text-gray-600 mt-1">Administra todos los documentos archivados</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.location.reload()" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Actualizar
            </button>
            <button onclick="nuevoDocumento()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nuevo Documento
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
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-6">
                <div class="bg-gradient-to-br from-green-500 to-green-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105">
                    <p class="text-sm text-green-100">Total</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['total'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105">
                    <p class="text-sm text-blue-100">Este Mes</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['este_mes'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105">
                    <p class="text-sm text-purple-100">Este Año</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['este_anio'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-amber-500 to-amber-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105">
                    <p class="text-sm text-amber-100">Categorías</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['categorias'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-rose-500 to-rose-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105">
                    <p class="text-sm text-rose-100">Oficiales</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['oficiales'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105">
                    <p class="text-sm text-cyan-100">Internos</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['internos'] ?? 0 }}</p>
                </div>
            </div>

            <!-- Panel principal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Listado de Documentos</h3>
                    </div>

                    <!-- Tabla de documentos -->
                    <div class="overflow-x-auto">
                        <table id="tabla-documentos" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-blue-600 to-blue-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Título</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Categoría</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Archivo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($documentos as $documento)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-600">#{{ $documento->id }}</td>
                                        <td class="px-6 py-4">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $documento->titulo }}</p>
                                                @if($documento->descripcion)
                                                    <p class="text-xs text-gray-500">{{ Str::limit($documento->descripcion, 50) }}</p>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 capitalize">
                                                {{ $documento->tipo }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-600 capitalize">{{ $documento->categoria ?? 'General' }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($documento->archivo_path)
                                            <a href="{{ Storage::url($documento->archivo_path) }}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <span class="text-sm font-semibold">Descargar</span>
                                            </a>
                                            @else
                                            <span class="text-gray-400 text-sm">Sin archivo</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($documento->created_at)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex gap-2">
                                                <button class="text-purple-600 hover:text-purple-900" title="Ver documento" onclick="verDocumento({{ $documento->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-yellow-600 hover:text-yellow-900" title="Editar" onclick="editarDocumento({{ $documento->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-red-600 hover:text-red-900" title="Eliminar" onclick="eliminarDocumento({{ $documento->id }})">
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                            </svg>
                                            <p class="mt-2 text-sm font-medium">No hay documentos archivados</p>
                                            <p class="text-xs text-gray-400 mt-1">Los documentos aparecerán aquí cuando sean creados</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Información de resultados -->
                    @if($documentos->count() > 0)
                    <div class="mt-6 flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Mostrando <span class="font-medium">{{ $documentos->count() }}</span> documento(s)
                        </div>
                    </div>
                    @endif

                    <!-- Paginación -->
                    @if($documentos->hasPages())
                    <div class="mt-6">
                        {{ $documentos->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear/Editar Documento -->
    <div id="modalDocumento" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-xl bg-white">
            <!-- Header -->
            <div class="bg-green-600 px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">
                        <span id="textoTituloDocumento">Nuevo Documento</span>
                    </h3>
                    <button onclick="cerrarModalDocumento()" class="text-white hover:text-gray-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <form id="formDocumento" enctype="multipart/form-data" class="p-6">
                <input type="hidden" id="documentoId" name="documento_id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Título -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Título del Documento <span class="text-red-500">*</span></label>
                        <input type="text" name="titulo" id="titulo_doc" required 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                            placeholder="Ej: Acta de Constitución 2024">
                    </div>

                    <!-- Tipo de Documento -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo <span class="text-red-500">*</span></label>
                        <select name="tipo" id="tipo_doc" required 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            <option value="">Seleccionar...</option>
                            <option value="oficial">Oficial</option>
                            <option value="interno">Interno</option>
                            <option value="comunicado">Comunicado</option>
                            <option value="carta">Carta</option>
                            <option value="informe">Informe</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>

                    <!-- Categoría -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                        <input type="text" name="categoria" id="categoria_doc" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                            placeholder="Ej: Administrativo, Legal, Eventos...">
                    </div>

                    <!-- Descripción -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea name="descripcion" id="descripcion_doc" rows="4" maxlength="1000"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                            placeholder="Breve descripción del documento..."></textarea>
                        <p class="text-xs text-gray-500 mt-1">Máximo 1000 caracteres</p>
                    </div>

                    <!-- Archivo -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Archivo <span class="text-red-500">*</span></label>
                        <input type="file" name="archivo" id="archivo_doc" accept=".pdf,.doc,.docx,.xls,.xlsx" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <p class="text-xs text-gray-500 mt-1">Formatos: PDF, DOC, DOCX, XLS, XLSX. Tamaño máximo: 10MB</p>
                        <div id="archivoActualDoc" class="hidden mt-2 p-3 bg-blue-50 rounded-lg">
                            <p class="text-sm text-blue-700">
                                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>Archivo actual: </span>
                                <a href="#" id="linkArchivoActualDoc" target="_blank" class="font-semibold hover:underline">Ver archivo</a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="mt-6 pt-4 border-t flex justify-end gap-3">
                    <button type="button" onclick="cerrarModalDocumento()"
                            class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium shadow-sm">
                        Cancelar
                    </button>
                    <button type="submit" id="btnGuardarDocumento"
                            class="px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium shadow-md hover:shadow-lg">
                        <span id="textoBotonGuardarDoc">Guardar Documento</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Ver Documento -->
    <div id="modalVerDocumento" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-xl bg-white">
            <!-- Header -->
            <div class="bg-teal-600 px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Detalles del Documento</h3>
                    <button onclick="cerrarModal('modalVerDocumento')" class="text-white hover:text-gray-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div id="contenidoDocumento" class="p-6">
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-teal-600 mb-4"></div>
                    <p class="text-gray-600 font-medium">Cargando detalles...</p>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t rounded-b-xl flex justify-end">
                <button onclick="cerrarModal('modalVerDocumento')" class="px-6 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-medium shadow-sm">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <script>
        // Abrir modal para crear nuevo documento
        function nuevoDocumento() {
            document.getElementById('documentoId').value = '';
            document.getElementById('formDocumento').reset();
            document.getElementById('textoTituloDocumento').textContent = 'Nuevo Documento';
            document.getElementById('textoBotonGuardarDoc').textContent = 'Guardar Documento';
            document.getElementById('archivoActualDoc').classList.add('hidden');
            document.getElementById('archivo_doc').required = true;
            document.getElementById('modalDocumento').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Ver detalles de un documento
        async function verDocumento(id) {
            const modal = document.getElementById('modalVerDocumento');
            const contenedor = document.getElementById('contenidoDocumento');
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            contenedor.innerHTML = `
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-teal-600 mb-4"></div>
                    <p class="text-gray-600 font-medium">Cargando detalles...</p>
                </div>
            `;
            
            try {
                const response = await fetch(`/secretaria/documentos/${id}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                const doc = await response.json();
                
                const fechaCreacion = new Date(doc.created_at).toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                let iconoArchivo = 'fa-file';
                if (doc.archivo_nombre) {
                    const ext = doc.archivo_nombre.split('.').pop().toLowerCase();
                    if (ext === 'pdf') iconoArchivo = 'fa-file-pdf text-red-500';
                    else if (['doc', 'docx'].includes(ext)) iconoArchivo = 'fa-file-word text-blue-500';
                    else if (['xls', 'xlsx'].includes(ext)) iconoArchivo = 'fa-file-excel text-green-500';
                }
                
                setTimeout(() => {
                    contenedor.innerHTML = `
                        <div class="animate-fadeIn">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Título y Tipo -->
                                <div class="md:col-span-2 bg-gradient-to-br from-green-50 to-lime-50 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Título del Documento</p>
                                    <p class="text-lg font-bold text-gray-900">${doc.titulo}</p>
                                    <div class="mt-3 flex gap-2">
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full capitalize">${doc.tipo}</span>
                                        ${doc.categoria ? 
                                            `<span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">${doc.categoria}</span>` : ''
                                        }
                                        <span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs font-semibold rounded-full">${fechaCreacion}</span>
                                    </div>
                                </div>
                                
                                ${doc.descripcion ? `
                                <div class="md:col-span-2 bg-white border-2 border-gray-200 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-2">Descripción</p>
                                    <div class="text-sm text-gray-700 bg-gray-50 p-4 rounded">
                                        ${doc.descripcion}
                                    </div>
                                </div>` : ''}
                                
                                ${doc.archivo_path ? `
                                <div class="md:col-span-2 bg-gray-50 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-3">Archivo</p>
                                    <div class="flex items-center gap-4">
                                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <div class="flex-1">
                                            <p class="font-semibold text-gray-800">${doc.archivo_nombre || 'Documento'}</p>
                                            <p class="text-sm text-gray-500">Formato: ${doc.archivo_nombre ? doc.archivo_nombre.split('.').pop().toUpperCase() : 'Desconocido'}</p>
                                        </div>
                                        <a href="/storage/${doc.archivo_path}" target="_blank" download
                                           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-sm inline-flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Descargar
                                        </a>
                                    </div>
                                </div>
                                ` : '<p class="md:col-span-2 text-gray-500 italic">No hay archivo adjunto</p>'}
                                
                                <!-- Metadata -->
                                <div class="md:col-span-2 bg-gray-50 p-4 rounded-lg text-sm text-gray-500 space-y-1">
                                    <p><strong>Creado por:</strong> ${doc.creador?.name || 'Sistema'}</p>
                                    <p><strong>Fecha de creación:</strong> ${new Date(doc.created_at).toLocaleString('es-ES')}</p>
                                    <p><strong>Última actualización:</strong> ${new Date(doc.updated_at).toLocaleString('es-ES')}</p>
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

        // Editar un documento existente
        async function editarDocumento(id) {
            try {
                const response = await fetch(`/secretaria/documentos/${id}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                const doc = await response.json();
                
                document.getElementById('documentoId').value = doc.id;
                document.getElementById('titulo_doc').value = doc.titulo;
                document.getElementById('tipo_doc').value = doc.tipo;
                document.getElementById('categoria_doc').value = doc.categoria || '';
                document.getElementById('descripcion_doc').value = doc.descripcion || '';
                
                document.getElementById('textoTituloDocumento').textContent = 'Editar Documento';
                document.getElementById('textoBotonGuardarDoc').textContent = 'Actualizar Documento';
                document.getElementById('archivo_doc').required = false;
                
                if (doc.archivo_path) {
                    document.getElementById('archivoActualDoc').classList.remove('hidden');
                    document.getElementById('linkArchivoActualDoc').href = `/storage/${doc.archivo_path}`;
                    document.getElementById('linkArchivoActualDoc').textContent = doc.archivo_nombre || 'Ver archivo';
                } else {
                    document.getElementById('archivoActualDoc').classList.add('hidden');
                }
                
                document.getElementById('modalDocumento').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } catch (error) {
                alert('Error al cargar los datos del documento');
                console.error(error);
            }
        }

        // Guardar documento (crear o actualizar)
        document.getElementById('formDocumento').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const documentoId = document.getElementById('documentoId').value;
            const formData = new FormData(this);
            const isEdit = documentoId !== '';
            
            const url = isEdit ? `/secretaria/documentos/${documentoId}` : '/secretaria/documentos';
            
            const btnGuardar = document.getElementById('btnGuardarDocumento');
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
                    alert(isEdit ? 'Documento actualizado exitosamente' : 'Documento creado exitosamente');
                    cerrarModalDocumento();
                    window.location.reload();
                } else {
                    alert(data.message || 'Error al guardar el documento');
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

        // Eliminar documento
        function eliminarDocumento(id) {
            if (!confirm('¿Estás seguro de eliminar este documento? Esta acción no se puede deshacer.')) return;
            
            fetch(`/secretaria/documentos/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Documento eliminado exitosamente');
                    window.location.reload();
                } else {
                    alert(data.message || 'Error al eliminar el documento');
                }
            })
            .catch(error => {
                alert('Error de conexión');
                console.error(error);
            });
        }

        function cerrarModalDocumento() {
            document.getElementById('modalDocumento').classList.add('hidden');
            document.getElementById('formDocumento').reset();
            document.body.style.overflow = 'auto';
        }

        function cerrarModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Cerrar modales al hacer clic fuera
        document.getElementById('modalDocumento')?.addEventListener('click', function(e) {
            if (e.target === this) cerrarModalDocumento();
        });
        document.getElementById('modalVerDocumento')?.addEventListener('click', function(e) {
            if (e.target === this) cerrarModal('modalVerDocumento');
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