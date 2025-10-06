@extends('modulos.aspirante.layou')

@section('title', 'Mis Notas')
@section('page-title', 'Blog de Notas Personales')
@section('notas-active', 'active')

@section('content')
<!-- Barra de acciones -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="filtroCategoria" class="form-label">Categoría:</label>
                        <select class="form-select" id="filtroCategoria">
                            <option value="">Todas las categorías</option>
                            <option value="proyecto">Proyectos</option>
                            <option value="reunion">Reuniones</option>
                            <option value="capacitacion">Capacitaciones</option>
                            <option value="idea">Ideas</option>
                            <option value="personal">Personal</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="filtroVisibilidad" class="form-label">Visibilidad:</label>
                        <select class="form-select" id="filtroVisibilidad">
                            <option value="">Todas</option>
                            <option value="privada">Privadas</option>
                            <option value="publica">Públicas</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="busqueda" class="form-label">Buscar:</label>
                        <input type="text" class="form-control" id="busqueda" placeholder="Buscar en notas...">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <a href="/aspirante/notas/crear" class="btn btn-success btn-lg w-100">
                    <i class="fas fa-plus"></i>
                    Nueva Nota
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas de notas -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body text-center">
                <h3>24</h3>
                <p class="mb-0">Total Notas</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h3>18</h3>
                <p class="mb-0">Notas Privadas</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body text-center">
                <h3>6</h3>
                <p class="mb-0">Notas Públicas</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h3>5</h3>
                <p class="mb-0">Este Mes</p>
            </div>
        </div>
    </div>
</div>

<!-- Lista de notas -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-sticky-note text-warning"></i>
                        Mis Notas
                    </h5>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary btn-sm active">
                            <i class="fas fa-th-large"></i> Tarjetas
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-list"></i> Lista
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Vista de tarjetas -->
                <div class="row" id="vista-tarjetas">
                    <!-- Nota 1 -->
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="badge bg-success">Proyecto</span>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="/aspirante/notas/editar/1">Editar</a></li>
                                        <li><a class="dropdown-item" href="#">Duplicar</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#">Eliminar</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">Ideas para Campaña de Reciclaje</h6>
                                <p class="card-text">
                                    Lluvia de ideas para mejorar la campaña:
                                    - Concurso de diseño entre estudiantes
                                    - Premios para escuelas participantes
                                    - App móvil para seguimiento...
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar"></i> 14 Sep 2025
                                    </small>
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-lock"></i> Privada
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="btn-group w-100" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-sm">Ver</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm">Editar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nota 2 -->
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="badge bg-primary">Reunión</span>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="/aspirante/notas/editar/2">Editar</a></li>
                                        <li><a class="dropdown-item" href="#">Duplicar</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#">Eliminar</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">Notas Reunión General Sept</h6>
                                <p class="card-text">
                                    Puntos importantes de la reunión:
                                    - Aprobación presupuesto octubre
                                    - Nuevos aspirantes presentados
                                    - Fechas próximos eventos...
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar"></i> 12 Sep 2025
                                    </small>
                                    <span class="badge bg-info text-white">
                                        <i class="fas fa-eye"></i> Pública
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="btn-group w-100" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-sm">Ver</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm">Editar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nota 3 -->
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="badge bg-info">Capacitación</span>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="/aspirante/notas/editar/3">Editar</a></li>
                                        <li><a class="dropdown-item" href="#">Duplicar</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#">Eliminar</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">Apuntes Liderazgo Juvenil</h6>
                                <p class="card-text">
                                    Conceptos clave del taller:
                                    - Comunicación asertiva
                                    - Delegación efectiva
                                    - Resolución de conflictos...
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar"></i> 10 Sep 2025
                                    </small>
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-lock"></i> Privada
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="btn-group w-100" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-sm">Ver</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm">Editar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nota 4 -->
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="badge bg-warning">Ideas</span>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="/aspirante/notas/editar/4">Editar</a></li>
                                        <li><a class="dropdown-item" href="#">Duplicar</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#">Eliminar</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">Propuestas Nuevos Proyectos</h6>
                                <p class="card-text">
                                    Ideas para próximos proyectos:
                                    - Taller de emprendimiento juvenil
                                    - Programa de mentorías
                                    - Festival cultural comunitario...
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar"></i> 08 Sep 2025
                                    </small>
                                    <span class="badge bg-info text-white">
                                        <i class="fas fa-eye"></i> Pública
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="btn-group w-100" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-sm">Ver</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm">Editar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nota 5 -->
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="badge bg-secondary">Personal</span>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="/aspirante/notas/editar/5">Editar</a></li>
                                        <li><a class="dropdown-item" href="#">Duplicar</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#">Eliminar</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">Objetivos Personales</h6>
                                <p class="card-text">
                                    Metas para mi desarrollo en Rotaract:
                                    - Mejorar habilidades de presentación
                                    - Liderar un proyecto propio
                                    - Obtener certificación...
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar"></i> 05 Sep 2025
                                    </small>
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-lock"></i> Privada
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="btn-group w-100" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-sm">Ver</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm">Editar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nota 6 -->
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="badge bg-success">Proyecto</span>
                                <div class="dropdown">
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="/aspirante/notas/editar/6">Editar</a></li>
                                        <li><a class="dropdown-item" href="#">Duplicar</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#">Eliminar</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">Contactos Feria de Salud</h6>
                                <p class="card-text">
                                    Lista de contactos importantes:
                                    - Dr. Martínez (Cardiología)
                                    - Enfermera Ana (Centro de Salud)
                                    - Farmacia San José...
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar"></i> 03 Sep 2025
                                    </small>
                                    <span class="badge bg-info text-white">
                                        <i class="fas fa-eye"></i> Pública
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="btn-group w-100" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-sm">Ver</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm">Editar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paginación -->
                <nav aria-label="Navegación de notas">
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

<!-- Notas más populares -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-star text-warning"></i>
                    Notas Públicas Más Vistas por Otros Miembros
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Propuestas Nuevos Proyectos</h6>
                            <p class="mb-1">Ideas innovadoras para próximos proyectos del club</p>
                            <small>Por: Tu - hace 1 semana</small>
                        </div>
                        <div class="text-center">
                            <span class="badge bg-primary rounded-pill">24 vistas</span>
                            <br>
                            <small class="text-muted">3 comentarios</small>
                        </div>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Contactos Feria de Salud</h6>
                            <p class="mb-1">Lista de profesionales y contactos útiles</p>
                            <small>Por: Tu - hace 2 semanas</small>
                        </div>
                        <div class="text-center">
                            <span class="badge bg-primary rounded-pill">18 vistas</span>
                            <br>
                            <small class="text-muted">5 comentarios</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection