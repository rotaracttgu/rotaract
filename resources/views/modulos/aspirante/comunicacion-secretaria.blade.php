@extends('modulos.aspirante.layou')

@section('title', 'Comunicación con Secretaría')
@section('page-title', 'Comunicación con Secretaría')
@section('secretaria-active', 'active')

@section('content')
<!-- Información del sistema de mensajería -->
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle"></i>
            <strong>Sistema de Mensajería:</strong> Aquí puedes enviar consultas, dudas o solicitudes directamente a la secretaría. Recibirás respuesta por este mismo medio.
        </div>
    </div>
</div>

<div class="row">
    <!-- Panel de chat principal -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-comments"></i>
                        Chat con Secretaría
                    </h5>
                    <div>
                        <span class="badge bg-success">En línea</span>
                    </div>
                </div>
            </div>
            
            <!-- Área de mensajes -->
            <div class="card-body" style="height: 400px; overflow-y: auto;" id="chat-area">
                <!-- Mensaje del sistema -->
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0">
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-robot"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="bg-light p-3 rounded">
                            <strong>Sistema</strong>
                            <p class="mb-1">Bienvenido al sistema de comunicación con secretaría. Puedes enviar tus consultas aquí.</p>
                            <small class="text-muted">Hoy, 8:00 AM</small>
                        </div>
                    </div>
                </div>

                <!-- Mensaje de secretaría -->
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0">
                        <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="bg-light p-3 rounded">
                            <strong>María Secretaría</strong>
                            <p class="mb-1">Hola! Te recuerdo que mañana tenemos la reunión general. ¿Tienes alguna consulta sobre la agenda?</p>
                            <small class="text-muted">Ayer, 4:30 PM</small>
                        </div>
                    </div>
                </div>

                <!-- Mensaje propio -->
                <div class="d-flex mb-3 justify-content-end">
                    <div class="flex-grow-1 me-3 text-end">
                        <div class="bg-primary text-white p-3 rounded">
                            <p class="mb-1">Hola María, gracias por el recordatorio. ¿Podrías enviarme la agenda detallada de la reunión?</p>
                            <small class="text-light">Ayer, 5:15 PM</small>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>

                <!-- Mensaje de secretaría -->
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0">
                        <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="bg-light p-3 rounded">
                            <strong>María Secretaría</strong>
                            <p class="mb-1">Por supuesto, te envío la agenda:</p>
                            <ul class="mb-1">
                                <li>Revisión de proyectos activos</li>
                                <li>Presentación de nuevos aspirantes</li>
                                <li>Planificación octubre</li>
                                <li>Asuntos varios</li>
                            </ul>
                            <small class="text-muted">Ayer, 5:45 PM</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Área de escribir mensaje -->
            <div class="card-footer">
                <form id="form-mensaje">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Escribe tu mensaje aquí..." id="input-mensaje">
                        <button class="btn btn-primary" type="submit">
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
        <!-- Nueva consulta -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-plus text-success"></i>
                    Nueva Consulta
                </h6>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="tipoConsulta" class="form-label">Tipo de consulta:</label>
                        <select class="form-select" id="tipoConsulta">
                            <option value="">Seleccionar tipo</option>
                            <option value="general">Consulta General</option>
                            <option value="proyecto">Sobre Proyectos</option>
                            <option value="reunion">Sobre Reuniones</option>
                            <option value="documentos">Documentos</option>
                            <option value="otros">Otros</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="asunto" class="form-label">Asunto:</label>
                        <input type="text" class="form-control" id="asunto" placeholder="Título de tu consulta">
                    </div>
                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje:</label>
                        <textarea class="form-control" id="mensaje" rows="4" placeholder="Describe tu consulta detalladamente..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="prioridad" class="form-label">Prioridad:</label>
                        <select class="form-select" id="prioridad">
                            <option value="baja">Baja</option>
                            <option value="media" selected>Media</option>
                            <option value="alta">Alta</option>
                            <option value="urgente">Urgente</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-send"></i>
                        Enviar Consulta
                    </button>
                </form>
            </div>
        </div>

        <!-- Consultas frecuentes -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-question-circle text-info"></i>
                    Consultas Frecuentes
                </h6>
            </div>
            <div class="card-body">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                ¿Cómo justificar una inasistencia?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Debes enviar un mensaje con al menos 24 horas de anticipación explicando el motivo de tu inasistencia.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                ¿Dónde obtengo documentos oficiales?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Puedes solicitar documentos como constancias, certificados y actas a través de este sistema de mensajería.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                ¿Cuál es el horario de respuesta?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Las consultas se responden de lunes a viernes de 8:00 AM a 5:00 PM. Respuesta promedio: 2-4 horas.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estado de consultas -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-list text-warning"></i>
                    Mis Consultas Recientes
                </h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Agenda reunión</div>
                            <small>Solicitud de agenda detallada</small>
                        </div>
                        <span class="badge bg-success rounded-pill">Respondida</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Constancia participación</div>
                            <small>Documento para universidad</small>
                        </div>
                        <span class="badge bg-warning rounded-pill">Pendiente</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Cambio de horario</div>
                            <small>Consulta sobre flexibilidad</small>
                        </div>
                        <span class="badge bg-success rounded-pill">Respondida</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Historial de conversaciones -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history text-secondary"></i>
                    Historial de Conversaciones
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Asunto</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>Respuesta</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>14 Sep 2025</td>
                                <td>Solicitud agenda reunión general</td>
                                <td><span class="badge bg-primary">Reunión</span></td>
                                <td><span class="badge bg-success">Respondida</span></td>
                                <td>2 horas</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary">Ver Chat</button>
                                </td>
                            </tr>
                            <tr>
                                <td>10 Sep 2025</td>
                                <td>Constancia de participación</td>
                                <td><span class="badge bg-warning">Documentos</span></td>
                                <td><span class="badge bg-warning">Pendiente</span></td>
                                <td>-</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary">Ver Chat</button>
                                </td>
                            </tr>
                            <tr>
                                <td>05 Sep 2025</td>
                                <td>Consulta sobre proyecto reciclaje</td>
                                <td><span class="badge bg-success">Proyecto</span></td>
                                <td><span class="badge bg-success">Respondida</span></td>
                                <td>1 día</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary">Ver Chat</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Simular envío de mensaje
document.getElementById('form-mensaje').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const input = document.getElementById('input-mensaje');
    const mensaje = input.value.trim();
    
    if (mensaje) {
        // Agregar mensaje al chat
        const chatArea = document.getElementById('chat-area');
        const nuevoMensaje = `
            <div class="d-flex mb-3 justify-content-end">
                <div class="flex-grow-1 me-3 text-end">
                    <div class="bg-primary text-white p-3 rounded">
                        <p class="mb-1">${mensaje}</p>
                        <small class="text-light">Ahora</small>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
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