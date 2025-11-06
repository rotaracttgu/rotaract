@extends('modulos.vicepresidente.layout')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Asistencia a Reuniones</h1>
            <p class="text-gray-600 mt-1">Control de asistencia de los miembros</p>
        </div>
        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
            🔒 Solo Lectura
        </span>
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <!-- Estadísticas de asistencia -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 shadow-sm">
                    <p class="text-sm text-gray-600 font-medium">Asistencia Promedio</p>
                    <p class="text-3xl font-bold text-green-700">87%</p>
                    <p class="text-xs text-gray-500 mt-1">Este mes</p>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 shadow-sm">
                    <p class="text-sm text-gray-600 font-medium">Total Reuniones</p>
                    <p class="text-3xl font-bold text-blue-700">24</p>
                    <p class="text-xs text-gray-500 mt-1">Este año</p>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 shadow-sm">
                    <p class="text-sm text-gray-600 font-medium">Socios Activos</p>
                    <p class="text-3xl font-bold text-purple-700">32</p>
                    <p class="text-xs text-gray-500 mt-1">De 35 totales</p>
                </div>
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-4 shadow-sm">
                    <p class="text-sm text-gray-600 font-medium">Mejor Asistencia</p>
                    <p class="text-3xl font-bold text-yellow-700">95%</p>
                    <p class="text-xs text-gray-500 mt-1">07/10/2025</p>
                </div>
                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-4 shadow-sm">
                    <p class="text-sm text-gray-600 font-medium">Menor Asistencia</p>
                    <p class="text-3xl font-bold text-red-700">72%</p>
                    <p class="text-xs text-gray-500 mt-1">21/09/2025</p>
                </div>
            </div>

            <!-- Panel principal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Registro de Asistencia</h3>
                        <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Exportar Excel
                        </button>
                    </div>

                    <!-- Filtros -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Reunión</label>
                            <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option>Todas</option>
                                <option>Directiva</option>
                                <option>General de Socios</option>
                                <option>Comité</option>
                                <option>Extraordinaria</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mes</label>
                            <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option>Octubre 2025</option>
                                <option>Septiembre 2025</option>
                                <option>Agosto 2025</option>
                                <option>Julio 2025</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Asistencia Mínima</label>
                            <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option>Todos</option>
                                <option>Mayor a 90%</option>
                                <option>Mayor a 80%</option>
                                <option>Menor a 80%</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Búsqueda</label>
                            <input type="text" placeholder="Buscar reunión..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Tabla de asistencia -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reunión</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asistentes</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">% Asistencia</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">14/10/2025</td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-gray-900">Reunión de Directiva</p>
                                        <p class="text-xs text-gray-500">Planificación mensual</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Directiva
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">18:00 hrs</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <span class="font-medium text-gray-900">8</span>
                                            <span class="text-gray-500"> / 10</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 mr-2">
                                                80%
                                            </span>
                                            <div class="w-20 bg-gray-200 rounded-full h-2">
                                                <div class="bg-green-600 h-2 rounded-full" style="width: 80%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3">Ver lista</button>
                                        <button class="text-gray-600 hover:text-gray-900">PDF</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">07/10/2025</td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-gray-900">Reunión General de Socios</p>
                                        <p class="text-xs text-gray-500">Presentación proyectos</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            General
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">19:00 hrs</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <span class="font-medium text-gray-900">28</span>
                                            <span class="text-gray-500"> / 32</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 mr-2">
                                                87.5%
                                            </span>
                                            <div class="w-20 bg-gray-200 rounded-full h-2">
                                                <div class="bg-green-600 h-2 rounded-full" style="width: 87.5%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3">Ver lista</button>
                                        <button class="text-gray-600 hover:text-gray-900">PDF</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">30/09/2025</td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-gray-900">Comité de Proyectos</p>
                                        <p class="text-xs text-gray-500">Evaluación trimestral</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Comité
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">17:00 hrs</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <span class="font-medium text-gray-900">12</span>
                                            <span class="text-gray-500"> / 15</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 mr-2">
                                                80%
                                            </span>
                                            <div class="w-20 bg-gray-200 rounded-full h-2">
                                                <div class="bg-green-600 h-2 rounded-full" style="width: 80%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3">Ver lista</button>
                                        <button class="text-gray-600 hover:text-gray-900">PDF</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">21/09/2025</td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-gray-900">Reunión Extraordinaria</p>
                                        <p class="text-xs text-gray-500">Votación urgente</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Extraordinaria
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">20:00 hrs</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <span class="font-medium text-gray-900">23</span>
                                            <span class="text-gray-500"> / 32</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 mr-2">
                                                72%
                                            </span>
                                            <div class="w-20 bg-gray-200 rounded-full h-2">
                                                <div class="bg-yellow-500 h-2 rounded-full" style="width: 72%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3">Ver lista</button>
                                        <button class="text-gray-600 hover:text-gray-900">PDF</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-6 flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Mostrando <span class="font-medium">1</span> a <span class="font-medium">10</span> de <span class="font-medium">24</span> reuniones
                        </div>
                        <div class="flex gap-2">
                            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm hover:bg-gray-50">Anterior</button>
                            <button class="px-3 py-1 bg-blue-600 text-white rounded-md text-sm">1</button>
                            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm hover:bg-gray-50">2</button>
                            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm hover:bg-gray-50">3</button>
                            <button class="px-3 py-1 border border-gray-300 rounded-md text-sm hover:bg-gray-50">Siguiente</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas por socio -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Top 10 Socios con Mayor Asistencia</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center justify-between p-3 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg border-l-4 border-yellow-500">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">🥇</span>
                                <div>
                                    <p class="font-semibold text-gray-900">Ana Martínez</p>
                                    <p class="text-xs text-gray-600">23 de 24 reuniones</p>
                                </div>
                            </div>
                            <span class="text-lg font-bold text-yellow-700">95.8%</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg border-l-4 border-gray-400">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">🥈</span>
                                <div>
                                    <p class="font-semibold text-gray-900">Luis Hernández</p>
                                    <p class="text-xs text-gray-600">22 de 24 reuniones</p>
                                </div>
                            </div>
                            <span class="text-lg font-bold text-gray-700">91.7%</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg border-l-4 border-orange-400">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">🥉</span>
                                <div>
                                    <p class="font-semibold text-gray-900">Sofia Rodríguez</p>
                                    <p class="text-xs text-gray-600">21 de 24 reuniones</p>
                                </div>
                            </div>
                            <span class="text-lg font-bold text-orange-700">87.5%</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <span class="text-lg text-gray-500">4</span>
                                <div>
                                    <p class="font-medium text-gray-900">Diego Flores</p>
                                    <p class="text-xs text-gray-600">20 de 24 reuniones</p>
                                </div>
                            </div>
                            <span class="text-md font-semibold text-gray-700">83.3%</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <span class="text-lg text-gray-500">5</span>
                                <div>
                                    <p class="font-medium text-gray-900">Elena Castro</p>
                                    <p class="text-xs text-gray-600">20 de 24 reuniones</p>
                                </div>
                            </div>
                            <span class="text-md font-semibold text-gray-700">83.3%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
