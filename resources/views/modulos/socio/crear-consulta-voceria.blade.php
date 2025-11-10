@extends('modulos.socio.layout')

@section('page-title', 'Nueva Solicitud a Vocalía')

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('socio.voceria.index') }}" class="text-orange-600 hover:text-orange-700 font-medium mb-3 inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver a Solicitudes
        </a>
        <div class="mt-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg p-6 border border-orange-200">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-bullhorn text-orange-600 mr-3"></i>
                Nueva Solicitud a Vocalía
            </h1>
            <p class="text-gray-600 mt-2">Completa el formulario para enviar tu solicitud</p>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 flex items-center">
                <i class="fas fa-edit text-orange-500 mr-3"></i>
                Información de la Solicitud
            </h2>
        </div>

        <form action="{{ route('socio.voceria.store') }}" method="POST" class="p-6">
            @csrf

            <div class="space-y-6">
                <!-- Tipo de Solicitud -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-layer-group text-purple-500 mr-1"></i>
                        Tipo de Solicitud <span class="text-red-500">*</span>
                    </label>
                    <select name="tipo_solicitud" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                        <option value="">Selecciona el tipo de solicitud</option>
                        <option value="Apoyo_Proyecto" {{ old('tipo_solicitud') === 'Apoyo_Proyecto' ? 'selected' : '' }}>
                            Apoyo en Proyecto
                        </option>
                        <option value="Recurso_Material" {{ old('tipo_solicitud') === 'Recurso_Material' ? 'selected' : '' }}>
                            Recurso Material
                        </option>
                        <option value="Recurso_Humano" {{ old('tipo_solicitud') === 'Recurso_Humano' ? 'selected' : '' }}>
                            Recurso Humano (Voluntarios)
                        </option>
                        <option value="Informacion" {{ old('tipo_solicitud') === 'Informacion' ? 'selected' : '' }}>
                            Información
                        </option>
                        <option value="Permiso" {{ old('tipo_solicitud') === 'Permiso' ? 'selected' : '' }}>
                            Permiso Especial
                        </option>
                        <option value="Otro" {{ old('tipo_solicitud') === 'Otro' ? 'selected' : '' }}>
                            Otro
                        </option>
                    </select>
                    @error('tipo_solicitud')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Selecciona el tipo que mejor describa tu solicitud</p>
                </div>

                <!-- Prioridad -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-flag text-orange-500 mr-1"></i>
                        Prioridad <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Baja -->
                        <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors
                            {{ old('prioridad') === 'Baja' ? 'border-gray-500 bg-gray-50' : 'border-gray-300' }}">
                            <input type="radio" name="prioridad" value="Baja" required
                                   {{ old('prioridad') === 'Baja' ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="flex items-center">
                                <div class="w-4 h-4 border-2 border-gray-400 rounded-full mr-3 peer-checked:border-gray-600 peer-checked:bg-gray-600"></div>
                                <div>
                                    <p class="font-semibold text-gray-700 text-sm">Baja</p>
                                    <p class="text-xs text-gray-500">Sin urgencia</p>
                                </div>
                            </div>
                        </label>

                        <!-- Media -->
                        <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-orange-50 transition-colors
                            {{ old('prioridad') === 'Media' || old('prioridad') === null ? 'border-orange-500 bg-orange-50' : 'border-gray-300' }}">
                            <input type="radio" name="prioridad" value="Media" required
                                   {{ old('prioridad') === 'Media' || old('prioridad') === null ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="flex items-center">
                                <div class="w-4 h-4 border-2 border-orange-400 rounded-full mr-3 peer-checked:border-orange-600 peer-checked:bg-orange-600"></div>
                                <div>
                                    <p class="font-semibold text-gray-700 text-sm">Media</p>
                                    <p class="text-xs text-gray-500">Normal</p>
                                </div>
                            </div>
                        </label>

                        <!-- Alta -->
                        <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-red-50 transition-colors
                            {{ old('prioridad') === 'Alta' ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">
                            <input type="radio" name="prioridad" value="Alta" required
                                   {{ old('prioridad') === 'Alta' ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="flex items-center">
                                <div class="w-4 h-4 border-2 border-red-400 rounded-full mr-3 peer-checked:border-red-600 peer-checked:bg-red-600"></div>
                                <div>
                                    <p class="font-semibold text-gray-700 text-sm">Alta</p>
                                    <p class="text-xs text-gray-500">Urgente</p>
                                </div>
                            </div>
                        </label>

                        <!-- Urgente -->
                        <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-red-100 transition-colors
                            {{ old('prioridad') === 'Urgente' ? 'border-red-600 bg-red-100' : 'border-gray-300' }}">
                            <input type="radio" name="prioridad" value="Urgente" required
                                   {{ old('prioridad') === 'Urgente' ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="flex items-center">
                                <div class="w-4 h-4 border-2 border-red-600 rounded-full mr-3 peer-checked:border-red-800 peer-checked:bg-red-800"></div>
                                <div>
                                    <p class="font-semibold text-gray-700 text-sm">Urgente</p>
                                    <p class="text-xs text-gray-500">Muy urgente</p>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('prioridad')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Asunto -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-heading text-blue-500 mr-1"></i>
                        Asunto <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="asunto" required maxlength="200" 
                           value="{{ old('asunto') }}"
                           placeholder="Ej: Solicitud de apoyo para evento de recaudación"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    @error('asunto')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Máximo 200 caracteres</p>
                </div>

                <!-- Descripción -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-align-left text-orange-500 mr-1"></i>
                        Descripción Detallada <span class="text-red-500">*</span>
                    </label>
                    <textarea name="descripcion" required rows="8"
                              placeholder="Describe tu solicitud con el mayor detalle posible. Incluye:&#10;- Qué necesitas&#10;- Por qué lo necesitas&#10;- Cuándo lo necesitas&#10;- Cualquier información adicional relevante"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors resize-none">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Sé específico y detallado para una mejor atención</p>
                </div>

                <!-- Botones de Acción -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-200">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors shadow-md hover:shadow-lg font-semibold">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Enviar Solicitud
                    </button>
                    <a href="{{ route('socio.voceria.index') }}" 
                       class="flex-1 px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-center font-semibold">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Información de Ayuda -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Tips -->
        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6">
            <div class="flex items-start">
                <i class="fas fa-lightbulb text-blue-600 text-2xl mr-4 mt-1"></i>
                <div>
                    <h4 class="font-bold text-blue-900 mb-2">Tips para una buena solicitud</h4>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Describe claramente qué necesitas</li>
                        <li>• Explica el propósito de tu solicitud</li>
                        <li>• Indica fechas límite si aplica</li>
                        <li>• Proporciona contexto del proyecto</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tipos de Solicitud -->
        <div class="bg-orange-50 border-l-4 border-orange-500 rounded-lg p-6">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-orange-600 text-2xl mr-4 mt-1"></i>
                <div>
                    <h4 class="font-bold text-orange-900 mb-2">Tipos de solicitud</h4>
                    <ul class="text-sm text-orange-800 space-y-1">
                        <li>• <strong>Apoyo en Proyecto:</strong> Ayuda para ejecutar</li>
                        <li>• <strong>Recurso Material:</strong> Equipos, material</li>
                        <li>• <strong>Recurso Humano:</strong> Voluntarios</li>
                        <li>• <strong>Permiso Especial:</strong> Autorizaciones</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Auto-resize del textarea
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.querySelector('textarea[name="descripcion"]');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }
    });
</script>
@endpush
