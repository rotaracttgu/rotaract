{{-- Extender layout solo si no es AJAX --}}
@if(!isset($isAjax) || !$isAjax)
    @extends('layouts.app-admin')
    @section('content')
@endif

<!-- Vista AJAX para Editar Permiso -->
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 via-teal-600 to-cyan-700 rounded-lg shadow-lg p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 text-white font-weight-bold">
                    <i class="fas fa-edit mr-2"></i>Editar Permiso: {{ $permiso->name }}
                </h1>
                <p class="text-white mb-0 mt-1 opacity-75">Modifica la información del permiso</p>
            </div>
            <button type="button" onclick="volverAPermisos()" class="btn btn-light shadow-sm">
                <i class="fas fa-arrow-left mr-2"></i>Volver a Permisos
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <form id="formEditarPermiso">
                @csrf
                @method('PUT')
                
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
                                   class="form-control" 
                                   id="name" 
                                   name="name" 
                                   value="{{ $permiso->name }}"
                                   placeholder="Ej: usuarios.ver, roles.crear"
                                   style="background-color: #374151; color: white; border-color: #4b5563;"
                                   required>
                            <div id="name-validation-permisos"></div>
                            <small class="form-text text-gray-400">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Formato: modulo.accion (Ejemplos: usuarios.ver, proyectos.crear, finanzas.aprobar)
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="guard_name" class="font-weight-bold text-white">Guard</label>
                            <select class="form-control" 
                                    id="guard_name" 
                                    name="guard_name"
                                    style="background-color: #374151; color: white; border-color: #4b5563;">
                                <option value="web" {{ $permiso->guard_name == 'web' ? 'selected' : '' }}>Web</option>
                                <option value="api" {{ $permiso->guard_name == 'api' ? 'selected' : '' }}>API</option>
                            </select>
                        </div>

                        <!-- Info adicional -->
                        <div class="alert alert-dark border">
                            <div class="row">
                                <div class="col-6">
                                    <strong class="text-white">Creado:</strong><br>
                                    <small class="text-gray-400">{{ $permiso->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                                <div class="col-6">
                                    <strong class="text-white">Actualizado:</strong><br>
                                    <small class="text-gray-400">{{ $permiso->updated_at->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Roles asignados -->
                <div class="card shadow-lg border-0 mb-4 bg-gray-800">
                    <div class="card-header bg-gradient-to-r from-purple-600 to-pink-600 text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-user-tag mr-2"></i>Roles con este Permiso
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
                                <div class="form-check">
                                    <input type="checkbox" 
                                           class="form-check-input role-checkbox" 
                                           id="role{{ $role->id }}"
                                           name="roles[]" 
                                           value="{{ $role->id }}"
                                           style="cursor: pointer;"
                                           {{ in_array($role->id, $permisoRoles) ? 'checked' : '' }}>
                                    <label class="form-check-label text-white" for="role{{ $role->id }}" style="cursor: pointer;">
                                        <i class="fas fa-shield-alt text-purple-400 mr-1"></i>
                                        <strong>{{ $role->name }}</strong>
                                        @if(in_array($role->id, $permisoRoles))
                                            <span class="badge badge-success badge-sm ml-2">Asignado</span>
                                        @endif
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
                        <button type="submit" class="btn btn-primary btn-lg btn-block shadow-sm">
                            <i class="fas fa-save mr-2"></i>Actualizar Permiso
                        </button>
                        <button type="button" onclick="volverAPermisos()" class="btn btn-secondary btn-block mt-2">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Panel lateral -->
        <div class="col-md-4">
            <!-- Estadísticas -->
            <div class="card shadow-lg border-0 mb-4 bg-gray-800">
                <div class="card-header bg-gradient-to-r from-yellow-600 to-orange-600 text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-bar mr-2"></i>Estadísticas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-users fa-3x text-purple-400 mb-2"></i>
                        <h3 class="mb-0 font-weight-bold text-white">{{ $permiso->roles->count() }}</h3>
                        <small class="text-gray-400">Roles asignados actualmente</small>
                    </div>
                    
                    @if($permiso->roles->count() > 0)
                        <hr class="border-gray-600">
                        <h6 class="font-weight-bold mb-2 text-white">Roles actuales:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($permiso->roles as $role)
                                <span class="badge badge-primary mb-1">{{ $role->name }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ayuda -->
            <div class="card shadow-lg border-0 bg-gray-800">
                <div class="card-header bg-gradient-to-r from-blue-600 to-cyan-600 text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-info-circle mr-2"></i>Información
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning border-0">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Cuidado:</strong> Modificar este permiso afectará a todos los roles que lo tienen asignado.
                    </div>
                    
                    <h6 class="font-weight-bold mt-3 mb-2 text-white">Convención de nombres:</h6>
                    <p class="small mb-2 text-gray-300">Los permisos siguen el formato:</p>
                    <div class="alert alert-dark border">
                        <code class="text-green-400">modulo.accion</code>
                    </div>
                    
                    <p class="small mb-0 text-gray-300">
                        <i class="fas fa-lightbulb text-yellow-400 mr-1"></i>
                        Mantén la consistencia en la nomenclatura para facilitar la administración.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function volverAPermisos() {
    // Usar la función global para recargar la vista de permisos
    if (typeof window.cargarContenidoAjax === 'function') {
        window.cargarContenidoAjax('{{ route("admin.configuracion.permisos.ajax") }}', '#config-content');
    }
}

// Variable para el timeout de validación
let validationTimeout;

// Función de validación en tiempo real
function validarNombrePermiso() {
    const nombre = $('#name').val().trim();
    const validationDiv = $('#name-validation-permisos');
    
    // Limpiar validación anterior
    validationDiv.empty();
    
    if (nombre.length === 0) {
        return;
    }
    
    if (nombre.length < 2) {
        validationDiv.html('<div class="alert alert-warning alert-sm mt-2"><i class="fas fa-exclamation-triangle mr-2"></i>El nombre debe tener al menos 2 caracteres</div>');
        return;
    }
    
    // Validar formato modulo.accion
    const formatoValido = /^[a-z_]+\.[a-z_]+$/.test(nombre);
    
    if (!formatoValido) {
        validationDiv.html('<div class="alert alert-warning alert-sm mt-2"><i class="fas fa-info-circle mr-2"></i>Formato recomendado: <code>modulo.accion</code> (ejemplo: <code>usuarios.ver</code>)</div>');
    } else {
        validationDiv.html('<div class="alert alert-success alert-sm mt-2"><i class="fas fa-check-circle mr-2"></i>Formato correcto</div>');
    }
}

$(document).ready(function() {
    // Validación con debounce (500ms)
    $('#name').on('input', function() {
        clearTimeout(validationTimeout);
        validationTimeout = setTimeout(validarNombrePermiso, 500);
    });
    
    // Interceptar el submit del formulario
    $('#formEditarPermiso').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        
        $.ajax({
            url: '{{ route("admin.configuracion.permisos.update", $permiso->id) }}',
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
                    text: 'Permiso actualizado correctamente',
                    background: '#1f2937',
                    color: '#fff',
                    confirmButtonColor: '#10b981'
                }).then(() => {
                    // Recargar la lista de permisos vía AJAX
                    volverAPermisos();
                });
            },
            error: function(xhr) {
                let errorMsg = 'Error al actualizar el permiso';
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

{{-- Cerrar section solo si no es AJAX --}}
@if(!isset($isAjax) || !$isAjax)
    @endsection
@endif