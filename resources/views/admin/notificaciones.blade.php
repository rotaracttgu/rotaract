@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                Centro de Notificaciones
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Alertas y avisos importantes del sistema
            </p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Dashboard
        </a>
    </div>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Filtros y Acciones -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <div class="flex flex-wrap gap-4 items-center justify-between">
                    <div class="flex gap-3">
                        <button onclick="filterNotifications('todas')" class="px-4 py-2 rounded-lg font-medium transition filter-btn active" data-filter="todas">
                            Todas
                        </button>
                        <button onclick="filterNotifications('usuarios')" class="px-4 py-2 rounded-lg font-medium transition filter-btn" data-filter="usuarios">
                            Usuarios
                        </button>
                        <button onclick="filterNotifications('sistema')" class="px-4 py-2 rounded-lg font-medium transition filter-btn" data-filter="sistema">
                            Sistema
                        </button>
                        <button onclick="filterNotifications('seguridad')" class="px-4 py-2 rounded-lg font-medium transition filter-btn" data-filter="seguridad">
                            Seguridad
                        </button>
                    </div>
                    <button onclick="markAllAsRead()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        Marcar todas como leídas
                    </button>
                </div>
            </div>

            <!-- Lista de Notificaciones -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Notificaciones Recientes</h3>
                    
                    <div id="notificationsList" class="space-y-3">
                        @forelse($notificaciones as $notificacion)
                            <div class="notification-item p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition cursor-pointer {{ $notificacion->leida ? 'bg-gray-50' : 'bg-blue-50 border-blue-200' }}" 
                                 data-type="{{ $notificacion->tipo }}">
                                <div class="flex items-start gap-4">
                                    <!-- Icono según tipo -->
                                    <div class="flex-shrink-0">
                                        @if($notificacion->tipo == 'usuarios')
                                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                            </div>
                                        @elseif($notificacion->tipo == 'sistema')
                                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>
                                        @elseif($notificacion->tipo == 'seguridad')
                                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
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
                                    </div>
                                    
                                    <!-- Indicador de no leída -->
                                    @if(!$notificacion->leida)
                                        <div class="flex-shrink-0">
                                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <!-- Estado vacío -->
                            <div class="text-center py-12">
                                <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
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

    <script>
        function filterNotifications(tipo) {
            const items = document.querySelectorAll('.notification-item');
            const buttons = document.querySelectorAll('.filter-btn');
            
            // Actualizar botones activos
            buttons.forEach(btn => {
                if (btn.dataset.filter === tipo) {
                    btn.classList.add('active', 'bg-blue-600', 'text-white');
                    btn.classList.remove('bg-gray-100', 'text-gray-700');
                } else {
                    btn.classList.remove('active', 'bg-blue-600', 'text-white');
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

        function markAllAsRead() {
            if (confirm('¿Marcar todas las notificaciones como leídas?')) {
                // Aquí iría la lógica para marcar como leídas
                const unreadItems = document.querySelectorAll('.notification-item.bg-blue-50');
                unreadItems.forEach(item => {
                    item.classList.remove('bg-blue-50', 'border-blue-200');
                    item.classList.add('bg-gray-50');
                    const indicator = item.querySelector('.bg-blue-500');
                    if (indicator) {
                        indicator.remove();
                    }
                });
                
                alert('Todas las notificaciones han sido marcadas como leídas');
            }
        }

        // Inicializar filtros
        document.addEventListener('DOMContentLoaded', function() {
            const activeBtn = document.querySelector('.filter-btn.active');
            if (activeBtn) {
                activeBtn.classList.add('bg-blue-600', 'text-white');
            }
        });
    </script>

    <style>
        .filter-btn {
            background-color: #f3f4f6;
            color: #374151;
        }
        
        .filter-btn.active {
            background-color: #3b82f6;
            color: white;
        }
        
        .filter-btn:hover:not(.active) {
            background-color: #e5e7eb;
        }
    </style>
@endsection
