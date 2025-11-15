<!-- Vista AJAX para Editar Rol -->
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-700 rounded-lg shadow-lg p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 text-white font-weight-bold">
                    <i class="fas fa-edit mr-2"></i>Editar Rol: {{ $role->name }}
                </h1>
                <p class="text-white mb-0 mt-1 opacity-75">Modifica la información y permisos del rol</p>
            </div>
            <button type="button" onclick="$('[data-section=\'roles\']').trigger('click')" class="btn btn-light shadow-sm">
                <i class="fas fa-arrow-left mr-1"></i>Volver
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
                                   class="form-control bg-gray-700 text-white border-gray-600" 
                                   id="name" 
                                   name="name" 
                                   value="{{ $role->name }}"
                                   placeholder="Ej: TÉCNICO, OFICIAL, etc."
                                   required>
                            <small class="form-text text-gray-400">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Nombre único del rol
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="guard_name" class="font-weight-bold text-white">Guard</label>
                            <select class="form-control bg-gray-700 text-white border-gray-600" 
                                    id="guard_name" 
                                    name="guard_name">
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
                        <button type="button" onclick="$('[data-section=\'roles\']').trigger('click')" class="btn btn-secondary btn-block mt-2">
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
                                                    <i class="fas fa-folder-open text-purple-400 mr-2"></i>
                                                    {{ ucfirst($modulo) }}
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
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" 
                                                               class="custom-control-input permission-checkbox" 
                                                               id="permission{{ $permission->id }}"
                                                               name="permissions[]" 
                                                               value="{{ $permission->id }}"
                                                               {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                        <label class="custom-control-label text-white" for="permission{{ $permission->id }}">
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

<script>
$(document).ready(function() {
    $('#formEditarRol').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        
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
                    text: 'Rol actualizado correctamente',
                    background: '#1f2937',
                    color: '#fff',
                    confirmButtonColor: '#10b981'
                }).then(() => {
                    $('[data-section="roles"]').trigger('click');
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
                    color: '#fff'
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