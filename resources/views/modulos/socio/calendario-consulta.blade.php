@extends('modulos.socio.layout')

@section('page-title', 'Calendario de Eventos')

@section('content')
    <!-- Header -->
    <div class="mb-6 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-xl p-6 shadow-lg text-white">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl font-bold flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Calendario de Eventos
                </h1>
                <p class="text-blue-100 mt-2">Vista de solo lectura - Consulta todos los eventos programados del club</p>
            </div>
            <div class="bg-white bg-opacity-30 backdrop-blur px-4 py-2 rounded-lg">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span class="font-semibold text-sm">Solo Lectura</span>
            </div>
        </div>
    </div>

    <!-- Leyenda de Colores -->
    <div class="mb-6 bg-white rounded-xl shadow-lg p-6 border border-gray-100">
        <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
            <div class="bg-gradient-to-br from-purple-500 to-pink-600 p-2 rounded-lg mr-3">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                </svg>
            </div>
            Tipos de Eventos
        </h3>
        <div class="flex flex-wrap gap-4">
            <div class="flex items-center px-4 py-2 bg-blue-50 rounded-lg border border-blue-200">
                <div class="w-4 h-4 bg-blue-500 rounded mr-3 shadow-sm"></div>
                <span class="text-sm font-medium text-gray-700">Virtual</span>
            </div>
            <div class="flex items-center px-4 py-2 bg-green-50 rounded-lg border border-green-200">
                <div class="w-4 h-4 bg-green-500 rounded mr-3 shadow-sm"></div>
                <span class="text-sm font-medium text-gray-700">Presencial</span>
            </div>
            <div class="flex items-center px-4 py-2 bg-yellow-50 rounded-lg border border-yellow-200">
                <div class="w-4 h-4 bg-yellow-500 rounded mr-3 shadow-sm"></div>
                <span class="text-sm font-medium text-gray-700">Inicio de Proyecto</span>
            </div>
            <div class="flex items-center px-4 py-2 bg-red-50 rounded-lg border border-red-200">
                <div class="w-4 h-4 bg-red-500 rounded mr-3 shadow-sm"></div>
                <span class="text-sm font-medium text-gray-700">Fin de Proyecto</span>
            </div>
        </div>
    </div>

    <!-- Calendario -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
        <div id="calendario"></div>
    </div>

    <!-- Modal de Detalles del Evento -->
    <div id="modalEvento" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" x-data="{ open: false }" x-show="open" x-cloak>
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto" @click.away="open = false">
            <!-- Header del Modal -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-6 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold" id="modalTitulo">Detalles del Evento</h3>
                    <button @click="open = false" class="text-white hover:text-gray-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Contenido del Modal -->
            <div class="p-6 space-y-4">
                <!-- Descripción -->
                <div class="flex items-start">
                    <div class="bg-gradient-to-br from-gray-100 to-gray-200 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-500 uppercase">Descripción</p>
                        <p class="text-gray-800 mt-1" id="modalDescripcion">-</p>
                    </div>
                </div>

                <!-- Fecha y Hora -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-blue-900 uppercase">Fecha Inicio</p>
                            <p class="text-gray-800 font-medium mt-1" id="modalFechaInicio">-</p>
                        </div>
                    </div>

                    <div class="flex items-start p-4 bg-green-50 rounded-lg border border-green-200">
                        <div class="bg-gradient-to-br from-green-500 to-green-600 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-green-900 uppercase">Fecha Fin</p>
                            <p class="text-gray-800 font-medium mt-1" id="modalFechaFin">-</p>
                        </div>
                    </div>
                </div>

                <!-- Ubicación -->
                <div class="flex items-start p-4 bg-red-50 rounded-lg border border-red-200">
                    <div class="bg-gradient-to-br from-red-500 to-red-600 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-red-900 uppercase">Ubicación</p>
                        <p class="text-gray-800 mt-1" id="modalUbicacion">-</p>
                    </div>
                </div>

                <!-- Tipo de Evento -->
                <div class="flex items-start p-4 bg-purple-50 rounded-lg border border-purple-200">
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-purple-900 uppercase">Tipo de Evento</p>
                        <span class="inline-block mt-2 px-3 py-1 rounded-full text-sm font-medium" id="modalTipo">-</span>
                    </div>
                </div>

                <!-- Estado -->
                <div class="flex items-start p-4 bg-orange-50 rounded-lg border border-orange-200">
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-orange-900 uppercase">Estado</p>
                        <span class="inline-block mt-2 px-3 py-1 rounded-full text-sm font-medium" id="modalEstado">-</span>
                    </div>
                </div>
            </div>

            <!-- Footer del Modal -->
            <div class="bg-gray-50 p-6 rounded-b-xl flex justify-end">
                <button @click="open = false" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors shadow-md font-semibold">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cerrar
                </button>
            </div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    /* Estilos personalizados para FullCalendar */
    #calendario {
        max-width: 100%;
        margin: 0 auto;
    }

    .fc-event {
        cursor: pointer;
        border-radius: 4px;
        padding: 2px 4px;
        margin-bottom: 2px;
    }

    .fc-event:hover {
        opacity: 0.85;
        transform: translateY(-1px);
        transition: all 0.2s;
    }

    /* Mejorar la apariencia de los botones del calendario */
    .fc-button {
        background-color: #3B82F6 !important;
        border-color: #3B82F6 !important;
        text-transform: capitalize !important;
        font-weight: 600 !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1) !important;
    }

    .fc-button:hover {
        background-color: #2563EB !important;
        border-color: #2563EB !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
    }

    .fc-button-active {
        background-color: #1E40AF !important;
        border-color: #1E40AF !important;
    }

    /* Estilo para días con eventos */
    .fc-day-today {
        background-color: #EFF6FF !important;
    }

    /* Mejorar títulos */
    .fc-toolbar-title {
        font-size: 1.5rem !important;
        font-weight: 700 !important;
        color: #1F2937 !important;
    }

    /* Alpine.js cloaking */
    [x-cloak] {
        display: none !important;
    }

    /* Animaciones */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fc-event {
        animation: fadeIn 0.3s ease-out;
    }
