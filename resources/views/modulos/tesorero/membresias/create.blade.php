@extends('modulos.tesorero.layout')

@section('title', 'Nueva Membresía')

@push('styles')
<style>
    /* Fondo claro */
    body {
        background-color: #f8f9fa !important;
    }

    /* Header elegante estilo membresías */
    .create-header {
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

    .create-header-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .create-header-content h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        color: white;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .create-header-content p {
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

    /* Info box */
    .info-box {
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

    .info-box i {
        color: #d97706;
    }

    .info-box strong {
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

    .alert-success {
        background-color: rgba(16, 185, 129, 0.1);
        border: 1px solid #6ee7b7;
        color: #047857;
        border-radius: 10px;
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

    /* Periodo display */
    .periodo-display {
        background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
        color: white;
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        margin-top: 1rem;
    }

    .periodo-display h6,
    .periodo-display p {
        color: white;
        margin: 0;
    }

    .periodo-display h6 {
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">

    <!-- Header -->
    <div class="create-header">
        <div class="create-header-content">
            <a href="{{ route('tesorero.membresias.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1>
                    <i class="fas fa-id-card"></i>
                    Registrar Pago de Membresía
                </h1>
                <p>Complete la información del pago de membresía</p>
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

    <!-- Información importante -->
    <div class="info-box">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Nota:</strong> Asegúrese de seleccionar el miembro correcto y verificar las fechas del período de membresía.
    </div>

    <!-- Formulario -->
    @can('finanzas.crear')
    <form action="{{ route('tesorero.membresias.store') }}" method="POST" enctype="multipart/form-data" id="formMembresia">
        @csrf

        <!-- Sección 1: Información del Miembro -->
        <div class="form-section">
            <h5><i class="fas fa-user me-2"></i>Información del Miembro</h5>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="usuario_id" class="form-label required-field">Miembro</label>
                    <select class="form-select @error('usuario_id') is-invalid @enderror"
                            id="usuario_id"
                            name="usuario_id"
                            required>
                        <option value="">Seleccione un miembro...</option>
                        @foreach($miembros as $miembro)
                            @if($miembro->user)
                                <option value="{{ $miembro->user_id }}" {{ old('usuario_id') == $miembro->user_id ? 'selected' : '' }}>
                                    {{ $miembro->user->name }} - {{ $miembro->user->email }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('usuario_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Sección 2: Información de la Membresía -->
        <div class="form-section">
            <h5><i class="fas fa-id-badge me-2"></i>Datos de la Membresía</h5>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="tipo_membresia" class="form-label required-field">Tipo de Membresía</label>
                    <select class="form-select @error('tipo_membresia') is-invalid @enderror"
                            id="tipo_membresia"
                            name="tipo_membresia"
                            required>
                        <option value="">Seleccione...</option>
                        @foreach($tipos_membresia as $valor => $descripcion)
                            <option value="{{ $valor }}" {{ old('tipo_membresia') == $valor ? 'selected' : '' }}>
                                {{ $descripcion }}
                            </option>
                        @endforeach
                    </select>
                    @error('tipo_membresia')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="estado" class="form-label required-field">Estado</label>
                    <select class="form-select @error('estado') is-invalid @enderror"
                            id="estado"
                            name="estado"
                            required>
                        @foreach($estados as $valor => $descripcion)
                            <option value="{{ $valor }}" {{ old('estado', 'pendiente') == $valor ? 'selected' : '' }}>
                                {{ $descripcion }}
                            </option>
                        @endforeach
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <label for="monto" class="form-label required-field">Monto (L.)</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-dollar-sign"></i>
                        </span>
                        <input type="number"
                               class="form-control @error('monto') is-invalid @enderror"
                               id="monto"
                               name="monto"
                               value="{{ old('monto') }}"
                               step="0.01"
                               min="0.01"
                               placeholder="0.00"
                               required>
                        @error('monto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="tipo_pago" class="form-label required-field">Periodo de Pago</label>
                    <select class="form-select @error('tipo_pago') is-invalid @enderror"
                            id="tipo_pago"
                            name="tipo_pago"
                            required>
                        <option value="">Seleccione...</option>
                        <option value="mensual" {{ old('tipo_pago', 'mensual') == 'mensual' ? 'selected' : '' }}>Mensual</option>
                        <option value="trimestral" {{ old('tipo_pago') == 'trimestral' ? 'selected' : '' }}>Trimestral</option>
                        <option value="semestral" {{ old('tipo_pago') == 'semestral' ? 'selected' : '' }}>Semestral</option>
                        <option value="anual" {{ old('tipo_pago') == 'anual' ? 'selected' : '' }}>Anual</option>
                    </select>
                    @error('tipo_pago')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="fecha_pago" class="form-label required-field">Fecha de Pago</label>
                    <input type="date"
                           class="form-control @error('fecha_pago') is-invalid @enderror"
                           id="fecha_pago"
                           name="fecha_pago"
                           value="{{ old('fecha_pago', date('Y-m-d')) }}"
                           max="{{ date('Y-m-d') }}"
                           required>
                    @error('fecha_pago')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="periodo_inicio" class="form-label required-field">Período Inicio</label>
                    <input type="date"
                           class="form-control @error('periodo_inicio') is-invalid @enderror"
                           id="periodo_inicio"
                           name="periodo_inicio"
                           value="{{ old('periodo_inicio', date('Y-m-d')) }}"
                           required>
                    @error('periodo_inicio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="periodo_fin" class="form-label required-field">Período Fin</label>
                    <input type="date"
                           class="form-control @error('periodo_fin') is-invalid @enderror"
                           id="periodo_fin"
                           name="periodo_fin"
                           value="{{ old('periodo_fin') }}"
                           required>
                    @error('periodo_fin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="periodo-display" id="periodoDisplay" style="display: none;">
                        <h6>Duración del Período</h6>
                        <p id="periodoDuracion"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección 3: Información de Pago -->
        <div class="form-section">
            <h5><i class="fas fa-credit-card me-2"></i>Información de Pago</h5>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="metodo_pago" class="form-label required-field">Método de Pago</label>
                    <select class="form-select @error('metodo_pago') is-invalid @enderror"
                            id="metodo_pago"
                            name="metodo_pago"
                            required>
                        <option value="">Seleccione...</option>
                        @foreach($metodos_pago as $valor => $nombre)
                            <option value="{{ $valor }}" {{ old('metodo_pago') == $valor ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('metodo_pago')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="numero_recibo" class="form-label">Número de Recibo</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-receipt"></i>
                        </span>
                        <input type="text"
                               class="form-control @error('numero_recibo') is-invalid @enderror"
                               id="numero_recibo"
                               name="numero_recibo"
                               value="{{ old('numero_recibo', 'REC-' . date('Y') . '-' . strtoupper(substr(uniqid(), -6))) }}"
                               placeholder="REC-2025-XXXXXX"
                               maxlength="100">
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>Generado automáticamente
                    </small>
                    @error('numero_recibo')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="numero_referencia" class="form-label">Número de Referencia</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-hashtag"></i>
                        </span>
                        <input type="text"
                               class="form-control @error('numero_referencia') is-invalid @enderror"
                               id="numero_referencia"
                               name="numero_referencia"
                               value="{{ old('numero_referencia', 'MEM-' . date('Y') . '-' . strtoupper(substr(uniqid(), -6))) }}"
                               readonly
                               style="background-color: #e9ecef;">
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-lock me-1"></i>Generado automáticamente
                    </small>
                    @error('numero_referencia')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Sección 4: Información Adicional -->
        <div class="form-section">
            <h5><i class="fas fa-clipboard me-2"></i>Información Adicional</h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="notas" class="form-label">Notas u Observaciones</label>
                    <textarea class="form-control @error('notas') is-invalid @enderror"
                              id="notas"
                              name="notas"
                              rows="4"
                              maxlength="500"
                              placeholder="Información adicional...">{{ old('notas') }}</textarea>
                    <small class="text-muted">Máximo 500 caracteres</small>
                    @error('notas')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="comprobante" class="form-label">Comprobante de Pago</label>
                    <input type="file"
                           class="form-control @error('comprobante') is-invalid @enderror"
                           id="comprobante"
                           name="comprobante"
                           accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted">Formatos: PDF, JPG, PNG (Máx. 5MB)</small>
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
                <a href="{{ route('tesorero.membresias.index') }}" class="btn btn-cancel me-2">
                    <i class="fas fa-times me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-submit">
                    <i class="fas fa-save me-2"></i>Registrar Membresía
                </button>
            </div>
        </div>

    </form>
    @endcan

</div>
@endsection

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const formElement = document.getElementById('formMembresia');
    let isSubmitting = false;

    // Calcular período automáticamente según tipo de pago
    const tipoPagoSelect = document.getElementById('tipo_pago');
    const periodoInicio = document.getElementById('periodo_inicio');
    const periodoFin = document.getElementById('periodo_fin');
    const periodoDisplay = document.getElementById('periodoDisplay');
    const periodoDuracion = document.getElementById('periodoDuracion');

    function calcularPeriodoFin() {
        if (tipoPagoSelect.value && periodoInicio.value) {
            const inicio = new Date(periodoInicio.value);
            let fin = new Date(inicio);

            switch(tipoPagoSelect.value) {
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

            mostrarDuracionPeriodo();
        }
    }

    function mostrarDuracionPeriodo() {
        if (periodoInicio.value && periodoFin.value) {
            const inicio = new Date(periodoInicio.value);
            const fin = new Date(periodoFin.value);
            const dias = Math.ceil((fin - inicio) / (1000 * 60 * 60 * 24)) + 1;

            periodoDisplay.style.display = 'block';
            periodoDuracion.textContent = `${dias} días (${inicio.toLocaleDateString('es-HN')} - ${fin.toLocaleDateString('es-HN')})`;
        }
    }

    tipoPagoSelect.addEventListener('change', calcularPeriodoFin);
    periodoInicio.addEventListener('change', calcularPeriodoFin);
    periodoFin.addEventListener('change', mostrarDuracionPeriodo);

    // Mostrar nombre del archivo seleccionado
    const comprobanteInput = document.getElementById('comprobante');
    const archivoDiv = document.getElementById('archivoSeleccionado');

    comprobanteInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const fileName = this.files[0].name;
            const fileSize = (this.files[0].size / 1024 / 1024).toFixed(2);
            archivoDiv.innerHTML = `
                <div class="alert alert-success mb-0 py-2">
                    <i class="fas fa-file-alt me-2"></i>
                    <strong>${fileName}</strong> (${fileSize} MB)
                </div>
            `;
        } else {
            archivoDiv.innerHTML = '';
        }
    });

    // Validación y confirmación del formulario
    formElement.addEventListener('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();

        // Validar formulario
        if (!formElement.checkValidity()) {
            formElement.classList.add('was-validated');
            Swal.fire({
                icon: 'error',
                title: 'Formulario Incompleto',
                text: 'Por favor complete todos los campos requeridos correctamente',
                confirmButtonColor: '#a855f7'
            });
            return;
        }

        // Prevenir envío múltiple
        if (isSubmitting) {
            return;
        }

        // Obtener datos para confirmación
        const miembroSelect = document.getElementById('usuario_id');
        const miembroNombre = miembroSelect.options[miembroSelect.selectedIndex].text;
        const monto = document.getElementById('monto').value;
        const tipoMembresiaSelect = document.getElementById('tipo_membresia');
        const tipoMembresia = tipoMembresiaSelect.options[tipoMembresiaSelect.selectedIndex].text;

        // Confirmar antes de guardar
        Swal.fire({
            title: '¿Confirmar registro de membresía?',
            html: `
                <div class="text-start">
                    <p class="mb-2"><strong>¿Desea registrar este pago de membresía?</strong></p>
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-user me-2"></i><small><strong>Miembro:</strong> ${miembroNombre}</small><br>
                        <i class="fas fa-calendar me-2"></i><small><strong>Tipo:</strong> ${tipoMembresia}</small><br>
                        <i class="fas fa-dollar-sign me-2"></i><small><strong>Monto:</strong> L. ${parseFloat(monto).toFixed(2)}</small>
                    </div>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#a855f7',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-save me-2"></i>Sí, registrar',
            cancelButtonText: '<i class="fas fa-times me-2"></i>Cancelar',
            showLoaderOnConfirm: true,
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                isSubmitting = true;
                Swal.fire({
                    title: 'Guardando...',
                    html: 'Registrando membresía',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                formElement.submit();
            }
        });
    });

});
</script>
@endpush
