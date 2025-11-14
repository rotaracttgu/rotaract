@extends('modulos.aspirante.layou')

@section('title', 'Mis Proyectos')
@section('page-title', 'Mis Proyectos')
@section('proyectos-active', 'active')

@section('content')
<!-- Resumen de proyectos -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h3>3</h3>
                <p class="mb-0">Proyectos Activos</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h3>1</h3>
                <p class="mb-0">En Planificación</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body text-center">
                <h3>2</h3>
                <p class="mb-0">Completados</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-secondary">
            <div class="card-body text-center">
                <h3>6</h3>
                <p class="mb-0">Total</p>
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
                    <div class="col-md-4">
                        <label for="filtroEstado" class="form-label">Estado del proyecto:</label>
                        <select class="form-select" id="filtroEstado">
                            <option value="">Todos los estados</option>
                            <option value="activo">Activos</option>
                            <option value="planificacion">En Planificación</option>
                            <option value="completado">Completados</option>
                            <option value="cancelado">Cancelados</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="filtroCategoria" class="form-label">Categoría:</label>
                        <select class="form-select" id="filtroCategoria">
                            <option value="">Todas las categorías</option>
                            <option value="educacion">Educación</option>
                            <option value="medio-ambiente">Medio Ambiente</option>
                            <option value="salud">Salud</option>
                            <option value="comunidad">Desarrollo Comunitario</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
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

<!-- Lista de proyectos -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-project-diagram text-primary"></i>
                    Proyectos Asignados
                </h5>
            </div>
            <div class="card-body">
                <!-- Proyecto 1 -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h5 class="card-title">
                                        Campaña de Reciclaje Escolar
                                        <span class="badge bg-success ms-2">En Progreso</span>
                                    </h5>
                                    <small class="text-muted">Medio Ambiente</small>
                                </div>
                                <p class="card-text">
                                    Proyecto educativo para promover el reciclaje y la conciencia ambiental en escuelas primarias del distrito central.
                                </p>
                                <div class="mb-3">
                                    <label class="form-label">Progreso del proyecto:</label>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" style="width: 75%">75%</div>
                                    </div>
                                </div>
                                <p class="mb-1">
                                    <i class="fas fa-user text-muted"></i>
                                    <strong>Coordinador:</strong> María González
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-calendar text-muted"></i>
                                    <strong>Fecha inicio:</strong> 1 de Agosto, 2025
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-calendar-check text-muted"></i>
                                    <strong>Fecha estimada fin:</strong> 30 de Noviembre, 2025
                                </p>
                            </div>
                            <div class="col-md-4">
                                <h6>Mi rol en el proyecto:</h6>
                                <span class="badge bg-primary">Colaborador</span>
                                <hr>
                                <h6>Próximas tareas:</h6>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check-circle text-success"></i> Preparar materiales educativos</li>
                                    <li><i class="fas fa-clock text-warning"></i> Coordinar visita a Escuela Central</li>
                                    <li><i class="fas fa-circle text-muted"></i> Evaluar resultados primera fase</li>
                                </ul>
                                <button class="btn btn-sm btn-outline-primary w-100 mt-2">
                                    Ver Detalles
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Proyecto 2 -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h5 class="card-title">
                                        Apoyo Educativo Comunitario
                                        <span class="badge bg-warning ms-2">Planificación</span>
                                    </h5>
                                    <small class="text-muted">Educación</small>
                                </div>
                                <p class="card-text">
                                    Programa de tutorías gratuitas para estudiantes de secundaria con dificultades académicas.
                                </p>
                                <div class="mb-3">
                                    <label class="form-label">Progreso del proyecto:</label>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" style="width: 25%">25%</div>
                                    </div>
                                </div>
                                <p class="mb-1">
                                    <i class="fas fa-user text-muted"></i>
                                    <strong>Coordinador:</strong> Carlos Mendoza
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-calendar text-muted"></i>
                                    <strong>Fecha inicio:</strong> 15 de Septiembre, 2025
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-calendar-check text-muted"></i>
                                    <strong>Fecha estimada fin:</strong> 15 de Diciembre, 2025
                                </p>
                            </div>
                            <div class="col-md-4">
                                <h6>Mi rol en el proyecto:</h6>
                                <span class="badge bg-info">Tutor de Matemáticas</span>
                                <hr>
                                <h6>Próximas tareas:</h6>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-clock text-warning"></i> Preparar plan de estudios</li>
                                    <li><i class="fas fa-circle text-muted"></i> Identificar estudiantes objetivo</li>
                                    <li><i class="fas fa-circle text-muted"></i> Coordinar horarios</li>
                                </ul>
                                <button class="btn btn-sm btn-outline-primary w-100 mt-2">
                                    Ver Detalles
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Proyecto 3 -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h5 class="card-title">
                                        Feria de Salud Comunitaria
                                        <span class="badge bg-primary ms-2">Iniciando</span>
                                    </h5>
                                    <small class="text-muted">Salud</small>
                                </div>
                                <p class="card-text">
                                    Jornada de salud gratuita con chequeos médicos básicos y educación en prevención.
                                </p>
                                <div class="mb-3">
                                    <label class="form-label">Progreso del proyecto:</label>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" style="width: 10%">10%</div>
                                    </div>
                                </div>
                                <p class="mb-1">
                                    <i class="fas fa-user text-muted"></i>
                                    <strong>Coordinador:</strong> Ana Ruiz
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-calendar text-muted"></i>
                                    <strong>Fecha inicio:</strong> 1 de Octubre, 2025
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-calendar-check text-muted"></i>
                                    <strong>Fecha estimada fin:</strong> 30 de Octubre, 2025
                                </p>
                            </div>
                            <div class="col-md-4">
                                <h6>Mi rol en el proyecto:</h6>
                                <span class="badge bg-secondary">Asistente de Logística</span>
                                <hr>
                                <h6>Próximas tareas:</h6>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-circle text-muted"></i> Contactar centros de salud</li>
                                    <li><i class="fas fa-circle text-muted"></i> Buscar lugar para evento</li>
                                    <li><i class="fas fa-circle text-muted"></i> Elaborar cronograma</li>
                                </ul>
                                <button class="btn btn-sm btn-outline-primary w-100 mt-2">
                                    Ver Detalles
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Proyectos completados recientes -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-check-circle text-success"></i>
                    Proyectos Completados Recientemente
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Jornada de Limpieza Parque Central</h6>
                            <small class="text-success">Completado - Julio 2025</small>
                        </div>
                        <p class="mb-1">Actividad de limpieza y embellecimiento del parque central de la ciudad.</p>
                        <small><strong>Mi rol:</strong> Coordinador de Voluntarios</small>
                    </div>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Donación de Útiles Escolares</h6>
                            <small class="text-success">Completado - Junio 2025</small>
                        </div>
                        <p class="mb-1">Recolección y entrega de útiles escolares a estudiantes de bajos recursos.</p>
                        <small><strong>Mi rol:</strong> Colaborador en Recolección</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection