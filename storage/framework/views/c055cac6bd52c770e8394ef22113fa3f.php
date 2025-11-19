<?php if(!isset($isAjax) || !$isAjax): ?>
    
    <?php $__env->startSection('content'); ?>
<?php endif; ?>

<!-- Vista AJAX para Crear Rol -->
<div class="w-full">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 mb-6">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h3 mb-0 text-white font-weight-bold">
                    <i class="fas fa-plus-circle mr-2"></i>Crear Nuevo Rol
                </h1>
                <p class="text-white mb-0 mt-2 opacity-90">Define un nuevo rol y asigna sus permisos</p>
            </div>
            <button type="button" onclick="volverARoles()" class="btn btn-light shadow-sm">
                <i class="fas fa-arrow-left mr-2"></i>Volver a Roles
            </button>
        </div>
    </div>

    <form id="formCrearRol">
        <?php echo csrf_field(); ?>
        
        <div class="row">
            <!-- Información básica del rol -->
            <div class="col-md-4">
                <div class="card shadow-lg border-0 mb-4 bg-gray-800">
                    <div class="card-header bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-info-circle mr-2"></i>Información del Rol
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="font-weight-bold text-white">
                                Nombre del Rol <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="name" 
                                   name="name" 
                                   placeholder="Ej: TÉCNICO, OFICIAL, COORDINADOR, etc."
                                   style="background-color: #374151; color: white; border-color: #4b5563;"
                                   required
                                   minlength="3"
                                   maxlength="50">
                            <div id="name-validation" class="mt-2" style="display: none;"></div>
                            <small class="form-text text-gray-400">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Nombre único del rol (3-50 caracteres, mayúsculas recomendadas)
                            </small>
                            <small class="form-text text-info d-block mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                <strong>Sugerencias:</strong> TÉCNICO, OFICIAL, COORDINADOR, DIRECTOR, GERENTE, ANALISTA, SUPERVISOR, ESPECIALISTA
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="guard_name" class="font-weight-bold text-white">Guard</label>
                            <select class="form-control" 
                                    id="guard_name" 
                                    name="guard_name"
                                    style="background-color: #374151; color: white; border-color: #4b5563;">
                                <option value="web">Web</option>
                                <option value="api">API</option>
                            </select>
                            <small class="form-text text-gray-400">
                                Tipo de autenticación (normalmente "web")
                            </small>
                        </div>

                        <div class="alert alert-info border-0">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Nota:</strong> Selecciona los permisos que tendrá este rol en la sección de la derecha.
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="card shadow-lg border-0 bg-gray-800">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-sm">
                            <i class="fas fa-save mr-2"></i>Guardar Rol
                        </button>
                        <button type="button" onclick="volverARoles()" class="btn btn-secondary btn-block mt-2">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Permisos disponibles -->
            <div class="col-md-8">
                <div class="card shadow-lg border-0 bg-gray-800">
                    <div class="card-header bg-gradient-to-r from-green-600 to-teal-600 text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-key mr-2"></i>Asignar Permisos
                            </h6>
                            <div>
                                <button type="button" class="btn btn-sm btn-light" onclick="selectAll()">
                                    <i class="fas fa-check-double mr-1"></i>Seleccionar Todos
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-light" onclick="deselectAll()">
                                    <i class="fas fa-times mr-1"></i>Deseleccionar Todos
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <?php if($permissions->count() > 0): ?>
                            <div class="accordion" id="permissionsAccordion">
                                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modulo => $perms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border-bottom border-gray-700">
                                    <div class="p-3 bg-gray-700" id="heading<?php echo e($loop->index); ?>">
                                        <h6 class="mb-0">
                                            <button class="btn btn-link btn-block text-left d-flex justify-content-between align-items-center text-decoration-none text-white" 
                                                    type="button" 
                                                    data-toggle="collapse" 
                                                    data-target="#collapse<?php echo e($loop->index); ?>"
                                                    aria-expanded="<?php echo e($loop->first ? 'true' : 'false'); ?>">
                                                <span class="font-weight-bold">
                                                    <?php
                                                        $iconos = [
                                                            'dashboard' => 'fa-chart-line',
                                                            'usuarios' => 'fa-users',
                                                            'roles' => 'fa-user-tag',
                                                            'permisos' => 'fa-key',
                                                            'presidente' => 'fa-crown',
                                                            'vicepresidente' => 'fa-user-tie',
                                                            'tesorero' => 'fa-coins',
                                                            'secretaria' => 'fa-file-alt',
                                                            'vocero' => 'fa-megaphone',
                                                            'socio' => 'fa-user',
                                                            'proyectos' => 'fa-project-diagram',
                                                            'finanzas' => 'fa-dollar-sign',
                                                            'eventos' => 'fa-calendar-alt',
                                                            'actas' => 'fa-file-contract',
                                                            'asistencias' => 'fa-user-check',
                                                            'bitacora' => 'fa-history',
                                                            'backup' => 'fa-database'
                                                        ];
                                                        $icono = $iconos[$modulo] ?? 'fa-folder-open';
                                                        
                                                        $nombres = [
                                                            'dashboard' => 'Panel de Control',
                                                            'usuarios' => 'Gestión de Usuarios',
                                                            'roles' => 'Gestión de Roles',
                                                            'permisos' => 'Gestión de Permisos',
                                                            'presidente' => 'Módulo Presidente',
                                                            'vicepresidente' => 'Módulo Vicepresidente',
                                                            'tesorero' => 'Módulo Tesorero',
                                                            'secretaria' => 'Módulo Secretaría',
                                                            'vocero' => 'Módulo Vocero',
                                                            'socio' => 'Módulo Socio',
                                                            'proyectos' => 'Gestión de Proyectos',
                                                            'finanzas' => 'Gestión Financiera',
                                                            'eventos' => 'Gestión de Eventos',
                                                            'actas' => 'Gestión de Actas',
                                                            'asistencias' => 'Control de Asistencias',
                                                            'bitacora' => 'Registro de Actividad',
                                                            'backup' => 'Respaldos del Sistema'
                                                        ];
                                                        $nombreModulo = $nombres[$modulo] ?? ucfirst($modulo);
                                                    ?>
                                                    <i class="fas <?php echo e($icono); ?> text-purple-400 mr-2"></i>
                                                    <?php echo e($nombreModulo); ?>

                                                </span>
                                                <span class="badge badge-primary badge-pill"><?php echo e($perms->count()); ?> permisos</span>
                                            </button>
                                        </h6>
                                    </div>

                                    <div id="collapse<?php echo e($loop->index); ?>" 
                                         class="collapse <?php echo e($loop->first ? 'show' : ''); ?>" 
                                         data-parent="#permissionsAccordion">
                                        <div class="p-3">
                                            <div class="row">
                                                <?php $__currentLoopData = $perms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" 
                                                               class="form-check-input permission-checkbox" 
                                                               id="permission<?php echo e($permission->id); ?>"
                                                               name="permissions[]" 
                                                               value="<?php echo e($permission->id); ?>"
                                                               style="cursor: pointer;">
                                                        <label class="form-check-label text-white" for="permission<?php echo e($permission->id); ?>" style="cursor: pointer; user-select: none;">
                                                            <i class="fas fa-shield-alt text-green-400 mr-1"></i>
                                                            <?php echo e($permission->name); ?>

                                                        </label>
                                                    </div>
                                                </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="p-5 text-center text-gray-400">
                                <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                                <p>No hay permisos disponibles en el sistema.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    /* Asegurar que los checkboxes sean visibles y clickeables */
    .form-check-input {
        width: 20px;
        height: 20px;
        margin-top: 0.15rem;
        cursor: pointer !important;
        position: relative;
        z-index: 1;
    }
    
    .form-check-label {
        padding-left: 0.5rem;
        cursor: pointer !important;
        user-select: none;
    }
    
    .form-check {
        padding-left: 1.5rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }
    
    /* Hover effect en los checkboxes */
    .form-check:hover {
        background-color: rgba(124, 58, 237, 0.1);
        border-radius: 0.375rem;
        padding: 0.25rem;
        margin-left: -0.25rem;
        transition: all 0.2s ease;
    }
    
    /* Efecto visual al seleccionar */
    .form-check-input:checked + .form-check-label {
        color: #10b981 !important;
        font-weight: 600;
    }
