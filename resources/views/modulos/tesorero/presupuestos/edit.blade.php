@extends('modulos.tesorero.layout')

@section('title', 'Editar Presupuesto')

@push('styles')
<style>
    body {
        background-color: #1e2836 !important;
    }

    .edit-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        color: white !important;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
    }

    .edit-header h1, .edit-header p {
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

    .form-card {
        background: #2a3544 !important;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        padding: 2rem;
    }

    .section-title {
        color: #3b82f6 !important;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid #3b82f6;
        opacity: 1 !important;
    }

    .form-label {
        font-weight: 600;
        color: #e5e7eb !important;
        margin-bottom: 0.5rem;
        opacity: 1 !important;
    }

    .form-control, .form-select {
        background-color: rgba(42, 53, 68, 0.8) !important;
        color: #ffffff !important;
        border-radius: 10px;
        border: 2px solid #3d4757;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        background-color: rgba(42, 53, 68, 0.9) !important;
        color: #ffffff !important;
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }

    .form-control::placeholder {
        color: #9ca3af !important;
        opacity: 0.7;
    }

    .form-select option {
        background-color: #2a3544;
        color: #ffffff;
    }

    .input-group-text {
        background-color: rgba(42, 53, 68, 0.8) !important;
        color: #3b82f6 !important;
        border: 2px solid #3d4757;
        border-right: none;
    }

    .btn-purple {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        border: none;
        color: white !important;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-purple:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        color: white !important;
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

    .warning-box {
        background: rgba(245, 158, 11, 0.15) !important;
        border-left: 4px solid #f59e0b;
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        color: #fbbf24 !important;
    }

    .warning-box * {
        color: #fbbf24 !important;
        opacity: 1 !important;
    }

    .text-warning {
        color: #fbbf24 !important;
    }

    .required-field::after {
        content: " *";
        color: #ef4444;
    }

    .text-danger {
        color: #fca5a5 !important;
    }

    .is-invalid {
        border-color: #ef4444 !important;
    }

    /* Texto general visible */
    p, span, label, div, small, h1, h2, h3, h4, h5, h6 {
        opacity: 1 !important;
    }

    .text-muted {
        color: #9ca3af !important;
    }

    /* Alertas */
    .alert {
        background-color: #2a3544 !important;
        border: 1px solid #3d4757;
        color: #e5e7eb !important;
    }

    .alert * {
        color: #e5e7eb !important;
    }
</style>
@endpush

@section('content')
    <!-- Header -->
    <div class="edit-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-2">
                    <i class="fas fa-edit me-2"></i>
                    Editar Presupuesto
                </h1>
                <p class="mb-0 opacity-75">Modifica los datos del presupuesto de {{ $presupuesto->categoria }}</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('tesorero.presupuestos.show', $presupuesto->id) }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>
                    Volver
                </a>
            </div>
        </div>
    </div>

    <!-- Advertencia -->
    <div class="warning-box">
        <h5 class="fw-bold text-warning mb-2">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Importante
        </h5>
        <p class="mb-0">
            Los cambios en el presupuesto afectarán los cálculos y alertas. 
            Los gastos ya registrados no se modificarán, solo los cálculos de disponibilidad.
        </p>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Formulario -->
            <div class="form-card">
                @can('finanzas.editar')
                <form action="{{ route('tesorero.presupuestos.update', $presupuesto->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Información del Presupuesto -->
                    <h4 class="section-title">
                        <i class="fas fa-info-circle me-2"></i>
                        Información del Presupuesto
                    </h4>

                    <div class="row mb-3">
                        <div class="col-md-6">
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

                        <div class="col-md-6">
                            <label for="monto_presupuestado" class="form-label required-field">Monto Presupuestado</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                                <input type="number" 
                                       name="monto_presupuestado" 
                                       id="monto_presupuestado" 
                                       class="form-control @error('monto_presupuestado') is-invalid @enderror" 
                                       step="0.01" 
                                       min="0" 
                                       value="{{ old('monto_presupuestado', $presupuesto->monto_presupuestado) }}"
                                       required>
                                <span class="input-group-text">L.</span>
                            </div>
                            @error('monto_presupuestado')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Período -->
                    <h4 class="section-title mt-4">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Período
                    </h4>

                    <div class="row mb-3">
                        <div class="col-md-12">
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
                    <h4 class="section-title mt-4">
                        <i class="fas fa-file-alt me-2"></i>
                        Detalles Adicionales
                    </h4>

                    <div class="mb-3">
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

                    <div class="mb-3">
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

                    <!-- Botones -->
                    <div class="d-flex justify-content-between mt-4 pt-4 border-top">
                        <a href="{{ route('tesorero.presupuestos.show', $presupuesto->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>
                            Cancelar
                        </a>
                        <button type="button" id="btnGuardar" class="btn btn-purple btn-lg">
                            <i class="fas fa-save me-2"></i>
                            Guardar Cambios
                        </button>
                    </div>
                </form>
                @endcan
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Confirmación antes de guardar cambios
    document.getElementById('btnGuardar').addEventListener('click', function() {
        const form = this.closest('form');
        
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
                <p style="margin-top: 15px; color: #666;">
                    <i class="fas fa-info-circle"></i> 
                    Los gastos registrados no se modificarán
                </p>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#667eea',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-check me-2"></i>Sí, guardar',
            cancelButtonText: '<i class="fas fa-times me-2"></i>Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            confirmButtonColor: '#667eea'
        });
    </script>
@endif
@endpush
@endsection
