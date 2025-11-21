@extends('modulos.socio.layout')

@section('page-title', 'Blog de Notas')

@section('content')
    <!-- Header con gradiente mejorado -->
    <div class="mb-6 bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 rounded-xl p-6 shadow-lg text-white">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl font-bold flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Blog de Notas
                </h1>
                <p class="text-purple-100 mt-2">Tus ideas, apuntes y recordatorios personales</p>
            </div>
            <a href="{{ route('socio.notas.crear') }}" 
               class="px-6 py-3 bg-white text-purple-600 rounded-lg hover:bg-purple-50 transition-colors font-bold shadow-md hover:shadow-lg">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Nota
            </a>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">TOTAL NOTAS</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent">{{ $totalNotas ?? 0 }}</h3>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">PRIVADAS</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">{{ $notasPrivadas ?? 0 }}</h3>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">PÚBLICAS</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent">{{ $notasPublicas ?? 0 }}</h3>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">ESTE MES</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-orange-800 bg-clip-text text-transparent">{{ $notasEsteMes ?? 0 }}</h3>
                </div>
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="mb-6 bg-white rounded-xl shadow-sm p-4 border border-gray-200">
        <form method="GET" action="{{ route('socio.notas.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Categoría
                </label>
                <select name="categoria" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="">Todas las categorías</option>
                    <option value="proyecto" {{ request('categoria') === 'proyecto' ? 'selected' : '' }}>📊 Proyecto</option>
                    <option value="reunion" {{ request('categoria') === 'reunion' ? 'selected' : '' }}>👥 Reunión</option>
                    <option value="capacitacion" {{ request('categoria') === 'capacitacion' ? 'selected' : '' }}>🎓 Capacitación</option>
                    <option value="idea" {{ request('categoria') === 'idea' ? 'selected' : '' }}>💡 Idea</option>
                    <option value="personal" {{ request('categoria') === 'personal' ? 'selected' : '' }}>📝 Personal</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors shadow-sm">
                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filtrar
            </button>
        </form>
    </div>

    <!-- Lista de Notas -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800 flex items-center">
                <div class="bg-gradient-to-br from-purple-500 to-pink-600 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                Mis Notas
            </h2>
        </div>

        @if(isset($notas) && count($notas) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($notas as $nota)
                    <div class="border-2 rounded-lg hover:shadow-xl transition-all duration-300 overflow-hidden group
                        {{ $nota->Categoria === 'proyecto' ? 'border-blue-200 hover:border-blue-400' : '' }}
                        {{ $nota->Categoria === 'reunion' ? 'border-green-200 hover:border-green-400' : '' }}
                        {{ $nota->Categoria === 'capacitacion' ? 'border-yellow-200 hover:border-yellow-400' : '' }}
                        {{ $nota->Categoria === 'idea' ? 'border-purple-200 hover:border-purple-400' : '' }}
                        {{ $nota->Categoria === 'personal' ? 'border-pink-200 hover:border-pink-400' : '' }}">
                        
                        <!-- Header de la nota -->
                        <div class="p-4 
                            {{ $nota->Categoria === 'proyecto' ? 'bg-gradient-to-r from-blue-50 to-blue-100' : '' }}
                            {{ $nota->Categoria === 'reunion' ? 'bg-gradient-to-r from-green-50 to-green-100' : '' }}
                            {{ $nota->Categoria === 'capacitacion' ? 'bg-gradient-to-r from-yellow-50 to-yellow-100' : '' }}
                            {{ $nota->Categoria === 'idea' ? 'bg-gradient-to-r from-purple-50 to-purple-100' : '' }}
                            {{ $nota->Categoria === 'personal' ? 'bg-gradient-to-r from-pink-50 to-pink-100' : '' }}">
                            <div class="flex items-center justify-between mb-2">
                                <span class="px-3 py-1 text-xs font-bold rounded-full
                                    {{ $nota->Categoria === 'proyecto' ? 'bg-blue-500 text-white' : '' }}
                                    {{ $nota->Categoria === 'reunion' ? 'bg-green-500 text-white' : '' }}
                                    {{ $nota->Categoria === 'capacitacion' ? 'bg-yellow-500 text-white' : '' }}
                                    {{ $nota->Categoria === 'idea' ? 'bg-purple-500 text-white' : '' }}
                                    {{ $nota->Categoria === 'personal' ? 'bg-pink-500 text-white' : '' }}">
                                    {{ ucfirst($nota->Categoria) }}
                                </span>
                                @if($nota->Visibilidad === 'publica')
                                    <span class="text-xs flex items-center text-gray-600">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Pública
                                    </span>
                                @else
                                    <span class="text-xs flex items-center text-gray-600">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                        Privada
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 line-clamp-2 group-hover:text-purple-600 transition-colors">
                                {{ $nota->Titulo }}
                            </h3>
                        </div>

                        <!-- Contenido -->
                        <div class="p-4">
                            <p class="text-sm text-gray-600 line-clamp-3 mb-4">
                                {{ $nota->Contenido }}
                            </p>

                            <!-- Footer -->
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($nota->FechaCreacion)->format('d/m/Y') }}
                                </span>
                                <span>{{ strlen($nota->Contenido) }} caracteres</span>
                            </div>

                            <!-- Etiquetas -->
                            @if($nota->Etiquetas)
                                <div class="flex flex-wrap gap-1 mb-4">
                                    @foreach(array_slice(explode(',', $nota->Etiquetas), 0, 3) as $etiqueta)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                            #{{ trim($etiqueta) }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Botones -->
                            <div class="flex gap-2">
                                <a href="{{ route('socio.notas.ver', $nota->NotaID) }}" 
                                   class="flex-1 px-4 py-2 bg-purple-600 text-white text-center rounded-lg hover:bg-purple-700 transition-colors text-sm font-medium">
                                    Ver
                                </a>
                                <a href="{{ route('socio.notas.editar', $nota->NotaID) }}" 
                                   class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Estado Vacío -->
            <div class="text-center py-16">
                <div class="inline-block p-6 bg-gray-100 rounded-full mb-4">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">No tienes notas aún</h3>
                <p class="text-gray-500 mb-4">Comienza a escribir tus ideas y pensamientos</p>
                <a href="{{ route('socio.notas.crear') }}" 
                   class="inline-block px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Crear Mi Primera Nota
                </a>
            </div>
        @endif
    </div>

    <!-- Información -->
    <div class="mt-6 bg-purple-50 border-l-4 border-purple-500 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-purple-600 mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="font-bold text-purple-900 mb-2">Sobre tus notas</h4>
                <ul class="text-sm text-purple-800 space-y-1">
                    <li>• Las notas privadas solo las puedes ver tú</li>
                    <li>• Las notas públicas son visibles para todos los miembros del club</li>
                    <li>• Usa etiquetas para organizar mejor tus notas</li>
                </ul>
            </div>
        </div>
    </div>
@endsection