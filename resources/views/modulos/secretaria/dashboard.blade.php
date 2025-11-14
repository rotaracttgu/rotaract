@extends('layouts.app')

@section('title', 'Panel de Secretaría')

@if(request()->has('embed'))
@push('styles')
<style>
    /* Ocultar solo navbar superior cuando está en iframe */
    body > div > nav, body > nav, [x-data*="open"] { display: none !important; }
</style>
@endpush
@endif

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-md mb-6">
            <div class="bg-gradient-to-r from-purple-600 via-pink-500 to-blue-500 h-2 rounded-t-2xl"></div>
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <!-- Título -->
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent flex items-center gap-3">
                            <i class="fas fa-tachometer-alt"></i>
                            Panel de Secretaría
                        </h1>
                        <p class="text-gray-600 mt-1">Gestión integral de documentos y consultas del club</p>
                    </div>
                    
                    <!-- Botones de Acción -->
                    <div class="flex flex-wrap gap-2 items-center relative z-50">
                        <!-- Actualizar -->
                        <button onclick="window.location.reload()" class="px-4 py-2 bg-gradient-to-r from-sky-400 to-cyan-500 hover:from-sky-500 hover:to-cyan-600 text-white rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                            <i class="fas fa-sync-alt"></i>
                            <span class="hidden sm:inline">Actualizar</span>
                        </button>
                        
                        <!-- Inicio -->
                        <a href="/dashboard" class="px-4 py-2 bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                            <i class="fas fa-home"></i>
                            <span class="hidden sm:inline">Inicio</span>
                        </a>
                        
                        <!-- Crear Nuevo (Dropdown) -->
                        <div x-data="{ open: false }" @click.away="open = false" class="relative">
                            <button @click="open = !open" type="button" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                                <i class="fas fa-plus"></i>
                                <span>Crear Nuevo</span>
                                <i class="fas fa-chevron-down text-sm transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                            </button>
                            
                            <div x-show="open" 
                                x-cloak
                                @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-95"
                                class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-visible z-[9999]"
                                style="position: absolute;">
                                
                                <a href="{{ route('secretaria.actas.index') }}?action=new" class="flex items-center gap-3 px-4 py-3 hover:bg-gradient-to-r hover:from-sky-50 hover:to-cyan-50 transition-colors border-l-4 border-transparent hover:border-sky-500">
                                    <i class="fas fa-file-signature text-sky-500"></i>
                                    <span class="text-gray-700 hover:text-sky-700 font-medium">Nueva Acta</span>
                                </a>
                                
                                <a href="{{ route('secretaria.diplomas.index') }}?action=new" class="flex items-center gap-3 px-4 py-3 hover:bg-gradient-to-r hover:from-amber-50 hover:to-yellow-50 transition-colors border-l-4 border-transparent hover:border-amber-500">
                                    <i class="fas fa-award text-amber-500"></i>
                                    <span class="text-gray-700 hover:text-amber-700 font-medium">Nuevo Diploma</span>
                                </a>
                                
                                <a href="{{ route('secretaria.documentos.index') }}?action=new" class="flex items-center gap-3 px-4 py-3 hover:bg-gradient-to-r hover:from-green-50 hover:to-lime-50 transition-colors border-l-4 border-transparent hover:border-green-500">
                                    <i class="fas fa-file-alt text-green-500"></i>
                                    <span class="text-gray-700 hover:text-green-700 font-medium">Nuevo Documento</span>
                                </a>
                                
                                <a href="{{ route('secretaria.consultas.pendientes') }}?action=new" class="flex items-center gap-3 px-4 py-3 hover:bg-gradient-to-r hover:from-purple-50 hover:to-indigo-50 transition-colors border-l-4 border-transparent hover:border-purple-500">
                                    <i class="fas fa-comment-medical text-purple-500"></i>
                                    <span class="text-gray-700 hover:text-purple-700 font-medium">Nueva Consulta</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjetas Principales con Enlaces Funcionales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            
            <!-- Consultas Pendientes -->
            <a href="{{ route('secretaria.consultas.pendientes') }}" class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-indigo-500 h-1.5"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-600 to-indigo-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-comments text-white text-2xl"></i>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-purple-600 group-hover:translate-x-1 transition-all duration-300"></i>
                    </div>
                    <div class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent mb-2">
                        {{ $consultasPendientes }}
                    </div>
                    <div class="text-gray-600 font-semibold mb-2">Consultas Pendientes</div>
                    <div class="text-sm text-green-600 flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i>
                        <span>+{{ $estadisticas['consultas_hoy'] ?? 0 }} hoy</span>
                    </div>
                </div>
            </a>

            <!-- Actas Registradas -->
            <a href="{{ route('secretaria.actas.index') }}" class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                <div class="bg-gradient-to-r from-sky-500 to-cyan-500 h-1.5"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-sky-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-file-signature text-white text-2xl"></i>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-sky-600 group-hover:translate-x-1 transition-all duration-300"></i>
                    </div>
                    <div class="text-4xl font-bold bg-gradient-to-r from-sky-500 to-cyan-600 bg-clip-text text-transparent mb-2">
                        {{ $estadisticas['total_actas'] ?? 0 }}
                    </div>
                    <div class="text-gray-600 font-semibold mb-2">Actas Registradas</div>
                    <div class="text-sm text-gray-500 flex items-center gap-1">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $estadisticas['actas_este_mes'] ?? 0 }} este mes</span>
                    </div>
                </div>
            </a>

            <!-- Diplomas Emitidos -->
            <a href="{{ route('secretaria.diplomas.index') }}" class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-yellow-500 h-1.5"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-yellow-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-award text-white text-2xl"></i>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-amber-600 group-hover:translate-x-1 transition-all duration-300"></i>
                    </div>
                    <div class="text-4xl font-bold bg-gradient-to-r from-amber-500 to-yellow-600 bg-clip-text text-transparent mb-2">
                        {{ $estadisticas['total_diplomas'] ?? 0 }}
                    </div>
                    <div class="text-gray-600 font-semibold mb-2">Total Diplomas</div>
                    <div class="text-sm text-gray-500 flex items-center gap-1">
                        <i class="fas fa-envelope"></i>
                        <span>{{ $estadisticas['diplomas_enviados'] ?? 0 }} enviados por email</span>
                    </div>
                </div>
            </a>

            <!-- Documentos Archivados -->
            <a href="{{ route('secretaria.documentos.index') }}" class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-lime-500 h-1.5"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-lime-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-folder-open text-white text-2xl"></i>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-green-600 group-hover:translate-x-1 transition-all duration-300"></i>
                    </div>
                    <div class="text-4xl font-bold bg-gradient-to-r from-green-500 to-lime-600 bg-clip-text text-transparent mb-2">
                        {{ $estadisticas['total_documentos'] ?? 0 }}
                    </div>
                    <div class="text-gray-600 font-semibold mb-2">Documentos Archivados</div>
                    <div class="text-sm text-gray-500 flex items-center gap-1">
                        <i class="fas fa-database"></i>
                        <span>{{ $estadisticas['categorias_documentos'] ?? 0 }} categorías</span>
                    </div>
                </div>
            </a>

            <!-- Calendario -->
            <a href="{{ route('secretaria.calendario') }}" class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                <div class="bg-gradient-to-r from-pink-500 to-rose-500 h-1.5"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-rose-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-calendar-alt text-white text-2xl"></i>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-pink-600 group-hover:translate-x-1 transition-all duration-300"></i>
                    </div>
                    <div class="text-4xl font-bold bg-gradient-to-r from-pink-500 to-rose-600 bg-clip-text text-transparent mb-2">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="text-gray-600 font-semibold mb-2">Calendario</div>
                    <div class="text-sm text-gray-500 flex items-center gap-1">
                        <i class="fas fa-clock"></i>
                        <span>Eventos y reuniones</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Sección de Consultas Recientes y Pendientes -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            
            <!-- Consultas Recientes -->
            <a href="{{ route('secretaria.consultas.recientes') }}" class="group bg-white rounded-2xl shadow-md hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-indigo-500 h-1.5"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-indigo-500 rounded-xl flex items-center justify-center shadow-md">
                                <i class="fas fa-clock text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">Consultas Recientes</h3>
                                <p class="text-sm text-gray-500">Últimas consultas recibidas</p>
                            </div>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-purple-600 group-hover:translate-x-1 transition-all duration-300 text-xl"></i>
                    </div>
                    <div class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                        {{ $consultasRecientes->count() }}
                    </div>
                    <div class="text-sm text-gray-600 mt-1">
                        <i class="fas fa-info-circle"></i> Click para ver todas
                    </div>
                </div>
            </a>

            <!-- Consultas Pendientes (alternativa) -->
            <a href="{{ route('secretaria.consultas.pendientes') }}" class="group bg-white rounded-2xl shadow-md hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="bg-gradient-to-r from-pink-500 to-rose-500 h-1.5"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-rose-500 rounded-xl flex items-center justify-center shadow-md">
                                <i class="fas fa-exclamation-circle text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">Pendientes de Atención</h3>
                                <p class="text-sm text-gray-500">Requieren respuesta urgente</p>
                            </div>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 group-hover:text-pink-600 group-hover:translate-x-1 transition-all duration-300 text-xl"></i>
                    </div>
                    <div class="text-3xl font-bold bg-gradient-to-r from-pink-500 to-rose-600 bg-clip-text text-transparent">
                        {{ $consultasPendientes }}
                    </div>
                    <div class="text-sm text-amber-600 mt-1 font-semibold">
                        <i class="fas fa-bell"></i> Atención prioritaria
                    </div>
                </div>
            </a>
        </div>

        <!-- Sección Inferior con Tablas -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Últimas Actas -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-sky-500 to-cyan-500 h-1"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-file-signature text-sky-600"></i>
                            Últimas Actas
                        </h3>
                        <a href="{{ route('secretaria.actas.index') }}" class="text-sky-600 hover:text-sky-700 text-sm font-semibold">Ver todas →</a>
                    </div>
                    
                    <div class="space-y-3">
                        @forelse($actas as $acta)
                        <div class="border-l-4 border-sky-500 pl-3 py-2 hover:bg-sky-50 rounded-r transition-colors">
                            <a href="{{ route('secretaria.actas.index') }}?view={{ $acta->id }}" class="block">
                                <h4 class="font-semibold text-gray-800 text-sm hover:text-sky-600 transition-colors">
                                    {{ Str::limit($acta->titulo ?? 'Sin título', 35) }}
                                </h4>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-xs text-gray-500">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($acta->fecha_reunion)->format('d/m/Y') }}
                                    </span>
                                    @if($acta->archivo_path)
                                    <a href="{{ Storage::url($acta->archivo_path) }}" target="_blank" class="text-xs text-sky-600 hover:text-sky-700">
                                        <i class="fas fa-file-pdf"></i> PDF
                                    </a>
                                    @endif
                                </div>
                            </a>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-400">
                            <i class="fas fa-inbox text-4xl mb-2 opacity-30"></i>
                            <p class="text-sm">No hay actas registradas</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Últimos Diplomas -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-yellow-500 h-1"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-award text-amber-600"></i>
                            Últimos Diplomas
                        </h3>
                        <a href="{{ route('secretaria.diplomas.index') }}" class="text-amber-600 hover:text-amber-700 text-sm font-semibold">Ver todos →</a>
                    </div>
                    
                    <div class="space-y-3">
                        @forelse($diplomas as $diploma)
                        <div class="border-l-4 border-amber-500 pl-3 py-2 hover:bg-amber-50 rounded-r transition-colors">
                            <a href="{{ route('secretaria.diplomas.index') }}?view={{ $diploma->id }}" class="block">
                                <h4 class="font-semibold text-gray-800 text-sm hover:text-amber-600 transition-colors">
                                    {{ Str::limit($diploma->motivo ?? 'Diploma', 35) }}
                                </h4>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-xs text-gray-600">
                                        {{ $diploma->miembro->nombre ?? 'Miembro' }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($diploma->fecha_emision)->format('d/m/Y') }}
                                    </span>
                                </div>
                            </a>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-400">
                            <i class="fas fa-award text-4xl mb-2 opacity-30"></i>
                            <p class="text-sm">No hay diplomas emitidos</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Documentos Recientes -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-lime-500 h-1"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-folder-open text-green-600"></i>
                            Documentos Recientes
                        </h3>
                        <a href="{{ route('secretaria.documentos.index') }}" class="text-green-600 hover:text-green-700 text-sm font-semibold">Ver todos →</a>
                    </div>
                    
                    <div class="space-y-3">
                        @forelse($documentos as $documento)
                        <div class="border-l-4 border-green-500 pl-3 py-2 hover:bg-green-50 rounded-r transition-colors">
                            <a href="{{ route('secretaria.documentos.index') }}?view={{ $documento->id }}" class="block">
                                <h4 class="font-semibold text-gray-800 text-sm hover:text-green-600 transition-colors">
                                    {{ Str::limit($documento->titulo ?? 'Documento', 35) }}
                                </h4>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-xs text-gray-600 capitalize">
                                        {{ $documento->categoria ?? 'General' }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($documento->created_at)->format('d/m/Y') }}
                                    </span>
                                </div>
                            </a>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-400">
                            <i class="fas fa-folder-open text-4xl mb-2 opacity-30"></i>
                            <p class="text-sm">No hay documentos archivados</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
