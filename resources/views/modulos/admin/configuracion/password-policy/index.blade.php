{{-- No extender layout si es petición AJAX --}}
@if(!isset($isAjax) || !$isAjax)
    @extends('layouts.app-admin')
    @section('content')
@endif

<div class="w-full">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-indigo-700 via-blue-700 to-cyan-700 rounded-xl shadow-lg p-6 mb-6">
        <div class="flex flex-wrap justify-between items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                    <i class="fas fa-shield-alt"></i> Política de Contraseñas
                </h1>
                <p class="text-white/80 mt-1">Configura las reglas de caducidad y renovación de contraseñas del sistema</p>
            </div>
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold
                {{ $parametros['politica_contrasenas_activa'] ? 'bg-green-500/20 text-green-200 border border-green-500/40' : 'bg-red-500/20 text-red-200 border border-red-500/40' }}">
                <i class="fas {{ $parametros['politica_contrasenas_activa'] ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                {{ $parametros['politica_contrasenas_activa'] ? 'Política Activa' : 'Política Inactiva' }}
            </span>
        </div>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/40 text-green-300 rounded-xl px-5 py-3 mb-5 flex items-center gap-3">
            <i class="fas fa-check-circle text-xl"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-500/20 border border-red-500/40 text-red-300 rounded-xl px-5 py-3 mb-5 flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-xl"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Estadísticas --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-gray-800/60 border border-gray-700 rounded-xl p-5 text-center">
            <p class="text-3xl font-bold text-white">{{ $stats['total_usuarios'] }}</p>
            <p class="text-gray-400 text-sm mt-1"><i class="fas fa-users mr-1"></i>Total Usuarios</p>
        </div>
        <div class="bg-green-900/40 border border-green-700/40 rounded-xl p-5 text-center">
            <p class="text-3xl font-bold text-green-400">{{ $stats['vigentes'] }}</p>
            <p class="text-green-400/70 text-sm mt-1"><i class="fas fa-check-circle mr-1"></i>Vigentes</p>
        </div>
        <div class="bg-yellow-900/40 border border-yellow-700/40 rounded-xl p-5 text-center">
            <p class="text-3xl font-bold text-yellow-400">{{ $stats['por_vencer_7'] }}</p>
            <p class="text-yellow-400/70 text-sm mt-1"><i class="fas fa-clock mr-1"></i>Por Vencer (7 días)</p>
        </div>
        <div class="bg-red-900/40 border border-red-700/40 rounded-xl p-5 text-center">
            <p class="text-3xl font-bold text-red-400">{{ $stats['vencidas'] }}</p>
            <p class="text-red-400/70 text-sm mt-1"><i class="fas fa-lock mr-1"></i>Vencidas</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        {{-- Formulario de configuración --}}
        <div class="bg-gray-800/60 border border-gray-700 rounded-xl shadow-xl overflow-hidden">
            <div class="bg-gray-900/60 px-6 py-4 border-b border-gray-700">
                <h2 class="text-white font-bold text-lg flex items-center gap-2">
                    <i class="fas fa-cog text-blue-400"></i> Parámetros de Configuración
                </h2>
            </div>
            <div class="p-6">
                <form id="formPolitica" action="{{ route('admin.configuracion.password-policy.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Estado de la política --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-300 mb-3">
                            <i class="fas fa-toggle-on mr-1 text-blue-400"></i> Estado de la Política
                        </label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-3 cursor-pointer bg-gray-700/50 hover:bg-gray-700 rounded-xl px-5 py-3 border border-gray-600 transition-all
                                {{ $parametros['politica_contrasenas_activa'] ? 'border-green-500 bg-green-900/30' : '' }}">
                                <input type="radio" name="politica_contrasenas_activa" value="1"
                                       {{ $parametros['politica_contrasenas_activa'] ? 'checked' : '' }}
                                       class="text-green-500 focus:ring-green-400">
                                <span class="text-white font-medium">Activada</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer bg-gray-700/50 hover:bg-gray-700 rounded-xl px-5 py-3 border border-gray-600 transition-all
                                {{ !$parametros['politica_contrasenas_activa'] ? 'border-red-500 bg-red-900/30' : '' }}">
                                <input type="radio" name="politica_contrasenas_activa" value="0"
                                       {{ !$parametros['politica_contrasenas_activa'] ? 'checked' : '' }}
                                       class="text-red-500 focus:ring-red-400">
                                <span class="text-white font-medium">Desactivada</span>
                            </label>
                        </div>
                    </div>

                    {{-- Días de vigencia --}}
                    <div class="mb-6">
                        <label for="dias_vigencia" class="block text-sm font-semibold text-gray-300 mb-2">
                            <i class="fas fa-calendar-alt mr-1 text-blue-400"></i> Días de Vigencia de la Contraseña
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="number"
                                   id="dias_vigencia"
                                   name="dias_vigencia_contrasena"
                                   value="{{ $parametros['dias_vigencia_contrasena'] }}"
                                   min="1" max="365"
                                   class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('dias_vigencia_contrasena') border-red-500 @enderror">
                            <span class="text-gray-400 whitespace-nowrap text-sm">días</span>
                        </div>
                        <p class="text-gray-500 text-xs mt-1">Las contraseñas vencerán después de este número de días desde su último cambio. (1–365)</p>
                        @error('dias_vigencia_contrasena')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Días de aviso --}}
                    <div class="mb-6">
                        <label for="dias_aviso" class="block text-sm font-semibold text-gray-300 mb-2">
                            <i class="fas fa-bell mr-1 text-yellow-400"></i> Días de Anticipación para Notificar
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="number"
                                   id="dias_aviso"
                                   name="dias_aviso_contrasena"
                                   value="{{ $parametros['dias_aviso_contrasena'] }}"
                                   min="1" max="30"
                                   class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('dias_aviso_contrasena') border-red-500 @enderror">
                            <span class="text-gray-400 whitespace-nowrap text-sm">días antes</span>
                        </div>
                        <p class="text-gray-500 text-xs mt-1">Se notificará al usuario por notificación interna y correo con esta anticipación. (1–30)</p>
                        @error('dias_aviso_contrasena')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Recalcular fechas --}}
                    <div class="mb-6 bg-yellow-900/20 border border-yellow-700/40 rounded-xl p-4">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" name="recalcular_fechas" value="1" class="mt-1 text-yellow-400 focus:ring-yellow-400">
                            <div>
                                <p class="text-yellow-300 font-medium text-sm">Recalcular fechas de vencimiento para todos los usuarios</p>
                                <p class="text-yellow-400/60 text-xs mt-1">Al marcar esta opción, se recalculará la fecha de vencimiento de todos los usuarios activos en base al nuevo valor de días de vigencia y su último cambio de contraseña.</p>
                            </div>
                        </label>
                    </div>

                    <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 shadow-lg hover:shadow-blue-500/25">
                        <i class="fas fa-save mr-2"></i> Guardar Configuración
                    </button>
                </form>
            </div>
        </div>

        {{-- Tabla de estado de usuarios --}}
        <div class="bg-gray-800/60 border border-gray-700 rounded-xl shadow-xl overflow-hidden">
            <div class="bg-gray-900/60 px-6 py-4 border-b border-gray-700 flex items-center justify-between gap-3">
                <h2 class="text-white font-bold text-lg flex items-center gap-2">
                    <i class="fas fa-users text-blue-400"></i> Estado de Contraseñas
                </h2>
                <div class="flex gap-2">
                    <button onclick="ejecutarNotificacionesAhora()" class="text-yellow-400 hover:text-yellow-300 text-sm transition-colors px-3 py-1 rounded bg-yellow-900/20 border border-yellow-700/30 hover:border-yellow-700 flex items-center gap-1">
                        <i class="fas fa-envelope mr-1"></i> Enviar Notificaciones
                    </button>
                    <button onclick="cargarTablaUsuarios()" class="text-blue-400 hover:text-blue-300 text-sm transition-colors">
                        <i class="fas fa-sync-alt mr-1"></i> Actualizar
                    </button>
                </div>
            </div>
            <div id="tabla-usuarios" class="overflow-x-auto" style="max-height: 480px; overflow-y: auto;">
                <div class="flex items-center justify-center py-12 text-gray-500">
                    <i class="fas fa-spinner fa-spin text-2xl mr-3"></i>
                    <span>Cargando usuarios...</span>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Modal para editar fecha de vencimiento --}}
<div id="modalEditarFecha" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-2xl p-8 max-w-md w-full mx-4">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-white flex items-center gap-2">
                <i class="fas fa-calendar-alt text-blue-400"></i> Editar Fecha de Vencimiento
            </h3>
            <button onclick="cerrarModalEditar()" class="text-gray-400 hover:text-gray-200 text-2xl leading-none">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Contenido -->
        <div class="space-y-4 mb-6">
            <!-- Nombre del usuario -->
            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-2">Usuario</label>
                <p id="editarNombre" class="text-white font-medium text-lg"></p>
            </div>

            <!-- Campo de fecha -->
            <div>
                <label for="editarFecha" class="block text-sm font-semibold text-gray-300 mb-2">
                    <i class="fas fa-calendar mr-1 text-yellow-400"></i> Nueva Fecha de Vencimiento
                </label>
                <input 
                    type="date" 
                    id="editarFecha" 
                    class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    min="{{ date('Y-m-d') }}"
                >
                <p class="text-gray-400 text-xs mt-2">Selecciona una fecha igual o posterior a hoy.</p>
                <p class="text-green-400 text-xs mt-2 flex items-center gap-1">
                    <i class="fas fa-check-circle"></i> Se enviará correo de notificación inmediatamente
                </p>
            </div>

            <!-- Campo oculto para ID -->
            <input type="hidden" id="editarUsuarioId">
        </div>

        <!-- Botones -->
        <div class="flex gap-3">
            <button 
                onclick="cerrarModalEditar()" 
                class="flex-1 px-4 py-2 bg-gray-700 hover:bg-gray-600 text-gray-200 font-medium rounded-lg transition-colors">
                <i class="fas fa-times mr-2"></i> Cancelar
            </button>
            <button 
                id="btnGuardarFecha"
                onclick="guardarNuevaFecha()" 
                class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-save mr-2"></i> Guardar Cambios
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    cargarTablaUsuarios();

    // Cerrar modal al hacer clic fuera
    document.getElementById('modalEditarFecha').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalEditar();
        }
    });

    // Resaltar radio seleccionado
    document.querySelectorAll('input[name="politica_contrasenas_activa"]').forEach(radio => {
        radio.addEventListener('change', function () {
            document.querySelectorAll('input[name="politica_contrasenas_activa"]').forEach(r => {
                const label = r.closest('label');
                label.classList.remove('border-green-500', 'bg-green-900/30', 'border-red-500', 'bg-red-900/30');
            });
            const lbl = this.closest('label');
            if (this.value === '1') {
                lbl.classList.add('border-green-500', 'bg-green-900/30');
            } else {
                lbl.classList.add('border-red-500', 'bg-red-900/30');
            }
        });
    });
});

