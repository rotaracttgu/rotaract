@extends('layouts.app')

@section('title', 'Gestión de Consultas')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-purple-600 via-pink-500 to-indigo-500 h-2"></div>
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <!-- Título -->
                    <div class="flex items-center gap-4">
                        <a href="{{ route('secretaria.dashboard') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fas fa-arrow-left text-gray-600"></i>
                        </a>
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent flex items-center gap-3">
                                <i class="fas fa-comments"></i>
                                Gestión de Consultas
                            </h1>
                            <p class="text-gray-600 mt-1">Administra todas las consultas recibidas</p>
                        </div>
                    </div>
                    
                    <!-- Botones -->
                    <div class="flex flex-wrap gap-2">
                        <button onclick="window.location.reload()" class="px-4 py-2 bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                            <i class="fas fa-sync-alt"></i>
                            <span>Actualizar</span>
                        </button>
                        <button onclick="alert('Función de exportar en desarrollo')" class="px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                            <i class="fas fa-file-excel"></i>
                            <span>Exportar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-indigo-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-inbox text-white text-xl"></i>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-800">{{ $estadisticas['total'] ?? 0 }}</div>
                <div class="text-gray-600 font-semibold">Total Consultas</div>
            </div>

            <!-- Pendientes -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-800">{{ $estadisticas['pendientes'] ?? 0 }}</div>
                <div class="text-gray-600 font-semibold">Pendientes</div>
            </div>

            <!-- Respondidas -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-800">{{ $estadisticas['respondidas'] ?? 0 }}</div>
                <div class="text-gray-600 font-semibold">Respondidas</div>
            </div>

            <!-- Hoy -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-day text-white text-xl"></i>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-800">{{ $estadisticas['hoy'] ?? 0 }}</div>
                <div class="text-gray-600 font-semibold">Hoy</div>
            </div>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Estado -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-filter"></i> Estado
                    </label>
                    <select name="estado" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">Todos</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="respondida" {{ request('estado') == 'respondida' ? 'selected' : '' }}>Respondida</option>
                        <option value="cerrada" {{ request('estado') == 'cerrada' ? 'selected' : '' }}>Cerrada</option>
                    </select>
                </div>

                <!-- Fecha -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar"></i> Fecha
                    </label>
                    <select name="fecha" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">Todas</option>
                        <option value="hoy" {{ request('fecha') == 'hoy' ? 'selected' : '' }}>Hoy</option>
                        <option value="semana" {{ request('fecha') == 'semana' ? 'selected' : '' }}>Esta Semana</option>
                        <option value="mes" {{ request('fecha') == 'mes' ? 'selected' : '' }}>Este Mes</option>
                    </select>
                </div>

                <!-- Buscar -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-search"></i> Buscar
                    </label>
                    <div class="flex gap-2">
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre, email, asunto..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request()->hasAny(['estado', 'fecha', 'buscar']))
                        <a href="{{ route('secretaria.consultas') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla de Consultas -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">ID</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Usuario</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Asunto</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Mensaje</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Estado</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Fecha</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($consultas as $consulta)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-gray-600">#{{ $consulta->id }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-indigo-400 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr($consulta->usuario->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800">{{ $consulta->usuario->name ?? 'Usuario' }}</div>
                                        <div class="text-sm text-gray-500">{{ $consulta->usuario->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">{{ Str::limit($consulta->asunto ?? 'Sin asunto', 40) }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($consulta->mensaje, 60) }}</td>
                            <td class="px-6 py-4">
                                @if($consulta->estado == 'pendiente')
                                <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full">
                                    <i class="fas fa-clock"></i> Pendiente
                                </span>
                                @elseif($consulta->estado == 'respondida')
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                    <i class="fas fa-check"></i> Respondida
                                </span>
                                @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">
                                    <i class="fas fa-times-circle"></i> Cerrada
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <i class="fas fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($consulta->created_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="verConsulta({{ $consulta->id }})" class="w-8 h-8 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors" title="Ver">
                                        <i class="fas fa-eye text-sm"></i>
                                    </button>
                                    @if($consulta->estado == 'pendiente')
                                    <button onclick="responderConsulta({{ $consulta->id }})" class="w-8 h-8 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg transition-colors" title="Responder">
                                        <i class="fas fa-reply text-sm"></i>
                                    </button>
                                    @endif
                                    <button onclick="eliminarConsulta({{ $consulta->id }})" class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors" title="Eliminar">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i class="fas fa-inbox text-6xl mb-4 opacity-30"></i>
                                    <p class="text-lg font-semibold">No hay consultas registradas</p>
                                    <p class="text-sm">Las consultas aparecerán aquí cuando sean creadas</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($consultas->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $consultas->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Ver Consulta -->
<div id="modalVerConsulta" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-bold text-gray-800">Detalles de Consulta</h3>
                <button onclick="cerrarModal('modalVerConsulta')" class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-lg">
                    <i class="fas fa-times text-gray-600"></i>
                </button>
            </div>
        </div>
        <div id="contenidoConsulta" class="p-6">
            <div class="animate-pulse">
                <div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div>
                <div class="h-4 bg-gray-200 rounded w-1/2"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Responder Consulta -->
<div id="modalResponderConsulta" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-bold text-gray-800">Responder Consulta</h3>
                <button onclick="cerrarModal('modalResponderConsulta')" class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-lg">
                    <i class="fas fa-times text-gray-600"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <form id="formResponderConsulta" onsubmit="enviarRespuesta(event)">
                <input type="hidden" id="consultaIdResponder" name="consulta_id">
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Respuesta</label>
                    <textarea name="respuesta" rows="6" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg font-semibold">
                        <i class="fas fa-paper-plane mr-2"></i>Enviar Respuesta
                    </button>
                    <button type="button" onclick="cerrarModal('modalResponderConsulta')" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function verConsulta(id) {
    document.getElementById('modalVerConsulta').classList.remove('hidden');
    document.getElementById('contenidoConsulta').innerHTML = '<div class="animate-pulse"><div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div><div class="h-4 bg-gray-200 rounded w-1/2"></div></div>';
    
    fetch(`/secretaria/consultas/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('contenidoConsulta').innerHTML = `
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-semibold text-gray-500">Usuario:</label>
                    <p class="text-lg font-semibold text-gray-800">${data.usuario?.name || 'N/A'}</p>
                    <p class="text-sm text-gray-600">${data.usuario?.email || ''}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Asunto:</label>
                    <p class="text-lg text-gray-800">${data.asunto || 'Sin asunto'}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Mensaje:</label>
                    <p class="text-gray-700 whitespace-pre-wrap">${data.mensaje}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Estado:</label>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold ${
                        data.estado === 'pendiente' ? 'bg-amber-100 text-amber-800' : 
                        data.estado === 'respondida' ? 'bg-green-100 text-green-800' : 
                        'bg-gray-100 text-gray-800'
                    }">${data.estado}</span>
                </div>
                ${data.respuesta ? `
                <div class="mt-4 p-4 bg-green-50 rounded-lg">
                    <label class="text-sm font-semibold text-green-700">Respuesta:</label>
                    <p class="text-gray-700 mt-2">${data.respuesta}</p>
                    <p class="text-xs text-gray-500 mt-2">Respondida el: ${new Date(data.respondido_at).toLocaleString('es-ES')}</p>
                </div>
                ` : ''}
                <div class="text-sm text-gray-500">
                    <i class="fas fa-calendar"></i> Creada: ${new Date(data.created_at).toLocaleString('es-ES')}
                </div>
            </div>
        `;
    })
    .catch(error => {
        document.getElementById('contenidoConsulta').innerHTML = '<div class="text-red-600"><i class="fas fa-exclamation-circle mr-2"></i>Error al cargar la consulta</div>';
    });
}

function responderConsulta(id) {
    document.getElementById('consultaIdResponder').value = id;
    document.getElementById('modalResponderConsulta').classList.remove('hidden');
}

function enviarRespuesta(event) {
    event.preventDefault();
    const form = event.target;
    const id = document.getElementById('consultaIdResponder').value;
    const formData = new FormData(form);
    
    fetch(`/secretaria/consultas/${id}/responder`, {
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
            alert('Respuesta enviada exitosamente');
            cerrarModal('modalResponderConsulta');
            window.location.reload();
        } else {
            alert('Error al enviar respuesta');
        }
    })
    .catch(error => {
        alert('Error de conexión');
    });
}

function eliminarConsulta(id) {
    if (!confirm('¿Estás seguro de eliminar esta consulta?')) return;
    
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
        alert('Error de conexión');
    });
}

function cerrarModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

// Cerrar modal al hacer clic fuera
document.querySelectorAll('[id^="modal"]').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
});
</script>
@endpush
