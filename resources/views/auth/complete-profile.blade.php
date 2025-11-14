<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Completar Perfil - Primera Vez</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">

    <!-- Overlay -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40"></div>

    <!-- Modal Container -->
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            
            <!-- Modal Content -->
            <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl overflow-hidden">
                
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-3xl font-black text-white">¡Bienvenido! 👋</h2>
                            <p class="text-blue-100 mt-1 text-sm">Completa tu perfil para comenzar</p>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-full p-3">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Alert Info -->
                <div class="mx-8 mt-6 bg-blue-50 border-l-4 border-blue-600 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="h-6 w-6 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-blue-900">Primera vez en el sistema</p>
                            <p class="text-sm text-blue-700 mt-1">Por seguridad, debes completar tu información y cambiar tu contraseña temporal.</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('profile.complete.store') }}" method="POST" class="p-8">
                    @csrf

                    <!-- Errores generales -->
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-600 rounded-lg p-4">
                            <div class="flex items-start">
                                <svg class="h-6 w-6 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-red-900 mb-2">Por favor corrige los siguientes errores:</p>
                                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="space-y-8">
                        
                        <!-- Sección 1: Información Personal -->
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm mr-3">1</span>
                                Información Personal
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nombre -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        Nombre <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('name') border-red-500 @enderror">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Apellidos -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        Apellidos <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" name="apellidos" value="{{ old('apellidos') }}" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('apellidos') border-red-500 @enderror">
                                    @error('apellidos')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- DNI -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        DNI/Cédula <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" name="dni" value="{{ old('dni') }}" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('dni') border-red-500 @enderror">
                                    @error('dni')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Teléfono -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        Teléfono
                                    </label>
                                    <input type="text" name="telefono" value="{{ old('telefono') }}"
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('telefono') border-red-500 @enderror">
                                    @error('telefono')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Sección 2: Credenciales de Acceso -->
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <span class="bg-indigo-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm mr-3">2</span>
                                Credenciales de Acceso
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Username -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        Nombre de Usuario <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" name="username" value="{{ old('username') }}" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('username') border-red-500 @enderror">
                                    @error('username')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        Correo Electrónico <span class="text-red-600">*</span>
                                    </label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('email') border-red-500 @enderror">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nueva Contraseña -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        Nueva Contraseña <span class="text-red-600">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="password" name="password" required
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('password') border-red-500 @enderror">
                                        <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-600">Mínimo 8 caracteres, mayúsculas, minúsculas, números y símbolos</p>
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        Confirmar Contraseña <span class="text-red-600">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="password_confirmation" name="password_confirmation" required
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección 3: Preguntas de Seguridad -->
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <span class="bg-purple-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm mr-3">3</span>
                                Preguntas de Seguridad
                            </h3>
                            <p class="text-sm text-gray-600 mb-6">Configura 2 preguntas de seguridad para recuperar tu cuenta</p>

                            <!-- Pregunta 1 -->
                            <div class="bg-purple-50 rounded-2xl p-6 mb-6">
                                <h4 class="font-bold text-gray-900 mb-4">Pregunta de Seguridad 1</h4>
                                
                                <div class="space-y-4">
                                    <!-- Tipo de pregunta -->
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Tipo de pregunta</label>
                                        <div class="flex space-x-4">
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="tipo_pregunta_1" value="predefinida" checked 
                                                    class="w-5 h-5 text-purple-600 focus:ring-2 focus:ring-purple-500"
                                                    onchange="togglePregunta(1, 'predefinida')">
                                                <span class="ml-2 text-sm font-medium text-gray-700">Predefinida</span>
                                            </label>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="tipo_pregunta_1" value="personalizada"
                                                    class="w-5 h-5 text-purple-600 focus:ring-2 focus:ring-purple-500"
                                                    onchange="togglePregunta(1, 'personalizada')">
                                                <span class="ml-2 text-sm font-medium text-gray-700">Personalizada</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Select predefinida -->
                                    <div id="pregunta_predefinida_1_container">
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Selecciona una pregunta</label>
                                        <select name="pregunta_predefinida_1" 
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                            <option value="">Seleccionar...</option>
                                            @foreach($preguntasPredefinidas as $pregunta)
                                                <option value="{{ $pregunta }}">{{ $pregunta }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Input personalizada (oculto por defecto) -->
                                    <div id="pregunta_personalizada_1_container" class="hidden">
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Escribe tu pregunta</label>
                                        <input type="text" name="pregunta_personalizada_1" 
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                            placeholder="Ej: ¿Cuál es mi libro favorito?">
                                    </div>

                                    <!-- Respuesta -->
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">
                                            Tu Respuesta <span class="text-red-600">*</span>
                                        </label>
                                        <input type="text" name="respuesta_seguridad_1" required
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('respuesta_seguridad_1') border-red-500 @enderror">
                                        @error('respuesta_seguridad_1')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Pregunta 2 -->
                            <div class="bg-purple-50 rounded-2xl p-6">
                                <h4 class="font-bold text-gray-900 mb-4">Pregunta de Seguridad 2</h4>
                                
                                <div class="space-y-4">
                                    <!-- Tipo de pregunta -->
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Tipo de pregunta</label>
                                        <div class="flex space-x-4">
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="tipo_pregunta_2" value="predefinida" checked
                                                    class="w-5 h-5 text-purple-600 focus:ring-2 focus:ring-purple-500"
                                                    onchange="togglePregunta(2, 'predefinida')">
                                                <span class="ml-2 text-sm font-medium text-gray-700">Predefinida</span>
                                            </label>
                                            <label class="flex items-center cursor-pointer">
                                                <input type="radio" name="tipo_pregunta_2" value="personalizada"
                                                    class="w-5 h-5 text-purple-600 focus:ring-2 focus:ring-purple-500"
                                                    onchange="togglePregunta(2, 'personalizada')">
                                                <span class="ml-2 text-sm font-medium text-gray-700">Personalizada</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Select predefinida -->
                                    <div id="pregunta_predefinida_2_container">
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Selecciona una pregunta</label>
                                        <select name="pregunta_predefinida_2"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                            <option value="">Seleccionar...</option>
                                            @foreach($preguntasPredefinidas as $pregunta)
                                                <option value="{{ $pregunta }}">{{ $pregunta }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Input personalizada (oculto por defecto) -->
                                    <div id="pregunta_personalizada_2_container" class="hidden">
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Escribe tu pregunta</label>
                                        <input type="text" name="pregunta_personalizada_2"
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                            placeholder="Ej: ¿Cuál es mi película favorita?">
                                    </div>

                                    <!-- Respuesta -->
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">
                                            Tu Respuesta <span class="text-red-600">*</span>
                                        </label>
                                        <input type="text" name="respuesta_seguridad_2" required
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('respuesta_seguridad_2') border-red-500 @enderror">
                                        @error('respuesta_seguridad_2')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Botón Submit -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <button type="submit" 
                            class="px-8 py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                            <span class="flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Completar Perfil y Continuar
                            </span>
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        // Toggle entre pregunta predefinida y personalizada
        function togglePregunta(numero, tipo) {
            const predefinidaContainer = document.getElementById(`pregunta_predefinida_${numero}_container`);
            const personalizadaContainer = document.getElementById(`pregunta_personalizada_${numero}_container`);
            
            if (tipo === 'predefinida') {
                predefinidaContainer.classList.remove('hidden');
                personalizadaContainer.classList.add('hidden');
                // Limpiar el input personalizado
                document.querySelector(`input[name="pregunta_personalizada_${numero}"]`).value = '';
            } else {
                predefinidaContainer.classList.add('hidden');
                personalizadaContainer.classList.remove('hidden');
                // Limpiar el select predefinido
                document.querySelector(`select[name="pregunta_predefinida_${numero}"]`).value = '';
            }
        }
    </script>

</body>
</html>
