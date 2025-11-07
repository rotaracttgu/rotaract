@extends('modulos.socio.layout')

@section('page-title', 'Detalle de Consulta')

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('socio.voceria.index') }}" class="text-orange-600 hover:text-orange-700 font-medium mb-3 inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver a Consultas
        </a>
        <div class="mt-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg p-6 border border-orange-200">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        {{ $consulta->Titulo }}
                    </h1>
                    <p class="text-gray-600 mt-2">Consulta #{{ $consulta->ConsultaID }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-6 py-3 text-sm font-bold rounded-lg
                        {{ $consulta->Estado === 'abierta' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $consulta->Estado === 'cerrada' ? 'bg-gray-100 text-gray-700' : '' }}">
                        @if($consulta->Estado === 'abierta')
                            <i class="fas fa-check-circle mr-1"></i>Abierta
                        @else
                            <i class="fas fa-times-circle mr-1"></i>Cerrada
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Información de la Consulta -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Metadata -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-orange-500 mr-2"></i>
                    Información
                </h3>

                <div class="space-y-4">
                    <!-- Fecha de Creación -->
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Creada el</p>
                        <p class="text-gray-800 flex items-center">
                            <i class="fas fa-calendar text-blue-500 mr-2"></i>
                            {{ \Carbon\Carbon::parse($consulta->FechaCreacion)->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    <!-- Autor -->
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Autor</p>
                        <p class="text-gray-800 flex items-center">
                            <i class="fas fa-user-tie text-purple-500 mr-2"></i>
                            {{ $consulta->Autor }}
                        </p>
                    </div>

                    <!-- Fecha de Cierre -->
                    @if($consulta->FechaCierre)
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Cierra el</p>
                            <p class="text-gray-800 flex items-center">
                                <i class="fas fa-calendar-times text-red-500 mr-2"></i>
                                {{ \Carbon\Carbon::parse($consulta->FechaCierre)->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    @endif

                    <!-- Respuestas -->
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Respuestas</p>
                        <p class="text-gray-800 flex items-center">
                            <i class="fas fa-comments text-orange-500 mr-2"></i>
                            {{ $consulta->Respuestas ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido de la Consulta -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <i class="fas fa-file-alt text-orange-500 mr-2"></i>
                        Contenido de la Consulta
                    </h3>
                </div>
                <div class="p-6">
                    <div class="prose max-w-none">
                        <p class="text-gray-800 whitespace-pre-wrap">{{ $consulta->Contenido }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Resultados de Votación -->
    @if(isset($consulta->Votos) && is_array($consulta->Votos))
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <i class="fas fa-chart-pie text-orange-500 mr-2"></i>
                    Resultados de Votación
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($consulta->Votos as $opcion => $votos)
                        <div class="bg-gradient-to-r from-orange-50 to-yellow-50 rounded-lg p-4 border border-orange-200">
                            <p class="font-semibold text-gray-800">{{ $opcion }}</p>
                            <p class="text-2xl font-bold text-orange-600">{{ $votos }}</p>
                            <p class="text-sm text-gray-600">votos</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Estado de Cierre -->
    @if($consulta->Estado === 'cerrada')
        <div class="bg-gray-50 border-l-4 border-gray-500 rounded-lg p-6">
            <div class="flex items-center">
                <i class="fas fa-lock text-gray-600 text-2xl mr-4"></i>
                <div>
                    <h4 class="font-bold text-gray-900 mb-1">Consulta Cerrada</h4>
                    <p class="text-sm text-gray-700">
                        Esta consulta ha finalizado. No se aceptan más respuestas ni votos.
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 text-2xl mr-4"></i>
                <div>
                    <h4 class="font-bold text-green-900 mb-1">Consulta Abierta</h4>
                    <p class="text-sm text-green-800">
                        Puedes participar respondiendo o votando hasta el {{ \Carbon\Carbon::parse($consulta->FechaCierre)->format('d/m/Y') }}.
                    </p>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('scripts')
<script>
    // Auto-scroll al contenido
    document.addEventListener('DOMContentLoaded', function() {
        const content = document.querySelector('.prose');
        if (content) {
            content.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    });
</script>
@endpush