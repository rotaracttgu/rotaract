<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-gray-900 to-indigo-950 -mt-5">
    
    <!-- Contenido Principal -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="space-y-6">
            
            <!-- ⭐ Contenedor para carga AJAX (Roles, Permisos, etc.) -->
            <div id="config-content" class="min-h-screen">
                <!-- Por defecto muestra el overview, AJAX cargará aquí Roles/Permisos -->
                <?php echo $__env->make('modulos.admin.partials.overview', [
                    'totalUsuarios' => $totalUsuarios ?? 0,
                    'verificados' => $verificados ?? 0,
                    'pendientes' => $pendientes ?? 0,
                    'nuevosEsteMes' => $nuevosEsteMes ?? 0,
                    'porcentajeVerificados' => $porcentajeVerificados ?? 0,
                    'rolesActivos' => $rolesActivos ?? 0,
                    'eventosHoy' => $eventosHoy ?? 0,
                    'loginsHoy' => $loginsHoy ?? 0,
                    'erroresHoy' => $erroresHoy ?? 0,
                    'totalEventos' => $totalEventos ?? 0
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Carlo\Desktop\Club Rotaract-Web Service\Rotaract_Diseño_Web\Rotaract\rotaract\resources\views/modulos/admin/dashboard-nuevo.blade.php ENDPATH**/ ?>