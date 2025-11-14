@extends('layouts.app')

@section('title', 'Cartas de Patrocinio - Vicepresidente')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-0">Cartas de Patrocinio</h2>
            <p class="text-muted">Gestión de cartas de patrocinio enviadas</p>
        </div>
        <div class="col-md-4 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaCarta">
                <i class="fas fa-plus me-2"></i>Nueva Carta
            </button>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select class="form-select" id="filtroEstado">
                        <option value="">Todos los estados</option>
                        <option value="enviada">Enviada</option>
                        <option value="respondida">Respondida</option>
                        <option value="pendiente">Pendiente</option>
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
                <div class="col-md-3">
                    <label class="form-label">Destinatario</label>
                    <input type="text" class="form-control" id="filtroDestinatario" placeholder="Buscar...">
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
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Cartas -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Cartas de Patrocinio</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tablaCarta">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Destinatario</th>
                            <th>Empresa/Organización</th>
                            <th>Fecha Envío</th>
                            <th>Monto Solicitado</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyCartas">
                        <tr data-id="1">
                            <td>CP-001</td>
                            <td>Lic. Roberto Gómez</td>
                            <td>Banco Nacional</td>
                            <td>15/09/2025</td>
                            <td>L. 50,000.00</td>
                            <td><span class="badge bg-success">Respondida</span></td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="verDetalle(1)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" onclick="editarCarta(1)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="eliminarCarta(1)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr data-id="2">
                            <td>CP-002</td>
                            <td>Ing. María Fernández</td>
                            <td>Constructora del Sur</td>
                            <td>20/09/2025</td>
                            <td>L. 75,000.00</td>
                            <td><span class="badge bg-warning text-dark">Enviada</span></td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="verDetalle(2)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" onclick="editarCarta(2)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="eliminarCarta(2)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr data-id="3">
                            <td>CP-003</td>
                            <td>Dr. Carlos Méndez</td>
                            <td>Hospital San Rafael</td>
                            <td>25/09/2025</td>
                            <td>L. 35,000.00</td>
                            <td><span class="badge bg-danger">Pendiente</span></td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="verDetalle(3)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" onclick="editarCarta(3)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="eliminarCarta(3)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr data-id="4">
                            <td>CP-004</td>
                            <td>Licda. Ana Martínez</td>
                            <td>Supermercados La Esperanza</td>
                            <td>28/09/2025</td>
                            <td>L. 100,000.00</td>
                            <td><span class="badge bg-success">Respondida</span></td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="verDetalle(4)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" onclick="editarCarta(4)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="eliminarCarta(4)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr data-id="5">
                            <td>CP-005</td>
                            <td>Lic. Pedro Ramírez</td>
                            <td>Industrias Textiles SA</td>
                            <td>01/10/2025</td>
                            <td>L. 60,000.00</td>
                            <td><span class="badge bg-warning text-dark">Enviada</span></td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="verDetalle(5)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" onclick="editarCarta(5)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="eliminarCarta(5)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva/Editar Carta -->
<div class="modal fade" id="modalNuevaCarta" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Carta de Patrocinio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formCarta">
                    <input type="hidden" id="cartaId">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Destinatario *</label>
                            <input type="text" class="form-control" id="destinatario" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Empresa/Organización *</label>
                            <input type="text" class="form-control" id="empresa" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha de Envío *</label>
                            <input type="date" class="form-control" id="fechaEnvio" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Monto Solicitado *</label>
                            <input type="number" class="form-control" id="monto" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Estado *</label>
                            <select class="form-select" id="estado" required>
                                <option value="pendiente">Pendiente</option>
                                <option value="enviada">Enviada</option>
                                <option value="respondida">Respondida</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Contacto</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Descripción del Proyecto</label>
                            <textarea class="form-control" id="descripcion" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notas</label>
                            <textarea class="form-control" id="notas" rows="2"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarCarta()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ver Detalle -->
<div class="modal fade" id="modalDetalle" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle de Carta de Patrocinio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detalleContenido">
                <!-- Se llenará dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
