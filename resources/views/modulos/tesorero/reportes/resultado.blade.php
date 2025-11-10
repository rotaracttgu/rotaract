@extends('layouts.app')

@section('title', 'Resultado del Reporte')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1><i class="fas fa-file-alt me-2"></i> Reporte Personalizado</h1>
                <a href="{{ route('tesorero.reportes.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i> Atrás
                </a>
            </div>
        </div>
    </div>

    <!-- Período del Reporte -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Período del Reporte:</strong> 
                {{ $fechaInicio->format('d/m/Y') }} - {{ $fechaFin->format('d/m/Y') }}
            </div>
        </div>
    </div>

    <!-- Resumen -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Ingresos</div>
                    <div class="h5 mb-0 font-weight-bold">
                        L. {{ number_format($totalIngresos, 2) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-danger shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Gastos</div>
                    <div class="h5 mb-0 font-weight-bold">
                        L. {{ number_format($totalGastos, 2) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Balance</div>
                    <div class="h5 mb-0 font-weight-bold">
                        L. {{ number_format($balance, 2) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ingresos -->
    @if($tipo != 'gastos')
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-arrow-down me-2"></i> Ingresos ({{ $ingresos->count() }} registros)
                </h5>
            </div>
            <div class="card-body">
                @if($ingresos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th>Categoría</th>
                                    <th class="text-end">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ingresos as $ingreso)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($ingreso->fecha)->format('d/m/Y') }}</td>
                                        <td>{{ $ingreso->descripcion }}</td>
                                        <td><span class="badge bg-light text-dark">{{ $ingreso->categoria ?? 'General' }}</span></td>
                                        <td class="text-end fw-bold text-success">+L. {{ number_format($ingreso->monto, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-3">No hay ingresos en este período</p>
                @endif
            </div>
        </div>
    @endif

    <!-- Gastos -->
    @if($tipo != 'ingresos')
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    <i class="fas fa-arrow-up me-2"></i> Gastos ({{ $gastos->count() }} registros)
                </h5>
            </div>
            <div class="card-body">
                @if($gastos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th>Categoría</th>
                                    <th class="text-end">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($gastos as $gasto)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($gasto->fecha)->format('d/m/Y') }}</td>
                                        <td>{{ $gasto->descripcion }}</td>
                                        <td><span class="badge bg-light text-dark">{{ $gasto->categoria ?? 'General' }}</span></td>
                                        <td class="text-end fw-bold text-danger">-L. {{ number_format($gasto->monto, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-3">No hay gastos en este período</p>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
