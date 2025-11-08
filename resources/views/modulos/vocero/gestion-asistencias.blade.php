<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Macero - Gestión de Asistencias</title>
    
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
            --sidebar-text: #e2e8f0;
            --light-bg: #f8fafc;
            --dark-color: #1e293b;
            --border-color: #e2e8f0;
        }

        body {
            background-color: #d0cfcd;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            background: var(--sidebar-bg);
            min-height: 100vh;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .main-content {
            margin-left: 200px;
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

        .sidebar .nav-link:hover {
            background: rgba(59, 130, 246, 0.1);
            color: #60a5fa;
        }

        .sidebar .nav-link.active {
            background: var(--primary-color);
            color: white;
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
                    Macero
                </h4>
            </div>

            <nav class="sidebar-nav">
                <a class="nav-link {{ request()->routeIs('vocero.dashboard') ? 'active' : '' }}" href="{{ route('vocero.dashboard') }}">
                    <i class="fas fa-chart-line"></i> Resumen General
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
                        <h2><i class="fas fa-users me-2"></i>Gestión de Asistencias</h2>
                        <p class="text-muted mb-0">Administra y registra la asistencia de los participantes</p>
                    </div>
                    <div>
                        <button class="btn btn-outline-secondary" onclick="refreshData()">
                            <i class="fas fa-sync-alt me-2"></i>Actualizar
                        </button>
                        <button class="btn btn-success" onclick="exportToCSV()" id="export-btn" disabled>
                            <i class="fas fa-download me-2"></i>Exportar CSV
                        </button>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-end mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Selecciona un Evento</label>
                                <select class="form-select" id="event-selector" onchange="loadEventAttendance()">
                                    <option value="">Cargando eventos...</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary" onclick="openNewAttendanceModal()" id="add-attendance-btn" disabled>
                                    <i class="fas fa-user-plus me-2"></i>Registrar Asistencia
                                </button>
                            </div>
                        </div>

                        <div id="event-info" class="mb-4" style="display: none;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="event-info">
                                        <h5 class="mb-2" id="selected-event-title">Evento Seleccionado</h5>
                                        <div id="selected-event-details"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card stat-card" onclick="filterByStatus('all')">
                            <div class="card-body">
                                <h6 class="text-muted">Total Participantes</h6>
                                <h2 class="mb-0" id="total-attendees">0</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card" onclick="filterByStatus('presente')">
                            <div class="card-body">
                                <h6 class="text-success">Presentes</h6>
                                <h2 class="mb-0 text-success" id="present-count">0</h2>
                                <small class="text-muted" id="present-percentage">0% del total</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card" onclick="filterByStatus('ausente')">
                            <div class="card-body">
                                <h6 class="text-danger">Ausentes</h6>
                                <h2 class="mb-0 text-danger" id="absent-count">0</h2>
                                <small class="text-muted" id="absent-percentage">0% del total</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card" onclick="filterByStatus('justificado')">
                            <div class="card-body">
                                <h6 class="text-info">Justificados</h6>
                                <h2 class="mb-0 text-info" id="justified-count">0</h2>
                                <small class="text-muted" id="justified-percentage">0% del total</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Participante</th>
                                        <th>Email</th>
                                        <th>Observaciones</th>
                                        <th>Estado</th>
                                        <th>Hora Llegada</th>
                                        <th>Minutos Tarde</th>
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
    </div>

    <!-- Modal para Registrar/Editar Asistencia -->
    <div class="modal fade" id="attendanceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Registrar Asistencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="attendanceForm">
                        <input type="hidden" id="attendance-id">
                        <input type="hidden" id="is-edit" value="false">

                        <div class="mb-3">
                            <label class="form-label">Participante *</label>
                            <select class="form-select" id="member-selector" required>
                                <option value="">Cargando participantes...</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Estado de Asistencia *</label>
                            <select class="form-select" id="status-selector" required>
                                <option value="presente">Presente</option>
                                <option value="ausente">Ausente</option>
                                <option value="justificado">Justificado</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hora de Llegada</label>
                            <input type="time" class="form-control" id="arrival-time">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Minutos Tarde</label>
                            <input type="number" class="form-control" id="minutes-late" min="0" value="0">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control" id="notes" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveAttendance()">
                        <i class="fas fa-save me-2"></i>Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.all.min.js"></script>

    <script>
        // ============================================================================
        // 🔄 CÓDIGO MODIFICADO - CONECTADO A BASE DE DATOS
        // ============================================================================
        
        let eventsData = [];
        let attendanceData = [];
        let miembrosData = [];
        let currentEventId = null;
        let attendanceModal;

        $(document).ready(function() {
            attendanceModal = new bootstrap.Modal(document.getElementById('attendanceModal'));
            loadEventsForSelector();
            loadMiembros();
            
            // Event listener para calcular minutos tarde automáticamente
            $('#arrival-time').on('change', function() {
                calculateMinutesLate();
            });
        });

        // ============================================================================
        // 🆕 FUNCIÓN: Calcular minutos tarde automáticamente
        // ============================================================================
        function calculateMinutesLate() {
            const arrivalTime = $('#arrival-time').val();
            
            if (!arrivalTime || !currentEventStartTime) {
                return;
            }
            
            // Obtener la fecha del evento
            const eventDate = new Date(currentEventStartTime);
            
            // Crear fecha completa con la hora de llegada ingresada
            const [hours, minutes] = arrivalTime.split(':');
            const arrivalDateTime = new Date(eventDate);
            arrivalDateTime.setHours(parseInt(hours), parseInt(minutes), 0, 0);
            
            // Calcular diferencia en minutos
            const diffInMs = arrivalDateTime - eventDate;
            const diffInMinutes = Math.floor(diffInMs / (1000 * 60));
            
            // Si llegó tarde (diferencia positiva), actualizar el campo
            if (diffInMinutes > 0) {
                $('#minutes-late').val(diffInMinutes);
            } else {
                // Si llegó a tiempo o temprano, poner 0
                $('#minutes-late').val(0);
            }
        }

        // ============================================================================
        // ✅ FUNCIÓN: Cargar eventos desde la base de datos
        // ============================================================================
        function loadEventsForSelector() {
            showLoading();
            
            $.ajax({
                url: '/api/calendario/eventos',
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(eventos) {
                    eventsData = eventos;
                    
                    const $selector = $('#event-selector');
                    $selector.empty();
                    
                    if (eventsData.length === 0) {
                        $selector.append('<option value="">No hay eventos disponibles</option>');
                        $selector.prop('disabled', true);
                    } else {
                        $selector.append('<option value="">--- Selecciona un Evento ---</option>');
                        eventsData.forEach(event => {
                            const title = event.title || 'Sin título';
                            const startDate = new Date(event.start);
                            const displayTitle = `${title} (${startDate.toLocaleDateString('es-ES')})`;
                            $selector.append(`<option value="${event.id}">${displayTitle}</option>`);
                        });
                        $selector.prop('disabled', false);
                    }
                    hideLoading();
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar eventos:', error);
                    showToast('Error al cargar eventos', 'error');
                    hideLoading();
                }
            });
        }

        // ============================================================================
        // ✅ FUNCIÓN: Cargar miembros desde la base de datos
        // ============================================================================
        function loadMiembros() {
            $.ajax({
                url: '/api/calendario/miembros',
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        miembrosData = response.miembros;
                        updateMemberSelector();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar miembros:', error);
                }
            });
        }

        function updateMemberSelector() {
            const $selector = $('#member-selector');
            $selector.empty();
            $selector.append('<option value="">--- Selecciona un Participante ---</option>');
            
            miembrosData.forEach(miembro => {
                $selector.append(`<option value="${miembro.MiembroID}">${miembro.Nombre} - ${miembro.Rol}</option>`);
            });
        }

        // ============================================================================
        // ✅ FUNCIÓN: Cargar asistencias del evento seleccionado
        // ============================================================================
        function loadEventAttendance() {
            currentEventId = $('#event-selector').val();
            
            if (!currentEventId) {
                $('#event-info').hide();
                $('#add-attendance-btn').prop('disabled', true);
                $('#export-btn').prop('disabled', true);
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
                $('#add-attendance-btn').prop('disabled', false);
                $('#export-btn').prop('disabled', false);
                loadAttendanceData(currentEventId);
            }
        }

        function loadAttendanceData(eventId = currentEventId) {
            if (!eventId) return;

            showLoading();
            
            $.ajax({
                url: `/api/calendario/eventos/${eventId}/asistencias`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        attendanceData = response.asistencias;
                        displayAttendance(attendanceData);
                        
                        const total = attendanceData.length;
                        const present = attendanceData.filter(a => a.status === 'presente').length;
                        const absent = attendanceData.filter(a => a.status === 'ausente').length;
                        const justified = attendanceData.filter(a => a.status === 'justificado').length;
                        
                        updateStats(total, present, absent, justified);
                    }
                    hideLoading();
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar asistencias:', error);
                    showToast('Error al cargar asistencias', 'error');
                    hideLoading();
                }
            });
        }

        // Variable global para almacenar la hora de inicio del evento
        let currentEventStartTime = null;

        function displayEventDetails(event) {
            const title = event.title || 'Sin título';
            const startDate = new Date(event.start);
            const endDate = new Date(event.end);
            
            // Guardar la hora de inicio del evento para calcular minutos tarde
            currentEventStartTime = startDate;
            
            let ubicacion = 'No especificada';
            const detalles = event.extendedProps?.detalles;
            if (detalles) {
                if (detalles.enlace) {
                    ubicacion = 'Reunión Virtual';
                } else if (detalles.lugar) {
                    ubicacion = detalles.lugar;
                } else if (detalles.ubicacion_proyecto) {
                    ubicacion = detalles.ubicacion_proyecto;
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

        function displayAttendance(attendance) {
            const tbody = $('#attendance-tbody');
            tbody.empty();

            if (attendance.length === 0) {
                tbody.html(`
                    <tr>
                        <td colspan="7" class="no-data">
                            <i class="fas fa-user-times fa-3x text-muted mb-3"></i>
                            <h5>Sin registros de asistencia</h5>
                            <p>No hay asistencias registradas para este evento</p>
                        </td>
                    </tr>
                `);
                return;
            }

            attendance.forEach(att => {
                const row = `
                    <tr>
                        <td><strong>${att.name}</strong></td>
                        <td>${att.email || 'N/A'}</td>
                        <td>${att.notes || 'Sin observaciones'}</td>
                        <td>${getStatusBadge(att.status)}</td>
                        <td>${att.arrival_time || 'N/A'}</td>
                        <td>${att.minutes_late || 0} min</td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="editAttendance(${att.id})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteAttendance(${att.id})" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
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
                displayAttendance(attendanceData);
                return;
            }
            
            const filtered = attendanceData.filter(a => a.status === status);
            displayAttendance(filtered);
        }

        // ============================================================================
        // ✅ FUNCIÓN: Abrir modal para nueva asistencia
        // ============================================================================
        function openNewAttendanceModal() {
            if (!currentEventId) {
                showToast('Selecciona un evento primero', 'warning');
                return;
            }

            $('#modal-title').text('Registrar Asistencia');
            $('#attendanceForm')[0].reset();
            $('#attendance-id').val('');
            $('#is-edit').val('false');
            $('#member-selector').prop('disabled', false);
            attendanceModal.show();
        }

        // ============================================================================
        // ✅ FUNCIÓN: Editar asistencia existente
        // ============================================================================
        function editAttendance(id) {
            const attendance = attendanceData.find(a => a.id == id);
            if (!attendance) {
                showToast('Asistencia no encontrada', 'error');
                return;
            }

            $('#modal-title').text('Editar Asistencia');
            $('#attendance-id').val(attendance.id);
            $('#is-edit').val('true');
            $('#member-selector').val(attendance.member_id);
            $('#member-selector').prop('disabled', true);
            $('#status-selector').val(attendance.status);
            
            // Convertir hora de HH:MM:SS a HH:MM para el input type="time"
            if (attendance.arrival_time) {
                const timeParts = attendance.arrival_time.split(':');
                const timeForInput = `${timeParts[0]}:${timeParts[1]}`;
                $('#arrival-time').val(timeForInput);
            } else {
                $('#arrival-time').val('');
            }
            
            $('#minutes-late').val(attendance.minutes_late || 0);
            $('#notes').val(attendance.notes || '');
            
            attendanceModal.show();
        }

        // ============================================================================
        // ✅ FUNCIÓN: Guardar asistencia (crear o actualizar)
        // ============================================================================
        function saveAttendance() {
            const isEdit = $('#is-edit').val() === 'true';
            const attendanceId = $('#attendance-id').val();
            
            // Obtener y formatear la hora de llegada
            let arrivalTime = $('#arrival-time').val();
            if (arrivalTime) {
                // Si la hora no tiene segundos, agregarlos
                if (arrivalTime.split(':').length === 2) {
                    arrivalTime = arrivalTime + ':00';
                }
            } else {
                arrivalTime = null;
            }
            
            const attendanceData = {
                member_id: $('#member-selector').val(),
                event_id: currentEventId,
                status: $('#status-selector').val(),
                arrival_time: arrivalTime,
                minutes_late: parseInt($('#minutes-late').val()) || 0,
                notes: $('#notes').val() || null
            };

            if (!attendanceData.member_id && !isEdit) {
                showToast('Selecciona un participante', 'warning');
                return;
            }

            showLoading();

            if (isEdit) {
                // Actualizar asistencia existente
                $.ajax({
                    url: `/api/calendario/asistencias/${attendanceId}`,
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify(attendanceData),
                    success: function(response) {
                        if (response.success) {
                            attendanceModal.hide();
                            loadAttendanceData(currentEventId);
                            showToast('Asistencia actualizada correctamente', 'success');
                        } else {
                            showToast(response.mensaje || 'Error al actualizar asistencia', 'error');
                        }
                        hideLoading();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al actualizar asistencia:', error);
                        showToast(xhr.responseJSON?.mensaje || 'Error al actualizar asistencia', 'error');
                        hideLoading();
                    }
                });
            } else {
                // Crear nueva asistencia
                $.ajax({
                    url: '/api/calendario/asistencias',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify(attendanceData),
                    success: function(response) {
                        if (response.success) {
                            attendanceModal.hide();
                            loadAttendanceData(currentEventId);
                            showToast('Asistencia registrada correctamente', 'success');
                        } else {
                            showToast(response.mensaje || 'Error al registrar asistencia', 'error');
                        }
                        hideLoading();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al registrar asistencia:', error);
                        showToast(xhr.responseJSON?.mensaje || 'Error al registrar asistencia', 'error');
                        hideLoading();
                    }
                });
            }
        }

        // ============================================================================
        // ✅ FUNCIÓN: Eliminar asistencia
        // ============================================================================
        function deleteAttendance(id) {
            Swal.fire({
                title: '¿Eliminar registro?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    
                    $.ajax({
                        url: `/api/calendario/asistencias/${id}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                loadAttendanceData(currentEventId);
                                showToast('Asistencia eliminada correctamente', 'success');
                            } else {
                                showToast(response.mensaje || 'Error al eliminar asistencia', 'error');
                            }
                            hideLoading();
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al eliminar asistencia:', error);
                            showToast(xhr.responseJSON?.mensaje || 'Error al eliminar asistencia', 'error');
                            hideLoading();
                        }
                    });
                }
            });
        }

        function refreshData() {
            showToast('Actualizando datos...', 'info');
            loadEventsForSelector();
            if (currentEventId) {
                loadAttendanceData(currentEventId);
            }
        }

        function exportToCSV() {
            if (!currentEventId || attendanceData.length === 0) {
                showToast('No hay registros para exportar', 'warning');
                return;
            }

            const headers = ['Nombre', 'Email', 'Estado', 'Hora Llegada', 'Minutos Tarde', 'Observaciones'];
            const rows = attendanceData.map(att => [
                att.name,
                att.email || 'N/A',
                getStatusName(att.status),
                att.arrival_time || 'N/A',
                att.minutes_late || 0,
                att.notes || 'Sin observaciones'
            ]);

            const csvContent = [headers, ...rows]
                .map(row => row.map(field => `"${field}"`).join(','))
                .join('\n');

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            
            const eventTitle = eventsData.find(e => e.id == currentEventId)?.title || 'evento';
            link.download = `asistencia_${eventTitle.replace(/\s/g, '_')}_${new Date().toISOString().split('T')[0]}.csv`;
            
            link.click();
            
            showToast('Archivo CSV descargado correctamente', 'success');
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