<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AsignarRolesUsuariosSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Array de email => rol
        $asignaciones = [
            'yenifercastro09@gmail.com' => 'Super Admin',
            'jwcastroarteaga@gmail.com' => 'Presidente',
        ];

        foreach ($asignaciones as $email => $rolNombre) {
            $usuario = User::where('email', $email)->first();
            
            if ($usuario) {
                $usuario->syncRoles([$rolNombre]);
                $this->command->info("✓ Rol '{$rolNombre}' asignado a {$usuario->name} ({$email})");
            } else {
                $this->command->warn("⚠ Usuario con email {$email} no encontrado");
            }
        }
    }
}