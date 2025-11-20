@extends('modulos.tesorero.layout')

@section('title', 'Configuración de Integraciones API')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1><i class="fas fa-plug text-info me-2"></i> Integraciones API y Webhooks</h1>
        </div>
    </div>

    <!-- Webhooks Configurados -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-server me-2"></i> Webhooks Activos</h5>
                <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modalNuevoWebhook">
                    <i class="fas fa-plus me-1"></i> Nuevo Webhook
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>URL</th>
                            <th>Evento</th>
                            <th>Estado</th>
                            <th>Último Envío</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Notificación de Ingreso</strong></td>
                            <td><code>https://api.ejemplo.com/ingresos</code></td>
                            <td><span class="badge bg-success">Ingreso Creado</span></td>
                            <td><span class="badge bg-success">Activo</span></td>
                            <td><small class="text-muted">Hace 2 horas</small></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-info" title="Probar">
                                    <i class="fas fa-flask"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Notificación de Gasto</strong></td>
                            <td><code>https://api.ejemplo.com/gastos</code></td>
                            <td><span class="badge bg-danger">Gasto Aprobado</span></td>
                            <td><span class="badge bg-success">Activo</span></td>
                            <td><small class="text-muted">Hace 30 minutos</small></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-info" title="Probar">
                                    <i class="fas fa-flask"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Claves API -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-key me-2"></i> Claves API</h5>
                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modalNuevaClaveAPI">
                            <i class="fas fa-plus me-1"></i> Nueva Clave
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1"><i class="fas fa-fingerprint me-2"></i> Clave de Producción</h6>
                                    <code style="font-size: 0.85rem;">sk_prod_1a2b3c4d5e6f7g8h9i0j</code>
                                    <small class="text-muted d-block mt-1">Creada hace 30 días</small>
                                </div>
                                <div>
                                    <span class="badge bg-success">Activa</span>
                                    <button class="btn btn-sm btn-outline-primary ms-2">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1"><i class="fas fa-fingerprint me-2"></i> Clave de Desarrollo</h6>
                                    <code style="font-size: 0.85rem;">sk_test_9z8y7x6w5v4u3t2s1r0q</code>
                                    <small class="text-muted d-block mt-1">Creada hace 15 días</small>
                                </div>
                                <div>
                                    <span class="badge bg-warning">Pruebas</span>
                                    <button class="btn btn-sm btn-outline-primary ms-2">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documentación -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-book me-2"></i> Documentación de API</h5>
                </div>
                <div class="card-body">
                    <h6 class="mb-3">Endpoints Disponibles:</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <code class="text-success">GET</code> <code>/api/ingresos</code>
                            <br><small class="text-muted">Listar todos los ingresos</small>
                        </li>
                        <li class="mb-2">
                            <code class="text-success">GET</code> <code>/api/gastos</code>
                            <br><small class="text-muted">Listar todos los gastos</small>
                        </li>
                        <li class="mb-2">
                            <code class="text-warning">POST</code> <code>/api/ingresos</code>
                            <br><small class="text-muted">Crear nuevo ingreso</small>
                        </li>
                        <li class="mb-2">
                            <code class="text-warning">POST</code> <code>/api/gastos</code>
                            <br><small class="text-muted">Crear nuevo gasto</small>
                        </li>
                        <li class="mb-2">
                            <code class="text-info">PATCH</code> <code>/api/gastos/{id}/aprobar</code>
                            <br><small class="text-muted">Aprobar gasto</small>
                        </li>
                    </ul>
                    <a href="#" class="btn btn-sm btn-outline-primary mt-3">
                        <i class="fas fa-external-link-alt me-1"></i> Ver Documentación Completa
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Eventos Disponibles -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0"><i class="fas fa-bell me-2"></i> Eventos Disponibles para Webhooks</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <h6 class="mb-2 text-success">Ingresos</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check me-2 text-success"></i> ingreso.creado</li>
                        <li><i class="fas fa-check me-2 text-success"></i> ingreso.actualizado</li>
                        <li><i class="fas fa-check me-2 text-success"></i> ingreso.eliminado</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="mb-2 text-danger">Gastos</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check me-2 text-success"></i> gasto.creado</li>
                        <li><i class="fas fa-check me-2 text-success"></i> gasto.aprobado</li>
                        <li><i class="fas fa-check me-2 text-success"></i> gasto.rechazado</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="mb-2 text-warning">Membresías</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check me-2 text-success"></i> membresia.pagada</li>
                        <li><i class="fas fa-check me-2 text-success"></i> membresia.vencida</li>
                        <li><i class="fas fa-check me-2 text-success"></i> membresia.proxima_vencer</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="mb-2 text-info">Presupuestos</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check me-2 text-success"></i> presupuesto.creado</li>
                        <li><i class="fas fa-check me-2 text-success"></i> presupuesto.superado</li>
                        <li><i class="fas fa-check me-2 text-success"></i> presupuesto.concluido</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Nuevo Webhook -->
<div class="modal fade" id="modalNuevoWebhook" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i> Nuevo Webhook</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="#" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" placeholder="Ej: Notificación de Ingreso" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL del Webhook</label>
                        <input type="url" class="form-control" placeholder="https://api.ejemplo.com/webhook" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Eventos a Disparar</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="evento1" checked>
                            <label class="form-check-label" for="evento1">ingreso.creado</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="evento2">
                            <label class="form-check-label" for="evento2">ingreso.actualizado</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="evento3">
                            <label class="form-check-label" for="evento3">gasto.creado</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Webhook</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Nueva Clave API -->
<div class="modal fade" id="modalNuevaClaveAPI" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-key me-2"></i> Nueva Clave API</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="#" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre de la Clave</label>
                        <input type="text" class="form-control" placeholder="Ej: Clave de Producción" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo</label>
                        <select class="form-select" required>
                            <option value="">Seleccionar tipo...</option>
                            <option value="prod">Producción</option>
                            <option value="test">Desarrollo/Pruebas</option>
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Guarda la clave en un lugar seguro. No podrás verla de nuevo.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear Clave</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
