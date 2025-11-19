@extends('modulos.socio.layout')

@section('page-title', 'Editar Nota')

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('socio.notas.index') }}" class="text-purple-600 hover:text-purple-700 font-medium mb-3 inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a Notas
        </a>
        <div class="mt-3 bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 rounded-xl p-6 shadow-lg text-white">
            <h1 class="text-2xl font-bold flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Editar Nota
            </h1>
            <p class="text-orange-100 mt-2">Actualiza el contenido de tu nota</p>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 flex items-center">
                <div class="bg-gradient-to-br from-orange-500 to-red-600 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                </div>
                Contenido de la Nota
            </h2>
        </div>

        <form action="{{ route('socio.notas.update', $nota->NotaID) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Título -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <svg class="w-4 h-4 inline-block text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                    Título <span class="text-red-500">*</span>
                </label>
                <input type="text" name="titulo" required maxlength="200" 
                       value="{{ old('titulo', $nota->Titulo) }}"
                       placeholder="Ej: Ideas para el proyecto de reciclaje"
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors text-lg font-semibold">
                @error('titulo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Categoría y Visibilidad -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Categoría -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline-block text-purple-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        Categoría <span class="text-red-500">*</span>
                    </label>
                    <select name="categoria" required 
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                        <option value="">Selecciona una categoría</option>
                        <option value="proyecto" {{ old('categoria', $nota->Categoria) === 'proyecto' ? 'selected' : '' }}>📊 Proyecto</option>
                        <option value="reunion" {{ old('categoria', $nota->Categoria) === 'reunion' ? 'selected' : '' }}>👥 Reunión</option>
                        <option value="capacitacion" {{ old('categoria', $nota->Categoria) === 'capacitacion' ? 'selected' : '' }}>🎓 Capacitación</option>
                        <option value="idea" {{ old('categoria', $nota->Categoria) === 'idea' ? 'selected' : '' }}>💡 Idea</option>
                        <option value="personal" {{ old('categoria', $nota->Categoria) === 'personal' ? 'selected' : '' }}>📝 Personal</option>
                    </select>
                    @error('categoria')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Visibilidad -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline-block text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Visibilidad <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Privada -->
                        <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors
                            {{ old('visibilidad', $nota->Visibilidad) === 'privada' ? 'border-purple-500 bg-purple-50' : 'border-gray-300' }}">
                            <input type="radio" name="visibilidad" value="privada" required
                                   {{ old('visibilidad', $nota->Visibilidad) === 'privada' ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-700">Privada</p>
                                    <p class="text-xs text-gray-500">Solo tú</p>
                                </div>
                            </div>
                        </label>

                        <!-- Pública -->
                        <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-blue-50 transition-colors
                            {{ old('visibilidad', $nota->Visibilidad) === 'publica' ? 'border-blue-500 bg-blue-50' : 'border-gray-300' }}">
                            <input type="radio" name="visibilidad" value="publica" required
                                   {{ old('visibilidad', $nota->Visibilidad) === 'publica' ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
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
                    <svg class="w-4 h-4 inline-block text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                    Contenido <span class="text-red-500">*</span>
                </label>
                <textarea name="contenido" required rows="12"
                          placeholder="Escribe aquí el contenido de tu nota..."
                          class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors resize-none font-mono">{{ old('contenido', $nota->Contenido) }}</textarea>
                @error('contenido')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <div class="flex items-center justify-between mt-2">
                    <p class="text-xs text-gray-500">Última actualización: 
                        {{ $nota->FechaActualizacion ? \Carbon\Carbon::parse($nota->FechaActualizacion)->format('d/m/Y H:i') : 'Sin actualizar' }}
                    </p>
                    <p class="text-xs text-gray-500" id="charCount">{{ strlen($nota->Contenido) }} caracteres</p>
                </div>
            </div>

            <!-- Etiquetas -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <svg class="w-4 h-4 inline-block text-orange-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Etiquetas (opcional)
                </label>
                <input type="text" name="etiquetas" maxlength="500" 
                       value="{{ old('etiquetas', $nota->Etiquetas) }}"
                       placeholder="Ej: reciclaje, medio ambiente, comunidad (separadas por comas)"
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                @error('etiquetas')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Separa las etiquetas con comas para facilitar la búsqueda</p>
            </div>

            <!-- Botones de Acción -->
            <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-200">
                <button type="submit" 
                        class="flex-1 px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors shadow-md hover:shadow-lg font-semibold">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    Guardar Cambios
                </button>
                <a href="{{ route('socio.notas.ver', $nota->NotaID) }}" 
                   class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-center font-semibold">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Ver Nota
                </a>
                <a href="{{ route('socio.notas.index') }}" 
                   class="flex-1 px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-center font-semibold">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <!-- Información de la Nota -->
    <div class="mt-6 bg-orange-50 border-l-4 border-orange-500 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-orange-600 mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="font-bold text-orange-900 mb-2">Información de la Nota</h4>
                <ul class="text-sm text-orange-800 space-y-1">
                    <li>• Creada: {{ \Carbon\Carbon::parse($nota->FechaCreacion)->format('d/m/Y H:i') }}</li>
                    <li>• ID de la nota: #{{ $nota->NotaID }}</li>
                    <li>• Estado: {{ ucfirst($nota->Estado) }}</li>
                </ul>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.querySelector('textarea[name="contenido"]');
        const charCount = document.getElementById('charCount');
        
        if (textarea && charCount) {
            textarea.addEventListener('input', function() {
                charCount.textContent = this.value.length + ' caracteres';
            });
            
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
            
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
        }
    });
</script>
@endpush