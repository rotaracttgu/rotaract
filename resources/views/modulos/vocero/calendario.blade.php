<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vocero - Calendario de Eventos</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --sidebar-bg: #1e293b;
            --sidebar-text: #e2e8f0;
        }

        body {
            background-color: #f8fafc;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .sidebar {
            background: var(--sidebar-bg);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link {
            color: var(--sidebar-text);
            border-radius: 8px;
            margin: 4px 0;
            padding: 12px 16px;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(59, 130, 246, 0.1);
            color: #60a5fa;
        }

        .content-wrapper {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
            padding: 24px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        #calendar {
            background-color: #fff;
            border-radius: 12px;
            padding: 20px;
        }

        .fc-toolbar-title {
            color: var(--primary-color) !important;
            font-weight: 600;
        }

        .fc-button-primary {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        .fc-event {
            white-space: normal !important;
            overflow: visible !important;
            text-overflow: initial !important;
            height: auto !important;
            min-height: 30px !important;
            padding: 3px 5px !important;
            font-size: 10px !important;
            line-height: 1.1 !important;
            border-radius: 4px !important;
            margin: 1px 0 !important;
        }

        .fc-event-main {
            white-space: normal !important;
            overflow: visible !important;
            padding: 1px 2px !important;
        }

        .fc-event-title {
            white-space: normal !important;
            overflow: visible !important;
            text-overflow: initial !important;
            word-wrap: break-word !important;
            line-height: 1.1 !important;
            font-weight: 500 !important;
            font-size: 10px !important;
        }

        .fc-event-title a {
            color: white !important;
            text-decoration: underline !important;
            font-size: 9px !important;
            transition: all 0.2s ease;
        }

        .fc-event-title a:hover {
            color: #ffff99 !important;
            text-decoration: none !important;
            background: rgba(255, 255, 255, 0.1);
            padding: 1px 3px;
            border-radius: 3px;
        }

        .fc-event-time {
            display: block !important;
            font-size: 9px !important;
            font-weight: normal !important;
            white-space: nowrap !important;
            opacity: 0.9;
        }

        .fc-daygrid-day-frame {
            min-height: 90px !important;
        }

        .fc-daygrid-event {
            margin: 1px 0 !important;
            white-space: normal !important;
        }

        .fc-daygrid-event-harness {
            position: relative !important;
        }

        .fc-timegrid-event {
            white-space: normal !important;
        }

        .event-fields {
            margin-top: 15px;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 4px solid #4CAF50;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }

        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-3 sidebar">
                <div class="p-4">
                    <div class="d-flex align-items-center mb-4">
                        <i class="fas fa-calendar-alt text-primary me-2 fs-3"></i>
                        <h4 class="text-white mb-0">Vocero</h4>
                    </div>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->routeIs('vocero.index') ? 'active' : '' }}" href="{{ route('vocero.index') }}">
                            <i class="fas fa-chart-line me-2"></i>
                            Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('vocero.calendario') ? 'active' : '' }}" href="{{ route('vocero.calendario') }}">
                            <i class="fas fa-calendar me-2"></i>
                            Calendario
                        </a>
                        <a class="nav-link {{ request()->routeIs('vocero.eventos') ? 'active' : '' }}" href="{{ route('vocero.eventos') }}">
                            <i class="fas fa-calendar-plus me-2"></i>
                            Gestión de Eventos
                        </a>
                        <a class="nav-link {{ request()->routeIs('vocero.asistencias') ? 'active' : '' }}" href="{{ route('vocero.asistencias') }}">
                            <i class="fas fa-users me-2"></i>
                            Asistencias
                        </a>
                        <a class="nav-link {{ request()->routeIs('vocero.reportes') ? 'active' : '' }}" href="{{ route('vocero.reportes') }}">
                            <i class="fas fa-chart-bar me-2"></i>
                            Reportes
                        </a>
                    </nav>
                </div>
            </div>

            <div class="col-lg-10 col-md-9">
                <div class="content-wrapper">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="mb-1">Calendario de Eventos</h2>
                            <p class="text-muted mb-0">Vista mensual de todos los eventos programados</p>
                        </div>
                        <button class="btn btn-primary" onclick="showCreateEventModal()">
                            <i class="fas fa-plus me-2"></i>Nuevo Evento
                        </button>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal (sin cambios) -->
    <div class="modal fade" id="eventoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Agregar Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="eventoForm">
                    <div class="modal-body">
                        <input type="hidden" id="eventoId">

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="titulo" class="form-label">Título del Evento *</label>
                                <input type="text" class="form-control" id="titulo" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="organizador" class="form-label">Organizador/Encargado *</label>
                                <input type="text" class="form-control" id="organizador" required placeholder="Nombre del organizador">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tipoEvento" class="form-label">Tipo de Evento *</label>
                                <select class="form-select" id="tipoEvento" required>
                                    <option value="">Selecciona un tipo</option>
                                    <option value="reunion-virtual">Reunión Virtual</option>
                                    <option value="reunion-presencial">Reunión Presencial</option>
                                    <option value="inicio-proyecto">Inicio de Proyecto</option>
                                    <option value="finalizar-proyecto">Finalizar Proyecto</option>
                                    <option value="cumpleanos">Cumpleaños</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado">
                                    <option value="programado">Programado</option>
                                    <option value="en_curso">En Curso</option>
                                    <option value="finalizado">Finalizado</option>
                                    <option value="cancelado">Cancelado</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_inicio" class="form-label">Fecha de Inicio *</label>
                                <input type="datetime-local" class="form-control" id="fecha_inicio" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_fin" class="form-label">Fecha de Fin *</label>
                                <input type="datetime-local" class="form-control" id="fecha_fin" required>
                            </div>
                        </div>

                        <div id="virtualFields" class="event-fields" style="display: none;">
                            <label for="enlace" class="form-label">Enlace de la Reunión:</label>
                            <input type="url" class="form-control" id="enlace" placeholder="https://...">
                        </div>

                        <div id="presencialFields" class="event-fields" style="display: none;">
                            <label for="lugar" class="form-label">Lugar de la Reunión:</label>
                            <input type="text" class="form-control" id="lugar" placeholder="Dirección o nombre del lugar">
                        </div>

                        <div id="proyectoFields" class="event-fields" style="display: none;">
                            <label for="ubicacion_proyecto" class="form-label">Ubicación del Proyecto:</label>
                            <input type="text" class="form-control" id="ubicacion_proyecto" placeholder="Ubicación o descripción del proyecto">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="eliminarBtn" style="display: none;">
                            <i class="fas fa-trash me-2"></i>Eliminar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Guardar Evento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts (sin cambios en la lógica) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/locales/es.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.all.min.js"></script>

    <script>
        // Todo el JavaScript permanece igual, solo se cambiaron las rutas en el HTML
        function getEventosFromStorage() {
            const eventos = localStorage.getItem('eventos');
            return eventos ? JSON.parse(eventos) : [];
        }

        function saveEventosToStorage(eventos) {
            localStorage.setItem('eventos', JSON.stringify(eventos));
            window.dispatchEvent(new Event('eventosUpdated'));
        }

        let calendar;
        let selectedDatesInfo = null;
        let eventModal;

        const colores = {
            'reunion-virtual': '#3498db',
            'reunion-presencial': '#e74c3c',
            'inicio-proyecto': '#2ecc71',
            'finalizar-proyecto': '#f1c40f',
            'cumpleanos': '#ff2d92'
        };

        $(document).ready(function() {
            initializeCalendar();
            setupEventHandlers();
            eventModal = new bootstrap.Modal(document.getElementById('eventoModal'));
        });

        function initializeCalendar() {
            const calendarEl = document.getElementById('calendar');
            
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                firstDay: 0,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día'
                },
                dayHeaderFormat: { weekday: 'long' },
                editable: true,
                selectable: true,
                selectHelper: true,
                height: 'auto',
                
                events: function(info, successCallback, failureCallback) {
                    const eventos = getEventosFromStorage();
                    successCallback(eventos);
                },
                
                datesSet: function(info) {
                    const currentDate = info.view.currentStart;
                    const month = currentDate.getMonth();
                    const year = currentDate.getFullYear();
                    
                    localStorage.setItem('calendar_current_month', month);
                    localStorage.setItem('calendar_current_year', year);
                },
                
                eventDidMount: function(info) {
                    const startHour = info.event.start.toLocaleTimeString('es-ES', { 
                        hour: '2-digit', 
                        minute: '2-digit' 
                    });
                    const endHour = info.event.end ? 
                        info.event.end.toLocaleTimeString('es-ES', { 
                            hour: '2-digit', 
                            minute: '2-digit' 
                        }) : '';
                    
                    const detalles = info.event.extendedProps.detalles;
                    let location = '';
                    let displayText = info.event.title;
                    
                    if (endHour) {
                        displayText += `<br><small>${startHour} - ${endHour}</small>`;
                    } else {
                        displayText += `<br><small>${startHour}</small>`;
                    }
                    
                    if (detalles) {
                        if (detalles.enlace) {
                            location = `${detalles.enlace}`;
                            displayText += `<br><a href="${detalles.enlace}" target="_blank" rel="noopener" style="color: white; text-decoration: underline; font-size: 9px;" onclick="event.stopPropagation();">🔗 Unirse</a>`;
                        } else if (detalles.lugar) {
                            location = `Lugar: ${detalles.lugar}`;
                            displayText += `<br><small>📍 ${detalles.lugar}</small>`;
                        } else if (detalles.ubicacion_proyecto) {
                            location = `Ubicación: ${detalles.ubicacion_proyecto}`;
                            displayText += `<br><small>📍 ${detalles.ubicacion_proyecto}</small>`;
                        }
                    }

                    const titleElement = info.el.querySelector('.fc-event-title');
                    if (titleElement) {
                        titleElement.innerHTML = displayText;
                    }

                    const tooltipContent = `${info.event.title}\n${startHour}${endHour ? ' - ' + endHour : ''}\n${location}`;
                    $(info.el).attr('title', tooltipContent);
                    $(info.el).tooltip();
                },

                select: function(info) {
                    showCreateEventModal(info);
                },

                eventClick: function(info) {
                    editEvent(info);
                },

                eventDrop: function(info) {
                    updateEventDates(info);
                },

                eventResize: function(info) {
                    updateEventDates(info);
                }
            });
            
            calendar.render();
        }

        function setupEventHandlers() {
            $('#tipoEvento').change(function() {
                const selectedType = $(this).val();
                
                $('#virtualFields, #presencialFields, #proyectoFields').hide();
                
                if (selectedType === 'reunion-virtual') {
                    $('#virtualFields').show();
                } else if (selectedType === 'reunion-presencial') {
                    $('#presencialFields').show();
                } else if (selectedType === 'inicio-proyecto' || selectedType === 'finalizar-proyecto') {
                    $('#proyectoFields').show();
                }
            });

            $('#eventoForm').submit(function(e) {
                e.preventDefault();
                saveEvent();
            });

            $('#eliminarBtn').click(function() {
                deleteEvent();
            });
        }

        function showCreateEventModal(info = null) {
            $('#modal-title').text('Agregar Evento');
            $('#eventoForm')[0].reset();
            $('#eventoId').val('');
            $('#eliminarBtn').hide();
            $('#virtualFields, #presencialFields, #proyectoFields').hide();
            
            $('#estado').val('programado');
            
            if (info) {
                selectedDatesInfo = info;
                $('#fecha_inicio').val(info.startStr.slice(0, 16));
                if (info.endStr) {
                    $('#fecha_fin').val(info.endStr.slice(0, 16));
                }
            }
            
            eventModal.show();
        }

        function editEvent(info) {
            $('#modal-title').text('Editar Evento');
            $('#eventoForm')[0].reset();
            $('#eliminarBtn').show();
            
            $('#eventoId').val(info.event.id);
            $('#titulo').val(info.event.title);
            $('#fecha_inicio').val(new Date(info.event.start).toISOString().slice(0, 16));
            
            if (info.event.end) {
                $('#fecha_fin').val(new Date(info.event.end).toISOString().slice(0, 16));
            }

            const props = info.event.extendedProps;
            
            if (props) {
                $('#tipoEvento').val(props.tipo_evento || '');
                $('#estado').val(props.estado || 'programado');
                $('#organizador').val(props.organizador || '');
            }
            
            $('#tipoEvento').trigger('change');
            
            const detalles = info.event.extendedProps.detalles;
            if (detalles) {
                $('#enlace').val(detalles.enlace || '');
                $('#lugar').val(detalles.lugar || '');
                $('#ubicacion_proyecto').val(detalles.ubicacion_proyecto || '');
            }
            
            eventModal.show();
        }

        function saveEvent() {
            if (!$('#titulo').val().trim() || !$('#organizador').val().trim()) {
                showToast('Todos los campos obligatorios son requeridos', 'error');
                return;
            }
            
            if (!$('#fecha_inicio').val() || !$('#fecha_fin').val()) {
                showToast('Las fechas son obligatorias', 'error');
                return;
            }
            
            if (new Date($('#fecha_inicio').val()) >= new Date($('#fecha_fin').val())) {
                showToast('La fecha de fin debe ser posterior a la de inicio', 'error');
                return;
            }
            
            const id = $('#eventoId').val();
            const isEdit = Boolean(id);
            
            const titulo = $('#titulo').val().trim();
            const organizador = $('#organizador').val().trim();
            const tipo = $('#tipoEvento').val();
            const estado = $('#estado').val();
            
            let detalles = { organizador: organizador };
            if (tipo === 'reunion-virtual') {
                detalles.enlace = $('#enlace').val();
            } else if (tipo === 'reunion-presencial') {
                detalles.lugar = $('#lugar').val();
            } else if (tipo === 'inicio-proyecto' || tipo === 'finalizar-proyecto') {
                detalles.ubicacion_proyecto = $('#ubicacion_proyecto').val();
            }

            const eventos = getEventosFromStorage();
            
            if (isEdit) {
                const index = eventos.findIndex(e => e.id == id);
                if (index !== -1) {
                    eventos[index] = {
                        ...eventos[index],
                        id: id,
                        title: titulo,
                        titulo: titulo,
                        start: $('#fecha_inicio').val(),
                        end: $('#fecha_fin').val(),
                        fecha_inicio: $('#fecha_inicio').val(),
                        fecha_fin: $('#fecha_fin').val(),
                        backgroundColor: colores[tipo],
                        borderColor: colores[tipo],
                        extendedProps: {
                            tipo_evento: tipo,
                            category: tipo,
                            estado: estado,
                            status: estado,
                            event_status: estado,
                            organizador: organizador,
                            organizer: organizador,
                            detalles: detalles
                        }
                    };
                }
            } else {
                const newId = Date.now().toString();
                eventos.push({
                    id: newId,
                    title: titulo,
                    titulo: titulo,
                    start: $('#fecha_inicio').val(),
                    end: $('#fecha_fin').val(),
                    fecha_inicio: $('#fecha_inicio').val(),
                    fecha_fin: $('#fecha_fin').val(),
                    backgroundColor: colores[tipo],
                    borderColor: colores[tipo],
                    extendedProps: {
                        tipo_evento: tipo,
                        category: tipo,
                        estado: estado,
                        status: estado,
                        event_status: estado,
                        organizador: organizador,
                        organizer: organizador,
                        detalles: detalles
                    }
                });
            }
            
            saveEventosToStorage(eventos);
            calendar.refetchEvents();
            eventModal.hide();
            
            showToast(isEdit ? 'Evento actualizado' : 'Evento creado', 'success');
        }

        function deleteEvent() {
            const id = $('#eventoId').val();
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    let eventos = getEventosFromStorage();
                    eventos = eventos.filter(e => e.id != id);
                    saveEventosToStorage(eventos);
                    
                    calendar.refetchEvents();
                    eventModal.hide();
                    showToast('Evento eliminado', 'success');
                }
            });
        }

        function updateEventDates(info) {
            const eventos = getEventosFromStorage();
            const index = eventos.findIndex(e => e.id == info.event.id);
            
            if (index !== -1) {
                eventos[index].start = info.event.start.toISOString();
                eventos[index].end = info.event.end ? info.event.end.toISOString() : null;
                eventos[index].fecha_inicio = info.event.start.toISOString();
                eventos[index].fecha_fin = info.event.end ? info.event.end.toISOString() : null;
                
                saveEventosToStorage(eventos);
                showToast('Evento actualizado', 'success');
            }
        }

        function showToast(message, type = 'info') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            
            Toast.fire({
                icon: type,
                title: message
            });
        }
    </script>
</body>
</html>