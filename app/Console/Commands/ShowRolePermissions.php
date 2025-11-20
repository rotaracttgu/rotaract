<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class ShowRolePermissions extends Command
{
    protected $signature = 'show:role-permissions {role}';
    protected $description = 'Mostrar todos los permisos de un rol';

    public function handle()
    {
        $roleName = $this->argument('role');
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            $this->error("❌ Rol '$roleName' no encontrado");
            return Command::FAILURE;
        }

        $this->info("🎭 Rol: {$role->name}");
        $this->info("═══════════════════════════════════════════════════");
        
        $permissions = $role->permissions()->orderBy('name')->get();
        
        if ($permissions->isEmpty()) {
            $this->warn("⚠️  Este rol NO tiene permisos asignados");
            return Command::SUCCESS;
        }

        $this->info("📋 Total de permisos: {$permissions->count()}\n");

        // Agrupar por módulo
        $grouped = $permissions->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        });

        foreach ($grouped as $module => $perms) {
            $this->line("📦 <fg=cyan>{$module}</>");
            foreach ($perms as $perm) {
                $action = explode('.', $perm->name)[1] ?? '';
                $this->line("   ├─ {$action}");
            }
            $this->newLine();
        }

        return Command::SUCCESS;
    }
}
