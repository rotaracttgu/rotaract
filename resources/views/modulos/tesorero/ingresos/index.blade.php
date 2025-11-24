@extends('modulos.tesorero.layout')

@section('title', 'Ingresos')

@section('content')
<div style="background: #F8FAFC; min-height: 100vh; padding: 1rem;">
<style>
    .ingresos-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .ingresos-header-content h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        margin: 0;
    }

    .ingresos-header-content p {
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

    .filter-group {
        display: flex;
        flex-direction: column;
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

    .form-control::placeholder {
        color: #94A3B8;
    }

    .form-control:focus, .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        outline: none;
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2310b981' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        padding-right: 2rem;
    }

    .btn-filter {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
        box-shadow: 0 6px 15px rgba(16, 185, 129, 0.4);
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
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: 1px solid #059669;
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

    .badge-confirmado {
        background: #DCFCE7;
        color: #166534;
        padding: 0.35rem 0.7rem;
        border-radius: 100px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .badge-pendiente {
        background: #FEF3C7;
        color: #92400E;
        padding: 0.35rem 0.7rem;
        border-radius: 100px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .badge-cancelado {
        background: #FEE2E2;
        color: #991B1B;
        padding: 0.35rem 0.7rem;
        border-radius: 100px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .badge-activo {
        background: #DBEAFE;
        color: #0C4A6E;
        padding: 0.35rem 0.7rem;
        border-radius: 100px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .tipo-badge {
        background: #10b981;
        color: white;
        padding: 0.3rem 0.6rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
    }

    .action-btns {
        display: flex;
        gap: 0.4rem;
    }

    .btn-action {
        width: auto !important;
        height: auto !important;
        padding: 0 !important;
        border: none !important;
        border-radius: 0 !important;
        font-size: 18px !important;
        font-weight: 600 !important;
        transition: all 0.2s ease !important;
        cursor: pointer !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 0 !important;
        text-decoration: none !important;
        background: transparent !important;
        margin: 0 6px !important;
    }

    .btn-view {
        color: #0EA5E9 !important;
    }

    .btn-view:hover {
        transform: scale(1.2) !important;
        opacity: 0.8 !important;
    }

    .btn-edit {
        color: #F59E0B !important;
    }

    .btn-edit:hover {
        transform: scale(1.2) !important;
        opacity: 0.8 !important;
    }

    .btn-delete {
        color: #EF4444 !important;
        border: none !important;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(239, 68, 68, 0.3) !important;
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
        background-color: #10b981;
        border-color: #10b981;
        color: white;
    }

    .page-item.active .page-link {
        background-color: #10b981;
        border-color: #10b981;
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #64748B;
    }

    .empty-state i {
        font-size: 3rem;
        color: #CBD5E1;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .ingresos-header {
            flex-direction: column;
            gap: 1rem;
        }

        .filters-row {
            grid-template-columns: 1fr;
        }

        .table {
            font-size: 0.75rem;
        }

        .table thead th,
        .table tbody td {
            padding: 0.6rem;
        }
    }
</style>

    
</style>

<div class="px-3 py-3">
    <!-- Header con gradiente verde -->
    <div class="ingresos-header">
        <div class="ingresos-header-content">
            <h1>
                <i class="fas fa-arrow-up me-2"></i>
                Gestion de Ingresos
            </h1>
            <p>Administra y controla todos los ingresos del club</p>
        </div>
        <div class="d-flex gap-2">
            @can('finanzas.crear')
            <a href="{{ route('tesorero.ingresos.create') }}" class="btn-nuevo">
                <i class="fas fa-plus"></i> Nuevo Ingreso
            </a>
            @endcan
        </div>
    </div>
    <!-- Mensajes de éxito/error -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tabla de ingresos -->
    <div class="table-container">
        <!-- Filtros -->
        <div class="row mb-4">
            <div class="col-md-3">
                <input type="text" class="form-control" id="searchInput" placeholder="Buscar por concepto...">
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterTipo">
                    <option value="">Todos los tipos</option>
                    <option value="Membresías">Membresías</option>
                    <option value="Donaciones">Donaciones</option>
                    <option value="Eventos">Eventos</option>
                    <option value="Servicios">Servicios</option>
                    <option value="Otros">Otros</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterEstado">
                    <option value="">Todos los estados</option>
                    <option value="confirmado">Confirmado</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="cancelado">Cancelado</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-nuevo w-100" id="btnFilter">
                    <i class="fas fa-filter me-2"></i> Filtrar
                </button>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-hover" id="ingresosTable">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="20%">Concepto</th>
                        <th width="10%">Tipo</th>
                        <th width="10%">Monto</th>
                        <th width="10%">Fecha</th>
                        <th width="10%">Origen</th>
                        <th width="10%">Metodo</th>
                        <th width="10%">Estado</th>
                        <th width="15%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ingresos ?? [] as $ingreso)
                        <tr>
                            <td>{{ $ingreso->id }}</td>
                            <td>{{ $ingreso->concepto ?? $ingreso->descripcion }}</td>
                            <td>
                                <span class="badge" style="background-color: #6c757d; color: white; padding: 6px 12px;">
                                    {{ $ingreso->tipo ?? $ingreso->categoria }}
                                </span>
                            </td>
                            <td class="text-end fw-bold">L. {{ number_format($ingreso->monto, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($ingreso->fecha_ingreso ?? $ingreso->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $ingreso->origen ?? $ingreso->fuente ?? '-' }}</td>
                            <td>{{ $ingreso->metodo_recepcion ?? $ingreso->metodo_pago ?? '-' }}</td>
                            <td>
                                @php
                                    $estado = $ingreso->estado ?? 'activo';
                                    $badgeClass = match($estado) {
                                        'confirmado', 'activo' => 'badge-confirmado',
                                        'pendiente' => 'badge-pendiente',
                                        default => 'badge-cancelado'
                                    };
                                    $estadoTexto = match($estado) {
                                        'confirmado' => 'Confirmado',
                                        'activo' => 'Activo',
                                        'pendiente' => 'Pendiente',
                                        'cancelado' => 'Cancelado',
                                        default => ucfirst($estado)
                                    };
                                @endphp
                                <span class="{{ $badgeClass }}">{{ $estadoTexto }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('tesorero.ingresos.show', $ingreso->id) }}" 
                                       class="btn btn-sm btn-view"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @can('finanzas.editar')
                                    <a href="{{ route('tesorero.ingresos.edit', $ingreso->id) }}" 
                                       class="btn btn-sm btn-edit"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    @can('finanzas.eliminar')
                                    <form action="{{ route('tesorero.ingresos.destroy', $ingreso->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          id="deleteForm{{ $ingreso->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn btn-sm btn-delete btn-delete-ingreso"
                                                data-id="{{ $ingreso->id }}"
                                                data-concepto="{{ $ingreso->concepto }}"
                                                data-monto="{{ number_format($ingreso->monto, 2) }}"
                                                title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No hay ingresos registrados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if(isset($ingresos) && $ingresos->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $ingresos->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterTipo = document.getElementById('filterTipo');
        const filterEstado = document.getElementById('filterEstado');
        const btnFilter = document.getElementById('btnFilter');
        const table = document.getElementById('ingresosTable');
        
        if (!searchInput || !filterTipo || !filterEstado || !btnFilter || !table) {
            console.error('No se encontraron algunos elementos del filtro');
            return;
        }
        
        const rows = table.querySelectorAll('tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const tipoValue = filterTipo.value.toLowerCase();
            const estadoValue = filterEstado.value.toLowerCase();

            rows.forEach(row => {
                // Saltar la fila de "no hay registros"
                if (row.cells.length === 1) return;

                const concepto = row.cells[1].textContent.toLowerCase().trim();
                const tipo = row.cells[2].textContent.toLowerCase().trim();
                const estado = row.cells[7].textContent.toLowerCase().trim();

                // Búsqueda más precisa: coincide si el concepto empieza con el término o contiene palabras que empiezan con él
                const matchSearch = searchTerm === '' || 
                                   concepto.startsWith(searchTerm) || 
                                   concepto.split(' ').some(word => word.startsWith(searchTerm));
                const matchTipo = tipoValue === '' || tipo.includes(tipoValue);
                const matchEstado = estadoValue === '' || estado.includes(estadoValue);

                if (matchSearch && matchTipo && matchEstado) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Filtrar al hacer clic en el botón
        btnFilter.addEventListener('click', filterTable);

        // Filtrar mientras escribe (en tiempo real)
        searchInput.addEventListener('input', filterTable);

        // Filtrar al presionar Enter en el campo de búsqueda
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                filterTable();
            }
        });

        // Filtrar automáticamente al cambiar los selectores
        filterTipo.addEventListener('change', filterTable);
        filterEstado.addEventListener('change', filterTable);

        // SweetAlert para eliminar ingreso
        document.querySelectorAll('.btn-delete-ingreso').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const ingresoId = this.getAttribute('data-id');
                const concepto = this.getAttribute('data-concepto');
                const monto = this.getAttribute('data-monto');

                Swal.fire({
                    title: '¿Eliminar este ingreso?',
                    html: `
                        <div class="text-start">
                            <p><strong>Concepto:</strong> ${concepto}</p>
                            <p><strong>Monto:</strong> L. ${monto}</p>
                            <p class="text-danger mt-3">Esta acción no se puede deshacer.</p>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: '<i class="fas fa-trash me-2"></i>Sí, eliminar',
                    cancelButtonText: '<i class="fas fa-times me-2"></i>Cancelar',
                    reverseButtons: true,
                    customClass: {
                        popup: 'swal-dark',
                        title: 'swal-title',
                        htmlContainer: 'swal-text'
                    }
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
