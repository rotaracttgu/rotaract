@extends('layouts.app')

@section('title', 'Cartas Formales - Vicepresidente')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-0">Cartas Formales</h2>
            <p class="text-muted">Registro y seguimiento de correspondencia formal</p>
        </div>
        <div class="col-md-4 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaCartaFormal">
                <i class="fas fa-plus me-2"></i>Nueva Carta Formal
            </button>
        </div>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Total Enviadas
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">23</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Con Respuesta
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">15</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Pendientes
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Este Mes
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">7</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Tipo de Carta</label>
                    <select class="form-select" id="filtroTipo">
                        <option value="">Todos los tipos</option>
                        <option value="invitacion">Invitación</option>
                        <option value="agradecimiento">Agradecimiento</option>
                        <option value="solicitud">Solicitud</option>
                        <option value="notificacion">Notificación</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado de Respuesta</label>
                    <select class="form-select" id="filtroRespuesta">
                        <option value="">Todos</option>
                        <option value="respondida">Respondida</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="no_requiere">No Requiere</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha Desde</label>
                    <input type="date" class="form-control" id="filtroFechaDesde">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha Hasta</label>
                    <input type="date" class="form-control" id="filtroFechaHasta">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <button class="btn btn-primary" onclick="aplicarFiltros()">
                        <i class="fas fa-filter me-2"></i>Aplicar Filtros
                    </button>
                    <button class="btn btn-secondary" onclick="limpiarFiltros()">
                        <i class="fas fa-times me-2"></i>Limpiar
                    </button>
                    <button class="btn btn-success" onclick="exportarArchivo()">
                        <i class="fas fa-file-excel me-2"></i>Exportar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Cartas Formales -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Archivo de Correspondencia</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tablaCartasFormal">
                    <thead>
                        <tr>
                            <th>Ref.</th>
                            <th>Tipo</th>
                            <th>Destinatario</th>
                            <th>Asunto</th>
                            <th>Fecha Envío</th>
                            <th>Estado Respuesta</th>
                            <th>Fecha Respuesta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyCartasFormal">
                        <!-- Datos cargados dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva/Editar Carta Formal -->
<div class="modal fade" id="modalNuevaCartaFormal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Carta Formal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formCartaFormal">
                    <input type="hidden" id="cartaFormalId">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tipo de Carta *</label>
                            <select class="form-select" id="tipo" required>
                                <option value="">Seleccione...</option>
                                <option value="invitacion">Invitación</option>
                                <option value="agradecimiento">Agradecimiento</option>
                                <option value="solicitud">Solicitud</option>
                                <option value="notificacion">Notificación</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha de Envío *</label>
                            <input type="date" class="form-control" id="fechaEnvio" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Destinatario *</label>
                            <input type="text" class="form-control" id="destinatario" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Cargo/Institución</label>
                            <input type="text" class="form-control" id="cargo">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Asunto *</label>
                            <input type="text" class="form-control" id="asunto" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Contenido de la Carta</label>
                            <textarea class="form-control" id="contenido" rows="4"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Estado de Respuesta *</label>
                            <select class="form-select" id="estadoRespuesta" required>
                                <option value="pendiente">Pendiente</option>
                                <option value="respondida">Respondida</option>
                                <option value="no_requiere">No Requiere Respuesta</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha de Respuesta</label>
                            <input type="date" class="form-control" id="fechaRespuesta">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Notas/Observaciones</label>
                            <textarea class="form-control" id="notas" rows="2"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarCartaFormal()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ver Detalle -->
<div class="modal fade" id="modalDetalleFormal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle de Carta Formal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detalleContenidoFormal">
                <!-- Se llenará dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="imprimirCarta()">
                    <i class="fas fa-print me-2"></i>Imprimir
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
</style>

