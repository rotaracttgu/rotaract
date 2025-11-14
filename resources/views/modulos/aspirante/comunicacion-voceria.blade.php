@extends('modulos.aspirante.layou')

@section('title', 'Comunicación con Vocalía')
@section('page-title', 'Comunicación con Vocalía')
@section('voceria-active', 'active')

@section('content')
<!-- Información del departamento de vocalía -->
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-warning" role="alert">
            <i class="fas fa-bullhorn"></i>
            <strong>Departamento de Vocalía:</strong> Aquí puedes enviar solicitudes relacionadas con comunicación externa, eventos públicos, redes sociales y representación del club.
        </div>
    </div>
</div>

<div class="row">
    <!-- Panel de chat principal -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-bullhorn"></i>
                        Chat con Vocalía
                    </h5>
                    <div>
                        <span class="badge bg-success">Disponible</span>
                    </div>
                </div>
            </div>
            
            <!-- Área de mensajes -->
            <div class="card-body" style="height: 400px; overflow-y: auto;" id="chat-area-voceria">
                <!-- Mensaje del sistema -->
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0">
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-robot"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="bg-light p-3 rounded">
                            <strong>Sistema Vocalía</strong>
                            <p class="mb-1">Bienvenido al canal de comunicación con vocalía. Aquí puedes solicitar apoyo en comunicación, eventos y redes sociales.</p>
                            <small class="text-muted">Hoy, 8:00 AM</small>
                        </div>
                    </div>
                </div>

                <!-- Mensaje de vocalía -->
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0">
                        <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="bg-light p-3 rounded">
                            <strong>Ana - Vocalía</strong>
                            <p class="mb-1">Hola! Recibí tu solicitud para promocionar el proyecto de reciclaje. ¿Necesitas que creemos contenido para redes sociales?</p>
                            <small class="text-muted">Ayer, 2:30 PM</small>
                        </div>
                    </div>
                </div>

                <!-- Mensaje propio -->
                <div class="d-flex mb-3 justify-content-end">
                    <div class="flex-grow-1 me-3 text-end">
                        <div class="bg-warning text-dark p-3 rounded">
                            <p class="mb-1">Sí, exactamente. Necesitamos posts para Instagram y Facebook, y si es posible un flyer para imprimir.</p>
                            <small>Ayer, 3:00 PM</small>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>

                <!-- Mensaje de vocalía -->
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0">
                        <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="bg-light p-3 rounded">
                            <strong>Ana - Vocalía</strong>
                            <p class="mb-1">Perfecto! Te envío las propuestas mañana. ¿Tienes fotos del proyecto o necesitas que programemos una sesión fotográfica?</p>
                            <small class="text-muted">Ayer, 3:15 PM</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Área de escribir mensaje -->
            <div class="card-footer">
                <form id="form-mensaje-voceria">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Escribe tu mensaje aquí..." id="input-mensaje-voceria">
                        <button class="btn btn-warning" type="submit">
                            <i class="fas fa-paper-plane"></i>
                            Enviar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Panel lateral -->
    <div class="col-md-4">
        <!-- Nueva solicitud a vocalía -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-plus text-warning"></i>
                    Nueva Solicitud
                </h6>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="tipoSolicitud" class="form-label">Tipo de solicitud:</label>
                        <select class="form-select" id="tipoSolicitud">
                            <option value="">Seleccionar tipo</option>
                            <option value="redes-sociales">Contenido Redes Sociales</option>
                            <option value="evento-publico">Evento Público</option>
                            <option value="material-grafico">Material Gráfico</option>
                            <option value="comunicado">Comunicado de Prensa</option>
                            <option value="colaboracion">Colaboración Externa</option>
                            <option value="fotografia">Sesión Fotográfica</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="asuntoVoceria" class="form-label">Asunto:</label>
                        <input type="text" class="form-control" id="asuntoVoceria" placeholder="Título de tu solicitud">
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea class="form-control" id="descripcion" rows="4" placeholder="Describe detalladamente tu solicitud..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="fechaLimite" class="form-label">Fecha límite:</label>
                        <input type="date" class="form-control" id="fechaLimite">
                    </div>
                    <div class="mb-3">
                        <label for="prioridadVoceria" class="form-label">Urgencia:</label>
                        <select class="form-select" id="prioridadVoceria">
                            <option value="baja">Baja (1-2 semanas)</option>
                            <option value="media" selected>Media (3-7 días)</option>
                            <option value="alta">Alta (1-3 días)</option>
                            <option value="urgente">Urgente (24 horas)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">
                        <i class="fas fa-send"></i>
                        Enviar Solicitud
                    </button>
                </form>
            </div>
        </div>

        <!-- Servicios de vocalía -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-list-check text-info"></i>
                    Servicios Disponibles
                </h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex align-items-center">
                        <i class="fas fa-share-alt text-primary me-2"></i>
                        <span>Contenido para redes sociales</span>
                    </div>
                    <div class="list-group-item d-flex align-items-center">
                        <i class="fas fa-image text-success me-2"></i>
                        <span>Diseño gráfico y flyers</span>
                    </div>
                    <div class="list-group-item d-flex align-items-center">
                        <i class="fas fa-camera text-warning me-2"></i>
                        <span>Cobertura fotográfica</span>
                    </div>
                    <div class="list-group-item d-flex align-items-center">
                        <i class="fas fa-newspaper text-info me-2"></i>
                        <span>Comunicados de prensa</span>
                    </div>
                    <div class="list-group-item d-flex align-items-center">
                        <i class="fas fa-calendar-alt text-secondary me-2"></i>
                        <span>Promoción de eventos</span>
                    </div>
                    <div class="list-group-item d-flex align-items-center">
                        <i class="fas fa-handshake text-danger me-2"></i>
                        <span>Gestión de alianzas</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tips de comunicación -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-lightbulb text-warning"></i>
                    Tips de Comunicación
                </h6>
            </div>
            <div class="card-body">
                <div class="accordion" id="tipsAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tip1">
                                Redes Sociales Efectivas
                            </button>
                        </h2>
                        <div id="tip1" class="accordion-collapse collapse" data-bs-parent="#tipsAccordion">
                            <div class="accordion-body">
                                Usa hashtags relevantes, imágenes de calidad y publica en horarios de mayor actividad (7-9 PM).
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tip2">
                                Solicitudes Claras
                            </button>
                        </h2>
                        <div id="tip2" class="accordion-collapse collapse" data-bs-parent="#tipsAccordion">
                            <div class="accordion-body">
                                Proporciona detalles específicos: objetivos, audiencia objetivo, fechas y material disponible.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tip3">
                                Tiempo de Respuesta
                            </button>
                        </h2>
                        <div id="tip3" class="accordion-collapse collapse" data-bs-parent="#tipsAccordion">
                            <div class="accordion-body">
                                Solicita con anticipación: diseños (1 semana), eventos (2 semanas), campañas (3 semanas).
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mis solicitudes a vocalía -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tasks text-warning"></i>
                    Mis Solicitudes a Vocalía
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Solicitud</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>Fecha Límite</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>13 Sep 2025</td>
                                <td>
                                    <strong>Contenido para proyecto reciclaje</strong>
                                    <br><small class="text-muted">Posts Instagram y flyer impreso</small>
                                </td>
                                <td><span class="badge bg-primary">Redes Sociales</span></td>
                                <td><span class="badge bg-warning">En Proceso</span></td>
                                <td>20 Sep 2025</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-warning">Ver Chat</button>
                                </td>
                            </tr>
                            <tr>
                                <td>08 Sep 2025</td>
                                <td>
                                    <strong>Cobertura reunión general</strong>
                                    <br><small class="text-muted">Fotos para redes sociales</small>
                                </td>
                                <td><span class="badge bg-success">Fotografía</span></td>
                                <td><span class="badge bg-success">Completada</span></td>
                                <td>15 Sep 2025</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary">Ver Resultado</button>
                                </td>
                            </tr>
                            <tr>
                                <td>02 Sep 2025</td>
                                <td>
                                    <strong>Flyer feria de salud</strong>
                                    <br><small class="text-muted">Material promocional impreso</small>
                                </td>
                                <td><span class="badge bg-info">Material Gráfico</span></td>
                                <td><span class="badge bg-secondary">Pendiente</span></td>
                                <td>30 Sep 2025</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-warning">Ver Chat</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Galería de trabajos recientes -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-images text-info"></i>
                    Trabajos Recientes de Vocalía
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                <h6>Post Instagram - Reciclaje</h6>
                                <small class="text-muted">Publicado hace 2 días</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-file-image fa-3x text-muted mb-2"></i>
                                <h6>Flyer Reunión General</h6>
                                <small class="text-muted">Creado hace 1 semana</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-camera fa-3x text-muted mb-2"></i>
                                <h6>Cobertura Proyecto Educativo</h6>
                                <small class="text-muted">Realizada hace 2 semanas</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Simular envío de mensaje a vocalía
document.getElementById('form-mensaje-voceria').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const input = document.getElementById('input-mensaje-voceria');
    const mensaje = input.value.trim();
    
    if (mensaje) {
        const chatArea = document.getElementById('chat-area-voceria');
        const nuevoMensaje = `
            <div class="d-flex mb-3 justify-content-end">
                <div class="flex-grow-1 me-3 text-end">
                    <div class="bg-warning text-dark p-3 rounded">
                        <p class="mb-1">${mensaje}</p>
                        <small>Ahora</small>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>
        `;
        
        chatArea.innerHTML += nuevoMensaje;
        chatArea.scrollTop = chatArea.scrollHeight;
        
        input.value = '';
    }
});
</script>
@endsection