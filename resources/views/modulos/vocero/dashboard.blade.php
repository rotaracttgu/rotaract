<x-app-layout>
    @if(request()->has('embed'))
    <style>
        /* Ocultar solo navbar cuando está en iframe, mantener sidebar */
        nav[x-data]:not(.sidebar-vocero), header:not(.sidebar-vocero) { display: none !important; }
        main { padding-top: 0 !important; }
    </style>
    @endif
    {{-- La barra superior de Laravel/Breeze ya se incluye automáticamente aquí --}}

    {{-- ***************************************************************** --}}
    {{-- ************** INICIO: CSS DE ESTILOS Y POSICIONAMIENTO *********** --}}
    {{-- ***************************************************************** --}}
    
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

        /* AJUSTE CLAVE 1: Estilos del Menú Lateral (Sidebar) */
        .sidebar-vocero {
            background: var(--sidebar-bg);
            width: 200px;
            position: fixed;
            left: 0;
            top: 0; 
            z-index: 20; 
            height: 100vh;
            padding-top: 64px; 
            transition: all 0.3s ease;
        }
        
        /* AJUSTE CLAVE 2: Modifica la barra de navegación de Breeze */
        nav.bg-white {
            margin-left: 200px; 
            width: calc(100% - 200px);
            z-index: 30; 
        }
        
        /* AJUSTE CLAVE 3: Estilos del contenido principal */
        .main-content-vocero {
            margin-left: 200px; 
            min-height: 100vh;
            padding: 0;
            flex-grow: 1;
            padding-top: 64px; 
        }

        /* Estilos internos del sidebar */
        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            position: absolute; 
            top: 0;
            width: 100%;
            height: 64px; 
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 40; 
        }

        .sidebar-brand h4 {
            color: var(--sidebar-text);
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 1.5rem;
        }

        .sidebar-brand h4 i {
            font-size: 1.75rem;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .sidebar-vocero .nav-link {
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
        }

        .sidebar-vocero .nav-link:hover {
            background: rgba(59, 130, 246, 0.1);
            color: #60a5fa;
        }

        .sidebar-vocero .nav-link.active {
            background: var(--primary-color);
            color: white;
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

        /* Estilos degradados de las tarjetas */
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            height: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
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
        .badge { font-weight: 500; border-radius: 6px; padding: 6px 12px; }
        .table th { background: #f8fafc; border: none; color: var(--secondary-color); font-weight: 600; padding: 15px; }
        .table td { padding: 15px; vertical-align: middle; }
        .table tbody tr:hover { background: #f8fafc; }
        .empty-state { text-align: center; padding: 60px 20px; color: var(--secondary-color); }
        .empty-state i { font-size: 4rem; margin-bottom: 1rem; opacity: 0.5; }
        
        /* Animaciones */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .stats-card, .card {
            animation: fadeIn 0.5s ease-out;
        }

        /* 🆕 OCULTAR BOTÓN "PANEL" DEL HEADER DE BREEZE */
        nav.bg-white a[href*="panel"], 
        nav.bg-white button:contains("Panel"),
        nav.bg-white .hidden.space-x-8 a:first-child {
            display: none !important;
        }

        /* Media Query: Importante para móviles */
        @media (max-width: 768px) {
            .sidebar-vocero { position: relative; width: 100%; height: auto; padding-top: 0; }
            .main-content-vocero { margin-left: 0; padding-top: 0; }
            nav.bg-white { margin-left: 0; width: 100%; }
        }
    </style>

    {{-- ***************************************************************** --}}
    {{-- ************** INICIO: HTML DE LA ESTRUCTURA PRINCIPAL ************ --}}
    {{-- ***************************************************************** --}}

    <div class="d-flex">
        {{-- ⭐ 1. MENÚ LATERAL (SIDEBAR) ⭐ --}}
        <div class="sidebar-vocero">
            <div class="sidebar-brand">
                <h4><i class="fas fa-calendar-alt text-primary"></i> Macero</h4>
            </div>
            
            <nav class="sidebar-nav">
                <a class="nav-link active" href="{{ route('vocero.dashboard') }}"> 
                    <i class="fas fa-chart-line"></i>
                    Resumen General
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
                <a class="nav-link" href="{{ route('vocero.reportes') }}">
                    <i class="fas fa-chart-bar"></i>
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
                        <h2><i class="fas fa-chart-line me-2"></i>RESUMEN GENERAL</h2>
                        <p class="text-muted mb-0">Resumen general del módulo Vocero</p>
                    </div>
                    <button class="btn btn-outline-primary" onclick="refreshDashboard()">
                        <i class="fas fa-sync-alt me-2"></i>Actualizar
                    </button>
                </div>

                {{-- TARJETAS DE ESTADÍSTICAS PRINCIPALES --}}
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="stats-card p-4 text-center" onclick="filtrarEventos('todos')" title="Click para ver todos los eventos">
                            <i class="fas fa-calendar-alt fa-3x mb-3"></i>
                            <h3 id="total-eventos" class="display-4 fw-bold">0</h3>
                            <p class="mb-0">Total de Eventos</p>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <div class="stats-card stats-card-success p-4 text-center" onclick="filtrarEventos('proximos')" title="Click para ver eventos próximos">
                            <i class="fas fa-clock fa-3x mb-3"></i>
                            <h3 id="eventos-proximos" class="display-4 fw-bold">0</h3>
                            <p class="mb-0">Eventos Próximos</p>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <div class="stats-card stats-card-warning p-4 text-center" onclick="mostrarInfoAsistencias()" title="Información de asistencias">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <h3 id="total-asistencias" class="display-4 fw-bold">0</h3>
                            <p class="mb-0">Asistencias Presentes</p>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <div class="stats-card stats-card-info p-4 text-center" onclick="filtrarEventos('finalizados')" title="Click para ver eventos finalizados">
                            <i class="fas fa-check-circle fa-3x mb-3"></i>
                            <h3 id="eventos-finalizados" class="display-4 fw-bold">0</h3>
                            <p class="mb-0">Eventos Finalizados</p>
                        </div>
                    </div>
                </div>

                {{-- TABLA DE PRÓXIMOS EVENTOS --}}
                <div class="card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0"><i class="fas fa-calendar-week me-2"></i>Próximos Eventos</h5>
                            <span id="filtro-activo-badge" class="badge bg-info ms-3" style="display: none;"></span>
                        </div>
                        <button id="btn-limpiar-filtro" class="btn btn-sm btn-warning" onclick="limpiarFiltroEventos()" style="display: none;">
                            <i class="fas fa-times me-1"></i>Mostrar Próximos
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
                                            <i class="fas fa-spinner fa-spin fa-3x text-muted mb-3"></i>
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

    {{-- ***************************************************************** --}}
    {{-- ************** INICIO: SCRIPTS DE FUNCIONALIDAD ****************** --}}
    {{-- ***************************************************************** --}}

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

            // ============================================================================
            // 🆕 FUNCIÓN: Ocultar botón "Panel" del header
            // ============================================================================
            function ocultarBotonPanel() {
                // Intentar múltiples selectores para encontrar y ocultar el botón "Panel"
                setTimeout(function() {
                    // Buscar por texto
                    $('nav.bg-white a').each(function() {
                        if ($(this).text().trim().toLowerCase() === 'panel') {
                            $(this).hide();
                        }
                    });
                    
                    // Buscar por href que contenga "panel"
                    $('nav.bg-white a[href*="panel"]').hide();
                    
                    // Buscar el primer link en el nav (generalmente es Dashboard/Panel)
                    $('nav.bg-white .hidden.space-x-8 > a:first-child').hide();
                }, 100);
            }

            // ============================================================================
            // 🔄 FUNCIÓN: Cargar dashboard desde la BD
            // ============================================================================
            function loadDashboard() {
                // Cargar estadísticas generales
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

                // Cargar eventos próximos
                loadRecentEvents();
            }

            // ============================================================================
            // ✅ FUNCIÓN: Actualizar estadísticas del dashboard
            // ============================================================================
            function updateDashboardStats(stats) {
                $('#total-eventos').text(stats.TotalEventos || 0);
                $('#eventos-finalizados').text(stats.TotalFinalizados || 0);
            }

            // ============================================================================
            // ✅ FUNCIÓN: Cargar eventos próximos desde la BD
            // ============================================================================
            function loadRecentEvents() {
                const tbody = $('#proximos-eventos-table');
                
                // Obtener todos los eventos
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
                                        <i class="fas fa-calendar-times"></i>
                                        <h5>No hay eventos registrados</h5>
                                        <p>Los eventos aparecerán aquí cuando los crees</p>
                                        <a href="{{ route('vocero.calendario') }}" class="btn btn-primary mt-3">
                                            <i class="fas fa-calendar-plus me-2"></i>Crear Evento
                                        </a>
                                    </td>
                                </tr>
                            `);
                            return;
                        }

                        // Guardar todos los eventos
                        eventsData = response.eventos;
                        
                        // Contar asistencias presentes
                        const totalAsistenciasPresentes = response.eventos.reduce((sum, evento) => {
                            return sum + (parseInt(evento.TotalPresentes) || 0);
                        }, 0);
                        
                        $('#total-asistencias').text(totalAsistenciasPresentes);

                        // Calcular eventos próximos
                        const now = new Date();
                        const eventosProximosReales = eventsData.filter(event => {
                            const eventDate = new Date(event.FechaInicio);
                            return eventDate >= now && event.EstadoEvento === 'Programado';
                        }).length;
                        
                        $('#eventos-proximos').text(eventosProximosReales);

                        // Mostrar eventos próximos por defecto
                        filtrarEventos('proximos');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al cargar eventos:', error);
                        tbody.html(`
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="fas fa-exclamation-triangle text-danger"></i>
                                    <h5>Error al cargar eventos</h5>
                                    <p>Por favor, intenta recargar la página</p>
                                </td>
                            </tr>
                        `);
                    }
                });
            }

            // ============================================================================
            // ✅ FUNCIÓN: Refrescar dashboard
            // ============================================================================
            function refreshDashboard() {
                showToast('Actualizando dashboard...', 'info');
                loadDashboard();
                setTimeout(() => {
                    showToast('Dashboard actualizado correctamente', 'success');
                }, 500);
            }

            // ============================================================================
            // 🆕 FUNCIÓN: Filtrar eventos según la tarjeta clickeada
            // ============================================================================
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

                // Ordenar por fecha
                eventosFiltrados.sort((a, b) => new Date(a.FechaInicio) - new Date(b.FechaInicio));

                // Mostrar badge de filtro activo
                if (tipo !== 'proximos') {
                    $('#filtro-activo-badge').text(tituloFiltro).show();
                    $('#btn-limpiar-filtro').show();
                } else {
                    $('#filtro-activo-badge').hide();
                    $('#btn-limpiar-filtro').hide();
                }

                // Mostrar eventos filtrados
                if (eventosFiltrados.length === 0) {
                    tbody.append(`
                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <h5>No hay eventos en esta categoría</h5>
                                <p>${tituloFiltro}</p>
                            </td>
                        </tr>
                    `);
                    showToast(`No hay eventos para mostrar: ${tituloFiltro}`, 'info');
                    return;
                }

                // Mostrar eventos filtrados
                eventosFiltrados.forEach(event => {
                    const fecha = formatDateTime(new Date(event.FechaInicio));
                    const tipo = getCategoryName(event.TipoEvento);
                    const tipoBadge = getCategoryColor(event.TipoEvento);
                    const estado = getStatusName(event.EstadoEvento);
                    const estadoBadge = getStatusColor(event.EstadoEvento);
                    const totalRegistros = event.TotalRegistros || 0;
                    
                    // Extraer nombre del organizador con validación estricta
                    let organizadorNombre = 'No especificado';
                    if (event.Organizador && typeof event.Organizador === 'string') {
                        const orgCompleto = String(event.Organizador).trim();
                        
                        // 🔥 FILTRAR texto extraño específico
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
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('vocero.asistencias') }}" class="btn btn-outline-success" title="Gestionar asistencia">
                                        <i class="fas fa-users"></i>
                                        <span class="badge bg-success">${totalRegistros}</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `);
                });

                showToast(`Mostrando ${eventosFiltrados.length} eventos: ${tituloFiltro}`, 'success');
            }

            // ============================================================================
            // 🆕 FUNCIÓN: Limpiar filtro y volver a eventos próximos
            // ============================================================================
            function limpiarFiltroEventos() {
                filtrarEventos('proximos');
                $('#filtro-activo-badge').hide();
                $('#btn-limpiar-filtro').hide();
            }

            // ============================================================================
            // 🆕 FUNCIÓN: Mostrar información de asistencias
            // ============================================================================
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

            // ============================================================================
            // FUNCIONES AUXILIARES
            // ============================================================================
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
