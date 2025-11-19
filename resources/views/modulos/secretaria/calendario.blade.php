@extends('modulos.secretaria.layout')  

@section('title', 'Calendario de Eventos')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Calendario de Eventos</h1>
            <p class="text-gray-600 mt-1">Visualiza todos los eventos del club</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('secretaria.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Dashboard
            </a>
        </div>
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <!-- Panel del Calendario -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Header del Calendario -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Calendario de Eventos</h2>
                        </div>
                    </div>
                </div>

                <!-- Cuerpo del Calendario -->
                <div class="p-6">
                    <!-- Controles de Navegación -->
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <div class="flex items-center gap-2">
                            <button id="prevMonth" class="w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button id="nextMonth" class="w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                            <button id="todayBtn" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                                Hoy
                            </button>
                        </div>

                        <h3 id="currentMonth" class="text-2xl font-bold text-gray-800"></h3>

                        <div class="flex items-center gap-2">
                            <button id="viewMonth" class="px-4 py-2 bg-gray-800 text-white rounded-lg font-medium transition-colors">
                                Mes
                            </button>
                            <button id="viewWeek" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                                Semana
                            </button>
                            <button id="viewDay" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                                Día
                            </button>
                        </div>
                    </div>

                    <!-- Grid del Calendario -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <!-- Días de la semana -->
                        <div class="grid grid-cols-7 bg-gray-50 border-b border-gray-200">
                            <div class="p-3 text-center text-sm font-bold text-gray-700 border-r border-gray-200">dom</div>
                            <div class="p-3 text-center text-sm font-bold text-gray-700 border-r border-gray-200">lun</div>
                            <div class="p-3 text-center text-sm font-bold text-gray-700 border-r border-gray-200">mar</div>
                            <div class="p-3 text-center text-sm font-bold text-gray-700 border-r border-gray-200">mié</div>
                            <div class="p-3 text-center text-sm font-bold text-gray-700 border-r border-gray-200">jue</div>
                            <div class="p-3 text-center text-sm font-bold text-gray-700 border-r border-gray-200">vie</div>
                            <div class="p-3 text-center text-sm font-bold text-gray-700">sáb</div>
                        </div>

                        <!-- Días del calendario -->
                        <div id="calendarDays" class="grid grid-cols-7 min-h-[500px]">
                            <!-- Los días se generarán dinámicamente con JavaScript -->
                        </div>
                    </div>

                    <!-- Leyenda de colores -->
                    <div class="mt-6 flex flex-wrap gap-4 justify-center">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="text-sm text-gray-600">Reuniones</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                            <span class="text-sm text-gray-600">Eventos</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <span class="text-sm text-gray-600">Importante</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                            <span class="text-sm text-gray-600">Actividades</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ver Evento -->
    <div id="modalVerEvento" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-2/3 lg:w-1/2 shadow-2xl rounded-xl bg-white">
            <!-- Header -->
            <div class="bg-purple-600 px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Detalles del Evento</h3>
                    <button onclick="cerrarModalEvento()" class="text-white hover:text-gray-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div id="contenidoEvento" class="p-6">
                <!-- Contenido dinámico del evento -->
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t rounded-b-xl flex justify-end">
                <button onclick="cerrarModalEvento()" class="px-6 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-medium shadow-sm">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentDate = new Date();
        let eventos = [];
        let currentView = 'month';

        // Obtener eventos desde el API
        async function cargarEventos() {
            try {
                const response = await fetch('/api/secretaria/calendario/eventos');
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                console.log('Eventos cargados:', data); // Debug
                
                // El API puede devolver un array directo o un objeto con propiedad 'data'
                eventos = Array.isArray(data) ? data : (data.data || []);
                
                console.log('Total eventos procesados:', eventos.length); // Debug
                renderCalendar();
            } catch (error) {
                console.error('Error al cargar eventos:', error);
                eventos = [];
                renderCalendar();
                
                // Mostrar mensaje al usuario
                alert('No se pudieron cargar los eventos. Por favor, recarga la página.');
            }
        }

        // Renderizar el calendario
        function renderCalendar() {
            const calendarDays = document.getElementById('calendarDays');
            const currentMonth = document.getElementById('currentMonth');
            
            // Actualizar título del mes
            const monthNames = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
                'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
            currentMonth.textContent = `${monthNames[currentDate.getMonth()]} de ${currentDate.getFullYear()}`;
            
            // Limpiar días previos
            calendarDays.innerHTML = '';
            
            // Primer día del mes
            const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
            const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
            
            // Días del mes anterior para completar la primera semana
            const prevMonthDays = firstDay.getDay();
            const prevMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 0);
            
            // Días del mes anterior
            for (let i = prevMonthDays - 1; i >= 0; i--) {
                const day = prevMonth.getDate() - i;
                const dayDiv = createDayElement(day, true, new Date(prevMonth.getFullYear(), prevMonth.getMonth(), day));
                calendarDays.appendChild(dayDiv);
            }
            
            // Días del mes actual
            for (let day = 1; day <= lastDay.getDate(); day++) {
                const dayDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
                const dayDiv = createDayElement(day, false, dayDate);
                calendarDays.appendChild(dayDiv);
            }
            
            // Días del siguiente mes para completar la última semana
            const remainingDays = 42 - (prevMonthDays + lastDay.getDate());
            for (let day = 1; day <= remainingDays; day++) {
                const dayDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, day);
                const dayDiv = createDayElement(day, true, dayDate);
                calendarDays.appendChild(dayDiv);
            }
        }

        // Crear elemento de día
        function createDayElement(day, isOtherMonth, date) {
            const dayDiv = document.createElement('div');
            dayDiv.className = `min-h-[100px] p-2 border-r border-b border-gray-200 ${isOtherMonth ? 'bg-gray-50' : 'bg-white'} hover:bg-gray-50 transition-colors`;
            
            // Resaltar día actual
            const today = new Date();
            const isToday = date.getDate() === today.getDate() && 
                           date.getMonth() === today.getMonth() && 
                           date.getFullYear() === today.getFullYear();
            
            // Número del día
            const dayNumber = document.createElement('div');
            dayNumber.className = `text-sm font-semibold mb-1 ${isOtherMonth ? 'text-gray-400' : 'text-gray-700'}`;
            if (isToday) {
                dayNumber.className += ' w-7 h-7 bg-blue-600 text-white rounded-full flex items-center justify-center';
            }
            dayNumber.textContent = day;
            dayDiv.appendChild(dayNumber);
            
            // Eventos del día
            if (!isOtherMonth) {
                const dayEvents = getEventsForDate(date);
                
                // Debug: ver eventos del día
                if (dayEvents.length > 0) {
                    console.log(`Día ${day}: ${dayEvents.length} evento(s)`, dayEvents);
                }
                
                dayEvents.forEach((evento, index) => {
                    if (index < 3) { // Máximo 3 eventos por día
                        const eventDiv = document.createElement('div');
                        
                        // Obtener el título del evento
                        const titulo = evento.title || evento.titulo || 'Sin título';
                        
                        // Obtener la hora si existe
                        let hora = '';
                        if (evento.hora) {
                            hora = evento.hora;
                        } else if (evento.start) {
                            const startDate = new Date(evento.start);
                            if (!isNaN(startDate.getTime())) {
                                hora = startDate.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
                            }
                        }
                        
                        eventDiv.className = `text-xs px-2 py-1 mb-1 rounded cursor-pointer hover:opacity-80 transition-opacity ${getEventColor(evento.tipo || evento.type)}`;
                        eventDiv.textContent = hora ? `${hora} ${titulo}` : titulo;
                        eventDiv.onclick = () => mostrarEvento(evento);
                        dayDiv.appendChild(eventDiv);
                    }
                });
                
                if (dayEvents.length > 3) {
                    const moreDiv = document.createElement('div');
                    moreDiv.className = 'text-xs text-gray-500 font-medium cursor-pointer hover:text-gray-700';
                    moreDiv.textContent = `+${dayEvents.length - 3} más`;
                    moreDiv.onclick = () => mostrarEventosDelDia(date, dayEvents);
                    dayDiv.appendChild(moreDiv);
                }
            }
            
            return dayDiv;
        }

        // Obtener eventos de una fecha específica
        function getEventsForDate(date) {
            return eventos.filter(evento => {
                let eventoDate;
                if (evento.start) {
                    // Puede venir como "2025-11-28" o "2025-11-28T17:00:00"
                    eventoDate = new Date(evento.start);
                } else if (evento.fecha) {
                    eventoDate = new Date(evento.fecha);
                } else {
                    return false;
                }
                
                // Asegurar que la comparación de fechas sea correcta
                return eventoDate.getDate() === date.getDate() &&
                       eventoDate.getMonth() === date.getMonth() &&
                       eventoDate.getFullYear() === date.getFullYear();
            });
        }

        // Obtener color según tipo de evento
        function getEventColor(tipo) {
            // Normalizar el tipo a minúsculas
            const tipoNormalizado = (tipo || '').toLowerCase();
            
            const colores = {
                'reunion': 'bg-green-100 text-green-800',
                'reuniones': 'bg-green-100 text-green-800',
                'evento': 'bg-blue-100 text-blue-800',
                'eventos': 'bg-blue-100 text-blue-800',
                'importante': 'bg-red-100 text-red-800',
                'actividad': 'bg-purple-100 text-purple-800',
                'actividades': 'bg-purple-100 text-purple-800'
            };
            
            return colores[tipoNormalizado] || 'bg-gray-100 text-gray-800';
        }

        // Mostrar detalles de un evento
        function mostrarEvento(evento) {
            const modal = document.getElementById('modalVerEvento');
            const contenedor = document.getElementById('contenidoEvento');
            
            console.log('Mostrando evento:', evento); // Debug
            
            // Obtener la fecha del evento
            let fechaEvento;
            if (evento.start) {
                fechaEvento = new Date(evento.start);
            } else if (evento.fecha) {
                fechaEvento = new Date(evento.fecha);
            } else {
                fechaEvento = new Date();
            }
            
            const fechaFormateada = fechaEvento.toLocaleDateString('es-ES', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            // Obtener título
            const titulo = evento.title || evento.titulo || 'Sin título';
            
            // Obtener hora
            let hora = '';
            if (evento.hora) {
                hora = evento.hora;
            } else if (evento.start) {
                const startDate = new Date(evento.start);
                if (!isNaN(startDate.getTime())) {
                    hora = startDate.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
                }
            }
            
            // Obtener descripción
            const descripcion = evento.descripcion || evento.description || '';
            
            contenedor.innerHTML = `
                <div class="space-y-4">
                    <div class="bg-gradient-to-br from-purple-50 to-indigo-50 p-4 rounded-lg">
                        <h4 class="text-xl font-bold text-gray-800 mb-2">${titulo}</h4>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="capitalize">${fechaFormateada}</span>
                        </div>
                        ${hora ? `
                        <div class="flex items-center gap-2 text-sm text-gray-600 mt-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>${hora}</span>
                        </div>
                        ` : ''}
                    </div>

                    ${descripcion ? `
                    <div class="bg-white border-2 border-gray-200 p-4 rounded-lg">
                        <p class="text-xs font-medium text-gray-500 uppercase mb-2">Descripción</p>
                        <p class="text-sm text-gray-700">${descripcion}</p>
                    </div>
                    ` : ''}

                    ${evento.ubicacion || evento.location ? `
                    <div class="bg-white border-2 border-gray-200 p-4 rounded-lg">
                        <p class="text-xs font-medium text-gray-500 uppercase mb-2">Ubicación</p>
                        <div class="flex items-center gap-2 text-sm text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>${evento.ubicacion || evento.location}</span>
                        </div>
                    </div>
                    ` : ''}
                </div>
            `;
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Mostrar todos los eventos de un día
        function mostrarEventosDelDia(fecha, eventosDelDia) {
            const modal = document.getElementById('modalVerEvento');
            const contenedor = document.getElementById('contenidoEvento');
            
            const fechaFormateada = fecha.toLocaleDateString('es-ES', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            let eventosHTML = eventosDelDia.map(evento => `
                <div class="border-l-4 ${getBorderColor(evento.tipo)} bg-gray-50 p-4 rounded-r-lg mb-3 cursor-pointer hover:bg-gray-100 transition-colors" onclick='mostrarEvento(${JSON.stringify(evento)})'>
                    <div class="flex justify-between items-start">
                        <div>
                            <h5 class="font-semibold text-gray-800">${evento.title || evento.titulo}</h5>
                            ${evento.hora ? `<p class="text-sm text-gray-600 mt-1">${evento.hora}</p>` : ''}
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            `).join('');
            
            contenedor.innerHTML = `
                <div>
                    <h4 class="text-xl font-bold text-gray-800 mb-4 capitalize">${fechaFormateada}</h4>
                    <p class="text-sm text-gray-600 mb-4">${eventosDelDia.length} evento(s) programado(s)</p>
                    <div class="space-y-3">
                        ${eventosHTML}
                    </div>
                </div>
            `;
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function getBorderColor(tipo) {
            const colores = {
                'reunion': 'border-green-500',
                'evento': 'border-blue-500',
                'importante': 'border-red-500',
                'actividad': 'border-purple-500'
            };
            return colores[tipo] || 'border-gray-500';
        }

        function cerrarModalEvento() {
            document.getElementById('modalVerEvento').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Navegación
        document.getElementById('prevMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });

        document.getElementById('todayBtn').addEventListener('click', () => {
            currentDate = new Date();
            renderCalendar();
        });

        // Cambio de vista (preparado para futuras implementaciones)
        document.getElementById('viewMonth').addEventListener('click', function() {
            currentView = 'month';
            updateViewButtons(this);
            renderCalendar();
        });

        document.getElementById('viewWeek').addEventListener('click', function() {
            currentView = 'week';
            updateViewButtons(this);
            alert('Vista semanal próximamente');
        });

        document.getElementById('viewDay').addEventListener('click', function() {
            currentView = 'day';
            updateViewButtons(this);
            alert('Vista diaria próximamente');
        });

        function updateViewButtons(activeBtn) {
            document.querySelectorAll('[id^="view"]').forEach(btn => {
                btn.className = 'px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors';
            });
            activeBtn.className = 'px-4 py-2 bg-gray-800 text-white rounded-lg font-medium transition-colors';
        }

        // Cerrar modal al hacer clic fuera
        document.getElementById('modalVerEvento')?.addEventListener('click', function(e) {
            if (e.target === this) cerrarModalEvento();
        });

        // Inicializar
        document.addEventListener('DOMContentLoaded', function() {
            cargarEventos();
        });
    </script>

    <style>
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

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }

        #calendarDays > div:nth-child(7n) {
            border-right: none;
        }

        #calendarDays > div:nth-last-child(-n+7) {
            border-bottom: none;
        }
    </style>
@endsection