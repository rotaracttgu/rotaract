<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class BitacoraSistema extends Model
{
    // Nombre de la tabla
    protected $table = 'bitacora_sistema';

    // Llave primaria
    protected $primaryKey = 'BitacoraID';

    // Timestamps (Laravel buscará created_at y updated_at)
    public $timestamps = false; // Usamos fecha_hora en lugar de timestamps

    /**
     * Campos que se pueden asignar masivamente
     */
    protected $fillable = [
        'user_id',
        'usuario_nombre',
        'usuario_email',
        'usuario_rol',
        'accion',
        'modulo',
        'tabla',
        'registro_id',
        'descripcion',
        'datos_anteriores',
        'datos_nuevos',
        'ip_address',
        'user_agent',
        'url',
        'metodo_http',
        'estado',
        'error_mensaje',
        'metadata',
        'fecha_hora',
    ];

    /**
     * Casts de atributos
     */
    protected $casts = [
        'datos_anteriores' => 'array',
        'datos_nuevos' => 'array',
        'metadata' => 'array',
        'fecha_hora' => 'datetime',
    ];

    /**
     * Relación: Pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Método estático para registrar eventos en la bitácora
     * 
     * @param array $data
     * @return BitacoraSistema|null
     */
    public static function registrar(array $data)
    {
        try {
            // Obtener información del usuario actual
            $user = Auth::user();
            
            // Datos por defecto
            $defaults = [
                'user_id' => $user?->id,
                'usuario_nombre' => $user?->name,
                'usuario_email' => $user?->email,
                'usuario_rol' => $user?->getRolPrincipal(),
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
                'url' => Request::fullUrl(),
                'metodo_http' => Request::method(),
                'fecha_hora' => now(),
                'estado' => 'exitoso',
            ];

            // Combinar datos proporcionados con defaults
            $bitacoraData = array_merge($defaults, $data);

            // Crear el registro
            return self::create($bitacoraData);
        } catch (\Exception $e) {
            // Si falla el registro en bitácora, no interrumpir la aplicación
            \Log::error('Error al registrar en bitácora: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Registrar un login exitoso
     */
    public static function registrarLogin($user)
    {
        return self::registrar([
            'user_id' => $user->id,
            'usuario_nombre' => $user->name,
            'usuario_email' => $user->email,
            'usuario_rol' => $user->getRolPrincipal(),
            'accion' => 'login',
            'modulo' => 'autenticacion',
            'descripcion' => "Inicio de sesión exitoso",
            'estado' => 'exitoso',
        ]);
    }

    /**
     * Registrar un login fallido
     */
    public static function registrarLoginFallido($email, $mensaje = null)
    {
        return self::registrar([
            'usuario_email' => $email,
            'accion' => 'login_fallido',
            'modulo' => 'autenticacion',
            'descripcion' => "Intento de inicio de sesión fallido para: {$email}",
            'estado' => 'fallido',
            'error_mensaje' => $mensaje,
        ]);
    }

    /**
     * Registrar un logout
     */
    public static function registrarLogout($user)
    {
        return self::registrar([
            'user_id' => $user->id,
            'usuario_nombre' => $user->name,
            'usuario_email' => $user->email,
            'usuario_rol' => $user->getRolPrincipal(),
            'accion' => 'logout',
            'modulo' => 'autenticacion',
            'descripcion' => "Cierre de sesión",
            'estado' => 'exitoso',
        ]);
    }

    /**
     * Registrar un registro de usuario
     */
    public static function registrarRegistro($user)
    {
        return self::registrar([
            'user_id' => $user->id,
            'usuario_nombre' => $user->name,
            'usuario_email' => $user->email,
            'accion' => 'registro',
            'modulo' => 'autenticacion',
            'tabla' => 'users',
            'registro_id' => $user->id,
            'descripcion' => "Nuevo usuario registrado: {$user->name}",
            'estado' => 'exitoso',
            'datos_nuevos' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    /**
     * Scopes para filtrar registros
     */
    public function scopePorUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopePorAccion($query, $accion)
    {
        return $query->where('accion', $accion);
    }

    public function scopePorModulo($query, $modulo)
    {
        return $query->where('modulo', $modulo);
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopeExitosos($query)
    {
        return $query->where('estado', 'exitoso');
    }

    public function scopeFallidos($query)
    {
        return $query->where('estado', 'fallido');
    }

    public function scopeHoy($query)
    {
        return $query->whereDate('fecha_hora', today());
    }

    public function scopeUltimaSemana($query)
    {
        return $query->where('fecha_hora', '>=', now()->subDays(7));
    }

    public function scopeUltimoMes($query)
    {
        return $query->where('fecha_hora', '>=', now()->subDays(30));
    }

    /**
     * Obtener descripción formateada
     */
    public function getDescripcionFormateada()
    {
        return ucfirst($this->descripcion);
    }

    /**
     * Obtener el ícono según la acción
     */
    public function getIcono()
    {
        $iconos = [
            'login' => '🔓',
            'logout' => '🔒',
            'login_fallido' => '❌',
            'registro' => '✨',
            'create' => '➕',
            'update' => '✏️',
            'delete' => '🗑️',
            'restore' => '♻️',
            'export' => '📥',
            'import' => '📤',
            'view' => '👁️',
        ];

        return $iconos[$this->accion] ?? '📋';
    }

    /**
     * Obtener color según el estado
     */
    public function getColorEstado()
    {
        $colores = [
            'exitoso' => 'green',
            'fallido' => 'red',
            'pendiente' => 'yellow',
        ];

        return $colores[$this->estado] ?? 'gray';
    }
}