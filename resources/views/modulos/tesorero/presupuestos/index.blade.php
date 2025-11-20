@extends('layouts.app')

@section('title', 'Gestión de Presupuestos')

@push('styles')
<style>
    body {
        background-color: #1e2836 !important;
    }

    .presupuestos-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        color: white !important;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
    }

    .presupuestos-header h1, .presupuestos-header p {
        color: #ffffff !important;
        opacity: 1 !important;
    }

    .presupuestos-header .btn-light {
        background: rgba(255,255,255,0.2) !important;
        border: none;
        color: #ffffff !important;
    }

    .presupuestos-header .btn-light:hover {
        background: rgba(255,255,255,0.3) !important;
        color: #ffffff !important;
    }

    .card-presupuesto {
        background: #2a3544 !important;
        border: 1px solid #3d4757;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .card-presupuesto:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
    }

    .card-presupuesto * {
        color: #e5e7eb !important;
        opacity: 1 !important;
    }

    .progress-custom {
        height: 25px;
        border-radius: 10px;
        background-color: #3d4757 !important;
    }

    .progress-bar-custom {
        border-radius: 10px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff !important;
    }

    .stat-card {
        background: #2a3544 !important;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        border-left: 4px solid;
    }

    .stat-card * {
        color: #e5e7eb !important;
        opacity: 1 !important;
    }

    .stat-card.primary {
        border-left-color: #3b82f6;
    }

    .stat-card.success {
        border-left-color: #10b981;
    }

    .stat-card.warning {
        border-left-color: #f59e0b;
    }

    .stat-card.danger {
        border-left-color: #ef4444;
    }

    .badge-status {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        opacity: 1 !important;
    }

    .btn-purple {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        border: none;
        color: white !important;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-purple:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        color: white !important;
    }

    .categoria-badge {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        color: white !important;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 0.5rem;
        opacity: 1 !important;
    }

    .filtros-card {
        background: #2a3544 !important;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    .filtros-card * {
        opacity: 1 !important;
    }

    .form-label {
        color: #e5e7eb !important;
        font-weight: 600;
    }

    .form-select, .form-control {
        background-color: rgba(42, 53, 68, 0.8) !important;
        color: #ffffff !important;
        border: 2px solid #3d4757;
        border-radius: 8px;
    }

    .form-select:focus, .form-control:focus {
        background-color: rgba(42, 53, 68, 0.9) !important;
        color: #ffffff !important;
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }

    .form-select option {
        background-color: #2a3544;
        color: #ffffff;
    }

    /* Tabla oscura */
    .table {
        color: #ffffff !important;
        background-color: #2a3544 !important;
    }

    .table thead {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
    }

    .table thead th {
        color: #ffffff !important;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        border: none !important;
        font-weight: 700 !important;
        opacity: 1 !important;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;
        padding: 1rem !important;
    }

    .table thead tr {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
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

    /* Alertas */
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

    /* Botones */
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

    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        border: none;
        color: white !important;
    }

    /* Texto general visible */
    p, span, label, div, small, h1, h2, h3, h4, h5, h6 {
        opacity: 1 !important;
    }

    .text-muted {
        color: #9ca3af !important;
    }

    .text-primary {
        color: #3b82f6 !important;
    }

    .text-success {
        color: #10b981 !important;
    }

    .text-warning {
        color: #f59e0b !important;
    }

    .text-danger {
        color: #ef4444 !important;
    }

    /* Card body */
    .card-body {
        background-color: #2a3544 !important;
    }

    .card-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        color: #ffffff !important;
        border: none !important;
    }

    /* Paginación */
    .pagination .page-link {
        background-color: #2a3544 !important;
        border-color: #3d4757 !important;
        color: #e5e7eb !important;
    }

    .pagination .page-link:hover {
        background-color: #3b82f6 !important;
        border-color: #3b82f6 !important;
        color: white !important;
    }

    .pagination .page-item.active .page-link {
        background-color: #3b82f6 !important;
        border-color: #3b82f6 !important;
        color: white !important;
    }
    
    /* Card de gráfica */
    .card {
        background-color: #2a3544 !important;
        border: 1px solid #3d4757 !important;
    }
    
    .card-body {
        background-color: #2a3544 !important;
    }
    
    .card-body h5 {
        color: #e5e7eb !important;
        opacity: 1 !important;
    }
    
    .card-body .text-primary {
        color: #3b82f6 !important;
    }
    
    .fw-bold {
        font-weight: 700 !important;
        color: #e5e7eb !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="presupuestos-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-2">
                    <i class="fas fa-chart-pie me-2"></i>
                    Gestión de Presupuestos
                </h1>
                <p class="mb-0 opacity-75">Control y seguimiento de presupuestos por categoría</p>
            </div>
            <div class="col-md-4 text-md-end">
                @can('finanzas.crear')
                <a href="{{ route('tesorero.presupuestos.create') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-plus me-2"></i>
                    Nuevo Presupuesto
                </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filtros-card">
        <form method="GET" action="{{ route('tesorero.presupuestos.index') }}">
            <div class="row align-items-end g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-calendar-alt me-1"></i>
                        Mes
                    </label>
                    <select name="mes" class="form-select">
                        @foreach(['1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'] as $num => $nombre)
                            <option value="{{ $num }}" {{ $mesActual == $num ? 'selected' : '' }}>{{ $nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">
                        <i class="fas fa-calendar me-1"></i>
                        Año
                    </label>
                    <select name="anio" class="form-select">
                        @for($i = 2020; $i <= 2030; $i++)
                            <option value="{{ $i }}" {{ $anioActual == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-tag me-1"></i>
                        Categoría
                    </label>
                    <select name="categoria" class="form-select">
                        <option value="">Todas las categorías</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat }}" {{ $categoriaFiltro == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">
                        <i class="fas fa-toggle-on me-1"></i>
                        Estado
                    </label>
                    <select name="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="1" {{ $estadoFiltro === '1' ? 'selected' : '' }}>Activos</option>
                        <option value="0" {{ $estadoFiltro === '0' ? 'selected' : '' }}>Inactivos</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-purple w-100">
                        <i class="fas fa-search me-2"></i>
                        Filtrar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Estadísticas Generales -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card primary">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1">Total Presupuestado</p>
                        <h3 class="mb-0 fw-bold">L. {{ number_format($totalPresupuestado, 2) }}</h3>
                    </div>
                    <div class="text-primary">
                        <i class="fas fa-wallet fa-3x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card {{ $totalGastado > $totalPresupuestado ? 'danger' : 'success' }}">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1">Total Gastado</p>
                        <h3 class="mb-0 fw-bold">L. {{ number_format($totalGastado, 2) }}</h3>
                        <small class="text-muted">
                            {{ $totalPresupuestado > 0 ? number_format(($totalGastado / $totalPresupuestado) * 100, 1) : 0 }}% del presupuesto
                        </small>
                    </div>
                    <div class="{{ $totalGastado > $totalPresupuestado ? 'text-danger' : 'text-success' }}">
                        <i class="fas fa-chart-line fa-3x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card {{ $totalDisponible < 0 ? 'danger' : 'warning' }}">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1">Disponible</p>
                        <h3 class="mb-0 fw-bold">L. {{ number_format($totalDisponible, 2) }}</h3>
                        <small class="{{ $totalDisponible < 0 ? 'text-danger' : 'text-muted' }}">
                            {{ $totalDisponible < 0 ? 'Excedido' : 'Restante' }}
                        </small>
                    </div>
                    <div class="{{ $totalDisponible < 0 ? 'text-danger' : 'text-warning' }}">
                        <i class="fas fa-piggy-bank fa-3x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="mb-4">
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('tesorero.presupuestos.seguimiento', ['anio' => $anioActual]) }}" class="btn btn-outline-primary">
                <i class="fas fa-chart-line me-2"></i>
                Ver Seguimiento Anual
            </a>
            <form action="{{ route('tesorero.presupuestos.exportar.excel', ['mes' => $mesActual, 'anio' => $anioActual]) }}" 
               method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-outline-success">
                    <i class="fas fa-file-excel me-2"></i>
                    Exportar Excel
                </button>
            </form>
            <form action="{{ route('tesorero.presupuestos.exportar.pdf', ['mes' => $mesActual, 'anio' => $anioActual]) }}" 
               method="POST" target="_blank" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-outline-danger">
                    <i class="fas fa-file-pdf me-2"></i>
                    Exportar PDF
                </button>
            </form>
            <a href="{{ route('tesorero.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Volver al Dashboard
            </a>
        </div>
    </div>

    <!-- Lista de Presupuestos -->
    @if($presupuestosConProgreso->count() > 0)
        <!-- Gráfico Comparativo -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card" style="border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="fas fa-chart-bar me-2 text-primary"></i>
                            Comparativo Presupuesto vs Gastos
                        </h5>
                        <canvas id="chartComparativo" height="80"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($presupuestosConProgreso as $presupuesto)
                <div class="col-md-6 col-lg-4">
                    <div class="card-presupuesto">
                        <div class="card-body">
                            <!-- Número de Referencia -->
                            @if(!empty($presupuesto->numero_referencia))
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-hashtag me-1"></i>
                                        <strong>{{ $presupuesto->numero_referencia }}</strong>
                                    </small>
                                </div>
                            @endif
                            
                            <div class="mb-3">
                                <span class="categoria-badge">
                                    <i class="fas fa-tag me-1"></i>
                                    {{ $presupuesto->categoria }}
                                </span>
                                @if(!$presupuesto->activo)
                                    <span class="badge bg-secondary">Inactivo</span>
                                @endif
                            </div>

                            <!-- Monto Presupuestado -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Presupuesto:</span>
                                    <span class="fw-bold">L. {{ number_format($presupuesto->presupuesto_mensual, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Gastado:</span>
                                    <span class="fw-bold text-{{ $presupuesto->estado }}">
                                        L. {{ number_format($presupuesto->gasto_real, 2) }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Disponible:</span>
                                    <span class="fw-bold text-{{ $presupuesto->disponible < 0 ? 'danger' : 'success' }}">
                                        L. {{ number_format($presupuesto->disponible, 2) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Barra de Progreso -->
                            <div class="progress progress-custom mb-3">
                                <div class="progress-bar progress-bar-custom bg-{{ $presupuesto->estado }}" 
                                     role="progressbar" 
                                     style="width: {{ min($presupuesto->porcentaje_usado, 100) }}%"
                                     aria-valuenow="{{ $presupuesto->porcentaje_usado }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    {{ number_format($presupuesto->porcentaje_usado, 1) }}%
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="text-center">
                                @if($presupuesto->porcentaje_usado >= 90)
                                    <span class="badge badge-status bg-danger">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Crítico
                                    </span>
                                @elseif($presupuesto->porcentaje_usado >= 75)
                                    <span class="badge badge-status bg-warning">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        Alerta
                                    </span>
                                @else
                                    <span class="badge badge-status bg-success">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Normal
                                    </span>
                                @endif
                                
                                <!-- Indicador de Movimientos -->
                                <span class="badge badge-status ms-2 {{ $presupuesto->total_movimientos > 0 ? 'bg-info' : 'bg-secondary' }}">
                                    <i class="fas fa-receipt me-1"></i>
                                    {{ $presupuesto->total_movimientos }} {{ $presupuesto->total_movimientos == 1 ? 'Movimiento' : 'Movimientos' }}
                                </span>
                            </div>

                            @if($presupuesto->descripcion)
                                <div class="mt-3 pt-3 border-top">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        {{ Str::limit($presupuesto->descripcion, 80) }}
                                    </small>
                                </div>
                            @endif

                            <!-- Botones de Acción -->
                            <div class="mt-3 pt-3 border-top d-flex gap-2">
                                <a href="{{ route('tesorero.presupuestos.show', $presupuesto->id) }}" 
                                   class="btn btn-sm btn-outline-primary flex-fill">
                                    <i class="fas fa-eye me-1"></i>Ver
                                </a>
                                @can('finanzas.editar')
                                <a href="{{ route('tesorero.presupuestos.edit', $presupuesto->id) }}" 
                                   class="btn btn-sm btn-outline-warning flex-fill">
                                    <i class="fas fa-edit me-1"></i>Editar
                                </a>
                                @endcan
                                @can('finanzas.eliminar')
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger flex-fill btn-delete-presupuesto" 
                                        data-id="{{ $presupuesto->id }}"
                                        data-categoria="{{ $presupuesto->categoria }}"
                                        data-presupuesto="{{ number_format($presupuesto->presupuesto_mensual, 2) }}">
                                    <i class="fas fa-trash me-1"></i>Eliminar
                                </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-chart-pie fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">No hay presupuestos configurados</h4>
                <p class="text-muted">Configura presupuestos para el mes y año seleccionado</p>
                @can('finanzas.crear')
                <a href="{{ route('tesorero.presupuestos.create') }}" class="btn btn-purple btn-lg mt-3">
                    <i class="fas fa-plus me-2"></i>
                    Crear Primer Presupuesto
                </a>
                @endcan
            </div>
        </div>
    @endif
</div>

@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Configuración global de Chart.js para tema oscuro
Chart.defaults.color = '#e5e7eb';
Chart.defaults.borderColor = 'rgba(61, 71, 87, 0.5)';

// Gráfico Comparativo
@if($presupuestosConProgreso->count() > 0)
const ctx = document.getElementById('chartComparativo');
if (ctx) {
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($presupuestosConProgreso->pluck('categoria')->toArray()) !!},
            datasets: [{
                label: 'Presupuesto',
                data: {!! json_encode($presupuestosConProgreso->pluck('presupuesto_mensual')->toArray()) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 2,
                borderRadius: 5
            }, {
                label: 'Gastado',
                data: {!! json_encode($presupuestosConProgreso->pluck('gasto_real')->toArray()) !!},
                backgroundColor: 'rgba(239, 68, 68, 0.7)',
                borderColor: 'rgba(239, 68, 68, 1)',
                borderWidth: 2,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#e5e7eb',
                        font: {
                            size: 13,
                            weight: 'bold'
                        },
                        padding: 15
                    }
                },
                tooltip: {
                    backgroundColor: '#2a3544',
                    titleColor: '#ffffff',
                    bodyColor: '#e5e7eb',
                    borderColor: '#3d4757',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': L. ' + context.parsed.y.toFixed(2);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#e5e7eb',
                        font: {
                            size: 12,
                            weight: '600'
                        },
                        callback: function(value) {
                            return 'L. ' + value.toLocaleString();
                        }
                    },
                    grid: {
                        color: 'rgba(61, 71, 87, 0.5)'
                    }
                },
                x: {
                    ticks: {
                        color: '#e5e7eb',
                        font: {
                            size: 12,
                            weight: '600'
                        },
                        maxRotation: 45,
                        minRotation: 45
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}
@endif

// Mensajes de sesión
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: 'top-end'
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
        confirmButtonColor: '#667eea'
    });
@endif

// Eliminar presupuesto con confirmación
document.querySelectorAll('.btn-delete-presupuesto').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.dataset.id;
        const categoria = this.dataset.categoria;
        const presupuesto = this.dataset.presupuesto;

        Swal.fire({
            title: '¿Eliminar presupuesto?',
            html: `
                <div class="text-start">
                    <p><strong>Categoría:</strong> ${categoria}</p>
                    <p><strong>Presupuesto:</strong> L. ${presupuesto}</p>
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
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Crear formulario y enviar
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/tesorero/presupuestos/${id}`;
                
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
