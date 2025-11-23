@extends('modulos.socio.layout')

@section('page-title', 'Comunicación con Secretaría')

@section('content')
    <!-- Header con gradiente mejorado -->
    <div class="mb-6 bg-gradient-to-r from-green-500 via-teal-500 to-cyan-500 rounded-xl p-6 shadow-lg text-white">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl font-bold flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Comunicación con Secretaría
                </h1>
                <p class="text-green-100 mt-2">Envía consultas y recibe respuestas de la Secretaría del club</p>
            </div>
            <a href="{{ route('socio.secretaria.crear') }}" 
               class="px-6 py-3 bg-white text-green-600 rounded-lg hover:bg-green-50 transition-colors shadow-md hover:shadow-lg font-bold">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Consulta
            </a>
        </div>
    </div>

    <!-- Estadísticas con diseño mejorado -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">TOTAL CONSULTAS</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">{{ $totalConsultas ?? 0 }}</h3>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">PENDIENTES</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-orange-800 bg-clip-text text-transparent">{{ $consultasPendientes ?? 0 }}</h3>
                </div>
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">RESPONDIDAS</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent">{{ $consultasRespondidas ?? 0 }}</h3>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-gray-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">CERRADAS</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-gray-600 to-gray-800 bg-clip-text text-transparent">{{ $consultasCerradas ?? 0 }}</h3>
                </div>
                <div class="bg-gradient-to-br from-gray-500 to-gray-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Consultas -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800 flex items-center">
                <div class="bg-gradient-to-br from-green-500 to-teal-600 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                Mis Consultas
            </h2>
            
            <!-- Filtros -->
            <form method="GET" action="{{ route('socio.secretaria.index') }}" class="flex gap-3">
                <select name="estado" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">Todos los estados</option>
                    <option value="pendiente" {{ ($filtroEstado ?? '') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="respondida" {{ ($filtroEstado ?? '') === 'respondida' ? 'selected' : '' }}>Respondida</option>
                    <option value="cerrada" {{ ($filtroEstado ?? '') === 'cerrada' ? 'selected' : '' }}>Cerrada</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    Filtrar
                </button>
            </form>
        </div>

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
                                            {{ $consulta->Asunto }}
                                        </h3>
                                        <span class="ml-4 px-4 py-1 text-sm font-semibold rounded-full whitespace-nowrap
                                            {{ $consulta->Estado === 'pendiente' ? 'bg-orange-100 text-orange-700' : '' }}
                                            {{ $consulta->Estado === 'respondida' ? 'bg-green-100 text-green-700' : '' }}
                                            {{ $consulta->Estado === 'cerrada' ? 'bg-gray-100 text-gray-700' : '' }}">
                                            {{ ucfirst($consulta->Estado) }}
                                        </span>
                                    </div>

                                    <!-- Mensaje -->
                                    <p class="text-gray-700 mb-4">
                                        {{ strlen($consulta->Mensaje) > 150 ? substr($consulta->Mensaje, 0, 150) . '...' : $consulta->Mensaje }}
                                    </p>

                                    <!-- Metadata -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                        <!-- Fecha -->
                                        <div class="flex items-center text-gray-600">
                                            <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>
                                                {{ \Carbon\Carbon::parse($consulta->FechaEnvio)->format('d/m/Y H:i') }}
                                            </span>
                                        </div>

                                        <!-- Prioridad -->
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2
                                                {{ $consulta->Prioridad === 'alta' ? 'text-red-500' : '' }}
                                                {{ $consulta->Prioridad === 'media' ? 'text-orange-500' : '' }}
                                                {{ $consulta->Prioridad === 'baja' ? 'text-gray-500' : '' }}"
                                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                                            </svg>
                                            <span class="text-gray-600">Prioridad: {{ ucfirst($consulta->Prioridad) }}</span>
                                        </div>
                                    </div>

                                    <!-- Respuesta (si existe) -->
                                    @if($consulta->Estado === 'respondida' && $consulta->Respuesta)
                                        <div class="mt-4 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 text-green-600 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                                </svg>
                                                <div class="flex-1">
                                                    <p class="text-sm font-semibold text-green-900 mb-1">
                                                        Respuesta de {{ $consulta->RespondidoPor ?? 'Secretaría' }}
                                                    </p>
                                                    <p class="text-sm text-gray-700">{{ strlen($consulta->Respuesta) > 100 ? substr($consulta->Respuesta, 0, 100) . '...' : $consulta->Respuesta }}</p>
                                                    @if($consulta->FechaRespuesta)
                                                        <p class="text-xs text-gray-500 mt-1">
                                                            {{ \Carbon\Carbon::parse($consulta->FechaRespuesta)->format('d/m/Y H:i') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if(isset($consulta->ComprobanteRuta) && $consulta->ComprobanteRuta)
                                        <div class="mt-3 flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                            </svg>
                                            <span>Con comprobante adjunto</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Acciones -->
                                <div class="mt-4 lg:mt-0 lg:ml-6">
                                    <a href="{{ route('socio.secretaria.ver', $consulta->ConsultaID ?? '#') }}" 
                                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg font-semibold">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
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
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">No tienes consultas aún</h3>
                <p class="text-gray-500 mb-6">Crea tu primera consulta para comunicarte con la Secretaría</p>
                <a href="{{ route('socio.secretaria.crear') }}" 
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nueva Consulta
                </a>
            </div>
        @endif
    </div>

    <!-- Información Adicional -->
    <div class="mt-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-green-600 mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
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