// Datos mock en memoria
let cartasData = [
    {
        id: 1,
        codigo: 'CP-001',
        destinatario: 'Lic. Roberto Gómez',
        empresa: 'Banco Nacional',
        fechaEnvio: '2025-09-15',
        monto: 50000,
        estado: 'respondida',
        email: 'rgomez@banconacional.hn',
        descripcion: 'Proyecto de educación comunitaria',
        notas: 'Respuesta positiva recibida el 20/09/2025'
    },
    {
        id: 2,
        codigo: 'CP-002',
        destinatario: 'Ing. María Fernández',
        empresa: 'Constructora del Sur',
        fechaEnvio: '2025-09-20',
        monto: 75000,
        estado: 'enviada',
        email: 'mfernandez@constructorasur.com',
        descripcion: 'Construcción de centro comunitario',
        notas: 'Pendiente de respuesta'
    },
    {
        id: 3,
        codigo: 'CP-003',
        destinatario: 'Dr. Carlos Méndez',
        empresa: 'Hospital San Rafael',
        fechaEnvio: '2025-09-25',
        monto: 35000,
        estado: 'pendiente',
        email: 'cmendez@sanrafael.hn',
        descripcion: 'Campaña de salud preventiva',
        notas: 'Carta por enviar'
    },
    {
        id: 4,
        codigo: 'CP-004',
        destinatario: 'Licda. Ana Martínez',
        empresa: 'Supermercados La Esperanza',
        fechaEnvio: '2025-09-28',
        monto: 100000,
        estado: 'respondida',
        email: 'amartinez@laesperanza.hn',
        descripcion: 'Programa de alimentación escolar',
        notas: 'Aprobado monto completo'
    },
    {
        id: 5,
        codigo: 'CP-005',
        destinatario: 'Lic. Pedro Ramírez',
        empresa: 'Industrias Textiles SA',
        fechaEnvio: '2025-10-01',
        monto: 60000,
        estado: 'enviada',
        email: 'pramirez@textiles.com',
        descripcion: 'Taller de capacitación técnica',
        notas: 'Seguimiento programado para 10/10/2025'
    }
];

let proximoId = 6;

function verDetalle(id) {
    const carta = cartasData.find(c => c.id === id);
    if (!carta) return;

    const estadoBadge = {
        'enviada': '<span class="badge bg-warning text-dark">Enviada</span>',
        'respondida': '<span class="badge bg-success">Respondida</span>',
        'pendiente': '<span class="badge bg-danger">Pendiente</span>'
    };

    document.getElementById('detalleContenido').innerHTML = `
        <div class="row g-3">
            <div class="col-md-6">
                <strong>Código:</strong><br>${carta.codigo}
            </div>
            <div class="col-md-6">
                <strong>Estado:</strong><br>${estadoBadge[carta.estado]}
            </div>
            <div class="col-md-6">
                <strong>Destinatario:</strong><br>${carta.destinatario}
            </div>
            <div class="col-md-6">
                <strong>Empresa:</strong><br>${carta.empresa}
            </div>
            <div class="col-md-6">
                <strong>Fecha de Envío:</strong><br>${formatearFecha(carta.fechaEnvio)}
            </div>
            <div class="col-md-6">
                <strong>Monto Solicitado:</strong><br>L. ${carta.monto.toLocaleString('es-HN', {minimumFractionDigits: 2})}
            </div>
            <div class="col-md-12">
                <strong>Email:</strong><br>${carta.email || 'No proporcionado'}
            </div>
            <div class="col-md-12">
                <strong>Descripción del Proyecto:</strong><br>${carta.descripcion || 'Sin descripción'}
            </div>
            <div class="col-md-12">
                <strong>Notas:</strong><br>${carta.notas || 'Sin notas'}
            </div>
        </div>
    `;

    new bootstrap.Modal(document.getElementById('modalDetalle')).show();
}

