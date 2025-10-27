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
            overflow-x: hidden; /* 🔒 EVITAR SCROLL HORIZONTAL */
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
            overflow-y: auto; /* Solo scroll vertical si es necesario */
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
            width: calc(100% - 250px); /* 🔒 ANCHO FIJO */
            max-width: calc(100% - 250px); /* 🔒 MÁXIMO ANCHO */
            overflow-x: hidden; /* 🔒 EVITAR DESBORDAMIENTO */
        }

        .content-wrapper {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 24px;
            max-width: 100%; /* 🔒 NO EXCEDER CONTENEDOR */
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            max-width: 100%; /* 🔒 NO EXCEDER CONTENEDOR */
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
            width: 100%; /* 🔒 ANCHO COMPLETO DEL CONTENEDOR */
            max-width: 100%; /* 🔒 NO EXCEDER */
        }

        .chart-container.large {
            height: 400px;
        }

        /* 📊 CONTENEDOR SCROLLABLE PARA GRÁFICO DE ASISTENCIAS */
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

        /* 🎨 ANIMACIONES Y EFECTOS */
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

        /* Spinner de carga mejorado */
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

        /* Efectos de tabla */
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

        /* 🔒 RESPONSIVE - EVITAR SCROLL HORIZONTAL */
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

        /* 🔒 ASEGURAR QUE TODOS LOS ELEMENTOS RESPETEN EL ANCHO */
        * {
            max-width: 100%;
        }

        canvas {
            max-width: 100% !important;
            height: auto !important;
        }

        /* Indicar que los gráficos son clicables */
        .chart-container canvas {
            cursor: pointer;
        }

        .chart-container canvas:hover {
            opacity: 0.9;
        }

        /* Badge de filtro activo */
        #filtro-activo-badge {
            animation: fadeIn 0.3s ease-in;
        }
    </style>
