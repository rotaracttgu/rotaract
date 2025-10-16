<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Preguntas de Seguridad</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                <div class="flex items-center justify-center">
                    <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white text-center mt-4">Recuperar Contraseña</h2>
                <p class="text-blue-100 text-center text-sm mt-2">Usando preguntas de seguridad</p>
            </div>

            <!-- Form -->
            <form action="{{ route('password.security.questions') }}" method="POST" class="p-8">
                @csrf

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-600 rounded-lg p-4">
                        <p class="text-sm text-red-700">{{ $errors->first() }}</p>
                    </div>
                @endif

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Email o Nombre de Usuario
                    </label>
                    <input type="text" name="identifier" value="{{ old('identifier') }}" required autofocus
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        placeholder="ejemplo@correo.com o usuario123">
                </div>

                <button type="submit" 
                    class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300">
                    Continuar
                </button>

                <div class="mt-6 text-center space-y-2">
                    <a href="{{ route('login') }}" class="block text-sm text-gray-600 hover:text-gray-900">
                        ← Volver al inicio de sesión
                    </a>
                </div>
            </form>

        </div>
    </div>

</body>
</html>