function editarCarta(id) {
    const carta = cartasData.find(c => c.id === id);
    if (!carta) return;

    document.getElementById('cartaId').value = carta.id;
    document.getElementById('destinatario').value = carta.destinatario;
    document.getElementById('empresa').value = carta.empresa;
    document.getElementById('fechaEnvio').value = carta.fechaEnvio;
    document.getElementById('monto').value = carta.monto;
    document.getElementById('estado').value = carta.estado;
    document.getElementById('email').value = carta.email || '';
    document.getElementById('descripcion').value = carta.descripcion || '';
    document.getElementById('notas').value = carta.notas || '';

    document.querySelector('#modalNuevaCarta .modal-title').textContent = 'Editar Carta de Patrocinio';
    new bootstrap.Modal(document.getElementById('modalNuevaCarta')).show();
}

function guardarCarta() {
    const id = document.getElementById('cartaId').value;
    const datos = {
        destinatario: document.getElementById('destinatario').value,
        empresa: document.getElementById('empresa').value,
        fechaEnvio: document.getElementById('fechaEnvio').value,
        monto: parseFloat(document.getElementById('monto').value),
        estado: document.getElementById('estado').value,
        email: document.getElementById('email').value,
        descripcion: document.getElementById('descripcion').value,
        notas: document.getElementById('notas').value
    };

    if (id) {
        // Editar
        const index = cartasData.findIndex(c => c.id === parseInt(id));
        if (index !== -1) {
            cartasData[index] = { ...cartasData[index], ...datos };
            alert('Carta actualizada exitosamente');
        }
    } else {
        // Crear nueva
        const nuevaCarta = {
            id: proximoId++,
            codigo: `CP-${String(proximoId - 1).padStart(3, '0')}`,
            ...datos
        };
        cartasData.push(nuevaCarta);
        alert('Carta creada exitosamente');
    }

    bootstrap.Modal.getInstance(document.getElementById('modalNuevaCarta')).hide();
    document.getElementById('formCarta').reset();
    document.getElementById('cartaId').value = '';
    document.querySelector('#modalNuevaCarta .modal-title').textContent = 'Nueva Carta de Patrocinio';
    
    renderizarTabla();
}

function eliminarCarta(id) {
    if (confirm('¿Está seguro de eliminar esta carta?')) {
        cartasData = cartasData.filter(c => c.id !== id);
        renderizarTabla();
        alert('Carta eliminada exitosamente');
    }
}

function formatearFecha(fecha) {
    const [year, month, day] = fecha.split('-');
    return `${day}/${month}/${year}`;
}

function renderizarTabla() {
    const tbody = document.getElementById('tbodyCartas');
    tbody.innerHTML = '';

    cartasData.forEach(carta => {
        const estadoBadge = {
            'enviada': '<span class="badge bg-warning text-dark">Enviada</span>',
            'respondida': '<span class="badge bg-success">Respondida</span>',
            'pendiente': '<span class="badge bg-danger">Pendiente</span>'
        };

        tbody.innerHTML += `
            <tr data-id="${carta.id}">
                <td>${carta.codigo}</td>
                <td>${carta.destinatario}</td>
                <td>${carta.empresa}</td>
                <td>${formatearFecha(carta.fechaEnvio)}</td>
                <td>L. ${carta.monto.toLocaleString('es-HN', {minimumFractionDigits: 2})}</td>
                <td>${estadoBadge[carta.estado]}</td>
                <td>
                    <button class="btn btn-sm btn-info" onclick="verDetalle(${carta.id})">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-warning" onclick="editarCarta(${carta.id})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="eliminarCarta(${carta.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });
}

function aplicarFiltros() {
    alert('Filtros aplicados (funcionalidad simulada)');
}

function limpiarFiltros() {
    document.getElementById('filtroEstado').value = '';
    document.getElementById('filtroFechaDesde').value = '';
    document.getElementById('filtroFechaHasta').value = '';
    document.getElementById('filtroDestinatario').value = '';
}

// Limpiar modal al cerrar
document.getElementById('modalNuevaCarta').addEventListener('hidden.bs.modal', function () {
    document.getElementById('formCarta').reset();
    document.getElementById('cartaId').value = '';
    document.querySelector('#modalNuevaCarta .modal-title').textContent = 'Nueva Carta de Patrocinio';
});
</script>
@endsection
