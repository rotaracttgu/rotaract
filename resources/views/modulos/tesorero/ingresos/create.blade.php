@extends('layouts.app')

@section('content')
<style>
    .form-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 40px rgba(16, 185, 129, 0.2);
        color: white;
    }

    .form-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }

    .form-header p {
        opacity: 0.95;
        margin: 0;
        font-size: 0.85rem;
    }

    .form-section {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 0.8rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid #E2E8F0;
        border-top: 4px solid #10b981;
    }

    .form-section.section-blue {
        border-top-color: #3b82f6;
    }

    .form-section.section-purple {
        border-top-color: #a855f7;
    }

    .form-section-title {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 1rem;
        padding-bottom: 0.6rem;
        border-bottom: 2px solid #F1F5F9;
    }

    .form-section-title i {
        color: #10b981;
        background: #D1FAE5;
        padding: 0.5rem;
        border-radius: 8px;
        font-size: 1rem;
    }

    .form-section.section-blue .form-section-title i {
        color: #3b82f6;
        background: #dbeafe;
    }

    .form-section.section-purple .form-section-title i {
        color: #a855f7;
        background: #f3e8ff;
    }

    .form-section-title h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: #1E293B;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .form-row.full {
        grid-template-columns: 1fr;
    }

    .form-label {
        font-weight: 600;
        font-size: 0.8rem;
        color: #475569;
        margin-bottom: 0.4rem;
        display: block;
    }

    .form-label .text-danger {
        color: #ef4444;
    }

    .form-control, .form-select {
        border: 1.5px solid #E2E8F0;
        border-radius: 8px;
        padding: 0.6rem 0.8rem;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        background: #F8FAFC;
    }

    .form-control:focus, .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        background: white;
    }

    .form-control::placeholder {
        color: #94A3B8;
    }

    small {
        color: #64748B;
        font-size: 0.7rem;
    }

    .input-group-text {
        background: #10b981;
        color: white;
        border: none;
        font-weight: 600;
    }

    .btn-modern {
        padding: 0.7rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-cancel {
        background: #E2E8F0;
        color: #64748B;
        text-decoration: none;
    }

    .btn-cancel:hover {
        background: #CBD5E1;
        color: #1E293B;
    }

    .btn-submit {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(16, 185, 129, 0.3);
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
    }

    .full-width {
        grid-column: 1 / -1;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .btn-group-estado {
        display: flex;
        gap: 0.5rem;
    }

    .btn-check:checked + .btn-outline-success {
        background: #10b981;
        border-color: #10b981;
        color: white;
    }

    .btn-check:checked + .btn-outline-warning {
        background: #f59e0b;
        border-color: #f59e0b;
        color: white;
    }

    .btn-check:checked + .btn-outline-danger {
        background: #ef4444;
        border-color: #ef4444;
        color: white;
    }
</style>

<div style="background: #F8FAFC; min-height: 100vh; padding: 1.5rem;">
    <!-- Header -->
    <div class="form-header">
        <h1><i class="fas fa-plus-circle me-2"></i>Registrar Nuevo Ingreso</h1>
        <p>Complete el formulario para registrar un nuevo ingreso financiero</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('tesorero.ingresos.store') }}" method="POST" enctype="multipart/form-data" id="formIngreso">
        @csrf

        <!-- Sección: Información Principal -->
        <div class="form-section">
            <div class="form-section-title">
                <i class="fas fa-file-alt"></i>
                <h5>Información Principal</h5>
            </div>

            <div class="form-row full">
                <div>
                    <label class="form-label">Concepto <span class="text-danger">*</span></label>
                    <input type="text" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" 
                           value="{{ old('descripcion') }}" placeholder="Ej: Pago de membresía enero 2025" required>
                    <small>No se permiten más de 2 caracteres repetidos consecutivos.</small>
                    @error('descripcion')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label class="form-label">Tipo de Ingreso <span class="text-danger">*</span></label>
                    <select name="fuente" class="form-select @error('fuente') is-invalid @enderror" required>
                        <option value="">-- Seleccione --</option>
                        @foreach($fuentes ?? ['Membresías', 'Donaciones', 'Eventos', 'Servicios', 'Ventas', 'Patrocinios', 'Intereses Bancarios', 'Otros'] as $fuente)
                            <option value="{{ $fuente }}" {{ old('fuente') == $fuente ? 'selected' : '' }}>{{ $fuente }}</option>
                        @endforeach
                    </select>
                    @error('fuente')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                    <div>
                    <label class="form-label">Monto (L.) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">L.</span>
                        <input type="number" name="monto" id="monto" class="form-control @error('monto') is-invalid @enderror" 
                               value="{{ old('monto') }}" step="0.01" min="0.01" placeholder="0.00" required>
                        @error('monto')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="form-label">Fecha de Ingreso <span class="text-danger">*</span></label>
                    <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" 
                           value="{{ old('fecha', date('Y-m-d')) }}" required>
                    @error('fecha')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Sección: Detalles de Pago -->
        <div class="form-section section-blue">
            <div class="form-section-title">
                <i class="fas fa-credit-card"></i>
                <h5>Detalles de Pago</h5>
            </div>
            <div class="form-row">
                <div>
                    <label class="form-label">Categoría <span class="text-danger">*</span></label>
                    <select name="categoria" class="form-select @error('categoria') is-invalid @enderror" required>
                        <option value="">-- Seleccione --</option>
                        @foreach($categorias ?? ['Membresías', 'Donaciones', 'Eventos', 'Servicios'] as $cat)
                            <option value="{{ $cat }}" {{ old('categoria') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    <small>No se permiten más de 2 caracteres repetidos consecutivos.</small>
                    @error('categoria')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Método de Pago</label>
                    <select name="metodo_pago" class="form-select @error('metodo_pago') is-invalid @enderror">
                        <option value="">-- Seleccione --</option>
                        @foreach($metodos_pago ?? [] as $valor => $etiqueta)
                            <option value="{{ $valor }}" {{ old('metodo_pago') == $valor ? 'selected' : '' }}>{{ $etiqueta }}</option>
                        @endforeach
                    </select>
                    @error('metodo_pago')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <input type="hidden" name="estado" value="confirmado">
        </div>

        <!-- Sección: Documentación y Notas -->
        <div class="form-section section-purple">
            <div class="form-section-title">
                <i class="fas fa-paperclip"></i>
                <h5>Documentación y Notas</h5>
            </div>

            <div class="form-row full">
                <div>
                    <label class="form-label">Comprobante</label>
                    <input type="file" name="comprobante" class="form-control @error('comprobante') is-invalid @enderror" 
                           accept=".pdf,.jpg,.jpeg,.png" id="comprobante">
                    <small><i class="fas fa-info-circle me-1"></i>Formatos permitidos: PDF, JPG, PNG • Tamaño máximo: 5MB</small>
                    @error('comprobante')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Notas Adicionales</label>
                    <textarea name="notas" class="form-control @error('notas') is-invalid @enderror" 
                              rows="4" placeholder="Agregue información adicional sobre este ingreso...">{{ old('notas') }}</textarea>
                    <small>No se permiten más de 2 caracteres repetidos consecutivos.</small>
                    @error('notas')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="form-actions">
            <a href="{{ route('tesorero.ingresos.index') }}" class="btn-modern btn-cancel">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="btn-modern btn-submit">
                <i class="fas fa-check"></i> Guardar Ingreso
            </button>
        </div>
    </form>
</div>

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
            const small = this.nextElementSibling;
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
