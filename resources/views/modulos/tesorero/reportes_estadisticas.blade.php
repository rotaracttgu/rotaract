@extends('modulos.tesorero.layout')

@section('title', 'Reportes y Estadísticas Financieras')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1><i class="fas fa-chart-bar text-primary me-2"></i> Reportes y Estadísticas</h1>
                <div class="btn-group" role="group">
                    <form action="{{ route('tesorero.reportes.generar', ['tipo' => 'excel']) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-file-excel me-1"></i> Exportar Excel
                        </button>
                    </form>
                    <form action="{{ route('tesorero.reportes.generar', ['tipo' => 'pdf']) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-file-pdf me-1"></i> Exportar PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('tesorero.reportes.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Mes</label>
                    <select name="mes" class="form-select">
                        <option value="">Todos los meses</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('mes') == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::createFromDate(2024, $i, 1)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Año</label>
                    <select name="anio" class="form-select">
                        <option value="">Todos los años</option>
                        @for ($i = 2020; $i <= now()->year; $i++)
                            <option value="{{ $i }}" {{ request('anio') == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tipo de Movimiento</label>
                    <select name="tipo" class="form-select">
                        <option value="">Todos</option>
                        <option value="ingreso" {{ request('tipo') == 'ingreso' ? 'selected' : '' }}>Ingresos</option>
                        <option value="gasto" {{ request('tipo') == 'gasto' ? 'selected' : '' }}>Gastos</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tarjetas de Resumen -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title opacity-75">Total Ingresos</h6>
                    <h3 class="mb-0">$ {{ number_format($totalIngresos, 2) }}</h3>
                    <small class="opacity-75">{{ $conteoIngresos }} registros</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-danger text-white">
                <div class="card-body">
                    <h6 class="card-title opacity-75">Total Gastos</h6>
                    <h3 class="mb-0">$ {{ number_format($totalGastos, 2) }}</h3>
                    <small class="opacity-75">{{ $conteoGastos }} registros</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title opacity-75">Saldo Neto</h6>
                    <h3 class="mb-0">$ {{ number_format($totalIngresos - $totalGastos, 2) }}</h3>
                    <small class="opacity-75">
                        @if ($totalIngresos > $totalGastos)
                            <i class="fas fa-arrow-up"></i> Superávit
                        @else
                            <i class="fas fa-arrow-down"></i> Déficit
                        @endif
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-warning text-white">
                <div class="card-body">
                    <h6 class="card-title opacity-75">Membresías</h6>
                    <h3 class="mb-0">$ {{ number_format($totalMembresias, 2) }}</h3>
                    <small class="opacity-75">{{ $conteoMembresias }} membresías activas</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row mb-4">
        <!-- Gráfico de Ingresos vs Gastos -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i> Ingresos vs Gastos</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartIngresosGastos" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Tendencia Mensual -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i> Tendencia Mensual</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartTendenciaMensual" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de Categorías -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-tags me-2"></i> Distribución por Categoría</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartCategorias" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla Detallada -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i> Movimientos Recientes</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Monto</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($movimientosRecientes as $mov)
                            <tr>
                                <td>{{ $mov->fecha->format('d/m/Y') ?? 'N/A' }}</td>
                                <td>
                                    @if ($mov->tipo === 'ingreso')
                                        <span class="badge bg-success">Ingreso</span>
                                    @elseif ($mov->tipo === 'gasto')
                                        <span class="badge bg-danger">Gasto</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($mov->tipo) }}</span>
                                    @endif
                                </td>
                                <td>{{ $mov->descripcion ?? 'N/A' }}</td>
                                <td>{{ $mov->categoria ?? 'N/A' }}</td>
                                <td>
                                    <strong>${{ number_format($mov->monto, 2) }}</strong>
                                </td>
                                <td>
                                    @if ($mov->estado === 'aprobado')
                                        <span class="badge bg-success">Aprobado</span>
                                    @elseif ($mov->estado === 'pendiente')
                                        <span class="badge bg-warning">Pendiente</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($mov->estado) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No hay movimientos para los filtros seleccionados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Colores
    const colorPrimario = '#007bff';
    const colorExito = '#28a745';
    const colorPeligro = '#dc3545';
    const colorAdvertencia = '#ffc107';

    // ===== GRÁFICO 1: Ingresos vs Gastos =====
    const ctx1 = document.getElementById('chartIngresosGastos');
    if (ctx1) {
        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ['Ingresos', 'Gastos'],
                datasets: [{
                    data: [{{ $totalIngresos }}, {{ $totalGastos }}],
                    backgroundColor: [colorExito, colorPeligro],
                    borderColor: ['#fff', '#fff'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // ===== GRÁFICO 2: Tendencia Mensual =====
    const ctx2 = document.getElementById('chartTendenciaMensual');
    if (ctx2) {
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: {!! json_encode($mesesLabels ?? []) !!},
                datasets: [
                    {
                        label: 'Ingresos',
                        data: {!! json_encode($ingresosMensual ?? []) !!},
                        borderColor: colorExito,
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Gastos',
                        data: {!! json_encode($gastosMensual ?? []) !!},
                        borderColor: colorPeligro,
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }

    // ===== GRÁFICO 3: Distribución por Categoría =====
    const ctx3 = document.getElementById('chartCategorias');
    if (ctx3) {
        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: {!! json_encode($categoriasLabels ?? []) !!},
                datasets: [
                    {
                        label: 'Gastos por Categoría',
                        data: {!! json_encode($categoriasMonto ?? []) !!},
                        backgroundColor: colorPeligro,
                        borderColor: colorPeligro,
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>

<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
    }

    .bg-success { background-color: #28a745 !important; }
    .bg-danger { background-color: #dc3545 !important; }
    .bg-primary { background-color: #007bff !important; }
    .bg-warning { background-color: #ffc107 !important; color: #000 !important; }
</style>
@endsection
