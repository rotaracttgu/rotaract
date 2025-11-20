@extends('layouts.app')

@section('title', 'Transferencias')

@push('styles')
<style>
    /* Header con tema oscuro */
    .transferencias-header {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(6, 182, 212, 0.3);
    }

    .transferencias-header h1,
    .transferencias-header p {
        color: #ffffff !important;
        opacity: 1 !important;
    }
    
    /* Stats cards oscuras */
    .stats-card {
        background: #2a3544 !important;
        color: #e5e7eb !important;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        transition: all 0.3s ease;
        border-left: 4px solid #06b6d4;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.4);
    }

    .stats-card h3,
    .stats-card p {
        color: #e5e7eb !important;
    }

    .stats-card .text-muted {
        color: #9ca3af !important;
    }
    
    /* Tabla oscura */
    .table-transferencias {
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
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
    }

    .table thead th {
        color: #ffffff !important;
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        border: none !important;
        font-weight: 700 !important;
        opacity: 1 !important;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;
        padding: 1rem !important;
    }
    
    .table thead tr {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
    }
    
    .table-transferencias thead th {
        color: #ffffff !important;
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
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
    
    /* Badges */
    .badge-entrada {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: white !important;
        font-weight: 700 !important;
    }
    
    .badge-salida {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        color: white !important;
        font-weight: 700 !important;
    }
    
    .badge-interna {
        background: linear-gradient(135deg, #5b6fd8 0%, #7c5cdc 100%) !important;
        color: white !important;
        font-weight: 700 !important;
    }
    
    .badge-externa {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: white !important;
        font-weight: 700 !important;
    }
    
    .badge-ajuste {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        color: white !important;
        font-weight: 700 !important;
    }

    .badge {
        opacity: 1 !important;
    }
    
    /* Botones */
    .btn-primary-custom {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white !important;
    }
    
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(6, 182, 212, 0.5);
        background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%) !important;
    }

    .btn-light {
        background-color: #f3f4f6 !important;
        color: #1e2836 !important;
        border: none !important;
        font-weight: 600;
    }

    .btn-light:hover {
        background-color: #e5e7eb !important;
        color: #1e2836 !important;
    }
    
    .action-buttons .btn {
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .btn-info {
        background-color: #06b6d4 !important;
        color: white !important;
    }

    .btn-warning {
        background-color: #f59e0b !important;
        color: #1e2836 !important;
    }

    .btn-danger {
        background-color: #ef4444 !important;
        color: white !important;
    }
    
    /* Search box oscuro */
    .search-box {
        background: #2a3544 !important;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        border: 1px solid #4a5568;
    }

    /* Formularios */
    .form-control, .form-select {
        background-color: rgba(42, 53, 68, 0.8) !important;
        border: 1px solid #4a5568 !important;
        color: #e5e7eb !important;
    }

    .form-control:focus, .form-select:focus {
        background-color: rgba(42, 53, 68, 0.9) !important;
        border-color: #06b6d4 !important;
        box-shadow: 0 0 0 0.25rem rgba(6, 182, 212, 0.25) !important;
        color: #e5e7eb !important;
    }

    .form-control::placeholder {
        color: #9ca3af !important;
    }

    .form-label {
        color: #e5e7eb !important;
    }

    /* Textos generales */
    h1, h2, h3, h4, h5, h6, p, label, span {
        color: #e5e7eb !important;
    }

    .text-muted {
        color: #9ca3af !important;
    }

    /* Card body */
    .card {
        background-color: #2a3544 !important;
        border: 1px solid #4a5568 !important;
    }

    .card-body {
        background-color: #2a3544 !important;
        color: #e5e7eb !important;
    }

    /* Forzar visibilidad total */
    td, th, span, div, p, strong, b {
        opacity: 1 !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    
    <!-- Header -->
    <div class="transferencias-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="mb-2">
                    <i class="fas fa-exchange-alt me-2"></i>
                    Transferencias
                </h1>
                <p class="mb-0 opacity-90">Gestión de transferencias entre cuentas</p>
            </div>
            <div class="col-md-6 text-md-end">
                @can('finanzas.crear')
                <a href="{{ route('tesorero.transferencias.create') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-plus-circle me-2"></i>
                    Nueva Transferencia
                </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- Mensajes de éxito/error -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    position: 'center'
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: '{{ session('error') }}',
                    showConfirmButton: true,
                    confirmButtonColor: '#dc3545',
                    position: 'center'
                });
            });
        </script>
    @endif

    <!-- Estadísticas Rápidas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Transferencias</p>
                        <h3 class="mb-0">{{ $transferencias->total() }}</h3>
                    </div>
                    <div class="text-primary" style="font-size: 2.5rem;">
                        <i class="fas fa-list"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Este Mes</p>
                        <h3 class="mb-0">{{ $transferenciasDelMes ?? 0 }}</h3>
                    </div>
                    <div class="text-info" style="font-size: 2.5rem;">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Monto Total</p>
                        <h3 class="mb-0">L. {{ number_format($transferencias->sum('monto'), 2) }}</h3>
                    </div>
                    <div class="text-success" style="font-size: 2.5rem;">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Comisiones</p>
                        <h3 class="mb-0">L. {{ number_format($totalComisiones ?? 0, 2) }}</h3>
                    </div>
                    <div class="text-warning" style="font-size: 2.5rem;">
                        <i class="fas fa-percentage"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros de búsqueda -->
    <div class="search-box">
        <form method="GET" action="{{ route('tesorero.transferencias.index') }}" id="formBusqueda">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small text-muted">Buscar</label>
                    <input type="text" name="buscar" class="form-control" 
                           placeholder="Buscar por descripción, cuenta, referencia..." 
                           value="{{ request('buscar') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted">Fecha Desde</label>
                    <input type="date" name="fecha_desde" class="form-control" 
                           value="{{ request('fecha_desde') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted">Fecha Hasta</label>
                    <input type="date" name="fecha_hasta" class="form-control" 
                           value="{{ request('fecha_hasta') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">&nbsp;</label>
                    <button type="submit" class="btn btn-primary-custom w-100 mb-2">
                        <i class="fas fa-search me-2"></i>Buscar
                    </button>
                    @if(request()->hasAny(['buscar', 'fecha_desde', 'fecha_hasta']))
                        <a href="{{ route('tesorero.transferencias.index') }}" class="btn btn-outline-secondary w-100 btn-sm">
                            <i class="fas fa-times me-1"></i>Limpiar
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Tabla de Transferencias -->
    <div class="table-transferencias">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Tipo</th>
                        <th>Subtipo</th>
                        <th>Cuenta Origen</th>
                        <th>Cuenta Destino</th>
                        <th class="text-end">Monto</th>
                        <th class="text-end">Comisión</th>
                        <th class="text-center">Referencia</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transferencias as $transferencia)
                        <tr>
                            <td>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($transferencia->fecha)->format('d/m/Y') }}
                                </small>
                            </td>
                            <td>
                                <strong>{{ $transferencia->descripcion }}</strong>
                            </td>
                            <td>
                                @php
                                    // Extraer el tipo de la categoría
                                    $categoria = $transferencia->categoria ?? '';
                                    if (str_contains($categoria, 'Interna')) {
                                        $tipo_trans = 'Interna';
                                    } elseif (str_contains($categoria, 'Externa')) {
                                        $tipo_trans = 'Externa';
                                    } elseif (str_contains($categoria, 'Ajuste')) {
                                        $tipo_trans = 'Ajuste';
                                    } else {
                                        $tipo_trans = 'Interna';
                                    }
                                @endphp
                                @if($tipo_trans === 'Interna')
                                    <span class="badge badge-interna">
                                        <i class="fas fa-building me-1"></i>Interna
                                    </span>
                                @elseif($tipo_trans === 'Externa')
                                    <span class="badge badge-externa">
                                        <i class="fas fa-university me-1"></i>Externa
                                    </span>
                                @else
                                    <span class="badge badge-ajuste">
                                        <i class="fas fa-cog me-1"></i>Ajuste
                                    </span>
                                @endif
                            </td>
                            <td>
                                @php
                                    // Extraer si es salida o entrada de la categoría
                                    $categoria = $transferencia->categoria ?? '';
                                    $subtipo = str_contains($categoria, 'Salida') ? 'salida' : 'entrada';
                                @endphp
                                @if($subtipo === 'entrada')
                                    <span class="badge badge-entrada">
                                        <i class="fas fa-arrow-down me-1"></i>Entrada
                                    </span>
                                @else
                                    <span class="badge badge-salida">
                                        <i class="fas fa-arrow-up me-1"></i>Salida
                                    </span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">
                                    @php
                                        // Extraer cuenta origen de la descripción
                                        preg_match('/Origen: ([^|]+)/', $transferencia->descripcion, $matches);
                                        echo $matches[1] ?? 'N/A';
                                    @endphp
                                </small>
                            </td>
                            <td>
                                <small class="text-muted">
                                    @php
                                        // Extraer cuenta destino de la descripción
                                        preg_match('/Destino: ([^|]+)/', $transferencia->descripcion, $matches);
                                        echo trim($matches[1] ?? 'N/A');
                                    @endphp
                                </small>
                            </td>
                            <td class="text-end">
                                <strong class="text-primary">
                                    L. {{ number_format($transferencia->monto, 2) }}
                                </strong>
                            </td>
                            <td class="text-end">
                                @php
                                    // Extraer comisión de la descripción
                                    preg_match('/Comisión: ([\d,.]+)/', $transferencia->descripcion, $matches);
                                    $comision = isset($matches[1]) ? floatval(str_replace(',', '', $matches[1])) : 0;
                                @endphp
                                @if($comision > 0)
                                    <span class="text-danger">
                                        L. {{ number_format($comision, 2) }}
                                    </span>
                                @else
                                    <span class="text-muted">L. 0.00</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @php
                                    // Extraer referencia de la descripción
                                    preg_match('/Ref: ([^|]+)/', $transferencia->descripcion, $matches);
                                    $ref = trim($matches[1] ?? '');
                                @endphp
                                @if($ref && $ref !== 'N/A')
                                    <small class="badge bg-secondary">{{ $ref }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('tesorero.transferencias.show', $transferencia->id) }}" 
                                       class="btn btn-sm btn-info text-white" 
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @can('finanzas.editar')
                                    <a href="{{ route('tesorero.transferencias.edit', $transferencia->id) }}" 
                                       class="btn btn-sm btn-warning text-white" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    @can('finanzas.eliminar')
                                    <form action="{{ route('tesorero.transferencias.destroy', $transferencia->id) }}" 
                                          method="POST" 
                                          id="delete-form-{{ $transferencia->id }}"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                onclick="confirmarEliminacion({{ $transferencia->id }}, '{{ addslashes($transferencia->descripcion) }}')"
                                                class="btn btn-sm btn-danger" 
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
                            <td colspan="10" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                @if(request()->hasAny(['buscar', 'fecha_desde', 'fecha_hasta']))
                                    <p class="text-muted mb-2">
                                        <strong>No se encontraron resultados para tu búsqueda</strong>
                                    </p>
                                    <p class="text-muted small mb-3">
                                        Intenta con otros criterios de búsqueda
                                    </p>
                                    <a href="{{ route('tesorero.transferencias.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Limpiar Filtros
                                    </a>
                                @else
                                    <p class="text-muted">No hay transferencias registradas</p>
                                    <a href="{{ route('tesorero.transferencias.create') }}" class="btn btn-primary-custom">
                                        <i class="fas fa-plus me-2"></i>Registrar Primera Transferencia
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($transferencias->hasPages())
            <div class="p-3 border-top">
                {{ $transferencias->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Función de confirmación con SweetAlert2
    function confirmarEliminacion(id, descripcion) {
        Swal.fire({
            title: '¿Estás seguro?',
            html: `Se eliminará la transferencia:<br><strong>${descripcion}</strong><br><span class="text-danger">Esta acción no se puede deshacer.</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush
