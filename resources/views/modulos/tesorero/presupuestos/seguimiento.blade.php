@extends('layouts.app')

@section('title', 'Seguimiento de Presupuestos')

@push('styles')
<style>
    body {
        background-color: #1e2836 !important;
    }

    .seguimiento-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        color: white !important;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
    }

    .seguimiento-header h1, .seguimiento-header p {
        color: #ffffff !important;
        opacity: 1 !important;
    }

    .seguimiento-header .btn-light {
        background: rgba(255,255,255,0.2) !important;
        border: none;
        color: #ffffff !important;
    }

    .seguimiento-header .btn-light:hover {
        background: rgba(255,255,255,0.3) !important;
        color: #ffffff !important;
    }

    .chart-card {
        background: #2a3544 !important;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .chart-title {
        color: #3b82f6 !important;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #3b82f6;
        opacity: 1 !important;
    }

    .categoria-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        color: white !important;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .categoria-header * {
        color: #ffffff !important;
        opacity: 1 !important;
    }

    .categoria-header:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
    }

    .mes-card {
        background: rgba(42, 53, 68, 0.8) !important;
        border-left: 4px solid transparent;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
    }

    .mes-card * {
        color: #e5e7eb !important;
        opacity: 1 !important;
    }

    .mes-card.success {
        border-left-color: #10b981;
    }

    .mes-card.warning {
        border-left-color: #f59e0b;
    }

    .mes-card.danger {
        border-left-color: #ef4444;
    }

    .mes-card:hover {
        background: #3d4757 !important;
    }

    .btn-purple {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        border: none;
        color: white !important;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
    }

    .btn-purple:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        color: white !important;
    }

    .stat-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        display: inline-block;
        opacity: 1 !important;
    }

    .filtros-card {
        background: #2a3544 !important;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    .form-label {
        color: #e5e7eb !important;
        font-weight: 600;
        opacity: 1 !important;
    }

    .form-select, .form-control {
        background-color: rgba(42, 53, 68, 0.8) !important;
        color: #ffffff !important;
        border: 2px solid #3d4757;
        border-radius: 8px;
    }

    .form-select:focus, .form-control:focus {
        background-color: rgba(42, 53, 68, 0.9) !important;
        color: #ffffff !important;
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }

    .form-select option {
        background-color: #2a3544;
        color: #ffffff;
    }

    /* Texto general visible */
    p, span, label, div, small, h1, h2, h3, h4, h5, h6 {
        opacity: 1 !important;
    }

    .text-muted {
        color: #9ca3af !important;
    }

    .text-success {
        color: #10b981 !important;
    }

    .text-warning {
        color: #f59e0b !important;
    }

    .text-danger {
        color: #ef4444 !important;
    }

    /* Progress bars */
    .progress {
        background-color: #3d4757 !important;
    }

    .progress-bar {
        opacity: 1 !important;
    }

    /* Badges */
    .badge {
        opacity: 1 !important;
    }

    /* Tablas */
    .table-responsive {
        background-color: #2a3544 !important;
        border-radius: 10px;
        padding: 0;
    }

    .table {
        color: #ffffff !important;
        background-color: transparent !important;
        margin-bottom: 0 !important;
    }

    .table thead {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
    }

    .table thead th {
        color: #ffffff !important;
        font-weight: 700 !important;
        border: none !important;
        padding: 1rem !important;
        opacity: 1 !important;
    }

    .table tbody {
        background-color: #2a3544 !important;
    }

    .table tbody tr {
        background-color: #2a3544 !important;
    }

    .table tbody td {
        color: #ffffff !important;
        border-color: #3d4757 !important;
        padding: 0.75rem !important;
        font-weight: 600 !important;
        opacity: 1 !important;
        background-color: transparent !important;
    }

    .table-hover tbody tr:hover {
        background-color: #3d4757 !important;
    }

    .table-hover tbody tr:hover td {
        background-color: transparent !important;
    }

    .table tfoot {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
    }

    .table tfoot td, .table tfoot th {
        color: #ffffff !important;
        font-weight: 700 !important;
        border: none !important;
        padding: 1rem !important;
        opacity: 1 !important;
        background-color: transparent !important;
    }

    .table-light,
    .table-light tr,
    .table > tbody > tr.table-light,
    tfoot.table-light {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
    }

    .table-light td, 
    .table-light th,
    tr.table-light td,
    tr.table-light th {
        color: #ffffff !important;
        background-color: transparent !important;
        border-color: transparent !important;
    }

    /* Override mes-card dentro de tabla */
    .table tbody tr.mes-card {
        background-color: #2a3544 !important;
        border-left: none !important;
        margin-bottom: 0 !important;
        padding: 0 !important;
    }

    .table tbody tr.mes-card td {
        background-color: transparent !important;
    }

    /* Asegurar que thead tenga el fondo correcto */
    .table > thead,
    .table > thead > tr,
    .table > thead > tr > th {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
    }

    /* Asegurar que tfoot tenga el fondo correcto */
    .table > tfoot,
    .table > tfoot > tr,
    .table > tfoot > tr > td,
    .table > tfoot > tr > th {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: #ffffff !important;
    }
