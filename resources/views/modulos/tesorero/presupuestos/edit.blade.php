@extends('modulos.tesorero.layout')

@section('title', 'Editar Presupuesto')

@push('styles')
<style>
    /* Fondo claro */
    body {
        background-color: #f8f9fa !important;
    }

    /* Header elegante estilo presupuestos */
    .edit-header {
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

    /* Warning box */
    .warning-box {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-left: 4px solid #f59e0b;
        padding: 1rem 1.25rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        color: #92400e;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .warning-box i {
        color: #d97706;
        font-size: 1.25rem;
        margin-top: 0.1rem;
    }

    .warning-box h5 {
        color: #92400e;
        font-weight: 700;
        margin-bottom: 0.25rem;
        font-size: 1rem;
    }

    .warning-box p {
        color: #92400e;
        margin: 0;
        font-size: 0.9rem;
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
    <div class="edit-header">
        <div class="edit-header-content">
            <a href="{{ route('tesorero.presupuestos.show', $presupuesto->id) }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1>
                    <i class="fas fa-edit"></i>
                    Editar Presupuesto
                </h1>
                <p>Modifica los datos del presupuesto de {{ $presupuesto->categoria }}</p>
            </div>
        </div>
    </div>

    <!-- Advertencia -->
    <div class="warning-box">
        <i class="fas fa-exclamation-triangle"></i>
        <div>
            <h5>Importante</h5>
            <p>Los cambios en el presupuesto afectarán los cálculos y alertas. Los gastos ya registrados no se modificarán, solo los cálculos de disponibilidad.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Formulario -->
            <div class="form-section">
                @can('finanzas.editar')
                <form action="{{ route('tesorero.presupuestos.update', $presupuesto->id) }}" method="POST" id="formPresupuesto">
                    @csrf
                    @method('PUT')

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
                                        <option value="{{ $cat }}" {{ old('categoria', $presupuesto->categoria) == $cat ? 'selected' : '' }}>
                                            {{ $cat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('categoria')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="monto_presupuestado" class="form-label required-field">Monto Presupuestado</label>
                            <div class="input-group">
                                <span class="input-group-text">L.</span>
                                <input type="number"
                                       name="monto_presupuestado"
                                       id="monto_presupuestado"
                                       class="form-control @error('monto_presupuestado') is-invalid @enderror"
                                       step="0.01"
                                       min="0"
                                       value="{{ old('monto_presupuestado', $presupuesto->monto_presupuestado) }}"
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
                        <div class="col-md-12 mb-3">
                            <label for="periodo" class="form-label required-field">Período (Mes/Año)</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                <input type="month"
                                       name="periodo"
                                       id="periodo"
                                       class="form-control @error('periodo') is-invalid @enderror"
                                       value="{{ old('periodo', $presupuesto->periodo ? \Carbon\Carbon::parse($presupuesto->periodo)->format('Y-m') : '') }}"
                                       required>
                            </div>
                            @error('periodo')
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
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea name="observaciones"
                                      id="observaciones"
                                      class="form-control @error('observaciones') is-invalid @enderror"
                                      rows="4"
                                      placeholder="Observaciones adicionales...">{{ old('observaciones', $presupuesto->observaciones) }}</textarea>
                            @error('observaciones')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="estado" class="form-label required-field">Estado del Presupuesto</label>
                            <select class="form-select @error('estado') is-invalid @enderror"
                                    name="estado"
                                    id="estado"
                                    required>
                                <option value="activa" {{ old('estado', $presupuesto->estado) == 'activa' ? 'selected' : '' }}>Activa</option>
                                <option value="inactiva" {{ old('estado', $presupuesto->estado) == 'inactiva' ? 'selected' : '' }}>Inactiva</option>
                                <option value="pausada" {{ old('estado', $presupuesto->estado) == 'pausada' ? 'selected' : '' }}>Pausada</option>
                                <option value="archivada" {{ old('estado', $presupuesto->estado) == 'archivada' ? 'selected' : '' }}>Archivada</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Los presupuestos inactivos no se consideran en los reportes</small>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-between mt-4 pt-4 border-top">
                        <a href="{{ route('tesorero.presupuestos.show', $presupuesto->id) }}" class="btn btn-cancel">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                        <button type="button" id="btnGuardar" class="btn btn-submit">
                            <i class="fas fa-save me-2"></i>Guardar Cambios
                        </button>
                    </div>
                </form>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Confirmación antes de guardar cambios
document.getElementById('btnGuardar').addEventListener('click', function() {
    const form = document.getElementById('formPresupuesto');

    // Validar formulario antes de mostrar confirmación
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    // Obtener valores del formulario
    const categoria = document.getElementById('categoria').selectedOptions[0].text;
    const presupuesto = parseFloat(document.getElementById('monto_presupuestado').value);
    const periodo = document.getElementById('periodo').value;
    const estado = document.getElementById('estado').selectedOptions[0].text;

    Swal.fire({
        title: '¿Confirmar actualización?',
        html: `
            <div style="text-align: left; padding: 10px;">
                <p><strong>Categoría:</strong> ${categoria}</p>
                <p><strong>Presupuesto:</strong> L. ${presupuesto.toFixed(2)}</p>
                <p><strong>Período:</strong> ${periodo}</p>
                <p><strong>Estado:</strong> ${estado}</p>
            </div>
            <p style="margin-top: 15px; color: #6b7280;">
                <i class="fas fa-info-circle"></i>
                Los gastos registrados no se modificarán
            </p>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-check me-2"></i>Sí, guardar',
        cancelButtonText: '<i class="fas fa-times me-2"></i>Cancelar'
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
