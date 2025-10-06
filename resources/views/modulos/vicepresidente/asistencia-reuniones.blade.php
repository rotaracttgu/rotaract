@extends('layouts.app')

@section('title', 'Asistencia a Reuniones - Vicepresidente')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0">Asistencia a Reuniones</h2>
            <p class="text-muted">Vista de solo lectura - Reportes de asistencia</p>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Nota:</strong> Esta es una vista de solo lectura. El registro de asistencia es gestionado por el módulo de Secretario.
            </div>
        </div>
    </div>

    <!-- Estadísticas de Asistencia -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Reuniones Este Mes
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">12</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Asistencia Promedio
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">85%</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Socios Activos
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">45</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Próximas Reuniones
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Tipo de Reunión</label>
                    <select class="form-select" id="filtroTipo" onchange="aplicarFiltros()">
                        <option value="">Todas</option>
                        <option value="ordinaria">Ordinaria</option>
                        <option value="extraordinaria">Extraordinaria</option>
                        <option value="junta_directiva">Junta Directiva</option>
                        <option value="comite">Comité</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Mes</label>
                    <select class="form-select" id="filtroMes" onchange="aplicarFiltros()">
                        <option value="">Todos</option>
                        <option value="01">Enero</option>
                        <option value="02">Febrero</option>
                        <option value="03">Marzo</option>
                        <option value="04">Abril</option>
                        <option value="05">Mayo</option>
                        <option value="06">Junio</option>
                        <option value="07">Julio</option>
                        <option value="08">Agosto</option>
                        <option value="09">Septiembre</option>
                        <option value="10" selected>Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Año</label>
                    <select class="form-select" id="filtroAnio" onchange="aplicarFiltros()">
                        <option value="2025" selected>2025</option>
                        <option value="2024">2024</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Búsqueda</label>
                    <input type="text" class="form-control" id="filtroBusqueda" placeholder="Buscar..." onkeyup="aplicarFiltros()">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <button class="btn btn-secondary" onclick="limpiarFiltros()">
                        <i class="fas fa-times me-2"></i>Limpiar Filtros
                    </button>
                    <button class="btn btn-success" onclick="exportarReporte()">
                        <i class="fas fa-file-excel me-2"></i>Exportar Reporte
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Reuniones -->
    <div id="listaReuniones">
        <!-- Las reuniones se cargarán dinámicamente -->
    </div>
</div>

<!-- Modal Detalle de Asistencia -->
<div class="modal fade" id="modalDetalleAsistencia" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle de Asistencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detalleAsistenciaContenido">
                <!-- Se llenará dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="imprimirAsistencia()">
                    <i class="fas fa-print me-2"></i>Imprimir Lista
                </button>
                <button type="button" class="btn btn-success" onclick="exportarAsistencia()">
                    <i class="fas fa-file-excel me-2"></i>Exportar
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
.reunion-card {
    transition: transform 0.2s;
}
.reunion-card:hover {
    transform: translateY(-3px);
}
</style>

