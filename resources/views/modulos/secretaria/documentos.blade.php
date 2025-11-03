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
                        <button onclick="alert('Función en desarrollo')" class="px-4 py-2 bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 text-white rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
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
                                    <button onclick="alert('Ver documento #{{ $documento->id }}')" class="w-8 h-8 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors">
                                        <i class="fas fa-eye text-sm"></i>
                                    </button>
                                    <button onclick="alert('Editar documento #{{ $documento->id }}')" class="w-8 h-8 bg-amber-100 hover:bg-amber-200 text-amber-600 rounded-lg transition-colors">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <button onclick="if(confirm('¿Eliminar este documento?')) alert('Eliminar #{{ $documento->id }}')" class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
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
@endsection
@push('scripts')
<script>
function verDocumento(id) {
    fetch(`/secretaria/documentos/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.archivo) {
            window.open(`/storage/${data.archivo}`, '_blank');
        } else {
            alert('El documento no tiene archivo disponible');
        }
    })
    .catch(error => {
        alert('Error al cargar el documento');
        console.error(error);
    });
}

function editarDocumento(id) {
    alert('Editar documento #' + id + ' - Por implementar modal de edici�n');
}

function eliminarDocumento(id) {
    if (!confirm('�Est�s seguro de eliminar este documento?')) return;
    
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
        alert('Error de conexi�n');
        console.error(error);
    });
}
</script>
@endpush
