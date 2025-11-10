@extends('layouts.app')

@section('title', 'Movimientos Financieros')

@section('content')
<style>
    .movimientos-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .stat-card.ingreso {
        border-left-color: #28a745;
    }

    .stat-card.gasto {
        border-left-color: #dc3545;
    }

    .stat-card.transferencia {
        border-left-color: #17a2b8;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .filtros-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
    }

    .table-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .table-custom {
        margin-bottom: 0;
    }

    .table-custom thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .table-custom thead th {
        border: none;
        padding: 1rem;
        font-weight: 600;
    }

    .table-custom tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #e9ecef;
    }

    .table-custom tbody tr:hover {
        background: #f8f9fa;
        transform: scale(1.01);
    }

    .badge-tipo {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .badge-ingreso {
        background: #28a745;
        color: white;
    }

    .badge-gasto {
        background: #dc3545;
        color: white;
    }

    .badge-transferencia {
        background: #17a2b8;
        color: white;
    }

    .btn-purple {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-purple:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .pagination {
        margin: 0 !important;
        padding: 0 !important;
        gap: 2px !important;
        display: flex !important;
        flex-wrap: wrap !important;
        justify-content: flex-end !important;
        align-items: center !important;
        list-style: none !important;
    }

    .page-item {
        margin: 0 !important;
        padding: 0 !important;
    }

    .page-link {
        color: #667eea !important;
        background-color: white !important;
        border: 1px solid #dee2e6 !important;
        border-radius: 3px !important;
        padding: 0.15rem 0.35rem !important;
        font-weight: 500 !important;
        font-size: 0.65rem !important;
        transition: all 0.3s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-width: 22px !important;
        max-width: 40px !important;
        height: 22px !important;
        line-height: 1 !important;
        text-decoration: none !important;
        margin: 0 1px !important;
    }

    .page-link:hover {
        background-color: #f0f2ff !important;
        border-color: #667eea !important;
        color: #667eea !important;
        transform: translateY(-1px) !important;
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        border-color: #667eea !important;
        color: white !important;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3) !important;
        font-weight: 600 !important;
    }

    .page-item.disabled .page-link {
        color: #adb5bd !important;
        background-color: #f8f9fa !important;
        border-color: #dee2e6 !important;
        cursor: not-allowed !important;
        opacity: 0.6 !important;
    }

    .page-item.disabled .page-link:hover {
        transform: none !important;
    }

    .pagination-info {
        font-size: 0.65rem !important;
        color: #6c757d !important;
        display: flex !important;
        align-items: center !important;
        gap: 0.25rem !important;
        white-space: nowrap !important;
        line-height: 1.2 !important;
    }

    .pagination-info span {
        display: inline-block;
    }

    .pagination-info strong {
        color: #495057 !important;
        font-weight: 600 !important;
    }

    .section-title {
        color: #667eea;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        opacity: 0.3;
    }

    .btn-action {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 8px;
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="movimientos-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-2">
                    <i class="fas fa-exchange-alt me-2"></i>
                    Movimientos Financieros
                </h1>
                <p class="mb-0 opacity-75">Historial completo de ingresos, gastos y transferencias</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('tesorero.dashboard') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>
                    Volver al Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Estadísticas Generales -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card ingreso">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Ingresos</p>
                        <h3 class="mb-0 fw-bold text-success">L. {{ number_format($totales->ingresos ?? 0, 2) }}</h3>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-arrow-up fa-3x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card gasto">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Gastos</p>
                        <h3 class="mb-0 fw-bold text-danger">L. {{ number_format($totales->gastos ?? 0, 2) }}</h3>
                    </div>
                    <div class="text-danger">
                        <i class="fas fa-arrow-down fa-3x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card transferencia">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Transferencias</p>
                        <h3 class="mb-0 fw-bold text-info">L. {{ number_format($totales->transferencias ?? 0, 2) }}</h3>
                    </div>
                    <div class="text-info">
                        <i class="fas fa-exchange-alt fa-3x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filtros-card">
        <h5 class="section-title">
            <i class="fas fa-filter me-2"></i>
            Filtros de Búsqueda
        </h5>
        <form method="GET" action="{{ route('tesorero.movimientos.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-exchange-alt me-1"></i>
                        Tipo de Movimiento
                    </label>
                    <select name="tipo" class="form-select">
                        <option value="">Todos</option>
                        <option value="ingreso" {{ request('tipo') == 'ingreso' ? 'selected' : '' }}>Ingresos</option>
                        <option value="gasto" {{ request('tipo') == 'gasto' ? 'selected' : '' }}>Gastos</option>
                        <option value="transferencia" {{ request('tipo') == 'transferencia' ? 'selected' : '' }}>Transferencias</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-calendar-alt me-1"></i>
                        Fecha Desde
                    </label>
                    <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-calendar-check me-1"></i>
                        Fecha Hasta
                    </label>
                    <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-search me-1"></i>
                        Buscar
                    </label>
                    <input type="text" name="buscar" class="form-control" placeholder="Descripción o categoría..." value="{{ request('buscar') }}">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <button type="submit" class="btn btn-purple">
                        <i class="fas fa-search me-2"></i>
                        Filtrar
                    </button>
                    <a href="{{ route('tesorero.movimientos.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>
                        Limpiar Filtros
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabla de Movimientos -->
    <div class="table-card">
        <div class="p-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2 text-primary"></i>
                    Listado de Movimientos
                </h5>
                <span class="badge bg-primary">{{ $movimientos->total() }} registros</span>
            </div>
        </div>

        @if($movimientos->count() > 0)
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th class="text-end">Monto</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimientos as $mov)
                        <tr>
                            <td>
                                <i class="fas fa-calendar-alt me-2 text-muted"></i>
                                <strong>{{ \Carbon\Carbon::parse($mov->fecha)->format('d/m/Y') }}</strong>
                                <br>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($mov->fecha)->format('H:i') }}</small>
                            </td>
                            <td>
                                <span class="badge-tipo badge-{{ $mov->tipo }}">
                                    @if($mov->tipo == 'ingreso')
                                        <i class="fas fa-arrow-up me-1"></i>
                                    @elseif($mov->tipo == 'gasto')
                                        <i class="fas fa-arrow-down me-1"></i>
                                    @else
                                        <i class="fas fa-exchange-alt me-1"></i>
                                    @endif
                                    {{ ucfirst($mov->tipo) }}
                                </span>
                            </td>
                            <td>
                                <strong>{{ Str::limit($mov->descripcion, 50) }}</strong>
                                @if(isset($mov->numero_referencia) && $mov->numero_referencia)
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-hashtag me-1"></i>{{ $mov->numero_referencia }}
                                    </small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $mov->categoria }}</span>
                            </td>
                            <td class="text-end">
                                <strong class="text-{{ $mov->tipo == 'ingreso' ? 'success' : 'danger' }}">
                                    {{ $mov->tipo == 'ingreso' ? '+' : '-' }} L. {{ number_format($mov->monto, 2) }}
                                </strong>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('tesorero.movimientos.detalle', $mov->id) }}" 
                                   class="btn btn-sm btn-outline-primary btn-action"
                                   title="Ver detalle">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="p-3 border-top bg-light">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div class="pagination-info">
                        <i class="fas fa-info-circle"></i>
                        <span>Mostrando <strong>{{ $movimientos->firstItem() }}</strong>-<strong>{{ $movimientos->lastItem() }}</strong> de <strong>{{ $movimientos->total() }}</strong></span>
                    </div>
                    <nav aria-label="Paginación">
                        {{ $movimientos->appends(request()->query())->links() }}
                    </nav>
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h4 class="text-muted">No hay movimientos para mostrar</h4>
                <p class="text-muted mb-4">
                    @if(request()->hasAny(['tipo', 'fecha_desde', 'fecha_hasta', 'buscar']))
                        No se encontraron resultados con los filtros aplicados
                    @else
                        Aún no hay movimientos registrados en el sistema
                    @endif
                </p>
                @if(request()->hasAny(['tipo', 'fecha_desde', 'fecha_hasta', 'buscar']))
                    <a href="{{ route('tesorero.movimientos.index') }}" class="btn btn-purple">
                        <i class="fas fa-times me-2"></i>
                        Limpiar Filtros
                    </a>
                @else
                    <a href="{{ route('tesorero.dashboard') }}" class="btn btn-purple">
                        <i class="fas fa-plus me-2"></i>
                        Volver al Dashboard
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
