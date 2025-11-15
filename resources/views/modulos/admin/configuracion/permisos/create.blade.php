<!-- Vista AJAX para Crear Permiso -->
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 via-teal-600 to-cyan-700 rounded-lg shadow-lg p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 text-white font-weight-bold">
                    <i class="fas fa-plus-circle mr-2"></i>Crear Nuevo Permiso
                </h1>
                <p class="text-white mb-0 mt-1 opacity-75">Define un nuevo permiso para el sistema</p>
            </div>
            <button type="button" onclick="$('[data-section=\'permisos\']').trigger('click')" class="btn btn-light shadow-sm">
                <i class="fas fa-arrow-left mr-1"></i>Volver
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <form id="formCrearPermiso">
                @csrf
                
                <div class="card shadow-lg border-0 mb-4 bg-gray-800">
                    <div class="card-header bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-info-circle mr-2"></i>Información del Permiso
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="font-weight-bold text-white">
                                Nombre del Permiso <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control bg-gray-700 text-white border-gray-600" 
                                   id="name" 
                                   name="name" 
                                   placeholder="Ej: usuarios.ver, roles.crear, etc."
                                   required>
                            <small class="form-text text-gray-400">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Usa el formato: modulo.accion (ej: usuarios.crear, proyectos.editar)
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
                        </div>
                    </div>
                </div>

                <!-- Asignar a roles -->
                <div class="card shadow-lg border-0 mb-4 bg-gray-800">
                    <div class="card-header bg-gradient-to-r from-purple-600 to-pink-600 text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-user-tag mr-2"></i>Asignar a Roles (Opcional)
                            </h6>
                            <div>
                                <button type="button" class="btn btn-sm btn-light" onclick="selectAllRoles()">
                                    <i class="fas fa-check-double"></i> Todos
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-light" onclick="deselectAllRoles()">
                                    <i class="fas fa-times"></i> Ninguno
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($roles as $role)
                            <div class="col-md-6 mb-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" 
                                           class="custom-control-input role-checkbox" 
                                           id="role{{ $role->id }}"
                                           name="roles[]" 
                                           value="{{ $role->id }}">
                                    <label class="custom-control-label text-white" for="role{{ $role->id }}">
                                        <i class="fas fa-shield-alt text-purple-400 mr-1"></i>
                                        <strong>{{ $role->name }}</strong>
                                    </label>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <p class="text-gray-400 text-center">No hay roles disponibles</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="card shadow-lg border-0 bg-gray-800">
                    <div class="card-body">
                        <button type="submit" class="btn btn-success btn-lg btn-block shadow-sm">
                            <i class="fas fa-save mr-2"></i>Guardar Permiso
                        </button>
                        <button type="button" onclick="$('[data-section=\'permisos\']').trigger('click')" class="btn btn-secondary btn-block mt-2">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Panel lateral con ayuda -->
        <div class="col-md-4">
            <div class="card shadow-lg border-0 mb-4 bg-gray-800">
                <div class="card-header bg-gradient-to-r from-yellow-600 to-orange-600 text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-question-circle mr-2"></i>Ayuda
                    </h6>
                </div>
                <div class="card-body">
                    <h6 class="font-weight-bold text-white mb-3">Convención de Nombres</h6>
                    <p class="small mb-3 text-gray-300">Los permisos deben seguir el formato:</p>
                    <div class="alert alert-dark border">
                        <code class="text-green-400">modulo.accion</code>
                    </div>
                    
                    <h6 class="font-weight-bold text-white mb-2 mt-4">Ejemplos:</h6>
                    <ul class="small text-gray-300">
                        <li><code class="text-green-400">usuarios.ver</code></li>
                        <li><code class="text-green-400">usuarios.crear</code></li>
                        <li><code class="text-green-400">usuarios.editar</code></li>
                        <li><code class="text-green-400">usuarios.eliminar</code></li>
                        <li><code class="text-green-400">proyectos.ver</code></li>
                        <li><code class="text-green-400">finanzas.aprobar</code></li>
                    </ul>
                </div>
            </div>

            <!-- Módulos disponibles -->
            <div class="card shadow-lg border-0 bg-gray-800">
                <div class="card-header bg-gradient-to-r from-blue-600 to-cyan-600 text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-th-large mr-2"></i>Módulos del Sistema
                    </h6>
                </div>
                <div class="card-body">
                    @foreach($modulos as $key => $nombre)
                    <div class="mb-2">
                        <span class="badge badge-primary">{{ $key }}</span>
                        <small class="text-gray-300 ml-2">{{ $nombre }}</small>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Interceptar el submit del formulario
    $('#formCrearPermiso').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        
        $.ajax({
            url: '{{ route("admin.configuracion.permisos.store") }}',
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
                    text: 'Permiso creado correctamente',
                    background: '#1f2937',
                    color: '#fff',
                    confirmButtonColor: '#10b981'
                }).then(() => {
                    // Recargar la lista de permisos vía AJAX
                    $('[data-section="permisos"]').trigger('click');
                });
            },
            error: function(xhr) {
                let errorMsg = 'Error al crear el permiso';
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

function selectAllRoles() {
    $('.role-checkbox').prop('checked', true);
}

function deselectAllRoles() {
    $('.role-checkbox').prop('checked', false);
}
</script>