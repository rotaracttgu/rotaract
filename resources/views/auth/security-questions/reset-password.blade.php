<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nueva Contraseña</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .logo-pink {
            filter: grayscale(1) sepia(1) saturate(6) hue-rotate(-320deg) brightness(1.05);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6" style="background: linear-gradient(135deg,#eef2ff 0%, #e9d5ff 100%);">

    <div class="w-72 sm:w-80">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden ring-1 ring-indigo-50">
            
            <!-- Encabezado -->
            <div class="p-6 text-center">
                <div class="mx-auto h-16 w-16 rounded-full bg-pink-100 flex items-center justify-center mb-3">
                    <img src="{{ asset('images/Logo_Rotarac.webp') }}" alt="Rotaract" class="h-12 w-auto logo-pink" />
                </div>
                <h2 class="text-xl font-semibold text-gray-800">¡Respuestas Correctas!</h2>
                <p class="text-sm text-gray-500 mt-1">Ahora puedes crear una nueva contraseña</p>
            </div>

            <!-- Formulario -->
            <form action="{{ route('password.security.reset') }}" method="POST" class="px-6 pb-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border-l-4 border-red-600 rounded-md p-3">
                        <ul class="list-disc list-inside text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Nueva Contraseña -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña</label>
                    <div class="relative">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow"
                               placeholder="********">
                        <button type="button" 
                                onclick="togglePassword('password')" 
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Mínimo 8 caracteres con mayúsculas, minúsculas y números</p>
                </div>

                <!-- Confirmar Contraseña -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña</label>
                    <div class="relative">
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow"
                               placeholder="********">
                        <button type="button" 
                                onclick="togglePassword('password_confirmation')" 
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-lg border-2 border-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Restablecer Contraseña
                </button>
            </form>

        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>
</html>