@extends('layouts.app')

@section('title', 'Detalle de Transferencia')

@push('styles')
<style>
    body {
        background-color: #1e2836 !important;
    }

    .show-header {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        color: white !important;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(6, 182, 212, 0.3);
    }
    
    .show-header h1, .show-header h2, .show-header p {
        color: #ffffff !important;
        opacity: 1 !important;
    }
    
    .show-header .btn-light {
        background: rgba(255,255,255,0.2) !important;
        border: none;
        color: #ffffff !important;
    }
    
    .show-header .btn-light:hover {
        background: rgba(255,255,255,0.3) !important;
        color: #ffffff !important;
    }
    
    .detail-card {
        background: #2a3544 !important;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        border-left: 4px solid #06b6d4;
    }
    
    .detail-card h5 {
        color: #06b6d4 !important;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #3d4757;
        opacity: 1 !important;
    }
    
    .detail-row {
        display: flex;
        padding: 1rem 0;
        border-bottom: 1px solid #3d4757;
    }
    
    .detail-row:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        font-weight: 600;
        color: #9ca3af !important;
        width: 200px;
        flex-shrink: 0;
        opacity: 1 !important;
    }
    
    .detail-value {
        color: #ffffff !important;
        flex-grow: 1;
        opacity: 1 !important;
        font-weight: 600;
    }
    
    .transfer-flow {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        color: white !important;
        padding: 2rem;
        border-radius: 12px;
        text-align: center;
        margin: 2rem 0;
    }
    
    .transfer-flow * {
        color: #ffffff !important;
        opacity: 1 !important;
    }
    
    .transfer-flow .cuenta-box {
        background: rgba(255, 255, 255, 0.2) !important;
        padding: 1.5rem;
        border-radius: 8px;
        backdrop-filter: blur(10px);
    }
    
    .transfer-flow .arrow {
        font-size: 3rem;
        margin: 0 1rem;
        color: #ffffff !important;
    }
    
    .badge-entrada {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%) !important;
        color: white !important;
    }
    
    .badge-salida {
        background: linear-gradient(135deg, #ef4444 0%, #f87171 100%) !important;
        color: white !important;
    }
    
    .badge-interna {
        background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%) !important;
        color: white !important;
    }
    
    .badge-externa {
        background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%) !important;
        color: white !important;
    }
    
    .badge-ajuste {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        color: white !important;
    }
    
    .badge {
        opacity: 1 !important;
    }
    
    .amount-box {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        color: white !important;
        padding: 2rem;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 8px 20px rgba(6, 182, 212, 0.3);
    }
    
    .amount-box * {
        color: #ffffff !important;
        opacity: 1 !important;
    }
    
    .amount-box .amount {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 1rem 0;
    }
    
    .comprobante-preview {
        max-width: 100%;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        border: 2px solid #3d4757;
    }
    
    .btn-action {
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-back {
        background: #6c757d !important;
        color: white !important;
        border: none;
    }
    
    .btn-back:hover {
        background: #5a6268 !important;
        transform: translateY(-2px);
        color: white !important;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%) !important;
        color: white !important;
        border: none;
    }
    
    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(245, 158, 11, 0.4);
        color: white !important;
    }
    
    .btn-print {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        color: white !important;
        border: none;
    }
    
    .btn-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(6, 182, 212, 0.4);
        color: white !important;
    }
    
    .metadata-box {
        background: rgba(42, 53, 68, 0.8) !important;
        padding: 1rem;
        border-radius: 8px;
        margin-top: 2rem;
        border: 1px solid #3d4757;
    }
    
    .metadata-box small {
        color: #9ca3af !important;
        opacity: 1 !important;
    }
    
    /* Breadcrumb oscuro */
    .breadcrumb {
        background-color: #2a3544 !important;
        padding: 0.75rem 1rem;
        border-radius: 8px;
    }
    
    .breadcrumb-item, .breadcrumb-item a {
        color: #e5e7eb !important;
        opacity: 1 !important;
    }
    
    .breadcrumb-item.active {
        color: #06b6d4 !important;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        color: #9ca3af !important;
    }
    
    /* Texto general visible */
    p, span, label, div, small, h1, h2, h3, h4, h5, h6 {
        opacity: 1 !important;
    }
    
    .text-muted {
        color: #9ca3af !important;
        opacity: 1 !important;
    }
    
    /* Card oscura */
    .card {
        background-color: #2a3544 !important;
        border: 1px solid #3d4757;
        color: #e5e7eb !important;
    }
    
    .card-body * {
        color: #e5e7eb !important;
    }
    
    /* Alert oscuro */
    .alert {
        background-color: #2a3544 !important;
        border: 1px solid #3d4757;
        color: #e5e7eb !important;
    }
    
    .alert * {
        color: #e5e7eb !important;
    }

    /* ========================================
       ESTILOS DE IMPRESIÓN - COMPACTO 1 PÁGINA
       ======================================== */
    @media print {
        /* Ocultar elementos innecesarios */
        .show-header .btn-light,
        .btn-print,
        .btn-edit,
        .btn-delete,
        .btn-back,
        .btn-action,
        nav,
        .navbar,
        .breadcrumb,
        footer,
        .sidebar,
        script {
            display: none !important;
        }

        /* Resetear colores a blanco/negro */
        body {
            background: white !important;
            color: black !important;
            margin: 1cm;
            font-size: 11pt;
        }

        /* Header compacto */
        .show-header {
            background: white !important;
            padding: 0.5rem 0 !important;
            margin-bottom: 0.5rem !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            border-bottom: 2px solid #000 !important;
            page-break-after: avoid;
        }

        .show-header h1,
        .show-header h2 {
            color: black !important;
            font-size: 16pt !important;
            margin: 0 !important;
        }

        .show-header p {
            color: #333 !important;
            font-size: 10pt !important;
            margin: 0 !important;
        }

        /* Cards compactas */
        .detail-card {
            background: white !important;
            border: 1px solid #ddd !important;
            border-radius: 0 !important;
            padding: 0.5rem !important;
            margin-bottom: 0.5rem !important;
            box-shadow: none !important;
            page-break-inside: avoid;
        }

        .detail-card h5 {
            color: black !important;
            font-size: 12pt !important;
            font-weight: bold !important;
            margin-bottom: 0.3rem !important;
            padding-bottom: 0.2rem !important;
            border-bottom: 1px solid #333 !important;
        }

        /* Filas de detalles compactas */
        .detail-row {
            padding: 0.3rem 0 !important;
            border-bottom: 1px solid #eee !important;
            display: flex;
            font-size: 10pt;
        }

        .detail-label {
            color: #333 !important;
            width: 140px !important;
            font-weight: 600;
        }

        .detail-value {
            color: black !important;
            font-weight: normal;
        }

        /* Flujo de transferencia compacto */
        .transfer-flow {
            background: #f5f5f5 !important;
            border: 1px solid #ddd !important;
            padding: 0.5rem !important;
            margin: 0.5rem 0 !important;
            page-break-inside: avoid;
        }

        .transfer-flow * {
            color: black !important;
        }

        .transfer-flow .cuenta-box {
            background: white !important;
            border: 1px solid #ddd !important;
            padding: 0.5rem !important;
        }

        /* Metadata compacto */
        .metadata-box {
            background: white !important;
            border: 1px solid #ddd !important;
            padding: 0.3rem !important;
            margin-top: 0.5rem !important;
            font-size: 8pt;
        }

        .metadata-box small {
            color: #666 !important;
        }

        /* Badges en blanco y negro */
        .badge {
            border: 1px solid #333 !important;
            background: white !important;
            color: black !important;
            font-weight: normal !important;
        }

        /* Eliminar gradientes y sombras */
        * {
            box-shadow: none !important;
            text-shadow: none !important;
        }

        /* Asegurar que todo quepa en una página */
        .container-fluid {
            max-width: 100% !important;
            padding: 0 !important;
        }

        /* Evitar saltos de página dentro de secciones */
        .detail-card,
        .transfer-flow,
        .metadata-box {
            page-break-inside: avoid;
        }

        /* Ajustar márgenes para compactar */
        h1, h2, h3, h4, h5, h6 {
            margin-top: 0.3rem !important;
            margin-bottom: 0.3rem !important;
        }

        p {
            margin-top: 0.2rem !important;
            margin-bottom: 0.2rem !important;
        }

        /* Ocultar íconos en impresión */
        i.fas, i.far, i.fab {
            display: none !important;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    
    <!-- Header -->
    <div class="show-header">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <a href="{{ route('tesorero.transferencias.index') }}" class="btn btn-light me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="mb-2">
                        <i class="fas fa-exchange-alt me-2"></i>
                        Detalle de Transferencia
                    </h1>
                    <p class="mb-0 opacity-90">ID: #{{ $transferencia->id }}</p>
                </div>
            </div>
            <div>
                @php
                    $tipo_trans = $transferencia->tipo_transferencia ?? 'Interna';
                @endphp
                @if($tipo_trans === 'Interna')
                    <span class="badge badge-interna fs-5">
                        <i class="fas fa-building me-1"></i>{{ $tipo_trans }}
                    </span>
                @elseif($tipo_trans === 'Externa')
                    <span class="badge badge-externa fs-5">
                        <i class="fas fa-university me-1"></i>{{ $tipo_trans }}
                    </span>
                @else
                    <span class="badge badge-ajuste fs-5">
                        <i class="fas fa-cog me-1"></i>{{ $tipo_trans }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Columna Izquierda: Detalles -->
        <div class="col-lg-8">
            
            <!-- Flujo de Transferencia -->
            <div class="transfer-flow">
                <h4 class="mb-4">Flujo de Transferencia</h4>
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <div class="cuenta-box">
                            <i class="fas fa-university fa-2x mb-3"></i>
                            <h5>Cuenta Origen</h5>
                            <p class="mb-0 fw-bold">
                                {{ $transferencia->cuenta_origen ?? $transferencia->cuenta ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="cuenta-box">
                            <i class="fas fa-university fa-2x mb-3"></i>
                            <h5>Cuenta Destino</h5>
                            <p class="mb-0 fw-bold">
                                {{ $transferencia->cuenta_destino ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información General -->
            <div class="detail-card">
                <h5><i class="fas fa-info-circle me-2"></i>Información General</h5>
                
                <div class="detail-row">
                    <div class="detail-label">
                        <i class="fas fa-file-alt me-2"></i>Descripción:
                    </div>
                    <div class="detail-value">
                        <strong>{{ $transferencia->descripcion ?? $transferencia->concepto }}</strong>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="fas fa-calendar me-2"></i>Fecha:
                    </div>
                    <div class="detail-value">
                        {{ \Carbon\Carbon::parse($transferencia->fecha ?? $transferencia->fecha_transferencia)->format('d/m/Y') }}
                        <small class="text-muted">
                            ({{ \Carbon\Carbon::parse($transferencia->fecha ?? $transferencia->fecha_transferencia)->diffForHumans() }})
                        </small>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="fas fa-exchange-alt me-2"></i>Tipo:
                    </div>
                    <div class="detail-value">
                        @if($tipo_trans === 'Interna')
                            <span class="badge badge-interna">Transferencia Interna</span>
                        @elseif($tipo_trans === 'Externa')
                            <span class="badge badge-externa">Transferencia Externa</span>
                        @else
                            <span class="badge badge-ajuste">Ajuste Contable</span>
                        @endif
                    </div>
                </div>

                @if($transferencia->subtipo ?? false)
                <div class="detail-row">
                    <div class="detail-label">
                        <i class="fas fa-arrow-up me-2"></i>Subtipo:
                    </div>
                    <div class="detail-value">
                        @if($transferencia->subtipo === 'entrada')
                            <span class="badge badge-entrada">
                                <i class="fas fa-arrow-down me-1"></i>Entrada
                            </span>
                        @else
                            <span class="badge badge-salida">
                                <i class="fas fa-arrow-up me-1"></i>Salida
                            </span>
                        @endif
                    </div>
                </div>
                @endif

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="fas fa-credit-card me-2"></i>Método:
                    </div>
                    <div class="detail-value">
                        {{ $transferencia->metodo_pago ?? $transferencia->metodo ?? 'No especificado' }}
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="fas fa-hashtag me-2"></i>Referencia:
                    </div>
                    <div class="detail-value">
                        @php
                            $referencia = $transferencia->numero_referencia ?? ($transferencia->referencia ?? null);
                        @endphp
                        @if($referencia)
                            <span class="badge bg-secondary">
                                {{ $referencia }}
                            </span>
                        @else
                            <span class="text-muted">Sin referencia</span>
                        @endif
                    </div>
                </div>

                @if(($transferencia->notas ?? null) || ($transferencia->observaciones ?? null))
                <div class="detail-row">
                    <div class="detail-label">
                        <i class="fas fa-sticky-note me-2"></i>Notas:
                    </div>
                    <div class="detail-value">
                        @php
                            $notas = $transferencia->notas ?? ($transferencia->observaciones ?? '');
                        @endphp
                        {{ $notas }}
                    </div>
                </div>
                @endif
            </div>

            <!-- Comprobante -->
            @php
                $comprobante = $transferencia->comprobante_ruta ?? ($transferencia->archivo_comprobante ?? null);
            @endphp
            @if($comprobante)
            <div class="detail-card">
                <h5><i class="fas fa-file-invoice me-2"></i>Comprobante</h5>
                
                <div class="text-center">
                    @php
                        $extension = pathinfo($comprobante, PATHINFO_EXTENSION);
                    @endphp
                    
                    @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                        <img src="{{ Storage::url($comprobante) }}" 
                             alt="Comprobante" 
                             class="comprobante-preview mb-3">
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-file-pdf fa-3x mb-3"></i>
                            <p class="mb-2">Documento PDF adjunto</p>
                        </div>
                    @endif
                    
                    <a href="{{ Storage::url($comprobante) }}" 
                       target="_blank" 
                       class="btn btn-primary btn-action">
                        <i class="fas fa-download me-2"></i>Descargar Comprobante
                    </a>
                </div>
            </div>
            @endif

        </div>

        <!-- Columna Derecha: Montos y Acciones -->
        <div class="col-lg-4">
            
            <!-- Monto Principal -->
            <div class="amount-box mb-4">
                <p class="mb-2 opacity-90">Monto Transferido</p>
                <div class="amount">
                    L. {{ number_format($transferencia->monto, 2) }}
                </div>
            </div>

            <!-- Detalles de Montos -->
            <div class="detail-card">
                <h5><i class="fas fa-dollar-sign me-2"></i>Detalles Financieros</h5>
                
                <div class="detail-row">
                    <div class="detail-label">Monto Base:</div>
                    <div class="detail-value text-end">
                        <strong>L. {{ number_format($transferencia->monto, 2) }}</strong>
                    </div>
                </div>

                @if(($transferencia->comision ?? 0) > 0)
                <div class="detail-row">
                    <div class="detail-label">Comisión:</div>
                    <div class="detail-value text-end">
                        <span class="text-danger">
                            L. {{ number_format($transferencia->comision, 2) }}
                        </span>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label"><strong>Total Debitado:</strong></div>
                    <div class="detail-value text-end">
                        <strong class="text-primary">
                            L. {{ number_format($transferencia->monto + $transferencia->comision, 2) }}
                        </strong>
                    </div>
                </div>
                @endif
            </div>

            <!-- Acciones -->
            <div class="detail-card">
                <h5><i class="fas fa-cogs me-2"></i>Acciones</h5>
                
                <div class="d-grid gap-2">
                    <a href="{{ route('tesorero.transferencias.edit', $transferencia->id) }}" 
                       class="btn btn-edit btn-action">
                        <i class="fas fa-edit me-2"></i>Editar Transferencia
                    </a>
                    
                    <button type="button" 
                            class="btn btn-print btn-action" 
                            onclick="window.print()">
                        <i class="fas fa-print me-2"></i>Imprimir Detalles
                    </button>
                    
                    <a href="{{ route('tesorero.transferencias.index') }}" 
                       class="btn btn-back btn-action">
                        <i class="fas fa-arrow-left me-2"></i>Volver al Listado
                    </a>
                </div>
            </div>

            <!-- Metadata -->
            <div class="metadata-box">
                <small class="d-block mb-2">
                    <strong>Registrado por:</strong> 
                    Usuario #{{ $transferencia->usuario_id ?? 'Sistema' }}
                </small>
                
                @if(isset($transferencia->created_at))
                <small class="d-block mb-2">
                    <strong>Creado:</strong> 
                    {{ \Carbon\Carbon::parse($transferencia->created_at)->format('d/m/Y H:i') }}
                </small>
                @endif
                
                @if(isset($transferencia->updated_at) && isset($transferencia->created_at) && $transferencia->updated_at != $transferencia->created_at)
                <small class="d-block">
                    <strong>Última actualización:</strong> 
                    {{ \Carbon\Carbon::parse($transferencia->updated_at)->format('d/m/Y H:i') }}
                </small>
                @endif
                
                @if(isset($transferencia->movimiento_relacionado_id))
                <small class="d-block mt-2">
                    <strong>Mov. Relacionado:</strong> 
                    #{{ $transferencia->movimiento_relacionado_id }}
                </small>
                @endif
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Print styles
    window.addEventListener('beforeprint', () => {
        document.querySelectorAll('.btn-action').forEach(btn => {
            btn.style.display = 'none';
        });
    });

    window.addEventListener('afterprint', () => {
        document.querySelectorAll('.btn-action').forEach(btn => {
            btn.style.display = '';
        });
    });
</script>
@endpush
