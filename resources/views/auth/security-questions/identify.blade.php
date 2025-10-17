
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Preguntas de Seguridad</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Tinte rosado suave para el logo (combinado con el fondo rosa del contenedor) */
        .logo-pink {
            filter: grayscale(1) sepia(1) saturate(6) hue-rotate(-320deg) brightness(1.05);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6" style="background: linear-gradient(135deg,#eef2ff 0%, #e9d5ff 100%);">

    <main role="main" aria-labelledby="page-title" class="w-full flex items-center justify-center">
        <!-- Card cuadrado centrado -->
        <div class="w-72 h-72 sm:w-80 sm:h-80 md:w-80 md:h-80 bg-white rounded-2xl shadow-2xl p-6 flex flex-col justify-between items-stretch overflow-hidden ring-1 ring-indigo-100">
            <header class="text-center">
                <!-- Logo dentro de círculo rosado para asegurar apariencia rosada (aumentado) -->
                <div class="mx-auto h-22 w-22 rounded-full bg-pink-100 flex items-center justify-center mb-3">
                    <img src="{{ asset('images/Logo_Rotarac.webp') }}" alt="Rotaract" class="h-12 w-auto logo-pink" />
                </div>

                <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-indigo-600/10 mx-auto">
                    <svg class="h-6 w-6 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h1 id="page-title" class="text-base sm:text-lg font-semibold text-gray-800 mt-2">Recuperar Contraseña</h1>
                <p class="text-xs text-gray-500 mt-1">Usando preguntas de seguridad</p>
            </header>

            <form action="{{ route('password.security.questions') }}" method="POST" class="mt-2 flex-1 flex flex-col justify-center" novalidate>
                @csrf

                @if ($errors->any())
                    <div class="mb-2 bg-red-50 border-l-4 border-red-600 rounded-md p-2 text-xs" role="alert" aria-live="assertive">
                        <p class="font-medium text-red-700">Se encontraron errores</p>
                        <ul class="mt-1 list-disc list-inside text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-2">
                    <label for="identifier" class="block text-xs font-medium text-gray-700 mb-1">Email o Usuario</label>
                    <div class="relative">
                        <input id="identifier" type="text" name="identifier" value="{{ old('identifier') }}" required autofocus
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                            placeholder="ejemplo@correo.com o usuario123" aria-describedby="identifier-help">
                        <span class="absolute right-2 top-2 text-gray-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 10-8 0v4" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21h18" />
                            </svg>
                        </span>
                    </div>
                    <p id="identifier-help" class="mt-1 text-xs text-gray-400">Introduce tu email o usuario.</p>
                </div>

                <button type="submit"
                    class="mt-2 w-full flex items-center justify-center gap-2 px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-lg border-2 border-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200"
                    aria-label="Continuar con preguntas de seguridad">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                    </svg>
                    Continuar
                </button>

                <div class="mt-2 text-center">
                    <a href="{{ route('login') }}" class="text-xs text-gray-600 hover:text-gray-900">← Volver al inicio de sesión</a>
                </div>

                <p class="mt-2 text-2xs text-gray-400 text-center">No compartas tus respuestas con nadie.</p>
            </form>
        </div>
    </main>

</body>
</html>
