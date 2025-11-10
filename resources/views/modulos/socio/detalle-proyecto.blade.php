@extends('modulos.socio.layout')

@section('page-title', $proyecto->NombreProyecto)

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('socio.proyectos') }}" class="text-blue-600 hover:text-blue-700 font-medium mb-3 inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver a Proyectos
        </a>
        <div class="mt-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-200">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900">
                        {{ $proyecto->NombreProyecto }}
                    </h1>
                    <p class="text-gray-600 mt-2">{{ $proyecto->DescripcionProyecto }}</p>
                </div>
                <div class="flex gap-2">
                    <span class="px-4 py-2 text-sm font-semibold rounded-lg
                        {{ $proyecto->EstadoProyecto === 'Activo' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                        {{ $proyecto->EstadoProyecto }}
                    </span>
                    <span class="px-4 py-2 bg-blue-100 text-blue-700 text-sm font-semibold rounded-lg">
                        {{ $proyecto->EstadoProyecto ?? 'Sin estado' }}
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
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-align-left text-blue-500 mr-3"></i>
                    Descripción del Proyecto
                </h3>
                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $proyecto->DescripcionProyecto }}</p>
            </div>

            <!-- Objetivos -->
            @if(isset($proyecto->Objetivos) && $proyecto->Objetivos)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-bullseye text-green-500 mr-3"></i>
                        Objetivos
                    </h3>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $proyecto->Objetivos }}</p>
                </div>
            @endif

            <!-- Actividades -->
            @if(isset($proyecto->Actividades) && $proyecto->Actividades)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-tasks text-purple-500 mr-3"></i>
                        Actividades Planificadas
                    </h3>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $proyecto->Actividades }}</p>
                </div>
            @endif

            <!-- Equipo del Proyecto -->
            @if(isset($participantes) && count($participantes) > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-users text-indigo-500 mr-3"></i>
                        Equipo del Proyecto
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($participantes as $miembro)
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="w-12 h-12 bg-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                    {{ substr($miembro->Nombre, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $miembro->Nombre }}</p>
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
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-3"></i>
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
                            <i class="fas fa-user-tie text-green-500 mr-2"></i>
                            {{ $proyecto->NombreResponsable ?? 'No asignado' }}
                        </p>
                    </div>

                    <!-- Fechas -->
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Fecha de Inicio</p>
                        <p class="text-gray-800 flex items-center">
                            <i class="fas fa-calendar-plus text-green-500 mr-2"></i>
                            {{ $proyecto->FechaInicio ? \Carbon\Carbon::parse($proyecto->FechaInicio)->format('d/m/Y') : 'Sin definir' }}
                        </p>
                    </div>

                    @if($proyecto->FechaFin)
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Fecha de Finalización</p>
                            <p class="text-gray-800 flex items-center">
                                <i class="fas fa-calendar-check text-red-500 mr-2"></i>
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
                <div class="bg-gradient-to-br from-green-50 to-teal-50 rounded-xl shadow-sm border-2 border-green-200 p-6">
                    <h3 class="text-lg font-bold text-green-900 mb-4 flex items-center">
                        <i class="fas fa-dollar-sign text-green-600 mr-3"></i>
                        Presupuesto
                    </h3>
                    <p class="text-3xl font-bold text-green-900">
                        L. {{ number_format($proyecto->Presupuesto, 2) }}
                    </p>
                </div>
            @endif

            <!-- Ubicación -->
            @if(isset($proyecto->Ubicacion) && $proyecto->Ubicacion)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-map-marker-alt text-red-500 mr-3"></i>
                        Ubicación
                    </h3>
                    <p class="text-gray-700">{{ $proyecto->Ubicacion }}</p>
                </div>
            @endif

            <!-- Beneficiarios -->
            @if(isset($proyecto->Beneficiarios) && $proyecto->Beneficiarios)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-heart text-red-500 mr-3"></i>
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
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-flag-checkered text-orange-500 mr-3"></i>
                        Resultados Esperados
                    </h3>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $proyecto->ResultadosEsperados }}</p>
                </div>
            @endif

            @if(isset($proyecto->ResultadosObtenidos) && $proyecto->ResultadosObtenidos)
                <div class="bg-gradient-to-r from-green-50 to-teal-50 rounded-xl shadow-sm border-2 border-green-200 p-6">
                    <h3 class="text-lg font-bold text-green-900 mb-4 flex items-center">
                        <i class="fas fa-trophy text-green-600 mr-3"></i>
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
                <i class="fas fa-exclamation-circle text-yellow-600 mr-3"></i>
                Observaciones
            </h3>
            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $proyecto->Observaciones }}</p>
        </div>
    @endif

@endsection
