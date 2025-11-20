<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Spatie\Permission\Models\Role;
use App\Models\User;

echo "=== VERIFICACIÓN DE PERMISOS ===\n\n";

// Verificar rol Vicepresidente
$roleVice = Role::where('name', 'Vicepresidente')->first();
if ($roleVice) {
    echo "Rol: Vicepresidente\n";
    echo "Total permisos: " . $roleVice->permissions->count() . "\n";
    
    $cartasPermisos = $roleVice->permissions->filter(function($p) {
        return str_starts_with($p->name, 'cartas.');
    });
    
    echo "Permisos de cartas (" . $cartasPermisos->count() . "):\n";
    foreach ($cartasPermisos as $permiso) {
        echo "  ✓ " . $permiso->name . "\n";
    }
} else {
    echo "⚠️ Rol Vicepresidente NO encontrado\n";
}

echo "\n";

// Verificar usuario DanUnah
$user = User::where('username', 'DanUnah')->first();
if ($user) {
    echo "Usuario: DanUnah\n";
    echo "Roles asignados: " . $user->roles->pluck('name')->implode(', ') . "\n";
    echo "Total permisos (directos + rol): " . $user->getAllPermissions()->count() . "\n";
    
    $cartasPermisos = $user->getAllPermissions()->filter(function($p) {
        return str_starts_with($p->name, 'cartas.');
    });
    
    echo "Permisos de cartas (" . $cartasPermisos->count() . "):\n";
    foreach ($cartasPermisos as $permiso) {
        echo "  ✓ " . $permiso->name . "\n";
    }
    
    echo "\n¿Puede ver cartas? " . ($user->can('cartas.ver') ? 'SÍ' : 'NO') . "\n";
    echo "¿Puede crear cartas? " . ($user->can('cartas.crear') ? 'SÍ' : 'NO') . "\n";
    echo "¿Puede editar cartas? " . ($user->can('cartas.editar') ? 'SÍ' : 'NO') . "\n";
    echo "¿Puede eliminar cartas? " . ($user->can('cartas.eliminar') ? 'SÍ' : 'NO') . "\n";
} else {
    echo "⚠️ Usuario DanUnah NO encontrado\n";
}
