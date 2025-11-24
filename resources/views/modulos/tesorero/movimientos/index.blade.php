@extends('modulos.tesorero.layout')

@section('title', 'Movimientos Financieros')

@section('content')
<style>
    .modern-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.2);
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: none;
    }

    .stat-card.ingreso {
        background: linear-gradient(135deg, #0EA5E9 0%, #2563EB 100%);
        color: white;
    }

    .stat-card.gasto {
        background: linear-gradient(135deg, #F97316 0%, #EC4899 100%);
        color: white;
    }

    .stat-card.balance {
        background: linear-gradient(135deg, #6366F1 0%, #A855F7 100%);
        color: white;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .stat-card .icon-wrapper {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0.2;
        font-size: 3rem;
    }

    .stat-card .stat-label {
        font-size: 0.875rem;
        opacity: 0.9;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .stat-card .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .stat-card .stat-change {
        font-size: 0.75rem;
        opacity: 0.8;
    }

    .table-section {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .table-section-header {
        background: #F8FAFC;
        padding: 1.5rem;
        border-bottom: 1px solid #E2E8F0;
    }

    .modern-table {
        margin: 0;
    }

    .modern-table thead {
        background: #F1F5F9;
        border-bottom: 2px solid #E2E8F0;
    }

    .modern-table thead th {
        padding: 1rem 1.5rem;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748B;
        border: none;
    }

    .modern-table tbody td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #F1F5F9;
    }

    .modern-table tbody tr {
        transition: all 0.2s ease;
    }

    .modern-table tbody tr:hover {
        background: #F8FAFC;
    }

    .modern-table tbody tr:last-child td {
        border-bottom: none;
    }

    .date-cell {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .date-icon {
        width: 42px;
        height: 42px;
        background: #EFF6FF;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #3B82F6;
        font-size: 1rem;
    }

    .date-info .date-main {
        font-weight: 600;
        font-size: 0.875rem;
        color: #1E293B;
    }

    .date-info .date-time {
        font-size: 0.75rem;
        color: #94A3B8;
    }

    .badge-modern {
        padding: 0.375rem 0.875rem;
        border-radius: 100px;
        font-weight: 600;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .badge-ingreso {
        background: #DCFCE7;
        color: #166534;
    }

    .badge-egreso {
        background: #FEE2E2;
        color: #991B1B;
    }

    .badge-category {
        background: #F1F5F9;
        color: #475569;
        padding: 0.375rem 0.875rem;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .badge-status {
        background: #DBEAFE;
        color: #1E40AF;
        padding: 0.375rem 0.875rem;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-status.pendiente {
        background: #FEF3C7;
        color: #92400E;
    }

    .badge-status.cancelado {
        background: #FEE2E2;
        color: #991B1B;
    }

    .amount-positive {
        color: #059669;
        font-weight: 700;
        font-size: 0.9375rem;
    }

    .amount-negative {
        color: #DC2626;
        font-weight: 700;
        font-size: 0.9375rem;
    }

    .btn-action-modern {
        width: 36px !important;
        height: 36px !important;
        padding: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 8px !important;
        background: #F1F5F9 !important;
        color: #64748B !important;
        border: none !important;
        transition: all 0.2s ease !important;
        text-decoration: none !important;
        opacity: 1 !important;
        visibility: visible !important;
        z-index: 100 !important;
        pointer-events: auto !important;
    }

    .btn-action-modern:hover {
        background: #3B82F6 !important;
        color: white !important;
        transform: scale(1.05) !important;
    }

    .btn-white {
        background: white;
        color: #667eea;
        border: 2px solid white;
        padding: 0.625rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-white:hover {
        background: rgba(255, 255, 255, 0.9);
        color: #667eea;
        transform: translateY(-2px);
    }

    .empty-state-modern {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state-modern .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: #F1F5F9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94A3B8;
        font-size: 2rem;
    }

    .empty-state-modern h5 {
        color: #1E293B;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .empty-state-modern p {
        color: #64748B;
        font-size: 0.875rem;
    }

    .pagination {
        margin: 0 !important;
        padding: 0 !important;
        gap: 0.25rem !important;
        display: flex !important;
        flex-wrap: wrap !important;
        justify-content: flex-end !important;
        align-items: center !important;
        list-style: none !important;
    }

    .page-item {
        margin: 0 !important;
    }

    .page-link {
        color: #64748B !important;
        background-color: white !important;
        border: 1px solid #E2E8F0 !important;
        border-radius: 8px !important;
        padding: 0.5rem 0.75rem !important;
        font-weight: 500 !important;
        font-size: 0.875rem !important;
        transition: all 0.2s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-width: 36px !important;
        height: 36px !important;
        text-decoration: none !important;
    }

    .page-link:hover {
        background-color: #F8FAFC !important;
        border-color: #CBD5E1 !important;
        color: #3B82F6 !important;
    }

    .page-item.active .page-link {
        background: #3B82F6 !important;
        border-color: #3B82F6 !important;
        color: white !important;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3) !important;
    }

    .page-item.disabled .page-link {
        color: #CBD5E1 !important;
        background-color: #F8FAFC !important;
        border-color: #E2E8F0 !important;
        cursor: not-allowed !important;
        opacity: 0.6 !important;
    }

    .table-footer {
        background: #F8FAFC;
        padding: 1.25rem 1.5rem;
        border-top: 1px solid #E2E8F0;
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="modern-header text-white">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="text-white mb-1" style="font-size: 1.5rem; font-weight: 700;">Movimientos Financieros</h1>
                <p class="text-white opacity-75 mb-0" style="font-size: 0.875rem;">Historial completo de ingresos y gastos</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('tesorero.dashboard') }}" class="btn btn-white">
                    <i class="fas fa-arrow-left me-2"></i>
                    Volver al Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Estadísticas Generales -->
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="stat-card ingreso">
                <div class="icon-wrapper">
                    <i class="fas fa-trending-up"></i>
                </div>
                <div class="position-relative">
                    <div class="stat-label">Total Ingresos</div>
                    <div class="stat-value">L {{ number_format(\App\Models\Ingreso::sum('monto') ?? 0, 2) }}</div>
                    <div class="stat-change">
                        <i class="fas fa-arrow-up me-1"></i> Todos los tiempos
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card gasto">
                <div class="icon-wrapper">
                    <i class="fas fa-trending-down"></i>
                </div>
                <div class="position-relative">
                    <div class="stat-label">Total Egresos</div>
                    <div class="stat-value">L {{ number_format(\App\Models\Egreso::sum('monto') ?? 0, 2) }}</div>
                    <div class="stat-change">
                        <i class="fas fa-arrow-down me-1"></i> Todos los tiempos
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card balance">
                <div class="icon-wrapper">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="position-relative">
                    <div class="stat-label">Balance</div>
                    <div class="stat-value">L {{ number_format((\App\Models\Ingreso::sum('monto') ?? 0) - (\App\Models\Egreso::sum('monto') ?? 0), 2) }}</div>
                    <div class="stat-change">Disponible</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Movimientos -->
    <div class="table-section">
        <div class="table-section-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0" style="color: #1E293B; font-weight: 600;">Historial de Movimientos</h5>
                </div>
            </div>
        </div>

        @if($movimientos->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Monto</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimientos as $mov)
                        <tr>
                            <td>
                                <div class="date-cell">
                                    <div class="date-icon">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div class="date-info">
                                        <div class="date-main">{{ \Carbon\Carbon::parse($mov['fecha'])->format('d/m/Y') }}</div>
                                        <div class="date-time">{{ \Carbon\Carbon::parse($mov['fecha'])->format('H:i') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-modern badge-{{ $mov['tipo'] }}">
                                    @if($mov['tipo'] == 'ingreso')
                                        <i class="fas fa-arrow-up"></i>
                                    @else
                                        <i class="fas fa-arrow-down"></i>
                                    @endif
                                    {{ ucfirst($mov['tipo']) }}
                                </span>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #1E293B;">{{ Str::limit($mov['descripcion'], 35) }}</div>
                            </td>
                            <td>
                                <span class="badge-category">{{ $mov['categoria'] }}</span>
                            </td>
                            <td>
                                <span class="{{ $mov['tipo'] == 'ingreso' ? 'amount-positive' : 'amount-negative' }}">
                                    {{ $mov['tipo'] == 'ingreso' ? '+' : '-' }}L {{ number_format($mov['monto'], 2) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $estadoClass = match($mov['estado']) {
                                        'pagado', 'completada', 'confirmado' => '',
                                        'pendiente' => 'pendiente',
                                        'cancelado', 'cancelada', 'anulado' => 'cancelado',
                                        default => ''
                                    };
                                @endphp
                                <span class="badge-status {{ $estadoClass }}">{{ ucfirst($mov['estado']) }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('tesorero.movimientos.detalle', $mov['id']) }}" 
                                   class="btn-action-modern"
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
            <div class="table-footer">
                <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
                    <nav aria-label="Paginación">
                        {{ $movimientos->links() }}
                    </nav>
                </div>
            </div>
        @else
            <div class="empty-state-modern">
                <div class="empty-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <h5>No hay movimientos registrados</h5>
                <p>Aún no hay movimientos financieros en el sistema</p>
            </div>
        @endif
    </div>
</div>
@endsection
