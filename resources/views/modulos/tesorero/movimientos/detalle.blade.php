@extends('layouts.app')

@section('title', 'Detalle de Movimiento')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>
                    <i class="fas fa-{{ $tipo == 'ingreso' ? 'arrow-down text-success' : 'arrow-up text-danger' }} me-2"></i>
                    Detalle de {{ ucfirst($tipo) }}
                </h1>
                <a href="{{ route('tesorero.movimientos.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i> Atrás
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header {{ $tipo == 'ingreso' ? 'bg-success' : 'bg-danger' }} text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Información del {{ ucfirst($tipo) }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted"><small>Descripción</small></label>
                            <p class="form-control-plaintext fw-bold">{{ $movimiento->descripcion ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted"><small>Categoría</small></label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-light text-dark">{{ $movimiento->categoria ?? 'General' }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted"><small>Monto</small></label>
                            <p class="form-control-plaintext fw-bold fs-5 text-{{ $tipo == 'ingreso' ? 'success' : 'danger' }}">
                                {{ $tipo == 'ingreso' ? '+' : '-' }}L. {{ number_format($movimiento->monto ?? 0, 2) }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted"><small>Fecha</small></label>
                            <p class="form-control-plaintext">
                                <i class="fas fa-calendar me-2"></i>
                                {{ $movimiento->fecha ? \Carbon\Carbon::parse($movimiento->fecha)->format('d/m/Y H:i') : 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted"><small>Estado</small></label>
                            <p class="form-control-plaintext">
                                @php
                                    $badgeClass = match($movimiento->estado ?? 'pendiente') {
                                        'pagado', 'completada' => 'success',
                                        'pendiente' => 'warning',
                                        'cancelado', 'cancelada' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($movimiento->estado ?? 'pendiente') }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted"><small>ID Registro</small></label>
                            <p class="form-control-plaintext text-monospace">{{ $movimiento->id }}</p>
                        </div>
                    </div>

                    @if($movimiento->observaciones ?? null)
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label text-muted"><small>Observaciones</small></label>
                                <p class="form-control-plaintext">{{ $movimiento->observaciones }}</p>
                            </div>
                        </div>
                    @endif

                    @if($tipo == 'egreso' && ($movimiento->cuenta_origen ?? null))
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted"><small>Cuenta Origen</small></label>
                                <p class="form-control-plaintext">{{ $movimiento->cuenta_origen }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted"><small>Cuenta Destino</small></label>
                                <p class="form-control-plaintext">{{ $movimiento->cuenta_destino ?? 'N/A' }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-actions me-2"></i>
                        Acciones
                    </h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('tesorero.' . ($tipo == 'ingreso' ? 'ingresos' : 'gastos') . '.edit', $movimiento->id) }}" 
                       class="btn btn-warning w-100 mb-2">
                        <i class="fas fa-edit me-2"></i> Editar
                    </a>
                    <form action="{{ route('tesorero.' . ($tipo == 'ingreso' ? 'ingresos' : 'gastos') . '.destroy', $movimiento->id) }}" 
                          method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este registro?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-2"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Información de Auditoría -->
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Auditoría
                    </h5>
                </div>
                <div class="card-body small text-muted">
                    <p>
                        <strong>Creado:</strong><br>
                        {{ $movimiento->created_at ? $movimiento->created_at->format('d/m/Y H:i:s') : 'N/A' }}
                    </p>
                    <p>
                        <strong>Última actualización:</strong><br>
                        {{ $movimiento->updated_at ? $movimiento->updated_at->format('d/m/Y H:i:s') : 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
