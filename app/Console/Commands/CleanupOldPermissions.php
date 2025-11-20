<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class CleanupOldPermissions extends Command
{
    protected $signature = 'cleanup:old-permissions';
    protected $description = 'Limpiar permisos antiguos con formato incorrecto (miembros)';

    public function handle()
    {
        $this->info("🧹 Limpiando permisos antiguos...");
        $this->info("═══════════════════════════════════════════════════");

        // Permisos antiguos que ya no se usan
        $oldPermissions = [
            'ver-miembros',
            'crear-miembros',
            'editar-miembros',
            'eliminar-miembros',
            'exportar-miembros',
        ];

        $deleted = 0;
        $notFound = 0;

        foreach ($oldPermissions as $oldPermission) {
            $permission = Permission::where('name', $oldPermission)->first();
            
            if ($permission) {
                // Verificar si algún rol lo está usando
                $rolesCount = $permission->roles()->count();
                $usersCount = $permission->users()->count();
                
                if ($rolesCount > 0 || $usersCount > 0) {
                    $this->warn("⚠️  {$oldPermission} - En uso por {$rolesCount} roles y {$usersCount} usuarios");
                    $this->line("   → Ya fue migrado a formato correcto, es seguro eliminar");
                }
                
                $permission->delete();
                $this->line("  ✓ Eliminado: {$oldPermission}");
                $deleted++;
            } else {
                $this->line("  - No existe: {$oldPermission}");
                $notFound++;
            }
        }

        $this->newLine();
        $this->info("✅ Limpieza completada!");
        $this->info("   - Permisos eliminados: {$deleted}");
        $this->info("   - No encontrados: {$notFound}");
        
        $this->newLine();
        $this->info("💡 Los permisos correctos (usuarios.ver, usuarios.crear, etc.) siguen activos");

        return Command::SUCCESS;
    }
}
