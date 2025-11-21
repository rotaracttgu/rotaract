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
                            <span class="text-sm text-gray-600">Reunión Presencial</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                            <span class="text-sm text-gray-600">Reunión Virtual</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                            <span class="text-sm text-gray-600">Inicio Proyecto</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <span class="text-sm text-gray-600">Fin Proyecto</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-gray-500"></div>
                            <span class="text-sm text-gray-600">Otros</span>
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
                
                // Contenedor de eventos
                const eventsContainer = document.createElement('div');
                eventsContainer.className = 'space-y-1';
                
                dayEvents.forEach((evento, index) => {
                    if (index < 3) { // Máximo 3 eventos por día
                        const eventDiv = document.createElement('div');
                        
                        // Obtener el título del evento
                        const titulo = evento.title || evento.titulo || 'Sin título';
                        
                        // Obtener la hora si existe
                        let hora = '';
                        if (evento.extendedProps?.hora_inicio) {
                            hora = evento.extendedProps.hora_inicio.substring(0, 5);
                        } else if (evento.start) {
                            const startDate = new Date(evento.start);
                            if (!isNaN(startDate.getTime()) && evento.start.includes('T')) {
                                hora = startDate.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
                            }
                        }
                        
                        // Obtener tipo de evento
                        const tipo = evento.extendedProps?.tipo_evento || evento.tipo || evento.type || 'otros';
                        
                        // Crear elemento con puntito de color
                        eventDiv.className = 'flex items-start gap-1 text-xs cursor-pointer hover:bg-gray-100 p-1 rounded transition-colors';
                        eventDiv.innerHTML = `
                            <span class="w-2 h-2 rounded-full ${getEventDot(tipo)} mt-1 flex-shrink-0"></span>
                            <span class="text-gray-700 line-clamp-1">${hora ? hora + ' ' : ''}${titulo}</span>
                        `;
                        eventDiv.onclick = () => mostrarEvento(evento);
                        eventsContainer.appendChild(eventDiv);
                    }
                });
                
                dayDiv.appendChild(eventsContainer);
                
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

        // Renderizar vista semanal
        function renderWeekView() {
            const calendarDays = document.getElementById('calendarDays');
            const currentMonth = document.getElementById('currentMonth');
            
            // Obtener el inicio de la semana (domingo)
            const startOfWeek = new Date(currentDate);
            startOfWeek.setDate(currentDate.getDate() - currentDate.getDay());
            
            // Obtener el fin de la semana (sábado)
            const endOfWeek = new Date(startOfWeek);
            endOfWeek.setDate(startOfWeek.getDate() + 6);
            
            // Actualizar título
            const monthNames = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
                'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
            currentMonth.textContent = `Semana del ${startOfWeek.getDate()} al ${endOfWeek.getDate()} de ${monthNames[startOfWeek.getMonth()]} ${startOfWeek.getFullYear()}`;
            
            // Limpiar calendario
            calendarDays.innerHTML = '';
            calendarDays.className = 'grid grid-cols-7 min-h-[500px]';
            
            // Renderizar los 7 días de la semana
            for (let i = 0; i < 7; i++) {
                const day = new Date(startOfWeek);
                day.setDate(startOfWeek.getDate() + i);
                const dayDiv = createDayElement(day.getDate(), false, day);
                calendarDays.appendChild(dayDiv);
            }
        }

        // Renderizar vista diaria
        function renderDayView() {
            const calendarDays = document.getElementById('calendarDays');
            const currentMonth = document.getElementById('currentMonth');
            
            // Actualizar título
            const dayNames = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
            const monthNames = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
                'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
            currentMonth.textContent = `${dayNames[currentDate.getDay()]}, ${currentDate.getDate()} de ${monthNames[currentDate.getMonth()]} de ${currentDate.getFullYear()}`;
            
            // Limpiar calendario
            calendarDays.innerHTML = '';
            calendarDays.className = 'grid grid-cols-1 min-h-[500px]';
            
            // Obtener eventos del día
            const dayEvents = getEventsForDate(currentDate);
            
            // Crear vista detallada del día
            const dayView = document.createElement('div');
            dayView.className = 'p-6 bg-white';
            
            if (dayEvents.length === 0) {
                dayView.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-12 text-gray-500">
                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-lg font-medium">No hay eventos programados para este día</p>
                    </div>
                `;
            } else {
                let eventosHTML = '<div class="space-y-4">';
                
                // Ordenar eventos por hora
                dayEvents.sort((a, b) => {
                    const horaA = a.extendedProps?.hora_inicio || '00:00';
                    const horaB = b.extendedProps?.hora_inicio || '00:00';
                    return horaA.localeCompare(horaB);
                });
                
                dayEvents.forEach(evento => {
                    const titulo = evento.title || evento.titulo || 'Sin título';
                    const tipo = evento.extendedProps?.tipo_evento || evento.tipo || 'otros';
                    const hora = evento.extendedProps?.hora_inicio ? evento.extendedProps.hora_inicio.substring(0, 5) : '';
                    const horaFin = evento.extendedProps?.hora_fin ? evento.extendedProps.hora_fin.substring(0, 5) : '';
                    const descripcion = evento.extendedProps?.descripcion || '';
                    const ubicacion = evento.extendedProps?.ubicacion || '';
                    
                    eventosHTML += `
                        <div class="border-l-4 ${getBorderColor(tipo)} bg-gray-50 p-6 rounded-r-lg hover:shadow-md transition-shadow cursor-pointer" onclick='mostrarEvento(eventos.find(e => e.id === ${evento.id}))'>
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h4 class="text-lg font-bold text-gray-800">${titulo}</h4>
                                    ${hora ? `<p class="text-sm text-gray-600 mt-1">🕐 ${hora}${horaFin ? ' - ' + horaFin : ''}</p>` : ''}
                                </div>
                                <span class="px-3 py-1 ${getEventColor(tipo)} text-xs font-semibold rounded-full capitalize">
                                    ${tipo.replace(/([A-Z])/g, ' $1').trim()}
                                </span>
                            </div>
                            ${descripcion ? `<p class="text-sm text-gray-700 mb-2">${descripcion}</p>` : ''}
                            ${ubicacion ? `<p class="text-sm text-gray-600">📍 ${ubicacion}</p>` : ''}
                        </div>
                    `;
                });
                
                eventosHTML += '</div>';
                dayView.innerHTML = eventosHTML;
            }
            
            calendarDays.appendChild(dayView);
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
            // Normalizar el tipo
            const tipoNormalizado = (tipo || '').toLowerCase().replace(/[\s-]/g, '');
            
            const colores = {
                'virtual': 'bg-blue-100 text-blue-800',
                'presencial': 'bg-green-100 text-green-800',
                'reunion-virtual': 'bg-blue-100 text-blue-800',
                'reunion-presencial': 'bg-green-100 text-green-800',
                'reunionvirtual': 'bg-blue-100 text-blue-800',
                'reunionpresencial': 'bg-green-100 text-green-800',
                'inicioproyecto': 'bg-purple-100 text-purple-800',
                'inicio-proyecto': 'bg-purple-100 text-purple-800',
                'finproyecto': 'bg-red-100 text-red-800',
                'finalizar-proyecto': 'bg-red-100 text-red-800',
                'finalizarproyecto': 'bg-red-100 text-red-800',
                'otros': 'bg-gray-100 text-gray-800',
                'importante': 'bg-red-100 text-red-800'
            };
            
            return colores[tipoNormalizado] || 'bg-gray-100 text-gray-800';
        }
        
        // Obtener puntito de color según tipo de evento
        function getEventDot(tipo) {
            const tipoNormalizado = (tipo || '').toLowerCase().replace(/[\s-]/g, '');
            
            const colores = {
                'virtual': 'bg-blue-500',
                'presencial': 'bg-green-500',
                'reunion-virtual': 'bg-blue-500',
                'reunion-presencial': 'bg-green-500',
                'reunionvirtual': 'bg-blue-500',
                'reunionpresencial': 'bg-green-500',
                'inicioproyecto': 'bg-purple-500',
                'inicio-proyecto': 'bg-purple-500',
                'finproyecto': 'bg-red-500',
                'finalizar-proyecto': 'bg-red-500',
                'finalizarproyecto': 'bg-red-500',
                'otros': 'bg-gray-500',
                'importante': 'bg-red-500'
            };
            
            return colores[tipoNormalizado] || 'bg-gray-500';
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
            
            // Obtener hora desde extendedProps o start
            let hora = '';
            if (evento.extendedProps?.hora_inicio) {
                const horaInicio = evento.extendedProps.hora_inicio.substring(0, 5);
                const horaFin = evento.extendedProps?.hora_fin ? evento.extendedProps.hora_fin.substring(0, 5) : '';
                hora = horaFin ? `${horaInicio} - ${horaFin}` : horaInicio;
            } else if (evento.start && evento.start.includes('T')) {
                const startDate = new Date(evento.start);
                if (!isNaN(startDate.getTime())) {
                    hora = startDate.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
                }
            }
            
            // Obtener descripción
            const descripcion = evento.extendedProps?.descripcion || evento.descripcion || evento.description || '';
            
            // Obtener ubicación
            const ubicacion = evento.extendedProps?.ubicacion || evento.ubicacion || evento.location || '';
            
            // Obtener tipo y estado
            const tipo = evento.extendedProps?.tipo_evento || evento.tipo || 'otros';
            const estado = evento.extendedProps?.estado || evento.estado || '';
            
            contenedor.innerHTML = `
                <div class="space-y-4">
                    <div class="bg-gradient-to-br from-purple-50 to-indigo-50 p-4 rounded-lg">
                        <div class="flex items-start justify-between mb-2">
                            <h4 class="text-xl font-bold text-gray-800">${titulo}</h4>
                            <span class="px-3 py-1 ${getEventColor(tipo).replace('text-', 'bg-').split(' ')[0]} ${getEventColor(tipo).split(' ')[1]} text-xs font-semibold rounded-full capitalize">
                                ${tipo.replace(/([A-Z])/g, ' $1').trim()}
                            </span>
                        </div>
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
                        ${estado ? `
                        <div class="flex items-center gap-2 text-sm text-gray-600 mt-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="capitalize">${estado}</span>
                        </div>
                        ` : ''}
                    </div>

                    ${descripcion ? `
                    <div class="bg-white border-2 border-gray-200 p-4 rounded-lg">
                        <p class="text-xs font-medium text-gray-500 uppercase mb-2">Descripción</p>
                        <p class="text-sm text-gray-700">${descripcion}</p>
                    </div>
                    ` : ''}

                    ${ubicacion ? `
                    <div class="bg-white border-2 border-gray-200 p-4 rounded-lg">
                        <p class="text-xs font-medium text-gray-500 uppercase mb-2">Ubicación</p>
                        <div class="flex items-center gap-2 text-sm text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>${ubicacion}</span>
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
            
            let eventosHTML = eventosDelDia.map((evento, index) => {
                const tipo = evento.extendedProps?.tipo_evento || evento.tipo || 'otros';
                const titulo = evento.title || evento.titulo || 'Sin título';
                const hora = evento.extendedProps?.hora_inicio ? evento.extendedProps.hora_inicio.substring(0, 5) : '';
                
                return `
                <div class="border-l-4 ${getBorderColor(tipo)} bg-gray-50 p-4 rounded-r-lg mb-3 cursor-pointer hover:bg-gray-100 transition-colors" onclick='mostrarEvento(eventos[${eventosDelDia.findIndex(e => e.id === evento.id)}])'>
                    <div class="flex justify-between items-start">
                        <div>
                            <h5 class="font-semibold text-gray-800">${titulo}</h5>
                            ${hora ? `<p class="text-sm text-gray-600 mt-1">${hora}</p>` : ''}
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
                `;
            }).join('');
            
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
            const tipoNormalizado = (tipo || '').toLowerCase().replace(/[\s-]/g, '');
            const colores = {
                'virtual': 'border-blue-500',
                'presencial': 'border-green-500',
                'reunionvirtual': 'border-blue-500',
                'reunionpresencial': 'border-green-500',
                'inicioproyecto': 'border-purple-500',
                'finproyecto': 'border-red-500',
                'finalizarproyecto': 'border-red-500',
                'otros': 'border-gray-500'
            };
            return colores[tipoNormalizado] || 'border-gray-500';
        }

        function cerrarModalEvento() {
            document.getElementById('modalVerEvento').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Navegación
        document.getElementById('prevMonth').addEventListener('click', () => {
            if (currentView === 'month') {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            } else if (currentView === 'week') {
                currentDate.setDate(currentDate.getDate() - 7);
                renderWeekView();
            } else if (currentView === 'day') {
                currentDate.setDate(currentDate.getDate() - 1);
                renderDayView();
            }
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
            if (currentView === 'month') {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            } else if (currentView === 'week') {
                currentDate.setDate(currentDate.getDate() + 7);
                renderWeekView();
            } else if (currentView === 'day') {
                currentDate.setDate(currentDate.getDate() + 1);
                renderDayView();
            }
        });

        document.getElementById('todayBtn').addEventListener('click', () => {
            currentDate = new Date();
            if (currentView === 'month') {
                renderCalendar();
            } else if (currentView === 'week') {
                renderWeekView();
            } else if (currentView === 'day') {
                renderDayView();
            }
        });

        // Cambio de vista
        document.getElementById('viewMonth').addEventListener('click', function() {
            currentView = 'month';
            updateViewButtons(this);
            renderCalendar();
        });

        document.getElementById('viewWeek').addEventListener('click', function() {
            currentView = 'week';
            updateViewButtons(this);
            renderWeekView();
        });

        document.getElementById('viewDay').addEventListener('click', function() {
            currentView = 'day';
            updateViewButtons(this);
            renderDayView();
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
        
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endsection