@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Calendario de Eventos - Secretaría</h2>
                    <a href="{{ route('secretaria.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Volver al Dashboard
                    </a>
                </div>
                
                <div id="calendar" style="min-height: 600px;"></div>
            </div>
        </div>
    </div>
</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    // Hacer calendar global para el sistema de notificaciones
    window.calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        height: 'auto',
        events: '/api/secretaria/calendario/eventos',
        eventColor: '#ec4899',
        editable: false,  // Secretaría NO puede mover eventos
        selectable: false, // Secretaría NO puede seleccionar fechas
        eventClick: function(info) {
            // Solo ver información del evento
            alert('Evento: ' + info.event.title + '\nFecha: ' + info.event.start.toLocaleDateString());
        }
    });
    window.calendar.render();
});
</script>
@endsection
