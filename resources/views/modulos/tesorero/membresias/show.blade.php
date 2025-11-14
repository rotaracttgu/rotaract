@extends('layouts.app')

@section('title', 'Detalle de Membresía')

@push('styles')
<style>
    body {
        background-color: #1e2836 !important;
    }

    .detail-header {
        background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%) !important;
        color: white !important;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(168, 85, 247, 0.3);
    }
    
    .detail-header h1, .detail-header p {
        color: #ffffff !important;
        opacity: 1 !important;
    }
    
    .detail-header .btn-light {
        background: rgba(255,255,255,0.2) !important;
        border: none;
        color: #ffffff !important;
    }
    
    .detail-header .btn-light:hover {
        background: rgba(255,255,255,0.3) !important;
        color: #ffffff !important;
    }
    
    .info-card {
        background: #2a3544 !important;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        margin-bottom: 1.5rem;
    }
    
    .info-section {
        margin-bottom: 2rem;
    }
    
    .info-section h6 {
        color: #a855f7 !important;
        font-weight: 700;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #3d4757;
        opacity: 1 !important;
    }
    
    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #3d4757;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: 600;
        color: #9ca3af !important;
        opacity: 1 !important;
    }
    
    .info-value {
        color: #ffffff !important;
        font-weight: 600;
        opacity: 1 !important;
    }
    
    .member-profile {
        text-align: center;
        padding: 2rem;
        background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%) !important;
        color: white !important;
        border-radius: 12px;
        margin-bottom: 1.5rem;
    }
    
    .member-profile * {
        color: #ffffff !important;
        opacity: 1 !important;
    }
    
    .member-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2) !important;
        color: #ffffff !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }
    
    .badge-status {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        opacity: 1 !important;
    }
    
    .badge-pagado { 
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: white !important;
    }
    
    .badge-pendiente { 
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: white !important;
    }
    
    .badge-vencido { 
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        color: white !important;
    }
    
    .badge-cancelado { 
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
        color: white !important;
    }
    
    .badge-tipo {
        padding: 0.4rem 0.8rem;
        border-radius: 15px;
        font-size: 0.85rem;
        opacity: 1 !important;
    }
    
    .badge-mensual { 
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        color: white !important;
    }
    
    .badge-trimestral { 
        background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%) !important;
        color: white !important;
    }
    
    .badge-semestral { 
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: white !important;
    }
    
    .badge-anual { 
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: white !important;
    }
    
    .amount-display {
        background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%) !important;
        color: white !important;
        padding: 1.5rem;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 1.5rem;
    }
    
    .amount-display * {
        color: #ffffff !important;
        opacity: 1 !important;
    }
    
    .amount-display .amount {
        font-size: 2.5rem;
        font-weight: 700;
    }
    
    .period-display {
        background: rgba(42, 53, 68, 0.8) !important;
        padding: 1rem;
        border-radius: 8px;
        text-align: center;
        margin: 1rem 0;
        border: 1px solid #3d4757;
    }
    
    .period-display * {
        color: #e5e7eb !important;
        opacity: 1 !important;
    }
    
    .period-arrow {
        color: #a855f7 !important;
        font-size: 1.5rem;
        margin: 0 1rem;
    }
    
    .action-buttons .btn {
        margin: 0.25rem;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%) !important;
        border: none;
        color: white !important;
    }
    
    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(168, 85, 247, 0.4);
        color: white !important;
    }
    
    .btn-print {
        background: #6c757d !important;
        border: none;
        color: white !important;
    }
    
    .btn-print:hover {
        background: #5a6268 !important;
        color: white !important;
    }
    
    .metadata-box {
        background: rgba(42, 53, 68, 0.8) !important;
        padding: 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        color: #9ca3af !important;
        border: 1px solid #3d4757;
    }
    
    .metadata-box * {
        color: #9ca3af !important;
        opacity: 1 !important;
    }
    
    /* Texto general visible */
    p, span, label, div, small, h1, h2, h3, h4, h5, h6 {
        opacity: 1 !important;
    }
    
    .text-muted {
        color: #9ca3af !important;
    }
    
    /* Alertas */
    .alert-success {
        background-color: rgba(16, 185, 129, 0.15) !important;
        border: 1px solid #10b981;
        color: #6ee7b7 !important;
    }

    /* ===== ESTILOS PARA IMPRESIÓN ===== */
    @media print {
        /* Ocultar elementos de navegación */
        .navbar, 
        .detail-header .btn, 
        .action-buttons,
        .btn-print,
        .btn-edit,
        footer {
            display: none !important;
        }

        /* Resetear colores de fondo para impresión */
        body {
            background-color: white !important;
            color: black !important;
        }

        .detail-header {
            background: white !important;
            color: black !important;
            border: 2px solid #000 !important;
            padding: 1rem !important;
            margin-bottom: 1rem !important;
            box-shadow: none !important;
        }

        .detail-header h1, 
        .detail-header p {
            color: black !important;
        }

        .info-card {
            background: white !important;
            border: 1px solid #ddd !important;
            padding: 1rem !important;
            margin-bottom: 0.5rem !important;
            box-shadow: none !important;
            page-break-inside: avoid;
        }

        .member-profile {
            background: white !important;
            border: 2px solid #000 !important;
            padding: 1rem !important;
            margin-bottom: 0.5rem !important;
        }

        .member-profile * {
            color: black !important;
        }

        .member-avatar {
            background: #e5e7eb !important;
            color: black !important;
            width: 60px !important;
            height: 60px !important;
            font-size: 1.5rem !important;
        }

        .amount-display {
            background: white !important;
            border: 2px solid #000 !important;
            padding: 0.75rem !important;
            margin-bottom: 0.5rem !important;
        }

        .amount-display * {
            color: black !important;
        }

        .amount-display .amount {
            font-size: 1.75rem !important;
        }

        .info-section h6 {
            color: black !important;
            border-bottom: 2px solid #000 !important;
            font-size: 0.95rem !important;
            margin-bottom: 0.5rem !important;
            padding-bottom: 0.25rem !important;
        }

        .info-row {
            padding: 0.4rem 0 !important;
            border-bottom: 1px solid #ddd !important;
        }

        .info-label,
        .info-value {
            color: black !important;
            font-size: 0.9rem !important;
        }

        .badge-status,
        .badge-tipo {
            border: 1px solid #000 !important;
            background: white !important;
            color: black !important;
            padding: 0.25rem 0.5rem !important;
            font-size: 0.8rem !important;
        }

        .period-display {
            background: white !important;
            border: 1px solid #ddd !important;
            padding: 0.5rem !important;
            margin: 0.5rem 0 !important;
        }

        .period-display * {
            color: black !important;
        }

        .metadata-box {
            background: white !important;
            border: 1px solid #ddd !important;
            padding: 0.5rem !important;
            font-size: 0.75rem !important;
        }

        .metadata-box * {
            color: #666 !important;
        }

        /* Compactar espaciado */
        .container-fluid {
            padding: 0.5rem !important;
        }

        .row {
            margin-bottom: 0.25rem !important;
        }

        .col-md-6,
        .col-md-8,
        .col-md-4 {
            padding: 0.25rem !important;
        }

        /* Ajustar tamaño de página */
        @page {
            size: letter;
            margin: 1cm;
        }

        /* Evitar saltos de página innecesarios */
        .info-section {
            page-break-inside: avoid;
            margin-bottom: 0.5rem !important;
        }

        /* Hacer texto más pequeño para compactar */
        body {
            font-size: 11pt !important;
        }

        h1 {
            font-size: 18pt !important;
        }

        h6 {
            font-size: 12pt !important;
        }
    }

    
    .alert-success * {
        color: #6ee7b7 !important;
    }
    
    @media print {
        .no-print { display: none !important; }
        .info-card { box-shadow: none; }
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    
    <div class="detail-header no-print">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('tesorero.membresias.index') }}" class="btn btn-light me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="mb-2">
                        <i class="fas fa-id-card me-2"></i>
                        Detalle de Membresía
                    </h1>
                    <p class="mb-0 opacity-90">Recibo: {{ $membresia->numero_recibo ?? 'Sin número' }}</p>
                </div>
            </div>
            <div class="action-buttons">
                <a href="{{ route('tesorero.membresias.edit', $membresia->id) }}" class="btn btn-edit">
                    <i class="fas fa-edit me-2"></i>Editar
                </a>
                <button onclick="window.print()" class="btn btn-print">
                    <i class="fas fa-print me-2"></i>Imprimir
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="info-card">
                
                <div class="info-section">
                    <h6><i class="fas fa-user me-2"></i>Información del Miembro</h6>
                    <div class="info-row">
                        <span class="info-label">Nombre:</span>
                        <span class="info-value">{{ $membresia->nombre_miembro ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $membresia->email ?? 'N/A' }}</span>
                    </div>
                </div>

                <div class="info-section">
                    <h6><i class="fas fa-id-badge me-2"></i>Datos de la Membresía</h6>
                    <div class="info-row">
                        <span class="info-label">Tipo:</span>
                        <span class="info-value">
                            @php
                                $tipoBadges = [
                                    'mensual' => 'badge-mensual',
                                    'trimestral' => 'badge-trimestral',
                                    'semestral' => 'badge-semestral',
                                    'anual' => 'badge-anual'
                                ];
                                $badgeClass = $tipoBadges[$membresia->tipo_membresia] ?? 'badge-secondary';
                            @endphp
                            <span class="badge badge-tipo {{ $badgeClass }}">
                                {{ ucfirst($membresia->tipo_membresia) }}
                            </span>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Estado:</span>
                        <span class="info-value">
                            @php
                                $estadoBadges = [
                                    'pagado' => 'badge-pagado',
                                    'pendiente' => 'badge-pendiente',
                                    'vencido' => 'badge-vencido',
                                    'cancelado' => 'badge-cancelado'
                                ];
                                $badgeClass = $estadoBadges[$membresia->estado] ?? 'badge-secondary';
                            @endphp
                            <span class="badge badge-status {{ $badgeClass }}">
                                {{ ucfirst($membresia->estado) }}
                            </span>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Fecha de Pago:</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($membresia->fecha_pago)->format('d/m/Y') }}</span>
                    </div>
                </div>

                <div class="info-section">
                    <h6><i class="fas fa-calendar me-2"></i>Período de Vigencia</h6>
                    <div class="period-display">
                        <strong>{{ \Carbon\Carbon::parse($membresia->periodo_inicio)->format('d/m/Y') }}</strong>
                        <span class="period-arrow">→</span>
                        <strong>{{ \Carbon\Carbon::parse($membresia->periodo_fin)->format('d/m/Y') }}</strong>
                        <div class="mt-2 text-muted">
                            <small>
                                @php
                                    $inicio = \Carbon\Carbon::parse($membresia->periodo_inicio);
                                    $fin = \Carbon\Carbon::parse($membresia->periodo_fin);
                                    $dias = $inicio->diffInDays($fin);
                                @endphp
                                Duración: {{ $dias }} días
                            </small>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <h6><i class="fas fa-credit-card me-2"></i>Información de Pago</h6>
                    <div class="info-row">
                        <span class="info-label">Método de Pago:</span>
                        <span class="info-value">{{ $membresia->metodo_pago ?? 'No especificado' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nº Recibo:</span>
                        <span class="info-value">{{ $membresia->numero_recibo ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nº Referencia:</span>
                        <span class="info-value">{{ $membresia->numero_referencia ?? 'N/A' }}</span>
                    </div>
                </div>

                @if($membresia->notas)
                <div class="info-section">
                    <h6><i class="fas fa-clipboard me-2"></i>Notas</h6>
                    <p class="text-muted">{{ $membresia->notas }}</p>
                </div>
                @endif

                @if($membresia->comprobante_ruta)
                <div class="info-section">
                    <h6><i class="fas fa-file me-2"></i>Comprobante</h6>
                    <div class="text-center">
                        @php
                            $ext = pathinfo($membresia->comprobante_ruta, PATHINFO_EXTENSION);
                        @endphp
                        @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                            <img src="{{ Storage::url($membresia->comprobante_ruta) }}" 
                                 alt="Comprobante" 
                                 class="img-fluid rounded" 
                                 style="max-height: 400px;">
                        @else
                            <a href="{{ Storage::url($membresia->comprobante_ruta) }}" 
                               target="_blank" 
                               class="btn btn-outline-primary">
                                <i class="fas fa-download me-2"></i>Descargar Comprobante ({{ strtoupper($ext) }})
                            </a>
                        @endif
                    </div>
                </div>
                @endif

            </div>
        </div>

        <div class="col-md-4">
            
            <div class="member-profile">
                <div class="member-avatar">
                    @php
                        $nombre = $membresia->nombre_miembro ?? 'Usuario';
                        $iniciales = collect(explode(' ', $nombre))->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->implode('');
                    @endphp
                    {{ $iniciales }}
                </div>
                <h5>{{ $membresia->nombre_miembro ?? 'Sin nombre' }}</h5>
                <p class="mb-0">{{ $membresia->email ?? '' }}</p>
            </div>

            <div class="amount-display">
                <div class="text-uppercase small mb-2">Monto Total</div>
                <div class="amount">L. {{ number_format($membresia->monto, 2) }}</div>
            </div>

            <div class="info-card">
                <h6 class="text-muted mb-3">
                    <i class="fas fa-info-circle me-2"></i>Información del Sistema
                </h6>
                <div class="metadata-box">
                    <div class="mb-2">
                        <i class="fas fa-clock me-2"></i>
                        <strong>Registrado:</strong><br>
                        <small>{{ \Carbon\Carbon::parse($membresia->created_at ?? now())->format('d/m/Y H:i') }}</small>
                    </div>
                    @if(isset($membresia->updated_at))
                    <div class="mb-2">
                        <i class="fas fa-sync me-2"></i>
                        <strong>Actualizado:</strong><br>
                        <small>{{ \Carbon\Carbon::parse($membresia->updated_at)->format('d/m/Y H:i') }}</small>
                    </div>
                    @endif
                    <div>
                        <i class="fas fa-hashtag me-2"></i>
                        <strong>ID:</strong> {{ $membresia->id }}
                    </div>
                </div>
            </div>

            <div class="info-card no-print">
                <h6 class="text-muted mb-3">
                    <i class="fas fa-tools me-2"></i>Acciones
                </h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('tesorero.membresias.edit', $membresia->id) }}" class="btn btn-edit">
                        <i class="fas fa-edit me-2"></i>Editar Membresía
                    </a>
                    <button onclick="window.print()" class="btn btn-print">
                        <i class="fas fa-print me-2"></i>Imprimir Recibo
                    </button>
                    <a href="{{ route('tesorero.membresias.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver al Listado
                    </a>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
    window.addEventListener('beforeprint', function() {
        document.querySelectorAll('.no-print').forEach(el => el.style.display = 'none');
    });
    
    window.addEventListener('afterprint', function() {
        document.querySelectorAll('.no-print').forEach(el => el.style.display = '');
    });
</script>
@endsection
