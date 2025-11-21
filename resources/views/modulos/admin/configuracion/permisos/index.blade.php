{{-- No extender layout si es petición AJAX --}}
@if(!isset($isAjax) || !$isAjax)
    @extends('layouts.app-admin')
    @section('content')
@endif

<div class="w-full">
    <!-- Header con gradiente -->
    <div class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 rounded-xl shadow-lg p-6 mb-6">
        <div class="flex flex-wrap justify-between items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white flex items-center">
                    <i class="fas fa-key mr-3"></i>Gestión de Permisos
                </h1>
                <p class="text-white/90 mt-2">Administra los permisos del sistema</p>
            </div>
            <button onclick="cargarFormularioCrearPermiso()" 
               class="bg-white text-green-600 hover:bg-green-50 px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i>Nuevo Permiso
            </button>
        </div>
    </div>

        <!-- Mensajes -->
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

        <!-- KPIs Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Total Permisos -->
            <div class="bg-gradient-to-br from-purple-600 to-indigo-700 rounded-2xl p-6 text-white shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-purple-200 text-xs font-semibold uppercase tracking-wider mb-2">🔑 Total Permisos</p>
                        <p class="text-4xl font-bold">{{ $permissions->total() }}</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <i class="fas fa-key text-3xl text-purple-300"></i>
                    </div>
                </div>
            </div>

            <!-- Módulos -->
            <div class="bg-gradient-to-br from-cyan-600 to-blue-700 rounded-2xl p-6 text-white shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-cyan-200 text-xs font-semibold uppercase tracking-wider mb-2">📁 Módulos</p>
                        <p class="text-4xl font-bold">{{ $permissionsGrouped->count() }}</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <i class="fas fa-folder text-3xl text-cyan-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs de visualización -->
        <div x-data="{ activeTab: 'list' }" class="mb-8">
            <div class="flex space-x-4 border-b border-gray-700 mb-6">
                <button @click="activeTab = 'list'" 
                        :class="activeTab === 'list' ? 'border-b-2 border-purple-500 text-white' : 'text-gray-400 hover:text-white'"
                        class="px-4 py-2 font-semibold transition-colors duration-200 flex items-center">
                    <i class="fas fa-list mr-2"></i>Vista Lista
                </button>
                <button @click="activeTab = 'group'" 
                        :class="activeTab === 'group' ? 'border-b-2 border-purple-500 text-white' : 'text-gray-400 hover:text-white'"
                        class="px-4 py-2 font-semibold transition-colors duration-200 flex items-center">
                    <i class="fas fa-layer-group mr-2"></i>Vista Agrupada
                </button>
            </div>

            <!-- Vista Lista -->
            <div x-show="activeTab === 'list'" x-transition class="space-y-6">
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl shadow-2xl border border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4 border-b border-gray-700">
                    <h6 class="text-xl font-bold text-white flex items-center m-0">
                        <i class="fas fa-list mr-3 text-green-400"></i>Todos los Permisos ({{ $permissions->total() }})
                    </h6>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-900/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">#</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Nombre del Permiso</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Guard</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-300 uppercase tracking-wider">Roles Asignados</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">Fecha Creación</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-300 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800/30 divide-y divide-gray-700">
                            @forelse($permissions as $index => $permission)
                            <tr class="hover:bg-gray-700/50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-gray-400 font-medium">{{ $permissions->firstItem() + $index }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-shield-alt text-green-500 mr-3"></i>
                                        <span class="font-bold text-white">{{ $permission->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-700 text-gray-300">{{ $permission->guard_name }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-green-600 text-white font-bold shadow-lg">
                                        {{ $permission->roles->count() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-400 text-sm flex items-center">
                                        <i class="far fa-calendar-alt mr-2"></i>
                                        {{ $permission->created_at->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button onclick="editarPermiso({{ $permission->id }})" 
                                           class="inline-flex items-center px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        
                                        <button type="button" 
                                                class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg"
                                                title="Eliminar"
                                                onclick="eliminarPermiso({{ $permission->id }}, '{{ addslashes($permission->name) }}', {{ $permission->roles->count() }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-gray-400">
                                        <i class="fas fa-inbox text-6xl mb-4 text-gray-600"></i>
                                        <p class="text-lg font-semibold">No hay permisos registrados</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($permissions->hasPages())
                <div class="bg-gray-800/50 px-6 py-4 border-t border-gray-700">
                    <div class="pagination-wrapper">
                        {{ $permissions->links() }}
                    </div>
                </div>
                @endif
            </div>
            </div>

            <!-- Vista Agrupada -->
            <div x-show="activeTab === 'group'" x-transition class="space-y-4">
                @foreach($permissionsGrouped as $modulo => $perms)
                <div x-data="{ open: false }" class="bg-gray-800/50 rounded-2xl border border-gray-700 overflow-hidden shadow-lg">
                    <button @click="open = !open" 
                            class="w-full px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold flex justify-between items-center hover:from-green-700 hover:to-emerald-700 transition-all duration-200">
                        <span class="flex items-center">
                            <i class="fas fa-folder-open mr-3"></i>
                            <strong>{{ ucfirst($modulo) }}</strong>
                        </span>
                        <span class="bg-white/20 px-3 py-1 rounded-full text-sm">{{ $perms->count() }} permisos</span>
                    </button>

                    <div x-show="open" x-transition class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($perms as $permission)
                            <div class="bg-gray-700/50 rounded-xl p-4 border border-gray-600 hover:border-green-500 transition-colors duration-200">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h6 class="font-semibold text-white flex items-center mb-2">
                                            <i class="fas fa-key text-green-400 mr-2"></i>
                                            {{ $permission->name }}
                                        </h6>
                                        <small class="text-gray-400 flex items-center">
                                            <i class="fas fa-users mr-1"></i>
                                            {{ $permission->roles->count() }} roles
                                        </small>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button onclick="editarPermiso({{ $permission->id }})" 
                                           class="inline-flex items-center px-2 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors duration-200 text-sm"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" 
                                                class="inline-flex items-center px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200 text-sm"
                                                onclick="eliminarPermiso({{ $permission->id }}, '{{ addslashes($permission->name) }}', {{ $permission->roles->count() }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    [x-cloak] { display: none !important; }
    
    .pagination-wrapper .pagination {
        display: flex;
        gap: 0.5rem;
    }
    
    .pagination-wrapper .page-link {
        @apply px-3 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition-colors;
    }
    
    .pagination-wrapper .page-item.active .page-link {
        @apply bg-green-600 text-white;
    }
</style>
@endpush

@push('scripts')
<script>
// Funciones para manejar las acciones de permisos
function cargarFormularioCrearPermiso() {
    cargarContenidoAjax('{{ route("admin.configuracion.permisos.create") }}', '#config-content');
}

function editarPermiso(permId) {
    cargarContenidoAjax(`{{ url('admin/configuracion/permisos') }}/${permId}/edit`, '#config-content');
}

function eliminarPermiso(permId, permName, rolesCount) {
    Swal.fire({
        title: '¿Eliminar Permiso?',
        html: `¿Estás seguro de que deseas eliminar el permiso <strong>${permName}</strong>?<br><br><small class="text-warning">Este permiso está asignado a <strong>${rolesCount}</strong> rol(es).</small>`,
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
                url: `{{ url('admin/configuracion/permisos') }}/${permId}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message || 'Permiso eliminado correctamente',
                        background: '#1f2937',
                        color: '#fff',
                        confirmButtonColor: '#10b981',
                        timer: 2000
                    }).then(() => {
                        // Recargar la vista de permisos
                        $('#sidebar .ajax-load[data-section="permisos"]').trigger('click');
                    });
                },
                error: function(xhr) {
                    let errorMsg = 'Error al eliminar el permiso';
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

// Función auxiliar para cargar contenido AJAX (si no existe globalmente)
if (typeof cargarContenidoAjax === 'undefined') {
    function cargarContenidoAjax(url, target) {
        $(target).html(`
            <div class="d-flex justify-content-center align-items-center" style="min-height: 300px;">
                <div class="text-center">
                    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem; margin-bottom: 1rem;"></div>
                    <p class="text-white">Cargando...</p>
                </div>
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
                // Reinicializar Alpine.js después de cargar contenido AJAX
                if (window.Alpine) {
                    Alpine.scan($(target)[0]);
                }
            },
            error: function(xhr) {
                $(target).html(`
                    <div class="alert alert-danger p-4 text-center m-4">
                        <i class="fas fa-exclamation-triangle me-2" style="font-size: 2rem;"></i>
                        <h4 class="mt-3">Error al cargar el contenido</h4>
                        <p class="mb-0">Estado: ${xhr.status}</p>
                    </div>
                `);
            }
        });
    }
}
</script>
@endpush

{{-- Cerrar section solo si no es AJAX --}}
@if(!isset($isAjax) || !$isAjax)
    @endsection
@endif