@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-indigo-950" x-data="{ activeTab: 'overview' }">
    
    <!-- Header con Gradiente -->
    <div class="bg-gradient-to-r from-red-500 via-pink-600 to-purple-600 p-8 shadow-2xl">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="bg-white/20 rounded-full p-4 backdrop-blur-sm">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-black text-white">👑 Panel de Administración</h1>
                        <p class="text-white/90 text-lg font-medium mt-1">Bienvenido al panel de control del Super Admin</p>
                    </div>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-2xl px-6 py-3">
                    <div class="flex items-center space-x-3">
                        <div class="text-right">
                            <p class="text-white text-sm font-medium">{{ Auth::user()->nombre_completo }}</p>
                            <p class="text-white/80 text-xs">Super Administrador</p>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center text-white text-lg font-bold shadow-lg">
                            {{ strtoupper(substr(Auth::user()->nombre_completo ?? 'SA', 0, 2)) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fecha y Hora -->
            <div class="mt-4 flex items-center space-x-4 text-white/90">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-sm font-medium">📅 {{ now()->format('d/m/Y') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium">🕐 {{ now()->format('H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sistema de Pestañas -->
    <div class="bg-gray-800 border-b border-gray-700 sticky top-0 z-40 shadow-lg">
        <div class="max-w-7xl mx-auto">
            <div class="flex space-x-1 overflow-x-auto px-4 py-2">
                <!-- Tab Resumen -->
                <button @click="activeTab = 'overview'" 
                        :class="activeTab === 'overview' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-gray-700'"
                        class="flex items-center space-x-2 px-6 py-3 rounded-xl transition-all duration-200 font-bold whitespace-nowrap">
                    <span class="text-xl">📊</span>
                    <span>Resumen</span>
                </button>

                <!-- Tab Presidente -->
                <button @click="activeTab = 'presidente'" 
                        :class="activeTab === 'presidente' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-gray-700'"
                        class="flex items-center space-x-2 px-6 py-3 rounded-xl transition-all duration-200 font-bold whitespace-nowrap">
                    <span class="text-xl">👔</span>
                    <span>Presidente</span>
                </button>

                <!-- Tab Vicepresidente -->
                <button @click="activeTab = 'vicepresidente'" 
                        :class="activeTab === 'vicepresidente' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-gray-700'"
                        class="flex items-center space-x-2 px-6 py-3 rounded-xl transition-all duration-200 font-bold whitespace-nowrap">
                    <span class="text-xl">🎩</span>
                    <span>Vicepresidente</span>
                </button>

                <!-- Tab Tesorero -->
                <button @click="activeTab = 'tesorero'" 
                        :class="activeTab === 'tesorero' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-gray-700'"
                        class="flex items-center space-x-2 px-6 py-3 rounded-xl transition-all duration-200 font-bold whitespace-nowrap">
                    <span class="text-xl">💰</span>
                    <span>Tesorero</span>
                </button>

                <!-- Tab Secretaria -->
                <button @click="activeTab = 'secretaria'" 
                        :class="activeTab === 'secretaria' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-gray-700'"
                        class="flex items-center space-x-2 px-6 py-3 rounded-xl transition-all duration-200 font-bold whitespace-nowrap">
                    <span class="text-xl">📝</span>
                    <span>Secretaría</span>
                </button>

                <!-- Tab Macero -->
                <button @click="activeTab = 'macero'" 
                        :class="activeTab === 'macero' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-gray-700'"
                        class="flex items-center space-x-2 px-6 py-3 rounded-xl transition-all duration-200 font-bold whitespace-nowrap">
                    <span class="text-xl">📅</span>
                    <span>Macero</span>
                </button>

                <!-- Tab Socio -->
                <button @click="activeTab = 'socio'" 
                        :class="activeTab === 'socio' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-gray-700'"
                        class="flex items-center space-x-2 px-6 py-3 rounded-xl transition-all duration-200 font-bold whitespace-nowrap">
                    <span class="text-xl">🎓</span>
                    <span>Socio</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Contenido de las Pestañas -->
    <div class="px-4 py-6">

        <!-- TAB: RESUMEN (Dashboard actual) -->
        <div x-show="activeTab === 'overview'" x-transition class="space-y-6">
            @include('modulos.admin.partials.overview')
        </div>

        <!-- TAB: PRESIDENTE -->
        <div x-show="activeTab === 'presidente'" x-transition x-cloak>
            <div class="bg-gray-800 rounded-2xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-pink-600 p-4">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <span class="text-3xl mr-3">👔</span>
                        Módulo de Presidente
                    </h2>
                </div>
                <div class="iframe-container">
                    <iframe src="{{ route('presidente.dashboard') }}" 
                            class="w-full border-0 iframe-full"
                            sandbox="allow-same-origin allow-scripts allow-forms allow-popups allow-modals allow-downloads"></iframe>
                </div>
            </div>
        </div>

        <!-- TAB: VICEPRESIDENTE -->
        <div x-show="activeTab === 'vicepresidente'" x-transition x-cloak>
            <div class="bg-gray-800 rounded-2xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-4">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <span class="text-3xl mr-3">🎩</span>
                        Módulo de Vicepresidente
                    </h2>
                </div>
                <div class="iframe-container">
                    <iframe src="{{ route('vicepresidente.dashboard') }}" 
                            class="w-full border-0 iframe-full"
                            sandbox="allow-same-origin allow-scripts allow-forms allow-popups allow-modals allow-downloads"></iframe>
                </div>
            </div>
        </div>

        <!-- TAB: TESORERO -->
        <div x-show="activeTab === 'tesorero'" x-transition x-cloak>
            <div class="bg-gray-800 rounded-2xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 p-4">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <span class="text-3xl mr-3">💰</span>
                        Módulo de Tesorero
                    </h2>
                </div>
                <div class="iframe-container">
                    <iframe src="{{ route('tesorero.dashboard') }}" 
                            class="w-full border-0 iframe-full"
                            sandbox="allow-same-origin allow-scripts allow-forms allow-popups allow-modals allow-downloads"></iframe>
                </div>
            </div>
        </div>

        <!-- TAB: SECRETARIA -->
        <div x-show="activeTab === 'secretaria'" x-transition x-cloak>
            <div class="bg-gray-800 rounded-2xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-pink-600 to-rose-600 p-4">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <span class="text-3xl mr-3">📝</span>
                        Módulo de Secretaría
                    </h2>
                </div>
                <div class="iframe-container">
                    <iframe src="{{ route('secretaria.dashboard') }}" 
                            class="w-full border-0 iframe-full"
                            sandbox="allow-same-origin allow-scripts allow-forms allow-popups allow-modals allow-downloads"></iframe>
                </div>
            </div>
        </div>

        <!-- TAB: MACERO -->
        <div x-show="activeTab === 'macero'" x-transition x-cloak>
            <div class="bg-gray-800 rounded-2xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-orange-600 to-red-600 p-4">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <span class="text-3xl mr-3">📅</span>
                        Módulo de Macero
                    </h2>
                </div>
                <div class="iframe-container">
                    <iframe src="{{ route('vocero.dashboard') }}" 
                            class="w-full border-0 iframe-full"
                            sandbox="allow-same-origin allow-scripts allow-forms allow-popups allow-modals allow-downloads"></iframe>
                </div>
            </div>
        </div>

        <!-- TAB: SOCIO -->
        <div x-show="activeTab === 'socio'" x-transition x-cloak>
            <div class="bg-gray-800 rounded-2xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-cyan-600 to-blue-600 p-4">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <span class="text-3xl mr-3">🎓</span>
                        Módulo de Socio
                    </h2>
                </div>
                <div class="iframe-container">
                    <iframe src="{{ route('socio.dashboard') }}" 
                            class="w-full border-0 iframe-full"
                            sandbox="allow-same-origin allow-scripts allow-forms allow-popups allow-modals allow-downloads"></iframe>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    /* Ocultar elementos con x-cloak hasta que Alpine.js esté listo */
    [x-cloak] { 
        display: none !important; 
    }
    
    /* Contenedor de iframe con altura dinámica */
    .iframe-container {
        position: relative;
        width: 100%;
        height: calc(100vh - 250px); /* Altura de viewport menos header y tabs */
        min-height: 800px; /* Altura mínima para que los calendarios se vean bien */
        background: white;
        overflow: hidden;
    }
    
    /* Iframe que ocupa todo el contenedor */
    .iframe-full {
        width: 100%;
        height: 100%;
        border: none;
        display: block;
    }
    
    /* Scroll suave en pestañas */
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: rgba(31, 41, 55, 0.5);
        border-radius: 10px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: rgba(139, 92, 246, 0.5);
        border-radius: 10px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: rgba(139, 92, 246, 0.8);
    }

    /* Hacer que el contenido sea responsive */
    @media (max-width: 768px) {
        .iframe-container {
            height: calc(100vh - 300px);
            min-height: 600px;
        }
    }
</style>

<script>
    // Script para ajustar dinámicamente la altura del iframe según su contenido
    document.addEventListener('DOMContentLoaded', function() {
        const iframes = document.querySelectorAll('.iframe-full');
        
        iframes.forEach(iframe => {
            iframe.addEventListener('load', function() {
                try {
                    // Intentar ajustar la altura según el contenido del iframe
                    const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                    const height = iframeDoc.body.scrollHeight;
                    
                    if (height > 800) {
                        iframe.style.height = height + 'px';
                    }
                } catch(e) {
                    // Si hay error de CORS, mantener altura por defecto
                    console.log('No se puede ajustar altura del iframe (CORS)');
                }
            });
        });
    });
</script>
@endsection
