<!-- Vista AJAX para Asignar Permisos por Módulo -->
<div class="w-full">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 mb-6">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h3 mb-0 text-white font-weight-bold">
                    <i class="fas fa-key mr-2"></i>Asignar Permisos: {{ $role->name }}
                </h1>
                <p class="text-white mb-0 mt-2 opacity-90">Administra los permisos por módulo para este rol</p>
            </div>
            <button type="button" onclick="volverARoles()" class="btn btn-light shadow-sm">
                <i class="fas fa-arrow-left mr-2"></i>Volver a Roles
            </button>
        </div>
    </div>

<script>
function volverARoles() {
    $('#sidebar .ajax-load[data-section="roles"]').trigger('click');
}
</script>

    <form id="formAsignarPermisos">
        @csrf
        
        <!-- Botones de acción superiores -->
        <div class="card shadow-lg border-0 mb-4 bg-gray-800">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex" style="gap: 0.5rem;">
                        <button type="button" 
                                onclick="document.querySelectorAll('input[name=\'permissions[]\']').forEach(cb => cb.checked = true); actualizarContador();"
                                class="btn btn-success btn-sm">
                            <i class="fas fa-check-double mr-1"></i>Seleccionar Todos
                        </button>
                        <button type="button" 
                                onclick="document.querySelectorAll('input[name=\'permissions[]\']').forEach(cb => cb.checked = false); actualizarContador();"
                                class="btn btn-danger btn-sm">
                            <i class="fas fa-times mr-1"></i>Deseleccionar Todos
                        </button>
                    </div>
                    <div class="text-gray-400">
                        <i class="fas fa-info-circle mr-1"></i>
                        <span id="contador-permisos">0 permisos seleccionados</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid de módulos -->
        <div class="row">
            @foreach($permisosPorModulo as $modulo => $permisos)
            <div class="col-lg-6 mb-4">
                <div class="card shadow-lg border-0 bg-gray-800 overflow-hidden">
                    <!-- Header del módulo -->
                    <div class="card-header bg-gradient-to-r from-indigo-700 to-purple-700" 
                         style="cursor: pointer;"
                         data-bs-toggle="collapse" 
                         data-bs-target="#modulo-{{ $modulo }}"
                         aria-expanded="true"
                         aria-controls="modulo-{{ $modulo }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-cube text-white mr-3"></i>
                                <div>
                                    <h5 class="text-white font-weight-bold mb-0">
                                        {{ $nombresModulos[$modulo] ?? ucfirst($modulo) }}
                                    </h5>
                                    <small class="text-white-50">{{ count($permisos) }} permisos disponibles</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center" style="gap: 0.5rem;">
                                <button type="button" 
                                        onclick="event.stopPropagation(); toggleModuleCheckboxes('{{ $modulo }}')"
                                        class="btn btn-sm btn-light">
                                    <i class="fas fa-check-square"></i>
                                </button>
                                <i class="fas fa-chevron-down text-white"></i>
                            </div>
                        </div>
                    </div>
                    <!-- Permisos del módulo -->
                    <div id="modulo-{{ $modulo }}" class="collapse show">
                        <div class="card-body">
                            @foreach($permisos as $permiso)
                            <div class="form-check mb-2 p-2 rounded hover-bg-gray-700">
                                <input type="checkbox" 
                                       class="form-check-input permission-checkbox" 
                                       id="permiso-{{ $permiso->id }}"
                                       name="permissions[]" 
                                       value="{{ $permiso->id }}"
                                       data-module="{{ $modulo }}"
                                       style="cursor: pointer;"
                                       {{ in_array($permiso->id, $permisosActuales) ? 'checked' : '' }}
                                       onchange="actualizarContador()">
                                <label class="form-check-label text-white" for="permiso-{{ $permiso->id }}" style="cursor: pointer;">
                                    {{ $permiso->name }}
                                    @if($permiso->roles->count() > 0)
                                    <small class="text-gray-400 ml-2">
                                        (Usado en {{ $permiso->roles->count() }} rol(es))
                                    </small>
                                    @endif
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Botones de acción inferiores -->
        <div class="card shadow-lg border-0 bg-gray-800 mt-4">
            <div class="card-body">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.configuracion.roles.ajax') }}" 
                       class="ajax-load btn btn-secondary"
                       data-target="#config-content"
                       data-section="roles">
                        <i class="fas fa-times mr-1"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>Guardar Permisos
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    /* Estilos para checkboxes visibles */
    .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0.25em;
        margin-right: 0.5rem;
        cursor: pointer !important;
        border: 2px solid #6b7280;
        background-color: #374151;
    }
    
    .form-check-input:checked {
        background-color: #10b981;
        border-color: #10b981;
    }
    
    .form-check-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25);
    }
    
    .form-check-label {
        cursor: pointer !important;
        user-select: none;
    }
    
    .hover-bg-gray-700:hover {
        background-color: rgba(55, 65, 81, 0.5);
        transition: background-color 0.2s;
    }
    
    /* Asegurar que los acordeones sean visibles */
    .collapse {
        transition: height 0.35s ease;
    }
    
    .collapse.show {
        display: block !important;
        height: auto !important;
        visibility: visible !important;
    }
</style>

<script>
// Función para actualizar contador de permisos seleccionados
function actualizarContador() {
    const total = document.querySelectorAll('input[name="permissions[]"]:checked').length;
    const contador = document.getElementById('contador-permisos');
    if (contador) {
        contador.textContent = total + ' permisos seleccionados';
    }
}

// Función para toggle de checkboxes por módulo
function toggleModuleCheckboxes(modulo) {
    const checkboxes = document.querySelectorAll(`input[data-module="${modulo}"]`);
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    checkboxes.forEach(cb => cb.checked = !allChecked);
    actualizarContador();
}

// Inicializar cuando jQuery esté listo
$(document).ready(function() {
    // Actualizar contador inicial
    setTimeout(function() {
        actualizarContador();
    }, 100);
    
    // Manejar submit del formulario
    $('#formAsignarPermisos').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        
        $.ajax({
            url: '{{ route("admin.configuracion.roles.asignar-permisos", $role->id) }}',
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
                    text: response.message || 'Permisos actualizados correctamente',
                    background: '#1f2937',
                    color: '#fff',
                    confirmButtonColor: '#10b981'
                }).then(() => {
                    // Recargar la lista de roles vía AJAX
                    const rolesLink = $('[data-section="roles"]');
                    if (rolesLink.length) {
                        rolesLink.trigger('click');
                    }
                });
            },
            error: function(xhr) {
                let errorMsg = 'Error al actualizar los permisos';
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
                    color: '#fff'
                });
            }
        });
    });
});
</script>
