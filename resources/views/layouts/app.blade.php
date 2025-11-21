<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Rotaract Fuerza Tegucigalpa Sur') }}</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/jpeg" href="{{ asset('images/Logo_barra_navegador.jpg') }}?v=2">
        <link rel="shortcut icon" type="image/jpeg" href="{{ asset('images/Logo_barra_navegador.jpg') }}?v=2">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/Logo_barra_navegador.jpg') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">
        
        <!-- Meta Tags para SEO -->
        <meta name="description" content="Bienvenidos a la paguina de Rotaract Fuerza Tegucigalpa Sur"
        <meta name="keywords" content="Rotaract, Fuerza Tegucigalpa Sur, Rotaract Fuerza, proyectos, voluntariado">
        <meta name="author" content="Rotaract Fuerza Tegucigalpa Sur">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:site_name" content="Rotaract Fuerza Tegucigalpa Sur">
        <meta property="og:title" content="{{ config('app.name', 'Rotaract Fuerza Tegucigalpa Sur') }}">
        <meta property="og:description" content="Sistema de gestión del Rotaract Fuerza Tegucigalpa Sur - Proyectos, reuniones, finanzas y más">
        <meta property="og:image" content="{{ asset('images/Logo_barra_navegador.jpg') }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:locale" content="es_HN">
        
        <!-- Twitter -->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:url" content="{{ url()->current() }}">
        <meta name="twitter:title" content="{{ config('app.name', 'Rotaract Fuerza Tegucigalpa Sur') }}">
        <meta name="twitter:description" content="Sistema de gestión del Rotaract Fuerza Tegucigalpa Sur">
        <meta name="twitter:image" content="{{ asset('images/Logo_barra_navegador.jpg') }}">
        
        <!-- Theme Color -->
        <meta name="theme-color" content="#0052A5">
        <meta name="msapplication-TileColor" content="#0052A5">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- SweetAlert2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Estilos personalizados de las vistas -->
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </main>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <!-- Sistema de Notificaciones para Tesorero -->
        @if(auth()->check() && auth()->user()->hasRole('Tesorero'))
        <script>
            // Función global para abrir el modal de notificaciones
            function abrirModalNotificaciones() {
                fetch('/tesorero/mis-notificaciones', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const notifs = data.notificaciones;
                        
                        let htmlContent = '';
                        if (notifs.length === 0) {
                            htmlContent = '<div class="alert alert-info"><i class="fas fa-info-circle me-2"></i>No tienes notificaciones</div>';
                        } else {
                            htmlContent = '<div class="list-group" style="max-height: 400px; overflow-y: auto;">';
                            notifs.forEach(notif => {
                                const fechaFormat = new Date(notif.created_at).toLocaleDateString('es-ES', {
                                    day: '2-digit',
                                    month: 'short',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });
                                
                                htmlContent += `
                                    <div class="list-group-item ${!notif.leida ? 'bg-light border-primary' : ''}" 
                                         style="cursor: pointer;"
                                         onclick="marcarNotificacionComoLeida(${notif.id})">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">
                                                <i class="fas fa-bell text-warning me-2"></i>
                                                ${notif.titulo}
                                                ${!notif.leida ? '<span class="badge bg-primary ms-2">Nueva</span>' : ''}
                                            </h6>
                                            <small class="text-muted">${fechaFormat}</small>
                                        </div>
                                        <p class="mb-1">${notif.mensaje}</p>
                                        ${!notif.leida ? '<small class="text-primary"><i class="fas fa-check me-1"></i>Click para marcar como leída</small>' : ''}
                                    </div>
                                `;
                            });
                            htmlContent += '</div>';
                            
                            // Botón para marcar todas como leídas
                            if (notifs.some(n => !n.leida)) {
                                htmlContent += `
                                    <div class="mt-3 text-center">
                                        <button class="btn btn-sm btn-primary" onclick="marcarTodasNotificacionesLeidas()">
                                            <i class="fas fa-check-double me-1"></i>Marcar todas como leídas
                                        </button>
                                    </div>
                                `;
                            }
                        }
                        
                        Swal.fire({
                            title: '<i class="fas fa-bell me-2"></i>Mis Notificaciones',
                            html: htmlContent,
                            width: '600px',
                            showConfirmButton: false,
                            showCloseButton: true,
                            customClass: {
                                container: 'notificaciones-modal'
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudieron cargar las notificaciones'
                    });
                });
            }
            
            // Marcar una notificación como leída
            function marcarNotificacionComoLeida(notifId) {
                fetch('/tesorero/marcar-notificacion-leida/' + notifId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Recargar notificaciones
                        Swal.close();
                        setTimeout(() => abrirModalNotificaciones(), 200);
                        actualizarBadgeNotificaciones();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
            
            // Marcar todas las notificaciones como leídas
            function marcarTodasNotificacionesLeidas() {
                fetch('/tesorero/marcar-todas-leidas', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.close();
                        Swal.fire({
                            icon: 'success',
                            title: '¡Listo!',
                            text: 'Todas las notificaciones han sido marcadas como leídas',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        actualizarBadgeNotificaciones();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
            
            // Actualizar el badge de notificaciones
            function actualizarBadgeNotificaciones() {
                fetch('/tesorero/mis-notificaciones', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const noLeidas = data.notificaciones.filter(n => !n.leida).length;
                        const badge = document.getElementById('notificaciones-badge-nav');
                        
                        if (badge) {
                            if (noLeidas > 0) {
                                badge.textContent = noLeidas;
                                badge.classList.remove('hidden');
                            } else {
                                badge.classList.add('hidden');
                            }
                        }
                        
                        // Actualizar también el badge del dashboard de finanzas si existe
                        const badgeDashboard = document.getElementById('notif-badge');
                        if (badgeDashboard) {
                            if (noLeidas > 0) {
                                badgeDashboard.textContent = noLeidas;
                                badgeDashboard.style.display = 'inline-flex';
                            } else {
                                badgeDashboard.style.display = 'none';
                            }
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
            }
            
            // Cargar notificaciones al iniciar la página
            document.addEventListener('DOMContentLoaded', function() {
                actualizarBadgeNotificaciones();
                
                // Actualizar cada 30 segundos
                setInterval(actualizarBadgeNotificaciones, 30000);
            });
        </script>
        @endif

        @yield('scripts')
        
        <!-- Scripts personalizados de las vistas -->
        @stack('scripts')
    </body>
</html>