function cargarTablaUsuarios() {
    fetch('{{ route("admin.configuracion.password-policy.usuarios") }}', {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) return;
        const usuarios = data.usuarios;
        if (!usuarios.length) {
            document.getElementById('tabla-usuarios').innerHTML =
                '<div class="py-10 text-center text-gray-500"><i class="fas fa-inbox text-3xl mb-3"></i><p>No hay usuarios activos</p></div>';
            return;
        }

        const badgeMap = {
            vencida:    '<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-red-500/20 text-red-400 border border-red-500/30"><i class="fas fa-times-circle"></i> Vencida</span>',
            por_vencer: '<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-yellow-500/20 text-yellow-400 border border-yellow-500/30"><i class="fas fa-exclamation-triangle"></i> Por Vencer</span>',
            vigente:    '<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-green-500/20 text-green-400 border border-green-500/30"><i class="fas fa-check-circle"></i> Vigente</span>',
            sin_fecha:  '<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-500/20 text-gray-400 border border-gray-500/30"><i class="fas fa-minus-circle"></i> Sin fecha</span>',
        };

        let rows = usuarios.map(u => `
            <tr class="border-b border-gray-700/50 hover:bg-gray-700/30 transition-colors">
                <td class="px-4 py-3 text-white text-sm font-medium">${u.nombre}</td>
                <td class="px-4 py-3 text-gray-400 text-xs">${u.email}</td>
                <td class="px-4 py-3 text-gray-400 text-xs">${u.password_expires_at ?? '—'}</td>
                <td class="px-4 py-3 text-center">
                    ${u.dias_restantes !== null
                        ? `<span class="text-xs font-bold ${u.dias_restantes < 0 ? 'text-red-400' : u.dias_restantes <= 7 ? 'text-yellow-400' : 'text-green-400'}">${u.dias_restantes < 0 ? 'Vencida' : u.dias_restantes + ' días'}</span>`
                        : '<span class="text-gray-500 text-xs">—</span>'
                    }
                </td>
                <td class="px-4 py-3 flex items-center gap-2">
                    ${badgeMap[u.estado] ?? ''}
                    <button onclick="abrirModalEditar(${u.id}, '${u.nombre}', '${u.password_expires_at_iso ?? ''}')" 
                            class="ml-auto text-blue-400 hover:text-blue-300 text-xs transition-colors" 
                            title="Editar fecha de vencimiento">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
            </tr>
        `).join('');

        document.getElementById('tabla-usuarios').innerHTML = `
            <table class="w-full text-sm">
                <thead class="bg-gray-900/60 sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wide">Usuario</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wide">Correo</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wide">Vence</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wide">Días</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wide">Estado</th>
                    </tr>
                </thead>
                <tbody>${rows}</tbody>
            </table>`;
    })
    .catch(() => {
        document.getElementById('tabla-usuarios').innerHTML =
            '<div class="py-10 text-center text-red-400"><i class="fas fa-exclamation-circle text-3xl mb-3"></i><p>Error al cargar datos</p></div>';
    });
}

