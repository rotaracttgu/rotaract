<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Crear permisos
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);
        Permission::create(['name' => 'ver usuarios']);
        Permission::create(['name' => 'gestionar sistema']);

        // Crear roles
        $admin = Role::create(['name' => 'administrador']);
        $editor = Role::create(['name' => 'editor']);
        $usuario = Role::create(['name' => 'usuario']);

        // Asignar permisos
        $admin->givePermissionTo([
            'crear usuarios',
            'editar usuarios', 
            'eliminar usuarios',
            'ver usuarios',
            'gestionar sistema'
        ]);

        $editor->givePermissionTo([
            'crear usuarios',
            'editar usuarios',
            'ver usuarios'
        ]);

        $usuario->givePermissionTo(['ver usuarios']);
    }
}