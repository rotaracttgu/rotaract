@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #2c3e50; min-height: 100vh;">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb p-3 rounded shadow-sm" style="background-color: #34495e;">
            <li class="breadcrumb-item"><a href="{{ route('tesorero.dashboard') }}" class="text-decoration-none text-white"><i class="fas fa-home"></i> Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tesorero.gastos.index') }}" class="text-decoration-none text-white">Gastos</a></li>
            <li class="breadcrumb-item active text-light" aria-current="page">Nuevo Registro</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header Card -->
            <div class="card border-0 shadow-lg mb-4" style="background-color: #34495e;">
                <div class="card-header py-4 border-0" style="background-color: #2c3e50; border-bottom: 2px solid #e74c3c;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 font-weight-bold text-white">
                                <i class="fas fa-plus-circle me-2 text-danger"></i> Registrar Nuevo Gasto
                            </h3>
                            <p class="mb-0 text-light opacity-75">Complete el formulario para registrar un nuevo gasto financiero</p>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="fas fa-file-invoice-dollar fa-3x text-danger opacity-50"></i>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4" style="background-color: #34495e;">
                    @if(session('error'))
                        <div class="alert alert-dismissible fade show border-0 shadow-sm" role="alert" style="background-color: #e74c3c; color: white;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                                <div>
                                    <h6 class="alert-heading mb-1">Error en el registro</h6>
                                    <p class="mb-0">{{ session('error') }}</p>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-dismissible fade show border-0 shadow-sm" role="alert" style="background-color: #e74c3c; color: white;">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-exclamation-circle fa-2x me-3 mt-1"></i>
                                <div class="flex-grow-1">
                                    <h6 class="alert-heading mb-2">Por favor corrija los siguientes errores:</h6>
                                    <ul class="mb-0 ps-3">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('tesorero.gastos.store') }}" method="POST" enctype="multipart/form-data" id="formGasto">
                        @csrf

                        <!-- Sección 1: Información Principal -->
                        <div class="card mb-4 border-0 shadow-sm" style="background-color: #2c3e50;">
                            <div class="card-header border-0" style="background-color: transparent;">
                                <h5 class="mb-0 text-white">
                                    <i class="fas fa-file-alt me-2"></i>Información Principal
                                </h5>
                            </div>
                            <div class="card-body" style="background-color: #2c3e50;">
                                <div class="row g-3">
                                    <!-- Descripción -->
                                    <div class="col-md-12">
                                        <label for="descripcion" class="form-label fw-bold text-white">
                                            <i class="fas fa-tag text-danger me-1"></i> Descripción 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control form-control-lg @error('descripcion') is-invalid @enderror" 
                                               id="descripcion" 
                                               name="descripcion" 
                                               value="{{ old('descripcion') }}" 
                                               placeholder="Ej: Pago de servicios públicos"
                                               required>
                                        <small class="text-muted">No se permiten más de 2 caracteres repetidos consecutivos.</small>
                                        @error('descripcion')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Categoría -->
                                    <div class="col-md-4">
                                        <label for="categoria" class="form-label fw-bold text-white">
                                            <i class="fas fa-layer-group text-info me-1"></i> Categoría 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('categoria') is-invalid @enderror" 
                                                style="background-color: #34495e; border: 1px solid #4a5f7f; color: #ecf0f1;"
                                                id="categoria" 
                                                name="categoria" 
                                                required>
                                            <option value="">-- Seleccione --</option>
                                            @foreach($categorias ?? ['Servicios', 'Suministros', 'Equipamiento'] as $cat)
                                                <option value="{{ $cat }}" {{ old('categoria') == $cat ? 'selected' : '' }}>
                                                    {{ $cat }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">No se permiten más de 2 caracteres repetidos consecutivos.</small>
                                        @error('categoria')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Monto -->
                                    <div class="col-md-4">
                                        <label for="monto" class="form-label fw-bold text-white">
                                            <i class="fas fa-dollar-sign text-danger me-1"></i> Monto (L.) 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text" style="background-color: #e74c3c; border-color: #e74c3c; color: white;">L.</span>
                                            <input type="number" 
                                                   class="form-control @error('monto') is-invalid @enderror" 
                                                   style="background-color: #34495e; border: 1px solid #4a5f7f; color: #ecf0f1;"
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
                                        <label for="fecha" class="form-label fw-bold text-white">
                                            <i class="fas fa-calendar-alt text-primary me-1"></i> Fecha de Gasto 
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

                                    <!-- Prioridad -->
                                    <div class="col-md-6">
                                        <label for="prioridad" class="form-label fw-bold text-white">
                                            <i class="fas fa-exclamation-circle text-warning me-1"></i> Prioridad
                                        </label>
                                        <select class="form-select @error('prioridad') is-invalid @enderror" 
                                                id="prioridad" 
                                                name="prioridad">
                                            <option value="">-- Seleccione --</option>
                                            @foreach($prioridades ?? ['Baja', 'Media', 'Alta', 'Urgente'] as $prioridad)
                                                <option value="{{ $prioridad }}" {{ old('prioridad') == $prioridad ? 'selected' : '' }}>
                                                    {{ $prioridad }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('prioridad')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Número de Factura -->
                                    <div class="col-md-6">
                                        <label for="numero_factura" class="form-label fw-bold text-white">
                                            <i class="fas fa-hashtag text-secondary me-1"></i> Número de Factura (Automático)
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('numero_factura') is-invalid @enderror" 
                                               id="numero_factura" 
                                               name="numero_factura" 
                                               value="{{ old('numero_factura', $numero_factura ?? 'FAC-2025-001') }}"
                                               readonly
                                               style="background-color: #2c3e50; border: 1px solid #4a5f7f; color: #ecf0f1;">
                                        @error('numero_factura')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección 2: Detalles de Pago -->
                        <div class="card mb-4 border-0 shadow-sm" style="background-color: #2c3e50;">
                            <div class="card-header border-0" style="background-color: transparent;">
                                <h5 class="mb-0 text-white">
                                    <i class="fas fa-credit-card me-2"></i>Detalles de Pago
                                </h5>
                            </div>
                            <div class="card-body" style="background-color: #2c3e50;">
                                <div class="row g-3">
                                    <!-- Proveedor -->
                                    <div class="col-md-6">
                                        <label for="proveedor" class="form-label fw-bold text-white">
                                            <i class="fas fa-building text-secondary me-1"></i> Proveedor
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('proveedor') is-invalid @enderror" 
                                               id="proveedor" 
                                               name="proveedor" 
                                               value="{{ old('proveedor') }}"
                                               placeholder="Ej: Empresa ABC">
                                        <small class="text-muted">No se permiten más de 2 caracteres repetidos consecutivos.</small>
                                        @error('proveedor')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Método de Pago -->
                                    <div class="col-md-6">
                                        <label for="metodo_pago" class="form-label fw-bold text-white">
                                            <i class="fas fa-money-check-alt text-warning me-1"></i> Método de Pago
                                        </label>
                                        <select class="form-select @error('metodo_pago') is-invalid @enderror" 
                                                id="metodo_pago" 
                                                name="metodo_pago">
                                            <option value="">-- Seleccione --</option>
                                            @foreach($metodos_pago ?? [] as $valor => $etiqueta)
                                                <option value="{{ $valor }}" {{ old('metodo_pago') == $valor ? 'selected' : '' }}>
                                                    {{ $etiqueta }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('metodo_pago')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Estado de Aprobación -->
                                    <div class="col-md-12">
                                        <label for="estado_aprobacion" class="form-label fw-bold text-white">
                                            <i class="fas fa-check-circle text-success me-1"></i> Estado de Aprobación
                                        </label>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="estado_aprobacion" id="pendiente" value="pendiente" {{ old('estado_aprobacion', 'pendiente') == 'pendiente' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning" for="pendiente">
                                                <i class="fas fa-clock"></i> Pendiente
                                            </label>

                                            <input type="radio" class="btn-check" name="estado_aprobacion" id="aprobado" value="aprobado" {{ old('estado_aprobacion') == 'aprobado' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success" for="aprobado">
                                                <i class="fas fa-check"></i> Aprobado
                                            </label>

                                            <input type="radio" class="btn-check" name="estado_aprobacion" id="rechazado" value="rechazado" {{ old('estado_aprobacion') == 'rechazado' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger" for="rechazado">
                                                <i class="fas fa-times"></i> Rechazado
                                            </label>
                                        </div>
                                        @error('estado_aprobacion')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección 3: Documentación y Notas -->
                        <div class="card mb-4 border-0 shadow-sm" style="background-color: #2c3e50;">
                            <div class="card-header border-0" style="background-color: transparent;">
                                <h5 class="mb-0 text-white">
                                    <i class="fas fa-paperclip me-2"></i>Documentación y Notas
                                </h5>
                            </div>
                            <div class="card-body" style="background-color: #2c3e50;">
                                <div class="row g-3">
                                    <!-- Comprobante -->
                                    <div class="col-md-12">
                                        <label for="comprobante" class="form-label fw-bold text-white">
                                            <i class="fas fa-file-upload text-info me-1"></i> Comprobante / Factura
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
                                        <label for="notas" class="form-label fw-bold text-white">
                                            <i class="fas fa-align-left text-secondary me-1"></i> Notas / Observaciones
                                        </label>
                                        <textarea class="form-control @error('notas') is-invalid @enderror" 
                                                  id="notas" 
                                                  name="notas" 
                                                  rows="4"
                                                  placeholder="Agregue información adicional sobre este gasto...">{{ old('notas') }}</textarea>
                                        <small class="text-muted">No se permiten más de 2 caracteres repetidos consecutivos.</small>
                                        @error('notas')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="card border-0 shadow-sm" style="background-color: #2c3e50;">
                            <div class="card-body" style="background-color: #2c3e50;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('tesorero.gastos.index') }}" class="btn btn-lg px-4" style="background-color: #7f8c8d; color: white; border: none;">
                                        <i class="fas fa-arrow-left me-2"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-lg px-5" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; border: none;">
                                        <i class="fas fa-save me-2"></i> Guardar Gasto
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
    /* Fondo oscuro general */
    body {
        background-color: #2c3e50 !important;
    }

    /* Cards oscuros */
    .card {
        background-color: #34495e !important;
        border: none !important;
    }

    .card-body {
        background-color: #34495e !important;
    }

    /* Formularios oscuros - estilos globales */
    .form-control, .form-select {
        background-color: #34495e !important;
        border: 1px solid #4a5f7f !important;
        color: #ecf0f1 !important;
    }

    .form-control:focus, .form-select:focus {
        background-color: #34495e !important;
        border-color: #e74c3c !important;
        box-shadow: 0 0 0 0.25rem rgba(231, 76, 60, 0.25) !important;
        color: #ecf0f1 !important;
    }

    .form-control::placeholder {
        color: #95a5a6 !important;
    }

    /* Selects - opciones */
    .form-select option {
        background-color: #34495e !important;
        color: #ecf0f1 !important;
    }

    /* Input type date - calendar icon */
    .form-control[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
    }

    /* Labels */
    .form-label {
        color: #ecf0f1 !important;
    }

    /* Text colors */
    .text-white {
        color: #ecf0f1 !important;
    }

    .text-light {
        color: #bdc3c7 !important;
    }

    /* Botones outline */
    .btn-outline-warning {
        color: #f39c12 !important;
        border-color: #f39c12 !important;
    }

    .btn-outline-success {
        color: #27ae60 !important;
        border-color: #27ae60 !important;
    }

    .btn-outline-danger {
        color: #e74c3c !important;
        border-color: #e74c3c !important;
    }

    /* Checked buttons */
    .btn-check:checked + .btn-outline-warning {
        background-color: #f39c12 !important;
        border-color: #f39c12 !important;
        color: white !important;
    }

    .btn-check:checked + .btn-outline-success {
        background-color: #27ae60 !important;
        border-color: #27ae60 !important;
        color: white !important;
    }

    .btn-check:checked + .btn-outline-danger {
        background-color: #e74c3c !important;
        border-color: #e74c3c !important;
        color: white !important;
    }

    /* File input */
    .form-control[type="file"] {
        color: #ecf0f1 !important;
    }

    .form-control[type="file"]::file-selector-button {
        background-color: #4a5f7f;
        color: #ecf0f1;
        border: none;
        padding: 0.375rem 0.75rem;
        margin-right: 0.75rem;
        border-radius: 0.25rem;
    }

    .form-control[type="file"]::file-selector-button:hover {
        background-color: #5b6f8f;
    }

    /* Textarea */
    textarea.form-control {
        background-color: #34495e !important;
        border: 1px solid #4a5f7f !important;
        color: #ecf0f1 !important;
    }

    /* Small text */
    small.text-muted {
        color: #95a5a6 !important;
    }

    /* Input group text */
    .input-group-text {
        background-color: #34495e;
        border: 1px solid #4a5f7f;
        color: #ecf0f1;
    }
</style>
@endpush

@push('scripts')
<script>
    // Formatear el campo de monto
    document.getElementById('monto').addEventListener('blur', function() {
        let value = parseFloat(this.value);
        if (!isNaN(value)) {
            this.value = value.toFixed(2);
        }
    });
    
    // Preview del archivo
    document.getElementById('comprobante').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            const fileSize = (e.target.files[0].size / 1024 / 1024).toFixed(2);
            const small = this.parentElement.nextElementSibling;
            small.innerHTML = `<i class="fas fa-check-circle me-2 text-success"></i><span><strong>${fileName}</strong> (${fileSize} MB)</span>`;
        }
    });
    
    // Animación al enviar
    document.getElementById('formGasto').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Guardando...';
        submitBtn.disabled = true;
    });
</script>
@endpush
@endsection
