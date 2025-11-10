@extends('layouts.app')

@section('title', 'Notificaciones del Sistema')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1><i class="fas fa-bell me-2"></i> Centro de Notificaciones</h1>
                <a href="{{ route('tesorero.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i> Atrás
                </a>
            </div>
        </div>
    </div>

    @if ($errors->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Error:</strong> {{ $errors->first('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Resumen de Notificaciones -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-envelope text-primary" style="font-size: 2rem;"></i>
                    <h6 class="mt-2 mb-0">Total de Notificaciones</h6>
                    <h3 class="text-primary">{{ $totalNotificaciones }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-envelope-open text-success" style="font-size: 2rem;"></i>
                    <h6 class="mt-2 mb-0">Notificaciones Leídas</h6>
                    <h3 class="text-success">{{ $totalNotificaciones - $notificacionesNoLeidas }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                    <h6 class="mt-2 mb-0">Pendientes de Leer</h6>
                    <h3 class="text-warning" id="notificacionesNoLeidasCount">{{ $notificacionesNoLeidas }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    @if ($notificacionesNoLeidas > 0)
                        <form action="{{ route('tesorero.notificaciones.todas-leer') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-check-double me-1"></i> Marcar Todas como Leídas
                            </button>
                        </form>
                    @else
                        <p class="text-muted mb-0">✓ Todas las notificaciones han sido leídas</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text" class="form-control" id="filtroTexto" placeholder="Buscar notificación...">
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filtroEstado">
                        <option value="">Todas las notificaciones</option>
                        <option value="no-leidas">No leídas</option>
                        <option value="leidas">Leídas</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filtroTipo">
                        <option value="">Todos los tipos</option>
                        <option value="ingreso">Ingresos</option>
                        <option value="gasto">Gastos</option>
                        <option value="membresia">Membresías</option>
                        <option value="presupuesto">Presupuestos</option>
                        <option value="sistema">Sistema</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" onclick="aplicarFiltros()">
                        <i class="fas fa-filter me-1"></i> Filtrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Notificaciones -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i> Mis Notificaciones
                <span class="badge bg-primary ms-2" id="badgeNotificaciones">{{ $notificacionesNoLeidas }}</span>
            </h5>
        </div>
        <div class="card-body p-0" id="listaNotificaciones">
            @if ($notificaciones->count() > 0)
                @foreach ($notificaciones as $notificacion)
                    <div class="notificacion-item border-bottom p-3" 
                         data-id="{{ $notificacion->id }}" 
                         data-leida="{{ $notificacion->leida ? 'leidas' : 'no-leidas' }}"
                         data-tipo="{{ $notificacion->tipo ?? 'sistema' }}">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                @if (!$notificacion->leida)
                                    <span class="badge bg-primary rounded-pill">Nuevo</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill">Leído</span>
                                @endif
                            </div>
                            <div class="col">
                                <h6 class="mb-1 {{ !$notificacion->leida ? 'fw-bold' : '' }}">
                                    {{ $notificacion->titulo }}
                                </h6>
                                <p class="mb-1 text-muted small">{{ $notificacion->mensaje }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i> 
                                    {{ $notificacion->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <div class="col-auto">
                                <div class="btn-group btn-group-sm" role="group">
                                    @if (!$notificacion->leida)
                                        <button type="button" 
                                                class="btn btn-outline-primary" 
                                                onclick="marcarLeida({{ $notificacion->id }})"
                                                title="Marcar como leída">
                                            <i class="fas fa-envelope-open"></i>
                                        </button>
                                    @endif
                                    <button type="button" 
                                            class="btn btn-outline-danger" 
                                            onclick="eliminarNotificacion({{ $notificacion->id }})"
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Paginación -->
                <div class="d-flex justify-content-center p-4">
                    {{ $notificaciones->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="p-5 text-center text-muted">
                    <i class="fas fa-inbox" style="font-size: 3rem;"></i>
                    <p class="mt-3">No hay notificaciones</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Toast Container para notificaciones en tiempo real -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" id="toastContainer"></div>

<style>
    .notificacion-item {
        transition: background-color 0.3s ease;
    }

    .notificacion-item:hover {
        background-color: #f8f9fa;
    }

    .notificacion-item.no-leida {
        background-color: #f0f7ff;
    }

    .btn-group-sm {
        gap: 4px;
    }

    .toast {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
</style>

<script>
// Polling para actualizaciones en tiempo real
let pollingInterval;
let ultimoTimestamp = new Date().toISOString();

function iniciarPolling() {
    // Verificar actualizaciones cada 30 segundos
    pollingInterval = setInterval(verificarActualizaciones, 30000);
}

function verificarActualizaciones() {
    fetch("{{ route('tesorero.notificaciones.verificar') }}", {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        // Actualizar contador de notificaciones no leídas
        if (data.notificaciones_no_leidas !== undefined) {
            document.getElementById('notificacionesNoLeidasCount').textContent = data.notificaciones_no_leidas;
            document.getElementById('badgeNotificaciones').textContent = data.notificaciones_no_leidas;
        }

        // Mostrar nuevas notificaciones
        if (data.nuevas_notificaciones > 0) {
            mostrarToastNotificacion(`Tienes ${data.nuevas_notificaciones} nueva(s) notificación(es)`, 'info');
            // Recargar la página o actualizar la lista (opcional)
            // location.reload();
        }

        // Mostrar alertas de gastos pendientes
        if (data.gastos_pendientes > 0) {
            mostrarToastNotificacion(`Tienes ${data.gastos_pendientes} gasto(s) pendiente(s) de aprobación`, 'warning');
        }

        // Mostrar alertas de membresías próximas a vencer
        if (data.membresias_proximas_vencer > 0) {
            mostrarToastNotificacion(`${data.membresias_proximas_vencer} membresía(s) próxima(s) a vencer`, 'danger');
        }

        ultimoTimestamp = data.timestamp || new Date().toISOString();
    })
    .catch(error => console.error('Error en polling:', error));
}

function marcarLeida(id) {
    fetch(`/tesorero/notificaciones/${id}/marcar-leida`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Actualizar el elemento en la UI
            const elemento = document.querySelector(`[data-id="${id}"]`);
            if (elemento) {
                elemento.dataset.leida = 'leidas';
                elemento.querySelector('.badge').textContent = 'Leído';
                elemento.querySelector('.badge').classList.remove('bg-primary');
                elemento.querySelector('.badge').classList.add('bg-secondary');
                elemento.querySelector('button:first-child').remove();
                mostrarToastNotificacion('Notificación marcada como leída', 'success');
            }
            verificarActualizaciones();
        }
    })
    .catch(error => console.error('Error:', error));
}

function eliminarNotificacion(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta notificación?')) {
        fetch(`/tesorero/notificaciones/${id}/marcar-leida`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const elemento = document.querySelector(`[data-id="${id}"]`);
                if (elemento) {
                    elemento.style.opacity = '0.5';
                    setTimeout(() => elemento.remove(), 300);
                    mostrarToastNotificacion('Notificación eliminada', 'success');
                }
                verificarActualizaciones();
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function aplicarFiltros() {
    const textoFiltro = document.getElementById('filtroTexto').value.toLowerCase();
    const estadoFiltro = document.getElementById('filtroEstado').value;
    const tipoFiltro = document.getElementById('filtroTipo').value;

    document.querySelectorAll('.notificacion-item').forEach(item => {
        let mostrar = true;

        // Filtro de texto
        if (textoFiltro) {
            const texto = item.textContent.toLowerCase();
            mostrar = mostrar && texto.includes(textoFiltro);
        }

        // Filtro de estado
        if (estadoFiltro) {
            mostrar = mostrar && item.dataset.leida === estadoFiltro;
        }

        // Filtro de tipo
        if (tipoFiltro) {
            mostrar = mostrar && item.dataset.tipo === tipoFiltro;
        }

        item.style.display = mostrar ? '' : 'none';
    });
}

function mostrarToastNotificacion(mensaje, tipo = 'info') {
    const toastContainer = document.getElementById('toastContainer');
    const toastId = 'toast-' + Date.now();
    
    const colores = {
        'success': { bg: 'success', icon: 'check-circle' },
        'error': { bg: 'danger', icon: 'exclamation-circle' },
        'warning': { bg: 'warning', icon: 'exclamation-triangle' },
        'info': { bg: 'info', icon: 'info-circle' },
        'danger': { bg: 'danger', icon: 'exclamation-circle' }
    };

    const config = colores[tipo] || colores['info'];

    const toastHTML = `
        <div id="${toastId}" class="toast show" role="alert">
            <div class="toast-header bg-${config.bg} text-white">
                <i class="fas fa-${config.icon} me-2"></i>
                <strong class="me-auto">Notificación</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                ${mensaje}
            </div>
        </div>
    `;

    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
    
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, { delay: 5000 });
    toast.show();

    setTimeout(() => {
        toastElement.remove();
    }, 5500);
}

// Inicializar polling cuando carga la página
document.addEventListener('DOMContentLoaded', function() {
    iniciarPolling();
    verificarActualizaciones();

    // Limpiar interval cuando abandona la página
    window.addEventListener('beforeunload', function() {
        if (pollingInterval) {
            clearInterval(pollingInterval);
        }
    });
});
</script>
@endsection
