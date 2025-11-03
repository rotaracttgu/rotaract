<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vocero - Reportes y Análisis</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    
    <!-- 🆕 jsPDF para generar PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    
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
            --sidebar-text: #ecf0f1;
            --light-bg: #f8fafc;
            --dark-color: #1e293b;
            --border-color: #e2e8f0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
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
            overflow-y: auto;
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
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 24px;
            max-width: 100%;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            max-width: 100%;
        }

        .stat-card {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--secondary-color);
            margin-top: 8px;
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
            background: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-success {
            background: var(--success-color);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: #047857;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        }

        .btn-outline-secondary {
            border-radius: 8px;
            transition: all 0.3s ease;
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

        .stat-number {
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-number {
            transform: scale(1.1);
        }

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
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .progress {
            transition: all 0.3s ease;
        }

        .progress:hover {
            transform: scaleY(1.2);
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
    </style>
</head>
<body>
    <div class="container-fluid" style="overflow-x: hidden;">
        <div class="sidebar">
            <div class="sidebar-brand">
                <h4>
                    <i class="fas fa-calendar-alt text-primary"></i>
                    Vocero
                </h4>
            </div>

            <nav class="sidebar-nav">
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

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.all.min.js"></script>

    <script>
        let estadosChart, tiposChart, tendenciaChart, asistenciasChart;
        let eventosDetallados = [];

        $(document).ready(function() {
            cargarDatos();
        });

        function cargarDatos() {
            console.log('🔄 Iniciando carga de datos...');
            
            // CARGAR EVENTOS DETALLADOS
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
            
            // CARGAR ESTADÍSTICAS GENERALES
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
            
            // CARGAR GRÁFICOS
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

            // Gráfico de Estados
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

            // Gráfico de Tipos
            const ctxTipos = document.getElementById('tiposChart').getContext('2d');
            tiposChart = new Chart(ctxTipos, {
                type: 'bar',
                data: {
                    labels: ['Virtual', 'Presencial', 'Inicio Proyecto', 'Fin Proyecto'],
                    datasets: [{
                        label: 'Cantidad de Eventos',
                        data: [
                            datos.tipos.virtual,
                            datos.tipos.presencial,
                            datos.tipos.inicio_proyecto,
                            datos.tipos.fin_proyecto
                        ],
                        backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444'],
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
                            const tipos = ['Virtual', 'Presencial', 'InicioProyecto', 'FinProyecto'];
                            filtrarEventosPorTipo(tipos[index]);
                        }
                    }
                }
            });

            // Gráfico de Tendencia
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

            // Gráfico de Asistencias
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
        // 🆕 FUNCIÓN: Exportar Reporte Completo en PDF (BOTÓN VERDE)
        // ============================================================================
        async function exportarReporteCompletoPDF() {
            showToast('📄 Generando reporte PDF completo...', 'info');
            
            try {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF('p', 'mm', 'a4');
                
                let yPos = 20;
                const pageWidth = doc.internal.pageSize.getWidth();
                const pageHeight = doc.internal.pageSize.getHeight();
                const margin = 15;
                
                // ========== PORTADA ==========
                doc.setFillColor(37, 99, 235);
                doc.rect(0, 0, pageWidth, 60, 'F');
                
                doc.setTextColor(255, 255, 255);
                doc.setFontSize(28);
                doc.setFont(undefined, 'bold');
                doc.text('Reporte de Eventos', pageWidth / 2, 30, { align: 'center' });
                
                doc.setFontSize(14);
                doc.setFont(undefined, 'normal');
                const fechaActual = new Date().toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                doc.text(fechaActual, pageWidth / 2, 45, { align: 'center' });
                
                yPos = 80;
                doc.setTextColor(0, 0, 0);
                
                // ========== ESTADÍSTICAS ==========
                doc.setFontSize(18);
                doc.setFont(undefined, 'bold');
                doc.setTextColor(37, 99, 235);
                doc.text('Estadísticas Generales', margin, yPos);
                yPos += 10;
                
                doc.setFontSize(11);
                doc.setFont(undefined, 'normal');
                doc.setTextColor(0, 0, 0);
                
                const totalEventos = $('#total-eventos').text() || '0';
                const eventosFinalizados = $('#eventos-finalizados').text() || '0';
                const totalAsistencias = $('#total-asistencias').text() || '0';
                const tasaAsistencia = $('#tasa-asistencia').text() || '0%';
                
                const stats = [
                    { label: 'Total de Eventos:', value: totalEventos, color: [37, 99, 235] },
                    { label: 'Eventos Finalizados:', value: eventosFinalizados, color: [5, 150, 105] },
                    { label: 'Total de Asistencias:', value: totalAsistencias, color: [6, 182, 212] },
                    { label: 'Tasa de Asistencia:', value: tasaAsistencia, color: [217, 119, 6] }
                ];
                
                stats.forEach((stat, index) => {
                    const boxY = yPos + (index * 20);
                    
                    doc.setFillColor(...stat.color);
                    doc.roundedRect(margin, boxY, 5, 8, 1, 1, 'F');
                    
                    doc.setFont(undefined, 'normal');
                    doc.text(stat.label, margin + 10, boxY + 6);
                    
                    doc.setFont(undefined, 'bold');
                    doc.setFontSize(14);
                    doc.text(stat.value, pageWidth - margin - 20, boxY + 6);
                    doc.setFontSize(11);
                });
                
                yPos += 90;
                
                // ========== GRÁFICOS ==========
                if (yPos > pageHeight - 100) {
                    doc.addPage();
                    yPos = 20;
                }
                
                doc.setFontSize(18);
                doc.setFont(undefined, 'bold');
                doc.setTextColor(37, 99, 235);
                doc.text('Gráficos y Análisis', margin, yPos);
                yPos += 10;
                
                // Gráfico de Estados
                const estadosCanvas = document.getElementById('estadosChart');
                if (estadosCanvas) {
                    const estadosImg = estadosCanvas.toDataURL('image/png');
                    doc.addImage(estadosImg, 'PNG', margin, yPos, 80, 60);
                }
                
                // Gráfico de Tipos
                const tiposCanvas = document.getElementById('tiposChart');
                if (tiposCanvas) {
                    const tiposImg = tiposCanvas.toDataURL('image/png');
                    doc.addImage(tiposImg, 'PNG', pageWidth - margin - 80, yPos, 80, 60);
                }
                
                yPos += 70;
                
                if (yPos > pageHeight - 80) {
                    doc.addPage();
                    yPos = 20;
                }
                
                // Gráfico de Tendencia
                const tendenciaCanvas = document.getElementById('tendenciaChart');
                if (tendenciaCanvas) {
                    const tendenciaImg = tendenciaCanvas.toDataURL('image/png');
                    const graphWidth = pageWidth - (margin * 2);
                    doc.addImage(tendenciaImg, 'PNG', margin, yPos, graphWidth, 70);
                    yPos += 80;
                }
                
                // ========== ASISTENCIAS ==========
                doc.addPage();
                yPos = 20;
                
                doc.setFontSize(18);
                doc.setFont(undefined, 'bold');
                doc.setTextColor(37, 99, 235);
                doc.text('Estadísticas de Asistencia', margin, yPos);
                yPos += 10;
                
                const asistenciasCanvas = document.getElementById('asistenciasChart');
                if (asistenciasCanvas && $('#asistenciasChart').is(':visible')) {
                    const asistenciasImg = asistenciasCanvas.toDataURL('image/png');
                    const graphWidth = pageWidth - (margin * 2);
                    doc.addImage(asistenciasImg, 'PNG', margin, yPos, graphWidth, 90);
                } else {
                    doc.setFontSize(11);
                    doc.setFont(undefined, 'normal');
                    doc.setTextColor(100, 116, 139);
                    doc.text('No hay datos de asistencias registradas', pageWidth / 2, yPos + 20, { align: 'center' });
                }
                
                // ========== PIE DE PÁGINA ==========
                const pageCount = doc.internal.getNumberOfPages();
                for (let i = 1; i <= pageCount; i++) {
                    doc.setPage(i);
                    doc.setFontSize(9);
                    doc.setTextColor(150, 150, 150);
                    doc.text(
                        `Página ${i} de ${pageCount} - Generado por Sistema Vocero`,
                        pageWidth / 2,
                        pageHeight - 10,
                        { align: 'center' }
                    );
                }
                
                const nombreArchivo = `Reporte_Completo_${new Date().toISOString().split('T')[0]}.pdf`;
                doc.save(nombreArchivo);
                
                showToast('✅ Reporte PDF generado exitosamente', 'success');
                
            } catch (error) {
                console.error('Error generando PDF:', error);
                showToast('❌ Error al generar el reporte PDF', 'error');
            }
        }

        // ============================================================================
        // 🔵 FUNCIÓN: Exportar Tabla a PDF (BOTÓN AZUL)
        // ============================================================================
        async function exportarTablaPDF() {
            showToast('📄 Generando PDF de tabla de eventos...', 'info');
            
            try {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF('p', 'mm', 'a4');
                
                let yPos = 20;
                const pageWidth = doc.internal.pageSize.getWidth();
                const pageHeight = doc.internal.pageSize.getHeight();
                const margin = 15;
                const usableWidth = pageWidth - (margin * 2);
                
                // ========== ENCABEZADO ==========
                doc.setFillColor(37, 99, 235);
                doc.rect(0, 0, pageWidth, 50, 'F');
                
                doc.setTextColor(255, 255, 255);
                doc.setFontSize(24);
                doc.setFont(undefined, 'bold');
                doc.text('Eventos Detallados', pageWidth / 2, 25, { align: 'center' });
                
                // Mostrar filtro activo si existe
                const filtroActivo = $('#filtro-activo-badge').is(':visible') 
                    ? $('#filtro-activo-badge').text() 
                    : 'Todos los eventos';
                
                doc.setFontSize(12);
                doc.setFont(undefined, 'normal');
                doc.text(filtroActivo, pageWidth / 2, 38, { align: 'center' });
                
                yPos = 60;
                doc.setTextColor(0, 0, 0);
                
                // ========== INFORMACIÓN DEL REPORTE ==========
                doc.setFontSize(10);
                doc.setTextColor(100, 116, 139);
                const fechaActual = new Date().toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                doc.text(`Generado: ${fechaActual}`, margin, yPos);
                yPos += 8;
                
                // Contar eventos visibles
                let totalEventosVisibles = 0;
                $('#eventos-tbody tr').each(function() {
                    if ($(this).find('td').length > 1) {
                        totalEventosVisibles++;
                    }
                });
                
                doc.text(`Total de eventos: ${totalEventosVisibles}`, margin, yPos);
                yPos += 12;
                
                doc.setTextColor(0, 0, 0);
                
                // ========== TABLA DE EVENTOS ==========
                // Configuración de columnas
                const colWidths = {
                    titulo: 55,
                    tipo: 30,
                    estado: 25,
                    fecha: 25,
                    asistencias: 20,
                    porcentaje: 25
                };
                
                // Encabezados de tabla
                doc.setFillColor(241, 245, 249);
                doc.rect(margin, yPos, usableWidth, 10, 'F');
                
                doc.setFontSize(9);
                doc.setFont(undefined, 'bold');
                doc.setTextColor(71, 85, 105);
                
                let xPos = margin + 2;
                doc.text('Título', xPos, yPos + 7);
                xPos += colWidths.titulo;
                doc.text('Tipo', xPos, yPos + 7);
                xPos += colWidths.tipo;
                doc.text('Estado', xPos, yPos + 7);
                xPos += colWidths.estado;
                doc.text('Fecha', xPos, yPos + 7);
                xPos += colWidths.fecha;
                doc.text('Asist.', xPos, yPos + 7);
                xPos += colWidths.asistencias;
                doc.text('% Asist.', xPos, yPos + 7);
                
                yPos += 12;
                
                // Línea separadora
                doc.setDrawColor(226, 232, 240);
                doc.line(margin, yPos, pageWidth - margin, yPos);
                yPos += 2;
                
                // Datos de la tabla
                doc.setFont(undefined, 'normal');
                doc.setFontSize(8);
                doc.setTextColor(0, 0, 0);
                
                let rowCount = 0;
                let alternateRow = false;
                
                $('#eventos-tbody tr').each(function() {
                    const $row = $(this);
                    
                    // Ignorar filas de carga o sin datos
                    if ($row.find('td').length <= 1) return;
                    
                    // Verificar si necesitamos nueva página
                    if (yPos > pageHeight - 30) {
                        doc.addPage();
                        yPos = 20;
                        
                        // Repetir encabezados en nueva página
                        doc.setFillColor(241, 245, 249);
                        doc.rect(margin, yPos, usableWidth, 10, 'F');
                        
                        doc.setFontSize(9);
                        doc.setFont(undefined, 'bold');
                        doc.setTextColor(71, 85, 105);
                        
                        xPos = margin + 2;
                        doc.text('Título', xPos, yPos + 7);
                        xPos += colWidths.titulo;
                        doc.text('Tipo', xPos, yPos + 7);
                        xPos += colWidths.tipo;
                        doc.text('Estado', xPos, yPos + 7);
                        xPos += colWidths.estado;
                        doc.text('Fecha', xPos, yPos + 7);
                        xPos += colWidths.fecha;
                        doc.text('Asist.', xPos, yPos + 7);
                        xPos += colWidths.asistencias;
                        doc.text('% Asist.', xPos, yPos + 7);
                        
                        yPos += 12;
                        doc.setDrawColor(226, 232, 240);
                        doc.line(margin, yPos, pageWidth - margin, yPos);
                        yPos += 2;
                        
                        doc.setFont(undefined, 'normal');
                        doc.setFontSize(8);
                        doc.setTextColor(0, 0, 0);
                    }
                    
                    // Fondo alternado para filas
                    if (alternateRow) {
                        doc.setFillColor(248, 250, 252);
                        doc.rect(margin, yPos, usableWidth, 8, 'F');
                    }
                    alternateRow = !alternateRow;
                    
                    // Extraer datos de la fila
                    const titulo = $row.find('td:eq(0)').text().trim();
                    const tipo = $row.find('td:eq(1)').text().trim();
                    const estado = $row.find('td:eq(2)').text().trim();
                    const fecha = $row.find('td:eq(3)').text().trim();
                    const asistencias = $row.find('td:eq(4)').text().trim();
                    const porcentaje = $row.find('td:eq(5) .progress-bar').text().trim();
                    
                    // Truncar título si es muy largo
                    const tituloCorto = titulo.length > 35 ? titulo.substring(0, 35) + '...' : titulo;
                    
                    // Dibujar datos
                    xPos = margin + 2;
                    doc.setFont(undefined, 'bold');
                    doc.text(tituloCorto, xPos, yPos + 6);
                    
                    doc.setFont(undefined, 'normal');
                    xPos += colWidths.titulo;
                    
                    // Truncar tipo si es muy largo
                    const tipoCorto = tipo.length > 18 ? tipo.substring(0, 18) + '...' : tipo;
                    doc.text(tipoCorto, xPos, yPos + 6);
                    
                    xPos += colWidths.tipo;
                    doc.text(estado, xPos, yPos + 6);
                    
                    xPos += colWidths.estado;
                    doc.text(fecha, xPos, yPos + 6);
                    
                    xPos += colWidths.fecha;
                    doc.text(asistencias, xPos, yPos + 6);
                    
                    xPos += colWidths.asistencias;
                    
                    // Dibujar barra de porcentaje
                    const porcentajeNum = parseInt(porcentaje) || 0;
                    const barWidth = 20;
                    const barHeight = 4;
                    const barX = xPos;
                    const barY = yPos + 2;
                    
                    // Fondo de la barra
                    doc.setFillColor(229, 231, 235);
                    doc.roundedRect(barX, barY, barWidth, barHeight, 1, 1, 'F');
                    
                    // Relleno según porcentaje
                    if (porcentajeNum > 0) {
                        const fillWidth = (barWidth * porcentajeNum) / 100;
                        doc.setFillColor(5, 150, 105);
                        doc.roundedRect(barX, barY, fillWidth, barHeight, 1, 1, 'F');
                    }
                    
                    // Texto del porcentaje
                    doc.setFontSize(7);
                    doc.text(porcentaje, barX + barWidth + 2, yPos + 6);
                    doc.setFontSize(8);
                    
                    yPos += 10;
                    rowCount++;
                });
                
                // Mensaje si no hay eventos
                if (rowCount === 0) {
                    doc.setTextColor(100, 116, 139);
                    doc.setFontSize(11);
                    doc.text('No hay eventos para mostrar', pageWidth / 2, yPos + 20, { align: 'center' });
                }
                
                // ========== PIE DE PÁGINA EN TODAS LAS PÁGINAS ==========
                const pageCount = doc.internal.getNumberOfPages();
                for (let i = 1; i <= pageCount; i++) {
                    doc.setPage(i);
                    
                    // Línea separadora
                    doc.setDrawColor(226, 232, 240);
                    doc.line(margin, pageHeight - 15, pageWidth - margin, pageHeight - 15);
                    
                    doc.setFontSize(8);
                    doc.setTextColor(150, 150, 150);
                    doc.text(
                        `Página ${i} de ${pageCount}`,
                        margin,
                        pageHeight - 10
                    );
                    doc.text(
                        'Sistema Vocero',
                        pageWidth - margin,
                        pageHeight - 10,
                        { align: 'right' }
                    );
                }
                
                // Guardar PDF
                const filtroNombre = filtroActivo !== 'Todos los eventos' 
                    ? `_${filtroActivo.replace(/[^a-zA-Z0-9]/g, '_')}`
                    : '';
                const nombreArchivo = `Tabla_Eventos${filtroNombre}_${new Date().toISOString().split('T')[0]}.pdf`;
                doc.save(nombreArchivo);
                
                showToast(`✅ PDF de tabla generado (${rowCount} eventos)`, 'success');
                
            } catch (error) {
                console.error('Error generando PDF de tabla:', error);
                showToast('❌ Error al generar el PDF de la tabla', 'error');
            }
        }

        // ============================================================================
        // FUNCIONES DE FILTRADO
        // ============================================================================
        function filtrarEventosPorEstado(estado) {
            const nombreEstado = obtenerNombreEstado(estado);
            const eventosFiltrados = eventosDetallados.filter(e => e.EstadoEvento === estado);
            
            $('#filtro-activo-badge').text(`Filtro: ${nombreEstado}`).show();
            
            if (eventosFiltrados.length === 0) {
                showToast(`No hay eventos con estado: ${nombreEstado}`, 'warning');
            } else {
                showToast(`Mostrando ${eventosFiltrados.length} eventos ${nombreEstado}`, 'info');
            }
            
            mostrarEventosDetallados(eventosFiltrados);
            agregarBotonLimpiarFiltro();
            
            $('html, body').animate({
                scrollTop: $("#eventos-table").offset().top - 100
            }, 500);
        }

        function filtrarEventosPorTipo(tipo) {
            const nombreTipo = obtenerNombreTipo(tipo);
            const eventosFiltrados = eventosDetallados.filter(e => e.TipoEvento === tipo);
            
            $('#filtro-activo-badge').text(`Filtro: ${nombreTipo}`).show();
            
            if (eventosFiltrados.length === 0) {
                showToast(`No hay eventos de tipo: ${nombreTipo}`, 'warning');
            } else {
                showToast(`Mostrando ${eventosFiltrados.length} eventos tipo ${nombreTipo}`, 'info');
            }
            
            mostrarEventosDetallados(eventosFiltrados);
            agregarBotonLimpiarFiltro();
            
            $('html, body').animate({
                scrollTop: $("#eventos-table").offset().top - 100
            }, 500);
        }

        function filtrarEventosPorMes(mes) {
            const [year, month] = mes.split('-');
            
            const eventosFiltrados = eventosDetallados.filter(e => {
                const fechaEvento = new Date(e.FechaInicio);
                const yearEvento = fechaEvento.getFullYear();
                const monthEvento = String(fechaEvento.getMonth() + 1).padStart(2, '0');
                
                return yearEvento == year && monthEvento == month;
            });
            
            const fecha = new Date(year, month - 1);
            const nombreMes = fecha.toLocaleDateString('es-ES', { month: 'long', year: 'numeric' });
            const nombreMesCapitalizado = nombreMes.charAt(0).toUpperCase() + nombreMes.slice(1);
            
            $('#filtro-activo-badge').text(`Filtro: ${nombreMesCapitalizado}`).show();
            
            if (eventosFiltrados.length === 0) {
                showToast(`No hay eventos en: ${nombreMesCapitalizado}`, 'warning');
            } else {
                showToast(`Mostrando ${eventosFiltrados.length} eventos de ${nombreMesCapitalizado}`, 'info');
            }
            
            mostrarEventosDetallados(eventosFiltrados);
            agregarBotonLimpiarFiltro();
            
            $('html, body').animate({
                scrollTop: $("#eventos-table").offset().top - 100
            }, 500);
        }

        function agregarBotonLimpiarFiltro() {
            if ($('#btn-limpiar-filtro').length === 0) {
                const boton = `
                    <button id="btn-limpiar-filtro" class="btn btn-sm btn-warning ms-2" onclick="limpiarFiltro()">
                        <i class="fas fa-times me-1"></i>Limpiar Filtro
                    </button>
                `;
                $('.card-header:has(#filtro-activo-badge) .d-flex:last').append(boton);
            }
        }

        function limpiarFiltro() {
            mostrarEventosDetallados(eventosDetallados);
            $('#btn-limpiar-filtro').remove();
            $('#filtro-activo-badge').hide();
            showToast(`Mostrando todos los eventos (${eventosDetallados.length})`, 'success');
        }

        // ============================================================================
        // FUNCIONES AUXILIARES
        // ============================================================================
        function verDetalleEvento(eventoId) {
            $.ajax({
                url: `/api/calendario/reportes/evento/${eventoId}`,
                method: 'GET',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    if (response.success) {
                        mostrarModalDetalle(response.reporte);
                    }
                },
                error: function(xhr) {
                    console.error('Error al cargar detalle:', xhr);
                    showToast('Error al cargar detalle del evento', 'error');
                }
            });
        }

        function mostrarModalDetalle(reporte) {
            let porcentaje = parseFloat(reporte.PorcentajeAsistencia) || 0;
            
            Swal.fire({
                title: reporte.TituloEvento,
                html: `
                    <div class="text-start">
                        <p><strong>Tipo:</strong> ${obtenerNombreTipo(reporte.TipoEvento)}</p>
                        <p><strong>Estado:</strong> ${obtenerNombreEstado(reporte.EstadoEvento)}</p>
                        <p><strong>Fecha:</strong> ${new Date(reporte.FechaInicio).toLocaleDateString('es-ES')}</p>
                        <p><strong>Organizador:</strong> ${reporte.Organizador}</p>
                        <hr>
                        <h5>Estadísticas de Asistencia</h5>
                        <p><strong>Total Registros:</strong> ${reporte.TotalRegistros}</p>
                        <p><strong>Presentes:</strong> <span class="text-success">${reporte.TotalPresentes}</span></p>
                        <p><strong>Ausentes:</strong> <span class="text-danger">${reporte.TotalAusentes}</span></p>
                        <p><strong>Justificados:</strong> <span class="text-info">${reporte.TotalJustificados}</span></p>
                        <p><strong>Porcentaje de Asistencia:</strong> <span class="text-success">${porcentaje.toFixed(1)}%</span></p>
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'Cerrar',
                width: '600px'
            });
        }

        function refreshData() {
            showToast('Actualizando datos...', 'info');
            cargarDatos();
        }

        function obtenerNombreTipo(tipo) {
            const tipos = {
                'Virtual': 'Reunión Virtual',
                'Presencial': 'Reunión Presencial',
                'InicioProyecto': 'Inicio de Proyecto',
                'FinProyecto': 'Fin de Proyecto'
            };
            return tipos[tipo] || tipo;
        }

        function obtenerNombreEstado(estado) {
            const estados = {
                'Programado': 'Programado',
                'EnCurso': 'En Curso',
                'Finalizado': 'Finalizado'
            };
            return estados[estado] || estado;
        }

        function obtenerBadgeEstado(estado) {
            const badges = {
                'Programado': '<span class="badge bg-warning">Programado</span>',
                'EnCurso': '<span class="badge bg-info">En Curso</span>',
                'Finalizado': '<span class="badge bg-success">Finalizado</span>'
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