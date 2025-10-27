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
        /* Variables de colores */
        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --info-color: #06b6d4;
            --sidebar-bg: #1e293b;
            --sidebar-text: #e2e8f0;
        }

        /* Estilos base */
        body {
            background-color: #f8fafc;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            overflow: hidden;
        }
        
        /* AJUSTES CLAVE PARA LA VISTA SIN X-APP-LAYOUT */
        .sidebar-vocero {
            background: var(--sidebar-bg);
            width: 200px;
            position: fixed;
            left: 0;
            top: 0; 
            z-index: 20; 
            height: 100vh;
            padding-top: 64px;
            transition: all 0.3s ease;
        }

        .main-content-vocero {
            margin-left: 300px; 
            min-height: 100vh;
            flex-grow: 1;
            width: 900px;
            padding: 100;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            position: relative;
            overflow-y: auto;
        }

        .main-content-vocero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 300px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.05) 0%, transparent 100%);
            pointer-events: none;
            z-index: 0;
        }
        
        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            position: absolute; 
            top: 0;
            width: 100%;
            height: 64px; 
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 40; 
        }

        .sidebar-brand h4 {
            color: var(--sidebar-text);
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .sidebar-vocero .nav-link {
            color: var(--sidebar-text);
            border-radius: 8px;
            margin: 4px 16px;
            padding: 12px 16px;
            transition: all 0.2s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }

        .sidebar-vocero .nav-link:hover {
            background: rgba(59, 130, 246, 0.1);
            color: #60a5fa;
        }

        .sidebar-vocero .nav-link.active {
            background: var(--primary-color);
            color: white;
        }

        .content-wrapper {
            background: white;
            border-radius: 0;
            box-shadow: none;
            margin: 0;
            padding: 15px;
            height: 100vh;
            overflow: hidden;
        }

        .card {
            border: none;
            border-radius: 0;
            box-shadow: none;
            transition: transform 0.2s ease;
            height: calc(100vh - 100px);
        }

        .card-body {
            padding: 0 !important;
            height: 100%;
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
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 16px;
            padding: 24px;
            height: 100%;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            animation: fadeInUp 0.6s ease-out;
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .fc-toolbar-title {
            color: var(--primary-color) !important;
            font-weight: 700 !important;
            font-size: 1.75rem !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            animation: slideInRight 0.5s ease-out;
        }

        .fc-button-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1d4ed8 100%) !important;
            border-color: var(--primary-color) !important;
            border-radius: 8px !important;
            padding: 8px 16px !important;
            font-weight: 600 !important;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fc-button-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
        }

        .fc-button-primary:active {
            transform: translateY(0);
        }

        /* FullCalendar Custom Styles */
        .fc-event {
            white-space: normal !important;
            overflow: visible !important;
            text-overflow: initial !important;
            height: auto !important;
            min-height: 30px !important;
            padding: 6px 8px !important;
            font-size: 11px !important;
            line-height: 1.3 !important;
            border-radius: 8px !important;
            margin: 2px 0 !important;
            border: none !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            animation: eventFadeIn 0.4s ease-out;
            cursor: pointer;
        }

        @keyframes eventFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .fc-event:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            z-index: 10;
        }

        .fc-event-main {
            white-space: normal !important;
            overflow: visible !important;
            padding: 2px 4px !important;
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
            transition: all 0.3s ease;
            border-radius: 4px;
        }

        .fc-daygrid-day-frame:hover {
            background: rgba(37, 99, 235, 0.03);
            transform: scale(1.01);
        }

        .fc-daygrid-day-number {
            transition: all 0.3s ease;
            font-weight: 600 !important;
        }

        .fc-day-today .fc-daygrid-day-frame {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.08) 0%, rgba(37, 99, 235, 0.03) 100%);
            border: 2px solid rgba(37, 99, 235, 0.2) !important;
            animation: pulse 2s ease-in-out infinite;
        }

        .fc-day-today .fc-daygrid-day-number {
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700 !important;
        }

        .fc-daygrid-event {
            margin: 2px 0 !important;
            white-space: normal !important;
        }

        .fc-daygrid-event-harness {
            position: relative !important;
        }

        .fc-timegrid-event {
            white-space: normal !important;
        }

        /* Estilo para los encabezados de días de la semana */
        .fc-col-header-cell {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important;
            border: none !important;
            padding: 12px 8px !important;
            font-weight: 700 !important;
            color: #475569 !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .fc-scrollgrid {
            border: none !important;
            border-radius: 12px;
            overflow: hidden;
        }

        .fc-daygrid-day {
            transition: all 0.2s ease;
        }

        .fc-daygrid-day:hover {
            background: rgba(37, 99, 235, 0.02);
        }

        .event-fields {
            margin-top: 15px;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 4px solid #4CAF50;
            border-radius: 5px;
        }

        .fc .fc-button-primary:not(:disabled).fc-button-active, 
        .fc .fc-button-primary:not(:disabled):active {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e3a8a 100%) !important;
            border-color: #1d4ed8 !important;
            transform: scale(0.98);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background: var(--primary-color);
            color: white;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .header-section {
            padding: 15px 20px;
            background: white;
            border-bottom: 1px solid #e5e7eb;
        }

        /* Media Query para móviles */
        @media (max-width: 768px) {
            .sidebar-vocero { 
                position: relative; 
                width: 100%; 
                height: auto; 
                padding-top: 0; 
            }
            .main-content-vocero { 
                margin-left: 0; 
                padding-top: 0; 
                width: 100%; 
            }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        {{-- ⭐ 1. MENÚ LATERAL (SIDEBAR) ⭐ --}}
        <div class="sidebar-vocero">
            <div class="sidebar-brand">
                <h4><i class="fas fa-calendar-alt text-primary"></i> Vocero</h4>
            </div>
            
            <nav class="sidebar-nav">
                <a class="nav-link {{ request()->routeIs('vocero.dashboard') ? 'active' : '' }}" href="{{ route('vocero.dashboard') }}">
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

        {{-- ⭐ 2. CONTENIDO PRINCIPAL ⭐ --}}
        <div class="main-content-vocero">
            <div class="content-wrapper">
                <div class="header-section d-flex justify-content-between align-items-center">
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

    <!-- Modal para Crear/Editar Evento -->
    <div class="modal fade" id="eventoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Agregar Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="eventoForm">
                        <input type="hidden" id="eventoId">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Título del Evento *</label>
                                <input type="text" class="form-control" id="titulo" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipo de Evento *</label>
                                <select class="form-select" id="tipoEvento" required>
                                    <option value="">Seleccione...</option>
                                    <option value="reunion-virtual">Reunión Virtual</option>
                                    <option value="reunion-presencial">Reunión Presencial</option>
                                    <option value="inicio-proyecto">Inicio de Proyecto</option>
                                    <option value="finalizar-proyecto">Finalización de Proyecto</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha y Hora de Inicio *</label>
                                <input type="datetime-local" class="form-control" id="fecha_inicio" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha y Hora de Fin *</label>
                                <input type="datetime-local" class="form-control" id="fecha_fin" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Organizador *</label>
                                <select class="form-select" id="organizador_id" required>
                                    <option value="">Seleccione un organizador...</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Estado</label>
                                <select class="form-select" id="estado">
                                    <option value="programado">Programado</option>
                                    <option value="en-curso">En Curso</option>
                                    <option value="finalizado">Finalizado</option>
                                </select>
                            </div>
                        </div>

                        <!-- Campos Específicos según Tipo de Evento -->
                        <div id="virtualFields" class="event-fields" style="display: none;">
                            <label class="form-label">Enlace de Reunión Virtual</label>
                            <input type="url" class="form-control" id="enlace" placeholder="https://meet.google.com/...">
                        </div>

                        <div id="presencialFields" class="event-fields" style="display: none;">
                            <label class="form-label">Lugar de Reunión</label>
                            <input type="text" class="form-control" id="lugar" placeholder="Sala de conferencias, dirección, etc.">
                        </div>

                        <div id="proyectoFields" class="event-fields" style="display: none;">
                            <label class="form-label">Ubicación del Proyecto</label>
                            <input type="text" class="form-control" id="ubicacion_proyecto" placeholder="Ubicación del proyecto">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="eliminarBtn" style="display: none;">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="eventoForm" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.all.min.js"></script>

    <script>
        // ============================================================================
        // 🔄 CÓDIGO MODIFICADO - CONECTADO A BASE DE DATOS
        // ============================================================================
        
        let calendar;
        let eventModal;
        let selectedDatesInfo = null;

        const colores = {
            'reunion-virtual': '#3b82f6',
            'reunion-presencial': '#10b981',
            'inicio-proyecto': '#f59e0b',
            'finalizar-proyecto': '#ef4444'
        };

        $(document).ready(function() {
            initializeCalendar();
            initializeEventModal();
            cargarMiembros(); // 🆕 CARGAR MIEMBROS AL INICIO
        });

        function initializeCalendar() {
            const calendarEl = document.getElementById('calendar');
            
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
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
                editable: true,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true,
                height: '100%',
                
                // ✅ CAMBIO: Cargar eventos desde el servidor
                events: function(info, successCallback, failureCallback) {
                    $.ajax({
                        url: '/api/calendario/eventos',
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(eventos) {
                            successCallback(eventos);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al cargar eventos:', error);
                            showToast('Error al cargar eventos', 'error');
                            failureCallback(error);
                        }
                    });
                },
                
                select: function(info) {
                    showCreateEventModal(info);
                },
                
                eventClick: function(info) {
                    editEvent(info);
                },
                
                // ✅ CAMBIO: Actualizar fechas en el servidor al arrastrar
                eventDrop: function(info) {
                    updateEventDates(info);
                },
                
                // ✅ CAMBIO: Actualizar fechas en el servidor al redimensionar
                eventResize: function(info) {
                    updateEventDates(info);
                },
                
                eventContent: function(arg) {
                    const props = arg.event.extendedProps;
                    let enlaceHTML = '';
                    
                    if (props.detalles && props.detalles.enlace) {
                        enlaceHTML = `<a href="${props.detalles.enlace}" target="_blank" onclick="event.stopPropagation();" style="color: white; text-decoration: underline; font-size: 9px;">🔗 Unirse</a>`;
                    }
                    
                    return {
                        html: `
                            <div style="padding: 2px 4px; overflow: visible; white-space: normal;">
                                <div style="font-weight: 500; font-size: 10px; line-height: 1.2; word-wrap: break-word;">
                                    ${arg.event.title}
                                </div>
                                ${enlaceHTML}
                            </div>
                        `
                    };
                }
            });
            
            calendar.render();
        }

        function initializeEventModal() {
            eventModal = new bootstrap.Modal(document.getElementById('eventoModal'));
            
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

        // ============================================================================
        // 🆕 FUNCIÓN PARA CARGAR MIEMBROS
        // ============================================================================
        function cargarMiembros() {
            $.ajax({
                url: '/api/calendario/miembros',
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        const select = $('#organizador_id');
                        select.empty();
                        select.append('<option value="">Seleccione un organizador...</option>');
                        
                        response.miembros.forEach(function(miembro) {
                            // Mostrar: Nombre - Rol
                            const nombreCompleto = `${miembro.Nombre} - ${miembro.Rol}`;
                            select.append(`<option value="${miembro.MiembroID}">${nombreCompleto}</option>`);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar miembros:', error);
                    showToast('Error al cargar la lista de miembros', 'error');
                }
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
                $('#organizador_id').val(props.organizador_id || ''); // 🆕 USA EL SELECT
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

        // ============================================================================
        // ✅ FUNCIÓN MODIFICADA: Guardar evento en la base de datos
        // ============================================================================
        function saveEvent() {
            // Validaciones
            if (!$('#titulo').val().trim() || !$('#organizador_id').val()) { // 🆕 VALIDACIÓN ACTUALIZADA
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
            
            // 🆕 Preparar datos del evento CON ID DE ORGANIZADOR
            const tipo = $('#tipoEvento').val();
            const organizadorId = $('#organizador_id').val();
            const organizadorNombre = $('#organizador_id option:selected').text();

            let detalles = {
                organizador: organizadorNombre
            };
            
            if (tipo === 'reunion-virtual') {
                detalles.enlace = $('#enlace').val();
            } else if (tipo === 'reunion-presencial') {
                detalles.lugar = $('#lugar').val();
            } else if (tipo === 'inicio-proyecto' || tipo === 'finalizar-proyecto') {
                detalles.ubicacion_proyecto = $('#ubicacion_proyecto').val();
            }
            
            const eventData = {
                titulo: $('#titulo').val().trim(),
                descripcion: $('#titulo').val().trim(),
                tipo_evento: tipo,
                estado: $('#estado').val(),
                fecha_inicio: $('#fecha_inicio').val(),
                fecha_fin: $('#fecha_fin').val(),
                organizador_id: organizadorId ? parseInt(organizadorId) : null, // 🆕 ENVÍA EL ID
                proyecto_id: null,
                detalles: detalles
            };
            
            // Determinar URL y método
            const url = isEdit 
                ? `/api/calendario/eventos/${id}`
                : '/api/calendario/eventos';
            
            const method = isEdit ? 'PUT' : 'POST';
            
            // ✅ CAMBIO: Enviar al servidor en lugar de localStorage
            $.ajax({
                url: url,
                method: method,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify(eventData),
                success: function(response) {
                    if (response.success) {
                        calendar.refetchEvents();
                        eventModal.hide();
                        showToast(isEdit ? 'Evento actualizado exitosamente' : 'Evento creado exitosamente', 'success');
                    } else {
                        showToast(response.mensaje || 'Error al guardar el evento', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al guardar evento:', error);
                    const mensaje = xhr.responseJSON?.mensaje || 'Error al guardar el evento';
                    showToast(mensaje, 'error');
                }
            });
        }

        // ============================================================================
        // ✅ FUNCIÓN MODIFICADA: Eliminar evento de la base de datos
        // ============================================================================
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
                    // ✅ CAMBIO: Eliminar del servidor en lugar de localStorage
                    $.ajax({
                        url: `/api/calendario/eventos/${id}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                calendar.refetchEvents();
                                eventModal.hide();
                                showToast('Evento eliminado exitosamente', 'success');
                            } else {
                                showToast(response.mensaje || 'Error al eliminar el evento', 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al eliminar evento:', error);
                            const mensaje = xhr.responseJSON?.mensaje || 'Error al eliminar el evento';
                            showToast(mensaje, 'error');
                        }
                    });
                }
            });
        }

        // ============================================================================
        // ✅ FUNCIÓN MODIFICADA: Actualizar fechas en la base de datos
        // ============================================================================
        function updateEventDates(info) {
            const eventData = {
                fecha_inicio: info.event.start.toISOString(),
                fecha_fin: info.event.end ? info.event.end.toISOString() : info.event.start.toISOString()
            };
            
            // ✅ CAMBIO: Actualizar en el servidor en lugar de localStorage
            $.ajax({
                url: `/api/calendario/eventos/${info.event.id}/fechas`,
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify(eventData),
                success: function(response) {
                    if (response.success) {
                        showToast('Fechas actualizadas exitosamente', 'success');
                    } else {
                        showToast(response.mensaje || 'Error al actualizar fechas', 'error');
                        info.revert();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al actualizar fechas:', error);
                    const mensaje = xhr.responseJSON?.mensaje || 'Error al actualizar fechas';
                    showToast(mensaje, 'error');
                    info.revert();
                }
            });
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