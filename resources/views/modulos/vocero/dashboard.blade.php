<x-app-layout>
    @if(request()->has('embed'))
    <style>
        /* Ocultar solo navbar cuando está en iframe, mantener sidebar */
        nav[x-data]:not(.sidebar-vocero), header:not(.sidebar-vocero) { display: none !important; }
        main { padding-top: 0 !important; }
    </style>
    @endif

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
        }

        /* AJUSTE CLAVE 1: Estilos del Menú Lateral (Sidebar) - ESTILO MODERNO CONSISTENTE */
        .sidebar-vocero {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            width: 250px;
            position: fixed;
            left: 0;
            top: 0; 
            z-index: 20; 
            height: 100vh;
            padding-top: 0; 
            transition: all 0.3s ease;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        /* AJUSTE CLAVE 2: Modifica la barra de navegación de Breeze */
        nav.bg-white {
            margin-left: 250px; 
            width: calc(100% - 250px);
            z-index: 30; 
        }
        
        /* AJUSTE CLAVE 3: Estilos del contenido principal */
        .main-content-vocero {
            margin-left: 250px; 
            min-height: 100vh;
            padding: 0;
            flex-grow: 1;
            padding-top: 64px; 
        }

        /* Estilos internos del sidebar - BRAND MODERNO */
        .sidebar-brand {
            padding: 24px 20px;
            border-bottom: 2px solid rgba(59, 130, 246, 0.2);
            text-align: center;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(10px);
        }

        .sidebar-brand h4 {
            color: white;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-size: 1.75rem;
            letter-spacing: -0.5px;
        }

        .sidebar-brand h4 svg {
            width: 32px;
            height: 32px;
            color: #3b82f6;
            filter: drop-shadow(0 2px 4px rgba(59, 130, 246, 0.4));
        }

        .sidebar-nav {
            padding: 24px 0;
            margin-top: 0;
        }

        .sidebar-vocero .nav-link {
            color: #cbd5e1;
            border-radius: 12px;
            margin: 6px 16px;
            padding: 14px 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 14px;
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
        }

        .sidebar-vocero .nav-link::before {
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

        .sidebar-vocero .nav-link:hover {
            background: rgba(59, 130, 246, 0.15);
            color: #93c5fd;
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }

        .sidebar-vocero .nav-link:hover::before {
            transform: scaleY(1);
        }

        .sidebar-vocero .nav-link.active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(37, 99, 235, 0.25) 100%);
            color: white;
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.3);
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .sidebar-vocero .nav-link.active::before {
            transform: scaleY(1);
        }

        .sidebar-vocero .nav-link svg {
            width: 20px;
            height: 20px;
            transition: all 0.3s ease;
        }

        .sidebar-vocero .nav-link:hover svg,
        .sidebar-vocero .nav-link.active svg {
            transform: scale(1.1);
            filter: drop-shadow(0 2px 4px rgba(59, 130, 246, 0.4));
        }
        
        /* Estilos de Contenido */
        .content-wrapper {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 24px;
            margin-top: 0; 
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1d4ed8 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e3a8a 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
        }

        /* Estilos degradados de las tarjetas con animación */
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            height: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stats-card:hover::before {
            opacity: 1;
        }

        .stats-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 12px 30px rgba(0,0,0,0.3);
        }

        .stats-card:active {
            transform: translateY(-4px) scale(1.01);
        }

        .stats-card-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .stats-card-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .stats-card-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        }

        /* Resto de estilos */
        .badge { 
            font-weight: 500; 
            border-radius: 6px; 
            padding: 6px 12px;
            font-size: 0.875rem;
        }
        
        .table th { 
            background: #f8fafc; 
            border: none; 
            color: var(--secondary-color); 
            font-weight: 600; 
            padding: 15px;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }
        
        .table td { 
            padding: 15px; 
            vertical-align: middle; 
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover { 
            background: #f8fafc;
            transform: scale(1.01);
        }
        
        .empty-state { 
            text-align: center; 
            padding: 60px 20px; 
            color: var(--secondary-color); 
        }
        
        .empty-state svg { 
            width: 4rem;
            height: 4rem;
            margin-bottom: 1rem; 
            opacity: 0.5; 
        }
        
        /* Animaciones */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .stats-card, .card {
            animation: fadeIn 0.5s ease-out;
        }

        .stats-card:nth-child(1) { animation-delay: 0.1s; }
        .stats-card:nth-child(2) { animation-delay: 0.2s; }
        .stats-card:nth-child(3) { animation-delay: 0.3s; }
        .stats-card:nth-child(4) { animation-delay: 0.4s; }

        /* 🆕 OCULTAR BOTÓN "PANEL" DEL HEADER DE BREEZE */
        nav.bg-white a[href*="panel"], 
        nav.bg-white button:contains("Panel"),
        nav.bg-white .hidden.space-x-8 a:first-child {
            display: none !important;
        }

        /* Media Query: Responsive para móviles y tablets */
        @media (max-width: 1024px) {
            .sidebar-vocero { 
                transform: translateX(-100%);
                position: fixed;
                z-index: 50;
            }
            .sidebar-vocero.active {
                transform: translateX(0);
            }
            .main-content-vocero { 
                margin-left: 0; 
                padding-top: 64px;
                width: 100%;
            }
            nav.bg-white { 
                margin-left: 0; 
                width: 100%; 
            }
            .stats-card {
                margin-bottom: 1rem;
            }
        }
        
        @media (max-width: 640px) {
            .sidebar-brand h4 {
                font-size: 1.25rem;
            }
            .content-wrapper {
                padding: 1rem !important;
            }
        }

        /* Spinner de carga */
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .fa-spin {
            animation: spin 1s linear infinite;
        }

        /* Badges con colores mejorados */
        .bg-primary { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important; }
        .bg-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; }
        .bg-warning { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important; }
        .bg-danger { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important; }
        .bg-info { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important; }
    </style>

    <div class="d-flex">
        {{-- ⭐ 1. MENÚ LATERAL (SIDEBAR) ⭐ --}}
        <div class="sidebar-vocero">
            <div class="sidebar-brand">
                <h4>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Macero
                </h4>
            </div>
            
            <nav class="sidebar-nav">
                <a class="nav-link active" href="{{ route('vocero.dashboard') }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Resumen General
                </a>
                <a class="nav-link" href="{{ route('vocero.calendario') }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Calendario
                </a>
                <a class="nav-link" href="{{ route('vocero.eventos') }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Gestión de Eventos
                </a>
                <a class="nav-link" href="{{ route('vocero.asistencias') }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Asistencias
                </a>
                <a class="nav-link" href="{{ route('vocero.reportes') }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Reportes
                </a>
            </nav>
        </div>

        {{-- ⭐ 2. CONTENIDO PRINCIPAL ⭐ --}}
        <div class="main-content-vocero">
            <div class="content-wrapper">
                {{-- TÍTULO Y BOTÓN DE ACTUALIZACIÓN --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2>
                            <svg class="d-inline-block me-2" style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            RESUMEN GENERAL
                        </h2>
                        <p class="text-muted mb-0">Resumen general del módulo Macero</p>
                    </div>
                    <button class="btn btn-outline-primary" onclick="refreshDashboard()">
                        <svg class="me-2" style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Actualizar
                    </button>
                </div>

                {{-- TARJETAS DE ESTADÍSTICAS PRINCIPALES --}}
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="stats-card p-4 text-center" onclick="filtrarEventos('todos')" title="Click para ver todos los eventos">
                            <svg class="mb-3" style="width: 48px; height: 48px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <h3 id="total-eventos" class="display-4 fw-bold">0</h3>
                            <p class="mb-0">Total de Eventos</p>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <div class="stats-card stats-card-success p-4 text-center" onclick="filtrarEventos('proximos')" title="Click para ver eventos próximos">
                            <svg class="mb-3" style="width: 48px; height: 48px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 id="eventos-proximos" class="display-4 fw-bold">0</h3>
                            <p class="mb-0">Eventos Próximos</p>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <div class="stats-card stats-card-warning p-4 text-center" onclick="mostrarInfoAsistencias()" title="Información de asistencias">
                            <svg class="mb-3" style="width: 48px; height: 48px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <h3 id="total-asistencias" class="display-4 fw-bold">0</h3>
                            <p class="mb-0">Asistencias Presentes</p>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <div class="stats-card stats-card-info p-4 text-center" onclick="filtrarEventos('finalizados')" title="Click para ver eventos finalizados">
                            <svg class="mb-3" style="width: 48px; height: 48px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 id="eventos-finalizados" class="display-4 fw-bold">0</h3>
                            <p class="mb-0">Eventos Finalizados</p>
                        </div>
                    </div>
                </div>

                {{-- TABLA DE PRÓXIMOS EVENTOS --}}
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">
                                <svg class="me-2" style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Próximos Eventos
                            </h5>
                            <span id="filtro-activo-badge" class="badge bg-info ms-3" style="display: none;"></span>
                        </div>
                        <button id="btn-limpiar-filtro" class="btn btn-sm btn-warning" onclick="limpiarFiltroEventos()" style="display: none;">
                            <svg class="me-1" style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Mostrar Próximos
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Evento</th>
                                        <th>Fecha</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Encargado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="proximos-eventos-table">
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <svg class="fa-spin mb-3" style="width: 48px; height: 48px; color: #cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            <h5>Cargando eventos...</h5>
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

    @push('scripts')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.all.min.js"></script>

        <script>
            let eventsData = [];

            $(document).ready(function() {
                loadDashboard();
                ocultarBotonPanel();
            });

            function ocultarBotonPanel() {
                setTimeout(function() {
                    $('nav.bg-white a').each(function() {
                        if ($(this).text().trim().toLowerCase() === 'panel') {
                            $(this).hide();
                        }
                    });
                    $('nav.bg-white a[href*="panel"]').hide();
                    $('nav.bg-white .hidden.space-x-8 > a:first-child').hide();
                }, 100);
            }

            function loadDashboard() {
                $.ajax({
                    url: '/api/calendario/reportes/estadisticas-generales',
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            updateDashboardStats(response.estadisticas);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al cargar estadísticas:', error);
                    }
                });

                loadRecentEvents();
            }

            function updateDashboardStats(stats) {
                $('#total-eventos').text(stats.TotalEventos || 0);
                $('#eventos-finalizados').text(stats.TotalFinalizados || 0);
            }

            function loadRecentEvents() {
                const tbody = $('#proximos-eventos-table');
                
                $.ajax({
                    url: '/api/calendario/reportes/detallado',
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (!response.success || response.eventos.length === 0) {
                            tbody.html(`
                                <tr>
                                    <td colspan="6" class="empty-state">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <h5>No hay eventos registrados</h5>
                                        <p>Los eventos aparecerán aquí cuando los crees</p>
                                        <a href="{{ route('vocero.calendario') }}" class="btn btn-primary mt-3">
                                            <svg class="me-2" style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Crear Evento
                                        </a>
                                    </td>
                                </tr>
                            `);
                            return;
                        }

                        eventsData = response.eventos;
                        
                        const totalAsistenciasPresentes = response.eventos.reduce((sum, evento) => {
                            return sum + (parseInt(evento.TotalPresentes) || 0);
                        }, 0);
                        
                        $('#total-asistencias').text(totalAsistenciasPresentes);

                        const now = new Date();
                        const eventosProximosReales = eventsData.filter(event => {
                            const eventDate = new Date(event.FechaInicio);
                            return eventDate >= now && event.EstadoEvento === 'Programado';
                        }).length;
                        
                        $('#eventos-proximos').text(eventosProximosReales);

                        filtrarEventos('proximos');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al cargar eventos:', error);
                        tbody.html(`
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <svg style="color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    <h5>Error al cargar eventos</h5>
                                    <p>Por favor, intenta recargar la página</p>
                                </td>
                            </tr>
                        `);
                    }
                });
            }

            function refreshDashboard() {
                showToast('Actualizando dashboard...', 'info');
                loadDashboard();
                setTimeout(() => {
                    showToast('Dashboard actualizado correctamente', 'success');
                }, 500);
            }

            function filtrarEventos(tipo) {
                const tbody = $('#proximos-eventos-table');
                tbody.empty();
                
                let eventosFiltrados = [];
                let tituloFiltro = '';
                const now = new Date();

                switch(tipo) {
                    case 'todos':
                        eventosFiltrados = eventsData;
                        tituloFiltro = 'Todos los Eventos';
                        break;
                        
                    case 'proximos':
                        eventosFiltrados = eventsData.filter(event => {
                            const eventDate = new Date(event.FechaInicio);
                            return eventDate >= now && event.EstadoEvento === 'Programado';
                        });
                        tituloFiltro = 'Eventos Próximos (Programados)';
                        $('#eventos-proximos').text(eventosFiltrados.length);
                        break;
                        
                    case 'finalizados':
                        eventosFiltrados = eventsData.filter(event => {
                            return event.EstadoEvento === 'Finalizado';
                        });
                        tituloFiltro = 'Eventos Finalizados';
                        $('#eventos-finalizados').text(eventosFiltrados.length);
                        break;
                        
                    default:
                        eventosFiltrados = eventsData.filter(event => {
                            const eventDate = new Date(event.FechaInicio);
                            return eventDate >= now && event.EstadoEvento === 'Programado';
                        });
                        tituloFiltro = 'Eventos Próximos';
                }

                eventosFiltrados.sort((a, b) => new Date(a.FechaInicio) - new Date(b.FechaInicio));

                if (tipo !== 'proximos') {
                    $('#filtro-activo-badge').text(tituloFiltro).show();
                    $('#btn-limpiar-filtro').show();
                } else {
                    $('#filtro-activo-badge').hide();
                    $('#btn-limpiar-filtro').hide();
                }

                if (eventosFiltrados.length === 0) {
                    tbody.append(`
                        <tr>
                            <td colspan="6" class="empty-state">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <h5>No hay eventos en esta categoría</h5>
                                <p>${tituloFiltro}</p>
                            </td>
                        </tr>
                    `);
                    showToast(`No hay eventos para mostrar: ${tituloFiltro}`, 'info');
                    return;
                }

                eventosFiltrados.forEach(event => {
                    const fecha = formatDateTime(new Date(event.FechaInicio));
                    const tipo = getCategoryName(event.TipoEvento);
                    const tipoBadge = getCategoryColor(event.TipoEvento);
                    const estado = getStatusName(event.EstadoEvento);
                    const estadoBadge = getStatusColor(event.EstadoEvento);
                    const totalRegistros = event.TotalRegistros || 0;
                    
                    let organizadorNombre = 'No especificado';
                    if (event.Organizador && typeof event.Organizador === 'string') {
                        const orgCompleto = String(event.Organizador).trim();
                        
                        if (orgCompleto.toLowerCase().includes('polarm') || 
                            orgCompleto.toLowerCase().includes('intenso') ||
                            orgCompleto.toLowerCase().includes('frecuente') ||
                            orgCompleto.length > 100) {
                            organizadorNombre = 'No especificado';
                        } else if (orgCompleto.includes(' - ')) {
                            organizadorNombre = orgCompleto.split(' - ')[0].trim();
                        } else {
                            organizadorNombre = orgCompleto;
                        }
                    }
                    
                    tbody.append(`
                        <tr>
                            <td><strong>${event.TituloEvento}</strong></td>
                            <td>${fecha}</td>
                            <td><span class="badge bg-${tipoBadge}">${tipo}</span></td>
                            <td><span class="badge bg-${estadoBadge}">${estado}</span></td>
                            <td>${organizadorNombre}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('vocero.calendario') }}" class="btn btn-outline-primary" title="Ver en calendario">
                                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('vocero.asistencias') }}" class="btn btn-outline-success" title="Gestionar asistencia">
                                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <span class="badge bg-success">${totalRegistros}</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `);
                });

                showToast(`Mostrando ${eventosFiltrados.length} eventos: ${tituloFiltro}`, 'success');
            }

            function limpiarFiltroEventos() {
                filtrarEventos('proximos');
                $('#filtro-activo-badge').hide();
                $('#btn-limpiar-filtro').hide();
            }

            function mostrarInfoAsistencias() {
                const totalPresentes = $('#total-asistencias').text();
                
                Swal.fire({
                    icon: 'info',
                    title: 'Asistencias Presentes',
                    html: `
                        <div class="text-start">
                            <p><strong>Total de asistencias con estado "Presente":</strong> ${totalPresentes}</p>
                            <hr>
                            <p class="text-muted small">Este número representa la suma de todas las asistencias marcadas como "Presente" en todos los eventos.</p>
                            <p class="text-muted small">Para ver el detalle completo, visita la sección de <a href="{{ route('vocero.reportes') }}">Reportes</a>.</p>
                        </div>
                    `,
                    confirmButtonText: 'Entendido'
                });
            }

            function formatDateTime(date) {
                return date.toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }

            function getCategoryName(tipo) {
                const mapping = {
                    'Virtual': 'Reunión Virtual',
                    'Presencial': 'Reunión Presencial',
                    'InicioProyecto': 'Inicio Proyecto',
                    'FinProyecto': 'Fin Proyecto'
                };
                return mapping[tipo] || 'Sin categoría';
            }

            function getCategoryColor(tipo) {
                const colors = {
                    'Virtual': 'primary',
                    'Presencial': 'success',
                    'InicioProyecto': 'warning',
                    'FinProyecto': 'danger'
                };
                return colors[tipo] || 'secondary';
            }

            function getStatusName(estado) {
                const mapping = {
                    'Programado': 'Programado',
                    'EnCurso': 'En Curso',
                    'Finalizado': 'Finalizado'
                };
                return mapping[estado] || 'Sin estado';
            }

            function getStatusColor(estado) {
                const colors = {
                    'Programado': 'info',
                    'EnCurso': 'warning',
                    'Finalizado': 'success'
                };
                return colors[estado] || 'secondary';
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
    @endpush

</x-app-layout>