@extends('modulos.tesorero.layout')

@section('title', 'Crear Presupuesto')

@push('styles')
<style>
    /* Fondo claro */
    body {
        background-color: #f8f9fa !important;
    }

    /* Header elegante estilo presupuestos */
    .create-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 1.5rem 2rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
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

    /* Form Section */
    .form-section {
        background: white;
        border-radius: 12px;
        padding: 1.75rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        border-left: 4px solid #3b82f6;
    }

    .form-section h4 {
        color: #2563eb;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e5e7eb;
        font-size: 1rem;
    }

    .form-section h4 i {
        color: #3b82f6;
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
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
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
        color: #3b82f6;
        border-radius: 10px 0 0 10px;
        font-weight: 600;
    }

    .input-group .form-control,
    .input-group .form-select {
        border-radius: 0 10px 10px 0;
    }

    /* Botones */
    .btn-submit {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
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

    /* Info Box */
    .info-box {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-left: 4px solid #3b82f6;
        padding: 1.25rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        color: #1e40af;
    }

    .info-box h5 {
        color: #1e40af;
        font-weight: 700;
        margin-bottom: 0.75rem;
        font-size: 1rem;
    }

    .info-box ul {
        color: #1e40af;
        margin-bottom: 0;
        padding-left: 1.25rem;
    }

    .info-box li {
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    /* Preview Box */
    .preview-box {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        border-left: 4px solid #10b981;
    }

    .preview-box h5 {
        color: #047857;
        font-weight: 700;
        margin-bottom: 1rem;
        font-size: 1rem;
    }

    .preview-box .preview-item {
        margin-bottom: 0.75rem;
    }

    .preview-box strong {
        color: #374151;
    }

    .preview-box span {
        color: #6b7280;
    }

    .preview-box .text-primary {
        color: #3b82f6 !important;
        font-weight: 700;
    }

    /* Warning Card */
    .warning-card {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 12px;
        padding: 1.25rem;
        border-left: 4px solid #f59e0b;
    }

    .warning-card h6 {
        color: #92400e;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .warning-card p {
        color: #92400e;
        font-size: 0.85rem;
        margin: 0;
    }

    /* Textarea */
    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    /* Text colors */
    .text-muted {
        color: #6b7280 !important;
    }

    .text-danger {
        color: #ef4444 !important;
    }

    /* Error state */
    .is-invalid {
        border-color: #ef4444 !important;
    }

    .invalid-feedback {
        color: #ef4444;
        font-size: 0.85rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="create-header">
        <div class="create-header-content">
            <a href="{{ route('tesorero.presupuestos.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1>
                    <i class="fas fa-plus-circle"></i>
                    Crear Nuevo Presupuesto
                </h1>
                <p>Define el presupuesto para una categoría y período</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Formulario -->
            <div class="form-section">
                @can('finanzas.crear')
                <form action="{{ route('tesorero.presupuestos.store') }}" method="POST" id="formPresupuesto">
                    @csrf

                    <!-- Información del Presupuesto -->
                    <h4>
                        <i class="fas fa-info-circle me-2"></i>
                        Información del Presupuesto
                    </h4>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="categoria" class="form-label required-field">Categoría</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-tag"></i>
                                </span>
                                <select name="categoria" id="categoria" class="form-select @error('categoria') is-invalid @enderror" required>
                                    <option value="">Seleccionar categoría...</option>
                                    @foreach($categorias as $cat)
                                        <option value="{{ $cat }}" {{ old('categoria') == $cat ? 'selected' : '' }}>
                                            {{ $cat }}
                                        </option>
                                    @endforeach
                                    <option value="__nueva__">+ Nueva Categoría</option>
                                </select>
                            </div>
                            @error('categoria')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror

                            <!-- Input para nueva categoría (oculto por defecto) -->
                            <div id="nuevaCategoriaDiv" style="display: none;" class="mt-2">
                                <input type="text" id="nuevaCategoria" class="form-control" placeholder="Escribe el nombre de la categoría">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="monto_presupuestado" class="form-label required-field">Presupuesto Mensual</label>
                            <div class="input-group">
                                <span class="input-group-text">L.</span>
                                <input type="number"
                                       name="monto_presupuestado"
                                       id="monto_presupuestado"
                                       class="form-control @error('monto_presupuestado') is-invalid @enderror"
                                       step="0.01"
                                       min="0"
                                       value="{{ old('monto_presupuestado') }}"
                                       placeholder="0.00"
                                       required>
                            </div>
                            @error('monto_presupuestado')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Período -->
                    <h4>
                        <i class="fas fa-calendar-alt me-2"></i>
                        Período
                    </h4>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="mes" class="form-label required-field">Mes</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                <select name="mes" id="mes" class="form-select @error('mes') is-invalid @enderror" required>
                                    <option value="">Seleccionar mes...</option>
                                    @foreach(['1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'] as $num => $nombre)
                                        <option value="{{ $num }}" {{ old('mes', date('n')) == $num ? 'selected' : '' }}>
                                            {{ $nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('mes')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="anio" class="form-label required-field">Año</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-check"></i>
                                </span>
                                <select name="anio" id="anio" class="form-select @error('anio') is-invalid @enderror" required>
                                    @for($i = 2020; $i <= 2030; $i++)
                                        <option value="{{ $i }}" {{ old('anio', date('Y')) == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            @error('anio')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Detalles Adicionales -->
                    <h4>
                        <i class="fas fa-file-alt me-2"></i>
                        Detalles Adicionales
                    </h4>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion"
                                      id="descripcion"
                                      class="form-control @error('descripcion') is-invalid @enderror"
                                      rows="4"
                                      placeholder="Describe el propósito de este presupuesto, objetivos, consideraciones especiales...">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label required-field">Estado del Presupuesto</label>
                            <select class="form-select @error('estado') is-invalid @enderror"
                                    name="estado"
                                    id="estado"
                                    required>
                                <option value="activa" {{ old('estado', 'activa') == 'activa' ? 'selected' : '' }}>Activa</option>
                                <option value="inactiva" {{ old('estado') == 'inactiva' ? 'selected' : '' }}>Inactiva</option>
                                <option value="pausada" {{ old('estado') == 'pausada' ? 'selected' : '' }}>Pausada</option>
                                <option value="archivada" {{ old('estado') == 'archivada' ? 'selected' : '' }}>Archivada</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Los presupuestos inactivos no se consideran en los reportes</small>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-between mt-4 pt-4 border-top">
                        <a href="{{ route('tesorero.presupuestos.index') }}" class="btn btn-cancel">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                        <button type="button" class="btn btn-submit" id="btnCrear">
                            <i class="fas fa-save me-2"></i>Crear Presupuesto
                        </button>
                    </div>
                </form>
                @endcan
            </div>
        </div>

        <!-- Sidebar con Información -->
        <div class="col-lg-4">
            <!-- Información -->
            <div class="info-box">
                <h5>
                    <i class="fas fa-lightbulb me-2"></i>
                    Consejos
                </h5>
                <ul>
                    <li>Define presupuestos realistas basados en gastos históricos</li>
                    <li>Considera un margen de seguridad del 10-15%</li>
                    <li>Revisa y ajusta mensualmente según necesidades</li>
                    <li>Las alertas te ayudarán a mantener el control</li>
                </ul>
            </div>

            <!-- Vista Previa -->
            <div class="preview-box" id="previewBox" style="display: none;">
                <h5>
                    <i class="fas fa-eye me-2"></i>
                    Vista Previa
                </h5>
                <div class="preview-item">
                    <strong>Categoría:</strong>
                    <span id="previewCategoria">-</span>
                </div>
                <div class="preview-item">
                    <strong>Presupuesto:</strong>
                    <span id="previewMonto" class="text-primary">L. 0.00</span>
                </div>
                <div class="preview-item">
                    <strong>Período:</strong>
                    <span id="previewPeriodo">-</span>
                </div>
            </div>

            <!-- Guía Rápida -->
            <div class="warning-card mt-3">
                <h6>
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Importante
                </h6>
                <p>No puedes crear dos presupuestos para la misma categoría en el mismo período. Si necesitas modificar uno existente, usa la opción de editar.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Manejo de nueva categoría
document.getElementById('categoria').addEventListener('change', function() {
    const nuevaCategoriaDiv = document.getElementById('nuevaCategoriaDiv');
    const nuevaCategoriaInput = document.getElementById('nuevaCategoria');

    if (this.value === '__nueva__') {
        nuevaCategoriaDiv.style.display = 'block';
        nuevaCategoriaInput.required = true;
    } else {
        nuevaCategoriaDiv.style.display = 'none';
        nuevaCategoriaInput.required = false;
    }

    actualizarPreview();
});

// Si se escribe una nueva categoría, actualizar el valor del select
document.getElementById('nuevaCategoria').addEventListener('input', function() {
    const selectCategoria = document.getElementById('categoria');

    if (this.value.trim() !== '') {
        // Crear/actualizar la opción personalizada
        let optionPersonalizada = selectCategoria.querySelector('option[value="' + this.value + '"]');
        if (!optionPersonalizada) {
            optionPersonalizada = document.createElement('option');
            selectCategoria.insertBefore(optionPersonalizada, selectCategoria.querySelector('option[value="__nueva__"]'));
        }
        optionPersonalizada.value = this.value;
        optionPersonalizada.textContent = this.value;
        optionPersonalizada.selected = true;
    }

    actualizarPreview();
});

// Vista previa en tiempo real
const inputs = ['categoria', 'monto_presupuestado', 'mes', 'anio'];
inputs.forEach(id => {
    const element = document.getElementById(id);
    if (element) {
        element.addEventListener('change', actualizarPreview);
        element.addEventListener('input', actualizarPreview);
    }
});

function actualizarPreview() {
    const categoria = document.getElementById('categoria').value === '__nueva__'
        ? document.getElementById('nuevaCategoria').value
        : document.getElementById('categoria').options[document.getElementById('categoria').selectedIndex]?.text;
    const monto = document.getElementById('monto_presupuestado').value;
    const mes = document.getElementById('mes').options[document.getElementById('mes').selectedIndex]?.text;
    const anio = document.getElementById('anio').value;

    const previewBox = document.getElementById('previewBox');

    if (categoria && monto && mes && anio) {
        previewBox.style.display = 'block';
        document.getElementById('previewCategoria').textContent = categoria || '-';
        document.getElementById('previewMonto').textContent = 'L. ' + parseFloat(monto || 0).toFixed(2);
        document.getElementById('previewPeriodo').textContent = mes + ' ' + anio;
    } else {
        previewBox.style.display = 'none';
    }
}

// Validación antes de enviar
document.getElementById('formPresupuesto').addEventListener('submit', function(e) {
    const categoria = document.getElementById('categoria').value;

    if (categoria === '__nueva__') {
        const nuevaCategoria = document.getElementById('nuevaCategoria').value.trim();
        if (nuevaCategoria === '') {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Categoría requerida',
                text: 'Por favor escribe el nombre de la nueva categoría',
                confirmButtonColor: '#3b82f6'
            });
            return false;
        }
        // Actualizar el valor del select con la nueva categoría
        document.getElementById('categoria').value = nuevaCategoria;
    }
});

// Confirmación antes de crear
document.getElementById('btnCrear').addEventListener('click', function() {
    const form = document.getElementById('formPresupuesto');
    const categoriaSelect = document.querySelector('#categoria');
    const categoria = categoriaSelect.value === '__nueva__'
        ? document.getElementById('nuevaCategoria').value
        : categoriaSelect.options[categoriaSelect.selectedIndex].text;
    const monto = document.querySelector('[name="monto_presupuestado"]').value;
    const mes = document.querySelector('#mes option:checked').text;
    const anio = document.querySelector('#anio').value;

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    // Si es nueva categoría, actualizar el campo antes de enviar
    if (categoriaSelect.value === '__nueva__') {
        const nuevaCategoria = document.getElementById('nuevaCategoria').value.trim();
        if (nuevaCategoria === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Categoría requerida',
                text: 'Por favor escribe el nombre de la nueva categoría',
                confirmButtonColor: '#3b82f6'
            });
            return;
        }
        categoriaSelect.value = nuevaCategoria;
    }

    Swal.fire({
        title: '¿Crear presupuesto?',
        html: `
            <div class="text-start">
                <p><strong>Categoría:</strong> ${categoria}</p>
                <p><strong>Presupuesto:</strong> L. ${parseFloat(monto).toFixed(2)}</p>
                <p><strong>Período:</strong> ${mes} ${anio}</p>
                <hr>
                <p class="mb-0" style="color: #3b82f6;">
                    <i class="fas fa-info-circle me-2"></i>
                    Se creará un nuevo presupuesto para esta categoría
                </p>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-check me-2"></i>Sí, crear',
        cancelButtonText: '<i class="fas fa-times me-2"></i>Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
        confirmButtonColor: '#3b82f6'
    });
@endif
</script>
@endpush
