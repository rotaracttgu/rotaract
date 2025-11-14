@extends('modulos.aspirante.layou')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Personal')
@section('dashboard-active', 'active')

@section('content')
<!-- Tarjetas de resumen -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">3</h4>
                        <p class="card-text">Proyectos Activos</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-project-diagram fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">5</h4>
                        <p class="card-text">Reuniones este mes</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">2</h4>
                        <p class="card-text">Mensajes pendientes</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-envelope fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">12</h4>
                        <p class="card-text">Notas personales</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-sticky-note fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Próximas reuniones y proyectos -->
<div class="row">
    <!-- Próximas reuniones -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-check text-primary"></i>
                    Próximas Reuniones
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Reunión General</h6>
                            <p class="mb-1 text-muted">15 de Septiembre, 2025</p>
                            <small>7:00 PM - Sede Central</small>
                        </div>
                        <span class="badge bg-primary rounded-pill">Mañana</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Proyecto Comunitario</h6>
                            <p class="mb-1 text-muted">20 de Septiembre, 2025</p>
                            <small>9:00 AM - Centro Comunitario</small>
                        </div>
                        <span class="badge bg-success rounded-pill">En 4 días</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Capacitación</h6>
                            <p class="mb-1 text-muted">25 de Septiembre, 2025</p>
                            <small>6:00 PM - Virtual</small>
                        </div>
                        <span class="badge bg-info rounded-pill">En 9 días</span>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="/aspirante/reuniones" class="btn btn-sm btn-outline-primary">
                        Ver todas las reuniones
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Proyectos activos -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tasks text-success"></i>
                    Mis Proyectos
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Campaña de Reciclaje</h6>
                            <small class="text-success">En progreso</small>
                        </div>
                        <p class="mb-1">Promoción del reciclaje en escuelas locales</p>
                        <div class="progress mb-2" style="height: 5px;">
                            <div class="progress-bar bg-success" style="width: 75%"></div>
                        </div>
                        <small>75% completado</small>
                    </div>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">Apoyo Educativo</h6>
                            <small class="text-warning">Planificando</small>
                        </div>
                        <p class="mb-1">Tutorías para estudiantes de secundaria</p>
                        <div class="progress mb-2" style="height: 5px;">
                            <div class="progress-bar bg-warning" style="width: 25%"></div>
                        </div>
                        <small>25% completado</small>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="/aspirante/proyectos" class="btn btn-sm btn-outline-success">
                        Ver todos los proyectos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notificaciones y acceso rápido -->
<div class="row">
    <!-- Notificaciones importantes -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bell text-warning"></i>
                    Notificaciones Importantes
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info d-flex align-items-center" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <div>
                        <strong>Nueva disposición:</strong> La reunión del viernes será en la sede norte.
                    </div>
                </div>
                <div class="alert alert-warning d-flex align-items-center" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <div>
                        <strong>Recordatorio:</strong> Entrega de reportes antes del 20 de septiembre.
                    </div>
                </div>
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>
                        <strong>Felicitaciones:</strong> Has completado el 75% de tus objetivos.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acceso rápido -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-rocket text-primary"></i>
                    Acceso Rápido
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="/aspirante/notas/crear" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i>
                        Nueva Nota
                    </a>
                    <a href="/aspirante/secretaria" class="btn btn-outline-info">
                        <i class="fas fa-envelope"></i>
                        Enviar Consulta
                    </a>
                    <a href="/aspirante/calendario" class="btn btn-outline-warning">
                        <i class="fas fa-calendar"></i>
                        Ver Calendario
                    </a>
                    <a href="/aspirante/perfil" class="btn btn-outline-secondary">
                        <i class="fas fa-user"></i>
                        Editar Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection