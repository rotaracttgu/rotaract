@extends('layouts.app')

@section('title', 'Gastos')

@push('styles')
<style>
    body {
        background-color: #1e2836 !important;
    }

    .gastos-header {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        color: white !important;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(239, 68, 68, 0.3);
    }
    
    .gastos-header h1, .gastos-header p {
        color: #ffffff !important;
        opacity: 1 !important;
    }
    
    .gastos-header .btn-light {
        background: rgba(255,255,255,0.2) !important;
        border: none;
        color: #ffffff !important;
    }
    
    .gastos-header .btn-light:hover {
        background: rgba(255,255,255,0.3) !important;
        color: #ffffff !important;
    }
    
    .stats-card {
        background: #2a3544 !important;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        transition: all 0.3s ease;
        border-left: 4px solid #ef4444;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
    }
    
    .stats-card h3 {
        color: #ef4444 !important;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stats-card p {
        color: #9ca3af !important;
        margin: 0;
        font-size: 0.9rem;
    }

    .table-container {
        background: #2a3544 !important;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    /* Estilos de tabla */
    .table thead th {
        background-color: #2a3544 !important;
        color: #ffffff !important;
        border: 1px solid #3d4757 !important;
        padding: 12px !important;
        font-weight: 600;
    }

    .table tbody td {
        background-color: #2a3544 !important;
        color: #ffffff !important;
        border: 1px solid #3d4757 !important;
        padding: 12px !important;
    }

    .table tbody tr:hover {
        background-color: #34495e !important;
    }

    /* Botones de acciÃ³n */
    .btn-view {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        color: white !important;
        border: none;
    }

    .btn-edit {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: white !important;
        border: none;
    }

    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        color: white !important;
        border: none;
    }

    .btn-nuevo {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        color: white !important;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-nuevo:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(239, 68, 68, 0.4);
        color: white !important;
    }

    /* Badges */
    .badge-aprobado {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: white !important;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
    }

    .badge-pendiente {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: white !important;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
    }

    .badge-rechazado {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        color: white !important;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
    }

    /* Filtros */
    .form-control, .form-select {
        background-color: #2a3544 !important;
        border: 1px solid #3d4757 !important;
        color: #ffffff !important;
    }

    .form-control::placeholder {
        color: #9ca3af !important;
        opacity: 1 !important;
    }

    .form-control:focus, .form-select:focus {
        background-color: #34495e !important;
        border-color: #ef4444 !important;
        color: #ffffff !important;
        box-shadow: 0 0 0 0.2rem rgba(239, 68, 68, 0.25);
    }

    .form-select option {
        background-color: #2a3544 !important;
        color: #ffffff !important;
    }

    /* PaginaciÃ³n */
    .pagination {
        margin-top: 1.5rem;
    }

    .page-link {
        background-color: #2a3544 !important;
        border-color: #3d4757 !important;
        color: #ffffff !important;
    }

    .page-link:hover {
        background-color: #ef4444 !important;
        border-color: #ef4444 !important;
        color: white !important;
    }

    .page-item.active .page-link {
        background-color: #ef4444 !important;
        border-color: #ef4444 !important;
    }

    /* Alertas */
    .alert-success {
        background-color: rgba(16, 185, 129, 0.15) !important;
        border: 1px solid #10b981;
        color: #6ee7b7 !important;
    }

    .alert-danger {
        background-color: rgba(239, 68, 68, 0.15) !important;
        border: 1px solid #ef4444;
        color: #fca5a5 !important;
    }

    /* Texto general */
    p, span, label, div, small {
        opacity: 1 !important;
    }

    .text-muted {
        color: #9ca3af !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header con gradiente rojo -->
    <div class="gastos-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">
                    <i class="fas fa-arrow-down me-2"></i>
                    Gestio de Gastos
                </h1>
                <p class="mb-0 opacity-90">Administra y controla todos los gastos del club</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('tesorero.dashboard') }}" class="btn btn-light">
                    <i class="fas fa-home me-2"></i> Dashboard Principal
                </a>
                <a href="{{ route('tesorero.gastos.create') }}" class="btn btn-nuevo">
                    <i class="fas fa-plus me-2"></i> Nuevo Gasto
                </a>
            </div>
        </div>
    </div>

    <!-- Tabla de gastos -->
    <div class="table-container">
        <!-- Filtros -->
        <div class="row mb-4">
            <div class="col-md-3">
                <input type="text" class="form-control" id="searchInput" placeholder="Buscar por concepto...">
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterCategoria">
                    <option value="">Todas las categorias</option>
                    <option value="Servicios">Servicios</option>
                    <option value="Suministros">Suministros</option>
                    <option value="Equipamiento">Equipamiento</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterEstado">
                    <option value="">Todos los estados</option>
                    <option value="aprobado">Aprobado</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="rechazado">Rechazado</option>
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
            <table class="table table-hover" id="gastosTable">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="20%">Concepto</th>
                        <th width="10%">Categoria</th>
                        <th width="10%">Monto</th>
                        <th width="10%">Fecha</th>
                        <th width="10%">Proveedor</th>
                        <th width="10%">Método</th>
                        <th width="10%">Estado</th>
                        <th width="15%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gastos ?? [] as $gasto)
                        <tr>
                            <td>{{ $gasto->id }}</td>
                            <td>{{ $gasto->concepto ?? $gasto->descripcion }}</td>
                            <td>
                                <span class="badge" style="background-color: #6c757d; color: white; padding: 6px 12px;">
                                    {{ $gasto->categoria }}
                                </span>
                            </td>
                            <td class="text-end fw-bold">L. {{ number_format($gasto->monto, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($gasto->fecha_gasto ?? $gasto->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $gasto->proveedor ?? '-' }}</td>
                            <td>{{ $gasto->metodo_pago ?? '-' }}</td>
                            <td>
                                @php
                                    $estado = $gasto->estado_aprobacion ?? $gasto->estado ?? 'pendiente';
                                    $badgeClass = match($estado) {
                                        'aprobado' => 'badge-aprobado',
                                        'pendiente' => 'badge-pendiente',
                                        default => 'badge-rechazado'
                                    };
                                    $estadoTexto = match($estado) {
                                        'aprobado' => 'Aprobado',
                                        'pendiente' => 'Pendiente',
                                        'rechazado' => 'Rechazado',
                                        default => ucfirst($estado)
                                    };
                                @endphp
                                <span class="{{ $badgeClass }}">{{ $estadoTexto }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('tesorero.gastos.show', $gasto->id) }}" 
                                       class="btn btn-sm btn-view"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('tesorero.gastos.edit', $gasto->id) }}" 
                                       class="btn btn-sm btn-edit"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('tesorero.gastos.destroy', $gasto->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          id="deleteForm{{ $gasto->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn btn-sm btn-delete btn-delete-gasto"
                                                data-id="{{ $gasto->id }}"
                                                data-descripcion="{{ $gasto->descripcion }}"
                                                data-monto="{{ number_format($gasto->monto, 2) }}"
                                                title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No hay gastos registrados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if(isset($gastos) && $gastos->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $gastos->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mensajes de éxito/error con SweetAlert
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
                position: 'center'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: '{{ session('error') }}',
                showConfirmButton: true,
                confirmButtonColor: '#dc3545',
                position: 'center'
            });
        @endif

        // Filtros de búsqueda
        const searchInput = document.getElementById('searchInput');
        const filterCategoria = document.getElementById('filterCategoria');
        const filterEstado = document.getElementById('filterEstado');
        const btnFilter = document.getElementById('btnFilter');
        const table = document.getElementById('gastosTable');
        const rows = table.querySelectorAll('tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const categoriaValue = filterCategoria.value.toLowerCase();
            const estadoValue = filterEstado.value.toLowerCase();

            rows.forEach(row => {
                // Saltar la fila de "no hay registros"
                if (row.cells.length === 1) return;

                const concepto = row.cells[1].textContent.toLowerCase().trim();
                const categoria = row.cells[2].textContent.toLowerCase();
                const estado = row.cells[7].textContent.toLowerCase();

                // Búsqueda más precisa: coincide si el concepto empieza con el término o contiene palabras que empiezan con él
                const matchSearch = searchTerm === '' || 
                                   concepto.startsWith(searchTerm) || 
                                   concepto.split(' ').some(word => word.startsWith(searchTerm));
                const matchCategoria = categoriaValue === '' || categoria.includes(categoriaValue);
                const matchEstado = estadoValue === '' || estado.includes(estadoValue);

                if (matchSearch && matchCategoria && matchEstado) {
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
        filterCategoria.addEventListener('change', filterTable);
        filterEstado.addEventListener('change', filterTable);

        // SweetAlert para eliminar gasto
        document.querySelectorAll('.btn-delete-gasto').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const gastoId = this.getAttribute('data-id');
                const descripcion = this.getAttribute('data-descripcion');
                const monto = this.getAttribute('data-monto');

                Swal.fire({
                    title: '¿Eliminar este gasto?',
                    html: `
                        <div class="text-start">
                            <p><strong>Descripción:</strong> ${descripcion}</p>
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
                        document.getElementById('deleteForm' + gastoId).submit();
                    }
                });
            });
        });
    });
</script>
@endpush

@endsection
