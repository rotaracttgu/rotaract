<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas de Seguridad</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-2xl">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-6">
                <h2 class="text-2xl font-bold text-white text-center">Preguntas de Seguridad</h2>
                <p class="text-purple-100 text-center text-sm mt-2">Responde correctamente para restablecer tu contraseña</p>
            </div>

            <!-- Form -->
            <form action="{{ route('password.security.verify') }}" method="POST" class="p-8">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <!-- Mensaje de error -->
                @if ($errors->has('respuestas'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-600 rounded-lg p-4 animate-shake">
                        <div class="flex items-start">
                            <svg class="h-6 w-6 text-red-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-red-900">{{ $errors->first('respuestas') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Pregunta 1 -->
                <div class="mb-8 bg-purple-50 rounded-2xl p-6 border-2 transition-all {{ $errors->has('respuestas') ? 'border-red-300 bg-red-50' : 'border-purple-100' }}">
                    <label class="block text-sm font-bold text-gray-900 mb-3">
                        <span class="inline-flex items-center justify-center w-6 h-6 bg-purple-600 text-white rounded-full text-xs mr-2">1</span>
                        Pregunta 1:
                    </label>
                    <p class="text-gray-700 mb-4 font-medium pl-8">{{ $pregunta1 }}</p>
                    <input type="text" name="respuesta_1" value="{{ old('respuesta_1') }}" required autofocus
                        class="w-full px-4 py-3 border-2 rounded-xl focus:ring-2 focus:ring-purple-500 transition-all {{ $errors->has('respuestas') ? 'border-red-400 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-purple-500' }}"
                        placeholder="Tu respuesta">
                </div>

                <!-- Pregunta 2 -->
                <div class="mb-8 bg-purple-50 rounded-2xl p-6 border-2 transition-all {{ $errors->has('respuestas') ? 'border-red-300 bg-red-50' : 'border-purple-100' }}">
                    <label class="block text-sm font-bold text-gray-900 mb-3">
                        <span class="inline-flex items-center justify-center w-6 h-6 bg-purple-600 text-white rounded-full text-xs mr-2">2</span>
                        Pregunta 2:
                    </label>
                    <p class="text-gray-700 mb-4 font-medium pl-8">{{ $pregunta2 }}</p>
                    <input type="text" name="respuesta_2" value="{{ old('respuesta_2') }}" required
                        class="w-full px-4 py-3 border-2 rounded-xl focus:ring-2 focus:ring-purple-500 transition-all {{ $errors->has('respuestas') ? 'border-red-400 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-purple-500' }}"
                        placeholder="Tu respuesta">
                </div>

                <button type="submit" 
                    class="w-full px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300">
                    <span class="flex items-center justify-center">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Verificar Respuestas
                    </span>
                </button>

                <div class="mt-6 text-center space-y-2">
                    <a href="{{ route('password.security.identify') }}" class="block text-sm text-purple-600 hover:text-purple-800 font-semibold">
                        ← Intentar con otro usuario
                    </a>
                    <a href="{{ route('login') }}" class="block text-sm text-gray-600 hover:text-gray-900">
                        Volver al inicio de sesión
                    </a>
                </div>
            </form>

        </div>
    </div>

    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        .animate-shake {
            animation: shake 0.5s;
        }
    </style>

</body>
</html>