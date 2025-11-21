<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Macero - Reportes y Análisis</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --info-color: #06b6d4;
            --purple-color: #8b5cf6;
            --sidebar-bg: #1e293b;
            --sidebar-text: #e2e8f0;
            --light-bg: #f8fafc;
            --dark-color: #1e293b;
            --border-color: #e2e8f0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: #f1f5f9;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* SIDEBAR MODERNIZADO */
        .sidebar {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: #cbd5e1;
            border-radius: 12px;
            margin: 6px 16px;
            padding: 14px 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 14px;
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }

        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background: rgba(59, 130, 246, 0.15);
            color: #93c5fd;
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }

        .sidebar .nav-link:hover::before {
            transform: scaleY(1);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(37, 99, 235, 0.25) 100%);
            color: white;
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.3);
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .sidebar .nav-link.active::before {
            transform: scaleY(1);
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover i,
        .sidebar .nav-link.active i {
            transform: scale(1.1);
            filter: drop-shadow(0 2px 4px rgba(59, 130, 246, 0.4));
        }

        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 2px solid rgba(59, 130, 246, 0.2);
            margin-bottom: 16px;
            text-align: center;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(10px);
        }

        .sidebar-brand h4 {
            color: white;
            margin: 0;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-size: 1.75rem;
            letter-spacing: -0.5px;
        }

        .sidebar-brand h4 i {
            color: #3b82f6;
            filter: drop-shadow(0 2px 4px rgba(59, 130, 246, 0.4));
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            padding: 0;
            width: calc(100% - 250px);
            max-width: calc(100% - 250px);
            overflow-x: hidden;
        }

        .content-wrapper {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin: 24px;
            padding: 32px;
            max-width: 100%;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.06);
            margin-bottom: 24px;
            max-width: 100%;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border-radius: 16px;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-number {
            transform: scale(1.05);
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--secondary-color);
            margin-top: 8px;
            font-weight: 600;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
            max-width: 100%;
        }

        .chart-container.large {
            height: 400px;
        }

        .chart-scroll-container {
            overflow-x: auto;
            overflow-y: hidden;
            width: 100%;
            position: relative;
        }

        .chart-scroll-container::-webkit-scrollbar {
            height: 8px;
        }

        .chart-scroll-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .chart-scroll-container::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }

        .chart-scroll-container::-webkit-scrollbar-thumb:hover {
            background: #1d4ed8;
        }

        .chart-inner-container {
            min-width: 100%;
            position: relative;
            height: 400px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1d4ed8 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e3a8a 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #047857 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(5, 150, 105, 0.3);
        }

        .btn-outline-secondary {
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .btn-outline-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(100, 116, 139, 0.2);
        }

        .btn-info, .btn-sm {
            transition: all 0.2s ease;
        }

        .btn-info:hover, .btn-sm:hover {
            transform: scale(1.1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
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

        .card {
            animation: fadeIn 0.5s ease-out;
        }

        .stat-card {
            animation: slideIn 0.6s ease-out;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }

        .loading-spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 4px solid rgba(37, 99, 235, 0.2);
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: var(--secondary-color);
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(37, 99, 235, 0.05);
            transform: scale(1.005);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .progress {
            transition: all 0.3s ease;
            height: 20px;
            border-radius: 10px;
        }

        .progress:hover {
            transform: scaleY(1.1);
        }

        .card-header {
            border-bottom: 2px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .card:hover .card-header {
            border-bottom-color: var(--primary-color);
        }

        @media (max-width: 991.98px) {
            .sidebar {
                position: relative;
                width: 100%;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                max-width: 100%;
            }
        }

        * {
            max-width: 100%;
        }

        canvas {
            max-width: 100% !important;
            height: auto !important;
        }

        .chart-container canvas {
            cursor: pointer;
        }

        .chart-container canvas:hover {
            opacity: 0.9;
        }

        #filtro-activo-badge {
            animation: fadeIn 0.3s ease-in;
        }

        .table {
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead th {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #475569;
            border: none;
            padding: 16px;
        }

        .table tbody td {
            padding: 16px;
            vertical-align: middle;
        }

        .badge {
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.75rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid" style="overflow-x: hidden;">
        <div class="sidebar">
            <div class="sidebar-brand">
                <h4>
                    <i class="fas fa-calendar-alt"></i>
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
                <!-- HEADER -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2><i class="fas fa-chart-bar me-2"></i>Reportes y Análisis</h2>
                        <p class="text-muted mb-0">Visualiza estadísticas y genera reportes detallados</p>
                    </div>
                    <div>
                        <button class="btn btn-outline-secondary" onclick="refreshData()">
                            <i class="fas fa-sync-alt me-2"></i>Actualizar
                        </button>
                        <button class="btn btn-success" onclick="exportarReporteCompletoPDF()">
                            <i class="fas fa-download me-2"></i>Exportar PDF
                        </button>
                    </div>
                </div>

                <!-- ESTADÍSTICAS GENERALES -->
                <div class="row mb-4" id="stats-container">
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-calendar-alt fa-2x text-primary mb-3" style="animation: pulse 2s infinite;"></i>
                                <h3 class="stat-number" id="total-eventos">0</h3>
                                <p class="stat-label">Total Eventos</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-check-circle fa-2x text-success mb-3" style="animation: pulse 2s infinite 0.2s;"></i>
                                <h3 class="stat-number text-success" id="eventos-finalizados">0</h3>
                                <p class="stat-label">Finalizados</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-2x text-info mb-3" style="animation: pulse 2s infinite 0.4s;"></i>
                                <h3 class="stat-number text-info" id="total-asistencias">0</h3>
                                <p class="stat-label">Total Asistencias</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="fas fa-percentage fa-2x text-warning mb-3" style="animation: pulse 2s infinite 0.6s;"></i>
                                <h3 class="stat-number text-warning" id="tasa-asistencia">0%</h3>
                                <p class="stat-label">Tasa de Asistencia</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GRÁFICOS -->
                <div class="row mb-4">
                    <!-- Gráfico de Estados de Eventos -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-pie-chart me-2"></i>Estados de Eventos
                                    <i class="fas fa-info-circle text-muted ms-2" style="font-size: 0.9rem; cursor: help;" 
                                       title="Haz clic en una sección para filtrar eventos"></i>
                                </h5>
                            </div>
                            <div class="card-body" style="cursor: pointer;">
                                <div class="chart-container">
                                    <canvas id="estadosChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gráfico de Tipos de Eventos -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-chart-bar me-2"></i>Tipos de Eventos
                                    <i class="fas fa-info-circle text-muted ms-2" style="font-size: 0.9rem; cursor: help;" 
                                       title="Haz clic en una barra para filtrar eventos"></i>
                                </h5>
                            </div>
                            <div class="card-body" style="cursor: pointer;">
                                <div class="chart-container">
                                    <canvas id="tiposChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Tendencia -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-chart-line me-2"></i>Tendencia de Eventos
                                    <i class="fas fa-info-circle text-muted ms-2" style="font-size: 0.9rem; cursor: help;" 
                                       title="Haz clic en un punto para filtrar eventos de ese mes"></i>
                                </h5>
                            </div>
                            <div class="card-body" style="cursor: pointer;">
                                <div class="chart-container large">
                                    <canvas id="tendenciaChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Asistencias -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="fas fa-user-check me-2"></i>Estadísticas de Asistencia por Evento</h5>
                                <small class="text-muted" id="asistencias-subtitle">Todos los eventos con asistencias registradas</small>
                            </div>
                            <div class="card-body">
                                <div class="chart-scroll-container">
                                    <div class="chart-inner-container" id="asistencias-chart-wrapper">
                                        <canvas id="asistenciasChart"></canvas>
                                    </div>
                                </div>
                                <div id="no-asistencias-message" class="no-data" style="display: none;">
                                    <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                                    <h5>No hay datos de asistencias registradas</h5>
                                    <p>Los eventos deben tener asistencias registradas para mostrar estadísticas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Eventos Detallados -->
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0"><i class="fas fa-table me-2"></i>Eventos Detallados</h5>
                            <span id="filtro-activo-badge" class="badge bg-info ms-3" style="display: none;"></span>
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-sm btn-primary" onclick="exportarTablaPDF()">
                                <i class="fas fa-file-pdf me-1"></i>Exportar Tabla PDF
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="eventos-table">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                        <th>Asistencias</th>
                                        <th>% Asistencia</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="eventos-tbody">
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="loading-spinner mx-auto mb-3"></div>
                                            <h5 class="text-muted">Cargando datos...</h5>
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

    <!-- Modal Ver Detalle Evento -->
    <div class="modal fade" id="detalleEventoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Detalle del Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detalle-evento-content">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-3">Cargando detalles...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.all.min.js"></script>

    <script>
        // [JavaScript completo del documento original - se mantiene intacto por funcionalidad]
        let estadosChart, tiposChart, tendenciaChart, asistenciasChart;
        let eventosDetallados = [];

        $(document).ready(function() {
            cargarDatos();
        });

        function cargarDatos() {
            console.log('🔄 Iniciando carga de datos...');
            
            $.ajax({
                url: '/api/calendario/reportes/detallado',
                method: 'GET',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    if (response.success && response.eventos) {
                        eventosDetallados = response.eventos;
                        
                        let totalAsistencias = 0;
                        let totalPresentes = 0;
                        
                        eventosDetallados.forEach(evento => {
                            const registros = parseInt(evento.TotalRegistros || evento.TotalAsistencias || 0);
                            const presentes = parseInt(evento.TotalPresentes || 0);
                            
                            totalAsistencias += registros;
                            totalPresentes += presentes;
                        });
                        
                        const tasaAsistencia = totalAsistencias > 0 ? 
                            Math.round((totalPresentes / totalAsistencias) * 100) : 0;
                        
                        $('#total-asistencias').text(totalAsistencias);
                        $('#tasa-asistencia').text(tasaAsistencia + '%');
                        
                        mostrarEventosDetallados(eventosDetallados);
                    }
                },
                error: function(xhr) {
                    console.error('❌ Error cargando eventos:', xhr);
                }
            });
            
            $.ajax({
                url: '/api/calendario/reportes/estadisticas-generales',
                method: 'GET',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    if (response.success && response.estadisticas) {
                        const stats = response.estadisticas;
                        $('#total-eventos').text(stats.TotalEventos || 0);
                        $('#eventos-finalizados').text(stats.TotalFinalizados || 0);
                    }
                }
            });
            
            $.ajax({
                url: '/api/calendario/reportes/graficos',
                method: 'GET',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    if (response.success && response.graficos) {
                        crearGraficos(response.graficos);
                    }
                }
            });
        }

        function crearGraficos(datos) {
            if (estadosChart) estadosChart.destroy();
            if (tiposChart) tiposChart.destroy();
            if (tendenciaChart) tendenciaChart.destroy();
            if (asistenciasChart) asistenciasChart.destroy();

            const ctxEstados = document.getElementById('estadosChart').getContext('2d');
            estadosChart = new Chart(ctxEstados, {
                type: 'doughnut',
                data: {
                    labels: ['Programados', 'En Curso', 'Finalizados'],
                    datasets: [{
                        data: [
                            datos.estados.programados,
                            datos.estados.en_curso,
                            datos.estados.finalizados
                        ],
                        backgroundColor: ['#f59e0b', '#06b6d4', '#059669'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    },
                    onClick: function(evt, activeElements) {
                        if (activeElements.length > 0) {
                            const index = activeElements[0].index;
                            const estados = ['Programado', 'EnCurso', 'Finalizado'];
                            filtrarEventosPorEstado(estados[index]);
                        }
                    }
                }
            });

            const ctxTipos = document.getElementById('tiposChart').getContext('2d');
            tiposChart = new Chart(ctxTipos, {
                type: 'bar',
                data: {
                    labels: ['Virtual', 'Presencial', 'Inicio Proyecto', 'Fin Proyecto', 'Otros'],
                    datasets: [{
                        label: 'Cantidad de Eventos',
                        data: [
                            datos.tipos.virtual,
                            datos.tipos.presencial,
                            datos.tipos.inicio_proyecto,
                            datos.tipos.fin_proyecto,
                            datos.tipos.otros || 0
                        ],
                        backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    },
                    onClick: function(evt, activeElements) {
                        if (activeElements.length > 0) {
                            const index = activeElements[0].index;
                            const tipos = ['Virtual', 'Presencial', 'InicioProyecto', 'FinProyecto', 'Otros'];
                            filtrarEventosPorTipo(tipos[index]);
                        }
                    }
                }
            });

            const ctxTendencia = document.getElementById('tendenciaChart').getContext('2d');
            const meses = datos.tendencia.map(t => {
                const [year, month] = t.mes.split('-');
                const fecha = new Date(year, month - 1);
                return fecha.toLocaleDateString('es-ES', { month: 'short', year: 'numeric' });
            });
            const cantidades = datos.tendencia.map(t => t.cantidad);

            tendenciaChart = new Chart(ctxTendencia, {
                type: 'line',
                data: {
                    labels: meses,
                    datasets: [{
                        label: 'Eventos por Mes',
                        data: cantidades,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 6,
                        pointHoverRadius: 9,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    },
                    onClick: function(evt, activeElements) {
                        if (activeElements.length > 0) {
                            const index = activeElements[0].index;
                            const mesSeleccionado = datos.tendencia[index].mes;
                            filtrarEventosPorMes(mesSeleccionado);
                        }
                    }
                }
            });

            const ctxAsistencias = document.getElementById('asistenciasChart').getContext('2d');
            
            if (datos.asistencias && datos.asistencias.length > 0) {
                $('#asistenciasChart').show();
                $('#no-asistencias-message').hide();
                
                const todasAsistencias = datos.asistencias;
                const numEventos = todasAsistencias.length;
                
                const anchoMinimo = Math.max(100, numEventos * 80);
                document.getElementById('asistencias-chart-wrapper').style.minWidth = anchoMinimo + 'px';
                
                $('#asistencias-subtitle').text(`${numEventos} eventos con asistencias registradas`);
                
                const eventosLabels = todasAsistencias.map(a => 
                    a.titulo.length > 20 ? a.titulo.substring(0, 20) + '...' : a.titulo
                );
                const presentes = todasAsistencias.map(a => a.presentes);
                const ausentes = todasAsistencias.map(a => a.ausentes);
                const justificados = todasAsistencias.map(a => a.justificados);

                asistenciasChart = new Chart(ctxAsistencias, {
                    type: 'bar',
                    data: {
                        labels: eventosLabels,
                        datasets: [
                            {
                                label: 'Presentes',
                                data: presentes,
                                backgroundColor: '#059669',
                                borderRadius: 8
                            },
                            {
                                label: 'Ausentes',
                                data: ausentes,
                                backgroundColor: '#dc2626',
                                borderRadius: 8
                            },
                            {
                                label: 'Justificados',
                                data: justificados,
                                backgroundColor: '#06b6d4',
                                borderRadius: 8
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'top' },
                            tooltip: {
                                callbacks: {
                                    title: function(context) {
                                        const index = context[0].dataIndex;
                                        return todasAsistencias[index].titulo;
                                    },
                                    afterLabel: function(context) {
                                        const index = context.dataIndex;
                                        let porcentaje = parseFloat(todasAsistencias[index].porcentaje) || 0;
                                        return 'Asistencia: ' + porcentaje.toFixed(1) + '%';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                stacked: false,
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 45
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1 }
                            }
                        },
                        onClick: function(evt, activeElements) {
                            if (activeElements.length > 0) {
                                const index = activeElements[0].index;
                                const eventoId = todasAsistencias[index].calendario_id;
                                verDetalleEvento(eventoId);
                            }
                        }
                    }
                });
            } else {
                $('#asistenciasChart').hide();
                $('#no-asistencias-message').show();
            }
        }

        function mostrarEventosDetallados(eventos) {
            const tbody = $('#eventos-tbody');
            tbody.empty();

            if (eventos.length === 0) {
                tbody.html(`
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5>No hay eventos que coincidan con el filtro</h5>
                        </td>
                    </tr>
                `);
                return;
            }

            eventos.forEach(evento => {
                const fecha = new Date(evento.FechaInicio).toLocaleDateString('es-ES');
                const tipo = obtenerNombreTipo(evento.TipoEvento);
                const estado = obtenerNombreEstado(evento.EstadoEvento);
                
                let porcentaje = parseFloat(evento.PorcentajeAsistencia) || 0;
                if (isNaN(porcentaje)) porcentaje = 0;
                
                const badgeEstado = obtenerBadgeEstado(evento.EstadoEvento);
                
                const row = `
                    <tr>
                        <td><strong>${evento.TituloEvento}</strong></td>
                        <td>${tipo}</td>
                        <td>${badgeEstado}</td>
                        <td>${fecha}</td>
                        <td>${evento.TotalAsistencias || 0}</td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: ${porcentaje}%">${Math.round(porcentaje)}%</div>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="verDetalleEvento(${evento.CalendarioID})" title="Ver detalle">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        // ============================================================================
        // FUNCIONES DE EXPORTACIÓN PDF
        // ============================================================================
        
        async function exportarReporteCompletoPDF() {
            showToast('📄 Generando reporte PDF completo...', 'info');
            
            try {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();
                
                const fecha = new Date().toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
                const hora = new Date().toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
                
                // Título
                doc.setFontSize(18);
                doc.setFont(undefined, 'bold');
                doc.text('Reporte Completo de Eventos', 105, 20, { align: 'center' });
                
                doc.setFontSize(11);
                doc.setFont(undefined, 'normal');
                doc.text(`Fecha de generación: ${fecha} ${hora}`, 14, 35);
                
                // Estadísticas generales
                doc.setFontSize(14);
                doc.setFont(undefined, 'bold');
                doc.text('Estadísticas Generales', 14, 50);
                
                doc.setFontSize(10);
                doc.setFont(undefined, 'normal');
                doc.text(`Total de Eventos: ${$('#total-eventos').text()}`, 14, 60);
                doc.text(`Total de Asistencias: ${$('#total-asistencias').text()}`, 14, 67);
                doc.text(`Tasa de Asistencia: ${$('#tasa-asistencia').text()}`, 14, 74);
                
                // Tabla de eventos
                const tableData = eventosDetallados.map(evento => [
                    evento.TituloEvento,
                    obtenerNombreTipo(evento.TipoEvento),
                    obtenerNombreEstado(evento.EstadoEvento),
                    new Date(evento.FechaInicio).toLocaleDateString('es-ES'),
                    evento.TotalAsistencias || 0,
                    Math.round(parseFloat(evento.PorcentajeAsistencia) || 0) + '%'
                ]);
                
                doc.autoTable({
                    head: [['Título', 'Tipo', 'Estado', 'Fecha', 'Asistencias', '% Asist.']],
                    body: tableData,
                    startY: 85,
                    styles: { fontSize: 8, cellPadding: 2 },
                    headStyles: { fillColor: [37, 99, 235], textColor: 255, fontStyle: 'bold' },
                    alternateRowStyles: { fillColor: [245, 245, 245] },
                    margin: { top: 85, left: 14, right: 14 }
                });
                
                // Footer
                const pageCount = doc.internal.getNumberOfPages();
                for (let i = 1; i <= pageCount; i++) {
                    doc.setPage(i);
                    doc.setFontSize(8);
                    doc.setTextColor(128);
                    doc.text(
                        'Documento generado automáticamente por el Sistema de Gestión Rotaract',
                        105,
                        doc.internal.pageSize.height - 10,
                        { align: 'center' }
                    );
                    doc.text(
                        `Página ${i} de ${pageCount}`,
                        105,
                        doc.internal.pageSize.height - 5,
                        { align: 'center' }
                    );
                }
                
                const fileName = `reporte_completo_${new Date().toISOString().split('T')[0]}.pdf`;
                doc.save(fileName);
                
                showToast('✅ Reporte PDF descargado correctamente', 'success');
                
            } catch (error) {
                console.error('Error al generar PDF:', error);
                showToast('❌ Error al generar el PDF: ' + error.message, 'error');
            }
        }

        async function exportarTablaPDF() {
            showToast('📄 Generando PDF de tabla de eventos...', 'info');
            
            try {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();
                
                const fecha = new Date().toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
                const hora = new Date().toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
                
                // Título
                doc.setFontSize(18);
                doc.setFont(undefined, 'bold');
                doc.text('Tabla de Eventos Detallados', 105, 20, { align: 'center' });
                
                doc.setFontSize(11);
                doc.setFont(undefined, 'normal');
                doc.text(`Fecha de generación: ${fecha} ${hora}`, 14, 35);
                doc.text(`Total de eventos: ${eventosDetallados.length}`, 14, 42);
                
                // Tabla de eventos
                const tableData = eventosDetallados.map(evento => [
                    evento.TituloEvento,
                    obtenerNombreTipo(evento.TipoEvento),
                    obtenerNombreEstado(evento.EstadoEvento),
                    new Date(evento.FechaInicio).toLocaleDateString('es-ES'),
                    evento.TotalAsistencias || 0,
                    Math.round(parseFloat(evento.PorcentajeAsistencia) || 0) + '%'
                ]);
                
                doc.autoTable({
                    head: [['Título', 'Tipo', 'Estado', 'Fecha', 'Asistencias', '% Asist.']],
                    body: tableData,
                    startY: 55,
                    styles: { fontSize: 9, cellPadding: 3 },
                    headStyles: { fillColor: [37, 99, 235], textColor: 255, fontStyle: 'bold' },
                    alternateRowStyles: { fillColor: [245, 245, 245] },
                    margin: { top: 55, left: 14, right: 14 },
                    columnStyles: {
                        0: { cellWidth: 60 },
                        1: { cellWidth: 30 },
                        2: { cellWidth: 25 },
                        3: { cellWidth: 25 },
                        4: { cellWidth: 25 },
                        5: { cellWidth: 'auto' }
                    }
                });
                
                // Footer
                const pageCount = doc.internal.getNumberOfPages();
                for (let i = 1; i <= pageCount; i++) {
                    doc.setPage(i);
                    doc.setFontSize(8);
                    doc.setTextColor(128);
                    doc.text(
                        'Documento generado automáticamente por el Sistema de Gestión Rotaract',
                        105,
                        doc.internal.pageSize.height - 10,
                        { align: 'center' }
                    );
                    doc.text(
                        `Página ${i} de ${pageCount}`,
                        105,
                        doc.internal.pageSize.height - 5,
                        { align: 'center' }
                    );
                }
                
                const fileName = `tabla_eventos_${new Date().toISOString().split('T')[0]}.pdf`;
                doc.save(fileName);
                
                showToast('✅ Tabla PDF descargada correctamente', 'success');
                
            } catch (error) {
                console.error('Error al generar PDF:', error);
                showToast('❌ Error al generar el PDF: ' + error.message, 'error');
            }
        }

        // ============================================================================
        // FUNCIONES DE FILTRADO
        // ============================================================================
        
        function filtrarEventosPorEstado(estado) {
            console.log('🔍 Filtrando por estado:', estado);
            const eventosFiltrados = eventosDetallados.filter(e => e.EstadoEvento === estado);
            mostrarEventosDetallados(eventosFiltrados);
            agregarBotonLimpiarFiltro(`Estado: ${obtenerNombreEstado(estado)}`);
        }

        function filtrarEventosPorTipo(tipo) {
            console.log('🔍 Filtrando por tipo:', tipo);
            const eventosFiltrados = eventosDetallados.filter(e => e.TipoEvento === tipo);
            mostrarEventosDetallados(eventosFiltrados);
            agregarBotonLimpiarFiltro(`Tipo: ${obtenerNombreTipo(tipo)}`);
        }

        function filtrarEventosPorMes(mes) {
            console.log('🔍 Filtrando por mes:', mes);
            const [year, month] = mes.split('-');
            const eventosFiltrados = eventosDetallados.filter(e => {
                const fechaEvento = new Date(e.FechaInicio);
                return fechaEvento.getFullYear() == year && (fechaEvento.getMonth() + 1) == month;
            });
            
            const fecha = new Date(year, month - 1);
            const mesNombre = fecha.toLocaleDateString('es-ES', { month: 'long', year: 'numeric' });
            mostrarEventosDetallados(eventosFiltrados);
            agregarBotonLimpiarFiltro(`Mes: ${mesNombre}`);
        }

        function agregarBotonLimpiarFiltro(texto) {
            const badge = $('#filtro-activo-badge');
            badge.html(`<i class="fas fa-filter me-1"></i>${texto} <button class="btn btn-sm btn-link text-white p-0 ms-2" onclick="limpiarFiltro()" style="text-decoration: none;"><i class="fas fa-times"></i></button>`);
            badge.show();
        }

        function limpiarFiltro() {
            $('#filtro-activo-badge').hide();
            mostrarEventosDetallados(eventosDetallados);
        }

        // ============================================================================
        // FUNCIÓN VER DETALLE DE EVENTO
        // ============================================================================
        
        function verDetalleEvento(eventoId) {
            console.log('👁️ Ver detalle evento:', eventoId);
            
            // Mostrar modal
            const modal = new bootstrap.Modal(document.getElementById('detalleEventoModal'));
            modal.show();
            
            // Cargar detalles
            $.ajax({
                url: `/api/calendario/reportes/evento/${eventoId}`,
                method: 'GET',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    console.log('Respuesta del servidor:', response);
                    if (response.success && response.reporte) {
                        mostrarModalDetalle(response.reporte);
                    } else {
                        $('#detalle-evento-content').html(`
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                No se pudieron cargar los detalles del evento.
                            </div>
                        `);
                    }
                },
                error: function(xhr) {
                    console.error('Error cargando detalle:', xhr);
                    $('#detalle-evento-content').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-times-circle me-2"></i>
                            Error al cargar los detalles del evento: ${xhr.responseJSON?.mensaje || xhr.statusText}
                        </div>
                    `);
                }
            });
        }

        function mostrarModalDetalle(evento) {
            const fecha = new Date(evento.FechaInicio).toLocaleDateString('es-ES', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });
            
            const horaInicio = evento.HoraInicio ? evento.HoraInicio.substring(0, 5) : 'N/A';
            const horaFin = evento.HoraFin ? evento.HoraFin.substring(0, 5) : 'N/A';
            
            const porcentaje = Math.round(parseFloat(evento.PorcentajeAsistencia) || 0);
            
            const html = `
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-primary mb-3">${evento.TituloEvento}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-calendar me-2"></i>Fecha:</strong> ${fecha}</p>
                        <p><strong><i class="fas fa-clock me-2"></i>Horario:</strong> ${horaInicio} - ${horaFin}</p>
                        <p><strong><i class="fas fa-map-marker-alt me-2"></i>Ubicación:</strong> ${evento.Ubicacion || 'No especificada'}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-tag me-2"></i>Tipo:</strong> ${obtenerNombreTipo(evento.TipoEvento)}</p>
                        <p><strong><i class="fas fa-info-circle me-2"></i>Estado:</strong> ${obtenerBadgeEstado(evento.EstadoEvento)}</p>
                        <p><strong><i class="fas fa-users me-2"></i>Total Asistencias:</strong> ${evento.TotalRegistros || evento.TotalAsistencias || 0}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Estadísticas de Asistencia</h5>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="text-center p-3 bg-success bg-opacity-10 rounded">
                                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                    <h4 class="mb-0">${evento.TotalPresentes || 0}</h4>
                                    <small>Presentes</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-3 bg-danger bg-opacity-10 rounded">
                                    <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                                    <h4 class="mb-0">${evento.TotalAusentes || 0}</h4>
                                    <small>Ausentes</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-3 bg-info bg-opacity-10 rounded">
                                    <i class="fas fa-exclamation-circle fa-2x text-info mb-2"></i>
                                    <h4 class="mb-0">${evento.TotalJustificados || 0}</h4>
                                    <small>Justificados</small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <p class="mb-2"><strong>Porcentaje de Asistencia:</strong></p>
                            <div class="progress" style="height: 30px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: ${porcentaje}%; font-size: 16px;">
                                    ${porcentaje}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            $('#detalle-evento-content').html(html);
        }

        // ============================================================================
        // FUNCIÓN ACTUALIZAR DATOS
        // ============================================================================
        
        function refreshData() {
            showToast('🔄 Actualizando datos...', 'info');
            
            // Limpiar filtros
            $('#filtro-activo-badge').hide();
            
            // Recargar datos
            cargarDatos();
            
            showToast('✅ Datos actualizados correctamente', 'success');
        }

        // ============================================================================
        // FUNCIONES AUXILIARES
        // ============================================================================
        
        function obtenerNombreTipo(tipo) {
            const tipos = {
                'Virtual': 'Virtual',
                'Presencial': 'Presencial',
                'InicioProyecto': 'Inicio de Proyecto',
                'FinProyecto': 'Fin de Proyecto',
                'Otros': 'Otros'
            };
            return tipos[tipo] || tipo;
        }

        function obtenerNombreEstado(estado) {
            const estados = {
                'Programado': 'Programado',
                'EnCurso': 'En Curso',
                'Completado': 'Completado',
                'Cancelado': 'Cancelado'
            };
            return estados[estado] || estado;
        }

        function obtenerBadgeEstado(estado) {
            const badges = {
                'Programado': '<span class="badge bg-primary">Programado</span>',
                'EnCurso': '<span class="badge bg-warning">En Curso</span>',
                'Completado': '<span class="badge bg-success">Completado</span>',
                'Cancelado': '<span class="badge bg-danger">Cancelado</span>'
            };
            return badges[estado] || `<span class="badge bg-secondary">${estado}</span>`;
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