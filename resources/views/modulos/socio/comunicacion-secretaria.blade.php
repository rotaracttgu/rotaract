@extends('modulos.socio.layout')

@section('page-title', 'Comunicación con Secretaría')

@section('content')
    <!-- Header -->
    <div class="mb-6 bg-gradient-to-r from-green-50 to-teal-50 rounded-lg p-6 border border-green-200">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-envelope text-green-600 mr-3"></i>
                    Comunicación con Secretaría
                </h1>
                <p class="text-gray-600 mt-2">Envía consultas y recibe respuestas de la Secretaría del club</p>
            </div>
            <a href="{{ route('socio.secretaria.crear') }}" 
               class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors shadow-md hover:shadow-lg">
                <i class="fas fa-plus mr-2"></i>
                Nueva Consulta
            </a>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Total Consultas</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ count($consultas ?? []) }}</h3>
                </div>
                <i class="fas fa-comments text-blue-600 text-3xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Pendientes</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                        {{ collect($consultas ?? [])->whereIn('Estado', ['Pendiente', 'EnRevision'])->count() }}
                    </h3>
                </div>
                <i class="fas fa-clock text-orange-600 text-3xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Respondidas</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                        {{ collect($consultas ?? [])->where('Estado', 'Respondida')->count() }}
                    </h3>
                </div>
                <i class="fas fa-check-circle text-green-600 text-3xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-gray-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Cerradas</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                        {{ collect($consultas ?? [])->where('Estado', 'Cerrada')->count() }}
                    </h3>
                </div>
                <i class="fas fa-archive text-gray-600 text-3xl"></i>
            </div>
        </div>
    </div>

    <!-- Lista de Consultas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 flex items-center">
                <i class="fas fa-list text-green-500 mr-3"></i>
                Mis Consultas
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
                                        <!-- Encabezado con Estado -->
                                        <div class="flex items-start justify-between mb-3">
                                            <h3 class="text-xl font-bold text-gray-900">
                                                {{ $consulta->Asunto ?? 'Sin asunto' }}
                                            </h3>
                                            <span class="ml-4 px-4 py-1 text-sm font-semibold rounded-full whitespace-nowrap
                                                {{ ($consulta->Estado ?? '') === 'Pendiente' ? 'bg-orange-100 text-orange-700' : '' }}
                                                {{ ($consulta->Estado ?? '') === 'EnRevision' ? 'bg-blue-100 text-blue-700' : '' }}
                                                {{ ($consulta->Estado ?? '') === 'Respondida' ? 'bg-green-100 text-green-700' : '' }}
                                                {{ ($consulta->Estado ?? '') === 'Cerrada' ? 'bg-gray-100 text-gray-700' : '' }}">
                                                {{ ($consulta->Estado ?? '') === 'EnRevision' ? 'En Revisión' : ($consulta->Estado ?? 'Sin estado') }}
                                            </span>
                                        </div>

                                        <!-- Mensaje -->
                                        <p class="text-gray-700 mb-4 line-clamp-2">
                                            {{ $consulta->Mensaje ?? 'Sin mensaje' }}
                                        </p>

                                        <!-- Metadata -->
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                                            <!-- Fecha -->
                                            <div class="flex items-center text-gray-600">
                                                <i class="fas fa-calendar text-blue-500 mr-2"></i>
                                                <span>
                                                    {{ isset($consulta->FechaConsulta) && $consulta->FechaConsulta 
                                                        ? \Carbon\Carbon::parse($consulta->FechaConsulta)->format('d/m/Y H:i') 
                                                        : 'Sin fecha' }}
                                                </span>
                                            </div>

                                            <!-- Categoría -->
                                            <div class="flex items-center text-gray-600">
                                                <i class="fas fa-tag text-purple-500 mr-2"></i>
                                                <span>{{ $consulta->Categoria ?? 'Sin categoría' }}</span>
                                            </div>

                                            <!-- Prioridad -->
                                            <div class="flex items-center">
                                                <i class="fas fa-flag mr-2
                                                    {{ ($consulta->Prioridad ?? '') === 'Alta' ? 'text-red-500' : '' }}
                                                    {{ ($consulta->Prioridad ?? '') === 'Media' ? 'text-orange-500' : '' }}
                                                    {{ ($consulta->Prioridad ?? '') === 'Baja' ? 'text-gray-500' : '' }}"></i>
                                                <span class="text-gray-600">Prioridad: {{ $consulta->Prioridad ?? 'Normal' }}</span>
                                            </div>
                                        </div>

                                        <!-- Respuesta (si existe) -->
                                        @if(($consulta->Estado ?? '') === 'Respondida' && $consulta->Respuesta)
                                            <div class="mt-4 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                                                <div class="flex items-start">
                                                    <i class="fas fa-reply text-green-600 mt-1 mr-3"></i>
                                                    <div class="flex-1">
                                                        <p class="text-sm font-semibold text-green-900 mb-1">
                                                            Respuesta de {{ $consulta->RespondidoPor ?? 'Secretaría' }}
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

                                        <!-- Número de Mensajes -->
                                        @if(isset($consulta->NumeroMensajes) && $consulta->NumeroMensajes > 1)
                                            <div class="mt-3 flex items-center text-sm text-gray-600">
                                                <i class="fas fa-comments text-blue-500 mr-2"></i>
                                                <span>{{ $consulta->NumeroMensajes }} mensaje(s) en esta conversación</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Acciones -->
                                    <div class="mt-4 lg:mt-0 lg:ml-6">
                                        <a href="{{ route('socio.secretaria.ver', $consulta->ConsultaID ?? '#') }}" 
                                           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg">
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
                        <i class="fas fa-inbox text-6xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">No tienes consultas aún</h3>
                    <p class="text-gray-500 mb-6">Crea tu primera consulta para comunicarte con la Secretaría</p>
                    <a href="{{ route('socio.secretaria.crear') }}" 
                       class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Nueva Consulta
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Información Adicional -->
    <div class="mt-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-6">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-green-600 text-2xl mr-4 mt-1"></i>
            <div>
                <h4 class="font-bold text-green-900 mb-2">¿Cuándo contactar a la Secretaría?</h4>
                <ul class="text-sm text-green-800 space-y-1">
                    <li>• Para consultas sobre documentación del club</li>
                    <li>• Para solicitar actas de reuniones</li>
                    <li>• Para obtener diplomas o certificados</li>
                    <li>• Para consultas generales sobre procedimientos</li>
                </ul>
            </div>
        </div>
    </div>

@endsection
