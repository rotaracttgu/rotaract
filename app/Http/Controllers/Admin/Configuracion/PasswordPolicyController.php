<?php

namespace App\Http\Controllers\Admin\Configuracion;

use App\Http\Controllers\Controller;
use App\Models\Parametro;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasswordPolicyController extends Controller
{
    /**
     * Mostrar el panel de política de contraseñas (AJAX o full)
     */
    public function index(Request $request)
    {
        $parametros = [
            'dias_vigencia_contrasena'   => Parametro::obtener('dias_vigencia_contrasena', 90),
            'dias_aviso_contrasena'      => Parametro::obtener('dias_aviso_contrasena', 7),
            'politica_contrasenas_activa'=> Parametro::obtener('politica_contrasenas_activa', true),
        ];

        // Estadísticas de usuarios
        $stats = [
            'total_usuarios'  => User::where('activo', true)->count(),
            'vencidas'        => User::where('activo', true)
                                    ->whereNotNull('password_expires_at')
                                    ->where('password_expires_at', '<', now())
                                    ->count(),
            'por_vencer_7'    => User::where('activo', true)
                                    ->whereNotNull('password_expires_at')
                                    ->where('password_expires_at', '>=', now())
                                    ->where('password_expires_at', '<=', now()->addDays(7))
                                    ->count(),
            'vigentes'        => User::where('activo', true)
                                    ->whereNotNull('password_expires_at')
                                    ->where('password_expires_at', '>', now()->addDays(7))
                                    ->count(),
        ];

        $isAjax = $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest';

        if ($isAjax) {
            $html = view('modulos.admin.configuracion.password-policy.index', compact('parametros', 'stats', 'isAjax'))->render();
            return response($html)
                ->header('Content-Type', 'text/html; charset=UTF-8')
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                ->header('Pragma', 'no-cache');
        }

        return view('modulos.admin.configuracion.password-policy.index', compact('parametros', 'stats', 'isAjax'));
    }

    /**
     * Guardar la configuración de política de contraseñas
     */
    public function update(Request $request)
    {
        $request->validate([
            'dias_vigencia_contrasena'    => ['required', 'integer', 'min:1', 'max:365'],
            'dias_aviso_contrasena'       => ['required', 'integer', 'min:1', 'max:30'],
            'politica_contrasenas_activa' => ['required', 'boolean'],
        ], [
            'dias_vigencia_contrasena.required' => 'Los días de vigencia son requeridos.',
            'dias_vigencia_contrasena.min'      => 'Los días de vigencia deben ser al menos 1.',
            'dias_vigencia_contrasena.max'      => 'Los días de vigencia no pueden superar 365.',
            'dias_aviso_contrasena.min'         => 'Los días de aviso deben ser al menos 1.',
            'dias_aviso_contrasena.max'         => 'Los días de aviso no pueden superar 30.',
        ]);

        $claves = ['dias_vigencia_contrasena', 'dias_aviso_contrasena', 'politica_contrasenas_activa'];

        foreach ($claves as $clave) {
            Parametro::updateOrCreate(
                ['clave' => $clave],
                ['valor' => $request->input($clave), 'updated_at' => now()]
            );
        }

        // Si se cambian los días de vigencia, recalcular la fecha de vencimiento
        // de todos los usuarios activos en base a su password_changed_at
        if ($request->has('recalcular_fechas') && $request->recalcular_fechas) {
            $diasVigencia = (int) $request->dias_vigencia_contrasena;
            User::where('activo', true)
                ->whereNotNull('password_changed_at')
                ->each(function (User $user) use ($diasVigencia) {
                    $user->password_expires_at = $user->password_changed_at->addDays($diasVigencia);
                    $user->saveQuietly();
                });
        }

        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json(['success' => true, 'message' => 'Configuración de política de contraseñas actualizada correctamente.']);
        }

        return back()->with('success', 'Configuración de política de contraseñas actualizada correctamente.');
    }

    /**
     * Obtener listado de usuarios con estado de contraseña (AJAX)
     */
    public function usuariosEstado()
    {
        $usuarios = User::where('activo', true)
            ->select('id', 'name', 'apellidos', 'email', 'password_changed_at', 'password_expires_at')
            ->orderBy('password_expires_at', 'asc')
            ->get()
            ->map(function (User $u) {
                $dias = $u->diasParaVencerContrasena();
                return [
                    'id'                   => $u->id,
                    'nombre'               => $u->nombre_completo,
                    'email'                => $u->email,
                    'password_changed_at'  => $u->password_changed_at?->format('d/m/Y'),
                    'password_expires_at'  => $u->password_expires_at?->format('d/m/Y'),
                    'dias_restantes'       => $dias,
                    'estado'               => $dias === null ? 'sin_fecha' : ($dias < 0 ? 'vencida' : ($dias <= 7 ? 'por_vencer' : 'vigente')),
                ];
            });

        return response()->json(['success' => true, 'usuarios' => $usuarios]);
    }
}
