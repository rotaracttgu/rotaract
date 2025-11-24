@extends('modulos.tesorero.layout')

@section('title', 'Editar Membresía')

@push('styles')
<style>
    /* Fondo claro */
    body {
        background-color: #f8f9fa !important;
    }

    /* Header elegante estilo membresías */
    .edit-header {
        background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
        color: white;
        padding: 1.5rem 2rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px rgba(168, 85, 247, 0.3);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .edit-header-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .edit-header-content h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        color: white;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .edit-header-content p {
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

    /* Secciones del formulario */
    .form-section {
        background: white;
        border-radius: 12px;
        padding: 1.75rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        border-left: 4px solid #a855f7;
    }

    .form-section h5 {
        color: #7c3aed;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e5e7eb;
        font-size: 1rem;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .required-field::after {
        content: " *";
        color: #ef4444;
    }

    .form-control, .form-select {
        background-color: #f9fafb;
        color: #1f2937;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
        background-color: white;
        color: #1f2937;
        border-color: #a855f7;
        box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.15);
        outline: none;
    }

    .form-control::placeholder {
        color: #9ca3af;
    }

    .form-select option {
        background-color: white;
        color: #1f2937;
    }

    /* Input group */
    .input-group-text {
        background-color: #f3f4f6;
        border: 2px solid #e5e7eb;
        border-right: none;
        color: #6b7280;
        border-radius: 10px 0 0 10px;
    }

    .input-group .form-control {
        border-radius: 0 10px 10px 0;
    }

    /* Botones */
    .btn-submit {
        background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(168, 85, 247, 0.4);
        color: white;
    }

    .btn-cancel {
        background: white;
        border: 2px solid #e5e7eb;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        color: #6b7280;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #f3f4f6;
        border-color: #d1d5db;
        color: #374151;
    }

    /* Warning box */
    .warning-box {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-left: 4px solid #f59e0b;
        padding: 1rem 1.25rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        color: #92400e;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .warning-box i {
        color: #d97706;
    }

    .warning-box strong {
        color: #92400e;
    }

    /* Alertas */
    .alert-danger {
        background-color: rgba(239, 68, 68, 0.1);
        border: 1px solid #fca5a5;
        color: #dc2626;
        border-radius: 10px;
    }

    .alert-danger h6 {
        color: #dc2626;
    }

    .alert-info {
        background-color: rgba(168, 85, 247, 0.1);
        border: 1px solid #c4b5fd;
        color: #7c3aed;
        border-radius: 8px;
    }

    .alert-info a {
        color: #7c3aed;
        font-weight: 600;
    }

    /* Texto */
    .text-muted {
        color: #6b7280 !important;
    }

    /* Textarea */
    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    /* File input */
    input[type="file"].form-control {
        padding: 0.5rem;
    }

    input[type="file"].form-control::file-selector-button {
        background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        margin-right: 1rem;
        cursor: pointer;
        font-weight: 500;
    }

    input[type="file"].form-control::file-selector-button:hover {
        background: linear-gradient(135deg, #9333ea 0%, #6d28d9 100%);
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    
    <div class="edit-header">
        <div class="edit-header-content">
            <a href="{{ route('tesorero.membresias.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1>
                    <i class="fas fa-edit"></i>
                    Editar Membresía
                </h1>
                <p>Modifique los datos de la membresía</p>
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

    @can('finanzas.editar')
    <form action="{{ route('tesorero.membresias.update', $membresia->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-section">
            <h5><i class="fas fa-user me-2"></i>Información del Miembro</h5>
            <div class="mb-3">
                <label for="usuario_id" class="form-label required-field">Miembro</label>
                <select class="form-select" id="usuario_id" name="usuario_id" required>
                    @foreach($miembros as $miembro)
                        @if($miembro->user)
                            <option value="{{ $miembro->user_id }}" {{ $membresia->usuario_id == $miembro->user_id ? 'selected' : '' }}>
                                {{ $miembro->user->name }} - {{ $miembro->user->email }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-section">
            <h5><i class="fas fa-id-badge me-2"></i>Datos de la Membresía</h5>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label required-field">Tipo</label>
                    <select class="form-select" name="tipo_membresia" required>
                        @foreach($tipos_membresia as $key => $val)
                            <option value="{{ $key }}" {{ $membresia->tipo_membresia == $key ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label required-field">Estado</label>
                    <select class="form-select" name="estado" required>
                        @foreach($estados as $key => $val)
                            <option value="{{ $key }}" {{ $membresia->estado == $key ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label required-field">Monto (L.)</label>
                    <input type="number" class="form-control" name="monto" value="{{ $membresia->monto }}" step="0.01" required>
                </div>
                <div class="col-md-3 mb-3">
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
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Notas</label>
                    <textarea class="form-control" name="notas" rows="4" placeholder="Observaciones o notas adicionales...">{{ $membresia->notas }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Comprobante</label>
                    @if($membresia->comprobante_ruta)
                        <div class="alert alert-info mb-2">
                            <i class="fas fa-file me-2"></i>
                            <a href="{{ Storage::url($membresia->comprobante_ruta) }}" target="_blank">Ver comprobante actual</a>
                        </div>
                    @endif
                    <input type="file" class="form-control" name="comprobante" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted">Formatos: PDF, JPG, PNG</small>
                </div>
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
    @endcan

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
