@extends('modulos.socio.layout')

@section('page-title', 'Blog de Notas')

@section('content')
    <!-- Header -->
    <div class="mb-6 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-6 border border-purple-200">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-sticky-note text-purple-600 mr-3"></i>
                    Blog de Notas Personales
                </h1>
                <p class="text-gray-600 mt-2">Organiza tus ideas, apuntes y recordatorios</p>
            </div>
            <a href="{{ route('socio.notas.crear') }}" 
               class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors shadow-md hover:shadow-lg">
                <i class="fas fa-plus mr-2"></i>
                Nueva Nota
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="mb-6 bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <form method="GET" action="{{ route('socio.notas.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Filtro por Categoría -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-folder text-purple-500 mr-1"></i>
                    Categoría
                </label>
                <select name="categoria" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="todas" {{ $filtroCategoria === 'todas' ? 'selected' : '' }}>Todas</option>
                    <option value="proyecto" {{ $filtroCategoria === 'proyecto' ? 'selected' : '' }}>Proyecto</option>
                    <option value="reunion" {{ $filtroCategoria === 'reunion' ? 'selected' : '' }}>Reunión</option>
                    <option value="capacitacion" {{ $filtroCategoria === 'capacitacion' ? 'selected' : '' }}>Capacitación</option>
                    <option value="idea" {{ $filtroCategoria === 'idea' ? 'selected' : '' }}>Idea</option>
                    <option value="personal" {{ $filtroCategoria === 'personal' ? 'selected' : '' }}>Personal</option>
                </select>
            </div>

            <!-- Filtro por Visibilidad -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-eye text-blue-500 mr-1"></i>
                    Visibilidad
                </label>
                <select name="visibilidad" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="todas" {{ $filtroVisibilidad === 'todas' ? 'selected' : '' }}>Todas</option>
                    <option value="privada" {{ $filtroVisibilidad === 'privada' ? 'selected' : '' }}>Privadas</option>
                    <option value="publica" {{ $filtroVisibilidad === 'publica' ? 'selected' : '' }}>Públicas</option>
                </select>
            </div>

            <!-- Botón de Filtrar -->
            <div class="flex items-end">
                <button type="submit" class="w-full px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                    <i class="fas fa-filter mr-2"></i>
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Grid de Notas -->
    <div>
        @if(isset($notas) && count($notas) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($notas as $nota)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <!-- Header de la Nota -->
                        <div class="p-4 border-b border-gray-200 bg-gradient-to-r 
                            {{ ($nota->Categoria ?? '') === 'proyecto' ? 'from-blue-50 to-blue-100' : '' }}
                            {{ ($nota->Categoria ?? '') === 'reunion' ? 'from-green-50 to-green-100' : '' }}
                            {{ ($nota->Categoria ?? '') === 'capacitacion' ? 'from-yellow-50 to-yellow-100' : '' }}
                            {{ ($nota->Categoria ?? '') === 'idea' ? 'from-purple-50 to-purple-100' : '' }}
                            {{ ($nota->Categoria ?? '') === 'personal' ? 'from-pink-50 to-pink-100' : '' }}">
                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 text-xs font-bold rounded-full
                                    {{ ($nota->Categoria ?? '') === 'proyecto' ? 'bg-blue-500 text-white' : '' }}
                                    {{ ($nota->Categoria ?? '') === 'reunion' ? 'bg-green-500 text-white' : '' }}
                                    {{ ($nota->Categoria ?? '') === 'capacitacion' ? 'bg-yellow-500 text-white' : '' }}
                                    {{ ($nota->Categoria ?? '') === 'idea' ? 'bg-purple-500 text-white' : '' }}
                                    {{ ($nota->Categoria ?? '') === 'personal' ? 'bg-pink-500 text-white' : '' }}">
                                    {{ ucfirst($nota->Categoria ?? 'Sin categoría') }}
                                </span>
                                <div class="flex items-center gap-2">
                                    @if(($nota->Visibilidad ?? '') === 'publica')
                                        <i class="fas fa-globe text-blue-500" title="Pública"></i>
                                    @else
                                        <i class="fas fa-lock text-gray-500" title="Privada"></i>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Contenido de la Nota -->
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-3 group-hover:text-purple-600 transition-colors line-clamp-2">
                                {{ $nota->Titulo ?? 'Sin título' }}
                            </h3>
                            
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $nota->Contenido ?? 'Sin contenido' }}
                            </p>

                            <!-- Etiquetas -->
                            @if(isset($nota->Etiquetas) && !empty(trim($nota->Etiquetas)))
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach(explode(',', $nota->Etiquetas) as $etiqueta)
                                        @if(trim($etiqueta) !== '')
                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                                #{{ trim($etiqueta) }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            <!-- Fecha -->
                            <div class="text-xs text-gray-500 mb-4">
                                <i class="fas fa-clock mr-1"></i>
                                {{ isset($nota->FechaCreacion) && $nota->FechaCreacion 
                                    ? \Carbon\Carbon::parse($nota->FechaCreacion)->diffForHumans() 
                                    : 'Sin fecha' }}
                            </div>

                            <!-- Acciones -->
                            <div class="flex gap-2">
                                <a href="{{ route('socio.notas.ver', $nota->NotaID ?? '#') }}" 
                                   class="flex-1 px-4 py-2 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                    <i class="fas fa-eye mr-1"></i>
                                    Ver
                                </a>
                                <a href="{{ route('socio.notas.editar', $nota->NotaID ?? '#') }}" 
                                   class="flex-1 px-4 py-2 bg-orange-600 text-white text-center rounded-lg hover:bg-orange-700 transition-colors text-sm font-medium">
                                    <i class="fas fa-edit mr-1"></i>
                                    Editar
                                </a>
                                <form action="{{ route('socio.notas.eliminar', $nota->NotaID ?? '#') }}" method="POST" class="inline"
                                      onsubmit="return confirm('¿Estás seguro de eliminar esta nota?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Estado Vacío -->
            <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="inline-block p-6 bg-gray-100 rounded-full mb-4">
                    <i class="fas fa-sticky-note text-6xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">No tienes notas aún</h3>
                <p class="text-gray-500 mb-6">Comienza a escribir tus ideas y apuntes</p>
                <a href="{{ route('socio.notas.crear') }}" 
                   class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Crear Primera Nota
                </a>
            </div>
        @endif
    </div>

    <!-- Información de Ayuda -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Categorías -->
        <div class="bg-purple-50 border-l-4 border-purple-500 rounded-lg p-6">
            <div class="flex items-start">
                <i class="fas fa-folder-open text-purple-600 text-2xl mr-4 mt-1"></i>
                <div>
                    <h4 class="font-bold text-purple-900 mb-2">Categorías de Notas</h4>
                    <ul class="text-sm text-purple-800 space-y-1">
                        <li>• <strong>Proyecto:</strong> Notas sobre proyectos</li>
                        <li>• <strong>Reunión:</strong> Apuntes de reuniones</li>
                        <li>• <strong>Capacitación:</strong> Notas de aprendizaje</li>
                        <li>• <strong>Idea:</strong> Ideas y brainstorming</li>
                        <li>• <strong>Personal:</strong> Notas personales</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tips -->
        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6">
            <div class="flex items-start">
                <i class="fas fa-lightbulb text-blue-600 text-2xl mr-4 mt-1"></i>
                <div>
                    <h4 class="font-bold text-blue-900 mb-2">Tips para organizar tus notas</h4>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Usa títulos descriptivos</li>
                        <li>• Agrega etiquetas para búsqueda rápida</li>
                        <li>• Marca como pública para compartir</li>
                        <li>• Categoriza correctamente tus notas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Animación al cargar las tarjetas
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.grid > div');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 10);
            }, index * 50);
        });
    });
</script>
@endpush
