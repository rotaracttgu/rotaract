@extends('modulos.tesorero.layout')

@section('title', 'Detalle de Presupuesto')

@push('styles')
<style>
    /* Fondo claro */
    body {
        background-color: #f8f9fa !important;
    }

    /* Header elegante estilo presupuestos */
    .detail-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 1.5rem 2rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .detail-header-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .detail-header-content h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        color: white;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .detail-header-content p {
        margin: 0.25rem 0 0 0;
        opacity: 0.9;
        font-size: 0.9rem;
        color: white;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.4);
        color: white;
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
    }

    .btn-header {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.4);
        color: white;
        padding: 0.6rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-header:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }

    .btn-header-primary {
        background: white;
        border: 2px solid white;
        color: #2563eb;
    }

    .btn-header-primary:hover {
        background: #f3f4f6;
        color: #1d4ed8;
    }

    /* Stat Box */
    .stat-box {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.25);
    }

    .stat-box p {
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .stat-box h2 {
        font-size: 2.25rem;
        font-weight: 700;
        margin: 0;
        color: white;
    }

    /* Detail Card */
    .detail-card {
        background: white;
        border-radius: 12px;
        padding: 1.75rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        border: 1px solid #e5e7eb;
        border-left: 4px solid #3b82f6;
    }

    .detail-card h5 {
        color: #2563eb;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e5e7eb;
        font-size: 1rem;
    }

    .detail-card h5 i {
        color: #3b82f6;
    }

    /* Info Row */
    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 500;
        color: #6b7280;
    }

    .info-value {
        font-weight: 600;
        color: #1f2937;
    }

    /* Badges */
    .badge-status {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    /* Progress Chart Container */
    .progress-chart-container {
        max-width: 180px;
        margin: 0 auto 1.5rem;
    }

    /* Buttons */
    .btn-action {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
        margin-bottom: 0.75rem;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(59, 130, 246, 0.4);
        color: white;
    }

    .btn-outline-action {
        background: white;
        border: 2px solid #3b82f6;
        color: #3b82f6;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
        margin-bottom: 0.75rem;
    }

    .btn-outline-action:hover {
        background: #3b82f6;
        color: white;
    }

    .btn-outline-danger {
        background: white;
        border: 2px solid #ef4444;
        color: #ef4444;
    }

    .btn-outline-danger:hover {
        background: #ef4444;
        color: white;
    }

    /* Table Styles */
    .detail-card .table-responsive {
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }

    .detail-card .table {
        margin-bottom: 0;
    }

    .detail-card .table thead {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }

    .detail-card .table thead th {
        color: white;
        font-weight: 600;
        border: none;
        padding: 1rem;
    }

    .detail-card .table tbody tr {
        border-bottom: 1px solid #e5e7eb;
    }

    .detail-card .table tbody tr:hover {
        background-color: #f9fafb;
    }

    .detail-card .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: #1f2937;
    }

    .detail-card .table tbody td strong {
        color: #1f2937;
    }

    .detail-card .table tbody td small {
        color: #6b7280;
    }

    .detail-card .table tbody td i {
        color: #3b82f6;
    }

    .detail-card .table tfoot {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }

    .detail-card .table tfoot td {
        color: white;
        font-weight: 600;
        border: none;
        padding: 1rem;
    }

    /* Badges in table */
    .table .badge {
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
        font-weight: 600;
        border-radius: 6px;
    }

    /* Text Colors */
    .text-muted {
        color: #6b7280 !important;
    }

    .text-danger {
        color: #ef4444 !important;
    }

    .text-success {
        color: #10b981 !important;
    }

    .text-warning {
        color: #f59e0b !important;
    }

    .text-primary {
        color: #3b82f6 !important;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem;
    }

    .empty-state i {
        color: #d1d5db;
    }

    .empty-state p {
        color: #6b7280;
    }

    /* Modal */
    .modal-content {
        border-radius: 12px;
        border: none;
    }

    .modal-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border-radius: 12px 12px 0 0;
        padding: 1rem 1.5rem;
    }

    .modal-header .modal-title {
        font-weight: 600;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-body .form-label {
        font-weight: 600;
        color: #374151;
    }

    .modal-body .form-select {
        background-color: #f9fafb;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.75rem 1rem;
    }

    .modal-body .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }

    .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #e5e7eb;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="detail-header">
        <div class="detail-header-content">
            <a href="{{ route('tesorero.presupuestos.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1>
                    <i class="fas fa-chart-pie"></i>
                    Detalle de Presupuesto
                </h1>
                <p>{{ $presupuesto->categoria }}</p>
            </div>
        </div>
        <div class="header-actions">
            @can('finanzas.editar')
            <a href="{{ route('tesorero.presupuestos.edit', $presupuesto->id) }}" class="btn-header">
                <i class="fas fa-edit"></i>
                Editar
            </a>
            @endcan
        </div>
    </div>

    <div class="row">
        <!-- Columna Izquierda: Estadísticas -->
        <div class="col-lg-4">
            <!-- Presupuesto -->
            <div class="stat-box">
                <i class="fas fa-wallet fa-2x mb-2 opacity-75"></i>
                <p class="mb-1">Presupuesto Mensual</p>
                <h2>L. {{ number_format($presupuesto->presupuesto_mensual, 2) }}</h2>
            </div>

            <!-- Progreso Circular -->
            <div class="detail-card text-center">
                <h5 class="mb-4 fw-bold">
                    <i class="fas fa-chart-pie me-2"></i>
                    Progreso de Uso
                </h5>
                <div class="progress-chart-container">
                    <canvas id="progressChart"></canvas>
                </div>
                <h3 class="mt-3 mb-2 fw-bold {{ $presupuesto->porcentaje_usado >= 90 ? 'text-danger' : ($presupuesto->porcentaje_usado >= 75 ? 'text-warning' : 'text-success') }}">
                    {{ number_format($presupuesto->porcentaje_usado, 1) }}%
                </h3>
                <p class="text-muted mb-3">Porcentaje Utilizado</p>

                <div>
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
                    <i class="fas fa-chart-line me-2"></i>
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
                    <i class="fas fa-cog me-2"></i>
                    Acciones
                </h5>
                <div class="d-grid gap-2">
                    @can('finanzas.crear')
                    <button class="btn btn-action" data-bs-toggle="modal" data-bs-target="#modalDuplicar">
                        <i class="fas fa-copy me-2"></i>
                        Duplicar a otro período
                    </button>
                    @endcan
                    @can('finanzas.editar')
                    <a href="{{ route('tesorero.presupuestos.edit', $presupuesto->id) }}" class="btn btn-outline-action">
                        <i class="fas fa-edit me-2"></i>
                        Editar Presupuesto
                    </a>
                    @endcan
                    @can('finanzas.eliminar')
                    <form action="{{ route('tesorero.presupuestos.destroy', $presupuesto->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este presupuesto?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-action btn-outline-danger w-100">
                            <i class="fas fa-trash me-2"></i>
                            Eliminar Presupuesto
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Detalles y Movimientos -->
        <div class="col-lg-8">
            <!-- Información del Presupuesto -->
            <div class="detail-card">
                <h5 class="mb-3 fw-bold">
                    <i class="fas fa-info-circle me-2"></i>
                    Información del Presupuesto
                </h5>
                <div class="row">
                    <div class="col-md-6">
                        @if(!empty($presupuesto->numero_referencia))
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-hashtag me-2"></i>Referencia:
                            </span>
                            <span class="info-value text-primary">
                                <strong>{{ $presupuesto->numero_referencia }}</strong>
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
                    <strong class="d-block mb-2" style="color: #374151;">
                        <i class="fas fa-file-alt me-2 text-primary"></i>Descripción:
                    </strong>
                    <p class="text-muted mb-0">{{ $presupuesto->descripcion }}</p>
                </div>
                @endif
            </div>

            <!-- Movimientos de esta categoría -->
            <div class="detail-card">
                <h5 class="mb-3 fw-bold">
                    <i class="fas fa-list me-2"></i>
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
                                        <i class="fas fa-calendar me-2"></i>
                                        {{ \Carbon\Carbon::parse($mov->fecha)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <strong>{{ $mov->descripcion }}</strong>
                                        @if($mov->proveedor)
                                            <br><small>Proveedor: {{ $mov->proveedor }}</small>
                                        @endif
                                        @if($mov->comprobante)
                                            <br><small>Comprobante: {{ $mov->comprobante }}</small>
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
                                <tr>
                                    <td colspan="2"><strong>Total Gastado:</strong></td>
                                    <td class="text-end"><strong>L. {{ number_format($presupuesto->gasto_real, 2) }}</strong></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p>No hay movimientos registrados para esta categoría en este período</p>
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
                    <button type="submit" class="btn btn-action" style="width: auto;">
                        <i class="fas fa-copy me-2"></i>
                        Duplicar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Gráfico circular de progreso
const ctx = document.getElementById('progressChart').getContext('2d');
const porcentaje = {{ $presupuesto->porcentaje_usado }};
const restante = Math.max(0, 100 - porcentaje);

let color = '#10b981'; // verde
if (porcentaje >= 90) {
    color = '#ef4444'; // rojo
} else if (porcentaje >= 75) {
    color = '#f59e0b'; // amarillo
}

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Usado', 'Disponible'],
        datasets: [{
            data: [Math.min(porcentaje, 100), restante],
            backgroundColor: [color, '#e5e7eb'],
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

@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
        confirmButtonColor: '#3b82f6'
    });
@endif
</script>
@endpush
