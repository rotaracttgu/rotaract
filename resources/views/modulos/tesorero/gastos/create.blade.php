@extends('layouts.app')

@section('content')
<style>
    .form-header {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        padding: 1.5rem 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 40px rgba(239, 68, 68, 0.2);
        color: white;
    }

    .form-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        margin: 0;
    }

    .form-header p {
        opacity: 0.95;
        margin-bottom: 0;
        font-size: 0.85rem;
    }

    .form-section {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 0.8rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid #E2E8F0;
        border-top: 4px solid #ef4444;
    }

    .form-section.section-orange {
        border-top-color: #f97316;
    }

    .form-section.section-orange .form-section-title i {
        color: #f97316;
        background: #ffedd5;
        padding: 0.5rem;
        border-radius: 8px;
    }

    .form-section.section-blue {
        border-top-color: #3b82f6;
    }

    .form-section.section-blue .form-section-title i {
        color: #3b82f6;
        background: #dbeafe;
        padding: 0.5rem;
        border-radius: 8px;
    }

    .form-section.section-purple {
        border-top-color: #a855f7;
    }

    .form-section.section-purple .form-section-title i {
        color: #a855f7;
        background: #f3e8ff;
        padding: 0.5rem;
        border-radius: 8px;
    }

    .form-section-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.8rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #F1F5F9;
    }

    .form-section-title i {
        font-size: 1rem;
        color: #ef4444;
        transition: all 0.3s ease;
    }

    .form-section-title h5 {
        margin: 0;
        color: #1E293B;
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-label {
        font-weight: 600;
        color: #1E293B;
        margin-bottom: 0.35rem;
        font-size: 0.8rem;
    }

    .form-control, .form-select, textarea {
        border-radius: 8px;
        border: 2px solid #E2E8F0;
        padding: 0.6rem 0.75rem;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        background: white;
        color: #1E293B;
        font-family: inherit;
    }

    .form-control:focus, .form-select:focus, textarea:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        outline: none;
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23ef4444' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        padding-right: 2rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 0.75rem;
    }

    .form-row .full-width {
        grid-column: 1 / -1;
    }

    .invalid-feedback {
        font-size: 0.75rem;
        color: #ef4444;
        margin-top: 0.25rem;
        display: block;
    }

    .is-invalid {
        border-color: #ef4444 !important;
    }

    .form-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
        justify-content: flex-end;
    }

    .btn-modern {
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-cancel {
        background: #E2E8F0;
        color: #64748B;
    }

    .btn-cancel:hover {
        background: #CBD5E1;
        color: #1E293B;
    }

    .btn-submit {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .form-header {
            padding: 1rem;
        }

        .form-header h1 {
            font-size: 1.25rem;
        }
    }
</style>

<div class="px-3 py-3" style="background: #F8FAFC; min-height: 100vh;">
    <!-- Header -->
    <div class="form-header">
        <h1><i class="fas fa-plus-circle me-2"></i>Registrar Nuevo Gasto</h1>
        <p>Completa los datos del gasto a registrar</p>
    </div>

    <!-- Formulario -->
    <form action="{{ route('tesorero.gastos.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <!-- Campo estado oculto - por defecto pendiente -->
        <input type="hidden" name="estado" value="pendiente">

        <!-- Sección: Información del Gasto -->
        <div class="form-section section-orange">
            <div class="form-section-title">
                <i class="fas fa-receipt"></i>
                <h5>Información del Gasto</h5>
            </div>

            <div class="form-row">
                <div>
                    <label class="form-label">Descripción / Concepto *</label>
                    <input type="text" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" 
                           value="{{ old('descripcion') }}" placeholder="Ej: Papelería para oficina" required>
                    @error('descripcion')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Categoría *</label>
                    <select name="categoria" class="form-select @error('categoria') is-invalid @enderror" required>
                        <option value="">Seleccionar categoría</option>
                        <option value="Servicios" {{ old('categoria') === 'Servicios' ? 'selected' : '' }}>Servicios</option>
                        <option value="Suministros" {{ old('categoria') === 'Suministros' ? 'selected' : '' }}>Suministros</option>
                        <option value="Equipamiento" {{ old('categoria') === 'Equipamiento' ? 'selected' : '' }}>Equipamiento</option>
                    </select>
                    @error('categoria')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Monto (L.) *</label>
                    <input type="number" name="monto" class="form-control @error('monto') is-invalid @enderror" 
                           value="{{ old('monto') }}" placeholder="0.00" step="0.01" min="0" required>
                    @error('monto')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Fecha del Gasto *</label>
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
                    <label class="form-label">Proveedor / Beneficiario</label>
                    <input type="text" name="proveedor" class="form-control @error('proveedor') is-invalid @enderror" 
                           value="{{ old('proveedor') }}" placeholder="Nombre del proveedor (opcional)">
                    @error('proveedor')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Método de Pago *</label>
                    <select name="metodo_pago" class="form-select @error('metodo_pago') is-invalid @enderror" required>
                        <option value="">Seleccionar método</option>
                        <option value="efectivo" {{ old('metodo_pago') === 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                        <option value="transferencia" {{ old('metodo_pago') === 'transferencia' ? 'selected' : '' }}>Transferencia Bancaria</option>
                        <option value="tarjeta_credito" {{ old('metodo_pago') === 'tarjeta_credito' ? 'selected' : '' }}>Tarjeta de Crédito</option>
                        <option value="tarjeta_debito" {{ old('metodo_pago') === 'tarjeta_debito' ? 'selected' : '' }}>Tarjeta de Débito</option>
                        <option value="cheque" {{ old('metodo_pago') === 'cheque' ? 'selected' : '' }}>Cheque</option>
                        <option value="otro" {{ old('metodo_pago') === 'otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('metodo_pago')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Número de Factura / Referencia</label>
                    <input type="text" name="numero_factura" class="form-control @error('numero_factura') is-invalid @enderror" 
                           value="{{ old('numero_factura', $numeroFactura ?? '') }}" 
                           readonly 
                           style="background-color: #F3F4F6; cursor: not-allowed; color: #6B7280; font-weight: 600;">
                    <small style="color: #64748B; font-size: 0.75rem;"><i class="fas fa-info-circle me-1"></i>El número de factura se genera automáticamente</small>
                    @error('numero_factura')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Sección: Documentos -->
        <div class="form-section section-purple">
            <div class="form-section-title">
                <i class="fas fa-paperclip"></i>
                <h5>Documentos y Notas</h5>
            </div>

            <div class="form-row">
                <div class="full-width">
                    <label class="form-label">Comprobante (PDF, Imagen)</label>
                    <input type="file" name="comprobante_archivo" class="form-control @error('comprobante_archivo') is-invalid @enderror" 
                           accept=".pdf,.jpg,.jpeg,.png,.gif">
                    <small style="color: #64748B; font-size: 0.75rem;">Máximo 10MB. Formatos: PDF, JPG, PNG, GIF</small>
                    @error('comprobante_archivo')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="full-width">
                    <label class="form-label">Notas / Observaciones</label>
                    <textarea name="notas" class="form-control @error('notas') is-invalid @enderror" 
                              rows="4" placeholder="Agrega notas sobre este gasto...">{{ old('notas') }}</textarea>
                    @error('notas')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="form-actions">
            <a href="{{ route('tesorero.gastos.index') }}" class="btn-modern btn-cancel">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="btn-modern btn-submit">
                <i class="fas fa-check"></i> Registrar Gasto
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar mensajes de sesión
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Gasto registrado!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonColor: '#ef4444'
            });
        @endif

        // Mostrar errores de validación si existen
        @if($errors->any())
            let erroresHtml = '<ul style="text-align: left; margin-left: 20px;">';
            @foreach($errors->all() as $error)
                erroresHtml += '<li>{{ $error }}</li>';
            @endforeach
            erroresHtml += '</ul>';
            
            Swal.fire({
                icon: 'error',
                title: 'Errores de validación',
                html: erroresHtml,
                confirmButtonColor: '#ef4444'
            });
        @endif

        // Validación del formulario antes de enviar
        const form = document.querySelector('form');
        const btnSubmit = form.querySelector('button[type="submit"]');
        
        form.addEventListener('submit', function(e) {
            const descripcion = form.querySelector('input[name="descripcion"]').value.trim();
            const categoria = form.querySelector('select[name="categoria"]').value;
            const monto = form.querySelector('input[name="monto"]').value;
            const fecha = form.querySelector('input[name="fecha"]').value;
            const metodoPago = form.querySelector('select[name="metodo_pago"]').value;
            
            if (!descripcion || !categoria || !monto || !fecha || !metodoPago) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos requeridos',
                    text: 'Por favor, completa todos los campos obligatorios marcados con *',
                    confirmButtonColor: '#ef4444'
                });
                return false;
            }

            if (parseFloat(monto) <= 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Monto inválido',
                    text: 'El monto debe ser mayor a 0',
                    confirmButtonColor: '#ef4444'
                });
                return false;
            }

            // Deshabilitar botón de envío y mostrar loading
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
        });
    });
</script>
@endpush

@endsection
