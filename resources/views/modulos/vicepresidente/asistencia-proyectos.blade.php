@extends('layouts.app')

@section('title', 'Participación en Proyectos - Vicepresidente')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0">Participación en Proyectos</h2>
            <p class="text-muted">Vista de solo lectura - Nivel de involucramiento por socio</p>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Nota:</strong> Esta es una vista de solo lectura. La gestión de participación es controlada por el módulo de Proyectos.
            </div>
        </div>
    </div>

    <!-- Estadísticas Generales -->
    <div class="row g-3 mb-4">
        <div class="col-md-2">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Proyectos</h6>
                    <h3 class="mb-0 text-primary">24</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Socios Activos</h6>
                    <h3 class="mb-0 text-success">38</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Participación Prom.</h6>
                    <h3 class="mb-0 text-info">3.2</h3>
                    <small class="text-muted">proyectos/socio</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Mayor Participación</h6>
                    <h3 class="mb-0 text-warning">Juan Pérez</h3>
                    <small class="text-muted">8 proyectos</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Horas Totales</h6>
                    <h3 class="mb-0 text-danger">1,250</h3>
                    <small class="text-muted">horas voluntarias</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Proyecto</label>
                    <select class="form-select" id="filtroProyecto" onchange="aplicarFiltros()">
                        <option value="">Todos los proyectos</option>
                        <option value="1">Sistema de Gestión Interna</option>
                        <option value="2">Campaña de Membresía</option>
                        <option value="3">Renovación de Infraestructura</option>
                        <option value="4">Evento Anual de Rotarios</option>
                        <option value="5">Programa Becas Estudiantiles</option>
                        <option value="6">Campaña de Salud Comunitaria</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Nivel de Involucramiento</label>
                    <select class="form-select" id="filtroNivel" onchange="aplicarFiltros()">
                        <option value="">Todos los niveles</option>
                        <option value="alto">Alto</option>
                        <option value="medio">Medio</option>
                        <option value="bajo">Bajo</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Rol</label>
                    <select class="form-select" id="filtroRol" onchange="aplicarFiltros()">
                        <option value="">Todos los roles</option>
                        <option value="lider">Líder</option>
                        <option value="coordinador">Coordinador</option>
                        <option value="voluntario">Voluntario</option>
                        <option value="asesor">Asesor</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Búsqueda</label>
                    <input type="text" class="form-control" id="filtroBusqueda" placeholder="Buscar socio..." onkeyup="aplicarFiltros()">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <button class="btn btn-secondary" onclick="limpiarFiltros()">
                        <i class="fas fa-times me-2"></i>Limpiar Filtros
                    </button>
                    <button class="btn btn-primary" onclick="verVistaProyectos()">
                        <i class="fas fa-project-diagram me-2"></i>Vista por Proyectos
                    </button>
                    <button class="btn btn-info" onclick="verVistaSocios()">
                        <i class="fas fa-users me-2"></i>Vista por Socios
                    </button>
                    <button class="btn btn-success" onclick="exportarReporte()">
                        <i class="fas fa-file-excel me-2"></i>Exportar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenedor de Vistas -->
    <div id="contenedorVistas">
        <!-- Se llenará dinámicamente -->
    </div>
</div>

<!-- Modal Detalle de Participación -->
<div class="modal fade" id="modalDetalleParticipacion" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle de Participación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detalleParticipacionContenido">
                <!-- Se llenará dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="imprimirDetalle()">
                    <i class="fas fa-print me-2"></i>Imprimir
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.participante-card {
    transition: transform 0.2s;
    cursor: pointer;
}
.participante-card:hover {
    transform: translateY(-3px);
}
.nivel-badge {
    width: 80px;
    text-align: center;
}
</style>

