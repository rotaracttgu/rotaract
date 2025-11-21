<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BitacoraSistema;
use App\Traits\ManagesCalendarEvents;
use App\Traits\ManagesAttendance;
use App\Traits\ManagesNotifications;
use App\Traits\ManagesLetters;
use App\Traits\ManagesProjects;
use App\Traits\ManagesDashboard;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * PresidenteController - VERSIÓN REFACTORIZADA
 *
 * Este controlador ahora usa Traits para eliminar código duplicado.
 * Pasó de ~1,904 líneas a ~320 líneas (83% menos código!)
 */
class PresidenteController extends Controller
{
    use AuthorizesRequests;
    use ManagesCalendarEvents;      // Gestión de eventos del calendario
    use ManagesAttendance;           // Gestión de asistencias
    use ManagesNotifications;        // Gestión de notificaciones
    use ManagesLetters;              // Gestión de cartas formales y patrocinio
    use ManagesProjects;             // Gestión de proyectos
    use ManagesDashboard;            // Dashboard y estadísticas

    // ============================================================================
    // IMPLEMENTACIÓN DE MÉTODOS ABSTRACTOS DE LOS TRAITS
    // ============================================================================

    /**
     * Vista de notificaciones para Presidente
     */
    protected function getNotificationsView(): string
    {
        return 'modulos.presidente.notificaciones';
    }

    /**
     * Vista de cartas para Presidente
     */
    protected function getLettersView(string $type): string
    {
        return $type === 'formales'
            ? 'modulos.presidente.cartas-formales'
            : 'modulos.presidente.cartas-patrocinio';
    }

    /**
     * Ruta de cartas para Presidente
     */
    protected function getLettersRoute(string $type): string
    {
        return $type === 'formales'
            ? 'presidente.cartas.formales'
            : 'presidente.cartas.patrocinio';
    }

    /**
     * Vista PDF de cartas para Presidente
     */
    protected function getLettersPdfView(string $type): string
    {
        return $type === 'formal'
            ? 'modulos.presidente.exports.carta-formal-pdf'
            : 'modulos.presidente.exports.carta-patrocinio-pdf';
    }

    /**
     * Vista de proyectos para Presidente
     */
    protected function getProjectsView(): string
    {
        return 'modulos.presidente.estado-proyectos';
    }

    /**
     * Ruta de proyectos para Presidente
     */
    protected function getProjectsRoute(): string
    {
        return 'presidente.estado.proyectos';
    }

    /**
     * Vista PDF de proyectos para Presidente
     */
    protected function getProjectsPdfView(): string
    {
        return 'modulos.presidente.exports.proyectos-pdf';
    }

    /**
     * Vista del dashboard para Presidente
     */
    protected function getDashboardView(): string
    {
        return 'modulos.presidente.dashboard';
    }

    // ============================================================================
    // GESTIÓN DE USUARIOS (ACCESO COMPLETO PARA PRESIDENTE - NO COMPARTIDO)
    // ============================================================================

    /**
     * Lista de usuarios
     */
    public function usuariosLista()
    {
        $this->authorize('usuarios.ver');
        $usuarios = User::orderBy('created_at', 'desc')->paginate(10);
        $totalUsuarios = User::count();
        return view('modulos.presidente.usuarios', compact('usuarios', 'totalUsuarios'));
    }

    /**
     * Ver usuario específico
     */
    public function usuariosVer($usuario)
    {
        $this->authorize('usuarios.ver');
        $usuario = User::findOrFail($usuario);

        BitacoraSistema::registrar([
            'accion' => 'view',
            'modulo' => 'usuarios',
            'tabla' => 'users',
            'registro_id' => $usuario->id,
            'descripcion' => "Visualización del perfil de usuario: {$usuario->name}",
            'estado' => 'exitoso',
        ]);

        return view('modulos.presidente.usuarios-show', compact('usuario'));
    }

    /**
     * Formulario de creación
     */
    public function usuariosCrear()
    {
        $this->authorize('usuarios.crear');
        $roles = \Spatie\Permission\Models\Role::orderBy('name')->get();
        $moduloActual = 'presidente';
        return view('modulos.users.create', compact('roles', 'moduloActual'));
    }

