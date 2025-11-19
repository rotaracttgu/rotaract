<!-- Header con Gradiente del Dashboard -->
<div class="bg-gradient-to-r from-red-500 via-pink-600 to-purple-600 p-8 shadow-2xl rounded-2xl mb-8 -mt-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="bg-white/20 rounded-full p-4 backdrop-blur-sm">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
            </div>
            <div>
                <h1 class="text-4xl font-black text-white">👑 Panel de Administración</h1>
                <p class="text-white/90 text-lg font-medium mt-1">Bienvenido al panel de control del Super Admin</p>
            </div>
        </div>
    </div>

    <!-- Fecha y Hora -->
    <div class="mt-4 flex items-center space-x-4 text-white/90">
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="text-sm font-medium">📅 <?php echo e(now()->format('d/m/Y')); ?></span>
        </div>
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-medium">🕐 <?php echo e(now()->format('H:i')); ?></span>
        </div>
    </div>
</div>

<!-- Estadísticas de Usuarios -->
<div class="mb-8">
    <h3 class="text-xl font-bold text-white mb-4 flex items-center">
        <svg class="w-6 h-6 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        Estadísticas de Usuarios
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Usuarios -->
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl p-6 shadow-xl transform hover:scale-105 transition-all duration-200">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <p class="text-blue-200 text-sm font-semibold uppercase mb-2">Total Usuarios</p>
                    <p class="text-4xl font-black text-white"><?php echo e($totalUsuarios ?? 0); ?></p>
                    <p class="text-blue-100 text-sm mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <?php echo e($rolesActivos ?? 0); ?> roles activos
                    </p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Verificados -->
        <div class="bg-gradient-to-br from-green-600 to-green-800 rounded-2xl p-6 shadow-xl transform hover:scale-105 transition-all duration-200">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <p class="text-green-200 text-sm font-semibold uppercase mb-2">Verificados</p>
                    <p class="text-4xl font-black text-white"><?php echo e($verificados ?? 0); ?></p>
                    <div class="mt-2 flex items-center">
                        <div class="flex-1 bg-green-900/50 rounded-full h-2">
                            <div class="bg-green-300 h-2 rounded-full" style="width: <?php echo e($porcentajeVerificados ?? 0); ?>%"></div>
                        </div>
                        <span class="text-green-100 text-sm ml-2 font-bold"><?php echo e($porcentajeVerificados ?? 0); ?>%</span>
                    </div>
                    <p class="text-green-100 text-xs mt-1">Progreso</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pendientes -->
        <div class="bg-gradient-to-br from-orange-600 to-orange-800 rounded-2xl p-6 shadow-xl transform hover:scale-105 transition-all duration-200">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <p class="text-orange-200 text-sm font-semibold uppercase mb-2">Pendientes</p>
                    <p class="text-4xl font-black text-white"><?php echo e($pendientes ?? 8); ?></p>
                    <p class="text-orange-100 text-sm mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Requieren verificación
                    </p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Nuevos Este Mes -->
        <div class="bg-gradient-to-br from-purple-600 to-purple-800 rounded-2xl p-6 shadow-xl transform hover:scale-105 transition-all duration-200">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <p class="text-purple-200 text-sm font-semibold uppercase mb-2">Nuevos Este Mes</p>
                    <p class="text-4xl font-black text-white"><?php echo e($nuevosEsteMes ?? 4); ?></p>
                    <p class="text-purple-100 text-sm mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <?php echo e(now()->format('F Y')); ?>

                    </p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Actividad del Sistema -->
<div class="mb-8">
    <h3 class="text-xl font-bold text-white mb-4 flex items-center">
        <svg class="w-6 h-6 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
        Actividad del Sistema
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Eventos Hoy -->
        <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-2xl p-6 shadow-xl transform hover:scale-105 transition-all duration-200">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <p class="text-indigo-200 text-sm font-semibold uppercase mb-2">Eventos Hoy</p>
                    <p class="text-4xl font-black text-white"><?php echo e($eventosHoy ?? 9); ?></p>
                    <p class="text-indigo-100 text-sm mt-2">📍 Últimas 24h</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Logins Hoy -->
        <div class="bg-gradient-to-br from-cyan-600 to-cyan-800 rounded-2xl p-6 shadow-xl transform hover:scale-105 transition-all duration-200">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <p class="text-cyan-200 text-sm font-semibold uppercase mb-2">Logins Hoy</p>
                    <p class="text-4xl font-black text-white"><?php echo e($loginsHoy ?? 4); ?></p>
                    <p class="text-cyan-100 text-sm mt-2">🔐 Accesos exitosos</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8 text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Errores Hoy -->
        <div class="bg-gradient-to-br from-red-600 to-red-800 rounded-2xl p-6 shadow-xl transform hover:scale-105 transition-all duration-200">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <p class="text-red-200 text-sm font-semibold uppercase mb-2">Errores Hoy</p>
                    <p class="text-4xl font-black text-white"><?php echo e($erroresHoy ?? 0); ?></p>
                    <p class="text-red-100 text-sm mt-2">✅ Sin problemas</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Eventos -->
        <div class="bg-gradient-to-br from-gray-700 to-gray-900 rounded-2xl p-6 shadow-xl transform hover:scale-105 transition-all duration-200">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <p class="text-gray-300 text-sm font-semibold uppercase mb-2">Total Eventos</p>
                    <p class="text-4xl font-black text-white"><?php echo e($totalEventos ?? 390); ?></p>
                    <p class="text-gray-400 text-sm mt-2">📊 Historial completo</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Distribución por Rol -->
