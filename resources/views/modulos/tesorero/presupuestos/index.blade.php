@extends('modulos.tesorero.layout')

@section('title', 'Gestión de Presupuestos')

@push('styles')
<style>
    /* Fondo claro */
    body {
        background-color: #f8f9fa !important;
    }

    /* Header Azul - Estilo Elegante */
    .presupuestos-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 1.5rem 2rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .presupuestos-header-content h1 {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .presupuestos-header-content h1 i {
        font-size: 1.5rem;
    }

    .presupuestos-header-content p {
        opacity: 0.9;
        font-size: 0.9rem;
        margin: 0.25rem 0 0 0;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .btn-header {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.4);
        color: white;
        padding: 0.6rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-header:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.6);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-header-primary {
        background: white;
        border: 2px solid white;
        color: #2563eb;
    }

    .btn-header-primary:hover {
        background: #f3f4f6;
        border-color: #f3f4f6;
        color: #1d4ed8;
    }

    /* Stats Cards - Estilo Dashboard */
    .stats-card {
        background: white !important;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border-left: 4px solid;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .stats-card.card-blue {
        border-left-color: #3b82f6;
    }

    .stats-card.card-green {
        border-left-color: #10b981;
    }

    .stats-card.card-orange {
        border-left-color: #f59e0b;
    }

    .stats-card.card-red {
        border-left-color: #ef4444;
    }

    .stats-card p {
        color: #6b7280 !important;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .stats-card .stats-value {
        font-size: 1.75rem;
        font-weight: 700;
    }

    .stats-card .stats-value.text-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stats-card .stats-value.text-green {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stats-card .stats-value.text-orange {
        background: linear-gradient(135deg, #f59e0b 0%, #b45309 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stats-card .stats-value.text-red {
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stats-card .icon-box {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .stats-card .icon-box.bg-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }

    .stats-card .icon-box.bg-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .stats-card .icon-box.bg-orange {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .stats-card .icon-box.bg-red {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .stats-card small {
        color: #9ca3af !important;
        font-size: 0.8rem;
    }

    /* Filtros */
    .filtros-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        border-left: 4px solid #3b82f6;
    }

    .filtros-card .form-label {
        color: #374151;
        font-weight: 600;
    }

    .filtros-card .form-select,
    .filtros-card .form-control {
        background-color: #f9fafb;
        color: #1f2937;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .filtros-card .form-select:focus,
    .filtros-card .form-control:focus {
        background-color: white;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }

    .filtros-card .form-select option {
        background-color: white;
        color: #1f2937;
    }

    .btn-filter {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(59, 130, 246, 0.4);
        color: white;
    }

    /* Acciones Rápidas */
    .quick-actions {
        background: white;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
    }

    .quick-actions .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    .btn-outline-primary {
        color: #3b82f6;
        border-color: #3b82f6;
    }

    .btn-outline-primary:hover {
        background: #3b82f6;
        color: white;
    }

    .btn-outline-success {
        color: #10b981;
        border-color: #10b981;
    }

    .btn-outline-success:hover {
        background: #10b981;
        color: white;
    }

    .btn-outline-danger {
        color: #ef4444;
        border-color: #ef4444;
    }

    .btn-outline-danger:hover {
        background: #ef4444;
        color: white;
    }

    .btn-outline-secondary {
        color: #6b7280;
        border-color: #e5e7eb;
    }

    .btn-outline-secondary:hover {
        background: #f3f4f6;
        border-color: #d1d5db;
        color: #374151;
    }

    /* Tarjetas de Presupuesto */
    .card-presupuesto {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .card-presupuesto:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.15);
    }

    .card-presupuesto .card-body {
        padding: 1.5rem;
    }

    .categoria-badge {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .card-presupuesto .text-muted {
        color: #6b7280 !important;
    }

    .card-presupuesto .fw-bold {
        color: #1f2937;
    }

    .progress-custom {
        height: 25px;
        border-radius: 10px;
        background-color: #e5e7eb;
        overflow: hidden;
    }

    .progress-bar-custom {
        border-radius: 10px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.85rem;
    }

    .badge-status {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .card-presupuesto .border-top {
        border-color: #e5e7eb !important;
    }

    /* Gráfico */
    .chart-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        margin-bottom: 1.5rem;
    }

    .chart-card .card-body {
        padding: 1.5rem;
    }

    .chart-card h5 {
        color: #1f2937;
        font-weight: 700;
    }

    .chart-card .text-primary {
        color: #3b82f6 !important;
    }

    /* Empty State */
    .empty-state {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        padding: 3rem;
        text-align: center;
    }

    .empty-state i {
        color: #d1d5db;
    }

    .empty-state h4, .empty-state p {
        color: #6b7280;
    }

    /* Alertas */
    .alert-success {
        background-color: rgba(16, 185, 129, 0.1);
        border: 1px solid #10b981;
        color: #047857;
        border-radius: 10px;
    }

    .alert-danger {
        background-color: rgba(239, 68, 68, 0.1);
        border: 1px solid #ef4444;
        color: #dc2626;
        border-radius: 10px;
    }

    /* Botones de acción en cards */
    .card-presupuesto .btn-sm {
        padding: 0.4rem 0.75rem;
        font-size: 0.8rem;
        border-radius: 8px;
        font-weight: 500;
    }

    .btn-outline-warning {
        color: #f59e0b;
        border-color: #f59e0b;
    }

    .btn-outline-warning:hover {
        background: #f59e0b;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="presupuestos-header">
        <div class="presupuestos-header-content">
            <h1>
                <i class="fas fa-chart-pie"></i>
                Gestión de Presupuestos
            </h1>
            <p>Control y seguimiento de presupuestos por categoría</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('tesorero.dashboard') }}" class="btn-header">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
            @can('finanzas.crear')
            <a href="{{ route('tesorero.presupuestos.create') }}" class="btn-header btn-header-primary">
                <i class="fas fa-plus-circle"></i>
                Nuevo Presupuesto
            </a>
            @endcan
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
                    <button type="submit" class="btn btn-filter w-100">
                        <i class="fas fa-search me-2"></i>
                        Filtrar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Estadísticas Generales -->
    <div class="row mb-4 g-4">
        <div class="col-md-4">
            <div class="stats-card card-blue">
                <div>
                    <p class="mb-1">Total Presupuestado</p>
                    <h3 class="stats-value text-blue mb-0">L. {{ number_format($totalPresupuestado, 2) }}</h3>
                </div>
                <div class="icon-box bg-blue">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card {{ $totalGastado > $totalPresupuestado ? 'card-red' : 'card-green' }}">
                <div>
                    <p class="mb-1">Total Gastado</p>
                    <h3 class="stats-value {{ $totalGastado > $totalPresupuestado ? 'text-red' : 'text-green' }} mb-0">L. {{ number_format($totalGastado, 2) }}</h3>
                    <small>{{ $totalPresupuestado > 0 ? number_format(($totalGastado / $totalPresupuestado) * 100, 1) : 0 }}% del presupuesto</small>
                </div>
                <div class="icon-box {{ $totalGastado > $totalPresupuestado ? 'bg-red' : 'bg-green' }}">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card {{ $totalDisponible < 0 ? 'card-red' : 'card-orange' }}">
                <div>
                    <p class="mb-1">Disponible</p>
                    <h3 class="stats-value {{ $totalDisponible < 0 ? 'text-red' : 'text-orange' }} mb-0">L. {{ number_format($totalDisponible, 2) }}</h3>
                    <small>{{ $totalDisponible < 0 ? 'Excedido' : 'Restante' }}</small>
                </div>
                <div class="icon-box {{ $totalDisponible < 0 ? 'bg-red' : 'bg-orange' }}">
                    <i class="fas fa-piggy-bank"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="quick-actions">
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
                <div class="chart-card">
                    <div class="card-body">
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
                                    <span class="badge bg-secondary ms-1">Inactivo</span>
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
                                    <span class="fw-bold" style="color: {{ $presupuesto->estado == 'danger' ? '#ef4444' : ($presupuesto->estado == 'warning' ? '#f59e0b' : '#10b981') }};">
                                        L. {{ number_format($presupuesto->gasto_real, 2) }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Disponible:</span>
                                    <span class="fw-bold" style="color: {{ $presupuesto->disponible < 0 ? '#ef4444' : '#10b981' }};">
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
        <div class="empty-state">
            <i class="fas fa-chart-pie fa-4x mb-3"></i>
            <h4>No hay presupuestos configurados</h4>
            <p>Configura presupuestos para el mes y año seleccionado</p>
            @can('finanzas.crear')
            <a href="{{ route('tesorero.presupuestos.create') }}" class="btn btn-filter btn-lg mt-3">
                <i class="fas fa-plus me-2"></i>
                Crear Primer Presupuesto
            </a>
            @endcan
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
// Configuración global de Chart.js para tema claro
Chart.defaults.color = '#6b7280';
Chart.defaults.borderColor = 'rgba(229, 231, 235, 0.8)';

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
                        color: '#374151',
                        font: {
                            size: 13,
                            weight: 'bold'
                        },
                        padding: 15
                    }
                },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleColor: '#ffffff',
                    bodyColor: '#e5e7eb',
                    borderColor: '#374151',
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
                        color: '#6b7280',
                        font: {
                            size: 12,
                            weight: '600'
                        },
                        callback: function(value) {
                            return 'L. ' + value.toLocaleString();
                        }
                    },
                    grid: {
                        color: 'rgba(229, 231, 235, 0.8)'
                    }
                },
                x: {
                    ticks: {
                        color: '#6b7280',
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
        confirmButtonColor: '#3b82f6'
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
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
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
