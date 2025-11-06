@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <a href="{{ route(($moduloActual ?? 'admin') . '.usuarios.lista') }}" class="flex items-center text-gray-600 hover:text-purple-600 transition-colors duration-200 group">
                <div class="bg-white rounded-lg p-2 shadow-md group-hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </div>
                <span class="ml-2 font-medium">Volver a Lista</span>
            </a>
        </div>
        <div class="flex items-center space-x-4">
            <div>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 bg-clip-text text-transparent text-right">
                    ✏️ Editar Usuario
                </h2>
                <p class="mt-1 text-sm text-gray-600 text-right">
                    Actualiza la información del usuario
                </p>
            </div>
            
            <!-- Botón de Eliminar -->
            <form method="POST" action="{{ route(($moduloActual ?? 'admin') . '.usuarios.eliminar', $usuario) }}" 
                  onsubmit="return confirm('¿Está seguro de que desea eliminar al usuario {{ $usuario->name }}? Esta acción no se puede deshacer.');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                    class="inline-flex items-center px-5 py-3 border-2 border-red-300 text-sm font-bold rounded-xl text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Eliminar Usuario
                </button>
            </form>
        </div>
    </div>
@endsection

@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Mensajes de error generales -->
            @if ($errors->any())
                <div class="mb-8 rounded-2xl bg-gradient-to-r from-red-500 via-pink-500 to-rose-500 p-5 shadow-2xl transform hover:scale-[1.02] transition-all duration-300 animate-fade-in">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="bg-white rounded-full p-2.5">
                                <svg class="h-7 w-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-white font-semibold text-lg">⚠️ Por favor corrige los siguientes errores:</h3>
                            <ul class="mt-2 text-sm text-white/90 list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Formulario de Edición -->
            <div class="overflow-hidden rounded-3xl bg-white shadow-2xl ring-1 ring-black/5">
                <!-- Header del formulario con info del usuario -->
                <div class="bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 px-8 py-10">
                    <div class="text-center">
                        <div class="mx-auto h-24 w-24 rounded-full bg-white flex items-center justify-center text-4xl font-black text-transparent bg-clip-text bg-gradient-to-br from-pink-600 via-purple-600 to-blue-600 shadow-2xl transform hover:scale-110 transition-transform duration-300 ring-4 ring-white">
                            {{ strtoupper(substr($usuario->name, 0, 2)) }}
                        </div>
                        <h3 class="mt-4 text-3xl font-black text-white">{{ $usuario->name }}</h3>
                        <div class="mt-2 flex items-center justify-center space-x-4 text-white/90">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-white/20">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                ID: #{{ $usuario->id }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-white/20">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Registrado: {{ $usuario->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                        <p class="mt-3 text-white/95 font-medium text-lg">Modifica la información según sea necesario</p>
                    </div>
                </div>

                <!-- Cuerpo del formulario -->
                <div class="px-8 py-10">
                    <form method="POST" action="{{ route(($moduloActual ?? 'admin') . '.usuarios.actualizar', $usuario) }}" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Nombre -->
                        <div class="group">
                            <label for="nombre" class="block text-sm font-bold text-gray-700 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Nombre Completo <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-6 w-6 text-gray-400 group-hover:text-purple-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input id="nombre" name="name" type="text" required 
                                    class="block w-full pl-12 pr-4 py-4 text-base border-2 border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('name') border-red-400 bg-red-50 @enderror" 
                                    placeholder="Ingrese el nombre completo" 
                                    value="{{ old('name', $usuario->name) }}">
                            </div>
                            @error('name')
                                <div class="mt-2 flex items-center text-sm text-red-600 bg-red-50 px-4 py-2 rounded-lg">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="group">
                            <label for="correo" class="block text-sm font-bold text-gray-700 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Correo Electrónico <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-6 w-6 text-gray-400 group-hover:text-purple-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input id="correo" name="email" type="email" required 
                                    class="block w-full pl-12 pr-4 py-4 text-base border-2 border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('email') border-red-400 bg-red-50 @enderror" 
                                    placeholder="usuario@ejemplo.com" 
                                    value="{{ old('email', $usuario->email) }}">
                            </div>
                            @error('email')
                                <div class="mt-2 flex items-center text-sm text-red-600 bg-red-50 px-4 py-2 rounded-lg">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Contraseña (Opcional) -->
                        <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6">
                            <div class="flex items-start mb-4">
                                <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <h4 class="text-sm font-bold text-blue-900">Cambiar Contraseña (Opcional)</h4>
                                    <p class="text-sm text-blue-700 mt-1">Deja estos campos en blanco si no deseas cambiar la contraseña actual</p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <!-- Nueva Contraseña -->
                                <div class="group">
                                    <label for="contrasena" class="block text-sm font-bold text-gray-700 mb-3">
                                        <span class="flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                            Nueva Contraseña
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-6 w-6 text-gray-400 group-hover:text-purple-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                        <input id="contrasena" name="password" type="password" 
                                            class="block w-full pl-12 pr-4 py-4 text-base border-2 border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('password') border-red-400 bg-red-50 @enderror" 
                                            placeholder="Dejar en blanco para mantener actual">
                                    </div>
                                    <p class="mt-2 text-xs text-gray-500 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Mínimo 8 caracteres si decides cambiarla
                                    </p>
                                    @error('password')
                                        <div class="mt-2 flex items-center text-sm text-red-600 bg-red-50 px-4 py-2 rounded-lg">
                                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div class="group">
                                    <label for="confirmar_contrasena" class="block text-sm font-bold text-gray-700 mb-3">
                                        <span class="flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Confirmar Nueva Contraseña
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-6 w-6 text-gray-400 group-hover:text-purple-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <input id="confirmar_contrasena" name="password_confirmation" type="password" 
                                            class="block w-full pl-12 pr-4 py-4 text-base border-2 border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                            placeholder="Repite la nueva contraseña">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rol del Usuario -->
                        <div class="group">
                            <label for="role" class="block text-sm font-bold text-gray-700 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Rol del Usuario <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-6 w-6 text-gray-400 group-hover:text-purple-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <select id="role" name="role" required
                                    class="block w-full pl-12 pr-4 py-4 text-base border-2 border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('role') border-red-400 bg-red-50 @enderror appearance-none bg-white cursor-pointer">
                                    <option value="">Seleccione un rol</option>
                                    <option value="Super Admin" {{ old('role', $usuario->role) == 'Super Admin' ? 'selected' : '' }}>🔐 Super Admin</option>
                                    <option value="Presidente" {{ old('role', $usuario->role) == 'Presidente' ? 'selected' : '' }}>👑 Presidente</option>
                                    <option value="Vicepresidente" {{ old('role', $usuario->role) == 'Vicepresidente' ? 'selected' : '' }}>👔 Vicepresidente</option>
                                    <option value="Tesorero" {{ old('role', $usuario->role) == 'Tesorero' ? 'selected' : '' }}>💰 Tesorero</option>
                                    <option value="Secretario" {{ old('role', $usuario->role) == 'Secretario' ? 'selected' : '' }}>📝 Secretario</option>
                                    <option value="Vocero" {{ old('role', $usuario->role) == 'Vocero' ? 'selected' : '' }}>📢 Vocero</option>
                                    <option value="Aspirante" {{ old('role', $usuario->role) == 'Aspirante' ? 'selected' : '' }}>⭐ Aspirante</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('role')
                                <div class="mt-2 flex items-center text-sm text-red-600 bg-red-50 px-4 py-2 rounded-lg">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Estado del Email -->
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6 border-2 border-purple-200">
                            <div class="flex items-start">
                                <div class="flex items-center h-6">
                                    <input id="correo_verificado" name="email_verified" type="checkbox" 
                                        class="h-5 w-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500 focus:ring-2 cursor-pointer" 
                                        {{ old('email_verified', $usuario->email_verified_at ? true : false) ? 'checked' : '' }}>
                                </div>
                                <div class="ml-4">
                                    <label for="correo_verificado" class="text-sm font-bold text-gray-900 cursor-pointer flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Correo verificado
                                    </label>
                                    <p class="text-sm text-gray-600 mt-1">
                                        @if($usuario->email_verified_at)
                                            Verificado el {{ $usuario->email_verified_at->format('d/m/Y H:i') }}
                                        @else
                                            Marca esta casilla para verificar manualmente el correo electrónico
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Nuevo: Estado de Verificación 2FA -->
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6 border-2 border-purple-200 mt-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-6">
                                    <input id="two_factor_verified" name="two_factor_verified" type="checkbox" 
                                        class="h-5 w-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500 focus:ring-2 cursor-pointer" 
                                        {{ old('two_factor_verified', $usuario->two_factor_verified_at ? true : false) ? 'checked' : '' }}>
                                </div>
                                <div class="ml-4">
                                    <label for="two_factor_verified" class="text-sm font-bold text-gray-900 cursor-pointer flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.1.9-2 2-2s2 .9 2 2-2 4-2 4-2-2.9-2-4z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.1-.9-2-2-2s-2 .9-2 2 2 4 2 4 2-2.9 2-4z" />
                                        </svg>
                                        Marcar como verificado para 2FA
                                    </label>
                                    <p class="text-sm text-gray-600 mt-1">
                                        @if($usuario->two_factor_verified_at)
                                            Verificado el {{ $usuario->two_factor_verified_at->format('d/m/Y H:i') }}
                                        @else
                                            Marca esta casilla para verificar manualmente la 2FA
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Botones Centrados -->
                        <div class="flex items-center justify-center space-x-4 pt-8 border-t-2 border-gray-200">
                            <a href="{{ route(($moduloActual ?? 'admin') . '.usuarios.lista') }}" 
                                class="inline-flex items-center px-8 py-4 border-2 border-gray-300 text-base font-bold rounded-2xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancelar
                            </a>
                            <button type="submit" 
                                class="inline-flex items-center px-10 py-4 border border-transparent text-base font-bold rounded-2xl text-white bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 hover:from-pink-600 hover:via-purple-600 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 shadow-xl transition-all duration-200 transform hover:scale-105">
                                <svg class="-ml-1 mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }

        /* Estilo para el select */
        select {
            background-image: none;
        }
    </style>
@endsection