<script>
// Datos mock en memoria
let cartasFormalesData = [
    {
        id: 1,
        referencia: 'CF-001',
        tipo: 'invitacion',
        destinatario: 'Lic. Jorge Hernández',
        cargo: 'Alcalde Municipal',
        asunto: 'Invitación Ceremonia de Aniversario',
        contenido: 'Por medio de la presente, tenemos el honor de invitarle a la ceremonia...',
        fechaEnvio: '2025-09-10',
        estadoRespuesta: 'respondida',
        fechaRespuesta: '2025-09-15',
        notas: 'Confirmó asistencia'
    },
    {
        id: 2,
        referencia: 'CF-002',
        tipo: 'agradecimiento',
        destinatario: 'Empresa Constructora Global',
        cargo: 'Gerencia General',
        asunto: 'Agradecimiento por Donación',
        contenido: 'Queremos expresar nuestro más sincero agradecimiento...',
        fechaEnvio: '2025-09-12',
        estadoRespuesta: 'no_requiere',
        fechaRespuesta: null,
        notas: 'Carta de cortesía'
    },
    {
        id: 3,
        referencia: 'CF-003',
        tipo: 'solicitud',
        destinatario: 'Dr. Manuel Rivera',
        cargo: 'Director Hospital Regional',
        asunto: 'Solicitud de Colaboración Campaña de Salud',
        contenido: 'Mediante la presente solicitamos su apoyo y colaboración...',
        fechaEnvio: '2025-09-18',
        estadoRespuesta: 'pendiente',
        fechaRespuesta: null,
        notas: 'Pendiente de respuesta'
    },
    {
        id: 4,
        referencia: 'CF-004',
        tipo: 'notificacion',
        destinatario: 'Socios Activos del Club',
        cargo: 'Miembros',
        asunto: 'Notificación Cambio de Horario Reunión',
        contenido: 'Les informamos que la reunión programada ha sido reprogramada...',
        fechaEnvio: '2025-09-22',
        estadoRespuesta: 'no_requiere',
        fechaRespuesta: null,
        notas: 'Comunicado general'
    },
    {
        id: 5,
        referencia: 'CF-005',
        tipo: 'invitacion',
        destinatario: 'Licda. Patricia Gómez',
        cargo: 'Ministra de Desarrollo Social',
        asunto: 'Invitación Evento Benéfico',
        contenido: 'Tenemos el gusto de invitarle a nuestro evento benéfico anual...',
        fechaEnvio: '2025-09-25',
        estadoRespuesta: 'respondida',
        fechaRespuesta: '2025-09-28',
        notas: 'Asistirá con comitiva'
    },
    {
        id: 6,
        referencia: 'CF-006',
        tipo: 'solicitud',
        destinatario: 'Banco de Desarrollo',
        cargo: 'Departamento de RSE',
        asunto: 'Solicitud Apoyo Financiero Proyecto Educativo',
        contenido: 'Solicitamos su valioso apoyo financiero para nuestro proyecto...',
        fechaEnvio: '2025-10-01',
        estadoRespuesta: 'pendiente',
        fechaRespuesta: null,
        notas: 'Seguimiento en 2 semanas'
    }
];

let proximoIdFormal = 7;

function renderizarTablaFormal() {
    const tbody = document.getElementById('tbodyCartasFormal');
    tbody.innerHTML = '';

    const tipoLabels = {
        'invitacion': 'Invitación',
        'agradecimiento': 'Agradecimiento',
        'solicitud': 'Solicitud',
        'notificacion': 'Notificación',
        'otro': 'Otro'
    };

    const estadoBadge = {
        'respondida': '<span class="badge bg-success">Respondida</span>',
        'pendiente': '<span class="badge bg-warning text-dark">Pendiente</span>',
        'no_requiere': '<span class="badge bg-secondary">No Requiere</span>'
    };

    cartasFormalesData.forEach(carta => {
        tbody.innerHTML += `
            <tr data-id="${carta.id}">
                <td><strong>${carta.referencia}</strong></td>
                <td>${tipoLabels[carta.tipo]}</td>
                <td>${carta.destinatario}</td>
                <td>${carta.asunto}</td>
                <td>${formatearFecha(carta.fechaEnvio)}</td>
                <td>${estadoBadge[carta.estadoRespuesta]}</td>
                <td>${carta.fechaRespuesta ? formatearFecha(carta.fechaRespuesta) : '-'}</td>
                <td>
                    <button class="btn btn-sm btn-info" onclick="verDetalleFormal(${carta.id})">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-warning" onclick="editarCartaFormal(${carta.id})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="eliminarCartaFormal(${carta.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });
}

function verDetalleFormal(id) {
    const carta = cartasFormalesData.find(c => c.id === id);
    if (!carta) return;

    const tipoLabels = {
        'invitacion': 'Invitación',
        'agradecimiento': 'Agradecimiento',
        'solicitud': 'Solicitud',
        'notificacion': 'Notificación',
        'otro': 'Otro'
    };

    const estadoBadge = {
        'respondida': '<span class="badge bg-success">Respondida</span>',
        'pendiente': '<span class="badge bg-warning text-dark">Pendiente</span>',
        'no_requiere': '<span class="badge bg-secondary">No Requiere</span>'
    };

    document.getElementById('detalleContenidoFormal').innerHTML = `
        <div class="row g-3">
            <div class="col-md-6">
                <strong>Referencia:</strong><br>${carta.referencia}
            </div>
            <div class="col-md-6">
                <strong>Tipo:</strong><br>${tipoLabels[carta.tipo]}
            </div>
            <div class="col-md-6">
                <strong>Destinatario:</strong><br>${carta.destinatario}
            </div>
            <div class="col-md-6">
                <strong>Cargo/Institución:</strong><br>${carta.cargo || 'N/A'}
            </div>
            <div class="col-md-12">
                <strong>Asunto:</strong><br>${carta.asunto}
            </div>
            <div class="col-md-6">
                <strong>Fecha de Envío:</strong><br>${formatearFecha(carta.fechaEnvio)}
            </div>
            <div class="col-md-6">
                <strong>Estado de Respuesta:</strong><br>${estadoBadge[carta.estadoRespuesta]}
            </div>
            <div class="col-md-12">
                <strong>Fecha de Respuesta:</strong><br>${carta.fechaRespuesta ? formatearFecha(carta.fechaRespuesta) : 'No aplica'}
            </div>
            <div class="col-md-12">
                <strong>Contenido:</strong><br>
                <div class="border p-3 mt-2" style="white-space: pre-wrap;">${carta.contenido || 'Sin contenido registrado'}</div>
            </div>
            <div class="col-md-12">
                <strong>Notas:</strong><br>${carta.notas || 'Sin notas'}
            </div>
        </div>
    `;

    new bootstrap.Modal(document.getElementById('modalDetalleFormal')).show();
}

function editarCartaFormal(id) {
    const carta = cartasFormalesData.find(c => c.id === id);
    if (!carta) return;

    document.getElementById('cartaFormalId').value = carta.id;
    document.getElementById('tipo').value = carta.tipo;
    document.getElementById('destinatario').value = carta.destinatario;
    document.getElementById('cargo').value = carta.cargo || '';
    document.getElementById('asunto').value = carta.asunto;
    document.getElementById('contenido').value = carta.contenido || '';
    document.getElementById('fechaEnvio').value = carta.fechaEnvio;
    document.getElementById('estadoRespuesta').value = carta.estadoRespuesta;
    document.getElementById('fechaRespuesta').value = carta.fechaRespuesta || '';
    document.getElementById('notas').value = carta.notas || '';

    document.querySelector('#modalNuevaCartaFormal .modal-title').textContent = 'Editar Carta Formal';
    new bootstrap.Modal(document.getElementById('modalNuevaCartaFormal')).show();
}

function guardarCartaFormal() {
    const id = document.getElementById('cartaFormalId').value;
    const datos = {
        tipo: document.getElementById('tipo').value,
        destinatario: document.getElementById('destinatario').value,
        cargo: document.getElementById('cargo').value,
        asunto: document.getElementById('asunto').value,
        contenido: document.getElementById('contenido').value,
        fechaEnvio: document.getElementById('fechaEnvio').value,
        estadoRespuesta: document.getElementById('estadoRespuesta').value,
        fechaRespuesta: document.getElementById('fechaRespuesta').value || null,
        notas: document.getElementById('notas').value
    };

    if (id) {
        // Editar
        const index = cartasFormalesData.findIndex(c => c.id === parseInt(id));
        if (index !== -1) {
            cartasFormalesData[index] = { ...cartasFormalesData[index], ...datos };
            alert('Carta actualizada exitosamente');
        }
    } else {
        // Crear nueva
        const nuevaCarta = {
            id: proximoIdFormal++,
            referencia: `CF-${String(proximoIdFormal - 1).padStart(3, '0')}`,
            ...datos
        };
        cartasFormalesData.push(nuevaCarta);
        alert('Carta creada exitosamente');
    }

    bootstrap.Modal.getInstance(document.getElementById('modalNuevaCartaFormal')).hide();
    document.getElementById('formCartaFormal').reset();
    document.getElementById('cartaFormalId').value = '';
    document.querySelector('#modalNuevaCartaFormal .modal-title').textContent = 'Nueva Carta Formal';
    
    renderizarTablaFormal();
}

function eliminarCartaFormal(id) {
    if (confirm('¿Está seguro de eliminar esta carta?')) {
        cartasFormalesData = cartasFormalesData.filter(c => c.id !== id);
        renderizarTablaFormal();
        alert('Carta eliminada exitosamente');
    }
}

function formatearFecha(fecha) {
    if (!fecha) return '';
    const [year, month, day] = fecha.split('-');
    return `${day}/${month}/${year}`;
}

function aplicarFiltros() {
    alert('Filtros aplicados (funcionalidad simulada)');
}

function limpiarFiltros() {
    document.getElementById('filtroTipo').value = '';
    document.getElementById('filtroRespuesta').value = '';
    document.getElementById('filtroFechaDesde').value = '';
    document.getElementById('filtroFechaHasta').value = '';
}

function exportarArchivo() {
    alert('Exportando archivo... (funcionalidad simulada)');
}

function imprimirCarta() {
    window.print();
}

// Limpiar modal al cerrar
document.getElementById('modalNuevaCartaFormal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('formCartaFormal').reset();
    document.getElementById('cartaFormalId').value = '';
    document.querySelector('#modalNuevaCartaFormal .modal-title').textContent = 'Nueva Carta Formal';
});

// Inicializar tabla
renderizarTablaFormal();
</script>
@endsection
