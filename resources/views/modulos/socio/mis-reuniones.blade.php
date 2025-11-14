@extends('modulos.socio.layout')

@section('page-title', 'Mis Reuniones')

@section('content')
    <!-- Header -->
    <div class="mb-6 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-6 border border-purple-200">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-users text-purple-600 mr-3"></i>
            Mis Reuniones
        </h1>
        <p class="text-gray-600 mt-2">Reuniones a las que estás invitado o has asistido</p>
    </div>

    <!-- Filtros -->
    <div class="mb-6 bg-white rounded-xl shadow-sm p-4 border border-gray-200">
        <form method="GET" action="{{ route('socio.reuniones') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-filter mr-1"></i>
                    Filtrar por Estado
                </label>
                <select name="estado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="todas" {{ $filtroEstado === 'todas' ? 'selected' : '' }}>Todas las Reuniones</option>
                    <option value="Programada" {{ $filtroEstado === 'Programada' ? 'selected' : '' }}>Programadas</option>
                    <option value="En Curso" {{ $filtroEstado === 'En Curso' ? 'selected' : '' }}>En Curso</option>
                    <option value="Finalizada" {{ $filtroEstado === 'Finalizada' ? 'selected' : '' }}>Finalizadas</option>
                    <option value="Cancelada" {{ $filtroEstado === 'Cancelada' ? 'selected' : '' }}>Canceladas</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-search mr-2"></i>
                Filtrar
            </button>
        </form>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Total</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ count($reuniones ?? []) }}</h3>
                </div>
                <i class="fas fa-calendar text-blue-600 text-3xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Programadas</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                        {{ collect($reuniones ?? [])->where('estado', 'Programada')->count() }}
                    </h3>
                </div>
                <i class="fas fa-clock text-green-600 text-3xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">En Curso</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                        {{ collect($reuniones ?? [])->where('estado', 'En Curso')->count() }}
                    </h3>
                </div>
                <i class="fas fa-spinner text-orange-600 text-3xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-gray-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Finalizadas</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                        {{ collect($reuniones ?? [])->where('estado', 'Finalizada')->count() }}
                    </h3>
                </div>
                <i class="fas fa-check-circle text-gray-600 text-3xl"></i>
            </div>
        </div>
    </div>

    <!-- Lista de Reuniones -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 flex items-center">
                <i class="fas fa-list text-purple-500 mr-3"></i>
                Listado de Reuniones
            </h2>
        </div>

        <div class="p-6">
            @if(isset($reuniones) && count($reuniones) > 0)
                <div class="space-y-4">
                    @foreach($reuniones as $reunion)
                        @php
                            $fechaReunion = isset($reunion->FechaHora) && $reunion->FechaHora 
                                ? \Carbon\Carbon::parse($reunion->FechaHora) 
                                : null;
                            $esFutura = $fechaReunion ? $fechaReunion->isFuture() : false;
                            $esHoy = $fechaReunion ? $fechaReunion->isToday() : false;
                        @endphp

                        @if($fechaReunion)
                            <div class="border border-gray-200 rounded-lg hover:shadow-lg transition-all duration-300 overflow-hidden
                                {{ $esHoy ? 'ring-2 ring-blue-500' : '' }}">
                                
                                <div class="flex flex-col md:flex-row">
                                    <!-- Fecha (Sidebar) -->
                                    <div class="bg-gradient-to-br from-blue-600 to-blue-700 text-white p-6 md:w-32 flex md:flex-col items-center justify-center text-center">
                                        <div>
                                            <div class="text-sm font-bold uppercase">{{ $fechaReunion->format('M') }}</div>
                                            <div class="text-4xl font-bold my-2">{{ $fechaReunion->format('d') }}</div>
                                            <div class="text-xs">{{ $fechaReunion->format('Y') }}</div>
                                        </div>
                                    </div>

                                    <!-- Contenido -->
                                    <div class="flex-1 p-6">
                                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between">
                                            <div class="flex-1">
                                                <!-- Título -->
                                                <h3 class="text-xl font-bold text-gray-900 mb-2">
                                                    {{ $reunion->titulo ?? 'Sin título' }}
                                                    @if($esHoy)
                                                        <span class="ml-2 inline-block px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full animate-pulse">
                                                            <i class="fas fa-star mr-1"></i>HOY
                                                        </span>
                                                    @endif
                                                </h3>

                                                <!-- Descripción -->
                                                <p class="text-gray-600 mb-4">
                                                    {{ $reunion->descripcion ?? 'Sin descripción' }}
                                                </p>

                                                <!-- Detalles -->
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                                    <!-- Hora -->
                                                    <div class="flex items-center">
                                                        <i class="fas fa-clock text-blue-500 mr-2"></i>
                                                        <span class="text-gray-700 font-medium">{{ $fechaReunion->format('h:i A') }}</span>
                                                    </div>

                                                    <!-- Lugar -->
                                                    <div class="flex items-center">
                                                        <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                                                        <span class="text-gray-700">{{ $reunion->lugar ?? 'Sin ubicación' }}</span>
                                                    </div>

                                                    <!-- Tipo -->
                                                    <div class="flex items-center">
                                                        <i class="fas fa-tag text-purple-500 mr-2"></i>
                                                        <span class="text-gray-700">{{ $reunion->tipo ?? 'General' }}</span>
                                                    </div>
                                                </div>

                                                <!-- Mi Asistencia -->
                                                @if(isset($reunion->estado_asistencia))
                                                    <div class="mt-4 flex items-center">
                                                        <span class="text-sm font-semibold text-gray-700 mr-2">Mi asistencia:</span>
                                                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                                                            {{ $reunion->estado_asistencia === 'Presente' ? 'bg-green-100 text-green-700' : '' }}
                                                            {{ $reunion->estado_asistencia === 'Ausente' ? 'bg-red-100 text-red-700' : '' }}
                                                            {{ $reunion->estado_asistencia === 'Justificado' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                            {{ !in_array($reunion->estado_asistencia, ['Presente', 'Ausente', 'Justificado']) ? 'bg-gray-100 text-gray-700' : '' }}">
                                                            {{ $reunion->estado_asistencia ?? 'Sin registrar' }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Estados y Acciones -->
                                            <div class="mt-4 lg:mt-0 lg:ml-6 flex flex-col items-end gap-3">
                                                <!-- Estado de la Reunión -->
                                                <span class="px-4 py-2 text-sm font-semibold rounded-lg
                                                    {{ $reunion->estado === 'Programada' ? 'bg-blue-100 text-blue-700' : '' }}
                                                    {{ $reunion->estado === 'En Curso' ? 'bg-green-100 text-green-700' : '' }}
                                                    {{ $reunion->estado === 'Finalizada' ? 'bg-gray-100 text-gray-700' : '' }}
                                                    {{ $reunion->estado === 'Cancelada' ? 'bg-red-100 text-red-700' : '' }}">
                                                    {{ $reunion->estado ?? 'Sin estado' }}
                                                </span>

                                                <!-- Tiempo Restante o Pasado -->
                                                @if($esFutura)
                                                    <div class="text-sm text-gray-600">
                                                        <i class="fas fa-hourglass-half text-orange-500 mr-1"></i>
                                                        En {{ $fechaReunion->diffForHumans() }}
                                                    </div>
                                                @else
                                                    <div class="text-sm text-gray-500">
                                                        <i class="fas fa-history text-gray-400 mr-1"></i>
                                                        {{ $fechaReunion->diffForHumans() }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Observaciones (si existen) -->
                                        @if(isset($reunion->observaciones) && $reunion->observaciones)
                                            <div class="mt-4 p-3 bg-yellow-50 border-l-4 border-yellow-400 rounded">
                                                <p class="text-sm text-gray-700">
                                                    <i class="fas fa-comment-dots text-yellow-600 mr-2"></i>
                                                    <strong>Observaciones:</strong> {{ $reunion->observaciones }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <!-- Estado Vacío -->
                <div class="text-center py-16">
                    <div class="inline-block p-6 bg-gray-100 rounded-full mb-4">
                        <i class="fas fa-calendar-times text-6xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">No tienes reuniones programadas</h3>
                    <p class="text-gray-500">Las reuniones asignadas aparecerán aquí automáticamente</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Información Adicional -->
    <div class="mt-6 bg-purple-50 border-l-4 border-purple-500 rounded-lg p-6">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-purple-600 text-2xl mr-4 mt-1"></i>
            <div>
                <h4 class="font-bold text-purple-900 mb-2">Información sobre las reuniones</h4>
                <ul class="text-sm text-purple-800 space-y-1">
                    <li>• Las reuniones son programadas por el Vocero del club</li>
                    <li>• Tu asistencia es registrada automáticamente durante las reuniones</li>
                    <li>• Si no puedes asistir, contacta con la Secretaría para justificar tu ausencia</li>
                </ul>
            </div>
        </div>
    </div>

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
