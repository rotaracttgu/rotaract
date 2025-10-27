@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.usuarios.lista') }}" class="flex items-center text-gray-600 hover:text-purple-600 transition-colors duration-200 group">
                <div class="bg-white rounded-lg p-2 shadow-md group-hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </div>
                <span class="ml-2 font-medium">Volver a Lista</span>
            </a>
        </div>
        <div>
            <h2 class="text-3xl font-bold bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 bg-clip-text text-transparent text-right">
                ➕ Crear Nuevo Usuario
            </h2>
            <p class="mt-1 text-sm text-gray-600 text-right">
                Completa el formulario para agregar un usuario
            </p>
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

            <!-- Formulario de Creación -->
            <div class="overflow-hidden rounded-3xl bg-white shadow-2xl ring-1 ring-black/5">
                <!-- Header del formulario -->
                <div class="bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 px-8 py-10">
                    <div class="text-center">
                        <div class="mx-auto h-20 w-20 rounded-full bg-white flex items-center justify-center shadow-xl transform hover:scale-110 transition-transform duration-300">
                            <svg class="h-10 w-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-2xl font-black text-white">Información del Nuevo Usuario</h3>
                        <p class="mt-2 text-white/90 font-medium">Complete todos los campos requeridos para crear la cuenta</p>
                    </div>
                </div>

                <!-- Cuerpo del formulario -->
                <div class="px-8 py-10">
                    <form method="POST" action="{{ route('admin.usuarios.guardar') }}" class="space-y-8">
                        @csrf

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
                                    placeholder="Ej: Juan Carlos Pérez López" 
                                    value="{{ old('name') }}">
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
                                    value="{{ old('email') }}">
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

                        <!-- Contraseña -->
                        <div class="group">
                            <label for="contrasena" class="block text-sm font-bold text-gray-700 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    Contraseña <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-6 w-6 text-gray-400 group-hover:text-purple-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input id="contrasena" name="password" type="password" required 
                                    class="block w-full pl-12 pr-4 py-4 text-base border-2 border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('password') border-red-400 bg-red-50 @enderror" 
                                    placeholder="Mínimo 8 caracteres">
                            </div>
                            <p class="mt-2 text-xs text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                La contraseña debe tener al menos 8 caracteres
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
                                    Confirmar Contraseña <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-6 w-6 text-gray-400 group-hover:text-purple-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <input id="confirmar_contrasena" name="password_confirmation" type="password" required 
                                    class="block w-full pl-12 pr-4 py-4 text-base border-2 border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                    placeholder="Repite la contraseña">
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
                                    <option value="Super Admin" {{ old('role') == 'Super Admin' ? 'selected' : '' }}>🔐 Super Admin</option>
                                    <option value="Presidente" {{ old('role') == 'Presidente' ? 'selected' : '' }}>👑 Presidente</option>
                                    <option value="Vicepresidente" {{ old('role') == 'Vicepresidente' ? 'selected' : '' }}>👔 Vicepresidente</option>
                                    <option value="Tesorero" {{ old('role') == 'Tesorero' ? 'selected' : '' }}>💰 Tesorero</option>
                                    <option value="Secretario" {{ old('role') == 'Secretario' ? 'selected' : '' }}>📝 Secretario</option>
                                    <option value="Vocero" {{ old('role') == 'Vocero' ? 'selected' : '' }}>📢 Vocero</option>
                                    <option value="Aspirante" {{ old('role') == 'Aspirante' ? 'selected' : '' }}>⭐ Aspirante</option>
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
                                        {{ old('email_verified') ? 'checked' : '' }}>
                                </div>
                                <div class="ml-4">
                                    <label for="correo_verificado" class="text-sm font-bold text-gray-900 cursor-pointer flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Marcar correo como verificado
                                    </label>
                                    <p class="text-sm text-gray-600 mt-1">Si activas esta opción, el usuario no necesitará verificar su correo electrónico para acceder al sistema</p>
                                </div>
                            </div>
                        </div>

                        <!-- Nuevo: Estado de Verificación 2FA -->
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6 border-2 border-purple-200 mt-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-6">
                                    <input id="two_factor_verified" name="two_factor_verified" type="checkbox" 
                                        class="h-5 w-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500 focus:ring-2 cursor-pointer" 
                                        {{ old('two_factor_verified') ? 'checked' : '' }}>
                                </div>
                                <div class="ml-4">
                                    <label for="two_factor_verified" class="text-sm font-bold text-gray-900 cursor-pointer flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.1.9-2 2-2s2 .9 2 2-2 4-2 4-2-2.9-2-4z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.1-.9-2-2-2s-2 .9-2 2 2 4 2 4 2-2.9 2-4z" />
                                        </svg>
                                        Marcar como verificado para 2FA
                                    </label>
                                    <p class="text-sm text-gray-600 mt-1">Si activas esta opción, el usuario no necesitará verificar con 2FA en el primer inicio de sesión</p>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-between pt-8 border-t-2 border-gray-200">
                            <a href="{{ route('admin.usuarios.lista') }}" 
                                class="inline-flex items-center px-8 py-4 border-2 border-gray-300 text-base font-bold rounded-2xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancelar
                            </a>
                            <button type="submit" 
                                class="inline-flex items-center px-10 py-4 border border-transparent text-base font-bold rounded-2xl text-white bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 hover:from-pink-600 hover:via-purple-600 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 shadow-xl transition-all duration-200 transform hover:scale-105">
                                <svg class="-ml-1 mr-3 h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                                </svg>
                                Crear Usuario
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