@extends('layouts.app')

@section('title', 'Dashboard Financiero - Tesorero')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Financiero</h1>
        <div class="d-sm-flex">
            <a href="{{ route('tesorero.finanzas') }}" class="btn btn-primary btn-sm me-2">
                <i class="fas fa-chart-line fa-sm text-white-50"></i> Ver Resumen
            </a>
            <a href="{{ route('tesorero.calendario') }}" class="btn btn-info btn-sm">
                <i class="fas fa-calendar fa-sm text-white-50"></i> Calendario
            </a>
        </div>
    </div>

    {{-- Tarjetas de resumen --}}
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Ingresos del Mes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ number_format($totalIngresosMes ?? 0, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Egresos del Mes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ number_format($totalEgresosMes ?? 0, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-credit-card fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-{{ ($balanceMes ?? 0) >= 0 ? 'success' : 'danger' }} shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-{{ ($balanceMes ?? 0) >= 0 ? 'success' : 'danger' }} text-uppercase mb-1">
                                Balance del Mes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ number_format($balanceMes ?? 0, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Saldo Actual</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ number_format($finanzaActual->saldo_actual ?? 0, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Accesos rápidos --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Accesos Rápidos</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('tesorero.finanzas') }}" class="btn btn-success btn-lg btn-block">
                                <i class="fas fa-coins mb-2"></i><br>
                                Gestión de Finanzas
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('tesorero.calendario') }}" class="btn btn-primary btn-lg btn-block">
                                <i class="fas fa-calendar-alt mb-2"></i><br>
                                Calendario Financiero
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('tesorero.welcome') }}" class="btn btn-info btn-lg btn-block">
                                <i class="fas fa-home mb-2"></i><br>
                                Volver a Inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection