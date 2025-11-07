@extends('modulos.socio.layout')

@section('page-title', 'Comunicación con Vocalía')

@section('content')
    <!-- Header -->
    <div class="mb-6 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg p-6 border border-orange-200">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-bullhorn text-orange-600 mr-3"></i>
                    Comunicación con Vocalía
                </h1>
                <p class="text-gray-600 mt-2">Solicita apoyo, recursos o permisos para tus actividades</p>
            </div>
            <a href="{{ route('socio.voceria.crear') }}" 
               class="px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors shadow-md hover:shadow-lg">
                <i class="fas fa-plus mr-2"></i>
                Nueva Solicitud
            </a>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Total</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ count($consultas ?? []) }}</h3>
                </div>
                <i class="fas fa-clipboard-list text-blue-600 text-3xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Pendientes</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                        {{ collect($consultas ?? [])->where('Estado', 'Pendiente')->count() }}
                    </h3>
                </div>
                <i class="fas fa-clock text-orange-600 text-3xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">En Revisión</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                        {{ collect($consultas ?? [])->where('Estado', 'EnRevision')->count() }}
                    </h3>
                </div>
                <i class="fas fa-search text-blue-600 text-3xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Aprobadas</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                        {{ collect($consultas ?? [])->where('Estado', 'Aprobada')->count() }}
                    </h3>
                </div>
                <i class="fas fa-check-circle text-green-600 text-3xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Rechazadas</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                        {{ collect($consultas ?? [])->where('Estado', 'Rechazada')->count() }}
                    </h3>
                </div>
                <i class="fas fa-times-circle text-red-600 text-3xl"></i>
            </div>
        </div>
    </div>

    <!-- Lista de Solicitudes -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 flex items-center">
                <i class="fas fa-list text-orange-500 mr-3"></i>
                Mis Solicitudes
            </h2>
        </div>

        <div class="p-6">
            @if(isset($consultas) && count($consultas) > 0)
                <div class="space-y-4">
                    @foreach($consultas as $consulta)
                        <div class="border border-gray-200 rounded-lg hover:shadow-lg transition-all duration-300 overflow-hidden">
                            <div class="p-6">
                                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between">
                                    <!-- Contenido Principal -->
                                    <div class="flex-1">
                                        <!-- Encabezado con Tipo y Estado -->
                                        <div class="flex items-start justify-between mb-3">
                                            <div>
                                                <h3 class="text-xl font-bold text-gray-900 mb-1">
                                                    {{ $consulta->Asunto ?? 'Sin asunto' }}
                                                </h3>
                                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-700">
                                                    <i class="fas fa-tag mr-1"></i>
                                                    {{ isset($consulta->TipoSolicitud) && $consulta->TipoSolicitud 
                                                        ? str_replace('_', ' ', $consulta->TipoSolicitud) 
                                                        : 'Sin tipo' }}
                                                </span>
                                            </div>
                                            <span class="ml-4 px-4 py-1 text-sm font-semibold rounded-full whitespace-nowrap
                                                {{ ($consulta->Estado ?? '') === 'Pendiente' ? 'bg-orange-100 text-orange-700' : '' }}
                                                {{ ($consulta->Estado ?? '') === 'EnRevision' ? 'bg-blue-100 text-blue-700' : '' }}
                                                {{ ($consulta->Estado ?? '') === 'Aprobada' ? 'bg-green-100 text-green-700' : '' }}
                                                {{ ($consulta->Estado ?? '') === 'Rechazada' ? 'bg-red-100 text-red-700' : '' }}
                                                {{ ($consulta->Estado ?? '') === 'Cerrada' ? 'bg-gray-100 text-gray-700' : '' }}">
                                                @if(($consulta->Estado ?? '') === 'EnRevision')
                                                    <i class="fas fa-search mr-1"></i>En Revisión
                                                @elseif(($consulta->Estado ?? '') === 'Aprobada')
                                                    <i class="fas fa-check mr-1"></i>Aprobada
                                                @elseif(($consulta->Estado ?? '') === 'Rechazada')
                                                    <i class="fas fa-times mr-1"></i>Rechazada
                                                @else
                                                    {{ $consulta->Estado ?? 'Sin estado' }}
                                                @endif
                                            </span>
                                        </div>

                                        <!-- Descripción -->
                                        <p class="text-gray-700 mb-4 line-clamp-2">
                                            {{ $consulta->Descripcion ?? 'Sin descripción' }}
                                        </p>

                                        <!-- Metadata -->
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                                            <!-- Fecha -->
                                            <div class="flex items-center text-gray-600">
                                                <i class="fas fa-calendar text-blue-500 mr-2"></i>
                                                <span>
                                                    {{ isset($consulta->FechaCreacion) && $consulta->FechaCreacion 
                                                        ? \Carbon\Carbon::parse($consulta->FechaCreacion)->format('d/m/Y H:i') 
                                                        : 'Sin fecha' }}
                                                </span>
                                            </div>

                                            <!-- Prioridad -->
                                            <div class="flex items-center">
                                                <i class="fas fa-flag mr-2
                                                    {{ ($consulta->Prioridad ?? '') === 'Urgente' ? 'text-red-600' : '' }}
                                                    {{ ($consulta->Prioridad ?? '') === 'Alta' ? 'text-red-500' : '' }}
                                                    {{ ($consulta->Prioridad ?? '') === 'Media' ? 'text-orange-500' : '' }}
                                                    {{ ($consulta->Prioridad ?? '') === 'Baja' ? 'text-gray-500' : '' }}"></i>
                                                <span class="text-gray-600">{{ $consulta->Prioridad ?? 'Normal' }}</span>
                                            </div>

                                            <!-- Mensajes -->
                                            @if(isset($consulta->NumeroMensajes) && $consulta->NumeroMensajes > 0)
                                                <div class="flex items-center text-gray-600">
                                                    <i class="fas fa-comments text-purple-500 mr-2"></i>
                                                    <span>{{ $consulta->NumeroMensajes }} mensaje(s)</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Respuesta (si está aprobada o rechazada) -->
                                        @if(in_array($consulta->Estado ?? '', ['Aprobada', 'Rechazada']) && $consulta->Respuesta)
                                            <div class="mt-4 p-4 border-l-4 rounded
                                                {{ ($consulta->Estado ?? '') === 'Aprobada' ? 'bg-green-50 border-green-500' : 'bg-red-50 border-red-500' }}">
                                                <div class="flex items-start">
                                                    <i class="fas {{ ($consulta->Estado ?? '') === 'Aprobada' ? 'fa-check-circle text-green-600' : 'fa-times-circle text-red-600' }} mt-1 mr-3"></i>
                                                    <div class="flex-1">
                                                        <p class="text-sm font-semibold mb-1
                                                            {{ ($consulta->Estado ?? '') === 'Aprobada' ? 'text-green-900' : 'text-red-900' }}">
                                                            {{ ($consulta->Estado ?? '') === 'Aprobada' ? 'Solicitud Aprobada' : 'Solicitud Rechazada' }}
                                                            @if($consulta->RevisadoPor)
                                                                - {{ $consulta->RevisadoPor }}
                                                            @endif
                                                        </p>
                                                        <p class="text-sm text-gray-700 line-clamp-2">{{ $consulta->Respuesta }}</p>
                                                        @if(isset($consulta->FechaRespuesta) && $consulta->FechaRespuesta)
                                                            <p class="text-xs text-gray-500 mt-1">
                                                                {{ \Carbon\Carbon::parse($consulta->FechaRespuesta)->format('d/m/Y H:i') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Acciones -->
                                    <div class="mt-4 lg:mt-0 lg:ml-6">
                                        <a href="{{ route('socio.voceria.ver', $consulta->ConsultaID ?? '#') }}" 
                                           class="inline-flex items-center px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors shadow-md hover:shadow-lg">
                                            <i class="fas fa-eye mr-2"></i>
                                            Ver Detalle
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Estado Vacío -->
                <div class="text-center py-16">
                    <div class="inline-block p-6 bg-gray-100 rounded-full mb-4">
                        <i class="fas fa-bullhorn text-6xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">No tienes solicitudes aún</h3>
                    <p class="text-gray-500 mb-6">Crea tu primera solicitud para comunicarte con la Vocalía</p>
                    <a href="{{ route('socio.voceria.crear') }}" 
                       class="inline-flex items-center px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Nueva Solicitud
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Información Adicional -->
    <div class="mt-6 bg-orange-50 border-l-4 border-orange-500 rounded-lg p-6">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-orange-600 text-2xl mr-4 mt-1"></i>
            <div>
                <h4 class="font-bold text-orange-900 mb-2">¿Cuándo contactar a la Vocalía?</h4>
                <ul class="text-sm text-orange-800 space-y-1">
                    <li>• Para solicitar apoyo en proyectos</li>
                    <li>• Para pedir recursos materiales o humanos</li>
                    <li>• Para solicitar permisos especiales</li>
                    <li>• Para obtener información sobre actividades</li>
                </ul>
            </div>
        </div>
    </div>

@endsection