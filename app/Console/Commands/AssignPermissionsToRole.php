<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignPermissionsToRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:assign-to-role {role} {permissions?}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Asignar permisos a un rol (crea el rol si no existe)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $roleName = $this->argument('role');
        $permissionsArg = $this->argument('permissions');

        // Crear o obtener el rol
        $role = Role::firstOrCreate(
            ['name' => $roleName],
            ['guard_name' => 'web']
        );

        $this->info("Rol '{$roleName}' procesado.");

        // Si se proporcionaron permisos específicos
        if ($permissionsArg) {
            $permissions = explode(',', $permissionsArg);
            $permissions = array_map('trim', $permissions);
            
            // Verificar que todos los permisos existan
            $invalidPermissions = [];
            foreach ($permissions as $perm) {
                if (!Permission::where('name', $perm)->exists()) {
                    $invalidPermissions[] = $perm;
                }
            }

            if (!empty($invalidPermissions)) {
                $this->error("Permisos no encontrados: " . implode(', ', $invalidPermissions));
                return 1;
            }

            $role->syncPermissions($permissions);
            $this->info("✓ Permisos asignados: " . implode(', ', $permissions));
        } else {
            // Mostrar permisos disponibles para seleccionar
            $this->info("\n📋 Permisos disponibles:");
            
            $permissions = Permission::all()->groupBy(function ($item) {
                return explode('.', $item->name)[0];
            });

            foreach ($permissions as $module => $perms) {
                $this->line("\n<fg=cyan>{$module}:</>");
                foreach ($perms as $perm) {
                    $this->line("  - {$perm->name}");
                }
            }

            $this->info("\n💡 Uso:");
            $this->line("php artisan permission:assign-to-role {$roleName} \"dashboard.ver,usuarios.ver\"");
        }

        return 0;
    }
}
