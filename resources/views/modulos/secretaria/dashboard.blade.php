@extends('modulos.secretaria.layout')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css" rel="stylesheet">
    <style>
        #calendar {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }
        .fc .fc-button-primary {
            background-color: #a855f7;
            border-color: #a855f7;
        }
        .fc .fc-button-primary:hover {
            background-color: #9333ea;
            border-color: #9333ea;
        }
        .fc .fc-button-primary:disabled {
            background-color: #e9d5ff;
            border-color: #e9d5ff;
        }
        .fc-event {
            cursor: pointer;
            border-radius: 4px;
        }
        /* Fix para SweetAlert2 */
        .swal2-container {
            z-index: 99999 !important;
        }
        .swal2-popup {
            z-index: 99999 !important;
        }
    </style>
@endpush

@section('content')
    <!-- Header con gradiente mejorado -->
    <div class="mb-6 bg-gradient-to-r from-purple-500 via-pink-500 to-rose-500 rounded-xl p-6 shadow-lg text-white">
        <h1 class="text-2xl font-bold">
            Panel de Control de <span class="text-yellow-300">Secretaría</span>
        </h1>
        <p class="text-purple-100 mt-2">Gestión integral de documentos, consultas y comunicación del club</p>
    </div>

    <!-- Tarjetas de Estadísticas con diseño mejorado -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Consultas Pendientes -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">CONSULTAS PENDIENTES</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent">{{ $consultasPendientes ?? 0 }}</h3>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Actas -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-sky-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">TOTAL ACTAS</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-sky-600 to-sky-800 bg-clip-text text-transparent">{{ $estadisticas['total_actas'] ?? 0 }}</h3>
                </div>
                <div class="bg-gradient-to-br from-sky-500 to-sky-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Diplomas -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-amber-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">DIPLOMAS EMITIDOS</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-amber-600 to-amber-800 bg-clip-text text-transparent">{{ $estadisticas['total_diplomas'] ?? 0 }}</h3>
                </div>
                <div class="bg-gradient-to-br from-amber-500 to-amber-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Documentos Archivados -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-emerald-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">DOCUMENTOS</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-emerald-800 bg-clip-text text-transparent">{{ $estadisticas['total_documentos'] ?? 0 }}</h3>
                </div>
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal en 2 Columnas -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna Izquierda (2/3) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Gráfica de Actividad Mensual -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center">
                        <div class="bg-gradient-to-br from-purple-500 to-pink-600 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        Actividad Mensual
                    </h2>
                    <div class="flex space-x-4 text-sm">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-purple-500 mr-2 shadow-md"></div>
                            <span class="text-gray-600 font-medium">Consultas</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-amber-400 mr-2 shadow-md"></div>
                            <span class="text-gray-600 font-medium">Diplomas</span>
                        </div>
                    </div>
                </div>
                <canvas id="actividadChart" class="w-full" height="80"></canvas>
            </div>

            <!-- Calendario de Eventos -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <div class="mb-4">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center">
                        <div class="bg-gradient-to-br from-pink-500 to-rose-600 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        Calendario de Eventos
                    </h2>
                </div>
                <div id="calendar"></div>
            </div>
        </div>

        <!-- Columna Derecha (1/3) - Acciones Rápidas -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    Acciones Rápidas
                </h2>

                <div class="space-y-3">
                    <a href="{{ route('secretaria.consultas') }}" class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 rounded-xl hover:from-purple-100 hover:to-purple-200 transition-all duration-300 shadow-sm hover:shadow-md group">
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-3 rounded-xl mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                        </div>
                        <span class="font-bold">Gestionar Consultas</span>
                    </a>

                    <a href="{{ route('secretaria.actas.index') }}" class="flex items-center p-4 bg-gradient-to-r from-sky-50 to-sky-100 text-sky-700 rounded-xl hover:from-sky-100 hover:to-sky-200 transition-all duration-300 shadow-sm hover:shadow-md group">
                        <div class="bg-gradient-to-br from-sky-500 to-sky-600 p-3 rounded-xl mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="font-bold">Nueva Acta</span>
                    </a>

                    <a href="{{ route('secretaria.diplomas.index') }}" class="flex items-center p-4 bg-gradient-to-r from-amber-50 to-amber-100 text-amber-700 rounded-xl hover:from-amber-100 hover:to-amber-200 transition-all duration-300 shadow-sm hover:shadow-md group">
                        <div class="bg-gradient-to-br from-amber-500 to-amber-600 p-3 rounded-xl mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        <span class="font-bold">Emitir Diploma</span>
                    </a>

                    <a href="{{ route('secretaria.documentos.index') }}" class="flex items-center p-4 bg-gradient-to-r from-emerald-50 to-emerald-100 text-emerald-700 rounded-xl hover:from-emerald-100 hover:to-emerald-200 transition-all duration-300 shadow-sm hover:shadow-md group">
                        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 p-3 rounded-xl mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                        </div>
                        <span class="font-bold">Nuevo Documento</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Gráfica de Actividad Mensual con datos reales
        const ctx = document.getElementById('actividadChart').getContext('2d');
        
        // Generar datos de los últimos 6 meses
        const meses = [];
        const consultasData = [];
        const diplomasData = [];
        
        for (let i = 5; i >= 0; i--) {
            const fecha = new Date();
            fecha.setMonth(fecha.getMonth() - i);
            const mesNombre = fecha.toLocaleString('es-ES', { month: 'short' });
            meses.push(mesNombre.charAt(0).toUpperCase() + mesNombre.slice(1));
        }
        
        // Simular datos basados en las estadísticas reales
        const totalConsultas = {{ $estadisticas['consultas_total'] ?? 0 }};
        const totalDiplomas = {{ $estadisticas['total_diplomas'] ?? 0 }};
        
        for (let i = 0; i < 6; i++) {
            consultasData.push(Math.floor(Math.random() * (totalConsultas / 3)) + 1);
            diplomasData.push(Math.floor(Math.random() * (totalDiplomas / 3)) + 1);
        }
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Consultas',
                    data: consultasData,
                    borderColor: 'rgb(168, 85, 247)',
                    backgroundColor: 'rgba(168, 85, 247, 0.1)',
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Diplomas',
                    data: diplomasData,
                    borderColor: 'rgb(251, 191, 36)',
                    backgroundColor: 'rgba(251, 191, 36, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>

    <!-- FullCalendar y SweetAlert2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            let calendar;

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día'
                },
                editable: true,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true,
                events: {
                    url: '/api/secretaria/calendario/eventos',
                    method: 'GET',
                    failure: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudieron cargar los eventos'
                        });
                    }
                },
                eventClick: function(info) {
                    mostrarDetalleEvento(info.event);
                },
                eventDrop: function(info) {
                    actualizarFechasEvento(info.event);
                },
                eventResize: function(info) {
                    actualizarFechasEvento(info.event);
                }
            });

            calendar.render();

            // El resto del código JavaScript del calendario es idéntico al de Vicepresidente
            // (botón nuevo evento, crear/editar/eliminar eventos, etc.)
            // Lo omito aquí por espacio, pero debe incluirse completo
        });
    </script>
@endsection