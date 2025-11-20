@extends('layouts.app')

@push('styles')
<style>
    .show-header {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 40px rgba(239, 68, 68, 0.2);
        color: white;
    }

    .show-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }

    .info-card {
        background: white;
        border-radius: 12px;
        padding: 0;
        margin-bottom: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid #E2E8F0;
        overflow: hidden;
    }

    .info-card-header {
        background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%);
        padding: 1rem 1.5rem;
        border-bottom: 2px solid #ef4444;
        font-weight: 700;
        font-size: 1rem;
        color: #1E293B;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-card-header i {
        color: #ef4444;
    }

    .info-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #F1F5F9;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .info-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 0.95rem;
        color: #1E293B;
        font-weight: 500;
    }

    .info-value.amount {
        font-size: 1.5rem;
        font-weight: 700;
        color: #ef4444;
    }

    .badge {
        padding: 0.4rem 0.8rem;
        border-radius: 100px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .badge-aprobado {
        background: #DCFCE7;
        color: #166534;
    }

    .badge-pendiente {
        background: #FEF3C7;
        color: #92400E;
    }

    .badge-rechazado {
        background: #FEE2E2;
        color: #991B1B;
    }

    .badge-prioridad-alta {
        background: #FED7AA;
        color: #9A3412;
    }

    .badge-prioridad-urgente {
        background: #FEE2E2;
        color: #991B1B;
    }

    .btn-action-group {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-modern {
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        text-decoration: none;
    }

    .btn-back {
        background: #E2E8F0;
        color: #64748B;
    }

    .btn-back:hover {
        background: #CBD5E1;
        color: #1E293B;
    }

    .btn-edit {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(245, 158, 11, 0.3);
    }

    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(239, 68, 68, 0.3);
    }

    .btn-print {
        background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
        color: white;
    }

    .btn-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(59, 130, 246, 0.3);
    }

    @media print {
        .btn-action-group, .show-header, nav, footer {
            display: none !important;
        }
        .info-card {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>
@endpush

@section('content')
<div style="background: #F8FAFC; min-height: 100vh; padding: 1.5rem;">
    <!-- Header -->
    <div class="show-header">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <h1><i class="fas fa-file-invoice-dollar me-2"></i>Detalle del Gasto #{{ $gasto->id }}</h1>
            <div class="btn-action-group">
                <a href="{{ route('tesorero.gastos.index') }}" class="btn-modern btn-back">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                @can('finanzas.editar')
                <a href="{{ route('tesorero.gastos.edit', $gasto->id) }}" class="btn-modern btn-edit">
                    <i class="fas fa-edit"></i> Editar
                </a>
                @endcan
                @can('finanzas.exportar')
                <button onclick="window.print()" class="btn-modern btn-print">
                    <i class="fas fa-print"></i> Imprimir
                </button>
                @endcan
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Información del Gasto -->
    <div class="info-card">
        <div class="info-card-header">
            <i class="fas fa-info-circle"></i> Información del Gasto
        </div>
        
        <div class="info-row">
            <div class="info-item">
                <span class="info-label">Descripción / Concepto</span>
                <span class="info-value">{{ $gasto->descripcion ?? $gasto->concepto }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Estado</span>
                <span class="info-value">
                    @php
                        $estado = $gasto->estado_aprobacion ?? $gasto->estado ?? 'pendiente';
                        $badgeClass = match($estado) {
                            'aprobado', 'activo' => 'badge-aprobado',
                            'pendiente' => 'badge-pendiente',
                            default => 'badge-rechazado'
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ ucfirst($estado) }}</span>
                </span>
            </div>
        </div>

        <div class="info-row">
            <div class="info-item">
                <span class="info-label">Categoría</span>
                <span class="info-value">{{ $gasto->categoria ?? $gasto->tipo ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Fecha del Gasto</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($gasto->fecha_gasto ?? $gasto->fecha)->format('d/m/Y') }}</span>
            </div>
        </div>

        <div class="info-row">
            <div class="info-item">
                <span class="info-label">Monto</span>
                <span class="info-value amount">L. {{ number_format($gasto->monto, 2) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Proveedor / Beneficiario</span>
                <span class="info-value">{{ $gasto->proveedor ?? '-' }}</span>
            </div>
        </div>

        <div class="info-row">
            <div class="info-item">
                <span class="info-label">Método de Pago</span>
                <span class="info-value">{{ ucfirst(str_replace('_', ' ', $gasto->metodo_pago ?? '-')) }}</span>
            </div>
            @if(isset($gasto->numero_factura) && $gasto->numero_factura)
            <div class="info-item">
                <span class="info-label">Número de Factura</span>
                <span class="info-value">{{ $gasto->numero_factura }}</span>
            </div>
            @endif
        </div>

        @if(isset($gasto->prioridad) && $gasto->prioridad)
        <div class="info-row">
            <div class="info-item">
                <span class="info-label">Prioridad</span>
                <span class="info-value">
                    @php
                        $prioBadge = match($gasto->prioridad) {
                            'Alta', 'alta' => 'badge-prioridad-alta',
                            'Urgente', 'urgente' => 'badge-prioridad-urgente',
                            default => 'badge-pendiente'
                        };
                    @endphp
                    <span class="badge {{ $prioBadge }}">{{ $gasto->prioridad }}</span>
                </span>
            </div>
        </div>
        @endif

        @if(isset($gasto->notas) && $gasto->notas)
        <div class="info-row">
            <div class="info-item" style="grid-column: 1 / -1;">
                <span class="info-label">Notas / Observaciones</span>
                <span class="info-value">{{ $gasto->notas }}</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Comprobante (si existe) -->
    @if((isset($gasto->comprobante) && $gasto->comprobante) || (isset($gasto->comprobante_ruta) && $gasto->comprobante_ruta))
    <div class="info-card">
        <div class="info-card-header">
            <i class="fas fa-file-alt"></i> Comprobante
        </div>
        <div style="text-align: center; padding: 1rem;">
            @php
                $comprobante = $gasto->comprobante ?? $gasto->comprobante_ruta;
                $extension = pathinfo($comprobante, PATHINFO_EXTENSION);
                $rutaComprobante = asset('storage/' . $comprobante);
            @endphp

            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
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
                <span class="info-value">#{{ $gasto->id }}</span>
            </div>
            @if(isset($gasto->created_at))
            <div class="info-item">
                <span class="info-label">Creado</span>
                <span class="info-value">
                    <i class="fas fa-calendar me-1" style="color: #ef4444;"></i>
                    {{ \Carbon\Carbon::parse($gasto->created_at)->format('d/m/Y H:i') }}
                    <small style="color: #64748B; font-size: 0.75rem; display: block;">({{ \Carbon\Carbon::parse($gasto->created_at)->diffForHumans() }})</small>
                </span>
            </div>
            @endif
        </div>

        @if(isset($gasto->updated_at) && $gasto->updated_at != $gasto->created_at)
        <div class="info-row">
            <div class="info-item">
                <span class="info-label">Última Actualización</span>
                <span class="info-value">
                    <i class="fas fa-clock me-1" style="color: #f59e0b;"></i>
                    {{ \Carbon\Carbon::parse($gasto->updated_at)->format('d/m/Y H:i') }}
                    <small style="color: #64748B; font-size: 0.75rem; display: block;">({{ \Carbon\Carbon::parse($gasto->updated_at)->diffForHumans() }})</small>
                </span>
            </div>
        </div>
        @endif
    </div>

    <!-- Acciones Disponibles -->
    <div class="info-card">
        <div class="info-card-header">
            <i class="fas fa-cogs"></i> Acciones Disponibles
        </div>
        
        <div class="btn-action-group" style="padding: 1rem;">
            @can('finanzas.editar')
            <a href="{{ route('tesorero.gastos.edit', $gasto->id) }}" class="btn-modern btn-edit">
                <i class="fas fa-edit"></i> Editar
            </a>
            @endcan
            @can('finanzas.exportar')
            <button onclick="window.print()" class="btn-modern btn-print">
                <i class="fas fa-print"></i> Imprimir
            </button>
            @endcan
            @can('finanzas.eliminar')
            <button type="button" class="btn-modern btn-delete btn-delete-gasto"
                    data-descripcion="{{ $gasto->descripcion ?? $gasto->concepto }}"
                    data-monto="{{ number_format($gasto->monto, 2) }}">
                <i class="fas fa-trash"></i> Eliminar
            </button>
            @endcan
        </div>
    </div>
</div>

<!-- Form oculto para eliminación -->
<form action="{{ route('tesorero.gastos.destroy', $gasto->id) }}" 
      method="POST"
      id="deleteFormShow"
      style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // SweetAlert para eliminar gasto
    document.addEventListener('DOMContentLoaded', function() {
        const btnDelete = document.querySelector('.btn-delete-gasto');
        if (btnDelete) {
            btnDelete.addEventListener('click', function(e) {
                e.preventDefault();
                const descripcion = this.getAttribute('data-descripcion');
                const monto = this.getAttribute('data-monto');

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