<div class="bg-gray-800 rounded-2xl shadow-xl p-6">
    <h3 class="text-xl font-bold text-white mb-4 flex items-center">
        <svg class="w-6 h-6 mr-2 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        Distribución por Rol
    </h3>
    
    <div class="space-y-3">
        <?php
        $roles = [
            ['nombre' => 'Super Admin', 'cantidad' => 2, 'porcentaje' => 18.2, 'color' => 'red'],
            ['nombre' => 'Presidente', 'cantidad' => 1, 'porcentaje' => 9.1, 'color' => 'blue'],
            ['nombre' => 'Vicepresidente', 'cantidad' => 1, 'porcentaje' => 9.1, 'color' => 'indigo'],
            ['nombre' => 'Tesorero', 'cantidad' => 2, 'porcentaje' => 18.2, 'color' => 'green'],
            ['nombre' => 'Secretario', 'cantidad' => 1, 'porcentaje' => 9.1, 'color' => 'pink'],
            ['nombre' => 'Vocero', 'cantidad' => 2, 'porcentaje' => 18.2, 'color' => 'orange'],
            ['nombre' => 'Aspirante', 'cantidad' => 2, 'porcentaje' => 18.2, 'color' => 'purple'],
        ];
        ?>

        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="flex items-center space-x-4">
            <div class="w-32">
                <span class="text-sm font-semibold text-gray-300"><?php echo e($rol['nombre']); ?></span>
            </div>
            <div class="flex-1">
                <div class="flex items-center space-x-2">
                    <div class="flex-1 bg-gray-700 rounded-full h-3">
                        <div class="bg-<?php echo e($rol['color']); ?>-500 h-3 rounded-full transition-all duration-500" style="width: <?php echo e($rol['porcentaje']); ?>%"></div>
                    </div>
                    <span class="text-sm font-bold text-gray-300 w-12 text-right"><?php echo e($rol['cantidad']); ?></span>
                    <span class="text-xs text-gray-500 w-16 text-right"><?php echo e($rol['porcentaje']); ?>%</span>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<!-- Usuarios Más Activos (7 días) -->
<div class="mt-8 bg-gray-800 rounded-2xl shadow-xl p-6">
    <h3 class="text-xl font-bold text-white mb-4 flex items-center">
        <svg class="w-6 h-6 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
        Usuarios Más Activos (7 días)
    </h3>
    
    <div class="overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-900">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-300 uppercase">Usuario</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-300 uppercase">Rol</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-300 uppercase">Actividad</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-300 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                <?php
                $usuariosActivos = [
                    ['nombre' => 'Rodrigo Palma', 'rol' => 'Super Admin', 'actividad' => '247 acciones'],
                    ['nombre' => 'Juan Pérez', 'rol' => 'Presidente', 'actividad' => '156 acciones'],
                    ['nombre' => 'María García', 'rol' => 'Tesorero', 'actividad' => '142 acciones'],
                ];
                ?>

                <?php $__empty_1 = true; $__currentLoopData = $usuariosActivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-700/50 transition-colors">
                    <td class="px-4 py-3">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center text-white text-sm font-bold">
                                <?php echo e(strtoupper(substr($usuario['nombre'], 0, 2))); ?>

                            </div>
                            <span class="ml-3 text-sm font-semibold text-gray-200"><?php echo e($usuario['nombre']); ?></span>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-purple-900/50 text-purple-200">
                            <?php echo e($usuario['rol']); ?>

                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="text-sm text-gray-400"><?php echo e($usuario['actividad']); ?></span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <button class="text-indigo-400 hover:text-indigo-300 text-sm font-semibold">
                            Ver detalles →
                        </button>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                        No hay datos de actividad disponibles
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH C:\Users\Carlo\Desktop\Club Rotaract-Web Service\Rotaract_Diseño_Web\Rotaract\rotaract\resources\views/modulos/admin/partials/overview.blade.php ENDPATH**/ ?>