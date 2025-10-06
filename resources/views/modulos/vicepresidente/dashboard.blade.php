@extends('layouts.app')

@section('title', 'Dashboard - Vicepresidente')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0">Panel de Vicepresidente</h2>
            <p class="text-muted">Resumen general de actividades</p>
        </div>
    </div>

    <!-- Tarjetas de Resumen -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Cartas Enviadas (Este Mes)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">15</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Respuestas Recibidas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Proyectos Activos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">12</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-project-diagram fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Reuniones Próximas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- Proyectos que Requieren Seguimiento -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Proyectos que Requieren Seguimiento</h6>
                    <a href="/vicepresidente/estado-proyectos" class="btn btn-sm btn-primary">Ver Todos</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Proyecto</th>
                                    <th>Responsable</th>
                                    <th>Estado</th>
                                    <th>Última Actualización</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Sistema de Gestión Interna</strong></td>
                                    <td>Juan Pérez</td>
                                    <td><span class="badge bg-warning text-dark">En Progreso</span></td>
                                    <td>02/10/2025</td>
                                </tr>
                                <tr>
                                    <td><strong>Campaña de Membresía</strong></td>
                                    <td>María González</td>
                                    <td><span class="badge bg-danger">Retrasado</span></td>
                                    <td>28/09/2025</td>
                                </tr>
                                <tr>
                                    <td><strong>Renovación de Infraestructura</strong></td>
                                    <td>Carlos Méndez</td>
                                    <td><span class="badge bg-warning text-dark">En Progreso</span></td>
                                    <td>04/10/2025</td>
                                </tr>
                                <tr>
                                    <td><strong>Evento Anual de Rotarios</strong></td>
                                    <td>Ana Martínez</td>
                                    <td><span class="badge bg-info text-dark">Planificación</span></td>
                                    <td>05/10/2025</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Próximas Reuniones Importantes -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Próximas Reuniones</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 border-0">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">Reunión de Junta Directiva</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i> 08/10/2025 - 10:00 AM
                                    </small>
                                </div>
                            </div>
                            <span class="badge bg-danger">Alta Prioridad</span>
                        </div>

                        <div class="list-group-item px-0 border-top">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">Comité de Proyectos</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i> 10/10/2025 - 02:00 PM
                                    </small>
                                </div>
                            </div>
                            <span class="badge bg-warning text-dark">Media Prioridad</span>
                        </div>

                        <div class="list-group-item px-0 border-top">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">Reunión con Patrocinadores</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i> 12/10/2025 - 04:00 PM
                                    </small>
                                </div>
                            </div>
                            <span class="badge bg-info text-dark">Normal</span>
                        </div>

                        <div class="list-group-item px-0 border-top">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">Revisión de Membresía</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i> 15/10/2025 - 09:00 AM
                                    </small>
                                </div>
                            </div>
                            <span class="badge bg-success">Baja Prioridad</span>
                        </div>

                        <div class="list-group-item px-0 border-top">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">Seguimiento Anual</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i> 18/10/2025 - 11:00 AM
                                    </small>
                                </div>
                            </div>
                            <span class="badge bg-secondary">Informativa</span>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <a href="/vicepresidente/asistencia-reuniones" class="btn btn-sm btn-outline-primary">
                            Ver Todas las Reuniones
                        </a>
                    </div>
                </div>
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
@endsection
