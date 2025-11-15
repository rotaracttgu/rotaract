<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Super Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Estilos personalizados -->
    @stack('styles')

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            font-family: 'Figtree', sans-serif;
        }

        .main-content-wrapper {
            margin-left: 280px;
            padding-top: 7rem;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        @media (max-width: 1024px) {
            .main-content-wrapper {
                margin-left: 0;
            }
            #sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            #sidebar.show {
                transform: translateX(0);
            }
        }

        /* Contenedor central para AJAX */
        #config-content {
            min-height: 600px;
            background: #1a1a2e;
            border-radius: 12px;
            padding: 1.5rem;
            color: white;
        }

        .ajax-load {
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 8px;
            color: #e2e8f0;
        }
        .ajax-load:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .ajax-load.active {
            background: linear-gradient(90deg, #6e48aa, #9d50bb);
            color: white !important;
            font-weight: 600;
        }
    </style>
</head>
<body class="font-sans antialiased">

    <!-- Navbar -->
    @include('layouts.navigation-admin')

    <!-- Sidebar -->
    @include('layouts.sidebar-admin')

    <!-- Contenido Principal -->
    <div class="main-content-wrapper">
        @isset($header)
            <header class="bg-white shadow-sm mb-4">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <h1 class="h5 mb-0 text-gray-800">{{ $header }}</h1>
                </div>
            </header>
        @endisset

        <main class="container-fluid px-4">
            @isset($slot)
                {{ $slot }}
            @else
                @yield('content')
            @endisset
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Toggle Sidebar (Móvil) -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('show');
            overlay?.classList.toggle('hidden');
        }
    </script>

    <!-- ⭐ PRIMERO: Scripts adicionales de las vistas -->
    @stack('scripts')

    <!-- ⭐ DESPUÉS: AJAX Carga de Contenido -->
    <script>
        $(document).ready(function() {
            console.log('✅ Sistema AJAX de Roles/Permisos inicializado');

            // Función para cargar contenido vía AJAX
            function cargarContenidoAjax(url, target) {
                console.log('🔄 Cargando vía AJAX:', url);

                $(target).html(`
                    <div class="d-flex justify-content-center align-items-center" style="min-height: 500px;">
                        <div class="text-center">
                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem; margin-bottom: 1rem;">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="text-white">Cargando contenido...</p>
                        </div>
                    </div>
                `);

                $.ajax({
                    url: url,
                    method: 'GET',
                    headers: { 
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    },
                    success: function(html) {
                        console.log('✅ Contenido cargado exitosamente');
                        $(target).html(html);
                        
                        // Re-inicializar tooltips si existen
                        if (typeof bootstrap !== 'undefined') {
                            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                            tooltipTriggerList.map(function (tooltipTriggerEl) {
                                return new bootstrap.Tooltip(tooltipTriggerEl);
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('❌ Error AJAX:', { xhr, status, error });
                        
                        let errorMessage = 'Error al cargar el contenido.';
                        
                        if (xhr.status === 404) {
                            errorMessage = 'Página no encontrada (404).';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Error del servidor (500). Revisa los logs.';
                        } else if (xhr.status === 0) {
                            errorMessage = 'No se pudo conectar al servidor.';
                        }
                        
                        $(target).html(`
                            <div class="alert alert-danger p-4 text-center m-4">
                                <i class="fas fa-exclamation-triangle me-2" style="font-size: 2rem;"></i>
                                <h4 class="mt-3">${errorMessage}</h4>
                                <p class="mb-0">Estado: ${xhr.status} - ${error}</p>
                                <button onclick="location.reload()" class="btn btn-primary mt-3">
                                    <i class="fas fa-redo me-2"></i>Recargar Página
                                </button>
                            </div>
                        `);
                    }
                });
            }

            // Cargar contenido desde el sidebar
            $(document).on('click', '.ajax-load', function(e) {
                e.preventDefault();

                const url = $(this).attr('href');
                const target = $(this).data('target') || '#config-content';
                const section = $(this).data('section') || '';

                // Verificar que el contenedor exista
                if (!$(target).length) {
                    console.error('❌ Contenedor no encontrado:', target);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'El contenedor #config-content no existe en esta página.',
                        background: '#1f2937',
                        color: '#fff'
                    });
                    return;
                }

                // Activar botón
                $('.ajax-load').removeClass('active');
                $(this).addClass('active');

                cargarContenidoAjax(url, target);
                
                if (section) {
                    history.pushState({ section }, '', url);
                }
            });

            // ⭐ NUEVO: Interceptar clics en enlaces DENTRO de #config-content
            $(document).on('click', '#config-content a:not([target="_blank"]):not(.no-ajax)', function(e) {
                const href = $(this).attr('href');
                
                // Solo interceptar enlaces que contengan 'admin/configuracion'
                if (href && href.includes('admin/configuracion')) {
                    e.preventDefault();
                    console.log('🔗 Enlace interceptado:', href);
                    cargarContenidoAjax(href, '#config-content');
                }
            });

            // Soporte para volver atrás
            window.addEventListener('popstate', function(e) {
                if (e.state && e.state.section) {
                    const link = $(`.ajax-load[data-section="${e.state.section}"]`);
                    if (link.length) {
                        link.trigger('click');
                    }
                }
            });

            // Cargar por hash al inicio
            const pathname = window.location.pathname;
            if (pathname.includes('roles/ajax')) {
                console.log('🔄 Auto-cargando Roles desde URL');
                $(`.ajax-load[data-section="roles"]`).trigger('click');
            } else if (pathname.includes('permisos/ajax')) {
                console.log('🔄 Auto-cargando Permisos desde URL');
                $(`.ajax-load[data-section="permisos"]`).trigger('click');
            }
        });
    </script>
</body>
</html>