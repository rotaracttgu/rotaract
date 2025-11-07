@extends('modulos.socio.layout')

@section('page-title', 'Mis Proyectos')

@section('content')
    <!-- Header -->
    <div class="mb-6 bg-gradient-to-r from-blue-50 to-green-50 rounded-lg p-6 border border-blue-200">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-project-diagram text-blue-600 mr-3"></i>
            Mis Proyectos
        </h1>
        <p class="text-gray-600 mt-2">Proyectos en los que estás participando activamente</p>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Total Proyectos</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ count($proyectos ?? []) }}</h3>
                </div>
                <div class="bg-blue-100 p-4 rounded-xl">
                    <i class="fas fa-folder-open text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">Activos</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                        {{ collect($proyectos ?? [])->where('EstadoProyecto', 'Activo')->count() }}
                    </h3>
                </div>
                <div class="bg-green-100 p-4 rounded-xl">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-1">En Progreso</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                        {{ collect($proyectos ?? [])->where('EstadoProyecto', 'En Progreso')->count() }}
                    </h3>
                </div>
                <div class="bg-orange-100 p-4 rounded-xl">
                    <i class="fas fa-spinner text-orange-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Proyectos -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-800 flex items-center">
                <i class="fas fa-list text-blue-500 mr-3"></i>
                Listado de Proyectos
            </h2>
        </div>

        <div class="p-6">
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
                                        <p class="text-sm text-gray-600 mt-1">
                                            <i class="fas fa-user text-blue-500 mr-1"></i>
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
                                        <i class="fas fa-tag text-purple-500 mr-2"></i>
                                        <span class="text-gray-600">{{ $proyecto->TipoProyecto ?? 'Sin tipo' }}</span>
                                    </div>

                                    <!-- Estado del Proyecto -->
                                    <div class="flex items-center">
                                        <i class="fas fa-tasks text-orange-500 mr-2"></i>
                                        <span class="text-gray-600">{{ $proyecto->EstadoProyecto ?? 'Sin estado' }}</span>
                                    </div>

                                    <!-- Fecha de Inicio -->
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-plus text-green-500 mr-2"></i>
                                        <span class="text-gray-600">
                                            {{ isset($proyecto->FechaInicio) && $proyecto->FechaInicio 
                                                ? \Carbon\Carbon::parse($proyecto->FechaInicio)->format('d/m/Y') 
                                                : 'Sin fecha' }}
                                        </span>
                                    </div>

                                    <!-- Fecha de Fin -->
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-check text-red-500 mr-2"></i>
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
                                        <i class="fas fa-user-tag text-purple-600 mr-2"></i>
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
                                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Estado Vacío -->
                <div class="text-center py-16">
                    <div class="inline-block p-6 bg-gray-100 rounded-full mb-4">
                        <i class="fas fa-folder-open text-6xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">No estás participando en ningún proyecto</h3>
                    <p class="text-gray-500">Los proyectos asignados aparecerán aquí automáticamente</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Información Adicional -->
    <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-600 text-2xl mr-4 mt-1"></i>
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