@extends('layouts.app')

@section('title', 'Gestión de Actas')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-sky-500 via-blue-500 to-cyan-500 h-2"></div>
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('secretaria.dashboard') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fas fa-arrow-left text-gray-600"></i>
                        </a>
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-sky-600 to-cyan-600 bg-clip-text text-transparent flex items-center gap-3">
                                <i class="fas fa-file-signature"></i>
                                Gestión de Actas
                            </h1>
                            <p class="text-gray-600 mt-1">Administra todas las actas del club</p>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        <button onclick="window.location.reload()" class="px-4 py-2 bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                            <i class="fas fa-sync-alt"></i>
                            <span>Actualizar</span>
                        </button>
                        <button onclick="nuevaActa()" class="px-4 py-2 bg-gradient-to-r from-sky-500 to-cyan-500 hover:from-sky-600 hover:to-cyan-600 text-white rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                            <i class="fas fa-plus"></i>
                            <span>Nueva Acta</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="w-12 h-12 bg-gradient-to-br from-sky-500 to-cyan-500 rounded-lg flex items-center justify-center mb-3">
                    <i class="fas fa-file-signature text-white text-xl"></i>
                </div>
                <div class="text-3xl font-bold text-gray-800">{{ $estadisticas['total'] ?? 0 }}</div>
                <div class="text-gray-600 font-semibold">Total Actas</div>
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
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center mb-3">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
                <div class="text-3xl font-bold text-gray-800">{{ $estadisticas['ordinarias'] ?? 0 }}</div>
                <div class="text-gray-600 font-semibold">Ordinarias</div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-500 rounded-lg flex items-center justify-center mb-3">
                    <i class="fas fa-star text-white text-xl"></i>
                </div>
                <div class="text-3xl font-bold text-gray-800">{{ $estadisticas['extraordinarias'] ?? 0 }}</div>
                <div class="text-gray-600 font-semibold">Extraordinarias</div>
            </div>
        </div>

        <!-- Tabla de Actas -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-sky-500 to-cyan-500 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">ID</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Título</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Tipo</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Fecha Reunión</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Archivo</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($actas as $acta)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-gray-600">#{{ $acta->id }}</td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">{{ $acta->titulo }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($acta->contenido ?? '', 60) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-sky-100 text-sky-800 text-xs font-semibold rounded-full capitalize">
                                    {{ $acta->tipo_reunion }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <i class="fas fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($acta->fecha_reunion)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($acta->archivo_path)
                                <a href="{{ Storage::url($acta->archivo_path) }}" target="_blank" class="inline-flex items-center gap-1 text-red-600 hover:text-red-700">
                                    <i class="fas fa-file-pdf"></i>
                                    <span class="text-sm font-semibold">Ver PDF</span>
                                </a>
                                @else
                                <span class="text-gray-400 text-sm">Sin archivo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="verActa({{ $acta->id }})" class="w-8 h-8 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors" title="Ver detalles">
                                        <i class="fas fa-eye text-sm"></i>
                                    </button>
                                    <button onclick="editarActa({{ $acta->id }})" class="w-8 h-8 bg-amber-100 hover:bg-amber-200 text-amber-600 rounded-lg transition-colors" title="Editar">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <button onclick="eliminarActa({{ $acta->id }})" class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors" title="Eliminar">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i class="fas fa-file-signature text-6xl mb-4 opacity-30"></i>
                                    <p class="text-lg font-semibold">No hay actas registradas</p>
                                    <p class="text-sm">Las actas aparecerán aquí cuando sean creadas</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($actas->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $actas->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
    </div>
</div>

<!-- Modal Crear/Editar Acta -->
<div id="modalActa" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-xl max-w-4xl w-full my-8">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 id="tituloModalActa" class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-file-signature text-sky-600"></i>
                    <span id="textoTituloActa">Nueva Acta</span>
                </h3>
                <button onclick="cerrarModalActa()" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    <i class="fas fa-times text-gray-600"></i>
                </button>
            </div>
        </div>
        
        <form id="formActa" enctype="multipart/form-data" class="p-6">
            <input type="hidden" id="actaId" name="acta_id">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Título -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-heading text-sky-500"></i> Título del Acta *
                    </label>
                    <input type="text" name="titulo" id="titulo" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent"
                        placeholder="Ej: Acta de Reunión Ordinaria #05">
                </div>

                <!-- Fecha Reunión -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar text-sky-500"></i> Fecha de Reunión *
                    </label>
                    <input type="date" name="fecha_reunion" id="fecha_reunion" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                </div>

                <!-- Tipo de Reunión -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-tag text-sky-500"></i> Tipo de Reunión *
                    </label>
                    <select name="tipo_reunion" id="tipo_reunion" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                        <option value="">Seleccionar...</option>
                        <option value="ordinaria">Ordinaria</option>
                        <option value="extraordinaria">Extraordinaria</option>
                        <option value="junta">Junta Directiva</option>
                        <option value="asamblea">Asamblea General</option>
                    </select>
                </div>

                <!-- Contenido/Descripción -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-file-alt text-sky-500"></i> Contenido del Acta *
                    </label>
                    <textarea name="contenido" id="contenido" rows="6" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent"
                        placeholder="Describe el desarrollo de la reunión, temas tratados, decisiones tomadas..."></textarea>
                </div>

                <!-- Asistentes -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-users text-sky-500"></i> Asistentes
                    </label>
                    <textarea name="asistentes" id="asistentes" rows="3" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent"
                        placeholder="Nombres de los asistentes, separados por comas..."></textarea>
                </div>

                <!-- Archivo PDF -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-file-pdf text-red-500"></i> Archivo PDF
                    </label>
                    <input type="file" name="archivo_pdf" id="archivo_pdf" accept=".pdf"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Formato: PDF. Tamaño máximo: 5MB</p>
                    <div id="archivoActual" class="hidden mt-2 p-3 bg-blue-50 rounded-lg">
                        <p class="text-sm text-blue-700">
                            <i class="fas fa-file-pdf text-red-500"></i>
                            <span>Archivo actual: </span>
                            <a href="#" id="linkArchivoActual" target="_blank" class="font-semibold hover:underline">Ver archivo</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200">
                <button type="submit" id="btnGuardarActa" 
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-sky-500 to-cyan-500 hover:from-sky-600 hover:to-cyan-600 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i><span id="textoBotonGuardar">Crear Acta</span>
                </button>
                <button type="button" onclick="cerrarModalActa()" 
                    class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Ver Acta -->
<div id="modalVerActa" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-eye text-sky-600"></i>
                    Detalles del Acta
                </h3>
                <button onclick="cerrarModal('modalVerActa')" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    <i class="fas fa-times text-gray-600"></i>
                </button>
            </div>
        </div>
        <div id="contenidoActa" class="p-6">
            <div class="animate-pulse space-y-4">
                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                <div class="h-4 bg-gray-200 rounded w-5/6"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ============================================================================
// FUNCIONES PARA GESTIÓN DE ACTAS
// ============================================================================

/**
 * Abrir modal para crear nueva acta
 */
function nuevaActa() {
    document.getElementById('actaId').value = '';
    document.getElementById('formActa').reset();
    document.getElementById('textoTituloActa').textContent = 'Nueva Acta';
    document.getElementById('textoBotonGuardar').textContent = 'Crear Acta';
    document.getElementById('archivoActual').classList.add('hidden');
    document.getElementById('modalActa').classList.remove('hidden');
}

/**
 * Ver detalles de un acta
 */
function verActa(id) {
    document.getElementById('modalVerActa').classList.remove('hidden');
    document.getElementById('contenidoActa').innerHTML = `
        <div class="animate-pulse space-y-4">
            <div class="h-4 bg-gray-200 rounded w-3/4"></div>
            <div class="h-4 bg-gray-200 rounded w-1/2"></div>
            <div class="h-4 bg-gray-200 rounded w-5/6"></div>
        </div>
    `;
    
    fetch(`/secretaria/actas/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const fechaReunion = new Date(data.fecha_reunion).toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        document.getElementById('contenidoActa').innerHTML = `
            <div class="space-y-6">
                <!-- Encabezado -->
                <div class="bg-gradient-to-r from-sky-50 to-cyan-50 p-6 rounded-xl border border-sky-200">
                    <h4 class="text-2xl font-bold text-gray-800 mb-2">${data.titulo}</h4>
                    <div class="flex flex-wrap gap-3">
                        <span class="px-3 py-1 bg-sky-100 text-sky-800 text-sm font-semibold rounded-full capitalize">
                            <i class="fas fa-tag"></i> ${data.tipo_reunion}
                        </span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">
                            <i class="fas fa-calendar"></i> ${fechaReunion}
                        </span>
                    </div>
                </div>

                <!-- Contenido -->
                <div>
                    <h5 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-file-alt text-sky-500"></i>
                        Contenido del Acta
                    </h5>
                    <div class="prose max-w-none bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700 whitespace-pre-wrap">${data.contenido || 'Sin contenido'}</p>
                    </div>
                </div>

                <!-- Asistentes -->
                ${data.asistentes ? `
                <div>
                    <h5 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-users text-sky-500"></i>
                        Asistentes
                    </h5>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700">${data.asistentes}</p>
                    </div>
                </div>
                ` : ''}

                <!-- Archivo PDF -->
                ${data.archivo_path ? `
                <div>
                    <h5 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-file-pdf text-red-500"></i>
                        Documento
                    </h5>
                    <a href="/storage/${data.archivo_path}" target="_blank" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 mr-2">
                        <i class="fas fa-eye"></i>
                        Ver PDF
                    </a>
                    <a href="{{ route('secretaria.actas.descargar', '') }}/${data.id}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                        <i class="fas fa-download"></i>
                        Descargar PDF
                    </a>
                </div>
                ` : `
                <div>
                    <h5 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-file-pdf text-red-500"></i>
                        Documento
                    </h5>
                    <a href="{{ route('secretaria.actas.descargar', '') }}/${data.id}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                        <i class="fas fa-download"></i>
                        Generar y Descargar PDF
                    </a>
                </div>
                `}

                <!-- Metadata -->
                <div class="pt-4 border-t border-gray-200 text-sm text-gray-500">
                    <p><i class="fas fa-user"></i> Creado por: <strong>${data.creador?.name || 'Sistema'}</strong></p>
                    <p><i class="fas fa-clock"></i> Fecha de creación: ${new Date(data.created_at).toLocaleString('es-ES')}</p>
                </div>
            </div>
        `;
    })
    .catch(error => {
        document.getElementById('contenidoActa').innerHTML = `
            <div class="text-center text-red-600 py-8">
                <i class="fas fa-exclamation-circle text-4xl mb-3"></i>
                <p class="text-lg font-semibold">Error al cargar el acta</p>
                <p class="text-sm">Por favor, intenta de nuevo</p>
            </div>
        `;
        console.error(error);
    });
}

/**
 * Editar un acta existente
 */
function editarActa(id) {
    // Cargar datos del acta
    fetch(`/secretaria/actas/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('actaId').value = data.id;
        document.getElementById('titulo').value = data.titulo;
        document.getElementById('fecha_reunion').value = data.fecha_reunion;
        document.getElementById('tipo_reunion').value = data.tipo_reunion;
        document.getElementById('contenido').value = data.contenido || '';
        document.getElementById('asistentes').value = data.asistentes || '';
        
        document.getElementById('textoTituloActa').textContent = 'Editar Acta';
        document.getElementById('textoBotonGuardar').textContent = 'Actualizar Acta';
        
        // Mostrar archivo actual si existe
        if (data.archivo_path) {
            document.getElementById('archivoActual').classList.remove('hidden');
            document.getElementById('linkArchivoActual').href = `/storage/${data.archivo_path}`;
        } else {
            document.getElementById('archivoActual').classList.add('hidden');
        }
        
        document.getElementById('modalActa').classList.remove('hidden');
    })
    .catch(error => {
        alert('Error al cargar los datos del acta');
        console.error(error);
    });
}

/**
 * Guardar acta (crear o actualizar)
 */
document.getElementById('formActa').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const actaId = document.getElementById('actaId').value;
    const formData = new FormData(this);
    const isEdit = actaId !== '';
    
    const url = isEdit ? `/secretaria/actas/${actaId}` : '/secretaria/actas';
    const method = 'POST';
    
    // Deshabilitar botón
    const btnGuardar = document.getElementById('btnGuardarActa');
    const textoOriginal = btnGuardar.innerHTML;
    btnGuardar.disabled = true;
    btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Guardando...';
    
    fetch(url, {
        method: method,
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

/**
 * Eliminar acta
 */
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

/**
 * Cerrar modal de acta
 */
function cerrarModalActa() {
    document.getElementById('modalActa').classList.add('hidden');
    document.getElementById('formActa').reset();
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
