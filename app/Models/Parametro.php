<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    use HasFactory;

    protected $table = 'parametros';

    protected $fillable = [
        'clave',
        'valor',
        'descripcion',
        'tipo',
    ];

    /**
     * Obtener el valor de un parámetro por su clave
     */
    public static function obtener($clave, $default = null)
    {
        $parametro = self::where('clave', $clave)->first();
        
        if (!$parametro) {
            return $default;
        }

        // Convertir según el tipo
        return match($parametro->tipo) {
            'integer' => (int) $parametro->valor,
            'boolean' => filter_var($parametro->valor, FILTER_VALIDATE_BOOLEAN),
            default => $parametro->valor,
        };
    }

    /**
     * Actualizar el valor de un parámetro
     */
    public static function actualizar($clave, $valor)
    {
        return self::where('clave', $clave)->update(['valor' => $valor]);
    }
}