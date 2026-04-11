<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Super Admin</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha384-iw3OoTErCYJJB9mCa8LNS2hbsQ7M3C0EpIsO/H5+EGAkPGc6rk+V8i04oW/K5xq0" crossorigin="anonymous">

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.24/dist/sweetalert2.min.css" rel="stylesheet" integrity="sha384-OxWqvePLOm0AAoo759Ls7uD8ysM4N0fSXEE+QUY3pkVXBtkv6jkKNsPMC0KFMxWe" crossorigin="anonymous">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Estilos personalizados -->
    @stack('styles')

    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom right, #111827, #1e1b4b);
            font-family: 'Figtree', sans-serif;
        }

        .main-content-wrapper {
            margin-left: 320px; /* w-80 de Tailwind = 20rem = 320px */
            padding-top: 5rem;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
            position: relative;
            z-index: 1;
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
            width: 100%;
            min-height: auto;
        }

        /* Contenedor de página normal */
        #page-content {
            width: 100%;
        }

        /* Asegurar que el main tenga el padding correcto */
        .main-content-wrapper > main {
            padding: 1.5rem;
        }

        /* IMPORTANTE: Asegurar que NADA corte el contenido */
        .main-content-wrapper main,
        #config-content,
        #page-content {
            overflow: visible !important;
            max-height: none !important;
            clip: auto !important;
            clip-path: none !important;
        }

        /* El wrapper principal puede tener overflow-x hidden para evitar scroll horizontal */
        .main-content-wrapper {
            overflow-x: hidden;
            overflow-y: visible;
        }

        /* Cuando se muestra contenido AJAX */
        #config-content.ajax-content-container {
            display: block;
        }

        /* Asegurar que el contenido AJAX esté correctamente posicionado */
        #config-content > *:first-child {
            padding-top: 0;
            margin-top: 0;
            margin-left: 0;
            position: relative;
            left: 0;
            top: 0;
        }

        /* Fix para elementos con rounded que pueden cortarse */
        #config-content .rounded-xl,
        #config-content .rounded-2xl {
            overflow: visible;
        }

        /* Asegurar que el contenedor AJAX no tenga transformaciones raras */
        #config-content {
            transform: none !important;
            margin: 0 !important;
            position: relative !important;
            left: 0 !important;
            top: 0 !important;
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

        <main>
            <!-- ⭐ CONTENEDOR PARA CONTENIDO NORMAL DE LAS VISTAS -->
            <div id="page-content">
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </div>

            <!-- ⭐ CONTENEDOR AJAX GLOBAL - Se muestra cuando se carga contenido AJAX -->
            <div id="config-content" class="ajax-content-container" style="display: none;"></div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha384-1H217gwSVyLSIfaLxHbE7dRb3v4mYCKbpQvzx0cegeju1MVsGrX5xXxAvs/HgeFs" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.24/dist/sweetalert2.all.min.js" integrity="sha384-QjoPbdj/93O7LUz0wqTxepA3tIabUD3jzfZX+x5QLvqFtHBzSw4eYFLSVthB+EDT" crossorigin="anonymous"></script>

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

            // ⭐ BANDERA PARA EVITAR LOOP INFINITO
            let isAjaxLoading = false;

            // Función GLOBAL para cargar contenido vía AJAX
            window.cargarContenidoAjax = function(url, target) {
                console.log('🔵 cargarContenidoAjax llamada');
                console.log('🔵 URL:', url);
                console.log('🔵 Target:', target);
                console.log('🔵 isAjaxLoading:', isAjaxLoading);

                if (isAjaxLoading) {
                    console.log('⚠️ Ya hay una petición AJAX en curso, ignorando...');
                    return;
                }

                isAjaxLoading = true;

                // ⭐ OCULTAR el contenido de la página y mostrar el contenedor AJAX
                console.log('🔵 Ocultando #page-content, mostrando', target);
                $('#page-content').css('display', 'none');

                // ⭐ Limpiar completamente el contenedor antes de mostrar el spinner
                $(target).empty().css({
                    'display': 'block',
                    'position': 'relative',
                    'top': '0',
                    'left': '0'
                }).html(`
                    <div class="d-flex justify-content-center align-items-center" style="min-height: 300px;">
                        <div class="text-center">
                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem; margin-bottom: 1rem;">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="text-white">Cargando contenido...</p>
                        </div>
                    </div>
                `);

                // Scroll hacia arriba - Forzar en todos los contenedores
                window.scrollTo(0, 0);
                document.documentElement.scrollTop = 0;
                document.body.scrollTop = 0;
                $('.main-content-wrapper').scrollTop(0);

                $.ajax({
                    url: url,
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    },
                    beforeSend: function() {
                        console.log('🔵 AJAX beforeSend - Enviando petición...');
                    },
                    success: function(html, textStatus, xhr) {
                        console.log('✅ AJAX SUCCESS - length:', html.length);

                        // ⭐ Asegurar que page-content está oculto
                        $('#page-content').hide();

                        // ⭐ LIMPIAR completamente e insertar nuevo HTML
                        $(target).empty().html(html).css({
                            'display': 'block',
                            'visibility': 'visible',
                            'opacity': '1',
                            'position': 'relative',
                            'top': '0',
                            'left': '0',
                            'transform': 'none'
                        });

                        // ⭐ Scroll arriba - Forzar en todos los contenedores posibles
                        window.scrollTo(0, 0);
                        document.documentElement.scrollTop = 0;
                        document.body.scrollTop = 0;
                        $('.main-content-wrapper').scrollTop(0);
                        $(target).scrollTop(0);

                        // Re-inicializar Alpine.js
                        setTimeout(function() {
                            if (window.Alpine) {
                                try {
                                    Alpine.initTree($(target)[0]);
                                } catch (e) {
                                    console.log('⚠️ Alpine init:', e);
                                }
                            }
                        }, 100);
                    },
                    error: function(xhr, status, error) {
                        console.error('❌ AJAX ERROR');
                        console.error('❌ XHR:', xhr);
                        console.error('❌ Status:', status);
                        console.error('❌ Error:', error);
                        console.error('❌ Response:', xhr.responseText);

                        let errorMessage = 'Error al cargar el contenido.';

                        if (xhr.status === 404) {
                            errorMessage = 'Página no encontrada (404).';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Error del servidor (500). Revisa los logs.';
                        } else if (xhr.status === 0) {
                            errorMessage = 'No se pudo conectar al servidor.';
                        }

                        // ⭐ Mantener visible en error
                        $('#page-content').hide();
                        $(target).show().html(`
                            <div class="alert alert-danger p-4 text-center m-4">
                                <i class="fas fa-exclamation-triangle me-2" style="font-size: 2rem;"></i>
                                <h4 class="mt-3">${errorMessage}</h4>
                                <p class="mb-0">Estado: ${xhr.status} - ${error}</p>
                                <button onclick="location.reload()" class="btn btn-primary mt-3">
                                    <i class="fas fa-redo me-2"></i>Recargar Página
                                </button>
                            </div>
                        `);
                    },
                    complete: function() {
                        console.log('🔵 AJAX COMPLETE - Petición finalizada');
                        isAjaxLoading = false; // ⭐ Resetear la bandera
                    }
                });
            }

            // Cargar contenido desde el sidebar
            // ⭐ IMPORTANTE: Solo del SIDEBAR, NO del contenido cargado
            $(document).on('click', '#sidebar .ajax-load', function(e) {
                console.log('🔵🔵🔵 CLICK DETECTADO EN .ajax-load 🔵🔵🔵');
                e.preventDefault();
                e.stopPropagation(); // ⭐ Detener la propagación

                console.log('🔵 CLICK en .ajax-load detectado');
                console.log('🔵 Elemento:', this);
                console.log('🔵 Elemento HTML:', this.outerHTML);

                const url = $(this).attr('href');
                const target = $(this).data('target') || '#config-content';
                const section = $(this).data('section') || '';

                console.log('🔵 URL extraída:', url);
                console.log('🔵 Target extraído:', target);
                console.log('🔵 Section extraída:', section);

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
                    return false; // ⭐ Detener ejecución
                }

                console.log('✅ Contenedor existe, continuando...');

                // Activar botón
                $('#sidebar .ajax-load').removeClass('active');
                $(this).addClass('active');

                console.log('🔵 Llamando a cargarContenidoAjax...');
                window.cargarContenidoAjax(url, target);

                if (section) {
                    history.pushState({ section }, '', url);
                    console.log('🔵 History pushState:', section, url);
                }

                return false; // ⭐ Prevenir cualquier acción adicional
            });

            // ⭐ INTERCEPTOR PARA PAGINACIÓN - Solo links de paginación dentro de #config-content
            $(document).on('click', '#config-content .pagination a', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const href = $(this).attr('href');
                console.log('📄 Click en paginación detectado:', href);

                if (href && !$(this).parent().hasClass('disabled') && !$(this).parent().hasClass('active')) {
                    console.log('📄 Cargando página vía AJAX...');
                    window.cargarContenidoAjax(href, '#config-content');
                }

                return false;
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
            // ⭐ DESHABILITADO: Causaba loop infinito
            // const pathname = window.location.pathname;
            // if (pathname.includes('roles/ajax')) {
            //     console.log('🔄 Auto-cargando Roles desde URL');
            //     $(`.ajax-load[data-section="roles"]`).trigger('click');
            // } else if (pathname.includes('permisos/ajax')) {
            //     console.log('🔄 Auto-cargando Permisos desde URL');
            //     $(`.ajax-load[data-section="permisos"]`).trigger('click');
            // }
        });
    </script>
</body>
</html>
