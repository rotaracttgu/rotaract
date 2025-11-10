@extends('layouts.app')

@push('styles')
<style>
    body {
        background-color: #1e2836 !important;
    }

    .show-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: white !important;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
    }
    
    h2, h3, h4, h5, h6 {
        color: #e5e7eb !important;
        opacity: 1 !important;
    }
    
    h2.text-success {
        color: #10b981 !important;
    }
    
    .btn-secondary {
        background: #6c757d !important;
        border: none;
        color: white !important;
    }
    
    .btn-secondary:hover {
        background: #5a6268 !important;
        color: white !important;
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        border: none;
        color: white !important;
    }
    
    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(245, 158, 11, 0.4);
        color: white !important;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        border: none;
        color: white !important;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(16, 185, 129, 0.4);
        color: white !important;
    }
    
    .card {
        background-color: #2a3544 !important;
        border: 1px solid #3d4757;
        color: #e5e7eb !important;
        margin-bottom: 1.5rem;
    }
    
    .card-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: #ffffff !important;
        border: none !important;
    }
    
    .card-header h5, .card-header h6 {
        color: #ffffff !important;
        opacity: 1 !important;
    }
    
    .card-body {
        background-color: #2a3544 !important;
    }
    
    .card-body * {
        opacity: 1 !important;
    }
    
    label {
        font-weight: 600;
        color: #9ca3af !important;
        opacity: 1 !important;
    }
    
    p {
        color: #e5e7eb !important;
        opacity: 1 !important;
    }
    
    .text-muted {
        color: #9ca3af !important;
        opacity: 1 !important;
    }
    
    .text-success {
        color: #10b981 !important;
    }
    
    .text-primary {
        color: #06b6d4 !important;
    }
    
    .badge-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: white !important;
    }
    
    .badge-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: white !important;
    }
    
    .badge-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        color: white !important;
    }
    
    .badge-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        color: white !important;
    }
    
    .badge-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
        color: white !important;
    }
    
    .badge {
        opacity: 1 !important;
    }
    
    hr {
        border-color: #3d4757 !important;
        opacity: 0.5;
    }
    
    .alert-success {
        background-color: rgba(16, 185, 129, 0.15) !important;
        border: 1px solid #10b981;
        color: #6ee7b7 !important;
    }
    
    .alert-success * {
        color: #6ee7b7 !important;
    }
    
    .alert-danger {
        background-color: rgba(239, 68, 68, 0.15) !important;
        border: 1px solid #ef4444;
        color: #fca5a5 !important;
    }
    
    .alert-danger * {
        color: #fca5a5 !important;
    }
    
    .bg-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    }
    
    .bg-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
    }
    
    .font-monospace {
        color: #e5e7eb !important;
    }
    
    /* Texto general visible */
    span, label, div, small {
        opacity: 1 !important;
    }
    
    .h4, .h5 {
        color: #e5e7eb !important;
    }
    
    .btn-group .btn {
        opacity: 1 !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header con botones de acción -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-success">
                    <i class="fas fa-file-invoice-dollar"></i> Detalle del Ingreso #{{ $ingreso->id }}
                </h2>
                <div class="btn-group">
                    <a href="{{ route('tesorero.ingresos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <a href="{{ route('tesorero.ingresos.edit', $ingreso->id) }}" class="btn btn-warning text-white">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <button type="button" class="btn btn-primary" onclick="window.print()">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <!-- Información Principal -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow">
                        <div class="card-header bg-success text-white py-3">
                            <h5 class="m-0">
                                <i class="fas fa-info-circle"></i> Información del Ingreso
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-weight-bold text-muted">Concepto:</label>
                                    <p class="h5">{{ $ingreso->concepto ?? $ingreso->descripcion }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold text-muted">Estado:</label>
                                    @php
                                        $estado = $ingreso->estado ?? 'activo';
                                        $badgeClass = [
                                            'confirmado' => 'success',
                                            'activo' => 'success',
                                            'pendiente' => 'warning',
                                            'cancelado' => 'danger'
                                        ][$estado] ?? 'secondary';
                                    @endphp
                                    <p>
                                        <span class="badge badge-{{ $badgeClass }} badge-lg">
                                            {{ ucfirst($estado) }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <hr>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="font-weight-bold text-muted">Tipo de Ingreso:</label>
                                    <p>
                                        <span class="badge badge-info badge-lg">
                                            {{ $ingreso->tipo ?? $ingreso->categoria ?? '-' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold text-muted">Fecha:</label>
                                    <p>
                                        <i class="fas fa-calendar text-primary"></i>
                                        {{ \Carbon\Carbon::parse($ingreso->fecha_ingreso ?? $ingreso->fecha)->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold text-muted">Monto:</label>
                                    <p class="h4 text-success font-weight-bold">
                                        L. {{ number_format($ingreso->monto, 2) }}
                                    </p>
                                </div>
                            </div>

                            <hr>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-weight-bold text-muted">Origen / Fuente:</label>
                                    <p>{{ $ingreso->origen ?? $ingreso->fuente ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold text-muted">Método de Pago:</label>
                                    <p>{{ $ingreso->metodo_recepcion ?? $ingreso->metodo_pago ?? '-' }}</p>
                                </div>
                            </div>

                            @if(isset($ingreso->numero_referencia) && $ingreso->numero_referencia)
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="font-weight-bold text-muted">Número de Referencia:</label>
                                        <p class="font-monospace">{{ $ingreso->numero_referencia }}</p>
                                    </div>
                                </div>
                            @endif

                            @if(isset($ingreso->descripcion) && $ingreso->descripcion || isset($ingreso->notas) && $ingreso->notas)
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="font-weight-bold text-muted">Descripción / Notas:</label>
                                        <p class="text-justify">{{ $ingreso->descripcion ?? $ingreso->notas ?? '-' }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Panel Lateral -->
                <div class="col-lg-4 mb-4">
                    <!-- Comprobante -->
                    @if(isset($ingreso->comprobante) && $ingreso->comprobante || isset($ingreso->comprobante_ruta) && $ingreso->comprobante_ruta)
                        <div class="card shadow mb-4">
                            <div class="card-header bg-info text-white py-3">
                                <h6 class="m-0">
                                    <i class="fas fa-file-alt"></i> Comprobante
                                </h6>
                            </div>
                            <div class="card-body text-center">
                                @php
                                    $comprobante = $ingreso->comprobante ?? $ingreso->comprobante_ruta;
                                    if ($comprobante) {
                                        $extension = pathinfo($comprobante, PATHINFO_EXTENSION);
                                        // Construir la ruta del archivo
                                        $rutaComprobante = asset('storage/' . $comprobante);
                                    } else {
                                        $extension = null;
                                        $rutaComprobante = null;
                                    }
                                @endphp

                                @if($rutaComprobante)
                                    @if($extension && in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                        <img src="{{ $rutaComprobante }}" 
                                             class="img-fluid mb-3" 
                                             alt="Comprobante"
                                             style="max-height: 300px;">
                                    @else
                                        <i class="fas fa-file-pdf fa-5x text-danger mb-3"></i>
                                    @endif

                                    <a href="{{ $rutaComprobante }}" 
                                       target="_blank" 
                                       class="btn btn-info btn-block">
                                        <i class="fas fa-download"></i> Ver / Descargar
                                    </a>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i> 
                                        No se adjuntó comprobante
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Información de Auditoría -->
                    <div class="card shadow">
                        <div class="card-header bg-secondary text-white py-3">
                            <h6 class="m-0">
                                <i class="fas fa-history"></i> Auditoría
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="font-weight-bold text-muted small">ID del Registro:</label>
                                <p class="mb-0">#{{ $ingreso->id }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="font-weight-bold text-muted small">Creado:</label>
                                <p class="mb-0">
                                    <i class="fas fa-clock text-primary"></i>
                                    {{ \Carbon\Carbon::parse($ingreso->created_at)->format('d/m/Y H:i') }}
                                </p>
                                <small class="text-muted">
                                    ({{ \Carbon\Carbon::parse($ingreso->created_at)->diffForHumans() }})
                                </small>
                            </div>

                            @if(isset($ingreso->updated_at) && $ingreso->updated_at != $ingreso->created_at)
                                <div class="mb-3">
                                    <label class="font-weight-bold text-muted small">Última Actualización:</label>
                                    <p class="mb-0">
                                        <i class="fas fa-clock text-warning"></i>
                                        {{ \Carbon\Carbon::parse($ingreso->updated_at)->format('d/m/Y H:i') }}
                                    </p>
                                    <small class="text-muted">
                                        ({{ \Carbon\Carbon::parse($ingreso->updated_at)->diffForHumans() }})
                                    </small>
                                </div>
                            @endif

                            @if(isset($ingreso->usuario_id))
                                <div class="mb-0">
                                    <label class="font-weight-bold text-muted small">Usuario:</label>
                                    <p class="mb-0">
                                        <i class="fas fa-user text-info"></i>
                                        Usuario #{{ $ingreso->usuario_id }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones Adicionales -->
            <div class="card shadow">
                <div class="card-header bg-light py-3">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-cogs"></i> Acciones Disponibles
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('tesorero.ingresos.edit', $ingreso->id) }}" class="btn btn-warning btn-block">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary btn-block" onclick="window.print()">
                                <i class="fas fa-print"></i> Imprimir
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-info btn-block" onclick="exportToPDF()">
                                <i class="fas fa-file-pdf"></i> Exportar PDF
                            </button>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('tesorero.ingresos.destroy', $ingreso->id) }}" 
                                  method="POST"
                                  id="deleteFormShow">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-block btn-delete-ingreso-show"
                                        data-concepto="{{ $ingreso->concepto }}"
                                        data-monto="{{ number_format($ingreso->monto, 2) }}">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        .btn-group, .card-header, nav, footer {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }
    
    .badge-lg {
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }
</style>
@endpush

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function exportToPDF() {
        alert('Funcionalidad de exportación PDF próximamente disponible');
        // Aquí puedes implementar la lógica para exportar a PDF
    }

    // SweetAlert para eliminar ingreso
    document.addEventListener('DOMContentLoaded', function() {
        const btnDelete = document.querySelector('.btn-delete-ingreso-show');
        if (btnDelete) {
            btnDelete.addEventListener('click', function(e) {
                e.preventDefault();
                const concepto = this.getAttribute('data-concepto');
                const monto = this.getAttribute('data-monto');

                Swal.fire({
                    title: '¿Eliminar este ingreso?',
                    html: `
                        <div class="text-start">
                            <p><strong>Concepto:</strong> ${concepto}</p>
                            <p><strong>Monto:</strong> L. ${monto}</p>
                            <p class="text-danger mt-3">Esta acción no se puede deshacer.</p>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: '<i class="fas fa-trash me-2"></i>Sí, eliminar',
                    cancelButtonText: '<i class="fas fa-times me-2"></i>Cancelar',
                    reverseButtons: true,
                    customClass: {
                        popup: 'swal-dark',
                        title: 'swal-title',
                        htmlContainer: 'swal-text'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('deleteFormShow').submit();
                    }
                });
            });
        }
    });
</script>
@endpush
@endsection
