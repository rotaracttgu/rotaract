<!-- Vista AJAX para Ver Detalles del Rol -->
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-700 rounded-lg shadow-lg p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 text-white font-weight-bold">
                    <i class="fas fa-eye mr-2"></i>Detalles del Rol: {{ $role->name }}
                </h1>
                <p class="text-white mb-0 mt-1 opacity-75">Información completa del rol y sus permisos</p>
            </div>
            <div>
                @if($role->name !== 'Super Admin')
                    <button type="button" 
                            onclick="cargarContenidoAjax('{{ route('admin.configuracion.roles.edit', $role->id) }}', '#config-content')" 
                            class="btn btn-warning shadow-sm mr-2">
                        <i class="fas fa-edit mr-1"></i>Editar
                    </button>
                @endif
                <button type="button" onclick="$('[data-section=\'roles\']').trigger('click')" class="btn btn-light shadow-sm">
                    <i class="fas fa-arrow-left mr-1"></i>Volver
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Información del rol -->
        <div class="col-md-4">
            <div class="card shadow-lg border-0 mb-4 bg-gray-800">
                <div class="card-header bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-info-circle mr-2"></i>Información General
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="font-weight-bold text-gray-400 small">NOMBRE DEL ROL</label>
                        <h5 class="mb-0 text-white">{{ $role->name }}</h5>
                    </div>

                    <div class="mb-3">
                        <label class="font-weight-bold text-gray-400 small">GUARD</label>
                        <div>
                            <span class="badge badge-secondary badge-lg">{{ $role->guard_name }}</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="font-weight-bold text-gray-400 small">FECHA DE CREACIÓN</label>
                        <div class="text-gray-300">
                            <i class="far fa-calendar-alt text-purple-400 mr-2"></i>
                            {{ $role->created_at->format('d/m/Y H:i:s') }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="font-weight-bold text-gray-400 small">ÚLTIMA ACTUALIZACIÓN</label>
                        <div class="text-gray-300">
                            <i class="far fa-clock text-purple-400 mr-2"></i>
                            {{ $role->updated_at->format('d/m/Y H:i:s') }}
                        </div>
                    </div>

                    @if(in_array($role->name, ['Super Admin', 'Presidente', 'Vicepresidente', 'Tesorero', 'Secretario', 'Vocero', 'Aspirante']))
                    <div class="alert alert-info border-0 mb-0">
                        <i class="fas fa-lock mr-2"></i>
                        <strong>Rol del Sistema</strong><br>
                        <small>Este rol es parte del sistema y tiene protección especial.</small>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="card shadow-lg border-0 bg-gray-800">
                <div class="card-header bg-gradient-to-r from-green-600 to-teal-600 text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-bar mr-2"></i>Estadísticas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 border-right border-gray-700">
                            <div class="mb-2">
                                <i class="fas fa-key fa-2x text-purple-400"></i>
                            </div>
                            <h4 class="mb-0 font-weight-bold text-white">{{ $role->permissions->count() }}</h4>
                            <small class="text-gray-400">Permisos</small>
                        </div>
                        <div class="col-6">
                            <div class="mb-2">
                                <i class="fas fa-users fa-2x text-green-400"></i>
                            </div>
                            <h4 class="mb-0 font-weight-bold text-white">{{ $role->users->count() }}</h4>
                            <small class="text-gray-400">Usuarios</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permisos y Usuarios -->
        <div class="col-md-8">
            <!-- Permisos asignados -->
            <div class="card shadow-lg border-0 mb-4 bg-gray-800">
                <div class="card-header bg-gradient-to-r from-yellow-600 to-orange-600 text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-key mr-2"></i>Permisos Asignados ({{ $role->permissions->count() }})
                    </h6>
                </div>
                <div class="card-body">
                    @if($role->permissions->count() > 0)
                        @php
                            $permissionsGrouped = $role->permissions->groupBy(function($permission) {
                                $parts = explode('.', $permission->name);
                                return $parts[0] ?? 'general';
                            });
                        @endphp

                        @foreach($permissionsGrouped as $modulo => $perms)
                            <div class="mb-3">
                                <h6 class="font-weight-bold text-purple-400 mb-2">
                                    <i class="fas fa-folder-open mr-2"></i>{{ ucfirst($modulo) }}
                                    <span class="badge badge-primary badge-pill ml-2">{{ $perms->count() }}</span>
                                </h6>
                                <div class="row">
                                    @foreach($perms as $permission)
                                        <div class="col-md-6 mb-2">
                                            <span class="badge badge-success px-3 py-2">
                                                <i class="fas fa-check-circle mr-1"></i>{{ $permission->name }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @if(!$loop->last)
                                <hr class="border-gray-700">
                            @endif
                        @endforeach
                    @else
                        <div class="text-center py-5 text-gray-400">
                            <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                            <p>Este rol no tiene permisos asignados</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Usuarios con este rol -->
            <div class="card shadow-lg border-0 bg-gray-800">
                <div class="card-header bg-gradient-to-r from-purple-600 to-pink-600 text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-users mr-2"></i>Usuarios con este Rol ({{ $role->users->count() }})
                    </h6>
                </div>
                <div class="card-body">
                    @if($role->users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-dark table-hover mb-0">
                                <thead class="bg-gray-900">
                                    <tr>
                                        <th class="text-white">Usuario</th>
                                        <th class="text-white">Email</th>
                                        <th class="text-center text-white">Estado</th>
                                        <th class="text-white">Fecha Registro</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($role->users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle bg-gradient-to-br from-purple-600 to-pink-600 text-white mr-2">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                <span class="font-weight-bold text-white">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-gray-300">{{ $user->email }}</td>
                                        <td class="text-center">
                                            @if($user->activo)
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check-circle"></i> Activo
                                                </span>
                                            @else
                                                <span class="badge badge-danger">
                                                    <i class="fas fa-times-circle"></i> Inactivo
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-gray-400">
                                                {{ $user->created_at->format('d/m/Y') }}
                                            </small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-gray-400">
                            <i class="fas fa-users-slash fa-3x mb-3"></i>
                            <p>No hay usuarios asignados a este rol</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
}

.badge-lg {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
}
</style>

<script>
// Función auxiliar para cargar contenido AJAX (ya está en app-admin.blade.php)
function cargarContenidoAjax(url, target) {
    $(target).html(`
        <div class="d-flex justify-content-center align-items-center" style="min-height: 500px;">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
        </div>
    `);

    $.ajax({
        url: url,
        method: 'GET',
        headers: { 
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html'
        },
        success: function(html) {
            $(target).html(html);
        },
        error: function(xhr) {
            $(target).html(`
                <div class="alert alert-danger p-4 text-center m-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Error al cargar el contenido
                </div>
            `);
        }
    });
}
</script>