@extends('modulos.tesorero.layout')

@section('title', 'Detalle de Movimiento')

@section('content')
<style>
    .detail-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.2);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .detail-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        margin: 0;
    }

    .detail-header p {
        opacity: 0.95;
        font-size: 0.85rem;
        margin: 0;
    }

    .btn-back-detail {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.4);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-back-detail:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }

    .info-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        margin-bottom: 1.2rem;
        border: 1px solid #E2E8F0;
    }

    .info-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .info-card-header h5 {
        margin: 0;
        color: white;
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-card-header i {
        font-size: 1.1rem;
        color: white;
        opacity: 0.9;
    }

    .info-card-body {
        padding: 1.2rem;
    }

    .info-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.2rem;
    }

    .info-row.full {
        grid-template-columns: 1fr;
    }

    .info-field {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748B;
        font-weight: 700;
        margin-bottom: 0.4rem;
    }

    .info-value {
        font-size: 0.95rem;
        color: #1E293B;
        font-weight: 600;
        word-break: break-word;
    }

    .info-value.amount {
        font-size: 1.3rem;
        font-weight: 700;
    }

    .info-value.amount.positive {
        color: #059669;
    }

    .info-value.amount.negative {
        color: #DC2626;
    }

    .badge-detail {
        display: inline-flex;
        align-items: center;
        padding: 0.4rem 0.8rem;
        border-radius: 100px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .badge-detail.success {
        background: #DCFCE7;
        color: #166534;
    }

    .badge-detail.pending {
        background: #FEF3C7;
        color: #92400E;
    }

    .badge-detail.danger {
        background: #FEE2E2;
        color: #991B1B;
    }

    .action-buttons {
        display: flex;
        flex-direction: row;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-modern {
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        cursor: pointer;
    }

    .btn-modern.primary {
        background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
        color: white;
    }

    .btn-modern.primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    }

    .btn-modern.danger {
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        color: white;
    }

    .btn-modern.danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
    }

    .audit-section {
        background: linear-gradient(135deg, #F0F9FF 0%, #F3E8FF 100%);
        padding: 1rem;
        border-radius: 10px;
        border: 1px solid #E0E7FF;
        margin-top: 1rem;
    }

    .audit-item {
        display: flex;
        flex-direction: column;
        margin-bottom: 0.8rem;
    }

    .audit-item:last-child {
        margin-bottom: 0;
    }

    .audit-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748B;
        font-weight: 700;
        margin-bottom: 0.2rem;
    }

    .audit-value {
        font-size: 0.8rem;
        color: #1E293B;
        font-family: 'Courier New', monospace;
    }

    .divider {
        height: 1px;
        background: #E2E8F0;
        margin: 2rem 0;
    }

    @media (max-width: 768px) {
        .info-row {
            grid-template-columns: 1fr;
        }

        .detail-header h1 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="detail-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1>
                    <i class="fas fa-{{ $tipo == 'ingreso' ? 'arrow-up' : 'arrow-down' }} me-2"></i>
                    Detalle de {{ ucfirst($tipo) }}
                </h1>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('tesorero.movimientos.index') }}" class="btn-back-detail">
                    <i class="fas fa-arrow-left me-2"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Información Principal -->
            <div class="info-card">
                <div class="info-card-header">
                    <i class="fas fa-circle-info"></i>
                    <h5>Información del {{ ucfirst($tipo) }}</h5>
                </div>
                <div class="info-card-body">
                    <!-- Descripción y Categoría -->
                    <div class="info-row">
                        <div class="info-field">
                            <div class="info-label">Descripción</div>
                            <div class="info-value">{{ $movimiento->descripcion ?? 'N/A' }}</div>
                        </div>
                        <div class="info-field">
                            <div class="info-label">Categoría</div>
                            <div class="info-value">
                                <span class="badge-detail" style="background: #F1F5F9; color: #475569;">
                                    {{ $movimiento->categoria ?? 'General' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Monto y Fecha -->
                    <div class="info-row">
                        <div class="info-field">
                            <div class="info-label">Monto</div>
                            <div class="info-value amount {{ $tipo == 'ingreso' ? 'positive' : 'negative' }}">
                                {{ $tipo == 'ingreso' ? '+' : '-' }}L. {{ number_format($movimiento->monto ?? 0, 2) }}
                            </div>
                        </div>
                        <div class="info-field">
                            <div class="info-label">Fecha de Registro</div>
                            <div class="info-value">
                                <i class="fas fa-calendar me-2"></i>
                                {{ $movimiento->fecha ? \Carbon\Carbon::parse($movimiento->fecha)->format('d/m/Y H:i') : 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <!-- Estado e ID -->
                    <div class="info-row">
                        <div class="info-field">
                            <div class="info-label">Estado</div>
                            <div class="info-value">
                                @php
                                    $estadoClass = match($movimiento->estado ?? 'pendiente') {
                                        'pagado', 'completada' => 'success',
                                        'pendiente' => 'pending',
                                        'cancelado', 'cancelada' => 'danger',
                                        default => 'success'
                                    };
                                    $estadoIcon = match($movimiento->estado ?? 'pendiente') {
                                        'pagado', 'completada' => 'check-circle',
                                        'pendiente' => 'clock',
                                        'cancelado', 'cancelada' => 'x-circle',
                                        default => 'info-circle'
                                    };
                                @endphp
                                <span class="badge-detail {{ $estadoClass }}">
                                    <i class="fas fa-{{ $estadoIcon }} me-1"></i>
                                    {{ ucfirst($movimiento->estado ?? 'pendiente') }}
                                </span>
                            </div>
                        </div>
                        <div class="info-field">
                            <div class="info-label">ID Registro</div>
                            <div class="info-value" style="font-family: monospace; background: #F1F5F9; padding: 0.5rem; border-radius: 8px;">
                                {{ $movimiento->id }}
                            </div>
                        </div>
                    </div>

                    <!-- Observaciones -->
                    @if($movimiento->observaciones ?? null)
                        <div class="divider"></div>
                        <div class="info-field">
                            <div class="info-label">Observaciones</div>
                            <div class="info-value" style="background: #F8FAFC; padding: 1rem; border-radius: 8px; border-left: 4px solid #3B82F6;">
                                {{ $movimiento->observaciones }}
                            </div>
                        </div>
                    @endif

                    <!-- Cuentas (para egresos) -->
                    @if($tipo == 'egreso' && (($movimiento->cuenta_origen ?? null) || ($movimiento->cuenta_destino ?? null)))
                        <div class="divider"></div>
                        <div class="info-row">
                            <div class="info-field">
                                <div class="info-label">Cuenta Origen</div>
                                <div class="info-value">{{ $movimiento->cuenta_origen ?? 'N/A' }}</div>
                            </div>
                            <div class="info-field">
                                <div class="info-label">Cuenta Destino</div>
                                <div class="info-value">{{ $movimiento->cuenta_destino ?? 'N/A' }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Card de Acciones -->
            <div class="info-card">
                <div class="info-card-header">
                    <i class="fas fa-cogs"></i>
                    <h5>Acciones</h5>
                </div>
                <div class="info-card-body">
                    <div class="action-buttons">
                        <a href="{{ route('tesorero.' . ($tipo == 'ingreso' ? 'ingresos' : 'gastos') . '.edit', $movimiento->id) }}" 
                           class="btn-modern primary">
                            <i class="fas fa-pencil"></i> Editar
                        </a>
                        <form action="{{ route('tesorero.' . ($tipo == 'ingreso' ? 'ingresos' : 'gastos') . '.destroy', $movimiento->id) }}" 
                              method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este registro?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-modern danger">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Card de Auditoría -->
            <div class="info-card">
                <div class="info-card-header">
                    <i class="fas fa-history"></i>
                    <h5>Auditoría</h5>
                </div>
                <div class="info-card-body">
                    <div class="audit-section">
                        <div class="audit-item">
                            <div class="audit-label">
                                <i class="fas fa-plus-circle me-1"></i> Creado
                            </div>
                            <div class="audit-value">
                                {{ $movimiento->created_at ? $movimiento->created_at->format('d/m/Y H:i:s') : 'N/A' }}
                            </div>
                        </div>
                        <div class="audit-item" style="margin-top: 1rem;">
                            <div class="audit-label">
                                <i class="fas fa-pencil-alt me-1"></i> Última actualización
                            </div>
                            <div class="audit-value">
                                {{ $movimiento->updated_at ? $movimiento->updated_at->format('d/m/Y H:i:s') : 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
