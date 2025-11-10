@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #2c3e50; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header con botones -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-white">
                    <i class="fas fa-file-invoice-dollar text-danger"></i> Detalle del Gasto #{{ $gasto->id }}
                </h2>
                <div class="btn-group">
                    <a href="{{ route('tesorero.gastos.index') }}" class="btn" style="background-color: #7f8c8d; color: white; border: none;">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <a href="{{ route('tesorero.gastos.edit', $gasto->id) }}" class="btn" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; border: none;">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <button type="button" class="btn" style="background-color: #3498db; color: white; border: none;" onclick="window.print()">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-dismissible fade show" role="alert" style="background-color: #27ae60; border: none; color: white;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-dismissible fade show" role="alert" style="background-color: #e74c3c; border: none; color: white;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- Información Principal -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow" style="background-color: #34495e; border: none;">
                        <div class="card-header py-3" style="background-color: #2c3e50; border-bottom: 2px solid #e74c3c;">
                            <h5 class="mb-0 text-white">
                                <i class="fas fa-info-circle me-2"></i> Información del Gasto
                            </h5>
                        </div>
                        <div class="card-body" style="background-color: #34495e;">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="fw-bold text-light">Descripción:</label>
                                    <p class="h5 text-white">{{ $gasto->descripcion ?? $gasto->concepto }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold text-light">Estado:</label>
                                    @php
                                        $estado = $gasto->estado_aprobacion ?? $gasto->estado ?? 'pendiente';
                                        $badgeClass = [
                                            'pendiente' => 'warning',
                                            'aprobado' => 'success',
                                            'activo' => 'success',
                                            'rechazado' => 'danger'
                                        ][$estado] ?? 'secondary';
                                    @endphp
                                    <p>
                                        <span class="badge bg-{{ $badgeClass }} badge-lg fs-6 px-3 py-2">
                                            {{ ucfirst($estado) }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <hr style="border-color: #4a5f7f;">

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="fw-bold text-light">Categoría:</label>
                                    <p>
                                        <span class="badge bg-secondary badge-lg fs-6 px-3 py-2">
                                            {{ $gasto->categoria ?? $gasto->tipo ?? '-' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <label class="fw-bold text-light">Fecha:</label>
                                    <p class="text-white">
                                        <i class="fas fa-calendar text-info"></i>
                                        {{ \Carbon\Carbon::parse($gasto->fecha_gasto ?? $gasto->fecha)->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <label class="fw-bold text-light">Monto:</label>
                                    <p class="h4 text-danger fw-bold">
                                        L. {{ number_format($gasto->monto, 2) }}
                                    </p>
                                </div>
                            </div>

                            <hr style="border-color: #4a5f7f;">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="fw-bold text-light">Proveedor:</label>
                                    <p class="text-white">{{ $gasto->proveedor ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-bold text-light">Método de Pago:</label>
                                    <p class="text-white">{{ $gasto->metodo_pago ?? '-' }}</p>
                                </div>
                            </div>

                            @if(isset($gasto->numero_factura) && $gasto->numero_factura)
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="fw-bold text-light">Número de Factura:</label>
                                        <p class="font-monospace text-white">{{ $gasto->numero_factura }}</p>
                                    </div>
                                    @if(isset($gasto->prioridad) && $gasto->prioridad)
                                        <div class="col-md-6">
                                            <label class="fw-bold text-light">Prioridad:</label>
                                            <p>
                                                @php
                                                    $prioColor = [
                                                        'Baja' => 'info',
                                                        'Media' => 'warning',
                                                        'Alta' => 'orange',
                                                        'Urgente' => 'danger'
                                                    ][$gasto->prioridad] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $prioColor }}">{{ $gasto->prioridad }}</span>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            @if(isset($gasto->notas) && $gasto->notas)
                                <hr style="border-color: #4a5f7f;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="fw-bold text-light">Notas / Observaciones:</label>
                                        <p class="text-white text-justify">{{ $gasto->notas }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Panel Lateral -->
                <div class="col-lg-4 mb-4">
                    <!-- Comprobante -->
                    @if(isset($gasto->comprobante) && $gasto->comprobante || isset($gasto->comprobante_ruta) && $gasto->comprobante_ruta)
                        <div class="card shadow mb-4" style="background-color: #34495e; border: none;">
                            <div class="card-header py-3" style="background-color: #2c3e50; border-bottom: 2px solid #3498db;">
                                <h6 class="mb-0 text-white">
                                    <i class="fas fa-file-alt"></i> Comprobante
                                </h6>
                            </div>
                            <div class="card-body text-center" style="background-color: #34495e;">
                                @php
                                    $comprobante = $gasto->comprobante ?? $gasto->comprobante_ruta;
                                    $extension = pathinfo($comprobante, PATHINFO_EXTENSION);
                                @endphp

                                @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                    <img src="{{ asset('storage/' . $comprobante) }}" 
                                         class="img-fluid mb-3" 
                                         alt="Comprobante"
                                         style="max-height: 300px; border-radius: 8px;">
                                @else
                                    <i class="fas fa-file-pdf fa-5x text-danger mb-3"></i>
                                @endif

                                <a href="{{ asset('storage/' . $comprobante) }}" 
                                   target="_blank" 
                                   class="btn w-100"
                                   style="background-color: #3498db; color: white; border: none;">
                                    <i class="fas fa-download"></i> Ver / Descargar
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Auditoría -->
                    <div class="card shadow" style="background-color: #34495e; border: none;">
                        <div class="card-header py-3" style="background-color: #2c3e50; border-bottom: 2px solid #95a5a6;">
                            <h6 class="mb-0 text-white">
                                <i class="fas fa-history"></i> Auditoría
                            </h6>
                        </div>
                        <div class="card-body" style="background-color: #34495e;">
                            <div class="mb-3">
                                <label class="fw-bold text-light small">ID del Registro:</label>
                                <p class="mb-0 text-white">#{{ $gasto->id }}</p>
                            </div>

                            @if(isset($gasto->created_at))
                                <div class="mb-3">
                                    <label class="fw-bold text-light small">Creado:</label>
                                    <p class="mb-0 text-white">
                                        <i class="fas fa-clock text-info"></i>
                                        {{ \Carbon\Carbon::parse($gasto->created_at)->format('d/m/Y H:i') }}
                                    </p>
                                    <small class="text-light">
                                        ({{ \Carbon\Carbon::parse($gasto->created_at)->diffForHumans() }})
                                    </small>
                                </div>
                            @endif

                            @if(isset($gasto->updated_at) && isset($gasto->created_at) && $gasto->updated_at != $gasto->created_at)
                                <div class="mb-3">
                                    <label class="fw-bold text-light small">Última Actualización:</label>
                                    <p class="mb-0 text-white">
                                        <i class="fas fa-clock text-warning"></i>
                                        {{ \Carbon\Carbon::parse($gasto->updated_at)->format('d/m/Y H:i') }}
                                    </p>
                                    <small class="text-light">
                                        ({{ \Carbon\Carbon::parse($gasto->updated_at)->diffForHumans() }})
                                    </small>
                                </div>
                            @endif

                            @if(isset($gasto->usuario_id))
                                <div class="mb-0">
                                    <label class="fw-bold text-light small">Usuario:</label>
                                    <p class="mb-0 text-white">
                                        <i class="fas fa-user text-info"></i>
                                        Usuario #{{ $gasto->usuario_id }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones -->
            <div class="card shadow" style="background-color: #34495e; border: none;">
                <div class="card-header py-3" style="background-color: #2c3e50; border-bottom: 2px solid #4a5f7f;">
                    <h6 class="mb-0 fw-bold text-white">
                        <i class="fas fa-cogs"></i> Acciones Disponibles
                    </h6>
                </div>
                <div class="card-body" style="background-color: #34495e;">
                    <div class="row">
                        <div class="col-md-3 mb-2 mb-md-0">
                            <a href="{{ route('tesorero.gastos.edit', $gasto->id) }}" class="btn w-100" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; border: none;">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        </div>
                        <div class="col-md-3 mb-2 mb-md-0">
                            <button type="button" class="btn w-100" style="background-color: #3498db; color: white; border: none;" onclick="window.print()">
                                <i class="fas fa-print"></i> Imprimir
                            </button>
                        </div>
                        <div class="col-md-3 mb-2 mb-md-0">
                            <button type="button" class="btn w-100" style="background-color: #9b59b6; color: white; border: none;" onclick="exportToPDF()">
                                <i class="fas fa-file-pdf"></i> Exportar PDF
                            </button>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('tesorero.gastos.destroy', $gasto->id) }}" 
                                  method="POST" 
                                  id="delete-form-{{ $gasto->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        onclick="confirmarEliminacion('{{ $gasto->descripcion }}', '{{ number_format($gasto->monto, 2) }}')"
                                        class="btn w-100"
                                        style="background-color: #e74c3c; color: white; border: none;">
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
    function confirmarEliminacion(descripcion, monto) {
        Swal.fire({
            title: '¿Eliminar este gasto?',
            html: `
                <div class="text-start">
                    <p><strong>Descripción:</strong> ${descripcion}</p>
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
                document.getElementById('delete-form-{{ $gasto->id }}').submit();
            }
        });
    }

    function exportToPDF() {
        alert('Funcionalidad de exportación PDF próximamente disponible');
    }
</script>
@endpush
@endsection
