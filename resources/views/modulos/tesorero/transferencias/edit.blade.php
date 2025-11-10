@extends('layouts.app')

@section('title', 'Editar Transferencia')

@push('styles')
<style>
    body {
        background-color: #1e2836 !important;
    }

    .edit-header {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        color: white !important;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(6, 182, 212, 0.3);
    }
    
    .edit-header h2, .edit-header p {
        color: #ffffff !important;
        opacity: 1 !important;
    }
    
    .form-section {
        background: #2a3544 !important;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        border-left: 4px solid #06b6d4;
    }
    
    .form-section h5 {
        color: #06b6d4 !important;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #3d4757;
        opacity: 1 !important;
    }
    
    .form-label {
        font-weight: 600;
        color: #e5e7eb !important;
        margin-bottom: 0.5rem;
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
        border-color: #06b6d4;
        box-shadow: 0 0 0 0.2rem rgba(6, 182, 212, 0.25);
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
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        border: none;
        padding: 0.875rem 2.5rem;
        border-radius: 8px;
        font-weight: 600;
        color: white !important;
        transition: all 0.3s ease;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(6, 182, 212, 0.3);
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
        transform: translateY(-2px);
        color: white !important;
    }
    
    .warning-box {
        background: rgba(255, 193, 7, 0.15) !important;
        border-left: 4px solid #ffc107;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        color: #ffc107 !important;
    }
    
    .warning-box * {
        color: #ffc107 !important;
        opacity: 1 !important;
    }
    
    .file-upload-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }
    
    .file-upload-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        cursor: pointer;
    }
    
    .file-upload-label {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        background: rgba(42, 53, 68, 0.8) !important;
        border: 2px dashed #3d4757;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #e5e7eb !important;
    }
    
    .file-upload-label:hover {
        background: rgba(61, 71, 87, 0.8) !important;
        border-color: #06b6d4;
    }
    
    .file-upload-label i, .file-upload-label span {
        color: #e5e7eb !important;
        opacity: 1 !important;
    }
    
    .current-file {
        background: rgba(6, 182, 212, 0.15) !important;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        border: 1px solid #06b6d4;
    }
    
    .current-file * {
        color: #06b6d4 !important;
        opacity: 1 !important;
    }
    
    .cuenta-transfer-display {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        color: white !important;
        padding: 1rem;
        border-radius: 8px;
        text-align: center;
        margin: 1rem 0;
    }
    
    .cuenta-transfer-display * {
        color: #ffffff !important;
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
    p, span, label, div, small {
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
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    
    <!-- Header -->
    <div class="edit-header">
        <div class="d-flex align-items-center">
            <a href="{{ route('tesorero.transferencias.index') }}" class="btn btn-light me-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="mb-2">
                    <i class="fas fa-edit me-2"></i>
                    Editar Transferencia
                </h1>
                <p class="mb-0 opacity-90">Modifique los datos de la transferencia</p>
            </div>
        </div>
    </div>

    <!-- Mensajes de error -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Errores de validación:</h6>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Advertencia -->
    <div class="warning-box">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Advertencia:</strong> Esta transferencia ya está registrada en el sistema. Los cambios afectarán los registros contables.
    </div>

    @if(isset($transferencia))
    @php
        // Asignar valores seguros para evitar errores de propiedades undefined
        $descripcion = $transferencia->descripcion ?? ($transferencia->concepto ?? '');
        $fecha = $transferencia->fecha ?? ($transferencia->fecha_transferencia ?? '');
        $tipo_transferencia = $transferencia->tipo_transferencia ?? '';
        $metodo = $transferencia->metodo_pago ?? ($transferencia->metodo ?? '');
        $numero_referencia = $transferencia->numero_referencia ?? ($transferencia->referencia ?? '');
        $cuenta_origen = $transferencia->cuenta_origen ?? ($transferencia->cuenta ?? '');
        $cuenta_destino = $transferencia->cuenta_destino ?? '';
        $monto = $transferencia->monto ?? '';
        $comision = $transferencia->comision ?? ($transferencia->comision_bancaria ?? 0);
        $notas = $transferencia->notas ?? ($transferencia->observaciones ?? '');
        $estado = $transferencia->estado ?? 'activo';
        $comprobante = $transferencia->comprobante_ruta ?? ($transferencia->archivo_comprobante ?? null);
    @endphp

    <!-- Formulario -->
    <form action="{{ route('tesorero.transferencias.update', $transferencia->id) }}" method="POST" enctype="multipart/form-data" id="formTransferencia">
        @csrf
        @method('PUT')

        <!-- Sección 1: Información Básica -->
        <div class="form-section">
            <h5><i class="fas fa-info-circle me-2"></i>Información Básica</h5>
            
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="descripcion" class="form-label required-field">Descripción</label>
                    <input type="text" 
                           class="form-control @error('descripcion') is-invalid @enderror" 
                           id="descripcion" 
                           name="descripcion" 
                           value="{{ old('descripcion', $descripcion) }}"
                           placeholder="Ej: Transferencia de fondos operativos"
                           required>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="fecha" class="form-label required-field">Fecha de Transferencia</label>
                    <input type="date" 
                           class="form-control @error('fecha') is-invalid @enderror" 
                           id="fecha" 
                           name="fecha" 
                           value="{{ old('fecha', $fecha) }}"
                           max="{{ date('Y-m-d') }}"
                           required>
                    @error('fecha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="tipo_transferencia" class="form-label required-field">Tipo de Transferencia</label>
                    <select class="form-select @error('tipo_transferencia') is-invalid @enderror" 
                            id="tipo_transferencia" 
                            name="tipo_transferencia" 
                            required>
                        <option value="">Seleccione...</option>
                        @foreach($tipos_transferencia as $valor => $descripcion_tipo)
                            <option value="{{ $valor }}" 
                                {{ old('tipo_transferencia', $tipo_transferencia) == $valor ? 'selected' : '' }}>
                                {{ $descripcion_tipo }}
                            </option>
                        @endforeach
                    </select>
                    @error('tipo_transferencia')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="metodo" class="form-label">Método</label>
                    <select class="form-select @error('metodo') is-invalid @enderror" 
                            id="metodo" 
                            name="metodo">
                        <option value="">Seleccione...</option>
                        @foreach($metodos as $metodo_item)
                            <option value="{{ $metodo_item }}" 
                                {{ old('metodo', $metodo) == $metodo_item ? 'selected' : '' }}>
                                {{ $metodo_item }}
                            </option>
                        @endforeach
                    </select>
                    @error('metodo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="numero_referencia" class="form-label">Número de Referencia</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-hashtag"></i>
                        </span>
                        <input type="text" 
                               class="form-control @error('numero_referencia') is-invalid @enderror" 
                               id="numero_referencia" 
                               name="numero_referencia" 
                               value="{{ old('numero_referencia', $numero_referencia) }}"
                               readonly
                               style="background-color: #f8f9fa;">
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-lock me-1"></i>No se puede modificar
                    </small>
                    @error('numero_referencia')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Sección 2: Cuentas y Montos -->
        <div class="form-section">
            <h5><i class="fas fa-wallet me-2"></i>Cuentas y Montos</h5>
            
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="cuenta_origen" class="form-label required-field">Cuenta de Origen</label>
                    <select class="form-select @error('cuenta_origen') is-invalid @enderror" 
                            id="cuenta_origen" 
                            name="cuenta_origen" 
                            required>
                        <option value="">Seleccione cuenta de origen...</option>
                        @foreach($cuentas as $cuenta)
                            <option value="{{ $cuenta }}" 
                                {{ old('cuenta_origen', $cuenta_origen) == $cuenta ? 'selected' : '' }}>
                                {{ $cuenta }}
                            </option>
                        @endforeach
                    </select>
                    @error('cuenta_origen')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-2 mb-3 d-flex align-items-end justify-content-center">
                    <div class="cuenta-transfer-display">
                        <i class="fas fa-arrow-right fa-2x"></i>
                    </div>
                </div>

                <div class="col-md-5 mb-3">
                    <label for="cuenta_destino" class="form-label required-field">Cuenta de Destino</label>
                    <select class="form-select @error('cuenta_destino') is-invalid @enderror" 
                            id="cuenta_destino" 
                            name="cuenta_destino" 
                            required>
                        <option value="">Seleccione cuenta de destino...</option>
                        @foreach($cuentas as $cuenta)
                            <option value="{{ $cuenta }}" 
                                {{ old('cuenta_destino', $cuenta_destino) == $cuenta ? 'selected' : '' }}>
                                {{ $cuenta }}
                            </option>
                        @endforeach
                    </select>
                    @error('cuenta_destino')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="monto" class="form-label required-field">Monto a Transferir (L.)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-dollar-sign"></i>
                        </span>
                        <input type="number" 
                               class="form-control @error('monto') is-invalid @enderror" 
                               id="monto" 
                               name="monto" 
                               value="{{ old('monto', $monto) }}"
                               step="0.01" 
                               min="0.01"
                               placeholder="0.00"
                               required>
                        @error('monto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="comision" class="form-label">Comisión (L.)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-percentage"></i>
                        </span>
                        <input type="number" 
                               class="form-control @error('comision') is-invalid @enderror" 
                               id="comision" 
                               name="comision" 
                               value="{{ old('comision', $comision) }}"
                               step="0.01" 
                               min="0"
                               placeholder="0.00">
                        @error('comision')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted">Si aplica, se registrará como gasto adicional</small>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info">
                        <strong>Monto Total a Debitar:</strong> 
                        <span id="montoTotal">L. {{ number_format(($transferencia->monto ?? 0) + ($transferencia->comision ?? 0), 2) }}</span>
                        <small class="d-block mt-1">(Monto + Comisión)</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección 3: Información Adicional -->
        <div class="form-section">
            <h5><i class="fas fa-clipboard me-2"></i>Información Adicional</h5>
            
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="notas" class="form-label">Notas u Observaciones</label>
                    <textarea class="form-control @error('notas') is-invalid @enderror" 
                              id="notas" 
                              name="notas" 
                              rows="3"
                              maxlength="500"
                              placeholder="Información adicional sobre la transferencia...">{{ old('notas', $notas) }}</textarea>
                    @error('notas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Máximo 500 caracteres</small>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="comprobante" class="form-label">Comprobante de Transferencia</label>
                    
                    @if($comprobante)
                        <div class="current-file">
                            <i class="fas fa-file-alt me-2"></i>
                            <strong>Archivo actual:</strong> 
                            <a href="{{ Storage::url($comprobante) }}" 
                               target="_blank" 
                               class="text-primary">
                                Ver comprobante actual
                            </a>
                            <small class="text-muted d-block mt-1">Seleccione un nuevo archivo para reemplazar el actual</small>
                        </div>
                    @endif
                    
                    <div class="file-upload-wrapper">
                        <input type="file" 
                               class="form-control @error('comprobante') is-invalid @enderror" 
                               id="comprobante" 
                               name="comprobante"
                               accept=".pdf,.jpg,.jpeg,.png">
                        <label class="file-upload-label" for="comprobante">
                            <i class="fas fa-cloud-upload-alt fa-2x text-muted me-3"></i>
                            <div>
                                <span class="d-block"><strong>Seleccionar archivo</strong></span>
                                <small class="text-muted">PDF, JPG, PNG (Máx. 5MB)</small>
                            </div>
                        </label>
                    </div>
                    @error('comprobante')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div id="archivoSeleccionado" class="mt-2"></div>
                </div>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="row">
            <div class="col-12 text-end">
                <a href="{{ route('tesorero.transferencias.index') }}" class="btn btn-cancel me-2">
                    <i class="fas fa-times me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-submit">
                    <i class="fas fa-save me-2"></i>Actualizar Transferencia
                </button>
            </div>
        </div>

    </form>
    @else
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle me-2"></i>
        No se encontró la transferencia solicitada.
    </div>
    @endif

</div>
@endsection

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Calcular monto total
    const montoInput = document.getElementById('monto');
    const comisionInput = document.getElementById('comision');
    const montoTotalSpan = document.getElementById('montoTotal');
    
    function calcularTotal() {
        const monto = parseFloat(montoInput.value) || 0;
        const comision = parseFloat(comisionInput.value) || 0;
        const total = monto + comision;
        montoTotalSpan.textContent = 'L. ' + total.toFixed(2);
    }
    
    montoInput.addEventListener('input', calcularTotal);
    comisionInput.addEventListener('input', calcularTotal);
    
    // Validar que las cuentas no sean iguales
    const cuentaOrigen = document.getElementById('cuenta_origen');
    const cuentaDestino = document.getElementById('cuenta_destino');
    
    function validarCuentas() {
        if (cuentaOrigen.value && cuentaDestino.value && cuentaOrigen.value === cuentaDestino.value) {
            cuentaDestino.setCustomValidity('La cuenta de destino debe ser diferente a la cuenta de origen');
            cuentaDestino.classList.add('is-invalid');
        } else {
            cuentaDestino.setCustomValidity('');
            cuentaDestino.classList.remove('is-invalid');
        }
    }
    
    cuentaOrigen.addEventListener('change', validarCuentas);
    cuentaDestino.addEventListener('change', validarCuentas);
    
    // Mostrar nombre del archivo seleccionado
    const comprobanteInput = document.getElementById('comprobante');
    const archivoDiv = document.getElementById('archivoSeleccionado');
    
    comprobanteInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const fileName = this.files[0].name;
            const fileSize = (this.files[0].size / 1024 / 1024).toFixed(2);
            archivoDiv.innerHTML = `
                <div class="alert alert-success mb-0">
                    <i class="fas fa-file-alt me-2"></i>
                    <strong>${fileName}</strong> (${fileSize} MB)
                </div>
            `;
        } else {
            archivoDiv.innerHTML = '';
        }
    });
    
    // Validación y confirmación del formulario
    const form = document.getElementById('formTransferencia');
    let isSubmitting = false;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        // Validar formulario
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            Swal.fire({
                icon: 'error',
                title: 'Formulario Incompleto',
                text: 'Por favor complete todos los campos requeridos correctamente',
                confirmButtonColor: '#667eea'
            });
            return;
        }
        
        // Validar cuentas diferentes
        if (cuentaOrigen.value === cuentaDestino.value) {
            Swal.fire({
                icon: 'error',
                title: 'Error de Validación',
                text: 'La cuenta de origen y destino deben ser diferentes',
                confirmButtonColor: '#667eea'
            });
            return;
        }
        
        // Prevenir envío múltiple
        if (isSubmitting) {
            return;
        }
        
        // Confirmar antes de guardar
        Swal.fire({
            title: '¿Confirmar cambios?',
            html: `
                <div class="text-start">
                    <p class="mb-2"><strong>¿Desea guardar los cambios realizados en esta transferencia?</strong></p>
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>Descripción: <strong>${document.getElementById('descripcion').value}</strong></small><br>
                        <small>Monto: <strong>L. ${parseFloat(montoInput.value || 0).toFixed(2)}</strong></small>
                    </div>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#667eea',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-save me-2"></i>Sí, guardar cambios',
            cancelButtonText: '<i class="fas fa-times me-2"></i>Cancelar',
            showLoaderOnConfirm: true,
            allowOutsideClick: false,
            preConfirm: () => {
                isSubmitting = true;
                return fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Error al actualizar la transferencia');
                        });
                    }
                    return response.json();
                })
                .catch(error => {
                    isSubmitting = false;
                    Swal.showValidationMessage(`Error: ${error.message}`);
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar éxito y redirigir
                Swal.fire({
                    icon: 'success',
                    title: '¡Transferencia Actualizada!',
                    text: 'Los cambios se han guardado correctamente',
                    confirmButtonColor: '#667eea',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "{{ route('tesorero.transferencias.index') }}";
                });
            } else {
                isSubmitting = false;
            }
        });
    });
    
});
</script>
@endpush
