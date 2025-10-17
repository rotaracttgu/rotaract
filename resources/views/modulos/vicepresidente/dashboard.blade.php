@extends('modulos.vicepresidente.layout')

@section('content')
    <!-- Header -->
    <div class="mb-6 bg-blue-50 rounded-lg p-4 border border-blue-200">
        <h1 class="text-xl font-semibold text-gray-800">
            Resumen general de actividades y <span class="text-orange-500">proyectos</span>
        </h1>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Proyectos -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2">TOTAL PROYECTOS</p>
                    <div class="flex items-baseline">
                        <h3 class="text-4xl font-bold text-gray-900">{{ $totalProyectos ?? 6 }}</h3>
                        <span class="ml-2 text-sm text-green-600 font-medium">+2</span>
                    </div>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Proyectos Activos -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2">PROYECTOS ACTIVOS</p>
                    <h3 class="text-4xl font-bold text-gray-900">{{ $proyectosActivos ?? 0 }}</h3>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Cartas Pendientes -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2">CARTAS PENDIENTES</p>
                    <div class="flex items-baseline">
                        <h3 class="text-4xl font-bold text-gray-900">{{ $cartasPendientes ?? 1 }}</h3>
                        <span class="ml-2 text-sm text-red-600 font-medium">-3</span>
                    </div>
                </div>
                <div class="bg-orange-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Reuniones Hoy -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2">REUNIONES HOY</p>
                    <h3 class="text-4xl font-bold text-gray-900">{{ $reunionesHoy ?? 0 }}</h3>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                        </svg>
                        Actividad Mensual
                    </h2>
                    <div class="flex space-x-4 text-sm">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                            <span class="text-gray-600">Proyectos</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-orange-400 mr-2"></div>
                            <span class="text-gray-600">Reuniones</span>
                        </div>
                    </div>
                </div>
                <canvas id="actividadChart" class="w-full" height="80"></canvas>
            </div>

            <!-- Próximas Reuniones -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Próximas Reuniones
                    </h2>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Ver todas →</a>
                </div>

                @if(isset($proximasReuniones) && $proximasReuniones->count() > 0)
                    @foreach($proximasReuniones as $reunion)
                        <div class="flex items-start p-4 mb-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex-shrink-0 bg-blue-500 text-white rounded-lg px-3 py-2 text-center mr-4">
                                <div class="text-xs font-bold uppercase">{{ \Carbon\Carbon::parse($reunion->fecha_hora)->format('M') }}</div>
                                <div class="text-2xl font-bold">{{ \Carbon\Carbon::parse($reunion->fecha_hora)->format('d') }}</div>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $reunion->titulo }}</h3>
                                <p class="text-sm text-gray-600">{{ $reunion->descripcion ?? 'Revisión de proyectos del mes y planificación de actividades' }}</p>
                                <div class="flex items-center mt-2 text-xs text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($reunion->fecha_hora)->format('H:i A') }}
                                    <svg class="w-4 h-4 ml-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    </svg>
                                    {{ $reunion->lugar }}
                                </div>
                                <span class="mt-2 inline-block text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full font-medium">{{ $reunion->estado }}</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="font-medium">No hay reuniones programadas</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Columna Derecha (1/3) - Acciones Rápidas -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Acciones Rápidas
                </h2>

                <div class="space-y-3">
                    <a href="#" class="flex items-center p-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors">
                        <div class="bg-blue-500 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Nuevo Proyecto</span>
                    </a>

                    <a href="{{ route('vicepresidente.cartas.patrocinio') }}" class="flex items-center p-3 bg-orange-50 text-orange-700 rounded-lg hover:bg-orange-100 transition-colors">
                        <div class="bg-orange-500 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Enviar Carta</span>
                    </a>

                    <a href="#" class="flex items-center p-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition-colors">
                        <div class="bg-purple-500 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Agendar Reunión</span>
                    </a>

                    <a href="#" class="flex items-center p-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="bg-green-500 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Gestionar Equipo</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Gráfica de Actividad Mensual
        const ctx = document.getElementById('actividadChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                datasets: [{
                    label: 'Proyectos',
                    data: [2, 4, 3, 5, 7, 4],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Reuniones',
                    data: [3, 2, 4, 3, 6, 5],
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
@endsection