</style>

<script>
function volverARoles() {
    $('#sidebar .ajax-load[data-section="roles"]').trigger('click');
}

$(document).ready(function() {
    // ⭐ Validación en tiempo real del nombre del rol
    let timeoutId = null;
    $('#name').on('input', function() {
        const value = $(this).val().trim();
        const validationDiv = $('#name-validation');
        
        // Limpiar timeout anterior
        if (timeoutId) clearTimeout(timeoutId);
        
        // Si tiene menos de 2 caracteres, no hacer nada
        if (value.length < 2) {
            validationDiv.hide();
            return;
        }
        
        // Validación local inmediata
        if (value.length < 3) {
            validationDiv.html(`
                <div class="alert alert-warning py-2 mb-0">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    El nombre debe tener al menos 3 caracteres (actual: ${value.length})
                </div>
            `).show();
            return;
        }
        
        // Verificar que no sea solo espacios
        if (value.length >= 3 && !value.match(/\S{3,}/)) {
            validationDiv.html(`
                <div class="alert alert-danger py-2 mb-0">
                    <i class="fas fa-times-circle mr-2"></i>
                    El nombre debe contener caracteres válidos
                </div>
            `).show();
            return;
        }
        
        // Mostrar OK si cumple requisitos básicos
        validationDiv.html(`
            <div class="alert alert-success py-2 mb-0">
                <i class="fas fa-check-circle mr-2"></i>
                Formato válido (${value.length} caracteres)
            </div>
        `).show();
    });
    
    // ⭐ Contador de permisos seleccionados
    function actualizarContador() {
        const total = $('.permission-checkbox').length;
        const seleccionados = $('.permission-checkbox:checked').length;
        
        // Actualizar en el botón de guardar
        const btnSubmit = $('button[type="submit"]');
        if (seleccionados === 0) {
            btnSubmit.html('<i class="fas fa-exclamation-triangle mr-2"></i>Guardar sin permisos');
            btnSubmit.removeClass('btn-primary').addClass('btn-warning');
        } else {
            btnSubmit.html(`<i class="fas fa-save mr-2"></i>Guardar Rol (${seleccionados} permisos)`);
            btnSubmit.removeClass('btn-warning').addClass('btn-primary');
        }
    }
    
    // Ejecutar al cargar y al cambiar checkboxes
    $('.permission-checkbox').on('change', actualizarContador);
    actualizarContador();
    
    $('#formCrearRol').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        
        // Mostrar loading
        Swal.fire({
            title: 'Guardando...',
            text: 'Por favor espera',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            },
            background: '#1f2937',
            color: '#fff'
        });
        
        $.ajax({
            url: '<?php echo e(route("admin.configuracion.roles.store")); ?>',
            method: 'POST',
            data: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: response.message || 'Rol creado correctamente',
                    background: '#1f2937',
                    color: '#fff',
                    confirmButtonColor: '#10b981',
                    timer: 2000
                }).then(() => {
                    volverARoles();
                });
            },
            error: function(xhr) {
                let errorMsg = 'Error al crear el rol';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: errorMsg,
                    background: '#1f2937',
                    color: '#fff',
                    confirmButtonColor: '#dc3545'
                });
            }
        });
    });
});

function selectAll() {
    $('.permission-checkbox').prop('checked', true);
}

function deselectAll() {
    $('.permission-checkbox').prop('checked', false);
}
</script>


<?php if(!isset($isAjax) || !$isAjax): ?>
    <?php $__env->stopSection(); ?>
<?php endif; ?>
<?php echo $__env->make('layouts.app-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Carlo\Desktop\Club Rotaract-Web Service\Rotaract_Diseño_Web\Rotaract\rotaract\resources\views/modulos/admin/configuracion/roles/create.blade.php ENDPATH**/ ?>