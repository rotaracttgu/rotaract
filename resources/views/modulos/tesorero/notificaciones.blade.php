@extends('layouts.app')

@section('title', 'Notificaciones - Tesorero')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                    Centro de Notificaciones
                </h1>
                <p class="text-gray-600 mt-1">Alertas y avisos importantes del sistema</p>
            </div>
            <a href="{{ route('tesorero.dashboard') }}" class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-bold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Dashboard
            </a>
        </div>

        <!-- Filtros y Acciones -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 mb-6">
            <div class="flex flex-wrap gap-4 items-center justify-between">
                <div class="flex gap-3">
                    <button onclick="filterNotifications('todas')" class="px-4 py-2 rounded-lg font-medium transition filter-btn active bg-gradient-to-r from-purple-600 to-blue-600 text-white" data-filter="todas">
                        Todas
                    </button>
                    <button onclick="filterNotifications('reunion_creada')" class="px-4 py-2 rounded-lg font-medium transition filter-btn bg-gray-100 text-gray-700 hover:bg-gray-200" data-filter="reunion_creada">
                        Reuniones
                    </button>
                    <button onclick="filterNotifications('proyecto_creado')" class="px-4 py-2 rounded-lg font-medium transition filter-btn bg-gray-100 text-gray-700 hover:bg-gray-200" data-filter="proyecto_creado">
                        Proyectos Nuevos
                    </button>
                    <button onclick="filterNotifications('proyecto_finalizado')" class="px-4 py-2 rounded-lg font-medium transition filter-btn bg-gray-100 text-gray-700 hover:bg-gray-200" data-filter="proyecto_finalizado">
                        Proyectos Finalizados
                    </button>
                </div>
                <button onclick="markAllAsRead()" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition font-medium shadow-md hover:shadow-lg">
                    Marcar todas como leídas
                </button>
            </div>
        </div>

        <!-- Lista de Notificaciones -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Notificaciones Recientes</h3>
                
                <div id="notificationsList" class="space-y-3">
                    @forelse($notificaciones as $notificacion)
                                                @php
                            // Determinar enlace según tipo de notificación y rol del usuario
                            $enlace = '#';
                            $userRole = auth()->user()->getRoleNames()->first();
                            
                            if(str_contains($notificacion->tipo, 'reunion')) {
                                // Cada módulo va a su propio calendario
                                if($userRole === 'Vocero') {
                                    $enlace = route('vocero.calendario');
                                } elseif($userRole === 'Vicepresidente') {
                                    $enlace = route('vicepresidente.calendario');
                                } elseif($userRole === 'Secretario') {
                                    $enlace = route('secretaria.calendario');
                                } elseif($userRole === 'Tesorero') {
                                    $enlace = route('tesorero.calendario');
                                } elseif($userRole === 'Presidente') {
                                    $enlace = route('presidente.calendario');
                                } elseif($userRole === 'Super Admin') {
                                    $enlace = route('admin.calendario');
                                }
                            } elseif(str_contains($notificacion->tipo, 'proyecto')) {
                                // Proyectos en Vicepresidente
                                $enlace = route('vicepresidente.estado.proyectos');
                            } elseif(str_contains($notificacion->tipo, 'carta')) {
                                // Cartas en Secretario o Vicepresidente según el tipo
                                if($userRole === 'Secretario') {
                                    $enlace = route('secretaria.cartas.index');
                                } elseif($userRole === 'Vicepresidente') {
                                    $enlace = route('vicepresidente.cartas.formales');
                                }
                            }
                        @endphp
                        
                        <div class="notification-item p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition {{ $notificacion->leida ? 'bg-gray-50' : 'bg-blue-50 border-blue-200' }}" 
                             data-type="{{ $notificacion->tipo }}"
                             data-id="{{ $notificacion->id }}">
                            <div class="flex items-start gap-4">
                                <!-- Icono según tipo -->
                                <div class="flex-shrink-0">
                                    @if(str_contains($notificacion->tipo, 'proyecto'))
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    @elseif(str_contains($notificacion->tipo, 'reunion'))
                                        <div class="w-10 h-10 bg-gradient-to-br from-purple-100 to-purple-200 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @elseif(str_contains($notificacion->tipo, 'carta'))
                                        <div class="w-10 h-10 bg-gradient-to-br from-orange-100 to-orange-200 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-10 h-10 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Contenido -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900">{{ $notificacion->titulo }}</p>
                                    <p class="text-sm text-gray-600 mt-1">{{ $notificacion->mensaje }}</p>
                                    <p class="text-xs text-gray-500 mt-2">{{ $notificacion->created_at->diffForHumans() }}</p>
                                    
                                    <!-- Botones de acción -->
                                    <div class="flex gap-2 mt-3">
                                        @if($enlace !== '#')
                                            <a href="{{ $enlace }}" onclick="markAsReadAndGo(event, {{ $notificacion->id }}, '{{ $enlace }}')" class="text-xs px-3 py-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-md hover:from-blue-600 hover:to-blue-700 transition">
                                                Ver detalles
                                            </a>
                                        @endif
                                        @if(!$notificacion->leida)
                                            <button onclick="markAsRead({{ $notificacion->id }})" class="text-xs px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                                                Marcar como leída
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Indicador de no leída -->
                                @if(!$notificacion->leida)
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full animate-pulse"></div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <!-- Estado vacío -->
                        <div class="text-center py-12">
                            <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay notificaciones</h3>
                            <p class="text-gray-500">Cuando recibas alertas importantes, aparecerán aquí</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function filterNotifications(tipo) {
        const items = document.querySelectorAll('.notification-item');
        const buttons = document.querySelectorAll('.filter-btn');
        
        // Actualizar botones activos
        buttons.forEach(btn => {
            if (btn.dataset.filter === tipo) {
                btn.classList.add('active');
                btn.classList.remove('bg-gray-100', 'text-gray-700');
                btn.classList.add('bg-gradient-to-r', 'from-purple-600', 'to-blue-600', 'text-white');
            } else {
                btn.classList.remove('active', 'bg-gradient-to-r', 'from-purple-600', 'to-blue-600', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            }
        });
        
        // Filtrar notificaciones
        items.forEach(item => {
            if (tipo === 'todas' || item.dataset.type === tipo) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function markAsRead(id) {
        fetch(`/tesorero/notificaciones/${id}/marcar-leida`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = document.querySelector(`[data-id="${id}"]`);
                if (item) {
                    item.classList.remove('bg-blue-50', 'border-blue-200');
                    item.classList.add('bg-gray-50');
                    const indicator = item.querySelector('.animate-pulse');
                    if (indicator) {
                        indicator.remove();
                    }
                    // Recargar para actualizar el badge
                    location.reload();
                }
            }
        });
    }

    function markAsReadAndGo(event, id, url) {
        event.preventDefault();
        
        fetch(`/tesorero/notificaciones/${id}/marcar-leida`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = url;
            }
        });
    }

    function markAllAsRead() {
        if (confirm('¿Marcar todas las notificaciones como leídas?')) {
            fetch('/tesorero/notificaciones/marcar-todas-leidas', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }
</script>
@endpush
@endsection

