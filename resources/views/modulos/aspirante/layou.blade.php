<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - ROTARACT Aspirante</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar .nav-link {
            color: white;
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.2);
            color: white;
        }
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Menú lateral -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky pt-3">
                    <!-- Título del módulo -->
                    <div class="text-center mb-4">
                        <h4 class="text-white">
                            <i class="fas fa-graduation-cap"></i>
                            ASPIRANTE
                        </h4>
                        <small class="text-light">Panel Personal</small>
                    </div>
                    
                    <!-- Enlaces del menú -->
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link @yield('dashboard-active')" href="/aspirante/dashboard">
                                <i class="fas fa-chart-pie"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield('calendario-active')" href="/aspirante/calendario">
                                <i class="fas fa-calendar-alt"></i>
                                Calendario
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield('proyectos-active')" href="/aspirante/proyectos">
                                <i class="fas fa-project-diagram"></i>
                                Mis Proyectos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield('reuniones-active')" href="/aspirante/reuniones">
                                <i class="fas fa-users"></i>
                                Mis Reuniones
                            </a>
                        </li>
                        
                        <hr class="my-3" style="border-color: rgba(255,255,255,0.3);">
                        
                        <li class="nav-item">
                            <a class="nav-link @yield('secretaria-active')" href="/aspirante/secretaria">
                                <i class="fas fa-envelope"></i>
                                Chat Secretaría
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield('voceria-active')" href="/aspirante/voceria">
                                <i class="fas fa-bullhorn"></i>
                                Chat Vocalía
                            </a>
                        </li>
                        
                        <hr class="my-3" style="border-color: rgba(255,255,255,0.3);">
                        
                        <li class="nav-item">
                            <a class="nav-link @yield('notas-active')" href="/aspirante/notas">
                                <i class="fas fa-sticky-note"></i>
                                Mis Notas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield('perfil-active')" href="/aspirante/perfil">
                                <i class="fas fa-user-circle"></i>
                                Mi Perfil
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Contenido principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Barra superior -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('page-title')</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-sm btn-outline-secondary me-2">
                            <i class="fas fa-bell"></i>
                            Notificaciones
                        </button>
                        <button type="button" class="btn btn-sm btn-primary">
                            <i class="fas fa-sign-out-alt"></i>
                            Cerrar Sesión
                        </button>
                    </div>
                </div>

                <!-- Aquí va el contenido de cada página -->
                <div class="container-fluid">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>