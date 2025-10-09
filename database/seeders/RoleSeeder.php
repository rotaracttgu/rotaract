<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class RoleSeeder extends Seeder
{
    public function run()
    {

         Artisan::call('cache:clear');
         app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Eliminar relaciones de las tablas pivote
        DB::table('role_has_permissions')->delete();
        DB::table('model_has_roles')->delete();
        DB::table('model_has_permissions')->delete();
        
        // Eliminar roles y permisos
        Role::query()->delete();
        Permission::query()->delete();

        // Crear permisos
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);
        Permission::create(['name' => 'ver usuarios']);

        // Proyectos
        Permission::create(['name' => 'crear proyectos']);
        Permission::create(['name' => 'editar proyectos']);
        Permission::create(['name' => 'eliminar proyectos']);
        Permission::create(['name' => 'ver proyectos']);

        // Asistencia
        Permission::create(['name' => 'crear asistencia']);
        Permission::create(['name' => 'editar asistencia']);
        Permission::create(['name' => 'eliminar asistencia']);
        Permission::create(['name' => 'ver asistencia']);

        // Pagos
        Permission::create(['name' => 'crear pagos']);
        Permission::create(['name' => 'editar pagos']);
        Permission::create(['name' => 'eliminar pagos']);
        Permission::create(['name' => 'ver pagos']);

        // Actividades
        Permission::create(['name' => 'crear actividades']);
        Permission::create(['name' => 'editar actividades']);
        Permission::create(['name' => 'eliminar actividades']);
        Permission::create(['name' => 'ver actividades']);

        // Documentos
        Permission::create(['name' => 'crear documentos']);
        Permission::create(['name' => 'editar documentos']);
        Permission::create(['name' => 'eliminar documentos']);
        Permission::create(['name' => 'ver documentos']);

        // donaciones
        Permission::create(['name' => 'crear donaciones']);
        Permission::create(['name' => 'editar donaciones']);
        Permission::create(['name' => 'eliminar donaciones']);
        Permission::create(['name' => 'ver donaciones']);

        // Eventos
        Permission::create(['name' => 'crear eventos']);
        Permission::create(['name' => 'editar eventos']);
        Permission::create(['name' => 'eliminar eventos']);
        Permission::create(['name' => 'ver eventos']);

        // Logs
        Permission::create(['name' => 'crear logs']);
        Permission::create(['name' => 'editar logs']);
        Permission::create(['name' => 'eliminar logs']);
        Permission::create(['name' => 'ver logs']);

        Permission::create(['name' => 'gestionar sistema']);

        // Crear roles
        $superadmin = Role::create(['name' => 'Super Admin']);
        $presidente = Role::create(['name' => 'Presidente']);
        $vicepresidente = Role::create(['name' => 'Vicepresidente']);
        $secretario = Role::create(['name' => 'Secretario']);
        $tesorero = Role::create(['name' => 'Tesorero']);
        $macero = Role::create(['name' => 'Macero']);
        $aspirantes = Role::create(['name' => 'Aspirantes']);

        // Asignar permisos
        $superadmin->givePermissionTo([
            'crear usuarios',
            'editar usuarios', 
            'eliminar usuarios',
            'ver usuarios',
            'gestionar sistema',
            'crear proyectos',
            'editar proyectos',
            'eliminar proyectos',
            'ver proyectos',
            'crear asistencia',
            'editar asistencia',
            'eliminar asistencia',
            'ver asistencia',
            'crear pagos',
            'editar pagos',
            'eliminar pagos',
            'ver pagos',
            'crear actividades',
            'editar actividades',
            'eliminar actividades',
            'ver actividades',
            'crear documentos',
            'editar documentos',
            'eliminar documentos',
            'ver documentos',
            'crear donaciones',
            'editar donaciones',
            'eliminar donaciones',
            'ver donaciones',
            'crear eventos',
            'editar eventos',
            'eliminar eventos',
            'ver eventos',
            'crear logs',
            'editar logs',
            'eliminar logs',
            'ver logs'
        ]);

        // Asignar permisos
        $presidente->givePermissionTo([
            'crear usuarios',
            'editar usuarios', 
            'eliminar usuarios',
            'ver usuarios',
            'gestionar sistema',
            'crear proyectos',
            'editar proyectos',
            'eliminar proyectos',
            'ver proyectos',
            'crear asistencia',
            'editar asistencia',
            'eliminar asistencia',
            'ver asistencia',
            'crear pagos',
            'editar pagos',
            'eliminar pagos',
            'ver pagos',
            'crear actividades',
            'editar actividades',
            'eliminar actividades',
            'ver actividades',
            'crear documentos',
            'editar documentos',
            'eliminar documentos',
            'ver documentos',
            'crear donaciones',
            'editar donaciones',
            'eliminar donaciones',
            'ver donaciones',
            'crear eventos',
            'editar eventos',
            'eliminar eventos',
            'ver eventos',
            'crear logs',
            'editar logs',
            'eliminar logs',
            'ver logs'
        ]);

        // Asignar permisos a vicepresidente
        $vicepresidente->givePermissionTo([
            'crear usuarios',
            'editar usuarios', 
            'eliminar usuarios',
            'ver usuarios',
            'gestionar sistema',
            'crear proyectos',
            'editar proyectos',
            'eliminar proyectos',
            'ver proyectos',
            'crear asistencia',
            'editar asistencia',
            'eliminar asistencia',
            'ver asistencia',
            'crear pagos',
            'editar pagos',
            'eliminar pagos',
            'ver pagos',
            'crear actividades',
            'editar actividades',
            'eliminar actividades',
            'ver actividades',
            'crear documentos',
            'editar documentos',
            'eliminar documentos',
            'ver documentos',
            'crear donaciones',
            'editar donaciones',
            'eliminar donaciones',
            'ver donaciones',
            'crear eventos',
            'editar eventos',
            'eliminar eventos',
            'ver eventos',
            'crear logs',
            'editar logs',
            'eliminar logs',
            'ver logs',
        ]);

        // Asignar permisos a Secretario
        $secretario->givePermissionTo([
            'crear proyectos',
            'editar proyectos',
            'ver proyectos',
            'crear asistencia',
            'editar asistencia',
            'ver asistencia',
            'crear pagos',
            'editar pagos',
            'ver pagos',
            'crear actividades',
            'editar actividades',
            'ver actividades',
            'crear documentos',
            'editar documentos',
            'ver documentos',
            'crear donaciones',
            'editar donaciones',
            'ver donaciones',
            'crear eventos',
            'editar eventos',
            'ver eventos',
        ]);

        // Asignar permisos a Tesorero
        $tesorero->givePermissionTo([
            'ver asistencia',
            'crear pagos',
            'editar pagos',
            'ver pagos',
        ]);
        
        $macero->givePermissionTo([
            'crear eventos',
            'editar eventos',
            'eliminar eventos',
            'ver eventos',
        ]);

    }
}