@extends('layouts.app')

@section('title', 'Detalle de Presupuesto')

@section('content')
<!-- Estilos v2.0 - Mejorado fondo oscuro -->
<style>
    body {
        background-color: #1e2836 !important;
    }

    .detail-header {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(245, 158, 11, 0.3);
    }

    .detail-card {
        background-color: #2a3544 !important;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        padding: 2rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid #f59e0b !important;
        border-right: 1px solid #3d4757;
        border-top: 1px solid #3d4757;
        border-bottom: 1px solid #3d4757;
    }

    .detail-card h5 {
        color: #f59e0b !important;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #3d4757;
    }

    .detail-card .card-body {
        background-color: #2a3544 !important;
    }

    .detail-card > * {
        background-color: transparent !important;
    }

    .stat-box {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .stat-box h2 {
        font-size: 3rem;
        font-weight: 700;
        margin: 1rem 0;
    }

    .progress-circular {
        width: 200px;
        height: 200px;
        margin: 0 auto 2rem;
        position: relative;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0;
        border-bottom: 1px solid #3d4757;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #9ca3af !important;
    }

    .info-value {
        font-weight: 700;
        color: #ffffff !important;
    }

    .badge-status {
        padding: 0.5rem 1.5rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 1rem;
    }

    .btn-purple {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-purple:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4);
        color: white;
    }

    .movimiento-item {
        padding: 1rem;
        border-left: 4px solid #f59e0b;
        background: rgba(42, 53, 68, 0.5) !important;
        border-radius: 10px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .movimiento-item:hover {
        background: #3d4757 !important;
        transform: translateX(5px);
    }

    .movimiento-item * {
        color: #ffffff !important;
    }

    /* Textos generales en cards */
    .detail-card p,
    .detail-card span:not(.badge),
    .detail-card small {
        color: #e5e7eb !important;
    }

    /* Ajustar color de texto muted */
    .text-muted {
        color: #9ca3af !important;
    }

    /* Asegurar que los badges se vean bien */
    .badge {
        font-weight: 600;
    }

    /* Estilos para tablas dentro de cards */
    .detail-card .table-responsive {
        background-color: #2a3544 !important;
        border-radius: 10px;
        padding: 0;
        border: 1px solid #3d4757;
        overflow: hidden;
    }

    .detail-card .table {
        color: #ffffff !important;
        background-color: #2a3544 !important;
        margin-bottom: 0 !important;
    }

    .detail-card .table thead {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
    }

    .detail-card .table thead th {
        color: #ffffff !important;
        font-weight: 700 !important;
        border: none !important;
        padding: 1rem !important;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;
        background: transparent !important;
    }

    .detail-card .table tbody {
        background-color: #2a3544 !important;
    }

    .detail-card .table tbody tr {
        border-bottom: 1px solid #3d4757 !important;
        background-color: #2a3544 !important;
    }

    .detail-card .table tbody td {
        color: #ffffff !important;
        border-color: #3d4757 !important;
        padding: 1rem !important;
        vertical-align: middle !important;
        background-color: #2a3544 !important;
    }

    .detail-card .table tbody td strong {
        color: #ffffff !important;
        font-weight: 700 !important;
        font-size: 0.95rem !important;
    }

    .detail-card .table tbody td small {
        color: #9ca3af !important;
        display: block !important;
        margin-top: 0.25rem !important;
    }

    .detail-card .table tbody td i {
        color: #f59e0b !important;
    }

    .detail-card .table-hover tbody tr:hover {
        background-color: #3d4757 !important;
    }

    .detail-card .table-hover tbody tr:hover td {
        background-color: #3d4757 !important;
    }

    .detail-card .table tfoot {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
    }

    .detail-card .table tfoot td,
    .detail-card .table tfoot th {
        color: #ffffff !important;
        font-weight: 700 !important;
        border: none !important;
        padding: 1rem !important;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;
        background: transparent !important;
    }

    /* Asegurar que todos los badges en la tabla se vean */
    .detail-card .table .badge {
        padding: 0.5rem 1rem !important;
        font-size: 0.85rem !important;
        font-weight: 600 !important;
    }

    .table .badge-danger {
        background-color: #dc2626 !important;
        color: #ffffff !important;
    }

    .table .badge-success {
        background-color: #059669 !important;
        color: #ffffff !important;
    }

    .table .badge-info {
        background-color: #0891b2 !important;
        color: #ffffff !important;
    }

    .table .badge-warning {
        background-color: #d97706 !important;
        color: #ffffff !important;
    }

    /* Cambiar colores primary a ámbar */
    .text-primary {
        color: #f59e0b !important;
    }

    .bg-primary {
        background-color: #f59e0b !important;
    }

    .border-primary {
        border-color: #f59e0b !important;
    }

    /* Ajustar colores de iconos y encabezados */
    h5 .text-primary,
    .detail-card h5 i {
        color: #f59e0b !important;
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="detail-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-2">
                    <i class="fas fa-chart-pie me-2"></i>
                    Detalle de Presupuesto
                </h1>
                <p class="mb-0 opacity-75">{{ $presupuesto->categoria }}</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('tesorero.presupuestos.index') }}" class="btn btn-light me-2">
                    <i class="fas fa-arrow-left me-2"></i>
                    Volver
                </a>
                <a href="{{ route('tesorero.presupuestos.edit', $presupuesto->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>
                    Editar
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Columna Izquierda: Estadísticas -->
        <div class="col-lg-4">
            <!-- Presupuesto -->
            <div class="stat-box">
                <i class="fas fa-wallet fa-2x mb-3 opacity-75"></i>
                <p class="mb-1 opacity-75">Presupuesto Mensual</p>
                <h2 class="mb-0">L. {{ number_format($presupuesto->presupuesto_mensual, 2) }}</h2>
            </div>

            <!-- Progreso Circular -->
            <div class="detail-card text-center">
                <h5 class="mb-4 fw-bold">Progreso de Uso</h5>
                <div style="max-width: 200px; margin: 0 auto;">
                    <canvas id="progressChart"></canvas>
                </div>
                <h3 class="mt-4 mb-2 fw-bold {{ $presupuesto->porcentaje_usado >= 90 ? 'text-danger' : ($presupuesto->porcentaje_usado >= 75 ? 'text-warning' : 'text-success') }}">
                    {{ number_format($presupuesto->porcentaje_usado, 1) }}%
                </h3>
                <p class="text-muted mb-0">Porcentaje Utilizado</p>

                <div class="mt-4">
                    @if($presupuesto->porcentaje_usado >= 90)
                        <span class="badge badge-status bg-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Crítico
                        </span>
                    @elseif($presupuesto->porcentaje_usado >= 75)
                        <span class="badge badge-status bg-warning">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Alerta
                        </span>
                    @else
                        <span class="badge badge-status bg-success">
                            <i class="fas fa-check-circle me-2"></i>
                            Normal
                        </span>
                    @endif
                </div>
            </div>

            <!-- Resumen -->
            <div class="detail-card">
                <h5 class="mb-3 fw-bold">
                    <i class="fas fa-chart-line me-2 text-primary"></i>
                    Resumen Financiero
                </h5>
                <div class="info-row">
                    <span class="info-label">Gastado:</span>
                    <span class="info-value text-danger">L. {{ number_format($presupuesto->gasto_real, 2) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Disponible:</span>
                    <span class="info-value {{ $presupuesto->disponible < 0 ? 'text-danger' : 'text-success' }}">
                        L. {{ number_format($presupuesto->disponible, 2) }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Estado:</span>
                    <span class="info-value">
                        @if($presupuesto->activo)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </span>
                </div>
            </div>

            <!-- Acciones -->
            <div class="detail-card">
                <h5 class="mb-3 fw-bold">
                    <i class="fas fa-cog me-2 text-primary"></i>
                    Acciones
                </h5>
                <div class="d-grid gap-2">
                    <button class="btn btn-purple" data-bs-toggle="modal" data-bs-target="#modalDuplicar">
                        <i class="fas fa-copy me-2"></i>
                        Duplicar a otro período
                    </button>
                    <a href="{{ route('tesorero.presupuestos.edit', $presupuesto->id) }}" class="btn btn-outline-primary">
                        <i class="fas fa-edit me-2"></i>
                        Editar Presupuesto
                    </a>
                    <form action="{{ route('tesorero.presupuestos.destroy', $presupuesto->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este presupuesto?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-2"></i>
                            Eliminar Presupuesto
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Detalles y Movimientos -->
        <div class="col-lg-8">
            <!-- Información del Presupuesto -->
            <div class="detail-card">
                <h5 class="mb-3 fw-bold">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    Información del Presupuesto
                </h5>
                <div class="row">
                    <div class="col-md-6">
                        @if(!empty($presupuesto->numero_referencia))
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-hashtag me-2"></i>Referencia:
                            </span>
                            <span class="info-value">
                                <strong class="text-primary">{{ $presupuesto->numero_referencia }}</strong>
                            </span>
                        </div>
                        @endif
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-tag me-2"></i>Categoría:
                            </span>
                            <span class="info-value">{{ $presupuesto->categoria }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-calendar me-2"></i>Mes:
                            </span>
                            <span class="info-value">
                                @if($presupuesto->mes)
                                    {{ DateTime::createFromFormat('!m', $presupuesto->mes)->format('F') }}
                                @else
                                    No especificado
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-calendar-check me-2"></i>Año:
                            </span>
                            <span class="info-value">{{ $presupuesto->anio }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-clock me-2"></i>Creado:
                            </span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($presupuesto->fecha_creacion)->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($presupuesto->fecha_actualizacion)
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-sync me-2"></i>Actualizado:
                            </span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($presupuesto->fecha_actualizacion)->format('d/m/Y H:i') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                @if($presupuesto->descripcion)
                <div class="mt-3 pt-3 border-top">
                    <strong class="d-block mb-2">
                        <i class="fas fa-file-alt me-2"></i>Descripción:
                    </strong>
                    <p class="text-muted mb-0">{{ $presupuesto->descripcion }}</p>
                </div>
                @endif
            </div>

            <!-- MovimientoL.Gastos de esta categoría -->
            <div class="detail-card">
                <h5 class="mb-3 fw-bold">
                    <i class="fas fa-list me-2 text-primary"></i>
                    Movimientos de esta Categoría ({{ $movimientos->count() }})
                </h5>

                @if($movimientos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th class="text-end">Monto</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($movimientos as $mov)
                                <tr>
                                    <td>
                                        <i class="fas fa-calendar me-2 text-muted"></i>
                                        {{ \Carbon\Carbon::parse($mov->fecha)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <strong>{{ $mov->descripcion }}</strong>
                                        @if($mov->proveedor)
                                            <br><small class="text-muted">Proveedor: {{ $mov->proveedor }}</small>
                                        @endif
                                        @if($mov->comprobante)
                                            <br><small class="text-muted">Comprobante: {{ $mov->comprobante }}</small>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <span class="badge bg-danger">
                                            - L. {{ number_format($mov->monto, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($mov->estado == 'pagado')
                                            <span class="badge bg-success">Pagado</span>
                                        @elseif($mov->estado == 'aprobado')
                                            <span class="badge bg-info">Aprobado</span>
                                        @elseif($mov->estado == 'pendiente')
                                            <span class="badge bg-warning">Pendiente</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($mov->estado) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="2">Total Gastado:</td>
                                    <td class="text-end text-danger">L. {{ number_format($presupuesto->gasto_real, 2) }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No hay movimientos registrados para esta categoría en este período</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Duplicar -->
<div class="modal fade" id="modalDuplicar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-copy me-2"></i>
                    Duplicar Presupuesto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('tesorero.presupuestos.duplicar', $presupuesto->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted">Duplica este presupuesto a otro mes y año</p>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mes Destino</label>
                        <select name="mes_destino" class="form-select" required>
                            @foreach(['1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'] as $num => $nombre)
                                <option value="{{ $num }}">{{ $nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Año Destino</label>
                        <select name="anio_destino" class="form-select" required>
                            @for($i = 2020; $i <= 2030; $i++)
                                <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-purple">
                        <i class="fas fa-copy me-2"></i>
                        Duplicar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            confirmButtonColor: '#f59e0b'
        });
    </script>
@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico circular de progreso
    const ctx = document.getElementById('progressChart').getContext('2d');
    const porcentaje = {{ $presupuesto->porcentaje_usado }};
    const restante = Math.max(0, 100 - porcentaje);
    
    let color = '#28a745'; // verde
    if (porcentaje >= 90) {
        color = '#dc3545'; // rojo
    } else if (porcentaje >= 75) {
        color = '#ffc107'; // amarillo
    }

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Usado', 'Disponible'],
            datasets: [{
                data: [Math.min(porcentaje, 100), restante],
                backgroundColor: [color, '#e9ecef'],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed.toFixed(1) + '%';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
