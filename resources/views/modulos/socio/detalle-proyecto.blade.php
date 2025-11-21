@extends('modulos.socio.layout')

@section('page-title', $proyecto->NombreProyecto)

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('socio.proyectos') }}" class="text-blue-600 hover:text-blue-700 font-medium mb-3 inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a Proyectos
        </a>
        <div class="mt-3 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 rounded-xl p-6 shadow-lg text-white">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold">
                        {{ $proyecto->NombreProyecto }}
                    </h1>
                    <p class="text-blue-100 mt-2">{{ $proyecto->DescripcionProyecto }}</p>
                </div>
                <div class="flex gap-2">
                    <span class="px-4 py-2 text-sm font-semibold rounded-lg bg-white bg-opacity-20 backdrop-blur">
                        {{ $proyecto->EstadoProyecto }}
                    </span>
                    <span class="px-4 py-2 bg-white bg-opacity-20 backdrop-blur text-sm font-semibold rounded-lg">
                        {{ $proyecto->TipoProyecto ?? 'General' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid Principal -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Información Principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Descripción Detallada -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                    </div>
                    Descripción del Proyecto
                </h3>
                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $proyecto->DescripcionProyecto }}</p>
            </div>

            <!-- Objetivos -->
            @if(isset($proyecto->Objetivos) && $proyecto->Objetivos)
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <div class="bg-gradient-to-br from-green-500 to-green-600 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        Objetivos
                    </h3>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $proyecto->Objetivos }}</p>
                </div>
            @endif

            <!-- Actividades -->
            @if(isset($proyecto->Actividades) && $proyecto->Actividades)
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        Actividades Planificadas
                    </h3>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $proyecto->Actividades }}</p>
                </div>
            @endif

            <!-- Equipo del Proyecto -->
            @if(isset($participantes) && count($participantes) > 0)
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        Equipo del Proyecto
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($participantes as $miembro)
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4 shadow-md">
                                    {{ substr($miembro->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $miembro->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $miembro->RolProyecto ?? 'Colaborador' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar con Detalles -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Datos Clave -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    Datos Clave
                </h3>

                <div class="space-y-4">
                    <!-- Tipo de Proyecto -->
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Tipo de Proyecto</p>
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-sm font-semibold rounded-full">
                            {{ $proyecto->TipoProyecto }}
                        </span>
                    </div>

                    <!-- Responsable -->
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Responsable</p>
                        <p class="text-gray-800 flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ $proyecto->NombreResponsable ?? 'No asignado' }}
                        </p>
                    </div>

                    <!-- Fechas -->
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Fecha de Inicio</p>
                        <p class="text-gray-800 flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $proyecto->FechaInicio ? \Carbon\Carbon::parse($proyecto->FechaInicio)->format('d/m/Y') : 'Sin definir' }}
                        </p>
                    </div>

                    @if($proyecto->FechaFin)
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Fecha de Finalización</p>
                            <p class="text-gray-800 flex items-center">
                                <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ \Carbon\Carbon::parse($proyecto->FechaFin)->format('d/m/Y') }}
                            </p>
                        </div>

                        <!-- Duración -->
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Duración</p>
                            <p class="text-gray-800">
                                {{ \Carbon\Carbon::parse($proyecto->FechaInicio)->diffInDays(\Carbon\Carbon::parse($proyecto->FechaFin)) }} días
                            </p>
                        </div>
                    @endif

                    <!-- Mi Rol -->
                    @if(isset($proyecto->RolProyecto))
                        <div class="p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg border-2 border-purple-200">
                            <p class="text-sm font-semibold text-purple-700 uppercase mb-1">Mi Rol</p>
                            <p class="text-lg font-bold text-purple-900">{{ $proyecto->RolProyecto }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Presupuesto -->
            @if(isset($proyecto->Presupuesto) && $proyecto->Presupuesto > 0)
                <div class="bg-gradient-to-br from-green-50 to-teal-50 rounded-xl shadow-lg border-2 border-green-200 p-6">
                    <h3 class="text-lg font-bold text-green-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Presupuesto
                    </h3>
                    <p class="text-3xl font-bold text-green-900">
                        L. {{ number_format($proyecto->Presupuesto, 2) }}
                    </p>
                </div>
            @endif

            <!-- Ubicación -->
            @if(isset($proyecto->Ubicacion) && $proyecto->Ubicacion)
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        </svg>
                        Ubicación
                    </h3>
                    <p class="text-gray-700">{{ $proyecto->Ubicacion }}</p>
                </div>
            @endif

            <!-- Beneficiarios -->
            @if(isset($proyecto->Beneficiarios) && $proyecto->Beneficiarios)
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        Beneficiarios
                    </h3>
                    <p class="text-gray-700">{{ $proyecto->Beneficiarios }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Resultados Esperados / Obtenidos -->
    @if(isset($proyecto->ResultadosEsperados) || isset($proyecto->ResultadosObtenidos))
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            @if(isset($proyecto->ResultadosEsperados) && $proyecto->ResultadosEsperados)
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                            </svg>
                        </div>
                        Resultados Esperados
                    </h3>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $proyecto->ResultadosEsperados }}</p>
                </div>
            @endif

            @if(isset($proyecto->ResultadosObtenidos) && $proyecto->ResultadosObtenidos)
                <div class="bg-gradient-to-r from-green-50 to-teal-50 rounded-xl shadow-lg border-2 border-green-200 p-6">
                    <h3 class="text-lg font-bold text-green-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                        Resultados Obtenidos
                    </h3>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $proyecto->ResultadosObtenidos }}</p>
                </div>
            @endif
        </div>
    @endif

    <!-- Observaciones -->
    @if(isset($proyecto->Observaciones) && $proyecto->Observaciones)
        <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-6">
            <h3 class="text-lg font-bold text-yellow-900 mb-3 flex items-center">
                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                Observaciones
            </h3>
            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $proyecto->Observaciones }}</p>
        </div>
    @endif

@endsection