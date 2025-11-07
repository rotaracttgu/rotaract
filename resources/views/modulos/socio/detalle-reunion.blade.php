@extends('modulos.socio.layout')

@section('page-title', $reunion->titulo)

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('socio.reuniones') }}" class="text-purple-600 hover:text-purple-700 font-medium mb-3 inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver a Reuniones
        </a>
        
        @php
            $fechaReunion = \Carbon\Carbon::parse($reunion->fecha_hora);
            $esFutura = $fechaReunion->isFuture();
            $esHoy = $fechaReunion->isToday();
        @endphp

        <div class="mt-3 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-6 border border-purple-200
            {{ $esHoy ? 'ring-2 ring-purple-500' : '' }}">
            <div class="flex items-start justify-between flex-wrap gap-4">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        {{ $reunion->titulo }}
                        @if($esHoy)
                            <span class="ml-3 inline-block px-4 py-1 bg-purple-500 text-white text-sm font-semibold rounded-full animate-pulse">
                                <i class="fas fa-star mr-1"></i>HOY
                            </span>
                        @endif
                    </h1>
                    <p class="text-gray-700 text-lg">{{ $reunion->descripcion }}</p>
                </div>
                <span class="px-6 py-3 text-sm font-bold rounded-lg
                    {{ $reunion->estado === 'Programada' ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $reunion->estado === 'En Curso' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $reunion->estado === 'Finalizada' ? 'bg-gray-100 text-gray-700' : '' }}
                    {{ $reunion->estado === 'Cancelada' ? 'bg-red-100 text-red-700' : '' }}">
                    {{ $reunion->estado }}
                </span>
            </div>
        </div>
    </div>

    <!-- Grid Principal -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Información de la Reunión -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Fecha y Hora Destacada -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl shadow-lg p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                    <div>
                        <i class="fas fa-calendar-alt text-5xl mb-3 opacity-80"></i>
                        <p class="text-sm uppercase font-semibold opacity-80">Fecha</p>
                        <p class="text-2xl font-bold">{{ $fechaReunion->format('d/m/Y') }}</p>
                        <p class="text-sm opacity-80">{{ $fechaReunion->locale('es')->isoFormat('dddd') }}</p>
                    </div>
                    <div>
                        <i class="fas fa-clock text-5xl mb-3 opacity-80"></i>
                        <p class="text-sm uppercase font-semibold opacity-80">Hora</p>
                        <p class="text-2xl font-bold">{{ $fechaReunion->format('h:i A') }}</p>
                        @if($esFutura)
                            <p class="text-sm opacity-80">En {{ $fechaReunion->diffForHumans() }}</p>
                        @else
                            <p class="text-sm opacity-80">{{ $fechaReunion->diffForHumans() }}</p>
                        @endif
                    </div>
                    <div>
                        <i class="fas fa-hourglass-half text-5xl mb-3 opacity-80"></i>
                        <p class="text-sm uppercase font-semibold opacity-80">Duración</p>
                        <p class="text-2xl font-bold">{{ $reunion->duracion ?? 60 }} min</p>
                    </div>
                </div>
            </div>

            <!-- Ubicación y Tipo -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-map-marker-alt text-red-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase">Lugar</p>
                            <p class="text-lg font-bold text-gray-900">{{ $reunion->lugar }}</p>
                        </div>
                    </div>
                    @if($reunion->direccion)
                        <p class="text-sm text-gray-600 pl-16">{{ $reunion->direccion }}</p>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-tag text-purple-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase">Tipo</p>
                            <p class="text-lg font-bold text-gray-900">{{ $reunion->tipo }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agenda -->
            @if($reunion->agenda)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-list-ul text-green-500 mr-3"></i>
                        Agenda
                    </h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $reunion->agenda }}</p>
                    </div>
                </div>
            @endif

            <!-- Acta de la Reunión -->
            @if($reunion->estado === 'Finalizada' && $reunion->acta)
                <div class="bg-gradient-to-r from-green-50 to-teal-50 rounded-xl shadow-sm border-2 border-green-200 p-6">
                    <h3 class="text-lg font-bold text-green-900 mb-4 flex items-center">
                        <i class="fas fa-file-alt text-green-600 mr-3"></i>
                        Acta de la Reunión
                    </h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $reunion->acta }}</p>
                    </div>
                </div>
            @endif

            <!-- Acuerdos y Compromisos -->
            @if($reunion->estado === 'Finalizada' && $reunion->acuerdos)
                <div class="bg-yellow-50 rounded-xl shadow-sm border-2 border-yellow-300 p-6">
                    <h3 class="text-lg font-bold text-yellow-900 mb-4 flex items-center">
                        <i class="fas fa-handshake text-yellow-600 mr-3"></i>
                        Acuerdos y Compromisos
                    </h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $reunion->acuerdos }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Mi Asistencia -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user-check text-blue-500 mr-3"></i>
                    Mi Asistencia
                </h3>
                @if(isset($reunion->estado_asistencia))
                    <div class="text-center p-4 rounded-lg
                        {{ $reunion->estado_asistencia === 'Presente' ? 'bg-green-100' : '' }}
                        {{ $reunion->estado_asistencia === 'Ausente' ? 'bg-red-100' : '' }}
                        {{ $reunion->estado_asistencia === 'Justificado' ? 'bg-yellow-100' : '' }}
                        {{ !in_array($reunion->estado_asistencia, ['Presente', 'Ausente', 'Justificado']) ? 'bg-gray-100' : '' }}">
                        <i class="fas text-4xl mb-2
                            {{ $reunion->estado_asistencia === 'Presente' ? 'fa-check-circle text-green-600' : '' }}
                            {{ $reunion->estado_asistencia === 'Ausente' ? 'fa-times-circle text-red-600' : '' }}
                            {{ $reunion->estado_asistencia === 'Justificado' ? 'fa-exclamation-circle text-yellow-600' : '' }}
                            {{ !in_array($reunion->estado_asistencia, ['Presente', 'Ausente', 'Justificado']) ? 'fa-question-circle text-gray-600' : '' }}"></i>
                        <p class="font-bold text-xl
                            {{ $reunion->estado_asistencia === 'Presente' ? 'text-green-900' : '' }}
                            {{ $reunion->estado_asistencia === 'Ausente' ? 'text-red-900' : '' }}
                            {{ $reunion->estado_asistencia === 'Justificado' ? 'text-yellow-900' : '' }}
                            {{ !in_array($reunion->estado_asistencia, ['Presente', 'Ausente', 'Justificado']) ? 'text-gray-900' : '' }}">
                            {{ $reunion->estado_asistencia ?? 'Sin registrar' }}
                        </p>
                    </div>
                    @if($reunion->observaciones_asistencia)
                        <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-700">
                                <strong>Observaciones:</strong><br>
                                {{ $reunion->observaciones_asistencia }}
                            </p>
                        </div>
                    @endif
                @else
                    <p class="text-center text-gray-500 py-4">
                        <i class="fas fa-clock text-3xl mb-2"></i><br>
                        La asistencia se registrará durante la reunión
                    </p>
                @endif
            </div>

            <!-- Organizador -->
            @if($reunion->organizador)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user-tie text-indigo-500 mr-3"></i>
                        Organizador
                    </h3>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-xl mr-4">
                            {{ substr($reunion->organizador, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $reunion->organizador }}</p>
                            <p class="text-sm text-gray-600">Vocero</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Participantes -->
            @if(isset($participantes) && count($participantes) > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-users text-purple-500 mr-3"></i>
                        Participantes ({{ count($participantes) }})
                    </h3>
                    <div class="space-y-2 max-h-64 overflow-y-auto">
                        @foreach($participantes as $participante)
                            <div class="flex items-center p-2 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="w-8 h-8 bg-purple-400 rounded-full flex items-center justify-center text-white font-bold text-sm mr-3">
                                    {{ substr($participante->Nombre, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">{{ $participante->Nombre }}</p>
                                </div>
                                @if(isset($participante->Asistencia))
                                    <i class="fas text-sm
                                        {{ $participante->Asistencia === 'Presente' ? 'fa-check-circle text-green-500' : '' }}
                                        {{ $participante->Asistencia === 'Ausente' ? 'fa-times-circle text-red-500' : '' }}
                                        {{ $participante->Asistencia === 'Justificado' ? 'fa-exclamation-circle text-yellow-500' : '' }}"></i>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Enlace Virtual -->
            @if($reunion->enlace_virtual)
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-sm border-2 border-blue-200 p-6">
                    <h3 class="text-lg font-bold text-blue-900 mb-4 flex items-center">
                        <i class="fas fa-video text-blue-600 mr-3"></i>
                        Reunión Virtual
                    </h3>
                    <a href="{{ $reunion->enlace_virtual }}" target="_blank"
                       class="block w-full px-4 py-3 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Unirse a la reunión
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Información Adicional -->
    @if($reunion->observaciones)
        <div class="bg-orange-50 border-l-4 border-orange-500 rounded-lg p-6">
            <h3 class="text-lg font-bold text-orange-900 mb-3 flex items-center">
                <i class="fas fa-info-circle text-orange-600 mr-3"></i>
                Observaciones
            </h3>
            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $reunion->observaciones }}</p>
        </div>
    @endif

@endsection

@push('styles')
<style>
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: .5;
        }
    }
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>
@endpush