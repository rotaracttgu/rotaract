@extends('layouts.app')

@section('title', 'Membresías')

@push('styles')
<style>
    body {
        background-color: #1e2836 !important;
    }

    .membresias-header {
        background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%) !important;
        color: white !important;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(168, 85, 247, 0.3);
    }
    
    .membresias-header h1, .membresias-header p {
        color: #ffffff !important;
        opacity: 1 !important;
    }
    
    .membresias-header .btn-light {
        background: rgba(255,255,255,0.2) !important;
        border: none;
        color: #ffffff !important;
    }
    
    .membresias-header .btn-light:hover {
        background: rgba(255,255,255,0.3) !important;
        color: #ffffff !important;
    }
    
    .stats-card {
        background: #2a3544 !important;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        transition: all 0.3s ease;
        border-left: 4px solid #a855f7;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(168, 85, 247, 0.3);
    }
    
    .stats-card h3 {
        color: #ffffff !important;
        opacity: 1 !important;
    }
    
    .stats-card p {
        color: #e5e7eb !important;
        opacity: 1 !important;
    }
    
    .stats-card .text-muted {
        color: #9ca3af !important;
    }
    
    .table-membresias {
        background: #2a3544 !important;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
    
    .table {
        color: #ffffff !important;
        background-color: #2a3544 !important;
        margin-bottom: 0;
    }
    
    .table thead {
        background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%) !important;
    }
    
    .table thead th {
        color: #ffffff !important;
        background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%) !important;
        border: none !important;
        font-weight: 700 !important;
        opacity: 1 !important;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;
        padding: 1rem !important;
    }
    
    .table thead tr {
        background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%) !important;
    }
    
    .table-membresias thead th {
        color: #ffffff !important;
        background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%) !important;
    }
    
    .table tbody {
        background-color: #2a3544 !important;
    }
    
    .table tbody tr {
        background-color: #2a3544 !important;
        border-color: rgba(74, 85, 104, 0.5) !important;
    }
    
    .table tbody tr:hover {
        background-color: #3d4757 !important;
    }
    
    .table tbody td {
        color: #ffffff !important;
        background-color: #2a3544 !important;
        border-color: rgba(74, 85, 104, 0.5) !important;
        font-weight: 600 !important;
        opacity: 1 !important;
    }
    
    table td, table th {
        opacity: 1 !important;
    }
    
    .table * {
        opacity: 1 !important;
    }
    
    .badge-pendiente {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: white !important;
    }
    
    .badge-pagado {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: white !important;
    }
    
    .badge-vencido {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        color: white !important;
    }
    
    .badge-cancelado {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
        color: white !important;
    }
    
    .badge-mensual {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        color: white !important;
    }
    
    .badge-trimestral {
        background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%) !important;
        color: white !important;
    }
    
    .badge-semestral {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        color: white !important;
    }
    
    .badge-anual {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: white !important;
    }
    
    .badge {
        opacity: 1 !important;
    }
    
    .btn-primary-custom {
        background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%) !important;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        color: white !important;
        transition: all 0.3s ease;
    }
    
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(168, 85, 247, 0.3);
        color: white !important;
    }
    
    .action-buttons .btn {
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.875rem;
        transition: all 0.2s;
        opacity: 1 !important;
    }
    
    .search-box {
        background: #2a3544 !important;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
    
    .form-label {
        color: #e5e7eb !important;
        opacity: 1 !important;
    }
    
    .form-control, .form-select {
        background-color: rgba(42, 53, 68, 0.8) !important;
        color: #ffffff !important;
        border: 2px solid #3d4757;
        border-radius: 8px;
    }
    
    .form-control:focus, .form-select:focus {
        background-color: rgba(42, 53, 68, 0.9) !important;
        color: #ffffff !important;
        border-color: #a855f7;
        box-shadow: 0 0 0 0.2rem rgba(168, 85, 247, 0.25);
    }
    
    .form-control::placeholder {
        color: #9ca3af !important;
        opacity: 0.7;
    }
    
    .form-select option {
        background-color: #2a3544;
        color: #ffffff;
    }
    
    .member-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .member-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%) !important;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white !important;
        font-weight: bold;
        font-size: 1.1rem;
        opacity: 1 !important;
    }
    
    .alert-success {
        background-color: rgba(16, 185, 129, 0.15) !important;
        border: 1px solid #10b981;
        color: #6ee7b7 !important;
    }
    
    .alert-success * {
        color: #6ee7b7 !important;
    }
    
    .alert-danger {
        background-color: rgba(239, 68, 68, 0.15) !important;
        border: 1px solid #ef4444;
        color: #fca5a5 !important;
    }
    
    .alert-danger * {
        color: #fca5a5 !important;
    }
    
    /* Botones de acción */
    .btn-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        border: none;
        color: white !important;
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        border: none;
        color: white !important;
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        border: none;
        color: white !important;
    }
    
    .btn-outline-secondary {
        border-color: #6c757d !important;
        color: #e5e7eb !important;
    }
    
    .btn-outline-secondary:hover {
        background: #6c757d !important;
        color: white !important;
    }
    
    /* Texto general visible */
    p, span, label, div, small {
        opacity: 1 !important;
    }
    
    .text-muted {
        color: #9ca3af !important;
        opacity: 1 !important;
    }
    
    .text-success {
        color: #10b981 !important;
    }
    
    .text-warning {
        color: #f59e0b !important;
    }
    
    .text-primary {
        color: #a855f7 !important;
    }
    
    /* Paginación */
    .pagination {
        margin-top: 1rem;
    }
    
    .pagination .page-link {
        background-color: #2a3544 !important;
        border-color: #3d4757 !important;
        color: #e5e7eb !important;
    }
    
    .pagination .page-link:hover {
        background-color: #a855f7 !important;
        border-color: #a855f7 !important;
        color: white !important;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #a855f7 !important;
        border-color: #a855f7 !important;
        color: white !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    
    <!-- Header -->
    <div class="membresias-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="mb-2">
                    <i class="fas fa-id-card me-2"></i>
                    Membresías
                </h1>
                <p class="mb-0 opacity-90">Gestión de pagos de membresías de miembros</p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="d-flex gap-2 justify-content-md-end">
                    <a href="{{ route('tesorero.dashboard') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-home me-2"></i>
                        Dashboard Principal
                    </a>
                    @can('finanzas.crear')
                    <a href="{{ route('tesorero.membresias.create') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-plus-circle me-2"></i>
                        Registrar Pago de Membresía
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <!-- Mensajes -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Membresías</p>
                        <h3 class="mb-0">{{ $membresias->total() }}</h3>
                    </div>
                    <div class="text-primary" style="font-size: 2.5rem;">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Pagadas</p>
                        <h3 class="mb-0 text-success">{{ $totalPagadas ?? 0 }}</h3>
                    </div>
                    <div class="text-success" style="font-size: 2.5rem;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Pendientes</p>
                        <h3 class="mb-0 text-warning">{{ $totalPendientes ?? 0 }}</h3>
                    </div>
                    <div class="text-warning" style="font-size: 2.5rem;">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Recaudado</p>
                        <h3 class="mb-0">L. {{ number_format($totalRecaudado ?? 0, 2) }}</h3>
                    </div>
                    <div style="font-size: 2.5rem; color: #f093fb;">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros de búsqueda -->
    <div class="search-box">
        <form method="GET" action="{{ route('tesorero.membresias.index') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small text-muted">Buscar Miembro</label>
                    <input type="text" name="buscar" class="form-control" 
                           placeholder="Buscar por nombre o correo..." 
                           value="{{ request('buscar') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="pagado" {{ request('estado') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                        <option value="vencido" {{ request('estado') == 'vencido' ? 'selected' : '' }}>Vencido</option>
                        <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted">Tipo de Membresía</label>
                    <select name="tipo" class="form-select">
                        <option value="">Todos los tipos</option>
                        <option value="mensual" {{ request('tipo') == 'mensual' ? 'selected' : '' }}>Mensual</option>
                        <option value="trimestral" {{ request('tipo') == 'trimestral' ? 'selected' : '' }}>Trimestral</option>
                        <option value="semestral" {{ request('tipo') == 'semestral' ? 'selected' : '' }}>Semestral</option>
                        <option value="anual" {{ request('tipo') == 'anual' ? 'selected' : '' }}>Anual</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">&nbsp;</label>
                    <button type="submit" class="btn btn-primary-custom w-100 mb-2">
                        <i class="fas fa-search me-2"></i>Buscar
                    </button>
                    @if(request()->hasAny(['buscar', 'estado', 'tipo']))
                        <a href="{{ route('tesorero.membresias.index') }}" class="btn btn-outline-secondary w-100 btn-sm">
                            <i class="fas fa-times me-1"></i>Limpiar
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Tabla de Membresías -->
    <div class="table-membresias">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Miembro</th>
                        <th>Tipo</th>
                        <th>Período</th>
                        <th>Fecha Pago</th>
                        <th class="text-end">Monto</th>
                        <th>Estado</th>
                        <th class="text-center">Recibo</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($membresias as $membresia)
                        <tr>
                            <td>
                                <div class="member-info">
                                    <div class="member-avatar">
                                        {{ strtoupper(substr($membresia->nombre_miembro, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $membresia->nombre_miembro }}</strong>
                                        <br><small class="text-muted">{{ $membresia->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $tipo = $membresia->tipo_membresia ?? 'mensual';
                                @endphp
                                @if($tipo === 'mensual')
                                    <span class="badge badge-mensual">
                                        <i class="fas fa-calendar me-1"></i>Mensual
                                    </span>
                                @elseif($tipo === 'trimestral')
                                    <span class="badge badge-trimestral">
                                        <i class="fas fa-calendar-alt me-1"></i>Trimestral
                                    </span>
                                @elseif($tipo === 'semestral')
                                    <span class="badge badge-semestral">
                                        <i class="fas fa-calendar-week me-1"></i>Semestral
                                    </span>
                                @else
                                    <span class="badge badge-anual">
                                        <i class="fas fa-calendar-day me-1"></i>Anual
                                    </span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($membresia->periodo_inicio)->format('d/m/Y') }}
                                    <i class="fas fa-arrow-right mx-1"></i>
                                    {{ \Carbon\Carbon::parse($membresia->periodo_fin)->format('d/m/Y') }}
                                </small>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($membresia->fecha_pago)->format('d/m/Y') }}
                                </small>
                            </td>
                            <td class="text-end">
                                <strong style="color: #f093fb;">
                                    L. {{ number_format($membresia->monto, 2) }}
                                </strong>
                            </td>
                            <td>
                                @php
                                    $estado = $membresia->estado ?? 'pendiente';
                                @endphp
                                @if($estado === 'pagado')
                                    <span class="badge badge-pagado">
                                        <i class="fas fa-check me-1"></i>Pagado
                                    </span>
                                @elseif($estado === 'pendiente')
                                    <span class="badge badge-pendiente">
                                        <i class="fas fa-clock me-1"></i>Pendiente
                                    </span>
                                @elseif($estado === 'vencido')
                                    <span class="badge badge-vencido">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Vencido
                                    </span>
                                @else
                                    <span class="badge badge-cancelado">
                                        <i class="fas fa-times me-1"></i>Cancelado
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($membresia->numero_recibo)
                                    <small class="badge bg-secondary">
                                        {{ $membresia->numero_recibo }}
                                    </small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('tesorero.membresias.show', $membresia->id) }}" 
                                       class="btn btn-sm btn-info text-white" 
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @can('finanzas.editar')
                                    <a href="{{ route('tesorero.membresias.edit', $membresia->id) }}" 
                                       class="btn btn-sm btn-warning text-white" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    @can('finanzas.eliminar')
                                    <button type="button" 
                                            class="btn btn-sm btn-danger text-white btn-delete" 
                                            data-id="{{ $membresia->id }}"
                                            data-miembro="{{ $membresia->nombre_miembro }}"
                                            data-monto="{{ number_format($membresia->monto, 2) }}"
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                @if(request()->hasAny(['buscar', 'estado', 'tipo']))
                                    <p class="text-muted mb-2">
                                        <strong>No se encontraron resultados para tu búsqueda</strong>
                                    </p>
                                    <p class="text-muted small mb-3">
                                        Intenta con otros criterios de búsqueda
                                    </p>
                                    <a href="{{ route('tesorero.membresias.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Limpiar Filtros
                                    </a>
                                @else
                                    <p class="text-muted">No hay membresías registradas</p>
                                    @can('finanzas.crear')
                                    <a href="{{ route('tesorero.membresias.create') }}" class="btn btn-primary-custom">
                                        <i class="fas fa-plus me-2"></i>Registrar Primera Membresía
                                    </a>
                                    @endcan
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($membresias->hasPages())
            <div class="p-3 border-top">
                {{ $membresias->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Auto-dismiss alerts
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // Eliminar membresía
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const miembro = this.dataset.miembro;
            const monto = this.dataset.monto;

            Swal.fire({
                title: '¿Eliminar membresía?',
                html: `
                    <div class="text-start">
                        <p><strong>Miembro:</strong> ${miembro}</p>
                        <p><strong>Monto:</strong> L. ${monto}</p>
                        <hr>
                        <p class="text-danger mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Esta acción no se puede deshacer
                        </p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-2"></i>Sí, eliminar',
                cancelButtonText: '<i class="fas fa-times me-2"></i>Cancelar',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Crear formulario y enviar
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/tesorero/membresias/${id}`;
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    
                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
