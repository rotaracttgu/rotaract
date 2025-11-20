@extends('modulos.tesorero.layout')

@section('title', 'Reporte Anual')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1><i class="fas fa-calendar-alt me-2"></i> Reporte Anual - {{ $anio }}</h1>
                <a href="{{ route('tesorero.reportes.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i> Atrás
                </a>
            </div>
        </div>
    </div>

    <!-- Resumen General Anual -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Ingresos del Año</div>
                    <div class="h5 mb-0 font-weight-bold">
                        L. {{ number_format($totalIngresos, 2) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-danger shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Gastos del Año</div>
                    <div class="h5 mb-0 font-weight-bold">
                        L. {{ number_format($totalGastos, 2) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Balance Anual</div>
                    <div class="h5 mb-0 font-weight-bold">
                        L. {{ number_format($balance, 2) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Resumen Mensual -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-chart-bar me-2"></i> Resumen Mensual
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Mes</th>
                            <th class="text-end">Ingresos</th>
                            <th class="text-end">Gastos</th>
                            <th class="text-end">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $meses = [1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 
                                     7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'];
                        @endphp
                        @foreach($meses as $numMes => $nombreMes)
                            @php
                                $ingMes = $ingresosPorMes[$numMes] ?? 0;
                                $egMes = $gastosPorMes[$numMes] ?? 0;
                                $balMes = $ingMes - $egMes;
                            @endphp
                            <tr>
                                <td>{{ $nombreMes }}</td>
                                <td class="text-end text-success fw-bold">L. {{ number_format($ingMes, 2) }}</td>
                                <td class="text-end text-danger fw-bold">L. {{ number_format($egMes, 2) }}</td>
                                <td class="text-end fw-bold" style="color: {{ $balMes >= 0 ? '#28a745' : '#dc3545' }};">
                                    L. {{ number_format($balMes, 2) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="table-active fw-bold">
                            <td>TOTALES</td>
                            <td class="text-end text-success">L. {{ number_format($totalIngresos, 2) }}</td>
                            <td class="text-end text-danger">L. {{ number_format($totalGastos, 2) }}</td>
                            <td class="text-end" style="color: {{ $balance >= 0 ? '#28a745' : '#dc3545' }};">
                                L. {{ number_format($balance, 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Ingresos Detallados -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">
                <i class="fas fa-arrow-down me-2"></i> Ingresos Anuales ({{ $ingresos->count() }} registros)
            </h5>
        </div>
        <div class="card-body">
            @if($ingresos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Descripción</th>
                                <th>Mes</th>
                                <th class="text-end">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ingresos as $ingreso)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($ingreso->fecha)->format('d/m/Y') }}</td>
                                    <td>{{ $ingreso->descripcion }}</td>
                                    <td>{{ \Carbon\Carbon::parse($ingreso->fecha)->format('M') }}</td>
                                    <td class="text-end text-success fw-bold">+L. {{ number_format($ingreso->monto, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center py-3">No hay ingresos registrados en este año</p>
            @endif
        </div>
    </div>

    <!-- Gastos Detallados -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">
                <i class="fas fa-arrow-up me-2"></i> Gastos Anuales ({{ $gastos->count() }} registros)
            </h5>
        </div>
        <div class="card-body">
            @if($gastos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Descripción</th>
                                <th>Mes</th>
                                <th class="text-end">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gastos as $gasto)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($gasto->fecha)->format('d/m/Y') }}</td>
                                    <td>{{ $gasto->descripcion }}</td>
                                    <td>{{ \Carbon\Carbon::parse($gasto->fecha)->format('M') }}</td>
                                    <td class="text-end text-danger fw-bold">-L. {{ number_format($gasto->monto, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center py-3">No hay gastos registrados en este año</p>
            @endif
        </div>
    </div>
</div>
@endsection
