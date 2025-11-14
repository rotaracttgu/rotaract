@extends('layouts.app')

@section('content')
<style>
    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 1.5rem 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.2);
        color: white;
    }

    .form-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
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
        border-top: 4px solid #667eea;
    }

    .form-section.section-blue {
        border-top-color: #0EA5E9;
    }

    .form-section.section-blue .form-section-title i {
        color: #0EA5E9;
        background: #CFFAFE;
        padding: 0.5rem;
        border-radius: 8px;
    }

    .form-section.section-orange {
        border-top-color: #F97316;
    }

    .form-section.section-orange .form-section-title i {
        color: #F97316;
        background: #FFEDD5;
        padding: 0.5rem;
        border-radius: 8px;
    }

    .form-section.section-green {
        border-top-color: #10B981;
    }

    .form-section.section-green .form-section-title i {
        color: #10B981;
        background: #D1FAE5;
        padding: 0.5rem;
        border-radius: 8px;
    }

    .form-section.section-pink {
        border-top-color: #EC4899;
    }

    .form-section.section-pink .form-section-title i {
        color: #EC4899;
        background: #FCE7F3;
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
        color: #667eea;
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
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .form-control:disabled, .form-select:disabled {
        background: #F8FAFC;
        color: #94A3B8;
        border-color: #E2E8F0;
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23667eea' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        padding-right: 2rem;
    }

    .form-select option {
        background: white;
        color: #1E293B;
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

    .is-invalid {
        border-color: #ef4444 !important;
    }

    .alert-danger {
        background: #FEE2E2;
        border: 1px solid #FECACA;
        color: #991B1B;
        border-radius: 12px;
        padding: 0.875rem;
        margin-bottom: 1rem;
    }

    .alert-info {
        background: #DBEAFE;
        border: 1px solid #BAE6FD;
        color: #0C4A6E;
        border-radius: 12px;
        padding: 0.875rem;
        margin-bottom: 1rem;
    }

    .alert-info a {
        color: #0284C7;
        font-weight: 600;
        text-decoration: none;
    }

    .alert-info a:hover {
        text-decoration: underline;
    }

    .input-group-text {
        background: #F1F5F9 !important;
        border: 2px solid #E2E8F0 !important;
        border-right: none !important;
        color: #64748B !important;
    }

    .input-group .form-control {
        border-left: none !important;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .form-row.full {
        grid-template-columns: 1fr;
    }

    .form-group {
        margin-bottom: 0;
    }

    .audit-info {
        background: linear-gradient(135deg, #F0F9FF 0%, #F3E8FF 100%);
        border: 1px solid #E0E7FF;
        border-radius: 10px;
        padding: 0.75rem;
        margin-bottom: 1rem;
    }

    .audit-info small {
        color: #64748B;
        font-size: 0.75rem;
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    .divider {
        height: 1px;
        background: #F1F5F9;
        margin: 1rem 0;
    }

    @media (max-width: 768px) {
        .form-header h1 {
            font-size: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn-modern {
            width: 100%;
            justify-content: center;
        }

        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="form-header">
        <h1>
            <i class="fas fa-edit me-2"></i>Editar Ingreso #{{ $ingreso->id }}
        </h1>
        <p>Actualiza la información del movimiento financiero</p>
    </div>

    <!-- Errores -->
    @if(session('error'))
        <div class="alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        </div>
    @endif

    <form action="{{ route('tesorero.ingresos.update', $ingreso->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Sección: Información General -->
        <div class="form-section section-blue">
            <div class="form-section-title">
                <i class="fas fa-info-circle"></i>
                <h5>Información General</h5>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label for="descripcion" class="form-label">
                        Concepto <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control @error('descripcion') is-invalid @enderror" 
                           id="descripcion" 
                           name="descripcion" 
                           value="{{ old('descripcion', $ingreso->concepto ?? $ingreso->descripcion) }}" 
                           required>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="fuente" class="form-label">
                        Tipo de Ingreso <span class="text-danger">*</span>
                    </label>
                    <select class="form-control @error('fuente') is-invalid @enderror" 
                            id="fuente" 
                            name="fuente" 
                            required>
                        <option value="">Seleccione...</option>
                        @foreach($fuentes ?? ['Membresías', 'Donaciones', 'Eventos', 'Servicios', 'Ventas', 'Patrocinios', 'Intereses Bancarios', 'Otros'] as $fuente_item)
                            <option value="{{ $fuente_item }}" 
                                    {{ old('fuente', $ingreso->tipo ?? $ingreso->fuente ?? '') == $fuente_item ? 'selected' : '' }}>
                                {{ $fuente_item }}
                            </option>
                        @endforeach
                    </select>
                    @error('fuente')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="monto" class="form-label">
                        Monto (L.) <span class="text-danger">*</span>
                    </label>
                    <input type="number" 
                           class="form-control @error('monto') is-invalid @enderror" 
                           id="monto" 
                           name="monto" 
                           value="{{ old('monto', $ingreso->monto) }}" 
                           step="0.01" 
                           min="0.01"
                           required>
                    @error('monto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="fecha" class="form-label">
                        Fecha de Ingreso <span class="text-danger">*</span>
                    </label>
                    <input type="date" 
                           class="form-control @error('fecha') is-invalid @enderror" 
                           id="fecha" 
                           name="fecha" 
                           value="{{ old('fecha', isset($ingreso->fecha_ingreso) ? \Carbon\Carbon::parse($ingreso->fecha_ingreso)->format('Y-m-d') : (isset($ingreso->fecha) ? \Carbon\Carbon::parse($ingreso->fecha)->format('Y-m-d') : '')) }}"
                           required>
                    @error('fecha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="categoria" class="form-label">
                        Categoría <span class="text-danger">*</span>
                    </label>
                    <select class="form-control @error('categoria') is-invalid @enderror" 
                            id="categoria" 
                            name="categoria"
                            required>
                        <option value="">Seleccione...</option>
                        @foreach($categorias ?? ['Membresías', 'Donaciones', 'Eventos', 'Servicios'] as $cat)
                            <option value="{{ $cat }}" 
                                    {{ old('categoria', $ingreso->origen ?? $ingreso->categoria ?? '') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="metodo_pago" class="form-label">Método de Pago</label>
                    <select class="form-control @error('metodo_pago') is-invalid @enderror" 
                            id="metodo_pago" 
                            name="metodo_pago">
                        <option value="">Seleccione...</option>
                        <option value="efectivo" {{ old('metodo_pago', $ingreso->metodo_recepcion ?? $ingreso->metodo_pago ?? '') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                        <option value="transferencia" {{ old('metodo_pago', $ingreso->metodo_recepcion ?? $ingreso->metodo_pago ?? '') == 'transferencia' ? 'selected' : '' }}>Transferencia Bancaria</option>
                        <option value="tarjeta_credito" {{ old('metodo_pago', $ingreso->metodo_recepcion ?? $ingreso->metodo_pago ?? '') == 'tarjeta_credito' ? 'selected' : '' }}>Tarjeta de Crédito</option>
                        <option value="tarjeta_debito" {{ old('metodo_pago', $ingreso->metodo_recepcion ?? $ingreso->metodo_pago ?? '') == 'tarjeta_debito' ? 'selected' : '' }}>Tarjeta de Débito</option>
                        <option value="cheque" {{ old('metodo_pago', $ingreso->metodo_recepcion ?? $ingreso->metodo_pago ?? '') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                        <option value="otro" {{ old('metodo_pago', $ingreso->metodo_recepcion ?? $ingreso->metodo_pago ?? '') == 'otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('metodo_pago')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="estado" class="form-label">
                        Estado <span class="text-danger">*</span>
                    </label>
                    <select class="form-control @error('estado') is-invalid @enderror" 
                            id="estado" 
                            name="estado" 
                            required>
                        <option value="confirmado" {{ old('estado', $ingreso->estado) == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                        <option value="activo" {{ old('estado', $ingreso->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="pendiente" {{ old('estado', $ingreso->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="cancelado" {{ old('estado', $ingreso->estado) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Sección: Referencia -->
        <div class="form-section section-orange">
            <div class="form-section-title">
                <i class="fas fa-hashtag"></i>
                <h5>Número de Referencia</h5>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label for="numero_referencia" class="form-label">Referencia</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="text" 
                               class="form-control @error('numero_referencia') is-invalid @enderror" 
                               id="numero_referencia" 
                               name="numero_referencia" 
                               value="{{ old('numero_referencia', $ingreso->comprobante ?? '') }}"
                               readonly>
                    </div>
                    <small class="form-text">
                        <i class="fas fa-info-circle me-1"></i>Este campo es generado automáticamente y no se puede editar
                    </small>
                </div>
            </div>
        </div>

        <!-- Sección: Documentos -->
        <div class="form-section section-green">
            <div class="form-section-title">
                <i class="fas fa-file-upload"></i>
                <h5>Documentos</h5>
            </div>

            @if(isset($ingreso->comprobante) && $ingreso->comprobante)
                <div class="alert-info">
                    <i class="fas fa-file-alt me-2"></i>
                    <a href="{{ asset('storage/' . $ingreso->comprobante) }}" target="_blank">
                        Ver comprobante actual
                    </a>
                </div>
            @endif

            <div class="form-row full">
                <div class="form-group">
                    <label for="comprobante" class="form-label">
                        {{ isset($ingreso->comprobante) && $ingreso->comprobante ? 'Cambiar Comprobante' : 'Adjuntar Comprobante' }}
                    </label>
                    <input type="file" 
                           class="form-control @error('comprobante') is-invalid @enderror" 
                           id="comprobante" 
                           name="comprobante"
                           accept=".pdf,.jpg,.jpeg,.png">
                    <small class="form-text">
                        <i class="fas fa-info-circle me-1"></i>Formatos: PDF, JPG, PNG. Tamaño máximo: 5MB
                    </small>
                    @error('comprobante')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Sección: Notas Adicionales -->
        <div class="form-section section-pink">
            <div class="form-section-title">
                <i class="fas fa-sticky-note"></i>
                <h5>Notas Adicionales</h5>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <textarea class="form-control @error('notas') is-invalid @enderror" 
                              id="notas" 
                              name="notas" 
                              rows="4"
                              placeholder="Añade notas o comentarios sobre este ingreso...">{{ old('notas', $ingreso->descripcion ?? $ingreso->notas ?? '') }}</textarea>
                    @error('notas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Información de Auditoría -->
        <div class="audit-info">
            <small>
                <i class="fas fa-clock me-2"></i>
                <strong>Creado:</strong> {{ \Carbon\Carbon::parse($ingreso->created_at)->format('d/m/Y H:i') }}
                @if(isset($ingreso->updated_at) && $ingreso->updated_at != $ingreso->created_at)
                    | <strong>Última actualización:</strong> {{ \Carbon\Carbon::parse($ingreso->updated_at)->format('d/m/Y H:i') }}
                @endif
            </small>
        </div>

        <!-- Botones -->
        <div class="form-actions">
            <a href="{{ route('tesorero.ingresos.index') }}" class="btn-modern btn-cancel">
                <i class="fas fa-times me-1"></i> Cancelar
            </a>
            <button type="submit" class="btn-modern btn-submit">
                <i class="fas fa-save me-1"></i> Actualizar Ingreso
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
</script>
@endpush
@endsection
