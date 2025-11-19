@extends('layouts.app-admin')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white flex items-center">
                <i class="fas fa-envelope mr-3 text-orange-400"></i>
                Cartas de Patrocinio
            </h1>
            <p class="text-gray-300 mt-1">Gestión de cartas de patrocinio - Módulo Presidente (Admin)</p>
        </div>
        <a href="{{ route('admin.presidente.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al Dashboard
        </a>
    </div>

    <div class="py-4 px-4">
        <div class="w-full">
            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-4">
                    <p class="text-sm text-purple-100">Total Cartas</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['total'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-4">
                    <p class="text-sm text-yellow-100">Pendientes</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['pendientes'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-4">
                    <p class="text-sm text-green-100">Aprobadas</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['aprobadas'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-4">
                    <p class="text-sm text-red-100">Rechazadas</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['rechazadas'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-4">
                    <p class="text-sm text-blue-100">Monto Aprobado</p>
                    <p class="text-2xl font-bold text-white">L. {{ number_format($estadisticas['montoTotal'] ?? 0, 2) }}</p>
                </div>
            </div>

            <!-- Panel principal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Gestión de Cartas de Patrocinio</h3>
                        <button onclick="abrirModalPatrocinio()" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Nueva Carta de Patrocinio
                        </button>
                    </div>

                    <!-- Barra de búsqueda -->
                    <div class="mb-6">
                        <div class="relative">
                            <input type="text" id="buscador" oninput="aplicarFiltros()" placeholder="Buscar por destinatario, número de carta o descripción..." 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-10">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Tabla de cartas -->
                    <div class="overflow-x-auto">
                        <table id="tabla-cartas" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-purple-600 to-purple-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Fecha Envío</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Destinatario</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Proyecto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Monto Solicitado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($cartas as $carta)
                                    <tr class="hover:bg-gray-50" 
                                        data-proyecto-id="{{ $carta->proyecto_id }}"
                                        data-fecha="{{ $carta->fecha_solicitud }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $carta->fecha_solicitud ? \Carbon\Carbon::parse($carta->fecha_solicitud)->format('d/m/Y') : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div>
                                                <p class="font-medium">{{ $carta->destinatario }}</p>
                                                @if($carta->numero_carta)
                                                    <p class="text-xs text-gray-500">Carta #{{ $carta->numero_carta }}</p>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $carta->proyecto ? $carta->proyecto->Nombre : 'Sin proyecto' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            L. {{ number_format($carta->monto_solicitado, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $estadoClasses = [
                                                    'Pendiente' => 'bg-yellow-100 text-yellow-800',
                                                    'Aprobada' => 'bg-green-100 text-green-800',
                                                    'Rechazada' => 'bg-red-100 text-red-800',
                                                    'En Revision' => 'bg-blue-100 text-blue-800',
                                                ];
                                                $clase = $estadoClasses[$carta->estado] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $clase }}">
                                                {{ $carta->estado }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex gap-2">
                                                <button class="text-blue-600 hover:text-blue-900" title="Ver detalles" onclick="verDetalleCarta({{ $carta->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-yellow-600 hover:text-yellow-900" title="Editar" onclick="editarCarta({{ $carta->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-red-600 hover:text-red-900" title="Eliminar" onclick="eliminarCarta({{ $carta->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                                <a href="{{ route('admin.presidente.cartas.patrocinio.pdf', $carta->id) }}" target="_blank" class="text-green-600 hover:text-green-900" title="Descargar PDF">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="mt-2 text-sm font-medium">No hay cartas de patrocinio registradas</p>
                                            <p class="text-xs text-gray-400 mt-1">Haz clic en "Nueva Carta de Patrocinio" para comenzar</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Información de resultados -->
                    @if($cartas->count() > 0)
                    <div class="mt-6 flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Mostrando <span class="font-medium">{{ $cartas->count() }}</span> carta(s) de patrocinio
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nueva Carta de Patrocinio -->
    <div id="modalNuevaCartaPatrocinio" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-xl bg-white overflow-hidden">
            <div class="bg-blue-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white">Nueva Carta de Patrocinio</h3>
                <button onclick="cerrarModalPatrocinio()" class="text-white hover:text-gray-200 transition-colors p-1 rounded-lg hover:bg-white hover:bg-opacity-10">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="formCartaPatrocinio" action="{{ route('admin.presidente.cartas.patrocinio.store') }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Número de Carta <span class="text-xs text-gray-500">(Opcional)</span></label>
                        <input type="text" name="numero_carta"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Generación automática">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Proyecto <span class="text-red-500">*</span></label>
                        <select name="proyecto_id" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Seleccionar proyecto</option>
                            @foreach($proyectos as $proyecto)
                                <option value="{{ $proyecto->ProyectoID }}">{{ $proyecto->Nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Destinatario <span class="text-red-500">*</span></label>
                        <input type="text" name="destinatario" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Nombre de la empresa o institución">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Monto Solicitado (L.) <span class="text-red-500">*</span></label>
                        <input type="number" name="monto_solicitado" required step="0.01" min="0"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="0.00">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                        <select name="estado"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="Pendiente">Pendiente</option>
                            <option value="En Revision">En Revisión</option>
                            <option value="Aprobada">Aprobada</option>
                            <option value="Rechazada">Rechazada</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Solicitud</label>
                        <input type="date" name="fecha_solicitud" value="{{ date('Y-m-d') }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Respuesta</label>
                        <input type="date" name="fecha_respuesta"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea name="descripcion" rows="3"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Descripción del patrocinio solicitado"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                        <textarea name="observaciones" rows="2"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Observaciones adicionales"></textarea>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-200 flex justify-end gap-3">
                    <button type="button" onclick="cerrarModalPatrocinio()"
                            class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all font-medium shadow-sm hover:shadow">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium shadow-md hover:shadow-lg">
                        Guardar Carta
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const baseRoute = 'admin/presidente';
    
    // Validación de caracteres repetidos
    function validarCaracteresRepetidos(texto) {
        const patron = /(.)\1{2,}/;
        return !patron.test(texto);
    }
    
    function mostrarError(inputName, mensaje) {
        const input = document.querySelector(`[name="${inputName}"]`);
        if (input) {
            input.classList.add('border-red-500');
            let errorDiv = input.nextElementSibling;
            if (!errorDiv || !errorDiv.classList.contains('error-message')) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'error-message text-red-500 text-xs mt-1';
                input.parentNode.insertBefore(errorDiv, input.nextSibling);
            }
            errorDiv.textContent = mensaje;
        }
    }
    
    function limpiarErrores() {
        document.querySelectorAll('.error-message').forEach(el => el.remove());
        document.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500');
        });
    }
    
    function abrirModalPatrocinio() {
        document.getElementById('modalNuevaCartaPatrocinio').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        limpiarErrores();
    }

    function cerrarModalPatrocinio() {
        document.getElementById('modalNuevaCartaPatrocinio').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('formCartaPatrocinio').reset();
        limpiarErrores();
    }
    
    // Validar formulario antes de enviar
    document.getElementById('formCartaPatrocinio')?.addEventListener('submit', function(e) {
        e.preventDefault();
        limpiarErrores();
        
        let errores = false;
        
        // Validar destinatario
        const destinatario = document.querySelector('[name="destinatario"]').value;
        if (!destinatario) {
            mostrarError('destinatario', 'El destinatario es obligatorio');
            errores = true;
        } else if (!validarCaracteresRepetidos(destinatario)) {
            mostrarError('destinatario', 'No puede contener más de 2 caracteres repetidos consecutivos');
            errores = true;
        }
        
        // Validar descripción
        const descripcion = document.querySelector('[name="descripcion"]').value;
        if (descripcion && !validarCaracteresRepetidos(descripcion)) {
            mostrarError('descripcion', 'No puede contener más de 2 caracteres repetidos consecutivos');
            errores = true;
        }
        
        // Validar observaciones
        const observaciones = document.querySelector('[name="observaciones"]').value;
        if (observaciones && !validarCaracteresRepetidos(observaciones)) {
            mostrarError('observaciones', 'No puede contener más de 2 caracteres repetidos consecutivos');
            errores = true;
        }
        
        // Validar monto
        const monto = parseFloat(document.querySelector('[name="monto_solicitado"]').value);
        if (isNaN(monto) || monto < 0) {
            mostrarError('monto_solicitado', 'El monto debe ser un número positivo');
            errores = true;
        }
        
        // Validar proyecto
        const proyectoId = document.querySelector('[name="proyecto_id"]').value;
        if (!proyectoId) {
            mostrarError('proyecto_id', 'Debe seleccionar un proyecto');
            errores = true;
        }
        
        if (!errores) {
            this.submit();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Errores de validación',
                text: 'Por favor corrige los errores marcados en rojo',
                confirmButtonText: 'Entendido'
            });
        }
    });

    async function verDetalleCarta(id) {
        Swal.fire({
            title: 'Cargando...',
            text: 'Obteniendo detalles de la carta',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        try {
            const response = await fetch(`/${baseRoute}/cartas/patrocinio/${id}`);
            const carta = await response.json();
            
            Swal.fire({
                title: 'Detalles de la Carta',
                html: `
                    <div class="text-left">
                        <p><strong>Número:</strong> ${carta.numero_carta || 'N/A'}</p>
                        <p><strong>Destinatario:</strong> ${carta.destinatario}</p>
                        <p><strong>Monto:</strong> L. ${parseFloat(carta.monto_solicitado).toFixed(2)}</p>
                        <p><strong>Estado:</strong> ${carta.estado}</p>
                        <p><strong>Proyecto:</strong> ${carta.proyecto ? carta.proyecto.Nombre : 'N/A'}</p>
                        <p><strong>Descripción:</strong> ${carta.descripcion || 'N/A'}</p>
                    </div>
                `,
                confirmButtonText: 'Cerrar'
            });
        } catch (error) {
            Swal.fire('Error', 'No se pudieron cargar los detalles', 'error');
        }
    }

    function eliminarCarta(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede revertir",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/${baseRoute}/cartas/patrocinio/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Eliminado', 'La carta ha sido eliminada', 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Error', data.mensaje || 'Error al eliminar', 'error');
                    }
                });
            }
        });
    }

    function aplicarFiltros() {
        const buscador = document.getElementById('buscador').value.toLowerCase();
        const filas = document.querySelectorAll('#tabla-cartas tbody tr');
        
        filas.forEach(fila => {
            if (fila.querySelector('td[colspan]')) return;
            
            const textoFila = fila.textContent.toLowerCase();
            fila.style.display = textoFila.includes(buscador) ? '' : 'none';
        });
    }
    
    document.getElementById('modalNuevaCartaPatrocinio')?.addEventListener('click', function(e) {
        if (e.target === this) cerrarModalPatrocinio();
    });
</script>
@endpush
