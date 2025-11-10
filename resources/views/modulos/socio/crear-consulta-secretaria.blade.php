@extends('modulos.socio.layout')

@section('page-title', 'Nueva Consulta a Secretaría')

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('socio.secretaria.index') }}" class="text-orange-600 hover:text-orange-700 font-medium mb-3 inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver a Consultas
        </a>
        <div class="mt-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg p-6 border border-orange-200">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-file-alt text-orange-600 mr-3"></i>
                Nueva Consulta a Secretaría
            </h1>
            <p class="text-gray-600 mt-2">Envía tu consulta o solicitud directamente a la Secretaría</p>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 flex items-center">
                <i class="fas fa-edit text-orange-500 mr-3"></i>
                Detalles de la Consulta
            </h2>
        </div>

        <form action="{{ route('socio.secretaria.store') }}" method="POST" class="p-6">
            @csrf

            <div class="space-y-6">
                <!-- Asunto -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-heading text-blue-500 mr-1"></i>
                        Asunto <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="asunto" required maxlength="200" 
                           value="{{ old('asunto') }}"
                           placeholder="Ej: Solicitud de certificado de membresía"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    @error('asunto')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Máximo 200 caracteres</p>
                </div>

                <!-- Tipo de Consulta -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-layer-group text-purple-500 mr-1"></i>
                        Tipo de Consulta <span class="text-red-500">*</span>
                    </label>
                    <select name="tipo" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                        <option value="">Selecciona el tipo</option>
                        <option value="Certificado" {{ old('tipo') === 'Certificado' ? 'selected' : '' }}>Certificado de Membresía</option>
                        <option value="Constancia" {{ old('tipo') === 'Constancia' ? 'selected' : '' }}>Constancia</option>
                        <option value="Informacion" {{ old('tipo') === 'Informacion' ? 'selected' : '' }}>Información General</option>
                        <option value="Queja" {{ old('tipo') === 'Queja' ? 'selected' : '' }}>Queja o Sugerencia</option>
                        <option value="Otro" {{ old('tipo') === 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('tipo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-align-left text-orange-500 mr-1"></i>
                        Mensaje Detallado <span class="text-red-500">*</span>
                    </label>
                    <textarea name="mensaje" required rows="8"
                              placeholder="Explica tu consulta con detalle..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors resize-none">{{ old('mensaje') }}</textarea>
                    @error('mensaje')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-200">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors shadow-md hover:shadow-lg font-semibold">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Enviar Consulta
                    </button>
                    <a href="{{ route('socio.secretaria.index') }}" 
                       class="flex-1 px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-center font-semibold">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Ayuda -->
    <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6">
        <div class="flex items-start">
            <i class="fas fa-lightbulb text-blue-600 text-2xl mr-4 mt-1"></i>
            <div>
                <h4 class="font-bold text-blue-900 mb-2">¿Necesitas ayuda?</h4>
                <p class="text-sm text-blue-800">
                    La Secretaría responde en un plazo máximo de <strong>48 horas hábiles</strong>. 
                    Incluye todos los detalles para una atención más rápida.
                </p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.querySelector('textarea[name="mensaje"]');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }
    });
</script>
@endpush
