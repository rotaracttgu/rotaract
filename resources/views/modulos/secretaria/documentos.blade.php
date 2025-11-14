@extends('layouts.app')

@section('title', 'Gestión de Documentos')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-green-500 via-emerald-500 to-lime-500 h-2"></div>
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('secretaria.dashboard') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fas fa-arrow-left text-gray-600"></i>
                        </a>
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-lime-600 bg-clip-text text-transparent flex items-center gap-3">
                                <i class="fas fa-folder-open"></i>
                                Gestión de Documentos
                            </h1>
                            <p class="text-gray-600 mt-1">Administra todos los documentos archivados</p>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        <button onclick="window.location.reload()" class="px-4 py-2 bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                            <i class="fas fa-sync-alt"></i>
                            <span>Actualizar</span>
                        </button>
                        <button onclick="nuevoDocumento()" class="px-4 py-2 bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 text-white rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                            <i class="fas fa-plus"></i>
                            <span>Nuevo Documento</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-lime-500 rounded-lg flex items-center justify-center mb-3">
                    <i class="fas fa-folder-open text-white text-xl"></i>
                </div>
                <div class="text-3xl font-bold text-gray-800">{{ $estadisticas['total'] ?? 0 }}</div>
                <div class="text-gray-600 font-semibold">Total</div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center mb-3">
                    <i class="fas fa-calendar-check text-white text-xl"></i>
                </div>
                <div class="text-3xl font-bold text-gray-800">{{ $estadisticas['este_mes'] ?? 0 }}</div>
                <div class="text-gray-600 font-semibold">Este Mes</div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center mb-3">
                    <i class="fas fa-calendar-alt text-white text-xl"></i>
                </div>
                <div class="text-3xl font-bold text-gray-800">{{ $estadisticas['este_anio'] ?? 0 }}</div>
                <div class="text-gray-600 font-semibold">Este Año</div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-500 rounded-lg flex items-center justify-center mb-3">
                    <i class="fas fa-layer-group text-white text-xl"></i>
                </div>
                <div class="text-3xl font-bold text-gray-800">{{ $estadisticas['categorias'] ?? 0 }}</div>
                <div class="text-gray-600 font-semibold text-sm">Categorías</div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="w-12 h-12 bg-gradient-to-br from-rose-500 to-red-500 rounded-lg flex items-center justify-center mb-3">
                    <i class="fas fa-file-contract text-white text-xl"></i>
                </div>
                <div class="text-3xl font-bold text-gray-800">{{ $estadisticas['oficiales'] ?? 0 }}</div>
                <div class="text-gray-600 font-semibold">Oficiales</div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-lg flex items-center justify-center mb-3">
                    <i class="fas fa-file-alt text-white text-xl"></i>
                </div>
                <div class="text-3xl font-bold text-gray-800">{{ $estadisticas['internos'] ?? 0 }}</div>
                <div class="text-gray-600 font-semibold">Internos</div>
            </div>
        </div>

        <!-- Tabla de Documentos -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-green-500 to-lime-500 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">ID</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Título</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Tipo</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Categoría</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Archivo</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Fecha</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($documentos as $documento)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-gray-600">#{{ $documento->id }}</td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">{{ $documento->titulo }}</div>
                                @if($documento->descripcion)
                                <div class="text-sm text-gray-500">{{ Str::limit($documento->descripcion, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full capitalize">
                                    {{ $documento->tipo }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600 capitalize">{{ $documento->categoria ?? 'General' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($documento->archivo_path)
                                <a href="{{ Storage::url($documento->archivo_path) }}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700">
                                    <i class="fas fa-download"></i>
                                    <span class="text-sm font-semibold">Descargar</span>
                                </a>
                                @else
                                <span class="text-gray-400 text-sm">Sin archivo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <i class="fas fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($documento->created_at)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="verDocumento({{ $documento->id }})" class="w-8 h-8 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors" title="Ver detalles">
                                        <i class="fas fa-eye text-sm"></i>
                                    </button>
                                    <button onclick="editarDocumento({{ $documento->id }})" class="w-8 h-8 bg-amber-100 hover:bg-amber-200 text-amber-600 rounded-lg transition-colors" title="Editar">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <button onclick="eliminarDocumento({{ $documento->id }})" class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors" title="Eliminar">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i class="fas fa-folder-open text-6xl mb-4 opacity-30"></i>
                                    <p class="text-lg font-semibold">No hay documentos archivados</p>
                                    <p class="text-sm">Los documentos aparecerán aquí cuando sean creados</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($documentos->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $documentos->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
    </div>
</div>

<!-- Modal Crear/Editar Documento -->
<div id="modalDocumento" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-xl max-w-3xl w-full my-8">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 id="tituloModalDocumento" class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-folder-open text-green-600"></i>
                    <span id="textoTituloDocumento">Nuevo Documento</span>
                </h3>
                <button onclick="cerrarModalDocumento()" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    <i class="fas fa-times text-gray-600"></i>
                </button>
            </div>
        </div>
        
        <form id="formDocumento" enctype="multipart/form-data" class="p-6">
            <input type="hidden" id="documentoId" name="documento_id">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Título -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-heading text-green-500"></i> Título del Documento *
                    </label>
                    <input type="text" name="titulo" id="titulo_doc" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Ej: Acta de Constitución 2024">
                </div>

                <!-- Tipo de Documento -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-tag text-green-500"></i> Tipo *
                    </label>
                    <select name="tipo" id="tipo_doc" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
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
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-layer-group text-green-500"></i> Categoría
                    </label>
                    <input type="text" name="categoria" id="categoria_doc" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Ej: Administrativo, Legal, Eventos...">
                </div>

                <!-- Descripción -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-align-left text-green-500"></i> Descripción
                    </label>
                    <textarea name="descripcion" id="descripcion_doc" rows="4" maxlength="1000"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Breve descripción del documento..."></textarea>
                    <p class="text-xs text-gray-500 mt-1">Máximo 1000 caracteres</p>
                </div>

                <!-- Archivo -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-paperclip text-green-500"></i> Archivo *
                    </label>
                    <input type="file" name="archivo" id="archivo_doc" accept=".pdf,.doc,.docx,.xls,.xlsx" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Formatos: PDF, DOC, DOCX, XLS, XLSX. Tamaño máximo: 10MB</p>
                    <div id="archivoActualDoc" class="hidden mt-2 p-3 bg-blue-50 rounded-lg">
                        <p class="text-sm text-blue-700">
                            <i class="fas fa-file"></i>
                            <span>Archivo actual: </span>
                            <a href="#" id="linkArchivoActualDoc" target="_blank" class="font-semibold hover:underline">Ver archivo</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200">
                <button type="submit" id="btnGuardarDocumento" 
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i><span id="textoBotonGuardarDoc">Guardar Documento</span>
                </button>
                <button type="button" onclick="cerrarModalDocumento()" 
                    class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Ver Documento -->
<div id="modalVerDocumento" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-file-alt text-green-600"></i>
                    Detalles del Documento
                </h3>
                <button onclick="cerrarModal('modalVerDocumento')" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    <i class="fas fa-times text-gray-600"></i>
                </button>
            </div>
        </div>
        <div id="contenidoDocumento" class="p-6">
            <div class="animate-pulse space-y-4">
                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                <div class="h-4 bg-gray-200 rounded w-1/2"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ============================================================================
// FUNCIONES PARA GESTIÓN DE DOCUMENTOS
// ============================================================================

/**
 * Abrir modal para crear nuevo documento
 */
function nuevoDocumento() {
    document.getElementById('documentoId').value = '';
    document.getElementById('formDocumento').reset();
    document.getElementById('textoTituloDocumento').textContent = 'Nuevo Documento';
    document.getElementById('textoBotonGuardarDoc').textContent = 'Guardar Documento';
    document.getElementById('archivoActualDoc').classList.add('hidden');
    document.getElementById('archivo_doc').required = true;
    document.getElementById('modalDocumento').classList.remove('hidden');
}

/**
 * Ver detalles de un documento
 */
function verDocumento(id) {
    document.getElementById('modalVerDocumento').classList.remove('hidden');
    document.getElementById('contenidoDocumento').innerHTML = `
        <div class="animate-pulse space-y-4">
            <div class="h-4 bg-gray-200 rounded w-3/4"></div>
            <div class="h-4 bg-gray-200 rounded w-1/2"></div>
        </div>
    `;
    
    fetch(`/secretaria/documentos/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const fechaCreacion = new Date(data.created_at).toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        // Determinar el icono según el tipo de archivo
        let iconoArchivo = 'fa-file';
        if (data.archivo_nombre) {
            const ext = data.archivo_nombre.split('.').pop().toLowerCase();
            if (ext === 'pdf') iconoArchivo = 'fa-file-pdf text-red-500';
            else if (['doc', 'docx'].includes(ext)) iconoArchivo = 'fa-file-word text-blue-500';
            else if (['xls', 'xlsx'].includes(ext)) iconoArchivo = 'fa-file-excel text-green-500';
        }
        
        document.getElementById('contenidoDocumento').innerHTML = `
            <div class="space-y-6">
                <!-- Encabezado -->
                <div class="bg-gradient-to-r from-green-50 to-lime-50 p-6 rounded-xl border border-green-200">
                    <h4 class="text-2xl font-bold text-gray-800 mb-3">${data.titulo}</h4>
                    <div class="flex flex-wrap gap-3">
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full capitalize">
                            <i class="fas fa-tag"></i> ${data.tipo}
                        </span>
                        ${data.categoria ? 
                            `<span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">
                                <i class="fas fa-layer-group"></i> ${data.categoria}
                            </span>` : ''
                        }
                        <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm font-semibold rounded-full">
                            <i class="fas fa-calendar"></i> ${fechaCreacion}
                        </span>
                    </div>
                </div>

                <!-- Descripción -->
                ${data.descripcion ? `
                <div>
                    <h5 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-align-left text-green-500"></i>
                        Descripción
                    </h5>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700">${data.descripcion}</p>
                    </div>
                </div>
                ` : ''}

                <!-- Archivo -->
                ${data.archivo_path ? `
                <div>
                    <h5 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas ${iconoArchivo}"></i>
                        Archivo
                    </h5>
                    <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-lg">
                        <i class="fas ${iconoArchivo} text-4xl"></i>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">${data.archivo_nombre || 'Documento'}</p>
                            <p class="text-sm text-gray-500">Formato: ${data.archivo_nombre ? data.archivo_nombre.split('.').pop().toUpperCase() : 'Desconocido'}</p>
                        </div>
                        <a href="/storage/${data.archivo_path}" target="_blank" download
                           class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                            <i class="fas fa-download mr-2"></i>Descargar
                        </a>
                    </div>
                </div>
                ` : '<p class="text-gray-500 italic">No hay archivo adjunto</p>'}

                <!-- Metadata -->
                <div class="pt-4 border-t border-gray-200 text-sm text-gray-500 space-y-1">
                    <p><i class="fas fa-user"></i> Creado por: <strong>${data.creador?.name || 'Sistema'}</strong></p>
                    <p><i class="fas fa-clock"></i> Fecha de creación: ${new Date(data.created_at).toLocaleString('es-ES')}</p>
                    <p><i class="fas fa-edit"></i> Última actualización: ${new Date(data.updated_at).toLocaleString('es-ES')}</p>
                </div>
            </div>
        `;
    })
    .catch(error => {
        document.getElementById('contenidoDocumento').innerHTML = `
            <div class="text-center text-red-600 py-8">
                <i class="fas fa-exclamation-circle text-4xl mb-3"></i>
                <p class="text-lg font-semibold">Error al cargar el documento</p>
            </div>
        `;
        console.error(error);
    });
}

/**
 * Editar un documento existente
 */
function editarDocumento(id) {
    // Cargar datos del documento
    fetch(`/secretaria/documentos/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('documentoId').value = data.id;
        document.getElementById('titulo_doc').value = data.titulo;
        document.getElementById('tipo_doc').value = data.tipo;
        document.getElementById('categoria_doc').value = data.categoria || '';
        document.getElementById('descripcion_doc').value = data.descripcion || '';
        
        document.getElementById('textoTituloDocumento').textContent = 'Editar Documento';
        document.getElementById('textoBotonGuardarDoc').textContent = 'Actualizar Documento';
        document.getElementById('archivo_doc').required = false;
        
        // Mostrar archivo actual si existe
        if (data.archivo_path) {
            document.getElementById('archivoActualDoc').classList.remove('hidden');
            document.getElementById('linkArchivoActualDoc').href = `/storage/${data.archivo_path}`;
            document.getElementById('linkArchivoActualDoc').textContent = data.archivo_nombre || 'Ver archivo';
        } else {
            document.getElementById('archivoActualDoc').classList.add('hidden');
        }
        
        document.getElementById('modalDocumento').classList.remove('hidden');
    })
    .catch(error => {
        alert('Error al cargar los datos del documento');
        console.error(error);
    });
}

/**
 * Guardar documento (crear o actualizar)
 */
document.getElementById('formDocumento').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const documentoId = document.getElementById('documentoId').value;
    const formData = new FormData(this);
    const isEdit = documentoId !== '';
    
    const url = isEdit ? `/secretaria/documentos/${documentoId}` : '/secretaria/documentos';
    
    // Deshabilitar botón
    const btnGuardar = document.getElementById('btnGuardarDocumento');
    const textoOriginal = btnGuardar.innerHTML;
    btnGuardar.disabled = true;
    btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Guardando...';
    
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

/**
 * Eliminar documento
 */
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

/**
 * Cerrar modal de documento
 */
function cerrarModalDocumento() {
    document.getElementById('modalDocumento').classList.add('hidden');
    document.getElementById('formDocumento').reset();
}

/**
 * Cerrar modal genérico
 */
function cerrarModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

// Cerrar modales al hacer clic fuera
document.querySelectorAll('[id^="modal"]').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
});
</script>
@endpush
