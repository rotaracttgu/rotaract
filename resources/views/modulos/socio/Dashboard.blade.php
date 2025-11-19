@extends('modulos.socio.layout')

@section('page-title', 'Dashboard')

@section('content')
    <!-- Header con gradiente mejorado -->
    <div class="mb-6 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 rounded-xl p-6 shadow-lg text-white">
        <h1 class="text-2xl font-bold">
            @php $welcomeName = Auth::user()->username ?? Auth::user()->name; @endphp
            Bienvenido, <span class="text-yellow-300">{{ $welcomeName }}</span>
        </h1>
        <p class="text-blue-100 mt-2">Panel de control del Aspirante - Aquí encontrarás toda tu información importante</p>
    </div>

    <!-- Tarjetas de Estadísticas con diseño mejorado -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Proyectos Activos -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">PROYECTOS ACTIVOS</p>
                    <div class="flex items-baseline">
                        <h3 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">{{ count($proyectosActivos ?? []) }}</h3>
                    </div>
                    <p class="text-xs text-blue-600 mt-2">En los que participas</p>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Próximas Reuniones -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">PRÓXIMAS REUNIONES</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent">{{ count($proximasReuniones ?? []) }}</h3>
                    <p class="text-xs text-green-600 mt-2">Programadas</p>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Consultas Pendientes -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">CONSULTAS PENDIENTES</p>
                    <div class="flex items-baseline">
                        <h3 class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-orange-800 bg-clip-text text-transparent">{{ ($consultasSecretariaPendientes ?? 0) + ($consultasVoceriaPendientes ?? 0) }}</h3>
                    </div>
                    <p class="text-xs text-orange-600 mt-2">Secretaría</p>
                </div>
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Mis Notas -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">MIS NOTAS</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent">{{ $notasActivas ?? 0 }}</h3>
                    <p class="text-xs text-purple-600 mt-2">Notas activas</p>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal en 2 Columnas -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Columna Izquierda (2/3) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Próximas Reuniones -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center">
                        <div class="bg-gradient-to-br from-green-500 to-green-600 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        Próximas Reuniones
                    </h2>
                    <a href="{{ route('socio.reuniones') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center">
                        Ver todas
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                @if(isset($proximasReuniones) && count($proximasReuniones) > 0)
                    <div class="space-y-4">
                        @foreach($proximasReuniones as $reunion)
                            @if($reunion->FechaHora ?? false)
                                <div class="flex items-start p-4 bg-gradient-to-r from-blue-50 to-transparent rounded-lg border border-blue-100 hover:border-blue-300 transition-all">
                                    <div class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl px-4 py-3 text-center mr-4 shadow-md">
                                        <div class="text-xs font-bold uppercase">
                                            {{ \Carbon\Carbon::parse($reunion->FechaHora)->format('M') }}
                                        </div>
                                        <div class="text-3xl font-bold">
                                            {{ \Carbon\Carbon::parse($reunion->FechaHora)->format('d') }}
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900 text-lg">{{ $reunion->titulo ?? 'Sin título' }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">{{ $reunion->descripcion ?? 'Sin descripción' }}</p>
                                        <div class="flex flex-wrap items-center gap-4 mt-3 text-xs text-gray-500">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($reunion->FechaHora)->format('h:i A') }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                </svg>
                                                {{ $reunion->lugar ?? 'Sin lugar' }}
                                            </span>
                                            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full font-medium">
                                                {{ $reunion->tipo ?? 'General' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-gray-500 font-medium">No hay reuniones programadas próximamente</p>
                        <p class="text-sm text-gray-400 mt-1">Las reuniones aparecerán aquí cuando sean agendadas</p>
                    </div>
                @endif
            </div>

            <!-- Mis Proyectos Activos -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center">
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        Proyectos en los que Participo
                    </h2>
                    <a href="{{ route('socio.proyectos') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center">
                        Ver todos
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                @if(isset($proyectosActivos) && count($proyectosActivos) > 0)
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($proyectosActivos as $proyecto)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 hover:shadow-md transition-all">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900">
                                            {{ $proyecto->NombreProyecto ?? 'Sin nombre' }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">
                                            {{ $proyecto->DescripcionProyecto ?? 'Sin descripción' }}
                                        </p>
                                        <div class="flex items-center gap-3 mt-3 text-xs">
                                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full font-medium">
                                                {{ $proyecto->TipoProyecto ?? 'General' }}
                                            </span>
                                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full font-medium">
                                                {{ $proyecto->EstadoProyecto ?? 'Activo' }}
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('socio.proyectos.detalle', $proyecto->ID ?? '#') }}" 
                                       class="ml-4 text-blue-600 hover:text-blue-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        <p class="text-gray-500 font-medium">No estás participando en ningún proyecto</p>
                        <p class="text-sm text-gray-400 mt-1">Los proyectos asignados aparecerán aquí</p>
                    </div>
                @endif
            </div>

        </div>

        <!-- Columna Derecha (1/3) - Acciones Rápidas y Resumen -->
        <div class="space-y-6">
            
            <!-- Acciones Rápidas -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    Acciones Rápidas
                </h2>

                <div class="space-y-3">
                    <a href="{{ route('socio.calendario') }}" 
                       class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-300 shadow-sm hover:shadow-md group">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <span class="font-bold block">Ver Calendario</span>
                            <span class="text-xs text-blue-600">Eventos programados</span>
                        </div>
                    </a>

                    <a href="{{ route('socio.secretaria.crear') }}" 
                       class="flex items-center p-4 bg-gradient-to-r from-green-50 to-green-100 text-green-700 rounded-xl hover:from-green-100 hover:to-green-200 transition-all duration-300 shadow-sm hover:shadow-md group">
                        <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-xl mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <span class="font-bold block">Contactar Secretaría</span>
                            <span class="text-xs text-green-600">Nueva consulta</span>
                        </div>
                    </a>

                    <a href="{{ route('socio.notas.crear') }}" 
                       class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 rounded-xl hover:from-purple-100 hover:to-purple-200 transition-all duration-300 shadow-sm hover:shadow-md group">
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-3 rounded-xl mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <span class="font-bold block">Nueva Nota</span>
                            <span class="text-xs text-purple-600">Crear nota personal</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Estado de Consultas -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg text-white p-6">
                <h3 class="text-lg font-bold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Resumen de Comunicación
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-white bg-opacity-20 rounded-lg backdrop-blur">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="font-medium">Secretaría</span>
                        </div>
                        <span class="text-2xl font-bold">{{ $consultasSecretariaPendientes ?? 0 }}</span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-white border-opacity-30">
                    <p class="text-sm text-blue-100">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Consultas pendientes de respuesta
                    </p>
                </div>
            </div>

            <!-- Recordatorio -->
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 border-l-4 border-orange-500 rounded-lg p-6">
                <h3 class="font-bold text-orange-900 flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                    Recordatorio
                </h3>
                <p class="text-sm text-orange-800">
                    Mantente al día con tus proyectos y reuniones. Revisa regularmente tu calendario y consulta con el equipo directivo si tienes dudas.
                </p>
            </div>

        </div>
    </div>
@endsection