@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #2c3e50; min-height: 100vh;">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb p-3 rounded shadow-sm" style="background-color: #34495e;">
            <li class="breadcrumb-item"><a href="{{ route('tesorero.dashboard') }}" class="text-decoration-none text-white"><i class="fas fa-home"></i> Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tesorero.gastos.index') }}" class="text-decoration-none text-white">Gastos</a></li>
            <li class="breadcrumb-item active text-light" aria-current="page">Editar Gasto #{{ $gasto->id }}</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg" style="background-color: #34495e;">
                <div class="card-header py-4 border-0" style="background-color: #2c3e50; border-bottom: 2px solid #e74c3c;">
                    <h3 class="mb-0 font-weight-bold text-white">
                        <i class="fas fa-edit me-2 text-danger"></i> Editar Gasto #{{ $gasto->id }}
                    </h3>
                </div>

                <div class="card-body p-4" style="background-color: #34495e;">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('tesorero.gastos.update', $gasto->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Información Principal -->
                        <div class="card mb-4 border-0 shadow-sm" style="background-color: #2c3e50;">
                            <div class="card-header border-0" style="background-color: transparent;">
                                <h5 class="mb-0 text-white"><i class="fas fa-file-alt me-2"></i>Información Principal</h5>
                            </div>
                            <div class="card-body" style="background-color: #2c3e50;">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="descripcion" class="form-label fw-bold text-white">Descripción <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('descripcion') is-invalid @enderror" 
                                               style="background-color: #34495e; border: 1px solid #4a5f7f; color: #ecf0f1;"
                                               id="descripcion" name="descripcion" 
                                               value="{{ old('descripcion', $gasto->descripcion ?? $gasto->concepto) }}" required>
                                        @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="categoria" class="form-label fw-bold text-white">Categoría <span class="text-danger">*</span></label>
                                        <select class="form-select @error('categoria') is-invalid @enderror" 
                                                style="background-color: #34495e; border: 1px solid #4a5f7f; color: #ecf0f1;"
                                                id="categoria" name="categoria" required>
                                            <option value="">-- Seleccione --</option>
                                            @foreach($categorias ?? ['Servicios', 'Suministros', 'Equipamiento'] as $cat)
                                                <option value="{{ $cat }}" {{ old('categoria', $gasto->categoria ?? $gasto->tipo) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                            @endforeach
                                        </select>
                                        @error('categoria')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="monto" class="form-label fw-bold text-white">Monto (L.) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text" style="background-color: #e74c3c; border-color: #e74c3c; color: white;">L.</span>
                                            <input type="number" class="form-control @error('monto') is-invalid @enderror" 
                                                   style="background-color: #34495e; border: 1px solid #4a5f7f; color: #ecf0f1;"
                                                   id="monto" name="monto" value="{{ old('monto', $gasto->monto) }}" 
                                                   step="0.01" min="0.01" required>
                                        </div>
                                        @error('monto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="fecha" class="form-label fw-bold text-white">Fecha <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('fecha') is-invalid @enderror" 
                                               style="background-color: #34495e; border: 1px solid #4a5f7f; color: #ecf0f1;"
                                               id="fecha" name="fecha" 
                                               value="{{ old('fecha', isset($gasto->fecha_gasto) ? \Carbon\Carbon::parse($gasto->fecha_gasto)->format('Y-m-d') : \Carbon\Carbon::parse($gasto->fecha)->format('Y-m-d')) }}" required>
                                        @error('fecha')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="prioridad" class="form-label fw-bold text-white">Prioridad</label>
                                        <select class="form-select @error('prioridad') is-invalid @enderror" 
                                                style="background-color: #34495e; border: 1px solid #4a5f7f; color: #ecf0f1;"
                                                id="prioridad" name="prioridad">
                                            <option value="">-- Seleccione --</option>
                                            @foreach($prioridades ?? ['Baja', 'Media', 'Alta', 'Urgente'] as $prio)
                                                <option value="{{ $prio }}" {{ old('prioridad', $gasto->prioridad ?? '') == $prio ? 'selected' : '' }}>{{ $prio }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="numero_factura" class="form-label fw-bold text-white">Número de Factura</label>
                                        <input type="text" class="form-control" 
                                               style="background-color: #34495e; border: 1px solid #4a5f7f; color: #ecf0f1;"
                                               id="numero_factura" name="numero_factura" 
                                               value="{{ old('numero_factura', $gasto->numero_factura ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detalles de Pago -->
                        <div class="card mb-4 border-0 shadow-sm" style="background-color: #2c3e50;">
                            <div class="card-header border-0" style="background-color: transparent;">
                                <h5 class="mb-0 text-white"><i class="fas fa-credit-card me-2"></i>Detalles de Pago</h5>
                            </div>
                            <div class="card-body" style="background-color: #2c3e50;">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="proveedor" class="form-label fw-bold text-white">Proveedor</label>
                                        <input type="text" class="form-control" 
                                               style="background-color: #34495e; border: 1px solid #4a5f7f; color: #ecf0f1;"
                                               id="proveedor" name="proveedor" 
                                               value="{{ old('proveedor', $gasto->proveedor ?? '') }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="metodo_pago" class="form-label fw-bold text-white">Método de Pago</label>
                                        <select class="form-select" 
                                                style="background-color: #34495e; border: 1px solid #4a5f7f; color: #ecf0f1;"
                                                id="metodo_pago" name="metodo_pago">
                                            <option value="">-- Seleccione --</option>
                                            @foreach($metodos_pago ?? ['Efectivo', 'Transferencia Bancaria', 'Tarjeta de Crédito', 'Tarjeta de Débito', 'Cheque', 'Pago en Línea'] as $metodo)
                                                <option value="{{ $metodo }}" {{ old('metodo_pago', $gasto->metodo_pago ?? '') == $metodo ? 'selected' : '' }}>{{ $metodo }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-bold text-white">Estado de Aprobación <span class="text-danger">*</span></label>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="estado_aprobacion" id="pendiente" value="pendiente" {{ old('estado_aprobacion', $gasto->estado_aprobacion ?? $gasto->estado ?? 'pendiente') == 'pendiente' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning" for="pendiente" style="color: #f39c12; border-color: #f39c12;"><i class="fas fa-clock"></i> Pendiente</label>

                                            <input type="radio" class="btn-check" name="estado_aprobacion" id="aprobado" value="aprobado" {{ old('estado_aprobacion', $gasto->estado_aprobacion ?? $gasto->estado ?? '') == 'aprobado' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success" for="aprobado" style="color: #27ae60; border-color: #27ae60;"><i class="fas fa-check"></i> Aprobado</label>

                                            <input type="radio" class="btn-check" name="estado_aprobacion" id="rechazado" value="rechazado" {{ old('estado_aprobacion', $gasto->estado_aprobacion ?? $gasto->estado ?? '') == 'rechazado' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger" for="rechazado" style="color: #e74c3c; border-color: #e74c3c;"><i class="fas fa-times"></i> Rechazado</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Documentación -->
                        <div class="card mb-4 border-0 shadow-sm" style="background-color: #2c3e50;">
                            <div class="card-header border-0" style="background-color: transparent;">
                                <h5 class="mb-0 text-white"><i class="fas fa-paperclip me-2"></i>Documentación</h5>
                            </div>
                            <div class="card-body" style="background-color: #2c3e50;">
                                @if(isset($gasto->comprobante) && $gasto->comprobante)
                                    <div class="alert mb-3" style="background-color: #3498db; border: none; color: white;">
                                        <i class="fas fa-file-alt"></i> 
                                        <a href="{{ asset('storage/' . $gasto->comprobante) }}" target="_blank" class="text-white text-decoration-underline">Ver comprobante actual</a>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="comprobante" class="form-label fw-bold text-white">{{ isset($gasto->comprobante) && $gasto->comprobante ? 'Cambiar Comprobante' : 'Adjuntar Comprobante' }}</label>
                                    <input type="file" class="form-control" 
                                           style="background-color: #34495e; border: 1px solid #4a5f7f; color: #ecf0f1;"
                                           id="comprobante" name="comprobante" accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="form-text text-light"><i class="fas fa-info-circle"></i> Formatos: PDF, JPG, PNG • Máx: 5MB</small>
                                </div>

                                <div>
                                    <label for="notas" class="form-label fw-bold text-white">Notas</label>
                                    <textarea class="form-control" 
                                              style="background-color: #34495e; border: 1px solid #4a5f7f; color: #ecf0f1;"
                                              id="notas" name="notas" rows="4">{{ old('notas', $gasto->notas ?? $gasto->observaciones ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Auditoría -->
                        @if(isset($gasto->created_at))
                            <div class="alert mb-4" style="background-color: #34495e; border: 1px solid #4a5f7f;">
                                <small class="text-light">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Creado:</strong> {{ \Carbon\Carbon::parse($gasto->created_at)->format('d/m/Y H:i') }}
                                    @if(isset($gasto->updated_at) && $gasto->updated_at != $gasto->created_at)
                                        | <strong>Última actualización:</strong> {{ \Carbon\Carbon::parse($gasto->updated_at)->format('d/m/Y H:i') }}
                                    @endif
                                </small>
                            </div>
                        @endif

                        <!-- Botones -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tesorero.gastos.index') }}" class="btn px-4" style="background-color: #7f8c8d; color: white; border: none;"><i class="fas fa-times me-2"></i> Cancelar</a>
                            <button type="submit" class="btn px-5" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; border: none;"><i class="fas fa-save me-2"></i> Actualizar Gasto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
