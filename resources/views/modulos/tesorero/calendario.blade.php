@extends('layouts.app')

@section('title', 'Calendario de Finanzas')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1><i class="fas fa-calendar-alt me-2"></i> Calendario Financiero</h1>
                <a href="{{ route('tesorero.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i> Atrás
                </a>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="row mb-3">
        <div class="col-md-6">
            <form method="GET" action="{{ route('tesorero.calendario') }}" class="d-flex gap-2">
                <select name="mes" class="form-select">
                    @foreach(['1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'] as $num => $nombre)
                        <option value="{{ $num }}" {{ $mes == $num ? 'selected' : '' }}>{{ $nombre }}</option>
                    @endforeach
                </select>
                <select name="anio" class="form-select">
                    @for($i = 2020; $i <= 2030; $i++)
                        <option value="{{ $i }}" {{ $anio == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-chart-line me-2"></i> Eventos Financieros de {{ \Carbon\Carbon::create($anio, $mes, 1)->format('F Y') }}
            </h5>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th class="text-end">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $eventosOrdenados = collect($eventos)->sortBy('start');
                    @endphp
                    
                    @forelse($eventosOrdenados as $evento)
                        <tr class="border-left-4" style="border-left: 4px solid {{ $evento['color'] }};">
                            <td>
                                <i class="far fa-calendar me-2"></i>
                                {{ \Carbon\Carbon::parse($evento['start'])->format('d/m/Y (D)') }}
                            </td>
                            <td>
                                @if($evento['type'] == 'ingreso')
                                    <span class="badge bg-success"><i class="fas fa-arrow-down me-1"></i> Ingreso</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-arrow-up me-1"></i> Gasto</span>
                                @endif
                            </td>
                            <td>
                                {{ str_replace(['Ingreso: ', 'Gasto: '], '', $evento['title']) }}
                            </td>
                            <td class="text-end fw-bold">
                                <span class="text-{{ $evento['type'] == 'ingreso' ? 'success' : 'danger' }}">
                                    {{ $evento['type'] == 'ingreso' ? '+' : '-' }}L. {{ number_format($evento['monto'], 2) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-2 opacity-50"></i>
                                <p>No hay eventos financieros en este período</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Resumen del período -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Ingresos</div>
                    <div class="h5 mb-0 font-weight-bold">
                        L. {{ number_format(collect($eventos)->where('type', 'ingreso')->sum('monto'), 2) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-danger shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Gastos</div>
                    <div class="h5 mb-0 font-weight-bold">
                        L. {{ number_format(collect($eventos)->where('type', 'egreso')->sum('monto'), 2) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-{{ (collect($eventos)->where('type', 'ingreso')->sum('monto') - collect($eventos)->where('type', 'egreso')->sum('monto')) >= 0 ? 'success' : 'danger' }} shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-{{ (collect($eventos)->where('type', 'ingreso')->sum('monto') - collect($eventos)->where('type', 'egreso')->sum('monto')) >= 0 ? 'success' : 'danger' }} text-uppercase mb-1">Balance</div>
                    <div class="h5 mb-0 font-weight-bold">
                        L. {{ number_format(collect($eventos)->where('type', 'ingreso')->sum('monto') - collect($eventos)->where('type', 'egreso')->sum('monto'), 2) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leyenda -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 bg-light">
                <div class="card-body">
                    <h6 class="mb-3"><i class="fas fa-key me-2"></i> Leyenda de Colores</h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div style="width: 20px; height: 20px; background-color: #28a745; border-radius: 3px; margin-right: 10px;"></div>
                                <span><strong>Ingresos</strong></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div style="width: 20px; height: 20px; background-color: #dc3545; border-radius: 3px; margin-right: 10px;"></div>
                                <span><strong>Gastos/Egresos</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