</style>
@endpush

@section('content')
    <!-- Header -->
    <div class="seguimiento-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-2">
                    <i class="fas fa-chart-line me-2"></i>
                    Seguimiento Anual de Presupuestos
                </h1>
                <p class="mb-0 opacity-75">Comparación mensual de presupuestos vs gastos reales</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('tesorero.presupuestos.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>
                    Volver
                </a>
            </div>
        </div>
    </div>

    <!-- Filtro de Año -->
    <div class="filtros-card">
        <form method="GET" action="{{ route('tesorero.presupuestos.seguimiento') }}">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-calendar me-1"></i>
                        Año
                    </label>
                    <select name="anio" class="form-select">
                        @for($i = 2020; $i <= 2030; $i++)
                            <option value="{{ $i }}" {{ $anio == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-purple w-100">
                        <i class="fas fa-search me-2"></i>
                        Filtrar
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if(count($datosComparativos) > 0)
        @foreach($datosComparativos as $categoria => $meses)
            <div class="chart-card">
                <!-- Header de Categoría -->
                <div class="categoria-header" data-bs-toggle="collapse" data-bs-target="#categoria-{{ Str::slug($categoria) }}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">
                                <i class="fas fa-tag me-2"></i>
                                {{ $categoria }}
                            </h4>
                        </div>
                        <div>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <!-- Contenido Colapsable -->
                <div class="collapse show" id="categoria-{{ Str::slug($categoria) }}">
                    <!-- Gráfico -->
                    <div class="mb-4">
                        <canvas id="chart-{{ Str::slug($categoria) }}" height="80"></canvas>
                    </div>

                    <!-- Tabla de Datos -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Mes</th>
                                    <th class="text-end">Presupuestado</th>
                                    <th class="text-end">Gastado</th>
                                    <th class="text-end">Diferencia</th>
                                    <th class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($meses as $mesData)
                                    @php
                                        $porcentaje = $mesData['presupuestado'] > 0 
                                            ? ($mesData['gastado'] / $mesData['presupuestado']) * 100 
                                            : 0;
                                        $estado = 'success';
                                        if ($porcentaje >= 90) $estado = 'danger';
                                        elseif ($porcentaje >= 75) $estado = 'warning';
                                    @endphp
                                    <tr class="mes-card {{ $estado }}">
                                        <td class="fw-bold">
                                            <i class="fas fa-calendar-alt me-2 text-muted"></i>
                                            {{ $mesData['mes_nombre'] }}
                                        </td>
                                        <td class="text-end">
                                            L. {{ number_format($mesData['presupuestado'], 2) }}
                                        </td>
                                        <td class="text-end text-danger">
                                            L. {{ number_format($mesData['gastado'], 2) }}
                                        </td>
                                        <td class="text-end fw-bold {{ $mesData['diferencia'] < 0 ? 'text-danger' : 'text-success' }}">
                                            {{ $mesData['diferencia'] >= 0 ? '+' : '' }}L. {{ number_format($mesData['diferencia'], 2) }}
                                        </td>
                                        <td class="text-center">
                                            @if($mesData['presupuestado'] > 0)
                                                <span class="stat-badge bg-{{ $estado }}">
                                                    {{ number_format($porcentaje, 1) }}%
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr class="fw-bold">
                                    <td>TOTAL ANUAL</td>
                                    <td class="text-end">
                                        L. {{ number_format(collect($meses)->sum('presupuestado'), 2) }}
                                    </td>
                                    <td class="text-end text-danger">
                                        L. {{ number_format(collect($meses)->sum('gastado'), 2) }}
                                    </td>
                                    <td class="text-end {{ collect($meses)->sum('diferencia') < 0 ? 'text-danger' : 'text-success' }}">
                                        {{ collect($meses)->sum('diferencia') >= 0 ? '+' : '' }}L. {{ number_format(collect($meses)->sum('diferencia'), 2) }}
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $totalPresup = collect($meses)->sum('presupuestado');
                                            $totalGastado = collect($meses)->sum('gastado');
                                            $porcentajeTotal = $totalPresup > 0 ? ($totalGastado / $totalPresup) * 100 : 0;
                                            $estadoTotal = 'success';
                                            if ($porcentajeTotal >= 90) $estadoTotal = 'danger';
                                            elseif ($porcentajeTotal >= 75) $estadoTotal = 'warning';
                                        @endphp
                                        <span class="stat-badge bg-{{ $estadoTotal }}">
                                            {{ number_format($porcentajeTotal, 1) }}%
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Script para el gráfico de esta categoría -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Configuración global de Chart.js para tema oscuro
                    Chart.defaults.color = '#e5e7eb';
                    Chart.defaults.borderColor = 'rgba(61, 71, 87, 0.5)';

                    const ctx = document.getElementById('chart-{{ Str::slug($categoria) }}').getContext('2d');
                    const meses = @json(array_column($meses, 'mes_nombre'));
                    const presupuestado = @json(array_column($meses, 'presupuestado'));
                    const gastado = @json(array_column($meses, 'gastado'));

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: meses,
                            datasets: [
                                {
                                    label: 'Presupuestado',
                                    data: presupuestado,
                                    backgroundColor: 'rgba(102, 126, 234, 0.7)',
                                    borderColor: 'rgba(102, 126, 234, 1)',
                                    borderWidth: 2
                                },
                                {
                                    label: 'Gastado',
                                    data: gastado,
                                    backgroundColor: 'rgba(220, 53, 69, 0.7)',
                                    borderColor: 'rgba(220, 53, 69, 1)',
                                    borderWidth: 2
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            scales: {
                                x: {
                                    ticks: {
                                        color: '#e5e7eb',
                                        font: {
                                            weight: '600'
                                        }
                                    },
                                    grid: {
                                        color: 'rgba(61, 71, 87, 0.5)'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        color: '#e5e7eb',
                                        font: {
                                            weight: '600'
                                        },
                                        callback: function(value) {
                                            return 'L. ' + value.toLocaleString();
                                        }
                                    },
                                    grid: {
                                        color: 'rgba(61, 71, 87, 0.5)'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        color: '#e5e7eb',
                                        font: {
                                            weight: '600'
                                        }
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.dataset.label + ': L. ' + context.parsed.y.toFixed(2);
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
        @endforeach
    @else
        <div class="chart-card text-center py-5">
            <i class="fas fa-chart-line fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">No hay datos de presupuestos para este año</h4>
            <p class="text-muted">Configura presupuestos para comenzar el seguimiento</p>
            <a href="{{ route('tesorero.presupuestos.create') }}" class="btn btn-purple btn-lg mt-3">
                <i class="fas fa-plus me-2"></i>
                Crear Presupuesto
            </a>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
