@extends('layouts.app')

@section('title', 'Reportes Financieros')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1><i class="fas fa-file-alt me-2"></i> Reportes Financieros</h1>
                <a href="{{ route('tesorero.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i> Atrás
                </a>
            </div>
        </div>
    </div>

    <!-- Resumen General -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Ingresos (Todo el tiempo)</div>
                    <div class="h5 mb-0 font-weight-bold">
                        L. {{ number_format($totalIngresos, 2) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-danger shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Gastos (Todo el tiempo)</div>
                    <div class="h5 mb-0 font-weight-bold">
                        L. {{ number_format($totalGastos, 2) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Balance General</div>
                    <div class="h5 mb-0 font-weight-bold">
                        L. {{ number_format($balance, 2) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Resumen Mes Actual -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Ingresos del Mes Actual</div>
                    <div class="h5 mb-0 font-weight-bold">
                        L. {{ number_format($ingresosDelMes, 2) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-left-danger shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Gastos del Mes Actual</div>
                    <div class="h5 mb-0 font-weight-bold">
                        L. {{ number_format($gastosDelMes, 2) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Opciones de Reportes -->
    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar me-2"></i> Reporte Mensual
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Genera un reporte detallado de ingresos y gastos para un mes específico.</p>
                    <form action="{{ route('tesorero.reportes.mensual') }}" method="GET">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Mes</label>
                                <select name="mes" class="form-select" required>
                                    @foreach(['1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'] as $num => $nombre)
                                        <option value="{{ $num }}" {{ $num == $mesActual ? 'selected' : '' }}>{{ $nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Año</label>
                                <select name="anio" class="form-select" required>
                                    @for($i = 2020; $i <= 2030; $i++)
                                        <option value="{{ $i }}" {{ $i == $anioActual ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-3">
                            <i class="fas fa-file-download me-2"></i> Generar Reporte
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-alt me-2"></i> Reporte Anual
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Genera un reporte anual con el resumen de todos los meses del año.</p>
                    <form action="{{ route('tesorero.reportes.anual') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label">Año</label>
                            <select name="anio" class="form-select" required>
                                @for($i = 2020; $i <= 2030; $i++)
                                    <option value="{{ $i }}" {{ $i == $anioActual ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        @can('finanzas.exportar')
                        <button type="submit" class="btn btn-success w-100 mt-4">
                            <i class="fas fa-file-download me-2"></i> Generar Reporte
                        </button>
                        @endcan
                    </form>utton>
                        @endcan
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-search me-2"></i> Reporte Personalizado
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Genera un reporte con un rango de fechas específico.</p>
                    <form action="{{ route('tesorero.reportes.generar') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Fecha Inicio</label>
                                <input type="date" name="fecha_inicio" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Fecha Fin</label>
                                <input type="date" name="fecha_fin" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tipo de Reporte</label>
                                <select name="tipo" class="form-select">
                                    <option value="general">General</option>
                                    <option value="ingresos">Solo Ingresos</option>
                                    <option value="gastos">Solo Gastos</option>
                                </select>
                            </div>
                        </div>
                        @can('finanzas.exportar')
                        <button type="submit" class="btn btn-info w-100 mt-3">
                            <i class="fas fa-file-download me-2"></i> Generar Reporte Personalizado
                        </button>
                        @endcan
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
