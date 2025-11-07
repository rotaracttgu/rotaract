@extends('modulos.socio.layout')

@section('page-title', 'Detalle de Consulta')

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('socio.secretaria.index') }}" class="text-blue-600 hover:text-blue-700 font-medium mb-3 inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver a Consultas
        </a>
        <div class="mt-3 bg-gradient-to-r from-green-50 to-teal-50 rounded-lg p-6 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        {{ $consulta->Asunto }}
                    </h1>
                    <p class="text-gray-600 mt-2">Consulta #{{ $consulta->ConsultaID }}</p>
                </div>
                <span class="px-6 py-3 text-sm font-bold rounded-lg
                    {{ $consulta->Estado === 'Pendiente' ? 'bg-orange-100 text-orange-700' : '' }}
                    {{ $consulta->Estado === 'EnRevision' ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $consulta->Estado === 'Respondida' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $consulta->Estado === 'Cerrada' ? 'bg-gray-100 text-gray-700' : '' }}">
                    {{ $consulta->Estado === 'EnRevision' ? 'En Revisión' : $consulta->Estado }}
                </span>
            </div>
        </div>
    </div>

    <!-- Información de la Consulta -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Metadata -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                    Información
                </h3>

                <div class="space-y-4">
                    <!-- Fecha de Consulta -->
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Fecha de Consulta</p>
                        <p class="text-gray-800 flex items-center">
                            <i class="fas fa-calendar text-blue-500 mr-2"></i>
                            {{ \Carbon\Carbon::parse($consulta->FechaConsulta)->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    <!-- Categoría -->
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Categoría</p>
                        <p class="text-gray-800 flex items-center">
                            <i class="fas fa-tag text-purple-500 mr-2"></i>
                            {{ $consulta->Categoria }}
                        </p>
                    </div>

                    <!-- Prioridad -->
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Prioridad</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                            {{ $consulta->Prioridad === 'Alta' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $consulta->Prioridad === 'Media' ? 'bg-orange-100 text-orange-700' : '' }}
                            {{ $consulta->Prioridad === 'Baja' ? 'bg-gray-100 text-gray-700' : '' }}">
                            <i class="fas fa-flag mr-2"></i>
                            {{ $consulta->Prioridad }}
                        </span>
                    </div>

                    @if($consulta->Estado === 'Respondida' && $consulta->FechaRespuesta)
                        <!-- Fecha de Respuesta -->
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Respondida el</p>
                            <p class="text-gray-800 flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                {{ \Carbon\Carbon::parse($consulta->FechaRespuesta)->format('d/m/Y H:i') }}
                            </p>
                        </div>

                        <!-- Respondido Por -->
                        @if($consulta->RespondidoPor)
                            <div>
                                <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Respondido por</p>
                                <p class="text-gray-800 flex items-center">
                                    <i class="fas fa-user text-blue-500 mr-2"></i>
                                    {{ $consulta->RespondidoPor }}
                                </p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Conversación -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <i class="fas fa-comments text-green-500 mr-2"></i>
                        Historial de Conversación
                    </h3>
                </div>

                <div class="p-6">
                    @if(isset($historial) && count($historial) > 0)
                        <div class="space-y-4">
                            @foreach($historial as $mensaje)
                                <div class="flex {{ $mensaje->TipoMensaje === 'Consulta' ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-[80%] {{ $mensaje->TipoMensaje === 'Consulta' ? 'bg-blue-50 border-blue-200' : 'bg-green-50 border-green-200' }} 
                                                border-2 rounded-lg p-4 shadow-sm">
                                        <!-- Header del Mensaje -->
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center mr-2
                                                    {{ $mensaje->TipoMensaje === 'Consulta' ? 'bg-blue-500' : 'bg-green-500' }}">
                                                    <i class="fas {{ $mensaje->TipoMensaje === 'Consulta' ? 'fa-user' : 'fa-user-tie' }} 
                                                       text-white text-sm"></i>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-900 text-sm">
                                                        {{ $mensaje->NombreRemitente }}
                                                    </p>
                                                    <p class="text-xs {{ $mensaje->TipoMensaje === 'Consulta' ? 'text-blue-600' : 'text-green-600' }}">
                                                        {{ $mensaje->TipoMensaje }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Contenido del Mensaje -->
                                        <div class="text-gray-800 whitespace-pre-wrap break-words">
                                            {{ $mensaje->Mensaje }}
                                        </div>

                                        <!-- Footer con Fecha -->
                                        <div class="flex items-center justify-between mt-3 pt-3 border-t {{ $mensaje->TipoMensaje === 'Consulta' ? 'border-blue-200' : 'border-green-200' }}">
                                            <p class="text-xs text-gray-500 flex items-center">
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ \Carbon\Carbon::parse($mensaje->FechaEnvio)->format('d/m/Y H:i') }}
                                            </p>
                                            @if($mensaje->Leido)
                                                <span class="text-xs text-gray-500 flex items-center">
                                                    <i class="fas fa-check-double text-green-500 mr-1"></i>
                                                    Leído
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Sin Historial -->
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-comments text-4xl mb-3"></i>
                            <p>No hay mensajes en esta conversación</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Mensaje Original -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 flex items-center">
                <i class="fas fa-file-alt text-blue-500 mr-2"></i>
                Consulta Original
            </h3>
        </div>
        <div class="p-6">
            <div class="prose max-w-none">
                <p class="text-gray-800 whitespace-pre-wrap">{{ $consulta->Mensaje }}</p>
            </div>
        </div>
    </div>

    <!-- Respuesta Oficial (si existe) -->
    @if($consulta->Respuesta)
        <div class="bg-gradient-to-r from-green-50 to-teal-50 rounded-xl shadow-sm border-2 border-green-300">
            <div class="p-6 border-b border-green-200">
                <h3 class="text-lg font-bold text-green-900 flex items-center">
                    <i class="fas fa-reply text-green-600 mr-2"></i>
                    Respuesta de la Secretaría
                </h3>
            </div>
            <div class="p-6">
                <div class="flex items-start mb-4">
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user-tie text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900">{{ $consulta->RespondidoPor ?? 'Secretaría' }}</p>
                        <p class="text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($consulta->FechaRespuesta)->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
                <div class="prose max-w-none">
                    <p class="text-gray-800 whitespace-pre-wrap">{{ $consulta->Respuesta }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Estado de Espera -->
    @if($consulta->Estado === 'Pendiente' || $consulta->Estado === 'EnRevision')
        <div class="mt-6 bg-orange-50 border-l-4 border-orange-500 rounded-lg p-6">
            <div class="flex items-center">
                <i class="fas fa-hourglass-half text-orange-600 text-2xl mr-4"></i>
                <div>
                    <h4 class="font-bold text-orange-900 mb-1">Tu consulta está {{ $consulta->Estado === 'EnRevision' ? 'en revisión' : 'pendiente' }}</h4>
                    <p class="text-sm text-orange-800">
                        La Secretaría responderá tu consulta lo antes posible según la prioridad establecida.
                    </p>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('scripts')
<script>
    // Auto-scroll al último mensaje
    document.addEventListener('DOMContentLoaded', function() {
        const lastMessage = document.querySelector('.space-y-4 > div:last-child');
        if (lastMessage) {
            lastMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    });
</script>
@endpush