@extends('modulos.vicepresidente.layout')

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
            background-color: #2563eb;
            border-color: #2563eb;
        }
        .fc .fc-button-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }
        .fc .fc-button-primary:disabled {
            background-color: #93c5fd;
            border-color: #93c5fd;
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
    <div class="mb-6 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 rounded-xl p-6 shadow-lg text-white">
        <h1 class="text-2xl font-bold">
            Resumen general de actividades y <span class="text-yellow-300">proyectos</span>
        </h1>
        <p class="text-blue-100 mt-2">Bienvenido al panel de control del Vicepresidente</p>
    </div>

    <!-- Tarjetas de Estadísticas con diseño mejorado -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Proyectos -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">TOTAL PROYECTOS</p>
                    <div class="flex items-baseline">
                        <h3 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">{{ $totalProyectos ?? 0 }}</h3>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Proyectos Activos -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">PROYECTOS ACTIVOS</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent">{{ $proyectosActivos ?? 0 }}</h3>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Cartas Pendientes -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">CARTAS PENDIENTES</p>
                    <div class="flex items-baseline">
                        <h3 class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-orange-800 bg-clip-text text-transparent">{{ $cartasPendientes ?? 0 }}</h3>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Reuniones Hoy -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">REUNIONES HOY</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent">{{ $reunionesHoy ?? 0 }}</h3>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
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
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                        </div>
                        Actividad Mensual
                    </h2>
                    <div class="flex space-x-4 text-sm">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-blue-500 mr-2 shadow-md"></div>
                            <span class="text-gray-600 font-medium">Proyectos</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-orange-400 mr-2 shadow-md"></div>
                            <span class="text-gray-600 font-medium">Reuniones</span>
                        </div>
                    </div>
                </div>
                <canvas id="actividadChart" class="w-full" height="80"></canvas>
            </div>

            <!-- Calendario de Eventos -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center">
                        <div class="bg-gradient-to-br from-purple-500 to-pink-600 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        Calendario de Eventos
                    </h2>
                    <button id="btnNuevoEvento" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 text-sm font-semibold shadow-sm hover:shadow-md">
                        + Nuevo Evento
                    </button>
                </div>
                <div id="calendar"></div>
            </div>
        </div>

        <!-- Columna Derecha (1/3) - Acciones Rápidas -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <div class="bg-gradient-to-br from-green-500 to-green-600 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    Acciones Rápidas
                </h2>

                <div class="space-y-3">
                    <a href="{{ route('vicepresidente.estado.proyectos') }}" class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-300 shadow-sm hover:shadow-md group">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="font-bold">Nuevo Proyecto</span>
                    </a>

                    <a href="{{ route('vicepresidente.cartas.patrocinio') }}" class="flex items-center p-4 bg-gradient-to-r from-orange-50 to-orange-100 text-orange-700 rounded-xl hover:from-orange-100 hover:to-orange-200 transition-all duration-300 shadow-sm hover:shadow-md group">
                        <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="font-bold">Enviar Carta</span>
                    </a>

                    <a href="{{ route('vicepresidente.cartas.formales') }}" class="flex items-center p-4 bg-gradient-to-r from-green-50 to-green-100 text-green-700 rounded-xl hover:from-green-100 hover:to-green-200 transition-all duration-300 shadow-sm hover:shadow-md group">
                        <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-xl mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="font-bold">Cartas Formales</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Gráfica de Actividad Mensual con datos reales
        const ctx = document.getElementById('actividadChart').getContext('2d');
        
        const mesesData = {!! json_encode($datosActividad['meses'] ?? ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun']) !!};
        const proyectosData = {!! json_encode($datosActividad['proyectos'] ?? [2, 4, 3, 5, 7, 4]) !!};
        const reunionesData = {!! json_encode($datosActividad['reuniones'] ?? [3, 2, 4, 3, 6, 5]) !!};
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: mesesData,
                datasets: [{
                    label: 'Proyectos',
                    data: proyectosData,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Reuniones',
                    data: reunionesData,
                    borderColor: 'rgb(251, 146, 60)',
                    backgroundColor: 'rgba(251, 146, 60, 0.1)',
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

            // Inicializar FullCalendar
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
                    url: '/api/vicepresidente/calendario/eventos',
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

            // Botón Nuevo Evento
            document.getElementById('btnNuevoEvento').addEventListener('click', function() {
                // Primero cargar lista de miembros
                fetch('/api/vicepresidente/calendario/miembros', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    let miembrosOptions = '<option value="">Seleccione un organizador...</option>';
                    if (data.success && data.miembros) {
                        data.miembros.forEach(miembro => {
                            miembrosOptions += `<option value="${miembro.MiembroID}">${miembro.Nombre} - ${miembro.Rol}</option>`;
                        });
                    }
                    
                    Swal.fire({
                        title: '<span style="color: #ea580c;">Crear Nuevo Evento</span>',
                        html: `
                            <style>
                                .custom-modal-vicepresidente .swal2-title {
                                    background: linear-gradient(135deg, #ea580c 0%, #fb923c 100%);
                                    -webkit-background-clip: text;
                                    -webkit-text-fill-color: transparent;
                                    font-weight: 700;
                                }
                                .form-group-custom {
                                    margin-bottom: 18px;
                                    text-align: left;
                                }
                                .form-label-custom {
                                    display: block;
                                    font-size: 13px;
                                    font-weight: 600;
                                    color: #4b5563;
                                    margin-bottom: 8px;
                                    text-align: left;
                                }
                                .form-label-custom .required {
                                    color: #ef4444;
                                    margin-left: 2px;
                                }
                                .form-input-custom {
                                    width: 100%;
                                    padding: 10px 14px;
                                    border: 2px solid #e5e7eb;
                                    border-radius: 8px;
                                    font-size: 14px;
                                    transition: all 0.3s ease;
                                    background: white;
                                }
                                .form-input-custom:focus {
                                    outline: none;
                                    border-color: #ea580c;
                                    box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.1);
                                }
                                .form-select-custom {
                                    width: 100%;
                                    padding: 10px 14px;
                                    border: 2px solid #e5e7eb;
                                    border-radius: 8px;
                                    font-size: 14px;
                                    transition: all 0.3s ease;
                                    background: white;
                                    cursor: pointer;
                                }
                                .form-select-custom:focus {
                                    outline: none;
                                    border-color: #ea580c;
                                    box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.1);
                                }
                                .form-textarea-custom {
                                    width: 100%;
                                    padding: 10px 14px;
                                    border: 2px solid #e5e7eb;
                                    border-radius: 8px;
                                    font-size: 14px;
                                    min-height: 70px;
                                    resize: vertical;
                                    transition: all 0.3s ease;
                                    font-family: inherit;
                                }
                                .form-textarea-custom:focus {
                                    outline: none;
                                    border-color: #ea580c;
                                    box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.1);
                                }
                                .row-custom {
                                    display: grid;
                                    grid-template-columns: 1fr 1fr;
                                    gap: 15px;
                                    margin-bottom: 18px;
                                }
                                @media (max-width: 768px) {
                                    .row-custom {
                                        grid-template-columns: 1fr;
                                    }
                                }
                            </style>
                            <div style="max-height: 65vh; overflow-y: auto; padding: 5px 15px;">
                                <div class="row-custom">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Título del Evento<span class="required">*</span></label>
                                        <input type="text" id="titulo" class="form-input-custom" placeholder="Nombre del evento" required>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Tipo de Evento<span class="required">*</span></label>
                                        <select id="tipo_evento" class="form-select-custom" required onchange="actualizarCamposDetalle()">
                                            <option value="">Seleccione...</option>
                                            <option value="reunion-virtual">Reunión Virtual</option>
                                            <option value="reunion-presencial">Reunión Presencial</option>
                                            <option value="inicio-proyecto">Inicio de Proyecto</option>
                                            <option value="finalizar-proyecto">Finalizar Proyecto</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row-custom">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Fecha y Hora de Inicio<span class="required">*</span></label>
                                        <input type="datetime-local" id="fecha_inicio" class="form-input-custom" required>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Fecha y Hora de Fin<span class="required">*</span></label>
                                        <input type="datetime-local" id="fecha_fin" class="form-input-custom" required>
                                    </div>
                                </div>
                                
                                <div class="row-custom">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Organizador<span class="required">*</span></label>
                                        <select id="organizador_id" class="form-select-custom" required>
                                            ${miembrosOptions}
                                        </select>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Estado</label>
                                        <select id="estado" class="form-select-custom" required>
                                            <option value="programado">Programado</option>
                                            <option value="en-curso">En Curso</option>
                                            <option value="finalizado">Finalizado</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div id="detalles_container"></div>
                            </div>
                        `,
                        width: '750px',
                        heightAuto: false,
                        customClass: {
                            container: 'custom-modal-vicepresidente',
                            confirmButton: 'swal2-confirm swal2-styled',
                            cancelButton: 'swal2-cancel swal2-styled'
                        },
                        showCancelButton: true,
                        confirmButtonText: '<i class="fas fa-plus-circle"></i> Crear Evento',
                        cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
                        confirmButtonColor: '#ea580c',
                        cancelButtonColor: '#6b7280',
                        didOpen: () => {
                            // Agregar función para actualizar campos de detalle
                            window.actualizarCamposDetalle = function() {
                                const tipo = document.getElementById('tipo_evento').value;
                                const container = document.getElementById('detalles_container');
                                
                                if (tipo === 'reunion-virtual') {
                                    container.innerHTML = `
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Enlace de Reunión Virtual</label>
                                            <input type="url" id="enlace" class="form-input-custom" placeholder="https://meet.google.com/...">
                                        </div>
                                    `;
                                } else if (tipo === 'reunion-presencial') {
                                    container.innerHTML = `
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Lugar de Reunión</label>
                                            <input type="text" id="lugar" class="form-input-custom" placeholder="Sala de conferencias, dirección, etc.">
                                        </div>
                                    `;
                                } else if (tipo === 'inicio-proyecto' || tipo === 'finalizar-proyecto') {
                                    container.innerHTML = `
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Ubicación del Proyecto</label>
                                            <input type="text" id="ubicacion_proyecto" class="form-input-custom" placeholder="Ubicación del proyecto">
                                        </div>
                                    `;
                                } else {
                                    container.innerHTML = '';
                                }
                            };
                        },
                        preConfirm: () => {
                            const titulo = document.getElementById('titulo').value;
                            const tipo_evento = document.getElementById('tipo_evento').value;
                            const organizador_id = document.getElementById('organizador_id').value;
                            const estado = document.getElementById('estado').value;
                            const fecha_inicio = document.getElementById('fecha_inicio').value;
                            const fecha_fin = document.getElementById('fecha_fin').value;

                            if (!titulo || !tipo_evento || !organizador_id || !estado || !fecha_inicio || !fecha_fin) {
                                Swal.showValidationMessage('Por favor complete todos los campos requeridos (*)');
                                return false;
                            }
                            
                            // Obtener organizador nombre
                            const organizadorSelect = document.getElementById('organizador_id');
                            const organizadorNombre = organizadorSelect.options[organizadorSelect.selectedIndex].text;

                            // Construir detalles según tipo de evento
                            let detalles = {
                                organizador: organizadorNombre
                            };
                            
                            if (tipo_evento === 'reunion-virtual') {
                                const enlace = document.getElementById('enlace');
                                if (enlace) detalles.enlace = enlace.value;
                            } else if (tipo_evento === 'reunion-presencial') {
                                const lugar = document.getElementById('lugar');
                                if (lugar) detalles.lugar = lugar.value;
                            } else if (tipo_evento === 'inicio-proyecto' || tipo_evento === 'finalizar-proyecto') {
                                const ubicacion = document.getElementById('ubicacion_proyecto');
                                if (ubicacion) detalles.ubicacion_proyecto = ubicacion.value;
                            }

                            return {
                                titulo: titulo,
                                descripcion: titulo, // Usar el título como descripción
                                tipo_evento: tipo_evento,
                                organizador_id: parseInt(organizador_id),
                                estado: estado,
                                fecha_inicio: fecha_inicio,
                                fecha_fin: fecha_fin,
                                proyecto_id: null,
                                detalles: detalles
                            };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            crearEvento(result.value);
                        }
                    });
                })
                .catch(error => {
                    console.error('Error al cargar miembros:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cargar la lista de organizadores'
                    });
                });
            });

            // Función para crear evento
            function crearEvento(datos) {
                fetch('/api/vicepresidente/calendario/eventos', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(datos)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Evento Creado!',
                            text: data.mensaje,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        calendar.refetchEvents();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.mensaje || 'No se pudo crear el evento'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al crear el evento'
                    });
                });
            }

            // Función para mostrar detalle de evento
            function mostrarDetalleEvento(evento) {
                const props = evento.extendedProps;
                const detalles = props.detalles || {};
                
                Swal.fire({
                    title: evento.title,
                    html: `
                        <div class="text-left space-y-2">
                            <p><strong>Tipo:</strong> ${obtenerNombreTipoEvento(props.tipo_evento) || 'N/A'}</p>
                            <p><strong>Estado:</strong> ${obtenerNombreEstado(props.estado) || 'N/A'}</p>
                            <p><strong>Inicio:</strong> ${evento.start ? evento.start.toLocaleString('es-ES', {dateStyle: 'short', timeStyle: 'short'}) : 'N/A'}</p>
                            <p><strong>Fin:</strong> ${evento.end ? evento.end.toLocaleString('es-ES', {dateStyle: 'short', timeStyle: 'short'}) : 'N/A'}</p>
                            <p><strong>Organizador:</strong> ${detalles.organizador || 'N/A'}</p>
                            ${detalles.enlace ? `<p><strong>Enlace:</strong> <a href="${detalles.enlace}" target="_blank">${detalles.enlace}</a></p>` : ''}
                            ${detalles.lugar ? `<p><strong>Lugar:</strong> ${detalles.lugar}</p>` : ''}
                            ${detalles.ubicacion_proyecto ? `<p><strong>Ubicación:</strong> ${detalles.ubicacion_proyecto}</p>` : ''}
                        </div>
                    `,
                    showCancelButton: true,
                    showDenyButton: true,
                    confirmButtonText: '<i class="fas fa-edit"></i> Editar',
                    denyButtonText: '<i class="fas fa-trash"></i> Eliminar',
                    cancelButtonText: 'Cerrar',
                    width: '600px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        editarEvento(evento);
                    } else if (result.isDenied) {
                        eliminarEvento(evento.id);
                    }
                });
            }

            // 🆕 Función para editar evento
            function editarEvento(evento) {
                const props = evento.extendedProps;
                const detalles = props.detalles || {};
                
                // Primero cargar lista de miembros
                fetch('/api/vicepresidente/calendario/miembros', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    let miembrosOptions = '<option value="">Seleccione un organizador...</option>';
                    if (data.success && data.miembros) {
                        data.miembros.forEach(miembro => {
                            const selected = props.organizador_id == miembro.MiembroID ? 'selected' : '';
                            miembrosOptions += `<option value="${miembro.MiembroID}" ${selected}>${miembro.Nombre} - ${miembro.Rol}</option>`;
                        });
                    }
                    
                    // Formatear fechas para datetime-local
                    const fechaInicio = evento.start ? evento.start.toISOString().slice(0, 16) : '';
                    const fechaFin = evento.end ? evento.end.toISOString().slice(0, 16) : '';
                    
                    Swal.fire({
                        title: '<span style="color: #ea580c;">Editar Evento</span>',
                        html: `
                            <style>
                                .custom-modal-vicepresidente .swal2-title {
                                    background: linear-gradient(135deg, #ea580c 0%, #fb923c 100%);
                                    -webkit-background-clip: text;
                                    -webkit-text-fill-color: transparent;
                                    font-weight: 700;
                                }
                                .form-group-custom {
                                    margin-bottom: 18px;
                                    text-align: left;
                                }
                                .form-label-custom {
                                    display: block;
                                    font-size: 13px;
                                    font-weight: 600;
                                    color: #4b5563;
                                    margin-bottom: 8px;
                                    text-align: left;
                                }
                                .form-label-custom .required {
                                    color: #ef4444;
                                    margin-left: 2px;
                                }
                                .form-input-custom {
                                    width: 100%;
                                    padding: 10px 14px;
                                    border: 2px solid #e5e7eb;
                                    border-radius: 8px;
                                    font-size: 14px;
                                    transition: all 0.3s ease;
                                    background: white;
                                }
                                .form-input-custom:focus {
                                    outline: none;
                                    border-color: #ea580c;
                                    box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.1);
                                }
                                .form-select-custom {
                                    width: 100%;
                                    padding: 10px 14px;
                                    border: 2px solid #e5e7eb;
                                    border-radius: 8px;
                                    font-size: 14px;
                                    transition: all 0.3s ease;
                                    background: white;
                                    cursor: pointer;
                                }
                                .form-select-custom:focus {
                                    outline: none;
                                    border-color: #ea580c;
                                    box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.1);
                                }
                                .row-custom {
                                    display: grid;
                                    grid-template-columns: 1fr 1fr;
                                    gap: 15px;
                                    margin-bottom: 18px;
                                }
                                @media (max-width: 768px) {
                                    .row-custom {
                                        grid-template-columns: 1fr;
                                    }
                                }
                            </style>
                            <div style="max-height: 65vh; overflow-y: auto; padding: 5px 15px;">
                                <div class="row-custom">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Título del Evento<span class="required">*</span></label>
                                        <input type="text" id="edit_titulo" class="form-input-custom" value="${evento.title}" required>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Tipo de Evento<span class="required">*</span></label>
                                        <select id="edit_tipo_evento" class="form-select-custom" required onchange="actualizarCamposDetalleEditar()">
                                            <option value="">Seleccione...</option>
                                            <option value="reunion-virtual" ${props.tipo_evento === 'reunion-virtual' ? 'selected' : ''}>Reunión Virtual</option>
                                            <option value="reunion-presencial" ${props.tipo_evento === 'reunion-presencial' ? 'selected' : ''}>Reunión Presencial</option>
                                            <option value="inicio-proyecto" ${props.tipo_evento === 'inicio-proyecto' ? 'selected' : ''}>Inicio de Proyecto</option>
                                            <option value="finalizar-proyecto" ${props.tipo_evento === 'finalizar-proyecto' ? 'selected' : ''}>Finalizar Proyecto</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row-custom">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Fecha y Hora de Inicio<span class="required">*</span></label>
                                        <input type="datetime-local" id="edit_fecha_inicio" class="form-input-custom" value="${fechaInicio}" required>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Fecha y Hora de Fin<span class="required">*</span></label>
                                        <input type="datetime-local" id="edit_fecha_fin" class="form-input-custom" value="${fechaFin}" required>
                                    </div>
                                </div>
                                
                                <div class="row-custom">
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Organizador<span class="required">*</span></label>
                                        <select id="edit_organizador_id" class="form-select-custom" required>
                                            ${miembrosOptions}
                                        </select>
                                    </div>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">Estado</label>
                                        <select id="edit_estado" class="form-select-custom" required>
                                            <option value="programado" ${props.estado === 'programado' ? 'selected' : ''}>Programado</option>
                                            <option value="en-curso" ${props.estado === 'en-curso' ? 'selected' : ''}>En Curso</option>
                                            <option value="finalizado" ${props.estado === 'finalizado' ? 'selected' : ''}>Finalizado</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div id="edit_detalles_container"></div>
                            </div>
                        `,
                        width: '750px',
                        heightAuto: false,
                        customClass: {
                            container: 'custom-modal-vicepresidente',
                            confirmButton: 'swal2-confirm swal2-styled',
                            cancelButton: 'swal2-cancel swal2-styled'
                        },
                        showCancelButton: true,
                        confirmButtonText: '<i class="fas fa-save"></i> Guardar Cambios',
                        cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
                        confirmButtonColor: '#ea580c',
                        cancelButtonColor: '#6b7280',
                        didOpen: () => {
                            // Agregar función para actualizar campos de detalle en edición
                            window.actualizarCamposDetalleEditar = function() {
                                const tipo = document.getElementById('edit_tipo_evento').value;
                                const container = document.getElementById('edit_detalles_container');
                                
                                if (tipo === 'reunion-virtual') {
                                    container.innerHTML = `
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Enlace de Reunión Virtual</label>
                                            <input type="url" id="edit_enlace" class="form-input-custom" value="${detalles.enlace || ''}" placeholder="https://meet.google.com/...">
                                        </div>
                                    `;
                                } else if (tipo === 'reunion-presencial') {
                                    container.innerHTML = `
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Lugar de Reunión</label>
                                            <input type="text" id="edit_lugar" class="form-input-custom" value="${detalles.lugar || ''}" placeholder="Sala de conferencias, dirección, etc.">
                                        </div>
                                    `;
                                } else if (tipo === 'inicio-proyecto' || tipo === 'finalizar-proyecto') {
                                    container.innerHTML = `
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Ubicación del Proyecto</label>
                                            <input type="text" id="edit_ubicacion_proyecto" class="form-input-custom" value="${detalles.ubicacion_proyecto || ''}" placeholder="Ubicación del proyecto">
                                        </div>
                                    `;
                                } else {
                                    container.innerHTML = '';
                                }
                            };
                            
                            // Llamar inmediatamente para mostrar campos actuales
                            actualizarCamposDetalleEditar();
                        },
                        preConfirm: () => {
                            const titulo = document.getElementById('edit_titulo').value;
                            const tipo_evento = document.getElementById('edit_tipo_evento').value;
                            const organizador_id = document.getElementById('edit_organizador_id').value;
                            const estado = document.getElementById('edit_estado').value;
                            const fecha_inicio = document.getElementById('edit_fecha_inicio').value;
                            const fecha_fin = document.getElementById('edit_fecha_fin').value;

                            if (!titulo || !tipo_evento || !organizador_id || !estado || !fecha_inicio || !fecha_fin) {
                                Swal.showValidationMessage('Por favor complete todos los campos requeridos (*)');
                                return false;
                            }
                            
                            // Obtener organizador nombre
                            const organizadorSelect = document.getElementById('edit_organizador_id');
                            const organizadorNombre = organizadorSelect.options[organizadorSelect.selectedIndex].text;

                            // Construir detalles según tipo de evento
                            let detallesNuevos = {
                                organizador: organizadorNombre
                            };
                            
                            if (tipo_evento === 'reunion-virtual') {
                                const enlace = document.getElementById('edit_enlace');
                                if (enlace) detallesNuevos.enlace = enlace.value;
                            } else if (tipo_evento === 'reunion-presencial') {
                                const lugar = document.getElementById('edit_lugar');
                                if (lugar) detallesNuevos.lugar = lugar.value;
                            } else if (tipo_evento === 'inicio-proyecto' || tipo_evento === 'finalizar-proyecto') {
                                const ubicacion = document.getElementById('edit_ubicacion_proyecto');
                                if (ubicacion) detallesNuevos.ubicacion_proyecto = ubicacion.value;
                            }

                            return {
                                titulo: titulo,
                                descripcion: titulo, // Usar el título como descripción
                                tipo_evento: tipo_evento,
                                organizador_id: parseInt(organizador_id),
                                estado: estado,
                                fecha_inicio: fecha_inicio,
                                fecha_fin: fecha_fin,
                                proyecto_id: props.proyecto_id || null,
                                detalles: detallesNuevos
                            };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            actualizarEvento(evento.id, result.value);
                        }
                    });
                })
                .catch(error => {
                    console.error('Error al cargar miembros:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cargar la lista de organizadores'
                    });
                });
            }

            // 🆕 Función para actualizar evento
            function actualizarEvento(eventoId, datos) {
                fetch(`/api/vicepresidente/calendario/eventos/${eventoId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(datos)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Actualizado!',
                            text: data.mensaje,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        calendar.refetchEvents();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.mensaje || 'No se pudo actualizar el evento'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al actualizar el evento'
                    });
                });
            }

            // 🆕 Funciones auxiliares para mostrar nombres legibles
            function obtenerNombreTipoEvento(tipo) {
                const nombres = {
                    'reunion-virtual': 'Reunión Virtual',
                    'reunion-presencial': 'Reunión Presencial',
                    'inicio-proyecto': 'Inicio de Proyecto',
                    'finalizar-proyecto': 'Finalización de Proyecto'
                };
                return nombres[tipo] || tipo;
            }

            function obtenerNombreEstado(estado) {
                const nombres = {
                    'programado': 'Programado',
                    'en-curso': 'En Curso',
                    'finalizado': 'Finalizado'
                };
                return nombres[estado] || estado;
            }

            // Función para eliminar evento
            function eliminarEvento(eventoId) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción no se puede deshacer',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/api/vicepresidente/calendario/eventos/${eventoId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Eliminado!',
                                    text: data.mensaje,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                calendar.refetchEvents();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.mensaje || 'No se pudo eliminar el evento'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Ocurrió un error al eliminar el evento'
                            });
                        });
                    }
                });
            }

            // Función para actualizar fechas del evento (drag & drop)
            function actualizarFechasEvento(evento) {
                fetch(`/api/vicepresidente/calendario/eventos/${evento.id}/fechas`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        fecha_inicio: evento.start.toISOString(),
                        fecha_fin: evento.end ? evento.end.toISOString() : evento.start.toISOString()
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Actualizado',
                            text: data.mensaje,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.mensaje || 'No se pudo actualizar el evento'
                        });
                        calendar.refetchEvents();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    calendar.refetchEvents();
                });
            }
        });
    </script>
@endsection
