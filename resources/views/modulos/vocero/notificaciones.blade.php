<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Centro de Notificaciones') }}
            </h2>
            <a href="{{ route('vocero.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filtros y Acciones -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <div class="flex flex-wrap gap-4 items-center justify-between">
                    <div class="flex gap-3">
                        <button onclick="filterNotifications('todas')" class="px-4 py-2 rounded-lg font-medium transition filter-btn active" data-filter="todas">
                            Todas
                        </button>
                        <button onclick="filterNotifications('eventos')" class="px-4 py-2 rounded-lg font-medium transition filter-btn" data-filter="eventos">
                            Eventos
                        </button>
                        <button onclick="filterNotifications('asistencias')" class="px-4 py-2 rounded-lg font-medium transition filter-btn" data-filter="asistencias">
                            Asistencias
                        </button>
                        <button onclick="filterNotifications('reportes')" class="px-4 py-2 rounded-lg font-medium transition filter-btn" data-filter="reportes">
                            Reportes
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
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900">{{ $notificacion->titulo }}</p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $notificacion->mensaje }}</p>
                                        <p class="text-xs text-gray-500 mt-2">{{ $notificacion->created_at->diffForHumans() }}</p>
                                    </div>
                                    @if(!$notificacion->leida)
                                        <div class="flex-shrink-0">
                                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
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
            
            buttons.forEach(btn => {
                if (btn.dataset.filter === tipo) {
                    btn.classList.add('active', 'bg-blue-600', 'text-white');
                    btn.classList.remove('bg-gray-100', 'text-gray-700');
                } else {
                    btn.classList.remove('active', 'bg-blue-600', 'text-white');
                    btn.classList.add('bg-gray-100', 'text-gray-700');
                }
            });
            
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
</x-app-layout>
