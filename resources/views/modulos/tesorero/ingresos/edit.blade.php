@extends('layouts.app')

@push('styles')
<style>
    body {
        background-color: #1e2836 !important;
    }

    .edit-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: white !important;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
    }
    
    .edit-header h1, .edit-header h2, .edit-header h4, .edit-header p {
        color: #ffffff !important;
        opacity: 1 !important;
    }
    
    .form-section {
        background: #2a3544 !important;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        border-left: 4px solid #10b981;
    }
    
    .form-label {
        font-weight: 600;
        color: #e5e7eb !important;
        margin-bottom: 0.5rem;
        opacity: 1 !important;
    }
    
    .text-danger {
        color: #ef4444 !important;
    }
    
    .form-control, .form-select {
        background-color: rgba(42, 53, 68, 0.8) !important;
        color: #ffffff !important;
        border: 2px solid #3d4757;
        border-radius: 8px;
        padding: 0.75rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        background-color: rgba(42, 53, 68, 0.9) !important;
        color: #ffffff !important;
        border-color: #10b981;
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
    }
    
    .form-control::placeholder {
        color: #9ca3af !important;
        opacity: 0.7;
    }
    
    .form-select option, select option {
        background-color: #2a3544 !important;
        color: #ffffff !important;
    }
    
    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        border: none;
        padding: 0.875rem 2.5rem;
        border-radius: 8px;
        font-weight: 600;
        color: white !important;
        transition: all 0.3s ease;
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(16, 185, 129, 0.3);
        color: white !important;
    }
    
    .btn-secondary {
        background: #6c757d !important;
        border: none;
        padding: 0.875rem 2.5rem;
        border-radius: 8px;
        font-weight: 600;
        color: white !important;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background: #5a6268 !important;
        transform: translateY(-2px);
        color: white !important;
    }
    
    .card {
        background-color: #2a3544 !important;
        border: 1px solid #3d4757;
        color: #e5e7eb !important;
    }
    
    .card-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: #ffffff !important;
        border: none !important;
    }
    
    .card-header h4 {
        color: #ffffff !important;
        opacity: 1 !important;
    }
    
    .card-body {
        background-color: #2a3544 !important;
    }
    
    .card-body * {
        opacity: 1 !important;
    }
    
    .alert-danger {
        background-color: rgba(239, 68, 68, 0.15) !important;
        border: 1px solid #ef4444;
        color: #fca5a5 !important;
    }
    
    .alert-danger * {
        color: #fca5a5 !important;
    }
    
    .invalid-feedback {
        color: #fca5a5 !important;
        opacity: 1 !important;
    }
    
    .is-invalid {
        border-color: #ef4444 !important;
    }
    
    /* Texto general visible */
    p, span, label, div, small {
        opacity: 1 !important;
    }
    
    .text-muted {
        color: #9ca3af !important;
        opacity: 1 !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h4 class="m-0">
                        <i class="fas fa-edit"></i> Editar Ingreso #{{ $ingreso->id }}
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('tesorero.ingresos.update', $ingreso->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Concepto/Descripción -->
                            <div class="col-md-12 mb-3">
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

                            <!-- Tipo/Fuente -->
                            <div class="col-md-6 mb-3">
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

                            <!-- Monto -->
                            <div class="col-md-6 mb-3">
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

                            <!-- Fecha -->
                            <div class="col-md-6 mb-3">
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

                            <!-- Categoría -->
                            <div class="col-md-6 mb-3">
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

                            <!-- Método de Pago -->
                            <div class="col-md-6 mb-3">
                                <label for="metodo_pago" class="form-label">Método de Pago</label>
                                <select class="form-control @error('metodo_pago') is-invalid @enderror" 
                                        id="metodo_pago" 
                                        name="metodo_pago">
                                    <option value="">Seleccione...</option>
                                    @foreach($metodos_pago ?? ['Efectivo', 'Transferencia Bancaria', 'Tarjeta de Crédito', 'Cheque'] as $metodo)
                                        <option value="{{ $metodo }}" 
                                                {{ old('metodo_pago', $ingreso->metodo_recepcion ?? $ingreso->metodo_pago ?? '') == $metodo ? 'selected' : '' }}>
                                            {{ $metodo }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('metodo_pago')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Número de Referencia -->
                            <div class="col-md-12 mb-3">
                                <label for="numero_referencia" class="form-label">
                                    <i class="fas fa-hashtag me-1"></i> Número de Referencia
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-secondary text-white">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control @error('numero_referencia') is-invalid @enderror" 
                                           id="numero_referencia" 
                                           name="numero_referencia" 
                                           value="{{ old('numero_referencia', $ingreso->comprobante ?? '') }}"
                                           readonly
                                           style="background-color: #e9ecef;">
                                    @error('numero_referencia')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>Este campo es generado automáticamente y no se puede editar
                                </small>
                            </div>

                            <!-- Estado -->
                            <div class="col-md-6 mb-3">
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

                            <!-- Comprobante Actual -->
                            @if(isset($ingreso->comprobante) && $ingreso->comprobante)
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Comprobante Actual</label>
                                    <div class="alert alert-info">
                                        <i class="fas fa-file-alt"></i> 
                                        <a href="{{ asset('storage/' . $ingreso->comprobante) }}" target="_blank" class="alert-link">
                                            Ver comprobante actual
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <!-- Nuevo Comprobante -->
                            <div class="col-md-12 mb-3">
                                <label for="comprobante" class="form-label">
                                    {{ isset($ingreso->comprobante) && $ingreso->comprobante ? 'Cambiar Comprobante' : 'Adjuntar Comprobante' }}
                                </label>
                                <input type="file" 
                                       class="form-control @error('comprobante') is-invalid @enderror" 
                                       id="comprobante" 
                                       name="comprobante"
                                       accept=".pdf,.jpg,.jpeg,.png">
                                @error('comprobante')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> Formatos permitidos: PDF, JPG, PNG. Tamaño máximo: 5MB
                                </small>
                            </div>

                            <!-- Notas -->
                            <div class="col-md-12 mb-3">
                                <label for="notas" class="form-label">Notas Adicionales</label>
                                <textarea class="form-control @error('notas') is-invalid @enderror" 
                                          id="notas" 
                                          name="notas" 
                                          rows="3">{{ old('notas', $ingreso->descripcion ?? $ingreso->notas ?? '') }}</textarea>
                                @error('notas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Info de auditoría -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-light">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        <strong>Creado:</strong> {{ \Carbon\Carbon::parse($ingreso->created_at)->format('d/m/Y H:i') }}
                                        @if(isset($ingreso->updated_at) && $ingreso->updated_at != $ingreso->created_at)
                                            | <strong>Última actualización:</strong> {{ \Carbon\Carbon::parse($ingreso->updated_at)->format('d/m/Y H:i') }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tesorero.ingresos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="fas fa-save"></i> Actualizar Ingreso
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
