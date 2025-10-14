@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.usuarios.lista') }}" class="flex items-center text-gray-600 hover:text-gray-900 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Volver a Lista
            </a>
            <h2 class="text-2xl font-bold text-gray-900">
                Detalles del Usuario
            </h2>
        </div>
        
        <!-- Botones de Acción -->
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.usuarios.editar', $usuario) }}" 
                class="inline-flex items-center px-4 py-2 border border-blue-300 text-sm font-medium rounded-xl text-blue-700 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Editar
            </a>
            
            <form method="POST" action="{{ route('admin.usuarios.eliminar', $usuario) }}" class="inline-block" 
                  onsubmit="return confirm('¿Está seguro de que desea eliminar este usuario? Esta acción no se puede deshacer.');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                    class="inline-flex items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-xl text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                    <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Eliminar
                </button>
            </form>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Información Principal del Usuario -->
            <div class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-black/5 mb-8">
                <div class="px-6 py-8">
                    <div class="flex items-center justify-center mb-8">
                        <div class="h-24 w-24 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                            {{ strtoupper(substr($usuario->name, 0, 2)) }}
                        </div>
                    </div>
                    
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $usuario->name }}</h1>
                        <p class="mt-2 text-lg text-gray-600">{{ $usuario->email }}</p>
                        <div class="mt-4 flex items-center justify-center space-x-3">
                            @if($usuario->email_verified_at)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Correo Verificado
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    Verificación Pendiente
                                </span>
                            @endif

                            @if($usuario->roles->count() > 0)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    {{ $usuario->roles->first()->name }}
                                </span>
                            @endif

                            @if($usuario->two_factor_enabled)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    2FA Activado
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Información Detallada -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- ID del Usuario -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">ID del Usuario</p>
                                    <p class="text-2xl font-bold text-gray-900">#{{ $usuario->id }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Fecha de Registro -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Fecha de Registro</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ $usuario->created_at->format('d/m/Y') }}</p>
                                    <p class="text-sm text-gray-600">{{ $usuario->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Última Actualización -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Última Actualización</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ $usuario->updated_at->format('d/m/Y') }}</p>
                                    <p class="text-sm text-gray-600">{{ $usuario->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Estado de Verificación -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if($usuario->email_verified_at)
                                        <svg class="h-8 w-8 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @else
                                        <svg class="h-8 w-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Estado de Verificación</p>
                                    @if($usuario->email_verified_at)
                                        <p class="text-lg font-semibold text-emerald-700">Verificado</p>
                                        <p class="text-sm text-gray-600">{{ $usuario->email_verified_at->format('d/m/Y H:i') }}</p>
                                    @else
                                        <p class="text-lg font-semibold text-yellow-700">No Verificado</p>
                                        <p class="text-sm text-gray-600">Pendiente de verificación</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cronología del Usuario -->
            <div class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-black/5">
                <div class="px-6 py-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Cronología del Usuario
                    </h3>
                </div>
                <div class="px-6 py-6">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            <!-- Evento: Registro -->
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-900 font-medium">Usuario registrado</p>
                                                <p class="text-sm text-gray-500">Se creó la cuenta en el sistema</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time datetime="{{ $usuario->created_at->toISOString() }}">{{ $usuario->created_at->format('d/m/Y H:i') }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <!-- Evento: Verificación de Email (si aplica) -->
                            @if($usuario->email_verified_at)
                                <li>
                                    <div class="relative pb-8">
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-emerald-500 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-900 font-medium">Correo verificado</p>
                                                    <p class="text-sm text-gray-500">El usuario confirmó su dirección de correo electrónico</p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <time datetime="{{ $usuario->email_verified_at->toISOString() }}">{{ $usuario->email_verified_at->format('d/m/Y H:i') }}</time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif

                            <!-- Evento: Última actualización (si es diferente del registro) -->
                            @if($usuario->updated_at->ne($usuario->created_at))
                                <li>
                                    <div class="relative">
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-purple-500 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-900 font-medium">Información actualizada</p>
                                                    <p class="text-sm text-gray-500">Se modificaron los datos del usuario</p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <time datetime="{{ $usuario->updated_at->toISOString() }}">{{ $usuario->updated_at->format('d/m/Y H:i') }}</time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection