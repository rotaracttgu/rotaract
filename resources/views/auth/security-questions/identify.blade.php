<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Preguntas de Seguridad</title>
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
            border: none;
            max-width: 450px;
            width: 100%;
            padding: 2.5rem;
            margin: 0 auto;
            transition: all 0.3s ease;
        }
        .card-custom:hover {
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
            transform: translateY(-5px);
        }
        .btn-custom {
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 50%, #3b82f6 100%);
            border: none;
            color: #ffffff;
            padding: 1rem 2rem;
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
        .btn-custom:active {
            transform: translateY(0);
        }
        .input-custom {
            border: 2px solid #e5e7eb;
            border-radius: 1rem;
            padding: 1rem 1rem 1rem 3rem;
            width: 100%;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        .input-custom:focus {
            border-color: #8b5cf6;
            outline: none;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            transition: color 0.3s ease;
        }
        .input-custom:focus + .input-icon {
            color: #8b5cf6;
        }
        .error-alert {
            border-left: 4px solid #ef4444;
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border-radius: 1rem;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px rgba(239, 68, 68, 0.1);
        }
        .gradient-text {
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 50%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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
        .logo-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .logo-header img {
            max-width: 190px;
            width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
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
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <main role="main" aria-labelledby="page-title" class="w-full max-w-md">
        <div class="card-custom">
            <header class="text-center">
                <div class="logo-header">
                    <img src="{{ asset('images/LogoRotaract.png') }}" alt="Rotaract Club Tegucigalpa Sur">
                </div>
                <p class="text-gray-600 mt-3 font-medium">Usando preguntas de seguridad</p>
            </header>

            <form action="{{ route('password.security.questions') }}" method="POST" class="mt-8 space-y-6" novalidate>
                @csrf

                @if ($errors->any())
                    <div class="error-alert" role="alert" aria-live="assertive">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-red-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-bold text-red-800 text-base">⚠️ Se encontraron errores</p>
                                <ul class="mt-2 list-disc list-inside text-red-700 text-sm space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="space-y-3">
                    <label for="identifier" class="block text-sm font-bold text-gray-800">
                        📧 Email o Usuario
                    </label>
                    <div class="relative">
                        <input id="identifier" 
                               type="text" 
                               name="identifier" 
                               value="{{ old('identifier') }}" 
                               required 
                               autofocus
                               class="input-custom placeholder-gray-400"
                               placeholder="ejemplo@correo.com o usuario123" 
                               aria-describedby="identifier-help">
                        <span class="input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                    </div>
                    <p id="identifier-help" class="text-xs text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Introduce tu email o usuario registrado
                    </p>
                </div>

                <button type="submit"
                    class="btn-custom w-full flex items-center justify-center gap-3 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-300 transition-all duration-300"
                    aria-label="Continuar con preguntas de seguridad">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                    Continuar
                </button>

                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center text-sm font-semibold text-purple-600 hover:text-purple-800 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Volver al inicio de sesión
                    </a>
                </div>

                <div class="mt-6 p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border-2 border-purple-100">
                    <p class="text-xs text-gray-700 text-center font-medium flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        🔒 No compartas tus respuestas con nadie
                    </p>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
