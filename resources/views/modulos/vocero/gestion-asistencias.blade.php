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
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
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
        }

        .badge {
            font-size: 0.85em;
            padding: 6px 12px;
        }

        .badge-success {
            background-color: var(--success-color);
        }

        .badge-danger {
            background-color: var(--danger-color);
        }

        .badge-info {
            background-color: var(--info-color);
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
                <a class="nav-link" href="{{ route('vocero.index') }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a class="nav-link" href="{{ route('vocero.calendario') }}">
                    <i class="fas fa-calendar"></i> Calendario
                </a>
                <a class="nav-link" href="{{ route('vocero.eventos') }}">
                    <i class="fas fa-calendar-plus"></i> Gestión de Eventos
                </a>
                <a class="nav-link active" href="{{ route('vocero.asistencias') }}">
                    <i class="fas fa-users"></i> Asistencias
                </a>
                <a class="nav-link" href="{{ route('vocero.reportes') }}">
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

                <!-- Stats Cards (sin cambios) -->
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

                <!-- Event Selector Card (sin cambios) -->
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

                <!-- Attendance Table (sin cambios) -->
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
                                    <th>Observaciones</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="attendance-tbody">
                                <tr>
                                    <td colspan="6" class="no-data">
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

    <!-- Modal (sin cambios en el código del modal) -->
    <div class="modal fade" id="attendanceModal" tabindex="-1">
        <!-- ... (mantén todo el código del modal igual) ... -->
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.all.min.js"></script>

    <!-- Todo el JavaScript permanece igual -->
    <script>
        // ... (mantén todo el código JavaScript sin cambios) ...
    </script>
</body>
</html>