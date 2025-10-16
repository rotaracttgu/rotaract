<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-2xl">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-8">
                <div class="text-center">
                    <svg class="h-16 w-16 text-white mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <h1 class="text-3xl font-black text-white">Recuperar Contraseña</h1>
                    <p class="text-blue-100 mt-2">Elige cómo deseas recuperar tu cuenta</p>
                </div>
            </div>

            <!-- Opciones -->
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Opción 1: Por Email -->
                <a href="{{ route('password.request') }}" 
                    class="group block p-8 bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-2xl border-2 border-blue-200 hover:border-blue-400 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                    <div class="text-center">
                        <div class="bg-blue-600 text-white rounded-full p-4 inline-flex mb-4 group-hover:scale-110 transition-transform">
                            <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Por Correo Electrónico</h3>
                        <p class="text-sm text-gray-600 mb-4">Recibirás un enlace para restablecer tu contraseña en tu email</p>
                        <span class="inline-flex items-center text-blue-600 font-semibold text-sm group-hover:text-blue-700">
                            Continuar
                            <svg class="h-4 w-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>
                </a>

                <!-- Opción 2: Por Preguntas -->
                <a href="{{ route('password.security.identify') }}" 
                    class="group block p-8 bg-gradient-to-br from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 rounded-2xl border-2 border-purple-200 hover:border-purple-400 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                    <div class="text-center">
                        <div class="bg-purple-600 text-white rounded-full p-4 inline-flex mb-4 group-hover:scale-110 transition-transform">
                            <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Preguntas de Seguridad</h3>
                        <p class="text-sm text-gray-600 mb-4">Responde tus preguntas de seguridad para restablecer tu contraseña</p>
                        <span class="inline-flex items-center text-purple-600 font-semibold text-sm group-hover:text-purple-700">
                            Continuar
                            <svg class="h-4 w-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>
                </a>

            </div>

            <!-- Footer -->
            <div class="px-8 pb-8 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 font-semibold">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver al inicio de sesión
                </a>
            </div>

        </div>
    </div>

</body>
</html>