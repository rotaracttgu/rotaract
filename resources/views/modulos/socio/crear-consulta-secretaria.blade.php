@extends('modulos.socio.layout')

@section('page-title', 'Nueva Consulta a Secretaría')

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('socio.secretaria.index') }}" class="text-orange-600 hover:text-orange-700 font-medium mb-3 inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a Consultas
        </a>
        <div class="mt-3 bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 rounded-xl p-6 shadow-lg text-white">
            <h1 class="text-2xl font-bold flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Nueva Consulta a Secretaría
            </h1>
            <p class="text-orange-100 mt-2">Envía tu consulta o solicitud directamente a la Secretaría</p>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 flex items-center">
                <div class="bg-gradient-to-br from-orange-500 to-red-600 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                </div>
                Detalles de la Consulta
            </h2>
        </div>

        <form action="{{ route('socio.secretaria.store') }}" method="POST" enctype="multipart/form-data" class="p-6" id="formConsulta">
            @csrf

            <div class="space-y-6">
                <!-- Asunto -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline-block text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        Asunto <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="asunto" id="asunto" required maxlength="200" 
                           value="{{ old('asunto') }}"
                           placeholder="Ej: Solicitud de certificado de membresía"
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    @error('asunto')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Máximo 200 caracteres</p>
                    <p id="error-asunto" class="mt-1 text-sm text-red-600 hidden"></p>
                </div>

                <!-- Tipo de Consulta -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline-block text-purple-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        Tipo de Consulta <span class="text-red-500">*</span>
                    </label>
                    <select name="tipo" id="tipo" required 
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                        <option value="">Selecciona el tipo</option>
                        <option value="Certificado" {{ old('tipo') === 'Certificado' ? 'selected' : '' }}>📜 Certificado de Membresía</option>
                        <option value="Constancia" {{ old('tipo') === 'Constancia' ? 'selected' : '' }}>📄 Constancia</option>
                        <option value="Pago" {{ old('tipo') === 'Pago' ? 'selected' : '' }}>💳 Pago de Membresía</option>
                        <option value="Informacion" {{ old('tipo') === 'Informacion' ? 'selected' : '' }}>ℹ️ Información General</option>
                        <option value="Queja" {{ old('tipo') === 'Queja' ? 'selected' : '' }}>💬 Queja o Sugerencia</option>
                        <option value="Otro" {{ old('tipo') === 'Otro' ? 'selected' : '' }}>📋 Otro</option>
                    </select>
                    @error('tipo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comprobante de Pago (solo visible cuando se selecciona "Pago") -->
                <div id="contenedor-comprobante" class="hidden">
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline-block text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Comprobante de Pago <span class="text-red-500">*</span>
                    </label>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-orange-400 transition-colors">
                        <input type="file" name="comprobante" id="comprobante" 
                               accept="image/jpeg,image/jpg,image/png,image/webp,application/pdf"
                               class="hidden">
                        
                        <label for="comprobante" class="cursor-pointer">
                            <div id="zona-carga">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="text-gray-600 font-medium mb-2">Haz clic aquí para subir tu comprobante</p>
                                <p class="text-xs text-gray-500">o arrastra y suelta el archivo</p>
                                <p class="text-xs text-gray-400 mt-2">Formatos: JPG, PNG, WEBP, PDF (Máx. 5MB)</p>
                            </div>
                        </label>

                        <!-- Vista previa del archivo -->
                        <div id="vista-previa" class="hidden mt-4">
                            <div class="flex items-center justify-center gap-4 p-4 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    <svg id="icono-archivo" class="w-12 h-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <img id="preview-imagen" class="hidden max-h-32 rounded-lg shadow-sm" alt="Vista previa">
                                </div>
                                <div class="flex-1 text-left">
                                    <p class="font-semibold text-gray-800" id="nombre-archivo"></p>
                                    <p class="text-sm text-gray-600" id="tamano-archivo"></p>
                                    <button type="button" id="btn-remover" 
                                            class="mt-2 text-sm text-red-600 hover:text-red-700 font-medium">
                                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Eliminar archivo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @error('comprobante')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p id="error-comprobante" class="mt-1 text-sm text-red-600 hidden"></p>
                </div>

                <!-- Descripción -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline-block text-orange-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                        Mensaje Detallado <span class="text-red-500">*</span>
                    </label>
                    <textarea name="mensaje" id="mensaje" required rows="8"
                              placeholder="Explica tu consulta con detalle..."
                              class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors resize-none">{{ old('mensaje') }}</textarea>
                    @error('mensaje')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p id="error-mensaje" class="mt-1 text-sm text-red-600 hidden"></p>
                    <p id="contador-mensaje" class="mt-1 text-xs text-gray-500">0 caracteres</p>
                </div>

                <!-- Botones -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-200">
                    <button type="submit" id="btnSubmit"
                            class="flex-1 px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors shadow-md hover:shadow-lg font-semibold">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Enviar Consulta
                    </button>
                    <a href="{{ route('socio.secretaria.index') }}" 
                       class="flex-1 px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-center font-semibold">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Ayuda -->
    <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-600 mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
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
        const form = document.getElementById('formConsulta');
        const asunto = document.getElementById('asunto');
        const mensaje = document.getElementById('mensaje');
        const tipo = document.getElementById('tipo');
        const btnSubmit = document.getElementById('btnSubmit');
        const errorAsunto = document.getElementById('error-asunto');
        const errorMensaje = document.getElementById('error-mensaje');
        const contadorMensaje = document.getElementById('contador-mensaje');
        
        // Elementos del comprobante
        const contenedorComprobante = document.getElementById('contenedor-comprobante');
        const comprobante = document.getElementById('comprobante');
        const errorComprobante = document.getElementById('error-comprobante');
        const vistaPrevia = document.getElementById('vista-previa');
        const zonaCarga = document.getElementById('zona-carga');
        const nombreArchivo = document.getElementById('nombre-archivo');
        const tamanoArchivo = document.getElementById('tamano-archivo');
        const previewImagen = document.getElementById('preview-imagen');
        const iconoArchivo = document.getElementById('icono-archivo');
        const btnRemover = document.getElementById('btn-remover');

        // Mostrar/ocultar campo de comprobante según tipo de consulta
        tipo.addEventListener('change', function() {
            if (this.value === 'Pago') {
                contenedorComprobante.classList.remove('hidden');
                comprobante.setAttribute('required', 'required');
            } else {
                contenedorComprobante.classList.add('hidden');
                comprobante.removeAttribute('required');
                limpiarArchivo();
            }
        });

        // Manejar selección de archivo
        comprobante.addEventListener('change', function(e) {
            const archivo = e.target.files[0];
            if (archivo) {
                validarYMostrarArchivo(archivo);
            }
        });

        // Drag and drop
        const zonaDrop = contenedorComprobante?.querySelector('.border-dashed');
        
        if (zonaDrop) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                zonaDrop.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                zonaDrop.addEventListener(eventName, () => {
                    zonaDrop.classList.add('border-orange-500', 'bg-orange-50');
                });
            });

            ['dragleave', 'drop'].forEach(eventName => {
                zonaDrop.addEventListener(eventName, () => {
                    zonaDrop.classList.remove('border-orange-500', 'bg-orange-50');
                });
            });

            zonaDrop.addEventListener('drop', function(e) {
                const archivo = e.dataTransfer.files[0];
                if (archivo) {
                    comprobante.files = e.dataTransfer.files;
                    validarYMostrarArchivo(archivo);
                }
            });
        }

        // Validar y mostrar archivo
        function validarYMostrarArchivo(archivo) {
            errorComprobante.classList.add('hidden');
            comprobante.classList.remove('border-red-500');

            // Validar tipo de archivo
            const tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'application/pdf'];
            if (!tiposPermitidos.includes(archivo.type)) {
                mostrarError('Solo se permiten archivos JPG, PNG, WEBP o PDF');
                limpiarArchivo();
                return;
            }

            // Validar tamaño (5MB máximo)
            const maxSize = 5 * 1024 * 1024; // 5MB en bytes
            if (archivo.size > maxSize) {
                mostrarError('El archivo no debe superar los 5MB');
                limpiarArchivo();
                return;
            }

            // Mostrar vista previa
            mostrarVistaPrevia(archivo);
        }

        // Mostrar vista previa del archivo
        function mostrarVistaPrevia(archivo) {
            zonaCarga.classList.add('hidden');
            vistaPrevia.classList.remove('hidden');
            
            nombreArchivo.textContent = archivo.name;
            tamanoArchivo.textContent = formatearTamano(archivo.size);

            // Si es imagen, mostrar preview
            if (archivo.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImagen.src = e.target.result;
                    previewImagen.classList.remove('hidden');
                    iconoArchivo.classList.add('hidden');
                };
                reader.readAsDataURL(archivo);
            } else {
                // Si es PDF, mostrar icono
                previewImagen.classList.add('hidden');
                iconoArchivo.classList.remove('hidden');
                iconoArchivo.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>';
                iconoArchivo.classList.add('text-red-500');
            }
        }

        // Remover archivo
        btnRemover.addEventListener('click', function() {
            limpiarArchivo();
        });

        function limpiarArchivo() {
            comprobante.value = '';
            vistaPrevia.classList.add('hidden');
            zonaCarga.classList.remove('hidden');
            previewImagen.src = '';
            previewImagen.classList.add('hidden');
            iconoArchivo.classList.remove('hidden');
            iconoArchivo.classList.remove('text-red-500');
            iconoArchivo.classList.add('text-orange-500');
            errorComprobante.classList.add('hidden');
        }

        function mostrarError(mensaje) {
            errorComprobante.textContent = mensaje;
            errorComprobante.classList.remove('hidden');
            contenedorComprobante.querySelector('.border-dashed').classList.add('border-red-500');
        }

        function formatearTamano(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }

        // Auto-resize del textarea
        if (mensaje) {
            mensaje.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
                
                // Actualizar contador de caracteres
                const length = this.value.length;
                contadorMensaje.textContent = `${length} caracteres`;
                
                if (length < 20) {
                    contadorMensaje.classList.add('text-red-500');
                    contadorMensaje.classList.remove('text-gray-500');
                } else {
                    contadorMensaje.classList.remove('text-red-500');
                    contadorMensaje.classList.add('text-gray-500');
                }
            });
        }

        // Función para validar letras repetidas
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

        // Función para validar caracteres especiales excesivos
        function validarCaracteresEspeciales(texto) {
            const regex = /[^a-záéíóúñA-ZÁÉÍÓÚÑ0-9\s]{6,}/;
            return !regex.test(texto);
        }

        // Función para validar mayúsculas excesivas
        function validarMayusculas(texto) {
            const letras = texto.replace(/[^a-záéíóúñA-ZÁÉÍÓÚÑ]/g, '');
            if (letras.length === 0) return true;
            
            const mayusculas = texto.replace(/[^A-ZÁÉÍÓÚÑ]/g, '');
            const porcentaje = (mayusculas.length / letras.length) * 100;
            
            return porcentaje <= 60;
        }

        // Función para validar espacios excesivos
        function validarEspacios(texto) {
            return !/\s{3,}/.test(texto);
        }

        // Función para validar números excesivos
        function validarNumeros(texto) {
            const regex = /\d{16,}/;
            return !regex.test(texto);
        }

        // Función para detectar texto spam o sin sentido
        function validarTextoCoherente(texto) {
            const textoLimpio = texto.replace(/\s/g, '');
            const letras = textoLimpio.replace(/[^a-záéíóúñA-ZÁÉÍÓÚÑ]/g, '');
            
            if (textoLimpio.length > 10 && letras.length < textoLimpio.length * 0.3) {
                return false;
            }
            
            return true;
        }

        // Validación en tiempo real del asunto
        asunto.addEventListener('input', function() {
            const valor = this.value;
            errorAsunto.classList.add('hidden');
            this.classList.remove('border-red-500');

            if (valor.length > 0) {
                if (!validarLetrasRepetidas(valor)) {
                    errorAsunto.textContent = 'No se permite repetir la misma letra más de 3 veces consecutivas';
                    errorAsunto.classList.remove('hidden');
                    this.classList.add('border-red-500');
                } else if (!validarCaracteresEspeciales(valor)) {
                    errorAsunto.textContent = 'Demasiados caracteres especiales consecutivos';
                    errorAsunto.classList.remove('hidden');
                    this.classList.add('border-red-500');
                } else if (!validarMayusculas(valor)) {
                    errorAsunto.textContent = 'No uses tantas MAYÚSCULAS';
                    errorAsunto.classList.remove('hidden');
                    this.classList.add('border-red-500');
                } else if (!validarEspacios(valor)) {
                    errorAsunto.textContent = 'Demasiados espacios consecutivos';
                    errorAsunto.classList.remove('hidden');
                    this.classList.add('border-red-500');
                }
            }
        });

        // Validación en tiempo real del mensaje
        mensaje.addEventListener('input', function() {
            const valor = this.value;
            errorMensaje.classList.add('hidden');
            this.classList.remove('border-red-500');

            if (valor.length > 0) {
                if (!validarLetrasRepetidas(valor)) {
                    errorMensaje.textContent = 'No se permite repetir la misma letra más de 3 veces consecutivas';
                    errorMensaje.classList.remove('hidden');
                    this.classList.add('border-red-500');
                } else if (!validarCaracteresEspeciales(valor)) {
                    errorMensaje.textContent = 'Demasiados caracteres especiales consecutivos';
                    errorMensaje.classList.remove('hidden');
                    this.classList.add('border-red-500');
                } else if (!validarMayusculas(valor)) {
                    errorMensaje.textContent = 'No uses tantas MAYÚSCULAS en tu mensaje';
                    errorMensaje.classList.remove('hidden');
                    this.classList.add('border-red-500');
                } else if (!validarEspacios(valor)) {
                    errorMensaje.textContent = 'Demasiados espacios consecutivos';
                    errorMensaje.classList.remove('hidden');
                    this.classList.add('border-red-500');
                } else if (!validarNumeros(valor)) {
                    errorMensaje.textContent = 'Demasiados números consecutivos';
                    errorMensaje.classList.remove('hidden');
                    this.classList.add('border-red-500');
                } else if (!validarTextoCoherente(valor)) {
                    errorMensaje.textContent = 'El mensaje debe contener texto coherente';
                    errorMensaje.classList.remove('hidden');
                    this.classList.add('border-red-500');
                }
            }
        });

        // Validación al enviar el formulario
        form.addEventListener('submit', function(e) {
            let errores = [];

            // Validar asunto
            const valorAsunto = asunto.value.trim();
            if (valorAsunto.length < 5) {
                errores.push('El asunto debe tener al menos 5 caracteres');
                asunto.classList.add('border-red-500');
            } else if (!validarLetrasRepetidas(valorAsunto)) {
                errores.push('El asunto contiene letras repetidas más de 3 veces');
                asunto.classList.add('border-red-500');
            } else if (!validarCaracteresEspeciales(valorAsunto)) {
                errores.push('El asunto contiene demasiados caracteres especiales');
                asunto.classList.add('border-red-500');
            } else if (!validarMayusculas(valorAsunto)) {
                errores.push('El asunto contiene demasiadas mayúsculas');
                asunto.classList.add('border-red-500');
            } else if (!validarEspacios(valorAsunto)) {
                errores.push('El asunto contiene demasiados espacios consecutivos');
                asunto.classList.add('border-red-500');
            }

            // Validar tipo
            if (tipo.value === '') {
                errores.push('Debes seleccionar un tipo de consulta');
                tipo.classList.add('border-red-500');
            }

            // Validar comprobante si es pago
            if (tipo.value === 'Pago' && !comprobante.files[0]) {
                errores.push('Debes adjuntar un comprobante de pago');
                contenedorComprobante.querySelector('.border-dashed').classList.add('border-red-500');
            }

            // Validar mensaje
            const valorMensaje = mensaje.value.trim();
            if (valorMensaje.length < 20) {
                errores.push('El mensaje debe tener al menos 20 caracteres');
                mensaje.classList.add('border-red-500');
            } else if (!validarLetrasRepetidas(valorMensaje)) {
                errores.push('El mensaje contiene letras repetidas más de 3 veces');
                mensaje.classList.add('border-red-500');
            } else if (!validarCaracteresEspeciales(valorMensaje)) {
                errores.push('El mensaje contiene demasiados caracteres especiales');
                mensaje.classList.add('border-red-500');
            } else if (!validarMayusculas(valorMensaje)) {
                errores.push('El mensaje contiene demasiadas mayúsculas');
                mensaje.classList.add('border-red-500');
            } else if (!validarEspacios(valorMensaje)) {
                errores.push('El mensaje contiene demasiados espacios consecutivos');
                mensaje.classList.add('border-red-500');
            } else if (!validarNumeros(valorMensaje)) {
                errores.push('El mensaje contiene demasiados números consecutivos');
                mensaje.classList.add('border-red-500');
            } else if (!validarTextoCoherente(valorMensaje)) {
                errores.push('El mensaje debe contener texto coherente');
                mensaje.classList.add('border-red-500');
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

            // Deshabilitar el botón para evitar doble envío
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<svg class="w-5 h-5 inline-block mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Enviando...';
        });

        // Limpiar estilos de error al corregir
        [asunto, tipo, mensaje].forEach(campo => {
            campo.addEventListener('input', function() {
                this.classList.remove('border-red-500');
            });
        });
    });
</script>
@endpush