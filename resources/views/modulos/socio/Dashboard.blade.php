@extends('modulos.socio.layout')

@section('page-title', 'Dashboard')

@section('content')
    <!-- Header -->
    <div class="mb-6 bg-gradient-to-r from-blue-50 to-orange-50 rounded-lg p-6 border border-blue-200">
        <h1 class="text-2xl font-bold text-gray-800">
            @php $welcomeName = Auth::user()->username ?? Auth::user()->name; @endphp
            Bienvenido, <span class="text-blue-600">{{ $welcomeName }}</span>
        </h1>
        <p class="text-gray-600 mt-2">Panel de control del Aspirante - Aquí encontrarás toda tu información importante</p>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Proyectos Activos -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">Proyectos Activos</p>
                    <h3 class="text-4xl font-bold text-gray-900">{{ count($proyectosActivos ?? []) }}</h3>
                    <p class="text-xs text-blue-600 mt-2">En los que participas</p>
                </div>
                <div class="bg-blue-100 p-4 rounded-xl">
                    <i class="fas fa-project-diagram text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Próximas Reuniones -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">Próximas Reuniones</p>
                    <h3 class="text-4xl font-bold text-gray-900">{{ count($proximasReuniones ?? []) }}</h3>
                    <p class="text-xs text-green-600 mt-2">Programadas</p>
                </div>
                <div class="bg-green-100 p-4 rounded-xl">
                    <i class="fas fa-calendar-check text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Consultas Pendientes -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">Consultas Pendientes</p>
                    <h3 class="text-4xl font-bold text-gray-900">{{ ($consultasSecretariaPendientes ?? 0) + ($consultasVoceriaPendientes ?? 0) }}</h3>
                    <p class="text-xs text-orange-600 mt-2">Secretaría</p>
                </div>
                <div class="bg-orange-100 p-4 rounded-xl">
                    <i class="fas fa-comment-dots text-orange-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Mis Notas -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">Mis Notas</p>
                    <h3 class="text-4xl font-bold text-gray-900">{{ $notasActivas ?? 0 }}</h3>
                    <p class="text-xs text-purple-600 mt-2">Notas activas</p>
                </div>
                <div class="bg-purple-100 p-4 rounded-xl">
                    <i class="fas fa-sticky-note text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal en 2 Columnas -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Columna Izquierda (2/3) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Próximas Reuniones -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-calendar-alt text-blue-500 mr-3"></i>
                            Próximas Reuniones
                        </h2>
                        <a href="{{ route('socio.reuniones') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center">
                            Ver todas
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    @if(isset($proximasReuniones) && count($proximasReuniones) > 0)
                        <div class="space-y-4">
                            @foreach($proximasReuniones as $reunion)
                                @if($reunion->FechaHora ?? false)
                                    <div class="flex items-start p-4 bg-gradient-to-r from-blue-50 to-transparent rounded-lg border border-blue-100 hover:border-blue-300 transition-colors">
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
                                                    <i class="fas fa-clock mr-1 text-blue-500"></i>
                                                    {{ \Carbon\Carbon::parse($reunion->FechaHora)->format('h:i A') }}
                                                </span>
                                                <span class="flex items-center">
                                                    <i class="fas fa-map-marker-alt mr-1 text-red-500"></i>
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
                            <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 font-medium">No hay reuniones programadas próximamente</p>
                            <p class="text-sm text-gray-400 mt-1">Las reuniones aparecerán aquí cuando sean agendadas</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Mis Proyectos Activos -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-project-diagram text-blue-500 mr-3"></i>
                            Proyectos en los que Participo
                        </h2>
                        <a href="{{ route('socio.proyectos') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center">
                            Ver todos
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <div class="p-6">
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
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 font-medium">No estás participando en ningún proyecto</p>
                            <p class="text-sm text-gray-400 mt-1">Los proyectos asignados aparecerán aquí</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Columna Derecha (1/3) - Acciones Rápidas y Resumen -->
        <div class="space-y-6">
            
            <!-- Acciones Rápidas -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center">
                        <i class="fas fa-bolt text-orange-500 mr-3"></i>
                        Acciones Rápidas
                    </h2>
                </div>

                <div class="p-6 space-y-3">
                    <a href="{{ route('socio.calendario') }}" 
                       class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 rounded-lg hover:from-blue-100 hover:to-blue-200 transition-all group">
                        <div class="bg-blue-500 p-3 rounded-lg mr-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-calendar-alt text-white text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <span class="font-semibold block">Ver Calendario</span>
                            <span class="text-xs text-blue-600">Eventos programados</span>
                        </div>
                        <i class="fas fa-chevron-right text-blue-400"></i>
                    </a>

                    <a href="{{ route('socio.secretaria.crear') }}" 
                       class="flex items-center p-4 bg-gradient-to-r from-green-50 to-green-100 text-green-700 rounded-lg hover:from-green-100 hover:to-green-200 transition-all group">
                        <div class="bg-green-500 p-3 rounded-lg mr-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-envelope text-white text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <span class="font-semibold block">Contactar Secretaría</span>
                            <span class="text-xs text-green-600">Nueva consulta</span>
                        </div>
                        <i class="fas fa-chevron-right text-green-400"></i>
                    </a>

                    <a href="{{ route('socio.notas.crear') }}" 
                       class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 rounded-lg hover:from-purple-100 hover:to-purple-200 transition-all group">
                        <div class="bg-purple-500 p-3 rounded-lg mr-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-plus-circle text-white text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <span class="font-semibold block">Nueva Nota</span>
                            <span class="text-xs text-purple-600">Crear nota personal</span>
                        </div>
                        <i class="fas fa-chevron-right text-purple-400"></i>
                    </a>
                </div>
            </div>

            <!-- Estado de Consultas -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg text-white p-6">
                <h3 class="text-lg font-bold mb-4 flex items-center">
                    <i class="fas fa-chart-line mr-2"></i>
                    Resumen de Comunicación
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-white bg-opacity-20 rounded-lg backdrop-blur">
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-2xl mr-3"></i>
                            <span class="font-medium">Secretaría</span>
                        </div>
                        <span class="text-2xl font-bold">{{ $consultasSecretariaPendientes ?? 0 }}</span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-white border-opacity-30">
                    <p class="text-sm text-blue-100">
                        <i class="fas fa-info-circle mr-1"></i>
                        Consultas pendientes de respuesta
                    </p>
                </div>
            </div>

            <!-- Recordatorio -->
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 border-l-4 border-orange-500 rounded-lg p-6">
                <h3 class="font-bold text-orange-900 flex items-center mb-2">
                    <i class="fas fa-lightbulb mr-2"></i>
                    Recordatorio
                </h3>
                <p class="text-sm text-orange-800">
                    Mantente al día con tus proyectos y reuniones. Revisa regularmente tu calendario y consulta con el equipo directivo si tienes dudas.
                </p>
            </div>

        </div>
    </div>
@endsection
