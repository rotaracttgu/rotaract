@extends('modulos.secretaria.layout')  

@section('title', 'Gestión de Diplomas')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Gestión de Diplomas</h1>
            <p class="text-gray-600 mt-1">Administra todos los diplomas emitidos</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.location.reload()" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Actualizar
            </button>
            @can('diplomas.crear')
            <button onclick="nuevoDiploma()" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nuevo Diploma
            </button>
            @endcan
            <a href="{{ route('secretaria.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Dashboard
            </a>
        </div>
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-6">
                <div class="bg-gradient-to-br from-amber-500 to-amber-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105">
                    <p class="text-sm text-amber-100">Total</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['total'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105">
                    <p class="text-sm text-blue-100">Este Mes</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['este_mes'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105">
                    <p class="text-sm text-purple-100">Este Año</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['este_anio'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105">
                    <p class="text-sm text-green-100">Participación</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['participacion'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-rose-500 to-rose-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105">
                    <p class="text-sm text-rose-100">Reconocim.</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['reconocimiento'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 overflow-hidden shadow-lg sm:rounded-lg p-4 cursor-pointer hover:shadow-xl transition-all transform hover:scale-105">
                    <p class="text-sm text-cyan-100">Enviados</p>
                    <p class="text-3xl font-bold text-white">{{ $estadisticas['enviados'] ?? 0 }}</p>
                </div>
            </div>

            <!-- Panel principal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Listado de Diplomas</h3>
                    </div>

                    <!-- Tabla de diplomas -->
                    <div class="overflow-x-auto">
                        <table id="tabla-diplomas" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-blue-600 to-blue-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Miembro</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Motivo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Fecha Emisión</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($diplomas as $diploma)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-600">#{{ $diploma->id }}</td>
                                        <td class="px-6 py-4">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $diploma->miembro->name ?? 'Miembro' }}</p>
                                                <p class="text-xs text-gray-500">{{ $diploma->miembro->email ?? '' }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800 capitalize">
                                                {{ $diploma->tipo }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($diploma->motivo, 50) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($diploma->fecha_emision)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($diploma->enviado_email)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Enviado
                                            </span>
                                            @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-600">
                                                No enviado
                                            </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex gap-2">
                                                <button class="text-purple-600 hover:text-purple-900" title="Ver diploma" onclick="verDiploma({{ $diploma->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </button>
                                                @if(!$diploma->enviado_email)
                                                @can('diplomas.enviar')
                                                <button class="text-green-600 hover:text-green-900" title="Enviar por email" onclick="enviarEmailDiploma({{ $diploma->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                    </svg>
                                                </button>
                                                @endcan
                                                @endif
                                                @can('diplomas.eliminar')
                                                <button class="text-red-600 hover:text-red-900" title="Eliminar" onclick="eliminarDiploma({{ $diploma->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                            </svg>
                                            <p class="mt-2 text-sm font-medium">No hay diplomas emitidos</p>
                                            <p class="text-xs text-gray-400 mt-1">Los diplomas aparecerán aquí cuando sean creados</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Información de resultados -->
                    @if($diplomas->count() > 0)
                    <div class="mt-6 flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Mostrando <span class="font-medium">{{ $diplomas->count() }}</span> diploma(s)
                        </div>
                    </div>
                    @endif

                    <!-- Paginación -->
                    @if($diplomas->hasPages())
                    <div class="mt-6">
                        {{ $diplomas->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear Diploma -->
    <div id="modalDiploma" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-xl bg-white">
            <!-- Header -->
            <div class="bg-amber-600 px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">
                        <span id="textoTituloDiploma">Nuevo Diploma</span>
                    </h3>
                    <button onclick="cerrarModalDiploma()" class="text-white hover:text-gray-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <form id="formDiploma" enctype="multipart/form-data" class="p-6">
                <input type="hidden" id="diplomaId" name="diploma_id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Miembro -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Miembro <span class="text-red-500">*</span></label>
                        <select name="miembro_id" id="miembro_id" required 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            <option value="">Seleccionar miembro...</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->name }} ({{ $usuario->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tipo de Diploma -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Diploma <span class="text-red-500">*</span></label>
                        <select name="tipo" id="tipo" required 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            <option value="">Seleccionar...</option>
                            <option value="participacion">Participación</option>
                            <option value="reconocimiento">Reconocimiento</option>
                            <option value="merito">Mérito</option>
                            <option value="asistencia">Asistencia</option>
                        </select>
                    </div>

                    <!-- Fecha de Emisión -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Emisión <span class="text-red-500">*</span></label>
                        <input type="date" name="fecha_emision" id="fecha_emision" required 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                    </div>

                    <!-- Motivo -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Motivo del Diploma <span class="text-red-500">*</span></label>
                        <textarea name="motivo" id="motivo" rows="4" required maxlength="500"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                            placeholder="Describe el motivo o logro por el cual se otorga este diploma..."></textarea>
                        <p class="text-xs text-gray-500 mt-1">Máximo 500 caracteres</p>
                    </div>

                    <!-- Archivo PDF (opcional) -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Archivo PDF (opcional)</label>
                        <input type="file" name="archivo_pdf" id="archivo_pdf_diploma" accept=".pdf"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        <p class="text-xs text-gray-500 mt-1">Si no subes un archivo, se generará automáticamente. Formato: PDF, máx. 5MB</p>
                    </div>
                </div>

                <!-- Botones -->
                <div class="mt-6 pt-4 border-t flex justify-end gap-3">
                    <button type="button" onclick="cerrarModalDiploma()"
                            class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium shadow-sm">
                        Cancelar
                    </button>
                    <button type="submit" id="btnGuardarDiploma"
                            class="px-6 py-2.5 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition font-medium shadow-md hover:shadow-lg">
                        <span id="textoBotonGuardarDiploma">Crear Diploma</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Ver Diploma -->
    <div id="modalVerDiploma" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-11/12 md:w-3/4 lg:w-1/2 shadow-2xl rounded-xl bg-white">
            <!-- Header -->
            <div class="bg-teal-600 px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Detalles del Diploma</h3>
                    <button onclick="cerrarModal('modalVerDiploma')" class="text-white hover:text-gray-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div id="contenidoDiploma" class="p-6">
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-teal-600 mb-4"></div>
                    <p class="text-gray-600 font-medium">Cargando detalles...</p>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t rounded-b-xl flex justify-end">
                <button onclick="cerrarModal('modalVerDiploma')" class="px-6 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-medium shadow-sm">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <script>
        // Abrir modal para crear nuevo diploma
        function nuevoDiploma() {
            document.getElementById('diplomaId').value = '';
            document.getElementById('formDiploma').reset();
            document.getElementById('textoTituloDiploma').textContent = 'Nuevo Diploma';
            document.getElementById('textoBotonGuardarDiploma').textContent = 'Crear Diploma';
            document.getElementById('fecha_emision').valueAsDate = new Date();
            document.getElementById('modalDiploma').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Ver detalles de un diploma
        async function verDiploma(id) {
            const modal = document.getElementById('modalVerDiploma');
            const contenedor = document.getElementById('contenidoDiploma');
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            contenedor.innerHTML = `
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-teal-600 mb-4"></div>
                    <p class="text-gray-600 font-medium">Cargando detalles...</p>
                </div>
            `;
            
            try {
                const response = await fetch(`/secretaria/diplomas/${id}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                const diploma = await response.json();
                
                const fechaEmision = new Date(diploma.fecha_emision).toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                setTimeout(() => {
                    contenedor.innerHTML = `
                        <div class="animate-fadeIn">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Miembro y Tipo -->
                                <div class="md:col-span-2 bg-gradient-to-br from-amber-50 to-yellow-50 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-1">Miembro</p>
                                    <p class="text-lg font-bold text-gray-900">${diploma.miembro?.name || 'Miembro no encontrado'}</p>
                                    <p class="text-sm text-gray-600">${diploma.miembro?.email || ''}</p>
                                    <div class="mt-3 flex gap-2">
                                        <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full capitalize">${diploma.tipo}</span>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">${fechaEmision}</span>
                                        ${diploma.enviado_email ? 
                                            '<span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Enviado por email</span>' :
                                            '<span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full">No enviado</span>'
                                        }
                                    </div>
                                </div>
                                
                                <!-- Motivo -->
                                <div class="md:col-span-2 bg-white border-2 border-gray-200 p-4 rounded-lg">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-2">Motivo del Diploma</p>
                                    <div class="text-sm text-gray-700 bg-gray-50 p-4 rounded border">
                                        ${diploma.motivo}
                                    </div>
                                </div>
                                
                                ${diploma.archivo_path ? `
                                <div class="md:col-span-2">
                                    <p class="text-xs font-medium text-gray-500 uppercase mb-2">Documento</p>
                                    <div class="flex gap-2">
                                        <a href="/storage/${diploma.archivo_path}" target="_blank" 
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium text-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Ver PDF
                                        </a>
                                        <a href="/secretaria/diplomas/${diploma.id}/descargar" 
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Descargar
                                        </a>
                                    </div>
                                </div>
                                ` : `
                                <div class="md:col-span-2">
                                    <a href="/secretaria/diplomas/${diploma.id}/descargar" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Generar y Descargar PDF
                                    </a>
                                </div>
                                `}
                                
                                <!-- Metadata -->
                                <div class="md:col-span-2 bg-gray-50 p-4 rounded-lg text-sm text-gray-500 space-y-1">
                                    <p><strong>Emitido por:</strong> ${diploma.emisor?.name || 'Sistema'}</p>
                                    <p><strong>Fecha de creación:</strong> ${new Date(diploma.created_at).toLocaleString('es-ES')}</p>
                                    ${diploma.enviado_email && diploma.fecha_envio_email ? 
                                        `<p><strong>Enviado por email:</strong> ${new Date(diploma.fecha_envio_email).toLocaleString('es-ES')}</p>` : 
                                        ''
                                    }
                                </div>

                                ${!diploma.enviado_email ? `
                                <div class="md:col-span-2 flex gap-3 pt-4 border-t border-gray-200">
                                    <button onclick="enviarEmailDiploma(${diploma.id}); cerrarModal('modalVerDiploma');" 
                                        class="flex-1 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transition-all">
                                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        Enviar por Email
                                    </button>
                                </div>
                                ` : ''}
                            </div>
                        </div>
                    `;
                }, 300);
                
            } catch (error) {
                console.error('Error:', error);
                contenedor.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-12 animate-shake">
                        <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-red-600 font-medium">Error al cargar los detalles</p>
                        <p class="text-gray-500 text-sm mt-2">Por favor, intenta nuevamente</p>
                    </div>
                `;
            }
        }

        // Guardar diploma
        document.getElementById('formDiploma').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const diplomaId = document.getElementById('diplomaId').value;
            const formData = new FormData(this);
            const isEdit = diplomaId !== '';
            
            const url = isEdit ? `/secretaria/diplomas/${diplomaId}` : '/secretaria/diplomas';
            
            const btnGuardar = document.getElementById('btnGuardarDiploma');
            const textoOriginal = btnGuardar.innerHTML;
            btnGuardar.disabled = true;
            btnGuardar.innerHTML = '<svg class="animate-spin h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Guardando...';
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(isEdit ? 'Diploma actualizado exitosamente' : 'Diploma creado exitosamente');
                    cerrarModalDiploma();
                    window.location.reload();
                } else {
                    alert(data.message || 'Error al guardar el diploma');
                    btnGuardar.disabled = false;
                    btnGuardar.innerHTML = textoOriginal;
                }
            })
            .catch(error => {
                alert('Error de conexión. Por favor, intenta de nuevo.');
                console.error(error);
                btnGuardar.disabled = false;
                btnGuardar.innerHTML = textoOriginal;
            });
        });

        // Eliminar diploma
        function eliminarDiploma(id) {
            if (!confirm('¿Estás seguro de eliminar este diploma? Esta acción no se puede deshacer.')) return;
            
            fetch(`/secretaria/diplomas/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Diploma eliminado exitosamente');
                    window.location.reload();
                } else {
                    alert(data.message || 'Error al eliminar el diploma');
                }
            })
            .catch(error => {
                alert('Error de conexión');
                console.error(error);
            });
        }

        // Enviar diploma por email
        function enviarEmailDiploma(id) {
            if (!confirm('¿Enviar este diploma por email al miembro?')) return;
            
            fetch(`/secretaria/diplomas/${id}/enviar-email`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Diploma enviado por email exitosamente');
                    window.location.reload();
                } else {
                    alert(data.message || 'Error al enviar el email');
                }
            })
            .catch(error => {
                alert('Error de conexión');
                console.error(error);
            });
        }

        function cerrarModalDiploma() {
            document.getElementById('modalDiploma').classList.add('hidden');
            document.getElementById('formDiploma').reset();
            document.body.style.overflow = 'auto';
        }

        function cerrarModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Cerrar modales al hacer clic fuera
        document.getElementById('modalDiploma')?.addEventListener('click', function(e) {
            if (e.target === this) cerrarModalDiploma();
        });
        document.getElementById('modalVerDiploma')?.addEventListener('click', function(e) {
            if (e.target === this) cerrarModal('modalVerDiploma');
        });
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }

        .animate-shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>
@endsection