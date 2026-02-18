<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Agregar columnas a la tabla users (solo si no existen)
        Schema::table('users', function (Blueprint $table) {
            if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'password_changed_at')) {
                $table->timestamp('password_changed_at')->nullable()->after('password');
            }
            if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'password_expires_at')) {
                $table->timestamp('password_expires_at')->nullable()->after('password_changed_at');
            }
        });

        // 2. Insertar parámetros de política de contraseñas en la tabla parametros
        $parametros = [
            [
                'clave'       => 'dias_vigencia_contrasena',
                'valor'       => '90',
                'descripcion' => 'Número de días que una contraseña es válida antes de vencer',
                'tipo'        => 'integer',
            ],
            [
                'clave'       => 'dias_aviso_contrasena',
                'valor'       => '7',
                'descripcion' => 'Días de anticipación para notificar al usuario que su contraseña vence pronto',
                'tipo'        => 'integer',
            ],
            [
                'clave'       => 'politica_contrasenas_activa',
                'valor'       => '1',
                'descripcion' => 'Habilita o deshabilita la política de caducidad de contraseñas (1=activo, 0=inactivo)',
                'tipo'        => 'boolean',
            ],
        ];

        foreach ($parametros as $parametro) {
            $existe = DB::table('parametros')->where('clave', $parametro['clave'])->exists();
            if (!$existe) {
                DB::table('parametros')->insert(array_merge($parametro, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }

        // 3. Inicializar password_changed_at en usuarios existentes con now()
        // para que no se les fuerce de inmediato
        DB::table('users')->whereNull('password_changed_at')->update([
            'password_changed_at' => now(),
            'password_expires_at' => now()->addDays(90),
        ]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['password_changed_at', 'password_expires_at']);
        });

        DB::table('parametros')->whereIn('clave', [
            'dias_vigencia_contrasena',
            'dias_aviso_contrasena',
            'politica_contrasenas_activa',
        ])->delete();
    }
};