<script>
// Datos mock de participación
let participacionData = [
    {
        id: 1,
        socio: 'Juan Pérez',
        proyectos: [
            { proyectoId: 1, proyecto: 'Sistema de Gestión Interna', rol: 'lider', nivel: 'alto', horasAportadas: 120 },
            { proyectoId: 2, proyecto: 'Campaña de Membresía', rol: 'coordinador', nivel: 'medio', horasAportadas: 45 },
            { proyectoId: 5, proyecto: 'Programa Becas Estudiantiles', rol: 'voluntario', nivel: 'medio', horasAportadas: 35 }
        ],
        totalProyectos: 3,
        totalHoras: 200,
        nivelGeneral: 'alto'
    },
    {
        id: 2,
        socio: 'María González',
        proyectos: [
            { proyectoId: 2, proyecto: 'Campaña de Membresía', rol: 'lider', nivel: 'alto', horasAportadas: 150 },
            { proyectoId: 6, proyecto: 'Campaña de Salud Comunitaria', rol: 'coordinador', nivel: 'alto', horasAportadas: 95 }
        ],
        totalProyectos: 2,
        totalHoras: 245,
        nivelGeneral: 'alto'
    },
    {
        id: 3,
        socio: 'Carlos Méndez',
        proyectos: [
            { proyectoId: 3, proyecto: 'Renovación de Infraestructura', rol: 'lider', nivel: 'alto', horasAportadas: 180 },
            { proyectoId: 7, proyecto: 'Construcción Centro Comunitario', rol: 'lider', nivel: 'alto', horasAportadas: 165 }
        ],
        totalProyectos: 2,
        totalHoras: 345,
        nivelGeneral: 'alto'
    },
    {
        id: 4,
        socio: 'Ana Martínez',
        proyectos: [
            { proyectoId: 4, proyecto: 'Evento Anual de Rotarios', rol: 'lider', nivel: 'alto', horasAportadas: 130 },
            { proyectoId: 8, proyecto: 'Talleres de Capacitación Técnica', rol: 'coordinador', nivel: 'medio', horasAportadas: 75 }
        ],
        totalProyectos: 2,
        totalHoras: 205,
        nivelGeneral: 'alto'
    },
    {
        id: 5,
        socio: 'Luis Rodríguez',
        proyectos: [
            { proyectoId: 5, proyecto: 'Programa Becas Estudiantiles', rol: 'coordinador', nivel: 'medio', horasAportadas: 80 },
            { proyectoId: 1, proyecto: 'Sistema de Gestión Interna', rol: 'asesor', nivel: 'bajo', horasAportadas: 25 }
        ],
        totalProyectos: 2,
        totalHoras: 105,
        nivelGeneral: 'medio'
    },
    {
        id: 6,
        socio: 'Pedro Ramírez',
        proyectos: [
            { proyectoId: 3, proyecto: 'Renovación de Infraestructura', rol: 'voluntario', nivel: 'medio', horasAportadas: 55 }
        ],
        totalProyectos: 1,
        totalHoras: 55,
        nivelGeneral: 'medio'
    },
    {
        id: 7,
        socio: 'Roberto Gómez',
        proyectos: [
            { proyectoId: 6, proyecto: 'Campaña de Salud Comunitaria', rol: 'voluntario', nivel: 'bajo', horasAportadas: 30 },
            { proyectoId: 4, proyecto: 'Evento Anual de Rotarios', rol: 'voluntario', nivel: 'bajo', horasAportadas: 20 }
        ],
        totalProyectos: 2,
        totalHoras: 50,
        nivelGeneral: 'bajo'
    },
    {
        id: 8,
        socio: 'Patricia López',
        proyectos: [
            { proyectoId: 2, proyecto: 'Campaña de Membresía', rol: 'voluntario', nivel: 'medio', horasAportadas: 45 },
            { proyectoId: 5, proyecto: 'Programa Becas Estudiantiles', rol: 'asesor', nivel: 'medio', horasAportadas: 40 }
        ],
        totalProyectos: 2,
        totalHoras: 85,
        nivelGeneral: 'medio'
    }
];

let vistaActual = 'socios'; // 'socios' o 'proyectos'

const nivelLabels = {
    'alto': { label: 'Alto', class: 'success' },
    'medio': { label: 'Medio', class: 'warning' },
    'bajo': { label: 'Bajo', class: 'secondary' }
};

const rolLabels = {
    'lider': { label: 'Líder', icon: 'fa-star' },
    'coordinador': { label: 'Coordinador', icon: 'fa-user-tie' },
    'voluntario': { label: 'Voluntario', icon: 'fa-hands-helping' },
    'asesor': { label: 'Asesor', icon: 'fa-user-graduate' }
};

function verVistaSocios() {
    vistaActual = 'socios';
    renderizarVistaSocios();
}

function verVistaProyectos() {
    vistaActual = 'proyectos';
    renderizarVistaProyectos();
}

function renderizarVistaSocios(datosFiltrados = participacionData) {
    const contenedor = document.getElementById('contenedorVistas');
    
    if (datosFiltrados.length === 0) {
        contenedor.innerHTML = `
            <div class="alert alert-warning text-center">
                <i class="fas fa-exclamation-triangle me-2"></i>
                No se encontraron registros con los filtros seleccionados.
            </div>
        `;
        return;
    }

    // Ordenar por total de horas
    datosFiltrados.sort((a, b) => b.totalHoras - a.totalHoras);

    contenedor.innerHTML = `
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Participación por Socio</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Ranking</th>
                                <th>Socio</th>
                                <th>Proyectos Activos</th>
                                <th>Horas Aportadas</th>
                                <th>Nivel General</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${datosFiltrados.map((item, index) => {
                                const nivel = nivelLabels[item.nivelGeneral];
                                return `
                                    <tr>
                                        <td>
                                            <strong class="text-primary">#${index + 1}</strong>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle bg-primary text-white me-2" 
                                                     style="width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    ${item.socio.split(' ').map(n => n[0]).join('')}
                                                </div>
                                                <strong>${item.socio}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">${item.totalProyectos}</span>
                                        </td>
                                        <td>
                                            <strong>${item.totalHoras}</strong> horas
                                        </td>
                                        <td>
                                            <span class="badge bg-${nivel.class} nivel-badge">${nivel.label}</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick="verDetalleSocio(${item.id})">
                                                <i class="fas fa-eye me-1"></i>Ver Detalle
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            }).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `;
}

function renderizarVistaProyectos() {
    // Agrupar por proyecto
    const proyectosAgrupados = {};
    
    participacionData.forEach(socio => {
        socio.proyectos.forEach(proyecto => {
            if (!proyectosAgrupados[proyecto.proyectoId]) {
                proyectosAgrupados[proyecto.proyectoId] = {
                    nombre: proyecto.proyecto,
                    participantes: []
                };
            }
            proyectosAgrupados[proyecto.proyectoId].participantes.push({
                socio: socio.socio,
                rol: proyecto.rol,
                nivel: proyecto.nivel,
                horas: proyecto.horasAportadas
            });
        });
    });

    const contenedor = document.getElementById('contenedorVistas');
    contenedor.innerHTML = '';

    Object.keys(proyectosAgrupados).forEach(proyectoId => {
        const proyecto = proyectosAgrupados[proyectoId];
        const totalHoras = proyecto.participantes.reduce((sum, p) => sum + p.horas, 0);
        
        contenedor.innerHTML += `
            <div class="card shadow mb-3">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">${proyecto.nombre}</h6>
                        <span class="badge bg-light text-dark">
                            ${proyecto.participantes.length} participantes - ${totalHoras} horas
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Socio</th>
                                    <th>Rol</th>
                                    <th>Nivel</th>
                                    <th>Horas</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${proyecto.participantes.map(p => {
                                    const nivel = nivelLabels[p.nivel];
                                    const rol = rolLabels[p.rol];
                                    return `
                                        <tr>
                                            <td>${p.socio}</td>
                                            <td>
                                                <i class="fas ${rol.icon} me-1"></i>${rol.label}
                                            </td>
                                            <td>
                                                <span class="badge bg-${nivel.class}">${nivel.label}</span>
                                            </td>
                                            <td><strong>${p.horas}</strong> hrs</td>
                                        </tr>
                                    `;
                                }).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;
    });
}

function verDetalleSocio(id) {
    const socio = participacionData.find(s => s.id === id);
    if (!socio) return;

    const nivel = nivelLabels[socio.nivelGeneral];

    document.getElementById('detalleParticipacionContenido').innerHTML = `
        <div class="row g-3">
            <div class="col-12">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-circle bg-primary text-white me-3" 
                         style="width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                        ${socio.socio.split(' ').map(n => n[0]).join('')}
                    </div>
                    <div>
                        <h4 class="mb-0">${socio.socio}</h4>
                        <span class="badge bg-${nivel.class}">${nivel.label} Involucramiento</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h3 class="text-primary mb-0">${socio.totalProyectos}</h3>
                        <small class="text-muted">Proyectos Activos</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h3 class="text-success mb-0">${socio.totalHoras}</h3>
                        <small class="text-muted">Horas Totales</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h3 class="text-info mb-0">${(socio.totalHoras / socio.totalProyectos).toFixed(1)}</h3>
                        <small class="text-muted">Horas por Proyecto</small>
                    </div>
                </div>
            </div>
            
            <div class="col-12">
                <h5 class="mb-3">Proyectos en los que Participa</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Proyecto</th>
                                <th>Rol</th>
                                <th>Nivel de Involucramiento</th>
                                <th>Horas Aportadas</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${socio.proyectos.map(p => {
                                const nivelP = nivelLabels[p.nivel];
                                const rolP = rolLabels[p.rol];
                                return `
                                    <tr>
                                        <td><strong>${p.proyecto}</strong></td>
                                        <td>
                                            <i class="fas ${rolP.icon} me-1"></i>${rolP.label}
                                        </td>
                                        <td>
                                            <span class="badge bg-${nivelP.class}">${nivelP.label}</span>
                                        </td>
                                        <td><strong>${p.horasAportadas}</strong> horas</td>
                                    </tr>
                                `;
                            }).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `;

    new bootstrap.Modal(document.getElementById('modalDetalleParticipacion')).show();
}

function aplicarFiltros() {
    // Implementación de filtros (simplificada)
    renderizarVistaSocios();
}

function limpiarFiltros() {
    document.getElementById('filtroProyecto').value = '';
    document.getElementById('filtroNivel').value = '';
    document.getElementById('filtroRol').value = '';
    document.getElementById('filtroBusqueda').value = '';
    if (vistaActual === 'socios') {
        renderizarVistaSocios();
    } else {
        renderizarVistaProyectos();
    }
}

function exportarReporte() {
    alert('Exportando reporte de participación... (funcionalidad simulada)');
}

function imprimirDetalle() {
    window.print();
}

// Inicializar vista por socios
renderizarVistaSocios();
</script>
@endsection
