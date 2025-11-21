{{-- No extender layout si es petición AJAX --}}
@if(!isset($isAjax) || !$isAjax)
    @extends('layouts.app-admin')
    @section('content')
@endif

<div class="w-full">
    <!-- Header con gradiente -->
    <div class="bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-600 rounded-xl shadow-lg p-6 mb-6">
        <div class="flex flex-wrap justify-between items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white flex items-center">
                    <i class="fas fa-user-tag mr-3"></i>Gestión de Roles
                </h1>
                <p class="text-white/90 mt-2">Administra los roles y sus permisos del sistema</p>
            </div>
            <button onclick="cargarFormularioCrear()" 
               class="bg-white text-purple-600 hover:bg-purple-50 px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i>Crear Nuevo Rol
            </button>
        </div>
    </div>

        <!-- Mensajes de alerta -->
        @if(session('success'))
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 py-4 rounded-2xl shadow-xl mb-6 flex items-center animate-fade-in">
                <i class="fas fa-check-circle text-2xl mr-3"></i>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-gradient-to-r from-red-600 to-pink-600 text-white px-6 py-4 rounded-2xl shadow-xl mb-6 flex items-center animate-fade-in">
                <i class="fas fa-exclamation-circle text-2xl mr-3"></i>
                <span class="font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('warning'))
            <div class="bg-gradient-to-r from-yellow-600 to-orange-600 text-white px-6 py-4 rounded-2xl shadow-xl mb-6 flex items-center animate-fade-in">
                <i class="fas fa-exclamation-triangle text-2xl mr-3"></i>
                <span class="font-semibold">{{ session('warning') }}</span>
            </div>
        @endif

    <!-- Card principal -->
    <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl shadow-xl border border-gray-700 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4 border-b border-gray-700">
            <div class="flex justify-between items-center">
                <h6 class="text-xl font-bold text-white flex items-center mb-0">
                    <i class="fas fa-list mr-3 text-purple-400"></i>Lista de Roles ({{ $roles->total() }})
                </h6>
                <div class="text-gray-400">
                    <small>Mostrando {{ $roles->firstItem() ?? 0 }} - {{ $roles->lastItem() ?? 0 }} de {{ $roles->total() }}</small>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-900/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">#</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Rol</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Guard</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-300 uppercase tracking-wider">Permisos</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-300 uppercase tracking-wider">Usuarios</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Fecha Creación</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-300 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-300 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800/30 divide-y divide-gray-700">
                        @forelse($roles as $index => $role)
                        <tr class="hover:bg-gray-700/50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-gray-400 font-medium">{{ $roles->firstItem() + $index }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-full flex items-center justify-center mr-3 shadow-lg">
                                        <i class="fas fa-shield-alt text-white"></i>
                                    </div>
                                    <div>
                                        <span class="font-bold text-white">{{ $role->name }}</span>
                                        @if(in_array($role->name, ['Super Admin', 'Presidente', 'Vicepresidente', 'Tesorero', 'Secretario', 'Vocero']))
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-600 text-white">
                                                <i class="fas fa-lock mr-1"></i> Sistema
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-700 text-gray-300">{{ $role->guard_name }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-purple-600 text-white font-bold shadow-lg">
                                    {{ $role->permissions->count() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-green-600 text-white font-bold shadow-lg">
                                    {{ $role->users_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-400 text-sm flex items-center">
                                    <i class="far fa-calendar-alt mr-2"></i>
                                    {{ $role->created_at->format('d/m/Y') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if(in_array($role->name, ['Super Admin', 'Presidente', 'Vicepresidente', 'Tesorero', 'Secretario', 'Vocero', 'Socio']))
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-600 text-white">
                                        <i class="fas fa-check-circle mr-1"></i> Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-600 text-white">
                                        <i class="fas fa-star mr-1"></i> Personalizado
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button onclick="verDetallesRol({{ $role->id }})"
                                       class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button onclick="asignarPermisos({{ $role->id }})"
                                       class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg"
                                       title="Asignar permisos">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    
                                    @if($role->name !== 'Super Admin')
                                        <button onclick="editarRol({{ $role->id }})"
                                           class="inline-flex items-center px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg"
                                           title="Editar rol">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        
                                        @if(!in_array($role->name, ['Presidente', 'Vicepresidente', 'Tesorero', 'Secretario', 'Vocero', 'Socio']))
                                            <button type="button" 
                                                    class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg"
                                                    title="Eliminar"
                                                    onclick="eliminarRol({{ $role->id }}, '{{ addslashes($role->name) }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    @else
                                        <button class="inline-flex items-center px-3 py-2 bg-gray-600 text-gray-400 rounded-lg cursor-not-allowed" disabled title="Protegido">
                                            <i class="fas fa-lock"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="text-gray-400">
                                    <i class="fas fa-inbox text-6xl mb-4 text-gray-600"></i>
                                    <p class="text-lg font-semibold">No hay roles registrados</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        <!-- Paginación -->
        @if($roles->hasPages())
        <div class="bg-gray-800/50 px-6 py-4 border-t border-gray-700">
            <div class="flex justify-between items-center">
                <div class="text-gray-400 text-sm">
                    Mostrando {{ $roles->firstItem() ?? 0 }} a {{ $roles->lastItem() ?? 0 }} de {{ $roles->total() }} resultados
                </div>
                <div class="pagination-wrapper">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
// Funciones para manejar las acciones de roles - INLINE para AJAX
function cargarFormularioCrear() {
    if (typeof window.cargarContenidoAjax === 'function') {
        window.cargarContenidoAjax('{{ route("admin.configuracion.roles.create") }}', '#config-content');
    }
}

function verDetallesRol(roleId) {
    if (typeof window.cargarContenidoAjax === 'function') {
        window.cargarContenidoAjax(`{{ url('admin/configuracion/roles') }}/${roleId}`, '#config-content');
    }
}

function editarRol(roleId) {
    if (typeof window.cargarContenidoAjax === 'function') {
        window.cargarContenidoAjax(`{{ url('admin/configuracion/roles') }}/${roleId}/edit`, '#config-content');
    }
}

function asignarPermisos(roleId) {
    if (typeof window.cargarContenidoAjax === 'function') {
        window.cargarContenidoAjax(`{{ url('admin/configuracion/roles') }}/${roleId}/asignar-permisos`, '#config-content');
    }
}

function eliminarRol(roleId, roleName) {
    Swal.fire({
        title: '¿Eliminar Rol?',
        html: `¿Estás seguro de que deseas eliminar el rol <strong>${roleName}</strong>?<br><br><small class="text-warning">Esta acción no se puede deshacer.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash mr-2"></i>Eliminar',
        cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancelar',
        background: '#1f2937',
        color: '#fff',
        customClass: {
            popup: 'border border-gray-700',
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `{{ url('admin/configuracion/roles') }}/${roleId}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message || 'Rol eliminado correctamente',
                        background: '#1f2937',
                        color: '#fff',
                        confirmButtonColor: '#10b981',
                        timer: 2000
                    }).then(() => {
                        // Recargar la vista de roles usando la función global
                        if (typeof window.cargarContenidoAjax === 'function') {
                            window.cargarContenidoAjax('{{ route("admin.configuracion.roles.ajax") }}', '#config-content');
                        }
                    });
                },
                error: function(xhr) {
                    let errorMsg = 'Error al eliminar el rol';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMsg,
                        background: '#1f2937',
                        color: '#fff',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        }
    });
}
</script>

{{-- Cerrar section solo si no es AJAX --}}
@if(!isset($isAjax) || !$isAjax)
    @endsection
@endif