@extends('modulos.tesorero.layout')

@section('title', 'Crear Presupuesto')

@push('styles')
<style>
    body {
        background-color: #1e2836 !important;
    }

    .create-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        color: white !important;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
    }

    .create-header h1, .create-header p {
        color: #ffffff !important;
        opacity: 1 !important;
    }

    .create-header .btn-light {
        background: rgba(255,255,255,0.2) !important;
        border: none;
        color: #ffffff !important;
    }

    .create-header .btn-light:hover {
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

    .info-box {
        background: rgba(59, 130, 246, 0.15) !important;
        border-left: 4px solid #3b82f6;
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        color: #60a5fa !important;
    }

    .info-box * {
        color: #60a5fa !important;
        opacity: 1 !important;
    }

    .preview-box {
        background: rgba(42, 53, 68, 0.8) !important;
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 2rem;
        border: 1px solid #3d4757;
    }

    .preview-box * {
        color: #e5e7eb !important;
        opacity: 1 !important;
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
    <div class="create-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-2">
                    <i class="fas fa-plus-circle me-2"></i>
                    Crear Nuevo Presupuesto
                </h1>
                <p class="mb-0 opacity-75">Define el presupuesto para una categoría y período</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('tesorero.presupuestos.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>
                    Volver
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Formulario -->
            <div class="form-card">
                @can('finanzas.crear')
                <form action="{{ route('tesorero.presupuestos.store') }}" method="POST" id="formPresupuesto">
                    @csrf

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

                        <div class="col-md-6">
                            <label for="monto_presupuestado" class="form-label required-field">Presupuesto Mensual</label>
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
                                       value="{{ old('monto_presupuestado') }}"
                                       placeholder="0.00"
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
                        <div class="col-md-6">
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

                        <div class="col-md-6">
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
                    <h4 class="section-title mt-4">
                        <i class="fas fa-file-alt me-2"></i>
                        Detalles Adicionales
                    </h4>

                    <div class="mb-3">
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

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-toggle-on me-1"></i>
                            Estado del Presupuesto
                        </label>
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

                    <!-- Botones -->
                    <div class="d-flex justify-content-between mt-4 pt-4 border-top">
                        <a href="{{ route('tesorero.presupuestos.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>
                            Cancelar
                        </a>
                        <button type="button" class="btn btn-purple btn-lg" id="btnCrear">
                            <i class="fas fa-save me-2"></i>
                            Crear Presupuesto
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
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-lightbulb me-2"></i>
                    Consejos
                </h5>
                <ul class="mb-0 ps-3">
                    <li class="mb-2">Define presupuestos realistas basados en gastos históricos</li>
                    <li class="mb-2">Considera un margen de seguridad del 10-15%</li>
                    <li class="mb-2">Revisa y ajusta mensualmente según necesidades</li>
                    <li class="mb-2">Las alertas te ayudarán a mantener el control</li>
                </ul>
            </div>

            <!-- Vista Previa -->
            <div class="preview-box" id="previewBox" style="display: none;">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-eye me-2"></i>
                    Vista Previa
                </h5>
                <div class="mb-2">
                    <strong>Categoría:</strong>
                    <span id="previewCategoria" class="text-muted">-</span>
                </div>
                <div class="mb-2">
                    <strong>Presupuesto:</strong>
                    <span id="previewMonto" class="text-primary fw-bold">S/ 0.00</span>
                </div>
                <div class="mb-2">
                    <strong>Período:</strong>
                    <span id="previewPeriodo" class="text-muted">-</span>
                </div>
            </div>

            <!-- Guía Rápida -->
            <div class="card mt-3 border-0" style="background: #fff3cd;">
                <div class="card-body">
                    <h6 class="fw-bold text-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Importante
                    </h6>
                    <p class="small mb-0">
                        No puedes crear dos presupuestos para la misma categoría en el mismo período. 
                        Si necesitas modificar uno existente, usa la opción de editar.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

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
                    confirmButtonColor: '#667eea'
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
                    confirmButtonColor: '#667eea'
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
                    <p class="text-info mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Se creará un nuevo presupuesto para esta categoría
                    </p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#667eea',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-check me-2"></i>Sí, crear',
            cancelButtonText: '<i class="fas fa-times me-2"></i>Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@endsection
