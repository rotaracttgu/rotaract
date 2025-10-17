@extends('modulos.vicepresidente.layout')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Estado de Proyectos</h1>
            <p class="text-gray-600 mt-1">Vista general del estado de todos los proyectos</p>
        </div>
        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
            🔒 Solo Lectura
        </span>
    </div>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">
            <!-- Estadísticas generales -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <p class="text-sm text-gray-600">Total Proyectos</p>
                    <p class="text-2xl font-bold text-indigo-600">15</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <p class="text-sm text-gray-600">En Planificación</p>
                    <p class="text-2xl font-bold text-yellow-600">4</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <p class="text-sm text-gray-600">En Ejecución</p>
                    <p class="text-2xl font-bold text-blue-600">6</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <p class="text-sm text-gray-600">Finalizados</p>
                    <p class="text-2xl font-bold text-green-600">4</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <p class="text-sm text-gray-600">Cancelados</p>
                    <p class="text-2xl font-bold text-red-600">1</p>
                </div>
            </div>

            <!-- Panel principal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Todos los Proyectos</h3>
                        <div class="flex gap-2">
                            <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Exportar PDF
                            </button>
                            <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Exportar Excel
                            </button>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                            <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option>Todos</option>
                                <option>Planificación</option>
                                <option>En Ejecución</option>
                                <option>Finalizado</option>
                                <option>Cancelado</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Área</label>
                            <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option>Todas</option>
                                <option>Educación</option>
                                <option>Medio Ambiente</option>
                                <option>Salud</option>
                                <option>Social</option>
                                <option>Desarrollo Comunitario</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Responsable</label>
                            <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option>Todos</option>
                                <option>Juan Pérez</option>
                                <option>María García</option>
                                <option>Carlos López</option>
                                <option>Ana Martínez</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vista</label>
                            <select id="viewMode" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="toggleView()">
                                <option value="grid">Tarjetas</option>
                                <option value="table">Tabla</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Búsqueda</label>
                            <input type="text" placeholder="Buscar proyecto..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Vista de tarjetas -->
                    <div id="gridView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Proyecto 1 -->
                        <div class="bg-white border border-gray-200 rounded-lg p-5 hover:shadow-lg transition-shadow">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800 mb-1">Proyecto Educativo 2025</h4>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">En Ejecución</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">Talleres de capacitación tecnológica para jóvenes de comunidades rurales</p>
                            
                            <div class="space-y-2 text-xs mb-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Responsable:</span>
                                    <span class="font-medium text-gray-700">Juan Pérez</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Área:</span>
                                    <span class="font-medium text-gray-700">Educación</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Inicio:</span>
                                    <span class="font-medium text-gray-700">01/09/2025</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Fin previsto:</span>
                                    <span class="font-medium text-gray-700">30/11/2025</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Participantes:</span>
                                    <span class="font-medium text-gray-700">24 socios</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Presupuesto:</span>
                                    <span class="font-medium text-green-700">L. 45,000.00</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="flex justify-between text-xs text-gray-600 mb-1">
                                    <span>Progreso</span>
                                    <span class="font-semibold">65%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 65%"></div>
                                </div>
                            </div>

                            <button class="w-full text-center text-sm text-indigo-600 hover:text-indigo-800 font-medium border border-indigo-200 rounded py-2 hover:bg-indigo-50 transition">
                                Ver detalles completos →
                            </button>
                        </div>

                        <!-- Proyecto 2 -->
                        <div class="bg-white border border-gray-200 rounded-lg p-5 hover:shadow-lg transition-shadow">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800 mb-1">Campaña Ambiental</h4>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Planificación</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">Reforestación y limpieza en zona norte de la ciudad</p>
                            
                            <div class="space-y-2 text-xs mb-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Responsable:</span>
                                    <span class="font-medium text-gray-700">María García</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Área:</span>
                                    <span class="font-medium text-gray-700">Medio Ambiente</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Inicio:</span>
                                    <span class="font-medium text-gray-700">01/11/2025</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Fin previsto:</span>
                                    <span class="font-medium text-gray-700">15/12/2025</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Participantes:</span>
                                    <span class="font-medium text-gray-700">18 socios</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Presupuesto:</span>
                                    <span class="font-medium text-green-700">L. 20,000.00</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="flex justify-between text-xs text-gray-600 mb-1">
                                    <span>Progreso</span>
                                    <span class="font-semibold">20%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-yellow-500 h-2.5 rounded-full" style="width: 20%"></div>
                                </div>
                            </div>

                            <button class="w-full text-center text-sm text-indigo-600 hover:text-indigo-800 font-medium border border-indigo-200 rounded py-2 hover:bg-indigo-50 transition">
                                Ver detalles completos →
                            </button>
                        </div>

                        <!-- Proyecto 3 -->
                        <div class="bg-white border border-gray-200 rounded-lg p-5 hover:shadow-lg transition-shadow">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800 mb-1">Jornada de Salud</h4>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Finalizado</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">Atención médica gratuita a comunidades vulnerables</p>
                            
                            <div class="space-y-2 text-xs mb-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Responsable:</span>
                                    <span class="font-medium text-gray-700">Carlos López</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Área:</span>
                                    <span class="font-medium text-gray-700">Salud</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Inicio:</span>
                                    <span class="font-medium text-gray-700">15/08/2025</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Finalizado:</span>
                                    <span class="font-medium text-gray-700">30/09/2025</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Participantes:</span>
                                    <span class="font-medium text-gray-700">30 socios</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Presupuesto:</span>
                                    <span class="font-medium text-green-700">L. 35,000.00</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="flex justify-between text-xs text-gray-600 mb-1">
                                    <span>Progreso</span>
                                    <span class="font-semibold">100%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-green-600 h-2.5 rounded-full" style="width: 100%"></div>
                                </div>
                            </div>

                            <button class="w-full text-center text-sm text-indigo-600 hover:text-indigo-800 font-medium border border-indigo-200 rounded py-2 hover:bg-indigo-50 transition">
                                Ver detalles completos →
                            </button>
                        </div>

                        <!-- Proyecto 4 -->
                        <div class="bg-white border border-gray-200 rounded-lg p-5 hover:shadow-lg transition-shadow">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800 mb-1">Biblioteca Móvil</h4>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">En Ejecución</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">Servicio de biblioteca itinerante en escuelas rurales</p>
                            
                            <div class="space-y-2 text-xs mb-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Responsable:</span>
                                    <span class="font-medium text-gray-700">Ana Martínez</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Área:</span>
                                    <span class="font-medium text-gray-700">Educación</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Inicio:</span>
                                    <span class="font-medium text-gray-700">01/08/2025</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Fin previsto:</span>
                                    <span class="font-medium text-gray-700">31/12/2025</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Participantes:</span>
                                    <span class="font-medium text-gray-700">15 socios</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Presupuesto:</span>
                                    <span class="font-medium text-green-700">L. 28,000.00</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="flex justify-between text-xs text-gray-600 mb-1">
                                    <span>Progreso</span>
                                    <span class="font-semibold">78%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 78%"></div>
                                </div>
                            </div>

                            <button class="w-full text-center text-sm text-indigo-600 hover:text-indigo-800 font-medium border border-indigo-200 rounded py-2 hover:bg-indigo-50 transition">
                                Ver detalles completos →
                            </button>
                        </div>
                    </div>

                    <!-- Vista de tabla (oculta por defecto) -->
                    <div id="tableView" class="hidden overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proyecto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsable</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Área</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progreso</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Presupuesto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Proyecto Educativo 2025</p>
                                            <p class="text-xs text-gray-500">01/09/2025 - 30/11/2025</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Juan Pérez</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Educación</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">En Ejecución</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="w-24">
                                            <div class="text-xs text-gray-600 mb-1">65%</div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: 65%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">L. 45,000.00</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-indigo-600 hover:text-indigo-900">Ver detalles</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Campaña Ambiental</p>
                                            <p class="text-xs text-gray-500">01/11/2025 - 15/12/2025</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">María García</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Medio Ambiente</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Planificación</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="w-24">
                                            <div class="text-xs text-gray-600 mb-1">20%</div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-yellow-500 h-2 rounded-full" style="width: 20%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">L. 20,000.00</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-indigo-600 hover:text-indigo-900">Ver detalles</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Jornada de Salud</p>
                                            <p class="text-xs text-gray-500">15/08/2025 - 30/09/2025</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Carlos López</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Salud</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Finalizado</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="w-24">
                                            <div class="text-xs text-gray-600 mb-1">100%</div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-green-600 h-2 rounded-full" style="width: 100%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">L. 35,000.00</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-indigo-600 hover:text-indigo-900">Ver detalles</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleView() {
            const viewMode = document.getElementById('viewMode').value;
            const gridView = document.getElementById('gridView');
            const tableView = document.getElementById('tableView');
            
            if (viewMode === 'grid') {
                gridView.classList.remove('hidden');
                tableView.classList.add('hidden');
            } else {
                gridView.classList.add('hidden');
                tableView.classList.remove('hidden');
            }
        }
    </script>
@endsection
