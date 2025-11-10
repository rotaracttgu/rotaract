@extends('layouts.app')

@section('title', 'Movimientos Financieros')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1><i class="fas fa-exchange-alt me-2"></i> Movimientos Financieros</h1>
                <a href="{{ route('tesorero.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i> Atrás
                </a>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i> Historial de Movimientos
            </h5>
        </div>
        <div class="card-body">
            @if($movimientos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Descripción</th>
                                <th>Categoría</th>
                                <th class="text-end">Monto</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($movimientos as $movimiento)
                                <tr class="border-left-4" style="border-left: 4px solid {{ $movimiento['color'] == 'success' ? '#28a745' : '#dc3545' }};">
                                    <td>
                                        <i class="far fa-calendar me-2"></i>
                                        {{ \Carbon\Carbon::parse($movimiento['fecha'])->format('d/m/Y H:i') }}
                                    </td>
                                    <td>
                                        @if($movimiento['tipo'] == 'ingreso')
                                            <span class="badge bg-success"><i class="fas fa-arrow-down me-1"></i> Ingreso</span>
                                        @else
                                            <span class="badge bg-danger"><i class="fas fa-arrow-up me-1"></i> Egreso</span>
                                        @endif
                                    </td>
                                    <td>{{ $movimiento['descripcion'] }}</td>
                                    <td><span class="badge bg-light text-dark">{{ $movimiento['categoria'] }}</span></td>
                                    <td class="text-end fw-bold">
                                        <span class="text-{{ $movimiento['tipo'] == 'ingreso' ? 'success' : 'danger' }}">
                                            {{ $movimiento['tipo'] == 'ingreso' ? '+' : '-' }}L. {{ number_format($movimiento['monto'], 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = match($movimiento['estado']) {
                                                'pagado', 'completada' => 'success',
                                                'pendiente' => 'warning',
                                                'cancelado', 'cancelada' => 'danger',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($movimiento['estado']) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('tesorero.movimientos.detalle', $movimiento['id']) }}" class="btn btn-sm btn-info" title="Ver detalle">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $movimientos->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No hay movimientos registrados</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Resumen General -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Ingresos</div>
                    <div class="h5 mb-0 font-weight-bold">
                        L. {{ number_format(\App\Models\Ingreso::sum('monto') ?? 0, 2) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-danger shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Egresos</div>
                    <div class="h5 mb-0 font-weight-bold">
                        L. {{ number_format(\App\Models\Egreso::sum('monto') ?? 0, 2) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Balance</div>
                    <div class="h5 mb-0 font-weight-bold">
                        L. {{ number_format((\App\Models\Ingreso::sum('monto') ?? 0) - (\App\Models\Egreso::sum('monto') ?? 0), 2) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
