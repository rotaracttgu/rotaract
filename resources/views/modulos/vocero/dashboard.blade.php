<x-app-layout>
    {{-- La barra superior de Laravel/Breeze ya se incluye automáticamente aquí --}}

    {{-- ***************************************************************** --}}
    {{-- ************** INICIO: CSS DE ESTILOS Y POSICIONAMIENTO *********** --}}
    {{-- ***************************************************************** --}}
    
    <style>
        /* Variables de colores (copiadas de tu código original) */
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
        
        /* Estilos base (copiados de tu código original) */
        body {
            background-color: #f8fafc;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* AJUSTE CLAVE 1: Estilos del Menú Lateral (Sidebar) */
        .sidebar-vocero {
            background: var(--sidebar-bg);
            width: 250px;
            position: fixed;
            left: 0;
            top: 0; 
            z-index: 20; 
            height: 100vh;
            /* Desplaza el contenido del sidebar para que no quede debajo de la navbar de Breeze (aprox 64px) */
            padding-top: 64px; 
            transition: all 0.3s ease;
        }
        
        /* AJUSTE CLAVE 2: Modifica la barra de navegación de Breeze para que empiece a la derecha del menú */
        nav.bg-white {
            margin-left: 250px; 
            width: calc(100% - 250px);
            z-index: 30; 
        }
        
        /* AJUSTE CLAVE 3: Estilos del contenido principal (Main Content) */
        .main-content-vocero {
            /* Desplaza todo el contenido para que empiece después del menú de 250px */
            margin-left: 250px; 
            min-height: 100vh;
            padding: 0;
            flex-grow: 1;
            /* Desplaza todo el contenido hacia abajo para que empiece debajo de la navbar de Breeze */
            padding-top: 64px; 
        }

        /* Estilos internos del sidebar (Brand y Navegación) */
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

        /* Resto de estilos... */
        .badge { font-weight: 500; border-radius: 6px; padding: 6px 12px; }
        .table th { background: #f8fafc; border: none; color: var(--secondary-color); font-weight: 600; padding: 15px; }
        .table td { padding: 15px; vertical-align: middle; }
        .table tbody tr:hover { background: #f8fafc; }
        .empty-state { text-align: center; padding: 60px 20px; color: var(--secondary-color); }
        .empty-state i { font-size: 4rem; margin-bottom: 1rem; opacity: 0.5; }
        
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
                <h4><i class="fas fa-calendar-alt text-primary"></i> Vocero</h4>
            </div>
            
            <nav class="sidebar-nav">
                <a class="nav-link active" href="{{ route('vocero.dashboard') }}"> 
                    <i class="fas fa-chart-line"></i>
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
                <a class="nav-link" href="{{ route('vocero.reportes') }}">
                    <i class="fas fa-chart-bar"></i>
                    Reportes
                </a>
            </nav>
        </div>

        {{-- ⭐ 2. CONTENIDO PRINCIPAL ⭐ --}}
        <div class="main-content-vocero">
            
            <div class="content-wrapper"> 

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Dashboard</h2>
                        <p class="text-muted mb-0">Resumen general de eventos y asistencias</p>
                    </div>
                    <button class="btn btn-primary" onclick="refreshDashboard()">
                        <i class="fas fa-sync-alt me-2"></i>Actualizar
                    </button>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="mb-1" id="total-eventos">0</h3>
                                        <small>Eventos Totales</small>
                                    </div>
                                    <i class="fas fa-calendar-alt fs-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card stats-card-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="mb-1" id="eventos-proximos">0</h3>
                                        <small>Próximos Eventos</small>
                                    </div>
                                    <i class="fas fa-clock fs-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card stats-card-warning">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="mb-1" id="total-asistencias">0</h3>
                                        <small>Total Asistencias</small>
                                    </div>
                                    <i class="fas fa-users fs-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ⭐ CORRECCIÓN APLICADA AQUÍ: Texto cambiado de "Regalos" a "Presentes" ⭐ --}}
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card stats-card-info">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="mb-1" id="asistencias-presentes">0</h3>
                                        <small>Presentes</small>
                                    </div>
                                    <i class="fas fa-check-circle fs-2"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Próximos Eventos</h5>
                        <a href="{{ route('vocero.calendario') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-calendar-plus me-1"></i>Ver Calendario
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Evento</th>
                                        <th>Fecha y Hora</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Organizador</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="proximos-eventos-table">
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            Cargando eventos...
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
    {{-- ************** INICIO: JAVASCRIPT ********************************* --}}
    {{-- ***************************************************************** --}}
    
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.all.min.js"></script>

        <script>
            let eventsData = [];
            let attendanceData = [];

            $(document).ready(function() {
                initializeApp();
            });

            function initializeApp() {
                loadDashboard();
                setupSyncListeners();
            }
            
            function setupSyncListeners() {
                window.addEventListener('eventosUpdated', function() {
                    console.log('Eventos actualizados, recargando dashboard...');
                    loadDashboard();
                });

                window.addEventListener('storage', function(e) {
                    if (e.key === 'eventos' || e.key === 'asistencias') {
                        console.log('Detectado cambio en', e.key);
                        loadDashboard();
                    }
                });
            }

            function loadDashboard() {
                const eventos = localStorage.getItem('eventos');
                eventsData = eventos ? JSON.parse(eventos) : [];
                
                const asistencias = localStorage.getItem('asistencias');
                attendanceData = asistencias ? JSON.parse(asistencias) : [];
                
                console.log('Dashboard cargado:', {
                    eventos: eventsData.length,
                    asistencias: attendanceData.length
                });
                
                updateDashboardStats();
                loadRecentEvents();
            }

            function updateDashboardStats() {
                const now = new Date();
                
                $('#total-eventos').text(eventsData.length);
                
                const eventosProximos = eventsData.filter(event => {
                    const eventDate = new Date(event.start || event.fecha_inicio);
                    return eventDate > now;
                });
                $('#eventos-proximos').text(eventosProximos.length);
                
                $('#total-asistencias').text(attendanceData.length);
                
                const asistenciasPresentes = attendanceData.filter(att => att.status === 'presente');
                $('#asistencias-presentes').text(asistenciasPresentes.length);
            }

            function loadRecentEvents() {
                const tbody = $('#proximos-eventos-table');
                tbody.empty();
                
                const now = new Date();
                
                const eventosProximos = eventsData
                    .filter(event => {
                        const eventDate = new Date(event.start || event.fecha_inicio);
                        return eventDate > now;
                    })
                    .sort((a, b) => {
                        const dateA = new Date(a.start || a.fecha_inicio);
                        const dateB = new Date(b.start || b.fecha_inicio);
                        return dateA - dateB;
                    })
                    .slice(0, 5);
                
                if (eventosProximos.length === 0) {
                    tbody.append(`
                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fas fa-calendar-times"></i>
                                <h5>No hay eventos próximos</h5>
                                <p>Los eventos futuros aparecerán aquí</p>
                                <a href="{{ route('vocero.calendario') }}" class="btn btn-primary mt-3">
                                    <i class="fas fa-calendar-plus me-2"></i>Crear Evento
                                </a>
                            </td>
                        </tr>
                    `);
                    return;
                }
                
                eventosProximos.forEach(event => {
                    const titulo = event.title || event.titulo || 'Sin título';
                    const startDate = new Date(event.start || event.fecha_inicio);
                    const organizador = event.extendedProps?.organizador || 'No especificado';
                    const tipoEvento = event.extendedProps?.tipo_evento || 'sin-categoria';
                    const estado = event.extendedProps?.estado || 'programado';
                    
                    const eventAttendance = attendanceData.filter(att => att.event_id == event.id);
                    const attendanceCount = eventAttendance.length;
                    
                    tbody.append(`
                        <tr>
                            <td><strong>${titulo}</strong></td>
                            <td>${formatDateTime(startDate)}</td>
                            <td><span class="badge bg-${getCategoryColor(tipoEvento)}">${getCategoryName(tipoEvento)}</span></td>
                            <td><span class="badge bg-${getStatusColor(estado)}">${getStatusName(estado)}</span></td>
                            <td>${organizador}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('vocero.calendario') }}" class="btn btn-outline-primary" title="Ver en calendario">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('vocero.asistencias') }}" class="btn btn-outline-success" title="Gestionar asistencia">
                                        <i class="fas fa-users"></i>
                                        <span class="badge bg-success">${attendanceCount}</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `);
                });
            }

            function refreshDashboard() {
                showToast('Actualizando dashboard...', 'info');
                loadDashboard();
                showToast('Dashboard actualizado correctamente', 'success');
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

            function getCategoryName(category) {
                const mapping = {
                    'reunion-virtual': 'Reunión Virtual',
                    'reunion-presencial': 'Reunión Presencial',
                    'inicio-proyecto': 'Inicio Proyecto',
                    'finalizar-proyecto': 'Fin Proyecto',
                    'cumpleanos': 'Cumpleaños'
                };
                return mapping[category] || 'Sin categoría';
            }

            function getCategoryColor(category) {
                const colors = {
                    'reunion-virtual': 'primary',
                    'reunion-presencial': 'purple',
                    'inicio-proyecto': 'success',
                    'finalizar-proyecto': 'danger',
                    'cumpleanos': 'pink'
                };
                return colors[category] || 'secondary';
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

            function getStatusColor(status) {
                const colors = {
                    'programado': 'primary',
                    'en_curso': 'success',
                    'finalizado': 'secondary',
                    'cancelado': 'danger'
                };
                return colors[status] || 'secondary';
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