@extends('modulos.socio.layout')

@section('page-title', 'Detalle de Consulta')

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('socio.secretaria.index') }}" class="text-blue-600 hover:text-blue-700 font-medium mb-3 inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a Consultas
        </a>
        <div class="mt-3 bg-gradient-to-r from-green-500 via-teal-500 to-cyan-500 rounded-xl p-6 shadow-lg text-white">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-2xl font-bold">
                        {{ $consulta->Asunto }}
                    </h1>
                    <p class="text-green-100 mt-2">Consulta #{{ $consulta->ConsultaID }}</p>
                </div>
                <span class="px-6 py-3 text-sm font-bold rounded-lg bg-white bg-opacity-30 backdrop-blur
                    {{ $consulta->Estado === 'Pendiente' ? 'ring-2 ring-orange-300' : '' }}
                    {{ $consulta->Estado === 'EnRevision' ? 'ring-2 ring-blue-300' : '' }}
                    {{ $consulta->Estado === 'Respondida' ? 'ring-2 ring-green-300' : '' }}
                    {{ $consulta->Estado === 'Cerrada' ? 'ring-2 ring-gray-300' : '' }}">
                    {{ $consulta->Estado === 'EnRevision' ? 'En Revisión' : $consulta->Estado }}
                </span>
            </div>
        </div>
    </div>

    <!-- Información de la Consulta -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Metadata -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    Información
                </h3>

                <div class="space-y-4">
                    <!-- Fecha de Consulta -->
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Fecha de Consulta</p>
                        <p class="text-gray-800 flex items-center">
                            <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ \Carbon\Carbon::parse($consulta->FechaConsulta)->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    <!-- Categoría -->
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Categoría</p>
                        <p class="text-gray-800 flex items-center">
                            <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
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
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                            </svg>
                            {{ $consulta->Prioridad }}
                        </span>
                    </div>

                    @if($consulta->Estado === 'Respondida' && $consulta->FechaRespuesta)
                        <!-- Fecha de Respuesta -->
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Respondida el</p>
                            <p class="text-gray-800 flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ \Carbon\Carbon::parse($consulta->FechaRespuesta)->format('d/m/Y H:i') }}
                            </p>
                        </div>

                        <!-- Respondido Por -->
                        @if($consulta->RespondidoPor)
                            <div>
                                <p class="text-sm font-semibold text-gray-500 uppercase mb-1">Respondido por</p>
                                <p class="text-gray-800 flex items-center">
                                    <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
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
            <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center">
                        <div class="bg-gradient-to-br from-green-500 to-teal-600 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                        </div>
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
                                                    {{ $mensaje->TipoMensaje === 'Consulta' ? 'bg-gradient-to-br from-blue-500 to-blue-600' : 'bg-gradient-to-br from-green-500 to-green-600' }}">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        @if($mensaje->TipoMensaje === 'Consulta')
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                        @endif
                                                    </svg>
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
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($mensaje->FechaEnvio)->format('d/m/Y H:i') }}
                                            </p>
                                            @if($mensaje->Leido)
                                                <span class="text-xs text-gray-500 flex items-center">
                                                    <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
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
                            <svg class="w-16 h-16 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                            <p>No hay mensajes en esta conversación</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Mensaje Original -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-6">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 flex items-center">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                Consulta Original
            </h3>
        </div>
        <div class="p-6">
            <div class="prose max-w-none">
                <p class="text-gray-800 whitespace-pre-wrap">{{ $consulta->Mensaje }}</p>
            </div>
        </div>
    </div>

    <!-- Comprobante de Pago (si existe) -->
    @if(isset($consulta->comprobante_ruta) && $consulta->comprobante_ruta)
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-6">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <div class="bg-gradient-to-br from-green-500 to-green-600 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    Comprobante de Pago
                </h3>
            </div>
            <div class="p-6">
                @php
                    $extension = pathinfo($consulta->comprobante_ruta, PATHINFO_EXTENSION);
                    $isPdf = strtolower($extension) === 'pdf';
                    $comprobanteUrl = asset('storage/' . $consulta->comprobante_ruta);
                @endphp

                @if($isPdf)
                    <!-- Si es PDF -->
                    <div class="flex items-center justify-center p-8 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                        <div class="text-center">
                            <svg class="w-16 h-16 mx-auto text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-gray-700 font-semibold mb-4">Comprobante en formato PDF</p>
                            <a href="{{ $comprobanteUrl }}" 
                               target="_blank"
                               class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Ver Comprobante PDF
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Si es imagen -->
                    <div class="text-center">
                        <a href="{{ $comprobanteUrl }}" 
                           target="_blank"
                           class="inline-block group">
                            <img src="{{ $comprobanteUrl }}" 
                                 alt="Comprobante de pago"
                                 class="max-w-full max-h-96 mx-auto rounded-lg shadow-lg border-2 border-gray-200 group-hover:shadow-xl transition-shadow cursor-pointer">
                            <p class="text-sm text-gray-600 mt-4 flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                </svg>
                                Haz clic en la imagen para verla en tamaño completo
                            </p>
                        </a>
                    </div>
                @endif

                <!-- Información adicional -->
                <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-blue-800 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Este comprobante fue adjuntado con la consulta de pago de membresía.</span>
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Respuesta Oficial (si existe) -->
    @if($consulta->Respuesta)
        <div class="bg-gradient-to-r from-green-50 to-teal-50 rounded-xl shadow-lg border-2 border-green-200">
            <div class="p-6 border-b border-green-200">
                <h3 class="text-lg font-bold text-green-900 flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                    </svg>
                    Respuesta de la Secretaría
                </h3>
            </div>
            <div class="p-6">
                <div class="flex items-start mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mr-4 shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
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
                <svg class="w-6 h-6 text-orange-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
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