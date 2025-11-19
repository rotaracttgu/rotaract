@extends('modulos.socio.layout')

@section('page-title', 'Nueva Nota')

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('socio.notas.index') }}" class="text-purple-600 hover:text-purple-700 font-medium mb-3 inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a Notas
        </a>
        <div class="mt-3 bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 rounded-xl p-6 shadow-lg text-white">
            <h1 class="text-2xl font-bold flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Crear Nueva Nota
            </h1>
            <p class="text-purple-100 mt-2">Escribe tus ideas, apuntes o recordatorios</p>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 flex items-center">
                <div class="bg-gradient-to-br from-purple-500 to-pink-600 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                </div>
                Contenido de la Nota
            </h2>
        </div>

        <form action="{{ route('socio.notas.store') }}" method="POST" class="space-y-6" id="formNota">
            @csrf

            <!-- Título -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <svg class="w-4 h-4 inline-block text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                    Título <span class="text-red-500">*</span>
                </label>
                <input type="text" name="titulo" id="titulo" required maxlength="200" 
                       value="{{ old('titulo') }}"
                       placeholder="Ej: Ideas para el proyecto de reciclaje"
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors text-lg font-semibold">
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
                        <svg class="w-4 h-4 inline-block text-purple-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        Categoría <span class="text-red-500">*</span>
                    </label>
                    <select name="categoria" id="categoria" required 
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                        <option value="">Selecciona una categoría</option>
                        <option value="proyecto" {{ old('categoria') === 'proyecto' ? 'selected' : '' }}>📊 Proyecto</option>
                        <option value="reunion" {{ old('categoria') === 'reunion' ? 'selected' : '' }}>👥 Reunión</option>
                        <option value="capacitacion" {{ old('categoria') === 'capacitacion' ? 'selected' : '' }}>🎓 Capacitación</option>
                        <option value="idea" {{ old('categoria') === 'idea' ? 'selected' : '' }}>💡 Idea</option>
                        <option value="personal" {{ old('categoria') === 'personal' ? 'selected' : '' }}>📝 Personal</option>
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
                        <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors border-gray-300" id="label-privada">
                            <input type="radio" name="visibilidad" value="privada" required
                                   {{ old('visibilidad') === 'privada' || old('visibilidad') === null ? 'checked' : '' }}
                                   class="hidden radio-visibilidad">
                            <div class="flex items-center w-full">
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
                        <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-blue-50 transition-colors border-gray-300" id="label-publica">
                            <input type="radio" name="visibilidad" value="publica" required
                                   {{ old('visibilidad') === 'publica' ? 'checked' : '' }}
                                   class="hidden radio-visibilidad">
                            <div class="flex items-center w-full">
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
                <textarea name="contenido" id="contenido" required rows="12"
                          placeholder="Escribe aquí el contenido de tu nota...&#10;&#10;Puedes incluir:&#10;• Listas&#10;• Ideas&#10;• Recordatorios&#10;• Cualquier información que necesites guardar"
                          class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors resize-none font-mono">{{ old('contenido') }}</textarea>
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
                    <svg class="w-4 h-4 inline-block text-orange-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Etiquetas (opcional)
                </label>
                <input type="text" name="etiquetas" id="etiquetas" maxlength="500" 
                       value="{{ old('etiquetas') }}"
                       placeholder="Ej: reciclaje, medio ambiente, comunidad (separadas por comas)"
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                @error('etiquetas')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Separa las etiquetas con comas para facilitar la búsqueda</p>
            </div>

            <!-- Botones de Acción -->
            <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-200">
                <button type="submit" id="btnSubmit"
                        class="flex-1 px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors shadow-md hover:shadow-lg font-semibold">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    Guardar Nota
                </button>
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

    <!-- Consejos -->
    <div class="mt-6 bg-purple-50 border-l-4 border-purple-500 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-purple-600 mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
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
            
            labelPrivada.classList.remove('border-purple-500', 'bg-purple-50');
            labelPublica.classList.remove('border-blue-500', 'bg-blue-50');
            labelPrivada.classList.add('border-gray-300');
            labelPublica.classList.add('border-gray-300');
            
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

        labelPrivada.addEventListener('click', function() {
            document.querySelector('input[value="privada"]').checked = true;
            actualizarEstilosVisibilidad();
        });

        labelPublica.addEventListener('click', function() {
            document.querySelector('input[value="publica"]').checked = true;
            actualizarEstilosVisibilidad();
        });

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
                
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }

        // Funciones de validación (código de validación completo del documento original)
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

            if (categoria.value === '') {
                errores.push('Debes seleccionar una categoría');
                categoria.classList.add('border-red-500');
            }

            const visibilidadSeleccionada = document.querySelector('.radio-visibilidad:checked');
            if (!visibilidadSeleccionada) {
                errores.push('Debes seleccionar la visibilidad de la nota');
            }

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

            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<svg class="w-5 h-5 inline-block mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Guardando...';
        });

        [titulo, categoria, contenido].forEach(campo => {
            campo.addEventListener('input', function() {
                this.classList.remove('border-red-500');
            });
        });
    });
</script>
@endpush