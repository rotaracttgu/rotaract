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

        <form action="{{ route('socio.notas.store') }}" method="POST" class="p-6" id="formNota">
            @csrf

            <div class="space-y-6">
                <!-- Título -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-heading text-blue-500 mr-1"></i>
                        Título <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="titulo" id="titulo" required maxlength="200" 
                           value="{{ old('titulo') }}"
                           placeholder="Ej: Ideas para el proyecto de reciclaje"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors text-lg font-semibold">
                    @error('titulo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p id="error-titulo" class="mt-1 text-sm text-red-600 hidden"></p>
                </div>

                <!-- Categoría y Visibilidad -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Categoría -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-folder text-purple-500 mr-1"></i>
                            Categoría <span class="text-red-500">*</span>
                        </label>
                        <select name="categoria" id="categoria" required 
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
                            <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors border-gray-300" 
                                   id="label-privada">
                                <input type="radio" name="visibilidad" value="privada" required
                                       {{ old('visibilidad') === 'privada' || old('visibilidad') === null ? 'checked' : '' }}
                                       class="hidden radio-visibilidad">
                                <div class="flex items-center w-full">
                                    <i class="fas fa-lock text-2xl mr-3 text-gray-600"></i>
                                    <div>
                                        <p class="font-semibold text-gray-700">Privada</p>
                                        <p class="text-xs text-gray-500">Solo tú</p>
                                    </div>
                                </div>
                            </label>

                            <!-- Pública -->
                            <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-blue-50 transition-colors border-gray-300" 
                                   id="label-publica">
                                <input type="radio" name="visibilidad" value="publica" required
                                       {{ old('visibilidad') === 'publica' ? 'checked' : '' }}
                                       class="hidden radio-visibilidad">
                                <div class="flex items-center w-full">
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
                    <textarea name="contenido" id="contenido" required rows="12"
                              placeholder="Escribe aquí el contenido de tu nota...&#10;&#10;Puedes incluir:&#10;• Listas&#10;• Ideas&#10;• Recordatorios&#10;• Cualquier información que necesites guardar"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors resize-none font-mono">{{ old('contenido') }}</textarea>
                    @error('contenido')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p id="error-contenido" class="mt-1 text-sm text-red-600 hidden"></p>
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
                    <input type="text" name="etiquetas" id="etiquetas" maxlength="500" 
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
                    <button type="submit" id="btnSubmit"
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
        const form = document.getElementById('formNota');
        const titulo = document.getElementById('titulo');
        const contenido = document.getElementById('contenido');
        const categoria = document.getElementById('categoria');
        const charCount = document.getElementById('charCount');
        const btnSubmit = document.getElementById('btnSubmit');
        const errorTitulo = document.getElementById('error-titulo');
        const errorContenido = document.getElementById('error-contenido');

        // Manejar radio buttons de visibilidad
        const radiosVisibilidad = document.querySelectorAll('.radio-visibilidad');
        const labelPrivada = document.getElementById('label-privada');
        const labelPublica = document.getElementById('label-publica');

        function actualizarEstilosVisibilidad() {
            const seleccionado = document.querySelector('.radio-visibilidad:checked');
            
            // Remover estilos de ambos
            labelPrivada.classList.remove('border-purple-500', 'bg-purple-50');
            labelPublica.classList.remove('border-blue-500', 'bg-blue-50');
            labelPrivada.classList.add('border-gray-300');
            labelPublica.classList.add('border-gray-300');
            
            // Aplicar estilo al seleccionado
            if (seleccionado) {
                if (seleccionado.value === 'privada') {
                    labelPrivada.classList.remove('border-gray-300');
                    labelPrivada.classList.add('border-purple-500', 'bg-purple-50');
                } else {
                    labelPublica.classList.remove('border-gray-300');
                    labelPublica.classList.add('border-blue-500', 'bg-blue-50');
                }
            }
        }

        // Click en los labels
        labelPrivada.addEventListener('click', function() {
            document.querySelector('input[value="privada"]').checked = true;
            actualizarEstilosVisibilidad();
        });

        labelPublica.addEventListener('click', function() {
            document.querySelector('input[value="publica"]').checked = true;
            actualizarEstilosVisibilidad();
        });

        // Inicializar estilos
        actualizarEstilosVisibilidad();

        // Contador de caracteres y auto-resize
        if (contenido && charCount) {
            contenido.addEventListener('input', function() {
                const length = this.value.length;
                charCount.textContent = length + ' caracteres';
                
                if (length < 10) {
                    charCount.classList.add('text-red-500');
                    charCount.classList.remove('text-gray-500');
                } else {
                    charCount.classList.remove('text-red-500');
                    charCount.classList.add('text-gray-500');
                }
                
                // Auto-resize
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }

        // Funciones de validación
        function validarLetrasRepetidas(texto) {
            const palabras = texto.split(/\s+/);
            for (let palabra of palabras) {
                const regex = /(.)\1{3,}/i;
                if (regex.test(palabra)) {
                    return false;
                }
            }
            return true;
        }

        function validarCaracteresEspeciales(texto) {
            const regex = /[^a-záéíóúñA-ZÁÉÍÓÚÑ0-9\s]{6,}/;
            return !regex.test(texto);
        }

        function validarMayusculas(texto) {
            const letras = texto.replace(/[^a-záéíóúñA-ZÁÉÍÓÚÑ]/g, '');
            if (letras.length === 0) return true;
            
            const mayusculas = texto.replace(/[^A-ZÁÉÍÓÚÑ]/g, '');
            const porcentaje = (mayusculas.length / letras.length) * 100;
            
            return porcentaje <= 60;
        }

        function validarEspacios(texto) {
            return !/\s{3,}/.test(texto);
        }

        function validarTextoCoherente(texto) {
            const textoLimpio = texto.replace(/\s/g, '');
            const letras = textoLimpio.replace(/[^a-záéíóúñA-ZÁÉÍÓÚÑ]/g, '');
            
            if (textoLimpio.length > 10 && letras.length < textoLimpio.length * 0.3) {
                return false;
            }
            
            return true;
        }

        function validarNumeros(texto) {
            const regex = /\d{16,}/;
            return !regex.test(texto);
        }

        // Validación en tiempo real del título
        titulo.addEventListener('input', function() {
            const valor = this.value;
            errorTitulo.classList.add('hidden');
            this.classList.remove('border-red-500');

            if (valor.length > 0) {
                if (!validarLetrasRepetidas(valor)) {
                    errorTitulo.textContent = 'No se permite repetir la misma letra más de 3 veces consecutivas';
                    errorTitulo.classList.remove('hidden');
                    this.classList.add('border-red-500');
                } else if (!validarCaracteresEspeciales(valor)) {
                    errorTitulo.textContent = 'Demasiados caracteres especiales consecutivos';
                    errorTitulo.classList.remove('hidden');
                    this.classList.add('border-red-500');
                } else if (!validarMayusculas(valor)) {
                    errorTitulo.textContent = 'No uses tantas MAYÚSCULAS';
                    errorTitulo.classList.remove('hidden');
                    this.classList.add('border-red-500');
                } else if (!validarEspacios(valor)) {
                    errorTitulo.textContent = 'Demasiados espacios consecutivos';
                    errorTitulo.classList.remove('hidden');
                    this.classList.add('border-red-500');
                }
            }
        });

        // Validación en tiempo real del contenido
        contenido.addEventListener('input', function() {
            const valor = this.value;
            errorContenido.classList.add('hidden');
            this.classList.remove('border-red-500');

            if (valor.length > 0) {
                if (!validarLetrasRepetidas(valor)) {
                    errorContenido.textContent = 'No se permite repetir la misma letra más de 3 veces consecutivas';
                    errorContenido.classList.remove('hidden');
                    this.classList.add('border-red-500');
                } else if (!validarCaracteresEspeciales(valor)) {
                    errorContenido.textContent = 'Demasiados caracteres especiales consecutivos';
                    errorContenido.classList.remove('hidden');
                    this.classList.add('border-red-500');
                } else if (!validarMayusculas(valor)) {
                    errorContenido.textContent = 'No uses tantas MAYÚSCULAS en tu contenido';
                    errorContenido.classList.remove('hidden');
                    this.classList.add('border-red-500');
                } else if (!validarEspacios(valor)) {
                    errorContenido.textContent = 'Demasiados espacios consecutivos';
                    errorContenido.classList.remove('hidden');
                    this.classList.add('border-red-500');
                } else if (!validarNumeros(valor)) {
                    errorContenido.textContent = 'Demasiados números consecutivos';
                    errorContenido.classList.remove('hidden');
                    this.classList.add('border-red-500');
                } else if (!validarTextoCoherente(valor)) {
                    errorContenido.textContent = 'El contenido debe tener texto coherente';
                    errorContenido.classList.remove('hidden');
                    this.classList.add('border-red-500');
                }
            }
        });

        // Validación al enviar el formulario
        form.addEventListener('submit', function(e) {
            let errores = [];

            // Validar título
            const valorTitulo = titulo.value.trim();
            if (valorTitulo.length < 5) {
                errores.push('El título debe tener al menos 5 caracteres');
                titulo.classList.add('border-red-500');
            } else if (!validarLetrasRepetidas(valorTitulo)) {
                errores.push('El título contiene letras repetidas más de 3 veces');
                titulo.classList.add('border-red-500');
            } else if (!validarCaracteresEspeciales(valorTitulo)) {
                errores.push('El título contiene demasiados caracteres especiales');
                titulo.classList.add('border-red-500');
            } else if (!validarMayusculas(valorTitulo)) {
                errores.push('El título contiene demasiadas mayúsculas');
                titulo.classList.add('border-red-500');
            } else if (!validarEspacios(valorTitulo)) {
                errores.push('El título contiene demasiados espacios consecutivos');
                titulo.classList.add('border-red-500');
            }

            // Validar categoría
            if (categoria.value === '') {
                errores.push('Debes seleccionar una categoría');
                categoria.classList.add('border-red-500');
            }

            // Validar visibilidad
            const visibilidadSeleccionada = document.querySelector('.radio-visibilidad:checked');
            if (!visibilidadSeleccionada) {
                errores.push('Debes seleccionar la visibilidad de la nota');
            }

            // Validar contenido
            const valorContenido = contenido.value.trim();
            if (valorContenido.length < 10) {
                errores.push('El contenido debe tener al menos 10 caracteres');
                contenido.classList.add('border-red-500');
            } else if (!validarLetrasRepetidas(valorContenido)) {
                errores.push('El contenido contiene letras repetidas más de 3 veces');
                contenido.classList.add('border-red-500');
            } else if (!validarCaracteresEspeciales(valorContenido)) {
                errores.push('El contenido contiene demasiados caracteres especiales');
                contenido.classList.add('border-red-500');
            } else if (!validarMayusculas(valorContenido)) {
                errores.push('El contenido contiene demasiadas mayúsculas');
                contenido.classList.add('border-red-500');
            } else if (!validarEspacios(valorContenido)) {
                errores.push('El contenido contiene demasiados espacios consecutivos');
                contenido.classList.add('border-red-500');
            } else if (!validarNumeros(valorContenido)) {
                errores.push('El contenido contiene demasiados números consecutivos');
                contenido.classList.add('border-red-500');
            } else if (!validarTextoCoherente(valorContenido)) {
                errores.push('El contenido debe tener texto coherente');
                contenido.classList.add('border-red-500');
            }

            // Si hay errores, prevenir el envío
            if (errores.length > 0) {
                e.preventDefault();
                
                let mensajeError = 'Por favor corrige los siguientes errores:\n\n';
                errores.forEach(error => {
                    mensajeError += '• ' + error + '\n';
                });
                
                alert(mensajeError);
                
                const primerError = document.querySelector('.border-red-500');
                if (primerError) {
                    primerError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    primerError.focus();
                }
                
                return false;
            }

            // Deshabilitar botón para evitar doble envío
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Guardando...';
        });

        // Limpiar estilos de error al corregir
        [titulo, categoria, contenido].forEach(campo => {
            campo.addEventListener('input', function() {
                this.classList.remove('border-red-500');
            });
        });
    });
</script>
@endpush