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

    .form-label .text-danger {
        color: #ef4444;
        margin-left: 0.25rem;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 2px solid #E2E8F0;
        padding: 0.6rem 0.75rem;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        background: white;
        color: #1E293B;
    }

    .form-control::placeholder {
        color: #94A3B8;
    }

    .form-control:focus, .form-select:focus {
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

    .form-text {
        font-size: 0.75rem;
        color: #64748B;
        margin-top: 0.25rem;
        display: block;
    }

    .invalid-feedback {
        display: block;
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        font-weight: 500;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .form-group {
        margin-bottom: 0;
    }

    .alert-info {
        background: #DBEAFE;
        border: 1px solid #BAE6FD;
        color: #0C4A6E;
        border-radius: 10px;
        padding: 0.75rem;
        margin-bottom: 1rem;
        font-size: 0.85rem;
    }

    .alert-info a {
        color: #0284C7;
        font-weight: 600;
        text-decoration: none;
    }

    .alert-info a:hover {
        text-decoration: underline;
    }

    .audit-info {
        background: linear-gradient(135deg, #fef2f2 0%, #f3e8ff 100%);
        border: 1px solid #fee2e2;
        border-radius: 10px;
        padding: 0.75rem;
        margin-bottom: 1rem;
        font-size: 0.75rem;
    }

    .audit-info small {
        color: #64748B;
    }

    .audit-info strong {
        color: #1E293B;
    }

    .form-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
        margin-top: 1rem;
        padding-top: 0.75rem;
        border-top: 2px solid #F1F5F9;
    }

    .btn-modern {
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        cursor: pointer;
    }

    .btn-cancel {
        background: #F1F5F9;
        color: #64748B;
    }

    .btn-cancel:hover {
        background: #E2E8F0;
        color: #1E293B;
        transform: translateY(-2px);
    }

    .btn-submit {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn-modern {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-fluid px-3 py-3">
    <!-- Header -->
    <div class="form-header">
        <h1>
            <i class="fas fa-edit me-2"></i>Editar Gasto #{{ $gasto->id }}
        </h1>
        <p>Actualiza los detalles del egreso</p>
    </div>

    <!-- Errores -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 1rem;">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @can('finanzas.editar')
    <form action="{{ route('tesorero.gastos.update', $gasto->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Información del Gasto -->
        <div class="form-section section-orange">
            <div class="form-section-title">
                <i class="fas fa-receipt"></i>
                <h5>Información del Gasto</h5>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label for="descripcion" class="form-label">Descripción <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" value="{{ old('descripcion', $gasto->descripcion ?? $gasto->concepto) }}" required>
                    @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="categoria" class="form-label">Categoría <span class="text-danger">*</span></label>
                    <select class="form-control @error('categoria') is-invalid @enderror" id="categoria" name="categoria" required>
                        <option value="">Seleccione...</option>
                        @foreach($categorias ?? ['Servicios', 'Suministros', 'Equipamiento', 'Mantenimiento', 'Viáticos', 'Otros'] as $cat)
                            <option value="{{ $cat }}" {{ old('categoria', $gasto->categoria ?? $gasto->tipo) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('categoria')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="monto" class="form-label">Monto (L.) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('monto') is-invalid @enderror" id="monto" name="monto" value="{{ old('monto', $gasto->monto) }}" step="0.01" min="0.01" required>
                    @error('monto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="fecha" class="form-label">Fecha de Gasto <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" value="{{ old('fecha', isset($gasto->fecha_gasto) ? \Carbon\Carbon::parse($gasto->fecha_gasto)->format('Y-m-d') : \Carbon\Carbon::parse($gasto->fecha)->format('Y-m-d')) }}" required>
                    @error('fecha')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                    <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                        <option value="pendiente" {{ old('estado', $gasto->estado ?? '') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="aprobado" {{ old('estado', $gasto->estado ?? '') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                        <option value="rechazado" {{ old('estado', $gasto->estado ?? '') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                        <option value="anulado" {{ old('estado', $gasto->estado ?? '') == 'anulado' ? 'selected' : '' }}>Anulado</option>
                        <option value="pagado" {{ old('estado', $gasto->estado ?? '') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                    </select>
                    @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <!-- Detalles de Pago -->
        <div class="form-section section-blue">
            <div class="form-section-title">
                <i class="fas fa-credit-card"></i>
                <h5>Detalles de Pago</h5>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="proveedor" class="form-label">Proveedor</label>
                    <input type="text" class="form-control" id="proveedor" name="proveedor" value="{{ old('proveedor', $gasto->proveedor ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="metodo_pago" class="form-label">Método de Pago <span class="text-danger">*</span></label>
                    <select class="form-control" id="metodo_pago" name="metodo_pago" required>
                        <option value="">Seleccione...</option>
                        <option value="efectivo" {{ old('metodo_pago', $gasto->metodo_pago ?? '') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                        <option value="transferencia" {{ old('metodo_pago', $gasto->metodo_pago ?? '') == 'transferencia' ? 'selected' : '' }}>Transferencia Bancaria</option>
                        <option value="tarjeta_credito" {{ old('metodo_pago', $gasto->metodo_pago ?? '') == 'tarjeta_credito' ? 'selected' : '' }}>Tarjeta de Crédito</option>
                        <option value="tarjeta_debito" {{ old('metodo_pago', $gasto->metodo_pago ?? '') == 'tarjeta_debito' ? 'selected' : '' }}>Tarjeta de Débito</option>
                        <option value="cheque" {{ old('metodo_pago', $gasto->metodo_pago ?? '') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                        <option value="otro" {{ old('metodo_pago', $gasto->metodo_pago ?? '') == 'otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label for="numero_factura" class="form-label">Número de Factura</label>
                    <input type="text" class="form-control" id="numero_factura" name="numero_factura" value="{{ $gasto->numero_factura ?? '' }}" readonly style="background-color: #F3F4F6; cursor: not-allowed; color: #6B7280; font-weight: 600;">
                    <small style="color: #64748B; font-size: 0.75rem;"><i class="fas fa-lock me-1"></i>Este campo no puede ser modificado</small>
                </div>
            </div>
        </div>

        <!-- Documentos -->
        <div class="form-section section-purple">
            <div class="form-section-title">
                <i class="fas fa-paperclip"></i>
                <h5>Documentos</h5>
            </div>

            @if(isset($gasto->comprobante_archivo) && $gasto->comprobante_archivo)
                <div class="alert alert-info" style="margin-bottom: 1rem;">
                    <i class="fas fa-file-alt me-2"></i>
                    <a href="{{ asset('storage/' . $gasto->comprobante_archivo) }}" target="_blank" class="text-primary">Ver comprobante actual</a>
                </div>
            @endif

            <div class="form-row full">
                <div class="form-group">
                    <label for="comprobante_archivo" class="form-label">{{ isset($gasto->comprobante_archivo) && $gasto->comprobante_archivo ? 'Cambiar Comprobante' : 'Adjuntar Comprobante' }}</label>
                    <input type="file" class="form-control @error('comprobante_archivo') is-invalid @enderror" id="comprobante_archivo" name="comprobante_archivo" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="form-text"><i class="fas fa-info-circle me-1"></i>Formatos: PDF, JPG, PNG. Máx: 5MB</small>
                    @error('comprobante_archivo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label for="notas" class="form-label">Notas Adicionales</label>
                    <textarea class="form-control @error('notas') is-invalid @enderror" id="notas" name="notas" rows="3" placeholder="Añade observaciones...">{{ old('notas', $gasto->notas ?? $gasto->observaciones ?? '') }}</textarea>
                    @error('notas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="form-actions">
            <a href="{{ route('tesorero.gastos.index') }}" class="btn-modern btn-cancel"><i class="fas fa-times"></i> Cancelar</a>
            <button type="submit" class="btn-modern btn-submit"><i class="fas fa-save"></i> Actualizar Gasto</button>
        </div>
    </form>
    @endcan
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
            const estado = form.querySelector('select[name="estado"]').value;
            
            if (!descripcion || !categoria || !monto || !fecha || !metodoPago || !estado) {
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
            btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Actualizando...';
        });
    });
</script>
@endpush

@endsection
