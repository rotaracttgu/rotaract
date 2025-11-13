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

                <!-- Tab Usuarios -->
                <button @click="activeTab = 'usuarios'" 
                        :class="activeTab === 'usuarios' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-gray-700'"
                        class="flex items-center space-x-2 px-6 py-3 rounded-xl transition-all duration-200 font-bold whitespace-nowrap">
                    <span class="text-xl">👥</span>
                    <span>Gestión de Usuarios</span>
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

                <!-- Tab Vocero -->
                <button @click="activeTab = 'vocero'" 
                        :class="activeTab === 'vocero' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-gray-700'"
                        class="flex items-center space-x-2 px-6 py-3 rounded-xl transition-all duration-200 font-bold whitespace-nowrap">
                    <span class="text-xl">📅</span>
                    <span>Vocero (Macero)</span>
                </button>

                <!-- Tab Socios -->
                <button @click="activeTab = 'socios'" 
                        :class="activeTab === 'socios' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-gray-700'"
                        class="flex items-center space-x-2 px-6 py-3 rounded-xl transition-all duration-200 font-bold whitespace-nowrap">
                    <span class="text-xl">🎓</span>
                    <span>Socios/Aspirantes</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Contenido de las Pestañas -->
    <div class="max-w-7xl mx-auto px-4 py-8">

        <!-- TAB: RESUMEN (Dashboard actual) -->
        <div x-show="activeTab === 'overview'" x-transition class="space-y-6">
            @include('modulos.admin.partials.overview')
        </div>

        <!-- TAB: USUARIOS -->
        <div x-show="activeTab === 'usuarios'" x-transition>
            <div class="bg-gray-800 rounded-2xl shadow-xl p-6">
                <h2 class="text-2xl font-bold text-white mb-4">👥 Gestión de Usuarios</h2>
                <p class="text-gray-400 mb-6">Administra todos los usuarios del sistema desde aquí</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    <a href="{{ route('admin.usuarios.lista') }}" class="bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 rounded-xl p-6 text-white transition-all transform hover:scale-105">
                        <div class="flex items-center space-x-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <div>
                                <h3 class="text-lg font-bold">Ver Usuarios</h3>
                                <p class="text-sm text-white/80">Lista completa</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.usuarios.crear') }}" class="bg-gradient-to-r from-green-600 to-teal-700 hover:from-green-700 hover:to-teal-800 rounded-xl p-6 text-white transition-all transform hover:scale-105">
                        <div class="flex items-center space-x-3">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <h3 class="text-lg font-bold">Crear Usuario</h3>
                                <p class="text-sm text-white/80">Nuevo registro</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.usuarios-bloqueados.index') }}" class="bg-gradient-to-r from-red-600 to-pink-700 hover:from-red-700 hover:to-pink-800 rounded-xl p-6 text-white transition-all transform hover:scale-105">
                        <div class="flex items-center space-x-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <div>
                                <h3 class="text-lg font-bold">Bloqueados</h3>
                                <p class="text-sm text-white/80">Gestionar accesos</p>
                            </div>
                        </div>
                    </a>
                </div>

                <iframe src="{{ route('admin.usuarios.lista') }}" class="w-full h-screen rounded-xl border-4 border-gray-700"></iframe>
            </div>
        </div>

        <!-- TAB: PRESIDENTE -->
        <div x-show="activeTab === 'presidente'" x-transition>
            <div class="bg-gray-800 rounded-2xl shadow-xl p-6">
                <h2 class="text-2xl font-bold text-white mb-4">👔 Módulo de Presidente</h2>
                <p class="text-gray-400 mb-6">Accede a todas las funciones del módulo de Presidente</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <a href="{{ route('presidente.dashboard') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 rounded-xl p-4 text-white transition-all transform hover:scale-105">
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <h3 class="font-bold">Dashboard</h3>
                        </div>
                    </a>

                    <a href="{{ route('presidente.cartas.formales') }}" class="bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 rounded-xl p-4 text-white transition-all transform hover:scale-105">
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="font-bold">Cartas Formales</h3>
                        </div>
                    </a>

                    <a href="{{ route('presidente.cartas.patrocinio') }}" class="bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 rounded-xl p-4 text-white transition-all transform hover:scale-105">
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="font-bold">Patrocinios</h3>
                        </div>
                    </a>

                    <a href="{{ route('presidente.estado.proyectos') }}" class="bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 rounded-xl p-4 text-white transition-all transform hover:scale-105">
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <h3 class="font-bold">Proyectos</h3>
                        </div>
                    </a>
                </div>

                <iframe src="{{ route('presidente.dashboard') }}" class="w-full h-screen rounded-xl border-4 border-gray-700"></iframe>
            </div>
        </div>

        <!-- TAB: VICEPRESIDENTE -->
        <div x-show="activeTab === 'vicepresidente'" x-transition>
            <div class="bg-gray-800 rounded-2xl shadow-xl p-6">
                <h2 class="text-2xl font-bold text-white mb-4">🎩 Módulo de Vicepresidente</h2>
                <p class="text-gray-400 mb-6">Funciones del Vicepresidente</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <a href="{{ route('vicepresidente.dashboard') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="font-bold">Dashboard</h3>
                    </a>

                    <a href="{{ route('vicepresidente.cartas.formales') }}" class="bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="font-bold">Cartas</h3>
                    </a>

                    <a href="{{ route('vicepresidente.estado.proyectos') }}" class="bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="font-bold">Proyectos</h3>
                    </a>

                    <a href="{{ route('vicepresidente.usuarios.lista') }}" class="bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <h3 class="font-bold">Usuarios</h3>
                    </a>
                </div>

                <iframe src="{{ route('vicepresidente.dashboard') }}" class="w-full h-screen rounded-xl border-4 border-gray-700"></iframe>
            </div>
        </div>

        <!-- TAB: TESORERO -->
        <div x-show="activeTab === 'tesorero'" x-transition>
            <div class="bg-gray-800 rounded-2xl shadow-xl p-6">
                <h2 class="text-2xl font-bold text-white mb-4">💰 Módulo de Tesorero</h2>
                <p class="text-gray-400 mb-6">Gestión financiera del club</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <a href="{{ route('tesorero.dashboard') }}" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        <h3 class="font-bold">Dashboard</h3>
                    </a>

                    <a href="{{ route('tesorero.ingresos.index') }}" class="bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="font-bold">Ingresos</h3>
                    </a>

                    <a href="{{ route('tesorero.gastos.index') }}" class="bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h3 class="font-bold">Gastos</h3>
                    </a>

                    <a href="{{ route('tesorero.reportes.index') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="font-bold">Reportes</h3>
                    </a>
                </div>

                <iframe src="{{ route('tesorero.dashboard') }}" class="w-full h-screen rounded-xl border-4 border-gray-700"></iframe>
            </div>
        </div>

        <!-- TAB: SECRETARIA -->
        <div x-show="activeTab === 'secretaria'" x-transition>
            <div class="bg-gray-800 rounded-2xl shadow-xl p-6">
                <h2 class="text-2xl font-bold text-white mb-4">📝 Módulo de Secretaría</h2>
                <p class="text-gray-400 mb-6">Gestión documental y comunicaciones</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <a href="{{ route('secretaria.dashboard') }}" class="bg-gradient-to-r from-pink-600 to-rose-600 hover:from-pink-700 hover:to-rose-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="font-bold">Dashboard</h3>
                    </a>

                    <a href="{{ route('secretaria.actas.index') }}" class="bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="font-bold">Actas</h3>
                    </a>

                    <a href="{{ route('secretaria.diplomas.index') }}" class="bg-gradient-to-r from-yellow-600 to-orange-600 hover:from-yellow-700 hover:to-orange-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                        <h3 class="font-bold">Diplomas</h3>
                    </a>

                    <a href="{{ route('secretaria.consultas') }}" class="bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <h3 class="font-bold">Consultas</h3>
                    </a>
                </div>

                <iframe src="{{ route('secretaria.dashboard') }}" class="w-full h-screen rounded-xl border-4 border-gray-700"></iframe>
            </div>
        </div>

        <!-- TAB: VOCERO -->
        <div x-show="activeTab === 'vocero'" x-transition>
            <div class="bg-gray-800 rounded-2xl shadow-xl p-6">
                <h2 class="text-2xl font-bold text-white mb-4">📅 Módulo de Vocero (Macero)</h2>
                <p class="text-gray-400 mb-6">Gestión de eventos y calendario</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <a href="{{ route('vocero.dashboard') }}" class="bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="font-bold">Dashboard</h3>
                    </a>

                    <a href="{{ route('vocero.calendario') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="font-bold">Calendario</h3>
                    </a>

                    <a href="{{ route('vocero.eventos') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                        </svg>
                        <h3 class="font-bold">Eventos</h3>
                    </a>

                    <a href="{{ route('vocero.reportes') }}" class="bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="font-bold">Reportes</h3>
                    </a>
                </div>

                <iframe src="{{ route('vocero.dashboard') }}" class="w-full h-screen rounded-xl border-4 border-gray-700"></iframe>
            </div>
        </div>

        <!-- TAB: SOCIOS -->
        <div x-show="activeTab === 'socios'" x-transition>
            <div class="bg-gray-800 rounded-2xl shadow-xl p-6">
                <h2 class="text-2xl font-bold text-white mb-4">🎓 Módulo de Socios/Aspirantes</h2>
                <p class="text-gray-400 mb-6">Portal para miembros del club</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <a href="{{ route('socio.dashboard') }}" class="bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="font-bold">Dashboard</h3>
                    </a>

                    <a href="{{ route('socio.calendario') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="font-bold">Calendario</h3>
                    </a>

                    <a href="{{ route('socio.proyectos') }}" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="font-bold">Proyectos</h3>
                    </a>

                    <a href="{{ route('socio.notas.index') }}" class="bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 rounded-xl p-4 text-white transition-all transform hover:scale-105 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <h3 class="font-bold">Blog</h3>
                    </a>
                </div>

                <iframe src="{{ route('socio.dashboard') }}" class="w-full h-screen rounded-xl border-4 border-gray-700"></iframe>
            </div>
        </div>

    </div>
</div>

<style>
    /* Animaciones suaves */
    [x-cloak] { display: none !important; }
    
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
</style>
@endsection
