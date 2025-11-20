<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UpdateRolePermissions extends Command
{
    protected $signature = 'update:role-permissions {role}';
    protected $description = 'Actualizar permisos de un rol al formato correcto';

    public function handle()
    {
        $roleName = $this->argument('role');
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            $this->error("❌ Rol '$roleName' no encontrado");
            return Command::FAILURE;
        }

        $this->info("🎭 Actualizando permisos del rol: {$role->name}");
        $this->info("═══════════════════════════════════════════════════");

        // Mapeo de permisos antiguos a nuevos
        $mapping = [
            'ver-miembros' => 'usuarios.ver',
            'crear-miembros' => 'usuarios.crear',
            'editar-miembros' => 'usuarios.editar',
            'eliminar-miembros' => 'usuarios.eliminar',
            'ver-usuarios' => 'usuarios.ver',
            'crear-usuarios' => 'usuarios.crear',
            'editar-usuarios' => 'usuarios.editar',
            'eliminar-usuarios' => 'usuarios.eliminar',
        ];

        $currentPermissions = $role->permissions()->pluck('name')->toArray();
        $newPermissions = [];

        foreach ($currentPermissions as $oldPermission) {
            if (isset($mapping[$oldPermission])) {
                $newPermission = $mapping[$oldPermission];
                $this->line("  🔄 {$oldPermission} → {$newPermission}");
                $newPermissions[] = $newPermission;
            } else {
                $this->line("  ✓ {$oldPermission} (sin cambios)");
                $newPermissions[] = $oldPermission;
            }
        }

        // Sincronizar con los nuevos permisos
        $role->syncPermissions($newPermissions);

        $this->newLine();
        $this->info("✅ Permisos actualizados exitosamente!");
        $this->info("📋 Nuevos permisos:");
        
        foreach ($role->permissions()->pluck('name') as $permission) {
            $this->line("   - {$permission}");
        }

        return Command::SUCCESS;
    }
}
