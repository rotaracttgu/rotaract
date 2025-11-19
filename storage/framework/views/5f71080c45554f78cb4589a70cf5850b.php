<?php $__env->startSection('header'); ?>
    <div class="flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <a href="<?php echo e(route(($moduloActual ?? 'admin') . '.usuarios.lista')); ?>" class="flex items-center text-gray-600 hover:text-purple-600 transition-colors duration-200 group">
                <div class="bg-white rounded-lg p-2 shadow-md group-hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </div>
                <span class="ml-2 font-medium">Volver a Lista</span>
            </a>
        </div>
        <div>
            <h2 class="text-3xl font-bold bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 bg-clip-text text-transparent text-right">
                ➕ Crear Nuevo Usuario
            </h2>
            <p class="mt-1 text-sm text-gray-600 text-right">
                Completa el formulario para agregar un usuario
            </p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Mensajes de error generales -->
            <?php if($errors->any()): ?>
                <div class="mb-8 rounded-2xl bg-gradient-to-r from-red-500 via-pink-500 to-rose-500 p-5 shadow-2xl transform hover:scale-[1.02] transition-all duration-300 animate-fade-in">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="bg-white rounded-full p-2.5">
                                <svg class="h-7 w-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-white font-semibold text-lg">⚠️ Por favor corrige los siguientes errores:</h3>
                            <ul class="mt-2 text-sm text-white/90 list-disc list-inside space-y-1">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Formulario de Creación -->
            <div class="overflow-hidden rounded-3xl bg-white shadow-2xl ring-1 ring-black/5">
                <!-- Header del formulario -->
                <div class="bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 px-8 py-10">
                    <div class="text-center">
                        <div class="mx-auto h-20 w-20 rounded-full bg-white flex items-center justify-center shadow-xl transform hover:scale-110 transition-transform duration-300">
                            <svg class="h-10 w-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-2xl font-black text-white">Información del Nuevo Usuario</h3>
                        <p class="mt-2 text-white/90 font-medium">Complete todos los campos requeridos para crear la cuenta</p>
                    </div>
                </div>

                <!-- Cuerpo del formulario -->
                <div class="px-8 py-10">
                    <form method="POST" action="<?php echo e(route(($moduloActual ?? 'admin') . '.usuarios.guardar')); ?>" class="space-y-8" id="formCrearUsuario" onsubmit="return validarFormulario('formCrearUsuario')">
                        <?php echo csrf_field(); ?>

                        <!-- Nombre -->
                        <div class="group">
                            <label for="nombre" class="block text-sm font-bold text-gray-700 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Nombre Completo <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-6 w-6 text-gray-400 group-hover:text-purple-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input id="nombre" name="name" type="text" required 
                                    oninput="validarCaracteresRepetidos(this)"
                                    class="block w-full pl-12 pr-4 py-4 text-base border-2 border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    placeholder="Ej: Juan Carlos Pérez López" 
                                    value="<?php echo e(old('name')); ?>">
                                <span class="text-xs text-red-500 hidden mt-1" id="error_nombre">No se permiten más de 2 caracteres repetidos consecutivos</span>
                            </div>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="mt-2 flex items-center text-sm text-red-600 bg-red-50 px-4 py-2 rounded-lg">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><?php echo e($message); ?></span>
                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Email -->
                        <div class="group">
                            <label for="correo" class="block text-sm font-bold text-gray-700 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Correo Electrónico <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-6 w-6 text-gray-400 group-hover:text-purple-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input id="correo" name="email" type="email" required 
                                    class="block w-full pl-12 pr-4 py-4 text-base border-2 border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    placeholder="usuario@ejemplo.com" 
                                    value="<?php echo e(old('email')); ?>">
                            </div>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="mt-2 flex items-center text-sm text-red-600 bg-red-50 px-4 py-2 rounded-lg">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><?php echo e($message); ?></span>
                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Rotary ID -->
                        <div class="group">
                            <label for="rotary_id" class="block text-sm font-bold text-gray-700 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                    Rotary ID
                                </span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-6 w-6 text-gray-400 group-hover:text-purple-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                                <input id="rotary_id" name="rotary_id" type="text"
                                    oninput="validarCaracteresRepetidos(this)"
                                    class="block w-full pl-12 pr-4 py-4 text-base border-2 border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 <?php $__errorArgs = ['rotary_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    placeholder="Ej: R123456" 
                                    value="<?php echo e(old('rotary_id')); ?>">
                                <span class="text-xs text-red-500 hidden mt-1" id="error_rotary_id">No se permiten más de 2 caracteres repetidos consecutivos</span>
                            </div>
                            <?php $__errorArgs = ['rotary_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="mt-2 flex items-center text-sm text-red-600 bg-red-50 px-4 py-2 rounded-lg">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><?php echo e($message); ?></span>
                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Fecha de Juramentación -->
                        <div class="group">
                            <label for="fecha_juramentacion" class="block text-sm font-bold text-gray-700 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Fecha de Juramentación
                                </span>
                            </label>
                            <input id="fecha_juramentacion" name="fecha_juramentacion" type="date"
                                class="block w-full px-4 py-4 text-base border-2 border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                value="<?php echo e(old('fecha_juramentacion')); ?>">
                        </div>

                        <!-- Fecha de Cumpleaños -->
                        <div class="group">
                            <label for="fecha_cumpleaños" class="block text-sm font-bold text-gray-700 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Fecha de Cumpleaños
                                </span>
                            </label>
                            <input id="fecha_cumpleaños" name="fecha_cumpleaños" type="date"
                                class="block w-full px-4 py-4 text-base border-2 border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                value="<?php echo e(old('fecha_cumpleaños')); ?>">
                        </div>

                        <!-- Contraseña -->
                        <div class="group">
                            <label for="contrasena" class="block text-sm font-bold text-gray-700 mb-3">
                                <span class="flex items-center justify-between">
                                    <span class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        Contraseña <span class="text-red-500 ml-1">*</span>
                                    </span>
                                    <button type="button" onclick="generarContrasenaAleatoria()" 
                                        class="px-3 py-1 text-xs bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition-colors font-medium flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Generar Automática
                                    </button>
                                </span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-6 w-6 text-gray-400 group-hover:text-purple-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input id="contrasena" name="password" type="password" required 
                                    class="block w-full pl-12 pr-12 py-4 text-base border-2 border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    placeholder="Mínimo 8 caracteres">
                                <button type="button" onclick="togglePasswordVisibility('contrasena')" 
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-purple-600 transition-colors">
                                    <svg id="icon-show-contrasena" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="icon-hide-contrasena" class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                La contraseña debe tener al menos 8 caracteres. Puedes generarla automáticamente.
                            </p>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="mt-2 flex items-center text-sm text-red-600 bg-red-50 px-4 py-2 rounded-lg">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><?php echo e($message); ?></span>
                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="group">
                            <label for="confirmar_contrasena" class="block text-sm font-bold text-gray-700 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Confirmar Contraseña <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-6 w-6 text-gray-400 group-hover:text-purple-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <input id="confirmar_contrasena" name="password_confirmation" type="password" required 
                                    class="block w-full pl-12 pr-12 py-4 text-base border-2 border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                    placeholder="Repite la contraseña">
                                <button type="button" onclick="togglePasswordVisibility('confirmar_contrasena')" 
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-purple-600 transition-colors">
                                    <svg id="icon-show-confirmar_contrasena" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="icon-hide-confirmar_contrasena" class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Rol del Usuario -->
                        <div class="group">
                            <label for="role" class="block text-sm font-bold text-gray-700 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Rol del Usuario <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-6 w-6 text-gray-400 group-hover:text-purple-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <select id="role" name="role" required
                                    class="block w-full pl-12 pr-4 py-4 text-base border-2 border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> appearance-none bg-white cursor-pointer">
                                    <option value="">Seleccione un rol</option>
                                    <option value="Super Admin" <?php echo e(old('role') == 'Super Admin' ? 'selected' : ''); ?>>🔐 Super Admin</option>
                                    <option value="Presidente" <?php echo e(old('role') == 'Presidente' ? 'selected' : ''); ?>>👑 Presidente</option>
                                    <option value="Vicepresidente" <?php echo e(old('role') == 'Vicepresidente' ? 'selected' : ''); ?>>👔 Vicepresidente</option>
                                    <option value="Tesorero" <?php echo e(old('role') == 'Tesorero' ? 'selected' : ''); ?>>💰 Tesorero</option>
                                    <option value="Secretario" <?php echo e(old('role') == 'Secretario' ? 'selected' : ''); ?>>📝 Secretario</option>
                                    <option value="Vocero" <?php echo e(old('role') == 'Vocero' ? 'selected' : ''); ?>>📢 Vocero</option>
                                    <option value="Aspirante" <?php echo e(old('role') == 'Aspirante' ? 'selected' : ''); ?>>⭐ Aspirante</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="mt-2 flex items-center text-sm text-red-600 bg-red-50 px-4 py-2 rounded-lg">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span><?php echo e($message); ?></span>
                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Estado del Email -->
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6 border-2 border-purple-200">
                            <div class="flex items-start">
                                <div class="flex items-center h-6">
                                    <input type="hidden" name="email_verified" value="0">
                                    <input id="correo_verificado" name="email_verified" value="1" type="checkbox" 
                                        class="h-5 w-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500 focus:ring-2 cursor-pointer" 
                                        <?php echo e(old('email_verified') ? 'checked' : ''); ?>>
                                </div>
                                <div class="ml-4">
                                    <label for="correo_verificado" class="text-sm font-bold text-gray-900 cursor-pointer flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Marcar correo como verificado
                                    </label>
                                    <p class="text-sm text-gray-600 mt-1">Si activas esta opción, el usuario no necesitará verificar su correo electrónico para acceder al sistema</p>
                                </div>
                            </div>
                        </div>

                        <!-- Nuevo: Estado de Verificación 2FA -->
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6 border-2 border-purple-200 mt-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-6">
                                    <input type="hidden" name="two_factor_verified" value="0">
                                    <input id="two_factor_verified" name="two_factor_verified" value="1" type="checkbox" 
                                        class="h-5 w-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500 focus:ring-2 cursor-pointer" 
                                        <?php echo e(old('two_factor_verified') ? 'checked' : ''); ?>>
                                </div>
                                <div class="ml-4">
                                    <label for="two_factor_verified" class="text-sm font-bold text-gray-900 cursor-pointer flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.1.9-2 2-2s2 .9 2 2-2 4-2 4-2-2.9-2-4z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.1-.9-2-2-2s-2 .9-2 2 2 4 2 4 2-2.9 2-4z" />
                                        </svg>
                                        Marcar como verificado para 2FA
                                    </label>
                                    <p class="text-sm text-gray-600 mt-1">Si activas esta opción, el usuario no necesitará verificar con 2FA en el primer inicio de sesión</p>
                                </div>
                            </div>
                        </div>

                        <!-- Estado del Usuario (Activo/Inactivo) -->
                        <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-2xl p-6 border-2 border-green-200 mt-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-6">
                                    <input type="hidden" name="activo" value="0">
                                    <input id="activo" name="activo" value="1" type="checkbox" 
                                        class="h-5 w-5 text-green-600 border-gray-300 rounded focus:ring-green-500 focus:ring-2 cursor-pointer" 
                                        <?php echo e(old('activo', true) ? 'checked' : ''); ?>>
                                </div>
                                <div class="ml-4">
                                    <label for="activo" class="text-sm font-bold text-gray-900 cursor-pointer flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Usuario Activo
                                    </label>
                                    <p class="text-sm text-gray-600 mt-1">Si desactivas esta opción, el usuario no podrá acceder al sistema</p>
                                </div>
                            </div>
                        </div>
                        <!-- Botones -->
                        <div class="flex items-center justify-between pt-8 border-t-2 border-gray-200">
                            <a href="<?php echo e(route(($moduloActual ?? 'admin') . '.usuarios.lista')); ?>" 
                                class="inline-flex items-center px-8 py-4 border-2 border-gray-300 text-base font-bold rounded-2xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancelar
                            </a>
                            <button type="submit" 
                                class="inline-flex items-center px-10 py-4 border border-transparent text-base font-bold rounded-2xl text-white bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 hover:from-pink-600 hover:via-purple-600 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 shadow-xl transition-all duration-200 transform hover:scale-105">
                                <svg class="-ml-1 mr-3 h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                                </svg>
                                Crear Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }

        /* Estilo para el select */
        select {
            background-image: none;
        }
    </style>

    <script>
        // Función para generar contraseña aleatoria segura
        function generarContrasenaAleatoria() {
            const mayusculas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            const minusculas = 'abcdefghijklmnopqrstuvwxyz';
            const numeros = '0123456789';
            const simbolos = '!@#$%&*';
            const todos = mayusculas + minusculas + numeros + simbolos;
            
            let contrasena = '';
            
            // Asegurar al menos un carácter de cada tipo
            contrasena += mayusculas[Math.floor(Math.random() * mayusculas.length)];
            contrasena += minusculas[Math.floor(Math.random() * minusculas.length)];
            contrasena += numeros[Math.floor(Math.random() * numeros.length)];
            contrasena += simbolos[Math.floor(Math.random() * simbolos.length)];
            
            // Completar hasta 12 caracteres con caracteres aleatorios
            for (let i = 4; i < 12; i++) {
                contrasena += todos[Math.floor(Math.random() * todos.length)];
            }
            
            // Mezclar la contraseña
            contrasena = contrasena.split('').sort(() => Math.random() - 0.5).join('');
            
            // Asignar la contraseña a ambos campos
            document.getElementById('contrasena').value = contrasena;
            document.getElementById('confirmar_contrasena').value = contrasena;
            
            // Mostrar la contraseña automáticamente
            document.getElementById('contrasena').type = 'text';
            document.getElementById('icon-show-contrasena').classList.add('hidden');
            document.getElementById('icon-hide-contrasena').classList.remove('hidden');
            
            document.getElementById('confirmar_contrasena').type = 'text';
            document.getElementById('icon-show-confirmar_contrasena').classList.add('hidden');
            document.getElementById('icon-hide-confirmar_contrasena').classList.remove('hidden');
            
            // Animación de éxito
            const passwordInput = document.getElementById('contrasena');
            passwordInput.classList.add('border-green-500', 'bg-green-50');
            setTimeout(() => {
                passwordInput.classList.remove('border-green-500', 'bg-green-50');
            }, 1000);
            
            // Mostrar notificación
            mostrarNotificacion('✓ Contraseña generada correctamente. Asegúrate de copiarla para proporcionarla al usuario.');
        }
        
        // Función para toggle de visibilidad de contraseña
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const iconShow = document.getElementById('icon-show-' + inputId);
            const iconHide = document.getElementById('icon-hide-' + inputId);
            
            if (input.type === 'password') {
                input.type = 'text';
                iconShow.classList.add('hidden');
                iconHide.classList.remove('hidden');
            } else {
                input.type = 'password';
                iconShow.classList.remove('hidden');
                iconHide.classList.add('hidden');
            }
        }
        
        // Función para mostrar notificación temporal
        function mostrarNotificacion(mensaje) {
            // Crear elemento de notificación
            const notificacion = document.createElement('div');
            notificacion.className = 'fixed top-20 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-2xl z-50 animate-fade-in flex items-center gap-3';
            notificacion.innerHTML = `
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">${mensaje}</span>
            `;
            document.body.appendChild(notificacion);
            
            // Eliminar después de 5 segundos
            setTimeout(() => {
                notificacion.style.opacity = '0';
                notificacion.style.transform = 'translateX(400px)';
                notificacion.style.transition = 'all 0.5s ease-out';
                setTimeout(() => notificacion.remove(), 500);
            }, 5000);
        }
        
        // Función de validación de caracteres repetidos
        function validarCaracteresRepetidos(input) {
            const valor = input.value;
            const regex = /(.)\1{2,}/;
            const errorSpan = document.getElementById('error_' + input.id);
            
            if (regex.test(valor)) {
                input.classList.add('border-red-500');
                input.classList.remove('border-gray-300');
                if (errorSpan) {
                    errorSpan.classList.remove('hidden');
                }
                return false;
            } else {
                input.classList.remove('border-red-500');
                input.classList.add('border-gray-300');
                if (errorSpan) {
                    errorSpan.classList.add('hidden');
                }
                return true;
            }
        }

        // Función de validación de formulario completo
        function validarFormulario(formId) {
            const form = document.getElementById(formId);
            const inputs = form.querySelectorAll('input[type="text"]');
            let valid = true;
            
            inputs.forEach(input => {
                if (input.value && !validarCaracteresRepetidos(input)) {
                    valid = false;
                }
            });
            
            if (!valid) {
                alert('Por favor corrige los errores antes de enviar el formulario');
            }
            
            return valid;
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Carlo\Desktop\Club Rotaract-Web Service\Rotaract_Diseño_Web\Rotaract\rotaract\resources\views/modulos/users/create.blade.php ENDPATH**/ ?>