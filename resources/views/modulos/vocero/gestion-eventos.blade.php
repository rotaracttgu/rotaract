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

        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            overflow-x: hidden !important;
            width: 100%;
            max-width: 100vw;
        }

        body {
            background: var(--light-bg);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .container-fluid {
            padding: 0;
            max-width: 100%;
            overflow-x: hidden;
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
            width: calc(100% - 250px);
            max-width: calc(100% - 250px);
            overflow-x: hidden;
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

        .table-responsive {
            overflow-x: auto;
            max-width: 100%;
            -webkit-overflow-scrolling: touch;
        }

        .events-table {
            width: 100%;
            margin-bottom: 0;
        }

        .events-table thead th {
            background: var(--light-bg);
            color: var(--dark-color);
            font-weight: 600;
            padding: 15px 20px;
            border: none;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .events-table tbody td {
            padding: 18px 20px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .events-table tbody tr:last-child td {
            border-bottom: none;
        }

        .events-table tbody tr:hover {
            background-color: rgba(37, 99, 235, 0.02);
        }

        .event-title {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 4px;
        }

        .event-description {
            font-size: 0.875rem;
            color: var(--secondary-color);
            margin: 0;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-status-programado { background: #dbeafe; color: #1e40af; }
        .badge-status-en_curso { background: #fef3c7; color: #92400e; }
        .badge-status-en-curso { background: #fef3c7; color: #92400e; }
        .badge-status-encurso { background: #fef3c7; color: #92400e; }
        .badge-status-finalizado { background: #d1fae5; color: #065f46; }
        .badge-status-cancelado { background: #fee2e2; color: #991b1b; }

        .badge-category-reunion-virtual { background: #dbeafe; color: #1e40af; }
        .badge-category-reunion-presencial { background: #d1fae5; color: #065f46; }
        .badge-category-inicio-proyecto { background: #fef3c7; color: #92400e; }
        .badge-category-finalizar-proyecto { background: #fee2e2; color: #991b1b; }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 8px 12px;
            font-size: 13px;
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-info {
            background: var(--info-color);
            border: none;
            color: white;
        }

        .btn-info:hover {
            background: #0891b2;
            color: white;
        }

        .btn-danger {
            background: var(--danger-color);
            border: none;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-outline-secondary {
            border: 1px solid var(--border-color);
            color: var(--secondary-color);
        }

        .btn-outline-secondary:hover {
            background: var(--light-bg);
            border-color: var(--secondary-color);
            color: var(--dark-color);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state-icon {
            font-size: 4rem;
            color: var(--secondary-color);
            opacity: 0.3;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: var(--dark-color);
            font-weight: 600;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: var(--secondary-color);
            margin-bottom: 20px;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .loading-overlay.active {
            display: flex;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid var(--border-color);
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .filter-indicator {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: var(--primary-color);
            color: white;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
            .stat-number {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="loading-overlay" id="loading-overlay">
        <div class="spinner"></div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="sidebar">
                <div class="sidebar-brand">
                    <h4><i class="fas fa-calendar-alt"></i> Vocero</h4>
                </div>
                <nav class="sidebar-nav">
                    <a class="nav-link {{ request()->routeIs('vocero.dashboard') ? 'active' : '' }}" href="{{ route('vocero.dashboard') }}">
                        <i class="fas fa-chart-line"></i>
                        Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('vocero.calendario') ? 'active' : '' }}" href="{{ route('vocero.calendario') }}">
                        <i class="fas fa-calendar"></i>
                        Calendario
                    </a>
                    <a class="nav-link {{ request()->routeIs('vocero.eventos') ? 'active' : '' }}" href="{{ route('vocero.eventos') }}">
                        <i class="fas fa-calendar-plus"></i>
                        Gestión de Eventos
                    </a>
                    <a class="nav-link {{ request()->routeIs('vocero.asistencias') ? 'active' : '' }}" href="{{ route('vocero.asistencias') }}">
                        <i class="fas fa-users"></i>
                        Asistencias
                    </a>
                    <a class="nav-link {{ request()->routeIs('vocero.reportes') ? 'active' : '' }}" href="{{ route('vocero.reportes') }}">
                        <i class="fas fa-chart-bar"></i>
                        Reportes
                    </a>
                </nav>
            </div>

            <div class="main-content">
                <div class="content-area">
                    <div class="page-header">
                        <h1><i class="fas fa-calendar-check me-2"></i>Gestión de Eventos</h1>
                        <p class="page-subtitle">Administra y visualiza todos tus eventos programados</p>
                        
                        <div class="header-actions">
                            <a href="{{ route('vocero.calendario') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Crear Nuevo Evento
                            </a>
                            <button class="btn btn-outline-secondary" onclick="refreshEvents()">
                                <i class="fas fa-sync-alt me-2"></i>Actualizar
                            </button>
                            <button class="btn btn-outline-secondary" onclick="exportEvents()">
                                <i class="fas fa-download me-2"></i>Exportar
                            </button>
                        </div>
                    </div>

                    <div class="stats-row">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="stat-card" data-filter="all" onclick="filterByCard('all')">
                                    <div class="stat-header">
                                        <h6 class="stat-title">Total de Eventos</h6>
                                        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div>
                                    <div class="stat-number" id="total-events">0</div>
                                    <p class="stat-change"><i class="fas fa-info-circle me-1"></i>Todos los eventos</p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="stat-card" data-filter="month" onclick="filterByCard('month')">
                                    <div class="stat-header">
                                        <h6 class="stat-title">Este Mes</h6>
                                        <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                            <i class="fas fa-calendar-week"></i>
                                        </div>
                                    </div>
                                    <div class="stat-number" id="month-events">0</div>
                                    <p class="stat-change"><i class="fas fa-chart-line me-1"></i>Eventos mensuales</p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="stat-card" data-filter="upcoming" onclick="filterByCard('upcoming')">
                                    <div class="stat-header">
                                        <h6 class="stat-title">Próximos</h6>
                                        <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                    </div>
                                    <div class="stat-number" id="upcoming-events">0</div>
                                    <p class="stat-change"><i class="fas fa-arrow-up me-1"></i>Por realizar</p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="stat-card" data-filter="completed" onclick="filterByCard('completed')">
                                    <div class="stat-header">
                                        <h6 class="stat-title">Completados</h6>
                                        <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                    </div>
                                    <div class="stat-number" id="completed-events">0</div>
                                    <p class="stat-change"><i class="fas fa-check me-1"></i>Finalizados</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="filter-section">
                        <h5 class="filter-title">
                            <i class="fas fa-filter"></i>
                            Filtros de Búsqueda
                            <span class="filter-indicator" id="filter-indicator" style="display: none;">
                                <i class="fas fa-check"></i>
                                <span id="filter-count">0</span> filtros activos
                            </span>
                        </h5>
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Buscar por título</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control" id="search-input" placeholder="Buscar eventos...">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Estado</label>
                                <select class="form-select" id="status-filter">
                                    <option value="">Todos</option>
                                    <option value="programado">Programado</option>
                                    <option value="en_curso">En Curso</option>
                                    <option value="finalizado">Finalizado</option>
                                    <option value="cancelado">Cancelado</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Categoría</label>
                                <select class="form-select" id="category-filter">
                                    <option value="">Todas</option>
                                    <option value="reunion-virtual">Reunión Virtual</option>
                                    <option value="reunion-presencial">Reunión Presencial</option>
                                    <option value="inicio-proyecto">Inicio Proyecto</option>
                                    <option value="finalizar-proyecto">Fin Proyecto</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Desde</label>
                                <input type="date" class="form-control" id="date-from">
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Hasta</label>
                                <input type="date" class="form-control" id="date-to">
                            </div>
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-primary btn-sm" onclick="applyFilters()">
                                <i class="fas fa-check me-1"></i>Aplicar Filtros
                            </button>
                            <button class="btn btn-outline-secondary btn-sm" onclick="clearFilters()">
                                <i class="fas fa-times me-1"></i>Limpiar Filtros
                            </button>
                        </div>
                    </div>

                    <div class="table-section">
                        <div class="table-header">
                            <h5 class="table-title">
                                <i class="fas fa-list me-2"></i>
                                Lista de Eventos
                                <small class="text-muted ms-2" id="pagination-info">Cargando...</small>
                            </h5>
                        </div>

                        <div class="table-responsive">
                            <table class="table events-table">
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
                                <tbody id="events-table-body">
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Cargando...</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div id="empty-state" class="empty-state" style="display: none;">
                            <div class="empty-state-icon">
                                <i class="fas fa-calendar-times"></i>
                            </div>
                            <h3>No hay eventos</h3>
                            <p>No se encontraron eventos con los filtros seleccionados</p>
                            <button class="btn btn-primary" onclick="clearFilters()">
                                <i class="fas fa-redo me-2"></i>Limpiar Filtros
                            </button>
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
        // 🔄 CÓDIGO MODIFICADO - CONECTADO A BASE DE DATOS
        // ============================================================================
        
        let eventsData = [];
        let filteredEvents = [];
        let currentFilter = 'all';

        $(document).ready(function() {
            loadEvents();
            initializeEventListeners();
        });

        function initializeEventListeners() {
            const debouncedFilter = debounce(applyFilters, 300);
            
            $('#search-input').on('input', debouncedFilter);
            $('#status-filter, #category-filter, #date-from, #date-to').on('change', applyFilters);
        }

        // ============================================================================
        // ✅ FUNCIÓN MODIFICADA: Cargar eventos desde la base de datos
        // ============================================================================
        function loadEvents() {
            showLoading();
            
            $.ajax({
                url: '/api/calendario/eventos',
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(eventos) {
                    eventsData = eventos;
                    filteredEvents = [...eventsData];
                    updateStats(eventsData);
                    displayEvents(filteredEvents);
                    hideLoading();
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar eventos:', error);
                    showToast('Error al cargar eventos', 'error');
                    hideLoading();
                }
            });
        }

        function updateStats(events) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const thisMonth = today.getMonth();
            const thisYear = today.getFullYear();

            const monthEvents = events.filter(e => {
                const eventDate = new Date(e.start || e.fecha_inicio);
                return eventDate.getMonth() === thisMonth && eventDate.getFullYear() === thisYear;
            });

            const upcomingEvents = events.filter(e => {
                const eventDate = new Date(e.start || e.fecha_inicio);
                return eventDate >= today && (e.extendedProps?.estado !== 'finalizado');
            });

            const completedEvents = events.filter(e => 
                e.extendedProps?.estado === 'finalizado'
            );

            $('#total-events').text(events.length);
            $('#month-events').text(monthEvents.length);
            $('#upcoming-events').text(upcomingEvents.length);
            $('#completed-events').text(completedEvents.length);
        }

        function filterByCard(filterType) {
            $('.stat-card').removeClass('active');
            $(`.stat-card[data-filter="${filterType}"]`).addClass('active');
            
            currentFilter = filterType;
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            switch(filterType) {
                case 'all':
                    filteredEvents = [...eventsData];
                    break;
                
                case 'month':
                    const thisMonth = today.getMonth();
                    const thisYear = today.getFullYear();
                    filteredEvents = eventsData.filter(e => {
                        const eventDate = new Date(e.start || e.fecha_inicio);
                        return eventDate.getMonth() === thisMonth && eventDate.getFullYear() === thisYear;
                    });
                    break;
                
                case 'upcoming':
                    filteredEvents = eventsData.filter(e => {
                        const eventDate = new Date(e.start || e.fecha_inicio);
                        return eventDate >= today && (e.extendedProps?.estado !== 'finalizado');
                    });
                    break;
                
                case 'today':
                    filteredEvents = eventsData.filter(e => {
                        const eventDate = new Date(e.start || e.fecha_inicio);
                        return eventDate.toDateString() === today.toDateString();
                    });
                    break;
                
                case 'completed':
                    filteredEvents = eventsData.filter(e => 
                        e.extendedProps?.estado === 'finalizado'
                    );
                    break;
            }

            displayEvents(filteredEvents);
        }

        function applyFilters() {
            const searchTerm = $('#search-input').val().toLowerCase();
            const statusFilter = $('#status-filter').val();
            const categoryFilter = $('#category-filter').val();
            const dateFrom = $('#date-from').val();
            const dateTo = $('#date-to').val();

            filteredEvents = eventsData.filter(event => {
                const title = (event.title || event.titulo || '').toLowerCase();
                const matchesSearch = !searchTerm || title.includes(searchTerm);
                
                const matchesStatus = !statusFilter || event.extendedProps?.estado === statusFilter;
                const matchesCategory = !categoryFilter || event.extendedProps?.tipo_evento === categoryFilter;
                
                let matchesDate = true;
                if (dateFrom || dateTo) {
                    const eventDate = new Date(event.start || event.fecha_inicio);
                    if (dateFrom) {
                        matchesDate = matchesDate && eventDate >= new Date(dateFrom);
                    }
                    if (dateTo) {
                        matchesDate = matchesDate && eventDate <= new Date(dateTo);
                    }
                }

                return matchesSearch && matchesStatus && matchesCategory && matchesDate;
            });

            displayEvents(filteredEvents);
            updateFilterIndicator();
        }

        function updateFilterIndicator() {
            let activeFilters = 0;
            
            if ($('#search-input').val()) activeFilters++;
            if ($('#status-filter').val()) activeFilters++;
            if ($('#category-filter').val()) activeFilters++;
            if ($('#date-from').val()) activeFilters++;
            if ($('#date-to').val()) activeFilters++;

            if (activeFilters > 0) {
                $('#filter-count').text(activeFilters);
                $('#filter-indicator').show();
            } else {
                $('#filter-indicator').hide();
            }
        }

        function displayEvents(events) {
            const tbody = $('#events-table-body');
            tbody.empty();

            if (events.length === 0) {
                tbody.html(`
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-calendar-times"></i>
                                </div>
                                <h3>No hay eventos</h3>
                                <p>No se encontraron eventos con los criterios seleccionados</p>
                            </div>
                        </td>
                    </tr>
                `);
                updatePaginationInfo(0);
                return;
            }

            events.forEach(event => {
                const titulo = event.title || event.titulo || 'Sin título';
                const fechaInicio = new Date(event.start || event.fecha_inicio);
                const fechaFin = event.end || event.fecha_fin ? new Date(event.end || event.fecha_fin) : null;
                
                const tipoEvento = event.extendedProps?.tipo_evento || '';
                const estado = event.extendedProps?.estado || 'programado';
                const organizador = event.extendedProps?.organizador || 'Sin organizador';
                
                let ubicacion = '';
                if (event.extendedProps?.detalles) {
                    if (event.extendedProps.detalles.lugar) {
                        ubicacion = event.extendedProps.detalles.lugar;
                    } else if (event.extendedProps.detalles.enlace) {
                        ubicacion = `<a href="${event.extendedProps.detalles.enlace}" target="_blank" class="text-primary"><i class="fas fa-link"></i> Virtual</a>`;
                    } else if (event.extendedProps.detalles.ubicacion_proyecto) {
                        ubicacion = event.extendedProps.detalles.ubicacion_proyecto;
                    }
                }

                const fechaFormateada = fechaInicio.toLocaleDateString('es-ES', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
                
                const horaFormateada = fechaInicio.toLocaleTimeString('es-ES', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const row = `
                    <tr>
                        <td>
                            <div class="event-title">${titulo}</div>
                        </td>
                        <td>
                            <div><i class="fas fa-calendar me-2 text-muted"></i>${fechaFormateada}</div>
                            <div class="text-muted small"><i class="fas fa-clock me-2"></i>${horaFormateada}</div>
                        </td>
                        <td>${ubicacion || '<span class="text-muted">Sin ubicación</span>'}</td>
                        <td><span class="badge badge-category-${getCategoryClass(tipoEvento)}">${getCategoryName(tipoEvento)}</span></td>
                        <td><span class="badge badge-status-${getStatusClass(estado)}">${getStatusName(estado)}</span></td>
                        <td>${organizador}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn btn-info btn-sm" onclick="viewEvent(${event.id})" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteEvent(${event.id})" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                
                tbody.append(row);
            });

            updatePaginationInfo(events.length);
        }

        function viewEvent(id) {
            const event = eventsData.find(e => e.id == id);
            if (!event) {
                showToast('Evento no encontrado', 'error');
                return;
            }

            const titulo = event.title || event.titulo || 'Sin título';
            const fechaInicio = new Date(event.start || event.fecha_inicio);
            const fechaFin = event.end || event.fecha_fin ? new Date(event.end || event.fecha_fin) : null;
            
            const tipoEvento = event.extendedProps?.tipo_evento || '';
            const estado = event.extendedProps?.estado || 'programado';
            const organizador = event.extendedProps?.organizador || 'Sin organizador';
            
            let ubicacion = 'Sin ubicación';
            let detallesAdicionales = '';
            
            if (event.extendedProps?.detalles) {
                if (event.extendedProps.detalles.lugar) {
                    ubicacion = event.extendedProps.detalles.lugar;
                } else if (event.extendedProps.detalles.enlace) {
                    ubicacion = 'Reunión Virtual';
                    detallesAdicionales = `<p style="margin: 0;"><strong>Enlace:</strong> <a href="${event.extendedProps.detalles.enlace}" target="_blank">${event.extendedProps.detalles.enlace}</a></p>`;
                } else if (event.extendedProps.detalles.ubicacion_proyecto) {
                    ubicacion = event.extendedProps.detalles.ubicacion_proyecto;
                }
            }

            const fechaFormateada = fechaInicio.toLocaleDateString('es-ES', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            Swal.fire({
                title: titulo,
                html: `
                    <div style="text-align: left;">
                        <div style="background: #f1f5f9; border-radius: 8px; padding: 15px; margin-bottom: 15px;">
                            <p style="margin: 0;"><strong>Fecha:</strong> ${fechaFormateada}</p>
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

        // ============================================================================
        // ✅ FUNCIÓN MODIFICADA: Eliminar evento de la base de datos
        // ============================================================================
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
                    
                    // ✅ CAMBIO: Eliminar del servidor
                    $.ajax({
                        url: `/api/calendario/eventos/${id}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                eventsData = eventsData.filter(e => e.id != id);
                                filteredEvents = filteredEvents.filter(e => e.id != id);
                                displayEvents(filteredEvents);
                                updateStats(eventsData);
                                showToast('Evento eliminado correctamente', 'success');
                            } else {
                                showToast(response.mensaje || 'Error al eliminar el evento', 'error');
                            }
                            hideLoading();
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al eliminar evento:', error);
                            const mensaje = xhr.responseJSON?.mensaje || 'Error al eliminar el evento';
                            showToast(mensaje, 'error');
                            hideLoading();
                        }
                    });
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
            // Normalizar el estado a minúsculas y sin espacios
            const normalizedStatus = String(status).toLowerCase().trim();
            
            const mapping = {
                'programado': 'Programado',
                'en_curso': 'En Curso',
                'en-curso': 'En Curso',
                'en curso': 'En Curso',
                'encurso': 'En Curso',
                'finalizado': 'Finalizado',
                'cancelado': 'Cancelado'
            };
            return mapping[normalizedStatus] || 'Sin estado';
        }

        function getStatusClass(status) {
            // Convertir el estado a formato CSS compatible
            const normalizedStatus = String(status).toLowerCase().trim();
            
            // Convertir espacios y guiones a guiones bajos para CSS
            return normalizedStatus.replace(/[\s-]+/g, '_');
        }

        function showLoading() {
            $('#loading-overlay').addClass('active');
        }

        function hideLoading() {
            $('#loading-overlay').removeClass('active');
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