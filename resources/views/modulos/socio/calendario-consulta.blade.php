@extends('modulos.socio.layout')

@section('page-title', 'Calendario de Eventos')

@section('content')
    <!-- Header -->
    <div class="mb-6 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-6 border border-blue-200">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-calendar-alt text-blue-600 mr-3"></i>
                    Calendario de Eventos
                </h1>
                <p class="text-gray-600 mt-2">Vista de solo lectura - Consulta todos los eventos programados del club</p>
            </div>
            <div class="bg-blue-100 px-4 py-2 rounded-lg">
                <i class="fas fa-eye text-blue-600 mr-2"></i>
                <span class="text-blue-800 font-semibold text-sm">Solo Lectura</span>
            </div>
        </div>
    </div>

    <!-- Leyenda de Colores -->
    <div class="mb-6 bg-white rounded-xl shadow-sm p-4 border border-gray-200">
        <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
            <i class="fas fa-palette mr-2"></i>
            Tipos de Eventos
        </h3>
        <div class="flex flex-wrap gap-4">
            <div class="flex items-center">
                <div class="w-4 h-4 bg-blue-500 rounded mr-2"></div>
                <span class="text-sm text-gray-700">Virtual</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-green-500 rounded mr-2"></div>
                <span class="text-sm text-gray-700">Presencial</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-yellow-500 rounded mr-2"></div>
                <span class="text-sm text-gray-700">Inicio de Proyecto</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-red-500 rounded mr-2"></div>
                <span class="text-sm text-gray-700">Fin de Proyecto</span>
            </div>
        </div>
    </div>

    <!-- Calendario -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div id="calendario"></div>
    </div>

    <!-- Modal de Detalles del Evento -->
    <div id="modalEvento" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" x-data="{ open: false }" x-show="open" x-cloak>
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto" @click.away="open = false">
            <!-- Header del Modal -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold" id="modalTitulo">Detalles del Evento</h3>
                    <button @click="open = false" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Contenido del Modal -->
            <div class="p-6 space-y-4">
                <!-- Descripción -->
                <div class="flex items-start">
                    <i class="fas fa-align-left text-gray-400 mt-1 mr-3 w-5"></i>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-500 uppercase">Descripción</p>
                        <p class="text-gray-800" id="modalDescripcion">-</p>
                    </div>
                </div>

                <!-- Fecha y Hora -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start">
                        <i class="fas fa-calendar text-blue-500 mt-1 mr-3 w-5"></i>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-500 uppercase">Fecha Inicio</p>
                            <p class="text-gray-800 font-medium" id="modalFechaInicio">-</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <i class="fas fa-calendar-check text-green-500 mt-1 mr-3 w-5"></i>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-500 uppercase">Fecha Fin</p>
                            <p class="text-gray-800 font-medium" id="modalFechaFin">-</p>
                        </div>
                    </div>
                </div>

                <!-- Ubicación -->
                <div class="flex items-start">
                    <i class="fas fa-map-marker-alt text-red-500 mt-1 mr-3 w-5"></i>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-500 uppercase">Ubicación</p>
                        <p class="text-gray-800" id="modalUbicacion">-</p>
                    </div>
                </div>

                <!-- Tipo de Evento -->
                <div class="flex items-start">
                    <i class="fas fa-tag text-purple-500 mt-1 mr-3 w-5"></i>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-500 uppercase">Tipo de Evento</p>
                        <span class="inline-block mt-1 px-3 py-1 rounded-full text-sm font-medium" id="modalTipo">-</span>
                    </div>
                </div>

                <!-- Estado -->
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-orange-500 mt-1 mr-3 w-5"></i>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-500 uppercase">Estado</p>
                        <span class="inline-block mt-1 px-3 py-1 rounded-full text-sm font-medium" id="modalEstado">-</span>
                    </div>
                </div>
            </div>

            <!-- Footer del Modal -->
            <div class="bg-gray-50 p-6 rounded-b-xl flex justify-end">
                <button @click="open = false" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-times mr-2"></i>
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
    }

    /* Mejorar la apariencia de los botones del calendario */
    .fc-button {
        background-color: #3B82F6 !important;
        border-color: #3B82F6 !important;
        text-transform: capitalize !important;
    }

    .fc-button:hover {
        background-color: #2563EB !important;
        border-color: #2563EB !important;
    }

    .fc-button-active {
        background-color: #1E40AF !important;
        border-color: #1E40AF !important;
    }

    /* Estilo para días con eventos */
    .fc-day-today {
        background-color: #EFF6FF !important;
    }

    /* Alpine.js cloaking */
    [x-cloak] {
        display: none !important;
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
            const year = info.start.getFullYear();
            const month = info.start.getMonth() + 1;

            fetch(`/socio/calendario/eventos/${year}/${month}`)
                .then(response => response.json())
                .then(data => {
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
                'Virtual': 'bg-blue-100 text-blue-700',
                'Presencial': 'bg-green-100 text-green-700',
                'InicioProyecto': 'bg-yellow-100 text-yellow-700',
                'FinProyecto': 'bg-red-100 text-red-700'
            };
            tipoSpan.className = 'inline-block mt-1 px-3 py-1 rounded-full text-sm font-medium ' + (tipoClasses[tipo] || 'bg-gray-100 text-gray-700');
            
            // Estado
            const estadoSpan = document.getElementById('modalEstado');
            const estado = evento.extendedProps.status || 'Sin estado';
            estadoSpan.textContent = estado;
            
            // Colores según el estado
            const estadoClasses = {
                'Programado': 'bg-blue-100 text-blue-700',
                'EnCurso': 'bg-green-100 text-green-700',
                'Finalizado': 'bg-gray-100 text-gray-700'
            };
            estadoSpan.className = 'inline-block mt-1 px-3 py-1 rounded-full text-sm font-medium ' + (estadoClasses[estado] || 'bg-gray-100 text-gray-700');
            
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