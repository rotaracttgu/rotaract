@extends('modulos.presidente.usuarios.layout')

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
                Editar Usuario
            </h2>
        </div>
        
        <!-- Botón de Eliminar -->
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
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Formulario de Edición -->
            <div class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-black/5">
                <div class="px-6 py-8">
                    <div class="mb-8">
                        <div class="mx-auto h-16 w-16 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl shadow-lg">
                            {{ strtoupper(substr($usuario->name, 0, 2)) }}
                        </div>
                        <h3 class="mt-4 text-center text-lg font-semibold text-gray-900">{{ $usuario->name }}</h3>
                        <p class="mt-1 text-center text-sm text-gray-600">ID: #{{ $usuario->id }} • Registrado: {{ $usuario->created_at->format('d/m/Y') }}</p>
                    </div>

                    <form method="POST" action="{{ route('admin.usuarios.actualizar', $usuario) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nombre -->
                        <div>
                            <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nombre Completo
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input id="nombre" name="name" type="text" required 
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('name') border-red-300 ring-red-500 @enderror" 
                                    placeholder="Ingrese el nombre completo" 
                                    value="{{ old('name', $usuario->name) }}">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="correo" class="block text-sm font-semibold text-gray-700 mb-2">
                                Correo Electrónico
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input id="correo" name="email" type="email" required 
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('email') border-red-300 ring-red-500 @enderror" 
                                    placeholder="usuario@ejemplo.com" 
                                    value="{{ old('email', $usuario->email) }}">
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Rol del Usuario -->
                        <div>
                            <label for="rol" class="block text-sm font-semibold text-gray-700 mb-2">
                                Rol del Usuario
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <select id="rol" name="role" 
                                    class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('role') border-red-300 ring-red-500 @enderror bg-white">
                                    <option value="">Sin rol asignado</option>
                                    <option value="Super Admin" {{ (old('role') ?? ($usuario->roles->first()->name ?? '')) == 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                                    <option value="Presidente" {{ (old('role') ?? ($usuario->roles->first()->name ?? '')) == 'Presidente' ? 'selected' : '' }}>Presidente</option>
                                    <option value="Vicepresidente" {{ (old('role') ?? ($usuario->roles->first()->name ?? '')) == 'Vicepresidente' ? 'selected' : '' }}>Vicepresidente</option>
                                    <option value="Tesorero" {{ (old('role') ?? ($usuario->roles->first()->name ?? '')) == 'Tesorero' ? 'selected' : '' }}>Tesorero</option>
                                    <option value="Secretario" {{ (old('role') ?? ($usuario->roles->first()->name ?? '')) == 'Secretario' ? 'selected' : '' }}>Secretario</option>
                                    <option value="Vocero" {{ (old('role') ?? ($usuario->roles->first()->name ?? '')) == 'Vocero' ? 'selected' : '' }}>Vocero</option>
                                    <option value="Aspirante" {{ (old('role') ?? ($usuario->roles->first()->name ?? '')) == 'Aspirante' ? 'selected' : '' }}>Aspirante</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('role')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            
                            <!-- Información del rol actual -->
                            <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="text-sm">
                                        @if($usuario->roles->count() > 0)
                                            <span class="text-blue-800">
                                                <strong>Rol actual:</strong> 
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ml-1">
                                                    {{ ucfirst($usuario->roles->first()->name) }}
                                                </span>
                                            </span>
                                        @else
                                            <span class="text-blue-700">Sin rol asignado actualmente</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cambiar Contraseña -->
                        <div class="border border-gray-200 rounded-xl p-6 bg-gray-50">
                            <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Cambiar Contraseña
                            </h4>
                            <p class="text-xs text-gray-600 mb-4">Deje estos campos en blanco si no desea cambiar la contraseña</p>
                            
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <!-- Nueva Contraseña -->
                                <div>
                                    <label for="nueva_contrasena" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nueva Contraseña
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                        <input id="nueva_contrasena" name="password" type="password" 
                                            class="block w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('password') border-red-300 ring-red-500 @enderror" 
                                            placeholder="Mínimo 8 caracteres">
                                    </div>
                                    @error('password')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Confirmar Nueva Contraseña -->
                                <div>
                                    <label for="confirmar_nueva_contrasena" class="block text-sm font-medium text-gray-700 mb-2">
                                        Confirmar Contraseña
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <input id="confirmar_nueva_contrasena" name="password_confirmation" type="password" 
                                            class="block w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                            placeholder="Confirme la nueva contraseña">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Estado del Email -->
                        <div class="flex items-start">
                            <div class="flex items-center h-6">
                                <input id="correo_verificado" name="email_verified" type="checkbox" 
                                    class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" 
                                    {{ old('email_verified', $usuario->email_verified_at ? true : false) ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3">
                                <label for="correo_verificado" class="text-sm font-medium text-gray-700">
                                    Correo verificado
                                </label>
                                <p class="text-sm text-gray-500">
                                    @if($usuario->email_verified_at)
                                        Verificado el {{ $usuario->email_verified_at->format('d/m/Y H:i') }}
                                    @else
                                        Marcar como verificado
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Información Adicional -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Información del Usuario</h3>
                                    <div class="mt-2 text-sm text-blue-700 space-y-1">
                                        <p><strong>Creado:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}</p>
                                        <p><strong>Última actualización:</strong> {{ $usuario->updated_at->format('d/m/Y H:i') }}</p>
                                        @if($usuario->created_at != $usuario->updated_at)
                                            <p class="text-xs opacity-75">Modificado {{ $usuario->updated_at->diffForHumans() }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.usuarios.lista') }}" 
                                class="inline-flex items-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                                Cancelar
                            </a>
                            <button type="submit" 
                                class="inline-flex items-center px-8 py-3 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-lg transition-all duration-200 transform hover:scale-105">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Actualizar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection