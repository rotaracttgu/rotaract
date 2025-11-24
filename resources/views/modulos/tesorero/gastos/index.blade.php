@extends('modulos.tesorero.layout')

@section('title', 'Gastos')

@section('content')
<style>
    .gastos-header {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px rgba(239, 68, 68, 0.3);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .gastos-header-content h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        margin: 0;
    }

    .gastos-header-content p {
        opacity: 0.95;
        font-size: 0.85rem;
        margin: 0;
    }

    .btn-nuevo {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.4);
        color: white;
        padding: 0.55rem 1.1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        cursor: pointer;
    }

    .btn-nuevo:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }

    .filters-section {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid #E2E8F0;
    }

    .filters-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 0.75rem;
        align-items: flex-end;
    }

    .filter-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.4rem;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 2px solid #E2E8F0;
        padding: 0.6rem 0.75rem;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        background: white;
        color: #1E293B;
    }

    .form-control:focus, .form-select:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        outline: none;
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23ef4444' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        padding-right: 2rem;
    }

    .btn-filter {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        cursor: pointer;
        width: 100%;
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(239, 68, 68, 0.4);
    }

    .table-container {
        background: white;
        border-radius: 12px;
        padding: 1.2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid #E2E8F0;
        overflow-x: auto;
    }

    .table {
        margin: 0;
        font-size: 0.85rem;
    }

    .table thead th {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border: 1px solid #dc2626;
        padding: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .table tbody td {
        border: 1px solid #E2E8F0;
        padding: 0.8rem;
        color: #1E293B;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: #F8FAFC;
    }

    .badge {
        padding: 0.35rem 0.7rem;
        border-radius: 100px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .badge-pendiente {
        background: #FEF3C7;
        color: #92400E;
    }

    .badge-aprobado {
        background: #DCFCE7;
        color: #166534;
    }

    .badge-rechazado {
        background: #FEE2E2;
        color: #991B1B;
    }

    .btn-action {
        padding: 8px 10px !important;
        border: none !important;
        border-radius: 6px !important;
        font-size: 0.85rem !important;
        font-weight: 600 !important;
        transition: all 0.3s ease !important;
        cursor: pointer !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.3rem !important;
        text-decoration: none !important;
        color: white !important;
        margin: 0 2px !important;
        min-width: 35px !important;
    }

    .btn-view {
        background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%) !important;
    }

    .btn-edit {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
    }

    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
    }

    .btn-action:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        color: white !important;
    }

    .pagination {
        margin-top: 1.5rem;
        justify-content: center;
    }

    .page-link {
        background-color: white;
        border-color: #E2E8F0;
        color: #1E293B;
        padding: 0.5rem 0.8rem;
        font-size: 0.85rem;
    }

    .page-link:hover {
        background-color: #ef4444;
        border-color: #ef4444;
        color: white;
    }

    .page-item.active .page-link {
        background-color: #ef4444;
        border-color: #ef4444;
    }

    @media (max-width: 768px) {
        .gastos-header {
            flex-direction: column;
            gap: 1rem;
        }

        .filters-row {
            grid-template-columns: 1fr;
        }
    }
</style>

@section('content')
<div class="px-3 py-3" style="background: #F8FAFC; min-height: 100vh;">
    <!-- Header -->
    <div class="gastos-header">
        <div class="gastos-header-content">
            <h1><i class="fas fa-arrow-down me-2"></i>Gestión de Gastos</h1>
            <p>Administra y controla todos los gastos del club Rotaract</p>
        </div>
        @can('finanzas.crear')
        <a href="{{ route('tesorero.gastos.create') }}" class="btn-nuevo">
            <i class="fas fa-plus"></i> Nuevo Gasto
        </a>
        @endcan
    </div>

    <!-- Filtros -->
    <div class="filters-section">
        <form method="GET" action="{{ route('tesorero.gastos.index') }}" class="filters-row">
            <div>
                <label class="filter-label">Buscar</label>
                <input type="text" name="search" class="form-control" placeholder="Concepto, proveedor..." 
                       value="{{ request('search') }}">
            </div>
            <div>
                <label class="filter-label">Categoría</label>
                <select name="categoria" class="form-select">
                    <option value="">Todas</option>
                    <option value="Servicios" {{ request('categoria') === 'Servicios' ? 'selected' : '' }}>Servicios</option>
                    <option value="Suministros" {{ request('categoria') === 'Suministros' ? 'selected' : '' }}>Suministros</option>
                    <option value="Equipamiento" {{ request('categoria') === 'Equipamiento' ? 'selected' : '' }}>Equipamiento</option>
                </select>
            </div>
            <div>
                <label class="filter-label">Estado</label>
                <select name="estado" class="form-select">
                    <option value="">Todos</option>
                    <option value="aprobado" {{ request('estado') === 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                    <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="rechazado" {{ request('estado') === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                </select>
            </div>
            <button type="submit" class="btn-filter">
                <i class="fas fa-search me-1"></i> Filtrar
            </button>
        </form>
    </div>

    <!-- Tabla -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="8%">#</th>
                        <th width="18%">Concepto</th>
                        <th width="12%">Categoría</th>
                        <th width="12%">Monto</th>
                        <th width="12%">Fecha</th>
                        <th width="12%">Proveedor</th>
                        <th width="12%">Estado</th>
                        <th width="14%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gastos ?? [] as $gasto)
                        <tr>
                            <td>{{ $gasto->id }}</td>
                            <td>{{ $gasto->concepto ?? $gasto->descripcion }}</td>
                            <td>{{ $gasto->categoria ?? '-' }}</td>
                            <td class="fw-bold" style="color: #ef4444;">L. {{ number_format($gasto->monto ?? 0, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($gasto->fecha_gasto ?? $gasto->created_at)->format('d/m/Y') }}</td>
                            <td>{{ $gasto->proveedor ?? '-' }}</td>
                            <td>
                                @php
                                    $estado = $gasto->estado_aprobacion ?? $gasto->estado ?? 'pendiente';
                                    $badgeClass = match($estado) {
                                        'aprobado' => 'badge-aprobado',
                                        'pendiente' => 'badge-pendiente',
                                        default => 'badge-rechazado'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($estado) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('tesorero.gastos.show', $gasto->id) }}" class="btn-action btn-view" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @can('finanzas.editar')
                                <a href="{{ route('tesorero.gastos.edit', $gasto->id) }}" class="btn-action btn-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @can('finanzas.eliminar')
                                <button type="button" class="btn-action btn-delete btn-delete-gasto" 
                                        data-id="{{ $gasto->id }}"
                                        data-descripcion="{{ $gasto->descripcion }}"
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endcan
                                <form id="deleteForm{{ $gasto->id }}" 
                                      action="{{ route('tesorero.gastos.destroy', $gasto->id) }}" 
                                      method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x" style="color: #CBD5E1;"></i>
                                <p style="color: #94A3B8; font-size: 0.9rem; margin-top: 0.5rem;">No hay gastos registrados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if(isset($gastos) && $gastos->hasPages())
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    {{ $gastos->links() }}
                </ul>
            </nav>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mensajes
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false,
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#ef4444'
            });
        @endif

        // Eliminar gasto
        document.querySelectorAll('.btn-delete-gasto').forEach(btn => {
            btn.addEventListener('click', function() {
                Swal.fire({
                    title: '¿Eliminar gasto?',
                    text: this.dataset.descripcion,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94A3B8',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then(result => {
                    if (result.isConfirmed) {
                        document.getElementById('deleteForm' + this.dataset.id).submit();
                    }
                });
            });
        });
    });
</script>
@endpush

@endsection
