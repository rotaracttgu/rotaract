@extends('modulos.socio.layout')

@section('page-title', 'Mis Proyectos')

@section('content')
    <!-- Header con gradiente mejorado -->
    <div class="mb-6 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 rounded-xl p-6 shadow-lg text-white">
        <h1 class="text-2xl font-bold flex items-center">
            <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Mis Proyectos
        </h1>
        <p class="text-blue-100 mt-2">Proyectos en los que estás participando activamente</p>
    </div>

    <!-- Estadísticas Rápidas con diseño mejorado -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">TOTAL PROYECTOS</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">{{ count($proyectos ?? []) }}</h3>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">ACTIVOS</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent">
                        {{ collect($proyectos ?? [])->where('EstadoProyecto', 'Activo')->count() }}
                    </h3>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">EN PROGRESO</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-orange-800 bg-clip-text text-transparent">
                        {{ collect($proyectos ?? [])->where('EstadoProyecto', 'En Progreso')->count() }}
                    </h3>
                </div>
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Proyectos -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800 flex items-center">
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                Listado de Proyectos
            </h2>
        </div>

        @if(isset($proyectos) && count($proyectos) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($proyectos as $proyecto)
                    <div class="border border-gray-200 rounded-lg hover:shadow-lg transition-all duration-300 overflow-hidden group">
                        <!-- Header del Proyecto -->
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 border-b border-blue-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                        {{ $proyecto->NombreProyecto ?? 'Sin nombre' }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1 flex items-center">
                                        <svg class="w-4 h-4 text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Responsable: {{ $proyecto->NombreResponsable ?? 'No asignado' }}
                                    </p>
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                                        {{ ($proyecto->EstadoProyecto ?? '') === 'Activo' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                        {{ $proyecto->EstadoProyecto ?? 'Sin estado' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Contenido del Proyecto -->
                        <div class="p-4 space-y-3">
                            <!-- Descripción -->
                            <p class="text-gray-700 text-sm line-clamp-3">
                                {{ $proyecto->DescripcionProyecto ?? 'Sin descripción disponible' }}
                            </p>

                            <!-- Detalles -->
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <!-- Tipo de Proyecto -->
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <span class="text-gray-600">{{ $proyecto->TipoProyecto ?? 'Sin tipo' }}</span>
                                </div>

                                <!-- Estado del Proyecto -->
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                    <span class="text-gray-600">{{ $proyecto->EstadoProyecto ?? 'Sin estado' }}</span>
                                </div>

                                <!-- Fecha de Inicio -->
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-gray-600">
                                        {{ isset($proyecto->FechaInicio) && $proyecto->FechaInicio 
                                            ? \Carbon\Carbon::parse($proyecto->FechaInicio)->format('d/m/Y') 
                                            : 'Sin fecha' }}
                                    </span>
                                </div>

                                <!-- Fecha de Fin -->
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-600">
                                        {{ isset($proyecto->FechaFin) && $proyecto->FechaFin 
                                            ? \Carbon\Carbon::parse($proyecto->FechaFin)->format('d/m/Y') 
                                            : 'En curso' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Presupuesto (si existe) -->
                            @if(isset($proyecto->Presupuesto) && $proyecto->Presupuesto > 0)
                                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                    <span class="text-sm font-semibold text-gray-700">Presupuesto:</span>
                                    <span class="text-lg font-bold text-blue-600">
                                        L. {{ number_format($proyecto->Presupuesto, 2) }}
                                    </span>
                                </div>
                            @endif

                            <!-- Mi Rol en el Proyecto -->
                            @if(isset($proyecto->RolProyecto))
                                <div class="flex items-center p-3 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg">
                                    <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="text-sm font-semibold text-gray-700">Mi rol:</span>
                                    <span class="ml-2 text-sm font-bold text-purple-700">{{ $proyecto->RolProyecto }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Footer con Acción -->
                        <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
                            <a href="{{ route('socio.proyectos.detalle', $proyecto->ProyectoID) }}" 
                               class="flex items-center justify-center w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors group">
                                <span class="font-medium">Ver Detalles</span>
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Estado Vacío -->
            <div class="text-center py-16">
                <div class="inline-block p-6 bg-gray-100 rounded-full mb-4">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">No estás participando en ningún proyecto</h3>
                <p class="text-gray-500">Los proyectos asignados aparecerán aquí automáticamente</p>
            </div>
        @endif
    </div>

    <!-- Información Adicional -->
    <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-600 mr-4 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="font-bold text-blue-900 mb-2">Información sobre tus proyectos</h4>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• Los proyectos son asignados por la directiva del club</li>
                    <li>• Puedes ver el detalle completo de cada proyecto haciendo clic en "Ver Detalles"</li>
                    <li>• Si tienes dudas sobre algún proyecto, contacta con la Vocalía</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.border.border-gray-200.rounded-lg');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 10);
            }, index * 100);
        });
    });
</script>
@endpush