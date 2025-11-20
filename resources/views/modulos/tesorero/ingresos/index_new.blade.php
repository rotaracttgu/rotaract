@extends('modulos.tesorero.layout')

@section('title', 'Ingresos')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-br from-emerald-600 via-green-600 to-teal-600 rounded-xl shadow-lg p-6">
        <div class="flex justify-between items-center">
            <div class="text-white">
                <h1 class="text-3xl font-bold flex items-center gap-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    Gestión de Ingresos
                </h1>
                <p class="text-emerald-100 mt-1">Administra y controla todos los ingresos del club</p>
            </div>
            @can('finanzas.crear')
            <a href="{{ route('tesorero.ingresos.create') }}" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm border-2 border-white/40 text-white px-6 py-3 rounded-lg font-semibold transition-all hover:scale-105 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nuevo Ingreso
            </a>
            @endcan
        </div>
    </div>

    <!-- Mensajes -->
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg flex items-center gap-3">
        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="text-green-800 font-medium">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg flex items-center gap-3">
        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="text-red-800 font-medium">{{ session('error') }}</span>
    </div>
    @endif

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wide">Buscar</label>
                <input type="text" id="searchInput" placeholder="Buscar por concepto..." class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wide">Tipo</label>
                <select id="filterTipo" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                    <option value="">Todos los tipos</option>
                    <option value="Membresías">Membresías</option>
                    <option value="Donaciones">Donaciones</option>
                    <option value="Eventos">Eventos</option>
                    <option value="Servicios">Servicios</option>
                    <option value="Otros">Otros</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wide">Estado</label>
                <select id="filterEstado" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                    <option value="">Todos los estados</option>
                    <option value="confirmado">Confirmado</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="cancelado">Cancelado</option>
                </select>
            </div>
            <div class="flex items-end">
                <button id="btnFilter" class="w-full bg-gradient-to-r from-emerald-500 to-teal-500 text-white px-6 py-2.5 rounded-lg font-semibold hover:from-emerald-600 hover:to-teal-600 transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filtrar
                </button>
            </div>
        </div>
    </div>

    <!-- Tabla -->
    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full" id="ingresosTable">
                <thead class="bg-gradient-to-r from-emerald-500 to-teal-500 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Concepto</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Tipo</th>
                        <th class="px-4 py-3 text-right text-xs font-bold uppercase tracking-wider">Monto</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Fecha</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Origen</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Método</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider">Estado</th>
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($ingresos ?? [] as $ingreso)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $ingreso->id }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $ingreso->concepto ?? $ingreso->descripcion }}</td>
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">
                                {{ $ingreso->tipo ?? $ingreso->categoria }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm font-bold text-right text-emerald-600">L. {{ number_format($ingreso->monto, 2) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($ingreso->fecha_ingreso ?? $ingreso->fecha)->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $ingreso->origen ?? $ingreso->fuente ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $ingreso->metodo_recepcion ?? $ingreso->metodo_pago ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @php
                                $estado = $ingreso->estado ?? 'activo';
                                $badgeClasses = match($estado) {
                                    'confirmado', 'activo' => 'bg-green-100 text-green-700',
                                    'pendiente' => 'bg-yellow-100 text-yellow-700',
                                    default => 'bg-red-100 text-red-700'
                                };
                                $estadoTexto = match($estado) {
                                    'confirmado' => 'Confirmado',
                                    'activo' => 'Activo',
                                    'pendiente' => 'Pendiente',
                                    'cancelado' => 'Cancelado',
                                    default => ucfirst($estado)
                                };
                            @endphp
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $badgeClasses }}">{{ $estadoTexto }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('tesorero.ingresos.show', $ingreso->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg transition-all hover:scale-110" title="Ver detalles">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                @can('finanzas.editar')
                                <a href="{{ route('tesorero.ingresos.edit', $ingreso->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white p-2 rounded-lg transition-all hover:scale-110" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                @endcan
                                @can('finanzas.eliminar')
                                <form action="{{ route('tesorero.ingresos.destroy', $ingreso->id) }}" method="POST" id="deleteForm{{ $ingreso->id }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition-all hover:scale-110 btn-delete-ingreso" data-id="{{ $ingreso->id }}" data-concepto="{{ $ingreso->concepto }}" data-monto="{{ number_format($ingreso->monto, 2) }}" title="Eliminar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-gray-500 font-medium">No hay ingresos registrados</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if(isset($ingresos) && $ingresos->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $ingresos->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterTipo = document.getElementById('filterTipo');
    const filterEstado = document.getElementById('filterEstado');
    const btnFilter = document.getElementById('btnFilter');
    const table = document.getElementById('ingresosTable');
    
    if (!table) return;
    
    const rows = table.querySelectorAll('tbody tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const tipoValue = filterTipo.value.toLowerCase();
        const estadoValue = filterEstado.value.toLowerCase();

        rows.forEach(row => {
            if (row.cells.length === 1) return;

            const concepto = row.cells[1].textContent.toLowerCase().trim();
            const tipo = row.cells[2].textContent.toLowerCase().trim();
            const estado = row.cells[7].textContent.toLowerCase().trim();

            const matchSearch = searchTerm === '' || concepto.includes(searchTerm);
            const matchTipo = tipoValue === '' || tipo.includes(tipoValue);
            const matchEstado = estadoValue === '' || estado.includes(estadoValue);

            row.style.display = (matchSearch && matchTipo && matchEstado) ? '' : 'none';
        });
    }

    btnFilter.addEventListener('click', filterTable);
    searchInput.addEventListener('input', filterTable);
    searchInput.addEventListener('keyup', (e) => e.key === 'Enter' && filterTable());
    filterTipo.addEventListener('change', filterTable);
    filterEstado.addEventListener('change', filterTable);

    document.querySelectorAll('.btn-delete-ingreso').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const ingresoId = this.getAttribute('data-id');
            const concepto = this.getAttribute('data-concepto');
            const monto = this.getAttribute('data-monto');

            Swal.fire({
                title: '¿Eliminar este ingreso?',
                html: `
                    <div class="text-left">
                        <p><strong>Concepto:</strong> ${concepto}</p>
                        <p><strong>Monto:</strong> L. ${monto}</p>
                        <p class="text-red-600 mt-3">Esta acción no se puede deshacer.</p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm' + ingresoId).submit();
                }
            });
        });
    });
});
</script>
@endpush

@endsection
