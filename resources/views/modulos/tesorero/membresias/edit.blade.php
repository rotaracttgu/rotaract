@extends('layouts.app')

@section('title', 'Editar Membresía')

@push('styles')
<style>
    body {
        background-color: #1e2836 !important;
    }

    .edit-header {
        background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%) !important;
        color: white !important;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(168, 85, 247, 0.3);
    }
    
    .edit-header h1, .edit-header h2, .edit-header p {
        color: #ffffff !important;
        opacity: 1 !important;
    }
    
    .edit-header .btn-light {
        background: rgba(255,255,255,0.2) !important;
        border: none;
        color: #ffffff !important;
    }
    
    .edit-header .btn-light:hover {
        background: rgba(255,255,255,0.3) !important;
        color: #ffffff !important;
    }
    
    .form-section {
        background: #2a3544 !important;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        border-left: 4px solid #a855f7;
    }
    
    .form-section h5 {
        color: #a855f7 !important;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #3d4757;
        opacity: 1 !important;
    }
    
    .form-label {
        font-weight: 600;
        color: #e5e7eb !important;
        opacity: 1 !important;
    }
    
    .required-field::after {
        content: " *";
        color: #ef4444;
    }
    
    .form-control, .form-select {
        background-color: rgba(42, 53, 68, 0.8) !important;
        color: #ffffff !important;
        border: 2px solid #3d4757;
        border-radius: 8px;
        padding: 0.75rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        background-color: rgba(42, 53, 68, 0.9) !important;
        color: #ffffff !important;
        border-color: #a855f7;
        box-shadow: 0 0 0 0.2rem rgba(168, 85, 247, 0.25);
    }
    
    .form-control::placeholder {
        color: #9ca3af !important;
        opacity: 0.7;
    }
    
    .form-select option {
        background-color: #2a3544;
        color: #ffffff;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%) !important;
        border: none;
        padding: 0.875rem 2.5rem;
        border-radius: 8px;
        font-weight: 600;
        color: white !important;
        transition: all 0.3s ease;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(168, 85, 247, 0.3);
        color: white !important;
    }
    
    .btn-cancel {
        background: #6c757d !important;
        border: none;
        padding: 0.875rem 2.5rem;
        border-radius: 8px;
        font-weight: 600;
        color: white !important;
        transition: all 0.3s ease;
    }
    
    .btn-cancel:hover {
        background: #5a6268 !important;
        color: white !important;
    }
    
    .warning-box {
        background: rgba(245, 158, 11, 0.15) !important;
        border-left: 4px solid #f59e0b;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        color: #fbbf24 !important;
    }
    
    .warning-box * {
        color: #fbbf24 !important;
        opacity: 1 !important;
    }
    
    .alert-danger {
        background-color: rgba(239, 68, 68, 0.15) !important;
        border: 1px solid #ef4444;
        color: #fca5a5 !important;
    }
    
    .alert-danger * {
        color: #fca5a5 !important;
        opacity: 1 !important;
    }
    
    /* Texto general visible */
    p, span, label, div, small, h1, h2, h3, h4, h5, h6 {
        opacity: 1 !important;
    }
    
    .text-muted {
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
        color: #a855f7 !important;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        color: #9ca3af !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    
    <div class="edit-header">
        <div class="d-flex align-items-center">
            <a href="{{ route('tesorero.membresias.index') }}" class="btn btn-light me-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="mb-2">
                    <i class="fas fa-edit me-2"></i>
                    Editar Membresía
                </h1>
                <p class="mb-0 opacity-90">Modifique los datos de la membresía</p>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <h6><i class="fas fa-exclamation-triangle me-2"></i>Errores:</h6>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="warning-box">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Advertencia:</strong> Los cambios afectarán los registros contables.
    </div>

    <form action="{{ route('tesorero.membresias.update', $membresia->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-section">
            <h5><i class="fas fa-user me-2"></i>Información del Miembro</h5>
            <div class="mb-3">
                <label for="usuario_id" class="form-label required-field">Miembro</label>
                <select class="form-select" id="usuario_id" name="usuario_id" required>
                    @foreach($miembros as $miembro)
                        <option value="{{ $miembro->user_id }}" {{ $membresia->usuario_id == $miembro->user_id ? 'selected' : '' }}>
                            {{ $miembro->Nombre }} - {{ $miembro->Correo }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-section">
            <h5><i class="fas fa-id-badge me-2"></i>Datos de la Membresía</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">Tipo</label>
                    <select class="form-select" name="tipo_membresia" required>
                        @foreach($tipos_membresia as $key => $val)
                            <option value="{{ $key }}" {{ $membresia->tipo_membresia == $key ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">Estado</label>
                    <select class="form-select" name="estado" required>
                        @foreach($estados as $key => $val)
                            <option value="{{ $key }}" {{ $membresia->estado == $key ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">Monto (L.)</label>
                    <input type="number" class="form-control" name="monto" value="{{ $membresia->monto }}" step="0.01" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">Periodo de Pago</label>
                    <select class="form-select" id="tipo_pago" name="tipo_pago" required>
                        <option value="mensual" {{ $membresia->tipo_pago == 'mensual' ? 'selected' : '' }}>Mensual</option>
                        <option value="trimestral" {{ $membresia->tipo_pago == 'trimestral' ? 'selected' : '' }}>Trimestral</option>
                        <option value="semestral" {{ $membresia->tipo_pago == 'semestral' ? 'selected' : '' }}>Semestral</option>
                        <option value="anual" {{ $membresia->tipo_pago == 'anual' ? 'selected' : '' }}>Anual</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">Fecha Pago</label>
                    <input type="date" class="form-control" name="fecha_pago" value="{{ $membresia->fecha_pago }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">Período Inicio</label>
                    <input type="date" class="form-control" name="periodo_inicio" value="{{ $membresia->periodo_inicio }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">Período Fin</label>
                    <input type="date" class="form-control" name="periodo_fin" value="{{ $membresia->periodo_fin }}" required>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h5><i class="fas fa-credit-card me-2"></i>Información de Pago</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label required-field">Método de Pago</label>
                    <select class="form-select" name="metodo_pago" required>
                        @foreach($metodos_pago as $valor => $nombre)
                            <option value="{{ $valor }}" {{ $membresia->metodo_pago == $valor ? 'selected' : '' }}>{{ $nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Nº Recibo</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-receipt"></i>
                        </span>
                        <input type="text" 
                               class="form-control" 
                               name="numero_recibo" 
                               value="{{ $membresia->numero_recibo ?? $membresia->numero_comprobante }}" 
                               readonly
                               style="background-color: #f8f9fa;">
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-lock me-1"></i>Generado automáticamente - No editable
                    </small>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Nº Referencia</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-hashtag"></i>
                        </span>
                        <input type="text" 
                               class="form-control" 
                               name="numero_referencia" 
                               value="{{ $membresia->numero_referencia }}" 
                               readonly
                               style="background-color: #f8f9fa;">
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-lock me-1"></i>Generado automáticamente - No editable
                    </small>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h5><i class="fas fa-clipboard me-2"></i>Información Adicional</h5>
            <div class="mb-3">
                <label class="form-label">Notas</label>
                <textarea class="form-control" name="notas" rows="3">{{ $membresia->notas }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Nuevo Comprobante</label>
                @if($membresia->comprobante_ruta)
                    <div class="alert alert-info">
                        <i class="fas fa-file me-2"></i>
                        <a href="{{ Storage::url($membresia->comprobante_ruta) }}" target="_blank">Ver comprobante actual</a>
                    </div>
                @endif
                <input type="file" class="form-control" name="comprobante" accept=".pdf,.jpg,.jpeg,.png">
            </div>
        </div>

        <div class="text-end">
            <a href="{{ route('tesorero.membresias.index') }}" class="btn btn-cancel me-2">
                <i class="fas fa-times me-2"></i>Cancelar
            </a>
            <button type="button" class="btn btn-submit" id="btnGuardar">
                <i class="fas fa-save me-2"></i>Actualizar Membresía
            </button>
        </div>
    </form>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Calcular periodo_fin automáticamente cuando cambie tipo_pago o periodo_inicio
document.addEventListener('DOMContentLoaded', function() {
    const tipoPago = document.getElementById('tipo_pago');
    const periodoInicio = document.querySelector('[name="periodo_inicio"]');
    const periodoFin = document.querySelector('[name="periodo_fin"]');

    function calcularPeriodoFin() {
        if (!tipoPago || !periodoInicio || !periodoFin) return;
        if (tipoPago.value && periodoInicio.value) {
            const inicio = new Date(periodoInicio.value);
            let fin = new Date(inicio);
            
            switch(tipoPago.value) {
                case 'mensual':
                    fin.setMonth(fin.getMonth() + 1);
                    break;
                case 'trimestral':
                    fin.setMonth(fin.getMonth() + 3);
                    break;
                case 'semestral':
                    fin.setMonth(fin.getMonth() + 6);
                    break;
                case 'anual':
                    fin.setFullYear(fin.getFullYear() + 1);
                    break;
            }
            
            fin.setDate(fin.getDate() - 1);
            periodoFin.value = fin.toISOString().split('T')[0];
        }
    }

    if (tipoPago && periodoInicio) {
        tipoPago.addEventListener('change', calcularPeriodoFin);
        periodoInicio.addEventListener('change', calcularPeriodoFin);
    }
});

document.getElementById('btnGuardar').addEventListener('click', function(e) {
    e.preventDefault();
    
    const form = this.closest('form');
    const miembro = document.querySelector('#usuario_id option:checked').text;
    const monto = document.querySelector('[name="monto"]').value;
    const tipo = document.querySelector('[name="tipo_membresia"] option:checked').text;
    const estado = document.querySelector('[name="estado"] option:checked').text;
    
    Swal.fire({
        title: '¿Actualizar membresía?',
        html: `
            <div class="text-start">
                <p><strong>Miembro:</strong> ${miembro}</p>
                <p><strong>Tipo:</strong> ${tipo}</p>
                <p><strong>Monto:</strong> L. ${parseFloat(monto).toFixed(2)}</p>
                <p><strong>Estado:</strong> ${estado}</p>
                <hr>
                <p class="text-warning mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Se actualizarán los datos de esta membresía
                </p>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#f093fb',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-save me-2"></i>Sí, actualizar',
        cancelButtonText: '<i class="fas fa-times me-2"></i>Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});
</script>
@endpush

@endsection
