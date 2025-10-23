<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vocero - Reportes y Análisis</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --info-color: #06b6d4;
            --purple-color: #8b5cf6;
            --pink-color: #ec4899;
            --sidebar-bg: #1e293b;
            --sidebar-text: #e2e8f0;
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
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
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

        .sidebar .nav-link {
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
            cursor: pointer;
        }

        .sidebar .nav-link:hover {
            background: rgba(59, 130, 246, 0.1);
            color: #60a5fa;
            transform: translateX(4px);
        }

        .sidebar .nav-link.active {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            padding: 0;
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
            transition: transform 0.2s ease;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

        .btn-success {
            background: var(--success-color);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
        }

        .btn-success:hover {
            background: #047857;
        }

        .stat-card {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .stat-title {
            font-size: 14px;
            color: var(--secondary-color);
            margin: 0;
        }

        .stat-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: white;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0;
        }

        .stat-change {
            font-size: 12px;
            font-weight: 500;
            margin-top: 4px;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        .chart-container.large {
            height: 400px;
        }

        .legend {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 16px;
            justify-content: center;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 4px;
        }

        .event-detail-item {
            padding: 12px;
            border-left: 3px solid var(--primary-color);
            background: rgba(37, 99, 235, 0.05);
            margin-bottom: 8px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .event-detail-item:hover {
            background: rgba(37, 99, 235, 0.1);
            transform: translateX(4px);
        }

        .event-detail-title {
            font-weight: 600;
            color: var(--dark-color);
            margin: 0 0 4px 0;
            font-size: 14px;
        }

        .event-detail-info {
            font-size: 12px;
            color: var(--secondary-color);
            margin: 0;
        }

        .completed-event-item {
            border-left-color: var(--success-color);
            background: rgba(5, 150, 105, 0.05);
        }

        .completed-event-item:hover {
            background: rgba(5, 150, 105, 0.1);
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
            }

            .main-content {
                margin-left: 0;
            }

            .content-wrapper {
                margin: 10px;
                padding: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="sidebar">
                <div class="sidebar-brand">
                    <h4><i class="fas fa-calendar-alt text-primary"></i> Vocero</h4>
                </div>
                
                <nav class="sidebar-nav">
                    {{-- RUTA CORREGIDA: vocero.dashboard --}}
                <a class="nav-link {{ request()->routeIs('vocero.dashboard') ? 'active' : '' }}" href="{{ route('vocero.dashboard') }}">
                    <i class="fas fa-chart-line me-2"></i>
                    Dashboard
                </a>
                    <a class="nav-link" href="{{ route('vocero.calendario') }}">
                        <i class="fas fa-calendar"></i>
                        Calendario
                    </a>
                    <a class="nav-link" href="{{ route('vocero.eventos') }}">
                        <i class="fas fa-calendar-plus"></i>
                        Gestión de Eventos
                    </a>
                    <a class="nav-link" href="{{ route('vocero.asistencias') }}">
                        <i class="fas fa-users"></i>
                        Asistencias
                    </a>
                    <a class="nav-link active" href="{{ route('vocero.reportes') }}">
                        <i class="fas fa-chart-bar"></i>
                        Reportes
                    </a>
                </nav>
            </div>

            <div class="main-content">
                <div class="content-wrapper">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="mb-1">Reportes y Análisis</h2>
                            <p class="text-muted mb-0">Visualiza tendencias y genera reportes detallados de eventos y asistencias</p>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <button class="btn btn-outline-primary" onclick="refreshData()">
                                <i class="fas fa-sync-alt me-2"></i>Actualizar
                            </button>
                            <button class="btn btn-success" onclick="generateReport()">
                                <i class="fas fa-file-pdf me-2"></i>Generar Reporte
                            </button>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card stat-card" onclick="showEventDetails('total')" title="Click para ver detalles de eventos">
                                <div class="card-body">
                                    <div class="stat-header">
                                        <h6 class="stat-title">Total Eventos</h6>
                                        <div class="stat-icon" style="background: var(--primary-color);">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div>
                                    <h2 class="stat-number" id="total-events">0</h2>
                                    <small class="stat-change text-success">Sincronizado con gestión</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card stat-card" onclick="showEventDetails('completed')" title="Click para ver eventos completados">
                                <div class="card-body">
                                    <div class="stat-header">
                                        <h6 class="stat-title">Eventos Finalizados</h6>
                                        <div class="stat-icon" style="background: var(--success-color);">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                    </div>
                                    <h2 class="stat-number" id="completed-events">0</h2>
                                    <small class="stat-change text-success" id="completed-description">Con estado finalizado</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card stat-card" onclick="showAttendanceDetails()" title="Click para ver detalles de asistencia">
                                <div class="card-body">
                                    <div class="stat-header">
                                        <h6 class="stat-title">Tasa de Asistencia</h6>
                                        <div class="stat-icon" style="background: var(--info-color);">
                                            <i class="fas fa-trophy"></i>
                                        </div>
                                    </div>
                                    <h2 class="stat-number" id="attendance-rate">N/A</h2>
                                    <small class="stat-change text-success" id="attendance-description">Reuniones virtuales/presenciales</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card stat-card" onclick="showProjectParticipantsDetails()" title="Click para ver detalles de participantes">
                                <div class="card-body">
                                    <div class="stat-header">
                                        <h6 class="stat-title">Promedio Participantes</h6>
                                        <div class="stat-icon" style="background: var(--purple-color);">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                    <h2 class="stat-number" id="avg-participants">N/A</h2>
                                    <small class="stat-change text-success" id="participants-description">En proyectos inicio/fin</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4 GRÁFICAS -->
                    <div class="row mb-4">
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Estados de Eventos</h5>
                                    <button class="btn btn-outline-primary btn-sm" onclick="exportChart('donut')">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="donutChart"></canvas>
                                    </div>
                                    <div class="legend" id="donut-legend"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Tendencia de Eventos</h5>
                                    <button class="btn btn-outline-primary btn-sm" onclick="exportChart('line')">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container large">
                                        <canvas id="lineChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Asistencias en Reuniones</h5>
                                    <button class="btn btn-outline-primary btn-sm" onclick="exportChart('attendance')">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container large">
                                        <canvas id="attendanceChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Participación en Proyectos</h5>
                                    <button class="btn btn-outline-primary btn-sm" onclick="exportChart('projects')">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container large">
                                        <canvas id="projectsChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.all.min.js"></script>

    <script>
        // Todo el JavaScript permanece exactamente igual
        let donutChart = null;
        let lineChart = null;
        let attendanceChart = null;
        let projectsChart = null;
        let eventsData = [];
        let attendanceData = [];

        $(document).ready(function() {
            initializeCharts();
            setupSyncListeners();
            loadData();
        });

        function loadData() {
            const eventos = localStorage.getItem('eventos');
            
            if (!eventos) {
                console.warn('No se encontraron eventos en localStorage');
                eventsData = [];
            } else {
                try {
                    eventsData = JSON.parse(eventos);
                    console.log('Eventos cargados:', eventsData.length);
                } catch (e) {
                    console.error('Error al parsear eventos:', e);
                    eventsData = [];
                }
            }
            
            const asistencias = localStorage.getItem('asistencias');
            attendanceData = asistencias ? JSON.parse(asistencias) : [];
            
            console.log('Datos cargados - Eventos:', eventsData.length, 'Asistencias:', attendanceData.length);
            
            calculateAllStats();
            updateChartsFromData(eventsData);
        }

        function setupSyncListeners() {
            window.addEventListener('eventosUpdated', function() {
                console.log('Eventos actualizados, recargando...');
                loadData();
            });

            window.addEventListener('storage', function(e) {
                if (e.key === 'eventos' || e.key === 'asistencias') {
                    console.log('Detectado cambio en', e.key);
                    loadData();
                }
            });
        }

        function calculateAllStats() {
            $('#total-events').text(eventsData.length);
            
            const completedEvents = eventsData.filter(event => {
                const estado = event.extendedProps?.estado || event.estado || '';
                return estado === 'finalizado';
            });
            
            $('#completed-events').text(completedEvents.length);
            $('#completed-description').text(`De ${eventsData.length} eventos totales`);
            
            calculateAttendanceRate();
            calculateProjectParticipants();
        }

        function calculateAttendanceRate() {
            const meetingAttendance = attendanceData.filter(att => {
                const event = eventsData.find(e => e.id == att.event_id);
                if (!event) return false;
                
                const tipoEvento = event.extendedProps?.tipo_evento || '';
                return tipoEvento === 'reunion-virtual' || tipoEvento === 'reunion-presencial';
            });
            
            if (meetingAttendance.length === 0) {
                $('#attendance-rate').text('N/A');
                $('#attendance-description').text('Sin datos de reuniones');
                return;
            }
            
            const totalMeetings = meetingAttendance.length;
            const present = meetingAttendance.filter(att => att.status === 'presente').length;
            const attendanceRate = totalMeetings > 0 ? Math.round((present / totalMeetings) * 100) : 0;
            
            $('#attendance-rate').text(`${attendanceRate}%`);
            $('#attendance-description').text(`De ${totalMeetings} reunión(es)`);
        }

        function calculateProjectParticipants() {
            const projectAttendance = attendanceData.filter(att => {
                const event = eventsData.find(e => e.id == att.event_id);
                if (!event) return false;
                
                const tipoEvento = event.extendedProps?.tipo_evento || '';
                return tipoEvento === 'inicio-proyecto' || tipoEvento === 'finalizar-proyecto';
            });
            
            if (projectAttendance.length === 0) {
                $('#avg-participants').text('N/A');
                $('#participants-description').text('Sin datos de proyectos');
                return;
            }
            
            const projectEvents = eventsData.filter(e => {
                const tipo = e.extendedProps?.tipo_evento || '';
                return tipo === 'inicio-proyecto' || tipo === 'finalizar-proyecto';
            });
            
            const avgParticipants = projectEvents.length > 0 ? Math.round(projectAttendance.length / projectEvents.length) : 0;
            
            $('#avg-participants').text(avgParticipants);
            $('#participants-description').text(`En ${projectAttendance.length} registro(s)`);
        }

        function showEventDetails(type) {
            let filteredEvents = [];
            let title = '';
            let eventClass = 'event-detail-item';

            if (type === 'total') {
                filteredEvents = [...eventsData];
                title = `Todos los Eventos (${filteredEvents.length})`;
            } else if (type === 'completed') {
                filteredEvents = eventsData.filter(event => {
                    const estado = event.extendedProps?.estado || event.estado || '';
                    return estado === 'finalizado';
                });
                title = `Eventos Finalizados (${filteredEvents.length})`;
                eventClass = 'completed-event-item';
            }

            if (filteredEvents.length === 0) {
                Swal.fire({
                    title: title,
                    html: `
                        <div style="text-align: center; padding: 40px 20px;">
                            <i class="fas fa-calendar-times" style="font-size: 3rem; color: #64748b; margin-bottom: 16px;"></i>
                            <p style="color: #64748b; margin: 0;">No hay eventos para mostrar</p>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonText: 'Cerrar',
                    width: '500px'
                });
                return;
            }

            let eventsHtml = filteredEvents.map(event => {
                const titulo = event.title || event.titulo || 'Sin título';
                const organizador = event.extendedProps?.organizador || 'Sin organizador';
                const tipoEvento = getCategoryName(event.extendedProps?.tipo_evento || 'sin-categoria');
                const estado = event.extendedProps?.estado || 'programado';
                
                return `
                    <div class="${eventClass}">
                        <div class="event-detail-title">${titulo}</div>
                        <div class="event-detail-info">
                            ${tipoEvento} - ${organizador} - Estado: ${getStatusName(estado)}
                        </div>
                    </div>
                `;
            }).join('');

            Swal.fire({
                title: title,
                html: `
                    <div style="max-height: 400px; overflow-y: auto; text-align: left; padding: 10px;">
                        ${eventsHtml}
                    </div>
                `,
                confirmButtonText: 'Cerrar',
                confirmButtonColor: type === 'completed' ? '#059669' : '#2563eb',
                width: '600px'
            });
        }

        function showAttendanceDetails() {
            const meetingAttendance = attendanceData.filter(att => {
                const event = eventsData.find(e => e.id == att.event_id);
                if (!event) return false;
                const tipoEvento = event.extendedProps?.tipo_evento || '';
                return tipoEvento === 'reunion-virtual' || tipoEvento === 'reunion-presencial';
            });
            
            if (meetingAttendance.length === 0) {
                Swal.fire({
                    title: 'Tasa de Asistencia',
                    html: `
                        <div style="text-align: center; padding: 40px 20px;">
                            <i class="fas fa-chart-line" style="font-size: 3rem; color: #06b6d4; margin-bottom: 16px;"></i>
                            <p style="color: #64748b; margin: 0;">No hay datos de asistencia para reuniones</p>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonText: 'Entendido'
                });
                return;
            }
            
            let detailsHtml = meetingAttendance.map(att => {
                const event = eventsData.find(e => e.id == att.event_id);
                const titulo = event ? (event.title || event.titulo) : 'Evento desconocido';
                const tipoEvento = event ? (event.extendedProps?.tipo_evento || '') : '';
                
                return `
                    <div class="event-detail-item">
                        <div class="event-detail-title">${titulo}</div>
                        <div class="event-detail-info">
                            ${tipoEvento === 'reunion-virtual' ? '💻 Virtual' : '🏢 Presencial'} - 
                            ${att.participant_name} - ${att.status === 'presente' ? '✅ Presente' : '❌ Ausente'}
                        </div>
                    </div>
                `;
            }).join('');

            Swal.fire({
                title: 'Detalles de Asistencia',
                html: `
                    <div style="max-height: 400px; overflow-y: auto; text-align: left; padding: 10px;">
                        ${detailsHtml}
                    </div>
                `,
                confirmButtonText: 'Cerrar',
                confirmButtonColor: '#06b6d4',
                width: '600px'
            });
        }

        function showProjectParticipantsDetails() {
            const projectAttendance = attendanceData.filter(att => {
                const event = eventsData.find(e => e.id == att.event_id);
                if (!event) return false;
                const tipoEvento = event.extendedProps?.tipo_evento || '';
                return tipoEvento === 'inicio-proyecto' || tipoEvento === 'finalizar-proyecto';
            });
            
            if (projectAttendance.length === 0) {
                Swal.fire({
                    title: 'Promedio de Participantes',
                    html: `
                        <div style="text-align: center; padding: 40px 20px;">
                            <i class="fas fa-users" style="font-size: 3rem; color: #8b5cf6; margin-bottom: 16px;"></i>
                            <p style="color: #64748b; margin: 0;">No hay datos de participantes en proyectos</p>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonText: 'Entendido'
                });
                return;
            }
            
            let detailsHtml = projectAttendance.map(att => {
                const event = eventsData.find(e => e.id == att.event_id);
                const titulo = event ? (event.title || event.titulo) : 'Proyecto desconocido';
                const tipoEvento = event ? (event.extendedProps?.tipo_evento || '') : '';
                
                return `
                    <div class="event-detail-item">
                        <div class="event-detail-title">${titulo}</div>
                        <div class="event-detail-info">
                            ${tipoEvento === 'inicio-proyecto' ? '🚀 Inicio' : '🎯 Finalización'} - 
                            ${att.participant_name}
                        </div>
                    </div>
                `;
            }).join('');

            Swal.fire({
                title: 'Participantes en Proyectos',
                html: `
                    <div style="max-height: 400px; overflow-y: auto; text-align: left; padding: 10px;">
                        ${detailsHtml}
                    </div>
                `,
                confirmButtonText: 'Cerrar',
                confirmButtonColor: '#8b5cf6',
                width: '600px'
            });
        }

        function updateChartsFromData(events) {
            updateDonutChart(events);
            updateLineChart();
            updateAttendanceChart();
            updateProjectsChart();
        }

        function updateDonutChart(events) {
            const estados = {
                'programado': 0,
                'en_curso': 0,
                'finalizado': 0,
                'cancelado': 0
            };

            events.forEach(event => {
                const estado = event.extendedProps?.estado || event.estado || 'programado';
                if (estados.hasOwnProperty(estado)) {
                    estados[estado]++;
                }
            });

            const data = [estados.programado, estados.en_curso, estados.finalizado, estados.cancelado];
            const labels = ['Programado', 'En Curso', 'Finalizado', 'Cancelado'];
            const colors = ['#2563eb', '#10b981', '#64748b', '#ef4444'];

            if (donutChart) {
                donutChart.data.datasets[0].data = data;
                donutChart.update();
            } else {
                initDonutChart(data, labels, colors);
            }

            createDonutLegend(data, labels, colors);
        }

        function initDonutChart(data, labels, colors) {
            const ctx = document.getElementById('donutChart').getContext('2d');
            
            donutChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: colors,
                        borderWidth: 0,
                        hoverBorderWidth: 2,
                        hoverBorderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label;
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '70%',
                    animation: {
                        animateRotate: true,
                        duration: 1000
                    }
                }
            });
        }

        function createDonutLegend(data, labels, colors) {
            const legendContainer = document.getElementById('donut-legend');
            legendContainer.innerHTML = '';

            labels.forEach((label, index) => {
                const legendItem = document.createElement('div');
                legendItem.className = 'legend-item';
                
                const total = data.reduce((a, b) => a + b, 0);
                const value = data[index];
                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                
                legendItem.innerHTML = `
                    <div class="legend-color" style="background-color: ${colors[index]}"></div>
                    <span>${label}: ${value} (${percentage}%)</span>
                `;
                
                legendContainer.appendChild(legendItem);
            });
        }

        function initializeCharts() {
            initLineChart();
            initAttendanceChart();
            initProjectsChart();
        }

        function initLineChart() {
            const ctx = document.getElementById('lineChart').getContext('2d');
            
            lineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Eventos por mes',
                        data: [],
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#2563eb',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return `Eventos: ${context.parsed.y}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeInOutQuart'
                    }
                }
            });
        }

        function updateLineChart() {
            if (!lineChart) return;
            
            const months = [];
            const eventCounts = [];
            const now = new Date();
            
            for (let i = 5; i >= 0; i--) {
                const date = new Date(now.getFullYear(), now.getMonth() - i, 1);
                const monthName = date.toLocaleDateString('es-ES', { month: 'short' });
                months.push(monthName.charAt(0).toUpperCase() + monthName.slice(1));
                
                const monthEvents = eventsData.filter(event => {
                    const eventDate = new Date(event.start || event.fecha_inicio);
                    return eventDate.getMonth() === date.getMonth() && 
                           eventDate.getFullYear() === date.getFullYear();
                });
                eventCounts.push(monthEvents.length);
            }
            
            lineChart.data.labels = months;
            lineChart.data.datasets[0].data = eventCounts;
            lineChart.update();
        }

        function initAttendanceChart() {
            const ctx = document.getElementById('attendanceChart').getContext('2d');
            
            attendanceChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Presentes',
                        data: [],
                        backgroundColor: '#10b981',
                        borderWidth: 0
                    },
                    {
                        label: 'Ausentes',
                        data: [],
                        backgroundColor: '#ef4444',
                        borderWidth: 0
                    },
                    {
                        label: 'Justificados',
                        data: [],
                        backgroundColor: '#06b6d4',
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        x: {
                            stacked: false,
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            stacked: false,
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        function updateAttendanceChart() {
            if (!attendanceChart) {
                initAttendanceChart();
            }
            
            const meetingEvents = eventsData.filter(e => {
                const tipo = e.extendedProps?.tipo_evento || '';
                return tipo === 'reunion-virtual' || tipo === 'reunion-presencial';
            });
            
            if (meetingEvents.length === 0) {
                attendanceChart.data.labels = ['Sin datos'];
                attendanceChart.data.datasets[0].data = [0];
                attendanceChart.data.datasets[1].data = [0];
                attendanceChart.data.datasets[2].data = [0];
                attendanceChart.update();
                return;
            }
            
            const labels = [];
            const presentes = [];
            const ausentes = [];
            const justificados = [];
            
            meetingEvents.forEach(event => {
                const titulo = (event.title || event.titulo || 'Sin título').substring(0, 20);
                labels.push(titulo);
                
                const eventAttendance = attendanceData.filter(att => att.event_id == event.id);
                
                const presentCount = eventAttendance.filter(att => att.status === 'presente').length;
                const absentCount = eventAttendance.filter(att => att.status === 'ausente').length;
                const justifiedCount = eventAttendance.filter(att => att.status === 'justificado').length;
                
                presentes.push(presentCount);
                ausentes.push(absentCount);
                justificados.push(justifiedCount);
            });
            
            attendanceChart.data.labels = labels;
            attendanceChart.data.datasets[0].data = presentes;
            attendanceChart.data.datasets[1].data = ausentes;
            attendanceChart.data.datasets[2].data = justificados;
            attendanceChart.update();
        }

        function initProjectsChart() {
            const ctx = document.getElementById('projectsChart').getContext('2d');
            
            projectsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Participantes',
                        data: [],
                        backgroundColor: '#8b5cf6',
                        borderWidth: 0
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Participantes: ${context.parsed.x}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                stepSize: 1
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        function updateProjectsChart() {
            if (!projectsChart) {
                initProjectsChart();
            }
            
            const projectEvents = eventsData.filter(e => {
                const tipo = e.extendedProps?.tipo_evento || '';
                return tipo === 'inicio-proyecto' || tipo === 'finalizar-proyecto';
            });
            
            if (projectEvents.length === 0) {
                projectsChart.data.labels = ['Sin proyectos'];
                projectsChart.data.datasets[0].data = [0];
                projectsChart.update();
                return;
            }
            
            const labels = [];
            const participantCounts = [];
            
            projectEvents.forEach(event => {
                const titulo = (event.title || event.titulo || 'Sin título').substring(0, 30);
                const tipo = event.extendedProps?.tipo_evento || '';
                const icono = tipo === 'inicio-proyecto' ? '🚀' : '🎯';
                
                labels.push(`${icono} ${titulo}`);
                
                const projectParticipants = attendanceData.filter(att => att.event_id == event.id);
                participantCounts.push(projectParticipants.length);
            });
            
            projectsChart.data.labels = labels;
            projectsChart.data.datasets[0].data = participantCounts;
            projectsChart.update();
        }

        function refreshData() {
            showToast('Actualizando datos...', 'info');
            loadData();
            showToast('Datos actualizados correctamente', 'success');
        }

        // FUNCIÓN GENERAR REPORTE - COMPLETAMENTE FUNCIONAL
        function generateReport() {
            Swal.fire({
                title: 'Generar Reporte Personalizado',
                html: `
                    <div style="text-align: left; max-width: 400px; margin: 0 auto;">
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Tipo de Reporte:</label>
                            <select id="report-type" class="swal2-select" style="width: 100%;">
                                <option value="summary">Resumen Ejecutivo</option>
                                <option value="detailed">Análisis Detallado</option>
                                <option value="attendance">Reporte de Asistencias</option>
                                <option value="trends">Análisis de Tendencias</option>
                            </select>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Formato:</label>
                            <select id="report-format" class="swal2-select" style="width: 100%;">
                                <option value="pdf">PDF</option>
                                <option value="excel">Excel (CSV)</option>
                                <option value="html">HTML</option>
                            </select>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Incluir:</label>
                            <div style="text-align: left;">
                                <label><input type="checkbox" id="include-stats" checked> Estadísticas</label><br>
                                <label><input type="checkbox" id="include-events" checked> Lista de Eventos</label><br>
                                <label><input type="checkbox" id="include-attendance" checked> Datos de Asistencia</label><br>
                                <label><input type="checkbox" id="include-charts"> Gráficos (solo HTML)</label>
                            </div>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Generar Reporte',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#10b981',
                preConfirm: () => {
                    return {
                        type: document.getElementById('report-type').value,
                        format: document.getElementById('report-format').value,
                        includeStats: document.getElementById('include-stats').checked,
                        includeEvents: document.getElementById('include-events').checked,
                        includeAttendance: document.getElementById('include-attendance').checked,
                        includeCharts: document.getElementById('include-charts').checked
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    generateCustomReport(result.value);
                }
            });
        }

        function generateCustomReport(options) {
            Swal.fire({
                title: 'Generando reporte...',
                html: `
                    <div style="text-align: center; padding: 20px;">
                        <div style="width: 48px; height: 48px; border: 4px solid #f3f4f6; border-top: 4px solid #2563eb; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 16px;"></div>
                        <p>Procesando ${eventsData.length} eventos y ${attendanceData.length} asistencias...</p>
                    </div>
                    <style>
                        @keyframes spin {
                            0% { transform: rotate(0deg); }
                            100% { transform: rotate(360deg); }
                        }
                    </style>
                `,
                showConfirmButton: false,
                allowOutsideClick: false
            });

            setTimeout(() => {
                const reportData = collectReportData();
                
                switch(options.format) {
                    case 'pdf':
                        generatePDFReport(reportData, options);
                        break;
                    case 'excel':
                        generateExcelReport(reportData, options);
                        break;
                    case 'html':
                        generateHTMLReport(reportData, options);
                        break;
                }
            }, 1500);
        }

        function collectReportData() {
            const now = new Date();
            
            const totalEventos = eventsData.length;
            const finalizados = eventsData.filter(e => {
                const estado = e.extendedProps?.estado || e.estado || '';
                return estado === 'finalizado';
            }).length;
            
            const programados = eventsData.filter(e => {
                const estado = e.extendedProps?.estado || e.estado || 'programado';
                return estado === 'programado';
            }).length;
            
            const enCurso = eventsData.filter(e => {
                const estado = e.extendedProps?.estado || e.estado || '';
                return estado === 'en_curso';
            }).length;
            
            const cancelados = eventsData.filter(e => {
                const estado = e.extendedProps?.estado || e.estado || '';
                return estado === 'cancelado';
            }).length;
            
            const totalAsistencias = attendanceData.length;
            const presentes = attendanceData.filter(a => a.status === 'presente').length;
            const ausentes = attendanceData.filter(a => a.status === 'ausente').length;
            const justificados = attendanceData.filter(a => a.status === 'justificado').length;
            
            const tasaAsistencia = totalAsistencias > 0 ? Math.round((presentes / totalAsistencias) * 100) : 0;
            
            return {
                fecha: now.toLocaleDateString('es-ES', { year: 'numeric', month: 'long', day: 'numeric' }),
                hora: now.toLocaleTimeString('es-ES'),
                estadisticas: {
                    totalEventos,
                    finalizados,
                    programados,
                    enCurso,
                    cancelados,
                    totalAsistencias,
                    presentes,
                    ausentes,
                    justificados,
                    tasaAsistencia
                },
                eventos: eventsData,
                asistencias: attendanceData
            };
        }

        function generatePDFReport(data, options) {
            const html = generateReportHTML(data, options, true);
            
            const printWindow = window.open('', '_blank');
            printWindow.document.write(html);
            printWindow.document.close();
            
            printWindow.onload = function() {
                printWindow.print();
                
                Swal.fire({
                    title: 'Reporte generado',
                    html: `
                        <div style="text-align: center; margin: 20px 0;">
                            <i class="fas fa-file-pdf" style="font-size: 3rem; color: #ef4444; margin-bottom: 16px;"></i>
                            <h4>Reporte PDF</h4>
                            <p>Se abrió la ventana de impresión. Guarda como PDF seleccionando "Guardar como PDF" en el destino.</p>
                            <div style="background: #f1f5f9; padding: 15px; border-radius: 8px; margin: 20px 0; text-align: left;">
                                <p style="margin: 5px 0;"><strong>Total Eventos:</strong> ${data.estadisticas.totalEventos}</p>
                                <p style="margin: 5px 0;"><strong>Finalizados:</strong> ${data.estadisticas.finalizados}</p>
                                <p style="margin: 5px 0;"><strong>Asistencias:</strong> ${data.estadisticas.totalAsistencias}</p>
                                <p style="margin: 5px 0;"><strong>Tasa Asistencia:</strong> ${data.estadisticas.tasaAsistencia}%</p>
                            </div>
                        </div>
                    `,
                    icon: 'success',
                    confirmButtonText: 'Cerrar',
                    confirmButtonColor: '#10b981'
                });
            };
        }

        function generateExcelReport(data, options) {
            let csvContent = "data:text/csv;charset=utf-8,";
            
            csvContent += `Reporte Vocero - ${data.fecha}\n\n`;
            
            if (options.includeStats) {
                csvContent += "ESTADISTICAS GENERALES\n";
                csvContent += `Total Eventos,${data.estadisticas.totalEventos}\n`;
                csvContent += `Programados,${data.estadisticas.programados}\n`;
                csvContent += `En Curso,${data.estadisticas.enCurso}\n`;
                csvContent += `Finalizados,${data.estadisticas.finalizados}\n`;
                csvContent += `Cancelados,${data.estadisticas.cancelados}\n`;
                csvContent += `Total Asistencias,${data.estadisticas.totalAsistencias}\n`;
                csvContent += `Presentes,${data.estadisticas.presentes}\n`;
                csvContent += `Ausentes,${data.estadisticas.ausentes}\n`;
                csvContent += `Justificados,${data.estadisticas.justificados}\n`;
                csvContent += `Tasa de Asistencia,${data.estadisticas.tasaAsistencia}%\n\n`;
            }
            
            if (options.includeEvents && data.eventos.length > 0) {
                csvContent += "LISTA DE EVENTOS\n";
                csvContent += "Titulo,Fecha Inicio,Fecha Fin,Organizador,Tipo,Estado\n";
                
                data.eventos.forEach(event => {
                    const titulo = (event.title || event.titulo || '').replace(/,/g, ';');
                    const fechaInicio = new Date(event.start || event.fecha_inicio).toLocaleString('es-ES');
                    const fechaFin = new Date(event.end || event.fecha_fin).toLocaleString('es-ES');
                    const organizador = (event.extendedProps?.organizador || 'No especificado').replace(/,/g, ';');
                    const tipo = getCategoryName(event.extendedProps?.tipo_evento || '');
                    const estado = getStatusName(event.extendedProps?.estado || 'programado');
                    
                    csvContent += `${titulo},${fechaInicio},${fechaFin},${organizador},${tipo},${estado}\n`;
                });
                csvContent += "\n";
            }
            
            if (options.includeAttendance && data.asistencias.length > 0) {
                csvContent += "REGISTRO DE ASISTENCIAS\n";
                csvContent += "Evento ID,Participante,Email,Estado,Hora Llegada,Observaciones\n";
                
                data.asistencias.forEach(att => {
                    const participante = (att.participant_name || '').replace(/,/g, ';');
                    const email = att.participant_email || '';
                    const estado = att.status || '';
                    const horaLlegada = att.arrival_time || '';
                    const observaciones = (att.notes || '').replace(/,/g, ';');
                    
                    csvContent += `${att.event_id},${participante},${email},${estado},${horaLlegada},${observaciones}\n`;
                });
            }
            
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `Reporte_Vocero_${new Date().toISOString().split('T')[0]}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            Swal.fire({
                title: 'Reporte Excel generado',
                text: 'El archivo CSV ha sido descargado. Puedes abrirlo con Excel.',
                icon: 'success',
                confirmButtonText: 'Cerrar',
                confirmButtonColor: '#10b981'
            });
        }

        function generateHTMLReport(data, options) {
            const html = generateReportHTML(data, options, false);
            
            const reportWindow = window.open('', '_blank');
            reportWindow.document.write(html);
            reportWindow.document.close();
            
            showToast('Reporte HTML generado en nueva ventana', 'success');
        }

        function generateReportHTML(data, options, forPrint) {
            let html = `
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Vocero - ${data.fecha}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: white;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2563eb;
            margin: 0;
        }
        .header p {
            color: #64748b;
            margin: 5px 0;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #1e293b;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .stat-card {
            background: #f8fafc;
            border-left: 4px solid #2563eb;
            padding: 15px;
            border-radius: 4px;
        }
        .stat-card h3 {
            margin: 0 0 5px 0;
            font-size: 2em;
            color: #2563eb;
        }
        .stat-card p {
            margin: 0;
            color: #64748b;
            font-size: 0.9em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th {
            background: #2563eb;
            color: white;
            padding: 12px;
            text-align: left;
        }
        table td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        table tr:hover {
            background: #f8fafc;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85em;
            font-weight: 500;
        }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fed7aa; color: #92400e; }
        .badge-danger { background: #fecaca; color: #991b1b; }
        .badge-info { background: #bfdbfe; color: #1e40af; }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e2e8f0;
            color: #64748b;
            font-size: 0.9em;
        }
        ${forPrint ? '@media print { body { padding: 0; } }' : ''}
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte Vocero</h1>
        <p>Generado el ${data.fecha} a las ${data.hora}</p>
    </div>
    `;
            
            if (options.includeStats) {
                html += `
    <div class="section">
        <h2>Estadísticas Generales</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <h3>${data.estadisticas.totalEventos}</h3>
                <p>Total Eventos</p>
            </div>
            <div class="stat-card">
                <h3>${data.estadisticas.finalizados}</h3>
                <p>Eventos Finalizados</p>
            </div>
            <div class="stat-card">
                <h3>${data.estadisticas.totalAsistencias}</h3>
                <p>Total Asistencias</p>
            </div>
            <div class="stat-card">
                <h3>${data.estadisticas.tasaAsistencia}%</h3>
                <p>Tasa de Asistencia</p>
            </div>
        </div>
    </div>
                `;
            }
            
            if (options.includeEvents && data.eventos.length > 0) {
                html += `
    <div class="section">
        <h2>Lista de Eventos (${data.eventos.length})</h2>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Fecha</th>
                    <th>Organizador</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                `;
                
                data.eventos.forEach(event => {
                    const titulo = event.title || event.titulo || 'Sin título';
                    const fecha = new Date(event.start || event.fecha_inicio).toLocaleDateString('es-ES');
                    const organizador = event.extendedProps?.organizador || 'No especificado';
                    const tipo = getCategoryName(event.extendedProps?.tipo_evento || '');
                    const estado = getStatusName(event.extendedProps?.estado || 'programado');
                    
                    html += `
                <tr>
                    <td><strong>${titulo}</strong></td>
                    <td>${fecha}</td>
                    <td>${organizador}</td>
                    <td>${tipo}</td>
                    <td><span class="badge badge-info">${estado}</span></td>
                </tr>
                    `;
                });
                
                html += `
            </tbody>
        </table>
    </div>
                `;
            }
            
            if (options.includeAttendance && data.asistencias.length > 0) {
                html += `
    <div class="section">
        <h2>Registro de Asistencias (${data.asistencias.length})</h2>
        <table>
            <thead>
                <tr>
                    <th>Participante</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Hora Llegada</th>
                </tr>
            </thead>
            <tbody>
                `;
                
                data.asistencias.forEach(att => {
                    const badgeClass = att.status === 'presente' ? 'badge-success' : 
                                       att.status === 'ausente' ? 'badge-danger' : 'badge-info';
                    
                    html += `
                <tr>
                    <td>${att.participant_name}</td>
                    <td>${att.participant_email}</td>
                    <td><span class="badge ${badgeClass}">${att.status}</span></td>
                    <td>${att.arrival_time || '-'}</td>
                </tr>
                    `;
                });
                
                html += `
            </tbody>
        </table>
    </div>
                `;
            }
            
            html += `
    <div class="footer">
        <p>Reporte generado por Sistema Vocero</p>
        <p>${data.fecha} - ${data.hora}</p>
    </div>
</body>
</html>
            `;
            
            return html;
        }

        function exportChart(chartType) {
            let chart, chartName;
            
            switch(chartType) {
                case 'donut':
                    chart = donutChart;
                    chartName = 'Estados_Eventos';
                    break;
                case 'line':
                    chart = lineChart;
                    chartName = 'Tendencia_Eventos';
                    break;
                case 'attendance':
                    chart = attendanceChart;
                    chartName = 'Asistencias_Reuniones';
                    break;
                case 'projects':
                    chart = projectsChart;
                    chartName = 'Participacion_Proyectos';
                    break;
                default:
                    showToast('Gráfico no válido', 'error');
                    return;
            }
            
            if (!chart) {
                showToast('Gráfico no disponible para exportar', 'warning');
                return;
            }
            
            const url = chart.toBase64Image();
            const link = document.createElement('a');
            link.download = `${chartName}_${new Date().toISOString().split('T')[0]}.png`;
            link.href = url;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            showToast('Gráfico descargado como PNG', 'success');
        }

        function getCategoryName(category) {
            const mapping = {
                'reunion-virtual': 'Reunión Virtual',
                'reunion-presencial': 'Reunión Presencial',
                'inicio-proyecto': 'Inicio de Proyecto',
                'finalizar-proyecto': 'Fin de Proyecto',
                'cumpleanos': 'Cumpleaños'
            };
            return mapping[category] || 'Sin categoría';
        }

        function getStatusName(status) {
            const mapping = {
                'programado': 'Programado',
                'en_curso': 'En Curso',
                'finalizado': 'Finalizado',
                'cancelado': 'Cancelado'
            };
            return mapping[status] || 'Sin estado';
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