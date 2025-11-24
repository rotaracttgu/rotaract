@extends('modulos.tesorero.layout')

@push('styles')
    <style>
        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
    </style>
@endpush

@section('content')
    <!-- Header con gradiente mejorado -->
    <div class="mb-6 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 rounded-xl p-6 shadow-lg text-white">
        <h1 class="text-2xl font-bold">
            Panel de Control <span class="text-yellow-300">Financiero</span>
        </h1>
        <p class="text-emerald-100 mt-2">Bienvenido al módulo de Tesorería</p>
    </div>

    <!-- Tarjetas de Estadísticas con diseño mejorado -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Balance Total -->
        <div class="stat-card bg-white rounded-xl shadow-lg p-6 border-l-4 border-emerald-500">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">BALANCE TOTAL</p>
                    <div class="flex items-baseline">
                        <h3 class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-emerald-800 bg-clip-text text-transparent">
                            L. {{ number_format($balanceTotal ?? 0, 2) }}
                        </h3>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Ingresos -->
        <div class="stat-card bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">TOTAL INGRESOS</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-green-600 to-green-800 bg-clip-text text-transparent">
                        L. {{ number_format($totalIngresos ?? 0, 2) }}
                    </h3>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Gastos -->
        <div class="stat-card bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">TOTAL GASTOS</p>
                    <div class="flex items-baseline">
                        <h3 class="text-4xl font-bold bg-gradient-to-r from-red-600 to-red-800 bg-clip-text text-transparent">
                            L. {{ number_format($totalGastos ?? 0, 2) }}
                        </h3>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-red-500 to-red-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Gastos Pendientes -->
        <div class="stat-card bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase tracking-wide mb-2 font-semibold">GASTOS PENDIENTES</p>
                    <h3 class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-orange-800 bg-clip-text text-transparent">
                        {{ $gastosPendientes ?? 0 }}
                    </h3>
                </div>
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas de Presupuesto -->
    @if(isset($alertasPresupuesto) && count($alertasPresupuesto) > 0)
    <div class="mb-6">
        <div class="bg-gradient-to-r from-orange-50 to-red-50 border-l-4 border-orange-500 rounded-xl p-4 shadow-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-bold text-orange-800">
                        Alertas de Presupuesto ({{ count($alertasPresupuesto) }})
                    </h3>
                    <div class="mt-2 text-sm text-orange-700 space-y-1">
                        @foreach($alertasPresupuesto as $alerta)
                        <p>• {{ $alerta }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Contenido Principal en 2 Columnas -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna Izquierda (2/3) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Gráfica de Flujo de Efectivo -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center">
                        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                        </div>
                        Flujo de Efectivo Mensual
                    </h2>
                    <div class="flex space-x-4 text-sm">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-green-500 mr-2 shadow-md"></div>
                            <span class="text-gray-600 font-medium">Ingresos</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-red-400 mr-2 shadow-md"></div>
                            <span class="text-gray-600 font-medium">Gastos</span>
                        </div>
                    </div>
                </div>
                <canvas id="flujoEfectivoChart" class="w-full" height="80"></canvas>
            </div>

            <!-- Gastos Pendientes de Aprobación -->
            @if(isset($gastosPendientesAprobacion) && count($gastosPendientesAprobacion) > 0)
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center">
                        <div class="bg-gradient-to-br from-orange-500 to-red-600 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        Gastos Pendientes de Aprobación
                    </h2>
                    <span class="px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-sm font-bold">
                        {{ count($gastosPendientesAprobacion) }}
                    </span>
                </div>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @foreach($gastosPendientesAprobacion as $gasto)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">{{ $gasto->descripcion }}</p>
                            <p class="text-sm text-gray-500">{{ $gasto->categoria }} • {{ $gasto->fecha }}</p>
                        </div>
                        <div class="text-right ml-4">
                            <p class="text-lg font-bold text-gray-900">L. {{ number_format($gasto->monto, 2) }}</p>
                            <div class="flex space-x-2 mt-2">
                                <button onclick="aprobarGasto({{ $gasto->id }})" class="px-3 py-1 bg-green-500 text-white text-xs rounded-lg hover:bg-green-600">
                                    Aprobar
                                </button>
                                <button onclick="rechazarGasto({{ $gasto->id }})" class="px-3 py-1 bg-red-500 text-white text-xs rounded-lg hover:bg-red-600">
                                    Rechazar
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Columna Derecha (1/3) - Acciones Rápidas -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    Acciones Rápidas
                </h2>

                <div class="space-y-3">
                    <a href="{{ route('tesorero.ingresos.create') }}" class="flex items-center p-4 bg-gradient-to-r from-green-50 to-green-100 text-green-700 rounded-xl hover:from-green-100 hover:to-green-200 transition-all duration-300 shadow-sm hover:shadow-md group">
                        <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-xl mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <span class="font-bold">Registrar Ingreso</span>
                    </a>

                    <a href="{{ route('tesorero.gastos.create') }}" class="flex items-center p-4 bg-gradient-to-r from-red-50 to-red-100 text-red-700 rounded-xl hover:from-red-100 hover:to-red-200 transition-all duration-300 shadow-sm hover:shadow-md group">
                        <div class="bg-gradient-to-br from-red-500 to-red-600 p-3 rounded-xl mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                        </div>
                        <span class="font-bold">Registrar Gasto</span>
                    </a>

                    <a href="{{ route('tesorero.reportes.index') }}" class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 rounded-xl hover:from-purple-100 hover:to-purple-200 transition-all duration-300 shadow-sm hover:shadow-md group">
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-3 rounded-xl mr-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="font-bold">Generar Reporte</span>
                    </a>
                </div>
            </div>

            <!-- Resumen de Presupuestos -->
            @if(isset($presupuestosActivos) && count($presupuestosActivos) > 0)
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    Presupuestos Activos
                </h2>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @foreach($presupuestosActivos as $presupuesto)
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <div class="flex justify-between items-start mb-2">
                            <p class="font-semibold text-gray-800 text-sm">{{ $presupuesto->nombre }}</p>
                            <span class="text-xs font-bold text-gray-600">
                                {{ $presupuesto->monto > 0 ? number_format(($presupuesto->gastado / $presupuesto->monto) * 100, 0) : 0 }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-2 rounded-full" 
                                 style="width: {{ $presupuesto->monto > 0 ? min(($presupuesto->gastado / $presupuesto->monto) * 100, 100) : 0 }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-600">
                            <span>L. {{ number_format($presupuesto->gastado, 2) }}</span>
                            <span>L. {{ number_format($presupuesto->monto, 2) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfica de Flujo de Efectivo
    const ctx = document.getElementById('flujoEfectivoChart').getContext('2d');
    
    const mesesData = {!! json_encode($datosFlujo['meses'] ?? ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun']) !!};
    const ingresosData = {!! json_encode($datosFlujo['ingresos'] ?? [5000, 6000, 5500, 7000, 8000, 7500]) !!};
    const gastosData = {!! json_encode($datosFlujo['gastos'] ?? [4000, 4500, 5000, 5500, 6000, 5800]) !!};
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: mesesData,
            datasets: [{
                label: 'Ingresos',
                data: ingresosData,
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                fill: true,
                tension: 0.4
            }, {
                label: 'Gastos',
                data: gastosData,
                borderColor: 'rgb(239, 68, 68)',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return 'L. ' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Funciones para aprobar/rechazar gastos
    function aprobarGasto(id) {
        if (confirm('¿Está seguro que desea aprobar este gasto?')) {
            fetch(`/tesorero/gastos/${id}/aprobar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al aprobar el gasto');
                }
            });
        }
    }

    function rechazarGasto(id) {
        const motivo = prompt('Ingrese el motivo del rechazo:');
        if (motivo) {
            fetch(`/tesorero/gastos/${id}/rechazar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ motivo: motivo })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al rechazar el gasto');
                }
            });
        }
    }
</script>
@endpush
