<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas de Seguridad</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .logo-pink {
            filter: grayscale(1) sepia(1) saturate(6) hue-rotate(-320deg) brightness(1.05);
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        .animate-shake {
            animation: shake 0.5s;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6" style="background: linear-gradient(135deg,#eef2ff 0%, #e9d5ff 100%);">

    <main role="main" aria-labelledby="page-title" class="w-full flex items-center justify-center">
        <!-- Card cuadrada y angosta -->
        <div class="w-72 sm:w-80 bg-white rounded-2xl shadow-2xl overflow-hidden ring-1 ring-indigo-100">
            <header class="text-center p-4">
                <!-- Logo con círculo rosado -->
                <div class="mx-auto h-22 w-22 rounded-full bg-pink-100 flex items-center justify-center mb-3">
                    <img src="{{ asset('images/Logo_Rotarac.webp') }}" alt="Rotaract" class="h-12 w-auto logo-pink" />
                </div>
                <h1 id="page-title" class="text-lg font-semibold text-gray-800">Preguntas de Seguridad</h1>
                <p class="text-xs text-gray-500 mt-1">Responde correctamente para continuar</p>
            </header>

            <form action="{{ route('password.security.verify') }}" method="POST" class="p-4">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                @if ($errors->has('respuestas'))
                    <div class="mb-3 bg-red-50 border-l-4 border-red-600 rounded-md p-2 text-xs text-red-700 animate-shake">
                        Las respuestas proporcionadas no son correctas. Intenta nuevamente.
                    </div>
                @endif

                <!-- Pregunta 1 -->
                <div class="mb-3">
                    <label class="block text-xs font-medium text-gray-700 mb-1">
                        <span class="inline-flex items-center justify-center w-4 h-4 bg-indigo-600 text-white rounded-full text-xs mr-1">1</span>
                        {{ $pregunta1 }}
                    </label>
                    <input type="text" name="respuesta_1" value="{{ old('respuesta_1') }}" required autofocus
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                        placeholder="Tu respuesta">
                </div>

                <!-- Pregunta 2 -->
                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-700 mb-1">
                        <span class="inline-flex items-center justify-center w-4 h-4 bg-indigo-600 text-white rounded-full text-xs mr-1">2</span>
                        {{ $pregunta2 }}
                    </label>
                    <input type="text" name="respuesta_2" value="{{ old('respuesta_2') }}" required
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                        placeholder="Tu respuesta">
                </div>

                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-lg border-2 border-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Verificar
                </button>

                <div class="mt-3 text-center space-y-1">
                    <a href="{{ route('password.security.identify') }}" class="block text-xs text-indigo-600 hover:text-indigo-800">
                        ← Intentar con otro usuario
                    </a>
                    <a href="{{ route('login') }}" class="block text-xs text-gray-600 hover:text-gray-900">
                        Volver al inicio de sesión
                    </a>
                </div>
            </form>
        </div>
    </main>

</body>
</html>