<script>
// Datos mock de reuniones
let reunionesData = [
    {
        id: 1,
        tipo: 'ordinaria',
        titulo: 'Reunión Ordinaria Semanal',
        fecha: '2025-10-01',
        hora: '18:00',
        lugar: 'Salón Principal',
        asistentes: 38,
        totalSocios: 45,
        porcentajeAsistencia: 84,
        asistencia: [
            { nombre: 'Juan Pérez', estado: 'presente' },
            { nombre: 'María González', estado: 'presente' },
            { nombre: 'Carlos Méndez', estado: 'ausente' },
            { nombre: 'Ana Martínez', estado: 'presente' },
            { nombre: 'Luis Rodríguez', estado: 'presente' },
            { nombre: 'Pedro Ramírez', estado: 'justificado' }
        ]
    },
    {
        id: 2,
        tipo: 'junta_directiva',
        titulo: 'Junta Directiva Mensual',
        fecha: '2025-10-02',
        hora: '19:00',
        lugar: 'Sala de Juntas',
        asistentes: 8,
        totalSocios: 10,
        porcentajeAsistencia: 80,
        asistencia: [
            { nombre: 'Roberto Gómez', estado: 'presente' },
            { nombre: 'Ana Martínez', estado: 'presente' },
            { nombre: 'Carlos Méndez', estado: 'ausente' },
            { nombre: 'María González', estado: 'presente' }
        ]
    },
    {
        id: 3,
        tipo: 'comite',
        titulo: 'Comité de Proyectos Comunitarios',
        fecha: '2025-10-03',
        hora: '17:00',
        lugar: 'Sala de Reuniones',
        asistentes: 12,
        totalSocios: 15,
        porcentajeAsistencia: 80,
        asistencia: [
            { nombre: 'Luis Rodríguez', estado: 'presente' },
            { nombre: 'Pedro Ramírez', estado: 'presente' },
            { nombre: 'Ana Martínez', estado: 'justificado' },
            { nombre: 'Juan Pérez', estado: 'presente' }
        ]
    },
    {
        id: 4,
        tipo: 'extraordinaria',
        titulo: 'Reunión Extraordinaria - Elecciones',
        fecha: '2025-10-05',
        hora: '18:30',
        lugar: 'Auditorio',
        asistentes: 42,
        totalSocios: 45,
        porcentajeAsistencia: 93,
        asistencia: [
            { nombre: 'Juan Pérez', estado: 'presente' },
            { nombre: 'María González', estado: 'presente' },
            { nombre: 'Carlos Méndez', estado: 'presente' },
            { nombre: 'Ana Martínez', estado: 'presente' }
        ]
    },
    {
        id: 5,
        tipo: 'ordinaria',
        titulo: 'Reunión Ordinaria Semanal',
        fecha: '2025-09-24',
        hora: '18:00',
        lugar: 'Salón Principal',
        asistentes: 35,
        totalSocios: 45,
        porcentajeAsistencia: 78,
        asistencia: [
            { nombre: 'Juan Pérez', estado: 'presente' },
            { nombre: 'María González', estado: 'ausente' },
            { nombre: 'Carlos Méndez', estado: 'presente' },
            { nombre: 'Ana Martínez', estado: 'presente' }
        ]
    },
    {
        id: 6,
        tipo: 'comite',
        titulo: 'Comité de Membresía',
        fecha: '2025-09-26',
        hora: '19:00',
        lugar: 'Sala de Conferencias',
        asistentes: 10,
        totalSocios: 12,
        porcentajeAsistencia: 83,
        asistencia: [
            { nombre: 'María González', estado: 'presente' },
            { nombre: 'Luis Rodríguez', estado: 'presente' },
            { nombre: 'Pedro Ramírez', estado: 'justificado' }
        ]
    }
];

const tipoLabels = {
    'ordinaria': { label: 'Ordinaria', class: 'primary' },
    'extraordinaria': { label: 'Extraordinaria', class: 'warning' },
    'junta_directiva': { label: 'Junta Directiva', class: 'danger' },
    'comite': { label: 'Comité', class: 'info' }
};

