{{-- Extender layout solo si no es AJAX --}}
@if(!isset($isAjax) || !$isAjax)
    @extends('layouts.app-admin')
    @section('content')
@endif

<!-- Vista AJAX para Editar Rol -->
<div class="w-full">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 mb-6">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h3 mb-0 text-white font-weight-bold">
                    <i class="fas fa-edit mr-2"></i>Editar Rol: {{ $role->name }}
                </h1>
                <p class="text-white mb-0 mt-2 opacity-90">Modifica la información y permisos del rol</p>
            </div>
            <button type="button" onclick="volverARoles()" class="btn btn-light shadow-sm">
                <i class="fas fa-arrow-left mr-2"></i>Volver a Roles
            </button>
        </div>
    </div>

    <form id="formEditarRol">
        @csrf
        @method('PUT')
        
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
                                   value="{{ $role->name }}"
                                   placeholder="Ej: TÉCNICO, OFICIAL, etc."
                                   style="background-color: #374151; color: white; border-color: #4b5563;"
                                   required>
                            <small class="form-text text-gray-400">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Nombre único del rol
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="guard_name" class="font-weight-bold text-white">Guard</label>
                            <select class="form-control" 
                                    id="guard_name" 
                                    name="guard_name"
                                    style="background-color: #374151; color: white; border-color: #4b5563;">
                                <option value="web" {{ $role->guard_name == 'web' ? 'selected' : '' }}>Web</option>
                                <option value="api" {{ $role->guard_name == 'api' ? 'selected' : '' }}>API</option>
                            </select>
                        </div>

                        <!-- Información adicional -->
                        <div class="alert alert-dark border">
                            <h6 class="font-weight-bold mb-2 text-white">
                                <i class="fas fa-chart-bar text-purple-400 mr-2"></i>Estadísticas
                            </h6>
                            <div class="d-flex justify-content-between mb-2 text-gray-300">
                                <span>Permisos asignados:</span>
                                <span class="badge badge-primary badge-pill">{{ $role->permissions->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 text-gray-300">
                                <span>Usuarios con este rol:</span>
                                <span class="badge badge-success badge-pill">{{ $role->users->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-between text-gray-400">
                                <span>Creado:</span>
                                <small>{{ $role->created_at->format('d/m/Y') }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="card shadow-lg border-0 bg-gray-800">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-sm">
                            <i class="fas fa-save mr-2"></i>Actualizar Rol
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
                                <i class="fas fa-key mr-2"></i>Gestionar Permisos
                            </h6>
                            <div>
                                <button type="button" class="btn btn-sm btn-light" onclick="selectAll()">
                                    <i class="fas fa-check-double mr-1"></i>Todos
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-light" onclick="deselectAll()">
                                    <i class="fas fa-times mr-1"></i>Ninguno
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if($permissions->count() > 0)
                            <div class="accordion" id="permissionsAccordion">
                                @foreach($permissions as $modulo => $perms)
                                <div class="border-bottom border-gray-700">
                                    <div class="p-3 bg-gray-700" id="heading{{ $loop->index }}">
                                        <h6 class="mb-0">
                                            <button class="btn btn-link btn-block text-left d-flex justify-content-between align-items-center text-decoration-none text-white" 
                                                    type="button" 
                                                    data-toggle="collapse" 
                                                    data-target="#collapse{{ $loop->index }}"
                                                    aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                                                <span class="font-weight-bold">
                                                    @php
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
                                                    @endphp
                                                    <i class="fas {{ $icono }} text-purple-400 mr-2"></i>
                                                    {{ $nombreModulo }}
                                                </span>
                                                <div>
                                                    <span class="badge badge-success badge-pill mr-2">
                                                        {{ $perms->whereIn('id', $rolePermissions)->count() }} activos
                                                    </span>
                                                    <span class="badge badge-secondary badge-pill">
                                                        {{ $perms->count() }} total
                                                    </span>
                                                </div>
                                            </button>
                                        </h6>
                                    </div>

                                    <div id="collapse{{ $loop->index }}" 
                                         class="collapse {{ $loop->first ? 'show' : '' }}" 
                                         data-parent="#permissionsAccordion">
                                        <div class="p-3">
                                            <div class="row">
                                                @foreach($perms as $permission)
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" 
                                                               class="form-check-input permission-checkbox" 
                                                               id="permission{{ $permission->id }}"
                                                               name="permissions[]" 
                                                               value="{{ $permission->id }}"
                                                               {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                                               style="cursor: pointer;">
                                                        <label class="form-check-label text-white" for="permission{{ $permission->id }}" style="cursor: pointer; user-select: none;">
                                                            <i class="fas fa-shield-alt text-green-400 mr-1"></i>
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-5 text-center text-gray-400">
                                <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                                <p>No hay permisos disponibles en el sistema.</p>
                            </div>
                        @endif
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
    // ⭐ Contador de permisos seleccionados
    function actualizarContador() {
        const total = $('.permission-checkbox').length;
        const seleccionados = $('.permission-checkbox:checked').length;
        
        // Actualizar en el botón de guardar
        const btnSubmit = $('button[type="submit"]');
        if (seleccionados === 0) {
            btnSubmit.html('<i class="fas fa-exclamation-triangle mr-2"></i>Actualizar sin permisos');
            btnSubmit.removeClass('btn-primary').addClass('btn-warning');
        } else {
            btnSubmit.html(`<i class="fas fa-save mr-2"></i>Actualizar Rol (${seleccionados} permisos)`);
            btnSubmit.removeClass('btn-warning').addClass('btn-primary');
        }
    }
    
    // Ejecutar al cargar y al cambiar checkboxes
    $('.permission-checkbox').on('change', actualizarContador);
    actualizarContador();
    
    $('#formEditarRol').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        
        // Mostrar loading
        Swal.fire({
            title: 'Actualizando...',
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
            url: '{{ route("admin.configuracion.roles.update", $role->id) }}',
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
                    text: response.message || 'Rol actualizado correctamente',
                    background: '#1f2937',
                    color: '#fff',
                    confirmButtonColor: '#10b981',
                    timer: 2000
                }).then(() => {
                    volverARoles();
                });
            },
            error: function(xhr) {
                let errorMsg = 'Error al actualizar el rol';
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

{{-- Cerrar section solo si no es AJAX --}}
@if(!isset($isAjax) || !$isAjax)
    @endsection
@endif