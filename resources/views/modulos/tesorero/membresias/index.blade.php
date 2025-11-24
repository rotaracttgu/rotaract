@extends('modulos.tesorero.layout')

@section('title', 'Membresías')

@push('styles')
<style>
    /* Fondo blanco limpio */
    body {
        background-color: #f8f9fa !important;
    }

    /* Header Purple - Estilo Elegante */
    .membresias-header {
        background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
        color: white;
        padding: 1.5rem 2rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px rgba(168, 85, 247, 0.3);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .membresias-header-content h1 {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .membresias-header-content h1 i {
        font-size: 1.5rem;
    }

    .membresias-header-content p {
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
        color: #7c3aed;
    }

    .btn-header-primary:hover {
        background: #f3f4f6;
        border-color: #f3f4f6;
        color: #6d28d9;
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

    .stats-card.card-purple {
        border-left-color: #a855f7;
    }

    .stats-card.card-green {
        border-left-color: #10b981;
    }

    .stats-card.card-orange {
        border-left-color: #f59e0b;
    }

    .stats-card.card-pink {
        border-left-color: #ec4899;
    }

    .stats-card h3 {
        color: #1f2937 !important;
        opacity: 1 !important;
        font-weight: 700;
        font-size: 2rem;
        margin: 0;
    }

    .stats-card p {
        color: #6b7280 !important;
        opacity: 1 !important;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .stats-card .text-muted {
        color: #9ca3af !important;
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

    .stats-card .icon-box.bg-purple {
        background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%);
    }

    .stats-card .icon-box.bg-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .stats-card .icon-box.bg-orange {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .stats-card .icon-box.bg-pink {
        background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
    }

    .stats-card .stats-value {
        font-size: 2rem;
        font-weight: 700;
    }

    .stats-card .stats-value.text-purple {
        background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
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

    .stats-card .stats-value.text-pink {
        background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* Tabla */
    .table-membresias {
        background: white !important;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }
    
    .table {
        color: #1f2937 !important;
        background-color: white !important;
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
        padding: 1.25rem !important;
    }
    
    .table thead tr {
        background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%) !important;
    }
    
    .table-membresias thead th {
        color: #ffffff !important;
        background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%) !important;
    }
    
    .table tbody {
        background-color: white !important;
    }
    
    .table tbody tr {
        background-color: white !important;
        border-color: #e5e7eb !important;
        transition: all 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: #f9fafb !important;
    }
    
    .table tbody td {
        color: #374151 !important;
        background-color: white !important;
        border-color: #e5e7eb !important;
        font-weight: 500 !important;
        opacity: 1 !important;
        padding: 1rem !important;
    }
    
    table td, table th {
        opacity: 1 !important;
    }
    
    .table * {
        opacity: 1 !important;
    }
    
    /* Badges */
    .badge-pendiente {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: white !important;
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .badge-pagado {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: white !important;
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .badge-vencido {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        color: white !important;
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .badge-cancelado {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
        color: white !important;
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .badge-mensual {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        color: white !important;
        padding: 0.4rem 0.6rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    
    .badge-trimestral {
        background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%) !important;
        color: white !important;
        padding: 0.4rem 0.6rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    
    .badge-semestral {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        color: white !important;
        padding: 0.4rem 0.6rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    
    .badge-anual {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: white !important;
        padding: 0.4rem 0.6rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8rem;
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
    
    /* Search Box */
    .search-box {
        background: white !important;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }
    
    .form-label {
        color: #374151 !important;
        opacity: 1 !important;
        font-weight: 600;
        font-size: 0.95rem;
    }
    
    .form-control, .form-select {
        background-color: #f9fafb !important;
        color: #1f2937 !important;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
    }
    
    .form-control:focus, .form-select:focus {
        background-color: #ffffff !important;
        color: #1f2937 !important;
        border-color: #a855f7;
        box-shadow: 0 0 0 0.2rem rgba(168, 85, 247, 0.25);
    }
    
    .form-control::placeholder {
        color: #9ca3af !important;
        opacity: 0.7;
    }
    
    .form-select option {
        background-color: white;
        color: #1f2937;
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
        background-color: rgba(16, 185, 129, 0.1) !important;
        border: 1px solid #10b981;
        color: #047857 !important;
    }
    
    .alert-success * {
        color: #047857 !important;
    }
    
    .alert-danger {
        background-color: rgba(239, 68, 68, 0.1) !important;
        border: 1px solid #ef4444;
        color: #dc2626 !important;
    }
    
    .alert-danger * {
        color: #dc2626 !important;
    }
    
    /* Botones de acción - solo iconos */
    .btn-info, .btn-warning, .btn-danger {
        display: inline-block !important;
        padding: 8px 12px !important;
        border-radius: 0 !important;
        font-size: 18px !important;
        border: none !important;
        transition: all 0.2s ease !important;
        margin: 0 4px !important;
        background: transparent !important;
        cursor: pointer !important;
    }
    
    .btn-info {
        color: #0EA5E9 !important;
    }
    
    .btn-info:hover {
        transform: scale(1.2) !important;
        opacity: 0.8 !important;
    }
    
    .btn-warning {
        color: #F59E0B !important;
    }
    
    .btn-warning:hover {
        transform: scale(1.2) !important;
        opacity: 0.8 !important;
    }
    
    .btn-danger {
        color: #EF4444 !important;
    }
    
    .btn-danger:hover {
        transform: scale(1.2) !important;
        opacity: 0.8 !important;
    }
    
    /* Paginación */
    .pagination {
        margin-top: 1rem;
    }
    
    .pagination .page-link {
        background-color: white !important;
        border-color: #e5e7eb !important;
        color: #374151 !important;
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
    
    /* Texto general */
    p, span, label, div, small {
        opacity: 1 !important;
    }
    
    .text-muted {
        color: #6b7280 !important;
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
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    
    <!-- Header -->
    <div class="membresias-header">
        <div class="membresias-header-content">
            <h1>
                <i class="fas fa-id-card"></i>
                Membresías
            </h1>
            <p>Gestión de pagos de membresías de miembros</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('tesorero.dashboard') }}" class="btn-header">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
            @can('finanzas.crear')
            <a href="{{ route('tesorero.membresias.create') }}" class="btn-header btn-header-primary">
                <i class="fas fa-plus-circle"></i>
                Registrar Pago
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

    <!-- Estadísticas -->
    <div class="row mb-4 g-4">
        <div class="col-md-3">
            <div class="stats-card card-purple">
                <div>
                    <p class="text-muted mb-1">Total Membresías</p>
                    <h3 class="stats-value text-purple">{{ $membresias->total() }}</h3>
                </div>
                <div class="icon-box bg-purple">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card card-green">
                <div>
                    <p class="text-muted mb-1">Pagadas</p>
                    <h3 class="stats-value text-green">{{ $totalPagadas ?? 0 }}</h3>
                </div>
                <div class="icon-box bg-green">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card card-orange">
                <div>
                    <p class="text-muted mb-1">Pendientes</p>
                    <h3 class="stats-value text-orange">{{ $totalPendientes ?? 0 }}</h3>
                </div>
                <div class="icon-box bg-orange">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card card-pink">
                <div>
                    <p class="text-muted mb-1">Total Recaudado</p>
                    <h3 class="stats-value text-pink">L. {{ number_format($totalRecaudado ?? 0, 2) }}</h3>
                </div>
                <div class="icon-box bg-pink">
                    <i class="fas fa-dollar-sign"></i>
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
