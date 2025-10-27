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
                        <button onclick="alert('Función en desarrollo')" class="px-4 py-2 bg-gradient-to-r from-sky-500 to-cyan-500 hover:from-sky-600 hover:to-cyan-600 text-white rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
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
                                    <button onclick="alert('Ver acta #{{ $acta->id }}')" class="w-8 h-8 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors">
                                        <i class="fas fa-eye text-sm"></i>
                                    </button>
                                    <button onclick="alert('Editar acta #{{ $acta->id }}')" class="w-8 h-8 bg-amber-100 hover:bg-amber-200 text-amber-600 rounded-lg transition-colors">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <button onclick="if(confirm('¿Eliminar esta acta?')) alert('Eliminar #{{ $acta->id }}')" class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
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
@endsection
@push('scripts')
<script>
function verActa(id) {
    fetch(`/secretaria/actas/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.archivo_pdf) {
            window.open(`/storage/${data.archivo_pdf}`, '_blank');
        } else {
            alert('El acta no tiene archivo PDF disponible');
        }
    })
    .catch(error => {
        alert('Error al cargar el acta');
        console.error(error);
    });
}

function editarActa(id) {
    alert('Editar acta #' + id + ' - Por implementar modal de edici�n');
}

function eliminarActa(id) {
    if (!confirm('�Est�s seguro de eliminar esta acta?')) return;
    
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
        alert('Error de conexi�n');
        console.error(error);
    });
}
</script>
@endpush
