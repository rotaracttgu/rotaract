@extends('modulos.vicepresidente.layout')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Calendario de Eventos</h1>
            <p class="text-gray-600 mt-1">Vista general de reuniones y eventos programados</p>
        </div>
        <a href="{{ route('vicepresidente.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Dashboard
        </a>
    </div>

    <!-- Contenedor del Calendario -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div id="calendar"></div>
    </div>

    <!-- Modal para Ver Detalles del Evento -->
    <div id="eventModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-4">
            <div class="bg-blue-600 px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 id="modalTitle" class="text-xl font-bold text-white">Detalles del Evento</h3>
                    <button onclick="closeEventModal()" class="text-white hover:text-gray-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="p-6">
                <div id="modalContent" class="space-y-4">
                    <!-- El contenido se llenará dinámicamente -->
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button onclick="closeEventModal()" class="px-6 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-medium">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/es.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            
            // Eventos desde el servidor
            var eventos = @json($eventos);
            
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'es',
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día',
                    list: 'Lista'
                },
                events: eventos.map(evento => ({
                    id: evento.id,
                    title: evento.title,
                    start: evento.start,
                    backgroundColor: evento.color,
                    borderColor: evento.color,
                    extendedProps: {
                        description: evento.description,
                        lugar: evento.lugar,
                        estado: evento.estado
                    }
                })),
                eventClick: function(info) {
                    showEventDetails(info.event);
                },
                height: 'auto',
                navLinks: true,
                editable: false,
                dayMaxEvents: true,
                eventDisplay: 'block'
            });
            
            calendar.render();
        });

        function showEventDetails(event) {
            const modal = document.getElementById('eventModal');
            const title = document.getElementById('modalTitle');
            const content = document.getElementById('modalContent');
            
            title.textContent = event.title;
            
            const startDate = new Date(event.start);
            const formattedDate = startDate.toLocaleDateString('es-HN', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            const formattedTime = startDate.toLocaleTimeString('es-HN', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            
            content.innerHTML = `
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha y Hora</label>
                        <div class="flex items-center text-gray-900">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            ${formattedDate} a las ${formattedTime}
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lugar</label>
                        <div class="flex items-center text-gray-900">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            ${event.extendedProps.lugar || 'No especificado'}
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${getEstadoBadgeClass(event.extendedProps.estado)}">
                            ${event.extendedProps.estado}
                        </span>
                    </div>
                    
                    ${event.extendedProps.description ? `
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">${event.extendedProps.description}</p>
                    </div>
                    ` : ''}
                </div>
            `;
            
            modal.classList.remove('hidden');
        }

        function closeEventModal() {
            document.getElementById('eventModal').classList.add('hidden');
        }

        function getEstadoBadgeClass(estado) {
            switch(estado) {
                case 'Programada':
                    return 'bg-blue-100 text-blue-800';
                case 'Completada':
                    return 'bg-green-100 text-green-800';
                case 'Cancelada':
                    return 'bg-red-100 text-red-800';
                default:
                    return 'bg-gray-100 text-gray-800';
            }
        }

        // Cerrar modal al hacer clic fuera
        document.getElementById('eventModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeEventModal();
            }
        });
    </script>

    <style>
        #calendar {
            max-width: 100%;
        }
        
        .fc-toolbar-title {
            color: #1f2937 !important;
            font-weight: 600 !important;
        }
        
        .fc-button-primary {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
        }
        
        .fc-button-primary:hover {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
        }
        
        .fc-button-primary:disabled {
            background-color: #93c5fd !important;
            border-color: #93c5fd !important;
        }
        
        .fc-event {
            cursor: pointer;
        }
        
        .fc-daygrid-event {
            white-space: normal !important;
        }
    </style>
@endsection
