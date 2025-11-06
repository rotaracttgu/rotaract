<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas de Seguridad</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
        }
        .card-custom {
            background: #ffffff;
            border-radius: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .card-custom:hover {
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
            transform: translateY(-5px);
        }
        .logo-circle {
            width: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }
        .logo-pink {
            max-width: 150px;
            width: 100%;
            height: auto;
            filter: 
                brightness(0) 
                saturate(100%) 
                invert(24%) 
                sepia(98%) 
                saturate(3500%) 
                hue-rotate(330deg) 
                brightness(90%) 
                contrast(92%);
        }
        .btn-custom {
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 50%, #3b82f6 100%);
            border: none;
            color: #ffffff;
            padding: 0.875rem 2rem;
            border-radius: 1rem;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4);
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(139, 92, 246, 0.5);
            background: linear-gradient(135deg, #db2777 0%, #7c3aed 50%, #2563eb 100%);
        }
        .input-custom {
            border: 2px solid #e5e7eb;
            border-radius: 1rem;
            padding: 0.875rem 1rem;
            width: 100%;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        .input-custom:focus {
            border-color: #8b5cf6;
            outline: none;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }
        .error-alert {
            border-left: 4px solid #ef4444;
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border-radius: 1rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px rgba(239, 68, 68, 0.1);
            animation: shake 0.5s;
        }
        .badge-number {
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.85rem;
            margin-right: 0.5rem;
            box-shadow: 0 4px 6px rgba(139, 92, 246, 0.3);
        }
        .gradient-text {
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 50%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .card-custom {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

    <main role="main" aria-labelledby="page-title" class="w-full flex items-center justify-center">
        <div class="w-full max-w-md card-custom">
            <header class="text-center px-6 pt-8 pb-6">
                <div class="logo-circle">
                    <img src="{{ asset('images/LogoRotaract.png') }}" alt="Rotaract" class="logo-pink" />
                </div>
                <h1 id="page-title" class="text-2xl font-black gradient-text mt-4">
                    🔒 Preguntas de Seguridad
                </h1>
                <p class="text-sm text-gray-600 mt-2 font-medium">Responde correctamente para continuar</p>
            </header>

            <form action="{{ route('password.security.verify') }}" method="POST" class="px-6 pb-8">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                @if ($errors->has('respuestas'))
                    <div class="error-alert">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-red-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-bold text-red-800 text-sm">⚠️ Error en las respuestas</p>
                                <p class="text-xs text-red-700 mt-1">Las respuestas proporcionadas no son correctas. Intenta nuevamente.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Pregunta 1 -->
                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-800 mb-2">
                        <span class="badge-number">1</span>
                        {{ $pregunta1 }}
                    </label>
                    <input type="text" 
                           name="respuesta_1" 
                           value="{{ old('respuesta_1') }}" 
                           required 
                           autofocus
                           class="input-custom placeholder-gray-400"
                           placeholder="Escribe tu respuesta aquí">
                </div>

                <!-- Pregunta 2 -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-800 mb-2">
                        <span class="badge-number">2</span>
                        {{ $pregunta2 }}
                    </label>
                    <input type="text" 
                           name="respuesta_2" 
                           value="{{ old('respuesta_2') }}" 
                           required
                           class="input-custom placeholder-gray-400"
                           placeholder="Escribe tu respuesta aquí">
                </div>

                <button type="submit"
                    class="btn-custom w-full flex items-center justify-center gap-3 focus:outline-none focus:ring-4 focus:ring-purple-300 transition-all duration-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Verificar Respuestas
                </button>

                <div class="mt-6 space-y-3">
                    <div class="flex items-center justify-center space-x-4 text-xs">
                        <a href="{{ route('password.security.identify') }}" 
                           class="inline-flex items-center font-semibold text-purple-600 hover:text-purple-800 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Otro usuario
                        </a>
                        <span class="text-gray-400">|</span>
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center font-semibold text-gray-600 hover:text-gray-900 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Inicio de sesión
                        </a>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border-2 border-purple-100">
                    <p class="text-xs text-gray-700 text-center font-medium flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        💡 Las respuestas distinguen mayúsculas y minúsculas
                    </p>
                </div>
            </form>
        </div>
    </main>

</body>
</html>