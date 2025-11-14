<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vocero - Gestión de Eventos</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            --sidebar-bg: #2c3e50;
            --sidebar-text: #ecf0f1;
            --light-bg: #f1f5f9;
            --dark-color: #1e293b;
            --border-color: #e2e8f0;
            --card-bg: #ffffff;
        }

        body {
            background: var(--light-bg);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container-fluid {
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
        }

        .sidebar-brand h4 {
            color: var(--sidebar-text);
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .sidebar .nav-link {
            color: var(--sidebar-text);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease;
            border: none;
            background: none;
            text-decoration: none;
            font-weight: 500;
        }

        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar .nav-link.active {
            background: var(--primary-color);
            color: white;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            background: var(--light-bg);
            padding: 0;
        }

        .content-area {
            padding: 30px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0 0 8px 0;
        }

        .page-subtitle {
            color: var(--secondary-color);
            margin: 0 0 25px 0;
            font-size: 1rem;
        }

        .header-actions {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        .stats-row {
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
            height: 100%;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .stat-card.active {
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
            background: rgba(37, 99, 235, 0.02);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .stat-title {
            font-size: 14px;
            color: var(--secondary-color);
            margin: 0;
            font-weight: 500;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0 0 5px 0;
            line-height: 1;
        }

        .stat-change {
            font-size: 13px;
            font-weight: 500;
            color: var(--success-color);
            margin: 0;
        }

        .filter-section {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid var(--border-color);
        }

        .filter-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0 0 20px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-section {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .table-header {
            padding: 25px;
            border-bottom: 1px solid var(--border-color);
            background: var(--card-bg);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
        }

        .filter-indicator {
            font-size: 14px;
            color: var(--secondary-color);
            font-style: italic;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-size: 14px;
            font-family: inherit;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .btn-outline-primary {
            background: white;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-outline-warning {
            background: white;
            color: var(--warning-color);
            border: 1px solid var(--warning-color);
        }

        .btn-outline-warning:hover {
            background: var(--warning-color);
            color: white;
        }

        .btn-outline-danger {
            background: white;
            color: var(--danger-color);
            border: 1px solid var(--danger-color);
        }

        .btn-outline-danger:hover {
            background: var(--danger-color);
            color: white;
        }

        .btn-outline-secondary {
            background: white;
            color: var(--secondary-color);
            border: 1px solid var(--border-color);
        }

        .btn-outline-secondary:hover {
            background: var(--light-bg);
            color: var(--dark-color);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .form-control, .form-select {
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.2s ease;
            background: white;
            font-family: inherit;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-label {
            font-weight: 500;
            color: var(--dark-color);
            font-size: 14px;
            margin-bottom: 6px;
        }

        .table-responsive {
            background: white;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background: var(--light-bg);
            border: none;
            color: var(--dark-color);
            font-weight: 600;
            padding: 15px;
            font-size: 13px;
            white-space: nowrap;
        }

        .table td {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: #fafbfc;
        }

        .event-title {
            font-weight: 600;
            color: var(--dark-color);
            margin: 0 0 4px 0;
        }

        .event-date {
            font-weight: 500;
            color: var(--dark-color);
            margin: 0 0 2px 0;
        }

        .event-time {
            font-size: 13px;
            color: var(--secondary-color);
            margin: 0;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-programado {
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary-color);
        }

        .status-en_curso {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .status-finalizado {
            background: rgba(100, 116, 139, 0.1);
            color: var(--secondary-color);
        }

        .status-cancelado {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }

        .category-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            border: 1px solid;
        }

        .category-reunion-virtual {
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary-color);
            border-color: rgba(37, 99, 235, 0.2);
        }

        .category-reunion-presencial {
            background: rgba(175, 82, 222, 0.1);
            color: #af52de;
            border-color: rgba(175, 82, 222, 0.2);
        }

        .category-inicio-proyecto {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
            border-color: rgba(16, 185, 129, 0.2);
        }

        .category-finalizar-proyecto {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
            border-color: rgba(239, 68, 68, 0.2);
        }

        .category-cumpleanos {
            background: rgba(255, 45, 146, 0.1);
            color: #ff2d92;
            border-color: rgba(255, 45, 146, 0.2);
        }

        .alert-info-custom {
            background: rgba(37, 99, 235, 0.1);
            border: 1px solid rgba(37, 99, 235, 0.2);
            color: var(--primary-color);
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--secondary-color);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .content-area {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <h4><i class="fas fa-calendar-alt text-primary"></i> Vocero</h4>
        </div>
        
        <nav class="sidebar-nav">
            <a class="nav-link {{ request()->routeIs('vocero.index') ? 'active' : '' }}" href="{{ route('vocero.index') }}">
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
        <div class="content-area">
            <div class="page-header">
                <h1>Gestión de Eventos</h1>
                <p class="page-subtitle">Vista consolidada de todos los eventos creados en el sistema</p>
                
                <div class="alert-info-custom">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Información:</strong> Los eventos se sincronizan automáticamente desde el calendario. 
                    Para crear nuevos eventos, utiliza el <a href="{{ route('vocero.calendario') }}" class="text-decoration-none"><strong>Calendario</strong></a>.
                </div>

                <div class="header-actions">
                    <a href="{{ route('vocero.calendario') }}" class="btn btn-primary">
                        <i class="fas fa-calendar-plus me-2"></i>Ir al Calendario
                    </a>
                    <button class="btn btn-outline-primary" onclick="exportEvents()">
                        <i class="fas fa-download"></i> Exportar
                    </button>
                </div>
            </div>

            <div class="row stats-row">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" data-filter="month" onclick="filterByCategory('month')">
                        <div class="stat-header">
                            <h3 class="stat-title">Este Mes</h3>
                            <div class="stat-icon" style="background: var(--primary-color);">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                        <h2 class="stat-number" id="month-events">0</h2>
                        <p class="stat-change">Eventos del mes actual</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" data-filter="upcoming" onclick="filterByCategory('upcoming')">
                        <div class="stat-header">
                            <h3 class="stat-title">Próximos</h3>
                            <div class="stat-icon" style="background: var(--warning-color);">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <h2 class="stat-number" id="upcoming-events">0</h2>
                        <p class="stat-change">Por realizar este mes</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" data-filter="today" onclick="filterByCategory('today')">
                        <div class="stat-header">
                            <h3 class="stat-title">Hoy</h3>
                            <div class="stat-icon" style="background: var(--success-color);">
                                <i class="fas fa-play-circle"></i>
                            </div>
                        </div>
                        <h2 class="stat-number" id="today-events">0</h2>
                        <p class="stat-change">Eventos de hoy</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" data-filter="completed" onclick="filterByCategory('completed')">
                        <div class="stat-header">
                            <h3 class="stat-title">Completados</h3>
                            <div class="stat-icon" style="background: var(--secondary-color);">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <h2 class="stat-number" id="completed-events">0</h2>
                        <p class="stat-change">Ya realizados este mes</p>
                    </div>
                </div>
            </div>

            <div class="filter-section">
                <h3 class="filter-title">
                    <i class="fas fa-filter"></i> Filtros y Búsqueda
                </h3>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Buscar eventos</label>
                        <input type="text" class="form-control" id="search-input" placeholder="Título, descripción, organizador...">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Estado</label>
                        <select class="form-select" id="status-filter">
                            <option value="">Todos</option>
                            <option value="programado">Programado</option>
                            <option value="en_curso">En Curso</option>
                            <option value="finalizado">Finalizado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Categoría</label>
                        <select class="form-select" id="category-filter">
                            <option value="">Todas</option>
                            <option value="reunion-virtual">Reunión Virtual</option>
                            <option value="reunion-presencial">Reunión Presencial</option>
                            <option value="inicio-proyecto">Inicio de Proyecto</option>
                            <option value="finalizar-proyecto">Finalizar Proyecto</option>
                            <option value="cumpleanos">Cumpleaños</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Fecha desde</label>
                        <input type="date" class="form-control" id="date-from">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Fecha hasta</label>
                        <input type="date" class="form-control" id="date-to">
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-end">
                    <button class="btn btn-outline-secondary" onclick="clearFilters()">
                        <i class="fas fa-times"></i> Limpiar
                    </button>
                    <button class="btn btn-outline-primary" onclick="refreshEvents()">
                        <i class="fas fa-sync"></i> Actualizar
                    </button>
                </div>
            </div>

            <div class="table-section">
                <div class="table-header">
                    <h3 class="table-title">Lista de Eventos</h3>
                    <span class="filter-indicator" id="filter-indicator"></span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover" id="events-table">
                        <thead>
                            <tr>
                                <th>Evento</th>
                                <th>Fecha y Hora</th>
                                <th>Ubicación</th>
                                <th>Categoría</th>
                                <th>Estado</th>
                                <th>Organizador</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    <div class="text-muted">
                        <span id="pagination-info">Cargando eventos...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.all.min.js"></script>

    <script>
        let eventsData = [];
        let filteredEvents = [];
        let currentFilter = 'all';
        let calendarMonth = null;
        let calendarYear = null;

        $(document).ready(function() {
            syncWithCalendar();
            setupEventHandlers();
            loadEvents();
            
            window.addEventListener('storage', function(e) {
                if (e.key === 'calendar_current_month' || e.key === 'calendar_current_year') {
                    syncWithCalendar();
                    if (eventsData.length > 0) {
                        updateStats(eventsData);
                        if (currentFilter === 'month') {
                            filterByCategory('month');
                        }
                    }
                }
            });
            
            window.addEventListener('eventosUpdated', function() {
                console.log('🔄 Eventos actualizados, recargando...');
                loadEvents();
            });
        });

        function syncWithCalendar() {
            const storedMonth = localStorage.getItem('calendar_current_month');
            const storedYear = localStorage.getItem('calendar_current_year');
            
            if (storedMonth !== null && storedYear !== null) {
                calendarMonth = parseInt(storedMonth);
                calendarYear = parseInt(storedYear);
            } else {
                const now = new Date();
                calendarMonth = now.getMonth();
                calendarYear = now.getFullYear();
            }
        }

        function setupEventHandlers() {
            $('#search-input, #status-filter, #category-filter, #date-from, #date-to').on('input change', debounce(applyFilters, 500));
        }

        function loadEvents() {
            showLoading();
            
            setTimeout(function() {
                const eventos = localStorage.getItem('eventos');
                eventsData = eventos ? JSON.parse(eventos) : [];
                
                console.log('=== EVENTOS CARGADOS DESDE LOCALSTORAGE ===');
                console.log('Total eventos:', eventsData.length);
                console.log('==========================================');
                
                filteredEvents = [...eventsData];
                displayEvents(filteredEvents);
                updateStats(eventsData);
                updateFilterIndicator();
                hideLoading();
            }, 300);
        }

        function updateStats(events) {
            const now = new Date();
            const currentMonth = calendarMonth !== null ? calendarMonth : now.getMonth();
            const currentYear = calendarYear !== null ? calendarYear : now.getFullYear();
            const today = now.toDateString();
            
            const monthEvents = events.filter(event => {
                const eventDate = new Date(event.fecha_inicio || event.start);
                return eventDate.getMonth() === currentMonth && eventDate.getFullYear() === currentYear;
            });
            
            const upcomingEvents = events.filter(event => {
                const eventDate = new Date(event.fecha_inicio || event.start);
                return eventDate.getMonth() === currentMonth && 
                       eventDate.getFullYear() === currentYear && 
                       eventDate > now;
            });
            
            const todayEvents = events.filter(event => {
                const eventDate = new Date(event.fecha_inicio || event.start);
                return eventDate.toDateString() === today;
            });
            
            const completedEvents = events.filter(event => {
                const eventDate = new Date(event.fecha_inicio || event.start);
                return eventDate.getMonth() === currentMonth && 
                       eventDate.getFullYear() === currentYear && 
                       eventDate < now;
            });
            
            $('#month-events').text(monthEvents.length);
            $('#upcoming-events').text(upcomingEvents.length);
            $('#today-events').text(todayEvents.length);
            $('#completed-events').text(completedEvents.length);
        }

        function filterByCategory(category) {
            $('.stat-card').removeClass('active');
            $(`.stat-card[data-filter="${category}"]`).addClass('active');
            
            currentFilter = category;
            const now = new Date();
            const currentMonth = calendarMonth !== null ? calendarMonth : now.getMonth();
            const currentYear = calendarYear !== null ? calendarYear : now.getFullYear();
            const today = now.toDateString();
            
            let filtered = [...eventsData];
            
            switch(category) {
                case 'month':
                    filtered = eventsData.filter(event => {
                        const eventDate = new Date(event.fecha_inicio || event.start);
                        return eventDate.getMonth() === currentMonth && eventDate.getFullYear() === currentYear;
                    });
                    break;
                    
                case 'upcoming':
                    filtered = eventsData.filter(event => {
                        const eventDate = new Date(event.fecha_inicio || event.start);
                        return eventDate.getMonth() === currentMonth && 
                               eventDate.getFullYear() === currentYear && 
                               eventDate > now;
                    });
                    break;
                    
                case 'today':
                    filtered = eventsData.filter(event => {
                        const eventDate = new Date(event.fecha_inicio || event.start);
                        return eventDate.toDateString() === today;
                    });
                    break;
                    
                case 'completed':
                    filtered = eventsData.filter(event => {
                        const eventDate = new Date(event.fecha_inicio || event.start);
                        return eventDate.getMonth() === currentMonth && 
                               eventDate.getFullYear() === currentYear && 
                               eventDate < now;
                    });
                    break;
                    
                default:
                    filtered = [...eventsData];
                    $('.stat-card').removeClass('active');
                    break;
            }
            
            filteredEvents = filtered;
            displayEvents(filteredEvents);
            updateFilterIndicator();
        }

        function applyFilters() {
            const search = $('#search-input').val().toLowerCase();
            const status = $('#status-filter').val();
            const category = $('#category-filter').val();
            const dateFrom = $('#date-from').val();
            const dateTo = $('#date-to').val();
            
            let filtered = [...filteredEvents];
            
            if (search) {
                filtered = filtered.filter(event => {
                    const titulo = (event.titulo || event.title || '').toLowerCase();
                    const organizador = (event.extendedProps?.organizador || '').toLowerCase();
                    const ubicacion = (event.extendedProps?.detalles?.lugar || event.extendedProps?.detalles?.enlace || '').toLowerCase();
                    
                    return titulo.includes(search) || 
                           organizador.includes(search) ||
                           ubicacion.includes(search);
                });
            }
            
            if (status) {
                filtered = filtered.filter(event => {
                    const eventStatus = event.extendedProps?.estado || event.extendedProps?.status || 'programado';
                    return eventStatus === status;
                });
            }
            
            if (category) {
                filtered = filtered.filter(event => {
                    const eventCategory = event.extendedProps?.tipo_evento || event.extendedProps?.category;
                    return eventCategory === category;
                });
            }
            
            if (dateFrom) {
                filtered = filtered.filter(event => {
                    const eventDate = event.start || event.fecha_inicio;
                    return eventDate >= dateFrom;
                });
            }
            
            if (dateTo) {
                filtered = filtered.filter(event => {
                    const eventDate = event.start || event.fecha_inicio;
                    return eventDate <= dateTo + 'T23:59:59';
                });
            }
            
            displayEvents(filtered);
        }

        function updateFilterIndicator() {
            const indicator = $('#filter-indicator');
            let text = '';
            
            switch(currentFilter) {
                case 'month':
                    text = 'Mostrando: Eventos del mes actual';
                    break;
                case 'upcoming':
                    text = 'Mostrando: Próximos eventos';
                    break;
                case 'today':
                    text = 'Mostrando: Eventos de hoy';
                    break;
                case 'completed':
                    text = 'Mostrando: Eventos completados del mes';
                    break;
                default:
                    text = 'Mostrando: Todos los eventos';
                    break;
            }
            
            indicator.text(text);
        }

        function displayEvents(events) {
            const tbody = $('#events-table tbody');
            tbody.empty();
            
            if (events.length === 0) {
                let emptyMessage = 'No se encontraron eventos';
                let emptyDescription = 'Los eventos creados desde el calendario aparecerán aquí automáticamente';
                
                switch(currentFilter) {
                    case 'month':
                        emptyMessage = 'No hay eventos este mes';
                        emptyDescription = 'Los eventos del mes actual aparecerán aquí';
                        break;
                    case 'upcoming':
                        emptyMessage = 'No hay próximos eventos';
                        emptyDescription = 'Los eventos futuros aparecerán aquí';
                        break;
                    case 'today':
                        emptyMessage = 'No hay eventos hoy';
                        emptyDescription = 'Los eventos programados para hoy aparecerán aquí';
                        break;
                    case 'completed':
                        emptyMessage = 'No hay eventos completados este mes';
                        emptyDescription = 'Los eventos ya realizados del mes aparecerán aquí';
                        break;
                }
                
                tbody.append(`
                    <tr>
                        <td colspan="7" class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <h3>${emptyMessage}</h3>
                            <p>${emptyDescription}</p>
                            <a href="{{ route('vocero.calendario') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-calendar-plus me-2"></i>Ir al Calendario
                            </a>
                        </td>
                    </tr>
                `);
                updatePaginationInfo(0);
                return;
            }
            
            events.forEach(event => {
                const startDate = new Date(event.fecha_inicio || event.start);
                const endDate = new Date(event.fecha_fin || event.end);
                
                const titulo = event.titulo || event.title || 'Sin título';
                const organizador = event.extendedProps?.organizador || event.extendedProps?.organizer || 'No especificado';
                const tipoEvento = event.extendedProps?.tipo_evento || event.extendedProps?.category || 'sin-categoria';
                const estado = event.extendedProps?.estado || event.extendedProps?.status || 'programado';
                
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
                
                tbody.append(`
                    <tr>
                        <td>
                            <div>
                                <h6 class="event-title">${titulo}</h6>
                            </div>
                        </td>
                        <td>
                            <div>
                                <p class="event-date">${startDate.toLocaleDateString('es-ES')}</p>
                                <p class="event-time">${startDate.toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'})} - ${endDate.toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'})}</p>
                            </div>
                        </td>
                        <td>${ubicacion}</td>
                        <td>
                            <span class="category-badge category-${getCategoryClass(tipoEvento)}">
                                ${getCategoryName(tipoEvento)}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge status-${estado}">
                                ${getStatusName(estado)}
                            </span>
                        </td>
                        <td>${organizador}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary btn-sm" onclick="viewEvent('${event.id}')" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="{{ route('vocero.calendario') }}" class="btn btn-outline-warning btn-sm" title="Editar en calendario">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-outline-danger btn-sm" onclick="deleteEvent('${event.id}')" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `);
            });
            
            updatePaginationInfo(events.length);
        }

        function viewEvent(id) {
            const event = eventsData.find(e => e.id == id);
            if (!event) {
                showToast('Evento no encontrado', 'error');
                return;
            }

            const startDate = new Date(event.fecha_inicio || event.start);
            const endDate = new Date(event.fecha_fin || event.end);
            
            const titulo = event.titulo || event.title || 'Sin título';
            const organizador = event.extendedProps?.organizador || 'No especificado';
            const tipoEvento = event.extendedProps?.tipo_evento || 'sin-categoria';
            const estado = event.extendedProps?.estado || 'programado';
            
            let ubicacion = 'No especificada';
            let detallesAdicionales = '';
            
            const detalles = event.extendedProps?.detalles;
            if (detalles) {
                if (detalles.enlace) {
                    ubicacion = 'Reunión Virtual';
                    detallesAdicionales += `<p style="margin: 0;"><strong>Enlace:</strong> <a href="${detalles.enlace}" target="_blank">${detalles.enlace}</a></p>`;
                } else if (detalles.lugar) {
                    ubicacion = detalles.lugar;
                    detallesAdicionales += `<p style="margin: 0;"><strong>Lugar específico:</strong> ${detalles.lugar}</p>`;
                } else if (detalles.ubicacion_proyecto) {
                    ubicacion = detalles.ubicacion_proyecto;
                    detallesAdicionales += `<p style="margin: 0;"><strong>Ubicación del proyecto:</strong> ${detalles.ubicacion_proyecto}</p>`;
                }
            }
            
            Swal.fire({
                title: `<strong>${titulo}</strong>`,
                html: `
                    <div style="text-align: left; margin: 20px 0; font-size: 14px; line-height: 1.6;">
                        <div style="display: grid; gap: 12px;">
                            <p style="margin: 0;"><strong>Fecha inicio:</strong> ${startDate.toLocaleDateString('es-ES')} a las ${startDate.toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'})}</p>
                            <p style="margin: 0;"><strong>Fecha fin:</strong> ${endDate.toLocaleDateString('es-ES')} a las ${endDate.toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'})}</p>
                            <p style="margin: 0;"><strong>Ubicación:</strong> ${ubicacion}</p>
                            <p style="margin: 0;"><strong>Tipo:</strong> ${getCategoryName(tipoEvento)}</p>
                            <p style="margin: 0;"><strong>Estado:</strong> ${getStatusName(estado)}</p>
                            <p style="margin: 0;"><strong>Organizador:</strong> ${organizador}</p>
                            ${detallesAdicionales}
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Editar en Calendario',
                cancelButtonText: 'Cerrar',
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#64748b',
                width: '600px'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route("vocero.calendario") }}';
                }
            });
        }

        function deleteEvent(id) {
            const event = eventsData.find(e => e.id == id);
            if (!event) {
                showToast('Evento no encontrado', 'error');
                return;
            }

            const titulo = event.titulo || event.title || 'Sin título';

            Swal.fire({
                title: '¿Eliminar evento?',
                html: `
                    <div style="text-align: center; margin: 20px 0;">
                        <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 15px; margin-bottom: 15px;">
                            <h4 style="margin: 0 0 8px 0; color: #dc2626;">${titulo}</h4>
                        </div>
                        <p style="color: #6b7280; margin: 0;">Esta acción no se puede deshacer</p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    
                    let eventos = JSON.parse(localStorage.getItem('eventos') || '[]');
                    eventos = eventos.filter(e => e.id != id);
                    localStorage.setItem('eventos', JSON.stringify(eventos));
                    window.dispatchEvent(new Event('eventosUpdated'));
                    
                    eventsData = eventsData.filter(e => e.id != id);
                    filteredEvents = filteredEvents.filter(e => e.id != id);
                    displayEvents(filteredEvents);
                    updateStats(eventsData);
                    showToast('Evento eliminado correctamente', 'success');
                    hideLoading();
                }
            });
        }

        function clearFilters() {
            $('#search-input').val('');
            $('#status-filter').val('');
            $('#category-filter').val('');
            $('#date-from').val('');
            $('#date-to').val('');
            
            $('.stat-card').removeClass('active');
            currentFilter = 'all';
            filteredEvents = [...eventsData];
            
            displayEvents(filteredEvents);
            updateFilterIndicator();
            showToast('Filtros limpiados', 'info');
        }

        function refreshEvents() {
            showToast('Actualizando eventos...', 'info');
            loadEvents();
        }

        function exportEvents() {
            const eventsToExport = filteredEvents.length > 0 ? filteredEvents : eventsData;
            
            if (eventsToExport.length === 0) {
                showToast('No hay eventos para exportar', 'warning');
                return;
            }

            Swal.fire({
                title: 'Exportar Eventos',
                text: 'Selecciona el formato de exportación',
                icon: 'question',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'CSV',
                denyButtonText: 'Excel',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    exportToCSV(eventsToExport);
                } else if (result.isDenied) {
                    showToast('Función de Excel próximamente...', 'info');
                }
            });
        }

        function exportToCSV(events) {
            const headers = ['Título', 'Fecha Inicio', 'Fecha Fin', 'Ubicación', 'Categoría', 'Estado', 'Organizador'];
            const rows = events.map(event => [
                event.titulo || event.title || '',
                event.fecha_inicio || event.start || '',
                event.fecha_fin || event.end || '',
                event.extendedProps?.detalles?.lugar || event.extendedProps?.detalles?.enlace || '',
                getCategoryName(event.extendedProps?.tipo_evento || ''),
                getStatusName(event.extendedProps?.estado || ''),
                event.extendedProps?.organizador || ''
            ]);

            const csvContent = [headers, ...rows]
                .map(row => row.map(field => `"${field}"`).join(','))
                .join('\n');

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            
            let filename = 'eventos';
            switch(currentFilter) {
                case 'month':
                    filename += '_mes_actual';
                    break;
                case 'upcoming':
                    filename += '_proximos';
                    break;
                case 'today':
                    filename += '_hoy';
                    break;
                case 'completed':
                    filename += '_completados';
                    break;
            }
            filename += `_${new Date().toISOString().split('T')[0]}.csv`;
            
            link.download = filename;
            link.click();
            
            showToast('Archivo CSV descargado correctamente', 'success');
        }

        function updatePaginationInfo(total) {
            let message = `Mostrando ${total} evento${total !== 1 ? 's' : ''}`;
            
            if (currentFilter !== 'all') {
                const totalAll = eventsData.length;
                message += ` de ${totalAll} totales`;
            }
            
            $('#pagination-info').text(message);
        }

        function getCategoryClass(category) {
            const mapping = {
                'reunion-virtual': 'reunion-virtual',
                'reunion-presencial': 'reunion-presencial',
                'inicio-proyecto': 'inicio-proyecto',
                'finalizar-proyecto': 'finalizar-proyecto',
                'cumpleanos': 'cumpleanos'
            };
            return mapping[category] || 'sin-categoria';
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

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
    </script>
</body>
</html>