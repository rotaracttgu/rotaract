@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                Detalle del Evento #{{ $registro->BitacoraID }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Información completa del registro de bitácora
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.bitacora.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver a la lista
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Información Principal -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden ring-1 ring-black/5 mb-6">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Información General</h3>
            </div>
            <div class="px-6 py-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- ID del Evento -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ID del Evento</label>
                        <p class="text-lg font-semibold text-gray-900">#{{ $registro->BitacoraID }}</p>
                    </div>

                    <!-- Fecha y Hora -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha y Hora</label>
                        <p class="text-lg text-gray-900">
                            {{ $registro->fecha_hora->format('d/m/Y H:i:s') }}
                            <span class="text-sm text-gray-500">({{ $registro->fecha_hora->diffForHumans() }})</span>
                        </p>
                    </div>

                    <!-- Acción -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Acción</label>
                        @php
                            $accionClasses = [
                                'login' => 'bg-blue-100 text-blue-800',
                                'logout' => 'bg-gray-100 text-gray-800',
                                'login_fallido' => 'bg-red-100 text-red-800',
                                'registro' => 'bg-purple-100 text-purple-800',
                                'cambio_password' => 'bg-yellow-100 text-yellow-800',
                                'verificacion_2fa' => 'bg-indigo-100 text-indigo-800',
                                'create' => 'bg-green-100 text-green-800',
                                'update' => 'bg-yellow-100 text-yellow-800',
                                'delete' => 'bg-red-100 text-red-800',
                                'restore' => 'bg-blue-100 text-blue-800',
                                'view' => 'bg-gray-100 text-gray-800',
                                'export' => 'bg-purple-100 text-purple-800',
                                'import' => 'bg-indigo-100 text-indigo-800',
                            ];
                            $class = $accionClasses[$registro->accion] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $class }}">
                            {{ ucfirst(str_replace('_', ' ', $registro->accion)) }}
                        </span>
                    </div>

                    <!-- Estado -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        @if($registro->estado === 'exitoso')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Exitoso
                            </span>
                        @elseif($registro->estado === 'fallido')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                Fallido
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                Pendiente
                            </span>
                        @endif
                    </div>

                    <!-- Módulo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Módulo</label>
                        <p class="text-lg text-gray-900">{{ ucfirst($registro->modulo) }}</p>
                    </div>

                    <!-- Tabla -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tabla</label>
                        <p class="text-lg text-gray-900 font-mono">{{ $registro->tabla ?? 'N/A' }}</p>
                    </div>

                    <!-- Descripción -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <p class="text-base text-gray-900 bg-gray-50 p-4 rounded-lg border border-gray-200">
                            {{ $registro->descripcion }}
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <!-- Información del Usuario -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden ring-1 ring-black/5 mb-6">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Información del Usuario</h3>
            </div>
            <div class="px-6 py-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    @if($registro->user)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Usuario</label>
                            <div class="flex items-center">
                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-lg font-bold">
                                    {{ strtoupper(substr($registro->usuario_nombre, 0, 2)) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-base font-semibold text-gray-900">{{ $registro->usuario_nombre }}</p>
                                    <p class="text-sm text-gray-500">{{ $registro->usuario_email }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
                            <p class="text-base text-gray-900">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                    {{ $registro->usuario_rol ?? 'Sin rol' }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ID de Usuario</label>
                            <p class="text-base text-gray-900 font-mono">#{{ $registro->user_id }}</p>
                        </div>
                    @else
                        <div class="md:col-span-2">
                            <div class="bg-gray-50 border-l-4 border-gray-400 p-4 rounded">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-700">
                                            Acción realizada por el sistema o usuario no autenticado
                                            @if($registro->usuario_email)
                                                <br><span class="font-medium">Email intentado:</span> {{ $registro->usuario_email }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- Información Técnica -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden ring-1 ring-black/5 mb-6">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Información Técnica</h3>
            </div>
            <div class="px-6 py-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- IP Address -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dirección IP</label>
                        <p class="text-base text-gray-900 font-mono bg-gray-50 px-3 py-2 rounded border border-gray-200">
                            {{ $registro->ip_address }}
                        </p>
                    </div>

                    <!-- Método HTTP -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Método HTTP</label>
                        <p class="text-base text-gray-900 font-mono">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $registro->metodo_http ?? 'N/A' }}
                            </span>
                        </p>
                    </div>

                    <!-- URL -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                        <p class="text-sm text-gray-900 font-mono bg-gray-50 px-3 py-2 rounded border border-gray-200 break-all">
                            {{ $registro->url ?? 'N/A' }}
                        </p>
                    </div>

                    <!-- User Agent -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">User Agent</label>
                        <p class="text-xs text-gray-900 font-mono bg-gray-50 px-3 py-2 rounded border border-gray-200 break-all">
                            {{ $registro->user_agent ?? 'N/A' }}
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <!-- Datos del Cambio -->
        @if($registro->datos_anteriores || $registro->datos_nuevos)
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden ring-1 ring-black/5 mb-6">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Datos del Cambio</h3>
                <p class="mt-1 text-sm text-gray-500">Comparación antes y después</p>
            </div>
            <div class="px-6 py-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    
                    <!-- Datos Anteriores -->
                    @if($registro->datos_anteriores)
                    <div>
                        <div class="flex items-center mb-3">
                            <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h4 class="text-sm font-semibold text-gray-900">Datos Anteriores</h4>
                        </div>
                        <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                            <pre class="text-xs text-gray-800 overflow-x-auto whitespace-pre-wrap">{{ json_encode($registro->datos_anteriores, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </div>
                    @endif

                    <!-- Datos Nuevos -->
                    @if($registro->datos_nuevos)
                    <div>
                        <div class="flex items-center mb-3">
                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h4 class="text-sm font-semibold text-gray-900">Datos Nuevos</h4>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                            <pre class="text-xs text-gray-800 overflow-x-auto whitespace-pre-wrap">{{ json_encode($registro->datos_nuevos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
        @endif

        <!-- Error (si existe) -->
        @if($registro->error_mensaje)
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden ring-1 ring-black/5 mb-6">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 text-red-600">Error Registrado</h3>
            </div>
            <div class="px-6 py-6">
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-800 font-mono">
                                {{ $registro->error_mensaje }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Metadata (si existe) -->
        @if($registro->metadata)
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden ring-1 ring-black/5">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Metadata Adicional</h3>
            </div>
            <div class="px-6 py-6">
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <pre class="text-xs text-gray-800 overflow-x-auto whitespace-pre-wrap">{{ json_encode($registro->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