</style>
@endpush

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/es.global.min.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendario');
    var modal = Alpine.$data(document.getElementById('modalEvento'));

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        initialDate: new Date(),
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listMonth'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            list: 'Lista'
        },
        height: 'auto',
        navLinks: true,
        editable: false, // Solo lectura
        selectable: false, // No se puede seleccionar
        selectMirror: false,
        dayMaxEvents: true,
        
        // Cargar eventos
        events: function(info, successCallback, failureCallback) {
            // Usar la fecha del medio del rango para asegurar que obtenemos el mes correcto
            const startTime = info.start.getTime();
            const endTime = info.end.getTime();
            const midTime = new Date((startTime + endTime) / 2);
            
            const year = midTime.getFullYear();
            const month = String(midTime.getMonth() + 1).padStart(2, '0');

            console.log(`Cargando eventos: ${year}-${month} (rango: ${info.start.toISOString()} a ${info.end.toISOString()})`);
            
            fetch(`/socio/calendario/eventos/${year}/${month}`)
                .then(response => response.json())
                .then(data => {
                    console.log(`Se cargaron ${data.length} eventos:`, data);
                    successCallback(data);
                })
                .catch(error => {
                    console.error('Error al cargar eventos:', error);
                    failureCallback(error);
                });
        },

        // Cuando se hace clic en un evento
        eventClick: function(info) {
            const evento = info.event;
            
            // Llenar el modal con la información del evento
            document.getElementById('modalTitulo').textContent = evento.title;
            document.getElementById('modalDescripcion').textContent = evento.extendedProps.description || 'Sin descripción';
            
            // Formatear fechas
            const fechaInicio = new Date(evento.start);
            const fechaFin = evento.end ? new Date(evento.end) : fechaInicio;
            
            document.getElementById('modalFechaInicio').textContent = fechaInicio.toLocaleString('es-ES', {
                day: '2-digit',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            document.getElementById('modalFechaFin').textContent = fechaFin.toLocaleString('es-ES', {
                day: '2-digit',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            document.getElementById('modalUbicacion').textContent = evento.extendedProps.location || 'No especificada';
            
            // Tipo de evento con color
            const tipoSpan = document.getElementById('modalTipo');
            const tipo = evento.extendedProps.type || 'Sin tipo';
            tipoSpan.textContent = tipo;
            
            // Colores según el tipo
            const tipoClasses = {
                'Virtual': 'bg-blue-100 text-blue-700 border border-blue-300',
                'Presencial': 'bg-green-100 text-green-700 border border-green-300',
                'InicioProyecto': 'bg-yellow-100 text-yellow-700 border border-yellow-300',
                'FinProyecto': 'bg-red-100 text-red-700 border border-red-300'
            };
            tipoSpan.className = 'inline-block mt-2 px-3 py-1 rounded-full text-sm font-medium ' + (tipoClasses[tipo] || 'bg-gray-100 text-gray-700 border border-gray-300');
            
            // Estado
            const estadoSpan = document.getElementById('modalEstado');
            const estado = evento.extendedProps.status || 'Sin estado';
            estadoSpan.textContent = estado;
            
            // Colores según el estado
            const estadoClasses = {
                'Programado': 'bg-blue-100 text-blue-700 border border-blue-300',
                'EnCurso': 'bg-green-100 text-green-700 border border-green-300',
                'Finalizado': 'bg-gray-100 text-gray-700 border border-gray-300'
            };
            estadoSpan.className = 'inline-block mt-2 px-3 py-1 rounded-full text-sm font-medium ' + (estadoClasses[estado] || 'bg-gray-100 text-gray-700 border border-gray-300');
            
            // Abrir modal
            modal.open = true;
        },

        // Personalizar el renderizado de eventos
        eventDidMount: function(info) {
            // Agregar tooltip
            info.el.title = info.event.title;
        }
    });

    calendar.render();

    // Mensaje informativo de solo lectura
    setTimeout(() => {
        if (calendar.getEvents().length === 0) {
            console.log('No hay eventos para mostrar en este mes');
        }
    }, 1000);
});
</script>
@endpush