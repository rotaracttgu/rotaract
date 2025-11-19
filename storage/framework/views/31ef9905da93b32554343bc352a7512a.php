

<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <!-- Header con gradiente mejorado -->
    <div class="mb-4 bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 rounded-xl p-4 shadow-lg text-white">
        <h1 class="text-xl font-bold flex items-center">
            <i class="fas fa-crown mr-2 text-yellow-300"></i>
            Módulo Presidente - <span class="text-yellow-200">Panel Admin</span>
        </h1>
        <p class="text-purple-100 mt-1 text-sm">Gestiona proyectos, cartas y calendario desde el panel de administración</p>
    </div>

    <!-- Tarjetas de Estadísticas con diseño mejorado -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
        <!-- Total Proyectos -->
        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-500 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1 font-semibold">TOTAL PROYECTOS</p>
                    <h3 class="text-2xl font-bold text-blue-600"><?php echo e($totalProyectos ?? 0); ?></h3>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-2 rounded-lg shadow-sm">
                    <i class="fas fa-folder text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Proyectos Activos -->
        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-green-500 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1 font-semibold">PROYECTOS ACTIVOS</p>
                    <h3 class="text-2xl font-bold text-green-600"><?php echo e($proyectosActivos ?? 0); ?></h3>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 p-2 rounded-lg shadow-sm">
                    <i class="fas fa-bolt text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Cartas Pendientes -->
        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-orange-500 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1 font-semibold">CARTAS PENDIENTES</p>
                    <h3 class="text-2xl font-bold text-orange-600"><?php echo e($cartasPendientes ?? 0); ?></h3>
                </div>
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-2 rounded-lg shadow-sm">
                    <i class="fas fa-envelope text-white text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Reuniones Hoy -->
        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-purple-500 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1 font-semibold">REUNIONES HOY</p>
                    <h3 class="text-2xl font-bold text-purple-600"><?php echo e($reunionesHoy ?? 0); ?></h3>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-2 rounded-lg shadow-sm">
                    <i class="fas fa-calendar text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal en 2 Columnas -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Columna Izquierda (2/3) -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Gráfica de Actividad Mensual -->
            <div class="bg-white rounded-lg shadow-md p-4 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-bold text-gray-800 flex items-center">
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-1.5 rounded-lg mr-2">
                            <i class="fas fa-chart-line text-white text-sm"></i>
                        </div>
                        Actividad Mensual
                    </h2>
                    <div class="flex space-x-3 text-xs">
                        <div class="flex items-center">
                            <div class="w-2 h-2 rounded-full bg-blue-500 mr-1"></div>
                            <span class="text-gray-600">Proyectos</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-2 h-2 rounded-full bg-orange-400 mr-1"></div>
                            <span class="text-gray-600">Reuniones</span>
                        </div>
                    </div>
                </div>
                <canvas id="actividadChart" class="w-full" height="60"></canvas>
            </div>

            <!-- Calendario de Eventos -->
            <div class="bg-white rounded-lg shadow-md p-4 border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-base font-bold text-gray-800 flex items-center">
                        <div class="bg-gradient-to-br from-purple-500 to-pink-600 p-1.5 rounded-lg mr-2">
                            <i class="fas fa-calendar text-white text-sm"></i>
                        </div>
                        Calendario de Eventos
                    </h2>
                    <button id="btnNuevoEvento" class="px-3 py-1.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 text-xs font-semibold shadow-sm">
                        + Nuevo Evento
                    </button>
                </div>
                <div id="calendar"></div>
            </div>
        </div>

        <!-- Columna Derecha (1/3) - Acciones Rápidas -->
        <div class="space-y-4">
            <div class="bg-white rounded-lg shadow-md p-4 border border-gray-100">
                <h2 class="text-base font-bold text-gray-800 mb-3 flex items-center">
                    <div class="bg-gradient-to-br from-green-500 to-green-600 p-1.5 rounded-lg mr-2">
                        <i class="fas fa-bolt text-white text-sm"></i>
                    </div>
                    Acciones Rápidas
                </h2>

                <div class="space-y-2">
                    <a href="<?php echo e(route('admin.presidente.estado.proyectos')); ?>" class="flex items-center p-3 bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 rounded-lg hover:from-blue-100 hover:to-blue-200 transition-all duration-200 shadow-sm group">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-2 rounded-lg mr-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-project-diagram text-white text-sm"></i>
                        </div>
                        <span class="font-semibold text-sm">Gestionar Proyectos</span>
                    </a>

                    <a href="<?php echo e(route('admin.presidente.cartas.patrocinio')); ?>" class="flex items-center p-3 bg-gradient-to-r from-orange-50 to-orange-100 text-orange-700 rounded-lg hover:from-orange-100 hover:to-orange-200 transition-all duration-200 shadow-sm group">
                        <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-2 rounded-lg mr-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-envelope text-white text-sm"></i>
                        </div>
                        <span class="font-semibold text-sm">Cartas Patrocinio</span>
                    </a>

                    <a href="<?php echo e(route('admin.presidente.cartas.formales')); ?>" class="flex items-center p-3 bg-gradient-to-r from-green-50 to-green-100 text-green-700 rounded-lg hover:from-green-100 hover:to-green-200 transition-all duration-200 shadow-sm group">
                        <div class="bg-gradient-to-br from-green-500 to-green-600 p-2 rounded-lg mr-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-file-alt text-white text-sm"></i>
                        </div>
                        <span class="font-semibold text-sm">Cartas Formales</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.js"></script>
    
    <script>
        // Gráfica de Actividad Mensual con datos reales
        const ctx = document.getElementById('actividadChart').getContext('2d');
        
        const mesesData = <?php echo json_encode($datosActividad['meses'] ?? ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun']); ?>;
        const proyectosData = <?php echo json_encode($datosActividad['proyectos'] ?? [2, 4, 3, 5, 7, 4]); ?>;
        const reunionesData = <?php echo json_encode($datosActividad['reuniones'] ?? [3, 2, 4, 3, 6, 5]); ?>;
        
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
                    tension: 0.4,
                    borderWidth: 2
                }, {
                    label: 'Reuniones',
                    data: reunionesData,
                    borderColor: 'rgb(251, 146, 60)',
                    backgroundColor: 'rgba(251, 146, 60, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 10,
                        titleFont: { size: 12 },
                        bodyFont: { size: 11 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            font: { size: 10 }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: { size: 10 }
                        }
                    }
                }
            }
        });

        // Inicializar FullCalendar
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
                    url: '/admin/api/presidente/calendario/eventos',
                    method: 'GET',
                    extraParams: function() {
                        return {};
                    },
                    failure: function(error) {
                        console.error('Error al cargar eventos:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudieron cargar los eventos'
                        });
                    }
                },
                eventClick: function(info) {
                    Swal.fire({
                        title: info.event.title,
                        html: `
                            <p><strong>Descripción:</strong> ${info.event.extendedProps.descripcion || 'N/A'}</p>
                            <p><strong>Tipo:</strong> ${info.event.extendedProps.tipo_evento || 'N/A'}</p>
                            <p><strong>Estado:</strong> ${info.event.extendedProps.estado || 'N/A'}</p>
                            <p><strong>Ubicación:</strong> ${info.event.extendedProps.ubicacion || 'N/A'}</p>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Editar',
                        cancelButtonText: 'Cerrar'
                    });
                }
            });

            calendar.render();

            // Botón para nuevo evento
            document.getElementById('btnNuevoEvento').addEventListener('click', function() {
                Swal.fire({
                    title: 'Nuevo Evento',
                    html: `
                        <input id="titulo" class="swal2-input" placeholder="Título del evento">
                        <textarea id="descripcion" class="swal2-textarea" placeholder="Descripción"></textarea>
                        <select id="tipo" class="swal2-select">
                            <option value="reunion-virtual">Reunión Virtual</option>
                            <option value="reunion-presencial">Reunión Presencial</option>
                            <option value="inicio-proyecto">Inicio Proyecto</option>
                            <option value="finalizar-proyecto">Finalizar Proyecto</option>
                        </select>
                        <input id="fecha_inicio" type="datetime-local" class="swal2-input">
                        <input id="fecha_fin" type="datetime-local" class="swal2-input">
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Crear',
                    cancelButtonText: 'Cancelar',
                    preConfirm: () => {
                        return {
                            titulo: document.getElementById('titulo').value,
                            descripcion: document.getElementById('descripcion').value,
                            tipo_evento: document.getElementById('tipo').value,
                            fecha_inicio: document.getElementById('fecha_inicio').value,
                            fecha_fin: document.getElementById('fecha_fin').value,
                            estado: 'programado'
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('/admin/api/presidente/calendario/eventos', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(result.value)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Éxito', 'Evento creado correctamente', 'success');
                                calendar.refetchEvents();
                            } else {
                                Swal.fire('Error', data.mensaje || 'Error al crear evento', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Carlo\Desktop\Club Rotaract-Web Service\Rotaract_Diseño_Web\Rotaract\rotaract\resources\views/modulos/admin/presidente/dashboard.blade.php ENDPATH**/ ?>