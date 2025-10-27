<!-- resources/views/modulos/secretaria/consultas.blade.php -->
@extends('layouts.app')

@section('title', 'Gestión de Consultas')

@section('content')
<div class="consultas-page">
    <!-- Header -->
    <div class="page-header">
        <div class="header-left">
            <button class="btn-back" onclick="window.location.href='{{ route('secretaria.dashboard') }}'">
                <i class="fas fa-arrow-left"></i>
            </button>
            <div class="header-title">
                <h1><i class="fas fa-comments"></i> Gestión de Consultas</h1>
                <p class="subtitle">Administra todas las consultas recibidas</p>
            </div>
        </div>
        <div class="header-actions">
            <button class="btn btn-secondary" onclick="window.location.reload()">
                <i class="fas fa-sync-alt"></i>
                <span>Actualizar</span>
            </button>
            <button class="btn btn-primary" onclick="exportarExcel()">
                <i class="fas fa-file-excel"></i>
                <span>Exportar</span>
            </button>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="stats-grid">
        <div class="stat-card purple">
            <div class="stat-icon"><i class="fas fa-inbox"></i></div>
            <div class="stat-content">
                <span class="stat-number">{{ $estadisticas['total'] ?? 0 }}</span>
                <span class="stat-label">Total Consultas</span>
            </div>
        </div>
        <div class="stat-card orange">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-content">
                <span class="stat-number">{{ $estadisticas['pendientes'] ?? 0 }}</span>
                <span class="stat-label">Pendientes</span>
            </div>
        </div>
        <div class="stat-card green">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-content">
                <span class="stat-number">{{ $estadisticas['respondidas'] ?? 0 }}</span>
                <span class="stat-label">Respondidas</span>
            </div>
        </div>
        <div class="stat-card blue">
            <div class="stat-icon"><i class="fas fa-calendar-day"></i></div>
            <div class="stat-content">
                <span class="stat-number">{{ $estadisticas['hoy'] ?? 0 }}</span>
                <span class="stat-label">Hoy</span>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filters-section">
        <form method="GET" class="filters-form">
            <div class="filter-group">
                <label><i class="fas fa-filter"></i> Estado</label>
                <select name="estado" class="form-control" onchange="this.form.submit()">
                    <option value="">Todos</option>
                    <option value="Pendiente" {{ request('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="Respondida" {{ request('estado') == 'Respondida' ? 'selected' : '' }}>Respondida</option>
                </select>
            </div>

            <div class="filter-group">
                <label><i class="fas fa-calendar"></i> Fecha</label>
                <select name="fecha" class="form-control" onchange="this.form.submit()">
                    <option value="">Todas</option>
                    <option value="hoy" {{ request('fecha') == 'hoy' ? 'selected' : '' }}>Hoy</option>
                    <option value="semana" {{ request('fecha') == 'semana' ? 'selected' : '' }}>Esta Semana</option>
                    <option value="mes" {{ request('fecha') == 'mes' ? 'selected' : '' }}>Este Mes</option>
                </select>
            </div>

            <div class="filter-group search-group">
                <label><i class="fas fa-search"></i> Buscar</label>
                <input type="text" name="buscar" class="form-control" placeholder="Nombre, email..." value="{{ request('buscar') }}">
            </div>

            <div class="filter-group">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </div>

            @if(request()->hasAny(['estado', 'fecha', 'buscar']))
            <div class="filter-group">
                <label>&nbsp;</label>
                <a href="{{ route('secretaria.consultas') }}" class="btn btn-light">
                    <i class="fas fa-times"></i> Limpiar
                </a>
            </div>
            @endif
        </form>
    </div>

    <!-- Tabla de Consultas -->
    <div class="table-card">
        <div class="table-header">
            <h3><i class="fas fa-list"></i> Lista de Consultas ({{ $consultas->total() }})</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="15%">Nombre</th>
                        <th width="15%">Email</th>
                        <th width="10%">Teléfono</th>
                        <th width="30%">Consulta</th>
                        <th width="10%">Fecha</th>
                        <th width="10%">Estado</th>
                        <th width="5%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consultas ?? [] as $consulta)
                    <tr>
                        <td><strong>#{{ $consulta->ConsultaID }}</strong></td>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar">
                                    {{ substr($consulta->Nombre, 0, 1) }}{{ substr($consulta->Apellido, 0, 1) }}
                                </div>
                                <div>
                                    <strong>{{ $consulta->Nombre }} {{ $consulta->Apellido }}</strong>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="mailto:{{ $consulta->Email }}" class="email-link">
                                <i class="fas fa-envelope"></i> {{ $consulta->Email }}
                            </a>
                        </td>
                        <td>
                            <a href="tel:{{ $consulta->Telefono }}" class="phone-link">
                                <i class="fas fa-phone"></i> {{ $consulta->Telefono }}
                            </a>
                        </td>
                        <td>
                            <div class="consulta-text">
                                {{ Str::limit($consulta->Consulta, 60) }}
                            </div>
                        </td>
                        <td>
                            <div class="date-cell">
                                <i class="fas fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($consulta->FechaConsulta)->format('d/m/Y') }}
                                <small>{{ \Carbon\Carbon::parse($consulta->FechaConsulta)->diffForHumans() }}</small>
                            </div>
                        </td>
                        <td>
                            <span class="status-badge {{ $consulta->Estado == 'Pendiente' ? 'warning' : 'success' }}">
                                <i class="fas fa-{{ $consulta->Estado == 'Pendiente' ? 'clock' : 'check-circle' }}"></i>
                                {{ $consulta->Estado }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon btn-info" onclick="verConsulta({{ $consulta->ConsultaID }})" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if($consulta->Estado == 'Pendiente')
                                <button class="btn-icon btn-success" onclick="responderConsulta({{ $consulta->ConsultaID }})" title="Responder">
                                    <i class="fas fa-reply"></i>
                                </button>
                                @endif
                                <button class="btn-icon btn-danger" onclick="eliminarConsulta({{ $consulta->ConsultaID }})" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p>No hay consultas registradas</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($consultas->hasPages())
        <div class="table-footer">
            {{ $consultas->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Ver Consulta -->
<div class="modal" id="modalVerConsulta">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-eye"></i> Detalle de la Consulta</h3>
                <button class="btn-close" onclick="cerrarModal('modalVerConsulta')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="contenidoVerConsulta">
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Cargando...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Responder Consulta -->
<div class="modal" id="modalResponderConsulta">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-reply"></i> Responder Consulta</h3>
                <button class="btn-close" onclick="cerrarModal('modalResponderConsulta')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="formResponderConsulta" onsubmit="enviarRespuesta(event)">
                <div class="modal-body" id="contenidoResponderConsulta">
                    <div class="loading-spinner">
                        <i class="fas fa-spinner fa-spin"></i>
                        <p>Cargando...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModal('modalResponderConsulta')">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane"></i> Enviar Respuesta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Ver consulta
function verConsulta(id) {
    abrirModal('modalVerConsulta');
    
    fetch(`/secretaria/consultas/${id}`)
        .then(response => response.json())
        .then(data => {
            const contenido = `
                <div class="consulta-detail">
                    <div class="detail-section">
                        <h4><i class="fas fa-user"></i> Información del Consultante</h4>
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Nombre Completo:</label>
                                <strong>${data.Nombre} ${data.Apellido}</strong>
                            </div>
                            <div class="info-item">
                                <label>Email:</label>
                                <a href="mailto:${data.Email}">${data.Email}</a>
                            </div>
                            <div class="info-item">
                                <label>Teléfono:</label>
                                <a href="tel:${data.Telefono}">${data.Telefono}</a>
                            </div>
                            <div class="info-item">
                                <label>Fecha:</label>
                                <span>${new Date(data.FechaConsulta).toLocaleDateString('es-ES')}</span>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h4><i class="fas fa-comment"></i> Consulta</h4>
                        <div class="consulta-content">
                            ${data.Consulta}
                        </div>
                    </div>

                    ${data.Respuesta ? `
                        <div class="detail-section">
                            <h4><i class="fas fa-reply"></i> Respuesta</h4>
                            <div class="respuesta-content">
                                ${data.Respuesta}
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-calendar"></i> 
                                Respondida el ${new Date(data.FechaRespuesta).toLocaleDateString('es-ES')}
                            </small>
                        </div>
                    ` : `
                        <div class="alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            Esta consulta aún no ha sido respondida
                        </div>
                    `}

                    <div class="detail-actions">
                        ${!data.Respuesta ? `
                            <button class="btn btn-success" onclick="cerrarModal('modalVerConsulta'); responderConsulta(${id})">
                                <i class="fas fa-reply"></i> Responder Ahora
                            </button>
                        ` : ''}
                        <button class="btn btn-secondary" onclick="cerrarModal('modalVerConsulta')">
                            <i class="fas fa-times"></i> Cerrar
                        </button>
                    </div>
                </div>
            `;
            document.getElementById('contenidoVerConsulta').innerHTML = contenido;
        })
        .catch(error => {
            document.getElementById('contenidoVerConsulta').innerHTML = `
                <div class="alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    Error al cargar la consulta
                </div>
            `;
        });
}

// Responder consulta
function responderConsulta(id) {
    abrirModal('modalResponderConsulta');
    
    fetch(`/secretaria/consultas/${id}`)
        .then(response => response.json())
        .then(data => {
            const contenido = `
                <input type="hidden" name="consulta_id" value="${id}">
                
                <div class="form-section">
                    <h4><i class="fas fa-info-circle"></i> Consulta Original</h4>
                    <div class="original-consulta">
                        <div class="consulta-header">
                            <strong>${data.Nombre} ${data.Apellido}</strong>
                            <span>${new Date(data.FechaConsulta).toLocaleDateString('es-ES')}</span>
                        </div>
                        <div class="consulta-body">
                            ${data.Consulta}
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4><i class="fas fa-reply"></i> Tu Respuesta</h4>
                    <div class="form-group">
                        <label for="respuesta" class="required">Mensaje de Respuesta</label>
                        <textarea id="respuesta" 
                                  name="respuesta" 
                                  class="form-control" 
                                  rows="6"
                                  required
                                  placeholder="Escribe tu respuesta aquí..."></textarea>
                        <small class="form-hint">
                            <i class="fas fa-info-circle"></i> 
                            La respuesta será enviada al email: ${data.Email}
                        </small>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="enviar_email" checked>
                            <span>Enviar respuesta por correo electrónico</span>
                        </label>
                    </div>
                </div>
            `;
            document.getElementById('contenidoResponderConsulta').innerHTML = contenido;
        })
        .catch(error => {
            document.getElementById('contenidoResponderConsulta').innerHTML = `
                <div class="alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    Error al cargar la consulta
                </div>
            `;
        });
}

// Enviar respuesta
function enviarRespuesta(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const consultaId = formData.get('consulta_id');
    
    fetch(`/secretaria/consultas/${consultaId}/responder`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            respuesta: formData.get('respuesta'),
            enviar_email: formData.get('enviar_email') ? true : false
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarNotificacion('Respuesta enviada exitosamente', 'success');
            cerrarModal('modalResponderConsulta');
            location.reload();
        } else {
            mostrarNotificacion('Error al enviar la respuesta', 'error');
        }
    })
    .catch(error => {
        mostrarNotificacion('Error al procesar la solicitud', 'error');
    });
}

// Eliminar consulta
function eliminarConsulta(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta consulta?')) {
        fetch(`/secretaria/consultas/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarNotificacion('Consulta eliminada exitosamente', 'success');
                location.reload();
            } else {
                mostrarNotificacion('Error al eliminar la consulta', 'error');
            }
        })
        .catch(error => {
            mostrarNotificacion('Error al procesar la solicitud', 'error');
        });
    }
}

// Exportar a Excel
function exportarExcel() {
    window.location.href = '{{ route("secretaria.consultas") }}?export=excel';
}

// Funciones de Modal
function abrirModal(modalId) {
    document.getElementById(modalId).classList.add('show');
    document.body.style.overflow = 'hidden';
}

function cerrarModal(modalId) {
    document.getElementById(modalId).classList.remove('show');
    document.body.style.overflow = '';
}

// Cerrar modal al hacer clic fuera
document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModal(this.id);
        }
    });
});

// Función para mostrar notificaciones
function mostrarNotificacion(mensaje, tipo) {
    const notificacion = document.createElement('div');
    notificacion.className = `notificacion ${tipo}`;
    notificacion.innerHTML = `
        <i class="fas fa-${tipo === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        <span>${mensaje}</span>
    `;
    document.body.appendChild(notificacion);
    
    setTimeout(() => {
        notificacion.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        notificacion.classList.remove('show');
        setTimeout(() => notificacion.remove(), 300);
    }, 3000);
}

// Abrir modal si viene de dashboard con parámetro
window.addEventListener('load', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const view = urlParams.get('view');
    
    if (view) {
        verConsulta(view);
    }
});
</script>
@endpush

@push('styles')
<style>
/* Estilos base - Reutilizar de dashboard */
.consultas-page {
    padding: 2rem;
    max-width: 1600px;
    margin: 0 auto;
}

/* Table Card */
.table-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.table-header {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e5e7eb;
    background: #fafbfc;
}

.table-header h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: #f8fafc;
}

.data-table th {
    padding: 1rem 1.5rem;
    text-align: left;
    font-weight: 600;
    color: #475569;
    font-size: 0.875rem;
    border-bottom: 2px solid #e5e7eb;
    white-space: nowrap;
}

.data-table td {
    padding: 1rem 1.5rem;
    color: #64748b;
    font-size: 0.9rem;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.data-table tbody tr {
    transition: all 0.3s ease;
}

.data-table tbody tr:hover {
    background: #f8fafc;
}

/* User Cell */
.user-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
}

.user-cell strong {
    color: #1e293b;
}

/* Links */
.email-link,
.phone-link {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    color: #6366f1;
    text-decoration: none;
    transition: all 0.3s ease;
}

.email-link:hover,
.phone-link:hover {
    color: #4f46e5;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.875rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.status-badge.warning {
    background: #fef3c7;
    color: #d97706;
}

.status-badge.success {
    background: #d1fae5;
    color: #059669;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-icon.btn-info {
    background: #dbeafe;
    color: #2563eb;
}

.btn-icon.btn-info:hover {
    background: #2563eb;
    color: white;
}

.btn-icon.btn-success {
    background: #d1fae5;
    color: #059669;
}

.btn-icon.btn-success:hover {
    background: #059669;
    color: white;
}

.btn-icon.btn-danger {
    background: #fee;
    color: #ef4444;
}

.btn-icon.btn-danger:hover {
    background: #ef4444;
    color: white;
}

/* Date Cell */
.date-cell {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.date-cell i {
    color: #94a3b8;
    margin-right: 0.25rem;
}

.date-cell small {
    color: #94a3b8;
    font-size: 0.75rem;
}

/* Modal */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 1000;
    padding: 2rem;
}

.modal.show {
    opacity: 1;
    visibility: visible;
}

.modal-dialog {
    width: 100%;
    max-width: 600px;
    transform: scale(0.9);
    transition: all 0.3s ease;
}

.modal.show .modal-dialog {
    transform: scale(1);
}

.modal-dialog.modal-lg {
    max-width: 900px;
}

.modal-content {
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    overflow: hidden;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e5e7eb;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
}

.modal-header h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.modal-header h3 i {
    color: #6366f1;
}

.btn-close {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: none;
    background: white;
    color: #64748b;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-close:hover {
    background: #fee;
    color: #ef4444;
}

.modal-body {
    padding: 2rem;
    max-height: 70vh;
    overflow-y: auto;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    padding: 1.5rem 2rem;
    border-top: 1px solid #e5e7eb;
    background: #fafbfc;
}

/* Loading Spinner */
.loading-spinner {
    text-align: center;
    padding: 3rem;
    color: #94a3b8;
}

.loading-spinner i {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

/* Consulta Detail */
.consulta-detail {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.detail-section {
    padding: 1.5rem;
    background: #f8fafc;
    border-radius: 12px;
}

.detail-section h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 1rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.detail-section h4 i {
    color: #6366f1;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.info-item label {
    color: #64748b;
    font-size: 0.875rem;
}

.info-item strong {
    color: #1e293b;
    font-size: 0.95rem;
}

.info-item a {
    color: #6366f1;
    text-decoration: none;
}

.consulta-content,
.respuesta-content {
    padding: 1rem;
    background: white;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    line-height: 1.6;
    color: #475569;
}

.respuesta-content {
    background: #f0fdf4;
    border-color: #86efac;
}

.detail-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    margin-top: 1rem;
}

/* Form Section */
.form-section {
    margin-bottom: 1.5rem;
}

.form-section h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 1rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.original-consulta {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
}

.consulta-header {
    display: flex;
    justify-content: space-between;
    padding: 1rem;
    background: white;
    border-bottom: 1px solid #e5e7eb;
}

.consulta-header strong {
    color: #1e293b;
}

.consulta-header span {
    color: #64748b;
    font-size: 0.875rem;
}

.consulta-body {
    padding: 1rem;
    color: #475569;
    line-height: 1.6;
}

/* Form Elements */
.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    font-weight: 600;
    color: #475569;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.form-group label.required::after {
    content: '*';
    color: #ef4444;
    margin-left: 0.25rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.95rem;
    color: #1e293b;
    transition: all 0.3s ease;
    font-family: inherit;
}

.form-control:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

textarea.form-control {
    resize: vertical;
}

.form-hint {
    display: block;
    color: #94a3b8;
    font-size: 0.85rem;
    margin-top: 0.5rem;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    color: #475569;
    font-weight: normal;
}

.checkbox-label input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

/* Alerts */
.alert-warning,
.alert-danger {
    padding: 1rem 1.25rem;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin: 1rem 0;
}

.alert-warning {
    background: #fef3c7;
    color: #92400e;
    border: 1px solid #fbbf24;
}

.alert-danger {
    background: #fee;
    color: #991b1b;
    border: 1px solid #fca5a5;
}

/* Notificaciones */
.notificacion {
    position: fixed;
    top: 2rem;
    right: 2rem;
    background: white;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    transform: translateX(400px);
    transition: all 0.3s ease;
    z-index: 9999;
}

.notificacion.show {
    transform: translateX(0);
}

.notificacion.success {
    border-left: 4px solid #10b981;
}

.notificacion.success i {
    color: #10b981;
    font-size: 1.25rem;
}

.notificacion.error {
    border-left: 4px solid #ef4444;
}

.notificacion.error i {
    color: #ef4444;
    font-size: 1.25rem;
}

/* Responsive */
@media (max-width: 768px) {
    .consultas-page {
        padding: 1rem;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .filters-form {
        grid-template-columns: 1fr;
    }

    .table-responsive {
        overflow-x: scroll;
    }

    .data-table {
        min-width: 900px;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

    .modal {
        padding: 1rem;
    }

    .modal-body {
        max-height: 60vh;
    }
}
</style>
@endpush
@endsection