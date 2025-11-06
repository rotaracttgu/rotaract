@extends('layouts.app')

@section('title', 'Gestión de Diplomas')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-amber-500 via-orange-500 to-yellow-500 h-2"></div>
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('secretaria.dashboard') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fas fa-arrow-left text-gray-600"></i>
                        </a>
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-amber-600 to-yellow-600 bg-clip-text text-transparent flex items-center gap-3">
                                <i class="fas fa-award"></i>
                                Gestión de Diplomas
                            </h1>
                            <p class="text-gray-600 mt-1">Administra todos los diplomas emitidos</p>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        <button onclick="window.location.reload()" class="px-4 py-2 bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                            <i class="fas fa-sync-alt"></i>
                            <span>Actualizar</span>
                        </button>
                        <button onclick="nuevoDiploma()" class="px-4 py-2 bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 text-white rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                            <i class="fas fa-plus"></i>
                            <span>Nuevo Diploma</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-yellow-500 rounded-lg flex items-center justify-center mb-3">
                    <i class="fas fa-award text-white text-xl"></i>
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
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center mb-3">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <div class="text-3xl font-bold text-gray-800">{{ $estadisticas['participacion'] ?? 0 }}</div>
                <div class="text-gray-600 font-semibold text-sm">Participación</div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="w-12 h-12 bg-gradient-to-br from-rose-500 to-red-500 rounded-lg flex items-center justify-center mb-3">
                    <i class="fas fa-medal text-white text-xl"></i>
                </div>
                <div class="text-3xl font-bold text-gray-800">{{ $estadisticas['reconocimiento'] ?? 0 }}</div>
                <div class="text-gray-600 font-semibold text-sm">Reconocim.</div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-lg flex items-center justify-center mb-3">
                    <i class="fas fa-envelope text-white text-xl"></i>
                </div>
                <div class="text-3xl font-bold text-gray-800">{{ $estadisticas['enviados'] ?? 0 }}</div>
                <div class="text-gray-600 font-semibold">Enviados</div>
            </div>
        </div>

        <!-- Tabla de Diplomas -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-amber-500 to-yellow-500 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">ID</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Miembro</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Tipo</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Motivo</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Fecha Emisión</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Email</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($diplomas as $diploma)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-gray-600">#{{ $diploma->id }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-yellow-400 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr($diploma->miembro->name ?? 'M', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800">{{ $diploma->miembro->name ?? 'Miembro' }}</div>
                                        <div class="text-sm text-gray-500">{{ $diploma->miembro->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full capitalize">
                                    {{ $diploma->tipo }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($diploma->motivo, 50) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <i class="fas fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($diploma->fecha_emision)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($diploma->enviado_email)
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                    <i class="fas fa-check"></i> Enviado
                                </span>
                                @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full">
                                    <i class="fas fa-times"></i> No enviado
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="verDiploma({{ $diploma->id }})" class="w-8 h-8 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors" title="Ver detalles">
                                        <i class="fas fa-eye text-sm"></i>
                                    </button>
                                    @if(!$diploma->enviado_email)
                                    <button onclick="enviarEmailDiploma({{ $diploma->id }})" class="w-8 h-8 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg transition-colors" title="Enviar por email">
                                        <i class="fas fa-envelope text-sm"></i>
                                    </button>
                                    @endif
                                    <button onclick="eliminarDiploma({{ $diploma->id }})" class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors" title="Eliminar">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i class="fas fa-award text-6xl mb-4 opacity-30"></i>
                                    <p class="text-lg font-semibold">No hay diplomas emitidos</p>
                                    <p class="text-sm">Los diplomas aparecerán aquí cuando sean creados</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($diplomas->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $diplomas->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
    </div>
</div>

<!-- Modal Crear/Editar Diploma -->
<div id="modalDiploma" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-xl max-w-3xl w-full my-8">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 id="titulModalDiploma" class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-award text-amber-600"></i>
                    <span id="textoTituloDiploma">Nuevo Diploma</span>
                </h3>
                <button onclick="cerrarModalDiploma()" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    <i class="fas fa-times text-gray-600"></i>
                </button>
            </div>
        </div>
        
        <form id="formDiploma" enctype="multipart/form-data" class="p-6">
            <input type="hidden" id="diplomaId" name="diploma_id">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Miembro -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user text-amber-500"></i> Miembro *
                    </label>
                    <select name="miembro_id" id="miembro_id" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        <option value="">Seleccionar miembro...</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->name }} ({{ $usuario->email }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tipo de Diploma -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-tag text-amber-500"></i> Tipo de Diploma *
                    </label>
                    <select name="tipo" id="tipo" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        <option value="">Seleccionar...</option>
                        <option value="participacion">Participación</option>
                        <option value="reconocimiento">Reconocimiento</option>
                        <option value="merito">Mérito</option>
                        <option value="asistencia">Asistencia</option>
                    </select>
                </div>

                <!-- Fecha de Emisión -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar text-amber-500"></i> Fecha de Emisión *
                    </label>
                    <input type="date" name="fecha_emision" id="fecha_emision" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                </div>

                <!-- Motivo -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-comment text-amber-500"></i> Motivo del Diploma *
                    </label>
                    <textarea name="motivo" id="motivo" rows="4" required maxlength="500"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                        placeholder="Describe el motivo o logro por el cual se otorga este diploma..."></textarea>
                    <p class="text-xs text-gray-500 mt-1">Máximo 500 caracteres</p>
                </div>

                <!-- Archivo PDF (opcional) -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-file-pdf text-red-500"></i> Archivo PDF (opcional)
                    </label>
                    <input type="file" name="archivo_pdf" id="archivo_pdf_diploma" accept=".pdf"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Si no subes un archivo, se generará automáticamente. Formato: PDF, máx. 5MB</p>
                </div>
            </div>

            <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200">
                <button type="submit" id="btnGuardarDiploma" 
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i><span id="textoBotonGuardarDiploma">Crear Diploma</span>
                </button>
                <button type="button" onclick="cerrarModalDiploma()" 
                    class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Ver Diploma -->
<div id="modalVerDiploma" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-award text-amber-600"></i>
                    Detalles del Diploma
                </h3>
                <button onclick="cerrarModal('modalVerDiploma')" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    <i class="fas fa-times text-gray-600"></i>
                </button>
            </div>
        </div>
        <div id="contenidoDiploma" class="p-6">
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
// FUNCIONES PARA GESTIÓN DE DIPLOMAS
// ============================================================================

/**
 * Abrir modal para crear nuevo diploma
 */
function nuevoDiploma() {
    document.getElementById('diplomaId').value = '';
    document.getElementById('formDiploma').reset();
    document.getElementById('textoTituloDiploma').textContent = 'Nuevo Diploma';
    document.getElementById('textoBotonGuardarDiploma').textContent = 'Crear Diploma';
    // Establecer fecha actual por defecto
    document.getElementById('fecha_emision').valueAsDate = new Date();
    document.getElementById('modalDiploma').classList.remove('hidden');
}

/**
 * Ver detalles de un diploma
 */
function verDiploma(id) {
    document.getElementById('modalVerDiploma').classList.remove('hidden');
    document.getElementById('contenidoDiploma').innerHTML = `
        <div class="animate-pulse space-y-4">
            <div class="h-4 bg-gray-200 rounded w-3/4"></div>
            <div class="h-4 bg-gray-200 rounded w-1/2"></div>
        </div>
    `;
    
    fetch(`/secretaria/diplomas/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const fechaEmision = new Date(data.fecha_emision).toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        document.getElementById('contenidoDiploma').innerHTML = `
            <div class="space-y-6">
                <!-- Encabezado -->
                <div class="bg-gradient-to-r from-amber-50 to-yellow-50 p-6 rounded-xl border border-amber-200">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h4 class="text-xl font-bold text-gray-800 mb-2">
                                <i class="fas fa-user text-amber-600"></i>
                                ${data.miembro?.name || 'Miembro no encontrado'}
                            </h4>
                            <p class="text-gray-600">${data.miembro?.email || ''}</p>
                        </div>
                        <span class="px-4 py-2 bg-amber-100 text-amber-800 font-semibold rounded-full capitalize text-sm">
                            <i class="fas fa-tag"></i> ${data.tipo}
                        </span>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 font-semibold rounded-full">
                            <i class="fas fa-calendar"></i> ${fechaEmision}
                        </span>
                        ${data.enviado_email ? 
                            '<span class="px-3 py-1 bg-green-100 text-green-800 font-semibold rounded-full"><i class="fas fa-check-circle"></i> Enviado por email</span>' :
                            '<span class="px-3 py-1 bg-gray-100 text-gray-600 font-semibold rounded-full"><i class="fas fa-clock"></i> No enviado</span>'
                        }
                    </div>
                </div>

                <!-- Motivo -->
                <div>
                    <h5 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-comment-alt text-amber-500"></i>
                        Motivo del Diploma
                    </h5>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700">${data.motivo}</p>
                    </div>
                </div>

                <!-- Archivo PDF -->
                ${data.archivo_path ? `
                <div>
                    <h5 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-file-pdf text-red-500"></i>
                        Documento
                    </h5>
                    <a href="/storage/${data.archivo_path}" target="_blank" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                        <i class="fas fa-download"></i>
                        Descargar Diploma (PDF)
                    </a>
                </div>
                ` : '<p class="text-gray-500 italic">No hay archivo adjunto</p>'}

                <!-- Metadata -->
                <div class="pt-4 border-t border-gray-200 text-sm text-gray-500 space-y-1">
                    <p><i class="fas fa-user-tie"></i> Emitido por: <strong>${data.emisor?.name || 'Sistema'}</strong></p>
                    <p><i class="fas fa-clock"></i> Fecha de creación: ${new Date(data.created_at).toLocaleString('es-ES')}</p>
                    ${data.enviado_email && data.fecha_envio_email ? 
                        `<p><i class="fas fa-envelope"></i> Enviado por email: ${new Date(data.fecha_envio_email).toLocaleString('es-ES')}</p>` : 
                        ''
                    }
                </div>

                <!-- Acciones -->
                <div class="flex gap-3 pt-4 border-t border-gray-200">
                    ${!data.enviado_email ? `
                    <button onclick="enviarEmailDiploma(${data.id}); cerrarModal('modalVerDiploma');" 
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transition-all">
                        <i class="fas fa-envelope mr-2"></i>Enviar por Email
                    </button>
                    ` : ''}
                </div>
            </div>
        `;
    })
    .catch(error => {
        document.getElementById('contenidoDiploma').innerHTML = `
            <div class="text-center text-red-600 py-8">
                <i class="fas fa-exclamation-circle text-4xl mb-3"></i>
                <p class="text-lg font-semibold">Error al cargar el diploma</p>
            </div>
        `;
        console.error(error);
    });
}

/**
 * Guardar diploma (crear o actualizar)
 */
document.getElementById('formDiploma').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const diplomaId = document.getElementById('diplomaId').value;
    const formData = new FormData(this);
    const isEdit = diplomaId !== '';
    
    const url = isEdit ? `/secretaria/diplomas/${diplomaId}` : '/secretaria/diplomas';
    
    // Deshabilitar botón
    const btnGuardar = document.getElementById('btnGuardarDiploma');
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
            alert(isEdit ? 'Diploma actualizado exitosamente' : 'Diploma creado exitosamente');
            cerrarModalDiploma();
            window.location.reload();
        } else {
            alert(data.message || 'Error al guardar el diploma');
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
 * Eliminar diploma
 */
function eliminarDiploma(id) {
    if (!confirm('¿Estás seguro de eliminar este diploma? Esta acción no se puede deshacer.')) return;
    
    fetch(`/secretaria/diplomas/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Diploma eliminado exitosamente');
            window.location.reload();
        } else {
            alert(data.message || 'Error al eliminar el diploma');
        }
    })
    .catch(error => {
        alert('Error de conexión');
        console.error(error);
    });
}

/**
 * Enviar diploma por email
 */
function enviarEmailDiploma(id) {
    if (!confirm('¿Enviar este diploma por email al miembro?')) return;
    
    const btn = event.target;
    const textoOriginal = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Enviando...';
    
    fetch(`/secretaria/diplomas/${id}/enviar-email`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Diploma enviado por email exitosamente');
            window.location.reload();
        } else {
            alert(data.message || 'Error al enviar el email');
            btn.disabled = false;
            btn.innerHTML = textoOriginal;
        }
    })
    .catch(error => {
        alert('Error de conexión');
        console.error(error);
        btn.disabled = false;
        btn.innerHTML = textoOriginal;
    });
}

/**
 * Cerrar modal de diploma
 */
function cerrarModalDiploma() {
    document.getElementById('modalDiploma').classList.add('hidden');
    document.getElementById('formDiploma').reset();
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
