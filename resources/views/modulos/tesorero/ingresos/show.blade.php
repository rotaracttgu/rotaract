@extends('layouts.app')

@push('styles')
<style>
    .show-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
    }
    
    .show-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }

    .info-card {
        background: white;
        border-radius: 12px;
        padding: 1.2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid #E2E8F0;
    }

    .info-card-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 0.8rem 1rem;
        border-radius: 8px 8px 0 0;
        margin: -1.2rem -1.2rem 1rem -1.2rem;
        font-weight: 700;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.2rem;
        margin-bottom: 0.8rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.3rem;
    }

    .info-value {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1E293B;
    }

    .info-value.amount {
        font-size: 1.3rem;
        font-weight: 700;
        color: #10b981;
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

    /* Print styles */
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

@section('content')
<div style="background: #F8FAFC; min-height: 100vh; padding: 1.5rem;">
    <!-- Header -->
    <div class="show-header">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <h1><i class="fas fa-file-invoice-dollar me-2"></i>Detalle del Ingreso #{{ $ingreso->id }}</h1>
            <div class="btn-action-group">
                <a href="{{ route('tesorero.ingresos.index') }}" class="btn-modern btn-back">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <a href="{{ route('tesorero.ingresos.edit', $ingreso->id) }}" class="btn-modern btn-edit">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <button onclick="window.print()" class="btn-modern btn-print">
                    <i class="fas fa-print"></i> Imprimir
                </button>
            </div>
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

    <!-- Información del Ingreso -->
    <div class="info-card">
        <div class="info-card-header">
            <i class="fas fa-info-circle"></i> Información del Ingreso
        </div>
        
        <div class="info-row">
            <div class="info-item">
                <span class="info-label">Concepto</span>
                <span class="info-value">{{ $ingreso->concepto ?? $ingreso->descripcion }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Estado</span>
                <span class="info-value">
                    @php
                        $estado = $ingreso->estado ?? 'pendiente';
                        $badgeClass = match($estado) {
                            'confirmado', 'activo' => 'badge-confirmado',
                            'pendiente' => 'badge-pendiente',
                            default => 'badge-cancelado'
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ ucfirst($estado) }}</span>
                </span>
            </div>
        </div>

        <div class="info-row">
            <div class="info-item">
                <span class="info-label">Tipo de Ingreso</span>
                <span class="info-value">{{ $ingreso->tipo ?? $ingreso->categoria ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Fecha</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($ingreso->fecha_ingreso ?? $ingreso->fecha)->format('d/m/Y') }}</span>
            </div>
        </div>

        <div class="info-row">
            <div class="info-item">
                <span class="info-label">Monto</span>
                <span class="info-value amount">L. {{ number_format($ingreso->monto, 2) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Origen / Fuente</span>
                <span class="info-value">{{ $ingreso->origen ?? $ingreso->fuente ?? '-' }}</span>
            </div>
        </div>

        <div class="info-row">
            <div class="info-item">
                <span class="info-label">Método de Pago</span>
                <span class="info-value">{{ ucfirst(str_replace('_', ' ', $ingreso->metodo_recepcion ?? $ingreso->metodo_pago ?? '-')) }}</span>
            </div>
            @if(isset($ingreso->numero_referencia) && $ingreso->numero_referencia)
            <div class="info-item">
                <span class="info-label">Número de Referencia</span>
                <span class="info-value">{{ $ingreso->numero_referencia }}</span>
            </div>
            @endif
        </div>

        @if((isset($ingreso->descripcion) && $ingreso->descripcion) || (isset($ingreso->notas) && $ingreso->notas))
        <div class="info-row">
            <div class="info-item" style="grid-column: 1 / -1;">
                <span class="info-label">Descripción / Notas</span>
                <span class="info-value">{{ $ingreso->descripcion ?? $ingreso->notas ?? '-' }}</span>
            </div>
        </div>
        @endif
    </div>


    <!-- Comprobante (si existe) -->
    @if((isset($ingreso->comprobante) && $ingreso->comprobante) || (isset($ingreso->comprobante_ruta) && $ingreso->comprobante_ruta))
    <div class="info-card">
        <div class="info-card-header">
            <i class="fas fa-file-alt"></i> Comprobante
        </div>
        <div style="text-align: center; padding: 1rem;">
            @php
                $comprobante = $ingreso->comprobante ?? $ingreso->comprobante_ruta;
                if ($comprobante) {
                    $extension = pathinfo($comprobante, PATHINFO_EXTENSION);
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
                         style="max-height: 300px; border-radius: 8px;">
                @else
                    <i class="fas fa-file-pdf fa-5x mb-3" style="color: #ef4444;"></i>
                @endif

                <a href="{{ $rutaComprobante }}" 
                   target="_blank" 
                   class="btn-modern btn-print"
                   style="display: inline-flex; margin-top: 1rem;">
                    <i class="fas fa-download"></i> Ver / Descargar
                </a>
            @else
                <div style="background: #FEF3C7; border: 1px solid #f59e0b; padding: 0.8rem; border-radius: 8px; color: #92400E;">
                    <i class="fas fa-exclamation-triangle"></i> 
                    No se adjuntó comprobante
                </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Auditoría -->
    <div class="info-card">
        <div class="info-card-header">
            <i class="fas fa-history"></i> Auditoría
        </div>
        
        <div class="info-row">
            <div class="info-item">
                <span class="info-label">ID del Registro</span>
                <span class="info-value">#{{ $ingreso->id }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Creado</span>
                <span class="info-value">
                    <i class="fas fa-calendar me-1" style="color: #10b981;"></i>
                    {{ \Carbon\Carbon::parse($ingreso->created_at)->format('d/m/Y H:i') }}
                    <small style="color: #64748B; font-size: 0.75rem; display: block;">({{ \Carbon\Carbon::parse($ingreso->created_at)->diffForHumans() }})</small>
                </span>
            </div>
        </div>

        @if(isset($ingreso->updated_at) && $ingreso->updated_at != $ingreso->created_at)
        <div class="info-row">
            <div class="info-item">
                <span class="info-label">Última Actualización</span>
                <span class="info-value">
                    <i class="fas fa-clock me-1" style="color: #f59e0b;"></i>
                    {{ \Carbon\Carbon::parse($ingreso->updated_at)->format('d/m/Y H:i') }}
                    <small style="color: #64748B; font-size: 0.75rem; display: block;">({{ \Carbon\Carbon::parse($ingreso->updated_at)->diffForHumans() }})</small>
                </span>
            </div>
            @if(isset($ingreso->usuario_id))
            <div class="info-item">
                <span class="info-label">Usuario</span>
                <span class="info-value">
                    <i class="fas fa-user me-1" style="color: #3B82F6;"></i>
                    Usuario #{{ $ingreso->usuario_id }}
                </span>
            </div>
            @endif
        </div>
        @endif
    </div>

    <!-- Acciones Disponibles -->
    <div class="info-card">
        <div class="info-card-header">
            <i class="fas fa-cogs"></i> Acciones Disponibles
        </div>
        
        <div class="btn-action-group" style="padding: 1rem;">
            <a href="{{ route('tesorero.ingresos.edit', $ingreso->id) }}" class="btn-modern btn-edit">
                <i class="fas fa-edit"></i> Editar
            </a>
            <button onclick="window.print()" class="btn-modern btn-print">
                <i class="fas fa-print"></i> Imprimir
            </button>
            <button type="button" class="btn-modern btn-delete btn-delete-ingreso-show"
                    data-concepto="{{ $ingreso->concepto }}"
                    data-monto="{{ number_format($ingreso->monto, 2) }}">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </div>
    </div>
</div>

<!-- Form oculto para eliminación -->
<form action="{{ route('tesorero.ingresos.destroy', $ingreso->id) }}" 
      method="POST"
      id="deleteFormShow"
      style="display: none;">
    @csrf
    @method('DELETE')

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
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
                    reverseButtons: true
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