function renderizarReuniones(reunionesFiltradas = reunionesData) {
    const contenedor = document.getElementById('listaReuniones');
    contenedor.innerHTML = '';

    if (reunionesFiltradas.length === 0) {
        contenedor.innerHTML = `
            <div class="alert alert-warning text-center">
                <i class="fas fa-exclamation-triangle me-2"></i>
                No se encontraron reuniones con los filtros seleccionados.
            </div>
        `;
        return;
    }

    reunionesFiltradas.forEach(reunion => {
        const tipo = tipoLabels[reunion.tipo];
        const porcentajeClass = reunion.porcentajeAsistencia >= 80 ? 'success' : 
                                reunion.porcentajeAsistencia >= 60 ? 'warning' : 'danger';

        contenedor.innerHTML += `
            <div class="card reunion-card shadow-sm mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center mb-2">
                                <h5 class="mb-0 me-3">${reunion.titulo}</h5>
                                <span class="badge bg-${tipo.class}">${tipo.label}</span>
                            </div>
                            <div class="text-muted">
                                <i class="fas fa-calendar me-2"></i>${formatearFecha(reunion.fecha)} - ${reunion.hora}
                                <i class="fas fa-map-marker-alt ms-3 me-2"></i>${reunion.lugar}
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="mb-2">
                                <h4 class="mb-0 text-${porcentajeClass}">${reunion.porcentajeAsistencia}%</h4>
                                <small class="text-muted">Asistencia</small>
                            </div>
                            <div class="text-muted small">
                                ${reunion.asistentes} / ${reunion.totalSocios} socios
                            </div>
                            <button class="btn btn-sm btn-primary mt-2" onclick="verDetalleAsistencia(${reunion.id})">
                                <i class="fas fa-list me-1"></i>Ver Asistencia
                            </button>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-${porcentajeClass}" 
                                 role="progressbar" 
                                 style="width: ${reunion.porcentajeAsistencia}%" 
                                 aria-valuenow="${reunion.porcentajeAsistencia}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                                ${reunion.asistentes} Asistentes
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
}

function verDetalleAsistencia(id) {
    const reunion = reunionesData.find(r => r.id === id);
    if (!reunion) return;

    const tipo = tipoLabels[reunion.tipo];
    const porcentajeClass = reunion.porcentajeAsistencia >= 80 ? 'success' : 
                            reunion.porcentajeAsistencia >= 60 ? 'warning' : 'danger';

    // Contar asistencias por estado
    const presentes = reunion.asistencia.filter(a => a.estado === 'presente').length;
    const ausentes = reunion.asistencia.filter(a => a.estado === 'ausente').length;
    const justificados = reunion.asistencia.filter(a => a.estado === 'justificado').length;

    document.getElementById('detalleAsistenciaContenido').innerHTML = `
        <div class="row g-3 mb-4">
            <div class="col-12">
                <h4>${reunion.titulo}</h4>
                <span class="badge bg-${tipo.class}">${tipo.label}</span>
            </div>
            
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6>Información de la Reunión</h6>
                        <table class="table table-sm mb-0">
                            <tr>
                                <td><strong>Fecha:</strong></td>
                                <td>${formatearFecha(reunion.fecha)}</td>
                            </tr>
                            <tr>
                                <td><strong>Hora:</strong></td>
                                <td>${reunion.hora}</td>
                            </tr>
                            <tr>
                                <td><strong>Lugar:</strong></td>
                                <td>${reunion.lugar}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6>Estadísticas de Asistencia</h6>
                        <div class="mb-3">
                            <h3 class="text-${porcentajeClass} mb-0">${reunion.porcentajeAsistencia}%</h3>
                            <small class="text-muted">${reunion.asistentes} de ${reunion.totalSocios} socios</small>
                        </div>
                        <div class="row g-2">
                            <div class="col-4 text-center">
                                <div class="text-success"><strong>${presentes}</strong></div>
                                <small class="text-muted">Presentes</small>
                            </div>
                            <div class="col-4 text-center">
                                <div class="text-danger"><strong>${ausentes}</strong></div>
                                <small class="text-muted">Ausentes</small>
                            </div>
                            <div class="col-4 text-center">
                                <div class="text-warning"><strong>${justificados}</strong></div>
                                <small class="text-muted">Justificados</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Lista de Asistencia</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Socio</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${reunion.asistencia.map((asistente, index) => {
                                const estadoBadge = {
                                    'presente': '<span class="badge bg-success">Presente</span>',
                                    'ausente': '<span class="badge bg-danger">Ausente</span>',
                                    'justificado': '<span class="badge bg-warning text-dark">Justificado</span>'
                                };
                                return `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${asistente.nombre}</td>
                                        <td>${estadoBadge[asistente.estado]}</td>
                                    </tr>
                                `;
                            }).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `;

    new bootstrap.Modal(document.getElementById('modalDetalleAsistencia')).show();
}

function aplicarFiltros() {
    const tipo = document.getElementById('filtroTipo').value;
    const mes = document.getElementById('filtroMes').value;
    const anio = document.getElementById('filtroAnio').value;
    const busqueda = document.getElementById('filtroBusqueda').value.toLowerCase();

    const reunionesFiltradas = reunionesData.filter(reunion => {
        const [year, month] = reunion.fecha.split('-');
        
        const cumpleTipo = !tipo || reunion.tipo === tipo;
        const cumpleMes = !mes || month === mes;
        const cumpleAnio = !anio || year === anio;
        const cumpleBusqueda = !busqueda || 
            reunion.titulo.toLowerCase().includes(busqueda) ||
            reunion.lugar.toLowerCase().includes(busqueda);

        return cumpleTipo && cumpleMes && cumpleAnio && cumpleBusqueda;
    });

    renderizarReuniones(reunionesFiltradas);
}

function limpiarFiltros() {
    document.getElementById('filtroTipo').value = '';
    document.getElementById('filtroMes').value = '10';
    document.getElementById('filtroAnio').value = '2025';
    document.getElementById('filtroBusqueda').value = '';
    renderizarReuniones();
}

function exportarReporte() {
    alert('Exportando reporte de asistencia... (funcionalidad simulada)');
}

function exportarAsistencia() {
    alert('Exportando lista de asistencia... (funcionalidad simulada)');
}

function imprimirAsistencia() {
    window.print();
}

function formatearFecha(fecha) {
    if (!fecha) return '';
    const [year, month, day] = fecha.split('-');
    const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    return `${day} ${meses[parseInt(month) - 1]} ${year}`;
}

// Inicializar
renderizarReuniones();
</script>
@endsection
