@extends('modulos.socio.layout')

@section('page-title', $reunion->titulo)

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('socio.reuniones') }}" class="text-purple-600 hover:text-purple-700 font-medium mb-3 inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a Reuniones
        </a>
        
        @php
            $fechaReunion = \Carbon\Carbon::parse($reunion->fecha_hora);
            $esFutura = $fechaReunion->isFuture();
            $esHoy = $fechaReunion->isToday();
        @endphp

        <div class="mt-3 bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 rounded-xl p-6 shadow-lg text-white
            {{ $esHoy ? 'ring-4 ring-purple-400' : '' }}">
            <div class="flex items-start justify-between flex-wrap gap-4">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold mb-2">
                        {{ $reunion->titulo }}
                        @if($esHoy)
                            <span class="ml-3 inline-block px-4 py-1 bg-white text-purple-600 text-sm font-semibold rounded-full animate-pulse">
                                <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                HOY
                            </span>
                        @endif
                    </h1>
                    <p class="text-purple-100 text-lg">{{ $reunion->descripcion }}</p>
                </div>
                <span class="px-6 py-3 text-sm font-bold rounded-lg bg-white bg-opacity-30 backdrop-blur">
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
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-sm uppercase font-semibold opacity-80">Fecha</p>
                        <p class="text-2xl font-bold">{{ $fechaReunion->format('d/m/Y') }}</p>
                        <p class="text-sm opacity-80">{{ $fechaReunion->locale('es')->isoFormat('dddd') }}</p>
                    </div>
                    <div>
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm uppercase font-semibold opacity-80">Hora</p>
                        <p class="text-2xl font-bold">{{ $fechaReunion->format('h:i A') }}</p>
                        @if($esFutura)
                            <p class="text-sm opacity-80">En {{ $fechaReunion->diffForHumans() }}</p>
                        @else
                            <p class="text-sm opacity-80">{{ $fechaReunion->diffForHumans() }}</p>
                        @endif
                    </div>
                    <div>
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm uppercase font-semibold opacity-80">Duración</p>
                        <p class="text-2xl font-bold">{{ $reunion->duracion ?? 60 }} min</p>
                    </div>
                </div>
            </div>

            <!-- Ubicación y Tipo -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
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

                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
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
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <div class="bg-gradient-to-br from-green-500 to-green-600 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        Agenda
                    </h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $reunion->agenda }}</p>
                    </div>
                </div>
            @endif

            <!-- Acta de la Reunión -->
            @if($reunion->estado === 'Finalizada' && $reunion->acta)
                <div class="bg-gradient-to-r from-green-50 to-teal-50 rounded-xl shadow-lg border-2 border-green-200 p-6">
                    <h3 class="text-lg font-bold text-green-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Acta de la Reunión
                    </h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $reunion->acta }}</p>
                    </div>
                </div>
            @endif

            <!-- Acuerdos y Compromisos -->
            @if($reunion->estado === 'Finalizada' && $reunion->acuerdos)
                <div class="bg-yellow-50 rounded-xl shadow-lg border-2 border-yellow-300 p-6">
                    <h3 class="text-lg font-bold text-yellow-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
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
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    Mi Asistencia
                </h3>
                @if(isset($reunion->estado_asistencia))
                    <div class="text-center p-4 rounded-lg
                        {{ $reunion->estado_asistencia === 'Presente' ? 'bg-green-100' : '' }}
                        {{ $reunion->estado_asistencia === 'Ausente' ? 'bg-red-100' : '' }}
                        {{ $reunion->estado_asistencia === 'Justificado' ? 'bg-yellow-100' : '' }}
                        {{ !in_array($reunion->estado_asistencia, ['Presente', 'Ausente', 'Justificado']) ? 'bg-gray-100' : '' }}">
                        <svg class="w-12 h-12 mx-auto mb-2
                            {{ $reunion->estado_asistencia === 'Presente' ? 'text-green-600' : '' }}
                            {{ $reunion->estado_asistencia === 'Ausente' ? 'text-red-600' : '' }}
                            {{ $reunion->estado_asistencia === 'Justificado' ? 'text-yellow-600' : '' }}
                            {{ !in_array($reunion->estado_asistencia, ['Presente', 'Ausente', 'Justificado']) ? 'text-gray-600' : '' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($reunion->estado_asistencia === 'Presente')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            @elseif($reunion->estado_asistencia === 'Ausente')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            @elseif($reunion->estado_asistencia === 'Justificado')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            @endif
                        </svg>
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
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        La asistencia se registrará durante la reunión
                    </p>
                @endif
            </div>

            <!-- Organizador -->
            @if($reunion->organizador)
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        Organizador
                    </h3>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-4 shadow-md">
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
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        Participantes ({{ count($participantes) }})
                    </h3>
                    <div class="space-y-2 max-h-64 overflow-y-auto">
                        @foreach($participantes as $participante)
                            <div class="flex items-center p-2 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-3 shadow-md">
                                    {{ isset($participante->user) ? substr($participante->user->name, 0, 1) : '?' }}
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">{{ $participante->user->name ?? 'Sin nombre' }}</p>
                                </div>
                                @if(isset($participante->Asistencia))
                                    <svg class="w-5 h-5
                                        {{ $participante->Asistencia === 'Presente' ? 'text-green-500' : '' }}
                                        {{ $participante->Asistencia === 'Ausente' ? 'text-red-500' : '' }}
                                        {{ $participante->Asistencia === 'Justificado' ? 'text-yellow-500' : '' }}"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($participante->Asistencia === 'Presente')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        @elseif($participante->Asistencia === 'Ausente')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Enlace Virtual -->
            @if($reunion->enlace_virtual)
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-lg border-2 border-blue-200 p-6">
                    <h3 class="text-lg font-bold text-blue-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Reunión Virtual
                    </h3>
                    <a href="{{ $reunion->enlace_virtual }}" target="_blank"
                       class="block w-full px-4 py-3 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Unirse a la reunión
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Observaciones -->
    @if($reunion->observaciones)
        <div class="bg-orange-50 border-l-4 border-orange-500 rounded-lg p-6">
            <h3 class="text-lg font-bold text-orange-900 mb-3 flex items-center">
                <svg class="w-5 h-5 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                </svg>
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