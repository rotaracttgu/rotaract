@extends('layouts.app')

@section('title', 'Gesti贸n de Diplomas')

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
                                Gesti贸n de Diplomas
                            </h1>
                            <p class="text-gray-600 mt-1">Administra todos los diplomas emitidos</p>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        <button onclick="window.location.reload()" class="px-4 py-2 bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                            <i class="fas fa-sync-alt"></i>
                            <span>Actualizar</span>
                        </button>
                        <button onclick="alert('Funci贸n en desarrollo')" class="px-4 py-2 bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 text-white rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                            <i class="fas fa-plus"></i>
                            <span>Nuevo Diploma</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estad铆sticas -->
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
                <div class="text-gray-600 font-semibold">Este A帽o</div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center mb-3">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <div class="text-3xl font-bold text-gray-800">{{ $estadisticas['participacion'] ?? 0 }}</div>
                <div class="text-gray-600 font-semibold text-sm">Participaci贸n</div>
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
                            <th class="px-6 py-4 text-left text-sm font-semibold">Fecha Emisi贸n</th>
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
                                    <button onclick="alert('Ver diploma #{{ $diploma->id }}')" class="w-8 h-8 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors">
                                        <i class="fas fa-eye text-sm"></i>
                                    </button>
                                    @if(!$diploma->enviado_email)
                                    <button onclick="alert('Enviar por email #{{ $diploma->id }}')" class="w-8 h-8 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg transition-colors">
                                        <i class="fas fa-envelope text-sm"></i>
                                    </button>
                                    @endif
                                    <button onclick="if(confirm('驴Eliminar este diploma?')) alert('Eliminar #{{ $diploma->id }}')" class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
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
                                    <p class="text-sm">Los diplomas aparecer谩n aqu铆 cuando sean creados</p>
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
@endsection
@push('scripts')
<script>
function verDiploma(id) {
    fetch(`/secretaria/diplomas/${id}`, {
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
            alert('El diploma no tiene archivo PDF disponible');
        }
    })
    .catch(error => {
        alert('Error al cargar el diploma');
        console.error(error);
    });
}

function editarDiploma(id) {
    alert('Editar diploma #' + id + ' - Por implementar modal de edici髇');
}

function eliminarDiploma(id) {
    if (!confirm('縀st醩 seguro de eliminar este diploma?')) return;
    
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
        alert('Error de conexi髇');
        console.error(error);
    });
}

function enviarEmailDiploma(id) {
    if (!confirm('縀nviar diploma por email?')) return;
    
    fetch(`/secretaria/diplomas/${id}/enviar`, {
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
        }
    })
    .catch(error => {
        alert('Error de conexi髇');
        console.error(error);
    });
}
</script>
@endpush
