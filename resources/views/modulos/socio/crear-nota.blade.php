@extends('modulos.socio.layout')

@section('page-title', 'Nueva Nota')

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('socio.notas.index') }}" class="text-purple-600 hover:text-purple-700 font-medium mb-3 inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver a Notas
        </a>
        <div class="mt-3 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-6 border border-purple-200">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-pen text-purple-600 mr-3"></i>
                Crear Nueva Nota
            </h1>
            <p class="text-gray-600 mt-2">Escribe tus ideas, apuntes o recordatorios</p>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 flex items-center">
                <i class="fas fa-edit text-purple-500 mr-3"></i>
                Contenido de la Nota
            </h2>
        </div>

        <form action="{{ route('socio.notas.store') }}" method="POST" class="p-6">
            @csrf

            <div class="space-y-6">
                <!-- Título -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-heading text-blue-500 mr-1"></i>
                        Título <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="titulo" required maxlength="200" 
                           value="{{ old('titulo') }}"
                           placeholder="Ej: Ideas para el proyecto de reciclaje"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors text-lg font-semibold">
                    @error('titulo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Categoría y Visibilidad -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Categoría -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-folder text-purple-500 mr-1"></i>
                            Categoría <span class="text-red-500">*</span>
                        </label>
                        <select name="categoria" required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                            <option value="">Selecciona una categoría</option>
                            <option value="proyecto" {{ old('categoria') === 'proyecto' ? 'selected' : '' }}>
                                📊 Proyecto
                            </option>
                            <option value="reunion" {{ old('categoria') === 'reunion' ? 'selected' : '' }}>
                                👥 Reunión
                            </option>
                            <option value="capacitacion" {{ old('categoria') === 'capacitacion' ? 'selected' : '' }}>
                                🎓 Capacitación
                            </option>
                            <option value="idea" {{ old('categoria') === 'idea' ? 'selected' : '' }}>
                                💡 Idea
                            </option>
                            <option value="personal" {{ old('categoria') === 'personal' ? 'selected' : '' }}>
                                📝 Personal
                            </option>
                        </select>
                        @error('categoria')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Visibilidad -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-eye text-blue-500 mr-1"></i>
                            Visibilidad <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Privada -->
                            <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors
                                {{ old('visibilidad') === 'privada' || old('visibilidad') === null ? 'border-purple-500 bg-purple-50' : 'border-gray-300' }}">
                                <input type="radio" name="visibilidad" value="privada" required
                                       {{ old('visibilidad') === 'privada' || old('visibilidad') === null ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="flex items-center">
                                    <i class="fas fa-lock text-2xl mr-3 text-gray-600"></i>
                                    <div>
                                        <p class="font-semibold text-gray-700">Privada</p>
                                        <p class="text-xs text-gray-500">Solo tú</p>
                                    </div>
                                </div>
                            </label>

                            <!-- Pública -->
                            <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-blue-50 transition-colors
                                {{ old('visibilidad') === 'publica' ? 'border-blue-500 bg-blue-50' : 'border-gray-300' }}">
                                <input type="radio" name="visibilidad" value="publica" required
                                       {{ old('visibilidad') === 'publica' ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="flex items-center">
                                    <i class="fas fa-globe text-2xl mr-3 text-blue-600"></i>
                                    <div>
                                        <p class="font-semibold text-gray-700">Pública</p>
                                        <p class="text-xs text-gray-500">Todos</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('visibilidad')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Contenido -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-align-left text-green-500 mr-1"></i>
                        Contenido <span class="text-red-500">*</span>
                    </label>
                    <textarea name="contenido" required rows="12"
                              placeholder="Escribe aquí el contenido de tu nota...&#10;&#10;Puedes incluir:&#10;• Listas&#10;• Ideas&#10;• Recordatorios&#10;• Cualquier información que necesites guardar"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors resize-none font-mono">{{ old('contenido') }}</textarea>
                    @error('contenido')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <div class="flex items-center justify-between mt-2">
                        <p class="text-xs text-gray-500">Usa un formato claro y organizado</p>
                        <p class="text-xs text-gray-500" id="charCount">0 caracteres</p>
                    </div>
                </div>

                <!-- Etiquetas -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-tags text-orange-500 mr-1"></i>
                        Etiquetas (opcional)
                    </label>
                    <input type="text" name="etiquetas" maxlength="500" 
                           value="{{ old('etiquetas') }}"
                           placeholder="Ej: reciclaje, medio ambiente, comunidad (separadas por comas)"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                    @error('etiquetas')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Separa las etiquetas con comas para facilitar la búsqueda</p>
                </div>

                <!-- Botones de Acción -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-200">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors shadow-md hover:shadow-lg font-semibold">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Nota
                    </button>
                    <a href="{{ route('socio.notas.index') }}" 
                       class="flex-1 px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-center font-semibold">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Consejos -->
    <div class="mt-6 bg-purple-50 border-l-4 border-purple-500 rounded-lg p-6">
        <div class="flex items-start">
            <i class="fas fa-lightbulb text-purple-600 text-2xl mr-4 mt-1"></i>
            <div>
                <h4 class="font-bold text-purple-900 mb-2">Consejos para escribir buenas notas</h4>
                <ul class="text-sm text-purple-800 space-y-1">
                    <li>• <strong>Título claro:</strong> Usa un título descriptivo que te ayude a encontrar la nota rápidamente</li>
                    <li>• <strong>Organización:</strong> Estructura tu contenido con listas y párrafos cortos</li>
                    <li>• <strong>Etiquetas útiles:</strong> Agrega palabras clave que te ayuden a buscar</li>
                    <li>• <strong>Categoría correcta:</strong> Clasifica bien para mantener orden</li>
                </ul>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Contador de caracteres
        const textarea = document.querySelector('textarea[name="contenido"]');
        const charCount = document.getElementById('charCount');
        
        if (textarea && charCount) {
            textarea.addEventListener('input', function() {
                charCount.textContent = this.value.length + ' caracteres';
            });
            
            // Auto-resize del textarea
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }
    });
</script>
@endpush