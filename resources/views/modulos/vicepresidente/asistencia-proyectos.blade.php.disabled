@extends('modulos.vicepresidente.layout')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Participación en Proyectos</h1>
            <p class="text-gray-600 mt-1">Registro de participación de miembros en proyectos</p>
        </div>
        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
            🔒 Solo Lectura
        </span>
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <!-- Estadísticas de participación -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 shadow-sm">
                    <p class="text-sm text-gray-600 font-medium">Proyectos Activos</p>
                    <p class="text-3xl font-bold text-purple-700">8</p>
                    <p class="text-xs text-gray-500 mt-1">En curso</p>
                </div>
                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg p-4 shadow-sm">
                    <p class="text-sm text-gray-600 font-medium">Total Participantes</p>
                    <p class="text-3xl font-bold text-indigo-700">156</p>
                    <p class="text-xs text-gray-500 mt-1">Registros</p>
                </div>
                <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg p-4 shadow-sm">
                    <p class="text-sm text-gray-600 font-medium">Promedio por Proyecto</p>
                    <p class="text-3xl font-bold text-pink-700">19.5</p>
                    <p class="text-xs text-gray-500 mt-1">Socios</p>
                </div>
                <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 rounded-lg p-4 shadow-sm">
                    <p class="text-sm text-gray-600 font-medium">Socios Activos</p>
                    <p class="text-3xl font-bold text-cyan-700">28</p>
                    <p class="text-xs text-gray-500 mt-1">De 35 totales</p>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 shadow-sm">
                    <p class="text-sm text-gray-600 font-medium">Nivel Alto</p>
                    <p class="text-3xl font-bold text-green-700">15</p>
                    <p class="text-xs text-gray-500 mt-1">Socios</p>
                </div>
            </div>

            <!-- Panel principal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Participación por Proyecto</h3>
                        <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Exportar Reporte
                        </button>
                    </div>

                    <!-- Filtros -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Proyecto</label>
                            <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                <option>Todos los proyectos</option>
                                <option>Proyecto Educativo 2025</option>
                                <option>Campaña Ambiental</option>
                                <option>Jornada de Salud</option>
                                <option>Biblioteca Móvil</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nivel de Involucramiento</label>
                            <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                <option>Todos</option>
                                <option>Alto (5+ actividades)</option>
                                <option>Medio (2-4 actividades)</option>
                                <option>Bajo (1 actividad)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estado del Proyecto</label>
                            <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                <option>Todos</option>
                                <option>En Ejecución</option>
                                <option>Finalizado</option>
                                <option>Planificación</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Buscar Socio</label>
                            <input type="text" placeholder="Nombre del socio..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>
                    </div>

                    <!-- Tabla de participación -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proyecto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsable</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Participantes</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nivel Promedio</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actividades</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-gray-900">Proyecto Educativo 2025</p>
                                        <p class="text-xs text-gray-500">Educación</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Juan Pérez</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            En Ejecución
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <span class="font-medium text-gray-900">24 socios</span>
                                            <p class="text-xs text-gray-500">68.6% del club</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Alto
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15 actividades</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-purple-600 hover:text-purple-900">Ver detalles</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-gray-900">Campaña Ambiental</p>
                                        <p class="text-xs text-gray-500">Medio Ambiente</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">María García</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Planificación
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <span class="font-medium text-gray-900">18 socios</span>
                                            <p class="text-xs text-gray-500">51.4% del club</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Medio
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">8 actividades</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-purple-600 hover:text-purple-900">Ver detalles</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-gray-900">Jornada de Salud</p>
                                        <p class="text-xs text-gray-500">Salud</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Carlos López</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Finalizado
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <span class="font-medium text-gray-900">30 socios</span>
                                            <p class="text-xs text-gray-500">85.7% del club</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Alto
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">20 actividades</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-purple-600 hover:text-purple-900">Ver detalles</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-gray-900">Biblioteca Móvil</p>
                                        <p class="text-xs text-gray-500">Educación</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Ana Martínez</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            En Ejecución
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <span class="font-medium text-gray-900">15 socios</span>
                                            <p class="text-xs text-gray-500">42.9% del club</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Alto
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">12 actividades</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-purple-600 hover:text-purple-900">Ver detalles</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Top socios más activos -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Top 10 Socios Más Activos en Proyectos</h3>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-4 border-l-4 border-yellow-500">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-2xl">🥇</span>
                                <p class="text-xs text-gray-600">1er Lugar</p>
                            </div>
                            <p class="font-semibold text-gray-900">Ana Martínez</p>
                            <p class="text-xs text-gray-500 mt-1">8 proyectos activos</p>
                            <div class="mt-2 flex items-center gap-1">
                                <div class="flex-1 bg-yellow-200 rounded-full h-2">
                                    <div class="bg-yellow-600 h-2 rounded-full" style="width: 100%"></div>
                                </div>
                                <span class="text-xs font-semibold text-yellow-700">100%</span>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-4 border-l-4 border-gray-400">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-2xl">🥈</span>
                                <p class="text-xs text-gray-600">2do Lugar</p>
                            </div>
                            <p class="font-semibold text-gray-900">Luis Hernández</p>
                            <p class="text-xs text-gray-500 mt-1">7 proyectos activos</p>
                            <div class="mt-2 flex items-center gap-1">
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-gray-500 h-2 rounded-full" style="width: 87.5%"></div>
                                </div>
                                <span class="text-xs font-semibold text-gray-700">87.5%</span>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-4 border-l-4 border-orange-400">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-2xl">🥉</span>
                                <p class="text-xs text-gray-600">3er Lugar</p>
                            </div>
                            <p class="font-semibold text-gray-900">Sofia Rodríguez</p>
                            <p class="text-xs text-gray-500 mt-1">6 proyectos activos</p>
                            <div class="mt-2 flex items-center gap-1">
                                <div class="flex-1 bg-orange-200 rounded-full h-2">
                                    <div class="bg-orange-500 h-2 rounded-full" style="width: 75%"></div>
                                </div>
                                <span class="text-xs font-semibold text-orange-700">75%</span>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-lg text-gray-500 font-semibold">4</span>
                                <p class="text-xs text-gray-600">4to Lugar</p>
                            </div>
                            <p class="font-semibold text-gray-900">Diego Flores</p>
                            <p class="text-xs text-gray-500 mt-1">5 proyectos activos</p>
                            <div class="mt-2 flex items-center gap-1">
                                <div class="flex-1 bg-blue-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: 62.5%"></div>
                                </div>
                                <span class="text-xs font-semibold text-blue-700">62.5%</span>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-lg text-gray-500 font-semibold">5</span>
                                <p class="text-xs text-gray-600">5to Lugar</p>
                            </div>
                            <p class="font-semibold text-gray-900">Elena Castro</p>
                            <p class="text-xs text-gray-500 mt-1">5 proyectos activos</p>
                            <div class="mt-2 flex items-center gap-1">
                                <div class="flex-1 bg-green-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 62.5%"></div>
                                </div>
                                <span class="text-xs font-semibold text-green-700">62.5%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Distribución por nivel de involucramiento -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-semibold text-gray-800">Nivel Alto</h4>
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">15 socios</span>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-green-600">42.9%</div>
                            <p class="text-xs text-gray-500 mt-2">5+ proyectos activos</p>
                        </div>
                        <div class="mt-4 bg-gray-200 rounded-full h-3">
                            <div class="bg-green-600 h-3 rounded-full" style="width: 42.9%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-semibold text-gray-800">Nivel Medio</h4>
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">10 socios</span>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-yellow-600">28.6%</div>
                            <p class="text-xs text-gray-500 mt-2">2-4 proyectos activos</p>
                        </div>
                        <div class="mt-4 bg-gray-200 rounded-full h-3">
                            <div class="bg-yellow-500 h-3 rounded-full" style="width: 28.6%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-semibold text-gray-800">Nivel Bajo</h4>
                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">10 socios</span>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-red-600">28.6%</div>
                            <p class="text-xs text-gray-500 mt-2">0-1 proyectos activos</p>
                        </div>
                        <div class="mt-4 bg-gray-200 rounded-full h-3">
                            <div class="bg-red-500 h-3 rounded-full" style="width: 28.6%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
