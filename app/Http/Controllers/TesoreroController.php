<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\NotificacionService;
use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\Miembro;
use App\Models\PagoMembresia;
use App\Models\Presupuesto;
use App\Models\Finanza;
use App\Models\Notificacion;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TesoreroController extends Controller
{
    use AuthorizesRequests;
    /**
     * Muestra el dashboard principal del Tesorero
     */
    public function index()
    {
        $this->authorize('finanzas.ver');
        // Datos del mes actual
        $mesActual = now()->month;
        $anioActual = now()->year;
        
        // Calcular ingresos del mes
        $totalIngresosMes = Ingreso::whereMonth('fecha', $mesActual)
            ->whereYear('fecha', $anioActual)
            ->sum('monto') ?? 0;
        
        // Calcular egresos del mes
        $totalEgresosMes = Egreso::whereMonth('fecha', $mesActual)
            ->whereYear('fecha', $anioActual)
            ->sum('monto') ?? 0;
        
        // Balance del mes
        $balanceMes = $totalIngresosMes - $totalEgresosMes;
        
        // Finanza actual (calculada sobre la marcha)
        $finanzaActual = (object)[
            'saldo_actual' => $balanceMes,
            'periodo' => now()->format('Y-m'),
            'total_ingresos_mes' => $totalIngresosMes,
            'total_egresos_mes' => $totalEgresosMes
        ];
        
        // Calcular datos generales (totales todos los tiempos)
        $total_ingresos = Ingreso::sum('monto') ?? 0;
        $total_gastos = Egreso::whereRaw('LOWER(estado) = ?', ['aprobado'])->sum('monto') ?? 0;
        $balance_neto = $total_ingresos - $total_gastos;
        $cantidad_ingresos = Ingreso::count();
        $cantidad_gastos = Egreso::count();
        $total_movimientos = $cantidad_ingresos + $cantidad_gastos;
        
        // Objeto balance_general
        $balance_general = (object)[
            'balance_neto' => $balance_neto,
            'total_ingresos' => $total_ingresos,
            'total_gastos' => $total_gastos,
            'total_movimientos' => $total_movimientos,
            'cantidad_ingresos' => $cantidad_ingresos,
            'cantidad_gastos' => $cantidad_gastos,
        ];
        
        // Presupuesto disponible (calculado desde presupuestos activos del mes actual)
        $totalPresupuestado = Presupuesto::where('estado', 'activa')
            ->whereMonth('fecha_inicio', $mesActual)
            ->whereYear('fecha_inicio', $anioActual)
            ->sum('monto_presupuestado') ?? 0;
        $totalGastadoPresupuesto = Presupuesto::where('estado', 'activa')
            ->whereMonth('fecha_inicio', $mesActual)
            ->whereYear('fecha_inicio', $anioActual)
            ->sum('monto_gastado') ?? 0;
        $presupuesto_disponible = max(0, $totalPresupuestado - $totalGastadoPresupuesto);
        
        // Miembros activos (solo miembros con user_id válido)
        $miembros_activos = Miembro::whereNotNull('user_id')
            ->count();
        
        // Alertas de presupuesto (vacío por ahora)
        $alertas_presupuesto = [];
        
        // Gastos pendientes con información adicional
        $gastos_pendientes = Egreso::whereRaw('LOWER(estado) = ?', ['pendiente'])
            ->with('usuarioRegistro')
            ->orderBy('fecha', 'desc')
            ->get()
            ->map(function($gasto) {
                $diasPendiente = now()->diffInDays($gasto->created_at);
                $gasto->dias_pendiente = $diasPendiente;
                
                // Asignar prioridad según días pendientes
                if ($diasPendiente > 7) {
                    $gasto->prioridad = 'Urgente';
                } elseif ($diasPendiente > 3) {
                    $gasto->prioridad = 'Atención';
                } else {
                    $gasto->prioridad = 'Normal';
                }
                
                $gasto->registrado_por = $gasto->usuarioRegistro->name ?? 'N/A';
                
                return $gasto;
            });
        
        // Movimientos recientes (combinar ingresos y egresos)
        $ingresosRecientes = Ingreso::orderBy('fecha', 'desc')
            ->take(5)
            ->get()
            ->map(function($item) {
                $item->tipo = 'ingreso';
                return $item;
            });
            
        $gastosRecientes = Egreso::orderBy('fecha', 'desc')
            ->take(5)
            ->get()
            ->map(function($item) {
                $item->tipo = 'gasto';
                return $item;
            });
        
        $movimientos_recientes = $ingresosRecientes->merge($gastosRecientes)
            ->sortByDesc('fecha')
            ->take(10);
        
        // Control de presupuesto por categoría
        $control_presupuesto = Egreso::selectRaw('categoria, SUM(monto) as gasto_real')
            ->groupBy('categoria')
            ->get()
            ->map(function($item) {
                $item->presupuesto_mensual = 1000; // Estimado
                $item->presupuesto_restante = $item->presupuesto_mensual - $item->gasto_real;
                $item->porcentaje_usado = ($item->gasto_real / $item->presupuesto_mensual) * 100;
                $item->estado_presupuesto = $item->porcentaje_usado > 100 ? 'Excedido' : ($item->porcentaje_usado > 80 ? 'Alerta' : 'Normal');
                return $item;
            });
        
        // Datos para gráficas
        // 1. Gráfica de líneas - Ingresos vs Gastos por mes (últimos 12 meses)
        $meses = [];
        $ingresos_mensuales = [];
        $gastos_mensuales = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $mes = $fecha->month;
            $anio = $fecha->year;
            
            // Nombre del mes en español
            $meses[] = ucfirst($fecha->locale('es')->monthName);
            
            // Ingresos del mes
            $ingresos_mensuales[] = Ingreso::whereMonth('fecha', $mes)
                ->whereYear('fecha', $anio)
                ->sum('monto') ?? 0;
            
            // Gastos del mes
            $gastos_mensuales[] = Egreso::whereMonth('fecha', $mes)
                ->whereYear('fecha', $anio)
                ->sum('monto') ?? 0;
        }
        
        // 2. Gráfica de pastel - Top categorías de gastos
        $categorias_data = Egreso::selectRaw('categoria, SUM(monto) as total')
            ->whereYear('fecha', $anioActual)
            ->groupBy('categoria')
            ->orderByDesc('total')
            ->limit(10)
            ->get();
        
        $categorias = $categorias_data->pluck('categoria')->toArray();
        $montos_categorias = $categorias_data->pluck('total')->toArray();
        
        // Si no hay datos, mostrar mensaje
        if (empty($categorias)) {
            $categorias = ['Sin datos'];
            $montos_categorias = [0];
        }
        
        // Preparar datos para la nueva vista dashboard
        $balanceTotal = $balance_general->balance_neto;
        $totalIngresos = $balance_general->total_ingresos;
        $totalGastos = $balance_general->total_gastos;
        $gastosPendientes = $gastos_pendientes->count();
        
        // Alertas de presupuesto
        $alertasPresupuesto = [];
        foreach ($control_presupuesto as $presupuesto) {
            if ($presupuesto->estado_presupuesto === 'Excedido') {
                $alertasPresupuesto[] = "Presupuesto de {$presupuesto->categoria} excedido en " . number_format($presupuesto->porcentaje_usado - 100, 1) . "%";
            } elseif ($presupuesto->estado_presupuesto === 'Alerta') {
                $alertasPresupuesto[] = "Presupuesto de {$presupuesto->categoria} al " . number_format($presupuesto->porcentaje_usado, 1) . "% de uso";
            }
        }
        
        // Datos para la gráfica de flujo de efectivo
        $datosFlujo = [
            'meses' => $meses,
            'ingresos' => $ingresos_mensuales,
            'gastos' => $gastos_mensuales
        ];
        
        // Gastos pendientes de aprobación con formato mejorado
        $gastosPendientesAprobacion = $gastos_pendientes->map(function($gasto) {
            return (object)[
                'id' => $gasto->id,
                'descripcion' => $gasto->concepto ?? $gasto->descripcion ?? 'Sin descripción',
                'categoria' => $gasto->categoria ?? 'General',
                'fecha' => $gasto->fecha ? date('d/m/Y', strtotime($gasto->fecha)) : 'N/A',
                'monto' => $gasto->monto ?? 0,
                'dias_pendiente' => $gasto->dias_pendiente ?? 0,
                'prioridad' => $gasto->prioridad ?? 'Normal'
            ];
        });
        
        // Presupuestos activos
        $presupuestosActivos = Presupuesto::where('estado', 'activa')
            ->get()
            ->map(function($presupuesto) {
                return (object)[
                    'nombre' => $presupuesto->nombre ?? $presupuesto->categoria,
                    'monto' => $presupuesto->monto_presupuestado ?? 0,
                    'gastado' => $presupuesto->monto_gastado ?? 0
                ];
            });
        
        return view('modulos.tesorero.dashboard', compact(
            'balanceTotal',
            'totalIngresos',
            'totalGastos',
            'gastosPendientes',
            'alertasPresupuesto',
            'datosFlujo',
            'gastosPendientesAprobacion',
            'presupuestosActivos'
        ));
    }

    /**
     * Muestra el resumen general de finanzas
     */
    public function finanzas()
    {
        $this->authorize('finanzas.ver');
        // Calcular datos de ingresos y gastos
        $total_ingresos = Ingreso::sum('monto') ?? 0;
        $total_gastos = Egreso::whereRaw('LOWER(estado) = ?', ['aprobado'])->sum('monto') ?? 0;
        $balance_neto = $total_ingresos - $total_gastos;
        $cantidad_ingresos = Ingreso::count();
        $cantidad_gastos = Egreso::count();
        $total_movimientos = $cantidad_ingresos + $cantidad_gastos;
        
        // Objeto balance_general
        $balance_general = (object)[
            'balance_neto' => $balance_neto,
            'total_ingresos' => $total_ingresos,
            'total_gastos' => $total_gastos,
            'total_movimientos' => $total_movimientos,
            'cantidad_ingresos' => $cantidad_ingresos,
            'cantidad_gastos' => $cantidad_gastos,
        ];
        
        // Presupuesto disponible (estimado)
        $presupuesto_disponible = max(0, 10000 - $total_gastos);
        
        // Miembros activos
        $miembros_activos = Miembro::where('estado', 'activo')->count();
        
        // Alertas de presupuesto
        $alertas_presupuesto = [];
        
        // Gastos pendientes
        $gastos_pendientes = Egreso::whereRaw('LOWER(estado) = ?', ['pendiente'])->get();
        
        // Control de presupuesto por categoría
        $control_presupuesto = Egreso::selectRaw('categoria, SUM(monto) as gasto_real')
            ->groupBy('categoria')
            ->get()
            ->map(function($item) {
                $item->presupuesto_mensual = 1000; // Estimado
                $item->presupuesto_restante = $item->presupuesto_mensual - $item->gasto_real;
                $item->porcentaje_usado = ($item->gasto_real / $item->presupuesto_mensual) * 100;
                $item->estado_presupuesto = $item->porcentaje_usado > 100 ? 'Excedido' : ($item->porcentaje_usado > 80 ? 'Alerta' : 'Normal');
                return $item;
            });
        
        return view('modulos.tesorero.finanza', compact(
            'balance_general',
            'presupuesto_disponible',
            'miembros_activos',
            'alertas_presupuesto',
            'gastos_pendientes',
            'control_presupuesto'
        ));
    }

    /**
     * Muestra el calendario financiero
     */
    public function calendario()
    {
        // Obtener eventos del mes actual
        $mes = request('mes', now()->month);
        $anio = request('anio', now()->year);
        
        // Obtener ingresos del período
        $ingresos = Ingreso::whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->get();
        
        // Obtener egresos del período
        $egresos = Egreso::whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->get();
        
        // Construir eventos para el calendario
        $eventos = [];
        
        foreach ($ingresos as $ingreso) {
            $eventos[] = [
                'title' => 'Ingreso: ' . $ingreso->descripcion,
                'start' => $ingreso->fecha->format('Y-m-d'),
                'type' => 'ingreso',
                'monto' => $ingreso->monto,
                'color' => '#28a745'
            ];
        }
        
        foreach ($egresos as $egreso) {
            $eventos[] = [
                'title' => 'Gasto: ' . $egreso->descripcion,
                'start' => $egreso->fecha->format('Y-m-d'),
                'type' => 'egreso',
                'monto' => $egreso->monto,
                'color' => '#dc3545'
            ];
        }
        
        return view('modulos.tesorero.calendario', compact('eventos', 'mes', 'anio'));
    }
    
    // ============================================================================
    // NOTIFICACIONES
    // ============================================================================

    /**
     * Muestra el centro de notificaciones
     */
    public function notificaciones()
    {
        $notificacionService = app(NotificacionService::class);
        
        // Obtener todas las notificaciones del usuario actual con paginación
        $notificaciones = $notificacionService->obtenerTodas(auth()->id(), 15);
        
        // Contar notificaciones no leídas del total (no solo de la página actual)
        $notificacionesNoLeidas = Notificacion::delUsuario(auth()->id())
            ->where('leida', false)
            ->count();
            
        $totalNotificaciones = Notificacion::delUsuario(auth()->id())->count();
        
        return view('modulos.tesorero.notificaciones', compact('notificaciones', 'notificacionesNoLeidas', 'totalNotificaciones'));
    }

    /**
     * Marcar una notificación como leída
     */
    public function marcarNotificacionLeida($id)
    {
        $notificacionService = app(NotificacionService::class);
        $notificacionService->marcarComoLeida($id);
        
        return response()->json(['success' => true]);
    }

    /**
     * Marcar todas las notificaciones como leídas
     */
    public function marcarTodasNotificacionesLeidas()
    {
        $notificacionService = app(NotificacionService::class);
        $notificacionService->marcarTodasComoLeidas(auth()->id());
        
        return response()->json(['success' => true]);
    }

    // ============================================================================
    // CRUD PRESUPUESTOS
    // ============================================================================

    /**
     * Mostrar lista de presupuestos
     */
    public function presupuestosIndex()
    {
        $this->authorize('finanzas.ver');
        $mesActual = request('mes', now()->month);
        $anioActual = request('anio', now()->year);
        $categoriaFiltro = request('categoria', null);
        $estadoFiltro = request('estado', null);
        
        $query = Presupuesto::query();
        
        // Filtrar por mes y año actual
        $query->where('mes', $mesActual)->where('anio', $anioActual);
        
        if ($categoriaFiltro) {
            $query->where('categoria', $categoriaFiltro);
        }
        
        if ($estadoFiltro !== null) {
            $query->where('estado', $estadoFiltro == '1' ? 'activa' : 'inactiva');
        }
        
        $presupuestos = $query->orderBy('categoria', 'asc')->paginate(15);
        
        // Presupuestos con progreso (filtrados por mes y año)
        $presupuestosConProgreso = Presupuesto::where('mes', $mesActual)
            ->where('anio', $anioActual)
            ->orderBy('categoria', 'asc')
            ->get()
            ->map(function($p) {
            // Calcular porcentaje usado
            $p->porcentaje_usado = $p->monto_presupuestado > 0 ? 
                round(($p->monto_gastado / $p->monto_presupuestado) * 100, 2) : 0;
            
            // Determinar estado del badge
            $p->estado_badge = $p->porcentaje_usado >= 100 ? 'danger' : 
                ($p->porcentaje_usado >= 80 ? 'warning' : 'success');
            
            // Usar nombres consistentes para la vista
            $p->presupuesto_mensual = $p->monto_presupuestado;
            $p->gasto_real = $p->monto_gastado;
            $p->disponible = $p->monto_disponible;
            
            // Estado según porcentaje
            if ($p->porcentaje_usado >= 90) {
                $p->estado = 'danger';
            } elseif ($p->porcentaje_usado >= 75) {
                $p->estado = 'warning';
            } else {
                $p->estado = 'success';
            }
            
            // Contador de movimientos (podrías calcular desde egresos si tienes relación)
            $p->total_movimientos = 0;
            
            // Flag de activo
            $p->activo = $p->estado === 'activa';
            
            return $p;
        });
        
        // Calcular totales - usar solo registros del mes/año actual y activos
        $totalPresupuestado = Presupuesto::where('estado', 'activa')
            ->where('mes', $mesActual)
            ->where('anio', $anioActual)
            ->sum('monto_presupuestado') ?? 0;
        $totalGastado = Presupuesto::where('estado', 'activa')
            ->where('mes', $mesActual)
            ->where('anio', $anioActual)
            ->sum('monto_gastado') ?? 0;
        $totalDisponible = $totalPresupuestado - $totalGastado;
        
        // Obtener categorías para el filtro (del mes/año actual)
        $categorias = Presupuesto::where('mes', $mesActual)
            ->where('anio', $anioActual)
            ->distinct()
            ->pluck('categoria')
            ->sort();
        
        return view('modulos.tesorero.presupuestos.index', compact(
            'presupuestos',
            'presupuestosConProgreso',
            'mesActual', 
            'anioActual', 
            'categoriaFiltro',
            'estadoFiltro',
            'totalPresupuestado',
            'totalGastado',
            'totalDisponible',
            'categorias'
        ));
    }

    /**
     * Mostrar formulario para crear presupuesto
     */
    public function presupuestosCreate()
    {
        $this->authorize('finanzas.crear');
        // Obtener categorías únicas de presupuestos existentes
        $categorias = Presupuesto::select('categoria')
            ->distinct()
            ->pluck('categoria')
            ->toArray();
        
        // Agregar categorías predeterminadas comunes
        $categoriasComunes = ['Oficina', 'Eventos', 'Marketing', 'Operaciones', 'Servicios', 'Proyectos', 'Otros'];
        $categorias = array_unique(array_merge($categorias, $categoriasComunes));
        
        return view('modulos.tesorero.presupuestos.create', compact('categorias'));
    }

    /**
     * Guardar nuevo presupuesto
     */
    public function presupuestosStore(Request $request)
    {
        $this->authorize('finanzas.crear');
        $validated = $request->validate([
            'categoria' => 'required|string|max:100',
            'monto_presupuestado' => 'required|numeric|min:0',
            'mes' => 'required|integer|min:1|max:12',
            'anio' => 'required|integer|min:2020|max:2030',
            'estado' => 'required|in:activa,inactiva,pausada,archivada',
            'descripcion' => 'nullable|string',
        ]);

        // Construir fecha de periodo
        $mes = str_pad($validated['mes'], 2, '0', STR_PAD_LEFT);
        $periodo = $validated['anio'] . '-' . $mes . '-01';
        
        // Verificar si ya existe un presupuesto para esta categoría y periodo
        $existente = Presupuesto::where('categoria', $validated['categoria'])
            ->whereYear('periodo', $validated['anio'])
            ->whereMonth('periodo', $validated['mes'])
            ->first();
        
        if ($existente) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ya existe un presupuesto para la categoría "' . $validated['categoria'] . '" en ' . date('F Y', strtotime($periodo)) . '. Por favor, edita el existente o selecciona otro periodo.');
        }

        try {
            // Crear presupuesto
            $presupuesto = new Presupuesto();
            $presupuesto->usuario_id = auth()->id();
            $presupuesto->categoria = $validated['categoria'];
            $presupuesto->monto_presupuestado = $validated['monto_presupuestado'];
            $presupuesto->monto_gastado = 0;
            $presupuesto->monto_disponible = $validated['monto_presupuestado'];
            $presupuesto->periodo = $periodo;
            $presupuesto->mes = $validated['mes'];
            $presupuesto->anio = $validated['anio'];
            $presupuesto->estado = $validated['estado'];
            $presupuesto->descripcion = $validated['descripcion'] ?? null;
            
            // Valores por defecto para campos requeridos
            $presupuesto->presupuesto_mensual = $validated['monto_presupuestado'];
            $presupuesto->presupuesto_anual = $validated['monto_presupuestado'] * 12;

            $presupuesto->save();

            return redirect()->route('tesorero.presupuestos.index')
                ->with('success', 'Presupuesto creado correctamente.');
                
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ya existe un presupuesto para esta categoría en el periodo seleccionado. Intenta con otro periodo o edita el existente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el presupuesto: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalles de un presupuesto
     */
    public function presupuestosShow($id)
    {
        $this->authorize('finanzas.ver');
        $presupuesto = Presupuesto::findOrFail($id);
        
        // Obtener gastos relacionados con la categoría del presupuesto
        $gastosQuery = Egreso::where('categoria', $presupuesto->categoria);
        
        // Filtrar por rango de fechas solo si existen fecha_inicio y fecha_fin
        if ($presupuesto->fecha_inicio && $presupuesto->fecha_fin) {
            $gastosQuery->whereBetween('fecha', [$presupuesto->fecha_inicio, $presupuesto->fecha_fin]);
        }
        
        $gastos = $gastosQuery->get();
        $movimientos = $gastos; // Alias para compatibilidad con la vista
        
        return view('modulos.tesorero.presupuestos.show', compact('presupuesto', 'gastos', 'movimientos'));
    }

    /**
     * Mostrar formulario para editar presupuesto
     */
    public function presupuestosEdit($id)
    {
        $this->authorize('finanzas.editar');
        $presupuesto = Presupuesto::findOrFail($id);
        
        // Obtener categorías únicas de presupuestos existentes
        $categorias = Presupuesto::select('categoria')
            ->distinct()
            ->pluck('categoria')
            ->toArray();
        
        // Agregar categorías predeterminadas comunes
        $categoriasComunes = ['Oficina', 'Eventos', 'Marketing', 'Operaciones', 'Servicios', 'Proyectos', 'Otros'];
        $categorias = array_unique(array_merge($categorias, $categoriasComunes));
        
        return view('modulos.tesorero.presupuestos.edit', compact('presupuesto', 'categorias'));
    }

    /**
     * Actualizar presupuesto
     */
    public function presupuestosUpdate(Request $request, $id)
    {
        $this->authorize('finanzas.editar');
        $presupuesto = Presupuesto::findOrFail($id);

        $validated = $request->validate([
            'categoria' => 'required|string|max:100',
            'monto_presupuestado' => 'required|numeric|min:0',
            'periodo' => 'required|date',
            'estado' => 'required|in:activa,inactiva,pausada,archivada',
            'observaciones' => 'nullable|string',
        ]);

        // Actualizar monto disponible
        $validated['monto_disponible'] = $validated['monto_presupuestado'] - $presupuesto->monto_gastado;
        
        // Actualizar mes y año del periodo
        $periodo = \Carbon\Carbon::parse($validated['periodo']);
        $validated['mes'] = $periodo->month;
        $validated['anio'] = $periodo->year;
        
        // Actualizar presupuestos mensuales y anuales
        $validated['presupuesto_mensual'] = $validated['monto_presupuestado'];
        $validated['presupuesto_anual'] = $validated['monto_presupuestado'] * 12;

        $presupuesto->update($validated);

        return redirect()->route('tesorero.presupuestos.index')
            ->with('success', 'Presupuesto actualizado correctamente.');
    }

    /**
     * Eliminar presupuesto
     */
    public function presupuestosDestroy($id)
    {
        $this->authorize('finanzas.eliminar');
        $presupuesto = Presupuesto::findOrFail($id);
        $presupuesto->delete();

        return redirect()->route('tesorero.presupuestos.index')
            ->with('success', 'Presupuesto eliminado correctamente.');
    }

    /**
     * Ver seguimiento de presupuestos
     */
    public function presupuestosSeguimiento()
    {
        $this->authorize('finanzas.ver');
        $presupuestos = Presupuesto::with('usuario')->get();
        
        $presupuestos = $presupuestos->map(function($item) {
            $item->monto_restante = $item->monto_presupuestado - $item->monto_gastado;
            $item->porcentaje_usado = $item->monto_presupuestado > 0 
                ? round(($item->monto_gastado / $item->monto_presupuestado) * 100, 2)
                : 0;
            $item->estado_budget = $item->porcentaje_usado > 100 ? 'Excedido' : 
                                   ($item->porcentaje_usado > 80 ? 'Alerta' : 'Normal');
            return $item;
        });

        return view('modulos.tesorero.presupuestos.seguimiento', compact('presupuestos'));
    }

    /**
     * Duplicar presupuesto
     */
    public function presupuestosDuplicar(Request $request, $id)
    {
        $this->authorize('finanzas.crear');
        $presupuesto = Presupuesto::findOrFail($id);
        
        $nuevo = $presupuesto->replicate();
        $nuevo->periodo = now()->startOfMonth();
        $nuevo->monto_gastado = 0;
        $nuevo->usuario_id = auth()->id();
        $nuevo->save();

        return redirect()->route('tesorero.presupuestos.index')
            ->with('success', 'Presupuesto duplicado correctamente.');
    }

    /**
     * Exportar presupuestos a Excel
     */
    public function presupuestosExportarExcel(Request $request)
    {
        $this->authorize('finanzas.exportar');
        // Obtener mes y año actual o desde request
        $mes = $request->input('mes', now()->month);
        $anio = $request->input('anio', now()->year);
        
        // Filtrar presupuestos por mes y año si se especifican
        $query = Presupuesto::query();
        
        if ($mes && $anio) {
            $query->where('mes', $mes)->where('anio', $anio);
        }
        
        $presupuestos = $query->get();
        
        // Crear CSV simple
        $csv = "Categoría,Monto Presupuestado,Monto Gastado,Monto Disponible,Mes,Año,Estado\n";
        foreach ($presupuestos as $item) {
            $csv .= "\"{$item->categoria}\",{$item->monto_presupuestado},{$item->monto_gastado},{$item->monto_disponible},{$item->mes},{$item->anio},{$item->estado}\n";
        }

        $filename = "presupuestos_" . str_pad($mes, 2, '0', STR_PAD_LEFT) . "_" . $anio . ".csv";
        
        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Exportar presupuestos a PDF
     */
    public function presupuestosExportarPDF(Request $request)
    {
        $this->authorize('finanzas.exportar');
        // Obtener mes y año actual o desde request
        $mes = $request->input('mes', now()->month);
        $anio = $request->input('anio', now()->year);
        
        // Filtrar presupuestos por mes y año si se especifican
        $query = Presupuesto::query();
        
        if ($mes && $anio) {
            $query->where('mes', $mes)->where('anio', $anio);
        }
        
        $presupuestos = $query->get();
        
        // Calcular totales
        $totalPresupuestado = $presupuestos->sum('monto_presupuestado');
        $totalGastado = $presupuestos->sum('monto_gastado');
        $totalDisponible = $presupuestos->sum('monto_disponible');
        
        return view('modulos.tesorero.presupuestos.pdf', compact(
            'presupuestos', 
            'mes', 
            'anio',
            'totalPresupuestado',
            'totalGastado',
            'totalDisponible'
        ));
    }

    // ============================================================================
    // CRUD INGRESOS
    // ============================================================================

    public function ingresosIndex()
    {
        $this->authorize('finanzas.ver');
        $ingresos = Ingreso::orderBy('fecha', 'desc')->paginate(15);
        return view('modulos.tesorero.ingresos.index', compact('ingresos'));
    }

    public function ingresosCreate()
    {
        $this->authorize('finanzas.crear');
        $metodos_pago = [
            'efectivo' => 'Efectivo',
            'transferencia' => 'Transferencia Bancaria',
            'tarjeta_credito' => 'Tarjeta de Crédito',
            'tarjeta_debito' => 'Tarjeta de Débito',
            'cheque' => 'Cheque',
            'otro' => 'Otro'
        ];
        return view('modulos.tesorero.ingresos.create', compact('metodos_pago'));
    }

    public function ingresosStore(Request $request)
    {
        $this->authorize('finanzas.crear');
        $validated = $request->validate([
            'descripcion' => ['required', 'string', 'max:255', 'regex:/^(?!.*(.)\\1{2})/'],
            'categoria' => ['required', 'string', 'max:100', 'regex:/^(?!.*(.)\\1{2})/'],
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'fuente' => ['nullable', 'string', 'max:100', 'regex:/^(?!.*(.)\\1{2})/'],
            'metodo_pago' => 'required|in:efectivo,transferencia,tarjeta_credito,tarjeta_debito,cheque,otro',
            'comprobante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'referencia' => ['nullable', 'string', 'max:100', 'regex:/^(?!.*(.)\\1{2})/'],
            'notas' => ['nullable', 'string', 'regex:/^(?!.*(.)\\1{2})/'],
            'estado' => 'required|in:pendiente,confirmado,anulado',
        ], [
            'descripcion.regex' => 'La descripción no puede contener más de 2 caracteres repetidos consecutivos.',
            'categoria.regex' => 'La categoría no puede contener más de 2 caracteres repetidos consecutivos.',
            'fuente.regex' => 'La fuente no puede contener más de 2 caracteres repetidos consecutivos.',
            'referencia.regex' => 'La referencia no puede contener más de 2 caracteres repetidos consecutivos.',
            'notas.regex' => 'Las notas no pueden contener más de 2 caracteres repetidos consecutivos.',
        ]);

        // Manejo del archivo comprobante (si se sube)
        if ($request->hasFile('comprobante')) {
            $file = $request->file('comprobante');
            $path = $file->store('comprobantes', 'public');
            $validated['comprobante'] = $path;
        }

        $validated['usuario_registro_id'] = auth()->id();
        Ingreso::create($validated);

        return redirect()->route('tesorero.ingresos.index')->with('success', 'Ingreso creado correctamente.');
    }

    public function ingresosShow($id)
    {
        $this->authorize('finanzas.ver');
        $ingreso = Ingreso::findOrFail($id);
        return view('modulos.tesorero.ingresos.show', compact('ingreso'));
    }

    public function ingresosEdit($id)
    {
        $this->authorize('finanzas.editar');
        $ingreso = Ingreso::findOrFail($id);
        $metodos_pago = [
            'efectivo' => 'Efectivo',
            'transferencia' => 'Transferencia Bancaria',
            'tarjeta_credito' => 'Tarjeta de Crédito',
            'tarjeta_debito' => 'Tarjeta de Débito',
            'cheque' => 'Cheque',
            'otro' => 'Otro'
        ];
        return view('modulos.tesorero.ingresos.edit', compact('ingreso', 'metodos_pago'));
    }

    public function ingresosUpdate(Request $request, $id)
    {
        $this->authorize('finanzas.editar');
        $ingreso = Ingreso::findOrFail($id);
        
        $validated = $request->validate([
            'descripcion' => ['required', 'string', 'max:255', 'regex:/^(?!.*(.)\\1{2})/'],
            'categoria' => ['required', 'string', 'max:100', 'regex:/^(?!.*(.)\\1{2})/'],
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'fuente' => ['nullable', 'string', 'max:100', 'regex:/^(?!.*(.)\\1{2})/'],
            'metodo_pago' => 'required|in:efectivo,transferencia,tarjeta_credito,tarjeta_debito,cheque,otro',
            'comprobante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'referencia' => ['nullable', 'string', 'max:100', 'regex:/^(?!.*(.)\\1{2})/'],
            'notas' => ['nullable', 'string', 'regex:/^(?!.*(.)\\1{2})/'],
            'estado' => 'required|in:pendiente,confirmado,anulado',
        ], [
            'descripcion.regex' => 'La descripción no puede contener más de 2 caracteres repetidos consecutivos.',
            'categoria.regex' => 'La categoría no puede contener más de 2 caracteres repetidos consecutivos.',
            'fuente.regex' => 'La fuente no puede contener más de 2 caracteres repetidos consecutivos.',
            'referencia.regex' => 'La referencia no puede contener más de 2 caracteres repetidos consecutivos.',
            'notas.regex' => 'Las notas no pueden contener más de 2 caracteres repetidos consecutivos.',
        ]);

        
        // Si se sube un nuevo comprobante, eliminar el anterior y almacenar el nuevo
        if ($request->hasFile('comprobante')) {
            // Eliminar fichero anterior si existe
            if (!empty($ingreso->comprobante) && Storage::disk('public')->exists($ingreso->comprobante)) {
                Storage::disk('public')->delete($ingreso->comprobante);
            }

            $file = $request->file('comprobante');
            $path = $file->store('comprobantes', 'public');
            $validated['comprobante'] = $path;
        }

        $ingreso->update($validated);
        return redirect()->route('tesorero.ingresos.index')->with('success', 'Ingreso actualizado correctamente.');
    }

    public function ingresosDestroy($id)
    {
        $this->authorize('finanzas.eliminar');
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->delete();
        return redirect()->route('tesorero.ingresos.index')->with('success', 'Ingreso eliminado correctamente.');
    }

    // ============================================================================
    // CRUD GASTOS/EGRESOS
    // ============================================================================

    public function gastosIndex()
    {
        $this->authorize('finanzas.ver');
        $gastos = Egreso::orderBy('fecha', 'desc')->paginate(15);
        return view('modulos.tesorero.gastos.index', compact('gastos'));
    }

    public function gastosCreate()
    {
        $this->authorize('finanzas.crear');
        $metodos_pago = [
            'efectivo' => 'Efectivo',
            'transferencia' => 'Transferencia Bancaria',
            'tarjeta_credito' => 'Tarjeta de Crédito',
            'tarjeta_debito' => 'Tarjeta de Débito',
            'cheque' => 'Cheque',
            'otro' => 'Otro'
        ];
        
        // Generar número de factura automáticamente
        $ultimoEgreso = Egreso::latest('id')->first();
        $numero = $ultimoEgreso ? ($ultimoEgreso->id + 1) : 1;
        $numeroFactura = 'FAC-' . date('Y') . '-' . str_pad($numero, 3, '0', STR_PAD_LEFT);
        
        return view('modulos.tesorero.gastos.create', compact('metodos_pago', 'numeroFactura'));
    }

    public function gastosStore(Request $request)
    {
        $this->authorize('finanzas.crear');
        $validated = $request->validate([
            'descripcion' => ['required', 'string', 'max:255', 'regex:/^(?!.*(.)\\1{2})/'],
            'categoria' => ['required', 'string', 'max:100', 'regex:/^(?!.*(.)\\1{2})/'],
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'proveedor' => ['nullable', 'string', 'max:100', 'regex:/^(?!.*(.)\\1{2})/'],
            'metodo_pago' => 'required|in:efectivo,transferencia,tarjeta_credito,tarjeta_debito,cheque,otro',
            'comprobante_archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'referencia' => ['nullable', 'string', 'max:100', 'regex:/^(?!.*(.)\\1{2})/'],
            'notas' => ['nullable', 'string', 'regex:/^(?!.*(.)\\1{2})/'],
            'estado' => 'required|in:pendiente,aprobado,rechazado,anulado,pagado',
            'numero_factura' => ['nullable', 'string', 'max:100'],
        ], [
            'descripcion.regex' => 'La descripción no puede contener más de 2 caracteres repetidos consecutivos.',
            'categoria.regex' => 'La categoría no puede contener más de 2 caracteres repetidos consecutivos.',
            'proveedor.regex' => 'El proveedor no puede contener más de 2 caracteres repetidos consecutivos.',
            'referencia.regex' => 'La referencia no puede contener más de 2 caracteres repetidos consecutivos.',
            'notas.regex' => 'Las notas no pueden contener más de 2 caracteres repetidos consecutivos.',
        ]);

        // Manejo del archivo comprobante si se sube
        if ($request->hasFile('comprobante_archivo')) {
            $file = $request->file('comprobante_archivo');
            $path = $file->store('comprobantes', 'public');
            $validated['comprobante_archivo'] = $path;
        }

        // Generar número de factura automáticamente si no se proporcionó
        if (empty($request->numero_factura)) {
            $ultimoEgreso = Egreso::latest('id')->first();
            $numero = $ultimoEgreso ? ($ultimoEgreso->id + 1) : 1;
            $validated['numero_factura'] = 'FAC-' . date('Y') . '-' . str_pad($numero, 3, '0', STR_PAD_LEFT);
        }

        $validated['usuario_registro_id'] = auth()->id();
        Egreso::create($validated);

        return redirect()->route('tesorero.gastos.index')->with('success', 'Gasto creado correctamente.');
    }

    public function gastosShow($id)
    {
        $this->authorize('finanzas.ver');
        $gasto = Egreso::findOrFail($id);
        return view('modulos.tesorero.gastos.show', compact('gasto'));
    }

    public function gastosEdit($id)
    {
        $this->authorize('finanzas.editar');
        $gasto = Egreso::findOrFail($id);
        $metodos_pago = [
            'efectivo' => 'Efectivo',
            'transferencia' => 'Transferencia Bancaria',
            'tarjeta_credito' => 'Tarjeta de Crédito',
            'tarjeta_debito' => 'Tarjeta de Débito',
            'cheque' => 'Cheque',
            'otro' => 'Otro'
        ];
        return view('modulos.tesorero.gastos.edit', compact('gasto', 'metodos_pago'));
    }

    public function gastosUpdate(Request $request, $id)
    {
        $this->authorize('finanzas.editar');
        $gasto = Egreso::findOrFail($id);
        
        $validated = $request->validate([
            'descripcion' => ['required', 'string', 'max:255', 'regex:/^(?!.*(.)\\1{2})/'],
            'categoria' => ['required', 'string', 'max:100', 'regex:/^(?!.*(.)\\1{2})/'],
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'proveedor' => ['nullable', 'string', 'max:100', 'regex:/^(?!.*(.)\\1{2})/'],
            'metodo_pago' => 'required|in:efectivo,transferencia,tarjeta_credito,tarjeta_debito,cheque,otro',
            'comprobante_archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'referencia' => ['nullable', 'string', 'max:100', 'regex:/^(?!.*(.)\\1{2})/'],
            'notas' => ['nullable', 'string', 'regex:/^(?!.*(.)\\1{2})/'],
            'estado' => 'required|in:pendiente,aprobado,rechazado,anulado,pagado',
            'numero_factura' => ['nullable', 'string', 'max:100'],
        ], [
            'descripcion.regex' => 'La descripción no puede contener más de 2 caracteres repetidos consecutivos.',
            'categoria.regex' => 'La categoría no puede contener más de 2 caracteres repetidos consecutivos.',
            'proveedor.regex' => 'El proveedor no puede contener más de 2 caracteres repetidos consecutivos.',
            'referencia.regex' => 'La referencia no puede contener más de 2 caracteres repetidos consecutivos.',
            'notas.regex' => 'Las notas no pueden contener más de 2 caracteres repetidos consecutivos.',
        ]);

        // Si se sube un nuevo comprobante, eliminar el anterior y almacenar el nuevo
        if ($request->hasFile('comprobante_archivo')) {
            if (!empty($gasto->comprobante_archivo) && Storage::disk('public')->exists($gasto->comprobante_archivo)) {
                Storage::disk('public')->delete($gasto->comprobante_archivo);
            }

            $file = $request->file('comprobante_archivo');
            $path = $file->store('comprobantes', 'public');
            $validated['comprobante_archivo'] = $path;
        }

        $gasto->update($validated);
        return redirect()->route('tesorero.gastos.index')->with('success', 'Gasto actualizado correctamente.');
    }

    public function gastosDestroy($id)
    {
        $this->authorize('finanzas.eliminar');
        $gasto = Egreso::findOrFail($id);
        $gasto->delete();
        return redirect()->route('tesorero.gastos.index')->with('success', 'Gasto eliminado correctamente.');
    }

    /**
     * Aprobar un gasto pendiente
     */
    public function aprobarGasto($id)
    {
        $this->authorize('finanzas.aprobar');
        try {
            $gasto = Egreso::findOrFail($id);
            
            if (strtolower($gasto->estado) !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Este gasto ya fue procesado anteriormente.'
                ], 400);
            }
            
            $gasto->estado = 'aprobado';
            $gasto->usuario_aprobacion_id = auth()->id();
            $gasto->save();
            
            // Actualizar presupuesto de la categoría si existe
            try {
                $this->actualizarPresupuestoCategoria($gasto->categoria, $gasto->monto);
            } catch (\Exception $budgetEx) {
                // Log silencioso si falla actualización de presupuesto
                \Log::warning('Error actualizando presupuesto: ' . $budgetEx->getMessage());
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Gasto aprobado correctamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al aprobar el gasto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Rechazar un gasto pendiente
     */
    public function rechazarGasto(Request $request, $id)
    {
        $this->authorize('finanzas.aprobar');
        try {
            $gasto = Egreso::findOrFail($id);
            
            if (strtolower($gasto->estado) !== 'pendiente') {
                return response()->json([
                    'success' => false,
                    'message' => 'Este gasto ya fue procesado anteriormente.'
                ], 400);
            }
            
            $motivo = $request->input('motivo', 'Sin motivo especificado');
            
            $gasto->estado = 'rechazado';
            $gasto->usuario_aprobacion_id = auth()->id();
            $gasto->notas = ($gasto->notas ? $gasto->notas . "\n\n" : '') . "RECHAZADO: " . $motivo;
            $gasto->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Gasto rechazado correctamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al rechazar el gasto: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ver detalles de un gasto
     */
    public function verDetallesGasto($id)
    {
        $this->authorize('finanzas.ver');
        try {
            $gasto = Egreso::with(['usuarioRegistro', 'usuarioAprobacion'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'gasto' => $gasto
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los detalles del gasto.'
            ], 500);
        }
    }

    /**
     * Actualizar presupuesto de categoría
     */
    private function actualizarPresupuestoCategoria($categoria, $monto)
    {
        $mesActual = now()->month;
        $anioActual = now()->year;
        
        $presupuesto = Presupuesto::where('categoria', $categoria)
            ->whereMonth('periodo', $mesActual)
            ->whereYear('periodo', $anioActual)
            ->first();
        
        if ($presupuesto) {
            $presupuesto->monto_gastado += $monto;
            $presupuesto->monto_disponible = $presupuesto->monto_presupuestado - $presupuesto->monto_gastado;
            $presupuesto->save();
        }
    }

    // ============================================================================
    // CRUD TRANSFERENCIAS
    // ============================================================================

    public function transferenciasIndex()
    {
        $this->authorize('finanzas.ver');
        $query = Egreso::where('tipo', 'transferencia')->orderBy('fecha', 'desc');

        // Filtros de búsqueda simples
        if ($buscar = request('buscar')) {
            $query->where(function($q) use ($buscar) {
                $q->where('descripcion', 'like', "%{$buscar}%")
                  ->orWhere('cuenta_origen', 'like', "%{$buscar}%")
                  ->orWhere('cuenta_destino', 'like', "%{$buscar}%")
                  ->orWhere('referencia', 'like', "%{$buscar}%")
                  ->orWhere('numero_referencia', 'like', "%{$buscar}%");
            });
        }

        if ($fechaDesde = request('fecha_desde')) {
            $query->whereDate('fecha', '>=', $fechaDesde);
        }
        if ($fechaHasta = request('fecha_hasta')) {
            $query->whereDate('fecha', '<=', $fechaHasta);
        }

        $transferencias = $query->paginate(15)->withQueryString();

        // Totales y métricas
        $transferenciasDelMes = Egreso::where('tipo', 'transferencia')
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->count();

        // Calcular monto total y total comisiones (usar columnas reales cuando existan)
        $totalMonto = Egreso::whereRaw('LOWER(estado) = ?', ['aprobado'])
            ->where('tipo', 'transferencia')
            ->sum('monto');

        $allTransferencias = Egreso::whereRaw('LOWER(estado) = ?', ['aprobado'])
            ->where('tipo', 'transferencia')
            ->get();
        $totalComisiones = $allTransferencias->sum(function($t) {
            return floatval($t->comision ?? $t->comision_bancaria ?? 0);
        });
        return view('modulos.tesorero.transferencias.index', compact('transferencias', 'transferenciasDelMes', 'totalComisiones', 'totalMonto'));
    }

   public function transferenciasCreate()
    {
        $this->authorize('finanzas.crear');
        // Tipos de transferencia (puede ajustarse según reglas del negocio)
        $tipos_transferencia = [
            'interna' => 'Interna (entre cuentas propias)',
            'interbancaria' => 'Interbancaria',
            'externa' => 'Externa (a terceros)'
        ];

        // Cuentas disponibles (ejemplo estático; reemplazar por consulta a tabla de cuentas si existe)
        $cuentas = [
            'Caja General',
            'Cuenta Bancaria Principal - Banco X',
            'Cuenta Bancaria Secundaria - Banco Y',
            'Fondo de Reserva'
        ];

        return view('modulos.tesorero.transferencias.create', compact('tipos_transferencia', 'cuentas'));
    }

    public function transferenciasStore(Request $request)
    {
        $this->authorize('finanzas.crear');
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'cuenta_origen' => 'required|string',
            'cuenta_destino' => 'required|string',
            'referencia' => 'nullable|string|max:100',
            'numero_referencia' => 'nullable|string|max:100',
            'comision' => 'nullable|numeric|min:0',
            'notas' => 'nullable|string',
            'metodo_pago' => 'nullable|in:efectivo,transferencia,tarjeta_credito,tarjeta_debito,cheque,otro',
            'comprobante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $validated['usuario_registro_id'] = auth()->id();
        $validated['tipo'] = 'transferencia';
        // if metodo_pago provided use it, otherwise default to 'transferencia'
        $validated['metodo_pago'] = $request->input('metodo_pago', 'transferencia');
        $validated['categoria'] = 'Transferencia';
        $validated['estado'] = 'pagado';

        // Mapear numero_referencia (campo del formulario) a la columna 'referencia' usada en el modelo
        if ($request->filled('numero_referencia') && empty($validated['referencia'])) {
            $validated['referencia'] = $request->input('numero_referencia');
        }

        // Asegurar que la comisión se guarde si fue enviada
        if ($request->filled('comision')) {
            $validated['comision'] = $request->input('comision');
        }

        // Manejo del comprobante (archivo)
        if ($request->hasFile('comprobante')) {
            $file = $request->file('comprobante');
            $path = $file->store('comprobantes', 'public');
            $validated['comprobante'] = $path;
        }

        Egreso::create($validated);

        return redirect()->route('tesorero.transferencias.index')->with('success', 'Transferencia creada correctamente.');
    }

    public function transferenciasShow($id)
    {
        $this->authorize('finanzas.ver');
        $transferencia = Egreso::findOrFail($id);
        return view('modulos.tesorero.transferencias.show', compact('transferencia'));
    }

    public function transferenciasEdit($id)
    {
        $this->authorize('finanzas.editar');
        $transferencia = Egreso::findOrFail($id);
        // Tipos de transferencia y cuentas (coincidentes con create)
        $tipos_transferencia = [
            'interna' => 'Interna (entre cuentas propias)',
            'interbancaria' => 'Interbancaria',
            'externa' => 'Externa (a terceros)'
        ];

        $cuentas = [
            'Caja General',
            'Cuenta Bancaria Principal - Banco X',
            'Cuenta Bancaria Secundaria - Banco Y',
            'Fondo de Reserva'
        ];

        return view('modulos.tesorero.transferencias.edit', compact('transferencia', 'tipos_transferencia', 'cuentas'));
    }

    public function transferenciasUpdate(Request $request, $id)
    {
        $this->authorize('finanzas.editar');
        $transferencia = Egreso::findOrFail($id);
        
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0',
            'fecha' => 'required|date',
            'cuenta_origen' => 'required|string',
            'cuenta_destino' => 'required|string',
            'referencia' => 'nullable|string|max:100',
            'numero_referencia' => 'nullable|string|max:100',
            'comision' => 'nullable|numeric|min:0',
            'notas' => 'nullable|string',
            'metodo_pago' => 'nullable|in:efectivo,transferencia,tarjeta_credito,tarjeta_debito,cheque,otro',
            'comprobante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Si se sube un nuevo comprobante, eliminar anterior y guardar nuevo
        if ($request->hasFile('comprobante')) {
            if (!empty($transferencia->comprobante) && Storage::disk('public')->exists($transferencia->comprobante)) {
                Storage::disk('public')->delete($transferencia->comprobante);
            }
            $file = $request->file('comprobante');
            $path = $file->store('comprobantes', 'public');
            $validated['comprobante'] = $path;
        }

        // If metodo_pago not present, preserve existing
        if (!$request->has('metodo_pago')) {
            $validated['metodo_pago'] = $transferencia->metodo_pago ?? 'transferencia';
        }

        // Mapear numero_referencia a 'referencia' si aplica
        if ($request->filled('numero_referencia') && empty($validated['referencia'])) {
            $validated['referencia'] = $request->input('numero_referencia');
        }

        // Guardar comisión si fue enviada
        if ($request->filled('comision')) {
            $validated['comision'] = $request->input('comision');
        }

        $transferencia->update($validated);

        // Si la petición es AJAX (fetch desde la vista), devolver JSON para que el frontend lo procese
        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Transferencia actualizada correctamente.'
            ]);
        }

        return redirect()->route('tesorero.transferencias.index')->with('success', 'Transferencia actualizada correctamente.');
    }

    public function transferenciasDestroy($id)
    {
        $this->authorize('finanzas.eliminar');
        $transferencia = Egreso::findOrFail($id);
        $transferencia->delete();
        return redirect()->route('tesorero.transferencias.index')->with('success', 'Transferencia eliminada correctamente.');
    }

    // ============================================================================
    // CRUD MEMBRESÍAS
    // ============================================================================

    public function membresiasIndex()
    {
        $this->authorize('finanzas.ver');
        $query = PagoMembresia::with('usuario')->orderBy('fecha_pago', 'desc');

        // Búsqueda simple por nombre o correo en la tabla users (relación 'usuario')
        if ($buscar = request('buscar')) {
            $query->where(function($q) use ($buscar) {
                // Buscar en la relación usuario (name, email)
                $q->whereHas('usuario', function($u) use ($buscar) {
                    $u->where('name', 'like', "%{$buscar}%")
                      ->orWhere('email', 'like', "%{$buscar}%");
                });

                // También permitir búsqueda por número de comprobante en la propia tabla
                $q->orWhere('numero_comprobante', 'like', "%{$buscar}%");
            });
        }

        if ($estado = request('estado')) {
            $query->where('estado', $estado);
        }

        if ($tipo = request('tipo')) {
            $query->where('tipo_pago', $tipo)->orWhere('tipo_membresia', $tipo);
        }

        $membresias = $query->paginate(15);
        
        // Agregar nombre_miembro y email a cada membresía para la vista
        $membresias->getCollection()->transform(function($membresia) {
            $membresia->nombre_miembro = $membresia->usuario->name ?? 'Sin usuario';
            $membresia->email = $membresia->usuario->email ?? 'N/A';
            return $membresia;
        });

        // Totales para los widgets
        // Considerar como "pagadas" solo el estado explícito 'pagado'
        $estadosPagados = ['pagado'];
        $totalPagadas = PagoMembresia::whereIn('estado', $estadosPagados)->count();
        $totalPendientes = PagoMembresia::where('estado', 'pendiente')->count();
        $totalRecaudado = PagoMembresia::whereIn('estado', $estadosPagados)->sum('monto');

        return view('modulos.tesorero.membresias.index', compact('membresias', 'totalPagadas', 'totalPendientes', 'totalRecaudado'));
    }

    /**
     * Sugerencias para autocompletar búsqueda de membresías por nombre o correo (AJAX)
     */
    public function membresiasSuggestions(Request $request)
    {
        $q = $request->get('q', '');

        if (trim($q) === '') {
            return response()->json(['success' => true, 'suggestions' => []]);
        }

        $items = PagoMembresia::with('usuario')
            ->where(function($query) use ($q) {
                // Buscar en la relación usuario (name, email)
                $query->whereHas('usuario', function($u) use ($q) {
                    $u->where('name', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%");
                });

                // También por número de comprobante
                $query->orWhere('numero_comprobante', 'like', "%{$q}%");
            })
            ->orderBy('fecha_pago', 'desc')
            ->limit(10)
            ->get();

        $suggestions = $items->map(function($m) {
            $usuario = $m->usuario;
            $name = $usuario->name ?? $m->nombre_miembro ?? null;
            $email = $usuario->email ?? $m->email ?? null;
            if ($name && $email) {
                return trim("{$name} <{$email}>");
            }
            return $name ?? $email ?? null;
        })->filter()->unique()->values()->all();

        return response()->json(['success' => true, 'suggestions' => $suggestions]);
    }

    public function membresiasCreate()
    {
        $this->authorize('finanzas.crear');
        // Solo mostrar miembros con user_id válido
        $miembros = Miembro::whereNotNull('user_id')->with('user')->get();
        $tipos_membresia = [
            'activo' => 'Activo',
            'honorario' => 'Honorario',
            'aspirante' => 'Aspirante',
            'alumni' => 'Alumni'
        ];
        $estados = [
            'pendiente' => 'Pendiente',
            'pagado' => 'Pagado',
            'cancelado' => 'Cancelado'
        ];
        $metodos_pago = [
            'efectivo' => 'Efectivo',
            'transferencia' => 'Transferencia Bancaria',
            'tarjeta_credito' => 'Tarjeta de Crédito',
            'tarjeta_debito' => 'Tarjeta de Débito',
            'cheque' => 'Cheque',
            'otro' => 'Otro'
        ];
        return view('modulos.tesorero.membresias.create', compact('miembros', 'tipos_membresia', 'estados', 'metodos_pago'));
    }

    public function membresiasStore(Request $request)
    {
        $this->authorize('finanzas.crear');
        $validated = $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'tipo_membresia' => 'required|in:activo,honorario,aspirante,alumni',
            'tipo_pago' => 'required|in:mensual,trimestral,semestral,anual',
            'monto' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
            'metodo_pago' => 'required|in:efectivo,transferencia,tarjeta_credito,tarjeta_debito,cheque,otro',
            'periodo_inicio' => 'required|date',
            'periodo_fin' => 'required|date|after:periodo_inicio',
            'comprobante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'numero_recibo' => ['nullable', 'string', 'max:100', 'regex:/^(?!.*(.)\\1{2})/'],
            'notas' => ['nullable', 'string', 'regex:/^(?!.*(.)\\1{2})/'],
            'estado' => 'required|in:pendiente,pagado,cancelado',
        ], [
            'numero_recibo.regex' => 'El número de recibo no puede contener más de 2 caracteres repetidos consecutivos.',
            'notas.regex' => 'Las notas no pueden contener más de 2 caracteres repetidos consecutivos.',
        ]);

        // Manejo de comprobante (archivo)
        if ($request->hasFile('comprobante')) {
            $file = $request->file('comprobante');
            $path = $file->store('comprobantes', 'public');
            $validated['comprobante'] = $path;
        }

        // Normalizar número de recibo: formulario puede enviar 'numero_recibo' pero el modelo usa 'numero_comprobante'
        if ($request->filled('numero_recibo') && empty($validated['numero_comprobante'])) {
            $validated['numero_comprobante'] = $request->input('numero_recibo');
        }

        PagoMembresia::create($validated);

        return redirect()->route('tesorero.membresias.index')->with('success', 'Membresía registrada correctamente.');
    }

    public function membresiasShow($id)
    {
        $this->authorize('finanzas.ver');
        $membresia = PagoMembresia::with('usuario')->findOrFail($id);
        
        // Agregar nombre_miembro y email para la vista
        $membresia->nombre_miembro = $membresia->usuario->name ?? 'Sin usuario';
        $membresia->email = $membresia->usuario->email ?? 'N/A';
        
        return view('modulos.tesorero.membresias.show', compact('membresia'));
    }

    public function membresiasEdit($id)
    {
        $this->authorize('finanzas.editar');
        $membresia = PagoMembresia::findOrFail($id);
        // Solo mostrar miembros con user_id válido
        $miembros = Miembro::whereNotNull('user_id')->with('user')->get();
        $tipos_membresia = [
            'activo' => 'Activo',
            'honorario' => 'Honorario',
            'aspirante' => 'Aspirante',
            'alumni' => 'Alumni'
        ];
        $estados = [
            'pendiente' => 'Pendiente',
            'pagado' => 'Pagado',
            'cancelado' => 'Cancelado'
        ];
        $metodos_pago = [
            'efectivo' => 'Efectivo',
            'transferencia' => 'Transferencia Bancaria',
            'tarjeta_credito' => 'Tarjeta de Crédito',
            'tarjeta_debito' => 'Tarjeta de Débito',
            'cheque' => 'Cheque',
            'otro' => 'Otro'
        ];
        return view('modulos.tesorero.membresias.edit', compact('membresia', 'miembros', 'tipos_membresia', 'estados', 'metodos_pago'));
    }

    public function membresiasUpdate(Request $request, $id)
    {
        $this->authorize('finanzas.editar');
        $membresia = PagoMembresia::findOrFail($id);
        
        $validated = $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'tipo_membresia' => 'required|in:activo,honorario,aspirante,alumni',
            'tipo_pago' => 'required|in:mensual,trimestral,semestral,anual',
            'monto' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
            'metodo_pago' => 'required|in:efectivo,transferencia,tarjeta_credito,tarjeta_debito,cheque,otro',
            'periodo_inicio' => 'required|date',
            'periodo_fin' => 'required|date|after:periodo_inicio',
            'comprobante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'numero_recibo' => ['nullable', 'string', 'max:100', 'regex:/^(?!.*(.)\\1{2})/'],
            'notas' => ['nullable', 'string', 'regex:/^(?!.*(.)\\1{2})/'],
            'estado' => 'required|in:pendiente,pagado,cancelado',
        ], [
            'numero_recibo.regex' => 'El número de recibo no puede contener más de 2 caracteres repetidos consecutivos.',
            'notas.regex' => 'Las notas no pueden contener más de 2 caracteres repetidos consecutivos.',
        ]);

        // Si se sube nuevo comprobante, eliminar anterior y guardar el nuevo
        if ($request->hasFile('comprobante')) {
            if (!empty($membresia->comprobante) && Storage::disk('public')->exists($membresia->comprobante)) {
                Storage::disk('public')->delete($membresia->comprobante);
            }
            $file = $request->file('comprobante');
            $path = $file->store('comprobantes', 'public');
            $validated['comprobante'] = $path;
        }

        // Mapear numero_recibo del formulario a numero_comprobante en la base
        if ($request->filled('numero_recibo') && empty($validated['numero_comprobante'])) {
            $validated['numero_comprobante'] = $request->input('numero_recibo');
        }

        $membresia->update($validated);

        return redirect()->route('tesorero.membresias.index')->with('success', 'Membresía actualizada correctamente.');
    }

    public function membresiasDestroy($id)
    {
        $this->authorize('finanzas.eliminar');
        $membresia = PagoMembresia::findOrFail($id);
        $membresia->delete();
        return redirect()->route('tesorero.membresias.index')->with('success', 'Membresía eliminada correctamente.');
    }

    public function misMembresías()
    {
        $usuario_id = auth()->id();
        $membresias = PagoMembresia::where('usuario_id', $usuario_id)->get();
        return view('modulos.tesorero.membresias.mis', compact('membresias'));
    }

    public function solicitarRenovacion(Request $request)
    {
        $membresia = PagoMembresia::findOrFail($request->membresia_id);
        $membresia->update(['estado' => 'completada']);
        return response()->json(['success' => true, 'message' => 'Renovación solicitada correctamente.']);
    }

    public function guardarRecordatorio(Request $request)
    {
        // Guardar recordatorio de membresía
        return response()->json(['success' => true]);
    }

    public function eliminarPagoHistorial(Request $request)
    {
        $membresia = PagoMembresia::findOrFail($request->membresia_id);
        $membresia->delete();
        return response()->json(['success' => true, 'message' => 'Pago eliminado del historial.']);
    }

    public function limpiarHistorial(Request $request)
    {
        $usuario_id = auth()->id();
        PagoMembresia::where('usuario_id', $usuario_id)->whereIn('estado', ['cancelada', 'vencida'])->delete();
        return response()->json(['success' => true, 'message' => 'Historial limpiado.']);
    }

    // ============================================================================
    // MOVIMIENTOS Y TRANSACCIONES
    // ============================================================================

    /**
     * Muestra todos los movimientos (ingresos y gastos)
     */
    public function movimientos()
    {
        $ingresos = Ingreso::orderBy('fecha', 'desc')->get();
        $gastos = Egreso::orderBy('fecha', 'desc')->get();
        
        // Combinar movimientos
        $movimientos = collect();
        
        foreach ($ingresos as $ingreso) {
            $movimientos->push([
                'id' => $ingreso->id,
                'tipo' => 'ingreso',
                'descripcion' => $ingreso->descripcion,
                'monto' => $ingreso->monto,
                'fecha' => $ingreso->fecha,
                'categoria' => $ingreso->categoria ?? 'General',
                'estado' => $ingreso->estado,
                'color' => 'success'
            ]);
        }
        
        foreach ($gastos as $gasto) {
            $movimientos->push([
                'id' => $gasto->id,
                'tipo' => 'egreso',
                'descripcion' => $gasto->descripcion,
                'monto' => $gasto->monto,
                'fecha' => $gasto->fecha,
                'categoria' => $gasto->categoria ?? 'General',
                'estado' => $gasto->estado,
                'color' => 'danger'
            ]);
        }
        
        // Ordenar por fecha descendente y paginar
        $movimientos = $movimientos->sortByDesc('fecha')->values();
        $perPage = 20;
        $page = request()->get('page', 1);
        $movimientos = new \Illuminate\Pagination\Paginator(
            $movimientos->forPage($page, $perPage),
            $perPage,
            $page,
            [
                'path' => route('tesorero.movimientos.index'),
                'query' => request()->query(),
            ]
        );
        
        return view('modulos.tesorero.movimientos.index', compact('movimientos'));
    }

    /**
     * Ver detalle de un movimiento
     */
    public function verDetalle($id)
    {
        // Intentar buscar como ingreso
        $ingreso = Ingreso::find($id);
        if ($ingreso) {
            return view('modulos.tesorero.movimientos.detalle', [
                'tipo' => 'ingreso',
                'movimiento' => $ingreso
            ]);
        }
        
        // Intentar buscar como egreso
        $egreso = Egreso::find($id);
        if ($egreso) {
            return view('modulos.tesorero.movimientos.detalle', [
                'tipo' => 'egreso',
                'movimiento' => $egreso
            ]);
        }
        
        return abort(404, 'Movimiento no encontrado');
    }

    // ============================================================================
    // REPORTES Y ESTADÍSTICAS
    // ============================================================================

    /**
     * Muestra la página de reportes
     */
    public function reportes()
    {
        $this->authorize('finanzas.ver');
        // Datos generales
        $totalIngresos = Ingreso::sum('monto') ?? 0;
        $totalGastos = Egreso::whereRaw('LOWER(estado) = ?', ['aprobado'])->sum('monto') ?? 0;
        $balance = $totalIngresos - $totalGastos;
        
        // Datos del mes actual
        $mesActual = now()->month;
        $anioActual = now()->year;
        
        $ingresosDelMes = Ingreso::whereMonth('fecha', $mesActual)
            ->whereYear('fecha', $anioActual)
            ->sum('monto') ?? 0;
            
        $gastosDelMes = Egreso::whereRaw('LOWER(estado) = ?', ['aprobado'])
            ->whereMonth('fecha', $mesActual)
            ->whereYear('fecha', $anioActual)
            ->sum('monto') ?? 0;
        
        return view('modulos.tesorero.reportes.index', compact(
            'totalIngresos',
            'totalGastos',
            'balance',
            'ingresosDelMes',
            'gastosDelMes',
            'mesActual',
            'anioActual'
        ));
    }

    /**
     * Genera un reporte personalizado
     */
    public function generarReporte(Request $request)
    {
        $this->authorize('finanzas.exportar');
        $tipo = $request->tipo ?? 'general';
        $fechaInicio = $request->fecha_inicio ? \Carbon\Carbon::parse($request->fecha_inicio) : now()->startOfMonth();
        $fechaFin = $request->fecha_fin ? \Carbon\Carbon::parse($request->fecha_fin) : now();
        
        $ingresos = Ingreso::whereBetween('fecha', [$fechaInicio, $fechaFin])->get();
        $gastos = Egreso::whereRaw('LOWER(estado) = ?', ['aprobado'])
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->get();
        
        $totalIngresos = $ingresos->sum('monto');
        $totalGastos = $gastos->sum('monto');
        $balance = $totalIngresos - $totalGastos;
        
        return view('modulos.tesorero.reportes.resultado', compact(
            'tipo',
            'fechaInicio',
            'fechaFin',
            'ingresos',
            'gastos',
            'totalIngresos',
            'totalGastos',
            'balance'
        ));
    }

    /**
     * Reporte mensual
     */
    public function reporteMensual(Request $request)
    {
        $this->authorize('finanzas.exportar');
        $mes = $request->mes ?? now()->month;
        $anio = $request->anio ?? now()->year;
        
        $ingresos = Ingreso::whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->get();
            
        $gastos = Egreso::whereRaw('LOWER(estado) = ?', ['aprobado'])
            ->whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->get();
        
        $totalIngresos = $ingresos->sum('monto');
        $totalGastos = $gastos->sum('monto');
        $balance = $totalIngresos - $totalGastos;
        
        return view('modulos.tesorero.reportes.mensual', compact(
            'mes',
            'anio',
            'ingresos',
            'gastos',
            'totalIngresos',
            'totalGastos',
            'balance'
        ));
    }

    /**
     * Reporte anual
     */
    public function reporteAnual(Request $request)
    {
        $this->authorize('finanzas.exportar');
        $anio = $request->anio ?? now()->year;
        
        $ingresos = Ingreso::whereYear('fecha', $anio)->get();
        $gastos = Egreso::whereRaw('LOWER(estado) = ?', ['aprobado'])
            ->whereYear('fecha', $anio)
            ->get();
        
        $totalIngresos = $ingresos->sum('monto');
        $totalGastos = $gastos->sum('monto');
        $balance = $totalIngresos - $totalGastos;
        
        // Agrupar por mes
        $ingresosPorMes = Ingreso::whereYear('fecha', $anio)
            ->selectRaw('MONTH(fecha) as mes, SUM(monto) as total')
            ->groupBy('mes')
            ->pluck('total', 'mes')
            ->toArray();
            
        $gastosPorMes = Egreso::whereRaw('LOWER(estado) = ?', ['aprobado'])
            ->whereYear('fecha', $anio)
            ->selectRaw('MONTH(fecha) as mes, SUM(monto) as total')
            ->groupBy('mes')
            ->pluck('total', 'mes')
            ->toArray();
        
        return view('modulos.tesorero.reportes.anual', compact(
            'anio',
            'ingresos',
            'gastos',
            'totalIngresos',
            'totalGastos',
            'balance',
            'ingresosPorMes',
            'gastosPorMes'
        ));
    }
    
    // ============================================================================
    // APIs PARA FUNCIONALIDADES DEL DASHBOARD
    // ============================================================================
    
    /**
     * Obtener mis notificaciones (API)
     */
    public function obtenerMisNotificaciones()
    {
        try {
            $notificacionService = app(NotificacionService::class);
            $notificaciones = $notificacionService->obtenerTodasColeccion(auth()->id(), 50);
            
            return response()->json([
                'success' => true,
                'notificaciones' => $notificaciones->map(function($notif) {
                    return [
                        'id' => $notif->id,
                        'titulo' => $notif->titulo,
                        'mensaje' => $notif->mensaje,
                        'leida' => $notif->leida,
                        'created_at' => $notif->created_at->toISOString(),
                        'icono' => $notif->icono ?? 'fa-bell',
                        'color' => $notif->color ?? 'primary',
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar notificaciones: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener mis membresías (API)
     */
    public function obtenerMisMembresías()
    {
        try {
            $usuarioId = auth()->id();
            
            // Obtener membresías del usuario
            $membresias = PagoMembresia::where('usuario_id', $usuarioId)
                ->orderBy('fecha_pago', 'desc')
                ->get();
            
            $activas = [];
            $proximas = [];
            $historial = [];
            
            foreach ($membresias as $membresia) {
                $fechaVencimiento = \Carbon\Carbon::parse($membresia->fecha_vencimiento ?? now()->addMonth());
                $diasRestantes = now()->diffInDays($fechaVencimiento, false);
                
                $data = [
                    'id' => $membresia->id,
                    'tipo' => $membresia->tipo_membresia ?? 'Membresía Mensual',
                    'monto' => $membresia->monto,
                    'fechaInicio' => $membresia->fecha_pago,
                    'fechaVencimiento' => $fechaVencimiento->toISOString(),
                    'diasRestantes' => $diasRestantes,
                    'estado' => $membresia->estado ?? 'activa',
                    'comprobante' => $membresia->numero_comprobante ?? 'N/A',
                    'metodo' => $membresia->metodo_pago ?? 'Transferencia',
                    'fecha' => $membresia->fecha_pago,
                ];
                
                if ($diasRestantes > 15) {
                    $activas[] = $data;
                } elseif ($diasRestantes > 0) {
                    $proximas[] = $data;
                } else {
                    $historial[] = $data;
                }
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'activas' => $activas,
                    'proximas' => $proximas,
                    'historial' => $historial,
                    'resumen' => [
                        'totalPagado' => $membresias->sum('monto'),
                        'pagosRealizados' => $membresias->count(),
                        'pagosProcessados' => $membresias->count(),
                        'montoGestionado' => $membresias->sum('monto'),
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar membresías: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Procesar renovación de membresía (API)
     */
    public function procesarRenovacion(Request $request)
    {
        try {
            $validated = $request->validate([
                'membresia_id' => 'required|exists:pagos_membresia,id',
                'monto' => 'required|numeric|min:0',
                'metodo_pago' => 'required|string',
                'banco_origen' => 'nullable|string',
                'numero_referencia' => 'nullable|string',
                'fecha_pago' => 'required|date',
                'numero_comprobante' => 'nullable|string',
            ]);
            
            // Crear nuevo pago de membresía
            $pago = PagoMembresia::create([
                'usuario_id' => auth()->id(),
                'miembro_id' => auth()->id(),  // Mantener por compatibilidad
                'monto' => $validated['monto'],
                'metodo_pago' => $validated['metodo_pago'],
                'fecha_pago' => $validated['fecha_pago'],
                'numero_comprobante' => $validated['numero_comprobante'] ?? 'COMP-' . date('Y') . '-' . rand(1000, 9999),
                'numero_referencia' => $validated['numero_referencia'] ?? null,
                'banco_origen' => $validated['banco_origen'] ?? null,
                'estado' => 'completado',
                'tipo_membresia' => $request->tipo_membresia ?? 'Membresía Mensual',
                'fecha_vencimiento' => now()->addMonth(),
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Renovación procesada exitosamente',
                'data' => [
                    'monto' => $pago->monto,
                    'numero_comprobante' => $pago->numero_comprobante,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar renovación: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener mis transacciones
     */
    public function misTransacciones()
    {
        try {
            $usuarioId = auth()->id();
            
            // Obtener pagos de membresías del usuario
            $membresias = PagoMembresia::where('usuario_id', $usuarioId)
                ->orderBy('fecha_pago', 'desc')
                ->get();
            
            $transacciones = $membresias->map(function($m) {
                return [
                    'id' => $m->id,
                    'tipo' => 'pago_membresia',
                    'descripcion' => 'Pago de ' . ($m->tipo_membresia ?? 'Membresía'),
                    'monto' => $m->monto,
                    'fecha' => $m->fecha_pago,
                    'comprobante' => $m->numero_comprobante,
                    'estado' => $m->estado ?? 'Completado',
                ];
            });
            
            return response()->json([
                'success' => true,
                'transacciones' => $transacciones,
                'resumen' => [
                    'totalPagado' => $membresias->sum('monto'),
                    'pagosRealizados' => $membresias->count(),
                    'pagosProcessados' => $membresias->count(),
                    'montoGestionado' => $membresias->sum('monto'),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtener mis estadísticas
     */
    public function misEstadisticas()
    {
        try {
            $usuarioId = auth()->id();
            
            // Obtener pagos del año actual
            $pagosAnio = PagoMembresia::where('usuario_id', $usuarioId)
                ->whereYear('fecha_pago', now()->year)
                ->get();
            
            // Pagos últimos 30 días
            $pagosUltimos30 = PagoMembresia::where('usuario_id', $usuarioId)
                ->where('fecha_pago', '>=', now()->subDays(30))
                ->count();
            
            // Próximo pago
            $proximoPago = PagoMembresia::where('usuario_id', $usuarioId)
                ->where('fecha_vencimiento', '>', now())
                ->orderBy('fecha_vencimiento', 'asc')
                ->first();
            
            // Pagos por mes
            $pagosPorMes = PagoMembresia::where('usuario_id', $usuarioId)
                ->whereYear('fecha_pago', now()->year)
                ->selectRaw('MONTH(fecha_pago) as mes, COUNT(*) as cantidad, SUM(monto) as total')
                ->groupBy('mes')
                ->get()
                ->map(function($item) {
                    return [
                        'mes' => \Carbon\Carbon::create()->month($item->mes)->format('F'),
                        'cantidad' => $item->cantidad,
                        'total' => $item->total,
                    ];
                });
            
            return response()->json([
                'success' => true,
                'stats' => [
                    'totalPagado' => $pagosAnio->sum('monto'),
                    'promedioPago' => $pagosAnio->count() > 0 ? $pagosAnio->avg('monto') : 0,
                    'pagosUltimos30Dias' => $pagosUltimos30,
                    'proximoPago' => $proximoPago ? $proximoPago->fecha_vencimiento : null,
                    'pagosPorMes' => $pagosPorMes,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
