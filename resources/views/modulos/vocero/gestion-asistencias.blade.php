<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vocero - Gestión de Asistencias</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --info-color: #06b6d4;
            --sidebar-bg: #1e293b;
            --sidebar-text: #ecf0f1;
            --light-bg: #f8fafc;
            --dark-color: #1e293b;
            --border-color: #e2e8f0;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            background: var(--sidebar-bg);
            min-height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            padding: 0;
        }

        .sidebar .nav-link {
            color: var(--sidebar-text);
            border-radius: 8px;
            margin: 4px 16px;
            padding: 12px 16px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(59, 130, 246, 0.1);
            color: #60a5fa;
        }

        .sidebar .nav-link i {
            margin-right: 8px;
            width: 20px;
            text-align: center;
        }

        .sidebar-brand {
            padding: 24px 16px;
            border-bottom: 1px solid rgba(226, 232, 240, 0.1);
            margin-bottom: 16px;
            text-align: center;
        }

        .sidebar-brand h4 {
            color: white;
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .content-wrapper {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 24px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
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

        .stat-card {
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid var(--border-color);
        }

        .stat-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .stat-card.active {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
            background: rgba(37, 99, 235, 0.02);
        }

        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: var(--secondary-color);
        }

        .event-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 16px;
            border-radius: 8px;
            height: 100%;
        }

        .badge {
            font-size: 0.85em;
            padding: 6px 12px;
        }

        .badge-success {
            background-color: var(--success-color);
            color: white;
        }

        .badge-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .badge-info {
            background-color: var(--info-color);
            color: white;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                position: relative;
                width: 100%;
            }

            .main-content {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="sidebar">
            <div class="sidebar-brand">
                <h4>
                    <i class="fas fa-calendar-alt text-primary"></i>
                    Vocero
                </h4>
            </div>

            <nav class="sidebar-nav">
                {{-- Rutas de navegación --}}
                <a class="nav-link {{ request()->routeIs('vocero.dashboard') ? 'active' : '' }}" href="{{ route('vocero.dashboard') }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('vocero.calendario') ? 'active' : '' }}" href="{{ route('vocero.calendario') }}">
                    <i class="fas fa-calendar"></i> Calendario
                </a>
                <a class="nav-link {{ request()->routeIs('vocero.eventos') ? 'active' : '' }}" href="{{ route('vocero.eventos') }}">
                    <i class="fas fa-calendar-plus"></i> Gestión de Eventos
                </a>
                <a class="nav-link {{ request()->routeIs('vocero.asistencias') ? 'active' : '' }}" href="{{ route('vocero.asistencias') }}">
                    <i class="fas fa-users"></i> Asistencias
                </a>
                <a class="nav-link {{ request()->routeIs('vocero.reportes') ? 'active' : '' }}" href="{{ route('vocero.reportes') }}">
                    <i class="fas fa-chart-bar"></i> Reportes
                </a>
            </nav>
        </div>

        <div class="main-content">
            <div class="content-wrapper">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Gestión de Asistencias</h2>
                        <p class="text-muted mb-0">Controla y administra la asistencia a eventos</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary" onclick="exportAttendance()">
                            <i class="fas fa-download me-2"></i>Exportar
                        </button>
                        <button class="btn btn-primary" onclick="showAttendanceForm()">
                            <i class="fas fa-plus me-2"></i>Registrar Asistencia
                        </button>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card" onclick="filterByStatus('all')">
                            <div class="card-body">
                                <h6 class="text-muted">Total Asistentes</h6>
                                <h2 class="mb-0" id="total-attendees">0</h2>
                                <small class="text-success">Registros totales</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card" onclick="filterByStatus('presente')">
                            <div class="card-body">
                                <h6 class="text-muted">Presentes</h6>
                                <h2 class="mb-0" id="present-count">0</h2>
                                <small class="text-success" id="present-percentage">0% del total</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card" onclick="filterByStatus('ausente')">
                            <div class="card-body">
                                <h6 class="text-muted">Ausentes</h6>
                                <h2 class="mb-0" id="absent-count">0</h2>
                                <small class="text-danger" id="absent-percentage">0% del total</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card" onclick="filterByStatus('justificado')">
                            <div class="card-body">
                                <h6 class="text-muted">Justificados</h6>
                                <h2 class="mb-0" id="justified-count">0</h2>
                                <small class="text-info" id="justified-percentage">0% del total</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-bullseye me-2"></i>Seleccionar Evento</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Evento:</label>
                                <select class="form-select" id="event-selector" onchange="loadEventAttendance()">
                                    <option value="">Cargando eventos...</option>
                                </select>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Los eventos se sincronizan desde Gestión de Eventos
                                </small>
                            </div>
                            <div class="col-md-6">
                                <div class="event-info" id="event-info" style="display: none;">
                                    <h6 id="selected-event-title">Evento Seleccionado</h6>
                                    <div id="selected-event-details">
                                        <small>Detalles del evento</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Lista de Asistencia</h5>
                        <button class="btn btn-sm btn-outline-primary" onclick="loadAttendanceData()" id="refresh-btn">
                            <i class="fas fa-sync-alt me-1"></i>Actualizar
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Participante</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th>Hora Llegada</th>
                                    <th>Minutos Tarde</th>
                                    <th>Observaciones</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="attendance-tbody">
                                <tr>
                                    <td colspan="7" class="no-data">
                                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                        <h5>Selecciona un evento</h5>
                                        <p>Elige un evento para ver la asistencia</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="attendanceModalLabel">Registrar Asistencia</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="attendanceForm">
                        <input type="hidden" id="modal-attendance-id">
                        
                        <div class="mb-3">
                            <label for="modal-event-id" class="form-label">Evento</label>
                            <select class="form-select" id="modal-event-id" required>
                                {{-- Se llena dinámicamente --}}
                            </select>
                            {{-- Muestra la hora de inicio del evento seleccionado --}}
                            <small class="form-text text-info" id="event-time-display"></small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="modal-name" class="form-label">Nombre de la Persona</label>
                            <input type="text" class="form-control" id="modal-name" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="modal-status" class="form-label">Estado de Asistencia</label>
                            <select class="form-select" id="modal-status" required>
                                <option value="presente">Presente</option>
                                <option value="ausente">Ausente</option>
                                <option value="justificado">Justificado</option>
                            </select>
                        </div>

                        {{-- GRUPO DE CAMPOS DE LLEGADA (Se muestra u oculta con JS) --}}
                        <div id="attendance-details-group" style="display: none;">
                            <hr>
                            <p class="text-muted">Detalles de la llegada (Para estado "Presente")</p>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="modal-arrival-time" class="form-label">Hora de Llegada</label>
                                    {{-- CAMPO PARA INGRESO MANUAL DE HORA --}}
                                    <input type="time" class="form-control" id="modal-arrival-time">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="modal-minutes-late" class="form-label">Minutos Tarde</label>
                                    {{-- CAMPO CALCULADO (solo lectura) --}}
                                    <input type="number" class="form-control" id="modal-minutes-late" readonly>
                                </div>
                            </div>
                            <hr>
                        </div>

                        <div class="mb-3">
                            <label for="modal-notes" class="form-label">Observación</label>
                            <textarea class="form-control" id="modal-notes" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveAttendance()">Guardar Asistencia</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.all.min.js"></script>

    <script>
        let eventsData = []; 
        let attendanceData = []; 
        let currentEventId = null;

        $(document).ready(function() {
            loadSimulatedAttendance();
            loadEventsForSelector();
            initModalEventSelector();
            
            window.addEventListener('eventosUpdated', function() {
                loadEventsForSelector();
                initModalEventSelector();
            });

            // Eventos para calcular minutos tarde y mostrar detalles del evento
            $('#modal-arrival-time').on('change', calculateMinutesLate);

            $('#modal-event-id').on('change', function() {
                updateModalEventTimeInfo($(this).val());
                calculateMinutesLate();
            });

            // Mostrar/Ocultar campos de detalle según el estado de asistencia
            $('#modal-status').on('change', function() {
                if ($(this).val() === 'presente') {
                    $('#attendance-details-group').show();
                    calculateMinutesLate(); 
                } else {
                    $('#attendance-details-group').hide();
                    $('#modal-arrival-time').val('');
                    $('#modal-minutes-late').val(0);
                }
            });
        });
        
        // Muestra la hora de inicio del evento seleccionado en el modal para referencia
        function updateModalEventTimeInfo(eventId) {
            const $infoDisplay = $('#event-time-display');
            const selectedEvent = eventsData.find(e => e.id == eventId);

            $infoDisplay.empty();

            if (selectedEvent) {
                // Usamos la fecha_inicio o start del evento para obtener la hora de inicio (e.g., 13:21 para 'Axel en examenes')
                const startDate = new Date(selectedEvent.fecha_inicio || selectedEvent.start);
                if (!isNaN(startDate)) {
                    const startTime = startDate.toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'});
                    $infoDisplay.text(`Hora de inicio del evento: ${startTime}`);
                }
            }
        }

        // ----------------------------------------------------------------------
        // --- FUNCIONES DE ASISTENCIA Y CÁLCULO DE TIEMPO ---
        // ----------------------------------------------------------------------

        function calculateMinutesLate() {
            const arrivalTime = $('#modal-arrival-time').val();
            const eventId = $('#modal-event-id').val();
            const status = $('#modal-status').val();
            const $minutesLateField = $('#modal-minutes-late');

            $minutesLateField.val(0); // Reset

            if (status !== 'presente' || !arrivalTime || !eventId) {
                return;
            }

            const selectedEvent = eventsData.find(e => e.id == eventId);

            if (selectedEvent) {
                // Obtener la hora de inicio del evento (e.g., 13:21)
                const startDateTime = selectedEvent.fecha_inicio || selectedEvent.start;
                const eventStartTime = new Date(startDateTime);

                if (isNaN(eventStartTime)) {
                    showToast('Error: No se puede obtener la hora de inicio del evento.', 'error');
                    return;
                }

                // Crear un objeto Date para la hora de llegada, usando la misma fecha del evento
                const [arrivalHour, arrivalMinute] = arrivalTime.split(':').map(Number);
                const arrivalDateTime = new Date(eventStartTime);
                arrivalDateTime.setHours(arrivalHour, arrivalMinute, 0, 0);

                // Comparar timestamps (en milisegundos)
                const diffInMs = arrivalDateTime.getTime() - eventStartTime.getTime();
                
                // Convertir milisegundos a minutos.
                const diffInMinutes = Math.ceil(diffInMs / (1000 * 60)); 
                
                let minutesLate = 0;

                // Solo si la llegada es posterior a la hora de inicio (retraso > 0)
                if (diffInMinutes > 0) {
                    minutesLate = diffInMinutes;
                }
                
                $minutesLateField.val(minutesLate);
            }
        }

        function loadSimulatedAttendance() {
            const storedAttendance = localStorage.getItem('asistencias')
            if (storedAttendance) {
                attendanceData = JSON.parse(storedAttendance);
            } else {
                // SIMULACIÓN DE DATOS - Asegúrate que estos ID existan en eventos
                attendanceData = [
                    { id: 101, event_id: '1', name: 'Axel Palma', email: 'axel@vocero.com', status: 'presente', arrival_time: '12:05', minutes_late: 5, notes: 'Se incorporó tarde.' },
                    { id: 102, event_id: '1', name: 'Eduardo Palma', email: 'eduardo@vocero.com', status: 'ausente', arrival_time: '', minutes_late: 0, notes: 'No se presentó' },
                    { id: 103, event_id: '2', name: 'Jose Lobo', email: 'jose@vocero.com', status: 'presente', arrival_time: '18:00', minutes_late: 0, notes: 'Llegó a tiempo' },
                    { id: 104, event_id: '2', name: 'Maria Lopez', email: 'maria@vocero.com', status: 'justificado', arrival_time: '', minutes_late: 0, notes: 'Motivos de salud' }
                ];
                localStorage.setItem('asistencias', JSON.stringify(attendanceData));
            }
        }

        function displayAttendance(attendanceList) {
            const tbody = $('#attendance-tbody');
            tbody.empty();

            if (attendanceList.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="7" class="no-data">
                            <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                            <h5>No hay registros de asistencia</h5>
                            <p>Utiliza el botón 'Registrar Asistencia' para agregar participantes.</p>
                        </td>
                    </tr>
                `);
                return;
            }

            attendanceList.forEach(att => {
                const statusBadge = getStatusBadge(att.status);
                let minutesLateDisplay = 'N/A';
                
                if (att.status === 'presente') {
                    if (att.minutes_late > 0) {
                        minutesLateDisplay = `<span class="badge bg-warning text-dark">${att.minutes_late} min</span>`;
                    } else if (att.arrival_time) {
                        minutesLateDisplay = '0';
                    }
                }

                tbody.append(`
                    <tr data-id="${att.id}">
                        <td>${att.name}</td>
                        <td>${att.email || 'N/A'}</td>
                        <td>${statusBadge}</td>
                        <td>${att.arrival_time || 'N/A'}</td>
                        <td>${minutesLateDisplay}</td>
                        <td>${att.notes || 'N/A'}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-warning" onclick="editAttendance('${att.id}')" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-outline-danger" onclick="deleteAttendance('${att.id}')" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `);
            });
        }
        
        // ----------------------------------------------------------------------
        // --- FUNCIONES CRUD ---
        // ----------------------------------------------------------------------
        
        function initModalEventSelector() {
             const $modalSelector = $('#modal-event-id');
             $modalSelector.empty();
             $modalSelector.append('<option value="">--- Selecciona un Evento ---</option>');
             
             eventsData.forEach(event => {
                const title = event.titulo || event.title || 'Sin título';
                const startDate = new Date(event.fecha_inicio || event.start);
                const displayTitle = `${title} (${startDate.toLocaleDateString('es-ES')})`;
                $modalSelector.append(`<option value="${event.id}">${displayTitle}</option>`);
            });
        }

        function showAttendanceForm(id = null) {
            const $modal = $('#attendanceModal');
            const $form = $('#attendanceForm');
            $form[0].reset();
            $('#modal-attendance-id').val('');
            $('#modal-event-id').prop('disabled', false);
            $('#attendance-details-group').hide();
            $('#modal-minutes-late').val(0);
            $('#event-time-display').empty();

            let initialEventId = null;

            if (id) {
                // Modo Edición
                const att = attendanceData.find(a => a.id == id);
                if (!att) {
                    showToast('Registro de asistencia no encontrado.', 'error');
                    return;
                }
                $('#attendanceModalLabel').text('Editar Asistencia');
                $('#modal-attendance-id').val(att.id);
                $('#modal-event-id').val(att.event_id).prop('disabled', true);
                $('#modal-name').val(att.name);
                $('#modal-status').val(att.status);
                $('#modal-arrival-time').val(att.arrival_time);
                $('#modal-minutes-late').val(att.minutes_late || 0); 
                $('#modal-notes').val(att.notes);

                if (att.status === 'presente') {
                     $('#attendance-details-group').show();
                }
                initialEventId = att.event_id;

            } else {
                // Modo Registro Nuevo
                $('#attendanceModalLabel').text('Registrar Asistencia');
                $('#modal-status').val('presente'); // Establecer 'Presente' por defecto
                
                if (currentEventId) {
                    $('#modal-event-id').val(currentEventId).prop('disabled', true);
                    initialEventId = currentEventId;
                }
                // Si es nuevo registro, mostrar los campos de hora por defecto (porque status es 'presente')
                $('#attendance-details-group').show();
            }
            
            // Mostrar hora del evento y recalcular si es necesario
            if (initialEventId) {
                updateModalEventTimeInfo(initialEventId);
            }

            if ($('#modal-status').val() === 'presente') {
                calculateMinutesLate();
            }

            new bootstrap.Modal($modal).show();
        }

        function editAttendance(id) {
            showAttendanceForm(id);
        }

        function saveAttendance() {
            const id = $('#modal-attendance-id').val();
            const event_id = $('#modal-event-id').val(); 
            const name = $('#modal-name').val();
            const status = $('#modal-status').val();
            const notes = $('#modal-notes').val();
            
            let arrival_time = '';
            let minutes_late = 0;
            let email = 'N/A'; // Email no está en el formulario, se usa N/A en la simulación

            if (!event_id || !name || !status) {
                showToast('Por favor, rellena todos los campos obligatorios (Evento, Nombre, Estado).', 'warning');
                return;
            }

            // Lógica para estado "Presente"
            if (status === 'presente') {
                arrival_time = $('#modal-arrival-time').val();
                
                if (!arrival_time) {
                     showToast('La Hora de Llegada es obligatoria para el estado "Presente".', 'warning');
                     return;
                }
                // Obtener el valor calculado
                minutes_late = $('#modal-minutes-late').val() ? parseInt($('#modal-minutes-late').val()) : 0;
            }

            const newRecord = { 
                id: id ? parseInt(id) : Date.now().toString().slice(-6), 
                event_id, 
                name, 
                email, // Usamos N/A
                status, 
                arrival_time, 
                minutes_late, 
                notes 
            };

            if (id) {
                const index = attendanceData.findIndex(a => a.id == id);
                if (index !== -1) {
                    attendanceData[index] = newRecord;
                    showToast('Asistencia actualizada correctamente', 'success');
                }
            } else {
                attendanceData.push(newRecord);
                showToast('Asistencia registrada correctamente', 'success');
            }

            localStorage.setItem('asistencias', JSON.stringify(attendanceData));

            if (event_id == currentEventId) {
                loadAttendanceData(currentEventId);
            }
            
            const modalElement = document.getElementById('attendanceModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) modal.hide();
        }

        function deleteAttendance(id) {
            Swal.fire({
                title: '¿Eliminar Asistencia?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#ef4444',
            }).then((result) => {
                if (result.isConfirmed) {
                    attendanceData = attendanceData.filter(a => a.id != id);
                    localStorage.setItem('asistencias', JSON.stringify(attendanceData));
                    
                    if (currentEventId) {
                        loadAttendanceData(currentEventId);
                    }
                    showToast('Registro de asistencia eliminado.', 'success');
                }
            });
        }
        
        function exportAttendance() {
            if (!currentEventId) {
                showToast('Selecciona un evento para exportar su asistencia.', 'warning');
                return;
            }
            
            const eventAttendance = attendanceData.filter(a => a.event_id == currentEventId);

            if (eventAttendance.length === 0) {
                showToast('No hay registros de asistencia para exportar en este evento.', 'warning');
                return;
            }

            const headers = ['Nombre', 'Email', 'Estado', 'Hora Llegada', 'Minutos Tarde', 'Observaciones'];
            const rows = eventAttendance.map(att => [
                att.name,
                att.email || 'N/A',
                getStatusName(att.status),
                att.arrival_time || 'N/A',
                att.minutes_late || 0,
                att.notes || 'N/A'
            ]);

            const csvContent = [headers, ...rows]
                .map(row => row.map(field => `"${field}"`).join(','))
                .join('\n');

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            
            const eventTitle = eventsData.find(e => e.id == currentEventId)?.titulo || 'evento';
            link.download = `asistencia_${eventTitle.replace(/\s/g, '_')}_${new Date().toISOString().split('T')[0]}.csv`;
            
            link.click();
            
            showToast('Archivo CSV descargado correctamente', 'success');
        }

        // ----------------------------------------------------------------------
        // --- FUNCIONES DE CARGA Y UX ---
        // ----------------------------------------------------------------------

        function loadEventsForSelector() {
            showLoading();
            // Simulación: Cargar eventos desde localStorage
            const eventosJson = localStorage.getItem('eventos');
            eventsData = eventosJson ? JSON.parse(eventosJson) : [
                 // Datos de simulación si no existen
                { id: '1', titulo: 'Hablar sobre el aborto', fecha_inicio: '2025-09-30T12:00:00', fecha_fin: '2025-09-30T13:00:00', extendedProps: { detalles: { enlace: 'url' } } },
                { id: '2', titulo: 'Axel en examenes', fecha_inicio: '2025-10-23T13:21:00', fecha_fin: '2025-10-23T14:25:00', extendedProps: { detalles: { lugar: 'UNAH' } } },
                { id: '3', titulo: 'CLASES INPLE', fecha_inicio: '2025-10-06T20:00:00', fecha_fin: '2025-10-06T20:30:00', extendedProps: { detalles: { lugar: 'UNIVERSIDAD' } } },
            ]; 
            // Guardar eventos simulados para el uso de la simulación de asistencia
            if (!eventosJson) {
                localStorage.setItem('eventos', JSON.stringify(eventsData));
            }

            const $selector = $('#event-selector');
            $selector.empty();
            
            if (eventsData.length === 0) {
                $selector.append('<option value="">No hay eventos disponibles</option>');
                $selector.prop('disabled', true);
            } else {
                $selector.append('<option value="">--- Selecciona un Evento ---</option>');
                eventsData.forEach(event => {
                    const title = event.titulo || event.title || 'Sin título';
                    const startDate = new Date(event.fecha_inicio || event.start);
                    const displayTitle = `${title} (${startDate.toLocaleDateString('es-ES')})`;
                    $selector.append(`<option value="${event.id}">${displayTitle}</option>`);
                });
                $selector.prop('disabled', false);
            }
            hideLoading();
        }

        function loadEventAttendance() {
            currentEventId = $('#event-selector').val();
            
            if (!currentEventId) {
                $('#event-info').hide();
                $('#attendance-tbody').html(`
                    <tr>
                        <td colspan="7" class="no-data">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <h5>Selecciona un evento</h5>
                            <p>Elige un evento para ver la asistencia</p>
                        </td>
                    </tr>
                `);
                updateStats(0, 0, 0, 0);
                return;
            }

            const selectedEvent = eventsData.find(e => e.id == currentEventId);
            if (selectedEvent) {
                displayEventDetails(selectedEvent);
                loadAttendanceData(currentEventId); 
            }
        }
        
        function loadAttendanceData(eventId = currentEventId) {
            if (!eventId) return;

            showLoading();
            const eventAttendance = attendanceData.filter(a => a.event_id == eventId);
            displayAttendance(eventAttendance);
            
            const total = eventAttendance.length;
            const present = eventAttendance.filter(a => a.status === 'presente').length;
            const absent = eventAttendance.filter(a => a.status === 'ausente').length;
            const justified = eventAttendance.filter(a => a.status === 'justificado').length;
            
            updateStats(total, present, absent, justified);
            hideLoading();
        }

        function displayEventDetails(event) {
            const title = event.titulo || event.title || 'Sin título';
            const startDate = new Date(event.fecha_inicio || event.start);
            const endDate = new Date(event.fecha_fin || event.end);
            
            let ubicacion = 'No especificada';
            const detalles = event.extendedProps?.detalles;
            if (detalles) {
                if (detalles.enlace) {
                    ubicacion = 'Reunión Virtual';
                } else if (detalles.lugar) {
                    ubicacion = detalles.lugar;
                }
            }

            $('#selected-event-title').text(title);
            $('#selected-event-details').html(`
                <small><strong>Fecha:</strong> ${startDate.toLocaleDateString('es-ES')} (${startDate.toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'})} - ${endDate.toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'})})</small><br>
                <small><strong>Ubicación:</strong> ${ubicacion}</small><br>
                <small><strong>Organizador:</strong> ${event.extendedProps?.organizador || 'N/A'}</small>
            `);
            $('#event-info').show();
        }

        function updateStats(total, present, absent, justified) {
            const calcPercentage = (count, total) => total === 0 ? '0%' : `${((count / total) * 100).toFixed(0)}%`;
            
            $('#total-attendees').text(total);
            $('#present-count').text(present);
            $('#absent-count').text(absent);
            $('#justified-count').text(justified);
            
            $('#present-percentage').text(`${calcPercentage(present, total)} del total`);
            $('#absent-percentage').text(`${calcPercentage(absent, total)} del total`);
            $('#justified-percentage').text(`${calcPercentage(justified, total)} del total`);
            
            $('.stat-card').removeClass('active');
            $('.stat-card[onclick="filterByStatus(\'all\')"]').addClass('active');
        }

        function filterByStatus(status) {
            $('.stat-card').removeClass('active');
            $(`.stat-card[onclick="filterByStatus('${status}')"]`).addClass('active');

            if (status === 'all') {
                loadAttendanceData(currentEventId);
                return;
            }
            
            const eventAttendance = attendanceData.filter(a => a.event_id == currentEventId);
            const filtered = eventAttendance.filter(a => a.status === status);
            
            displayAttendance(filtered);
        }

        function getStatusBadge(status) {
            const mapping = {
                'presente': '<span class="badge badge-success">Presente</span>',
                'ausente': '<span class="badge badge-danger">Ausente</span>',
                'justificado': '<span class="badge badge-info">Justificado</span>',
            };
            return mapping[status] || '<span class="badge bg-secondary">Sin estado</span>';
        }
        
        function getStatusName(status) {
             const mapping = {
                'presente': 'Presente',
                'ausente': 'Ausente',
                'justificado': 'Justificado',
            };
            return mapping[status] || 'Sin estado';
        }

        function showLoading() {
            $('body').addClass('loading');
        }

        function hideLoading() {
            $('body').removeClass('loading');
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