    /**
     * Almacenar nuevo usuario
     */
    public function usuariosGuardar(Request $request)
    {
        $this->authorize('usuarios.crear');
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'email_verified' => ['nullable', 'boolean'],
            'two_factor_verified' => ['nullable', 'boolean'],
            'role' => ['required', 'string', 'exists:roles,name'],
            'rotary_id' => ['nullable', 'string', 'max:50'],
            'fecha_juramentacion' => ['nullable', 'date'],
            'fecha_cumpleaños' => ['nullable', 'date'],
            'activo' => ['nullable', 'boolean'],
        ]);

        try {
            $passwordAleatorio = \Illuminate\Support\Str::random(12) . rand(100, 999);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $passwordAleatorio,
                'email_verified_at' => $request->email_verified ? now() : null,
                'first_login' => true,
                'two_factor_enabled' => true,
                'two_factor_verified_at' => $request->two_factor_verified ? now() : null,
                'rotary_id' => $request->rotary_id,
                'fecha_juramentacion' => $request->fecha_juramentacion,
                'fecha_cumpleaños' => $request->fecha_cumpleaños,
                'activo' => $request->has('activo') ? (bool)$request->activo : true,
            ]);

            if ($request->role) {
                $user->assignRole($request->role);
            }

            BitacoraSistema::registrar([
                'accion' => 'create',
                'modulo' => 'usuarios',
                'tabla' => 'users',
                'registro_id' => $user->id,
                'descripcion' => "Nuevo usuario creado: {$user->name} ({$user->email}) con rol {$request->role}",
                'estado' => 'exitoso',
                'datos_nuevos' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $request->role,
                    'two_factor_enabled' => true,
                    'email_verified' => $request->email_verified ? true : false,
                    'first_login' => true,
                    'two_factor_verified' => $request->two_factor_verified ? true : false,
                    'rotary_id' => $request->rotary_id,
                    'fecha_juramentacion' => $request->fecha_juramentacion,
                    'fecha_cumpleaños' => $request->fecha_cumpleaños,
                    'activo' => $user->activo,
                ],
            ]);

            return redirect()->route('presidente.usuarios.lista')
                ->with('success', "Usuario creado exitosamente. Contraseña temporal: {$passwordAleatorio}. El usuario deberá cambiarla en el primer inicio de sesión.")
                ->with('usuario_creado', $user->name)
                ->with('password_temporal', $passwordAleatorio);

        } catch (\Exception $e) {
            BitacoraSistema::registrar([
                'accion' => 'create',
                'modulo' => 'usuarios',
                'tabla' => 'users',
                'descripcion' => "Error al crear usuario: {$request->name} ({$request->email})",
                'estado' => 'fallido',
                'error_mensaje' => $e->getMessage(),
                'datos_nuevos' => [
                    'name' => $request->name,
                    'email' => $request->email,
                ],
            ]);

            return back()->withInput()
                ->withErrors(['error' => 'Error al crear el usuario: ' . $e->getMessage()]);
        }
    }

    /**
     * Formulario de edición
     */
    public function usuariosEditar($usuario)
    {
        $this->authorize('usuarios.editar');
        $usuario = User::findOrFail($usuario);
        $roles = \Spatie\Permission\Models\Role::orderBy('name')->get();
        $moduloActual = 'presidente';
        return view('modulos.users.edit', compact('usuario', 'roles', 'moduloActual'));
    }

    /**
     * Actualizar usuario
     */
    public function usuariosActualizar(Request $request, $usuario)
    {
        $this->authorize('usuarios.editar');
        $usuario = User::findOrFail($usuario);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $usuario->id],
            'email_verified' => ['nullable', 'boolean'],
            'two_factor_verified' => ['nullable', 'boolean'],
            'role' => ['required', 'string', 'exists:roles,name'],
            'rotary_id' => ['nullable', 'string', 'max:50'],
            'fecha_juramentacion' => ['nullable', 'date'],
            'fecha_cumpleaños' => ['nullable', 'date'],
            'activo' => ['nullable', 'boolean'],
        ]);

        try {
            $datosAntiguos = $usuario->getAttributes();

            $usuario->update([
                'name' => $request->name,
                'email' => $request->email,
                'email_verified_at' => $request->email_verified ? now() : null,
                'two_factor_verified_at' => $request->two_factor_verified ? now() : null,
                'rotary_id' => $request->rotary_id,
                'fecha_juramentacion' => $request->fecha_juramentacion,
                'fecha_cumpleaños' => $request->fecha_cumpleaños,
                'activo' => $request->has('activo') ? (bool)$request->activo : true,
            ]);

            if ($request->role) {
                $usuario->syncRoles($request->role);
            }

            BitacoraSistema::registrar([
                'accion' => 'update',
                'modulo' => 'usuarios',
                'tabla' => 'users',
                'registro_id' => $usuario->id,
                'descripcion' => "Actualización de usuario: {$usuario->name} ({$usuario->email})",
                'estado' => 'exitoso',
                'datos_antiguos' => $datosAntiguos,
                'datos_nuevos' => $usuario->getAttributes(),
            ]);

            return redirect()->route('presidente.usuarios.lista')
                ->with('success', "Usuario {$usuario->name} actualizado correctamente");
        } catch (\Exception $e) {
            BitacoraSistema::registrar([
                'accion' => 'update',
                'modulo' => 'usuarios',
                'tabla' => 'users',
                'registro_id' => $usuario->id,
                'descripcion' => "Error al actualizar usuario: {$usuario->name}",
                'estado' => 'fallido',
                'error_mensaje' => $e->getMessage(),
            ]);

            return back()->withInput()
                ->withErrors(['error' => 'Error al actualizar el usuario: ' . $e->getMessage()]);
        }
    }

    /**
     * Eliminar usuario
     */
    public function usuariosEliminar($usuario)
    {
        $this->authorize('usuarios.eliminar');
        $usuario = User::findOrFail($usuario);
        $nombre = $usuario->name;

        BitacoraSistema::registrar([
            'accion' => 'delete',
            'modulo' => 'usuarios',
            'tabla' => 'users',
            'registro_id' => $usuario->id,
            'descripcion' => "Usuario {$usuario->name} eliminado",
            'estado' => 'exitoso',
        ]);

        $usuario->delete();

        return redirect()->route('presidente.usuarios.lista')
            ->with('success', "Usuario {$nombre} eliminado correctamente");
    }
}
