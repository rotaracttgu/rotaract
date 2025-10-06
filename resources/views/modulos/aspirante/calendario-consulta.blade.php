@extends('modulos.aspirante.layou')

@section('title', 'Calendario')
@section('page-title', 'Calendario de Eventos - Solo Lectura')
@section('calendario-active', 'active')

@section('content')
<!-- Información importante -->
<div class="row mb-3">
    <div class="col-12">
        <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle"></i>
            <strong>Información:</strong> Esta es una vista de solo lectura. No puedes crear o modificar eventos.
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-filter text-primary"></i>
                    Filtros
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="filtroTipo" class="form-label">Tipo de evento:</label>
                        <select class="form-select" id="filtroTipo">
                            <option value="">Todos los eventos</option>
                            <option value="reunion">Reuniones</option>
                            <option value="proyecto">Proyectos</option>
                            <option value="capacitacion">Capacitaciones</option>
                            <option value="social">Eventos Sociales</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="filtroMes" class="form-label">Mes:</label>
                        <select class="form-select" id="filtroMes">
                            <option value="2025-09" selected>Septiembre 2025</option>
                            <option value="2025-10">Octubre 2025</option>
                            <option value="2025-11">Noviembre 2025</option>
                            <option value="2025-12">Diciembre 2025</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button class="btn btn-outline-secondary w-100">
                            <i class="fas fa-refresh"></i>
                            Limpiar Filtros
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leyenda de colores -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <small class="text-muted">Leyenda de colores:</small>
                <div class="mt-2">
                    <span class="badge bg-primary me-2">Reuniones</span>
                    <span class="badge bg-success me-2">Proyectos</span>
                    <span class="badge bg-info me-2">Capacitaciones</span>
                    <span class="badge bg-warning me-2">Eventos Sociales</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Calendario -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-alt text-primary"></i>
                    Septiembre 2025
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" style="table-layout: fixed;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 14.28%;">Domingo</th>
                                <th style="width: 14.28%;">Lunes</th>
                                <th style="width: 14.28%;">Martes</th>
                                <th style="width: 14.28%;">Miércoles</th>
                                <th style="width: 14.28%;">Jueves</th>
                                <th style="width: 14.28%;">Viernes</th>
                                <th style="width: 14.28%;">Sábado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="height: 120px;">
                                <td class="text-muted" style="vertical-align: top;">1</td>
                                <td style="vertical-align: top;">2</td>
                                <td style="vertical-align: top;">3</td>
                                <td style="vertical-align: top;">4</td>
                                <td style="vertical-align: top;">5</td>
                                <td style="vertical-align: top;">6</td>
                                <td style="vertical-align: top;">7</td>
                            </tr>
                            <tr style="height: 120px;">
                                <td style="vertical-align: top;">8</td>
                                <td style="vertical-align: top;">9</td>
                                <td style="vertical-align: top;">10</td>
                                <td style="vertical-align: top;">11</td>
                                <td style="vertical-align: top;">12</td>
                                <td style="vertical-align: top;">13</td>
                                <td style="vertical-align: top;">14</td>
                            </tr>
                            <tr style="height: 120px;">
                                <td style="vertical-align: top;">
                                    15
                                    <div class="mt-1">
                                        <small class="badge bg-primary d-block">Reunión General</small>
                                    </div>
                                </td>
                                <td style="vertical-align: top; background-color: #e3f2fd;">
                                    16
                                    <div class="text-center mt-1">
                                        <span class="badge bg-secondary">HOY</span>
                                    </div>
                                </td>
                                <td style="vertical-align: top;">17</td>
                                <td style="vertical-align: top;">18</td>
                                <td style="vertical-align: top;">19</td>
                                <td style="vertical-align: top;">
                                    20
                                    <div class="mt-1">
                                        <small class="badge bg-success d-block">Proyecto Reciclaje</small>
                                    </div>
                                </td>
                                <td style="vertical-align: top;">21</td>
                            </tr>
                            <tr style="height: 120px;">
                                <td style="vertical-align: top;">22</td>
                                <td style="vertical-align: top;">23</td>
                                <td style="vertical-align: top;">24</td>
                                <td style="vertical-align: top;">
                                    25
                                    <div class="mt-1">
                                        <small class="badge bg-info d-block">Capacitación</small>
                                    </div>
                                </td>
                                <td style="vertical-align: top;">26</td>
                                <td style="vertical-align: top;">27</td>
                                <td style="vertical-align: top;">
                                    28
                                    <div class="mt-1">
                                        <small class="badge bg-warning d-block">Cena Social</small>
                                    </div>
                                </td>
                            </tr>
                            <tr style="height: 120px;">
                                <td style="vertical-align: top;">29</td>
                                <td style="vertical-align: top;">30</td>
                                <td class="text-muted" style="vertical-align: top;">1</td>
                                <td class="text-muted" style="vertical-align: top;">2</td>
                                <td class="text-muted" style="vertical-align: top;">3</td>
                                <td class="text-muted" style="vertical-align: top;">4</td>
                                <td class="text-muted" style="vertical-align: top;">5</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lista de eventos próximos -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list text-success"></i>
                    Eventos Próximos
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">
                                <span class="badge bg-primary me-2">Reunión</span>
                                Reunión General Mensual
                            </h6>
                            <small>15 Sep 2025</small>
                        </div>
                        <p class="mb-1">Revisión de proyectos y planificación del próximo mes</p>
                        <small>
                            <i class="fas fa-clock text-muted"></i> 19:00 - 21:00 | 
                            <i class="fas fa-map-marker-alt text-muted"></i> Sede Central
                        </small>
                    </div>
                    
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">
                                <span class="badge bg-success me-2">Proyecto</span>
                                Campaña de Reciclaje
                            </h6>
                            <small>20 Sep 2025</small>
                        </div>
                        <p class="mb-1">Actividad educativa sobre reciclaje para estudiantes</p>
                        <small>
                            <i class="fas fa-clock text-muted"></i> 09:00 - 12:00 | 
                            <i class="fas fa-map-marker-alt text-muted"></i> Escuela José Cecilio del Valle
                        </small>
                    </div>
                    
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">
                                <span class="badge bg-info me-2">Capacitación</span>
                                Taller de Liderazgo
                            </h6>
                            <small>25 Sep 2025</small>
                        </div>
                        <p class="mb-1">Desarrollo de habilidades de liderazgo juvenil</p>
                        <small>
                            <i class="fas fa-clock text-muted"></i> 18:00 - 20:00 | 
                            <i class="fas fa-video text-muted"></i> Virtual - Zoom
                        </small>
                    </div>
                    
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">
                                <span class="badge bg-warning me-2">Social</span>
                                Cena de Hermandad
                            </h6>
                            <small>28 Sep 2025</small>
                        </div>
                        <p class="mb-1">Actividad de integración entre miembros</p>
                        <small>
                            <i class="fas fa-clock text-muted"></i> 19:30 - 22:00 | 
                            <i class="fas fa-map-marker-alt text-muted"></i> Restaurante El Portal
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection