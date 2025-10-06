@extends('modulos.aspirante.layou')

@section('title', 'Mis Reuniones')
@section('page-title', 'Mis Reuniones')
@section('reuniones-active', 'active')

@section('content')
<!-- Estadísticas de asistencia -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body text-center">
                <h3>12</h3>
                <p class="mb-0">Reuniones Asistidas</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h3>95%</h3>
                <p class="mb-0">Porcentaje Asistencia</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h3>3</h3>
                <p class="mb-0">Próximas Reuniones</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body text-center">
                <h3>2</h3>
                <p class="mb-0">Este Mes</p>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="filtroTipo" class="form-label">Tipo de reunión:</label>
                        <select class="form-select" id="filtroTipo">
                            <option value="">Todas las reuniones</option>
                            <option value="general">Reuniones Generales</option>
                            <option value="proyecto">Reuniones de Proyecto</option>
                            <option value="capacitacion">Capacitaciones</option>
                            <option value="directiva">Reuniones de Directiva</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filtroFecha" class="form-label">Período:</label>
                        <select class="form-select" id="filtroFecha">
                            <option value="proximas">Próximas</option>
                            <option value="este-mes">Este mes</option>
                            <option value="mes-pasado">Mes pasado</option>
                            <option value="todas">Todas</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filtroEstado" class="form-label">Estado:</label>
                        <select class="form-select" id="filtroEstado">
                            <option value="">Todos los estados</option>
                            <option value="programada">Programadas</option>
                            <option value="realizada">Realizadas</option>
                            <option value="cancelada">Canceladas</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-outline-primary w-100">
                            <i class="fas fa-search"></i>
                            Filtrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Próximas reuniones -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-plus text-success"></i>
                    Próximas Reuniones
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-md-1 text-center">
                                <div class="bg-primary text-white rounded p-2">
                                    <div><strong>15</strong></div>
                                    <div><small>SEP</small></div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <h6 class="mb-1">
                                    <span class="badge bg-primary me-2">General</span>
                                    Reunión General Mensual
                                </h6>
                                <p class="mb-1">Revisión de avances de proyectos y planificación octubre</p>
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> 19:00 - 21:00 | 
                                    <i class="fas fa-map-marker-alt"></i> Sede Central
                                </small>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="badge bg-warning">Mañana</span>
                            </div>
                            <div class="col-md-2 text-center">
                                <button class="btn btn-sm btn-outline-primary">Ver Agenda</button>
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-md-1 text-center">
                                <div class="bg-success text-white rounded p-2">
                                    <div><strong>20</strong></div>
                                    <div><small>SEP</small></div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <h6 class="mb-1">
                                    <span class="badge bg-success me-2">Proyecto</span>
                                    Reunión Campaña de Reciclaje
                                </h6>
                                <p class="mb-1">Coordinación actividades en escuelas y evaluación primera fase</p>
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> 16:00 - 17:30 | 
                                    <i class="fas fa-video"></i> Virtual - Google Meet
                                </small>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="badge bg-success">En 4 días</span>
                            </div>
                            <div class="col-md-2 text-center">
                                <button class="btn btn-sm btn-outline-success">Ver Agenda</button>
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-md-1 text-center">
                                <div class="bg-info text-white rounded p-2">
                                    <div><strong>25</strong></div>
                                    <div><small>SEP</small></div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <h6 class="mb-1">
                                    <span class="badge bg-info me-2">Capacitación</span>
                                    Taller de Liderazgo Juvenil
                                </h6>
                                <p class="mb-1">Desarrollo de habilidades de comunicación y trabajo en equipo</p>
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> 18:00 - 20:00 | 
                                    <i class="fas fa-video"></i> Virtual - Zoom
                                </small>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="badge bg-info">En 9 días</span>
                            </div>
                            <div class="col-md-2 text-center">
                                <button class="btn btn-sm btn-outline-info">Ver Agenda</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Historial de reuniones -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history text-secondary"></i>
                    Historial de Reuniones
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Reunión</th>
                                <th>Tipo</th>
                                <th>Duración</th>
                                <th>Asistencia</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>12 Sep 2025</td>
                                <td>
                                    <strong>Reunión Proyecto Feria de Salud</strong>
                                    <br><small class="text-muted">Planificación inicial y asignación de roles</small>
                                </td>
                                <td><span class="badge bg-success">Proyecto</span></td>
                                <td>1h 30min</td>
                                <td><span class="badge bg-success">Asistió</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary">Ver Acta</button>
                                </td>
                            </tr>
                            <tr>
                                <td>08 Sep 2025</td>
                                <td>
                                    <strong>Reunión General Agosto</strong>
                                    <br><small class="text-muted">Revisión mensual y nuevos proyectos</small>
                                </td>
                                <td><span class="badge bg-primary">General</span></td>
                                <td>2h 00min</td>
                                <td><span class="badge bg-success">Asistió</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary">Ver Acta</button>
                                </td>
                            </tr>
                            <tr>
                                <td>02 Sep 2025</td>
                                <td>
                                    <strong>Capacitación en Gestión de Proyectos</strong>
                                    <br><small class="text-muted">Metodologías y herramientas de gestión</small>
                                </td>
                                <td><span class="badge bg-info">Capacitación</span></td>
                                <td>3h 00min</td>
                                <td><span class="badge bg-success">Asistió</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary">Ver Material</button>
                                </td>
                            </tr>
                            <tr>
                                <td>28 Ago 2025</td>
                                <td>
                                    <strong>Reunión Campaña de Reciclaje</strong>
                                    <br><small class="text-muted">Evaluación resultados segunda etapa</small>
                                </td>
                                <td><span class="badge bg-success">Proyecto</span></td>
                                <td>1h 15min</td>
                                <td><span class="badge bg-warning">Justificó</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary">Ver Acta</button>
                                </td>
                            </tr>
                            <tr>
                                <td>25 Ago 2025</td>
                                <td>
                                    <strong>Reunión General Julio</strong>
                                    <br><small class="text-muted">Cierre de actividades del mes</small>
                                </td>
                                <td><span class="badge bg-primary">General</span></td>
                                <td>1h 45min</td>
                                <td><span class="badge bg-success">Asistió</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary">Ver Acta</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <nav aria-label="Navegación de reuniones">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Anterior</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas de asistencia mensual -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar text-info"></i>
                    Mi Estadística de Asistencia
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Asistencia por Mes (2025)</h6>
                        <div class="mb-2">
                            <label>Septiembre: 3/3 reuniones</label>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: 100%">100%</div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label>Agosto: 4/5 reuniones</label>
                            <div class="progress">
                                <div class="progress-bar bg-warning" style="width: 80%">80%</div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label>Julio: 5/5 reuniones</label>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: 100%">100%</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Asistencia por Tipo de Reunión</h6>
                        <div class="mb-2">
                            <label>Reuniones Generales: 95%</label>
                            <div class="progress">
                                <div class="progress-bar bg-primary" style="width: 95%">95%</div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label>Reuniones de Proyecto: 90%</label>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: 90%">90%</div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label>Capacitaciones: 100%</label>
                            <div class="progress">
                                <div class="progress-bar bg-info" style="width: 100%">100%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection