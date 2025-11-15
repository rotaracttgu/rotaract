<!-- Vista AJAX para Crear Rol -->
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-700 rounded-lg shadow-lg p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 text-white font-weight-bold">
                    <i class="fas fa-plus-circle mr-2"></i>Crear Nuevo Rol
                </h1>
                <p class="text-white mb-0 mt-1 opacity-75">Define un nuevo rol y asigna sus permisos</p>
            </div>
            <button type="button" onclick="$('[data-section=\'roles\']').trigger('click')" class="btn btn-light shadow-sm">
                <i class="fas fa-arrow-left mr-1"></i>Volver
            </button>
        </div>
    </div>

    <form id="formCrearRol">
        @csrf
        
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
                                   placeholder="Ej: TÉCNICO, OFICIAL, etc."
                                   required>
                            <small class="form-text text-gray-400">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Nombre único del rol (mayúsculas recomendadas)
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="guard_name" class="font-weight-bold text-white">Guard</label>
                            <select class="form-control bg-gray-700 text-white border-gray-600" 
                                    id="guard_name" 
                                    name="guard_name">
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
                                                    aria-expanded="true">
                                                <span class="font-weight-bold">
                                                    <i class="fas fa-folder-open text-purple-400 mr-2"></i>
                                                    {{ ucfirst($modulo) }}
                                                </span>
                                                <span class="badge badge-primary badge-pill">{{ $perms->count() }} permisos</span>
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
                                                               value="{{ $permission->id }}">
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
    $('#formCrearRol').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        
        $.ajax({
            url: '{{ route("admin.configuracion.roles.store") }}',
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
                    text: 'Rol creado correctamente',
                    background: '#1f2937',
                    color: '#fff',
                    confirmButtonColor: '#10b981'
                }).then(() => {
                    $('[data-section="roles"]').trigger('click');
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