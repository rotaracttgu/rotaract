<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BitacoraSistema;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BitacoraController extends Controller
{
    public function index(Request $request)
    {
        $query = BitacoraSistema::with('user')
            ->orderBy('fecha_hora', 'desc');

        // Filtros
        if ($request->filled('usuario')) {
            $query->where('user_id', $request->usuario);
        }

        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }

        if ($request->filled('modulo')) {
            $query->where('modulo', $request->modulo);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_hora', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_hora', '<=', $request->fecha_hasta);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('descripcion', 'like', "%{$buscar}%")
                  ->orWhere('usuario_nombre', 'like', "%{$buscar}%")
                  ->orWhere('usuario_email', 'like', "%{$buscar}%")
                  ->orWhere('ip_address', 'like', "%{$buscar}%");
            });
        }

        $registros = $query->paginate(20);

        // Estadísticas para el dashboard
        $stats = $this->getEstadisticas();

        // Datos para filtros
        $usuarios = User::orderBy('name')->get();
        $modulos = BitacoraSistema::select('modulo')
            ->distinct()
            ->orderBy('modulo')
            ->pluck('modulo');

        return view('users.bitacora.index', compact(
            'registros',
            'stats',
            'usuarios',
            'modulos'
        ));
    }

    public function show($id)
    {
        $registro = BitacoraSistema::with('user')->findOrFail($id);
        
        return view('users.bitacora.show', compact('registro'));
    }

    private function getEstadisticas()
    {
        $hoy = now()->startOfDay();
        $semanaAtras = now()->subDays(7);
        $mesAtras = now()->subDays(30);

        return [
            // Total de eventos
            'total_eventos' => BitacoraSistema::count(),
            'eventos_hoy' => BitacoraSistema::whereDate('fecha_hora', $hoy)->count(),
            'eventos_semana' => BitacoraSistema::where('fecha_hora', '>=', $semanaAtras)->count(),
            'eventos_mes' => BitacoraSistema::where('fecha_hora', '>=', $mesAtras)->count(),

            // Por estado
            'exitosos' => BitacoraSistema::where('estado', 'exitoso')->count(),
            'fallidos' => BitacoraSistema::where('estado', 'fallido')->count(),
            'pendientes' => BitacoraSistema::where('estado', 'pendiente')->count(),

            // Login stats
            'logins_exitosos' => BitacoraSistema::where('accion', 'login')
                ->where('estado', 'exitoso')
                ->where('fecha_hora', '>=', $mesAtras)
                ->count(),
            'logins_fallidos' => BitacoraSistema::where('accion', 'login_fallido')
                ->where('fecha_hora', '>=', $mesAtras)
                ->count(),

            // Por acción
            'por_accion' => BitacoraSistema::select('accion', DB::raw('count(*) as total'))
                ->where('fecha_hora', '>=', $semanaAtras)
                ->groupBy('accion')
                ->get(),

            // Por módulo
            'por_modulo' => BitacoraSistema::select('modulo', DB::raw('count(*) as total'))
                ->where('fecha_hora', '>=', $semanaAtras)
                ->groupBy('modulo')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get(),

            // Usuarios más activos
            'usuarios_activos' => BitacoraSistema::select('usuario_nombre', 'user_id', DB::raw('count(*) as total'))
                ->where('fecha_hora', '>=', $semanaAtras)
                ->whereNotNull('user_id')
                ->groupBy('usuario_nombre', 'user_id')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get(),

            // Actividad por hora (últimas 24 horas)
            'actividad_por_hora' => BitacoraSistema::select(
                    DB::raw('HOUR(fecha_hora) as hora'),
                    DB::raw('count(*) as total')
                )
                ->where('fecha_hora', '>=', now()->subDay())
                ->groupBy('hora')
                ->orderBy('hora')
                ->get(),
        ];
    }

    public function exportar(Request $request)
    {
        $query = BitacoraSistema::with('user')
            ->orderBy('fecha_hora', 'desc');

        // Aplicar los mismos filtros que en index
        if ($request->filled('usuario')) {
            $query->where('user_id', $request->usuario);
        }
        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }
        if ($request->filled('modulo')) {
            $query->where('modulo', $request->modulo);
        }
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_hora', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_hora', '<=', $request->fecha_hasta);
        }

        $registros = $query->limit(1000)->get();

        $csv = "ID,Fecha y Hora,Usuario,Email,Rol,Acción,Módulo,Descripción,IP,Estado\n";
        
        foreach ($registros as $registro) {
            $csv .= sprintf(
                "%d,%s,%s,%s,%s,%s,%s,%s,%s,%s\n",
                $registro->BitacoraID,
                $registro->fecha_hora->format('Y-m-d H:i:s'),
                $registro->usuario_nombre ?? 'N/A',
                $registro->usuario_email ?? 'N/A',
                $registro->usuario_rol ?? 'N/A',
                $registro->accion,
                $registro->modulo,
                str_replace(["\n", "\r", '"'], ['', '', '""'], $registro->descripcion),
                $registro->ip_address,
                $registro->estado
            );
        }

        $filename = 'bitacora_' . now()->format('Y-m-d_His') . '.csv';

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    public function limpiar(Request $request)
    {
        $request->validate([
            'dias' => 'required|integer|min:1|max:365'
        ]);

        $fecha = now()->subDays($request->dias);
        $eliminados = BitacoraSistema::where('fecha_hora', '<', $fecha)->delete();

        return redirect()->route('admin.bitacora.index')
            ->with('success', "Se eliminaron {$eliminados} registros anteriores a {$request->dias} días.");
    }
}