/**
 * Abre el modal para editar la fecha de vencimiento de un usuario
 */
function abrirModalEditar(usuarioId, nombreUsuario, fechaActual) {
    // Poblar modal con datos
    document.getElementById('editarUsuarioId').value = usuarioId;
    document.getElementById('editarNombre').textContent = nombreUsuario;
    document.getElementById('editarFecha').value = fechaActual || '';
    
    // Mostrar modal
    document.getElementById('modalEditarFecha').classList.remove('hidden');
    document.getElementById('modalEditarFecha').classList.add('flex');
}

/**
 * Cierra el modal de edición
 */
function cerrarModalEditar() {
    document.getElementById('modalEditarFecha').classList.add('hidden');
    document.getElementById('modalEditarFecha').classList.remove('flex');
}

/**
 * Guarda la nueva fecha de vencimiento (AJAX)
 */
function guardarNuevaFecha() {
    const usuarioId = document.getElementById('editarUsuarioId').value;
    const nuevaFecha = document.getElementById('editarFecha').value;
    const btnGuardar = document.getElementById('btnGuardarFecha');
    
    if (!usuarioId || !nuevaFecha) {
        alert('Por favor, completa todos los campos.');
        return;
    }

    // Mostrar indicador de carga
    btnGuardar.disabled = true;
    btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Guardando...';

    fetch('{{ route("admin.configuracion.password-policy.update-expiry") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            usuario_id: usuarioId,
            nueva_fecha: nuevaFecha
        })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            // Mostrar mensaje de éxito
            mostrarToast('✅ ' + data.message, 'success');
            
            // Cerrar modal
            cerrarModalEditar();
            
            // Recargar tabla
            cargarTablaUsuarios();
        } else {
            mostrarToast('❌ ' + (data.message || 'Error al guardar'), 'error');
        }
    })
    .catch(err => {
        console.error(err);
        mostrarToast('❌ Error de red. Intenta nuevamente.', 'error');
    })
    .finally(() => {
        btnGuardar.disabled = false;
        btnGuardar.innerHTML = '<i class="fas fa-save mr-2"></i>Guardar Cambios';
    });
}

/**
 * Muestra un toast notification (notificación flotante)
 */
function mostrarToast(mensaje, tipo = 'info') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg font-medium max-w-sm z-[9999] ${
        tipo === 'success' 
            ? 'bg-green-500/20 border border-green-500/40 text-green-300' 
            : 'bg-red-500/20 border border-red-500/40 text-red-300'
    }`;
    toast.innerHTML = mensaje;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

/**
 * Ejecuta todas las notificaciones de vencimiento de contraseñas ahora
 */
function ejecutarNotificacionesAhora() {
    const btn = event.target.closest('button');
    const originalHTML = btn.innerHTML;
    
    // Mostrar indicador de carga
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Enviando...';

    fetch('{{ route("admin.configuracion.password-policy.ejecutar-notificaciones") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            mostrarToast('✅ ' + data.message, 'success');
            // Recargar tabla después de 1 segundo
            setTimeout(() => cargarTablaUsuarios(), 1000);
        } else {
            mostrarToast('❌ ' + (data.message || 'Error'), 'error');
        }
    })
    .catch(err => {
        console.error(err);
        mostrarToast('❌ Error de red. Intenta nuevamente.', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalHTML;
    });
}
</script>

@if(!isset($isAjax) || !$isAjax)
    @endsection
@endif