</head>
<body>
    <div class="container-fluid" style="overflow-x: hidden;"> <!-- 🔒 CONTENEDOR PRINCIPAL SIN SCROLL -->
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
                        <button class="btn btn-success" onclick="exportarReporte()">
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
                                <!-- Contenedor con scroll horizontal -->
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
                            <button class="btn btn-sm btn-primary" onclick="exportarTablaCSV()">
                                <i class="fas fa-file-csv me-1"></i>Exportar CSV
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
        // ============================================================================
        // 🔄 CÓDIGO CONECTADO A BASE DE DATOS
        // ============================================================================
        
        let estadosChart, tiposChart, tendenciaChart, asistenciasChart;
        let eventosDetallados = [];

        $(document).ready(function() {
            cargarDatos();
        });

        // ============================================================================
        // ✅ FUNCIÓN: Cargar todos los datos desde la BD
        // ============================================================================
        function cargarDatos() {
            console.log('🔄 Iniciando carga de datos...');
            
            // 1️⃣ CARGAR EVENTOS DETALLADOS Y CALCULAR ASISTENCIAS
            $.ajax({
                url: '/api/calendario/reportes/detallado',
                method: 'GET',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    console.log('📦 Respuesta completa del servidor:', response);
                    
                    if (response.success && response.eventos) {
                        eventosDetallados = response.eventos;
                        console.log('✅ Eventos cargados:', eventosDetallados.length);
                        
                        if (eventosDetallados.length > 0) {
                            console.log('📋 Primer evento (ejemplo):', eventosDetallados[0]);
                            console.log('🔑 Campos disponibles:', Object.keys(eventosDetallados[0]));
                        }
                        
                        // Calcular asistencias (soporta ambos nombres de campo)
                        let totalAsistencias = 0;
                        let totalPresentes = 0;
                        
                        eventosDetallados.forEach(evento => {
                            // 🔥 Soportar ambos nombres: TotalRegistros (del SP) o TotalAsistencias (legacy)
                            const registros = parseInt(evento.TotalRegistros || evento.TotalAsistencias || 0);
                            const presentes = parseInt(evento.TotalPresentes || 0);
                            
                            totalAsistencias += registros;
                            totalPresentes += presentes;
                            
                            console.log(`  - ${evento.TituloEvento}: ${registros} registros, ${presentes} presentes`);
                        });
                        
                        const tasaAsistencia = totalAsistencias > 0 ? 
                            Math.round((totalPresentes / totalAsistencias) * 100) : 0;
                        
                        console.log('\n📊 CÁLCULOS FINALES:');
                        console.log('  Total Asistencias:', totalAsistencias);
                        console.log('  Total Presentes:', totalPresentes);
                        console.log('  Tasa:', tasaAsistencia + '%');
                        
                        // 🔥 ACTUALIZAR tarjetas con JavaScript puro Y jQuery (doble seguridad)
                        const elemAsistencias = document.getElementById('total-asistencias');
                        const elemTasa = document.getElementById('tasa-asistencia');
                        
                        console.log('\n🎯 ACTUALIZANDO TARJETAS:');
                        
                        if (elemAsistencias) {
                            elemAsistencias.textContent = totalAsistencias;
                            $('#total-asistencias').text(totalAsistencias);
                            console.log('✅ Total Asistencias actualizado a:', totalAsistencias);
                            console.log('   Contenido actual del elemento:', elemAsistencias.textContent);
                        } else {
                            console.error('❌ Elemento #total-asistencias no encontrado en el DOM');
                        }
                        
                        if (elemTasa) {
                            elemTasa.textContent = tasaAsistencia + '%';
                            $('#tasa-asistencia').text(tasaAsistencia + '%');
                            console.log('✅ Tasa de Asistencia actualizada a:', tasaAsistencia + '%');
                            console.log('   Contenido actual del elemento:', elemTasa.textContent);
                        } else {
                            console.error('❌ Elemento #tasa-asistencia no encontrado en el DOM');
                        }
                        
                        // Mostrar en tabla
                        mostrarEventosDetallados(eventosDetallados);
                        
                    } else {
                        console.error('❌ Respuesta sin eventos o sin éxito:', response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('❌ Error cargando eventos:', {
                        status: xhr.status,
                        statusText: xhr.statusText,
                        error: error,
                        response: xhr.responseText
                    });
                }
            });
            
            // 2️⃣ CARGAR ESTADÍSTICAS GENERALES
            $.ajax({
                url: '/api/calendario/reportes/estadisticas-generales',
                method: 'GET',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    if (response.success && response.estadisticas) {
                        const stats = response.estadisticas;
                        
                        // Con JavaScript puro
                        const elemEventos = document.getElementById('total-eventos');
                        const elemFinalizados = document.getElementById('eventos-finalizados');
                        
                        if (elemEventos) {
                            elemEventos.textContent = stats.TotalEventos || 0;
                            $('#total-eventos').text(stats.TotalEventos || 0);
                        }
                        
                        if (elemFinalizados) {
                            elemFinalizados.textContent = stats.TotalFinalizados || 0;
                            $('#eventos-finalizados').text(stats.TotalFinalizados || 0);
                        }
                        
                        console.log('✅ Estadísticas generales actualizadas');
                    }
                },
                error: function(xhr) {
                    console.error('❌ Error cargando estadísticas:', xhr);
                }
            });
            
            // 3️⃣ CARGAR GRÁFICOS
            $.ajax({
                url: '/api/calendario/reportes/graficos',
                method: 'GET',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    if (response.success && response.graficos) {
                        crearGraficos(response.graficos);
                        console.log('✅ Gráficos creados');
                    }
                },
                error: function(xhr) {
                    console.error('❌ Error cargando gráficos:', xhr);
                }
            });
        }

        // ============================================================================
        // ✅ FUNCIÓN: Actualizar estadísticas generales (solo eventos y finalizados)
        // ============================================================================
        function actualizarEstadisticasGenerales(stats) {
            // Esta función ya no se usa, se actualiza directamente en cargarDatos()
        }

        // ============================================================================
        // ✅ FUNCIÓN: Crear gráficos con Chart.js
        // ============================================================================
        function crearGraficos(datos) {
            // Destruir gráficos anteriores si existen
            if (estadosChart) estadosChart.destroy();
            if (tiposChart) tiposChart.destroy();
            if (tendenciaChart) tendenciaChart.destroy();
            if (asistenciasChart) asistenciasChart.destroy();

            // Gráfico de Estados (Donut) - INTERACTIVO
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
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    onClick: function(evt, activeElements) {
                        if (activeElements.length > 0) {
                            const index = activeElements[0].index;
                            const estados = ['Programado', 'EnCurso', 'Finalizado'];
                            const estadoSeleccionado = estados[index];
                            filtrarEventosPorEstado(estadoSeleccionado);
                        }
                    }
                }
            });

            // Gráfico de Tipos (Barras) - INTERACTIVO
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
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Eventos: ${context.parsed.y}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    onClick: function(evt, activeElements) {
                        if (activeElements.length > 0) {
                            const index = activeElements[0].index;
                            const tipos = ['Virtual', 'Presencial', 'InicioProyecto', 'FinProyecto'];
                            const tipoSeleccionado = tipos[index];
                            filtrarEventosPorTipo(tipoSeleccionado);
                        }
                    }
                }
            });

            // Gráfico de Tendencia (Línea) - INTERACTIVO
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
                        pointBorderWidth: 2,
                        pointHoverBackgroundColor: '#1d4ed8',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 3
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
                                title: function(context) {
                                    return context[0].label;
                                },
                                label: function(context) {
                                    return `Eventos: ${context.parsed.y}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
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

            // Gráfico de Asistencias (Barras Agrupadas) - SCROLLABLE
            const ctxAsistencias = document.getElementById('asistenciasChart').getContext('2d');
            
            if (datos.asistencias && datos.asistencias.length > 0) {
                // Mostrar el canvas y ocultar mensaje de "no hay datos"
                $('#asistenciasChart').show();
                $('#no-asistencias-message').hide();
                
                // 🆕 MOSTRAR TODOS LOS EVENTOS (no solo 10)
                const todasAsistencias = datos.asistencias;
                const numEventos = todasAsistencias.length;
                
                // 🆕 CALCULAR ANCHO DINÁMICO: cada evento necesita ~80px
                const anchoMinimo = Math.max(100, numEventos * 80);
                const contenedorWrapper = document.getElementById('asistencias-chart-wrapper');
                contenedorWrapper.style.minWidth = anchoMinimo + 'px';
                
                // 🆕 ACTUALIZAR SUBTÍTULO
                $('#asistencias-subtitle').text(`${numEventos} eventos con asistencias registradas`);
                
                const eventosLabels = todasAsistencias.map(a => {
                    // Truncar títulos largos
                    return a.titulo.length > 20 ? a.titulo.substring(0, 20) + '...' : a.titulo;
                });
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
                            legend: {
                                position: 'top'
                            },
                            tooltip: {
                                callbacks: {
                                    title: function(context) {
                                        // Mostrar título completo en tooltip
                                        const index = context[0].dataIndex;
                                        return todasAsistencias[index].titulo;
                                    },
                                    afterLabel: function(context) {
                                        const index = context.dataIndex;
                                        let porcentaje = parseFloat(todasAsistencias[index].porcentaje) || 0;
                                        if (isNaN(porcentaje)) porcentaje = 0;
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
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            } else {
                // Ocultar el canvas y mostrar mensaje de "no hay datos"
                $('#asistenciasChart').hide();
                $('#no-asistencias-message').show();
            }
        }

        // ============================================================================
        // ✅ FUNCIÓN: Mostrar eventos detallados en tabla
        // ============================================================================
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
                
                // Convertir porcentaje a número y manejar null/undefined
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
        // 🆕 FUNCIÓN: Filtrar eventos por estado
        // ============================================================================
        function filtrarEventosPorEstado(estado) {
            console.log('Filtrando por estado:', estado);
            console.log('Eventos disponibles:', eventosDetallados);
            
            const nombreEstado = obtenerNombreEstado(estado);
            const eventosFiltrados = eventosDetallados.filter(e => {
                console.log('Comparando:', e.EstadoEvento, 'con', estado);
                return e.EstadoEvento === estado;
            });
            
            console.log('Eventos filtrados:', eventosFiltrados);
            
            // Mostrar badge de filtro activo
            $('#filtro-activo-badge').text(`Filtro: ${nombreEstado}`).show();
            
            if (eventosFiltrados.length === 0) {
                showToast(`No hay eventos con estado: ${nombreEstado}`, 'warning');
            } else {
                showToast(`Mostrando ${eventosFiltrados.length} eventos ${nombreEstado}`, 'info');
            }
            
            mostrarEventosDetallados(eventosFiltrados);
            
            // Agregar botón para limpiar filtro
            agregarBotonLimpiarFiltro();
            
            // Scroll a la tabla
            $('html, body').animate({
                scrollTop: $("#eventos-table").offset().top - 100
            }, 500);
        }

        // ============================================================================
        // 🆕 FUNCIÓN: Filtrar eventos por tipo
        // ============================================================================
        function filtrarEventosPorTipo(tipo) {
            console.log('Filtrando por tipo:', tipo);
            console.log('Eventos disponibles:', eventosDetallados);
            
            const nombreTipo = obtenerNombreTipo(tipo);
            const eventosFiltrados = eventosDetallados.filter(e => {
                console.log('Comparando:', e.TipoEvento, 'con', tipo);
                return e.TipoEvento === tipo;
            });
            
            console.log('Eventos filtrados:', eventosFiltrados);
            
            // Mostrar badge de filtro activo
            $('#filtro-activo-badge').text(`Filtro: ${nombreTipo}`).show();
            
            if (eventosFiltrados.length === 0) {
                showToast(`No hay eventos de tipo: ${nombreTipo}`, 'warning');
            } else {
                showToast(`Mostrando ${eventosFiltrados.length} eventos tipo ${nombreTipo}`, 'info');
            }
            
            mostrarEventosDetallados(eventosFiltrados);
            
            // Agregar botón para limpiar filtro
            agregarBotonLimpiarFiltro();
            
            // Scroll a la tabla
            $('html, body').animate({
                scrollTop: $("#eventos-table").offset().top - 100
            }, 500);
        }

        // ============================================================================
        // 🆕 FUNCIÓN: Filtrar eventos por mes
        // ============================================================================
        function filtrarEventosPorMes(mes) {
            console.log('Filtrando por mes:', mes);
            console.log('Eventos disponibles:', eventosDetallados);
            
            // mes viene en formato "YYYY-MM"
            const [year, month] = mes.split('-');
            
            const eventosFiltrados = eventosDetallados.filter(e => {
                const fechaEvento = new Date(e.FechaInicio);
                const yearEvento = fechaEvento.getFullYear();
                const monthEvento = String(fechaEvento.getMonth() + 1).padStart(2, '0');
                
                console.log(`Comparando: ${yearEvento}-${monthEvento} con ${year}-${month}`);
                
                return yearEvento == year && monthEvento == month;
            });
            
            console.log('Eventos filtrados:', eventosFiltrados);
            
            // Formatear nombre del mes para mostrar
            const fecha = new Date(year, month - 1);
            const nombreMes = fecha.toLocaleDateString('es-ES', { month: 'long', year: 'numeric' });
            const nombreMesCapitalizado = nombreMes.charAt(0).toUpperCase() + nombreMes.slice(1);
            
            // Mostrar badge de filtro activo
            $('#filtro-activo-badge').text(`Filtro: ${nombreMesCapitalizado}`).show();
            
            if (eventosFiltrados.length === 0) {
                showToast(`No hay eventos en: ${nombreMesCapitalizado}`, 'warning');
            } else {
                showToast(`Mostrando ${eventosFiltrados.length} eventos de ${nombreMesCapitalizado}`, 'info');
            }
            
            mostrarEventosDetallados(eventosFiltrados);
            
            // Agregar botón para limpiar filtro
            agregarBotonLimpiarFiltro();
            
            // Scroll a la tabla
            $('html, body').animate({
                scrollTop: $("#eventos-table").offset().top - 100
            }, 500);
        }

        // ============================================================================
        // 🆕 FUNCIÓN: Agregar botón para limpiar filtro
        // ============================================================================
        function agregarBotonLimpiarFiltro() {
            // Verificar si ya existe el botón
            if ($('#btn-limpiar-filtro').length === 0) {
                const boton = `
                    <button id="btn-limpiar-filtro" class="btn btn-sm btn-warning ms-2" onclick="limpiarFiltro()">
                        <i class="fas fa-times me-1"></i>Limpiar Filtro
                    </button>
                `;
                $('.card-header:has(#filtro-activo-badge) .d-flex:last').append(boton);
            }
        }

        // ============================================================================
        // 🆕 FUNCIÓN: Limpiar filtro y mostrar todos los eventos
        // ============================================================================
        function limpiarFiltro() {
            mostrarEventosDetallados(eventosDetallados);
            $('#btn-limpiar-filtro').remove();
            $('#filtro-activo-badge').hide();
            showToast(`Mostrando todos los eventos (${eventosDetallados.length})`, 'success');
        }

        // ============================================================================
        // ✅ FUNCIÓN: Ver detalle de un evento
        // ============================================================================
        function verDetalleEvento(eventoId) {
            $.ajax({
                url: `/api/calendario/reportes/evento/${eventoId}`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        mostrarModalDetalle(response.reporte);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar detalle:', error);
                    showToast('Error al cargar detalle del evento', 'error');
                }
            });
        }

        function mostrarModalDetalle(reporte) {
            let porcentaje = parseFloat(reporte.PorcentajeAsistencia) || 0;
            if (isNaN(porcentaje)) porcentaje = 0;
            
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

        // ============================================================================
        // ✅ FUNCIÓN: Exportar tabla a CSV
        // ============================================================================
        function exportarTablaCSV() {
            if (eventosDetallados.length === 0) {
                showToast('No hay datos para exportar', 'warning');
                return;
            }

            const headers = ['Título', 'Tipo', 'Estado', 'Fecha', 'Asistencias', 'Porcentaje'];
            const rows = eventosDetallados.map(evento => [
                evento.TituloEvento,
                obtenerNombreTipo(evento.TipoEvento),
                obtenerNombreEstado(evento.EstadoEvento),
                new Date(evento.FechaInicio).toLocaleDateString('es-ES'),
                evento.TotalAsistencias || 0,
                (evento.PorcentajeAsistencia || 0).toFixed(2) + '%'
            ]);

            const csvContent = [headers, ...rows]
                .map(row => row.map(field => `"${field}"`).join(','))
                .join('\n');

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `reporte_eventos_${new Date().toISOString().split('T')[0]}.csv`;
            link.click();

            showToast('CSV exportado correctamente', 'success');
        }

        // ============================================================================
        // ✅ FUNCIÓN: Exportar reporte completo
        // ============================================================================
        function exportarReporte() {
            showToast('Generando reporte PDF...', 'info');
            // Aquí puedes implementar la generación de PDF con una librería como jsPDF
            // Por ahora, exportamos como CSV
            exportarTablaCSV();
        }

        // ============================================================================
        // FUNCIONES AUXILIARES
        // ============================================================================
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