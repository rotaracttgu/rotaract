@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
            <li class="breadcrumb-item"><a href="{{ route('tesorero.dashboard') }}" class="text-decoration-none"><i class="fas fa-home"></i> Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tesorero.ingresos.index') }}" class="text-decoration-none">Ingresos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nuevo Registro</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header Card -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-gradient-success text-white py-4 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 font-weight-bold">
                                <i class="fas fa-plus-circle me-2"></i> Registrar Nuevo Ingreso
                            </h3>
                            <p class="mb-0 opacity-75">Complete el formulario para registrar un nuevo ingreso financiero</p>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="fas fa-money-bill-wave fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                                <div>
                                    <h6 class="alert-heading mb-1">Error en el registro</h6>
                                    <p class="mb-0">{{ session('error') }}</p>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('tesorero.ingresos.store') }}" method="POST" enctype="multipart/form-data" id="formIngreso">
                        @csrf

                        <!-- Sección 1: Información Principal -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light border-bottom">
                                <h5 class="mb-0 text-success">
                                    <i class="fas fa-file-alt me-2"></i>Información Principal
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Concepto -->
                                    <div class="col-md-12">
                                        <label for="descripcion" class="form-label fw-bold">
                                            <i class="fas fa-tag text-success me-1"></i> Concepto 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control form-control-lg @error('descripcion') is-invalid @enderror" 
                                               id="descripcion" 
                                               name="descripcion" 
                                               value="{{ old('descripcion') }}" 
                                               placeholder="Ej: Pago de membresía enero 2025"
                                               required>
                                        @error('descripcion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Tipo -->
                                    <div class="col-md-4">
                                        <label for="fuente" class="form-label fw-bold">
                                            <i class="fas fa-layer-group text-info me-1"></i> Tipo de Ingreso 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('fuente') is-invalid @enderror" 
                                                id="fuente" 
                                                name="fuente" 
                                                required>
                                            <option value="">-- Seleccione --</option>
                                            @foreach($fuentes ?? ['Membresías', 'Donaciones', 'Eventos', 'Servicios', 'Ventas', 'Patrocinios', 'Intereses Bancarios', 'Otros'] as $fuente)
                                                <option value="{{ $fuente }}" {{ old('fuente') == $fuente ? 'selected' : '' }}>
                                                    {{ $fuente }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('fuente')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Monto -->
                                    <div class="col-md-4">
                                        <label for="monto" class="form-label fw-bold">
                                            <i class="fas fa-dollar-sign text-success me-1"></i> Monto (L.) 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success text-white">L.</span>
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

                                    <!-- Fecha -->
                                    <div class="col-md-4">
                                        <label for="fecha" class="form-label fw-bold">
                                            <i class="fas fa-calendar-alt text-primary me-1"></i> Fecha de Ingreso 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" 
                                               class="form-control @error('fecha') is-invalid @enderror" 
                                               id="fecha" 
                                               name="fecha" 
                                               value="{{ old('fecha', date('Y-m-d')) }}"
                                               required>
                                        @error('fecha')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección 2: Detalles de Pago -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light border-bottom">
                                <h5 class="mb-0 text-success">
                                    <i class="fas fa-credit-card me-2"></i>Detalles de Pago
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Categoría -->
                                    <div class="col-md-6">
                                        <label for="categoria" class="form-label fw-bold">
                                            <i class="fas fa-tags text-info me-1"></i> Categoría
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('categoria') is-invalid @enderror" 
                                                id="categoria" 
                                                name="categoria"
                                                required>
                                            <option value="">-- Seleccione --</option>
                                            @foreach($categorias ?? ['Membresías', 'Donaciones', 'Eventos', 'Servicios'] as $cat)
                                                <option value="{{ $cat }}" {{ old('categoria') == $cat ? 'selected' : '' }}>
                                                    {{ $cat }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('categoria')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Método de Pago -->
                                    <div class="col-md-6">
                                        <label for="metodo_pago" class="form-label fw-bold">
                                            <i class="fas fa-money-check-alt text-warning me-1"></i> Método de Pago
                                        </label>
                                        <select class="form-select @error('metodo_pago') is-invalid @enderror" 
                                                id="metodo_pago" 
                                                name="metodo_pago">
                                            <option value="">-- Seleccione --</option>
                                            @foreach($metodos_pago ?? ['Efectivo', 'Transferencia Bancaria'] as $metodo)
                                                <option value="{{ $metodo }}" {{ old('metodo_pago') == $metodo ? 'selected' : '' }}>
                                                    {{ $metodo }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('metodo_pago')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Estado (oculto, siempre confirmado) -->
                                    <input type="hidden" name="estado" value="confirmado">
                                </div>
                            </div>
                        </div>

                        <!-- Sección 3: Documentación y Notas -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light border-bottom">
                                <h5 class="mb-0 text-success">
                                    <i class="fas fa-paperclip me-2"></i>Documentación y Notas
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Comprobante -->
                                    <div class="col-md-12">
                                        <label for="comprobante" class="form-label fw-bold">
                                            <i class="fas fa-file-upload text-info me-1"></i> Comprobante
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-upload"></i></span>
                                            <input type="file" 
                                                   class="form-control @error('comprobante') is-invalid @enderror" 
                                                   id="comprobante" 
                                                   name="comprobante"
                                                   accept=".pdf,.jpg,.jpeg,.png">
                                            @error('comprobante')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="form-text text-muted d-flex align-items-center mt-2">
                                            <i class="fas fa-info-circle me-2 text-primary"></i> 
                                            <span>Formatos permitidos: PDF, JPG, PNG • Tamaño máximo: 5MB</span>
                                        </small>
                                    </div>

                                    <!-- Notas -->
                                    <div class="col-md-12">
                                        <label for="notas" class="form-label fw-bold">
                                            <i class="fas fa-align-left text-secondary me-1"></i> Notas Adicionales
                                        </label>
                                        <textarea class="form-control @error('notas') is-invalid @enderror" 
                                                  id="notas" 
                                                  name="notas" 
                                                  rows="4"
                                                  placeholder="Agregue información adicional sobre este ingreso...">{{ old('notas') }}</textarea>
                                        @error('notas')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('tesorero.ingresos.index') }}" class="btn btn-lg btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-lg btn-success px-5">
                                        <i class="fas fa-save me-2"></i> Guardar Ingreso
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Breadcrumb oscuro */
    .breadcrumb {
        background-color: rgba(42, 53, 68, 0.7) !important;
        border: 1px solid #4a5568;
    }

    .breadcrumb-item a {
        color: #818cf8 !important;
    }

    .breadcrumb-item.active {
        color: #e5e7eb !important;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        font-size: 1.2rem;
        color: #9ca3af;
    }

    /* Header verde oscuro */
    .bg-gradient-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    }
    
    /* Cards oscuros */
    .card {
        background-color: #2a3544 !important;
        border: 1px solid #4a5568 !important;
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.4) !important;
    }

    .card-header {
        background-color: rgba(52, 62, 79, 0.7) !important;
        border-bottom: 2px solid #4a5568 !important;
        color: #e5e7eb !important;
    }

    .card-header.bg-light {
        background-color: rgba(52, 62, 79, 0.7) !important;
    }

    .card-body {
        background-color: #2a3544 !important;
        color: #e5e7eb !important;
    }

    /* Formularios oscuros */
    .form-control, .form-select {
        background-color: rgba(42, 53, 68, 0.8) !important;
        border: 1px solid #4a5568 !important;
        color: #e5e7eb !important;
    }

    .form-control:focus, .form-select:focus {
        background-color: rgba(42, 53, 68, 0.9) !important;
        border-color: #10b981 !important;
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25) !important;
        color: #e5e7eb !important;
    }

    .form-control::placeholder {
        color: #9ca3af !important;
    }

    .form-label {
        color: #e5e7eb !important;
    }

    /* Textos */
    h3, h5, h6, p, label, small {
        color: #e5e7eb !important;
    }

    .text-success {
        color: #34d399 !important;
    }

    .text-info {
        color: #22d3ee !important;
    }

    .text-danger {
        color: #f87171 !important;
    }

    .text-warning {
        color: #fbbf24 !important;
    }

    .text-muted {
        color: #9ca3af !important;
    }

    /* Botones */
    .btn-check:checked + .btn-outline-success {
        background-color: #10b981 !important;
        border-color: #10b981 !important;
        color: white !important;
    }
    
    .btn-check:checked + .btn-outline-warning {
        background-color: #f59e0b !important;
        border-color: #f59e0b !important;
        color: #1e2836 !important;
    }
    
    .btn-check:checked + .btn-outline-danger {
        background-color: #ef4444 !important;
        border-color: #ef4444 !important;
        color: white !important;
    }

    .btn-outline-success {
        color: #34d399 !important;
        border-color: #4a5568 !important;
    }

    .btn-outline-success:hover {
        background-color: #10b981 !important;
        border-color: #10b981 !important;
        color: white !important;
    }

    .btn-outline-warning {
        color: #fbbf24 !important;
        border-color: #4a5568 !important;
    }

    .btn-outline-warning:hover {
        background-color: #f59e0b !important;
        border-color: #f59e0b !important;
        color: #1e2836 !important;
    }

    .btn-outline-danger {
        color: #f87171 !important;
        border-color: #4a5568 !important;
    }

    .btn-outline-danger:hover {
        background-color: #ef4444 !important;
        border-color: #ef4444 !important;
        color: white !important;
    }

    /* Alertas */
    .alert-danger {
        background-color: rgba(239, 68, 68, 0.15) !important;
        border-color: #ef4444 !important;
        color: #f87171 !important;
    }

    .alert-danger .alert-heading {
        color: #f87171 !important;
    }

    /* File input */
    .form-control[type="file"] {
        color: #e5e7eb !important;
    }

    .form-control[type="file"]::file-selector-button {
        background-color: #4a5568;
        color: #e5e7eb;
        border: none;
        padding: 0.375rem 0.75rem;
        margin-right: 0.75rem;
        border-radius: 0.25rem;
    }

    .form-control[type="file"]::file-selector-button:hover {
        background-color: #5b6fd8;
    }
</style>
@endpush

@push('scripts')
<script>
    // Formatear el campo de monto en tiempo real
    document.getElementById('monto').addEventListener('blur', function() {
        let value = parseFloat(this.value);
        if (!isNaN(value)) {
            this.value = value.toFixed(2);
        }
    });
    
    // Preview del archivo seleccionado
    document.getElementById('comprobante').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            const fileSize = (e.target.files[0].size / 1024 / 1024).toFixed(2);
            const small = this.parentElement.nextElementSibling;
            small.innerHTML = `<i class="fas fa-check-circle me-2 text-success"></i><span><strong>${fileName}</strong> (${fileSize} MB)</span>`;
        }
    });
    
    // Animación al enviar el formulario
    document.getElementById('formIngreso').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Guardando...';
        submitBtn.disabled = true;
    });
</script>
@endpush
@endsection
